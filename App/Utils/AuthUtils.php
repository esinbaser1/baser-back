<?php

namespace Utils;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Dotenv\Dotenv;

class AuthUtils
{
    public function __construct()
    {
        // Charger les variables d'environnement depuis le fichier .env
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
    }

    // Extraire le token JWT des en-têtes de la requête
    public function extractTokenFromHeaders()
    {
        $headers = getallheaders();
        if (isset($headers['Authorization'])) {
            return str_replace('Bearer ', '', $headers['Authorization']);
        }
        return null;
    }

    // Vérifier l'accès à une route avec un rôle spécifique
    public function verifyAccess($requiredRole = 'admin')
    {
        // Extraire le token JWT des en-têtes
        $token = $this->extractTokenFromHeaders();

        if (!$token) {
            http_response_code(401);
            return ["success" => false, "message" => "Accès non autorisé"];
        }

        try {
            // Décoder le token JWT en utilisant la clé secrète chargée depuis .env
            $decoded = JWT::decode($token, new Key($_ENV['JWT_SECRET_KEY'], 'HS256'));

            // Vérifier si le token a expiré
            if ($decoded->exp < time()) {
                http_response_code(401);
                return ["success" => false, "message" => "Token expiré"];
            }

            // Extraire le rôle du token JWT
            $userRole = $decoded->role;
            $userId = $decoded->user_id;

            error_log("User ID = " . $userId . " - Rôle = " . $userRole);

            // Vérifier si le rôle est correct (insensible à la casse)
            if (strtolower($userRole) !== strtolower($requiredRole)) {
                http_response_code(403);
                return ["success" => false, "message" => "Droits insuffisants."];
            }

            // Si tout est bon, accès accordé
            return null;
        } catch (\Exception $e) {
            http_response_code(401);
            return ["success" => false, "message" => "Token invalide ou non autorisé"];
        }
    }
}
