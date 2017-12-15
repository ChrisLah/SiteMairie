<div class="row body">
	<legend class="col-md-12"> Mes objets non acceptés </legend>
</div>
<div class="row body">
	<?php
	$i=0;
		foreach($tab_noAccept as $v){
			echo'
				<div class="col-xs-4">
					<img class="col-xs-4" style="padding:0px 10px 25px 0px;width:85px;height:100px;" src="'.$v->image.'">
					<div class="col-xs-7 listeE" style="padding:0px 0px 0px 0px;" > 
						<div class="col-xs-6" style="padding:0px 0px 0px 0px;">
							<p> Nom du Produit :'.$v->nomObjet.'</p>
							<div class="row">
								<div class="col-xs-12">
									<p> Catégorie :'.$v->nomCategorie.'</p>
								</div>
							</div>
						</div>
					<div class="col-xs-6">
							<div class="row">
								<div class="col-xs-12">
									<a href="./index.php?controller=objet&action=consultationO&idObjet='.$v->idObjet.'" <button type="button" class="btn btn-default btn-xs "> Consulter</button> </a>
									<a href="./index.php?controller=offre&action=modifO&idObjet='.$v->idObjet.'" <button type="button" class="btn btn-default btn-xs "> Modifier</button> </a>
									<a href="./index.php?controller=offre&action=modifierDate&idObjet='.$v->idObjet.'" <button type="button" class="btn btn-default btn-xs ">Modifier date</button> </a>
									<a href="./index.php?controller=offre&action=deleteO&idObjet='.$v->idObjet.'" <button type="button" class="btn btn-default btn-xs "> Supprimer</button> </a>
								</div>
							</div>
						</div>
					</div>
				</div>
					';
				}?>
</div>
<div class="row body">
	<legend class="col-md-12"> Mes objets disponibles </legend>
</div>
<div class="row body">
	<?php 
		$j=0;
		foreach($tab_dispo as $v){
			echo'
				<div class="col-xs-4">
					<img class="col-xs-4" style="padding:0px 10px 25px 0px;width:85px;height:100px;" src="'.$v->image.'">
					<div class="col-xs-7 listeE" style="padding:0px 0px 0px 0px;" > 
						<div class="col-xs-6" style="padding:0px 0px 0px 0px;">
							<p> Nom du Produit :'.$v->nomObjet.'</p>
							<div class="row">
								<div class="col-xs-12">
									<p> Catégorie :'.$v->nomCategorie.'</p>
								</div>
							</div>
						</div>
					<div class="col-xs-6">
						<p> Note :';if($v->niveau !=null ){ echo '<img class="etoile" src="./lib/image/'.$v->niveau.'_etoiles.png">';}else{echo ' Non notée ';} echo '</p>
							<div class="row">
								<div class="col-xs-12">
									<a href="./index.php?controller=objet&action=consultationO&idObjet='.$v->idObjet.'" <button type="button" class="btn btn-default btn-xs "> Consulter</button> </a>
									<a href="./index.php?controller=offre&action=deleteO&idObjet='.$v->idObjet.'" <button type="button" class="btn btn-default btn-xs "> Supprimer</button> </a>
									<a href="./index.php?controller=offre&action=indisponibleO&idObjet='.$v->idObjet.'" <button type="button" class="btn btn-default btn-xs "> Rendre indisponible</button> </a>
								</div>
							</div>
						</div>
					</div>
				</div>
					';
				}?>
</div>
<div class="row body">
	<legend class="col-md-12"> Mes objets indisponibles</legend>
</div>
<div class="row body">
	<?php
		$l=0;
		foreach($tab_encours as $v){
			echo'
				<div class="col-xs-4">
					<img class="col-xs-4" style="padding:0px 10px 25px 0px;width:85px;height:100px;" src="'.$v->image.'">
					<div class="col-xs-7 listeE" style="padding:0px 0px 0px 0px;" > 
						<div class="col-xs-6" style="padding:0px 0px 0px 0px;">
							<p> Nom du Produit :'.$v->nomObjet.'</p>
							<div class="row">
								<div class="col-xs-12">
									<p> Catégorie :'.$v->nomCategorie.'</p>
								</div>
							</div>
						</div>
					<div class="col-xs-6">
						<p> Note :';if($v->niveau !=null ){ echo '<img class="etoile" src="./lib/image/'.$v->niveau.'_etoiles.png">';}else{echo ' Non notée ';} echo '</p>
							<div class="row">
								<div class="col-xs-12">
									<a href="./index.php?controller=objet&action=consultationO&idObjet='.$v->idObjet.'" <button type="button" class="btn btn-default btn-xs "> Consulter</button> </a>
									<a href="./index.php?controller=offre&action=disponibleO&idObjet='.$v->idObjet.'" <button type="button" class="btn btn-default btn-xs "> Rendre disponible</button> </a>
									<a href="./index.php?controller=offre&action=deleteO&idObjet='.$v->idObjet.'" <button type="button" class="btn btn-default btn-xs "> Supprimer</button> </a>
								</div>
							</div>
						</div>
					</div>
				</div>
					';
				}?>
</div>
<div class="row body">
	<legend class="col-md-12"> Mes objets en cours de validation </legend>
</div>
<div class="row body">
	<?php
		$k=0;
		foreach($tab_endemande as $v){
			echo'
				<div class="col-xs-4">
					<img class="col-xs-4" style="padding:0px 10px 25px 0px;width:85px;height:100px;" src="'.$v->image.'">
					<div class="col-xs-7 listeE" style="padding:0px 0px 0px 0px;" > 
						<div class="col-xs-6" style="padding:0px 0px 0px 0px;">
							<p> Nom du Produit :'.$v->nomObjet.'</p>
							<div class="row">
								<div class="col-xs-12">
									<p> Catégorie :'.$v->nomCategorie.'</p>
								</div>
							</div>
						</div>
					<div class="col-xs-6">
						<p> Note :';if($v->niveau !=null ){ echo '<img class="etoile" src="./lib/image/'.$v->niveau.'_etoiles.png">';}else{echo ' Non notée ';} echo '</p>
							<div class="row">
								<div class="col-xs-12">
									<a href="./index.php?controller=objet&action=consultationO&idObjet='.$v->idObjet.'" <button type="button" class="btn btn-default btn-xs "> Consulter</button> </a>
									<a href="./index.php?controller=offre&action=deleteO&idObjet='.$v->idObjet.'" <button type="button" class="btn btn-default btn-xs "> Supprimer</button> </a>
									<a href="./index.php?controller=offre&action=indisponibleO&idObjet='.$v->idObjet.'" <button type="button" class="btn btn-default btn-xs "> Rendre indisponible</button> </a>
								</div>
							</div>
						</div>
					</div>
				</div>
					';
				}?>
</div>
<div class="row body">
	<legend class="col-md-12"> Mes objets en cours de prêt </legend>
</div>
<div class="row body">
	<?php
		$k=0;
		foreach($tab_enechange as $v){
			echo'
				<div class="col-xs-4">
					<img class="col-xs-4" style="padding:0px 10px 25px 0px;width:85px;height:100px;" src="'.$v->image.'">
					<div class="col-xs-7 listeE" style="padding:0px 0px 0px 0px;" > 
						<div class="col-xs-6" style="padding:0px 0px 0px 0px;">
							<p> Nom du Produit :'.$v->nomObjet.'</p>
							<div class="row">
								<div class="col-xs-12">
									<p> Catégorie :'.$v->nomCategorie.'</p>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12">
									';foreach($tab_emprunteur as $e){ 
									if(($e->isRendu==0)&&($e->isPrete==1)&&($e->idOffre==$e->idOffre)){
										echo '
									<p> Emprunteur :'.$e->login.'</p>
								</div>
							</div>
						</div>
					<div class="col-xs-6">
						<p> Note :';if($e->niveau !=null ){ echo '<img class="etoile" src="./lib/image/'.$e->niveau.'_etoiles.png">';}else{echo ' Non notée ';} echo '</p>';}break;} echo '
							<div class="row">
								<div class="col-xs-12">
									<a href="./index.php?controller=objet&action=consultationO&idObjet='.$v->idObjet.'" <button type="button" class="btn btn-default btn-xs "> Consulter</button> </a>
								</div>
							</div>
						</div>
					</div>
				</div>
					';
				}?>
</div>
<a class="body" href="./index.php?controller=utilisateur&action=monprofil">Retour profil</a>

