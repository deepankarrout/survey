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
if ($type == 'fetchCardDetails') {
    $surveyCode = isset($_POST['survey']) ? htmlspecialchars(strip_tags($_POST['survey'])) : 'CRSS';
    $output = array('data' => '', 'response' => '', 'message' => '', 'status' => 500);
    $query = "SELECT count(DISTINCT A.id) as surveyor_cnt, count(DISTINCT B.survey_uuid) as survey_cnt,
                count(DISTINCT C.question_bit) as total_qn
            FROM surveyor as A 
            INNER JOIN surevey_data as B ON A.survey_code = B.survey_code
            INNER JOIN questions as C ON A.survey_code = C.survey_code
            WHERE A.survey_code = :sc AND A.is_active = 1;";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':sc', $surveyCode);
    if ($stmt->execute()) {
        $num = $stmt->rowCount();
        if ($num > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $output['data'] = $row;
            $output['response'] = 'SUCCESS';
            $output['message'] = 'Successfully Fetched Analytic Details !';
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
} else {
    echo json_encode(array('response' => 'FAILURE', 'message' => 'Invalid Request !', 'status' => 404));
    exit;
}
