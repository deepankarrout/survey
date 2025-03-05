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
include_once '../assets/bundles/php-jwt-main/src/Key.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
// get posted data
$data = json_decode(file_get_contents("php://input"));
$output = array('response' => '', 'message' => '', 'token' => '', 'status' => 401, 'data' => array());
$data = json_decode(file_get_contents("php://input"));
$jwt = isset($data->token) ? $data->token : "";
if ($jwt) {
    try {
        $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
        $surveyCode = 'CRSS';
        $database = new Database();
        $conn = $database->getConnection();
        $query = "SELECT `question_bit`, `question`, `question_type`, `is_required`
                  FROM `questions` 
                  WHERE `survey_code` = :sc AND `status` = 1
                  ORDER BY `question_bit`;";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':sc', $surveyCode);
        if ($stmt->execute()) {
            $num = $stmt->rowCount();
            if ($num > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $output['data'][] = $row;
                }
                $output['response'] = 'SUCCESS';
                $output['message'] = 'Access granted !';
                $output['status'] = '200';
            } else {
                $output['response'] = 'SUCCESS';
                $output['message'] = 'Questions not available !';
                $output['status'] = '200';
            }
        } else {
            $output['response'] = 'FAILURE';
            $output['message'] = 'Failed to get questions !';
            $output['status'] = '500';
        }
    } catch (Exception $e) {
        $output['response'] = 'FAILURE';
        $output['message'] = $e->getMessage();
        $output['status'] = '401';
    }
} else {
    $output['response'] = 'FAILURE';
    $output['message'] = 'Access Denied !';
    $output['status'] = '401';
}
http_response_code($output['status']);
echo json_encode($output);
