<?php
function validateRequiredData($data){
    foreach($data as $key => $val){
        if($val == '' || $val == null || $val == 'null'){
            echo json_encode(array('response' => 'FAILURE','message' => $key.' Should Not Be Empty !', 'status' => 500));exit;
        }
    }
}
?>