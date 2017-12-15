		<?php if(isset($_SESSION['Form_succes'])){
            if($_SESSION['Form_succes']==1){
                echo '
                <div class="alert alert-success alert-dismissable ">
					<a href="./index.php?controller=echange&action=mesechanges" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Votre requete a été envoyée, merci de votre aide !</strong>
                </div>';
				$_SESSION['Form_succes']=0;
            }
        } 
?>

<?php foreach($v as $p){ echo '
	<div class="row body">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-12">
					<h2>'.$p->nomObjet.'</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<img class="image_detail" src="'.$p->image.'">
				</div>
				<div class="col-md-offset-1 col-md-4">
					<div class="row">
						<p class="col-md-12"> Pseudo du demandeur : '.$p->login.' </p>
					</div>
					<div class="row">
						<p class="col-md-12"> Quartier : '.$p->quartier.' </p>
					</div>
					<div class="row">
						';if($d->get('notation')!=NULL){
							echo '
						<p class="col-md-12"> Note :  <img class="etoileP" src="./lib/image/'.$d->get('notation').'_etoiles.png"> </p>';
						}else{
							echo '
							<p class="col-md-12"> Note : Non noté </p>';
						}echo '
					</div>
					<div class="row">
						<p class="col-md-12"> Catégorie : '.$p->nomCategorie.' </p>
					</div>
					<div class="row">
						<p class="col-md-12"> Marque : '.$p->marque.' </p>
					</div>
					<div class="row">
						<p class="col-md-12"> Necessité :'; if($p->isRendu){echo 'oui';}else{echo 'non';} echo '</p>
					</div>
					<div class="row">
						<p class="col-md-12"> Du : '.$p->date_debut.'</p>
					</div>
					<div class="row">
						<p class="col-md-12"> Au : ';if($p->date_fin == '2000-01-01'){echo 'non spécifiée';}else{ echo ''.$p->date_fin.'';} echo '</p>
					</div>';
						if($p->isOnDemand==1){echo '<div class=row>
						<p class="col-md-12"> Une demande a déjà été proposée pour cette offre !</p>
						</div>';}break;}
			
			if(isset($_SESSION['login'])&& (strtolower($u->get('login'))==strtolower($_SESSION['login']))&&((!empty($verifDemande)))&&(($verifEchange==false))){
				echo '
					<div class="row">
						<p class="col-md-12"> Liste des prêteurs qui ont répondu à cette demande </p>
					</div>
					<div class="row">
						<form  style="margin-left:15px;" method="post" action="./index.php?controller=demande&action=miseEnEchange&idEmprunteur='.$u->get('idUser').'&idDemande='.$d->get('idDemande').'&idObjet='.$_GET['idObjet'].'">';
								foreach($tab_p as $p){ echo 
								'<p><label for="idP"><a href="./index.php?controller=utilisateur&action=consult_profilD&idUser='.$p->idPreteur.'" > '.$p->login.'</a></label>  <input type= "radio" name="idPreteur" id="idP" value="'.$p->idPreteur.'" checked></a></p>';}echo' 
							</select>
							<intput type="hidden" value"'.$d->get('idDemande').' name="idDemande">
							<p class="col-md-4"><input type="submit" value="Choisir ce preteur"/></p>
						</form>
					</div>
					';}
			echo'
				</div>
			</div>
			';
			if(!isset($_SESSION['login'])){
			echo '
				<div class="row" style="text-align:center;">
					<p> Si vous voulez répondre à cette annonce, veuillez vous connecter <a href="./index.php?controller=utilisateur&action=connect"> ici </a> </p>
				</div>
		</div>
	</div>';}else{
		foreach($v as $p){
			if(strtolower($u->get('login'))==strtolower($_SESSION['login'])&&($verifEchange==true)){ echo '
			<div class="row" style="text-align:center;">
				<a href ="./index.php?controller=demande&action=modifD&idObjet='.$p->idObjet.'" <button type="button" class="btn btn-default"> Modifier votre demande</button> </a>
				</div>';
			}
			if(strtolower($u->get('login'))==strtolower($_SESSION['login'])){	
				echo '
					<div class="row" style="text-align:center;">
						<p>Ceci est votre demande, retournez à l\'accueil <a href="./index.php"> ici </a></p>
					</div>';
			}else if(strtolower($u->get('login'))!=strtolower($_SESSION['login'])&&($verifDejaPropose==true)){
				echo ' <div class="row" style="text-align:center;">
						<p> Vous avez déjà répondu à cette demande, retournez à l\'accueil <a href="./index.php"> ici </a></p>';
			}else{
			echo '
				<div class="row" style="text-align:center;">
					<p><a href="./index.php?controller=demande&action=demandeD&idEmprunteur='.$p->idUser.'&idObjet='.$_GET['idObjet'].'&idDemande='.$d->get('idDemande').'"><button type="button" class="btn btn-default btn-xs "> Répondre à la demande </button>  </a> </p>
				</div>
		</div>
	</div>';}break;}}
?>
