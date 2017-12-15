<?php
if(isset($_SESSION['login'])){
require_once File::build_path(array('model','ModelUtilisateur.php'));
$idUser=ModelUtilisateur::getIdByLogin($_SESSION['login']);	
}

require_once File::build_path(array("view", 'header.php'));

$filepath = File::build_path(array("view", $controller, "$view.php"));
require $filepath;

require_once File::build_path(array("view", 'footer.html'));
