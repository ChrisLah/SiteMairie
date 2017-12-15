<?php

require_once File::build_path(array("model", "Model.php"));

class ModelPreEchange {
	
	private $idOffre;
	private $idDemande;
	private $idEmprunteur;
	private $idPreteur;

	
		
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
	  // un constructeur
	public function __construct($idOffre = NULL, $idDemande = NULL, $idPreteur = NULL, $idEmprunteur = NULL) {
		if (!is_null($idEmprunteur) && !is_null($idPreteur)){
			$this->idOffre=$idOffre;
			$this->idDemande=$idDemande;			
			$this->idEmprunteur=$idEmprunteur;
			$this->idPreteur=$idPreteur;
		}
	}
	
	public function save (){
		try {
			require_once File::build_path(array('model','Model.php'));
			$statement = "INSERT INTO preechange (idOffre, idDemande, idPreteur, idEmprunteur)
					VALUES (:tag_idoffre, :tag_iddemande, :tag_preteur, :tag_emprunt)";
			$req_prep = Model::$pdo->prepare($statement);
			$values = array(
				"tag_emprunt"=>$this->idEmprunteur,
				"tag_preteur"=>$this->idPreteur,
				"tag_idoffre"=>$this->idOffre,
				"tag_iddemande"=>$this->idDemande
				);
			$req_prep->execute($values);
		} catch (Exception $ex) {
            echo $ex->getMessage(); 
            die();
        }
	}
	
	public function deleteO(){
		$sql="DELETE FROM preechange WHERE idOffre=:tag_idoffre AND idPreteur=:tag_preteur AND idEmprunteur=:tag_emprunt";
		$req_prep = Model::$pdo->prepare($sql);
		$values=array("tag_idoffre"=>$this->idOffre, "tag_preteur"=>$this->idPreteur,"tag_emprunt"=>$this->idEmprunteur);
		$req_prep->execute($values);
	}
	
	public static function getPreEchangeByIdO($idOffre,$idPreteur,$idEmprunteur){
		$sql="SELECT * FROM preechange WHERE idOffre=:tag_idoffre AND idPreteur=:tag_preteur AND idEmprunteur=:tag_emprunt";
		$req_prep = Model::$pdo->prepare($sql);
		$values=array("tag_idoffre"=>$idOffre,"tag_preteur"=>$idPreteur,"tag_emprunt"=>$idEmprunteur);
		$req_prep->execute($values);
        $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelPreEchange');
        $PreEchange = $req_prep->fetchAll();
		if (empty($PreEchange)){
            return false;
        }
        else{
            return $PreEchange[0];
        }
	}
	
	public function deleteD(){
		$sql="DELETE FROM preechange WHERE idDemande=:tag_iddemande AND idPreteur=:tag_preteur AND idEmprunteur=:tag_emprunt";
		$req_prep = Model::$pdo->prepare($sql);
		$values=array("tag_iddemande"=>$this->idDemande, "tag_preteur"=>$this->idPreteur,"tag_emprunt"=>$this->idEmprunteur);
		$req_prep->execute($values);
	}
	
	public static function getPreEchangeByIdD($idDemande,$idPreteur,$idEmprunteur){
		$sql="SELECT * FROM preechange WHERE idDemande=:tag_iddemande AND idPreteur=:tag_preteur AND idEmprunteur=:tag_emprunt";
		$req_prep = Model::$pdo->prepare($sql);
		$values=array("tag_iddemande"=>$idDemande,"tag_preteur"=>$idPreteur,"tag_emprunt"=>$idEmprunteur);
		$req_prep->execute($values);
        $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelPreEchange');
        $PreEchange = $req_prep->fetchAll();
		if (empty($PreEchange)){
            return false;
        }
        else{
            return $PreEchange[0];
        }
	}
	
	public function deleteOD(){
		$sql="DELETE FROM preechange WHERE idDemande=:tag_iddemande AND idOffre=:tag_idoffre AND idPreteur=:tag_preteur AND idEmprunteur=:tag_emprunt";
		$req_prep = Model::$pdo->prepare($sql);
		$values=array("tag_iddemande"=>$this->idDemande,"tag_idoffre"=>$this->idOffre, "tag_preteur"=>$this->idPreteur,"tag_emprunt"=>$this->idEmprunteur);
		$req_prep->execute($values);
	}
	
	public static function getPreEchangeByIdOD($idOffre,$idDemande,$idPreteur,$idEmprunteur){
		$sql="SELECT * FROM preechange WHERE idDemande=:tag_iddemande AND idOffre=:tag_idoffre AND idPreteur=:tag_preteur AND idEmprunteur=:tag_emprunt";
		$req_prep = Model::$pdo->prepare($sql);
		$values=array("tag_iddemande"=>$idDemande,"tag_idoffre"=>$idOffre,"tag_preteur"=>$idPreteur,"tag_emprunt"=>$idEmprunteur);
		$req_prep->execute($values);
        $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelPreEchange');
        $PreEchange = $req_prep->fetchAll();
		if (empty($PreEchange)){
            return false;
        }
        else{
            return $PreEchange[0];
        }
	}
}