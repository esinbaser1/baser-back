<?php

namespace Models\ContentManagement;

use App\Database;

class DeleteContentModel
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function deleteContent($id)
    {
        try 
        {
            $request = "DELETE FROM content WHERE id = ?";
            $pdo = $this->db->prepare($request);
            $pdo->execute([$id]);

            return $pdo->rowCount() > 0;
        } 
        catch (\PDOException $e) 
        {
            throw new \Exception("Erreur de base de données: " . $e->getMessage()); 
        }
    }
}