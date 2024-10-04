<?php

namespace Controllers\ContactManagement;

use Models\ContactManagement\AddContactModel;

class AddContactController
{
    protected $model;

    public function __construct()
    {
        $this->model = new AddContactModel();
    }

    public function addContact()
    {
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        $firstname = isset($data['firstname']) ? trim(strip_tags($data['firstname'])) : null;
        $lastname = isset($data['lastname']) ? trim(strip_tags($data['lastname'])) : null;
        $email = isset($data['email']) ? filter_var($data['email'], FILTER_VALIDATE_EMAIL) : null;
        $mobile = isset($data['mobile']) ? trim(strip_tags($data['mobile'])) : null;
        $city = isset($data['city']) ? trim(strip_tags($data['city'])) : null;
        $message = isset($data['message']) ? trim(strip_tags($data['message'])) : null;
        $typeOfProject = isset($data['type_of_project_id']) ? trim(strip_tags($data['type_of_project_id'])) : null;

        if (empty($firstname) || empty($lastname) || empty($email) || empty($mobile) || empty($city) || empty($typeOfProject)) 
        {
            return ["success" => false, "message" => "Veuillez compléter tous les champs obligatoires."];
        }

        if (!preg_match('/^\+?[0-9]*$/', $mobile)) 
        {
            return ["success" => false, "message" => "Format du numéro de téléphone mobile invalide."];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
        {
            return ["success" => false, "message" => "Email invalide."];
        }

        return $this->model->addContact($firstname, $lastname, $email, $mobile, $city, $message, $typeOfProject);
    }
}