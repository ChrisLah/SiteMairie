<?php
require_once File::build_path(array('model','ModelUtilisateur.php')); // chargement du modèle
require_once File::build_path(array('model','ModelObjet.php'));
require_once File::build_path(array('model','ModelOffre.php'));
require_once File::build_path(array('model','ModelDemande.php'));
require_once File::build_path(array('model','ModelCategorie.php'));

class ControllerAccueil {

    public static function afficher(){

		$_SESSION['active']=0;
        $controller = 'accueil';
        $view = 'accueil';
        $pagetitle = 'Accueil';
		$tab_op=ModelObjet::getProduitDerniereOffre();
		$tab_c=ModelCategorie::getAllCategorie();
		$tab_dp=ModelObjet::getProduitDerniereDemande();
        require_once File::build_path(array('view','view.php'));
    }

    public static function erreur(){
		$_SESSION['active']=0;
        $controller = 'accueil';
        $view = 'erreur';
        $pagetitle = "Error 404";
        require_once File::build_path(array('view','view.php'));
    }
	
	public static function aide(){
		$_SESSION['active']=5;
		$controller='accueil';
		$view='aide';
		$pagetitle="Aide";
		require_once File::build_path(array('view','view.php'));
	}
	
	public static function rechercheO(){
		if (($_POST['rechercheC1']==0)&&(empty($_POST['rechercheO']))&&(empty($_POST['rechercheV']))){
			$tab_c=ModelCategorie::getAllCategorie();
			$offreParPageO=10;
			$nombre_total_offre=ModelOffre::getNombreOffre();
			$nombre_total_offre=intval($nombre_total_offre['nombre']);
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
			$tab_op=ModelOffre::getOffresP($premiereEntreeO,$offreParPageO);
			$_SESSION['active']=1;
			$controller='offre';
			$view='listO';
			$pagetitle='RÃ©sultat des recherches';
			require_once File::build_path(array('view','view.php'));
		}else if(($_POST['rechercheC1']!=0)&&(empty($_POST['rechercheO']))&&(empty($_POST['rechercheV']))){
			$offreParPageO=10;
			$nombre_total_offre=ModelOffre::getNombreOffreC($_POST['rechercheC1']);
			$nombre_total_offre=intval($nombre_total_offre['nombre']);
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
			$tab_op=ModelOffre::getOffreOnlyCategorie($_POST['rechercheC1'],$premiereEntreeO,$offreParPageO);
			$tab_c=ModelCategorie::getAllCategorie();
			$_SESSION['active']=1;
			$controller='offre';
			$view='listO';
			$pagetitle='Résultat des recherches';
			require_once File::build_path(array('view','view.php'));
		}else if(($_POST['rechercheC1']!=0)&&(!empty($_POST['rechercheO']))&&(empty($_POST['rechercheV']))){
			$offreParPageO=10;
			$nombre_total_offre=ModelOffre::getNombreOffreCN($_POST['rechercheC1'],$_POST['rechercheO']);
			$nombre_total_offre=intval($nombre_total_offre['nombre']);
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
			$tab_op=ModelOffre::getOffreCategorieObjet($_POST['rechercheC1'],$_POST['rechercheO'],$premiereEntreeO,$offreParPageO);
			$tab_c=ModelCategorie::getAllCategorie();
			$_SESSION['active']=1;
			$controller='offre';
			$view='listO';
			$pagetitle='Résultat des recherches';
			require_once File::build_path(array('view','view.php'));
		}else if(($_POST['rechercheC1']!=0)&&(!empty($_POST['rechercheO']))&&(!empty($_POST['rechercheV']))){
			$offreParPageO=10;
			$nombre_total_offre=ModelOffre::getNombreOffreCNV($_POST['rechercheC1'],$_POST['rechercheO'],$_POST['rechercheV']);
			$nombre_total_offre=intval($nombre_total_offre['nombre']);
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
			$tab_op=ModelOffre::getOffreCategorieObjetVille($_POST['rechercheC1'],$_POST['rechercheO'],$_POST['rechercheV'],$premiereEntreeO,$offreParPageO);
			$tab_c=ModelCategorie::getAllCategorie();
			$_SESSION['active']=1;
			$controller='offre';
			$view='listO';
			$pagetitle='Résultat des recherches';
			require_once File::build_path(array('view','view.php'));
		}else if(($_POST['rechercheC1']==0)&&(!empty($_POST['rechercheO']))&&(empty($_POST['rechercheV']))){ 
			$offreParPageO=10;
			$nombre_total_offre=ModelOffre::getNombreOffreO($_POST['rechercheO']);
			$nombre_total_offre=intval($nombre_total_offre['nombre']);
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
			$tab_op=ModelOffre::getOffreOnlyObjet($_POST['rechercheO'],$premiereEntreeO,$offreParPageO);
			$tab_c=ModelCategorie::getAllCategorie();
			$_SESSION['active']=1;
			$controller='offre';
			$view='listO';
			$pagetitle='Résultat des recherches';
			require_once File::build_path(array('view','view.php'));
		}
		else if(($_POST['rechercheC1']==0)&&(empty($_POST['rechercheO']))&&(!empty($_POST['rechercheV']))){ 
			$offreParPageO=10;
			$nombre_total_offre=ModelOffre::getNombreOffreV($_POST['rechercheV']);
			$nombre_total_offre=intval($nombre_total_offre['nombre']);
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
			$tab_op=ModelOffre::getOffreOnlyVille($_POST['rechercheV'],$premiereEntreeO,$offreParPageO);
			$tab_c=ModelCategorie::getAllCategorie();
			$_SESSION['active']=1;
			$controller='offre';
			$view='listO';
			$pagetitle='Résultat des recherches';
			require_once File::build_path(array('view','view.php'));
		}
		else if(($_POST['rechercheC1']!=0)&&(empty($_POST['rechercheO']))&&(!empty($_POST['rechercheV']))){ 
			$offreParPageO=10;
			$nombre_total_offre=ModelOffre::getNombreOffreCV($_POST['rechercheC1'],$_POST['rechercheV']);
			$nombre_total_offre=intval($nombre_total_offre['nombre']);
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
			$tab_op=ModelOffre::getOffreCategorieVille($_POST['rechercheC1'],$_POST['rechercheV'],$premiereEntreeO,$offreParPageO);
			$tab_c=ModelCategorie::getAllCategorie();
			$_SESSION['active']=1;
			$controller='offre';
			$view='listO';
			$pagetitle='Résultat des recherches';
			require_once File::build_path(array('view','view.php'));
		}
		else if(($_POST['rechercheC1']==0)&&(!empty($_POST['rechercheO']))&&(!empty($_POST['rechercheV']))){ 
			$offreParPageO=10;
			$nombre_total_offre=ModelOffre::getNombreOffreOV($_POST['rechercheO'],$_POST['rechercheV']);
			$nombre_total_offre=intval($nombre_total_offre['nombre']);
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
			$tab_op=ModelOffre::getOffreObjetVille($_POST['rechercheO'],$_POST['rechercheV'],$premiereEntreeO,$offreParPageO);
			$tab_c=ModelCategorie::getAllCategorie();
			$_SESSION['active']=1;
			$controller='offre';
			$view='listO';
			$pagetitle='Résultat des recherches';
			require_once File::build_path(array('view','view.php'));
		}
	}
	
	
	
	public static function rechercheD(){
		if (($_POST['rechercheC2']==0)&&(empty($_POST['rechercheO2']))&&(empty($_POST['rechercheV2']))){
			$tab_c=ModelCategorie::getAllCategorie();
			$demandeParPageD=10;
			$nombre_total_demande=ModelDemande::getNombreDemande();
			$nombre_total_demande=intval($nombre_total_demande['nombre']);
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
			$tab_op=ModelDemande::getDemandesP($premiereEntreeD,$demandeParPageD);
			$_SESSION['active']=2;
			$controller='demande';
			$view='listD';
			$pagetitle='Résultat des recherches';
			require_once File::build_path(array('view','view.php'));
		}else if(($_POST['rechercheC2']!=0)&&(empty($_POST['rechercheO2']))&&(empty($_POST['rechercheV2']))){
			$demandeParPageD=10;
			$nombre_total_demande=ModelDemande::getNombreDemandeC($_POST['rechercheC2']);
			$nombre_total_demande=intval($nombre_total_demande['nombre']);
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
			$tab_op=ModelDemande::getDemandeOnlyCategorie($_POST['rechercheC2'],$premiereEntreeD,$demandeParPageD);
			$tab_c=ModelCategorie::getAllCategorie();
			$_SESSION['active']=2;
			$controller='demande';
			$view='listD';
			$pagetitle='Résultat des recherches';
			require_once File::build_path(array('view','view.php'));
		}else if(($_POST['rechercheC2']!=0)&&(!empty($_POST['rechercheO2']))&&(empty($_POST['rechercheV2']))){
			$demandeParPageD=10;
			$nombre_total_demande=ModelDemande::getNombreDemandeCN($_POST['rechercheC2'],$_POST['rechercheO2']);
			$nombre_total_demande=intval($nombre_total_demande['nombre']);
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
			$tab_op=ModelDemande::getDemandeCategorieObjet($_POST['rechercheC2'],$_POST['rechercheO2'],$premiereEntreeD,$demandeParPageD);
			$tab_c=ModelCategorie::getAllCategorie();
			$_SESSION['active']=2;
			$controller='demande';
			$view='listD';
			$pagetitle='Résultat des recherches';
			require_once File::build_path(array('view','view.php'));
		}else if(($_POST['rechercheC2']!=0)&&(!empty($_POST['rechercheO2']))&&(!empty($_POST['rechercheV2']))){
			$demandeParPageD=10;
			$nombre_total_demande=ModelDemande::getNombreDemandeCNV($_POST['rechercheC2'],$_POST['rechercheO2'],$_POST['rechercheV2']);
			$nombre_total_demande=intval($nombre_total_demande['nombre']);
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
			$tab_op=ModelDemande::getDemandeCategorieObjetVille($_POST['rechercheC2'],$_POST['rechercheO2'],$_POST['rechercheV2'],$premiereEntreeD,$demandeParPageD);
			$tab_c=ModelCategorie::getAllCategorie();
			$_SESSION['active']=2;
			$controller='demande';
			$view='listD';
			$pagetitle='Résultat des recherches';
			require_once File::build_path(array('view','view.php'));
		}else if(($_POST['rechercheC2']==0)&&(!empty($_POST['rechercheO2']))&&(empty($_POST['rechercheV2']))){ 
			$demandeParPageD=10;
			$nombre_total_demande=ModelDemande::getNombreDemandeO($_POST['rechercheO2']);
			$nombre_total_demande=intval($nombre_total_demande['nombre']);
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
			$tab_op=ModelDemande::getDemandeOnlyObjet($_POST['rechercheO2'],$premiereEntreeD,$demandeParPageD);
			$tab_c=ModelCategorie::getAllCategorie();
			$_SESSION['active']=2;
			$controller='demande';
			$view='listD';
			$pagetitle='Résultat des recherches';
			require_once File::build_path(array('view','view.php'));
		}
		else if(($_POST['rechercheC2']==0)&&(empty($_POST['rechercheO2']))&&(!empty($_POST['rechercheV2']))){ 
			$demandeParPageD=10;
			$nombre_total_demande=ModelDemande::getNombreDemandeV($_POST['rechercheV2']);
			$nombre_total_demande=intval($nombre_total_demande['nombre']);
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
			$tab_op=ModelDemande::getDemandeOnlyVille($_POST['rechercheV2'],$premiereEntreeD,$demandeParPageD);
			$tab_c=ModelCategorie::getAllCategorie();
			$_SESSION['active']=2;
			$controller='demande';
			$view='listD';
			$pagetitle='Résultat des recherches';
			require_once File::build_path(array('view','view.php'));
		}
		else if(($_POST['rechercheC2']!=0)&&(empty($_POST['rechercheO2']))&&(!empty($_POST['rechercheV2']))){ 
			$demandeParPageD=10;
			$nombre_total_demande=ModelDemande::getNombreDemandeCV($_POST['rechercheC2'],$_POST['rechercheV2']);
			$nombre_total_demande=intval($nombre_total_demande['nombre']);
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
			$tab_op=ModelDemande::getDemandeCategorieVille($_POST['rechercheC2'],$_POST['rechercheV2'],$premiereEntreeD,$demandeParPageD);
			$tab_c=ModelCategorie::getAllCategorie();
			$_SESSION['active']=2;
			$controller='demande';
			$view='listD';
			$pagetitle='Résultat des recherches';
			require_once File::build_path(array('view','view.php'));
		}
		else if(($_POST['rechercheC2']==0)&&(!empty($_POST['rechercheO2']))&&(!empty($_POST['rechercheV2']))){ 
			$demandeParPageD=10;
			$nombre_total_demande=ModelDemande::getNombreDemandeOV($_POST['rechercheO2'],$_POST['rechercheV2']);
			$nombre_total_demande=intval($nombre_total_demande['nombre']);
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
			$tab_op=ModelDemande::getDemandeObjetVille($_POST['rechercheO2'],$_POST['rechercheV2'],$premiereEntreeD,$demandeParPageD);
			$tab_c=ModelCategorie::getAllCategorie();
			$_SESSION['active']=2;
			$controller='demande';
			$view='listD';
			$pagetitle='Résultat des recherches';
			require_once File::build_path(array('view','view.php'));
		}
	}
	
	public static function requete(){
		if(isset($_SESSION['login'])){
			$_SESSION['active']=5;
			$controller='accueil';
			$view='form_contact';
			$pagetitle='Contactez un admin !';
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
	
	public static function contacted(){
		if(isset($_SESSION['login'])){
			$user=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
			$admin=ModelUtilisateur::getAdmin();
			
			$destinataire=$admin->get('email');
			
			$sujet='Requete de '.$user->get('login').'';
			$header=$_POST['objet'];
		
			$message=$_POST['message'];

			if((!empty($message)) && (mail($destinataire,$sujet,$message,$header))){
				$_SESSION['Form_succes']=1;
				$tab_op=ModelObjet::getProduitDerniereOffre();
				$tab_c=ModelCategorie::getAllCategorie();
				$tab_dp=ModelObjet::getProduitDerniereDemande();
				$_SESSION['active']=0;
				$controller='accueil';
				$view='accueil';
				$pagetitle='Accueil';
				require_once File::build_path(array('view','view.php'));
			}else{
				$_SESSION['Form_failed']=1;
				$_SESSION['active']=0;
				$controller='accueil';
				$view='form_contact';
				$pagetitle='Contactez un admin !';
				require_once File::build_path(array('view','view.php'));
			}
		}else{
			header('Location: ./index.php');
		}
	}
}
?>
