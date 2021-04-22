<?php
require_once('../INCLUDE/connexionBDD.php');

$bdd = connexionBDD();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$employee = json_decode($_POST['employee']);
$formation = json_decode($_POST['formation']);
$group = json_decode($_POST['group']);

$dateEnd = $_POST['date'];
$dateStart = date("Y-m-t", strtotime($dateEnd));


$query = "SELECT exam2_salarie.nom,exam2_salarie.prenom,exam2_formation.libelle,exam2_salarie_form.date_debut,exam2_salarie_form.commentaire,exam2_salarie_form.date_fin,exam2_groupe.libelle as grpLibelle
          FROM exam2_salarie_form
          JOIN exam2_salarie ON exam2_salarie_form.id_salarie = exam2_salarie.id_salarie
          JOIN exam2_formation ON exam2_salarie_form.id_formation = exam2_formation.id_formation
          JOIN exam2_groupe ON exam2_formation.id_groupe = exam2_groupe.id_groupe";

$countWhere = 0;


for ($i=0; $i < count($employee); $i++) {
  if($countWhere == 0){
    $query .= " WHERE (exam2_salarie.id_salarie = '".$employee[$i]."'";
    $countWhere += 1;
  }else{
    $query .= " OR exam2_salarie.id_salarie = '".$employee[$i]."'";
  }
  if($i == (count($employee)-1)){
    $query .= ")";
  }
}

for ($i=0; $i < count($formation); $i++) {
  if($countWhere == 0){
    $query .= " WHERE (exam2_formation.id_formation = '".$formation[$i]."'";
    $countWhere += 1;
  }elseif(count($employee)>0 && $i == 0){
    $query .= " AND (exam2_formation.id_formation = '".$formation[$i]."'";
  }else{
    $query .= " OR exam2_formation.id_formation = '".$formation[$i]."'";
  }
  if($i == (count($formation)-1)){
    $query .= ")";
  }
}

for ($i=0; $i < count($group); $i++) {
  if($countWhere == 0){
    $query .= " WHERE (exam2_groupe.id_groupe = '".$group[$i]."'";
    $countWhere += 1;
  }elseif((count($employee)>0 || count($formation)>0) && $i == 0){
    $query .= " AND (exam2_groupe.id_groupe = '".$group[$i]."'";
  }else{
    $query .= " OR exam2_groupe.id_groupe = '".$group[$i]."'";
  }
  if($i == (count($group)-1)){
    $query .= ")";
  }
}

if($dateEnd != ""){
  if($countWhere == 0){
    $query .= " WHERE (exam2_salarie_form.date_debut <= '".$dateStart."' AND exam2_salarie_form.date_fin >= '".$dateEnd."')";
    $countWhere += 1;
  }elseif((count($employee)>0 || count($formation)>0 || count($group)>0)){
    $query .= " AND (exam2_salarie_form.date_debut <= '".$dateStart."' AND exam2_salarie_form.date_fin >= '".$dateEnd."')";
  }
}


$queryEmployee = $bdd->prepare($query);
$queryEmployee->execute();

if($queryEmployee->rowCount() == 0){
  echo '<tr><td colspan = "5">Aucun résultat ne correspond</td><tr>';
}
while($employee = $queryEmployee->fetch()){
  echo'
  <tr class="borderCellBody hoverCell" onclick="displayComment(\''.$employee['commentaire'].'\')">
    <td>'.$employee['nom'].' '.$employee['prenom'].'</td>
    <td>'.$employee['grpLibelle'].'</td>
    <td>'.$employee['libelle'].'</td>
    <td>'.date('d/m/Y', strtotime($employee['date_debut'])).'</td>
    <td>'.date('d/m/Y', strtotime($employee['date_fin'])).'</td>
  </tr>
  ';
}
 ?>
