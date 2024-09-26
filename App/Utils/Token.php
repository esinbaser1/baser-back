<?php

namespace Utils;

use Firebase\JWT\JWT;
use Dotenv\Dotenv;

class Token
{
    // le constructeur sert à charger les variables d'environnement au moment où l'objet est créé
    public function __construct()
    {
        // Charger les variables d'environnement depuis le fichier .env
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');  

        $dotenv->load(); 
    }

    // Générer un JWT avec une expiration
    public function generateToken($userId, $userRole)
    {
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600; // Le token expire après 1 heure

        $payload = [
            'iat' => $issuedAt,              // Heure à laquelle le token est émis
            'exp' => $expirationTime,        // Expiration du token
            'user_id' => $userId,            // L'identifiant de l'utilisateur
            'role' => $userRole              // Le rôle de l'utilisateur (admin, user, etc.)
        ];

        // Générer le token JWT avec la clé secrète depuis le fichier .env
        return JWT::encode($payload, $_ENV['JWT_SECRET_KEY'], 'HS256');
    }

}
