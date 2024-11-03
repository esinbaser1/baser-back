<?php

namespace Models\ContentManagement;

use App\Database;
use PDOException;

class AddContentModel
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function addContent($content, $section, $status)
    {
        try 
        {
            $request = "INSERT INTO content (content, section_id, status_id) VALUES (?, ?, ?)";
            $pdo = $this->db->prepare($request);
            $pdo->execute([$content, $section, $status]);

            return true;
        } 
        catch (PDOException $e) 
        {
            throw new \Exception("Erreur de base de données: " . $e->getMessage());
        }
    }
}
