<?php

require_once './App/Models/UserModel.php';

use Models\UserModel;

$userModel = new UserModel();

// Créer un nouvel utilisateur
$response = $userModel->createUser('esin@gmail.com', 'esin');

// Afficher le résultat
if ($response['success']) {
    echo $response['message'];
} else {
    echo $response['message'];
}
?>
