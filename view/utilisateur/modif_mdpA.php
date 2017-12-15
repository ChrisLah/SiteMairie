<div class="row body">
	<fieldset class="col-md-6">
		<form id="form1" method="post" <?php echo 'action="./index.php?controller=utilisateur&action=modifiedMDP&login='.$_GET['login'].'"'; ?>>
			<p><label for="mdp2">Veuillez confirmer votre ancien Mot de Passe* </label></p>
			<p><input type="password" placeholder="Ex : MonMDP" name="mdp2" id="mdp2" required/></p>
			<p><label for="mdp2">Nouveau Mot de Passe* </label></p>
			<p><input type="password" placeholder="Ex : MonMDP" name="newMdp" id="mdp2" required/></p>
			<p ><input type="submit" value="Modifier mot de passe"/></p>
		</form>
	</fieldset>
</div>
