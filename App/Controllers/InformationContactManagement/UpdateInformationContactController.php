<?php

namespace Controllers\InformationContactManagement;

use Models\InformationContactManagement\UpdateInformationContactModel;

class UpdateInformationContactController
{
    protected $model;

    public function __construct()
    {
        $this->model = new UpdateInformationContactModel();
    }

    public function updateInformationContact()
    {
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        $mobile = isset($data['mobile']) ? trim(strip_tags($data['mobile'])) : null;
        $email = isset($data['email']) ? trim($data['email']) : null;

        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) 
        {
            return ["success" => false, "message" => "Email invalide."];
        }
        
        $address = isset($data['address']) ? trim(strip_tags($data['address'])) : null;
        $id = isset($data['idInformation']) ? intval($data['idInformation']) : null;

        if (empty($mobile) && empty($email) && empty($address)) 
        {
            return ["success" => false, "message" => "Au moins un champ doit être rempli."];
        }

        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) 
        {
            return ["success" => false, "message" => "Email invalide."];
        }

        if (!empty($mobile) && !preg_match('/^\+?[0-9]*$/', $mobile)) 
        {
            return ["success" => false, "message" => "Format du numéro de téléphone mobile invalide."];
        }

        if (empty($id)) 
        {
            return ["success" => false, "message" => "ID de l'information de contact manquant."];
        }

        try 
        {
            $updateResult = $this->model->updateInformationContact($mobile, $email, $address, $id);

            if ($updateResult) 
            {
                return ["success" => true, "message" => "Information de contact mise à jour avec succès!"];
            } 
            else 
            {
                return ["success" => false, "message" => "Aucun changement détecté."];
            }
        } 
        catch (\Exception $e) 
        {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }

    public function getInformationContactById($id)
    {
        if (empty($id)) 
        {
            return ["success" => false, "message" => "ID non fourni"];
        }

        try 
        {
            $content = $this->model->getInformationContactById($id);
            if ($content) 
            {
                return ["success" => true, "information" => $content];
            } 
            else 
            {
                return ["success" => false, "message" => "Information de contact introuvable."];
            }
        } 
        catch (\Exception $e) 
        {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }
}
