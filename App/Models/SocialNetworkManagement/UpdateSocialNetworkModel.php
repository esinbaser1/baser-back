<?php

namespace Models\SocialNetworkManagement;

use App\Database;

class UpdateSocialNetworkModel
{
  protected $db;

  public function __construct()
  {
    $database = new Database();
    $this->db = $database->getConnection();
  }

  public function updateSocialNetwork()
  {
      $input = file_get_contents("php://input");
      $data = json_decode($input, true);
  
      $platform = isset($data['platform']) ? trim(strip_tags($data['platform'])) : null;
      $url = isset($data['url']) ? trim(strip_tags($data['url'])) : null;
      $id = isset($data['idSocialNetwork']) ? intval($data['idSocialNetwork']) : null;
  
      // Récupérer les informations du réseau social existant
      $existingSocialNetworkResult = $this->getSocialNetworkById($id);
  
      if (!$existingSocialNetworkResult['success']) {
          return $existingSocialNetworkResult;
      }
  
      $existingSocialNetwork = $existingSocialNetworkResult['socialNetwork'];
  
      // Comparer les nouvelles données avec celles existantes
      if (
        $platform === $existingSocialNetwork['platform'] &&
        $url === $existingSocialNetwork['url']
      ) {
        return ["success" => false, "message" => "Aucun changement détecté."];
      }
  
      if ($this->existsInColumn('platform', $platform, $id)) {
        return ["success" => false, "message" => "Ce nom de plateforme est déjà utilisé."];
    }

    // Vérifier si l'URL existe déjà pour un autre ID
    if ($this->existsInColumn('url', $url, $id)) {
        return ["success" => false, "message" => "Cette URL est déjà utilisée."];
    }
  
      // Mise à jour des informations dans la base de données
      try {
        $request = "UPDATE social_network SET platform = ?, url = ? WHERE id = ?";
        $pdo = $this->db->prepare($request);
        $pdo->execute([$platform, $url, $id]);
  
        return ["success" => true, "message" => "Réseau social mis à jour avec succès!"];
      } 
      catch (\PDOException $e) {
        return ["success" => false, "message" => "Erreur de base de données: " . $e->getMessage()];
      }
  }
  

  // Méthode pour récupérer le contenu existant par ID
  public function getSocialNetworkById($id)
  {
    try {
      $request = "SELECT * FROM social_network WHERE id = ?";
      $pdo = $this->db->prepare($request);
      $pdo->execute([$id]);
      $socialNetwork = $pdo->fetch(\PDO::FETCH_ASSOC);

      return ["success" => true, "socialNetwork" => $socialNetwork];
    } catch (\PDOException $e) {
      return ["success" => false, "message" => "Erreur de base de données: " . $e->getMessage()];
    }
  }

  private function existsInColumn($column, $value, $id = null)
  {
      $query = "SELECT COUNT(*) FROM social_network WHERE $column = ? AND id != ?";
      $pdo = $this->db->prepare($query);
      $pdo->execute([$value, $id]);
      return $pdo->fetchColumn() > 0;
  }
}