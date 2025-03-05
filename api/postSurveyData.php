<?php
//required headers
header("Access-Control-Allow-Origin: https://bgvsodisha.org/survey/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
// files needed to connect to database
include_once('../include/connection.php');
include_once('../include/common.php');
// files needed for JWT authentication
include_once '../include/config.php';
include_once '../assets/bundles/php-jwt-main/src/SignatureInvalidException.php';
include_once '../assets/bundles/php-jwt-main/src/JWT.php';
include_once '../assets/bundles/php-jwt-main/src/Key.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

$output = array('response' => '', 'message' => '', 'token' => '', 'status' => 401);
$data = json_decode(file_get_contents("php://input"));
$jwt = isset($data->token) ? $data->token : "";
$datas = (array) $data;
if ($jwt) {
    try {
        $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
        $surveyCode = 'CRSS';
        $database = new Database();
        $conn = $database->getConnection();
        $QnQuery = "SELECT `question_bit`, `question`, `is_required`
                  FROM `questions` 
                  WHERE `survey_code` = :sc AND `status` = 1
                  ORDER BY `question_bit`;";
        $stmt = $conn->prepare($QnQuery);
        $stmt->bindParam(':sc', $surveyCode);
        if ($stmt->execute()) {
            $num = $stmt->rowCount();
            if ($num > 0) {
                $uuid = uniqid();
                $answerArray = array();
                $surveyorName = $decoded->data->name;
                $surveyorUserName = $decoded->data->user_name;
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $qn_no = $row['question_bit'];
                    if($row['is_required'] && !isset($datas['qn_'.$row['question_bit']])){
                        $output['response'] = 'FAILURE';
                        $output['message'] = 'Please submit mandatory question no '.$row['question_bit'];
                        $output['status'] = '401';
                        http_response_code($output['status']);
                        echo json_encode($output);exit;
                    }
                    $answer = isset($datas['qn_'.$row['question_bit']]) ? $datas['qn_'.$row['question_bit']] : "";
                    $answerArray[] = [$uuid, $surveyCode, $surveyorName, $qn_no, $answer, $surveyorUserName];
                }
                if (!empty($answerArray)) {
                    $values = str_repeat('?,', count($answerArray[0]) - 1) . '?';
                    $sql = "INSERT INTO surevey_data (survey_uuid, survey_code, surveyor_name,
                            question_bit, answer, created_by ) 
                            VALUES " . str_repeat("($values),", count($answerArray) - 1) . "($values)";
                    $stmt = $conn->prepare($sql);
                    if ($stmt->execute(array_merge(...$answerArray))) {
                        $output['response'] = 'SUCCESS';
                        $output['message'] = 'Sucessfully Submitted !';
                        $output['status'] = '200';
                    }else{
                        $output['response'] = 'FAILURE';
                        $output['message'] = 'Failed to Submit Survey, Try Again !';
                        $output['status'] = '401';
                    }
                }else{
                    $output['response'] = 'FAILURE';
                    $output['message'] = 'Question not available for this survey !';
                    $output['status'] = '200';
                }
            } else {
                $output['response'] = 'FAILURE';
                $output['message'] = 'Questions not available !';
                $output['status'] = '200';
            }
        } else {
            $output['response'] = 'FAILURE';
            $output['message'] = 'Failed to submit survey !';
            $output['status'] = '500';
        }
    } catch (Exception $e) {
        $output['response'] = 'FAILURE';
        $output['message'] = $e->getMessage();
        $output['status'] = '401';
    }
} else {
    $output['response'] = 'FAILURE';
    $output['message'] = 'Invalid Request !';
    $output['status'] = '401';
}
http_response_code($output['status']);
echo json_encode($output);
