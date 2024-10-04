<?php

namespace Models\ContactManagement;

use App\Database;

class DisplayContactModel 
{
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getContact()
    {
        try {
            $request = "SELECT contact.*, type_of_project.name AS project_name, status_contact.name AS status_name 
                        FROM contact 
                        JOIN type_of_project ON contact.type_of_project_id = type_of_project.id 
                        JOIN status_contact ON contact.status_id = status_contact.id 
                        WHERE contact.is_archived = 0";
            $pdo = $this->db->query($request);
            $contact = $pdo->fetchAll(\PDO::FETCH_ASSOC);
    
            return ["success" => true, "contact" => $contact];
        } catch (\PDOException) {
            return ["success" => false, "message" => "Erreur de base de données"];
        }
    }
    
}