<div class="row body">
	<legend class="col-md-12"> Commentaires </legend>
</div>

<div class="row body">
	<form class=" col-sm-3" method="post" action="./index.php?controller=utilisateur&action=rechercheComment1">
		<legend>Commentaires concernant la personne  :</legend>
		<p>
			<select name="idUser" id="user">
				<?php 
					foreach($tab_user as $u){
						echo ' <option value="'.$u->idUser.'">'.$u->login.'</option>';
				}?>
			</select>
		</p>
		<input type="submit" value="Rechercher" />
	</form>
	<form class=" col-sm-3" method="post" action="./index.php?controller=utilisateur&action=rechercheComment2">
		<legend>Commentaires concernant les echanges de la personne  :</legend>
		<p>
			<select name="idUser" id="user">
				<?php 
					foreach($tab_user as $u){
						echo ' <option value="'.$u->idUser.'">'.$u->login.'</option>';
				}?>
			</select>
		</p>
		<input type="submit" value="Rechercher" />
	</form>
	<form class="col-sm-3" method="post" action="./index.php?controller=utilisateur&action=rechercheComment3">
		<legend>Commentaires de la personne concernant d'autres personne :</legend>
		<p>
			<select name="idUser" id="user">
				<?php 
					foreach($tab_user as $u){
						echo ' <option value="'.$u->idUser.'">'.$u->login.'</option>';
				}?>
			</select>
		</p>
		<input type="submit" value="Rechercher" />
	</form>
		<form class="col-sm-3" method="post" action="./index.php?controller=utilisateur&action=rechercheComment4">
		<legend>Commentaires de la personne concernant les échanges :</legend>
		<p>
			<select name="idUser" id="user">
				<?php 
					foreach($tab_user as $u){
						echo ' <option value="'.$u->idUser.'">'.$u->login.'</option>';
				}?>
			</select>
		</p>
		<input type="submit" value="Rechercher" />
	</form>
	<p style="text-align:center;"><a style="margin-top:10px;"  href="./index.php?controller=utilisateur&action=listeCommentaireD" type="button" class="btn btn-default"> Commentaires sur la démarche</button> </a>
	<a  style="margin-top:10px;" href="./index.php?controller=utilisateur&action=listeCommentaireU" type="button" class="btn btn-default"> Commentaires sur l'utilisation du site </button> </a></p>
</div>
<div class="body">
  <p>Liste de tous les commentaires :</p>            
  <table class="table table-hover">
    <thead>
      <tr>
		<?php if(!empty($tab_formU)){echo'
				<th>Commenteur</th>
				<th>Commenté</th>
				<th>Note</th>
				<th>Commentaires</th>';}
			if(!empty($tab_formO)){echo'
				<th>Commenteur</th>
				<th>Commenté</th>
				<th>Objet</th>
				<th>Note</th>
				<th>Commentaires</th>';}
			if(!empty($tab_comment)){echo '
				<th> Commenteur </th>
				<th> Note </th
				<th> Commentaires </th>';
			}
		?>
      </tr>
    </thead>
    <tbody>
		<?php if(!empty($tab_formU)){
				foreach($tab_formU as $c){ echo '
					<tr>
						<td>'.$c->nomCommenteur.'</td>
						<td>'.$c->nomCommente.'</td>
						<td>'.$c->noteCommente.'</td>
						<td>'.$c->Commmentaire.'</td>
					</tr>';
				}
			}if(!empty($tab_formO)){
				foreach($tab_formO as $c){ echo '
					<tr>
						<td>'.$c->nomCommenteur.'</td>
						<td>'.$c->nomCommente.'</td>
						<td>'.$c->nomObjet.'</td>
						<td>'.$c->notation.'</td>
						<td>'.$c->Commentaire.'</td>
					</tr>';
				}
			}
			if(!empty($tab_comment)){
				foreach($tab_comment as $c){ echo ' 
					<tr>
						<td>'.$c->nomCommenteur.'</td>
						<td>'.$c->note.'</td>
						<td>'.$c->avis.'</td>

					</tr>';
					}
			}
		?>
    </tbody>
  </table>
      <a href="./index.php?controller=utilisateur&action=panneauAdmin">Retour</a>
</div>
