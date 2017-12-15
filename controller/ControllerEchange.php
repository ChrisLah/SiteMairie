	<?php
require_once File::build_path(array('model','ModelEchange.php'));// chargement du mod�le

class ControllerEchange{
	
	public static function mesechanges(){
		if (isset($_SESSION['login'])){		
			require_once File::build_path(array('model','ModelUtilisateur.php'));
			$User=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
			$idUser= $User->get('idUser');
			$tab_enCours=ModelEchange::getEchangeEnCours($_SESSION['login']);
			require_once File::build_path(array('model','ModelDemande.php'));
			require_once File::build_path(array('model','ModelOffre.php'));
			
			
				
			require_once File::build_path(array('model','ModelUtilisateur.php'));
			$idUser=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
			$tab_emprunteur=ModelOffre::getEmprunteur($idUser->get('idUser'));
			$tab_preteur=ModelDemande::getPreteur($idUser->get('idUser'));
			
			$tab_enechangeD=ModelDemande::getDemandeMesEchanges($_SESSION['login']);	
			$tab_enechangeO=ModelOffre::getOffreMesEchanges($_SESSION['login']);
			//$tab_attente=ModelEchange::getOffreDemandeAttente($_SESSION['login']);
			$tab_fin=ModelEchange::getEchangeFin($_SESSION['login']);
			
			$_SESSION['active']=6;
			$controller="echange";
			$view="mesechanges";
			$pagetitle="Mes echanges";
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
	
	public static function EndEchangeO(){
		if (isset($_SESSION['login'])){
			require_once File::build_path(array('model','ModelUtilisateur.php'));
			require_once File::build_path(array('model','ModelObjet.php'));
			
			$demande=ModelEchange::getInfoDemandeEchange($_GET['idOffre'],$_GET['idDemande'],$_GET['date']);
			$offre=ModelEchange::getInfoOffreEchange($_GET['idOffre'],$_GET['idDemande'],$_GET['date']);
			$echange=ModelEchange::getEchange($_GET['idOffre'],$_GET['idDemande'],$_GET['date']);
			
			$Emprunteur=ModelEchange::getInfoEmprunteur($_GET['idOffre'],$_GET['idDemande'],$_GET['date']);
			$Objet=ModelObjet::getObjetByIdd($_GET['idObjet']);
			$Preteur=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
					
			$destinataire=$Emprunteur->get('email');
			
			$sujet='Fin d\'échange';
			$header="Fin de prêt avec vous !";
				
			$message=" Votre échange au sujet de ".$Objet->get('nomObjet')." a été finalisé. Votre demande sera desormais disponible sur le site, si vous ne désirez pas la garder, vous pouvez la rendre indisponible ou l'annuler. 
			De plus, suite à l'échange vous avez la possibilité de noter l'objet échangé précédemment.
				
			Cordialement,
				
			(Merci de ne pas répondre à ce mail automatique)";
				
			if(mail($destinataire,utf8_decode($sujet),utf8_decode($message),$header)){
				$offre->updateAllOffre();
				$demande->updateAllDemande();
				$echange->updateEchange();
				$dateF = date("Y-m-d H:i:s");
				ModelEchange::addDateFin($_GET['idOffre'],$_GET['idDemande'],$_GET['date'],$dateF);
				ModelEchange::deletePreEchange($demande->get('idDemande'),$offre->get('idOffre'));
			}

			$_SESSION['active']=7;
			$controller="echange";
			$view="note_echange_offre";
			$pagetitle="Notez cet échange !";
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
	
	
	public static function noteD(){
		if (isset($_SESSION['login'])){	
			require_once File::build_path(array('model','ModelUtilisateur.php'));
			$Demandeur=ModelUtilisateur::getUtilByLogin($_SESSION['login']);		
			$verifNote=ModelEchange::verifNoted($_GET['idDemande'],$_GET['idOffre'],$_GET['date'],$Demandeur->get('idUser'));
			if($verifNote==true){
				require_once File::build_path(array('model','ModelUtilisateur.php'));
				$User=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
				$idUser= $User->get('idUser');
				$tab_enCours=ModelEchange::getEchangeEnCours($_SESSION['login']);
				require_once File::build_path(array('model','ModelDemande.php'));
				require_once File::build_path(array('model','ModelOffre.php'));
				
				
					
				require_once File::build_path(array('model','ModelUtilisateur.php'));
				$idUser=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
				$tab_emprunteur=ModelOffre::getEmprunteur($idUser->get('idUser'));
				$tab_preteur=ModelDemande::getPreteur($idUser->get('idUser'));
				
				$tab_enechangeD=ModelDemande::getDemandeMesEchanges($_SESSION['login']);	
				$tab_enechangeO=ModelOffre::getOffreMesEchanges($_SESSION['login']);
				//$tab_attente=ModelEchange::getOffreDemandeAttente($_SESSION['login']);
				$tab_fin=ModelEchange::getEchangeFin($_SESSION['login']);
				$_SESSION['voted']=1;
				
				$_SESSION['active']=6;
				$controller="echange";
				$view="mesechanges";
				$pagetitle="Mes echanges";
				require_once File::build_path(array('view','view.php'));	
			
			}else{
			$_SESSION['active']=7;
			$controller="echange";
			$view="note_echange_demande";
			$pagetitle="Notez cet échange !";
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
	
	/*public static function EndEchangeD(){
		require_once File::build_path(array('model','ModelUtilisateur.php'));
		require_once File::build_path(array('model','ModelObjet.php'));
		
		$demande=ModelEchange::getInfoDemandeEchange($_GET['idOffre'],$_GET['idDemande'],$_GET['date']);
		$offre=ModelEchange::getInfoOffreEchange($_GET['idOffre'],$_GET['idDemande'],$_GET['date']);
		$echange=ModelEchange::getEchange($_GET['idOffre'],$_GET['idDemande'],$_GET['date']);
		
		$Preteur=ModelEchange::getInfoPreteur($_GET['idOffre'],$_GET['idDemande'],$_GET['date']);
		$Objet=ModelObjet::getObjetByIdd($_GET['idObjet']);
		$Emprunteur=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
		
		if(($demande->get('isEnAttente')==0)&&($offre->get('isEnAttente')==0)){
			
			$destinataire=$Emprunteur->get('email');
		
			$sujet='Fin d\'échange';
			$header="Fin de l'offre avec vous !";
			
			$message=" Merci d'avoir procédé à cet échange !
			
			L'emprunteur ".$Emprunteur->get('login')." a décidé de vouloir terminer l'échange avec vous à propos de l'objet".$Objet->get('nom').".
			
			Afin de procéder à la fin de l'échange, veuillez vous aussi mettre un terme à cet échange en vous rendant à l'onglet \" Mes Echanges \", puis en cliquant sur \" Terminer l\'échange \" de l'offre en question.
			
			Cordialement,
			
			(Merci de ne pas répondre à ce mail automatique)";
			
			if(mail($destinataire,$sujet,$message,$header)){
				$demande->updateAttenteDemande();
				
			}
			
			$controller="echange";
			$view="note_echange_demande";
			$pagetitle="Notez cet échange !";
			require_once File::build_path(array('view','view.php'));
				
		}else if (($offre->get('isEnAttente')==1)){
				
			$destinataire=$Emprunteur->get('email');
		
			$sujet='Fin d\'échange';
			$header="Fin de l'offre avec vous !";
			
			$message=" Votre échange avec a bien été confirmé des deux cotés. Vous pouvez à présent relancer votre demande comme auparavant.
			
			Cordialement,
			
			(Merci de ne pas répondre à ce mail automatique)";
			
			if(mail($destinataire,$sujet,$message,$header)){
				$offre->updateAllOffre();
				$demande->updateAllDemande();
				$echange->updateEchange();
				$echange->addDateFin();
				ModelEchange::deletePreEchange($demande->get('idDemande'),$offre->get('idOffre'));
			}	
			
			$controller="echange";
			$view="note_echange_demande";
			$pagetitle="Notez cet échange !";
			require_once File::build_path(array('view','view.php'));
			
		}
	}*/
	
	public static function notedOffre(){
		if (isset($_SESSION['login'])){
			require_once File::build_path(array('model','ModelUtilisateur.php'));
			require_once File::build_path(array('model','ModelDemande.php'));
			require_once File::build_path(array('model','ModelOffre.php'));
			require_once File::build_path(array('model','ModelCommentaire.php'));
			$note1=$_POST['note1'];
			$commentaire1=$_POST['commentaire1'];
			$note2=$_POST['note2'];
			$commentaire2=$_POST['commentaire2'];
			$note3=$_POST['note3'];
			$commentaire3=$_POST['commentaire3'];
			$note4=$_POST['note4'];
			$commentaire4=$_POST['commentaire4'];
			$note5=$_POST['note5'];
			$commentaire5=$_POST['commentaire5'];
			
			if($note1!=null && $note2!=null){
				$emprunteur=ModelEchange::getInfoEmprunteur($_GET['idOffre'],$_GET['idDemande'],$_GET['date']);
				if($emprunteur->get('niveau') == null){
					$noteG=$note1 + $note2;
					$noteG=$noteG/2;
					if( $noteG >= 1 && $noteG <=1.5){
						$noteG=1;
					}
					if( $noteG > 1.5 && $noteG <=2){
						$noteG=2;
					}
					if( $noteG > 2 && $noteG <=2.5){
						$noteG=2;
					}
					if( $noteG > 2.5 && $noteG <=3){
						$noteG=3;
					}
					if( $noteG > 3 && $noteG <=3.5){
						$noteG=3;
					}
					if( $noteG > 3.5 && $noteG <=4){
						$noteG=4;
					}
					ModelEchange::addNoteUser($noteG,$emprunteur->get('idUser'));
				}else{
					$noteG=$note1 + $note2 + $emprunteur->get('niveau');
					$noteG=$noteG/3;
					if( $noteG >= 1 && $noteG <=1.5){
						$noteG=1;
					}
					if( $noteG > 1.5 && $noteG <=2){
						$noteG=2;
					}
					if( $noteG > 2 && $noteG <=2.5){
						$noteG=2;
					}
					if( $noteG > 2.5 && $noteG <=3){
						$noteG=3;
					}
					if( $noteG > 3 && $noteG <=3.5){
						$noteG=3;
					}
					if( $noteG > 3.5 && $noteG <=4){
						$noteG=4;
					}
					ModelEchange::addNoteUser($noteG,$emprunteur->get('idUser'));
				}
			}else if($note1!=null && $note2==null){
				$emprunteur=ModelEchange::getInfoEmprunteur($_GET['idOffre'],$_GET['idDemande'],$_GET['date']);
				if($emprunteur->get('niveau') == null){
					ModelEchange::addNoteUser($note1,$emprunteur->get('idUser'));
				}else{
					$noteG=$note1 + $emprunteur->get('niveau');
					$noteG=$noteG/2;
					if( $noteG >= 1 && $noteG <=1.5){
						$noteG=1;
					}
					if( $noteG > 1.5 && $noteG <=2){
						$noteG=2;
					}
					if( $noteG > 2 && $noteG <=2.5){
						$noteG=2;
					}
					if( $noteG > 2.5 && $noteG <=3){
						$noteG=3;
					}
					if( $noteG > 3 && $noteG <=3.5){
						$noteG=3;
					}
					if( $noteG > 3.5 && $noteG <=4){
						$noteG=4;
					}
					ModelEchange::addNoteUser($noteG,$emprunteur->get('idUser'));
				}
			}else if($note1==null && $note2!=null){
				$emprunteur=ModelEchange::getInfoEmprunteur($_GET['idOffre'],$_GET['idDemande'],$_GET['date']);
				if($emprunteur->get('niveau') == null){
					ModelEchange::addNoteUser($note2,$emprunteur->get('idUser'));
				}else{
					$noteG=$note2 + $emprunteur->get('niveau');
					$noteG=$noteG/2;
					if( $noteG >= 1 && $noteG <=1.5){
						$noteG=1;
					}
					if( $noteG > 1.5 && $noteG <=2){
						$noteG=2;
					}
					if( $noteG > 2 && $noteG <=2.5){
						$noteG=2;
					}
					if( $noteG > 2.5 && $noteG <=3){
						$noteG=3;
					}
					if( $noteG > 3 && $noteG <=3.5){
						$noteG=3;
					}
					if( $noteG > 3.5 && $noteG <=4){
						$noteG=4;
					}
					ModelEchange::addNoteUser($noteG,$emprunteur->get('idUser'));
				}
			}
			
			
			if($commentaire1!=null){
				$emprunteur=ModelEchange::getInfoEmprunteur($_GET['idOffre'],$_GET['idDemande'],$_GET['date']);
				$Preteur=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
				$newComment=new ModelCommentaire(null,null,$Preteur->get('idUser'),$emprunteur->get('idUser'),$commentaire1,null,null,null,null);
				$newComment->save();
			}
			
			if($commentaire2!=null){
				$emprunteur=ModelEchange::getInfoEmprunteur($_GET['idOffre'],$_GET['idDemande'],$_GET['date']);
				$Preteur=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
				$newComment=new ModelCommentaire(null,null,$Preteur->get('idUser'),$emprunteur->get('idUser'),$commentaire2,null,null,null,null);
				$newComment->save();
			}
			
			if($note3!=null){
				$demande=ModelEchange::getInfoDemandeEchange($_GET['idOffre'],$_GET['idDemande'],$_GET['date']);
				if($demande->get('notation') == null){
					ModelEchange::addNoteDemande($note3,$_GET['idDemande']);
				}else{
					$noteG2=$note3 + $demande->get('notation');
					$noteG2=$noteG2/2;
					if( $noteG2 >= 1 && $noteG2 <=1.5){
						$noteG2=1;
					}
					if( $noteG2 > 1.5 && $noteG2 <=2){
						$noteG2=2;
					}
					if( $noteG2 > 2 && $noteG2 <=2.5){
						$noteG2=2;
					}
					if( $noteG2 > 2.5 && $noteG2 <=3){
						$noteG2=3;
					}
					if( $noteG2 > 3 && $noteG2 <=3.5){
						$noteG2=3;
					}
					if( $noteG2 > 3.5 && $noteG2 <=4){
						$noteG2=4;
					}
					ModelEchange::addNoteDemande($noteG2,$_GET['idDemande']);
				}
			}
			
			if($commentaire3!=null){
				$Preteur=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
				$newComment=new ModelCommentaire(null,$_GET['idDemande'],$Preteur->get('idUser'),null,$commentaire3,null,null,null,null);
				$newComment->save();
			}
			
			if($note4!=null){
				$Preteur=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
				$newComment=new ModelCommentaire($_GET['idOffre'],$_GET['idDemande'],$Preteur->get('idUser'),null,null,null,null,$note4,null);
				$newComment->save();
				if($commentaire4 != null){
					$newComment=ModelCommentaire::addCommentD($commentaire4,$_GET['idOffre'],$_GET['idDemande'],$Preteur->get('idUser'),$note4);
				}
			}
			
			if($note5!=null){
				$Preteur=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
				$newComment=new ModelCommentaire($_GET['idOffre'],$_GET['idDemande'],$Preteur->get('idUser'),null,null,$note5,null,null,null);
				$newComment->save();
				if($commentaire4 != null){
					$newComment=ModelCommentaire::addCommentU($commentaire4,$_GET['idOffre'],$_GET['idDemande'],$Preteur->get('idUser'),$note5);
				}
			}

			
			$User=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
			$idUser= $User->get('idUser');
			$tab_enCours=ModelEchange::getEchangeEnCours($_SESSION['login']);

			$idUser=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
			$tab_emprunteur=ModelOffre::getEmprunteur($idUser->get('idUser'));
			$tab_preteur=ModelDemande::getPreteur($idUser->get('idUser'));
			
			$tab_enechangeD=ModelDemande::getDemandeMesEchanges($_SESSION['login']);	
			$tab_enechangeO=ModelOffre::getOffreMesEchanges($_SESSION['login']);
			//$tab_attente=ModelEchange::getOffreDemandeAttente($_SESSION['login']);
			$tab_fin=ModelEchange::getEchangeFin($_SESSION['login']);
			
			$_SESSION['active']=6;
			$controller="echange";
			$view="mesechanges";
			$pagetitle="Mes echanges";
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
	
	public static function notedDemande(){
		if (isset($_SESSION['login'])){		
			require_once File::build_path(array('model','ModelUtilisateur.php'));
			require_once File::build_path(array('model','ModelDemande.php'));
			require_once File::build_path(array('model','ModelOffre.php'));
			require_once File::build_path(array('model','ModelCommentaire.php'));
			$note1=$_POST['note1'];
			$commentaire1=$_POST['commentaire1'];
			$note2=$_POST['note2'];
			$commentaire2=$_POST['commentaire2'];
			$note3=$_POST['note3'];
			$commentaire3=$_POST['commentaire3'];
			$note4=$_POST['note4'];
			$commentaire4=$_POST['commentaire4'];
			$note5=$_POST['note5'];
			$commentaire5=$_POST['commentaire5'];
			
			
			if($note1!=null && $note2!=null){
				$preteur=ModelEchange::getInfoPreteur($_GET['idOffre'],$_GET['idDemande'],$_GET['date']);
				if($preteur->get('niveau') == null){
					$noteG=$note1 + $note2;
					$noteG=$noteG/2;
					if( $noteG >= 1 && $noteG <=1.5){
						$noteG=1;
					}
					if( $noteG > 1.5 && $noteG <=2){
						$noteG=2;
					}
					if( $noteG > 2 && $noteG <=2.5){
						$noteG=2;
					}
					if( $noteG > 2.5 && $noteG <=3){
						$noteG=3;
					}
					if( $noteG > 3 && $noteG <=3.5){
						$noteG=3;
					}
					if( $noteG > 3.5 && $noteG <=4){
						$noteG=4;
					}
					ModelEchange::addNoteUser($noteG,$preteur->get('idUser'));
				}else{
					$noteG=$note1 + $note2 + $preteur->get('niveau');
					$noteG=$noteG/3;
					if( $noteG >= 1 && $noteG <=1.5){
						$noteG=1;
					}
					if( $noteG > 1.5 && $noteG <=2){
						$noteG=2;
					}
					if( $noteG > 2 && $noteG <=2.5){
						$noteG=2;
					}
					if( $noteG > 2.5 && $noteG <=3){
						$noteG=3;
					}
					if( $noteG > 3 && $noteG <=3.5){
						$noteG=3;
					}
					if( $noteG > 3.5 && $noteG <=4){
						$noteG=4;
					}
					ModelEchange::addNoteUser($noteG,$preteur->get('idUser'));
				}
			}else if($note1!=null && $note2==null){
				$preteur=ModelEchange::getInfoPreteur($_GET['idOffre'],$_GET['idDemande'],$_GET['date']);
				if($preteur->get('niveau') == null){
					ModelEchange::addNoteUser($note1,$preteur->get('idUser'));
				}else{
					$noteG=$note1 + $preteur->get('niveau');
					$noteG=$noteG/2;
					if( $noteG >= 1 && $noteG <=1.5){
						$noteG=1;
					}
					if( $noteG > 1.5 && $noteG <=2){
						$noteG=2;
					}
					if( $noteG > 2 && $noteG <=2.5){
						$noteG=2;
					}
					if( $noteG > 2.5 && $noteG <=3){
						$noteG=3;
					}
					if( $noteG > 3 && $noteG <=3.5){
						$noteG=3;
					}
					if( $noteG > 3.5 && $noteG <=4){
						$noteG=4;
					}
					ModelEchange::addNoteUser($noteG,$preteur->get('idUser'));
				}
			}else if($note1==null && $note2!=null){
				$preteur=ModelEchange::getInfoPreteur($_GET['idOffre'],$_GET['idDemande'],$_GET['date']);
				if($preteur->get('niveau') == null){
					ModelEchange::addNoteUser($note2,$preteur->get('idUser'));
				}else{
					$noteG=$note2 + $preteur->get('niveau');
					$noteG=$noteG/2;
					if( $noteG >= 1 && $noteG <=1.5){
						$noteG=1;
					}
					if( $noteG > 1.5 && $noteG <=2){
						$noteG=2;
					}
					if( $noteG > 2 && $noteG <=2.5){
						$noteG=2;
					}
					if( $noteG > 2.5 && $noteG <=3){
						$noteG=3;
					}
					if( $noteG > 3 && $noteG <=3.5){
						$noteG=3;
					}
					if( $noteG > 3.5 && $noteG <=4){
						$noteG=4;
					}
					ModelEchange::addNoteUser($noteG,$preteur->get('idUser'));
				}
			}
			if($commentaire1!=null){
				$preteur=ModelEchange::getInfoPreteur($_GET['idOffre'],$_GET['idDemande'],$_GET['date']);
				$Emprunteur=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
				$newComment=new ModelCommentaire(null,null,$Emprunteur->get('idUser'),$preteur->get('idUser'),$commentaire1,null,null,null,null);
				$newComment->save();
			}
			
			if($commentaire2!=null){
				$preteur=ModelEchange::getInfoPreteur($_GET['idOffre'],$_GET['idDemande'],$_GET['date']);
				$Emprunteur=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
				$newComment=new ModelCommentaire(null,null,$Emprunteur->get('idUser'),$preteur->get('idUser'),$commentaire2,null,null,null,null);
				$newComment->save();
			}
			
			if($note3!=null){
				$offre=ModelEchange::getInfoOffreEchange($_GET['idOffre'],$_GET['idDemande'],$_GET['date']);
				if($offre->get('notation') == null){
					ModelEchange::addNoteOffre($note3,$_GET['idOffre']);
				}else{
					$noteG2=$note3 + $offre->get('notation');
					$noteG2=$noteG2/2;
					if( $noteG2 >= 1 && $noteG2 <=1.5){
						$noteG2=1;
					}
					if( $noteG2 > 1.5 && $noteG2 <=2){
						$noteG2=2;
					}
					if( $noteG2 > 2 && $noteG2 <=2.5){
						$noteG2=2;
					}
					if( $noteG2 > 2.5 && $noteG2 <=3){
						$noteG2=3;
					}
					if( $noteG2 > 3 && $noteG2 <=3.5){
						$noteG2=3;
					}
					if( $noteG2 > 3.5 && $noteG2 <=4){
						$noteG2=4;
					}
					ModelEchange::addNoteOffre($noteG2,$_GET['idOffre']);
				}
			}
			
			if($commentaire3!=null){
				$Emprunteur=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
				$newComment=new ModelCommentaire($_GET['idOffre'],null,$Emprunteur->get('idUser'),null,$commentaireO,null,null,null,null);
				$newComment->save();
			}
			
			if($note4!=null){
				$Emprunteur=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
				$newComment=new ModelCommentaire($_GET['idOffre'],$_GET['idDemande'],$Emprunteur->get('idUser'),null,null,null,null,$note4,null);
				$newComment->save();
				if($commentaire4 != null){
					$newComment=ModelCommentaire::addCommentD($commentaire4,$_GET['idOffre'],$_GET['idDemande'],$Emprunteur->get('idUser'),$note4);
				}
			}
			
			if($note5!=null){
				$Emprunteur=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
				$newComment=new ModelCommentaire($_GET['idOffre'],$_GET['idDemande'],$Emprunteur->get('idUser'),null,null,$note5,null,null,null);
				$newComment->save();
				if($commentaire4 != null){
					$newComment=ModelCommentaire::addCommentU($commentaire4,$_GET['idOffre'],$_GET['idDemande'],$Emprunteur->get('idUser'),$note5);
				}
			}
			
			
			
		/*	if($commentaireO!=null){
				if($avisUse!=null){
					if($avisDemarche!=null){
						$Emprunteur=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
						$preteur=ModelEchange::getInfoPreteur($_GET['idOffre'],$_GET['idDemande'],$_GET['date']);
						$newComment=new ModelCommentaire($_GET['idOffre'],null,$Emprunteur->get('idUser'),null,$commentaireO,$avisUse,$avisDemarche);
						$newComment->save();
					}else{
						$Emprunteur=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
						$preteur=ModelEchange::getInfoPreteur($_GET['idOffre'],$_GET['idDemande'],$_GET['date']);
						$newComment=new ModelCommentaire($_GET['idOffre'],null,$Emprunteur->get('idUser'),null,$commentaireO,$avisUse,null);
						$newComment->save();
					}
				}else{
					$Emprunteur=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
					$preteur=ModelEchange::getInfoPreteur($_GET['idOffre'],$_GET['idDemande'],$_GET['date']);
					$newComment=new ModelCommentaire($_GET['idOffre'],null,$Emprunteur->get('idUser'),null,$commentaireO,null,null);
					$newComment->save();
				}	
			}else if($commentaireO==null){
				if($avisUse==null){
					if($avisDemarche==null){
						
					}
				}
			}*/

			
			$User=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
			$idUser= $User->get('idUser');
			$tab_enCours=ModelEchange::getEchangeEnCours($_SESSION['login']);
			
			$idUser=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
			$tab_emprunteur=ModelOffre::getEmprunteur($idUser->get('idUser'));
			$tab_preteur=ModelDemande::getPreteur($idUser->get('idUser'));
			
			$tab_enechangeD=ModelDemande::getDemandeMesEchanges($_SESSION['login']);	
			$tab_enechangeO=ModelOffre::getOffreMesEchanges($_SESSION['login']);
		//	$tab_attente=ModelEchange::getOffreDemandeAttente($_SESSION['login']);
			$tab_fin=ModelEchange::getEchangeFin($_SESSION['login']);
			
			$Demandeur=ModelUtilisateur::getUtilByLogin($_SESSION['login']);
			$isNoted=ModelEchange::verifNoted($_GET['idOffre'],$_GET['idDemande'],$_GET['date'],$Demandeur->get('idUser'));
			
			$_SESSION['active']=6;
			$controller="echange";
			$view="mesechanges";
			$pagetitle="Mes echanges";
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
	
	public static function listedemandeechange(){
		if(isset($_SESSION['admin'])){
			$_SESSION['active']=7;
			$tab_info=ModelEchange::getDemandesEchange();
			$controller="echange";
			$view="liste_demandes_echanges";
			$pagetitle="Liste des demandes d'échanges";
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
	
	public static function listeEchangeCours(){
		if(isset($_SESSION['admin'])){
			$_SESSION['active']=7;
			$tab_info=ModelEchange::getEchangesCours();
			$controller="echange";
			$view="liste_echanges_en_cours";
			$pagetitle="Liste des echanges en cours";
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
	
		
	public static function listeEchangeFin(){
		if(isset($_SESSION['admin'])){
			$_SESSION['active']=7;
			$tab_info=ModelEchange::getEchangesFins();
			$controller="echange";
			$view="liste_echanges_termines";
			$pagetitle="Liste des echanges terminés";
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
	
	public static function deleteP(){
		if(isset($_SESSION['admin'])){
			require_once File::build_path(array('model','ModelPreEchange.php'));
			if(empty($_GET['idOffre'])){
				$PreEchange=ModelPreEchange::getPreEchangeByIdD($_GET['idDemande'],$_GET['idP'],$_GET['idE']);
				$PreEchange->deleteD();
			}else if(empty($_GET['idDemande'])){
				$PreEchange=ModelPreEchange::getPreEchangeByIdO($_GET['idOffre'],$_GET['idP'],$_GET['idE']);
				$PreEchange->deleteO();
			}else{
				$PreEchange=ModelPreEchange::getPreEchangeByIdOD($_GET['idOffre'],$_GET['idDemande'],$_GET['idP'],$_GET['idE']);
				$PreEchange->deleteOD();
			}
			$tab_info=ModelEchange::getDemandesEchange();
			$_SESSION['active']=7;
			$controller="echange";
			$view="liste_demandes_echanges";
			$pagetitle="Liste des demandes d'échanges";
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
	
	public static function EndEchangeAdmin(){
		if(isset($_SESSION['admin'])){
			require_once File::build_path(array('model','ModelUtilisateur.php'));
			require_once File::build_path(array('model','ModelObjet.php'));
			$demande=ModelEchange::getInfoDemandeEchange($_GET['idOffre'],$_GET['idDemande'],$_GET['date']);
			$offre=ModelEchange::getInfoOffreEchange($_GET['idOffre'],$_GET['idDemande'],$_GET['date']);
			$echange=ModelEchange::getEchange($_GET['idOffre'],$_GET['idDemande'],$_GET['date']);
			$offre->updateAllOffre();
			$demande->updateAllDemande();
			$echange->updateEchange();
			$dateF = date("Y-m-d H:i:s");
			ModelEchange::addDateFin($_GET['idOffre'],$_GET['idDemande'],$_GET['date'],$dateF);
			ModelEchange::deletePreEchange($demande->get('idDemande'),$offre->get('idOffre'));
			$tab_info=ModelEchange::getEchangesCours();
			$_SESSION['active']=7;
			$controller="echange";
			$view="liste_echanges_en_cours";
			$pagetitle="Liste des echanges en cours";
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
	
	public static function deleteEC(){
		if(isset($_SESSION['admin'])){
			$echange=ModelEchange::getEchangeById($_GET['idEchange'],$_GET['date']);
			$echange->deleteEC();
			$tab_info=ModelEchange::getEchangesCours();
			$_SESSION['active']=7;
			$controller="echange";
			$view="liste_echanges_en_cours";
			$pagetitle="Liste des echanges en cours";
			require_once File::build_path(array('view','view.php'));
		}else{
			header('Location: ./index.php');
		}
	}
}