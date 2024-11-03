<?php

namespace Controllers\ContactManagement;

use Models\ContactManagement\ReplyContactModel;

class ReplyContactController 
{
    protected $model;

    public function __construct()
    {
        $this->model = new ReplyContactModel();
    }

    public function replyContact()
    {
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        if (isset($data['contactId']) && isset($data['replyMessage'])) 
        {
            $contactId = intval($data['contactId']);
            $replyMessage = trim(strip_tags($data['replyMessage']));

            if (empty($replyMessage)) 
            {
                return ["success" => false, "message" => "Le message de réponse ne peut pas être vide."];
            }

            try 
            {
                $this->model->sendReply($contactId, $replyMessage);
                return ["success" => true, "message" => "Réponse envoyée avec succès."];
            } 
            catch (\Exception $e) 
            {
                return ["success" => false, "message" => $e->getMessage()];
            }
        }
        else 
        {
            return ["success" => false, "message" => "Paramètres manquants."];
        }
    }
}
