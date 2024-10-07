<?php

namespace Models\ContactManagement;

use App\Database;

class DeleteContactModel 
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function deleteContact($contactId)
    {
        try 
        {
            $request = "DELETE FROM contact WHERE id = ?";
            $pdo = $this->db->prepare($request);
            $pdo->execute([$contactId]);

            if ($pdo->rowCount() > 0) 
            {
                return ["success" => true, "message" => "Message supprimé avec succès."];
            } 
            else 
            {
                return ["success" => false, "message" => "Message introuvable."];
            }
        } 
        catch (\PDOException $e) 
        {
            return ["success" => false, "message" => "Erreur de base de données : " . $e->getMessage()];
        }
    }
}
