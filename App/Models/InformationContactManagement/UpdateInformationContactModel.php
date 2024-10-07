<?php

namespace Models\InformationContactManagement;

use App\Database;

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
        $existingInformationResult = $this->getInformationContactById($id);

        if (!$existingInformationResult['success']) 
        {
            return $existingInformationResult;  
        }

        $existingContent = $existingInformationResult['information'];

        if (
            $mobile === $existingContent['mobile'] &&
            $email === $existingContent['email'] &&
            $address === $existingContent['address']
        ) 
        {
            return ["success" => false, "message" => "Aucun changement détecté."];
        }

        try 
        {
            $request = "UPDATE information_contact SET mobile = ?, email = ?, address = ? WHERE id = ?";
            $pdo = $this->db->prepare($request);
            $pdo->execute([$mobile, $email, $address, $id]);

            return ["success" => true, "message" => "Information de contact mise à jour avec succès!"];
        } 
        catch (\PDOException $e) 
        {
            return ["success" => false, "message" => "Erreur de base de données: " . $e->getMessage()];
        }
    }

    public function getInformationContactById($id)
    {
        try 
        {
            $request = "SELECT * FROM information_contact WHERE id = ?";
            $pdo = $this->db->prepare($request);
            $pdo->execute([$id]);
            $information = $pdo->fetch(\PDO::FETCH_ASSOC);

            if ($information) 
            {
                return ["success" => true, "information" => $information];
            } 
            else 
            {
                return ["success" => false, "message" => "Information non trouvée."];
            }
        } 
        catch (\PDOException $e) 
        {
            return ["success" => false, "message" => "Erreur de base de données: " . $e->getMessage()];
        }
    }
}
