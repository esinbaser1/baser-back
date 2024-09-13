<?php

require_once('vendor/autoload.php');

use Controllers\LoginController;


$action = $_REQUEST['action'] ?? null;

// Initialisation de la réponse par défaut
$response = ["success" => false, "message" => "Action not found"];

$loginController = new LoginController();

// Gestion des actions
switch ($action) {
    case 'login':
        $response = $loginController->login();
        break;

    default:
        http_response_code(404);
        $response = ["success" => false, "message" => "Action not found"];
        break;
}

// Retourner la réponse en JSON
header('Content-Type: application/json');
echo json_encode($response);