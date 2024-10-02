<?php

namespace Models\SocialNetworkManagement;

use App\Database;

class DisplaySocialNetworkModel
{
	protected $db;

	public function __construct()
	{
		$database = new Database();
		$this->db = $database->getConnection();
	}

	public function getSocialNetwork()
	{
		try {
			$request = "SELECT * from social_network";
			$pdo = $this->db->query($request);
			$socialNetwork = $pdo->fetchAll(\PDO::FETCH_ASSOC);

			return ["success" => true, "socialNetwork" => $socialNetwork];
		} catch (\PDOException $e) {
			return ["success" => false, "message" => "Erreur de base de données"];
		}
	}
}