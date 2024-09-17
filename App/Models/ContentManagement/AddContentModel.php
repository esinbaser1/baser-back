<?php

namespace Models\ContentManagement;

use App\Database;

class AddContentModel
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function addContent()
    {
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);
    
        $content = isset($data['content']) ? trim(strip_tags($data['content'])) : null;
        $section = isset($data['section_id']) ? intval($data['section_id']) : null;
        $status = isset($data['status_id']) ? intval($data['status_id']) : null;
    
        if (empty($content) || empty($section) || empty($status)) {
            return ["success" => false, "message" => "Veuillez compléter tous les champs."];
        }
    
        try 
        {
            $request = "INSERT INTO content (content, section_id, status_id) VALUES (?, ?, ?)";
            $pdo = $this->db->prepare($request);
            $pdo->execute([$content, $section, $status]);
    
            $contentId = $this->db->lastInsertId();
            
            $newContent = [
                'id' => $contentId,
                'content' => $content,
                'section_id' => $section,
                'status_id' => $status
            ];
    
            return ["success" => true, "message" => "Contenu ajouté avec succès!", "content" => $newContent];
    
        } 
        catch (\PDOException $e) 
        {
            error_log("Error when creating content: " . $e->getMessage());
            return ["success" => false, "message" => "Database error: " . $e->getMessage()];
        }
    }
    
}

