//Ajout des select 'select2' et récupération des événements
$(document).ready(function() {
    $('#selectEmployee').select2({
      placeholder: "Cliquez et sélectionnez pour filtrer avec un/des employés ‎‍💼"
    });

    $('#selectEmployee').on('select2:select', function(e) {
      filterTable();
    });

    $('#selectEmployee').on('select2:unselect', function(e) {
      filterTable();
    });

    $('#selectGroup').select2({
      placeholder: "Cliquez et sélectionnez pour filtrer avec un/des groupes 🗄️",
    });

    $('#selectGroup').on('select2:select', function(e) {
      var select_val = $(e.currentTarget).val();
      modifyFormationSelect(select_val);
      filterTable();
    });

    $('#selectGroup').on('select2:unselect', function(e) {
      var select_val = $(e.currentTarget).val();
      modifyFormationSelect(select_val);
      testSelectedFormation(select_val);
      filterTable();
    });

    $('#selectFormation').select2({
      placeholder: "Cliquez et sélectionnez pour filtrer avec une/des formations 🎓",
    });

    $('#selectFormation').on('select2:select', function(e) {
      filterTable();
    });

    $('#selectFormation').on('select2:unselect', function(e) {
      filterTable();
    });

});

//Modifie le select de formation en fonction du groupe sélectionné
function modifyFormationSelect(selected){
  let formation = document.getElementsByName('formation');
  if(selected.length == 0){
    for (var i = 0; i < formation.length; i++) {
      formation[i].removeAttribute('disabled','');
    }
  }else{
    for (var i = 0; i < formation.length; i++) {
      for (var j = 0; j < selected.length; j++) {
        if(formation[i].getAttribute('data-grp')==selected[j]){
           formation[i].removeAttribute('disabled','');
          break;
        }else{
           formation[i].setAttribute('disabled','');
        }
      }
    }
  }

  $('#selectFormation').select2({
    placeholder: "Cliquez et sélectionnez pour filtrer avec une/des formations 🎓",
  });
}

//Retire les formations correspondants au groupe désélectionné
function testSelectedFormation(){
  let data = $("#selectFormation").val();
  $('#selectFormation').val(data);
  $('#selectFormation').trigger('change');
}

//Affichage du commentaire si une ligne est sélectionnée
function displayComment(content){
  let modal = document.getElementById('modalBody');
  document.getElementById('modalTitle').innerHTML = 'Commentaire :';
  if(content == ""){
    modal.innerHTML = '<p class="fs-5 text-center">Aucun commentaire</p>'
  }else{
    modal.innerHTML = '<p class="fs-5 text-center">'+content+'</p>'
  }
  $('#modalId').modal('toggle');
}

//Refresh du tableau en fonction des filtres
function filterTable(){
  let employee = $("#selectEmployee").val();
  let formation = $("#selectFormation").val();
  let group = $("#selectGroup").val();
  let date = document.getElementById('dateInput').value;
  $.ajax({
     url : 'jobReporting/changeTableContent.php',
     type : 'POST',
     data: {'employee':JSON.stringify(employee),'formation':JSON.stringify(formation),'group':JSON.stringify(group),'date':date},
     success : function(result){
       document.getElementById('tableBody').innerHTML=result;
     }
  });
}
