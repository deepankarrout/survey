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
if ($type == 'getReport') {
    $surveyCode = isset($_GET['survey']) ? htmlspecialchars(strip_tags($_GET['survey'])) : 'CRSS';
    $output = array('html' => '','response' => '', 'message' => '', 'status' => 500);

    $CenterDetails = array();
    $query = "SELECT `code`, `name` FROM center_master WHERE survey_code = :sc AND `status` = 1";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':sc', $surveyCode);
    if ($stmt->execute()) {
        $num = $stmt->rowCount();
        if ($num > 0) {
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $CenterDetails = $row;
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

    $TopicDetails = array();
    if($output['response'] == 'SUCCESS'){
        $TopicQuery = "SELECT B.code, B.name, COUNT(question_code) AS colspan FROM questions AS A
            INNER JOIN topic AS B ON B.survey_code = :sc AND A.topic_code = B.code AND B.status = 1
            WHERE A.survey_code = :sc AND A.status = 1
            GROUP BY B.code, B.name
            ORDER BY B.id;";
        $stmt = $conn->prepare($TopicQuery);
        $stmt->bindParam(':sc', $surveyCode);
        if ($stmt->execute()) {
            $num = $stmt->rowCount();
            if ($num > 0) {
                $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($row AS $TopicRow){
                    $TopicDetails[$TopicRow['code']]['name'] = $TopicRow['name'];
                    $TopicDetails[$TopicRow['code']]['colspan'] = $TopicRow['colspan'];
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
    }

    $SubTopicDetails = array();
    if($output['response'] == 'SUCCESS'){
        $SubTopicQuery = "SELECT `topic_code`, `code`, `name` FROM `subtopic`
            WHERE survey_code = :sc AND STATUS = 1;";
        $stmt = $conn->prepare($SubTopicQuery);
        $stmt->bindParam(':sc', $surveyCode);
        if ($stmt->execute()) {
            $num = $stmt->rowCount();
            if ($num > 0) {
                $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($row AS $STRow){
                    $SubTopicDetails[$STRow['code']] = $STRow['name'];
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
    }
    
    $OptionDetails = array();
    if($output['response'] == 'SUCCESS'){
        $OptionQuery = "SELECT `option_code`, `option_text` FROM `option_master`
            WHERE survey_code = :sc AND STATUS = 1;";
        $stmt = $conn->prepare($OptionQuery);
        $stmt->bindParam(':sc', $surveyCode);
        if ($stmt->execute()) {
            $num = $stmt->rowCount();
            if ($num > 0) {
                $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($row AS $ORow){
                    $OptionDetails[$ORow['option_code']] = $ORow['option_text'];
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
    }

    $QuestionDetails = array();
    $QuestionArr = array();
    if($output['response'] == 'SUCCESS'){
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
                    $QuestionDetails[$QRow['topic_code']][$QRow['sub_topic_code']][] = $QRow;
                    $QuestionArr[$QRow['question_code']] = $QRow;
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
    }

    $SurveyDetails = array();
    if($output['response'] == 'SUCCESS'){
        $SurveyDetailsQuery = "SELECT * FROM surevey_data AS A
            WHERE A.survey_code = :sc;";
        $stmt = $conn->prepare($SurveyDetailsQuery);
        $stmt->bindParam(':sc', $surveyCode);
        if ($stmt->execute()) {
            $num = $stmt->rowCount();
            if ($num > 0) {
                $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($row AS $SRow){
                    $SurveyDetails[$SRow['survey_uuid']][$SRow['question_code']] = $SRow;
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
    }
    
    $TableHeader1stRow = '<th colspan="5" class="text-center">Tracking :- CR School</th>';
    $TableHeader2ndRow = '<th colspan="5"></th>';
    $TableHeader3rdRow = '<th>Sl. No</th>
                        <th>UDISE Code</th>
                        <th>District</th>
                        <th>Name of the School</th>
                        <th>Date</th>'; 
    $TableBody = '';
    if($output['response'] == 'SUCCESS'){
        if(count($QuestionDetails) > 0 ){
            foreach($QuestionDetails AS $QuestionTopicKey => $QuestionTopicVal){
                $TableHeader1stRow .= '<th colspan="'.$TopicDetails[$QuestionTopicKey]['colspan'].'" class="text-center">'.$TopicDetails[$QuestionTopicKey]['name'].'</th>';
                foreach($QuestionTopicVal AS $QuestionSubTopicKey => $QuestionSubTopicVal){
                    $TableHeader2ndRow .= '<th colspan="'.count($QuestionSubTopicVal).'" class="text-center">'.$SubTopicDetails[$QuestionSubTopicKey].'</th>';
                    foreach($QuestionSubTopicVal AS $QuestionKey => $QuestionVal){
                        $TableHeader3rdRow .= '<th>'.$QuestionVal['question'].'</th>';
                    }
                }
            }
        }
        if(count($CenterDetails) > 0){
            foreach($CenterDetails AS $Key => $Val){
                $TableBody .= '<tr>
                        <td>' . ((int)$Key + 1) . '</td>
                        <td>' . $Val['code'] . '</td>
                        <td></td>
                        <td>' . $Val['name'] . '</td>
                        <td></td>';
                foreach($QuestionArr AS $QAKey => $QAVal){
                    if($Val['code'] != null && $Val['code'] != '' && array_key_exists($Val['code'], $SurveyDetails)){
                        if($QAKey != null && $QAKey != '' && array_key_exists($QAKey, $SurveyDetails[$Val['code']])){
                            if(in_array($QAVal['question_type'], ['MCQ2','MCQ3','MCQ4']) && $SurveyDetails[$Val['code']][$QAKey]['answer'] != '' && $SurveyDetails[$Val['code']][$QAKey]['answer'] != null){
                                $Asnwer = $OptionDetails[$SurveyDetails[$Val['code']][$QAKey]['answer']];
                                $TableBody .= '<td>' . $Asnwer . '</td>';
                            }else if(in_array($QAVal['question_type'], ['Text','Numeric']) && $SurveyDetails[$Val['code']][$QAKey]['answer'] != '' && $SurveyDetails[$Val['code']][$QAKey]['answer'] != null){
                                $Asnwer = $SurveyDetails[$Val['code']][$QAKey]['answer'];
                                $TableBody .= '<td>' . $Asnwer . '</td>';
                            }else{
                                $TableBody .= '<td></td>';
                            }
                        }else{
                            $TableBody .= '<td></td>';
                        }
                    }else{
                        $TableBody .= '<td></td>';
                    }
                }
                $TableBody .= '</tr>';
            }
        }
    }
    $html = '<table class="table-hover" id="tableSurveyReport" style="width:100%;">
            <thead>
                <tr>'.$TableHeader1stRow.'</tr>
                <tr>'.$TableHeader2ndRow.'</tr>
                <tr>'.$TableHeader3rdRow.'</tr>
            </thead>
            <tbody>'.$TableBody.'</tbody>
        </table>';

    $output['response'] = 'SUCCESS';
    $output['message'] = 'Successfully Fetched !';
    $output['status'] = '200';
    $output['html'] = $html;
    echo json_encode($output);
    exit;
}  else {
    echo json_encode(array('response' => 'FAILURE', 'message' => 'Invalid Request !', 'status' => 404));
    exit;
}
