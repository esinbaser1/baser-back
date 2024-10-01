<?php

namespace Models\ImageManagement;

use App\Database;

class DisplayImageModel
{
  protected $db;

  public function __construct()
  {
    $database = new Database();
    $this->db = $database->getConnection();
  }

  public function getImage()
  {
    try 
    {
      $request = "SELECT image.*, section.name AS section_name FROM image JOIN section ON image.section_id = section.id";

      $pdo = $this->db->query($request);
      $image = $pdo->fetchAll(\PDO::FETCH_ASSOC);

      return ["success" => true, "image" => $image];
    } 
    catch (\PDOException $e) 
    {
      return ["success" => false, "message" => "Erreur de base de données"];
    }
  }
}
