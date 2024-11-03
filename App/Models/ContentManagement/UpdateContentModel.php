<?php

namespace Models\ContentManagement;

use App\Database;
use PDOException;

class UpdateContentModel
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function updateContent($id, $content, $section, $status)
    {
        try 
        {
            $request = "UPDATE content SET content = ?, section_id = ?, status_id = ? WHERE id = ?";
            $pdo = $this->db->prepare($request);
            $pdo->execute([$content, $section, $status, $id]);

            return $pdo->rowCount() > 0; // Retourne true si une modification a été effectuée, sinon false
        } 
        catch (PDOException $e) 
        {
            throw new \Exception("Erreur de base de données: " . $e->getMessage()); 
        }
    }

    public function getContentById($id)
    {
        try 
        {
            $request = "SELECT * FROM content WHERE id = ?";
            $pdo = $this->db->prepare($request);
            $pdo->execute([$id]);
            return $pdo->fetch(\PDO::FETCH_ASSOC); // Retourne les données ou null si introuvable
        } 
        catch (PDOException $e) 
        {
            throw new \Exception("Erreur de base de données: " . $e->getMessage());
        }
    }
}