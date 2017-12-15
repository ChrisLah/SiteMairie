<h2 class="body"> Faire une demande de prêt </h2>
<fieldset class="row body">
	<div class="col-md-6">
		<form method="post" action="./index.php?controller=demande&action=proposed">
			<h4> Informations sur le bien : </h4>
			<p><label for="nomObjet">Nom du bien* </label></p>
			<p><input type="text" placeholder="Ex : MonObjet" name="nomObjet" id="nomObjet" required/></p>
			<p><label for="marque">Marque </label></p>
			<p><input type="text" placeholder="Ex : Marque" name="marque" id="marque"></p>
			<p><label for="categorie">Catégorie* </label></p>
			<div class="form-group">
				<select name="idCategorie" id="categorie" class="form-control">
					<?php
						foreach($tab_c as $v){
							echo '
						<option value="'.$v->idCategorie.'">'.$v->nomCategorie.'</option>';}
					?>
				</select>
			</div>
			<h4> Informations sur la demande de prêt : </h4>
			<label for="dateDebut"> Date de début du prêt (Si non renseignée, la date sera celle de la création de la demande )</label>
			<p><input type="date" name="dateDebut" id="dateDebut" /></p>
			<label for="dateDebut"> Date de fin du prêt (Facultatif) </label>
			<p><input type="date" name="dateFin" id="dateFin" ></p>
			<div class=row">
				<p class="col-md-offset-5"><input type="submit" value="Confirmer la demande"/></p>
			</div>
		</form>
	</div>
</fieldset>
