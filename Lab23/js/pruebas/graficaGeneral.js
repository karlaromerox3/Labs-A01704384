//------------------------------------------------------------
//--------------------Grafica General-------------------------
//------------------------------------------------------------
 const color = d3.scaleOrdinal(d3.schemePaired);
 let pruebaact = $("#idpruebactual").val()

 let jsonData = $.ajax({
   url: "../pruebas/genGraphjson.php?idPrueba="+pruebaact,
   dataType: "json",
   async: false
   }).responseText;
 let Jdata = JSON.parse(jsonData);
 //Segundo parseo porque el primero lo deja en string aun.
 Jdata = JSON.parse(Jdata);
 Sunburst()
   .data(Jdata)
   .label('name')
   .size('size')
   .color('color')
   .tooltipContent((d, node) => `Size: <i>${node.value}</i>`)
   (document.getElementById('json'));
