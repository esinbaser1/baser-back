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

           return $pdo->rowCount() > 0;
     
        } 
        catch (\PDOException $e) 
        {
            throw new \Exception("Erreur de base de données: " . $e->getMessage());
        }
    }
}
