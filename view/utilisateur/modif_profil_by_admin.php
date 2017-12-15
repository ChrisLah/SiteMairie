<div class="row body">
	<div class="col-md-6">
		<h3 > <?php echo 'Profil de'.$user->get('login').''; ?></h3>
		<?php
			echo'
			<p class="row">Nom de Compte : '.$user->get('login').' </p>
			<p class="row">Nom : '.$user->get('nom').' </p>
			<p class="row">Prénom : '.$user->get('prenom').' </p>
			<p class="row">Quartier : '.$quartier->get('nomQuartier').'</p>
			<p class="row">Adresse : '.$user->get('adresse').'</p>
			';if($user->get('sexe')==0){ echo '	<p class="row">Sexe : Homme </p>';}
			else{echo '	<p class="row">Sexe : Femme </p>';}echo'
			<p class="row">Téléphone : '.$user->get('telephone').'</p>
			<p class="row">Adresse Email : '.$user->get('email').'</p>
			<p class="row">Compagnie d\'Assurance : '.$user->get('nomAssurance').'</p>
			<p class="row">Numéro personnel d\'assurance : '.$user->get('numeroA').'</p>
			<p class="row">Niveau : <img class="etoileP" src="./lib/image/'.$user->get('niveau').'_etoiles.png"> </p>';
		?>
		<p class="row"><a <?php echo' href ="./index.php?controller=utilisateur&action=modifA&idUser='.$user->get('idUser').'';?>" <button type="button" class="btn btn-default"> Modifier Profil</button> </a>
		<a <?php echo 'href ="./index.php?controller=utilisateur&action=modifMDPA&login='.$user->get('login').'';?>" <button  type="button" class="btn btn-default"> Modifier mot de passe</button> </a><p>
		<a href ="./index.php?controller=utilisateur&action=listeuser" <button  type="button" class="btn btn-default"> Retour à la liste</button> </a><p>
	</div>
</div>
