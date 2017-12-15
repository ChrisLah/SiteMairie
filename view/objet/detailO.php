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
						<p class="col-md-12"> Pseudo du prêteur : '.$p->login.' </p>
					</div>
					<div class="row">
						<p class="col-md-12"> Quartier : '.$p->quartier.' </p>
					</div>
					<div class="row">
						';if($o->get('notation')!=NULL){
							echo '
						<p class="col-md-12"> Note : <img class="etoileP" src="./lib/image/'.$o->get('notation').'_etoiles.png"> </p>';
						}else{
							echo '
							<p class="col-md-12"> Note : Non noté </p>';
						}echo '
					</div>
					<div class="row">
						<p class="col-md-12"> Catégorie : '.$p->nomCategorie.' </p>
					</div>
					<div class="row">
						<p class="col-md-12"> Description : '.$p->description.' </p>
					</div>
					<div class="row">
						<p class="col-md-12"> Marque : '.$p->marque.' </p>
					</div>
					<div class="row">
						<p class="col-md-12"> Disponible :'; if($p->isDisponible==1){echo 'oui';}else{echo 'non';} echo '</p>
					</div>
					<div class="row">
						<p class="col-md-12"> Du : '.$p->date_debut.'</p>
					</div>
					<div class="row">
						<p class="col-md-12"> Au : ';if($p->date_fin == '2000-01-01'){echo 'non spécifiée';}else{ echo ''.$p->date_fin.'';} echo '</p>
					</div>';
						if($p->isOnOffre==1){echo '<div class=row><p> Une demande a déjà été proposée à cette offre !</p></div>';}break;}
				

			if(isset($_SESSION['login'])&& (strtolower($u->get('login'))==strtolower($_SESSION['login']))&&(!empty($verifOffre))&&($verifEchange==false)){
				echo '
					<div class="row">
						<p class="col-md-12"> Liste des demandeurs qui ont répondu à cette offre </p>
					</div>
					<div class="row">
						<p class="col-md-3"> Recevoir l\'offre de </p>
						<form style="margin-left:15px;" method="post" action="./index.php?controller=offre&action=miseEnEchange&idPreteur='.$u->get('idUser').'&idObjet='.$_GET['idObjet'].'&idOffre='.$o->get('idOffre').'">';
								foreach($tab_p as $p){ echo 
								'<p> <label for="idE"><a href="./index.php?controller=utilisateur&action=consult_profilD&idUser='.$p->idEmprunteur.'" >'.$p->login.' </a></label> <input type= "radio" name="idEmprunteur" id="idE" value="'.$p->idEmprunteur.'" checked></p>';}echo' 
							</select>
							<intput type="hidden" value"'.$o->get('idOffre').' name="idOffre">
							<p class="col-md-4"><input type="submit" value="Choisir cet emprunteur"/></p>
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
			if(strtolower($u->get('login'))==strtolower($_SESSION['login'])&&($verifEchange==true)){	
				echo ' <div class="row" style="text-align:center;">
				<a href ="./index.php?controller=offre&action=modifOR&idObjet='.$p->idObjet.'" <button type="button" class="btn btn-default"> Modifier votre offre</button> </a>
				</div>';
			}
			if(strtolower($u->get('login'))==strtolower($_SESSION['login'])){	
				echo '
					<div class="row" style="text-align:center;">
						<p>Ceci est votre offre, retournez à l\'accueil <a href="./index.php"> ici </a></p>
					</div>
					';
			}else if(strtolower($u->get('login'))!=strtolower($_SESSION['login'])&&($verifDejaPropose==true)){
				echo ' <div class="row" style="text-align:center;">
						<p> Vous avez déjà répondu à cette offre, retournez à l\'accueil <a href="./index.php"> ici </a></p>';
			}else{
			echo '
				<div class="row" style="text-align:center;">
					<p><a href="./index.php?controller=offre&action=demandeO&idPreteur='.$p->idUser.'&idObjet='.$_GET['idObjet'].'&idOffre='.$o->get('idOffre').'"><button type="button" class="btn btn-default btn-xs "> Répondre à l\'offre </button>  </a> </p>
				</div>
		</div>
	</div>';}break;}}
?>
