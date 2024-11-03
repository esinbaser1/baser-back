<?php

namespace Models\ContactManagement;

use App\Database;

class DisplayContactStatusModel 
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getContactStatus()
    {
        try 
        {
            $request="SELECT * FROM status_contact";
            $pdo = $this->db->query($request);
            return $pdo->fetchAll(\PDO::FETCH_ASSOC);
        }
        catch(\PDOException $e)
        {
            throw new \Exception("Erreur de base de données: " . $e->getMessage());
        }
    }
}