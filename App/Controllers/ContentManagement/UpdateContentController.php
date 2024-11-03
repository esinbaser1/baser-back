<?php

namespace Controllers\ContentManagement;

use Models\ContentManagement\UpdateContentModel;

class UpdateContentController
{
    protected $model;

    public function __construct()
    {
        $this->model = new UpdateContentModel();
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

        try 
        {
            $existingContent = $this->model->getContentById($id);

            if (!$existingContent) 
            {
                return ["success" => false, "message" => "Contenu introuvable."];
            }

            if (
                $content === $existingContent['content'] &&
                $section === intval($existingContent['section_id']) &&
                $status === intval($existingContent['status_id'])
            ) 
            {
                return ["success" => false, "message" => "Aucun changement détecté."];
            }

            $updateResult = $this->model->updateContent($id, $content, $section, $status);

            if ($updateResult) 
            {
                return ["success" => true, "message" => "Contenu mis à jour avec succès!"];
            } 
            else 
            {
                return ["success" => false, "message" => "Échec de la mise à jour du contenu."];
            }
        } 
        catch (\Exception $e) 
        {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }

    public function getContentById($id)
    {
        if (empty($id)) 
        {
            return ["success" => false, "message" => "ID non fourni"];
        }

        try 
        {
            $content = $this->model->getContentById($id);
            if ($content) 
            {
                return ["success" => true, "content" => $content];
            } 
            else 
            {
                return ["success" => false, "message" => "Contenu introuvable."];
            }
        } 
        catch (\Exception $e) 
        {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }
}