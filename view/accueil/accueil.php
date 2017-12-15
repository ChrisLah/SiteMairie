		<?php if(isset($_SESSION['Form_succes'])){
            if($_SESSION['Form_succes']==1){
                echo '
                <div class="alert alert-success alert-dismissable">
					<a href="./index.php?controller=echange&action=mesechanges" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Votre requete a été envoyée, merci de votre aide !</strong>
                </div>';
				$_SESSION['Form_succes']=0;
            }
        } 
?>


	<div class="row body " style="padding-bottom:50px;padding-top:50px;">
		<div class="col-sm-offset-1 col-sm-4 formulaire1 ">
			<div class="row listeOA">
				<form style="margin-bot:20px;" class="col-lg-12" method="post" action="./index.php?controller=accueil&action=rechercheO">
				  <legend>Je recherche :</legend>
				  	<div class="form-group">
					  <input id="objet" type="text" placeholder="Qu'est ce que vous voulez emprunter ?" name="rechercheO" class="form-control">
					</div>
					<div class="form-group">
					  <select name="rechercheC1" id="select" class="form-control">
						<option value="0">Toutes les catégories</option>
						<?php
							foreach($tab_c as $c){
								echo '<option value="'.$c->idCategorie.'">'.$c->nomCategorie.'</option>';}
						?>
					  </select>
					</div>
					<input type="submit" value="Rechercher" />
				</form>
			</div>
			<div class="row listeOA ">
				<h4 class="col-sm-offset-1"> Exemples d'offres </h4>
				<?php 
					$i=0;
					foreach($tab_op as $v){
						echo'
						<div class="row elemO">
							<img class="col-xs-4" style="padding:0px 10px 25px 0px;width:85px;height:100px;" src="'.$v->image.'">
							<div class="col-xs-7 listeE" style="padding:0px 0px 0px 0px;" > 
								<div class="col-xs-6" style="padding:0px 0px 0px 0px;">
									<p> Nom du Produit :'.$v->nomObjet.'</p>
									<div class="row">
										<div class="col-xs-12">
											<p> Catégorie :'.$v->nomCategorie.'</p>
												<div class="row">
													<p class="col-xs-12"> Prêteur : '.$v->login.'</p>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xs-6">
									<p> Note :';if($v->niveau !=null ){ echo '<img class="etoile" src="./lib/image/'.$v->niveau.'_etoiles.png">';}else{echo ' Non notée ';} echo '</p>
									<div class="row">
										<div class="col-xs-12">
											<a href="./index.php?controller=objet&action=consultationO&idObjet='.$v->idObjet.'" <button type="button" class="btn btn-default btn-xs "> Consulter</button> </a>
										</div>
									</div>
								</div>
							</div>
						</div>
						';
						if ($i++ == 3) break;
					}
					
				?>
				<a href="./index.php?controller=offre&action=listO">Plus d'offres ...</a>
			</div>
		</div>

		<div class=" col-sm-offset-2 col-sm-4 formulaire2 ">
			<div class="row listeDA">
				<form class="col-lg-12" method="post" action="./index.php?controller=accueil&action=rechercheD">
				  <legend>Je prête :</legend>
				  <div class="form-group">
					  <input id="objet" type="text" placeholder="Qu'est ce que vous voulez prêter ?" name="rechercheO2" class="form-control">
				</div>
					<div class="form-group">
					  <select name="rechercheC2" id="select" class="form-control">
						<option value="0">Toutes les catégories</option>
						<?php
							foreach($tab_c as $c){
								echo '<option value="'.$c->idCategorie.'">'.$c->nomCategorie.'</option>';}
						?>
					  </select>
					</div>
					<input type="submit" value="Rechercher" />
				</form>
			</div>
			<div class="row listeDA" >
				<h4 class="col-sm-offset-1"> Exemples de demandes </h4>
				<?php 
					$j=0;
					foreach($tab_dp as $p){
						echo'
						<div class="row elemD">
							<img class="col-xs-4" style="padding:0px 10px 25px 0px;width:85px;height:100px;" src="'.$p->image.'">
							<div class="col-xs-7 listeE" style="padding:0px 0px 0px 0px;" > 
								<div class="col-xs-6" style="padding:0px 0px 0px 0px;">
									<p> Nom du Produit :'.$p->nomObjet.'</p>
									<div class="row">
										<div class="col-xs-12">
											<p> Catégorie :'.$p->nomCategorie.'</p>
												<div class="row">
													<p class="col-xs-12"> Emprunteur : '.$p->login.'</p>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xs-6">
									<p> Note :';if($p->niveau !=null ){ echo '<img class="etoile" src="./lib/image/'.$p->niveau.'_etoiles.png">';}else{echo ' Non notée ';} echo '</p>
									<div class="row">
										<div class="col-xs-12">
											<a href="./index.php?controller=objet&action=consultationD&idObjet='.$p->idObjet.'" <button type="button" class="btn btn-default btn-xs "> Consulter</button> </a>
										</div>
									</div>
								</div>
							</div>
						</div>
						';
						if ($j++ == 3) break;
					}
				?>	
				<a href="./index.php?controller=demande&action=listD">Plus de demandes ...</a>
			</div>
		</div>

	</div>
</div>
<div class="row" style="background-color:white;padding-bottom:50px;border-top:ridge;">
	<h3 class="row" style="padding-left:100px;" > Projet Pradéens solidaires, simple et facile ! </h3>
	<BR>
	<div class="row">
		<div class="col-xs-offset-1 col-xs-4"  style >
			<div class="row">
				<h3> 1. Envie d'être prêteur ou emprunteur ? </h3>
				<p style="font-size:16px;"> Publiez ou recherchez des offre(s) ou/et des demandes ! </p>
			</div>
			<div class="row">
				<h3> 2. Choississez votre objet ! </h3>
				<p style="font-size:16px;"> Les utilisateurs peuvent proposer leur aide à propos des demandes ou des offres en ligne ! </p>
			</div>
			<div class="row" >
				<h3> 3. Participez à la solidarité ! </h3>
				<p style="font-size:16px;"> Ainsi vous participerez à l'élan de solidarité de Prades-le-lez ! </p>
			</div>
		</div>
		<div class="col-xs-offset-6 ">
			<iframe  width="560" height="315" src="https://www.youtube.com/embed/wOnE5-vtRus" frameborder="0" allowfullscreen></iframe>
		</div>
	</div>

</div>
<div class="row" style="background-color:#E1E1E1;border-top:ridge;padding-bottom:50px;">
	<h3 class="row" style="padding-left:100px;" > Ce qui vous plaira </h3>
	<div class="row">
		<div class="col-sm-offset-1 col-xs-3">
			<img  style="width:70%;height:70%;" src="./lib/image/solidarité.png">
			<h4> Echanger gratuitement et en confiance </h4>
			<p> Ici vous pourrez emprunter ou prêter des objets gratuitement en toute sécurité ! </p>
		</div>
		<div class="col-sm-offset-1 col-xs-3">
			<img style="width:68%;height:68%;" src="./lib/image/coin_money_icon-icons.com_51091.png">
			<h4> Economisez </h4>
			<p> Grâce à cette plateforme, vous n'aurez même plus besoin de louer un bien </p>
		</div>
		<div class="col-sm-offset-1 col-xs-3">
			<img style="width:68%;height:68%;" src="./lib/image/recycle-logo2.png">
			<h4> Réduisez l'empreinte environnementale </h4>
			<p> A la place de louer ou d'acheter des biens qui sont fabriqués loin, profitez des objets des Pradéens à proximité</p>
		</div>
	</div>
</div>
		
