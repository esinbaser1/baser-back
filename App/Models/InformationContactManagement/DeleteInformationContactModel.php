<?php

namespace Models\InformationContactManagement;

use App\Database;
use PDOException;

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

            return $pdo->rowCount() > 0;
        } 
        catch (PDOException $e) 
        {
            throw new \Exception("Erreur de base de données: " . $e->getMessage());
        }
    }
}