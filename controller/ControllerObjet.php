<?php
require_once File::build_path(array('model','ModelObjet.php'));// chargement du modèle

class ControllerObjet{
	


	public static function create(){
		$tab_p=ModelObjet::getOffreDispo();
		$tab_c=ModelCategorie::getAllCategorie();
		$_SESSION['active']=3;
        $controller='objet';
        $view='inscriptionO';
        $pagetitle="Inscription";
        require_once File::build_path(array('view','view.php'));
	}
	
	public static function created() {
		/*if(){ //verifier l'existant de login*/
			$adresse =null;
			$maxsize = 61440;
			$width= 350;
			$height = 350;
			$erreur = null;
			if ($_FILES['image']['error'] > 0) $erreur = "Erreur lors du transfert";
				
			if ($_FILES['image']['size'] > $maxsize) $erreur = "Le fichier est trop gros";
			
			$extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
			//1. strrchr renvoie l'extension avec le point (« . »).
			//2. substr(chaine,1) ignore le premier caractère de chaine.
			//3. strtolower met l'extension en minuscules.
			$extension_upload = strtolower(  substr(  strrchr($_FILES['image']['name'], '.')  ,1)  );
			
			if ($erreur == null){
				$nom = "./lib/image/";
				$resultat = move_uploaded_file($_FILES['image']['tmp_name'], './lib/image/'.$_FILES['image']['name'] );
					
				$nomImage = $_FILES['image']['name'];
					
				$adresse = "./lib/image/{$nomImage}";
			}
			if($adresse ==null){
				require_once File::build_path(array('model','ModelCategorie.php'));
				$Categorie=ModelCategorie::getCategorieById($_POST['idCategorie']);
				$adresse=$Categorie->get('image');
			}
			$newObjet = new ModelObjet(null,$_POST['nomObjet'],$adresse,$_POST['marque'],$_POST['description'],$_POST['idCategorie']);
			$newObjet->save();
			$_SESSION['idObjetI']=$newObjet->get('idObjet');
			$_SESSION['active']=3;
			$controller='offre';
			$view='inscriptionP';
			$pagetitle="Inscription";
			require_once File::build_path(array('view','view.php'));
			/*}
			else{
				$controller='utilisateur';
				$view='Error_Ins';
				$pagetitle="Erreur d'inscription";
				require_once File::build_path(array('view','view.php')); 
			}*/
		}
		
		
		public static function consultationO(){
			if (isset($_GET['idObjet'])){
				require_once File::build_path(array('model','ModelOffre.php'));
				require_once File::build_path(array('model','ModelUtilisateur.php'));
				require_once File::build_path(array('model','ModelCommentaire.php'));
				require_once File::build_path(array('model','ModelEchange.php'));
				$v = ModelObjet::getObjetOById($_GET['idObjet']);
				$o= ModelOffre::getOffreByIdO($_GET['idObjet']);
				$u=ModelUtilisateur::getUserById($_GET['idObjet']);
				if(isset($_SESSION['login'])){
					$User=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
					$tab_p=ModelOffre::getUserOnOffre($_GET['idObjet'],$User->get('idUser'));
					$verifOffre=ModelOffre::verifOffre($_GET['idObjet'],$User->get('idUser'));
					$verifEchange=ModelEchange::verifEchangeOffre($_GET['idObjet'],$User->get('idUser'));
					$verifDejaPropose=ModelEchange::verifOffreDejaPropose($_GET['idObjet'],$User->get('idUser'));
				}
				$tab_commentaire=ModelCommentaire::getCommentByOffre($_GET['idObjet']);
				$_SESSION['active']=1;
				$controller='objet';
				$view='detailO';
				$pagetitle ='Détails du produit';
				require_once File::build_path(array('view','view.php'));
			}
		}
		
		public static function consultationD(){
			if (isset($_GET['idObjet'])){
				require_once File::build_path(array('model','ModelDemande.php'));
				require_once File::build_path(array('model','ModelUtilisateur.php'));
				require_once File::build_path(array('model','ModelCommentaire.php'));
				require_once File::build_path(array('model','ModelEchange.php'));
				$v = ModelObjet::getObjetById($_GET['idObjet']);
				$d= ModelDemande::getDemandeByIdO($_GET['idObjet']);
				$u=ModelUtilisateur::getUserByIdO($_GET['idObjet']);	
				if(isset($_SESSION['login'])){
					$User=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
					$tab_p=ModelDemande::getUserOnDemand($_GET['idObjet'],$User->get('idUser'));
					$verifDemande=ModelDemande::verifDemande($_GET['idObjet'],$User->get('idUser'));
					$verifEchange=ModelEchange::verifEchangeDemande($_GET['idObjet'],$User->get('idUser'));
					$verifDejaPropose=ModelEchange::verifDemandeDejaPropose($_GET['idObjet'],$User->get('idUser'));
				}
				
				$tab_commentaire=ModelCommentaire::getCommentByDemande($_GET['idObjet']);
				$_SESSION['active']=2;
				$controller='objet';
				$view='detailD';
				$pagetitle ='Détails du produit';
				require_once File::build_path(array('view','view.php'));
			}
		}
		
		public static function listeobjet(){
			if(isset($_SESSION['admin'])){
				require_once File::build_path(array('model','ModelCategorie.php'));
				$tab_info=ModelCategorie::getObjetByCategorie($_GET['idCategorie']);
				$_SESSION['active']=7;
				$controller="objet";
				$view="liste_objet";
				$pagetitle="Liste des objets";
				require_once File::build_path(array('view','view.php'));
			}else{
				header('Location: ./index.php');
			}
		}
		
		public static function deleteDD(){
			if(isset($_SESSION['admin'])){
				require_once File::build_path(array('model','ModelCategorie.php'));
				$Objet=ModelObjet::getInfoObjet($_GET['idObjet']);
				$Objet->deleteDD();
				$tab_info=ModelCategorie::getObjetByCategorie($_GET['idCategorie']);
				$_SESSION['active']=7;
				$controller="objet";
				$view="liste_objet";
				$pagetitle="Liste des objets";
				require_once File::build_path(array('view','view.php'));
			}else{
				header('Location: ./index.php');
			}
		}
		
		public static function map(){

			//(1) On inclut la classe de Google Maps pour générer ensuite la carte.
			require_once File::build_path(array('lib','GoogleMapAPI.class.php'));

			//(2) On crée une nouvelle carte; Ici, notre carte sera $map.
			$map = new GoogleMapAPI('map');

			//(3) On ajoute la clef de Google Maps.
			$map->setAPIKey('AIzaSyCp8jdtW9aN-ABm5dt43EX4PHwwLst7Rw4');
				
			//(4) On ajoute les caractéristiques que l'on désire à notre carte.
			$map->setWidth("800px");
			$map->setHeight("500px");
			$map->setCenterCoords ('2', '48');
			$map->setZoomLevel (5);
			
			$controller="utilisateur";
			$view="consult_profil_byUser";
			$pagetitle="Map";
			require_once File::build_path(array('view','view.php'));
		}
}