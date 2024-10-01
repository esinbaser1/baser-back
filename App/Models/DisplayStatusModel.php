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
            $statuses = $pdo->fetchAll(\PDO::FETCH_ASSOC);

            return ["success" => true, "statuses" => $statuses];
        }
        catch(\PDOException $e)
        {
            return ["success" => false, "message" => "Erreur de base de données"];
        }
    }
}
