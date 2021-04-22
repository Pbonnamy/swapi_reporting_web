let tmpCSV = [];

// Ajout des données ()à un tableau js) d'une ligne du tableau lorsque sa checkbox est checkée
function itemstoArray(name,birthYear,gender){
  let array = {name:name,birthYear:birthYear,gender:gender};
  let deleteBool = 0;

  for (var i = 0; i < tmpCSV.length; i++) {
    if(name == tmpCSV[i]['name']){
      tmpCSV.splice(i, 1);
      deleteBool = 1;
      break;
    }
  }
  if(deleteBool != 1){
    tmpCSV.push(array);
    document.getElementById('error').innerHTML = "";
  }
}

// Check des checkbox précédemment sélectionnées à l'affichage d'une page
function checkItems(){
  let checkbox = document.getElementsByName('checkbox');
  for (var i = 0; i < checkbox.length; i++) {
    for (var j = 0; j < tmpCSV.length; j++) {
      if(checkbox[i].getAttribute('data-name')==tmpCSV[j]['name']){
        checkbox[i].checked =true;
      }
    }
  }
}

//Transformation du tableau contenant les données checkées pour respecter le format CSV
function toCSV(){
  if(tmpCSV.length != 0){
    const csvString = [
      [
        "Nom",
        "Date de naissance",
        "Genre"
      ],
      ...tmpCSV.map(item => [
        item.name,
        item.birthYear,
        item.gender
      ])
    ].map(e => e.join(";")).join("\n");
    downloadCSV(csvString);
  }else{
    document.getElementById('error').innerHTML = 'Merci de sélectionner au moins un élément';
  }

}

//Téléchargement du CSV
function downloadCSV(csvStr) {
    var hiddenElement = document.createElement('a');
    hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csvStr);
    hiddenElement.target = '_blank';
    hiddenElement.download = 'result.csv';
    hiddenElement.click();
}
