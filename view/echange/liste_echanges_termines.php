<div class="row body">
	<legend class="col-md-12"> Echanges terminés </legend>
</div>

<div class=" body">
  <p>Liste de tous les échanges terminés :</p>            
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Nom de l'Objet</th>
        <th>Catégorie de l'Objet</th>
        <th>Nom Emprunteur</th>
		<th>Nom Preteur</th>
		<th>Date début</th>
		<th>Date fin</th>
		<th>Commandes</th>
      </tr>
    </thead>
    <tbody>
	  <?php foreach($tab_info as $n){echo '
      <tr>
		  <td>'.$n->nomObjet.'</td>
		  <td>'.$n->nomCategorie.'</td>
		  <td>'.$n->nomEmprunteur.'</td>
		  <td>'.$n->nomPreteur.'</td>
		  <td>'.$n->date_debutEchange.'</td>
		  <td>'.$n->date_finEchange.'</td>
		  <td>
		  <a  href="./index.php?controller=echange&action=deleteEC&idEchange='.$n->idEchange.'&date='.$n->date_debutEchange.'" type="button" class="btn btn-default"> Supprimer</button> </a>
		  </td>
      </tr>';
	   }?>
    </tbody>
  </table>
   <a href="./index.php?controller=utilisateur&action=panneauAdmin">Retour</a>
</div>
