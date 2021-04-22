// Trie du tableau affiché en fonction de la colonne sélectionnée
function sortTable(column) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("table");
  switching = true;

  dir = "asc";

  while (switching) {

    switching = false;
    rows = table.rows;

    if(dir == "asc"){
      document.getElementById('dirSymbole'+column).innerHTML = "⬇";
    }else{
      document.getElementById('dirSymbole'+column).innerHTML = "⬆";
    }

    for(var j = 0; j<3; j++){
      if(j!=column){
        document.getElementById('dirSymbole'+j).innerHTML = "🔃";
      }
    }

    for (i = 1; i < (rows.length - 1); i++) {

      shouldSwitch = false;
      x = rows[i].getElementsByTagName("TD")[column];
      y = rows[i + 1].getElementsByTagName("TD")[column];

      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          shouldSwitch = true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          shouldSwitch = true;
          break;
        }
      }
    }

    if (shouldSwitch) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      switchcount ++;
    } else {
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}
