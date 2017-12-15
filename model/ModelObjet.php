<?php

require_once File::build_path(array('model','Model.php'));

class ModelObjet{
	
	private $idObjet;
	private $nomObjet;
	private $image;
	private $marque;
	private $description;
	private $idCategorie;

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
	
	public function __construct($idObjet = NULL, $nomObjet = NULL, $image = NULL, $marque = NULL, $description = NULL, $idCategorie = NULL) {
		if (!is_null($idObjet)){
			$this->idObjet = $idObjet;
		}
		if (!is_null($nomObjet) && !is_null($image) && !is_null($idCategorie)){
			$this->nomObjet =$nomObjet;
			$this->image=$image;
			$this->marque=$marque;
			$this->description=$description;
			$this->idCategorie=$idCategorie;
		}
	}
		public function save (){
		try {
			$statement = "INSERT INTO objet (nomObjet,image,marque,description,idCategorie)
					VALUES (:tag_nomObjet,:tag_image,:tag_marque,:tag_description,:tag_idCategorie)";
			$req_prep = Model::$pdo->prepare($statement);
			$values = array(
				"tag_nomObjet"=>$this->nomObjet,
				"tag_image"=>$this->image,
				"tag_marque"=>$this->marque,
				"tag_description"=>$this->description,
				"tag_idCategorie"=>$this->idCategorie
				);
			$req_prep->execute($values);
			$bdd = new Model();
			$this->set('idObjet', $bdd::$pdo->lastInsertId());
		} catch (Exception $ex) {
            echo $ex->getMessage(); 
            die();
        }
	}
	
	public static function getProduitOffre(){
		$sql = "SELECT Ob.nomObjet,C.nomCategorie,Of.idUser,U.niveau,U.login,Ob.image, Ob.idObjet FROM objet Ob JOIN offre Of ON Of.idObjet=Ob.idObjet JOIN categorie C ON C.idCategorie=Ob.idCategorie JOIN utilisateur U ON Of.idUser=U.idUser WHERE Of.isDisponible=1 AND Of.isAccept=1";
        $bdd = new Model();
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute();
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
	}
	
	public static function getProduitDerniereOffre(){
		$sql = "SELECT Ob.nomObjet,C.nomCategorie,Of.idUser,U.niveau,U.login,Ob.image,Ob.idObjet,Of.idOffre FROM objet Ob JOIN offre Of ON Of.idObjet=Ob.idObjet JOIN categorie C ON C.idCategorie=Ob.idCategorie JOIN utilisateur U ON Of.idUser=U.idUser WHERE Of.isDisponible=1 AND Of.isAccept=1 ORDER BY Of.idOffre DESC";
        $bdd = new Model();
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute();
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
	}
	
	public static function getProduitDemande(){
		$sql = "SELECT Ob.nomObjet,C.nomCategorie,D.idUser,U.niveau,U.login,Ob.image,Ob.idObjet FROM objet Ob JOIN demande D ON D.idObjet=Ob.idObjet JOIN categorie C ON C.idCategorie=Ob.idCategorie JOIN utilisateur U ON D.idUser=U.idUser WHERE D.isRendu=1 AND D.isAccept=1";
        $bdd = new Model();
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute();
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
	}
	
	public static function getProduitDerniereDemande(){
		$sql = "SELECT Ob.nomObjet,C.nomCategorie,D.idUser,U.niveau,U.login,Ob.image,Ob.idObjet,D.idDemande FROM objet Ob JOIN demande D ON D.idObjet=Ob.idObjet JOIN categorie C ON C.idCategorie=Ob.idCategorie JOIN utilisateur U ON D.idUser=U.idUser WHERE D.isRendu=1 AND D.isAccept=1 ORDER BY D.idDemande DESC";
        $bdd = new Model();
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute();
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
	}
	
	public static function getObjetOById($idObjet){
		$sql = "SELECT Ob.idObjet,Ob.nomObjet,C.nomCategorie,Of.idUser,Ob.description,Ob.marque,Of.isDisponible,Of.isOnOffre,Of.date_debut,Of.date_fin,Ob.image,Of.notation,U.login,Q.nomQuartier AS quartier FROM objet Ob JOIN offre Of ON Ob.idObjet=Of.idObjet JOIN categorie C ON Ob.idCategorie=C.idCategorie JOIN utilisateur U ON U.idUser=Of.idUser JOIN quartier Q ON Q.idQuartier=U.idQuartier WHERE Ob.idObjet=:tag_idObjet";	
        $bdd = new Model();
		$values=array(
			":tag_idObjet"=>$idObjet
		);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
		$produit=$req_prep->fetchAll(PDO::FETCH_OBJ);
		return $produit;
	}
	
		
	public static function getObjetById($idObjet){
		$sql = "SELECT Ob.idObjet,Ob.nomObjet,C.nomCategorie,D.idUser,Ob.description,Ob.marque,D.isOnDemand,D.isRendu,D.date_debut,D.date_fin,Ob.image,D.notation,U.login,Q.nomQuartier AS quartier FROM objet Ob JOIN demande D ON Ob.idObjet=D.idObjet JOIN categorie C ON Ob.idCategorie=C.idCategorie JOIN utilisateur U ON U.idUser=D.idUser JOIN quartier Q ON Q.idQuartier=U.idQuartier WHERE Ob.idObjet=:tag_idObjet";	
        $bdd = new Model();
		$values=array(
			":tag_idObjet"=>$idObjet
		);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
		$produit=$req_prep->fetchAll(PDO::FETCH_OBJ);
		return $produit;
	}

	
	public static function getObjetByIdd($idObjet){
		$sql= "SELECT * FROM objet WHERE idObjet=:tag_id";
		$bdd = new Model();
		$req_prep = $bdd::$pdo->prepare($sql);
		$values = array("tag_id" => $idObjet);
		$req_prep->execute($values);
		$req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelObjet');
		$tab_Objet = $req_prep->fetchAll();
		if (empty($tab_Objet)){
				 return false;
			 }
		else{
			return $tab_Objet[0];
		}
	}
	
	public static function getProduitDemandeOneCategorie($idCategorie){
		$sql = "SELECT Ob.nomObjet,C.nomCategorie,D.idUser,U.niveau,Ob.image,Ob.idObjet FROM objet Ob JOIN demande D ON D.idObjet=Ob.idObjet JOIN categorie C ON C.idCategorie=Ob.idCategorie JOIN utilisateur U ON D.idUser=U.idUser WHERE D.isRendu=1 AND D.isAccept=1 AND Ob.idCategorie=:tag_idCategorie";
		$bdd = new Model();
		$values=array(
			":tag_idCategorie"=>$idCategorie
		);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
		$produit=$req_prep->fetchAll(PDO::FETCH_OBJ);
		return $produit;
	}
	
	public static function getProduitOffreOneCategorie($idCategorie){
		$sql = "SELECT Ob.nomObjet,C.nomCategorie,Of.idUser,U.niveau,Ob.image, Ob.idObjet FROM objet Ob JOIN offre Of ON Of.idObjet=Ob.idObjet JOIN categorie C ON C.idCategorie=Ob.idCategorie JOIN utilisateur U ON Of.idUser=U.idUser WHERE Of.isDisponible=1 AND Of.isAccept=1 AND Ob.idCategorie=:tag_idCategorie";
		$bdd = new Model();
		$values=array(
			":tag_idCategorie"=>$idCategorie
		);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
		$produit=$req_prep->fetchAll(PDO::FETCH_OBJ);
		return $produit;		
	}
	
	public static function modifD($nom,$marque,$idCategorie,$id){
		$sql="UPDATE objet SET nomObjet=:tag_nom,marque=:tag_marque,idCategorie=:tag_idCategorie WHERE idObjet=:tag_id";
		$req_prep = Model::$pdo->prepare($sql);
		$values=array("tag_id"=>$id,
		"tag_nom"=>$nom,
		"tag_marque"=>$marque,
		"tag_idCategorie"=>$idCategorie);
		$req_prep->execute($values);
	}
	
	public static function deleteD($id){
		$sql="DELETE FROM objet WHERE idObjet=:tag_id";
		$req_prep = Model::$pdo->prepare($sql);
		$values=array("tag_id"=>$id);
		$req_prep->execute($values);
		
	}
	
	public static function modifO($nom,$marque,$description,$image,$idCategorie,$id){
		$sql="UPDATE objet SET nomObjet=:tag_nom,marque=:tag_marque,idCategorie=:tag_idCategorie,description=:tag_description,image=:tag_image WHERE idObjet=:tag_id";
		$req_prep = Model::$pdo->prepare($sql);
		$values=array("tag_id"=>$id,
		"tag_nom"=>$nom,
		"tag_marque"=>$marque,
		"tag_idCategorie"=>$idCategorie,
		"tag_description"=>$description,
		"tag_image"=>$image);
		$req_prep->execute($values);
	}
	
	public static function getInfoObjet($idObjet){
		$sql="SELECT * FROM objet WHERE idObjet=:tag_id";
		$req_prep = Model::$pdo->prepare($sql);
		$values=array("tag_id"=>$idObjet);
		$req_prep->execute($values);
		$req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelObjet');
		$tab_Objet = $req_prep->fetchAll();
		if (empty($tab_Objet)){
				 return false;
			 }
		else{
			return $tab_Objet[0];
		}
	}
	
	public function deleteDD(){
		$sql="DELETE FROM objet WHERE idObjet=:tag_id";
		$req_prep = Model::$pdo->prepare($sql);
		$values=array("tag_id"=>$this->idObjet);
		$req_prep->execute($values);
		
	}
	
	public static function getObjetByOffre($idOffre){
		$sql="SELECT * FROM offre Of JOIN objet O ON O.idObjet=Of.idObjet WHERE idOffre=:tag_offre";
		$req_prep = Model::$pdo->prepare($sql);
		$values=array("tag_id"=>$idOffre);
		$req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelObjet');
		$tab_Objet = $req_prep->fetchAll();
		if (empty($tab_Objet)){
				 return false;
			 }
		else{
			return $tab_Objet[0];
		}
	}
	
	public static function modifOR($description,$idObjet){
		$sql="UPDATE objet SET description=:tag_description WHERE idObjet=:tag_id";
		$req_prep = Model::$pdo->prepare($sql);
		$values=array("tag_id"=>$idObjet,
		"tag_description"=>$description);
		$req_prep->execute($values);	
	}
}