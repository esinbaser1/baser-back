<?php
namespace Models\ContentManagement;

use App\Database;

class UpdateContentModel
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function updateContent()
    {
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        $content = isset($data['content']) ? trim(strip_tags($data['content'])) : null;
        $section = isset($data['section_id']) ? intval($data['section_id']) : null;
        $status = isset($data['status_id']) ? intval($data['status_id']) : null;
        $id = isset($data['idContent']) ? intval($data['idContent']) : null;

        if (empty($content) || empty($section) || empty($status) || empty($id)) 
        {
            return ["success" => false, "message" => "Tous les champs doivent être remplis."];
        }

        // Récupérer l'ancien contenu pour vérifier s'il y a un changement
        $existingContentResult = $this->getContentById($id);

        if (!$existingContentResult['success']) 
        {
            return $existingContentResult;  // Si une erreur survient lors de la récupération du contenu
        }

        $existingContent = $existingContentResult['content'];

        // Comparer les données existantes avec celles fournies
        if (
            $content === $existingContent['content'] &&
            $section === intval($existingContent['section_id']) &&
            $status === intval($existingContent['status_id'])
        ) 
        {
            return ["success" => false, "message" => "Aucun changement détecté."];
        }

        try 
        {
            // Mise à jour du contenu seulement si un changement a été détecté
            $request = "UPDATE content SET content = ?, section_id = ?, status_id = ? WHERE id = ?";
            $pdo = $this->db->prepare($request);
            $pdo->execute([$content, $section, $status, $id]);

            return ["success" => true, "message" => "Contenu mis à jour avec succès!"];
        } 
        catch (\PDOException $e) 
        {
            return ["success" => false, "message" => "Erreur de base de données: " . $e->getMessage()];
        }
    }

    // Méthode pour récupérer le contenu existant par ID
    public function getContentById($id)
    {
        try 
        {
            $request = "SELECT * FROM content WHERE id = ?";
            $pdo = $this->db->prepare($request);
            $pdo->execute([$id]);
            $content = $pdo->fetch(\PDO::FETCH_ASSOC);

            return ["success" => true, "contents" => $content];
        } 
        catch (\PDOException $e) 
        {
            error_log("Erreur lors de la récupération du contenu: " . $e->getMessage());
            return ["success" => false, "message" => "Erreur de base de données: " . $e->getMessage()];
        }
    }
}