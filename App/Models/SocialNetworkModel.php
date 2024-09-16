<?php

namespace Models;

use App\Database;

class SocialNetworkModel
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function fetchAll()
    {
        try {
            $request = "SELECT * FROM social_network";
            $pdo = $this->db->prepare($request);
            $pdo->execute();
            return $pdo->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Erreur lors de la récupération des réseaux sociaux : " . $e->getMessage());
            return [];
        }
    }
}
