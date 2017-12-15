<div class="row body">
	<div class="col-md-4">
		<h3 > <?php echo 'Profil de '.$user->get('login').''; ?></h3>
		<?php
			echo'
			<p class="row">Nom de Compte : '.$user->get('login').' </p>
			<p class="row">Nom : '.$user->get('nom').' </p>
			<p class="row">Prénom : '.$user->get('prenom').' </p>
			<p class="row">Quartier : '.$user->get('nomQuartier').'</p>
			<p class="row">Adresse : '.$user->get('adresse').'</p>
			';if($user->get('sexe')==0){ echo '	<p class="row">Sexe : Homme </p>';}
			else{echo '	<p class="row">Sexe : Femme </p>';}echo'
			<p class="row">Téléphone : '.$user->get('telephone').'</p>
			<p class="row">Adresse Email : '.$user->get('email').'</p>
			<p class="row">Compagnie d\'Assurance : '.$user->get('nomAssurance').'</p>
			<p class="row">Numéro personnel d\'assurance : '.$user->get('numeroA').'</p>';
		?>
		<p class="row"><a <?php echo' href ="./index.php?controller=utilisateur&action=confirmed&idUser='.$user->get('idUser').'';?> <button type="button" class="btn btn-default"> Confirmer l'adhésion</button> </a>
		<a <?php echo 'href ="./index.php?controller=utilisateur&action=deleted&idUser='.$user->get('idUser').'';?>" <button  type="button" class="btn btn-default"> Refuser l'adhésion</button> </a><p>
		<a href ="./index.php?controller=utilisateur&action=demandesadhesions" <button  type="button" class="btn btn-default"> Retour à la liste</button> </a><p>
	</div>
	

	<?php
		foreach($tab_offre as $o){
			echo '
		<div class="col-md-7 ">
			<div class="row">
				<div class="col-md-12">
					<h2>'.$o->nomObjet.'</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<img class="image_detail" style="width:200px; height:200px;"src="'.$o->image.'">
				</div>
				<div class="col-md-offset-1 col-md-7">
					<div class="row">
						<p class="col-md-12"> Catégorie : '.$o->nomCategorie.' </p>
					</div>
					<div class="row">
						<p class="col-md-12"> Description : '.$o->description.' </p>
					</div>
					<div class="row">
						<p class="col-md-12"> Marque : '.$o->marque.' </p>
					</div>
					<div class="row">
						<p class="col-md-12"> Du : '.$o->date_debut.'</p>
					</div>
					<div class="row">
						<p class="col-md-12"> Au : ';if($o->date_fin == '2000-01-01'){echo 'non spécifiée';}else{ echo ''.$o->date_fin.'';} echo '</p>
					</div>
				</div>
			</div>
		</div>';} 
			
?>
</div>
