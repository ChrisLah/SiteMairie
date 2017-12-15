<h2> Modification de l'offre </h2>
<fieldset class="row body">
	<div class="col-md-6">
		<form method="post"<?php echo 'action="./index.php?controller=offre&action=modifiedO&idObjet='.$_GET['idObjet'].'"';?> enctype="multipart/form-data">
			<h4> Informations sur le bien : </h4>
			<p><label for="nomObjet">Nom du bien* </label></p>
			<p><input type="text" value="<?php echo ''.$objet->get('nomObjet').'';?>" name="nomObjet" id="nomObjet" required/></p>
			<p><label for="marque">Marque </label></p>
			<p><input type="text" value="<?php echo ''.$objet->get('marque').'';?>" name="marque" id="marque"></p>
			<p><label for="categorie">Catégorie </label></p>
			<div class="form-group">
				<select name="idCategorie" id="categorie" class="form-control">
					<?php
						foreach($tab_c as $v){
							if(($v->idCategorie)==($categorie->get('idCategorie'))){
							echo '
								<option selected value="'.$v->idCategorie.'">'.$v->nomCategorie.'</option>';}
						else{
							echo '
								<option value="'.$v->idCategorie.'">'.$v->nomCategorie.'</option>';}
						}
					?>
				</select>
			</div>
			<label for="description"> Description (Veuillez spécifier l'état de votre bien en plus de sa description) :</label>
			<p><textarea name="description" value="<?php echo ''.$objet->get('description').'';?>" id="description" required></textarea></p>
			<input type="hidden" name="MAX_FILE_SIZE" value="61440" />
			<label for="image"> Image </label>
			<p><input type="file" value="<?php echo ''.$objet->get('image').'';?>" name="image" id="image" ></p>
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

	