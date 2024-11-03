<?php

namespace Models\ContentManagement;

use App\Database;

class ArchiveContentModel
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function archiveContent($id)
    {
        try 
        {
            $request = "UPDATE content SET is_archived = 1 WHERE id = ?";
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