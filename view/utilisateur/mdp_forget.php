		<?php if(isset($_SESSION['mdp_fail'])){
            if($_SESSION['mdp_fail']==1){
                echo '
                <div class="alert alert-info alert-dismissable">
					<a href="./index.php?controller=echange&action=mdpforget" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>L\'email entrée ne correspond à aucune adresse enregistrée, veuillez réssayez.</strong>
                </div>';
				$_SESSION['mdp_fail']=0;
            }
        } 
?>
<div class="row body" >
	<fieldset class="col-md-offset-5 col-md-3 body" >
		<h4> Mot de passe oublié ? </h4>
		<form method="post" action="./index.php?controller=utilisateur&action=mdpretrouve">
			<label for="email" > Entrez votre adresse mail, un mail sera alors envoyé à cette adresse avec vos identifiants :</label>
			<p><input type="text" name="email" id="email" required/></p>
			<input type="submit" value="Retrouver son mot de passe">
		</form>
	</fieldset>
</div>