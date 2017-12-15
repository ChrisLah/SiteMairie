<?php
	
require_once File::build_path(array('model','ModelCategorie.php'));

class ControllerCategorie{
	
	public static function afficher(){
		require_once File::build_path(array('model','ModelObjet.php'));
		require_once File::build_path(array('model','ModelOffre.php'));
		require_once File::build_path(array('model','ModelDemande.php'));
		$tab_c=ModelCategorie::getAllCategorie();
		
		$offreParPageO=5;
		$nombre_total_offre=ModelOffre::getNombreOffreC($_GET['idCategorie']);
		$nombre_total_offre=intval($nombre_total_offre);
		$nombreOffre=ceil($nombre_total_offre/$offreParPageO);
		if(isset($_GET['pageO'])){
			$pageOActuelle=intval($_GET['pageO']);
			if($pageOActuelle>$nombreOffre){
				$pageOActuelle=$nombreOffre;
			}
		}else{
			$pageOActuelle=1;
		}
		$premiereEntreeO=($pageOActuelle-1)*$offreParPageO;
		$tab_op=ModelOffre::getOffreOnlyCategorie($_GET['idCategorie'],$premiereEntreeO,$offreParPageO);
		
		$demandeParPageD=5;
		$nombre_total_demande=ModelDemande::getNombreDemandeC($_GET['idCategorie']);
		$nombre_total_demande=intval($nombre_total_demande);
		$nombreDemande=ceil($nombre_total_demande/$demandeParPageD);
		if(isset($_GET['pageD'])){
			$pageDActuelle=intval($_GET['pageD']);
			if($pageDActuelle>$nombreDemande){
				$pageDActuelle=$nombreDemande;
			}
		}else{
			$pageDActuelle=1;
		}
		$premiereEntreeD=($pageDActuelle-1)*$demandeParPageD;
		$tab_dp=ModelDemande::getDemandeOnlyCategorie($_GET['idCategorie'],$premiereEntreeD,$demandeParPageD);
		
		$_SESSION['active']=7;
		$controller="categorie";
		$view="listC";
		$pagetitle="Liste des objets de cette catégorie";
		require_once File::build_path(array('view','view.php'));
	}
	
	public static function listecategorie(){
		if(isset($_SESSION['admin'])){
			$_SESSION['active']=7;
			$tab_info=ModelCategorie::getCategories();
			$controller="categorie";
			$view="liste_categorie";
			$pagetitle="Liste des catégories";
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
	
	public static function deleted(){
		if(isset($_SESSION['admin'])){
			$_SESSION['active']=7;
			$Categorie=ModelCategorie::getCategorieById($_GET['idCategorie']);
			$Categorie->deleted();
			$tab_info=ModelCategorie::getCategories();
			$controller="categorie";
			$view="liste_categorie";
			$pagetitle="Liste des catégories";
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
	
	public static function addCategorie(){
		if(isset($_SESSION['admin'])){
			$_SESSION['active']=7;
			$controller="categorie";
			$view="add_categorie";
			$pagetitle="Ajouter une catégorie";
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
	
	public static function created(){
		if(isset($_SESSION['admin'])){
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

			$newCategorie=new ModelCategorie(null,$_POST['nomCategorie'],$adresse);
			$newCategorie->save();
			$tab_info=ModelCategorie::getCategories();
			$_SESSION['active']=7;
			$controller="categorie";
			$view="liste_categorie";
			$pagetitle="Liste des catégories";
			require_once File::build_path(array('view','view.php'));
			
		}else{
			header('Location: ./index.php');
		}
	}
	
}