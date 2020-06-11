let prueba1Comp = $("#prueba1").val();
const color = d3.scaleOrdinal(d3.schemePaired);
let jsonData1 = $.ajax({
  url: "../pruebas/genGraphjson.php?idPrueba="+prueba1Comp,
  dataType: "json",
  async: false
  }).responseText;
let Jdata1 = JSON.parse(jsonData1);
//Segundo parseo porque el primero lo deja en string aun.
Jdata1 = JSON.parse(Jdata1);

Sunburst()
  .data(Jdata1)
  .label('name')
  .size('size')
  .color('color')
  .tooltipContent((d, node) => `Size: <i>${node.value}</i>`)
  (document.getElementById('jsonPruebaUno'));


  let prueba2Comp = $("#prueba2").val();
  let jsonData2 = $.ajax({
    url: "../pruebas/genGraphjson.php?idPrueba="+prueba2Comp,
    dataType: "json",
    async: false
    }).responseText;
  let Jdata2 = JSON.parse(jsonData2);
  //Segundo parseo porque el primero lo deja en string aun.
  Jdata2 = JSON.parse(Jdata2);
  Sunburst()
    .data(Jdata2)
    .label('name')
    .size('size')
    .color('color')
    .tooltipContent((d, node) => `Size: <i>${node.value}</i>`)
    (document.getElementById('jsonPruebaDos'));
