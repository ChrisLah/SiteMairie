		<?php if(isset($_SESSION['email_existe'])){
            if($_SESSION['email_existe']==1){
                echo '
                <div class="alert alert-info alert-dismissable">
					<a href="./index.php?controller=utilisateur&action=modifInfo" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>L\'email entrée existe déjà, veuillez essayer avec une autre adresse email !</strong>
                </div>';
				$_SESSION['email_existe']=0;
            }
        } 
?>
<div class="row body">
	<legend class="col-xs-12 ">Modification de votre compte</legend>
</div>
<div class="row body">
	<?php if(isset($_SESSION['admin'])){
		echo '<form id="form1" method="post" action="./index.php?controller=utilisateur&action=modifiedA&idUser='.$_GET['idUser'].'&login='.$user->get('login').'">';
	}else{ echo '
	<form id="form1" method="post" action="./index.php?controller=utilisateur&action=modified">';
	}?>
		<fieldset class="col-md-6">
			<p><label for="nom">Nom* </label></p>
			<p><input type="text" value="<?php echo ''.$user->get('nom').'';?>" name="nom" id="nom" required/></p>
			<p><label for="prenom">Prenom* </label></p>
			<p><input type="text" value="<?php echo ''.$user->get('prenom').'';?>" name="prenom" id="prenom" required/></p>
			<p><label for="sexe_id">Sexe* </label></p>
			<p><input type="radio" name="sexe" value="0" id="sexe_id" <?php if($user->get('sexe')==0){echo 'checked="checked"';}?>> Homme</p>
			<p><input type="radio" name="sexe" value="1" id="sexe_id"<?php if($user->get('sexe')==1){echo 'checked="checked"';}?>> Femme</p>
			<p><label for="telephone">Téléphone* </label></p>
			<p><input type="text" value="<?php echo ''.$user->get('telephone').'';?>" name="telephone" id="telephone" required/></p>
			<p><label for="quartier"> Nom du quartier </label> </p>
			<p>
				<select name="idQuartier" id="quartier">
					<?php 
						foreach($tab_quartier as $q){
							if(($q->idQuartier)==($quartier->get('idQuartier'))){
								echo ' <option selected value="'.$q->idQuartier.'">'.$q->nomQuartier.'</option>';
							}else{
								echo ' <option value="'.$q->idQuartier.'">'.$q->nomQuartier.'</option>';
							}
						}
					?>
				</select>
			</p>
			<p><label for="adresse">Adresse* </label></p>
			<p><input type="text" value="<?php echo ''.$user->get('adresse').'';?>" name="adresse" id="adresse" required/></p>
			<p><label for="email">Email* </label></p>		
			<p><input type="email" value="<?php echo ''.$user->get('email').'';?>" name="email" id="email" required/></p>
		</fieldset>			
		<fieldset class="col-md-4">
			<h4> Informations sur l'assurance : </h4>
			<p><label for="nomAssurance"> Nom de la compagnie d'assurance* </label> </p>
			<p><input type="text"value="<?php echo ''.$user->get('nomAssurance').'';?>" name="nomAssurance" id="nomAssurance" required/></p>
			<p><label for="numeroA">Numéro personnel d'assurance* </label></p>
			<p><input type="text" value="<?php echo ''.$user->get('numeroA').'';?>" name="numeroA" id="numeroA" required/></p>
			
			<p ><input type="submit" value="Modifier ses infos"/></p>	
		</fieldset>
			
	</form>
</div>
