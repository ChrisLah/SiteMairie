<div class="row body">
	<legend class="col-md-12"> Adhérents </legend>
</div>

<div class=" body">
  <p>Liste de tous les adhérents :</p>            
  <table class="table table-hover">
    <thead>
      <tr>
		<th>Login</th>
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
		  <td>'.$n->login.'</td>
		  <td>'.$n->nom.'</td>
		  <td>'.$n->prenom.'</td>
		  <td>'.$n->telephone.'</td>
		  <td>'.$n->email.'</td>
		  <td>'.$n->quartier.'</td>
		  <td>'.$n->nomAssurance.'</td>
		  <td>
		  <a  href="./index.php?controller=utilisateur&action=gotomodified&idUser='.$n->idUser.'" type="button" class="btn btn-default"> Consulter</button> </a>
		  <a  href="./index.php?controller=utilisateur&action=deletedU&idUser='.$n->idUser.'" type="button" class="btn btn-default"> Supprimer</button> </a>
		  </td>
      </tr>';
	   }?>
    </tbody>
  </table>
  <a href="./index.php?controller=utilisateur&action=panneauAdmin">Retour</a>
  <a href="./index.php?controller=utilisateur&action=addUser"> Ajouter un utilisateur </a>
</div>
