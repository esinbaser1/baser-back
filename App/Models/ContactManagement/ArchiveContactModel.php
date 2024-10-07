<?php
namespace Models\ContactManagement;

use App\Database;

class ArchiveContactModel
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function archiveContact($id)
    {
        try 
        {
            $request = "UPDATE contact SET is_archived = 1 WHERE id = ?";
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