<div class="row body">

	<form class="col-md-offset-1 col-md-5" method="post" action="./index.php?controller=accueil&action=rechercheO">
		<legend> Offres disponibles : </legend>
		<div style="text-align:center;">
			<select name="rechercheC1" id="select">
				<option value="0">Toutes les catégories</option>
				<?php
					foreach($tab_c as $c){
						echo '<option value="'.$c->idCategorie.'">'.$c->nomCategorie.'</option>';}
				?>
			</select>
			<input id="objet" type="text" placeholder="Qu'est ce que vous voulez emprunter ?" name="rechercheO">
			<input id="ville" type="text" placeholder="Où ça ?" name="rechercheV">
			<input type="submit" value="Rechercher" />
		</div>
	</form>
	<form class="col-md-offset-1 col-md-5" method="post" action="./index.php?controller=accueil&action=rechercheD">
	<legend> Demandes disponibles : </legend>
		<div style="text-align:center;">
			<select name="rechercheC2" id="select">
				<option value="0">Toutes les catégories</option>
				<?php
					foreach($tab_c as $c){
						echo '<option value="'.$c->idCategorie.'">'.$c->nomCategorie.'</option>';}
				?>
			</select>
			<input id="objet" type="text" placeholder="Qu'est ce que vous voulez prêter ?" name="rechercheO">
			<input id="ville" type="text" placeholder="Où ça ?" name="rechercheV">
			<input type="submit" value="Rechercher" />
		</div>
	</form>
</div>
<div class="row row-2 body" style="text-align:center;">
		<div class="col-md-offset-1 col-md-5" >
			<?php 
				$i=0;
				foreach($tab_op as $v){
					echo'
					<div class="row elemO">
						<img class="col-sm-4" style="padding:0px 10px 25px 0px;width:85px;height:100px;" src="'.$v->image.'">
						<div class="col-xs-8 listeE" style="padding:0px 0px 0px 0px;" > 
							<div class="col-xs-6" style="padding:0px 0px 0px 0px;">
								<p> Nom du Produit :'.$v->nomObjet.'</p>
								<div class="row">
									<div class="col-xs-12">
										<p> Catégorie :'.$v->nomCategorie.'</p>
											<div class="row">
												<p class="col-xs-12"> Prêteur :'.$v->idUser.'</p>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xs-6">
								<p> Niveau :'.$v->niveau.'</p>
								<div class="row">
									<div class="col-xs-12">
										<a href="./index.php?controller=objet&action=consultationO&idObjet='.$v->idObjet.'" <button type="button" class="btn btn-default btn-xs "> Consulter</button> </a>
									</div>
								</div>
							</div>
						</div>
					</div>
					';
				}
			?>
			<div class="row">
				<div class="col-sm-offset-4 col-sm-5" >
				<?php
					echo '<p align="center">Page : ';
					for($i=1; $i<=$nombreOffre; $i++){
						if($i==$pageOActuelle){
							echo ' [ '.$i.' ] ';
						} 
						else //Sinon...
						{
							echo ' <a href="New4.php?page='.$i.'">'.$i.'</a> ';
						}
					}
				?>
				</div>
			</div>
		</div>
		<div class="col-md-offset-1 col-md-5" >
			<?php 
				$j=0;
				foreach($tab_dp as $v){
					echo'
					<div class="row elemO">
						<img class="col-sm-4" style="padding:0px 10px 25px 0px;width:85px;height:100px;" src="'.$v->image.'">
						<div class="col-xs-8 listeE" style="padding:0px 0px 0px 0px;" > 
							<div class="col-xs-6" style="padding:0px 0px 0px 0px;">
								<p> Nom du Produit :'.$v->nomObjet.'</p>
								<div class="row">
									<div class="col-xs-12">
										<p> Catégorie :'.$v->nomCategorie.'</p>
											<div class="row">
												<p class="col-xs-12"> Prêteur :'.$v->idUser.'</p>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xs-6">
								<p> Niveau :'.$v->niveau.'</p>
								<div class="row">
									<div class="col-xs-12">
										<a href="./index.php?controller=objet&action=consultationD&idObjet='.$v->idObjet.'" <button type="button" class="btn btn-default btn-xs "> Consulter</button> </a>
									</div>
								</div>
							</div>
						</div>
					</div>
					';
				}
			?>
			<div class=row">
				<div class="col-sm-offset-4 col-sm-5" >
				<?php
					echo '<p align="center">Page : ';
					for($j=1; $j<=$nombreDemande; $j++){
						if($j==$pageDActuelle){
							echo ' [ '.$j.' ] ';
						} 
						else //Sinon...
						{
							echo ' <a href="New4.php?page='.$j.'">'.$j.'</a> ';
						}
					}
				?>
				</div>
			</div>
		</div>
</div>
