<div class="row body">
	<legend class="col-md-12"> Demandes d'échanges </legend>
</div>

<div class=" body">
  <p>Liste de toutes les demandes d'échanges :</p>            
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Nom de l'Objet</th>
        <th>Catégorie de l'Objet</th>
        <th>Nom Emprunteur</th>
		<th>Nom Preteur</th>
		<th>Mail Emprunteur</th>
		<th>Mail Preteur</th>
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
		  <td>'.$n->emailEmprunteur.'</td>
		  <td>'.$n->emailPreteur.'</td>
		  <td>
		  <a  href="./index.php?controller=echange&action=deleteP&idOffre='.$n->idOffre.'&idDemande='.$n->idDemande.'&idP='.$n->idPreteur.'&idE='.$n->idEmprunteur.'" type="button" class="btn btn-default"> Supprimer</button> </a>
		  </td>
      </tr>';
	   }?>
    </tbody>
  </table>   <a href="./index.php?controller=utilisateur&action=panneauAdmin">Retour</a>
</div>
