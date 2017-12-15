<div class="row body">
	<legend class="col-md-12"> Demandes d'offres </legend>
</div>

<div class=" body">
  <p>Liste de toutes les demandes d'offres :</p>            
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Nom de l'Objet</th>
        <th>Catégorie de l'Objet</th>
        <th>Nom Prêteur</th>
		<th>Téléphone</th>
		<th>Mail</th>
		<th>Quartier</th>
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
		  <td>
		  <a  href="./index.php?controller=offre&action=consultedOD&idOffre='.$n->idOffre.'" type="button" class="btn btn-default"> Consulter</button> </a>
		  <a  href="./index.php?controller=offre&action=confirmed&idOffre='.$n->idOffre.'" type="button" class="btn btn-default"> Accepter</button> </a>
		  <a  href="./index.php?controller=offre&action=deleted&idOffre='.$n->idOffre.'" type="button" class="btn btn-default"> Refuser</button> </a>
		  </td>
      </tr>';
	   }?>
    </tbody>
  </table>
  <a href="./index.php?controller=utilisateur&action=panneauAdmin">Retour</a>
</div>
