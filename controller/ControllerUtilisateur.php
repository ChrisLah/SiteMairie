<?php
require_once File::build_path(array('model','ModelUtilisateur.php'));// chargement du mod?e

class ControllerUtilisateur{
	
	public static function create(){
		require_once File::build_path(array('model','ModelQuartier.php'));
		$tab_quartier=ModelQuartier::getAllQuartier();
		$_SESSION['active']=3;
        $controller='utilisateur';
        $view='inscriptionU';
        $pagetitle="Inscription";
        require_once File::build_path(array('view','view.php'));
	}
	
	    public static function created() {
			require_once File::build_path(array('lib','Security.php'));
			require_once File::build_path(array('model','ModelQuartier.php'));
			$action = 'connect';
			$login=$_POST['login'];
			$login=strtolower($login);
			$log=ModelUtilisateur::getUtilByLogin($login);
			$email=ModelUtilisateur::verifEmail($_POST['email']);
			$mdp1=$_POST['MotDePasse1'];
			$longueurmdp= strlen($mdp1);
			
			if(empty($log)){ //verifier l'existant de login
				if($_POST['MotDePasse1']==$_POST['MotDePasse2']){
					if($longueurmdp >= 5){
						if(empty($email)){
							$mdp=$_POST['MotDePasse1'];
							$mdpchiffre=Security::chiffrer($mdp);
							$newUtilisateur = new ModelUtilisateur(null,$_POST['login'], $mdpchiffre, $_POST['nom'], $_POST['prenom'], $_POST['sexe'], $_POST['telephone'], $_POST['idQuartier'],$_POST['adresse'],$_POST['email'],null,$_POST['nomAssurance']);
							$newUtilisateur->save();
							$_SESSION['idUserI']=$newUtilisateur->get('idUser');
							$controller='utilisateur';
							$view='charte';
							$pagetitle='Charte d\'utilisation';
							require_once File::build_path(array('view','view.php'));
						}else{
							$_SESSION['email_existe']=1;
							$tab_quartier=ModelQuartier::getAllQuartier();
							$_SESSION['active']=3;
							$controller='utilisateur';
							$view='inscriptionU';
							$pagetitle="Inscription";
							require_once File::build_path(array('view','view.php'));
						}
						if(isset($_SESSION['admin'])){
							$newUtilisateur->confirmed();
							$tab_info=ModelUtilisateur::getAdhesions();
							$_SESSION['active']=7;
							$controller='utilisateur';
							$view='liste_user';
							$pagetitle='Panneau administration';
							require_once File::build_path(array('view','view.php'));
						}
					}else{
						$_SESSION['mdp_longueur_fail']=1;
						$tab_quartier=ModelQuartier::getAllQuartier();
						$_SESSION['active']=3;
						$controller='utilisateur';
						$view='inscriptionU';
						$pagetitle="Inscription";
						require_once File::build_path(array('view','view.php'));
					}
				}else{
					$_SESSION['mdp_fail']=1;
					$tab_quartier=ModelQuartier::getAllQuartier();
					$_SESSION['active']=3;
					$controller='utilisateur';
					$view='inscriptionU';
					$pagetitle="Inscription";
					require_once File::build_path(array('view','view.php'));
				}
			}
			else{
					$_SESSION['login_fail']=1;
					$tab_quartier=ModelQuartier::getAllQuartier();
					$_SESSION['active']=3;
					$controller='utilisateur';
					$view='inscriptionU';
					$pagetitle="Inscription";
					require_once File::build_path(array('view','view.php'));
			}

		}
		
	public static function charte(){
		if(empty($_POST['conf_charte'])){
			$_SESSION['active']=3;
			$controller='utilisateur';
			$view='charte';
			$pagetitle='Charte d\'utilisation';
			require_once File::build_path(array('view','view.php'));
		}
	}
	
	public static function charteOK(){
		if(empty($_POST['conf_charte']) && empty($_POST['conf_use'])){
			$_SESSION['charte_fail']=1;
			$_SESSION['active']=3;
			$controller='utilisateur';
			$view='charte';
			$pagetitle='Charte d\'utilisation';
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
	}
	
	public static function connect(){
		require_once File::build_path(array('model','ModelCategorie.php'));
		$tab_c=ModelCategorie::getAllCategorie();
		$_SESSION['active']=4;
		$controller='utilisateur';
		$view='connexion';
		$pagetitle='Se connecter';
		require_once File::build_path(array('view','view.php'));
	}
	
	public static function connected(){
		require_once File::build_path(array('lib','Security.php'));
		$login=$_POST['login'];
	    $motDePasse=$_POST['MotDePasse'];
		$idUser=ModelUtilisateur::getIdByLogin($_POST['login']);
	    $motDePasseChiff=Security::chiffrer($motDePasse);
        $connect=ModelUtilisateur::checkPassword($login,$motDePasseChiff);
        $admin=  ModelUtilisateur::isAdmin($login);
		if (($connect==false)){
            $_SESSION['connect_fail']=1;
			$_SESSION['active']=4;
			$controller='utilisateur';
            $view='connexion';
			$pagetitle='Erreur de Connexion';
			require_once File::build_path(array('view','view.php'));
		}else{
            if($admin){
				require_once File::build_path(array('model','ModelObjet.php'));
				require_once File::build_path(array('model','ModelCategorie.php'));
				$_SESSION['admin']=$admin;
				$_SESSION['login'] = $login;
                $_SESSION['mdp']=$motDePasse;
				$_SESSION['active']=0;
				$controller='accueil';
				$view='accueil';
				$pagetitle="Accueil";
				$tab_op=ModelObjet::getProduitDerniereOffre();
				$tab_c=ModelCategorie::getAllCategorie();
				$tab_dp=ModelObjet::getProduitDerniereDemande();
				require_once File::build_path(array('view','view.php'));
			}else{
				require_once File::build_path(array('model','ModelObjet.php'));
				require_once File::build_path(array('model','ModelCategorie.php'));
				$_SESSION['login'] = $login;
				$_SESSION['mdp']=$motDePasse;
				$_SESSION['active']=0;
				$controller='accueil';
				$view='accueil';
				$pagetitle="Accueil";
				$tab_op=ModelObjet::getProduitDerniereOffre();
				$tab_c=ModelCategorie::getAllCategorie();
				$tab_dp=ModelObjet::getProduitDerniereDemande();
				require_once File::build_path(array('view','view.php'));
			}
        }
	}
	
	public static function deconnect(){
		if (!empty($_SESSION['login'])){
			session_unset($_SESSION['login']);
			session_unset($_SESSION['admin']);
			session_unset($_SESSION['mdp']);
			$_SESSION['active']=0;
            header('Location: ./index.php');
		}else{
			header('Location: ./index.php');
		}
	}
	
	public static function monprofil(){
		if (isset($_SESSION['login'])){
			$_SESSION['active']=6;
			require_once File::build_path(array('model','ModelQuartier.php'));
			$user=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
			$quartier=ModelQuartier::getQuartierUser($user->get('idQuartier'));
			$controller='utilisateur';
			$view='profil';
			$pagetitle='Mon profil';
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
	
	public static function modifInfo(){
		if (isset($_SESSION['login'])){
			require_once File::build_path(array('model','ModelQuartier.php'));
			$user=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
			$_GET['idUser']=$user->get('idUser');
			$tab_quartier=ModelQuartier::getAllQuartier();
			$quartier=ModelQuartier::getQuartierUser($user->get('idQuartier'));
			$_SESSION['active']=6;
			$controller='utilisateur';
			$view='modif_profil';
			$pagetitle='Modification profil';
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php?controller=utilisateur$action=monprofil');
		}
	}
	
	public static function modified(){
		$email1=ModelUtilisateur::verifEmailLogin($_POST['email'],$_SESSION['login']);
		$email2=ModelUtilisateur::verifEmail($_POST['email']);
		if (isset($_SESSION['login'])){
			if(empty($email1)&&empty($email2)){
				ModelUtilisateur::modified($_SESSION['login'],$_POST['nom'],$_POST['prenom'],$_POST['sexe'],$_POST['telephone'],$_POST['idQuartier'],$_POST['adresse'],$_POST['nomAssurance']);
				ModelUtilisateur::modifiedEmail($_SESSION['login'],$_POST['email']);
				require_once File::build_path(array('model','ModelQuartier.php'));
				$user=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
				$quartier=ModelQuartier::getQuartierUser($user->get('idQuartier'));
				$_SESSION['active']=6;
				$controller='utilisateur';
				$view='profil';
				$pagetitle='Mon profil';
				require_once File::build_path(array('view','view.php'));
			}else if(!empty($email1)){
				ModelUtilisateur::modified($_SESSION['login'],$_POST['nom'],$_POST['prenom'],$_POST['sexe'],$_POST['telephone'],$_POST['idQuartier'],$_POST['adresse'],$_POST['nomAssurance']);
				require_once File::build_path(array('model','ModelQuartier.php'));
				$user=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
				$quartier=ModelQuartier::getQuartierUser($user->get('idQuartier'));
				$_SESSION['active']=6;
				$controller='utilisateur';
				$view='profil';
				$pagetitle='Mon profil';
				require_once File::build_path(array('view','view.php'));
			}else{
				$_SESSION['email_existe']=1;
				require_once File::build_path(array('model','ModelQuartier.php'));
				$user=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
				$_GET['idUser']=$user->get('idUser');
				$tab_quartier=ModelQuartier::getAllQuartier();
				$quartier=ModelQuartier::getQuartierUser($user->get('idQuartier'));
				$_SESSION['active']=6;
				$controller='utilisateur';
				$view='modif_profil';
				$pagetitle='Modification profil';
				require_once File::build_path(array('view','view.php'));
			}


		}else{
			header('Location: ./index.php?controller=utilisateur$action=monprofil');
		}
		
	}
	
	public static function modifMdp(){
		if (isset($_SESSION['login'])){
			$_SESSION['active']=6;
			$controller='utilisateur';
			$view='modif_mdp';
			$pagetitle='Modification mot de passe';
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php?controller=utilisateur$action=monprofil');
		}
	}
	
	public static function modifiedMDP(){
		if (isset($_SESSION['login']) && $_POST['mdp1']==$_POST['mdp2'] && $_POST['newMdp']!=$_POST['mdp1']){
			require_once File::build_path(array('lib','Security.php'));
			$motDePasse=$_POST['newMdp'];
			$motDePasseChiff=Security::chiffrer($motDePasse);
			ModelUtilisateur::modifiedMDP($motDePasseChiff,$_SESSION['login']);
			$_SESSION['mdp']=$motDePasse;
			require_once File::build_path(array('model','ModelQuartier.php'));
			$user=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
			$quartier=ModelQuartier::getQuartierUser($user->get('idQuartier'));
			$_SESSION['active']=6;
			$controller='utilisateur';
			$view='profil';
			$pagetitle='Mon profil';
			require_once File::build_path(array('view','view.php'));
		}
	}
	
	public static function panneauAdmin(){
		if (isset($_SESSION['admin'])){
			$_SESSION['active']=7;
			$controller='utilisateur';
			$view='panneau_admin';
			$pagetitle='Panneau administration';
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
	
	public static function demandesadhesions(){
		if (isset($_SESSION['admin'])){
			$tab_info=ModelUtilisateur::getDemandesAdhesions();
			$_SESSION['active']=7;
			$controller='utilisateur';
			$view='demandes_adhesions';
			$pagetitle='Panneau administration';
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
	
	public static function listeuser(){
		if (isset($_SESSION['admin'])){
			$_SESSION['active']=7;
			$tab_info=ModelUtilisateur::getAdhesions();
			$controller='utilisateur';
			$view='liste_user';
			$pagetitle='Panneau administration';
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
	
	public static function confirmed(){
		if (isset($_SESSION['admin'])){
			$_SESSION['active']=7;
			require_once File::build_path(array('model','ModelOffre.php'));
			$User=ModelUtilisateur::getUtilById($_GET['idUser']);
			$Offre=ModelOffre::getOffresByIdUser($_GET['idUser']);
			$tab_info=ModelUtilisateur::getDemandesAdhesions();
			$User->confirmed();
			foreach($Offre as $o){
				$o->confirmed();
			}
			$destinataire=$User->get('email');

			$sujet='Inscription validée !';
			$header="Inscription de ".$User->get('login')." validée ! ";

			$message="Inscription Validée

			Bonjour ".$User->get('login').", 

			Nous sommes heureux de vous accueillir parmi nos Pradéens Solidaires. Vous pouvez dès maintenant créer votre profil et 
			accéder à votre espace personnel où vous pourrez gérer et consulter les emprunts et les prêts.

			Merci de participer à cette plateforme d'échanges.

			Cordialement,

			Natalie Nicetto

			CCAS

			04 99 65 25 19 www.pradeenssolidaires.fr

		  
			
			
			\" Tout groupe humain prend sa richesse dans la communication, l'entraide et la solidarité visant à un but commun : 
			l'épanouissement de chacun dans le respect des différences. \"
			- Françoise Dolto. ";
			
			
			mail($destinataire,utf8_decode($sujet),utf8_decode($message),$header);
			
			
			$controller='utilisateur';
			$view='demandes_adhesions';
			$pagetitle='Panneau administration';
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
	
	public static function consulted(){
		if (isset($_SESSION['admin'])){
			$_SESSION['active']=7;
			require_once File::build_path(array('model','ModelOffre.php'));
			require_once File::build_path(array('model','ModelObjet.php'));
			require_once File::build_path(array('model','ModelCategorie.php'));
			require_once File::build_path(array('model','ModelQuartier.php'));
			$user=ModelUtilisateur::getUtilAndQuartierById($_GET['idUser']);
			$tab_offre=ModelOffre::getOffreByUtil($_GET['idUser']);
			$controller='utilisateur';
			$view='consult_profil';
			$pagetitle='Profil';
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
	
	public static function deleted(){
		if (isset($_SESSION['admin'])){
			$_SESSION['active']=7;
			$User=ModelUtilisateur::getUtilById($_GET['idUser']);
			
			$destinataire=$User->get('email');
		
			$sujet='Inscription refusée !';
			$header="Inscription de ".$User->get('login')." refusée ! ";
			
			$message=" Bonjour,Bonsoir,
			
			Votre demande d'adhésion a été finalement refusée. Il y a du avoir un problème lors de votre inscription. Si vous voulez toujours participez au projet solidaire, vous pouvez toujours essayé de refaire une demande !
			Merci d'avoir essayé de faire partie de cette plateforme d'échanges.

			Cordialement,";
			
			mail($destinataire,utf8_decode($sujet),utf8_decode($message),$header);
			$User->deleted();
			$tab_info=ModelUtilisateur::getDemandesAdhesions();
			$controller='utilisateur';
			$view='demandes_adhesions';
			$pagetitle='Panneau administration';
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}

		public static function deletedU(){
		if (isset($_SESSION['admin'])){
			$_SESSION['active']=7;
			$User=ModelUtilisateur::getUtilById($_GET['idUser']);
			
			$destinataire=$User->get('email');
		
			$sujet='Compte supprimé ! ';
			$header="Suppression de ".$User->get('login')." ! ";
			
			$message=" Bonjour,Bonsoir,
			
			Votre compte a été supprimé. Si vous voulez toujours participez au projet solidaire, vous pouvez toujours essayé de refaire une demande !
			Merci d'avoir fait partie de la plateforme 

			Cordialement,";
			
			mail($destinataire,utf8_decode($sujet),utf8_decode($message),$header);
			$User->deleted();
			$tab_info=ModelUtilisateur::getAdhesions();
			$controller='utilisateur';
			$view='listeuser';
			$pagetitle='Panneau administration';
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
	
	public static function gotomodified(){
		if (isset($_SESSION['admin'])){
			$_SESSION['active']=7;
			require_once File::build_path(array('model','ModelQuartier.php'));
			$user=ModelUtilisateur::getUtilById($_GET['idUser']);
			$tab_quartier=ModelQuartier::getAllQuartier();
			$quartier=ModelQuartier::getQuartierUser($user->get('idQuartier'));
			$controller='utilisateur';
			$view='modif_profil_by_admin';
			$pagetitle='Profil';
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
	
	public static function modifA(){
		if (isset($_SESSION['admin'])){
			$_SESSION['active']=7;
			require_once File::build_path(array('model','ModelQuartier.php'));
			$user=ModelUtilisateur::getUtilById($_GET['idUser']);
			$tab_quartier=ModelQuartier::getAllQuartier();
			$quartier=ModelQuartier::getQuartierUser($user->get('idQuartier'));
			$controller='utilisateur';
			$view='modif_profil';
			$pagetitle='Modification profil';
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
	
	public static function modifiedA(){
		if (isset($_SESSION['admin'])){
			$_SESSION['active']=7;
			ModelUtilisateur::modified($_GET['login'],$_POST['nom'],$_POST['prenom'],$_POST['sexe'],$_POST['telephone'],$_POST['ville'],$_POST['codePostal'],$_POST['adresse'],$_POST['email'],$_POST['nomAssurance']);
			require_once File::build_path(array('model','ModelQuartier.php'));
			$user=ModelUtilisateur::getUtilById($_GET['idUser']);
			$tab_quartier=ModelQuartier::getAllQuartier();
			$quartier=ModelQuartier::getQuartierUser($user->get('idQuartier'));
			$controller='utilisateur';
			$view='modif_profil_by_admin';
			$pagetitle='Profil';
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
		
	}
	
	public static function modifMDPA(){
		if (isset($_SESSION['admin'])){
			$_SESSION['active']=7;
			$controller='utilisateur';
			$view='modif_mdpA';
			$pagetitle='Modification mot de passe';
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
	
	public static function modifiedMDPA(){
		if (isset($_SESSION['admin']) && $_POST['mdp1']==$_POST['mdp2']){
			require_once File::build_path(array('lib','Security.php'));
			$motDePasse=$_POST['newMdp'];
			$motDePasseChiff=Security::chiffrer($motDePasse);
			ModelUtilisateur::modifiedMDP($motDePasseChiff,$_GET['login']);
			require_once File::build_path(array('model','ModelQuartier.php'));
			$user=ModelUtilisateur::getUtilById($_GET['idUser']);
			$quartier=ModelQuartier::getQuartierUser($user->get('idQuartier'));
			$_SESSION['active']=7;
			$controller='utilisateur';
			$view='modif_profil_by_admin';
			$pagetitle='Profil';
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
	
	
	public static function map(){

			//(1) On inclut la classe de Google Maps pour g??er ensuite la carte.
			require_once File::build_path(array('lib','GoogleMapAPI.class.php'));

			//(2) On cr? une nouvelle carte; Ici, notre carte sera $map.
			$map = new GoogleMapAPI('map');

			//(3) On ajoute la clef de Google Maps.
			$map->setAPIKey('AIzaSyCp8jdtW9aN-ABm5dt43EX4PHwwLst7Rw4');
				
			//(4) On ajoute les caract?istiques que l'on d?ire ?notre carte.
			$map->setWidth("800px");
			$map->setHeight("500px");
			$map->setCenterCoords ('2', '48');
			$map->setZoomLevel (5);
			$map->geoGetCoords('34140 Meze'); 
			$controller="utilisateur";
			$view="consult_profil_byUser";
			$pagetitle="Map";
			require_once File::build_path(array('view','view.php'));
		}
		
	public static function addUser(){
		if (isset($_SESSION['admin'])){
			$_SESSION['active']=7;
			require_once File::build_path(array('model','ModelQuartier.php'));
			$tab_quartier=ModelQuartier::getAllQuartier();
			$controller='utilisateur';
			$view='add_user';
			$pagetitle='Panneau administration';
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
	
	public static function consult_profilD(){
		if(isset($_SESSION['login'])){
			require_once File::build_path(array('model','ModelCommentaire.php'));
			require_once File::build_path(array('model','ModelQuartier.php'));
			$_SESSION['active']=2;
			$user=ModelUtilisateur::getUtilById($_GET['idUser']);
			$quartier=ModelQuartier::getQuartierUser($user->get('idQuartier'));
			$controller='utilisateur';
			$view="consult_profil_byUser";
			$pagetitle='Profil Utilisateur';
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
	
	public static function listeCommentaire(){
		if(isset($_SESSION['admin'])){
			$tab_user=ModelUtilisateur::getAllUser();
			$_SESSION['active']=7;
			$controller='commentaire';
			$view='liste_commentaire';
			$pagetitle="Commentaires";
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
	
	public static function rechercheComment1(){
		if(isset($_SESSION['admin'])){
			$tab_formU=ModelUtilisateur::getCommentOfUser($_POST['idUser']);
			$tab_user=ModelUtilisateur::getAllUser();
			$controller='commentaire';
			$view='liste_commentaire';
			$pagetitle="Commentaires";
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
	
	public static function rechercheComment2(){
		if(isset($_SESSION['admin'])){
			$tab_formO=ModelUtilisateur::getCommentOfEchange($_POST['idUser']);
			$tab_user=ModelUtilisateur::getAllUser();
			$controller='commentaire';
			$view='liste_commentaire';
			$pagetitle="Commentaires";
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
	
	public static function rechercheComment3(){
		if(isset($_SESSION['admin'])){
			$tab_formU=ModelUtilisateur::getCommentByUser($_POST['idUser']);
			$tab_user=ModelUtilisateur::getAllUser();
			$controller='commentaire';
			$view='liste_commentaire';
			$pagetitle="Commentaires";
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}	
	
	public static function rechercheComment4(){
		if(isset($_SESSION['admin'])){
			$tab_formO=ModelUtilisateur::getCommentByEchange($_POST['idUser']);
			$tab_user=ModelUtilisateur::getAllUser();
			$controller='commentaire';
			$view='liste_commentaire';
			$pagetitle="Commentaires";
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
	
	public static function listeCommentaireD(){
		if(isset($_SESSION['admin'])){
			$tab_comment=ModelUtilisateur::getCommentDemarche();
			$tab_user=ModelUtilisateur::getAllUser();
			$controller='commentaire';
			$view='liste_commentaire';
			$pagetitle="Commentaires";
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
	
	
	public static function listeCommentaireU(){
		if(isset($_SESSION['admin'])){
			$tab_comment=ModelUtilisateur::getCommentUse();
			$tab_user=ModelUtilisateur::getAllUser();
			$controller='commentaire';
			$view='liste_commentaire';
			$pagetitle="Commentaires";
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
	
	public static function mdpforget(){
		$controller="utilisateur";
		$view='mdp_forget';
		$pagetitle="Mot de passe oublié";
		require_once File::build_path(array('view','view.php'));		
	}
	
	public static function mdpretrouve(){
		$user=ModelUtilisateur::getUserByEmail($_POST['email']);
		if(!empty($user)){
			 $characters = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");

			for($i=0;$i<8;$i++){
				$password .= ($i%2) ? strtoupper($characters[array_rand($characters)]) : $characters[array_rand($characters)];
			}
		
			$destinataire=$user->get('email');
		
			$sujet='Recuperation mot de passe';
			$header="Recuperation de mot de passe de ".$user->get('login');
			
			$message=" Bonjour,Bonsoir,
			
			Suite à cette demande à cause d'un oublie de mot de passe, voici vos identifiants avec un nouveau mot de passe:
			Login : ".$user->get('login')."
			Mot de passe :".$password."
			
			Afin de sécuriser votre compte, à votre connexion, il sera fortement recommandé de changer votre mot de passe à nouveau
			
			Cordialement,";
			
			mail($destinataire,utf8_decode($sujet),utf8_decode($message),$header);
			$motDePasse=$password;
			require_once File::build_path(array('lib','Security.php'));
			$motDePasseChiff=Security::chiffrer($motDePasse);
			ModelUtilisateur::modifiedMDP($motDePasseChiff,$user->get('login'));
			$_SESSION['mdpretrouve']=1;
			require_once File::build_path(array('model','ModelCategorie.php'));
			$tab_c=ModelCategorie::getAllCategorie();
			$_SESSION['active']=4;
			$controller='utilisateur';
			$view='connexion';
			$pagetitle='Se connecter';
			require_once File::build_path(array('view','view.php'));
		}else{
			$_SESSION['mdp_fail']=1;
			$controller="utilisateur";
			$view='mdp_forget';
			$pagetitle="Mot de passe oublié";
			require_once File::build_path(array('view','view.php'));	
		}
	}
}