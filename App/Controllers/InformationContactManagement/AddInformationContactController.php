<?php

namespace Controllers\InformationContactManagement;

use Models\InformationContactManagement\AddInformationContactModel;

class AddInformationContactController
{
    protected $model;

    public function __construct()
    {
        $this->model = new AddInformationContactModel();
    }

    public function addInformationContact()
    {
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        $mobile = isset($data['mobile']) ? trim(strip_tags($data['mobile'])) : null;
        $email = isset($data['email']) ? trim($data['email']) : null;
        $address = isset($data['address']) ? trim(strip_tags($data['address'])) : null;
    
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

        return $this->model->addInformationContact($mobile, $email, $address);
    }
}