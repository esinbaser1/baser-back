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
    
            if ($pdo->rowCount() > 0) 
            {
                return ["success" => true, "message" => "Contenu supprimé avec succès."];
            } 
            else 
            {
                return ["success" => false, "message" => "Contenu introuvable."];
            }
        } 
        catch (\PDOException $e) 
        {
            return ["success" => false, "message" => "Erreur de base de données : " . $e->getMessage()];
        }
    }
}
