<h2 class="body"> Modification de l'offre </h2>
<fieldset class="row body">
	<div class="col-md-6">
		<form method="post"<?php echo 'action="./index.php?controller=offre&action=modifiedOR&idObjet='.$_GET['idObjet'].'"';?> enctype="multipart/form-data">
			<label for="description"> Description  (Veuillez spécifier l'état de votre bien en plus de sa description) : </label>
			<p><textarea name="description" value="<?php echo ''.$objet->get('description').'';?>" id="description" required></textarea></p>
			<h4> Informations sur l'offre de prêt : </h4>
			<label for="dateDebut"> Date de début du prêt (Si non renseignée, la date sera celle de la création de l'offre )</label>
			<p><input type="date" value="<?php echo ''.$offre->get('date_debut').'';?>" name="dateDebut" id="dateDebut" /></p>
			<label for="dateDebut"> Date de fin du prêt (Facultatif) </label>
			<p><input type="date" value="<?php echo ''.$offre->get('date_fin').'';?>" name="dateFin" id="dateFin" ></p>
			<div class=row">
				<p class="col-md-offset-5"><input type="submit" value="Modifier l'offre"/></p>
			</div>
		</form>
	</div>
</fieldset>
