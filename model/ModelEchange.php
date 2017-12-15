<?php

require_once File::build_path(array('model', 'Model.php'));

class ModelEchange {
	
	private $idEchange;
	private $idOffre;
	private $idDemande;
	private $date_debutEchange;
	private $date_finEchange;
	private $isPrete;
	private $isRendu;
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
	public function __construct($idEchange= NULL, $date_debutEchange = NULL, $date_finEchange = NULL, $isPrete = NULL, $isRendu = NULL,$idOffre = NULL, $idDemande = NULL, $idEmprunteur = NULL, $idPreteur = NULL) {
		if (!is_null($idEchange)){
			$this->idEchange= $idEchange;
		}
		if (!is_null($date_debutEchange) && !is_null($isPrete) && !is_null($isRendu) && !is_null($idEmprunteur) && !is_null($idPreteur)){
			$this->idOffre=$idOffre;
			$this->idDemande=$idDemande;			
			$this->date_debutEchange = $date_debutEchange;
			$this->date_finEchange=$date_finEchange;
			$this->isPrete=$isPrete;
			$this->isRendu=$isRendu;
			$this->idEmprunteur=$idEmprunteur;
			$this->idPreteur=$idPreteur;
		}
	}
	
		public function save (){
		try {
			require_once File::build_path(array('model','Model.php'));
			$statement = "INSERT INTO echange (date_debutEchange , date_finEchange, isPrete, isRendu, idOffre, idDemande, idEmprunteur, idPreteur)
					VALUES (:tag_dateDE, :tag_dateFE, :tag_pret, :tag_rend,:tag_idoffre, :tag_iddemande,:tag_emprunt, :tag_preteur)";
			$req_prep = Model::$pdo->prepare($statement);
			$values = array(
				"tag_dateDE"=> $this->date_debutEchange,
				"tag_dateFE"=>$this->date_finEchange,
				"tag_pret"=>$this->isPrete,
				"tag_rend"=>$this->isRendu,
				"tag_emprunt"=>$this->idEmprunteur,
				"tag_preteur"=>$this->idPreteur,
				"tag_idoffre"=>$this->idOffre,
				"tag_iddemande"=>$this->idDemande
				);
			$req_prep->execute($values);
			$bdd = new Model();
			$this->set('idEchange', $bdd::$pdo->lastInsertId());
		} catch (Exception $ex) {
            echo $ex->getMessage(); 
            die();
        }
	}
	
	public function saveD (){
		try {
			require_once File::build_path(array('model','Model.php'));
			$statement = "INSERT INTO echange (date_debutEchange , date_finEchange, isPrete, isRendu, idOffre, idDemande, idEmprunteur, idPreteur)
					VALUES (:tag_dateDE, :tag_dateFE, :tag_pret, :tag_rend,:tag_idoffre, :tag_iddemande,:tag_emprunt, :tag_preteur) ON DUPLICATE KEY UPDATE idDemande=:tag_iddemande";
			$req_prep = Model::$pdo->prepare($statement);
			$values = array(
				"tag_dateDE"=> $this->date_debutEchange,
				"tag_dateFE"=>$this->date_finEchange,
				"tag_pret"=>$this->isPrete,
				"tag_rend"=>$this->isRendu,
				"tag_emprunt"=>$this->idEmprunteur,
				"tag_preteur"=>$this->idPreteur,
				"tag_idoffre"=>$this->idOffre,
				"tag_iddemande"=>$this->idDemande
				);
			$req_prep->execute($values);
			$bdd = new Model();
			$this->set('idEchange', $bdd::$pdo->lastInsertId());
		} catch (Exception $ex) {
            echo $ex->getMessage(); 
            die();
        }
	}
	
	public function saveO (){
		try {
			require_once File::build_path(array('model','Model.php'));
			$statement = "INSERT INTO echange (date_debutEchange , date_finEchange, isPrete, isRendu, idOffre, idDemande, idEmprunteur, idPreteur)
					VALUES (:tag_dateDE, :tag_dateFE, :tag_pret, :tag_rend,:tag_idoffre, :tag_iddemande,:tag_emprunt, :tag_preteur) ON DUPLICATE KEY UPDATE idOffre=:tag_idoffre";
			$req_prep = Model::$pdo->prepare($statement);
			$values = array(
				"tag_dateDE"=> $this->date_debutEchange,
				"tag_dateFE"=>$this->date_finEchange,
				"tag_pret"=>$this->isPrete,
				"tag_rend"=>$this->isRendu,
				"tag_emprunt"=>$this->idEmprunteur,
				"tag_preteur"=>$this->idPreteur,
				"tag_idoffre"=>$this->idOffre,
				"tag_iddemande"=>$this->idDemande
				);
			$req_prep->execute($values);
			$bdd = new Model();
			$this->set('idEchange', $bdd::$pdo->lastInsertId());
		} catch (Exception $ex) {
            echo $ex->getMessage(); 
            die();
        }
	}
	
	public static function getEchangesById($idUser){
		$sql= "SELECT * FROM utilisateur WHERE idUser=:log_tag";
		$bdd = new Model();
		$req_prep = $bdd::$pdo->prepare($sql);
		$values = array("log_tag" => $idUser);
		$req_prep->execute($values);
		$req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelUtilisateur');
		$tab_echange = $req_prep->fetchAll();
		if (empty($tab_echange)){
				 return false;
			 }
		else{
			return $tab_echange[0];
		}
	}
	
	public static function getEchangeById($idEchange,$date){
		$sql= "SELECT * FROM echange WHERE idEchange=:log_tag AND date_debutEchange=:tag_date";
		$bdd = new Model();
		$req_prep = $bdd::$pdo->prepare($sql);
		$values = array("log_tag" => $idEchange,":tag_date"=>$date);
		$req_prep->execute($values);
		$req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelEchange');
		$tab_echange = $req_prep->fetchAll();
		if (empty($tab_echange)){
				 return false;
			 }
		else{
			return $tab_echange[0];
		}
	}
	
	public static function getEchangeOffre($login){
		$sql="SELECT * FROM echange E JOIN utilisateur U ON E.idPreteur=U.idUser JOIN offre Of ON Of.idOffre=E.idOffre JOIN objet O ON O.idObjet=Of.idObjet JOIN categorie C ON C.idCategorie=O.idCategorie WHERE U.login=:tag_login AND E.idOffre!=NULL AND E.isPrete=1 AND E.isRendu=0 ORDER BY E.idEchange DESC";
		$bdd = new Model();
		$values=array("tag_login"=>$login);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
	}
	
	public static function getEchangeDemande($login){
		$sql="SELECT * FROM echange E JOIN utilisateur U ON E.idEmprunteur=U.idUser JOIN demande D ON D.idDemande=E.idDemande JOIN objet O ON O.idObjet=D.idObjet JOIN categorie C ON C.idCategorie=O.idCategorie WHERE U.login=:tag_login AND E.idDemande!=NULL AND E.isPrete=1 AND E.isRendu=0 ORDER BY E.idEchange DESC";
		$bdd = new Model();
		$values=array("tag_login"=>$login);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;		
	}
	
	public static function getEchangeFinies($id){
		$sql="SELECT *
		FROM echange E JOIN utilisateur U ON E.idPreteur=U.idUser JOIN offre Of ON Of.idUser=U.idUser JOIN objet O ON O.idObjet=Of.idObjet JOIN categorie C ON O.idCategorie=C.idCategorie 
		WHERE E.idEmprunteur=:tag_id AND U.idUser=:tag_id AND E.isPrete=1 AND E.isRendu=1
		UNION 
		SELECT * 
		FROM echange E JOIN utilisateur U ON E.idEmprunteur=U.idUser JOIN demande D ON D.idUser=U.idUser JOIN objet O ON O.idObjet=D.idObjet JOIN categorie C ON O.idCategorie=C.idCategorie 
		WHERE E.idPreteur=:tag_id AND U.idUser=:tag_id AND E.isPrete=1 AND E.isRendu=1";
		$bdd = new Model();
		$values=array("tag_id"=>$id);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
	}
	
	public static function mespropositions($id){
		$sql="SELECT * 
		FROM echange E JOIN utilisateur U ON E.idPreteur=U.idUser JOIN offre Of ON Of.idUser=U.idUser JOIN objet O ON O.idObjet=Of.idObjet JOIN categorie C ON O.idCategorie=C.idCategorie 
		WHERE E.idPreteur=:tag_id AND U.idUser=:tag_id AND E.isPrete=1 AND E.isRendu=0
		UNION 
		SELECT * 
		FROM echange E JOIN utilisateur U ON E.idEmprunteur=U.idUser JOIN demande D ON D.idUser=U.idUser JOIN objet O ON O.idObjet=D.idObjet JOIN categorie C ON O.idCategorie=C.idCategorie 
		WHERE E.idEmprunteur=:tag_id AND U.idUser=:tag_id AND E.isPrete=1 AND E.isRendu=0
		";
		$bdd = new Model();
		$values=array("tag_id"=>$id);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_echange = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_echange;	
	}
	
	public static function getPropositionsFinies($id){
		$sql="SELECT Ob.nomObjet,C.nomCategorie,Of.idUser,U.niveau,Ob.image, Ob.idObjet FROM echange E JOIN offre Of ON E.idPreteur=Of.idUser JOIN utilisateur U ON U.idUser=E.idPreteur JOIN objet Ob ON Ob.idObjet=Of.idObjet JOIN categorie C ON Ob.idCategorie=C.idCategorie WHERE E.isRendu=1 AND E.isPrete=1 AND E.idPreteur=:tag_id 
			UNION
			SELECT Ob.nomObjet,C.nomCategorie,D.idUser,U.niveau,Ob.image, Ob.idObjet FROM echange E JOIN demande D ON E.idPreteur=D.idUser JOIN utilisateur U ON U.idUser=E.idPreteur JOIN objet Ob ON Ob.idObjet=D.idObjet JOIN categorie C ON Ob.idCategorie=C.idCategorie WHERE E.isRendu=1 AND E.isPrete=1 AND E.idEmprunteur=:tag_id ";
		$bdd = new Model();
		$values=array("tag_id"=>$id);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_echange = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_echange;	
	}
	
	
	
	public static function getInfoEchange($idEmprunteur,$idPreteur,$idDemande){
		$sql="SELECT * FROM echange E JOIN demande D ON D.idDemande=E.idDemande WHERE E.idDemande=:tag_demande AND E.idEmprunteur=:tag_emprunteur AND E.idPreteur=:tag_preteur";
		$req_prep = Model::$pdo->prepare($sql);
		$values = array("tag_emprunteur"=>$idEmprunteur, "tag_preteur"=>$idPreteur,"tag_demande"=>$idDemande);
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
	
	public static function getEchangeEnCours($login){
		$sql="SELECT * FROM demande D 
			JOIN utilisateur U ON D.idUser=U.idUser 
			JOIN objet O ON O.idObjet=D.idObjet 
			JOIN categorie C ON C.idCategorie=O.idCategorie 
			JOIN echange E ON E.idDemande=D.idDemande 
			WHERE U.login=:tag_login AND D.isAccept=1 AND D.isRendu=0 
			AND D.isOnDemand=1 AND E.isPrete=1 AND E.isRendu=0 
			AND isOnEchange=1 
			UNION
			SELECT * FROM offre Of 
			JOIN utilisateur U ON Of.idUser=U.idUser 
			JOIN objet O ON O.idObjet=Of.idObjet 
			JOIN categorie C ON C.idCategorie=O.idCategorie 
			JOIN echange E ON E.idOffre=Of.idOffre 
			WHERE U.login=:tag_login AND Of.isAccept=1 AND Of.isDisponible=0 
			AND Of.isOnOffre=1 AND E.isPrete=1 AND E.isRendu=0 
			AND isOnEchange=1";
		$bdd = new Model();
		$values=array("tag_login"=>$login);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
	}
	
	public static function getEchangeOffreEnCoursByUser($login){
		$sql="SELECT * FROM echange E
			JOIN utilisateur U ON E.idPreteur=U.idUser
			WHERE login=:tag_login AND E.isPrete=1 AND E.isRendu=0 ";
		$bdd = new Model();
		$values=array("tag_login"=>$login);
		$req_prep = Model::$pdo->prepare($sql);
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
	
	public static function getEchangeDemandeEnCoursByUser($login){
		$sql="SELECT * FROM echange E
			JOIN utilisateur U ON E.idEmprunteur=U.idUser
			WHERE login=:tag_login AND E.isPrete=1 AND E.isRendu=0 ";

		$values=array("tag_login"=>$login);
		$req_prep = Model::$pdo->prepare($sql);
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
	
	public static function getEchangeFin($login){
		$sql="(SELECT * FROM demande D 
			JOIN utilisateur U ON D.idUser=U.idUser 
			JOIN objet O ON O.idObjet=D.idObjet 
			JOIN categorie C ON C.idCategorie=O.idCategorie 
			JOIN echange E ON E.idDemande=D.idDemande
			JOIN offre Of ON Of.idOffre=E.idOffre
			WHERE U.login=:tag_login AND D.isAccept=1 AND D.isRendu=1 
			AND D.isOnDemand=0 AND E.isPrete=1 AND E.isRendu=1 
			AND D.isOnEchange=0 ORDER BY Of.idOffre,D.idDemande DESC LIMIT 0,10000)
			UNION
			(SELECT * FROM offre Of 
			JOIN utilisateur U ON Of.idUser=U.idUser 
			JOIN objet O ON O.idObjet=Of.idObjet 
			JOIN categorie C ON C.idCategorie=O.idCategorie 
			JOIN echange E ON E.idOffre=Of.idOffre
			JOIN demande D ON D.idDemande=E.idDemande
			WHERE U.login=:tag_login AND Of.isAccept=1 AND Of.isDisponible=1
			AND Of.isOnOffre=0 AND E.isPrete=1 AND E.isRendu=1 
			AND Of.isOnEchange=0 ORDER BY Of.idOffre,D.idDemande DESC LIMIT 0,10000)";
		$bdd = new Model();
		$values=array("tag_login"=>$login);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
		
	}
	
	public static function getInfoDemandeEchange($idOffre,$idDemande,$date_debutEchange){
		$sql="SELECT * FROM demande D 
			JOIN echange E ON D.idDemande=E.idDemande
			WHERE E.idDemande=:tag_demande AND E.idOffre=:tag_offre AND E.date_debutEchange=:tag_date";
		$bdd = new Model();
		$values=array("tag_demande"=>$idDemande,"tag_offre"=>$idOffre,"tag_date"=>$date_debutEchange);
		$req_prep = Model::$pdo->prepare($sql);
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
	
	public static function getInfoOffreEchange($idOffre,$idDemande,$date_debutEchange){
		$sql="SELECT * FROM offre Of 
			JOIN echange E ON Of.idOffre=E.idOffre
			WHERE E.idDemande=:tag_demande AND E.idOffre=:tag_offre AND E.date_debutEchange=:tag_date";
		$req_prep = Model::$pdo->prepare($sql);
		$values=array("tag_demande"=>$idDemande,"tag_offre"=>$idOffre,"tag_date"=>$date_debutEchange);
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
	
	public static function getInfoEmprunteur($idOffre,$idDemande,$date_debutEchange){
		$sql="SELECT * FROM utilisateur U
			JOIN echange E ON U.idUser=E.idEmprunteur
			WHERE E.idDemande=:tag_demande AND E.idOffre=:tag_offre AND E.date_debutEchange=:tag_date";
		$bdd = new Model();
		$values=array("tag_demande"=>$idDemande,"tag_offre"=>$idOffre,"tag_date"=>$date_debutEchange);
		$req_prep = Model::$pdo->prepare($sql);
		$req_prep->execute($values);
        $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelUtilisateur');
        $user = $req_prep->fetchAll();
		if (empty($user)){
            return false;
        }
        else{
            return $user[0];
        }	
	}
	
	public static function getInfoPreteur($idOffre,$idDemande,$date_debutEchange){
		$sql="SELECT * FROM utilisateur U
			JOIN echange E ON U.idUser=E.idPreteur
			WHERE E.idDemande=:tag_demande AND E.idOffre=:tag_offre AND E.date_debutEchange=:tag_date";
		$values=array("tag_demande"=>$idDemande,"tag_offre"=>$idOffre,"tag_date"=>$date_debutEchange);
		$req_prep = Model::$pdo->prepare($sql);
		$req_prep->execute($values);
        $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelUtilisateur');
        $user = $req_prep->fetchAll();
		if (empty($user)){
            return false;
        }
        else{
            return $user[0];
        }	
	}
	
	public static function getInfoPreteurO($idOffre,$idDemande,$date_debutEchange){
		$sql="SELECT * FROM utilisateur U
			JOIN echange E ON U.idUser=E.idPreteur
			WHERE E.idDemande=:tag_demande AND E.idOffre=:tag_offre AND E.date_debutEchange=:tag_date";
		$values=array("tag_demande"=>$idDemande,"tag_offre"=>$idOffre,"tag_date"=>$date_debutEchange);
		$req_prep = Model::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
	}

	public static function getEchange($idOffre,$idDemande,$date_debutEchange){
		$sql="SELECT * FROM echange E
			WHERE E.idDemande=:tag_demande AND E.idOffre=:tag_offre AND E.date_debutEchange=:tag_date";
		$bdd = new Model();
		$values=array("tag_demande"=>$idDemande,"tag_offre"=>$idOffre,"tag_date"=>$date_debutEchange);
		$req_prep = Model::$pdo->prepare($sql);
		$req_prep->execute($values);
        $req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelEchange');
        $echange = $req_prep->fetchAll();
		if (empty($echange)){
            return false;
        }
        else{
            return $echange[0];
        }		
	}

	/*public static function getOffreDemandeAttente($login){
		$sql="SELECT * FROM demande D 
			JOIN utilisateur U ON D.idUser=U.idUser 
			JOIN objet O ON O.idObjet=D.idObjet 
			JOIN categorie C ON C.idCategorie=O.idCategorie 
			JOIN echange E ON E.idDemande=D.idDemande
			JOIN offre Of ON Of.idOffre=E.idOffre
			WHERE U.login=:tag_login AND D.isAccept=1 AND D.isRendu=0 
			AND D.isOnDemand=1 AND E.isPrete=1 AND E.isRendu=0 AND D.isEnAttente=1 AND Of.isEnAttente=0
			AND D.isOnEchange=1 
			UNION
			SELECT * FROM offre Of 
			JOIN utilisateur U ON Of.idUser=U.idUser 
			JOIN objet O ON O.idObjet=Of.idObjet 
			JOIN categorie C ON C.idCategorie=O.idCategorie 
			JOIN echange E ON E.idOffre=Of.idOffre
			JOIN demande D ON D.idDemande=E.idDemande
			WHERE U.login=:tag_login AND Of.isAccept=1 AND Of.isDisponible=0
			AND Of.isOnOffre=1 AND E.isPrete=1 AND E.isRendu=0 AND D.isEnAttente=0 AND Of.isEnAttente=1
			AND Of.isOnEchange=1";
		$bdd = new Model();
		$values=array("tag_login"=>$login);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_produit = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_produit;	
	}
	
	public function updateAttenteOffre(){
		$sql="UPDATE offre SET isEnAttente=1 WHERE idOffre=:tag_offre";
		$req_prep = Model::$pdo->prepare($sql);		
		$values = array("tag_offre"=>$this->idOffre);
		$req_prep->execute($values);
	}
	
	public function updateAttenteDemande(){
		$sql="UPDATE demande SET isEnAttente=1 WHERE idDemande=:tag_demande";
		$req_prep = Model::$pdo->prepare($sql);		
		$values = array("tag_demande"=>$this->idDemande);
		$req_prep->execute($values);
	}*/
	
	public function updateAllOffre(){
		$sql="UPDATE offre SET isOnOffre=0,isDisponible=1,isOnEchange=0 WHERE idOffre=:tag_offre";
		$req_prep = Model::$pdo->prepare($sql);		
		$values = array("tag_offre"=>$this->idOffre);
		$req_prep->execute($values);		
	}
	
	public function updateAllDemande(){
		$sql="UPDATE demande SET isOnDemand=0,isRendu=1,isOnEchange=0 WHERE idDemande=:tag_demande";
		$req_prep = Model::$pdo->prepare($sql);		
		$values = array("tag_demande"=>$this->idDemande);
		$req_prep->execute($values);		
	}
	
	public function updateEchange(){
		$sql="UPDATE echange SET isRendu=1 WHERE idDemande=:tag_demande AND idOffre=:tag_offre AND date_debutEchange=:tag_date";
		$req_prep = Model::$pdo->prepare($sql);		
		$values = array("tag_demande"=>$this->idDemande,"tag_offre"=>$this->idOffre,"tag_date"=>$this->date_debutEchange);
		$req_prep->execute($values);
	}
	
	public static function deletePreEchange($idDemande,$idOffre){
		$sql="DELETE FROM preechange WHERE idDemande=:tag_demande OR idOffre=:tag_offre";
		$req_prep = Model::$pdo->prepare($sql);		
		$values = array("tag_demande"=>$idDemande,"tag_offre"=>$idOffre);
		$req_prep->execute($values);
	}
	
	public static function addNoteUser($note,$idUser){
		$sql="UPDATE utilisateur SET niveau=:tag_note WHERE idUser=:tag_id";
		$req_prep = Model::$pdo->prepare($sql);		
		$values = array("tag_note"=>$note,"tag_id"=>$idUser);
		$req_prep->execute($values);
	}
	
	public static function addNoteOffre($note,$offre){
		$sql="UPDATE offre SET notation=:tag_note WHERE idOffre=:tag_id";
		$req_prep = Model::$pdo->prepare($sql);		
		$values = array("tag_note"=>$note,"tag_id"=>$offre);
		$req_prep->execute($values);
	}
	
	public static function addNoteDemande($note,$demande){
		$sql="UPDATE demande SET notation=:tag_note WHERE idDemande=:tag_id";
		$req_prep = Model::$pdo->prepare($sql);		
		$values = array("tag_note"=>$note,"tag_id"=>$demande);
		$req_prep->execute($values);
	}
	
	public static function addDateFin($idOffre,$idDemande,$dateD,$dateF){
		$sql="UPDATE echange SET date_finEchange=:tag_datefin WHERE idOffre=:tag_idoffre and idDemande=:tag_idDemande AND date_debutEchange=:tag_datedebut";
		$req_prep = Model::$pdo->prepare($sql);		
		$values = array("tag_idDemande"=>$idDemande,"tag_idoffre"=>$idOffre,"tag_datefin"=>$dateF,"tag_datedebut"=>$dateD);
		$req_prep->execute($values);	
	}
	
	public static function existDemande($idDemande){
		$sql="SELECT idDemande FROM demande WHERE idDemande=:tag_idDemande";
		$bdd = new Model();
		$values=array("tag_idDemande"=>$idDemande);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
		$req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelDemande');
        $demande = $req_prep->fetchAll();
		if(empty($demande)){
			return false;
		}else{
			return true;
		}
	}
	
	public static function existOffre($idOffre){
		$sql="SELECT idOffre FROM offre WHERE idOffre=:tag_idOffre";
		$bdd = new Model();
		$values=array("tag_idOffre"=>$idOffre);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
		$req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelOffre');
        $offre = $req_prep->fetchAll();
		if(empty($offre)){
			return false;
		}else{
			return true;
		}
	}
	
	public static function getDemandesEchange(){
		$sql="SELECT E.idOffre,E.idDemande,E.idEmprunteur,E.idPreteur,nomObjet,UE.nom AS nomEmprunteur, UO.nom AS nomPreteur, nomCategorie,UE.email AS emailEmprunteur, UO.email AS emailPreteur
		FROM preechange E 
		JOIN utilisateur UE ON UE.idUser=E.idEmprunteur 
		JOIN utilisateur UO ON UO.idUser=E.idPreteur 
		JOIN offre Of ON E.idOffre=Of.idOffre
		JOIN objet O ON O.idObjet=Of.idObjet
		JOIN categorie C ON C.idCategorie=O.idCategorie
		UNION
		SELECT  E.idOffre,E.idDemande,E.idEmprunteur,E.idPreteur,nomObjet,UE.nom AS nomEmprunteur, UO.nom AS nomPreteur, nomCategorie,UE.email AS emailEmprunteur, UO.email AS emailPreteur
		FROM preechange E 
		JOIN utilisateur UE ON UE.idUser=E.idEmprunteur 
		JOIN utilisateur UO ON UO.idUser=E.idPreteur 
		JOIN demande D ON E.idDemande=D.idDemande
		JOIN objet O ON O.idObjet=D.idObjet
		JOIN categorie C ON C.idCategorie=O.idCategorie";
		$bdd = new Model();
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute();
        $tab_echange = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_echange;	
	}
	
	public static function getEchangesCours(){
		$sql="SELECT E.idOffre,E.idDemande,E.idEchange,nomObjet,UE.nom AS nomEmprunteur, UO.nom AS nomPreteur, nomCategorie, date_debutEchange
		FROM echange E 
		JOIN utilisateur UE ON UE.idUser=E.idEmprunteur 
		JOIN utilisateur UO ON UO.idUser=E.idPreteur 
		JOIN offre Of ON E.idOffre=Of.idOffre
		JOIN objet O ON O.idObjet=Of.idObjet
		JOIN categorie C ON C.idCategorie=O.idCategorie
		WHERE E.isPrete=1 AND E.isRendu=0";
		$bdd = new Model();
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute();
        $tab_offre = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_offre;	
	}
	
	public static function getEchangesFins(){
		$sql="SELECT E.idEchange,nomObjet,UE.nom AS nomEmprunteur, UO.nom AS nomPreteur, nomCategorie, date_debutEchange, date_finEchange
		FROM echange E 
		JOIN utilisateur UE ON UE.idUser=E.idEmprunteur 
		JOIN utilisateur UO ON UO.idUser=E.idPreteur 
		JOIN offre Of ON E.idOffre=Of.idOffre
		JOIN objet O ON O.idObjet=Of.idObjet
		JOIN categorie C ON C.idCategorie=O.idCategorie
		WHERE E.isPrete=1 AND E.isRendu=1";
		$bdd = new Model();
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute();
        $tab_offre = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_offre;	
	}
	
	public static function verifNoted($idDemande,$idOffre,$date,$iddemandeur){
		$sql="SELECT idEchange FROM echange E
		JOIN commentaire C ON E.idOffre=C.idOffre
		WHERE E.idOffre=:tag_idoffre AND E.idDemande=:tag_idDemande AND date_debutEchange=:tag_date AND C.idCommenteur=:tag_demandeur AND C.idOffre=:tag_idoffre AND C.idDemande=:tag_idDemande ";
		$bdd = new Model();
        $req_prep = $bdd::$pdo->prepare($sql);
		$values=array("tag_idoffre"=>$idOffre,"tag_idDemande"=>$idDemande,"tag_date"=>$date,"tag_demandeur"=>$iddemandeur);
		$req_prep->execute($values);
		$req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelEchange');
        $echange = $req_prep->fetchAll();
		if(empty($echange)){
			return false;
		}else{
			return true;
		}
	}
	
	public function deleteEC(){
		$sql="DELETE FROM echange WHERE idDemande=:tag_demande AND idOffre=:tag_offre AND date_debutEchange=:tag_date";
		$req_prep = Model::$pdo->prepare($sql);		
		$values = array("tag_demande"=>$this->idDemande,"tag_offre"=>$this->idOffre,"tag_date"=>$this->date_debutEchange);
		$req_prep->execute($values);
	}
	
	public static function verifEchangeDemande($idObjet,$idUser){
		$sql="SELECT * FROM echange E JOIN demande D ON D.idDemande=E.idDemande WHERE D.idObjet=:tag_idObjet AND E.idEmprunteur=:tag_emprunt AND E.isPrete=1 AND E.isRendu=0";
		$bdd = new Model();
        $req_prep = $bdd::$pdo->prepare($sql);
		$values=array("tag_idObjet"=>$idObjet,"tag_emprunt"=>$idUser);
		$req_prep->execute($values);
		$req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelEchange');
        $echange = $req_prep->fetchAll();
		if(empty($echange)){
			return false;
		}else{
			return true;
		}
	}
	
	public static function verifEchangeOffre($idObjet,$idUser){
		$sql="SELECT * FROM echange E JOIN offre O ON O.idOffre=E.idOffre WHERE O.idObjet=:tag_idObjet AND E.idPreteur=:tag_pret AND E.isPrete=1 AND E.isRendu=0";
		$bdd = new Model();
        $req_prep = $bdd::$pdo->prepare($sql);
		$values=array("tag_idObjet"=>$idObjet,"tag_pret"=>$idUser);
		$req_prep->execute($values);
		$req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelEchange');
        $echange = $req_prep->fetchAll();
		if(empty($echange)){
			return false;
		}else{
			return true;
		}
	}
	
	public static function verifOffreDejaPropose($idObjet,$idUser){
		$sql="SELECT * FROM preechange E JOIN offre O ON O.idOffre=E.idOffre WHERE O.idObjet=:tag_idObjet AND E.idEmprunteur=:tag_emprunt";
		$bdd = new Model();
        $req_prep = $bdd::$pdo->prepare($sql);
		$values=array("tag_idObjet"=>$idObjet,"tag_emprunt"=>$idUser);
		$req_prep->execute($values);
		$req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelEchange');
        $echange = $req_prep->fetchAll();
		if(empty($echange)){
			return false;
		}else{
			return true;
		}
	}
	
	public static function verifDemandeDejaPropose($idObjet,$idUser){
		$sql="SELECT * FROM preechange E JOIN demande D ON D.idDemande=E.idDemande WHERE D.idObjet=:tag_idObjet AND E.idPreteur=:tag_pret";
		$bdd = new Model();
        $req_prep = $bdd::$pdo->prepare($sql);
		$values=array("tag_idObjet"=>$idObjet,"tag_pret"=>$idUser);
		$req_prep->execute($values);
		$req_prep->setFetchMode(PDO::FETCH_CLASS, 'ModelEchange');
        $echange = $req_prep->fetchAll();
		if(empty($echange)){
			return false;
		}else{
			return true;
		}
	}

}
	
	