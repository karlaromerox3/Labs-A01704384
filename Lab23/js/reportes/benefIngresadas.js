google.charts.load('current', {'packages':['corechart','table', 'controls']});

//google.charts.setOnLoadCallback(tablaBenefIngresadas);
google.charts.setOnLoadCallback(drawDashboard);
//google.charts.setOnLoadCallback(graficaBenefIngresadas);
var graphData, dashboard, sliderEdades, table, numBeneficiarias;

function drawDashboard()
{


	dashboard = new google.visualization.Dashboard(document.getElementById('dashboard_div'));

	var jsonData = $.ajax({
		url: "../reportes/getData.php?id=2",
		dataType: "json",
		async: false
		}).responseText;
	jsonData = JSON.parse(jsonData);

	// Create our data table out of JSON data loaded from server.
	graphData = new google.visualization.DataTable(jsonData);

	//graphData.sort([{column: 1}]);
	var range = graphData.getColumnRange(2);

	sliderEdades = new google.visualization.ControlWrapper({
		'controlType': 'NumberRangeFilter',
		'containerId': 'filterEdades_div',
		'options': {
		  'filterColumnLabel': 'edad',
		  'minValue': range.min,
		  'maxValue': range.max,
		  'ui': {
			'labelStacking': 'vertical',
			'label': 'Rango de edades:'
		  }
		}
	  });

	var sliderFechas = new google.visualization.ControlWrapper({
      'controlType': 'DateRangeFilter',
      'containerId': 'filterFechas_div',
      'options': {
		'filterColumnLabel': 'fecha de ingreso',
        'ui': {
			'format': { 'pattern': 'd/M/Y' },
			'labelStacking': 'vertical',
			'label': 'Rango de fecha de ingreso:'
		}

      }
    });

	var columnChart = new google.visualization.ChartWrapper({
		'chartType': 'ColumnChart',
		'containerId': 'chart_div',
		'options': {
			title: "Edades de Beneficiarias Activas",
			titleTextStyle:{
				textAlgi: "middle",
				fontSize: "24"
			},
			hAxis:{
				title: "Nombres"
			},
			vAxis:{
				title: "Edades"
			},
			height: 600,
			colors: ["#f0037f"],
			animation:{
				duration: 800
			}
		},
		'view': {'columns': [0,2]}
	});
	var cssClassNames = {
		'tableCell': 'textoTabla'};

	table = new google.visualization.ChartWrapper({
		'chartType': 'Table',
		'containerId': 'table_div',
		'options': {
			showRowNumber: true,
			width: '100%',
			height: '100%',
			allowHtml: true,
			'cssClassNames': cssClassNames}
	});

	dashboard.bind([sliderEdades,sliderFechas], [columnChart, table]);

	google.visualization.events.addListener(dashboard, 'ready', onReady);

	dashboard.draw(graphData);


	//numBeneficiarias = table.getDataTable().getNumberOfRows();
	//$("#numBeneficiarias").html("Número de beneficiarias: "+numBeneficiarias);
}

function onReady()
{
	numBeneficiarias = table.getDataTable().getNumberOfRows();
	$("#numBeneficiarias").html("Número de beneficiarias: "+numBeneficiarias);
}


window.onresize = function () {
	dashboard.draw(graphData);
	
};

