<?php

namespace Models\InformationContactManagement;

use App\Database;

class DeleteInformationContactModel
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function deleteInformationContact($id)
    {
        try 
        {
            $request = "DELETE FROM information_contact WHERE id = ?";
            $pdo = $this->db->prepare($request);
            $pdo->execute([$id]);
    
            if ($pdo->rowCount() > 0) 
            {
                return ["success" => true, "message" => "Information de contact supprimée avec succès."];
            } 
            else 
            {
                return ["success" => false, "message" => "Information de contact introuvable."];
            }
        } 
        catch (\PDOException $e) 
        {
            return ["success" => false, "message" => "Erreur de base de données: " . $e->getMessage()];
        }
    }
}
