<div class="row body">
	<form class="col-lg-12" method="post" action="./index.php?controller=accueil&action=rechercheO">
		<div style="text-align:center;">
			<input id="objet" type="text" placeholder="Qu'est ce que vous voulez emprunter ?" name="rechercheO">
			<select name="rechercheC1" id="select">
				<option value="0">Toutes les catégories</option>
				<?php
					foreach($tab_c as $c){
						echo '<option value="'.$c->idCategorie.'">'.$c->nomCategorie.'</option>';}
				?>
			</select>
			<input type="submit" value="Rechercher" />
		</div>
	</form>
</div>
<div class="row row-2 body" style="text-align:center;">
		
		<div class="col-sm-offset-4 col-sm-4 listeO " >
			<div class="listeOA">
			<?php 
				$g=0;
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
												<p class="col-xs-12"> Prêteur :'.$v->login.'</p>
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
					
				}
			 if(empty($tab_op)){ echo 'Si vous n\'avez pas trouvé d\'objet dans cette catégorie, vous pouvez réssayer dans une autre catégorie ! ';} 
			?>
			</div>
		</div>
		<div class=row">
			<div class="col-sm-offset-4 col-sm-4" >
			<?php
				echo '<p align="center">Page : ';
				for($i=1; $i<=$nombreOffre; $i++){
					if($i==$pageOActuelle){
						echo ' [ '.$i.' ] ';
					} 
					else //Sinon...
					{
						echo ' <a href="./index.php?controller=offre&action=listO&pageO='.$i.'">'.$i.'</a>';
;
					}
				}
			?>
			</div>
		</div>
		
</div>
