<?php

namespace Models\ContentManagement;

use App\Database;
use PDOException;

class DisplayContentModel
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getContent()
    {
        try 
        {
            $request = "SELECT content.*, status_content.name AS status_name, section.name AS section_name 
                        FROM content 
                        JOIN status_content ON content.status_id = status_content.id 
                        JOIN section ON content.section_id = section.id";

            $pdo = $this->db->query($request);
            return $pdo->fetchAll(\PDO::FETCH_ASSOC); 
        } 
        catch (PDOException $e) 
        {
            throw new \Exception("Erreur de base de données: " . $e->getMessage()); // Lève une exception pour que le contrôleur la capture
        }
    }
}