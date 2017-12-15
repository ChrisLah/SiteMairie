<?php

require_once File::build_path(array("model", "Model.php"));

class ModelQuartier {
	
	private $idQuartier;
	private $nomQuartier;
	
		//getter
	public function get($nom_attribut) {
		if (property_exists($this, $nom_attribut))
			return $this->$nom_attribut;
		return false;
	}
		
	 //setter
	public function set($nom_attribut, $valeur) {
		if (property_exists($this, $nom_attribut))
			$this->$nom_attribut = $valeur;
		return false;
	}
	
	public function __construct($idQuartier = NULL, $nomQuartier = NULL) {
		if (!is_null($idQuartier)){
			$this->idQuartier = $idQuartier;
		}
		if (!is_null($nomQuartier)){
			$this->nomQuartier = $nomQuartier;

		}
	}
	
	public function save (){
		try {
			$statement = "INSERT INTO quartier (nomQuartier)
					VALUES (:tag_quartier)";
			$req_prep = Model::$pdo->prepare($statement);
			$values = array(
				"tag_quartier"=> $this->nomQuartier
				);
			$req_prep->execute($values);
			$bdd = new Model();
			$this->set('idQuartier', $bdd::$pdo->lastInsertId());
		} catch (Exception $ex) {
            echo $ex->getMessage(); 
            die();
        }
	}
	
	public static function getQuartierUser($idQuartier){
		$sql= "SELECT * FROM quartier WHERE idQuartier=:tag_quartier";
		$bdd = new Model();
		$req_prep = $bdd::$pdo->prepare($sql);
		$values = array("tag_quartier" => $idQuartier);
		$req_prep->execute($values);
		$req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelQuartier');
		$tab_quartier = $req_prep->fetchAll();
		if (empty($tab_quartier)){
				 return false;
			 }
		else{
			return $tab_quartier[0];
		}
	}
	
	public static function getAllQuartier(){
		$sql= "SELECT * FROM quartier";
		$bdd = new Model();
		$req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute();
		$tab_quartier = $req_prep->fetchAll(PDO::FETCH_OBJ);
		if (empty($tab_quartier)){
				 return false;
			 }
		else{
			return $tab_quartier;
		}
	}
}