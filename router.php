<?php

require_once('vendor/autoload.php');
$action = $_REQUEST['action'] ?? null;

$response = ["success" => false, "message" => "Action not found"];

// switch ($action) {

// }


echo json_encode($response);