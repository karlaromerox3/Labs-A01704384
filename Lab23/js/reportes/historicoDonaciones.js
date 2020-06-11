google.charts.load('current', {'packages':['corechart','table', 'controls']});


google.charts.setOnLoadCallback(drawChart);

var graphDataChart,graphDataTable, chart, chartOptions, table, tableOptions;


function drawChart()
{
	
	var jsonData = $.ajax({
		url: "../reportes/getData.php?id=6&tablaNum=1",
		dataType: "json",
		async: false
		}).responseText;
	jsonData = JSON.parse(jsonData);
	console.log(jsonData);
	
	// Create our data table out of JSON data loaded from server.
	graphDataChart = new google.visualization.DataTable(jsonData);
	console.log(graphDataChart);

	
	//formatter.format(graphData, 3);
	//formatter.format(graphData, 5);

	chart = new google.visualization.ChartWrapper({
		'chartType': 'ColumnChart',
		'containerId': 'chart_div',
		'dataTable': graphDataChart,
		'options': {
			title: "Históricos de donaciones más grandes, más bajas y más recientes por tipo de donante",
			titleTextStyle:{
				textAlgi: "middle",
				fontSize: "24"
			},
			hAxis:{
				title: "Donantes"
			},
			vAxis:{
				title: "Valor de donaciones",
				logScale: true
			},
			height: 600		
		},
		'view': {'columns': [1,2,3,4]}
	});

	var cssClassNames = {
		'tableCell': 'textoTabla'
	};

	var formatter = new google.visualization.NumberFormat(
		{prefix: '$'});
	formatter.format(graphDataChart, 2);
	formatter.format(graphDataChart, 3);
	formatter.format(graphDataChart, 4);

	var jsonData = $.ajax({
		url: "../reportes/getData.php?id=6&tablaNum=2",
		dataType: "json",
		async: false
		}).responseText;
	jsonData = JSON.parse(jsonData);
	console.log(jsonData);
	
	// Create our data table out of JSON data loaded from server.
	graphDataTable = new google.visualization.DataTable(jsonData);
	console.log(graphDataTable);

	table = new google.visualization.Table(document.getElementById('table_div'));
	tableOptions = {
		showRowNumber: true, 
		width: '100%', 
		height: '100%', 
		allowHtml: true, 
		'cssClassNames': cssClassNames
	};

	formatter.format(graphDataTable, 2);
	formatter.format(graphDataTable, 3);
	formatter.format(graphDataTable, 4);

	//chart.draw(graphData, chartOptions);
	chart.draw();
	table.draw(graphDataTable, tableOptions);	
}



window.onresize = function () {
	chart.draw();
	table.draw(graphDataTable, tableOptions);
};