<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>API Star Wars</title>
    <?php require_once('INCLUDE/head.php') ?>
    <script src="JS/contactSWAPI.js"></script>
    <script src="JS/CSVexport.js"></script>
  </head>
  <body class="SWwallpaper">
    <div class="position-relative" style="margin-left:10%;">
      <button type="button" class="btn btn-primary position-absolute top-50 start-0 translate-middle" onclick="location.href='index.php'">Retourner à l'accueil</button>
    </div>
    <div class="container">
      <p class="text-center fs-1 SWtitle mt-5 mb-4">api star wars</p>
      <p id="error" class="SWerror text-center fs-5 mb-2" style="height:40px"></p>
      <div class="d-grid gap-2 col-6 mx-auto">
        <button type="button"  onclick="toCSV()" class="btn  btn-primary mb-5">Exporter en CSV</button>
      </div>
      <table id="table" class="5  table table-bordered tableBack text-center fs-5">
        <thead>
          <tr>
            <th scope="col">Nom</th>
            <th scope="col">Année de naissance</th>
            <th scope="col">Genre</th>
            <th scope="col">Checkbox</th>
          </tr>
        </thead>
        <tbody id="tableBody">
          <label id="positionInfo" data-next="https://swapi.dev/api/people/?page=1" data-previous=""></label>
        </tbody>
      </table>
      <div class="justify-content-center text-center mt-5">
        <label id="loader" class="loader mt-5"></label>
      </div>
        <button id="prevBtn" type="button" class="btn btn-primary w-25" onclick="APIrequest('data-previous')">Précédent</button>
        <button id="nextBtn" type="button" class="btn btn-primary float-end w-25" onclick="APIrequest('data-next')">Suivant</button>
        <p class="text-center fs-4 fw-bold SWtitle" id="pageCount">page 1</p>
    </div>
  </body>
</html>
