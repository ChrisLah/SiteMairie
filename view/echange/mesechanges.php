		<?php if(isset($_SESSION['voted'])){
            if($_SESSION['voted']==1){
                echo '
                <div class="alert alert-info alert-dismissable">
					<a href="./index.php?controller=echange&action=mesechanges" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Vous avez déjà voté pour cette offre et il est impossible de voter une seconde fois !</strong>
                </div>';
				$_SESSION['voted']=0;
            }
        } 
?>
<div class="row body">
	<legend class="col-md-12"> Mes échanges en cours avec mes propositions d'offres </legend>
</div>
<div class="row body">
	<?php
		$k=0;
		foreach($tab_enechangeO as $v){
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
									if(($e->isRendu==0)&&($e->isPrete==1)&&($e->idOffre==$v->idOffre)){
										echo '
									<p> Emprunteur :'.$e->login.'</p>
								</div>
							</div>
						</div>
					<div class="col-xs-6">
						<p> Note :';if($v->niveau !=null ){ echo '<img class="etoile" src="./lib/image/'.$v->niveau.'_etoiles.png">';}else{echo ' Non notée ';} echo '</p>';}break;} echo '
							<div class="row">
								<div class="col-xs-12">
									<a href="./index.php?controller=objet&action=consultationO&idObjet='.$v->idObjet.'" <button type="button" class="btn btn-default btn-xs "> Consulter</button> </a>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12">
									<a href="./index.php?controller=echange&action=EndEchangeO&idObjet='.$v->idObjet.'&idOffre='.$v->idOffre.'&idDemande='.$v->idDemande.'&date='.$v->date_debutEchange.'" <button type="button" class="btn btn-default btn-xs "> Terminer l\'échange</button> </a>
								</div>
							</div>
						</div>
					</div>
				</div>
					';
				}?>
</div>
<div class="row body">
	<legend class="col-md-12"> Mes échanges en cours avec mes demandes d'offres </legend>
</div>
<div class="row body">
	<?php
		$k=0;
		$l=0;
		foreach($tab_enechangeD as $v){
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
									';foreach($tab_preteur as $p){ 
									if(($p->isRendu==0)&&($p->isPrete==1)&&($p->idDemande==$v->idDemande)){
										echo '
									<p> Prêteur :'.$p->login.'</p>
								</div>
							</div>
						</div>
					<div class="col-xs-6">
						<p> Note :';if($p->niveau !=null ){ echo '<img class="etoile" src="./lib/image/'.$p->niveau.'_etoiles.png">';}else{echo ' Non notée ';} echo '</p>';}break;} echo '
							<div class="row">
								<div class="col-xs-12">
									<a href="./index.php?controller=objet&action=consultationD&idObjet='.$v->idObjet.'" <button type="button" class="btn btn-default btn-xs "> Consulter</button> </a>
								</div>
							</div>
						</div>
					</div>
				</div>
					';
				}?>
</div>
<div class="row body">
	<legend class="col-md-12"> Mes echanges terminés </legend> <! -- ensemble avec les 2 en attente + isprete =  0 et rendu = 1-- !>
</div>
<div class="row body">
	<?php
	$j=0;
		foreach($tab_fin as $v){
			echo'
				<div class="col-xs-4">
					<img class="col-xs-4" style="padding:0px 10px 25px 0px;width:85px;height:100px;" src="'.$v->image.'">
					<div class="col-xs-7 listeE" style="padding:0px 0px 0px 0px;" > 
						<div class="col-xs-6" style="padding:0px 0px 0px 0px;">
							<p> Nom du Produit :'.$v->nomObjet.'</p>
							<div class="row">
								<div class="col-xs-12">
									<p> Catégorie :'.$v->nomCategorie.'</p>
									<div class="row">';
										if(($User->get('idUser')==$v->idPreteur )){
											foreach($tab_emprunteur as $e){
												if($e->idEmprunteur == $v->idEmprunteur){
													echo '<p class="col-xs-12"> Emprunteur :'.$e->login.'</p>';
												}
											}	
										}else if($User->get('idUser')==($v->idEmprunteur )){										
											foreach($tab_preteur as $p){
												if($p->idPreteur == $v->idPreteur){
													echo '<p class="col-xs-12"> Prêteur :'.$p->login.'</p>';
												}
											}
										}
										echo '	
									</div>
								</div>
							</div>
						</div>
					<div class="col-xs-6">
							<div class="row">
								<div class="col-xs-12">';
									if(($User->get('idUser')==$v->idPreteur )){ echo '
									<a href="./index.php?controller=objet&action=consultationD&idObjet='.$v->idObjet.'" <button type="button" class="btn btn-default btn-xs "> Consulter</button> </a>';}
									else{echo '
									<a href="./index.php?controller=objet&action=consultationO&idObjet='.$v->idObjet.'" <button type="button" class="btn btn-default btn-xs "> Consulter</button> </a>
									<a href="./index.php?controller=echange&action=noteD&idObjet='.$v->idObjet.'&idOffre='.$v->idOffre.'&idDemande='.$v->idDemande.'&date='.$v->date_debutEchange.'" <button type="button" class="btn btn-default btn-xs "> Noter l\'offre</button> </a>';}
									echo '								
								</div>
							</div>
						</div>
					</div>
				</div>
					';
					if ($j++ == 7) break;
				}?>
</div>
<a class="body" href="./index.php?controller=utilisateur&action=monprofil">Retour profil</a>

