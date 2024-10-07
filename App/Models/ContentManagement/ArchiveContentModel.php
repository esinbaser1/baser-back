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

            if ($pdo->rowCount() > 0) 
            {
                return ["success" => true, "message" => "Message archivé avec succès."];
            } 
            else 
            {
                return ["success" => false, "message" => "Message introuvable."];
            }
        } 
        catch (\PDOException $e) 
        {
            return ["success" => false, "message" => "Erreur de base de données: " . $e->getMessage()];
        }
    }
}
