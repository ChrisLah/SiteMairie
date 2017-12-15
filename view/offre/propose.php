<h2 class="body"> Faire une offre de prêt </h2>
<fieldset class="row body">
	<div class="col-md-6">
		<form method="post" action="./index.php?controller=offre&action=proposed" enctype="multipart/form-data">
			<h4> Informations sur le bien : </h4>
			<p><label for="nomObjet">Nom du bien* </label></p>
			<p><input type="text" placeholder="Ex : MonObjet" name="nomObjet" id="nomObjet" required/></p>

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
			<label for="description"> Description (Veuiller spécifier l'état de votre objet en plus de sa description)* </label>
			<p><textarea name="description" id="description" required></textarea></p>
			<p><label for="marque">Marque </label></p>
			<p><input type="text" placeholder="Ex : Marque" name="marque" id="marque"></p>
			<input type="hidden" name="MAX_FILE_SIZE" value="61440" />
			<label for="image"> Image </label>
			<p><input type="file" placeholder="Ex : image.png" name="image" id="image" ></p>
			<h4> Informations sur l'offre de prêt : </h4>
			<label for="dateDebut"> Date de début du prêt (Si non renseignée, la date sera celle de la création de l'offre )</label>
			<p><input type="date" name="dateDebut" id="dateDebut" /></p>
			<label for="dateDebut"> Date de fin du prêt (Facultatif) </label>
			<p><input type="date" name="dateFin" id="dateFin" ></p>
			<div class=row">
				<p class="col-md-offset-5"><input type="submit" value="Proposer l'offre"/></p>
			</div>
		</form>
	</div>
</fieldset>
