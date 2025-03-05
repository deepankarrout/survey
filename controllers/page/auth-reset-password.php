<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
session_start();
require_once('../../include/connection.php');
require_once('../../include/common.php');
// get database connection
$database = new Database();
$conn = $database->getConnection();
$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
if ($type == 'fetchDetails') {
    $output = array('data' => '', 'response' => '', 'message' => '', 'status' => 500);
    if (isset($_SESSION['username'])) {
        $output['data'] = array('username' => $_SESSION['username'], 'id' => $_SESSION['adminid']);
        $output['response'] = 'SUCCESS';
        $output['status'] = '200';
    } else {
        session_destroy();
        header('location:index.php');
        die;
    }
    echo json_encode($output);
    exit;
} elseif ($type == 'changePassword') {
    $hiddenUserId = isset($_POST['hiddenUserId']) ? htmlspecialchars(strip_tags($_POST['hiddenUserId'])) : '';
    $username = isset($_POST['username']) ? htmlspecialchars(strip_tags($_POST['username'])) : '';
    $oldPassword = isset($_POST['old-password']) ? htmlspecialchars(strip_tags($_POST['old-password'])) : '';
    $password = isset($_POST['password']) ? htmlspecialchars(strip_tags($_POST['password'])) : '';
    $passwordConfirm = isset($_POST['password-confirm']) ? htmlspecialchars(strip_tags($_POST['password-confirm'])) : '';
    $output = array('data' => '', 'response' => '', 'message' => '', 'status' => 500);
    if ($password == $passwordConfirm) {
        if ($passwordConfirm != $oldPassword) {
            $oldEncPw = md5($oldPassword . '#' . $username);
            $query = "SELECT `username`, `id`
              FROM `admin` WHERE id = :id 
              AND username = :un 
              AND enc_password = :op
              AND is_active = 1 ";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $hiddenUserId);
            $stmt->bindParam(':un', $username);
            $stmt->bindParam(':op', $oldEncPw);
            if ($stmt->execute()) {
                $num = $stmt->rowCount();
                if ($num > 0) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($hiddenUserId == $row['id'] && $username == $row['username']) {
                        $output['response'] = 'SUCCESS';
                        $output['message'] = 'Successfully Fetched Surveyor !';
                        $output['status'] = '200';
                    } else {
                        $output['response'] = 'INVALID';
                        $output['message'] = 'Invalid old password !';
                        $output['status'] = '401';
                    }
                } else {
                    $output['response'] = 'INVALID';
                    $output['message'] = 'Invalid old password !';
                    $output['status'] = '401';
                }
            } else {
                $output['response'] = 'FAILURE';
                $output['message'] = 'Somthing Went Wrong !';
                $output['status'] = '500';
            }
            if ($output['response'] == 'SUCCESS') {
                $newEncPw = md5($passwordConfirm . '#' . $username);
                $upQuery = "UPDATE `admin` SET enc_password = :np
                            WHERE id = :id AND username = :un 
                            AND enc_password = :op
                            AND is_active = 1";
                $stmt = $conn->prepare($upQuery);
                $stmt->bindParam(':id', $hiddenUserId);
                $stmt->bindParam(':un', $username);
                $stmt->bindParam(':op', $oldEncPw);
                $stmt->bindParam(':np', $newEncPw);
                if ($stmt->execute()) {
                    $output['response'] = 'SUCCESS';
                    $output['message'] = 'Successfully changed password !';
                    $output['status'] = '200';
                } else {
                    $output['response'] = 'FAILURE';
                    $output['message'] = 'Try again, Faild to change password !';
                    $output['status'] = '401';
                }
            }
        } else {
            $output['response'] = 'INVALID';
            $output['message'] = 'Old Password & New Password should be different !';
            $output['status'] = '401';
        }
    } else {
        $output['response'] = 'FAILURE';
        $output['message'] = 'New Password & Confirm Password must be same !';
        $output['status'] = '401';
    }
    echo json_encode($output);
    exit;
} else {
    echo json_encode(array('response' => 'FAILURE', 'message' => 'Invalid Request !', 'status' => 404));
    exit;
}
