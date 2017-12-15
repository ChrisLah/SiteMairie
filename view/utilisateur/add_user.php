<div class="row body">
	<div class="col-md-12">	
		<div class="row">
			<div class="col-md-12">
				<legend>Nouveau Utilisateur</legend>
			</div>
		</div>
		<div class="row">
			<fieldset class="col-md-6">
				<form id="form1" method="post" action="./index.php?controller=utilisateur&action=created">
					<h4>Informations de compte :</h4>
					<p><label for="login">Nom de compte* </label></p>
					<p><input type="text" placeholder="Ex : MonLogin" name="login" id="login" required/></p>
					<p><label for="mdp1">Mot de Passe* </label></p>
					<p><input type="password" placeholder="Ex : MonMDP" name="MotDePasse1" id="mdp1" required/></p>
					<p><label for="mdp2">Veuillez confirmer votre Mot de Passe* </label></p>
					<p><input type="password" placeholder="Ex : MonMDP" name="MotDePasse2" id="mdp2" required/></p>
					<h4>Information personnelles :</h4>
					<p><label for="nom">Nom* </label></p>
					<p><input type="text" placeholder="Ex : Dupont" name="nom" id="nom" required/></p>
					<p><label for="prenom">Prenom* </label></p>
					<p><input type="text" placeholder="Ex : Michel" name="prenom" id="prenom" required/></p>
					<p><label for="sexe_id">Sexe* </label></p>
					<p><input type="radio" name="sexe" value="0" id="sexe_id" required> Homme</p>
					<p><input type="radio" name="sexe" value="1" id="sexe_id"> Femme</p>
					<p><label for="telephone">Téléphone* </label></p>
					<p><input type="text" placeholder="Ex : 0612345678" name="telephone" id="telephone" required/></p>
					<p>
						<select name="idQuartier" id="quartier">
							<?php 
								foreach($tab_quartier as $q){
									echo ' <option value="'.$q->idQuartier.'">'.$q->nomQuartier.'</option>';
								}?>
						</select>
					</p>
					<p><label for="adresse">Adresse* </label></p>
					<p><input type="text" placeholder="Ex : 88 Avenue Occitanie" name="adresse" id="adresse" required/></p>
					<p><label for="email">Email* </label></p>		
					<p><input type="email" placeholder="Ex : Monadresse.mail@gmail.com" name="email" id="email" required/></p>
			</fieldset>
			<fieldset class="col-md-4">
					<h4> Informations sur l'assurance : </h4>
					<p><label for="nomAssurance"> Nom de la compagnie d'assurance* </label> </p>
					<p><input type="text" placeholder="Ex : Mon Assurance" name="nomAssurance" id="nomAssurance" required/></p>
					<p><label for="numeroA">Numéro personnel d'assurance* </label></p>
					<p><input type="text" placeholder="Ex : 7548856" name="numeroA" id="numeroA" required/></p>
					<div class=row">
						<p class="col-md-offset-5"><input type="submit" value="Ajouter"/></p>
					</div>	
				</form>
			</fieldset>
		</div>
	</div>
</div>

