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

    public function addInformationContact()
    {
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);
    
        $mobile = isset($data['mobile']) ? trim(strip_tags($data['mobile'])) : null;
        $email = isset($data['email']) ? filter_var($data['email'], FILTER_VALIDATE_EMAIL) : null;
        $address = isset($data['address']) ? trim(strip_tags($data['address'])) : null;
    
        if (empty($description) && empty($email) && empty($address)) 
        {
            return ["success" => false, "message" => "Au moins un champ doit être rempli."];
        }

        if (!empty($mobile) && !preg_match('/^\+?[0-9]*$/', $mobile)) 
        {
            return ["success" => false, "message" => "Format du numéro de téléphone mobile invalide."];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
        {
            return ["success" => false, "message" => "Email invalide."];
        }

        try 
        {
            $request = "INSERT INTO information_contact (mobile, email, address) VALUES (?, ?, ?)";
            $pdo = $this->db->prepare($request);
            $pdo->execute([$mobile, $email, $address]);
    
            return ["success" => true, "message" => "Information de contact ajoutée avec succès!"];
    
        } 
        catch (\PDOException $e) 
        {
            return ["success" => false, "message" => "Database error: " . $e->getMessage()];
        }
    }
}