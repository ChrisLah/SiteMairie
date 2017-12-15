<?php


require_once File::build_path(array("model", "Model.php"));


class ModelOffre{
	
	private $idOffre;
	private $date_debut;
	private $date_fin;
	private $isDisponible;
	private $isAccept;
	private $idObjet;
	private $idUser;
	private $isOnOffre;
	private $isOnEchange;
	private $notation;
	
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
	
	public function __construct($idOffre = NULL, $date_debut = NULL, $date_fin = NULL,$isOnOffre = NULL, $isDisponible = NULL, $isAccept = NULL,$isOnEchange = NULL,$notation = NULL, $idUser = NULL, $idObjet = NULL) {
		if (!is_null($idOffre)){
			$this->idOffre = $idOffre;
		}
		if (!is_null($date_debut) && !is_null($isDisponible) && !is_null($isAccept) && !is_null($idUser) && !is_null($idObjet) && !is_null($isOnOffre)){
			$this->date_debut = $date_debut;
			$this->date_fin=$date_fin;
			$this->isDisponible=$isDisponible;
			$this->isAccept=$isAccept;
			$this->isOnOffre=$isOnOffre;
			$this->isOnEchange=$isOnEchange;
			$this->idUser=$idUser;
			$this->idObjet=$idObjet;
			$this->notation=$notation;
		}
	}

	public function save (){
		try {
			require_once File::build_path(array('model','Model.php'));
			$statement = "INSERT INTO offre (date_debut,date_fin,isOnOffre,isDisponible,isAccept,isOnEchange,notation, idUser,idObjet)
					VALUES (:tag_dateD,:tag_dateF,:tag_Onoffre,:tag_dispo,:tag_accept,:tag_echange,:tag_notation, :tag_User,:tag_Objet)";
			$req_prep = Model::$pdo->prepare($statement);
			$values = array(
				"tag_dateD"=>$this->date_debut,
				"tag_dateF"=>$this->date_fin,
				"tag_Onoffre"=>$this->isOnOffre,
				"tag_dispo"=>$this->isDisponible,
				"tag_accept"=>$this->isAccept,
				"tag_echange"=>$this->isOnEchange,
				"tag_User"=>$this->idUser,
				"tag_notation"=>$this->notation,
				"tag_Objet"=>$this->idObjet
				);
			$req_prep->execute($values);
			$bdd = new Model();
			$this->set('idOffre', $bdd::$pdo->lastInsertId());
		} catch (Exception $ex) {
            echo $ex->getMessage(); 
            die();
        }
	}
	
	public static function getNombreOffre(){
		$sql = "SELECT COUNT(*) AS nombre FROM objet Ob JOIN offre Of ON Of.idObjet=Ob.idObjet JOIN categorie C ON C.idCategorie=Ob.idCategorie JOIN utilisateur U ON Of.idUser=U.idUser WHERE Of.isDisponible=1 AND Of.isAccept=1";
        $bdd = new Model();
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute();
        $tab_produit = $req_prep->fetch();
        return $tab_produit;	
	}
	
	public static function getOffresP($premiereEntree,$p){
		$sql = "SELECT Ob.nomObjet,C.nomCategorie,Of.idUser,U.login,U.niveau,Ob.image, Ob.idObjet FROM objet Ob JOIN offre Of ON Of.idObjet=Ob.idObjet JOIN categorie C ON C.idCategorie=Ob.idCategorie JOIN utilisateur U ON Of.idUser=U.idUser WHERE Of.isDisponible=1 AND Of.isAccept=1 LIMIT {$premiereEntree},{$p}";
        $bdd = new Model();
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute();
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
	}
	
	public static function getNombreOffreC($idCategorie){
		$sql = "SELECT COUNT(*) AS nombre FROM objet Ob JOIN offre Of ON Of.idObjet=Ob.idObjet JOIN categorie C ON C.idCategorie=Ob.idCategorie JOIN utilisateur U ON Of.idUser=U.idUser WHERE Of.isDisponible=1 AND Of.isAccept=1 AND Ob.idCategorie=:tag_idCategorie";
        $bdd = new Model();
		$values = array("tag_idCategorie"=>$idCategorie);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_produit = $req_prep->fetch();
        return $tab_produit;	
	}
	
	public static function getOffreOnlyCategorie($idCategorie,$premiereEntree,$p){
		$sql = "SELECT Ob.nomObjet,C.nomCategorie,Of.idUser,U.login,U.niveau,Ob.image, Ob.idObjet FROM objet Ob JOIN offre Of ON Of.idObjet=Ob.idObjet JOIN categorie C ON C.idCategorie=Ob.idCategorie JOIN utilisateur U ON Of.idUser=U.idUser WHERE Of.isDisponible=1 AND Of.isAccept=1 AND Ob.idCategorie=:tag_idCategorie LIMIT {$premiereEntree},{$p}";
        $bdd = new Model();
		$values = array("tag_idCategorie"=>$idCategorie);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
	}
	
	public static function getNombreOffreCN($idCategorie,$nomObjet){
		$sql = "SELECT COUNT(*) AS nombre FROM objet Ob JOIN offre Of ON Of.idObjet=Ob.idObjet JOIN categorie C ON C.idCategorie=Ob.idCategorie JOIN utilisateur U ON Of.idUser=U.idUser WHERE Of.isDisponible=1 AND Of.isAccept=1 AND Ob.idCategorie=:tag_idCategorie AND Ob.nomObjet LIKE '%{$nomObjet}%'";
        $bdd = new Model();
		$values = array("tag_idCategorie"=>$idCategorie);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_produit = $req_prep->fetch();
        return $tab_produit;	
	}
	
	public static function getOffreCategorieObjet($idCategorie,$nomObjet,$premiereEntree,$p){	//Faire en sorte que la requete osef des maj et mins
		$sql = "SELECT Ob.nomObjet,C.nomCategorie,Of.idUser,U.login,U.niveau,Ob.image, Ob.idObjet FROM objet Ob JOIN offre Of ON Of.idObjet=Ob.idObjet JOIN categorie C ON C.idCategorie=Ob.idCategorie JOIN utilisateur U ON Of.idUser=U.idUser WHERE Of.isDisponible=1 AND Of.isAccept=1 AND Ob.idCategorie=:tag_idCategorie AND Ob.nomObjet LIKE '%{$nomObjet}%' LIMIT {$premiereEntree},{$p}";
        $bdd = new Model();
		$values = array("tag_idCategorie"=>$idCategorie);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
	}
	
	public static function getNombreOffreCNV($idCategorie,$nomObjet,$ville){
		$sql = "SELECT COUNT(*) AS nombre FROM objet Ob JOIN offre Of ON Of.idObjet=Ob.idObjet JOIN categorie C ON C.idCategorie=Ob.idCategorie JOIN utilisateur U ON Of.idUser=U.idUser WHERE Of.isDisponible=1 AND Of.isAccept=1 AND Ob.idCategorie=:tag_idCategorie AND Ob.nomObjet LIKE '%{$nomObjet}%' AND U.ville LIKE '%{$ville}%'";
        $bdd = new Model();
		$values = array("tag_idCategorie"=>$idCategorie);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_produit = $req_prep->fetch();
        return $tab_produit;	
	}
	
	public static function getOffreCategorieObjetVille($idCategorie,$nomObjet,$ville,$premiereEntree,$p){
		$sql = "SELECT Ob.nomObjet,C.nomCategorie,Of.idUser,U.login,U.niveau,Ob.image,Ob.idObjet FROM objet Ob JOIN offre Of ON Of.idObjet=Ob.idObjet JOIN categorie C ON C.idCategorie=Ob.idCategorie JOIN utilisateur U ON Of.idUser=U.idUser WHERE Of.isDisponible=1 AND Of.isAccept=1 AND Ob.idCategorie=:tag_idCategorie AND Ob.nomObjet LIKE '%{$nomObjet}%' AND U.ville LIKE '%{$ville}%' LIMIT {$premiereEntree},{$p}";
        $bdd = new Model();
		$values = array("tag_idCategorie"=>$idCategorie);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
	}
	
	public static function getNombreOffreO($nomObjet){
		$sql = "SELECT COUNT(*) AS nombre FROM objet Ob JOIN offre Of ON Of.idObjet=Ob.idObjet JOIN categorie C ON C.idCategorie=Ob.idCategorie JOIN utilisateur U ON Of.idUser=U.idUser WHERE Of.isDisponible=1 AND Of.isAccept=1 AND Ob.nomObjet LIKE '%{$nomObjet}%'";
        $bdd = new Model();
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute();
        $tab_produit = $req_prep->fetch();
        return $tab_produit;	
	}
	
		
	public static function getOffreOnlyObjet($nomObjet,$premiereEntree,$p){
		$sql = "SELECT Ob.nomObjet,C.nomCategorie,Of.idUser,U.login,U.niveau,Ob.image, Ob.idObjet FROM objet Ob JOIN offre Of ON Of.idObjet=Ob.idObjet JOIN categorie C ON C.idCategorie=Ob.idCategorie JOIN utilisateur U ON Of.idUser=U.idUser WHERE Of.isDisponible=1 AND Of.isAccept=1 AND Ob.nomObjet LIKE '%{$nomObjet}%' LIMIT {$premiereEntree},{$p}";
        $bdd = new Model();
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute();
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
	}

	public static function getNombreOffreV($ville){
		$sql = "SELECT COUNT(*) AS nombre FROM objet Ob JOIN offre Of ON Of.idObjet=Ob.idObjet JOIN categorie C ON C.idCategorie=Ob.idCategorie JOIN utilisateur U ON Of.idUser=U.idUser WHERE Of.isDisponible=1 AND Of.isAccept=1 AND U.ville LIKE '%{$ville}%'";
        $bdd = new Model();
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute();
        $tab_produit = $req_prep->fetch();
        return $tab_produit;	
	}
	
	public static function getOffreOnlyVille($ville,$premiereEntree,$p){
		$sql = "SELECT Ob.nomObjet,C.nomCategorie,Of.idUser,U.login,U.niveau,Ob.image, Ob.idObjet FROM objet Ob JOIN offre Of ON Of.idObjet=Ob.idObjet JOIN categorie C ON C.idCategorie=Ob.idCategorie JOIN utilisateur U ON Of.idUser=U.idUser WHERE Of.isDisponible=1 AND Of.isAccept=1 AND ville LIKE '%{$ville}%' LIMIT {$premiereEntree},{$p}";
        $bdd = new Model();
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute();
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
	}

	public static function getNombreOffreCV($idCategorie,$ville){
		$sql = "SELECT COUNT(*) AS nombre FROM objet Ob JOIN offre Of ON Of.idObjet=Ob.idObjet JOIN categorie C ON C.idCategorie=Ob.idCategorie JOIN utilisateur U ON Of.idUser=U.idUser WHERE Of.isDisponible=1 AND Of.isAccept=1 AND Ob.idCategorie=:tag_idCategorie AND ville LIKE '%{$ville}%'";
        $bdd = new Model();
		$values = array("tag_idCategorie"=>$idCategorie);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_produit = $req_prep->fetch();
        return $tab_produit;	
	}
	
	public static function getOffreCategorieVille($idCategorie,$ville,$premiereEntree,$p){	//Faire en sorte que la requete osef des maj et mins
		$sql = "SELECT Ob.nomObjet,C.nomCategorie,Of.idUser,U.niveau,U.login,Ob.image, Ob.idObjet FROM objet Ob JOIN offre Of ON Of.idObjet=Ob.idObjet JOIN categorie C ON C.idCategorie=Ob.idCategorie JOIN utilisateur U ON Of.idUser=U.idUser WHERE Of.isDisponible=1 AND Of.isAccept=1 AND AND Ob.idCategorie=:tag_idCategorie AND ville LIKE '%{$ville}%'  LIMIT {$premiereEntree},{$p}";
        $bdd = new Model();
        $bdd = new Model();
		$values = array("tag_idCategorie"=>$idCategorie);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
	}
	
	public static function getNombreOffreOV($nomObjet,$ville){
		$sql = "SELECT COUNT(*) AS nombre FROM objet Ob JOIN offre Of ON Of.idObjet=Ob.idObjet JOIN categorie C ON C.idCategorie=Ob.idCategorie JOIN utilisateur U ON Of.idUser=U.idUser WHERE Of.isDisponible=1 AND Of.isAccept=1 AND Ob.nomObjet LIKE '%{$nomObjet}%' AND U.ville LIKE '%{$ville}%' LIMIT {$premiereEntree},{$p}";
        $bdd = new Model();
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute();
        $tab_produit = $req_prep->fetch();
        return $tab_produit;	
	}
	
	public static function getOffreObjetVille($nomObjet,$ville){
		$sql = "SELECT Ob.nomObjet,C.nomCategorie,Of.idUser,U.niveau,U.login,Ob.image, Ob.idObjet FROM objet Ob JOIN offre Of ON Of.idObjet=Ob.idObjet JOIN categorie C ON C.idCategorie=Ob.idCategorie JOIN utilisateur U ON Of.idUser=U.idUser WHERE Of.isDisponible=1 AND Of.isAccept=1 AND Ob.nomObjet LIKE '%{$nomObjet}%' AND U.ville LIKE '%{$ville}%' LIMIT {$premiereEntree},{$p}";
        $bdd = new Model();
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute();
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
	}
	
	public static function getOffreById($idOffre){
		$sql="SELECT * FROM offre WHERE idOffre=:tag_id";
		// Préparation de la requête
        $req_prep = Model::$pdo->prepare($sql);
		$values = array("tag_id"=>$idOffre);
        $req_prep = Model::$pdo->prepare($sql);
		$req_prep->execute($values);
        $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelOffre');
        $offre = $req_prep->fetchAll();
		if (empty($offre)){
            return false;
        }
        else{
            return $offre[0];
        }
	}
	
	public static function getOffreByIdO($idObjet){
		$sql="SELECT * FROM offre WHERE idObjet=:tag_id";
		// Préparation de la requête
		$values = array("tag_id"=>$idObjet);
        $req_prep = Model::$pdo->prepare($sql);
		$req_prep->execute($values);
        $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelOffre');
        $offre = $req_prep->fetchAll();
		if (empty($offre)){
            return false;
        }
        else{
            return $offre[0];
        }
	}
	
	public function updateStatutOUp($idOffre){
		$sql="UPDATE offre SET isOnOffre=1 WHERE idOffre=:tag_id";
        $req_prep = Model::$pdo->prepare($sql);
		$values=array("tag_id"=>$idOffre);
		$req_prep->execute($values);
	}
	
	public static function getOffresById($idUser){
		$sql="SELECT * FROM offre WHERE idUser=:tag_id";
		// Préparation de la requête
        $req_prep = Model::$pdo->prepare($sql);
		$values = array("tag_id"=>$idUser);
        $req_prep = Model::$pdo->prepare($sql);
		$req_prep->execute($values);
        $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelOffre');
        $offre = $req_prep->fetchAll();
		if (empty($offre)){
            return false;
        }
        else{
            return $offre[0];
        }
	}
	
		public static function getOffreNonAccept($login){
		$sql="SELECT * FROM offre Of JOIN utilisateur U ON Of.idUser=U.idUser JOIN objet O ON O.idObjet=Of.idObjet JOIN categorie C ON C.idCategorie=O.idCategorie WHERE U.login=:tag_login AND Of.isAccept=0 AND Of.isDisponible=1 AND Of.isOnOffre=0 AND isOnEchange=0 ORDER BY Of.idOffre DESC";
		$bdd = new Model();
		$values=array("tag_login"=>$login);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
	}
	
	public static function getOffreDispo($login){
		$sql="SELECT * FROM offre Of JOIN utilisateur U ON Of.idUser=U.idUser JOIN objet O ON O.idObjet=Of.idObjet JOIN categorie C ON C.idCategorie=O.idCategorie WHERE U.login=:tag_login AND Of.isAccept=1 AND Of.isDisponible=1 AND Of.isOnOffre=0 AND isOnEchange=0 ORDER BY Of.idOffre DESC";
		$bdd = new Model();
		$values=array("tag_login"=>$login);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
	}
	
	public static function getOffreCours($login){
		$sql="SELECT * FROM offre Of JOIN utilisateur U ON Of.idUser=U.idUser JOIN objet O ON O.idObjet=Of.idObjet JOIN categorie C ON C.idCategorie=O.idCategorie WHERE U.login=:tag_login AND Of.isAccept=1 AND Of.isDisponible=1 AND Of.isOnOffre=1 AND isOnEchange=0 ORDER BY Of.idOffre DESC";
		$bdd = new Model();
		$values=array("tag_login"=>$login);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
	}
	
	public static function getOffreNonDispo($login){
		$sql="SELECT * FROM offre Of JOIN utilisateur U ON Of.idUser=U.idUser JOIN objet O ON O.idObjet=Of.idObjet JOIN categorie C ON C.idCategorie=O.idCategorie WHERE U.login=:tag_login AND Of.isAccept=1 AND Of.isDisponible=0 AND isOnEchange=0 ORDER BY Of.idOffre DESC";
		$bdd = new Model();
		$values=array("tag_login"=>$login);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
	}	
	
	public static function getOffreEchange($login){
		$sql="SELECT * FROM offre Of JOIN utilisateur U ON Of.idUser=U.idUser JOIN objet O ON O.idObjet=Of.idObjet JOIN categorie C ON C.idCategorie=O.idCategorie JOIN echange E ON E.idOffre=Of.idOffre WHERE U.login=:tag_login AND Of.isAccept=1 AND Of.isDisponible=0 AND Of.isOnOffre=1 AND E.isPrete=1 AND E.isRendu=0 AND isOnEchange=1 ORDER BY Of.idOffre DESC";
		$bdd = new Model();
		$values=array("tag_login"=>$login);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
	}
	
	public static function getOffreMesEchanges($login){
		$sql="SELECT * FROM offre Of JOIN utilisateur U ON Of.idUser=U.idUser JOIN objet O ON O.idObjet=Of.idObjet JOIN categorie C ON C.idCategorie=O.idCategorie JOIN echange E ON E.idOffre=Of.idOffre WHERE U.login=:tag_login AND Of.isAccept=1 AND Of.isDisponible=0 AND Of.isOnOffre=1 AND E.isPrete=1 AND E.isRendu=0 AND isOnEchange=1 ORDER BY Of.idOffre DESC";
		$bdd = new Model();
		$values=array("tag_login"=>$login);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
	}
	
	public static function modifO($debut,$fin,$id){
		$sql="UPDATE offre SET date_debut=:tag_debut,date_fin=:tag_fin WHERE idObjet=:tag_id";
		$req_prep = Model::$pdo->prepare($sql);
		$values=array("tag_debut"=>$debut,
		"tag_fin"=>$fin,
		"tag_id"=>$id);
		$req_prep->execute($values);
	}
	
	public static function deleteO($id){
		$sql="DELETE FROM offre WHERE idObjet=:tag_id";
		$req_prep = Model::$pdo->prepare($sql);
		$values=array("tag_id"=>$id);
		$req_prep->execute($values);	
	}
	
	public static function indisponibleO($id){
		$sql="UPDATE offre SET isDisponible=0 WHERE idObjet=:tag_id";
		$req_prep = Model::$pdo->prepare($sql);
		$values=array("tag_id"=>$id);
		$req_prep->execute($values);
	}
	
	public static function disponibleO($id){
		$sql="UPDATE offre SET isDisponible=1 WHERE idObjet=:tag_id";
		$req_prep = Model::$pdo->prepare($sql);
		$values=array("tag_id"=>$id);
		$req_prep->execute($values);
	}
	
	public static function getUserOnOffre($idObjet,$idPreteur){
		$sql="SELECT E.idEmprunteur,U.login FROM preechange E JOIN offre Of ON Of.idOffre=E.idOffre JOIN utilisateur U ON E.idEmprunteur=U.idUser WHERE Of.idObjet=:tag_objet AND E.idPreteur=:tag_preteur";
		$bdd = new Model();
		$values=array("tag_objet"=>$idObjet, "tag_preteur"=>$idPreteur);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
	}
	
	public static function verifOffre($idObjet,$idPreteur){
		$sql="SELECT E.idOffre FROM preechange E JOIN offre Of ON E.idOffre=Of.idOffre WHERE Of.isOnOffre=1 AND E.idPreteur=:tag_preteur AND Of.idObjet=:tag_Objet";
		$req_prep = Model::$pdo->prepare($sql);
		$values = array("tag_preteur"=>$idPreteur, "tag_Objet"=>$idObjet);
		$req_prep->execute($values);
        $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelEchange');
        $offre = $req_prep->fetchAll();
		if (empty($offre)){
            return false;
        }
        else{
            return $offre[0];
        }
	}
	
	
	public static function getEmprunteur($idPreteur){
		$sql="SELECT E.idEmprunteur,U.login,U.niveau,E.idOffre,E.isRendu,E.isPrete FROM echange E JOIN utilisateur U ON U.idUser=E.idEmprunteur WHERE E.isPrete=1 AND E.isRendu=0 AND E.idPreteur=:tag_preteur";
		$req_prep = Model::$pdo->prepare($sql);
		$values = array("tag_preteur"=>$idPreteur);
		$req_prep->execute($values);
        $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelEchange');
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;		
	}
	
	public function encours(){
		$sql="UPDATE offre SET isDisponible=0,isOnEchange=1 WHERE idOffre=:tag_offre";
		$req_prep = Model::$pdo->prepare($sql);
		$values = array("tag_offre"=>$this->idOffre);
		$req_prep->execute($values);
	}
	
	public static function getDemandesOffres(){
		$sql="SELECT idOffre,nomObjet,nom, nomQuartier AS quartier, nomCategorie,email,telephone FROM objet O JOIN offre Of ON Of.idObjet=O.idObjet JOIN utilisateur U ON Of.idUser=U.idUser JOIN categorie C ON C.idCategorie=O.idCategorie JOIN quartier Q ON Q.idQuartier=U.idQuartier  WHERE isAccept=0";
		$bdd = new Model();
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute();
        $tab_offre = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_offre;	
	}
	
	public static function getOffres(){
		$sql="SELECT Of.idOffre,nomObjet,nom,nomQuartier AS quartier ,nomCategorie,email,telephone,isDisponible,isOnEchange FROM objet O JOIN offre Of ON Of.idObjet=O.idObjet JOIN utilisateur U ON Of.idUser=U.idUser JOIN categorie C ON C.idCategorie=O.idCategorie  JOIN quartier Q ON Q.idQuartier=U.idQuartier WHERE isAccept=1";
		$bdd = new Model();
        $req_prep = $bdd::$pdo->prepare($sql);
	    $req_prep->execute();
        $tab_offre = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_offre;	
	}
	
	public static function getObjetOByIdOffre($idOffre){
		$sql = "SELECT Of.isAccept,Of.idOffre,Ob.idObjet,Ob.nomObjet,C.nomCategorie,Of.idUser,Ob.description,Ob.marque,Of.isDisponible,Of.isOnOffre,Of.date_debut,Of.date_fin,Ob.image,Of.notation,U.login FROM objet Ob JOIN offre Of ON Ob.idObjet=Of.idObjet JOIN categorie C ON Ob.idCategorie=C.idCategorie JOIN utilisateur U ON U.idUser=Of.idUser WHERE Of.idOffre=:tag_idOffre";	
        $bdd = new Model();
		$values=array(
			":tag_idOffre"=>$idOffre
		);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
		$produit=$req_prep->fetchAll(PDO::FETCH_OBJ);
		return $produit;
	}
	
	public function confirmed(){
		$sql="UPDATE offre SET isAccept=1 WHERE idOffre=:tag_id";
		$req_prep = Model::$pdo->prepare($sql);
		$values=array("tag_id"=>$this->idOffre);
		$req_prep->execute($values);
	}
	
	public function deleted(){
		$sql="DELETE FROM offre WHERE idOffre=:tag_id";
		$req_prep = Model::$pdo->prepare($sql);
		$values=array("tag_id"=>$this->idOffre);
		$req_prep->execute($values);
	}
	
	public static function getOffreByUtil($idUser){
		$sql="SELECT nomObjet, Ob.image, nomCategorie, description, marque, date_debut, date_fin FROM offre Of JOIN objet Ob ON Ob.idObjet=Of.idObjet JOIN categorie C ON C.idCategorie=Ob.idCategorie WHERE idUser=:tag_id";
		// Préparation de la requête
        $req_prep = Model::$pdo->prepare($sql);
		$values = array("tag_id"=>$idUser);
		$req_prep->execute($values);
        $tab_offre = $req_prep->fetchAll(PDO::FETCH_OBJ);
		if (empty($tab_offre)){
            return false;
        }
        else{
            return $tab_offre;
        }
	}
	
		public static function getOffresByIdUser($idUser){
		$sql="SELECT * FROM offre WHERE idUser=:tag_id";
		// Préparation de la requête
        $req_prep = Model::$pdo->prepare($sql);
		$values = array("tag_id"=>$idUser);
        $req_prep = Model::$pdo->prepare($sql);
		$req_prep->execute($values);
        $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelOffre');
        $offre = $req_prep->fetchAll();
		if (empty($offre)){
            return false;
        }
        else{
            return $offre;
        }
	}
	
}