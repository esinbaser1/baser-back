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
            $statuses = $pdo->fetchAll(\PDO::FETCH_ASSOC);

            return ["success" => true, "statuses" => $statuses];
        }
        catch(\PDOException)
        {
            return ["success" => false, "message" => "Erreur de base de données"];
        }
    }
}