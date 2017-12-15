<div class="row body">
	<legend class="col-md-12"> Offres </legend>
</div>

<div class=" body">
  <p>Liste de toutes les offres :</p>            
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Nom de l'Objet</th>
        <th>Catégorie de l'Objet</th>
        <th>Nom Prêteur</th>
		<th>Téléphone</th>
		<th>Mail</th>
		<th>Quartier</th>
		<th>Disponible</th>
		<th>Echange</th>
		<th>Commandes</th>
      </tr>
    </thead>
    <tbody>
	  <?php foreach($tab_info as $n){echo '
      <tr>
		  <td>'.$n->nomObjet.'</td>
		  <td>'.$n->nomCategorie.'</td>
		  <td>'.$n->nom.'</td>
		  <td>'.$n->telephone.'</td>
		  <td>'.$n->email.'</td>
		  <td>'.$n->quartier.'</td>
	  ';if($n->isDisponible == 0){echo '<td> Non </td>';}else{echo '<td> Oui </td>';}
	    if($n->isOnEchange == 0){echo '<td> Non </td>';}else{echo '<td> Oui </td>';}echo'
		  <td>
		  <a  href="./index.php?controller=offre&action=consultedOD&idOffre='.$n->idOffre.'" type="button" class="btn btn-default"> Consulter</button> </a>
		  <a  href="./index.php?controller=offre&action=deletedO&idOffre='.$n->idOffre.'" type="button" class="btn btn-default"> Supprimer</button> </a>
		  </td>
      </tr>';
	   }?>
    </tbody>
  </table>
   <a href="./index.php?controller=utilisateur&action=panneauAdmin">Retour</a>
  <a href="./index.php?controller=offre&action=addOffre"> Ajouter une Offre </a>
</div>
