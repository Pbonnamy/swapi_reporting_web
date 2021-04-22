<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <?php require_once('INCLUDE/head.php') ?>
    <title>Reporting de Formation</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="JS/sortTable.js"></script>
    <script src="JS/registerEmployee.js"></script>
    <script src="JS/filterTable.js"></script>
  </head>
  <body>

    <div class="modal fade" id="modalId" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTitle"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body px-5" id="modalBody">
          </div>
        </div>
      </div>
    </div>
    <div class="position-relative" style="margin-left:10%;">
      <button type="button" class="btn btn-primary position-absolute top-50 start-0 translate-middle" onclick="location.href='index.php'">Retourner à l'accueil</button>
    </div>

    <div class="container">

        <p class="text-center fs-1 my-5 titleFont">Reporting de Formation</p>


      <div class="d-grid mb-3 col-6 mx-auto">
        <button class="btn btn-primary fs-5" type="button" onclick="showModal()">Inscrire un salarié à une formation</button>
      </div>

      <div class="mainPage text-center">
      <?php
      require_once('INCLUDE/connexionBDD.php');

      $bdd = connexionBDD();

      ini_set('display_errors', 1);
      ini_set('display_startup_errors', 1);
      error_reporting(E_ALL);

      $query = $bdd->prepare("SELECT nom, prenom,id_salarie FROM exam2_salarie");
      $query->execute();


      echo '<br><select id="selectEmployee" class="form-select mt-3" name="name[]" multiple="multiple">';
      while($employee = $query->fetch()){
        echo '<option value="'.$employee['id_salarie'].'">'.$employee['nom'].' '.$employee['prenom'].'</option>';
      }
      echo '</select>';

      $query = $bdd->prepare("SELECT libelle,id_groupe FROM exam2_groupe");
      $query->execute();

      echo '<br><br><select id="selectGroup" class="form-select mt-3" name="group[]" multiple="multiple">';
      while($group = $query->fetch()){
        echo '<option value="'.$group['id_groupe'].'">'.$group['libelle'].'</option>';
      }
      echo '</select>';

      $query = $bdd->prepare("SELECT exam2_groupe.libelle as grpLibelle,exam2_formation.libelle as formLibelle,exam2_groupe.id_groupe,exam2_formation.id_formation
                              FROM exam2_formation
                              INNER JOIN exam2_groupe ON exam2_formation.id_groupe = exam2_groupe.id_groupe");
      $query->execute();

      echo '<br><br><select id="selectFormation" class="form-select mt-3" name="formation[]" multiple="multiple">';
      while($formation = $query->fetch()){
        echo '<option style="display:none" data-form="'.$formation['id_formation'].'" data-grp="'.$formation['id_groupe'].'" name="formation" value="'.$formation['id_formation'].'">'.$formation['formLibelle'].'</option>';
      }
      echo '</select>';

      ?>

      <div class="d-flex justify-content-center mt-4">
          <p class="pt-1">Cliquez et sélectionnez pour filtrer avec une date 📅 : &nbsp&nbsp&nbsp</p>
          <div class="">
            <input id="dateInput" type="month" class="align-text-bottom " onchange="filterTable()">
            <button class="btn btn-danger btn-sm align-bottom ms-2" onclick="javascript:dateInput.value='';this.blur();filterTable();">Effacer</button>
          </div>
      </div>
      </div>

      <table id="table" class="mt-4 mb-5 table table-bordered table-striped text-center fs-5">
        <thead>
          <tr class="borderCellHead tableHeader">
            <th scope="col" onclick="sortTable(0)" class="clickable ">Salarié <label class="float-end clickable" id="dirSymbole0">🔃</label></th>
            <th scope="col" onclick="sortTable(1)" class="clickable ">Groupe <label class="float-end clickable" id="dirSymbole1">🔃</label></th>
            <th scope="col" onclick="sortTable(2)" class="clickable ">Formation <label class="float-end clickable" id="dirSymbole2">🔃</label></th>
            <th scope="col" >Date de début</th>
            <th scope="col" >Date de fin</th>
          </tr>
        </thead>
        <tbody id="tableBody">
          <?php

          $query = $bdd->prepare("SELECT exam2_salarie.nom,exam2_salarie.prenom,exam2_formation.libelle,exam2_salarie_form.date_debut,exam2_salarie_form.commentaire,exam2_salarie_form.date_fin,exam2_groupe.libelle as grpLibelle
                                  FROM exam2_salarie_form
                                  JOIN exam2_salarie ON exam2_salarie_form.id_salarie = exam2_salarie.id_salarie
                                  JOIN exam2_formation ON exam2_salarie_form.id_formation = exam2_formation.id_formation
                                  JOIN exam2_groupe ON exam2_formation.id_groupe = exam2_groupe.id_groupe");
          $query->execute();

          while($employee = $query->fetch()){
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
        </tbody>
      </table>

    </div>
  </body>
</html>
