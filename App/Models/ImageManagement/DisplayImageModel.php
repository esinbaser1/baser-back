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
      $request = "SELECT image.*, section_image.name AS section_name, section_image.slug AS section_slug 
            FROM image 
            JOIN section_image ON image.section_id = section_image.id";


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
