
	<?php if(isset($_SESSION['mdpretrouve'])){
            if($_SESSION['mdpretrouve']==1){
                echo '
                <div class="alert alert-info alert-dismissable">
					<a href="./index.php?controller=utilisateur&action=connect" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Un mail a été envoyé à votre adresse email. Veuillez aller le consulter pour tenter de vous connecter !</strong>
                </div>';
				$_SESSION['mdpretrouve']=0;
            }
        } 
?>
	<?php if(isset($_SESSION['connect_fail'])){
            if($_SESSION['connect_fail']==1){
                echo '
                <div class="alert alert-info alert-dismissable">
					<a href="./index.php?controller=utilisateur&action=connect" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Votre mot de passe est incorrect, veuillez réssayer !</strong>
                </div>';
				$_SESSION['connect_fail']=0;
            }
        } 
?>
<div class="row body" >
<fieldset class="col-md-offset-5 col-md-3 body" >
	<form method="post" action="./index.php?controller=utilisateur&action=connected">
		<h4> Connectez vous ! </h4>
		<label for="login" > Nom de Compte : </label>
		<p><input type="text" name="login" id="login" required/></p>
		<label for="MotDePasse"> Mot de passe : </label>
		<p><input type="password" name="MotDePasse" id="MotDePasse"></p>
		<input type="submit" value="Se connecter">
	</form>
	<p style="font-size:10px;">Vous n'êtes pas encore inscrit sur le site ? Venez vous inscrire <a href="./index.php?controller=utilisateur&action=create"> ici </a> ! </p>
	<p style="font-size:10px;"> Vous avez oublié votre mot de passe ? Cliquez <a href="./index.php?controller=utilisateur&action=mdpforget"> ici </a> ! </p>
</fieldset>
</div>
