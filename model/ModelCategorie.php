<?php

require_once File::build_path(array('model','Model.php'));

class ModelCategorie{
	
	private $idCategorie;
	private $nomCategorie;
	private $image;
	
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
	
	public function __construct($idCategorie = NULL, $nomCategorie= NULL, $image=NULL) {
		if (!is_null($idCategorie)){
			$this->idCategorie = $idCategorie;
		}
		if (!is_null($nomCategorie) && !is_null($image)){
			$this->nomCategorie = $nomCategorie;
			$this->image=$image;
		}
	}
	
	
	public function save (){
		try {
			require_once File::build_path(array('model','Model.php'));
			$statement = "INSERT INTO categorie (nomCategorie,image)
					VALUES (:tag_nomC,:tag_image)";
			$bdd=new Model();
			$req_prep = Model::$pdo->prepare($statement);
			$values = array(
				"tag_nomC"=>$this->nomCategorie,
				"tag_image"=>$this->image
				);
			$req_prep->execute($values);
			$this->set('idCategorie', $bdd::$pdo->lastInsertId());
		} catch (Exception $ex) {
            echo $ex->getMessage(); 
            die();
        }
	}
	
	public static function getAllCategorie(){
		require_once File::build_path(array('model','Model.php'));
		$sql="SELECT idCategorie,nomCategorie FROM categorie ORDER BY nomCategorie ASC";
		$bdd = new Model();
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute();
        $tab_categorie = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_categorie;	
	}
	
	public static function getCategorieById($id){
		$sql= "SELECT * FROM categorie WHERE idCategorie=:tag_id";
		$bdd = new Model();
		$req_prep = $bdd::$pdo->prepare($sql);
		$values = array("tag_id" => $id);
		$req_prep->execute($values);
		$req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelCategorie');
		$tab_categorie = $req_prep->fetchAll();
		if (empty($tab_categorie)){
				 return false;
			 }
		else{
			return $tab_categorie[0];
		}
	}
	
	public static function getCategorieByIdO($id){
		$sql= "SELECT * FROM categorie C JOIN objet O ON O.idCategorie=C.idCategorie WHERE O.idObjet=:tag_id";
		$bdd = new Model();
		$req_prep = $bdd::$pdo->prepare($sql);
		$values = array("tag_id" => $id);
		$req_prep->execute($values);
		$req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelCategorie');
		$tab_categorie = $req_prep->fetchAll();
		if (empty($tab_categorie)){
				 return false;
			 }
		else{
			return $tab_categorie[0];
		}		
	}
	
	public static function getCategories(){
		require_once File::build_path(array('model','Model.php'));
		$sql="SELECT nomCategorie,idCategorie FROM categorie";
		$bdd = new Model();
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute();
        $tab_categorie = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_categorie;	
	}

	public static function getObjetByCategorie($idCategorie){
		$sql="SELECT * FROM objet O JOIN Categorie C ON O.idCategorie=C.idCategorie WHERE O.idCategorie=:tag_id";
		$bdd = new Model();
		$req_prep = $bdd::$pdo->prepare($sql);
		$values = array("tag_id" => $idCategorie);
		$req_prep->execute($values);
		$req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelObjet');
        $tab_categorie = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_categorie;		
	}
	
	public function deleted(){
		$sql="DELETE FROM categorie WHERE idCategorie=:tag_categorie";
		$req_prep = Model::$pdo->prepare($sql);
		$values=array("tag_categorie"=>$this->idCategorie);
		$req_prep->execute($values);	
	}
}	