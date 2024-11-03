<?php

namespace Models\ContactManagement;

use App\Database;

class AddContactModel
{
  protected $db;

  public function __construct()
  {
    $database = new Database();
    $this->db = $database->getConnection();
  }

  public function addContact($firstname, $lastname, $email, $mobile, $city, $message, $typeOfProject, $consent)
  {
    $status = 1; // Statut par défaut (1 = "Non lu")

    try {
      $request = "INSERT INTO contact (firstname, lastname, email, mobile, city, message, type_of_project_id, status_id, consent) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
      $pdo = $this->db->prepare($request);
      $pdo->execute([$firstname, $lastname, $email, $mobile, $city, $message, $typeOfProject, $status, $consent]);

      return true;
    } catch (\PDOException $e) {
      return ["success" => false, "message" => "Database error: " . $e->getMessage()];
    }
  }
}
