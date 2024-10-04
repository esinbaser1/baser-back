<?php

namespace Models\InformationContactManagement;

use App\Database;

class AddInformationContactModel
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Le modèle attend désormais les données validées depuis le contrôleur
    public function addInformationContact($mobile, $email, $address)
    {
        try 
        {
            $request = "INSERT INTO information_contact (mobile, email, address) VALUES (?, ?, ?)";
            $pdo = $this->db->prepare($request);
            $pdo->execute([$mobile, $email, $address]);
    
            return ["success" => true, "message" => "Information de contact ajoutée avec succès!"];
    
        } 
        catch (\PDOException $e) 
        {
            return ["success" => false, "message" => "Erreur de base de données: " . $e->getMessage()];
        }
    }
}
