<div class="row body">
	<h3> Merci d'avoir contribué au projet Pradéens Solidaires ! Vous pouvez désormais laisser vos avis et vos notes </h3>
</div>
<div class="row body">
	<legend class="col-md-12"> Qualité de l'échange  </legend>
</div>
<form class="body" method="post" <?php echo 'action="./index.php?controller=echange&action=notedOffre&idOffre='.$_GET['idOffre'].'&idDemande='.$_GET['idDemande'].'&date='.$_GET['date'].'"'; ?> >
	<label> Avez vous eu un contact agréable avec l'autre personne ?* </label>
	<div class="row">
		 (min) 
		<label for="note01" title="Note&nbsp;: 1 sur 4">1</label>
		<input type="radio" name="note1" id="note01" value="1" />
		<label for="note02" title="Note&nbsp;: 2 sur 4">2</label>
		<input type="radio" name="note1" id="note02" value="2" />
		<label for="note03" title="Note&nbsp;: 3 sur 4">3</label>
		<input type="radio" name="note1" id="note03" value="3" />
		<label for="note04" title="Note&nbsp;: 3 sur4">4</label>
		<input type="radio" name="note1" id="note04" value="4" />
		 (max) 
	</div>
	<label> Laissez votre avis : </label>
	<div class="row">
			<textarea name="commentaire1" rows="8" cols="45"></textarea>
		</div>
	<label> Etes-vous satisfait de l'organisation convenue avec l'autre personne ?* </label>
	<div class="row">
		 (min) 
		<label for="note01" title="Note&nbsp;: 1 sur 4">1</label>
		<input type="radio" name="note2" id="note01" value="1" />
		<label for="note02" title="Note&nbsp;: 2 sur 4">2</label>
		<input type="radio" name="note2" id="note02" value="2" />
		<label for="note03" title="Note&nbsp;: 3 sur 4">3</label>
		<input type="radio" name="note2" id="note03" value="3" />
		<label for="note04" title="Note&nbsp;: 3 sur4">4</label>
		<input type="radio" name="note2" id="note04" value="4" />
		 (max) 
	</div>
	<label> Laissez votre avis : </label>
	<div class="row">
			<textarea name="commentaire2" rows="8" cols="45"></textarea>
	</div>
	<div class="row body">
		<legend class="col-md-12"> La conformité de l'objet :   </legend>
	</div>
	<label> L'objet vous a-t-il été rendu dans l'état initial ?* </label>
	<div class="row">
		 (min) 
		<label for="note01" title="Note&nbsp;: 1 sur 4">1</label>
		<input type="radio" name="note3" id="note01" value="1" />
		<label for="note02" title="Note&nbsp;: 2 sur 4">2</label>
		<input type="radio" name="note3" id="note02" value="2" />
		<label for="note03" title="Note&nbsp;: 3 sur 4">3</label>
		<input type="radio" name="note3" id="note03" value="3" />
		<label for="note04" title="Note&nbsp;: 3 sur4">4</label>
		<input type="radio" name="note3" id="note04" value="4" />
		 (max) 
	</div>
	<label> Laissez votre avis : </label>
	<div class="row">
		<textarea name="commentaire3" rows="8" cols="45"></textarea>
	</div>
	<div class="row body">
		<legend class="col-md-12"> Efficacité du site </legend>
	</div>
	<label> La démarche  vous a t-elle semblé facile ?* </label>
	<div class="row">
		 (min) 
		<label for="note01" title="Note&nbsp;: 1 sur 4">1</label>
		<input type="radio" name="note4" id="note01" value="1" />
		<label for="note02" title="Note&nbsp;: 2 sur 4">2</label>
		<input type="radio" name="note4" id="note02" value="2" />
		<label for="note03" title="Note&nbsp;: 3 sur 4">3</label>
		<input type="radio" name="note4" id="note03" value="3" />
		<label for="note04" title="Note&nbsp;: 3 sur4">4</label>
		<input type="radio" name="note4" id="note04" value="4" />
		 (max) 
	</div>
	<label> Laissez votre avis : </label>
	<div class="row">
		<textarea name="commentaire4" rows="8" cols="45"></textarea>
	</div>
	<label> Etes-vous prêts à réutiliser notre site ?*</label>
	<div class="row">
		 (min) 
		<label for="note01" title="Note&nbsp;: 1 sur 4">1</label>
		<input type="radio" name="note5" id="note01" value="1" />
		<label for="note02" title="Note&nbsp;: 2 sur 4">2</label>
		<input type="radio" name="note5" id="note02" value="2" />
		<label for="note03" title="Note&nbsp;: 3 sur 4">3</label>
		<input type="radio" name="note5" id="note03" value="3" />
		<label for="note04" title="Note&nbsp;: 3 sur4">4</label>
		<input type="radio" name="note5" id="note04" value="4" />
		(max)
	</div>		
	<label> Laissez votre avis : </label>
	<div class="row">
		<textarea name="commentaire5" rows="8" cols="45"></textarea>
	</div>
	<input class="row" type="submit" value="Noter">
</form>
