<?php

namespace Utils;

use Models\LoginModel;
use Utils\Token;

class AuthUtils
{
    protected $token;

    public function __construct()
    {
        $this->token = new Token();
    }

    public function verifyAccess($requiredRole = 'admin') // Cette méthode va vérifier si l'utilisateur a le rôle admin pour accéder à la ressource protégée
    {
        $headers = getallheaders(); // Récupère tous les en-têtes HTTP de la requête, y compris l'en-tête d'autorisation (Authorization) qui contient le token d'authentification
        $authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : ''; // Vérifie si l'en-tête Authorization est présent dans la requête. Si oui, il stocke sa valeur dans $authHeader, sinon il le laisse vide

        if (!$authHeader) { // Si l'en-tête Authorization est manquant, cela signifie que l'utilisateur n'est pas authentifié
            http_response_code(401); // HTTP 401 = Non autorisé
            return ["success" => false, "message" => "Authorization header missing"]; // Retourne un message d'erreur indiquant que l'en-tête d'autorisation est manquant
        }

        $token = str_replace('Bearer ', '', $authHeader); // Cette ligne extrait le token réel de l'en-tête Authorization. Généralement, l'en-tête Authorization est au format Bearer <token>, donc cette ligne enlève la partie Bearer pour ne garder que le token
        $tokenVerification = $this->token->verifyToken($token); // Vérifie la validité du token

        if (!$tokenVerification['success']) { // Si le token est expiré ou invalide
            http_response_code(401); // HTTP 401 = Non autorisé
            return $tokenVerification; // Retourne le résultat de la vérification du token qui contient le message d'erreur approprié
        }

        $userId = $tokenVerification['user_id']; // Si le token est valide, l'ID de l'utilisateur est extrait du résultat de la vérification
        $userRole = $this->getUserRole($userId); // Appelle la méthode getUserRole pour obtenir le rôle de l'utilisateur en fonction de son ID

        if ($userRole !== $requiredRole) { // Si le rôle de l'utilisateur ne correspond pas au rôle requis
            http_response_code(403); // HTTP 403 = Accès interdit
            return ["success" => false, "message" => "Access forbidden: insufficient rights"]; // Retourne un message d'erreur indiquant que l'accès est interdit en raison de droits insuffisants
        }

        // Si tout est correct, la méthode ne retourne aucune erreur
        return null;
    }

    protected function getUserRole($userId)
    {
        $loginModel = new LoginModel(); // Crée une instance de LoginModel pour récupérer les informations de l'utilisateur
        $user = $loginModel->getUserById($userId); // Récupère l'utilisateur à partir de son ID
        return $user ? $user['role'] : null; // Retourne le rôle de l'utilisateur s'il existe, sinon retourne null
    }
}
