<?php foreach($v as $p){ echo '
	<div class="row body">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-12">
					<h2>'.$p->nomObjet.'</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<img class="image_detail" src="'.$p->image.'">
				</div>
				<div class="col-md-offset-1 col-md-4">
					<div class="row">
						<p class="col-md-12"> Pseudo du prêteur : '.$p->login.' </p>
					</div>
					<div class="row">
						';if($o->get('notation')!=NULL){
							echo '
						<p class="col-md-12"> Note : <img src="./lib/image/'.$o->get('notation').'_etoiles.png"> </p>';
						}else{
							echo '
							<p class="col-md-12"> Note : Non noté </p>';
						}echo '
					</div>
					<div class="row">
						<p class="col-md-12"> Catégorie : '.$p->nomCategorie.' </p>
					</div>
					<div class="row">
						<p class="col-md-12"> Description : '.$p->description.' </p>
					</div>
					<div class="row">
						<p class="col-md-12"> Marque : '.$p->marque.' </p>
					</div>
					<div class="row">
						<p class="col-md-12"> Disponible :'; if($p->isDisponible==1){echo 'oui';}else{echo 'non';} echo '</p>
					</div>
					<div class="row">
						<p class="col-md-12"> Du : '.$p->date_debut.'</p>
					</div>
					<div class="row">
						<p class="col-md-12"> Au : ';if($p->date_fin == '2000-01-01'){echo 'non spécifiée';}else{ echo ''.$p->date_fin.'';} echo '</p>
					</div>';
					if($p->isOnOffre==1){echo '<div class=row><p> Une demande a déjà été proposée à cette offre !</p></div>';}
					if($p->isAccept==0){echo '
						<a  href="./index.php?controller=offre&action=listedemandeoffre" type="button" class="btn btn-default"> Retour à la liste</button> </a>
						<a  href="./index.php?controller=offre&action=confirmed&idOffre='.$p->idOffre.'" type="button" class="btn btn-default"> Accepter</button> </a>
						<a  href="./index.php?controller=offre&action=deleted&idOffre='.$p->idOffre.'" type="button" class="btn btn-default"> Refuser</button> </a>';}
					else{
						echo '
						<a  href="./index.php?controller=offre&action=listeoffre" type="button" class="btn btn-default"> Retour à la liste</button> </a>
							<a  href="./index.php?controller=offre&action=deletedO&idOffre='.$p->idOffre.'" type="button" class="btn btn-default"> Supprimer</button> </a>';

					}
		  break;}
						
			echo'
				</div>
			</div>
			';
			if(!isset($_SESSION['login'])){
			echo '
				<div class="row" style="text-align:center;">
					<p> Si vous voulez répondre à cette annonce, veuillez vous connecter <a href="./index.php?controller=utilisateur&action=connect"> ici </a> </p>
				</div>
		</div>
	</div>';}
	
?>

