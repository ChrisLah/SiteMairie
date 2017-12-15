<div class="row body">
	 <?php foreach($tab_info as $n){ echo '<legend class="col-md-12"> Liste d\'objet de la catégorie '.$n->nomCategorie.' </legend>';break;}?>
</div>

<div class=" body">
  <p>Liste :</p>            
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Nom de l'Objet</th>
        <th>Catégorie de l'Objet</th>
        <th>Marque</th>
		<th>Commande</th>
      </tr>
    </thead>
    <tbody>
	  <?php foreach($tab_info as $n){echo '
      <tr>
		  <td>'.$n->nomObjet.'</td>
		  <td>'.$n->nomCategorie.'</td>
		  <td>'.$n->marque.'</td>
		  <td>
		  <a  href="./index.php?controller=objet&action=deleteDD&idObjet='.$n->idObjet.'&idCategorie='.$n->idCategorie.'" type="button" class="btn btn-default"> Supprimer</button> </a>
		  </td>
      </tr>';
	   }?>
    </tbody>
  </table>
  <a href="./index.php?controller=categorie&action=listecategorie"> Retour </a>
</div>
