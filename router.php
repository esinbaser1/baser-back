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

$content = new DisplayContentController();
$updateContent = new UpdateContentController;
$addContent = new AddContentController();
$deleteContent = new DeleteContentController();


$section = new DisplaySectionController();
$status = new DisplayStatusController();


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

    case 'content':
        $response = $content->getContents();
        break;

    case 'addContent':
        $response = $addContent->addContents();
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
        $response = $updateContent->updateContent();
        break;

    case 'deleteContent':
        $response = $deleteContent->deleteContents();
        break;

    default:
        http_response_code(404);
        $response = ["success" => false, "message" => "Action non trouvée"];
        break;
}

header('Content-Type: application/json');
echo json_encode($response);
