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
if ($type == 'fetchCenterList') {
    $surveyCode = isset($_GET['survey']) ? htmlspecialchars(strip_tags($_GET['survey'])) : 'CRSS';
    $output = array('data' => [], 'response' => '', 'message' => '', 'status' => 500);
    $query = "SELECT `code`, `name` FROM center_master WHERE survey_code = :sc AND `status` = 1";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':sc', $surveyCode);
    if ($stmt->execute()) {
        $num = $stmt->rowCount();
        if ($num > 0) {
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $output['data'] = $row;
            $output['response'] = 'SUCCESS';
            $output['message'] = 'Successfully Fetched !';
            $output['status'] = '200';
        } else {
            $output['response'] = 'NA';
            $output['message'] = 'Data Not Available !';
            $output['status'] = '500';
        }
    } else {
        $output['response'] = 'FAILURE';
        $output['message'] = 'Somthing Went Wrong !';
        $output['status'] = '500';
    }
    echo json_encode($output);
    exit;
} else if ($type == 'verifyCenter') {
    $surveyCode = isset($_GET['survey']) ? htmlspecialchars(strip_tags($_GET['survey'])) : 'CRSS';
    $centerCode = isset($_GET['center_code']) ? htmlspecialchars(strip_tags($_GET['center_code'])) : NULL;
    $output = array('data' => [], 'response' => '', 'message' => '', 'status' => 500);
    $query = "SELECT `code`, `name`, B.survey_date, CASE WHEN COUNT(B.survey_uuid) > 0 THEN TRUE ELSE FALSE END AS is_surveyed
            FROM `center_master` AS A
            LEFT JOIN `surevey_data` AS B ON A.survey_code = B.survey_code AND A.code = B.survey_uuid
            WHERE A.survey_code = :sc AND A.code = :center_code AND A.status = 1
            GROUP BY `code`, `name`, B.survey_date;";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':sc', $surveyCode);
    $stmt->bindParam(':center_code', $centerCode);
    if ($stmt->execute()) {
        $num = $stmt->rowCount();
        if ($num > 0) {
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $output['data'] = $row;
            $output['response'] = 'SUCCESS';
            $output['message'] = 'Successfully Fetched !';
            $output['status'] = '200';
        } else {
            $output['response'] = 'NA';
            $output['message'] = 'Data Not Available !';
            $output['status'] = '500';
        }
    } else {
        $output['response'] = 'FAILURE';
        $output['message'] = 'Somthing Went Wrong !';
        $output['status'] = '500';
    }
    echo json_encode($output);
    exit;
} else if ($type == 'getQuestions') {
    $surveyCode = isset($_GET['survey']) ? htmlspecialchars(strip_tags($_GET['survey'])) : 'CRSS';
    $output = array('data' => [], 'topic' => [], 'sub_topic' => [], 'option' => [], 'response' => '', 'message' => '', 'status' => 500);
    $QuestionQuery = "SELECT A.topic_code, A.sub_topic_code, A.question_code, A.question, A.option1, A.option2, A.option3, A.option4, A.option5, A.question_type, A.is_required 
            FROM `questions` AS A 
            WHERE A.survey_code = :sc AND A.status = 1;";
    $stmt = $conn->prepare($QuestionQuery);
    $stmt->bindParam(':sc', $surveyCode);
    if ($stmt->execute()) {
        $num = $stmt->rowCount();
        if ($num > 0) {
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($row AS $QRow){
                $output['data'][$QRow['sub_topic_code']][] = $QRow;
            }
            $output['response'] = 'SUCCESS';
            $output['message'] = 'Successfully Fetched !';
            $output['status'] = '200';
        } else {
            $output['response'] = 'NA';
            $output['message'] = 'Data Not Available !';
            $output['status'] = '500';
        }
    } else {
        $output['response'] = 'FAILURE';
        $output['message'] = 'Somthing Went Wrong !';
        $output['status'] = '500';
    }

    $TopicQuery = "SELECT `code`, `name` FROM `topic`
        WHERE survey_code = :sc AND STATUS = 1;";
    $stmt = $conn->prepare($TopicQuery);
    $stmt->bindParam(':sc', $surveyCode);
    if ($stmt->execute()) {
        $num = $stmt->rowCount();
        if ($num > 0) {
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $output['topic'] = $row;
            $output['response'] = 'SUCCESS';
            $output['message'] = 'Successfully Fetched !';
            $output['status'] = '200';
        } else {
            $output['response'] = 'NA';
            $output['message'] = 'Data Not Available !';
            $output['status'] = '500';
        }
    } else {
        $output['response'] = 'FAILURE';
        $output['message'] = 'Somthing Went Wrong !';
        $output['status'] = '500';
    }

    $SubTopicQuery = "SELECT `topic_code`, `code`, `name` FROM `subtopic`
        WHERE survey_code = :sc AND STATUS = 1;";
    $stmt = $conn->prepare($SubTopicQuery);
    $stmt->bindParam(':sc', $surveyCode);
    if ($stmt->execute()) {
        $num = $stmt->rowCount();
        if ($num > 0) {
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($row AS $STRow){
                $output['sub_topic'][$STRow['topic_code']][] = $STRow;
            }
            $output['response'] = 'SUCCESS';
            $output['message'] = 'Successfully Fetched !';
            $output['status'] = '200';
        } else {
            $output['response'] = 'NA';
            $output['message'] = 'Data Not Available !';
            $output['status'] = '500';
        }
    } else {
        $output['response'] = 'FAILURE';
        $output['message'] = 'Somthing Went Wrong !';
        $output['status'] = '500';
    }

    $OptionQuery = "SELECT `option_code`, `option_text` FROM `option_master`
        WHERE survey_code = :sc AND STATUS = 1;";
    $stmt = $conn->prepare($OptionQuery);
    $stmt->bindParam(':sc', $surveyCode);
    if ($stmt->execute()) {
        $num = $stmt->rowCount();
        if ($num > 0) {
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($row AS $ORow){
                $output['option'][$ORow['option_code']] = $ORow['option_text'];
            }
            $output['response'] = 'SUCCESS';
            $output['message'] = 'Successfully Fetched !';
            $output['status'] = '200';
        } else {
            $output['response'] = 'NA';
            $output['message'] = 'Data Not Available !';
            $output['status'] = '500';
        }
    } else {
        $output['response'] = 'FAILURE';
        $output['message'] = 'Somthing Went Wrong !';
        $output['status'] = '500';
    }
    echo json_encode($output);
    exit;
} else if ($type == 'saveSurvey') {
    $surveyCode = isset($_REQUEST['survey']) ? htmlspecialchars(strip_tags($_REQUEST['survey'])) : 'CRSS';
    $centerCode = isset($_REQUEST['center_code']) ? htmlspecialchars(strip_tags($_REQUEST['center_code'])) : NULL;
    $output = array('data' => [], 'response' => '', 'message' => '', 'status' => 500);
    try {
        $QnQuery = "SELECT `question_code`, `question`, `is_required`
                  FROM `questions` 
                  WHERE `survey_code` = :sc AND `status` = 1
                  ORDER BY `id`;";
        $stmt = $conn->prepare($QnQuery);
        $stmt->bindParam(':sc', $surveyCode);
        if ($stmt->execute()) {
            $num = $stmt->rowCount();
            if ($num > 0) {
                $uuid = uniqid();
                $answerArray = array();
                $surveyorName = 'Test Surveyor';
                $surveyorUserName = 'surveyor';
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $qnCode = $row['question_code'];
                    if($row['is_required'] && !isset($_POST[$row['question_code']])){
                        $output['response'] = 'FAILURE';
                        $output['message'] = 'Please submit all mandatory question.';
                        $output['status'] = '401';
                        // http_response_code($output['status']);
                        echo json_encode($output);
                        exit;
                    }
                    $answer = isset($_POST[$row['question_code']]) ? $_POST[$row['question_code']] : "";
                    $answerArray[] = [$centerCode, $surveyCode, $surveyorName, $qnCode, $answer, $surveyorUserName];
                }
                if (!empty($answerArray)) {
                    $values = str_repeat('?,', count($answerArray[0]) - 1) . '?';
                    $sql = "INSERT INTO surevey_data (survey_uuid, survey_code, surveyor_name,
                            question_code, answer, created_by ) 
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
    echo json_encode($output);
    exit;
} else {
    echo json_encode(array('response' => 'FAILURE', 'message' => 'Invalid Request !', 'status' => 404));
    exit;
}
