<div style="padding-left: 25px;"class="row body">
	<div class="col-md-6">
		<a href="./index.php?controller=demande&action=mesdemandes" type="button" class="btn btn-default"> Mes Demandes</button></a>
		<a href="./index.php?controller=offre&action=mesoffres" type="button" class="btn btn-default">Mes Offres</button></a>
		<a href="./index.php?controller=echange&action=mesechanges" type="button" class="btn btn-default">Mes Echanges</button></a>
		<h3> Mon Profil </h3>
		<?php
		$mot_de_passe = $_SESSION['mdp'];
		$nb_caractere_visible = 0;
		$remplacement = '*';
		$longueur_mdp = strlen($mot_de_passe);
		$partie_visible = substr($mot_de_passe, 0, $nb_caractere_visible);
		$mdp_final = str_pad($partie_visible, $longueur_mdp, $remplacement);
			echo'
			<p class="row">Nom de Compte : '.$user->get('login').' </p>
			<p class="row"> Mot de Passe : '.$mdp_final.'</p>
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
		<p class="row"><a href ="./index.php?controller=utilisateur&action=modifInfo" <button type="button" class="btn btn-default"> Modifier son compte</button> </a>
		<a href ="./index.php?controller=utilisateur&action=modifMdp" <button  type="button" class="btn btn-default"> Modifier son mot de passe</button> </a><p>
	</div>
</div>
