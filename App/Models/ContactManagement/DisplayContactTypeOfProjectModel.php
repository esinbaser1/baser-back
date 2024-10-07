<?php

namespace Models\ContactManagement;

use App\Database;

class DisplayContactTypeOfProjectModel 
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getContactTypeOfProject()
    {
        try 
        {
            $request="SELECT * FROM type_of_project";
            $pdo = $this->db->query($request);
            $typeOfProject = $pdo->fetchAll(\PDO::FETCH_ASSOC);

            return ["success" => true, "typeOfProject" => $typeOfProject];
        }
        catch(\PDOException)
        {
            return ["success" => false, "message" => "Erreur de base de données"];
        }
    }
}