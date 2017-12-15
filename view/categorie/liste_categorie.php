<div class="row body">
	<legend class="col-md-12"> Categories </legend>
</div>

<div class=" body">
  <p>Liste de toutes les catégories :</p>            
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Nom Catégorie</th>
        <th>Listes objet de la catégorie</th>
        <th>Commandes</th>
      </tr>
    </thead>
    <tbody>
	  <?php foreach($tab_info as $n){echo '
      <tr>
		  <td>'.$n->nomCategorie.'</td>
		  <td><a href="./index.php?controller=objet&action=listeobjet&idCategorie='.$n->idCategorie.'" > Liste des objets </td>
		  <td>
		  <a  href="./index.php?controller=categorie&action=deleted&idCategorie='.$n->idCategorie.'" type="button" class="btn btn-default"> Supprimer</button> </a>
		  </td>
      </tr>';
	   }?>
    </tbody>
  </table>
      <a href="./index.php?controller=utilisateur&action=panneauAdmin">Retour</a>
	  <a href="./index.php?controller=categorie&action=addCategorie"> Ajouter une Catégorie </a>
</div>
