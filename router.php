<?php

require_once('vendor/autoload.php');

use Controllers\LoginController;
use Controllers\SocialNetworkController;
use Utils\AuthUtils;

$loginController = new LoginController();
$socialNetworkController = new SocialNetworkController();
$authMiddleware = new AuthUtils();

$action = $_REQUEST['action'] ?? null;
$response = ["success" => false, "message" => "Action non trouvée"];

switch ($action) {

    case 'login':
        $response = $loginController->login();
        break;

    case 'admin':
        $authMiddleware->verifyAccess('admin');
        break;

    case 'socialNetwork':
        $authResult = $authMiddleware->verifyAccess('admin');
        if ($authResult !== null) { //Si $authResult contient une erreur (c'est-à-dire qu'il est non nul), cette erreur est assignée à $response
            $response = $authResult;
        } else { // Si la vérification réussit, on continue avec l'exécution normale
            $response = $socialNetworkController->getSocialNetworks();
        }
        break;

    default:
        http_response_code(404);
        $response = ["success" => false, "message" => "Action non trouvée"];
        break;
}

header('Content-Type: application/json');
echo json_encode($response);
