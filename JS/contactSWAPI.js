$(document).ready(function() {
  // Au chargement -> effectuer l'affichage
  APIrequest('data-next');
});

// Gestion des boutons 'précédent' et 'suivant'
function handleButton(){
  let next = document.getElementById('positionInfo').getAttribute('data-next');
  let previous = document.getElementById('positionInfo').getAttribute('data-previous');

  let buttonNext = document.getElementById('nextBtn');
  let buttonPrevious = document.getElementById('prevBtn');
  if(next == ""){
    buttonNext.setAttribute('disabled','');
  }else{
    buttonNext.removeAttribute('disabled','');
  }

  if(previous == ""){
    buttonPrevious.setAttribute('disabled','');
  }else{
    buttonPrevious.removeAttribute('disabled','');
  }
}

let pageNb = 0;

// Envoi des données à starWarsAPI/contactAPI.php et récupération du résultat (renvoyé par SWAPI)
function APIrequest(index){
  document.getElementById('loader').style.display = "";
  document.getElementById('tableBody').hidden =true;
  let page =document.getElementById('positionInfo').getAttribute(index);

  if(index == 'data-next'){
    pageNb += 1;
  }else{
    pageNb -=1;
  }

  $.ajax({
     url : 'starWarsAPI/contactAPI.php',
     type : 'GET',
     data: 'page='+page,
     success : function(result){
       document.getElementById('positionInfo').remove();
       document.getElementById('tableBody').innerHTML = result;
       document.getElementById('tableBody').hidden =false;
       handleButton();
       checkItems();
       document.getElementById('pageCount').innerHTML = 'Page '+pageNb;
       document.getElementById('loader').style.display = "none";
     }
  });
}
