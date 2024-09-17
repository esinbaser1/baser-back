<?php

namespace Models\ContentManagement;

use App\Database;

class DisplayContentModel
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getContent()
    {
        try {
            $request = "SELECT content.*, status_content.name AS status_name, section.name AS section_name FROM content JOIN status_content ON content.status_id = status_content.id JOIN section ON content.section_id = section.id";

            $pdo = $this->db->query($request);
            $content = $pdo->fetchAll(\PDO::FETCH_ASSOC);

            return ["success" => true, "content" => $content];
        } catch (\PDOException $e) {
            error_log("Erreur lors de la récupération des données: " . $e->getMessage());
            return ["success" => false, "message" => "Erreur de base de données"];
        }
    }
}
