<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <title><?php echo $pagetitle ?></title>
    <link href="./lib/css/bootstrap.css" rel="stylesheet">
    <link href="./lib/css/style.css" rel="stylesheet">
  </head>
  <header>
	<div> <?php if(isset($_SESSION['admin'])){ echo'
	<div class="bar" style="text-align:center;"> <a  href="./index.php?controller=utilisateur&action=panneauAdmin" type="button" class="btn btn-default"> Panneau administrateur </button> </a> </div>';}?>
		<div class="all-banniere">
			<div class="row banniere" >
				<div class="col-sm-offset-1 col-sm-2"> <a href="./index.php?controller=accueil$action=afficher"><img class="logo" src="./lib/image/logopradéensolidaires.png"></a> </div>
				<div class="col-md-5 hidden-sm hidden-xs slogan"> Premier réseau de prêt gratuit d'objets entre Pradéens </div>
				<div class="col-sm-offset-1 col-sm-3"> 
				<?php if((!isset($_SESSION['login']))) { echo '<a href ="./index.php?controller=utilisateur&action=connect" <button type="button" class="btn btn-default"> Proposer une offre</button> </a>';}
				else{ echo '<a href ="./index.php?controller=offre&action=propose" <button type="button" class="btn btn-default"> Proposer une offre</button> </a>';}?>
					<div class="row">
						<div class="col-xs-12"> 
							<?php if((!isset($_SESSION['login']))) { echo '<a  href="./index.php?controller=utilisateur&action=connect" type="button" class="btn btn-default"> Faire une demande</button> </a>';}
							else{ echo '<a  href="./index.php?controller=demande&action=propose" type="button" class="btn btn-default"> Faire une demande</button> </a>';} ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<ul class="nav navbar-nav col-xs-12">
					
						<li <?php if($_SESSION['active']==0){echo 'class="active"';}?> ><a href="./index.php">Accueil</a></li> <! -- Faire du php ici pour récupérer toutes les catégories -->
						<?php if((!isset($_SESSION['login']))) { echo '
						<li '; if($_SESSION['active']==1){echo 'class="active"';}echo '><a href="./index.php?controller=offre&action=listO">Offres</a></li>
						<li '; if($_SESSION['active']==2){echo 'class="active"';}echo '><a href="./index.php?controller=demande&action=listD">Demandes</a></li>
						<li '; if($_SESSION['active']==3){echo 'class="active"';}echo '><a href="./index.php?controller=utilisateur&action=create">Inscription</a></li>
						<li '; if($_SESSION['active']==4){echo 'class="active"';}echo '><a href="./index.php?controller=utilisateur&action=connect">Connexion</a></li>
						<li '; if($_SESSION['active']==5){echo 'class="active"';}echo '><a href="./index.php?controller=accueil&action=aide">Aide</a></li>';}
						if(isset($_SESSION['login'])){ echo '
						<li '; if($_SESSION['active']==1){echo 'class="active"';}echo '><a href="./index.php?controller=offre&action=listO">Offres</a></li>
						<li '; if($_SESSION['active']==2){echo 'class="active"';}echo '><a href="./index.php?controller=demande&action=listD">Demandes</a></li>
						<li '; if($_SESSION['active']==6){echo 'class="active"';}echo '><a href="./index.php?controller=utilisateur&action=monprofil">Mon Profil</a></li>
						<li '; if($_SESSION['active']==5){echo 'class="active"';}echo '><a href="./index.php?controller=accueil&action=aide">Aide</a></li>
						<li><a href="./index.php?controller=utilisateur&action=deconnect">Déconnexion</a></li>';}?>
					</ul>
				</div>
			</nav>
		</div>
	</div>		
		
  </header>
 <body> 
  <div>

		