google.charts.load('current', {'packages':['corechart','table', 'controls']});


//este arreglo contiene todos los objetos
var items = [];

var prueba1 = $("#prueba1").val();
var prueba2 = $("#prueba2").val();

google.charts.setOnLoadCallback(
	function ()
	{
		for(let i = 1; i <= 47; i++)
		{

			let jsonData = $.ajax({
				url: "../pruebas/datosVerPrueba.php?tablaNum="+i+"&tabla=1&idPrueba="+prueba1,
				dataType: "json",
				async: false
				}).responseText;
			jsonData = JSON.parse(jsonData);
			
			// Create our data table out of JSON data loaded from server.
			let graphDataTable = new google.visualization.DataTable(jsonData);

			var cssClassNames = {
				'tableCell': 'textoTabla'
			};
			table = new google.visualization.ChartWrapper({
				'chartType': 'Table',
				'containerId': 'table'+i+'Prueba'+prueba1+'_div',
				'dataTable': graphDataTable,
				'options': {
					showRowNumber: true,
					width: '100%',
					height: '100%',
					allowHtml: true,
					'cssClassNames': cssClassNames
				},
				'view': {'columns': [0,1,2]}
			});

			jsonData = $.ajax({
				url: "../pruebas/datosVerPrueba.php?tablaNum="+i+"&tabla=0&idPrueba="+prueba1,
				dataType: "json",
				async: false
				}).responseText;
			jsonData = JSON.parse(jsonData);

			// Create our data table out of JSON data loaded from server.
			var graphDataChart = new google.visualization.DataTable(jsonData);

			chart = new google.visualization.ChartWrapper({
				'chartType': 'ColumnChart',
				'containerId': 'chart'+i+'Prueba'+prueba1+'_div',
				'dataTable': graphDataChart,
				'options': {
					title: $("#seccion"+i).html(),
					titleTextStyle:{
						fontSize: "20"
					},
					hAxis:{
						title: "progreso"
					},
					vAxis:{
						title: "# de actividades"
					},
					legend:{
						position: "none"
					}
				}
			});

			table.draw();
			items.push(table);

			chart.draw();
			items.push(chart);

		}
		
	}
);

google.charts.setOnLoadCallback(
	function ()
	{
		for(let i = 1; i <= 47; i++)
		{

			let jsonData = $.ajax({
				url: "../pruebas/datosVerPrueba.php?tablaNum="+i+"&tabla=1&idPrueba="+prueba2,
				dataType: "json",
				async: false
				}).responseText;
			jsonData = JSON.parse(jsonData);
			
			// Create our data table out of JSON data loaded from server.
			let graphDataTable = new google.visualization.DataTable(jsonData);

			var cssClassNames = {
				'tableCell': 'textoTabla'
			};
			table = new google.visualization.ChartWrapper({
				'chartType': 'Table',
				'containerId': 'table'+i+'Prueba'+prueba2+'_div',
				'dataTable': graphDataTable,
				'options': {
					showRowNumber: true,
					width: '100%',
					height: '100%',
					allowHtml: true,
					'cssClassNames': cssClassNames
				},
				'view': {'columns': [0,1,2]}
			});

			jsonData = $.ajax({
				url: "../pruebas/datosVerPrueba.php?tablaNum="+i+"&tabla=0&idPrueba="+prueba2,
				dataType: "json",
				async: false
				}).responseText;
			jsonData = JSON.parse(jsonData);

			// Create our data table out of JSON data loaded from server.
			var graphDataChart = new google.visualization.DataTable(jsonData);

			chart = new google.visualization.ChartWrapper({
				'chartType': 'ColumnChart',
				'containerId': 'chart'+i+'Prueba'+prueba2+'_div',
				'dataTable': graphDataChart,
				'options': {
					title: $("#seccion"+i).html(),
					titleTextStyle:{
						fontSize: "20"
					},
					hAxis:{
						title: "progreso"
					},
					vAxis:{
						title: "# de actividades"
					},
					legend:{
						position: "none"
					}
				}
			});

			table.draw();
			items.push(table);

			chart.draw();
			items.push(chart);

		}
		
	}
);


$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
	var target = $(e.target).attr("href") // activated tab
	repaint();
  });

function repaint()
{
	window.resizeBy(1,1);
	items.forEach(element => element.draw());
}

window.onresize = function () {
	items.forEach(element => element.draw());
};


//back to top
//Get the button:
mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 800 || document.documentElement.scrollTop > 800) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}
