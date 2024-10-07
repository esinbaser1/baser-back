<?php

require_once('vendor/autoload.php');

use Controllers\ContactManagement\AddContactController;
use Controllers\ContactManagement\ArchiveContactController;
use Controllers\ContactManagement\DeleteContactController;
use Controllers\ContactManagement\DisplayContactController;
use Controllers\ContactManagement\DisplayContactStatusController;
use Controllers\ContactManagement\DisplayContactTypeOfProjectController;
use Controllers\ContactManagement\ReplyContactController;
use Controllers\ContentManagement\AddContentController;
use Controllers\ContentManagement\ArchiveContentController;
use Controllers\ContentManagement\DeleteContentController;
use Controllers\ContentManagement\DisplayContentController;
use Controllers\ContentManagement\UpdateContentController;
use Controllers\DisplaySectionController;
use Controllers\DisplayStatusController;
use Controllers\ImageManagement\AddImageController;
use Controllers\ImageManagement\DeleteImageController;
use Controllers\ImageManagement\DisplayImageController;
use Controllers\ImageManagement\UpdateImageController;
use Controllers\InformationContactManagement\AddInformationContactController;
use Controllers\InformationContactManagement\DeleteInformationContactController;
use Controllers\InformationContactManagement\DisplayInformationContactController;
use Controllers\InformationContactManagement\UpdateInformationContactController;
use Controllers\LoginController;
use Controllers\SocialNetworkManagement\AddSocialNetworkController;
use Controllers\SocialNetworkManagement\DeleteSocialNetworkController;
use Controllers\SocialNetworkManagement\DisplaySocialNetworkController;
use Controllers\SocialNetworkManagement\UpdateSocialNetworkController;
use Utils\AuthUtils;

// Initialisation des contrôleurs -------------------------

// Content
$content = new DisplayContentController();
$updateContent = new UpdateContentController();
$addContent = new AddContentController();
$deleteContent = new DeleteContentController();
$archiveContent = new ArchiveContentController();

// Image
$image = new DisplayImageController();
$addImage = new AddImageController();
$updateImage = new UpdateImageController();
$deleteImage = new DeleteImageController();

// Social Network

$socialNetwork = new DisplaySocialNetworkController();
$addSocialNetwork = new AddSocialNetworkController();
$updateSocialNetwork = new UpdateSocialNetworkController();
$deleteSocialNetwork = new DeleteSocialNetworkController();

// Information contact

$information = new DisplayInformationContactController();
$addInformation = new AddInformationContactController();
$updateInformation = new UpdateInformationContactController();
$deleteInformation = new DeleteInformationContactController();
$replyContact = new ReplyContactController();

// Contact

$contact = new DisplayContactController();
$contactStatus = new DisplayContactStatusController();
$contactTypeOfProject = new DisplayContactTypeOfProjectController();
$addContact = new AddContactController();
$deleteContact = new DeleteContactController();
$archiveContact = new ArchiveContactController();

// Section
$section = new DisplaySectionController();

// Status
$status = new DisplayStatusController();

// Login
$loginController = new LoginController();

// Initialisation de l'authentification JWT 
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

        // Content
    case 'content':
        $response = $content->getContents();
        break;

    case 'contentById':
        $id = $_GET['id'] ?? null;
        $response = $updateContent->getContentById($id);
        break;

    case 'addContent':
        $authResult = $authMiddleware->verifyAccess('admin');
        if ($authResult !== null) {  
            $response = $authResult;
        } else {
            $response = $addContent->addContents(); 
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
        
    case 'archiveContent':
        $authResult = $authMiddleware->verifyAccess('admin');
        if ($authResult !== null) {
            $response = $authResult;
        } else {
            $response = $archiveContent->archiveContent();
        }
        break;

        // Section
    case 'section':
        $response = $section->getSections();
        break;

        // Status
    case 'status':
        $response = $status->getStatus();
        break;

        // Image
    case "image":
        $response = $image->getImages();
        break;

    case 'imageById':
        $id = $_GET['id'] ?? null;
        $response = $updateImage->getImageById($id);

        break;

    case "addImage":
        $authResult = $authMiddleware->verifyAccess('admin');
        if ($authResult !== null) {
            $response = $authResult;
        } else {
            $response = $addImage->addImages();
        }
        break;

    case "updateImage":
        $authResult = $authMiddleware->verifyAccess('admin');
        if ($authResult !== null) {
            $response = $authResult;
        } else {
            $response = $updateImage->updateImage();
        }
        break;

    case "deleteImage":
        $authResult = $authMiddleware->verifyAccess('admin');
        if ($authResult !== null) {
            $response = $authResult;
        } else {
            $response = $deleteImage->deleteImages();
        }
        break;

        // Social Network
    case "socialNetwork":
        $response = $socialNetwork->getSocialNetwork();
        break;

    case 'socialNetworkById':
        $id = $_GET['id'] ?? null;
        $response = $updateSocialNetwork->getSocialNetworkById($id);
        break;


    case "addSocialNetwork":
        $authResult = $authMiddleware->verifyAccess('admin');
        if ($authResult !== null) {
            $response = $authResult;
        } else {
            $response = $addSocialNetwork->addSocialNetwork();
        }
        break;

    case "updateSocialNetwork":
        $authResult = $authMiddleware->verifyAccess('admin');
        if ($authResult !== null) {
            $response = $authResult;
        } else {
            $response = $updateSocialNetwork->updateSocialNetwork();
        }
        break;

    case "deleteSocialNetwork":
        $authResult = $authMiddleware->verifyAccess('admin');
        if ($authResult !== null) {
            $response = $authResult;
        } else {
            $response = $deleteSocialNetwork->deleteSocialNetwork();
        }
        break;

        // Information contact 

    case "information":
        $response = $information->getInformationContact();
        break;

    case 'informationById':
        $id = $_GET['id'] ?? null;
        $response = $updateInformation->getInformationContactById($id);

        break;

    case "addInformation":
        $authResult = $authMiddleware->verifyAccess('admin');
        if ($authResult !== null) {
            $response = $authResult;
        } else {
            $response = $addInformation->addInformationContact();
        }
        break;

    case "updateInformation":
        $authResult = $authMiddleware->verifyAccess('admin');
        if ($authResult !== null) {
            $response = $authResult;
        } else {
            $response = $updateInformation->updateInformationContact();
        }
        break;

    case "deleteInformation":
        $authResult = $authMiddleware->verifyAccess('admin');
        if ($authResult !== null) {
            $response = $authResult;
        } else {
            $response = $deleteInformation->deleteInformationContact();
        }
        break;

        // Contact

    case 'contact':
        $response = $contact->getContact();
        break;

    case 'contactStatus':
        $response = $contactStatus->getContactStatus();
        break;

    case 'contactTypeOfProject':
        $response = $contactTypeOfProject->getContactTypeOfProject();
        break;

    case 'addContact':
        $response = $addContact->addContact();
        break;

    case 'deleteContact':
        $authResult = $authMiddleware->verifyAccess('admin');
        if ($authResult !== null) {
            $response = $authResult;
        } else {
            $response = $deleteContact->deleteContact();
        }
        break;

    case 'replyContact':
        $authResult = $authMiddleware->verifyAccess('admin');
        if ($authResult !== null) {
            $response = $authResult;
        } else {
            $response = $replyContact->replyContact();
        }
        break;

    case 'archiveContact':
        $authResult = $authMiddleware->verifyAccess('admin');
        if ($authResult !== null) {
            $response = $authResult;
        } else {
            $response = $archiveContact->archiveContact();
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
