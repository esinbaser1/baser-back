<?php

namespace Models\InformationContactManagement;

use App\Database;
use PDOException;

class AddInformationContactModel
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function addInformationContact($mobile, $email, $address)
    {
        try 
        {
            $request = "INSERT INTO information_contact (mobile, email, address) VALUES (?, ?, ?)";
            $pdo = $this->db->prepare($request);
            $pdo->execute([$mobile, $email, $address]);

            return true;
        } 
        catch (PDOException $e) 
        {
            throw new \Exception("Erreur de base de données: " . $e->getMessage());
        }
    }
}
