<?php
namespace Models\SocialNetworkManagement;

use App\Database;

class DeleteSocialNetworkModel
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function deleteSocialNetwork()
    {
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        $id = $data['id'] ?? null;
    
        if (empty($id)) 
        {
            return ["success" => false, "message" => "Id manquant."];
        }
    
        try 
        {
            $request = "DELETE FROM social_network WHERE id = ?";
            $pdo = $this->db->prepare($request);
            $pdo->execute([$id]);
    
            if ($pdo->rowCount() > 0) 
            {
                return ["success" => true, "message" => "Réseau social supprimé avec succès."];
            } 
            else 
            {
                return ["success" => false, "message" => "Réseau social introuvable."];
            }
        } 
        catch (\PDOException $e) 
        {
            return ["success" => false, "message" => "Erreur de base de données"];
        }
    }
}