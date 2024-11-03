<?php

namespace Models\ImageManagement;

use App\Database;
use PDOException;

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
      $request = "SELECT image.*, section.name AS section_name, section.slug AS section_slug 
                  FROM image 
                  JOIN section ON image.section_id = section.id";

      $pdo = $this->db->query($request);
      return $pdo->fetchAll(\PDO::FETCH_ASSOC);
    } 
    catch (PDOException $e) 
    {
      throw new \Exception("Erreur de base de données: " . $e->getMessage());
    }
  }
}
