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
if ($type == 'fetchSurveyDetails') {
    $surveyCode = isset($_POST['survey']) ? htmlspecialchars(strip_tags($_POST['survey'])) : 'CRSS';
    $output = array('aaData' => '', 'response' => '', 'message' => '', 'status' => 500);
    $query = "SELECT A.survey_code, B.survey_uuid, MAX(CASE WHEN C.question_bit = 1 THEN B.answer END) AS '1',
    MAX(CASE WHEN C.question_bit = 2 THEN B.answer END) AS '2',
    MAX(CASE WHEN C.question_bit = 3 THEN B.answer END) AS '3',
    MAX(CASE WHEN C.question_bit = 4 THEN B.answer END) AS '4',
    MAX(CASE WHEN C.question_bit = 5 THEN B.answer END) AS '5',
    MAX(CASE WHEN C.question_bit = 6 THEN B.answer END) AS '6',
    MAX(CASE WHEN C.question_bit = 7 THEN B.answer END) AS '7',
    MAX(CASE WHEN C.question_bit = 8 THEN B.answer END) AS '8',
    MAX(CASE WHEN C.question_bit = 9 THEN B.answer END) AS '9',
    MAX(CASE WHEN C.question_bit = 10 THEN B.answer END) AS '10',
    MAX(CASE WHEN C.question_bit = 11 THEN B.answer END) AS '11',
    MAX(CASE WHEN C.question_bit = 12 THEN B.answer END) AS '12',
    MAX(CASE WHEN C.question_bit = 13 THEN B.answer END) AS '13',
    MAX(CASE WHEN C.question_bit = 14 THEN B.answer END) AS '14',
    MAX(CASE WHEN C.question_bit = 15 THEN B.answer END) AS '15',
    MAX(CASE WHEN C.question_bit = 16 THEN B.answer END) AS '16',
    MAX(CASE WHEN C.question_bit = 17 THEN B.answer END) AS '17',
    MAX(CASE WHEN C.question_bit = 18 THEN B.answer END) AS '18',
    MAX(CASE WHEN C.question_bit = 19 THEN B.answer END) AS '19',
    MAX(CASE WHEN C.question_bit = 20 THEN B.answer END) AS '20'
    FROM surveyor as A 
    INNER JOIN surevey_data as B ON A.survey_code = B.survey_code
    INNER JOIN questions as C ON A.survey_code = C.survey_code AND C.question_bit = B.question_bit
    WHERE A.survey_code = :sc AND A.is_active = 1
    GROUP BY A.survey_code, B.survey_uuid
    ORDER BY C.question_bit;";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':sc', $surveyCode);
    if ($stmt->execute()) {
        $num = $stmt->rowCount();
        if ($num > 0) {
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $output['aaData'] = $row;
            $output['response'] = 'SUCCESS';
            $output['message'] = 'Successfully Fetched Survey Details !';
            $output['status'] = '200';
        } else {
            $output['response'] = 'NA';
            $output['message'] = 'Survey Details Not Available !';
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
