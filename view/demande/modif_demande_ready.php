<h2 class="body"> Modification de la demande </h2>
<fieldset class="row body">
	<div class="col-md-6">
		<form method="post"<?php echo 'action="./index.php?controller=demande&action=modifiedDR&idObjet='.$_GET['idObjet'].'"';?> enctype="multipart/form-data">
			<h4> Informations sur la demande : </h4>
			<label for="dateDebut"> Date de début du prêt (Si non renseignée, la date sera celle de la création de l'offre )</label>
			<p><input type="date" value="<?php echo ''.$demande->get('date_debut').'';?>" name="dateDebut" id="dateDebut" /></p>
			<label for="dateDebut"> Date de fin du prêt (Facultatif) </label>
			<p><input type="date" value="<?php echo ''.$demande->get('date_fin').'';?>" name="dateFin" id="dateFin" ></p>
			<div class=row">
				<p class="col-md-offset-5"><input type="submit" value="Modifier la demande"/></p>
			</div>
		</form>
	</div>
</fieldset>
