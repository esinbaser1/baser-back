<?php

require_once './App/Models/UserModel.php';

use Models\UserModel;

$userModel = new UserModel();

// Créer un nouvel utilisateur
$response = $userModel->createUser('hokablese@gmail.com', 'hokablese');

// Afficher le résultat
if ($response['success']) {
    echo $response['message'];
} else {
    echo $response['message'];
}
?>
