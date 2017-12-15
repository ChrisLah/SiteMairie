<?php


require_once File::build_path(array("model", "Model.php"));


class ModelCommentaire{
	
	private $idDemande;
	private $idOffre;
	private $idCommenteur;
	private $idCommente;
	private $commentaire;	
	private $noteUse;
	private $avisUse;
	private $noteDemarche;
	private $avisDemarche;
	
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
	
	public function __construct($idOffre = NULL, $idDemande = NULL,  $idCommenteur = NULL , $idCommente = NULL, $commentaire = NULL, $noteUse = NULL, $avisUse = NULL,$noteDemarche = NULL, $avisDemarche = NULL) {
		if (!is_null($idCommenteur)){
			$this->idDemande = $idDemande;
			$this->idOffre=$idOffre;
			$this->idCommenteur=$idCommenteur;
			$this->idCommente=$idCommente;
			$this->commentaire=$commentaire;
			$this->avisUse=$avisUse;
			$this->avisDemarche=$avisDemarche;
			$this->noteUse=$noteUse;
			$this->noteDemarche=$noteDemarche;
		}
	}

	public function save (){
		try {
			require_once File::build_path(array('model','Model.php'));
			$statement = "INSERT INTO commentaire (idOffre,idDemande,idCommenteur,idCommente,Commentaire,noteUse, avisUse,noteDemarche, avisDemarche)
					VALUES (:tag_offre,:tag_demande,:tag_commenteur,:tag_commente,:tag_comment,:tag_nuse,:tag_use,:tag_ndemarche,:tag_demarche)";
			$req_prep = Model::$pdo->prepare($statement);
			$values = array(
				"tag_demande"=>$this->idDemande,
				"tag_offre"=>$this->idOffre,
				"tag_commenteur"=>$this->idCommenteur,
				"tag_commente"=>$this->idCommente,
				"tag_comment"=>$this->commentaire,
				"tag_nuse"=>$this->noteUse,
				"tag_use"=>$this->avisUse,
				"tag_ndemarche"=>$this->noteDemarche,
				"tag_demarche"=>$this->avisDemarche
				);
			$req_prep->execute($values);
		} catch (Exception $ex) {
            echo $ex->getMessage(); 
            die();
        }
	}
	
	public static function getCommentByDemande($objet){
		$sql="SELECT U.login,C.Commentaire,E.date_debutEchange FROM objet O JOIN demande D ON O.idObjet=D.idObjet JOIN commentaire C ON C.idDemande=D.idDemande JOIN utilisateur U ON U.idUser=D.idUser JOIN echange E ON E.idDemande=D.idDemande WHERE O.idObjet=:tag_objet ORDER BY date_debutEchange DESC";
		$bdd = new Model();
		$values=array("tag_objet"=>$objet);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_commentaire = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_commentaire;
	}
	
	public static function getCommentByOffre($objet){
		$sql="SELECT U.login,C.Commentaire,E.date_debutEchange FROM objet O JOIN offre Of ON O.idObjet=Of.idObjet JOIN commentaire C ON C.idOffre=Of.idOffre JOIN utilisateur U ON U.idUser=Of.idUser JOIN echange E ON E.idOffre=Of.idOffre WHERE O.idObjet=:tag_objet ORDER BY date_debutEchange DESC";
		$bdd = new Model();
		$values=array("tag_objet"=>$objet);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_commentaire = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_commentaire;
	}
	
	public static function getCommentByUser($idUser){
		$sql="SELECT U.login,C.Commentaire FROM utilisateur U JOIN commentaire C ON U.idUser=C.idCommenteur WHERE C.idCommente=:tag_id";
		$bdd = new Model();
		$values=array("tag_id"=>$idUser);
        $req_prep = $bdd::$pdo->prepare($sql);
		$req_prep->execute($values);
        $tab_commentaire = $req_prep->fetchAll(PDO::FETCH_OBJ);
        return $tab_commentaire;
	}
	
	public static function addCommentU($commentaire,$offre,$demande,$commenteur,$note){
		$sql="UPDATE commentaire SET avisUse=:tag_comment WHERE idOffre=:tag_offre AND idDemande=:tag_demande AND idCommenteur=:tag_commenteur AND noteUse=:tag_note";
		$bdd = new Model();
        $req_prep = $bdd::$pdo->prepare($sql);
		$values=array("tag_demande"=> $demande,
		"tag_offre"=>$offre,
		"tag_comment"=>$commentaire,
		"tag_commenteur"=>$commenteur,
		"tag_note"=>$note);
		$req_prep->execute($values);
	}
	
	public static function addCommentD($commentaire,$offre,$demande,$commenteur,$note){
		$sql="UPDATE commentaire SET avisDemarche=:tag_comment WHERE idOffre=:tag_offre AND idDemande=:tag_demande AND idCommenteur=:tag_commenteur AND noteDemarche=:tag_note";
		$bdd = new Model();
        $req_prep = $bdd::$pdo->prepare($sql);
		$values=array("tag_demande"=> $demande,
		"tag_offre"=>$offre,
		"tag_comment"=>$commentaire,
		"tag_commenteur"=>$commenteur,
		"tag_note"=>$note);
		$req_prep->execute($values);
	}
}
?>	