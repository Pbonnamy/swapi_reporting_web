<?php
require_once('../INCLUDE/connexionBDD.php');

$bdd = connexionBDD();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$employeeId = $_POST['employeeId'];
$formationId = $_POST['formationId'];
$dateStart =$_POST['dateStart'];
$dateEnd =$_POST['dateEnd'];
$comment = $_POST['comment'];

$query= $bdd->prepare("INSERT INTO exam2_salarie_form (id_salarie,id_formation,date_debut,date_fin,commentaire) VALUES (?,?,?,?,?)");
$query->execute([$employeeId,$formationId,$dateStart,$dateEnd,$comment]);

if($query){
  echo "success";
}else{
  echo "failure";
}
 ?>
