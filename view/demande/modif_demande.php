<h2 class="body"> Faire une demande de prêt </h2>
<fieldset class="row body">
	<div class="col-md-6">
		<form method="post" <?php echo 'action="./index.php?controller=demande&action=modifiedD&idObjet='.$_GET['idObjet'].'">';?>
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
			<h4> Informations sur la demande de prêt : </h4>
			<label for="dateDebut"> Date de début du prêt (Si non renseignée, la date sera celle de la création de la demande )</label>
			<p><input type="date" value="<?php echo ''.$demande->get('date_debut').'';?>"name="dateDebut" id="dateDebut" /></p>
			<label for="dateDebut"> Date de fin du prêt (Facultatif) </label>
			<p><input type="date" value="<?php echo ''.$demande->get('date_fin').'';?>" name="dateFin" id="dateFin" ></p>
			<div class=row">
				<p class="col-md-offset-5"><input type="submit" value="Confirmer la demande"/></p>
			</div>
		</form>
	</div>
</fieldset>
