<?php

namespace Models;

use App\Database;

class DisplaySectionModel 
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getSection()
    {
        try
        {
            $request = "SELECT * FROM section";
            $pdo = $this->db->query($request);
            return $pdo->fetchAll(\PDO::FETCH_ASSOC);
        }
        catch(\PDOException $e)
        {
            throw new \Exception("Erreur de base de données: " . $e->getMessage());
        }
    }
}