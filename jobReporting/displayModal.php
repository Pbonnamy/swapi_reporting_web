<?php
require_once('../INCLUDE/connexionBDD.php');

$bdd = connexionBDD();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$query = $bdd->prepare('SELECT nom, prenom,id_salarie FROM exam2_salarie ORDER BY nom ASC');
$query->execute();

$count = 0;

echo '<br><select id="modalSelectEmployee" class="form-select mt-3"><option></option>';

while($employee = $query->fetch()){
  $count++;
  echo '<option value="'.$employee['id_salarie'].'">'.$employee['nom'].' '.$employee['prenom'].'</option>';
}

echo '</select>';

$query = $bdd->prepare("SELECT exam2_groupe.libelle as grpLibelle,GROUP_CONCAT(exam2_formation.libelle) as formLibelle,GROUP_CONCAT(exam2_formation.id_formation) as formId
                        FROM exam2_formation
                        JOIN exam2_groupe ON exam2_formation.id_groupe = exam2_groupe.id_groupe
                        GROUP BY exam2_groupe.libelle");
$query->execute();

$dataArray = array();
$formationLibelle = array();
$formationId = array();

while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
    $dataArray[] = $data;
}

echo
'<br><br><select id="modalSelectFormation" class="form-select"><option></option>';

for ($i=0; $i < count($dataArray); $i++) {
  echo '<optgroup label="'.$dataArray[$i]['grpLibelle'].'">';
  $formationLibelle = explode(',',$dataArray[$i]['formLibelle']);
  $formationId = explode(',',$dataArray[$i]['formId']);
  for ($j=0; $j < count($formationId); $j++) {
    echo '<option value="'.$formationId[$j].'">'.$formationLibelle[$j].'</option>';
  }
  echo '</optgroup>';
}

echo
'</select>';

echo
'<div class="d-flex mt-3">
  <div class="flex-fill text-center">
    <p class="fs-5">Date de début</p>
    <input type="date" id="startDateModal">
  </div>
  <div class="flex-fill text-center">
    <p class="fs-5">Date de fin</p>
    <input type="date" id="endDateModal">
  </div>
</div>
<p class="text-center mt-4 fs-5">Commentaire</p>
<div class="input-group">
  <textarea class="form-control" id="commentModal"></textarea>
</div>
<p id="errorModal" class="mt-3 text-center text-danger"></p>
<div class="d-grid mt-3 mb-3">
  <button class="btn btn-primary fs-5" type="button" onclick="registerEmployee()">Valider</button>
</div>';
?>
