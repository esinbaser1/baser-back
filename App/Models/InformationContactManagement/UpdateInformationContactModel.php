<?php

namespace Models\InformationContactManagement;

use App\Database;
use PDOException;

class UpdateInformationContactModel
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function updateInformationContact($mobile, $email, $address, $id)
    {
        $existingContent = $this->getInformationContactById($id);

        if (!$existingContent) 
        {
            throw new \Exception("Information de contact introuvable.");
        }

        if (
            $mobile === $existingContent['mobile'] &&
            $email === $existingContent['email'] &&
            $address === $existingContent['address']
        ) 
        {
            return false; // Indique qu'aucun changement n'a été effectué
        }

        try 
        {
            $request = "UPDATE information_contact SET mobile = ?, email = ?, address = ? WHERE id = ?";
            $pdo = $this->db->prepare($request);
            $pdo->execute([$mobile, $email, $address, $id]);

            return $pdo->rowCount() > 0; // Retourne true si la mise à jour a réussi, sinon false
        } 
        catch (PDOException $e) 
        {
            throw new \Exception("Erreur de base de données: " . $e->getMessage()); 
        }
    }

    public function getInformationContactById($id)
    {
        try 
        {
            $request = "SELECT * FROM information_contact WHERE id = ?";
            $pdo = $this->db->prepare($request);
            $pdo->execute([$id]);
            return $pdo->fetch(\PDO::FETCH_ASSOC); 
        } 
        catch (PDOException $e) 
        {
            throw new \Exception("Erreur de base de données: " . $e->getMessage()); 
        }
    }
}
