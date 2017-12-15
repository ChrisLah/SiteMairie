<?php
require_once File::build_path(array('model','ModelDemande.php'));// chargement du mod�le

class ControllerDemande{
			
	public static function propose(){
		require_once File::build_path(array('model','ModelCategorie.php'));
		$tab_c=ModelCategorie::getAllCategorie();
		$controller='demande';
		$view='propose';
		$pagetitle="Faites une demande";
		require_once File::build_path(array('view','view.php'));
	}
	
	public static function proposed(){
		if(isset($_SESSION['login'])){
			require_once File::build_path(array('model','ModelObjet.php'));
			require_once File::build_path(array('model','ModelUtilisateur.php'));
			require_once File::build_path(array('model','ModelCategorie.php'));
			$User=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
			$Categorie=ModelCategorie::getCategorieById($_POST['idCategorie']);
			$idUser= $User->get('idUser');
			$imageC=$Categorie->get('image');
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
			$newObjet = new ModelObjet(null,$_POST['nomObjet'],$imageC,$_POST['marque'],null,$_POST['idCategorie']);
			$newObjet->save();
			$idObjet=$newObjet->get('idObjet');
			$newDemande = new ModelDemande(null,$date,$dateF,1,0,0,0,null,$idUser,$idObjet);
			$newDemande->save();
			if(isset($_SESSION['admin'])){
				$newDemande->confirmed();
				$tab_info=ModelDemande::getDemandes();
				$_SESSION['active']=7;
				$controller="demande";
				$view="liste_demandes";
				$pagetitle="Liste des demandes";
				require_once File::build_path(array('view','view.php'));
			}else{
				$_SESSION['active']=7;
				$controller='demande';
				$view='conf_propose';
				$pagetitle="Proposition confirm�e";
				require_once File::build_path(array('view','view.php'));
			}
		}
	}
	
	public static function demandeD(){
		if(isset($_SESSION['login'])){
			require_once File::build_path(array('model','ModelUtilisateur.php'));
			require_once File::build_path(array('model','ModelObjet.php'));
			require_once File::build_path(array('model','ModelEchange.php'));
			require_once File::build_path(array('model','ModelPreEchange.php'));
			$Preteur=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
			$Emprunteur=ModelUtilisateur::getUtilById($_GET['idEmprunteur']);
			$Objet=ModelObjet::getObjetByIdd($_GET['idObjet']);
			$Demande=ModelDemande::getDemandeById($_GET['idDemande']);
			
			$destinatairee=$Preteur->get('email');
			
			$sujett='Demande envoyée';
			$headerr="Demande envoyée à ".$Emprunteur->get('login');
			
			/*$message=" Merci de nous avoir fais confiance,
			
			Voici les coordonnées de la personne à qui vous voulez prêter le bien :".$Objet->get('nom')."
			
			Numéro :".$Emprunteur->get('idUser')."
			Nom :".$Emprunteur->get('nom')."
			Prenom :".$Emprunteur->get('prenom')."
			Adresse :".$Emprunteur->get('adresse')."        ".$Emprunteur->get('codePostal')."             ".$Emprunteur->get('ville')."
			Mail :".$Emprunteur->get('email')."
			Téléphone :".$Emprunteur->get('telephone')."
			
			
			Veuillez le contacter afin de procéder à l'échange.
			
			Cordialement,
			
			(Merci de ne pas répondre à ce mail automatique)";*/
			
			$messagee="Bonjour,Bonsoir,
			
			Merci de votre confiance.
			Une demande a bien été envoyée à l'offre de ".$Objet->get('nomObjet').". Dorénavant, il vous suffit de patienter pour que l'emprunteur sélectionne votre demande et vous contact !
			
			Cordialement,
			
			(Merci de ne pas répondre à ce mail automatique)";
			
			$destinataire=$Emprunteur->get('email');
			
			$sujet="Reception de demande";
			$header="Demande reçue de ".$Preteur->get('login');
			
			$message="Bonjour, Bonsoir,
			
			Une personne est interessé vient de répondre à votre demande par rapport à l'objet ".$Objet->get('nomObjet')." ! Veuillez le contacter par mail : ".$Preteur->get('email')." ou par telephone : ".$Preteur->get('telephone')." .";
			
			if(mail($destinatairee,utf8_decode($sujett),utf8_decode($messagee),$headerr) && mail($destinataire,utf8_decode($sujet),utf8_decode($message),$header)){
				$newPreEchange=new ModelPreEchange(null,$_GET['idDemande'],$Preteur->get('idUser'),$_GET['idEmprunteur']);
				$newPreEchange->save();
				$Demande->updateStatutDUp($_GET['idDemande']);
				$_SESSION['active']=7;
				$controller='demande';
				$view='conf_demande';
				$pagetitle="Coordonnées envoyées !";
				require_once File::build_path(array('view','view.php'));			
			}
		}
	}
	
	public static function listD(){
		require_once File::build_path(array('model','ModelCategorie.php'));
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
		$controller="demande";
		$view="listD";
		$pagetitle="Liste de toutes les demandes";
		require_once File::build_path(array('view','view.php'));
	}
	
	public static function mesdemandes(){
		if(isset($_SESSION['login'])){
			$tab_noAccept=ModelDemande::getDemandeNonAccept($_SESSION['login']);
			$tab_dispo=ModelDemande::getDemandeDispo($_SESSION['login']);
			$tab_endemande=ModelDemande::getDemandeCours($_SESSION['login']);
			$tab_encours=ModelDemande::getDemandeNonDispo($_SESSION['login']);
			$tab_enechange=ModelDemande::getDemandeEchange($_SESSION['login']);
			require_once File::build_path(array('model','ModelUtilisateur.php'));
			$idUser=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
			$tab_preteur=ModelDemande::getPreteur($idUser->get('idUser'));
			$_SESSION['active']=6;
			$controller="demande";
			$view="mesdemandes";
			$pagetitle="Mes demandes";
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
	
	public static function modifD(){
		if (isset($_SESSION['login'])){
			require_once File::build_path(array('model','ModelCategorie.php'));
			require_once File::build_path(array('model','ModelObjet.php'));
			$objet=ModelObjet::getObjetByIdd($_GET['idObjet']);
			$categorie=ModelCategorie::getCategorieByIdO($_GET['idObjet']);
			$demande=ModelDemande::getDemandeByIdO($_GET['idObjet']);
			$tab_c=ModelCategorie::getAllCategorie();
			$_SESSION['active']=6;
			$controller="demande";
			$view="modif_demande";
			$pagetitle="Modification demande";
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
	
	public static function modifiedD(){
		if (isset($_SESSION['login'])){
			require_once File::build_path(array('model','ModelObjet.php'));
			ModelObjet::modifD($_POST['nomObjet'],$_POST['marque'],$_POST['idCategorie'],$_GET['idObjet']);
			ModelDemande::modifD($_POST['dateDebut'],$_POST['dateFin'],$_GET['idObjet']);
			$tab_noAccept=ModelDemande::getDemandeNonAccept($_SESSION['login']);
			$tab_dispo=ModelDemande::getDemandeDispo($_SESSION['login']);
			$tab_endemande=ModelDemande::getDemandeCours($_SESSION['login']);
			$tab_encours=ModelDemande::getDemandeNonDispo($_SESSION['login']);
			$tab_enechange=ModelDemande::getDemandeEchange($_SESSION['login']);
			require_once File::build_path(array('model','ModelUtilisateur.php'));
			$idUser=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
			$tab_preteur=ModelDemande::getPreteur($idUser->get('idUser'));
			//tab_termin� mais � voir les liens avec la table �change
			$_SESSION['active']=6;
			$controller="demande";
			$view="mesdemandes";
			$pagetitle="Mes demandes";
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
	
	public static function deleteD(){
		if(isset($_SESSION['login'])){
			require_once File::build_path(array('model','ModelObjet.php'));
			ModelDemande::deleteD($_GET['idObjet']);
			ModelObjet::deleteD($_GET['idObjet']);				
			$tab_noAccept=ModelDemande::getDemandeNonAccept($_SESSION['login']);
			$tab_dispo=ModelDemande::getDemandeDispo($_SESSION['login']);
			$tab_endemande=ModelDemande::getDemandeCours($_SESSION['login']);
			$tab_encours=ModelDemande::getDemandeNonDispo($_SESSION['login']);	
			$tab_enechange=ModelDemande::getDemandeEchange($_SESSION['login']);
			require_once File::build_path(array('model','ModelUtilisateur.php'));
			$idUser=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
			$tab_preteur=ModelDemande::getPreteur($idUser->get('idUser'));
			$_SESSION['active']=6;
			$controller="demande";
			$view="mesdemandes";
			$pagetitle="Mes demandes";
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
	
	public static function indisponibleD(){
		if(isset($_SESSION['login'])){
			ModelDemande::indisponibleD($_GET['idObjet']);
			$tab_noAccept=ModelDemande::getDemandeNonAccept($_SESSION['login']);
			$tab_dispo=ModelDemande::getDemandeDispo($_SESSION['login']);
			$tab_endemande=ModelDemande::getDemandeCours($_SESSION['login']);
			$tab_encours=ModelDemande::getDemandeNonDispo($_SESSION['login']);	
			$tab_enechange=ModelDemande::getDemandeEchange($_SESSION['login']);
			require_once File::build_path(array('model','ModelUtilisateur.php'));
			$idUser=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
			$tab_preteur=ModelDemande::getPreteur($idUser->get('idUser'));
			$_SESSION['active']=6;
			$controller="demande";
			$view="mesdemandes";
			$pagetitle="Mes demandes";
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
	
	public static function disponibleD(){
		if(isset($_SESSION['login'])){
			ModelDemande::disponibleD($_GET['idObjet']);
			$tab_noAccept=ModelDemande::getDemandeNonAccept($_SESSION['login']);
			$tab_dispo=ModelDemande::getDemandeDispo($_SESSION['login']);
			$tab_endemande=ModelDemande::getDemandeCours($_SESSION['login']);
			$tab_encours=ModelDemande::getDemandeNonDispo($_SESSION['login']);	
			$tab_enechange=ModelDemande::getDemandeEchange($_SESSION['login']);
			require_once File::build_path(array('model','ModelUtilisateur.php'));
			$idUser=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
			$tab_preteur=ModelDemande::getPreteur($idUser->get('idUser'));
			$_SESSION['active']=6;
			$controller="demande";
			$view="mesdemandes";
			$pagetitle="Mes demandes";
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
			if(($_GET['idEmprunteur']==$idUser->get('idUser'))&&isset($_SESSION['login'])){
				require_once File::build_path(array('model','ModelOffre.php'));
				require_once File::build_path(array('model','ModelEchange.php'));
				
				require_once File::build_path(array('model','ModelObjet.php'));
				//$echange=ModelDemande::getInfoEchange($_GET['idEmprunteur'],$_POST['idPreteur'],$_GET['idDemande']);
				$demande=ModelDemande::getDemandeById($_GET['idDemande']);
				$objet=ModelObjet::getObjetByIdd($_GET['idObjet']);
				
				$Preteur=ModelUtilisateur::getUtilById($_POST['idPreteur']);
				$Emprunteur=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
				
				$destinataire=$Preteur->get('email');
			
				$sujet='Coordonnées de l\'emprunteur';
				$header="Coordonnées de".$Emprunteur->get('nom').$Emprunteur->get('prenom');
			
				$message=" Merci de nous avoir fais confiance,
				
				Voici les coordonnées de la personne à qui vous voulez prêter le bien :".$objet->get('nom')."
				
				Numéro :".$Emprunteur->get('idUser')."
				Nom :".$Emprunteur->get('nom')."
				Prenom :".$Emprunteur->get('prenom')."
				Adresse :".$Emprunteur->get('adresse')."        ".$Emprunteur->get('codePostal')."             ".$Emprunteur->get('ville')."
				Mail :".$Emprunteur->get('email')."
				Telephone :".$Emprunteur->get('telephone')."
				
				
				Veuillez le contacter afin de procéder à l'échange.
				
				Cordialement,
				
				(Merci de ne pas répondre à ce mail automatique)";
				
				
				$date = date("Y-m-d H:i:s");
			
				if(mail($destinataire,utf8_decode($sujet),utf8_decode($message),$header)){
					
					$destinatairee=$Emprunteur->get('email');
					
					$sujett='Coordonnées du demandeur';
					$headerr="Coordonnées de".$Preteur->get('nom').$Preteur->get('prenom');
				
					$messagee=" Merci de nous avoir fais confiance,
					
					Voici les coordonnées de la personne à qui vous voulez emprunter le bien :".$objet->get('nom')."
					
					Numéro :".$Preteur->get('idUser')."
					Nom :".$Preteur->get('nom')."
					Prenom :".$Preteur->get('prenom')."
					Adresse :".$Preteur->get('adresse')."        ".$Preteur->get('codePostal')."             ".$Preteur->get('ville')."
					Mail :".$Preteur->get('email')."
					Telephone :".$Preteur->get('telephone')."
					
					
					Veuillez le contacter afin de procéder à l'échange.
					
					Cordialement,
					
					(Merci de ne pas répondre à ce mail automatique)";
				
					mail($destinatairee,utf8_decode($sujett),utf8_decode($messagee),$headerr);
					
					$tab_refus=ModelUtilisateur::getPreteurRefus($objet->get('idObjet'),$demande->get('idDemande'),$Emprunteur->get('idUser'));
					
					foreach($tab_refus as $u){
						
						$destinataireR=$u->email;
						
						$sujetR="Refus offre";
						
						$headerR="Refus de la demande d'offre de l'objet".$objet->get('nomObjet')."";
						
						$messageR=" Bonjour,Bonsoir,
						
						Nous avons le regret de vous signaler que votre offre à la demande de l'objet ".$objet->get('nomObjet')." a été refusée.
						Pour trouver d'autres offres correspondantes à vos recherches, vous pouvez continuer vos recherches sur le site !
						
						Cordialement,
						
						(Merci de ne pas répondre à ce mail automatique)";
						
						mail($destinataireR,utf8_decode($sujetR),utf8_decode($messageR),$headerR);
					
						
					}
				
				}
				
				$newObjet=new ModelObjet(null,$objet->get('nomObjet'),$objet->get('image'),null,null,$objet->get('idCategorie'));
				$newObjet->save();
				$idObjet=$newObjet->get('idObjet');
				
				$newOffre= new ModelOffre(null,$demande->get('date_debut'),$demande->get('date_fin'),0,1,1,1,null,$_POST['idPreteur'],$idObjet);
				$newOffre->save();
				$idOffre=$newOffre->get('idOffre');
				
				$date = date("Y-m-d H:i:s");
				
				$newEchange=new ModelEchange(null,$date,null,1,0,$idOffre,$_GET['idDemande'],$_GET['idEmprunteur'],$_POST['idPreteur']);
				$ifDemandeExist=ModelEchange::existDemande($_GET['idDemande']);
				$ifEchangeExist=ModelEchange::existOffre($idOffre);
				$newEchange->save();
				$demande->encours();
				
				$tab_noAccept=ModelDemande::getDemandeNonAccept($_SESSION['login']);
				$tab_dispo=ModelDemande::getDemandeDispo($_SESSION['login']);
				$tab_endemande=ModelDemande::getDemandeCours($_SESSION['login']);
				$tab_encours=ModelDemande::getDemandeNonDispo($_SESSION['login']);
				$tab_enechange=ModelDemande::getDemandeEchange($_SESSION['login']);	
				
				require_once File::build_path(array('model','ModelUtilisateur.php'));
				$idUser=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
				$tab_preteur=ModelDemande::getPreteur($idUser->get('idUser'));			
				
				$_SESSION['active']=6;
				$controller="demande";
				$view="mesdemandes";
				$pagetitle="Mes demandes";
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
	
	public static function listedemanderecherche(){
		if(isset($_SESSION['admin'])){
			$_SESSION['active']=7;
			$tab_info=ModelDemande::getDemandesRecherches();
			$controller="demande";
			$view="liste_demandes_recherches";
			$pagetitle="Liste des demandes de recherches";
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
	
	public static function listedemande(){
		if(isset($_SESSION['admin'])){
			$_SESSION['active']=7;
			$tab_info=ModelDemande::getDemandes();
			$controller="demande";
			$view="liste_demandes";
			$pagetitle="Liste des demandes";
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
	
	public static function consultedDD(){
		if (isset($_SESSION['admin'])){
			$_SESSION['active']=7;
			require_once File::build_path(array('model','ModelDemande.php'));
			require_once File::build_path(array('model','ModelUtilisateur.php'));
			require_once File::build_path(array('model','ModelCommentaire.php'));
			$v = ModelDemande::getObjetOByIdDemande($_GET['idDemande']);
			$o= ModelDemande::getDemandeById($_GET['idDemande']);
			$u=ModelUtilisateur::getUserByIdDemande($_GET['idDemande']);
			$controller='demande';
			$view='consult_demande';
			$pagetitle ='D�tails du produit';
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
	
	public static function confirmed(){
		if (isset($_SESSION['admin'])){
			$_SESSION['active']=7;
			$Demande=ModelDemande::getDemandeById($_GET['idDemande']);
			$Demande->confirmed();
			$tab_info=ModelDemande::getDemandesRecherches();
			$controller="demande";
			$view="liste_demandes_recherches";
			$pagetitle="Liste des demandes de recherche";
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
	
	
	public static function deletedD(){
		if (isset($_SESSION['admin'])){
			$_SESSION['active']=7;
			$Demande=ModelDemande::getDemandeById($_GET['idDemande']);
			$Demande->deletedD();
			$tab_info=ModelDemande::getDemandesRecherches();
			$controller="demande";
			$view="liste_demandes_recherches";
			$pagetitle="Liste des demandes de recherche";
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
	
		
	public static function deletedDD(){
		if (isset($_SESSION['admin'])){
			$_SESSION['active']=7;
			$Demande=ModelDemande::getDemandeById($_GET['idDemande']);
			$Demande->deletedD();
			$tab_info=ModelDemande::getDemandes();
			$controller="demande";
			$view="liste_demandes";
			$pagetitle="Liste des demandes";
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
	
	public static function modifDR(){
		if(isset($_SESSION['login'])){
			$_SESSION['active']=6;
			require_once File::build_path(array('model','ModelObjet.php'));
			$objet=ModelObjet::getInfoObjet($_GET['idObjet']);
			$demande=ModelDemande::getDemandeByIdO($objet->get('idObjet'));
			$controller="demande";
			$view="modif_demande_ready";
			$pagetitle="Modifier votre demande!";
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
	
	public static function modifiedDR(){
		if (isset($_SESSION['login'])){
			$_SESSION['active']=6;
			require_once File::build_path(array('model','ModelObjet.php'));
			ModelDemande::modifD($_POST['dateDebut'],$_POST['dateFin'],$_GET['idObjet']);
			require_once File::build_path(array('model','ModelDemande.php'));
			require_once File::build_path(array('model','ModelUtilisateur.php'));
			require_once File::build_path(array('model','ModelCommentaire.php'));
			$v = ModelObjet::getObjetById($_GET['idObjet']);
			$d= ModelDemande::getDemandeByIdO($_GET['idObjet']);
			$u=ModelUtilisateur::getUserByIdO($_GET['idObjet']);	
			$User=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
			$tab_p=ModelDemande::getUserOnDemand($_GET['idObjet'],$User->get('idUser'));
			$verifDemande=ModelDemande::verifDemande($_GET['idObjet'],$User->get('idUser'));
			$verifEchange=ModelEchange::verifEchangeDemande($_GET['idObjet'],$User->get('idUser'));
			$tab_commentaire=ModelCommentaire::getCommentByDemande($_GET['idObjet']);
			$controller='objet';
			$view='detailD';
			$pagetitle ='D�tails du produit';
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
	
	public static function addDemande(){
		if(isset($_SESSION['admin'])){
			$_SESSION['active']=7;
			require_once File::build_path(array('model','ModelCategorie.php'));
			$tab_c=ModelCategorie::getAllCategorie();
			$controller='demande';
			$view='add_demande';
			$pagetitle="Faites une demande";
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
}