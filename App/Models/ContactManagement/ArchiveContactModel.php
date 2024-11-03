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

            return $pdo->rowCount() > 0; // retourne true si un enregistrement a été modifié sinon false
        } 
        catch (\PDOException $e) 
        {
            throw new \Exception("Erreur de base de données: " . $e->getMessage());
        }
    }
}