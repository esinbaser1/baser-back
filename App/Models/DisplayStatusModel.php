<?php

namespace Models;

use App\Database;

class DisplayStatusModel 
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getStatus()
    {
        try
        {
            $request = "SELECT * FROM status_content";
            $pdo = $this->db->query($request);
            return $pdo->fetchAll(\PDO::FETCH_ASSOC);
        }
        catch(\PDOException $e)
        {
            throw new \Exception("Erreur de base de données: " . $e->getMessage());
        }
    }
}
