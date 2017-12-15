<?php

require_once File::build_path(array("model", "Model.php"));

class ModelUtilisateur {
	private $idUser;
	private $login;
	private $MotDePasse;
	private $isAdmin;
	private $isActif;
	private $nom;
	private $prenom;
	private $sexe;
	private $telephone;
	private $adresse;
	private $email;
	private $niveau;
	private $idQuartier;
	private $nomAssurance;
	
		
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
	public function __construct($idUser = NULL, $login = NULL, $mdp = NULL, $nom = NULL, $prenom = NULL, $sexe = NULL, $telephone = NULL,$idQuartier = NULL, $adresse = NULL, $mail = NULL, $niveau= NULL, $nomAssurance = NULL) {
		if (!is_null($idUser)){
			$this->idUser = $idUser;
		}
		if (!is_null($login) && !is_null($mdp) && !is_null($nom) && !is_null($prenom) && !is_null($sexe) && !is_null($telephone) && !is_null($idQuartier) && !is_null($adresse) && !is_null($mail) && !is_null($nomAssurance)){
			$this->login = $login;
			$this->MotDePasse=$mdp;
			$this->nom=$nom;
			$this->prenom=$prenom;
			$this->sexe=$sexe;
			$this->telephone=$telephone;
			$this->adresse=$adresse;
			$this->email=$mail;
			$this->idQuartier=$idQuartier;
			$this->isAdmin=0;
			$this->isActif=0;
			$this->niveau= NULL;
			$this->nomAssurance=$nomAssurance;
		}
	}
	
	public function save (){
		try {
			require_once File::build_path(array('model','Model.php'));
			$statement = "INSERT INTO utilisateur (login , MotDePasse, isAdmin, isActif, nom, prenom, sexe, telephone,idQuartier, adresse, email, niveau, nomAssurance) 
					VALUES (:tag_login, :tag_mdp, :tag_admin, :tag_actif, :tag_nom, :tag_prenom, :tag_sexe, :tag_telephone,:tag_quartier, :tag_adresse, :tag_email, :tag_niveau, :tag_nomAssurance)";
			$req_prep = Model::$pdo->prepare($statement);
			$values = array(
				"tag_login"=> $this->login,
				"tag_mdp"=>$this->MotDePasse,
				"tag_admin"=>$this->isAdmin,
				"tag_actif"=>$this->isActif,
				"tag_nom"=>$this->nom,
				"tag_prenom"=>$this->prenom,
				"tag_sexe"=>$this->sexe,
				"tag_telephone"=>$this->telephone,
				"tag_quartier"=>$this->idQuartier,
				"tag_adresse"=>$this->adresse,
				"tag_email"=>$this->email,
				"tag_niveau"=>$this->niveau,
				"tag_nomAssurance"=>$this->nomAssurance
				);
			$req_prep->execute($values);
			$bdd = new Model();
			$this->set('idUser', $bdd::$pdo->lastInsertId());
		} catch (Exception $ex) {
            echo $ex->getMessage(); 
            die();
        }
	}
	
	public static function getUtilByLogin($login){
		$sql= "SELECT * FROM utilisateur WHERE login=:log_tag";
		$bdd = new Model();
		$req_prep = $bdd::$pdo->prepare($sql);
		$values = array("log_tag" => $login);
		$req_prep->execute($values);
		$req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelUtilisateur');
		$tab_util = $req_prep->fetchAll();
		if (empty($tab_util)){
				 return false;
			 }
		else{
			return $tab_util[0];
		}
	}
	
	public static function checkPassword($login,$mdp){
		require_once File::build_path(array('model','Model.php'));
		$sql="SELECT * FROM utilisateur WHERE login=:log_tag AND MotDePasse=:mdp_tag AND isActif=1";
		$req_prep = Model::$pdo->prepare($sql);
		$values = array(
		   "log_tag" => $login,
		   "mdp_tag" => $mdp
		  );
		$req_prep->execute($values);
		$req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelUtilisateur');
		$tab_util = $req_prep->fetchAll();
		if(empty($tab_util)){
			return false;
		}else{
			return true;
		}
	}
	
	public static function isAdmin($login){
        require_once File::build_path(array('model','Model.php'));
		$sql="SELECT * FROM utilisateur WHERE login=:log_tag AND isAdmin=1";
		$req_prep=Model::$pdo->prepare($sql);
		$values = array(
		   "log_tag" => $login
		);
		$req_prep->execute($values);
		$req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelUtilisateur');
		$tab_util = $req_prep->fetchAll();
		if (empty($tab_util)){
			return false;
		}
			else{
			return true;
		}
	}
	
	public static function getIdByLogin($login){
		$sql= "SELECT idUser FROM utilisateur WHERE login=:log_tag";
		$bdd = new Model();
		$req_prep = $bdd::$pdo->prepare($sql);
		$values = array("log_tag" => $login);
		$req_prep->execute($values);
		$req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelUtilisateur');
		$tab_util = $req_prep->fetchAll();
		if (empty($tab_util)){
				 return false;
			 }
		else{
			return $tab_util[0];
		}
	}
	
	public static function getUtilById($id){
		$sql= "SELECT * FROM utilisateur WHERE idUser=:tag_id";
		$bdd = new Model();
		$req_prep = $bdd::$pdo->prepare($sql);
		$values = array("tag_id" => $id);
		$req_prep->execute($values);
		$req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelUtilisateur');
		$tab_util = $req_prep->fetchAll();
		if (empty($tab_util)){
				 return false;
			 }
		else{
			return $tab_util[0];
		}		
	}
	
	public static function getUserByEmail($email){
		$sql= "SELECT * FROM utilisateur WHERE email=:tag_email";
		$bdd = new Model();
		$req_prep = $bdd::$pdo->prepare($sql);
		$values = array("tag_email" => $email);
		$req_prep->execute($values);
		$req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelUtilisateur');
		$tab_util = $req_prep->fetchAll();
		if (empty($tab_util)){
				 return false;
			 }
		else{
			return $tab_util[0];
		}		
	}
	
	public static function verifEmail($email){
		$sql= "SELECT * FROM utilisateur WHERE email=:tag_email";
		$bdd = new Model();
		$req_prep = $bdd::$pdo->prepare($sql);
		$values = array("tag_email" => $email);
		$req_prep->execute($values);
		$req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelUtilisateur');
		$tab_util = $req_prep->fetchAll();
		return $tab_util;	
	}
	
	public static function verifEmailLogin($email,$login){
		$sql= "SELECT * FROM utilisateur WHERE email=:tag_email AND login=:tag_login";
		$bdd = new Model();
		$req_prep = $bdd::$pdo->prepare($sql);
		$values = array("tag_email" => $email,"tag_login"=>$login);
		$req_prep->execute($values);
		$req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelUtilisateur');
		$tab_util = $req_prep->fetchAll();
		return $tab_util;	
	}
	
	public static function getUserByIdO($idObjet){
		$sql="SELECT * FROM utilisateur U JOIN demande D ON U.idUser=D.idUser JOIN objet O ON D.idObjet=O.idObjet WHERE O.idObjet=:tag_id";
		$bdd = new Model();
		$req_prep = $bdd::$pdo->prepare($sql);
		$values = array("tag_id" => $idObjet);
		$req_prep->execute($values);
		$req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelUtilisateur');
		$tab_util = $req_prep->fetchAll();
		if (empty($tab_util)){
			return false;
			 }
		else{
			return $tab_util[0];
		}	
	}
	
	public static function getUserById($idObjet){
		$sql="SELECT * FROM utilisateur U JOIN offre Of ON U.idUser=Of.idUser JOIN objet O ON Of.idObjet=O.idObjet WHERE O.idObjet=:tag_id";
		$bdd = new Model();
		$req_prep = $bdd::$pdo->prepare($sql);
		$values = array("tag_id" => $idObjet);
		$req_prep->execute($values);
		$req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelUtilisateur');
		$tab_util = $req_prep->fetchAll();
		if (empty($tab_util)){
			return false;
			 }
		else{
			return $tab_util[0];
		}	
	}
	
	public static function verifUser($idUser){
		$sql= "SELECT * FROM utilisateur WHERE idUser=:log_tag";
		$bdd = new Model();
		$req_prep = $bdd::$pdo->prepare($sql);
		$values = array("log_tag" => $idUser);
		$req_prep->execute($values);
		$req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelUtilisateur');
		$tab_util = $req_prep->fetchAll();
		if (empty($tab_util)){
				 return false;
			 }
		else{
			return $tab_util[0];
		}
	}
	
	public static function modified($login,$nom,$prenom,$sexe,$telephone,$quartier,$adresse,$nomAssurance){
		$sql="UPDATE utilisateur SET nom=:tag_nom,prenom=:tag_prenom,sexe=:tag_sexe,telephone=:tag_telephone,idQuartier=:tag_quartier,adresse=:tag_adresse,nomAssurance=:tag_nomAssurance WHERE login=:tag_login";
        $bdd = new Model();
        $req_prep = $bdd::$pdo->prepare($sql);
		$values=array("tag_login"=> $login,
				"tag_nom"=>$nom,
				"tag_prenom"=>$prenom,
				"tag_sexe"=>$sexe,
				"tag_telephone"=>$telephone,
				"tag_quartier"=>$quartier,
				"tag_adresse"=>$adresse,
				"tag_nomAssurance"=>$nomAssurance);
		$req_prep->execute($values);
	}
	
	public static function modifiedEmail($login,$email){
		$sql="UPDATE utilisateur SET email=:tag_email WHERE login=:tag_login";
		$bdd = new Model();
        $req_prep = $bdd::$pdo->prepare($sql);
		$values=array("tag_email"=>$email,"tag_login"=>$login);
		$req_prep->execute($values);
	}
	
	public static function modifiedMdp($mdp,$login){
		$sql="UPDATE utilisateur SET MotDePasse=:tag_mdp WHERE login=:tag_login";
		$bdd = new Model();
        $req_prep = $bdd::$pdo->prepare($sql);
		$values=array("tag_login"=> $login,
		"tag_mdp"=>$mdp);
		$req_prep->execute($values);
	}
	
	public static function getDemandesAdhesions(){
		$sql="SELECT DISTINCT U.idUser,nom, nomQuartier AS quartier, prenom,email,telephone,nomAssurance FROM utilisateur U JOIN quartier Q ON U.idQuartier=Q.idQuartier WHERE isActif=0";
		$bdd = new Model();
		$req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute();
        $tab_nom = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_nom;	
	}
	
	public static function getAdhesions(){
		$sql="SELECT login,idUser,nom,nomQuartier AS quartier, prenom,email,telephone,nomAssurance FROM utilisateur U JOIN quartier Q ON U.idQuartier=Q.idQuartier WHERE isActif=1";
		$bdd = new Model();
		$req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute();
        $tab_nom = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_nom;
	}
	
	public function confirmed(){
		$sql="UPDATE utilisateur SET isActif=1 WHERE idUser=:tag_id";
		$bdd = new Model();
		$req_prep = $bdd::$pdo->prepare($sql);
		$values=array("tag_id"=>$this->idUser);
		$req_prep->execute($values);
	}

	public function deleted(){
		$sql="DELETE FROM utilisateur WHERE idUser=:tag_id";
		$bdd = new Model();
		$req_prep = $bdd::$pdo->prepare($sql);
		$values=array("tag_id"=>$this->idUser);
		$req_prep->execute($values);
	}
	
	public static function getUserByIdOffre($idOffre){
		$sql="SELECT * FROM utilisateur U JOIN offre Of ON U.idUser=Of.idUser WHERE Of.idOffre=:tag_id";
		$bdd = new Model();
		$req_prep = $bdd::$pdo->prepare($sql);
		$values = array("tag_id" => $idOffre);
		$req_prep->execute($values);
		$req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelUtilisateur');
		$tab_util = $req_prep->fetchAll();
		if (empty($tab_util)){
			return false;
			 }
		else{
			return $tab_util[0];
		}	
	}
	
	
	public static function getUserByIdDemande($idDemande){
		$sql="SELECT * FROM utilisateur U JOIN demande D ON U.idUser=D.idUser WHERE D.idDemande=:tag_id";
		$bdd = new Model();
		$req_prep = $bdd::$pdo->prepare($sql);
		$values = array("tag_id" => $idDemande);
		$req_prep->execute($values);
		$req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelUtilisateur');
		$tab_util = $req_prep->fetchAll();
		if (empty($tab_util)){
			return false;
			 }
		else{
			return $tab_util[0];
		}	
	}
	
	
	public static function getAdmin(){
		$sql="SELECT * FROM utilisateur U WHERE isAdmin=1";
		$bdd = new Model();
		$req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute();
		$req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelUtilisateur');
		$tab_util = $req_prep->fetchAll();
		if (empty($tab_util)){
			return false;
			 }
		else{
			return $tab_util[0];
		}	
	}
	
	public static function getEmprunteurRefus($idObjet,$idOffre,$idPreteur){
		$sql="SELECT * FROM preechange E JOIN offre Of ON E.idOffre=Of.idOffre JOIN objet O ON O.idObjet=Of.idObjet JOIN utilisateur U ON E.idEmprunteur=U.idUser WHERE E.idPreteur=:tag_preteur AND E.idOffre=:tag_offre AND Of.idObjet=:tag_objet";
		$bdd = new Model();
		$values=array("tag_objet"=>$idObjet,"tag_offre"=>$idOffre,"tag_preteur"=>$idPreteur);
		$req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_refus = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_refus;
	}
	
	public static function getPreteurRefus($idObjet,$idDemande,$idEmprunteur){
		$sql="SELECT * FROM preechange E JOIN demande D ON E.idDemande=D.idDemande JOIN objet O ON O.idObjet=D.idObjet JOIN utilisateur U ON E.idPreteur=U.idUser WHERE E.idEmprunteur=:tag_emprunteur AND E.idDemande=:tag_demande AND D.idObjet=:tag_objet";
		$bdd = new Model();
		$values=array("tag_objet"=>$idObjet,"tag_demande"=>$idDemande,"tag_emprunteur"=>$idEmprunteur);
		$req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_refus = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_refus;
	}
	
	public static function getAllUser(){
		$sql="SELECT * FROM utilisateur WHERE isActif=1";
		$bdd = new Model();
		$req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute();
        $tab_user = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_user;
	}
	
	public static function getCommentOfUser($idUser){
		$sql="SELECT U1.login AS nomCommenteur, U2.login AS nomCommente, U2.niveau AS noteCommente, Commentaire		
		FROM commentaire C1 
		JOIN utilisateur U1 ON C1.idCommenteur=U1.idUser
		JOIN utilisateur U2 ON C1.idCommente=U2.idUser
		WHERE idCommente=:tag_id";
		$bdd = new Model();
		$values=array("tag_id"=>$idUser);
		$req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_comment = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_comment;
	}
	
	public static function getCommentOfEchange($idUser){
		$sql="SELECT U1.login AS nomCommenteur, U2.login AS nomCommente, Of.notation, Ob.nomObjet, Commentaire		
		FROM commentaire C1 
		JOIN utilisateur U1 ON C1.idCommenteur=U1.idUser
		JOIN echange E ON E.idOffre=C1.idOffre
		JOIN offre Of ON Of.idOffre=E.idOffre
		JOIN objet Ob ON Ob.idObjet=Of.idObjet
		JOIN utilisateur U2 ON U2.idUser=E.idPreteur
		WHERE U2.idUser=:tag_id
		UNION
		SELECT U1.login AS nomCommenteur, U2.login AS nomCommente,D.notation, Ob.nomObjet, Commentaire		
		FROM commentaire C1 
		JOIN utilisateur U1 ON C1.idCommenteur=U1.idUser
		JOIN echange E ON E.idDemande=C1.idDemande
		JOIN demande D ON D.idDemande=E.idDemande
		JOIN objet Ob ON Ob.idObjet=D.idObjet
		JOIN utilisateur U2 ON U2.idUser=E.idEmprunteur
		WHERE U2.idUser=:tag_id";
		$bdd = new Model();
		$values=array("tag_id"=>$idUser);
		$req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_comment = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_comment;
	}
	
	public static function getCommentByUser($idUser){
		$sql="SELECT U1.login AS nomCommenteur, U2.login AS nomCommente, U2.niveau AS noteCommente, Commentaire		
		FROM commentaire C1 
		JOIN utilisateur U1 ON C1.idCommenteur=U1.idUser
		JOIN utilisateur U2 ON C1.idCommente=U2.idUser
		WHERE idCommenteur=:tag_id";
		$bdd = new Model();
		$values=array("tag_id"=>$idUser);
		$req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_comment = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_comment;
	}
	
	public static function getCommentByEchange($idUser){
		$sql="SELECT U1.login AS nomCommenteur, U2.login AS nomCommente, Of.notation, Ob.nomObjet, Commentaire		
		FROM commentaire C1 
		JOIN utilisateur U1 ON C1.idCommenteur=U1.idUser
		JOIN echange E ON E.idOffre=C1.idOffre
		JOIN offre Of ON Of.idOffre=E.idOffre
		JOIN objet Ob ON Ob.idObjet=Of.idObjet
		JOIN utilisateur U2 ON U2.idUser=E.idPreteur
		WHERE C1.idCommenteur=:tag_id
		UNION
		SELECT U1.login AS nomCommenteur, U2.login AS nomCommente,D.notation, Ob.nomObjet, Commentaire		
		FROM commentaire C1 
		JOIN utilisateur U1 ON C1.idCommenteur=U1.idUser
		JOIN echange E ON E.idDemande=C1.idDemande
		JOIN demande D ON D.idDemande=E.idDemande
		JOIN objet Ob ON Ob.idObjet=D.idObjet
		JOIN utilisateur U2 ON U2.idUser=E.idEmprunteur
		WHERE C1.idCommenteur=:tag_id";
		$bdd = new Model();
		$values=array("tag_id"=>$idUser);
		$req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_comment = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_comment;
	}
	
	public static function getCommentDemarche(){
		$sql="SELECT login AS nomCommenteur, avisDemarche AS avis, noteDemarche AS note
		FROM commentaire C
		JOIN utilisateur U ON C.idCommenteur=U.idUser";
		$bdd = new Model();
		$req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute();
        $tab_comment = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_comment;
	}
	
	public static function getCommentUse(){
		$sql="SELECT login AS nomCommenteur, avisUse AS avis, noteUse AS note
		FROM commentaire C
		JOIN utilisateur U ON C.idCommenteur=U.idUser";
		$bdd = new Model();
		$req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute();
        $tab_comment = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_comment;
	}

	public static function getUtilAndQuartierById($id){
		$sql= "SELECT * FROM utilisateur U JOIN quartier Q ON U.idQuartier=Q.idQuartier WHERE idUser=:tag_id";
		$bdd = new Model();
		$req_prep = $bdd::$pdo->prepare($sql);
		$values = array("tag_id" => $id);
		$req_prep->execute($values);
		$req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelUtilisateur');
		$tab_util = $req_prep->fetchAll();
		if (empty($tab_util)){
				 return false;
			 }
		else{
			return $tab_util[0];
		}		
	}
}
	
	