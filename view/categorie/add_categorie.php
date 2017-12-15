<h2 class="body"> Ajouter une catégorie </h2>
<fieldset class="row body">
	<div class="col-md-8">
		<form method="post" action="./index.php?controller=categorie&action=created" enctype="multipart/form-data">
			<p><label for="nomCategorie">Nom de la catégorie </label></p>
			<p><input type="text" placeholder="Ex : Categorie" name="nomCategorie" id="nomCategorie" required/></p>
			<p><label for="image">Image par défaut de la catégorie </label></p>
			<p><input type="file" placeholder="Ex : image.png" name="image" id="image" ></p>
			<div class=row">
				<p class="col-md-offset-5"><input type="submit" value="Créer la catégorie"/></p>
			</div>
		</form>
	</div>
</fieldset>
