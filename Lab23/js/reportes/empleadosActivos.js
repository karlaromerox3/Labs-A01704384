google.charts.load('current', {'packages':['corechart','table', 'controls']});

//google.charts.setOnLoadCallback(tablaBenefIngresadas);
google.charts.setOnLoadCallback(drawDashboard);
//google.charts.setOnLoadCallback(graficaBenefIngresadas);
var graphData, dashboard, table;

function drawDashboard()
{
	
	
	dashboard = new google.visualization.Dashboard(document.getElementById('dashboard_div'));

	var jsonData = $.ajax({
		url: "../reportes/getData.php?id=4",
		dataType: "json",
		async: false
		}).responseText;
	jsonData = JSON.parse(jsonData);
	console.log(jsonData);
	
	// Create our data table out of JSON data loaded from server.
	graphData = new google.visualization.DataTable(jsonData);
	console.log(graphData);
	//graphData.sort([{column: 1}]);
	var range = graphData.getColumnRange(1);
	console.log(range.min);
	var sliderEdades = new google.visualization.ControlWrapper({
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

	var columnChart = new google.visualization.ChartWrapper({
		'chartType': 'ColumnChart',
		'containerId': 'chart_div',
		'options': {
			title: "Edades de Empleados Activos",
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
		'view': {'columns': [0,1]}
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

	dashboard.bind(sliderEdades, [columnChart, table]);

	google.visualization.events.addListener(dashboard, 'ready', onReady);

	dashboard.draw(graphData);
	
	
	numEmpleados = table.getDataTable().getNumberOfRows();
	$("#numEmpleados").html("Número de empleados: "+numBeneficiarias);
}

function onReady()
{
	numEmpleados = table.getDataTable().getNumberOfRows();
	$("#numEmpleados").html("Número de empleados: "+numEmpleados);
}

window.onresize = function () {
	dashboard.draw(graphData);
};

