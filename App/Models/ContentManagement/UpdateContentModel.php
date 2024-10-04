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

    // Le modèle attend désormais des données validées depuis le contrôleur
    public function updateContent($id, $content, $section, $status)
    {
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

            return ["success" => true, "content" => $content];
        } 
        catch (\PDOException $e) 
        {
            error_log("Erreur lors de la récupération du contenu: " . $e->getMessage());
            return ["success" => false, "message" => "Erreur de base de données: " . $e->getMessage()];
        }
    }
}
