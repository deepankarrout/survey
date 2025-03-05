<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// set your default time-zone
date_default_timezone_set('Asia/Kolkata');

$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "survey";

// variables used for jwt
$key = "tyfght78gcfgc9yfvghdrte5uffd3udgfctre767tfgftr";
$issued_at = time();
$expiration_time = $issued_at + (60 * 60); // valid for 1 hour
$issuer = "https://bgvsodisha.org/survey/";
?>