<?php


require_once File::build_path(array("model", "Model.php"));


class ModelDemande{
	
	private $idDemande;
	private $date_debut;
	private $date_fin;
	private $isRendu;
	private $isOnDemand;
	private $isAccept;
	private $idUser;
	private $idObjet;
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
	
	public function __construct($idDemande = NULL, $date_debut = NULL, $date_fin = NULL,$isRendu = NULL, $isOnDemand = NULL, $isAccept = NULL,$isOnEchange = NULL,$notation = NULL, $idUser = NULL, $idObjet = NULL) {
		if (!is_null($idDemande)){
			$this->idDemande= $idDemande;
		}
		if (!is_null($date_debut) && !is_null($isOnDemand) && !is_null($isRendu) && !is_null($isAccept) && !is_null($idUser) && !is_null($idObjet)){
			$this->date_debut = $date_debut;
			$this->date_fin=$date_fin;
			$this->isRendu=$isRendu;
			$this->isOnDemand=$isOnDemand;
			$this->isAccept=$isAccept;
			$this->idUser=$idUser;
			$this->idObjet=$idObjet;
			$this->isOnEchange=$isOnEchange;	
			$this->notation=$notation;
		}
	}

	public function save (){
		try {
			require_once File::build_path(array('model','Model.php'));
			$statement = "INSERT INTO demande (date_debut,date_fin,isRendu,isOnDemand,isAccept,isOnEchange,notation, idUser,idObjet)
					VALUES (:tag_dateD,:tag_dateF,:tag_rendu,:tag_OnDemand,:tag_accept,:tag_echange,:tag_notation, :tag_User,:tag_Objet)";
			$req_prep = Model::$pdo->prepare($statement);
			$values = array(
				"tag_dateD"=>$this->date_debut,
				"tag_dateF"=>$this->date_fin,
				"tag_rendu"=>$this->isRendu,
				"tag_OnDemand"=>$this->isOnDemand,
				"tag_accept"=>$this->isAccept,
				"tag_echange"=>$this->isOnEchange,
				"tag_notation"=>$this->notation,
				"tag_User"=>$this->idUser,
				"tag_Objet"=>$this->idObjet
				);
			$req_prep->execute($values);
			$bdd = new Model();
			$this->set('idDemande', $bdd::$pdo->lastInsertId());
		} catch (Exception $ex) {
            echo $ex->getMessage(); 
            die();
        }
	}	
	
	public static function getNombreDemande(){
		$sql = "SELECT COUNT(*) AS nombre FROM objet Ob JOIN demande D ON D.idObjet=Ob.idObjet JOIN categorie C ON C.idCategorie=Ob.idCategorie JOIN utilisateur U ON D.idUser=U.idUser WHERE D.isRendu=1 AND D.isAccept=1";
        $bdd = new Model();
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute();
        $tab_produit = $req_prep->fetch();
        return $tab_produit;	
	}
	
	public static function getDemandesP($premiereEntree,$p){
		$sql = "SELECT Ob.nomObjet,C.nomCategorie,D.idUser,U.login,U.niveau,Ob.image, Ob.idObjet FROM objet Ob JOIN demande D ON D.idObjet=Ob.idObjet JOIN categorie C ON C.idCategorie=Ob.idCategorie JOIN utilisateur U ON D.idUser=U.idUser WHERE D.isRendu=1 AND D.isAccept=1 LIMIT {$premiereEntree},{$p}";
        $bdd = new Model();
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute();
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
	}
	
	public static function getNombreDemandeC($idCategorie){
		$sql = "SELECT COUNT(*) AS nombre FROM objet Ob JOIN demande D ON D.idObjet=Ob.idObjet JOIN categorie C ON C.idCategorie=Ob.idCategorie JOIN utilisateur U ON D.idUser=U.idUser WHERE D.isRendu=1 AND D.isAccept=1 AND Ob.idCategorie=:tag_idCategorie";
        $bdd = new Model();
		$values = array("tag_idCategorie"=>$idCategorie);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_produit = $req_prep->fetch();
        return $tab_produit;	
	}
	
	public static function getDemandeOnlyCategorie($idCategorie,$premiereEntree,$p){
		$sql = "SELECT Ob.nomObjet,C.nomCategorie,D.idUser,U.niveau,U.login,Ob.image, Ob.idObjet FROM objet Ob JOIN demande D ON D.idObjet=Ob.idObjet JOIN categorie C ON C.idCategorie=Ob.idCategorie JOIN utilisateur U ON D.idUser=U.idUser WHERE D.isRendu=1 AND D.isAccept=1 AND Ob.idCategorie=:tag_idCategorie LIMIT {$premiereEntree},{$p}";
        $bdd = new Model();
		$values = array("tag_idCategorie"=>$idCategorie);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
	}
	
	public static function getNombreDemandeCN($idCategorie,$nomObjet){
		$sql = "SELECT COUNT(*) AS nombre FROM objet Ob JOIN demande D ON D.idObjet=Ob.idObjet JOIN categorie C ON C.idCategorie=Ob.idCategorie JOIN utilisateur U ON D.idUser=U.idUser WHERE D.isRendu=1 AND D.isAccept=1 AND Ob.idCategorie=:tag_idCategorie AND Ob.nomObjet LIKE '%{$nomObjet}%'";
        $bdd = new Model();
		$values = array("tag_idCategorie"=>$idCategorie);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_produit = $req_prep->fetch();
        return $tab_produit;	
	}
	
	public static function getDemandeCategorieObjet($idCategorie,$nomObjet,$premiereEntree,$p){	//Faire en sorte que la requete osef des maj et mins
		$sql = "SELECT Ob.nomObjet,C.nomCategorie,D.idUser,U.niveau,U.login,Ob.image, Ob.idObjet FROM objet Ob JOIN demande D ON D.idObjet=Ob.idObjet JOIN categorie C ON C.idCategorie=Ob.idCategorie JOIN utilisateur U ON D.idUser=U.idUser WHERE D.isRendu=1 AND D.isAccept=1 AND Ob.idCategorie=:tag_idCategorie AND Ob.nomObjet LIKE '%{$nomObjet}%' LIMIT {$premiereEntree},{$p}";
        $bdd = new Model();
		$values = array("tag_idCategorie"=>$idCategorie);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
	}
	
	public static function getNombreDemandeCNV($idCategorie,$nomObjet,$ville){
		$sql = "SELECT COUNT(*) AS nombre FROM objet Ob JOIN demande D ON D.idObjet=Ob.idObjet JOIN categorie C ON C.idCategorie=Ob.idCategorie JOIN utilisateur U ON D.idUser=U.idUser WHERE D.isRendu=1 AND D.isAccept=1 AND Ob.idCategorie=:tag_idCategorie AND Ob.nomObjet LIKE '%{$nomObjet}%' AND U.ville LIKE '%{$ville}%'";
        $bdd = new Model();
		$values = array("tag_idCategorie"=>$idCategorie);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_produit = $req_prep->fetch();
        return $tab_produit;	
	}
	
		public static function getDemandeCategorieObjetVille($idCategorie,$nomObjet,$ville,$premiereEntree,$p){
		$sql = "SELECT Ob.nomObjet,C.nomCategorie,D.idUser,U.niveau,U.login,Ob.image,Ob.idObjet FROM objet Ob JOIN demande D ON D.idObjet=Ob.idObjet JOIN categorie C ON C.idCategorie=Ob.idCategorie JOIN utilisateur U ON D.idUser=U.idUser WHERE D.isRendu=1 AND D.isAccept=1 AND Ob.idCategorie=:tag_idCategorie AND Ob.nomObjet LIKE '%{$nomObjet}%' AND U.ville LIKE '%{$ville}%' LIMIT {$premiereEntree},{$p}";
        $bdd = new Model();
		$values = array("tag_idCategorie"=>$idCategorie);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
	}
	
	public static function getNombreDemandeO($nomObjet){
		$sql = "SELECT COUNT(*) AS nombre FROM objet Ob JOIN demande D ON D.idObjet=Ob.idObjet JOIN categorie C ON C.idCategorie=Ob.idCategorie JOIN utilisateur U ON D.idUser=U.idUser WHERE D.isRendu=1 AND D.isAccept=1 AND Ob.nomObjet LIKE '%{$nomObjet}%'";
        $bdd = new Model();
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute();
        $tab_produit = $req_prep->fetch();
        return $tab_produit;	
	}
	
		
	public static function getDemandeOnlyObjet($nomObjet,$premiereEntree,$p){
		$sql = "SELECT Ob.nomObjet,C.nomCategorie,D.idUser,U.niveau,U.login,Ob.image, Ob.idObjet FROM objet Ob JOIN demande D ON D.idObjet=Ob.idObjet JOIN categorie C ON C.idCategorie=Ob.idCategorie JOIN utilisateur U ON D.idUser=U.idUser WHERE D.isRendu=1 AND D.isAccept=1 AND Ob.nomObjet LIKE '%{$nomObjet}%' LIMIT {$premiereEntree},{$p}";
        $bdd = new Model();
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute();
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
	}

	public static function getNombreDemandeV($ville){
		$sql = "SELECT COUNT(*) AS nombre FROM objet Ob JOIN demande D ON D.idObjet=Ob.idObjet JOIN categorie C ON C.idCategorie=Ob.idCategorie JOIN utilisateur U ON D.idUser=U.idUser WHERE D.isRendu=1 AND D.isAccept=1 AND U.ville LIKE '%{$ville}%'";
        $bdd = new Model();
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute();
        $tab_produit = $req_prep->fetch();
        return $tab_produit;	
	}
	
	public static function getDemandeOnlyVille($ville,$premiereEntree,$p){
		$sql = "SELECT Ob.nomObjet,C.nomCategorie,D.idUser,U.niveau,U.login,Ob.image, Ob.idObjet FROM objet Ob JOIN demande D ON D.idObjet=Ob.idObjet JOIN categorie C ON C.idCategorie=Ob.idCategorie JOIN utilisateur U ON D.idUser=U.idUser WHERE D.isRendu=1 AND D.isAccept=1 AND Ob.ville LIKE '%{$ville}%' LIMIT {$premiereEntree},{$p}";
        $bdd = new Model();
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute();
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
	}

	public static function getNombreDemandeCV($idCategorie,$ville){
		$sql = "SELECT COUNT(*) AS nombre FROM objet Ob JOIN demande D ON D.idObjet=Ob.idObjet JOIN categorie C ON C.idCategorie=Ob.idCategorie JOIN utilisateur U ON D.idUser=U.idUser WHERE D.isRendu=1 AND D.isAccept=1 AND Ob.idCategorie=:tag_idCategorie AND Ob.ville LIKE '%{$ville}%'";
        $bdd = new Model();
		$values = array("tag_idCategorie"=>$idCategorie);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_produit = $req_prep->fetch();
        return $tab_produit;	
	}
	
	public static function getDemandeCategorieVille($idCategorie,$ville,$premiereEntree,$p){	//Faire en sorte que la requete osef des maj et mins
		$sql = "SELECT Ob.nomObjet,C.nomCategorie,D.idUser,U.niveau,U.login,Ob.image, Ob.idObjet FROM objet Ob JOIN demande D ON D.idObjet=Ob.idObjet JOIN categorie C ON C.idCategorie=Ob.idCategorie JOIN utilisateur U ON D.idUser=U.idUser WHERE D.isRendu=1 AND D.isAccept=1 AND AND Ob.idCategorie=:tag_idCategorie AND Ob.ville LIKE '%{$ville}%'  LIMIT {$premiereEntree},{$p}";
        $bdd = new Model();
        $bdd = new Model();
		$values = array("tag_idCategorie"=>$idCategorie);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
	}
	
	public static function getNombreDemandeOV($nomObjet,$ville){
		$sql = "SELECT COUNT(*) AS nombre FROM objet Ob JOIN demande D ON D.idObjet=Ob.idObjet JOIN categorie C ON C.idCategorie=Ob.idCategorie JOIN utilisateur U ON D.idUser=U.idUser WHERE D.isRendu=1 AND D.isAccept=1 AND Ob.nomObjet LIKE '%{$nomObjet}%' AND U.ville LIKE '%{$ville}%' LIMIT {$premiereEntree},{$p}";
        $bdd = new Model();
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute();
        $tab_produit = $req_prep->fetch();
        return $tab_produit;	
	}
	
	public static function getDemandeObjetVille($nomObjet,$ville){
		$sql = "SELECT Ob.nomObjet,C.nomCategorie,D.idUser,U.niveau,U.login,Ob.image, Ob.idObjet FROM objet Ob JOIN demande D ON D.idObjet=Ob.idObjet JOIN categorie C ON C.idCategorie=Ob.idCategorie JOIN utilisateur U ON D.idUser=U.idUser WHERE D.isRendu=1 AND D.isAccept=1 AND Ob.nomObjet LIKE '%{$nomObjet}%' AND U.ville LIKE '%{$ville}%' LIMIT {$premiereEntree},{$p}";
        $bdd = new Model();
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute();
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
	}
	
	public static function getDemandeById($idDemande){
		$sql="SELECT * FROM demande WHERE idDemande=:tag_id";
		// Préparation de la requête
        $req_prep = Model::$pdo->prepare($sql);
		$values = array("tag_id"=>$idDemande);
        $req_prep = Model::$pdo->prepare($sql);
		$req_prep->execute($values);
        $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelDemande');
        $demande = $req_prep->fetchAll();
		if (empty($demande)){
            return false;
        }
        else{
            return $demande[0];
        }
	}
	
	public static function getDemandeByIdO($idObjet){
		$sql="SELECT * FROM demande WHERE idObjet=:tag_id";
		// Préparation de la requête
        $req_prep = Model::$pdo->prepare($sql);
		$values = array("tag_id"=>$idObjet);
        $req_prep = Model::$pdo->prepare($sql);
		$req_prep->execute($values);
        $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelDemande');
        $demande = $req_prep->fetchAll();
		if (empty($demande)){
            return false;
        }
        else{
            return $demande[0];
        }
	}
	
	public function updateStatutDUp($idDemande){
		$sql="UPDATE demande SET isOnDemand=1 WHERE idDemande=:tag_id";
        $req_prep = Model::$pdo->prepare($sql);
		$values=array("tag_id"=>$idDemande);
		$req_prep->execute($values);
	}
	
	
	public static function getDemandesById($idUser){
		$sql="SELECT * FROM demande WHERE idUser=:tag_id";
		// Préparation de la requête
        $req_prep = Model::$pdo->prepare($sql);
		$values = array("tag_id"=>$idUser);
        $req_prep = Model::$pdo->prepare($sql);
		$req_prep->execute($values);
        $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelDemande');
        $demande = $req_prep->fetchAll();
		if (empty($demande)){
            return false;
        }
        else{
            return $demande[0];
        }
	}
	
	public static function getDemandeNonAccept($login){
		$sql="SELECT * FROM demande D JOIN utilisateur U ON D.idUser=U.idUser JOIN objet O ON O.idObjet=D.idObjet JOIN categorie C ON C.idCategorie=O.idCategorie WHERE U.login=:tag_login AND D.isAccept=0 AND D.isRendu=1 AND isOnDemand=0 AND isOnEchange=0 ORDER BY D.idDemande DESC";
		$bdd = new Model();
		$values=array("tag_login"=>$login);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
	}
	
	public static function getDemandeDispo($login){
		$sql="SELECT * FROM demande D JOIN utilisateur U ON D.idUser=U.idUser JOIN objet O ON O.idObjet=D.idObjet JOIN categorie C ON C.idCategorie=O.idCategorie WHERE U.login=:tag_login AND D.isAccept=1 AND D.isRendu=1 AND isOnDemand=0 AND isOnEchange=0 ORDER BY D.idDemande DESC";
		$bdd = new Model();
		$values=array("tag_login"=>$login);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
	}
	
	public static function getDemandeCours($login){
		$sql="SELECT * FROM demande D JOIN utilisateur U ON D.idUser=U.idUser JOIN objet O ON O.idObjet=D.idObjet JOIN categorie C ON C.idCategorie=O.idCategorie WHERE U.login=:tag_login AND D.isAccept=1 AND D.isRendu=1 AND isOnDemand=1 AND isOnEchange=0 ORDER BY D.idDemande DESC";
		$bdd = new Model();
		$values=array("tag_login"=>$login);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
	}
	
	public static function getDemandeNonDispo($login){
		$sql="SELECT * FROM demande D JOIN utilisateur U ON D.idUser=U.idUser JOIN objet O ON O.idObjet=D.idObjet JOIN categorie C ON C.idCategorie=O.idCategorie WHERE U.login=:tag_login AND D.isAccept=1 AND D.isRendu=0 AND isOnEchange=0 ORDER BY D.idDemande DESC";
		$bdd = new Model();
		$values=array("tag_login"=>$login);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
	}
	
	public static function getDemandeEchange($login){
		$sql="SELECT * FROM demande D JOIN utilisateur U ON D.idUser=U.idUser JOIN objet O ON O.idObjet=D.idObjet JOIN categorie C ON C.idCategorie=O.idCategorie JOIN echange E ON E.idDemande=D.idDemande WHERE U.login=:tag_login AND D.isAccept=1 AND D.isRendu=0 AND D.isOnDemand=1 AND E.isPrete=1 AND E.isRendu=0 AND isOnEchange=1 ORDER BY D.idDemande DESC";
		$bdd = new Model();
		$values=array("tag_login"=>$login);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
	}
	
	public static function getDemandeMesEchanges($login){
		$sql="SELECT * FROM demande D JOIN utilisateur U ON D.idUser=U.idUser JOIN objet O ON O.idObjet=D.idObjet JOIN categorie C ON C.idCategorie=O.idCategorie JOIN echange E ON E.idDemande=D.idDemande WHERE U.login=:tag_login AND D.isAccept=1 AND D.isRendu=0 AND D.isOnDemand=1 AND E.isPrete=1 AND E.isRendu=0 AND isOnEchange=1 ORDER BY D.idDemande DESC";
		$bdd = new Model();
		$values=array("tag_login"=>$login);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
	}
	
	public static function modifD($debut,$fin,$id){
		$sql="UPDATE demande D SET date_debut=:tag_debut,date_fin=:tag_fin WHERE idObjet=:tag_id";
		$req_prep = Model::$pdo->prepare($sql);
		$values=array("tag_debut"=>$debut,
		"tag_fin"=>$fin,
		"tag_id"=>$id);
		$req_prep->execute($values);
	}
	
	public static function deleteD($id){
		$sql="DELETE FROM demande WHERE idObjet=:tag_id";
		$req_prep = Model::$pdo->prepare($sql);
		$values=array("tag_id"=>$id);
		$req_prep->execute($values);
		
	}
	
	public static function indisponibleD($id){
		$sql="UPDATE demande SET isRendu=0 WHERE idObjet=:tag_id";
		$req_prep = Model::$pdo->prepare($sql);
		$values=array("tag_id"=>$id);
		$req_prep->execute($values);
	}
	
	public static function disponibleD($id){
		$sql="UPDATE demande SET isRendu=1 WHERE idObjet=:tag_id";
		$req_prep = Model::$pdo->prepare($sql);
		$values=array("tag_id"=>$id);
		$req_prep->execute($values);
	}
	
	public static function getUserOnDemand($idObjet,$idEmprunteur){
		$sql="SELECT E.idPreteur,U.login FROM preechange E JOIN demande D ON D.idDemande=E.idDemande JOIN utilisateur U ON E.idPreteur=U.idUser WHERE D.idObjet=:tag_objet AND E.idEmprunteur=:tag_emprunteur";
		$bdd = new Model();
		$values=array("tag_objet"=>$idObjet, "tag_emprunteur"=>$idEmprunteur);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
	}
	
	public static function verifDemande($idObjet,$idEmprunteur){
		$sql="SELECT E.idDemande FROM preechange E JOIN demande D ON E.idDemande=D.idDemande WHERE D.isOnDemand=1 AND E.idEmprunteur=:tag_emprunteur AND D.idObjet=:tag_Objet";
		$req_prep = Model::$pdo->prepare($sql);
		$values = array("tag_emprunteur"=>$idEmprunteur, "tag_Objet"=>$idObjet);
		$req_prep->execute($values);
        $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelEchange');
        $demande = $req_prep->fetchAll();
		if (empty($demande)){
            return false;
        }
        else{
            return $demande[0];
        }
	}
	
	public static function getPreteur($idEmprunteur){
		$sql="SELECT E.idPreteur,U.login,U.niveau,E.idDemande,E.isRendu,E.isPrete FROM echange E JOIN utilisateur U ON U.idUser=E.idPreteur WHERE E.isPrete=1 AND E.isRendu=0 AND E.idEmprunteur=:tag_emprunteur";
				$req_prep = Model::$pdo->prepare($sql);
		$values = array("tag_emprunteur"=>$idEmprunteur);
		$req_prep->execute($values);
        $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelEchange');
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;		
	}
	
	public function encours(){
		$sql="UPDATE demande SET isRendu=0,isOnEchange=1 WHERE idDemande=:tag_demande";
		$req_prep = Model::$pdo->prepare($sql);
		$values = array("tag_demande"=>$this->idDemande);
		$req_prep->execute($values);
	}
	
	public static function getDemandesRecherches(){
		$sql="SELECT D.idDemande,nomObjet,nom,nomCategorie,nomQuartier AS quartier,email,telephone FROM objet O JOIN demande D ON D.idObjet=O.idObjet JOIN utilisateur U ON D.idUser=U.idUser JOIN categorie C ON C.idCategorie=O.idCategorie JOIN quartier Q ON Q.idQuartier=U.idQuartier		WHERE isAccept=0";
		$bdd = new Model();
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute();
        $tab_offre = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_offre;	
	}
	
	public static function getDemandes(){
		$sql="SELECT D.idDemande,nomObjet,nom,nomCategorie,nomQuartier AS quartier, email,telephone,isRendu,isOnEchange FROM objet O JOIN demande D ON D.idObjet=O.idObjet JOIN utilisateur U ON D.idUser=U.idUser JOIN categorie C ON C.idCategorie=O.idCategorie JOIN quartier Q ON Q.idQuartier=U.idQuartier WHERE isAccept=1";
		$bdd = new Model();
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute();
        $tab_offre = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_offre;	
	}
	
	public static function getObjetOByIdDemande($idDemande){
		$sql = "SELECT D.isAccept,D.idDemande,Ob.idObjet,Ob.nomObjet,C.nomCategorie,D.idUser,Ob.description,Ob.marque,D.isRendu,D.isOnDemand,D.date_debut,D.date_fin,Ob.image,D.notation,U.login FROM objet Ob JOIN demande D ON Ob.idObjet=D.idObjet JOIN categorie C ON Ob.idCategorie=C.idCategorie JOIN utilisateur U ON U.idUser=D.idUser WHERE D.idDemande=:tag_idDemande";	
        $bdd = new Model();
		$values=array(
			":tag_idDemande"=>$idDemande
		);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
		$produit=$req_prep->fetchAll(PDO::FETCH_OBJ);
		return $produit;
	}
	
	public function confirmed(){
		$sql="UPDATE demande SET isAccept=1 WHERE idDemande=:tag_id";
		$req_prep = Model::$pdo->prepare($sql);
		$values=array("tag_id"=>$this->idDemande);
		$req_prep->execute($values);
	}
	
	public function deletedD(){
		$sql="DELETE FROM demande WHERE idDemande=:tag_id";
		$req_prep = Model::$pdo->prepare($sql);
		$values=array("tag_id"=>$this->idDemande);
		$req_prep->execute($values);
	}

}