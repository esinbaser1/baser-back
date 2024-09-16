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

    case 'logout':
        $response = $loginController->logout();
        break;

        case 'admin':
            $authResult = $authMiddleware->verifyAccess('admin');
            if ($authResult !== null) {
                $response = $authResult;  // si l'accès est refusé, renvoyer le message d'erreur
            } else {
                $response = ["success" => true, "message" => "Access granted to admin."];
            }
            break;

    case 'socialNetwork':
        $authResult = $authMiddleware->verifyAccess('admin');
        if ($authResult !== null) {
            $response = $authResult;
        } else {
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
