<div class="row body">
	<div class="col-md-12">	
		<div class="row">
			<div class="col-md-12">
				<legend>Inscrivez vous !</legend>
			</div>
		</div>
		<div class="row">
			<fieldset class="col-md-6">
				<label> Afin de valider votre inscription, vous avez l'obligation de prêter au moins un produit. </label>
				<h3> Prêt d'un bien </h3>
				<form id="form2" method="post" action="./index.php?controller=objet&action=created" enctype="multipart/form-data">
					<h4> Informations sur le bien </h4>
					<label for="nom"> Nom du bien* </label>
					<p><input type="text" placeholder="Ex : Tondeuse" name="nomObjet" id="nom" required/></p>
					<label for="categorie"> Catégorie du bien* </label>
					<select name="idCategorie" id="categorie" class="form-control" required>
						<option value="">            </option>
						<?php
						foreach($tab_c as $c){
							echo '<option value="'.$c->idCategorie.'">'.$c->nomCategorie.'</option>';}
					?>
					</select>
					<label for="description"> Description (Veuiller spécifier l'état de votre objet en plus de sa description)*</label>
					<p><textarea name="description" id="description" required></textarea></p>
					<label for="marque"> Marque </label>
					<p><input type="text" placeholder="Ex : " name="marque" id="marque" /></p>
					<input type="hidden" name="MAX_FILE_SIZE" value="61440" />
					<label for="image"> Image </label>
					<p><input type="file" placeholder="Ex : image.png" name="image" id="image" /></p>
					<div class=row">
						<p class="col-md-offset-5"><input type="submit" value="Continuer l'inscription"/></p>
					</div>	
				</form>
			</fieldset>
		</div>
	</div>
</div>
