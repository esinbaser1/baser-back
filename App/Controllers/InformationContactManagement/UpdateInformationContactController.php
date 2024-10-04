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
        $email = isset($data['email']) ? filter_var($data['email'], FILTER_VALIDATE_EMAIL) : null;
        $address = isset($data['address']) ? trim(strip_tags($data['address'])) : null;
        $id = isset($data['idInformation']) ? intval($data['idInformation']) : null;

        if (empty($mobile) && empty($email) && empty($address)) 
        {
            return ["success" => false, "message" => "Au moins un champ doit être rempli."];
        }

        if (!empty($mobile) && !preg_match('/^\+?[0-9]*$/', $mobile)) 
        {
            return ["success" => false, "message" => "Format du numéro de téléphone mobile invalide."];
        }

        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) 
        {
            return ["success" => false, "message" => "Email invalide."];
        }

        if (empty($id)) 
        {
            return ["success" => false, "message" => "ID de l'information de contact manquant."];
        }

        return $this->model->updateInformationContact($mobile, $email, $address, $id);
    }

    public function getInformationContactById($id)
    {
        if (empty($id)) {
            return ["success" => false, "message" => "ID non fourni"];
        }
        return $this->model->getInformationContactById($id);
    }
}