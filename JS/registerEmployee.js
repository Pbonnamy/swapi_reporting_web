// Affichage du modal pour inscrire un employé à une formation
function showModal(){
  $.ajax({
     url : 'jobReporting/displayModal.php',
     success : function(result){
       document.getElementById('modalTitle').innerHTML = 'Inscrivez un salarié à une formation :'
       document.getElementById('modalBody').innerHTML = result;
       $('#modalSelectFormation').select2({
          dropdownParent: $('#modalId'),
          placeholder: "Séléctionnez une formation",
       });

       $('#modalSelectFormation').one('select2:open', function(e) {
           $('input.select2-search__field').prop('placeholder', 'Recherche...');
       });

       $('#modalSelectEmployee').select2({
           dropdownParent: $('#modalId'),
           placeholder: "Séléctionnez un salarié"
       });

       $('#modalSelectEmployee').one('select2:open', function(e) {
           $('input.select2-search__field').prop('placeholder', 'Recherche...');
       });

       $('#modalId').modal('toggle');
     }
  });
}

// Vérification des données et envoie à la BDD
function registerEmployee(){
  let employee = $("#modalSelectEmployee").val();
  let formation = $("#modalSelectFormation").val();
  let dateStart = document.getElementById('startDateModal').value;
  let dateEnd = document.getElementById('endDateModal').value;
  let comment = document.getElementById('commentModal').value;
  let error = document.getElementById('errorModal');

  let dateStartConvert = new Date(dateStart);
  let dateEndConvert = new Date(dateEnd);

  if(employee.length == 0 || formation.length == 0){
    error.innerHTML = "Merci de sélectionner un salarié et une formation";
  }else if(dateStart == "" || dateEnd == ""){
    error.innerHTML = "Merci de renseigner des dates";
  }else if(dateEndConvert<dateStartConvert){
    error.innerHTML = "Incohérence au niveau des dates";
  }else{
    $.ajax({
       url : 'jobReporting/registerEmployee.php',
       type : 'POST',
       data : 'employeeId='+employee+'&formationId='+formation+'&dateStart='+dateStart+'&dateEnd='+dateEnd+'&comment='+comment,
       success : function(result){
         if(result == 'success'){
           document.getElementById('modalBody').innerHTML = '<p class="fs-4 text-center text-success">Inscription réussi</p>'
           filterTable();
         }else{
           error.innerHTML = "Une erreur est survenue, merci de contacter le support";
         }
       }
    });
  }
}
