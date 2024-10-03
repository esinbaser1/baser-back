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

    public function updateInformationContact()
    {
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        $mobile = isset($data['mobile']) ? trim(strip_tags($data['mobile'])) : null;
        $email = isset($data['email']) ? trim(strip_tags($data['email'])) : null;
        $address = isset($data['address']) ? trim(strip_tags($data['address'])) : null;
        $id = isset($data['idInformation']) ? intval($data['idInformation']) : null;

        // Récupérer l'information de contact existante
        $existingInformationResult = $this->getInformationContactById($id);

        if (!$existingInformationResult['success']) 
        {
            return $existingInformationResult;  
        }

        $existingContent = $existingInformationResult['information'];

        // Comparer les données existantes avec celles fournies
        if (
            $mobile === $existingContent['mobile'] &&
            $email === $existingContent['email'] &&
            $address === $existingContent['address']
        ) 
        {
            return ["success" => false, "message" => "Aucun changement détecté."];
        }

        // Validation du mobile et email
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
            // Mise à jour des données si nécessaire
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

            if ($information) {
                return ["success" => true, "information" => $information];
            } else {
                return ["success" => false, "message" => "Information non trouvée."];
            }
        } 
        catch (\PDOException $e) 
        {
            error_log("Erreur lors de la récupération du contenu: " . $e->getMessage());
            return ["success" => false, "message" => "Erreur de base de données: " . $e->getMessage()];
        }
    }
}
