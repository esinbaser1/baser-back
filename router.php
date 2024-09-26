<?php

require_once('vendor/autoload.php');

use Controllers\ContentManagement\AddContentController;
use Controllers\ContentManagement\DeleteContentController;
use Controllers\ContentManagement\DisplayContentController;
use Controllers\ContentManagement\UpdateContentController;
use Controllers\DisplaySectionController;
use Controllers\DisplayStatusController;
use Controllers\LoginController;
use Controllers\SocialNetworkController;
use Utils\AuthUtils;

// Initialisation des contrôleurs
$content = new DisplayContentController();
$updateContent = new UpdateContentController();
$addContent = new AddContentController();
$deleteContent = new DeleteContentController();

$section = new DisplaySectionController();
$status = new DisplayStatusController();

$loginController = new LoginController();
$socialNetworkController = new SocialNetworkController();

// Initialisation de l'authentification JWT (middleware)
$authMiddleware = new AuthUtils();

// Récupération de l'action à exécuter
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
            $response = $authResult;
        } else {
            $response = ["success" => true, "role" => "admin"];
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

    case 'addContent':
        $authResult = $authMiddleware->verifyAccess('admin');  // vérification admin
        if ($authResult !== null) {  // si pas d'accès
            $response = $authResult;  // retourne l'erreur, comme un 401
        } else {
            $response = $addContent->addContents();  // sinon, ajoute le contenu
        }
        break;

    case 'content':
        $response = $content->getContents();
        break;

    case 'section':
        $response = $section->getSections();
        break;

    case 'status':
        $response = $status->getStatus();
        break;

    case 'contentById':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $response = $updateContent->getContentById($id);
        } else {
            $response = ["success" => false, "message" => "ID non fourni"];
        }
        break;

    case 'updateContent':
        $authResult = $authMiddleware->verifyAccess('admin');
        if ($authResult !== null) {
            $response = $authResult;
        } else {
            $response = $updateContent->updateContent();
        }
        break;

    case 'deleteContent':
        $authResult = $authMiddleware->verifyAccess('admin');
        if ($authResult !== null) {
            $response = $authResult;
        } else {
            $response = $deleteContent->deleteContents();
        }
        break;

    default:
        http_response_code(404);
        $response = ["success" => false, "message" => "Action non trouvée"];
        break;
}

// Retourner la réponse en JSON
header('Content-Type: application/json');
echo json_encode($response);
