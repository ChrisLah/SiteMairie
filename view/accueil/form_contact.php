		<?php if(isset($_SESSION['Form_failed'])){
            if($_SESSION['Form_failed']==1){
                echo '
                <div class="alert alert-danger alert-dismissable">
					<a href="./index.php?controller=accueil&action=requete" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Erreur lors de l\'envoi de la requete, veuillez réessayer ! </strong>
                </div>';
				$_SESSION['Form_failed']=0;
            }
        } ?>

<div class="row body">
	<legend class="col-sm-12">Formulez votre demande </legend>
</div>
<form class="body" method="post" action='index.php?controller=accueil&action=contacted' >
    <fieldset>
        <p>
            <label for="objet_id"> Objet de la demande : </label></p>
         <p>   <input type="text" name="objet" id="objet_id" required/></p>
		<p >
            <label for="message_id">Formulez votre demande : </label></p>
               <p> <textarea name="message" id="message_id" rows="10" cols="50" required></textarea> </p>
        
    </fieldset>
    <p class="bouton">
		<input type="submit" value="Envoyer" />
		<input type="reset"/>
    </p>
</form>