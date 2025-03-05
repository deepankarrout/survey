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
if ($type == 'fetchSurveyorDetails1') {
    $surveyCode = isset($_POST['survey']) ? htmlspecialchars(strip_tags($_POST['survey'])) : 'CRSS';
    $output = array('data' => '', 'response' => '', 'message' => '', 'status' => 500);
    $query = "SELECT `id`, `user_name`, `name`, `email`, `phone`, `is_active`
              FROM `admin` WHERE survey_code = :sc";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':sc', $surveyCode);
    if ($stmt->execute()) {
        $num = $stmt->rowCount();
        if ($num > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $output['data'] = $row;
            $output['response'] = 'SUCCESS';
            $output['message'] = 'Successfully Fetched Surveyor !';
            $output['status'] = '200';
        } else {
            $output['response'] = 'NA';
            $output['message'] = 'Surveyor Details Not Available !';
            $output['status'] = '500';
        }
    } else {
        $output['response'] = 'FAILURE';
        $output['message'] = 'Somthing Went Wrong !';
        $output['status'] = '500';
    }
    echo json_encode($output);
    exit;
} else if ($type == 'fetchSurveyorDetails') {
    $surveyCode = isset($_POST['survey']) ? htmlspecialchars(strip_tags($_POST['survey'])) : 'CRSS';
    $output = array('data' => '', 'response' => '', 'message' => '', 'status' => 500);
    $query = "SELECT `id`, `username`, `admin_name`, `email`, `phone`, `is_active`
              FROM `admin` WHERE is_active = 1 AND admin_type = 2";
    $stmt = $conn->prepare($query);
    // $stmt->bindParam(':sc', $surveyCode);
    if ($stmt->execute()) {
        $num = $stmt->rowCount();
        if ($num > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $output['data'] = $row;
            $output['response'] = 'SUCCESS';
            $output['message'] = 'Successfully Fetched Surveyor !';
            $output['status'] = '200';
        } else {
            $output['response'] = 'NA';
            $output['message'] = 'Surveyor Details Not Available !';
            $output['status'] = '500';
        }
    } else {
        $output['response'] = 'FAILURE';
        $output['message'] = 'Somthing Went Wrong !';
        $output['status'] = '500';
    }
    echo json_encode($output);
    exit;
} elseif ($type == 'changePassword1') {
    $hiddenUserId = isset($_POST['hiddenUserId']) ? htmlspecialchars(strip_tags($_POST['hiddenUserId'])) : '';
    $name = isset($_POST['name']) ? htmlspecialchars(strip_tags($_POST['name'])) : '';
    $username = isset($_POST['username']) ? htmlspecialchars(strip_tags($_POST['username'])) : '';
    $oldPassword = isset($_POST['old-password']) ? htmlspecialchars(strip_tags($_POST['old-password'])) : '';
    $password = isset($_POST['password']) ? htmlspecialchars(strip_tags($_POST['password'])) : '';
    $passwordConfirm = isset($_POST['password-confirm']) ? htmlspecialchars(strip_tags($_POST['password-confirm'])) : '';
    $output = array('data' => '', 'response' => '', 'message' => '', 'status' => 500);
    if ($password == $passwordConfirm) {
        if ($passwordConfirm != $oldPassword) {
            $oldEncPw = md5($oldPassword . '#' . $username);
            $query = "SELECT `user_name`, `id`
              FROM `surveyor` WHERE id = :id 
              AND survey_code = 'CRSS' AND user_name = :un 
              AND enc_password = :op";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $hiddenUserId);
            $stmt->bindParam(':un', $username);
            $stmt->bindParam(':op', $oldEncPw);
            if ($stmt->execute()) {
                $num = $stmt->rowCount();
                if ($num > 0) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($hiddenUserId == $row['id'] && $username == $row['user_name']) {
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
                $upQuery = "UPDATE `surveyor` SET enc_password = :np, updated_on = now()
              WHERE id = :id  AND survey_code = 'CRSS' 
                AND user_name = :un AND enc_password = :op";
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
} elseif ($type == 'changePassword') {
    $hiddenUserId = isset($_POST['hiddenUserId']) ? htmlspecialchars(strip_tags($_POST['hiddenUserId'])) : '';
    $name = isset($_POST['name']) ? htmlspecialchars(strip_tags($_POST['name'])) : '';
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
              AND is_active = 1 AND admin_type = 2";
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
                            AND is_active = 1 AND admin_type = 2";
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
