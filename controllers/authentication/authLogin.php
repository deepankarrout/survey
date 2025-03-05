<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../../include/connection.php');
require_once('../../include/common.php');
// get database connection
$database = new Database();
$conn = $database->getConnection();
$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
if ($type == 'Login') {
    $userName = isset($_POST['username']) ? htmlspecialchars(strip_tags($_POST['username'])) : '';
    $password = isset($_POST['password']) ? htmlspecialchars(strip_tags($_POST['password'])) : '';
    validateRequiredData(['Username' => $userName, 'Password' => $password]);
    $encPassword = md5($password . '#' . $userName);
    $output = array('response' => '', 'message' => '', 'status' => 500);
    $query = "SELECT id,username,admin_name,admin_type,phone,email
                FROM admin 
                WHERE username = :username
                    AND enc_password = :password
                    AND is_active = 1";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':username', $userName);
    $stmt->bindParam(':password', $encPassword);
    if ($stmt->execute()) {
        $num = $stmt->rowCount();
        if ($num > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            session_start();
            $_SESSION['session_id'] = session_id();
            $_SESSION['adminid'] = $row['id'];
            $_SESSION['admin_type'] = $row['admin_type'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['admin_name'] = $row['admin_name'];
            $_SESSION['phone'] = $row['phone'];
            $_SESSION['email'] = $row['email'];
            $output['response'] = 'SUCCESS';
            $output['message'] = 'Successfully Authenticated !';
            $output['status'] = '200';
        } else {
            $output['response'] = 'FAILURE';
            $output['message'] = 'Invalid User Credential !';
            $output['status'] = '500';
        }
    } else {
        $output['response'] = 'FAILURE';
        $output['message'] = 'Somthing Went Wrong !';
        $output['status'] = '500';
    }
    echo json_encode($output);
    exit;
} else {
    echo json_encode(array('response' => 'FAILURE', 'message' => 'Invalid Request !', 'status' => 404));
    exit;
}
