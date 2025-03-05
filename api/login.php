<?php
//required headers
header("Access-Control-Allow-Origin: https://bgvsodisha.org/survey/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
// files needed to connect to database
include_once('../include/connection.php');
// files needed for JWT authentication
include_once '../include/config.php';
// include_once '../assets/bundles/php-jwt-main/src/BeforeValidException.php';
// include_once '../assets/bundles/php-jwt-main/src/ExpiredException.php';
include_once '../assets/bundles/php-jwt-main/src/SignatureInvalidException.php';
include_once '../assets/bundles/php-jwt-main/src/JWT.php';
use \Firebase\JWT\JWT;
// get database connection
$database = new Database();
$conn = $database->getConnection();
// get posted data
$data = json_decode(file_get_contents("php://input"));
$output = array('response' => '', 'message' => '', 'token' => '', 'status' => 401);
if (!empty($data)) {
    $userName = htmlspecialchars(strip_tags(isset($data->username)?$data->username:''));
    $password = htmlspecialchars(strip_tags(isset($data->password))?$data->password:'');
    if ($userName != '' && $userName != NULL && $password != '' && $password != NULL) {
        $shaPw = md5($password . '#' . $userName);
        $query = "SELECT id, user_name, name, email, phone, enc_password
            FROM surveyor
            WHERE user_name = :un
            AND enc_password = :pw AND is_active = 1";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':un', $userName);
        $stmt->bindParam(':pw', $shaPw);
        if ($stmt->execute()) {
            $num = $stmt->rowCount();
            if ($num > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $userId = $row['id'];
                $userName = $row['user_name'];
                $token = array(
                    "iat" => $issued_at,
                    "exp" => $expiration_time,
                    "iss" => $issuer,
                    "data" => array(
                        "id" => $row['id'],
                        "user_name" => $row['user_name'],
                        "name" => $row['name'],
                        "email" => $row['email'],
                        "phone" => $row['phone']
                    )
                );
                $jwt = JWT::encode($token, $key, 'HS256');
                $output['response'] = 'SUCCESS';
                $output['message'] = 'Successfully logged In.';
                $output['token'] = $jwt;
                $output['status'] = '200';
            } else {
                $output['response'] = 'FAILURE';
                $output['message'] = 'Invalid User Credential !';
                $output['status'] = '401';
            }
        } else {
            $output['response'] = 'FAILURE';
            $output['message'] = 'Login Failed !';
            $output['status'] = '401';
        }
    } else {
        $output['response'] = 'FAILURE';
        $output['message'] = 'Credential should not be blank !';
        $output['status'] = '401';
    }
}else {
    $output['response'] = 'FAILURE';
    $output['message'] = 'Invalid Login Request !';
    $output['status'] = '500';
}
http_response_code($output['status']);
echo json_encode($output);
