<?php

namespace Models\InformationContactManagement;

use App\Database;

class DisplayInformationContactModel
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getInformationContact()
    {
        try 
        {
            $request = "SELECT * FROM information_contact";
            $pdo = $this->db->query($request);
            $information = $pdo->fetchAll(\PDO::FETCH_ASSOC);

            return ["success" => true, "information" => $information];
        } 
        catch (\PDOException $e) 
        {
            return ["success" => false, "message" => "Erreur de base de données"];
        }
    }
}