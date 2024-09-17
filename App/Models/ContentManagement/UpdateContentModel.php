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
        $id = isset($data['id']) ? intval($data['id']) : null;

        if (empty($content) || empty($section) || empty($status) || empty($id)) {
            return ["success" => false, "message" => "Tous les champs doivent être remplis."];
        }

        try {
            $request = "UPDATE content SET content = ?, section_id = ?, status_id = ? WHERE id = ?";
            $pdo = $this->db->prepare($request);
            $pdo->execute([$content, $section, $status, $id]);

            return ["success" => true, "message" => "Contenu mis à jour avec succès"];
        } catch (\PDOException $e) {
            return ["success" => false, "message" => "Erreur de base de données: " . $e->getMessage()];
        }
    }

    public function getContentById($id)
    {
        try {
            $request = "SELECT * FROM content WHERE id = ?";
            $pdo = $this->db->prepare($request);
            $pdo->execute([$id]);
            $content = $pdo->fetch(\PDO::FETCH_ASSOC);

            return ["success" => true, "content" => $content];

        } catch (\PDOException $e) {
            error_log("Erreur lors de la récupération du contenu: " . $e->getMessage());
            return ["success" => false, "message" => "Erreur de base de données: " . $e->getMessage()];
        }
    }
}
