		<?php if(isset($_SESSION['certificat'])){
            if($_SESSION['certificat']==1){
                echo '
                <div class="alert alert-danger alert-dismissable">
					<strong>Vous n\'avez pas certifié vos informations !</strong>
                </div>';
				$_SESSION['certificat']=0;
            }
        } 
?>

<div class="row body">
	<form id="form" method="post" action="./index.php?controller=offre&action=created">
		<h4> Informations sur le prêt </h4>
		<label for="dateDebut"> Date de début du prêt (Si non renseignée, la date sera celle de la création de l'offre )</label>
		<p><input type="date" name="dateDebut" id="dateDebut" /></p>
		<label for="dateDebut"> Date de fin du prêt (Facultatif) </label>
		<p><input type="date" name="dateFin" id="dateFin" ></p>
		<p> Je certifie que toutes mes informations sont exactes : <input type="checkbox" name="certifier" id="certifier" value="1"></p>
		<div class="row">
			<p class="col-md-offset-5"><input type="submit" name="finish" value="Confirmer l'inscription"/></p>
			<p class="col-md-offset-5"><input type="submit" name="continue" value="Proposer un autre objet"/></p>
		</div>	
	</form>
</div>
