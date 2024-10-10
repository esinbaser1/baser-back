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
            $request = "SELECT * FROM section_image";
            $pdo = $this->db->query($request);
            $section = $pdo->fetchAll(\PDO::FETCH_ASSOC);

            return ["success" => true, "sections" => $section];
        }
        catch(\PDOException $e)
        {
            return ["success" => false, "message" => "Erreur de base de données"];
        }
    }
}