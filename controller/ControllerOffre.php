<?php
require_once File::build_path(array('model','ModelOffre.php'));// chargement du mod�le

class ControllerOffre{
	
	public static function created() {
		if(isset($_POST['certifier'])==1){

			date_default_timezone_set('UTC');
			if($_POST['dateDebut'] == null){
				$date = date("Y-m-d H:i:s");
			}else{
				$date=$_POST['dateDebut'];
			}
			$user=$_SESSION['idUserI'];
			$objet=$_SESSION['idObjetI'];
			if($_POST['dateFin'] == null){
				$dateF='2000-01-01 00:00:00';
			}else{
				$dateF=$_POST['dateFin'];
			}
			$newOffre = new ModelOffre(null,$date,$dateF,0,1,0,0,null,$user,$objet);
			$newOffre->save();
			if(isset($_POST['finish'])){
				$_SESSION['active']=3;
				$controller='accueil';
				$view='Confirm_Ins';
				$pagetitle="Inscription";
				require_once File::build_path(array('view','view.php'));
			}else{
				require_once File::build_path(array('model','ModelCategorie.php'));
				$tab_c=ModelCategorie::getAllCategorie();
				$_SESSION['active']=3;
				$controller='objet';
				$view='inscriptionO';
				$pagetitle="Inscription";
				require_once File::build_path(array('view','view.php'));
			}	
		}else{
			$_SESSION['certificat']=1;
			$controller='offre';
			$view='inscriptionP';
			$pagetitle="Inscription";
			require_once File::build_path(array('view','view.php'));
		}
		/*}
		else{
			$controller='utilisateur';
			$view='Error_Ins';
				$pagetitle="Erreur d'inscription";
				require_once File::build_path(array('view','view.php')); 
			}*/
		}
		
	public static function propose(){
		if (isset($_SESSION['login'])){
			require_once File::build_path(array('model','ModelCategorie.php'));
			$tab_c=ModelCategorie::getAllCategorie();
			$_SESSION['active']=7;
			$controller='offre';
			$view='propose';
			$pagetitle="Proposez une offre";
			require_once File::build_path(array('view','view.php'));
		}else{
			require_once File::build_path(array('model','ModelCategorie.php'));
			$tab_c=ModelCategorie::getAllCategorie();
			$_SESSION['active']=4;
			$controller='utilisateur';
			$view='connexion';
			$pagetitle='Se connecter';
			require_once File::build_path(array('view','view.php'));
		}
	}
	
	public static function proposed(){
		if (isset($_SESSION['login'])){
			require_once File::build_path(array('model','ModelObjet.php'));
			require_once File::build_path(array('model','ModelUtilisateur.php'));
			$User=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
			$idUser= $User->get('idUser');
			date_default_timezone_set('UTC');
			if($_POST['dateDebut'] == null){
				$date = date("Y-m-d H:i:s");
			}else{
				$date=$_POST['dateDebut'];
			}
			if($_POST['dateFin'] == null){
				$dateF='2000-01-01 00:00:00';
			}else{
				$dateF=$_POST['dateFin'];
			}
			
			$adresse =null;
			$maxsize = 61440;
			$width= 350;
			$height = 350;
			$erreur = null;
			if ($_FILES['image']['error'] > 0) $erreur = "Erreur lors du transfert";
					
			if ($_FILES['image']['size'] > $maxsize) $erreur = "Le fichier est trop gros";
				
			$extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
			//1. strrchr renvoie l'extension avec le point (� . �).
			//2. substr(chaine,1) ignore le premier caract�re de chaine.
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
			$idObjet=$newObjet->get('idObjet');
			$newOffre = new ModelOffre(null,$date,$dateF,0,1,0,0,null,$idUser,$idObjet);
			$newOffre->save();
			if(isset($_SESSION['admin'])){
				$newOffre->confirmed();
				$tab_info=ModelOffre::getOffres();
				$_SESSION['active']=7;
				$controller="offre";
				$view="liste_offres";
				$pagetitle="Liste des demandes d'offres";
				require_once File::build_path(array('view','view.php'));
			}else{
				$_SESSION['active']=0;
				$controller='offre';
				$view='conf_propose';
				$pagetitle="Proposition confirmée";
				require_once File::build_path(array('view','view.php'));
			}
		}else{
			require_once File::build_path(array('model','ModelCategorie.php'));
			$tab_c=ModelCategorie::getAllCategorie();
			$_SESSION['active']=4;
			$controller='utilisateur';
			$view='connexion';
			$pagetitle='Se connecter';
			require_once File::build_path(array('view','view.php'));
		}
	}
	
	
	
		public static function demandeO(){
		if (isset($_SESSION['login'])){
			require_once File::build_path(array('model','ModelUtilisateur.php'));
			require_once File::build_path(array('model','ModelObjet.php'));
			require_once File::build_path(array('model','ModelEchange.php'));
			require_once File::build_path(array('model','ModelPreEchange.php'));	
			$Emprunteur=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
			$Preteur=ModelUtilisateur::getUtilById($_GET['idPreteur']);
			$Objet=ModelObjet::getObjetByIdd($_GET['idObjet']);
			$Offre=ModelOffre::getOffreById($_GET['idOffre']);
			
			$destinatairee=$Emprunteur->get('email');
			
			$sujett='Demande envoyée';
			$headerr="Demande envoyée à".$Preteur->get('login');
			
		/*	$message=" Merci de nous avoir fais confiance,
			
			Voici les coordonn�es de la personne � qui vous voulez prêter le bien :".$Objet->get('nom')."
			
			Num�ro :".$Preteur->get('idUser')."
			Nom :".$Preteur->get('nom')."
			Prenom :".$Preteur->get('prenom')."
			Adresse :".$Preteur->get('adresse')."        ".$Preteur->get('codePostal')."             ".$Preteur->get('ville')."
			Mail :".$Preteur->get('email')."
			Telephone :".$Preteur->get('telephone')."
			
			
			Veuillez le contacter afin de proc�der � l'�change.
			
			Cordialement,
			
			(Merci de ne pas r�pondre � ce mail automatique)";*/
			
			$messagee="Bonjour,Bonsoir,
			
			Merci de votre confiance.
			Une demande a bien été envoyée à l'offre de ".$Objet->get('nomObjet').". Dorénavant, il vous suffit de patienter pour que le prêteur sélectionne votre demande !
			
			Cordialement,
			
			(Merci de ne pas répondre à ce mail automatique)";
			
			$destinataire=$Preteur->get('email');
			
			$sujet="Reception de demande";
			$header="Demande reçue de ".$Emprunteur->get('login');
			
			$message="Bonjour, Bonsoir,
			
			Une personne est interessée vient de répondre à votre offre par rapport à l'objet ".$Objet->get('nomObjet')." ! Veuillez le contacter par mail : ".$Emprunteur->get('email')." ou par téléphone : ".$Emprunteur->get('telephone');
			
			
			$date = date("Y-m-d H:i:s");
			
			if(mail($destinatairee,utf8_decode($sujett),utf8_decode($messagee),$headerr) && mail($destinataire,utf8_decode($sujet),utf8_decode($message),$header)){
				$newPreEchange=new ModelPreEchange($_GET['idOffre'],NULL,$_GET['idPreteur'],$Emprunteur->get('idUser'));
				$newPreEchange->save();
				$Offre->updateStatutOUp($_GET['idOffre']);
				$_SESSION['active']=7;
				$controller='offre';
				$view='conf_offre';
				$pagetitle="Coordonnées envoyées !";
				require_once File::build_path(array('view','view.php'));	
			}else{
				
			}
		}else{
			require_once File::build_path(array('model','ModelCategorie.php'));
			$tab_c=ModelCategorie::getAllCategorie();
			$_SESSION['active']=4;
			$controller='utilisateur';
			$view='connexion';
			$pagetitle='Se connecter';
			require_once File::build_path(array('view','view.php'));
		}
	}
	
	public static function listO(){
		require_once File::build_path(array('model','ModelCategorie.php'));
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
		$pagetitle="Liste de toutes les offres";
		require_once File::build_path(array('view','view.php'));	
	
	}
	
	public static function mesoffres(){
		if (isset($_SESSION['login'])){
			$tab_noAccept=ModelOffre::getOffreNonAccept($_SESSION['login']);
			$tab_dispo=ModelOffre::getOffreDispo($_SESSION['login']);
			$tab_endemande=ModelOffre::getOffreCours($_SESSION['login']);
			$tab_encours=ModelOffre::getOffreNonDispo($_SESSION['login']);
			$tab_enechange=ModelOffre::getOffreEchange($_SESSION['login']);
			require_once File::build_path(array('model','ModelUtilisateur.php'));
			$idUser=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
			$tab_emprunteur=ModelOffre::getEmprunteur($idUser->get('idUser'));
			$_SESSION['active']=6;
			$controller="offre";
			$view="mesoffres";
			$pagetitle="Mes offres";
			require_once File::build_path(array('view','view.php'));
		}else{
			require_once File::build_path(array('model','ModelCategorie.php'));
			$tab_c=ModelCategorie::getAllCategorie();
			$_SESSION['active']=4;
			$controller='utilisateur';
			$view='connexion';
			$pagetitle='Se connecter';
			require_once File::build_path(array('view','view.php'));
		}
	}
	
	public static function modifO(){
		if (isset($_SESSION['login'])){
			require_once File::build_path(array('model','ModelCategorie.php'));
			require_once File::build_path(array('model','ModelObjet.php'));
			$objet=ModelObjet::getObjetByIdd($_GET['idObjet']);
			$categorie=ModelCategorie::getCategorieByIdO($_GET['idObjet']);
			$offre=ModelOffre::getOffreByIdO($_GET['idObjet']);
			$tab_c=ModelCategorie::getAllCategorie();
			$controller="offre";
			$view="modif_offre";
			$pagetitle="Modification offre";
			require_once File::build_path(array('view','view.php'));
		}else{
			require_once File::build_path(array('model','ModelCategorie.php'));
			$tab_c=ModelCategorie::getAllCategorie();
			$_SESSION['active']=4;
			$controller='utilisateur';
			$view='connexion';
			$pagetitle='Se connecter';
			require_once File::build_path(array('view','view.php'));
		}
	}
	
	public static function modifiedO(){
		if (isset($_SESSION['login'])){
			require_once File::build_path(array('model','ModelObjet.php'));
			$adresse =null;
			$maxsize = 61440;
			$width= 350;
			$height = 350;
			$erreur = null;
			if ($_FILES['image']['error'] > 0) $erreur = "Erreur lors du transfert";
					
			if ($_FILES['image']['size'] > $maxsize) $erreur = "Le fichier est trop gros";
				
			$extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
			//1. strrchr renvoie l'extension avec le point (� . �).
			//2. substr(chaine,1) ignore le premier caract�re de chaine.
			//3. strtolower met l'extension en minuscules.
			$extension_upload = strtolower(  substr(  strrchr($_FILES['image']['name'], '.')  ,1)  );
				
			if ($erreur == null){
				$nom = "./lib/image/";
				$resultat = move_uploaded_file($_FILES['image']['tmp_name'], './lib/image/'.$_FILES['image']['name'] );
						
				$nomImage = $_FILES['image']['name'];
						
				$adresse = "./lib/image/{$nomImage}";
			}
			if($adresse ==null){
				$objet=ModelObjet::getObjetByIdd($_GET['idObjet']);
				$adresse=$objet->get('image');
			}
			ModelObjet::modifO($_POST['nomObjet'],$_POST['marque'],$_POST['description'],$adresse,$_POST['idCategorie'],$_GET['idObjet']);
			ModelOffre::modifO($_POST['dateDebut'],$_POST['dateFin'],$_GET['idObjet']);
			$tab_noAccept=ModelOffre::getOffreNonAccept($_SESSION['login']);
			$tab_dispo=ModelOffre::getOffreDispo($_SESSION['login']);
			$tab_endemande=ModelOffre::getOffreCours($_SESSION['login']);
			$tab_encours=ModelOffre::getOffreNonDispo($_SESSION['login']);
			$tab_enechange=ModelOffre::getOffreEchange($_SESSION['login']);
			require_once File::build_path(array('model','ModelUtilisateur.php'));
			$idUser=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
			$tab_emprunteur=ModelOffre::getEmprunteur($idUser->get('idUser'));
			//tab_termin� mais � voir les liens avec la table �change
			$_SESSION['active']=6;
			$controller="offre";
			$view="mesoffres";
			$pagetitle="Mes offres";
			require_once File::build_path(array('view','view.php'));
		}else{
			require_once File::build_path(array('model','ModelCategorie.php'));
			$tab_c=ModelCategorie::getAllCategorie();
			$_SESSION['active']=4;
			$controller='utilisateur';
			$view='connexion';
			$pagetitle='Se connecter';
			require_once File::build_path(array('view','view.php'));
		}
	}
	
	public static function deleteO(){
		if(isset($_SESSION['login'])){
			require_once File::build_path(array('model','ModelObjet.php'));
			ModelOffre::deleteO($_GET['idObjet']);
			ModelObjet::deleteD($_GET['idObjet']);				
			$tab_noAccept=ModelOffre::getOffreNonAccept($_SESSION['login']);
			$tab_dispo=ModelOffre::getOffreDispo($_SESSION['login']);
			$tab_endemande=ModelOffre::getOffreCours($_SESSION['login']);
			$tab_encours=ModelOffre::getOffreNonDispo($_SESSION['login']);
			$tab_enechange=ModelOffre::getOffreEchange($_SESSION['login']);
			require_once File::build_path(array('model','ModelUtilisateur.php'));
			$idUser=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
			$tab_emprunteur=ModelOffre::getEmprunteur($idUser->get('idUser'));
			$_SESSION['active']=6;
			$controller="offre";
			$view="mesoffres";
			$pagetitle="Mes offres";
			require_once File::build_path(array('view','view.php'));
		}else{
			require_once File::build_path(array('model','ModelCategorie.php'));
			$tab_c=ModelCategorie::getAllCategorie();
			$_SESSION['active']=4;
			$controller='utilisateur';
			$view='connexion';
			$pagetitle='Se connecter';
			require_once File::build_path(array('view','view.php'));
		}
	}
	
	public static function indisponibleO(){
		if(isset($_SESSION['login'])){
			ModelOffre::indisponibleO($_GET['idObjet']);
			$tab_noAccept=ModelOffre::getOffreNonAccept($_SESSION['login']);
			$tab_dispo=ModelOffre::getOffreDispo($_SESSION['login']);
			$tab_endemande=ModelOffre::getOffreCours($_SESSION['login']);
			$tab_encours=ModelOffre::getOffreNonDispo($_SESSION['login']);
			$tab_enechange=ModelOffre::getOffreEchange($_SESSION['login']);
			require_once File::build_path(array('model','ModelUtilisateur.php'));
			$idUser=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
			$tab_emprunteur=ModelOffre::getEmprunteur($idUser->get('idUser'));
			$_SESSION['active']=6;
			$controller="offre";
			$view="mesoffres";
			$pagetitle="Mes offres";
			require_once File::build_path(array('view','view.php'));			
		}else{
			require_once File::build_path(array('model','ModelCategorie.php'));
			$tab_c=ModelCategorie::getAllCategorie();
			$_SESSION['active']=4;
			$controller='utilisateur';
			$view='connexion';
			$pagetitle='Se connecter';
			require_once File::build_path(array('view','view.php'));
		}
	}
	
	public static function disponibleO(){
		if(isset($_SESSION['login'])){
			ModelOffre::disponibleO($_GET['idObjet']);
			$tab_noAccept=ModelOffre::getOffreNonAccept($_SESSION['login']);
			$tab_dispo=ModelOffre::getOffreDispo($_SESSION['login']);
			$tab_endemande=ModelOffre::getOffreCours($_SESSION['login']);
			$tab_encours=ModelOffre::getOffreNonDispo($_SESSION['login']);
			$tab_enechange=ModelOffre::getOffreEchange($_SESSION['login']);
			require_once File::build_path(array('model','ModelUtilisateur.php'));
			$idUser=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
			$tab_emprunteur=ModelOffre::getEmprunteur($idUser->get('idUser'));
			$_SESSION['active']=6;
			$controller="offre";
			$view="mesoffres";
			$pagetitle="Mes offres";
			require_once File::build_path(array('view','view.php'));			
		}else{
			require_once File::build_path(array('model','ModelCategorie.php'));
			$tab_c=ModelCategorie::getAllCategorie();
			$_SESSION['active']=4;
			$controller='utilisateur';
			$view='connexion';
			$pagetitle='Se connecter';
			require_once File::build_path(array('view','view.php'));
		}
	}

	public static function miseEnEchange(){
		require_once File::build_path(array('model','ModelUtilisateur.php'));
		$idUser=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
		if(($_GET['idPreteur']==$idUser->get('idUser'))&&isset($_SESSION['login'])){
			//$echange=ModelDemande::getInfoEchange($_GET['idEmprunteur'],$_POST['idPreteur'],$_GET['idDemande']);
			require_once File::build_path(array('model','ModelDemande.php'));
			require_once File::build_path(array('model','ModelEchange.php'));
			require_once File::build_path(array('model','ModelObjet.php'));	
			
			$offre=ModelOffre::getOffreById($_GET['idOffre']);
			$objet=ModelObjet::getObjetByIdd($_GET['idObjet']);
			
			$Emprunteur=ModelUtilisateur::getUtilById($_POST['idEmprunteur']);
			$Preteur=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
			
			$destinataire=$Emprunteur->get('email');
		
			$sujet='Coordonnées du prêteur';
			$header="Coordonnées de".$Preteur->get('nom').$Preteur->get('prenom');
		
			$message=" Merci de nous avoir fais confiance,
			
			Voici les coordonnées de la personne à qui vous voulez emprunter le bien :".$objet->get('nom')."
			
			Nom :".$Preteur->get('nom')."
			Prenom :".$Preteur->get('prenom')."
			Adresse :".$Preteur->get('adresse')."        ".$Preteur->get('codePostal')."             ".$Preteur->get('ville')."
			Mail :".$Preteur->get('email')."
			Telephone :".$Preteur->get('telephone')."
			
			
			Veuillez le contacter afin de procéder à l'échange.
			
			Cordialement,
			
			(Merci de ne pas répondre à ce mail automatique)";
			
			
			$date = date("Y-m-d H:i:s");
		
			if(mail($destinataire,utf8_decode($sujet),utf8_decode($message),$header)){
				
				$destinatairee=$Preteur->get('email');
				
				$sujett='Coordonnées du demandeur';
				$headerr="Coordonnées de".$Emprunteur->get('nom').$Emprunteur->get('prenom');
			
				$messagee=" Merci de nous avoir fais confiance,
				
				Voici les coordonnées de la personne à qui vous voulez prêter le bien :".$objet->get('nom')."
				
				Nom :".$Emprunteur->get('nom')."
				Prenom :".$Emprunteur->get('prenom')."
				Adresse :".$Emprunteur->get('adresse')."        ".$Emprunteur->get('codePostal')."             ".$Emprunteur->get('ville')."
				Mail :".$Emprunteur->get('email')."
				Telephone :".$Emprunteur->get('telephone')."
				
				
				Veuillez le contacter afin de procéder à l'échange.
				
				Cordialement,
				
				(Merci de ne pas répondre à ce mail automatique)";
			
				mail($destinatairee,utf8_decode($sujett),utf8_decode($messagee),$headerr);
				
				$tab_refus=ModelUtilisateur::getEmprunteurRefus($objet->get('idObjet'),$offre->get('idOffre'),$Preteur->get('idUser'));
				
				
				foreach($tab_refus as $u){
					
					$destinataireR=$u->email;
					
					$sujetR="Refus offre";
					
					$headerR="Refus de la demande d'offre de l'objet".$objet->get('nomObjet')."";
					
					$messageR=" Bonjour,Bonsoir,
					
					Nous avons le regret de vous signaler que votre demande à l'offre de l'objet ".$objet->get('nomObjet')." a été refusée.
					Pour trouver d'autres offres correspondantes à vos recherches, vous pouvez continuer vos recherches sur le site !
					
					Cordialement,
					
					(Merci de ne pas répondre à ce mail automatique)";
					
					mail($destinataireR,utf8_decode($sujetR),utf8_decode($messageR),$headerR);
				
					
				}
			
			}
			
			$newObjet=new ModelObjet(null,$objet->get('nomObjet'),$objet->get('image'),null,null,$objet->get('idCategorie'));
			$newObjet->save();
			$idObjet=$newObjet->get('idObjet');
			
			$newDemande= new ModelDemande(null,$offre->get('date_debut'),$offre->get('date_fin'),0,1,1,1,null,$_POST['idEmprunteur'],$idObjet);
			$newDemande->save();
			$idDemande=$newDemande->get('idDemande');
			
			$date = date("Y-m-d H:i:s");
			$newEchange=new ModelEchange(null,$date,null,1,0,$_GET['idOffre'],$idDemande,$_POST['idEmprunteur'],$_GET['idPreteur']);
			
			$ifDemandeExist=ModelEchange::existDemande($idDemande);
			$ifEchangeExist=ModelEchange::existOffre($_GET['idOffre']);
			
			$newEchange->save();
			$offre->encours();
			
			$tab_noAccept=ModelOffre::getOffreNonAccept($_SESSION['login']);
			$tab_dispo=ModelOffre::getOffreDispo($_SESSION['login']);
			$tab_endemande=ModelOffre::getOffreCours($_SESSION['login']);
			$tab_encours=ModelOffre::getOffreNonDispo($_SESSION['login']);
			$tab_enechange=ModelOffre::getOffreEchange($_SESSION['login']);
			
			require_once File::build_path(array('model','ModelUtilisateur.php'));
			$idUser=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
			$tab_emprunteur=ModelOffre::getEmprunteur($idUser->get('idUser'));
			
			$_SESSION['active']=6;
			$controller="offre";
			$view="mesoffres";
			$pagetitle="Mes offres";
			require_once File::build_path(array('view','view.php'));	
		}else{
			require_once File::build_path(array('model','ModelCategorie.php'));
			$tab_c=ModelCategorie::getAllCategorie();
			$_SESSION['active']=4;
			$controller='utilisateur';
			$view='connexion';
			$pagetitle='Se connecter';
			require_once File::build_path(array('view','view.php'));
		}
	}
	
	public static function listedemandeoffre(){
		if(isset($_SESSION['admin'])){
			$tab_info=ModelOffre::getDemandesOffres();
			$_SESSION['active']=7;
			$controller="offre";
			$view="liste_demandes";
			$pagetitle="Liste des demandes d'offres";
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
	
	public static function listeoffre(){
		if(isset($_SESSION['admin'])){
			$tab_info=ModelOffre::getOffres();
			$_SESSION['active']=7;
			$controller="offre";
			$view="liste_offres";
			$pagetitle="Liste des demandes d'offres";
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
	
	public static function consultedOD(){
		if (isset($_SESSION['admin'])){
				require_once File::build_path(array('model','ModelOffre.php'));
				require_once File::build_path(array('model','ModelUtilisateur.php'));
				require_once File::build_path(array('model','ModelCommentaire.php'));
				$v = ModelOffre::getObjetOByIdOffre($_GET['idOffre']);
				$o= ModelOffre::getOffreById($_GET['idOffre']);
				$u=ModelUtilisateur::getUserByIdOffre($_GET['idOffre']);
				$_SESSION['active']=7;
				$controller='offre';
				$view='consult_demande';
				$pagetitle ='Détails du produit';
				require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
	
	public static function confirmed(){
		if (isset($_SESSION['admin'])){
			$_SESSION['active']=7;
			$Offre=ModelOffre::getOffreById($_GET['idOffre']);
			$Offre->confirmed();
			$tab_info=ModelOffre::getDemandesOffres();
			$controller="offre";
			$view="liste_demandes";
			$pagetitle="Liste des demandes d'offres";
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
	
	
	public static function deleted(){
		if (isset($_SESSION['admin'])){
			$Offre=ModelOffre::getOffreById($_GET['idOffre']);
			$Offre->deleted();
			$tab_info=ModelOffre::getDemandesOffres();
			$_SESSION['active']=7;
			$controller="offre";
			$view="liste_demandes";
			$pagetitle="Liste des demandes d'offres";
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
	
		
	public static function deletedO(){
		if (isset($_SESSION['admin'])){
			$Offre=ModelOffre::getOffreById($_GET['idOffre']);
			$Offre->deleted();
			$tab_info=ModelOffre::getOffres();
			$_SESSION['active']=7;
			$controller="offre";
			$view="liste_offres";
			$pagetitle="Liste des demandes d'offres";
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
	
	public static function modifOR(){
		if (isset($_SESSION['login'])){
			require_once File::build_path(array('model','ModelObjet.php'));
			$objet=ModelObjet::getInfoObjet($_GET['idObjet']);
			$offre=ModelOffre::getOffreByIdO($objet->get('idObjet'));
			$_SESSION['active']=6;
			$controller="offre";
			$view="modif_offre_ready";
			$pagetitle="Modifier votre offre !";
			require_once File::build_path(array('view','view.php'));
		}else{
			require_once File::build_path(array('model','ModelCategorie.php'));
			$tab_c=ModelCategorie::getAllCategorie();
			$_SESSION['active']=4;
			$controller='utilisateur';
			$view='connexion';
			$pagetitle='Se connecter';
			require_once File::build_path(array('view','view.php'));
		}
	}
	
	public static function modifiedOR(){
		if (isset($_SESSION['login'])){
			require_once File::build_path(array('model','ModelObjet.php'));
			ModelObjet::modifOR($_POST['description'],$_GET['idObjet']);
			ModelOffre::modifO($_POST['dateDebut'],$_POST['dateFin'],$_GET['idObjet']);
			require_once File::build_path(array('model','ModelOffre.php'));
			require_once File::build_path(array('model','ModelUtilisateur.php'));
			require_once File::build_path(array('model','ModelCommentaire.php'));
			$v = ModelObjet::getObjetOById($_GET['idObjet']);
			$o= ModelOffre::getOffreByIdO($_GET['idObjet']);
			$u=ModelUtilisateur::getUserById($_GET['idObjet']);
			$User=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
			$tab_p=ModelOffre::getUserOnOffre($_GET['idObjet'],$User->get('idUser'));
			$verifOffre=ModelOffre::verifOffre($_GET['idObjet'],$User->get('idUser'));
			$verifEchange=ModelEchange::verifEchangeOffre($_GET['idObjet'],$User->get('idUser'));
			$tab_commentaire=ModelCommentaire::getCommentByOffre($_GET['idObjet']);
			$_SESSION['active']=6;
			$controller='objet';
			$view='detailO';
			$pagetitle ='Détails du produit';
			require_once File::build_path(array('view','view.php'));
		}else{
			require_once File::build_path(array('model','ModelCategorie.php'));
			$tab_c=ModelCategorie::getAllCategorie();
			$_SESSION['active']=4;
			$controller='utilisateur';
			$view='connexion';
			$pagetitle='Se connecter';
			require_once File::build_path(array('view','view.php'));
		}
	}
	
	public static function addOffre(){
		if (isset($_SESSION['admin'])){
			$_SESSION['active']=7;
			require_once File::build_path(array('model','ModelCategorie.php'));
			$tab_c=ModelCategorie::getAllCategorie();
			$controller='offre';
			$view='add_offre';
			$pagetitle="Proposez une offre";
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
	
}