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
            return $pdo->fetchAll(\PDO::FETCH_ASSOC);
        }
        catch(\PDOException $e)
        {
            throw new \Exception("Erreur de base de données: " . $e->getMessage());
        }
    }
}