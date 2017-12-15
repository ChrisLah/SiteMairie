<div class="row body">
	<fieldset class="col-md-6">
		<form id="form1" method="post" action="./index.php?controller=utilisateur&action=modifiedMDP">
			<legend>Modification de votre mot de passe</legend>
			<p><label for="mdp1">Ancien Mot de Passe* </label></p>
			<p><input type="password" placeholder="Ex : MonMDP" name="mdp1" id="mdp1" required/></p>
			<p><label for="mdp2">Veuillez confirmer votre ancien Mot de Passe* </label></p>
			<p><input type="password" placeholder="Ex : MonMDP" name="mdp2" id="mdp2" required/></p>
			<p><label for="mdp2">Nouveau Mot de Passe* </label></p>
			<p><input type="password" placeholder="Ex : MonMDP" name="newMdp" id="mdp2" required/></p>
			<p ><input type="submit" value="Modifier mot de passe"/></p>
		</form>
	</fieldset>
</div>
