var tabla   = document.createElement("table");
  var tblBody = document.createElement("tbody");

function crearTabla() {
  // Obtener la referencia del elemento article
  var body = document.getElementsByTagName("article")[0];
 
  // Crea un elemento <table> y un elemento <tbody>
  
 
  // Crea las celdas
  for (var i = 0; i < 1; i++) {
    // Crea las hileras de la tabla
    var hilera = document.createElement("tr");
 
    for (var j = 0; j < 7; j++) {
      var celda = document.createElement("td");
      switch(j){
            case 0: 
              var textoCelda = document.createTextNode("Tarea ");
            break;
            case 1: 
              var textoCelda = document.createTextNode("Encargado ");
            break;
              
            case 2: 
              var textoCelda = document.createTextNode("Estado ");
            break;
            case 3: 
              var textoCelda = document.createTextNode("Recursos ");
            break;
            case 4: 
              var textoCelda = document.createTextNode("Tiempo Estimado ");
            break;
            case 5: 
              var textoCelda = document.createTextNode("Tiempo Real ");
            break;
            case 6: 
              var textoCelda = document.createTextNode("Discrepacia ");
            break;
    
      }
      celda.appendChild(textoCelda);
      hilera.appendChild(celda);
    }
 
    // agrega la hilera al final de la tabla (al final del elemento tblbody)
    tblBody.appendChild(hilera);
  }
 
  // posiciona el <tbody> debajo del elemento <table>
  tabla.appendChild(tblBody);
  // appends <table> into <body>
  article.appendChild(tabla);
  // modifica el atributo "border" de la tabla y lo fija a "2";
  tabla.setAttribute("border", "2");
}



function añadirFila(){
    var hilera = document.createElement("tr");
 
    for (var j = 0; j < 7; j++) {
      var celda = document.createElement("td");
      switch(j){
            case 0: 
              var textoCelda = document.createTextNode(document.getElementById("task").value);
            break;
            case 1: 
              var textoCelda = document.createTextNode(document.getElementById("resp").value);
            break;
              
            case 2: 
              var textoCelda = document.createTextNode(document.getElementById("est").value);
            break;
            case 3: 
              var textoCelda = document.createTextNode(document.getElementById("url").value);
            break;
            case 4: 
              var textoCelda = document.createTextNode(document.getElementById("tiest").value);
            break;
            case 5:
              var textoCelda = document.createTextNode(document.getElementById("treal").value);
            break;
            case 6:
              var a =  document.getElementById("treal").value;
              var b = document.getElementById("tiest").value;
              let disc = a - b ;
              var textoCelda = document.createTextNode(disc);
            break;
    
      }
      celda.appendChild(textoCelda);
      hilera.appendChild(celda);
      
    // agrega la hilera al final de la tabla (al final del elemento tblbody)
  tblBody.appendChild(hilera);
    }    
  
    table.appendChild(tblBody);
    // appends <table> into <body>
    article.appendChild(tabl);
}

document.getElementById("agregar").onclick = añadirFila;
