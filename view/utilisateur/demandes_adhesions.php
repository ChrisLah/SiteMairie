<div class="row body">
	<legend class="col-md-12"> Demandes d'adhésions </legend>
</div>

<div class="body">
  <p>Liste de toutes les demandes d'adhésions :</p>            
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Téléphone</th>
		<th>Adresse Email</th>
		<th>Quartier</th>
		<th>Assurance </th>
		<th>Profil</th>
      </tr>
    </thead>
    <tbody>
	  <?php foreach($tab_info as $n){echo '
      <tr>
		  <td>'.$n->nom.'</td>
		  <td>'.$n->prenom.'</td>
		  <td>'.$n->telephone.'</td>
		  <td>'.$n->email.'</td>
		  <td>'.$n->quartier.'</td>
		  <td>'.$n->nomAssurance.'</td>
		  <td>
		  <a  href="./index.php?controller=utilisateur&action=confirmed&idUser='.$n->idUser.'" type="button" class="btn btn-default"> Confirmer</button> </a>
		  <a  href="./index.php?controller=utilisateur&action=consulted&idUser='.$n->idUser.'" type="button" class="btn btn-default"> Consulter</button> </a>
		  <a  href="./index.php?controller=utilisateur&action=deleted&idUser='.$n->idUser.'" type="button" class="btn btn-default"> Refuser</button> </a>
		  </td>
      </tr>';
	   }?>
    </tbody>
  </table>
  <a href="./index.php?controller=utilisateur&action=panneauAdmin">Retour</a>
</div>
