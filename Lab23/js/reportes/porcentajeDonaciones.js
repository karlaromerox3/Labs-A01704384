//comentarios
google.charts.load('current', {'packages':['corechart','table', 'controls']});


google.charts.setOnLoadCallback(drawTipo);
google.charts.setOnLoadCallback(drawFrecuencia);
google.charts.setOnLoadCallback(drawDonaciones);

var graphDataTipo, chartTipo, chartTipoOptions, tableTipo, tableTipoOptions, chartFrecuencia, chartFrecuenciaOptions, tableFrecuencia, tableFrecuencia, graphDataDonaciones, chartDonaciones, chartDonacionesOptions, tableDonaciones, tableDonacionesOptions;





function drawTipo()
{

	var jsonData = $.ajax({
		url: "../reportes/getData.php?id=5&tablaNum=1",
		dataType: "json",
		async: false
		}).responseText;
	jsonData = JSON.parse(jsonData);
	console.log(jsonData);
	
	// Create our data table out of JSON data loaded from server.
	graphDataTipo = new google.visualization.DataTable(jsonData);
	console.log(graphDataTipo);

	chartTipo = new google.visualization.PieChart(document.getElementById('chartTipo_div'));
	chartTipoOptions = {
		title: 'Porcentaje de donantes por tipo',
		titleTextStyle:{
			textAlgi: "middle",
			fontSize: "24"
		},
		legend:{
			alignment: 'center',
			position: 'labeled'
		},
		height: 600
	};

	var cssClassNames = {
		'tableCell': 'textoTabla'};
	

	tableTipo = new google.visualization.Table(document.getElementById('tableTipo_div'));
	tableTipoOptions = {
		showRowNumber: true, 
		width: '100%', 
		height: '100%', 
		allowHtml: true, 
		'cssClassNames': cssClassNames
	};


	chartTipo.draw(graphDataTipo, chartTipoOptions);
	tableTipo.draw(graphDataTipo, tableTipoOptions);	

	setNumeroDonantes();
}


function drawFrecuencia()
{
	
	var jsonData = $.ajax({
		url: "../reportes/getData.php?id=5&tablaNum=2",
		dataType: "json",
		async: false
		}).responseText;
	jsonData = JSON.parse(jsonData);
	console.log(jsonData);
	
	// Create our data table out of JSON data loaded from server.
	graphDataFrecuencia = new google.visualization.DataTable(jsonData);
	console.log(graphDataFrecuencia);


	chartFrecuencia = new google.visualization.PieChart(document.getElementById('chartFrecuencia_div'));
	chartFrecuenciaOptions = {
		title: 'Porcentaje de donantes por frecuencia',
		titleTextStyle:{
			textAlgi: "middle",
			fontSize: "24"
		},
		legend:{
			alignment: 'center',
			position: 'labeled'
		},
		height: 600,
		colors: ["#f0037f","#0a0d52"]
	};

	var cssClassNames = {
		'tableCell': 'textoTabla'};
	

	tableFrecuencia = new google.visualization.Table(document.getElementById('tableFrecuencia_div'));
	tableFrecuenciaOptions = {
		showRowNumber: true, 
		width: '100%', 
		height: '100%', 
		allowHtml: true, 
		'cssClassNames': cssClassNames
	};


	chartFrecuencia.draw(graphDataFrecuencia, chartFrecuenciaOptions);
	tableFrecuencia.draw(graphDataFrecuencia, tableFrecuenciaOptions);	
}

function drawDonaciones()
{
	
	var jsonData = $.ajax({
		url: "../reportes/getData.php?id=5&tablaNum=3",
		dataType: "json",
		async: false
		}).responseText;
	jsonData = JSON.parse(jsonData);
	console.log(jsonData);
	
	// Create our data table out of JSON data loaded from server.
	graphDataDonaciones = new google.visualization.DataTable(jsonData);
	console.log(graphDataDonaciones);


	chartDonaciones = new google.visualization.PieChart(document.getElementById('chartDonaciones_div'));
	chartDonacionesOptions = {
		title: 'Porcentaje de donaciones por tipo',
		titleTextStyle:{
			textAlgi: "middle",
			fontSize: "24"
		},
		legend:{
			alignment: 'center',
			position: 'labeled'
		},
		height: 600,
		colors: ["#f0037f","#0a0d52"]
	};

	var cssClassNames = {
		'tableCell': 'textoTabla'};
	

	tableDonaciones = new google.visualization.Table(document.getElementById('tableDonaciones_div'));
	tableDonacionesOptions = {
		showRowNumber: true, 
		width: '100%', 
		height: '100%', 
		allowHtml: true, 
		'cssClassNames': cssClassNames
	};


	chartDonaciones.draw(graphDataDonaciones, chartDonacionesOptions);
	tableDonaciones.draw(graphDataDonaciones, tableDonacionesOptions);	
	setNumeroDonaciones();
}


window.onresize = function () {
	chartTipo.draw(graphDataTipo, chartTipoOptions);
	tableTipo.draw(graphDataTipo, tableTipoOptions);
	chartFrecuencia.draw(graphDataFrecuencia, chartFrecuenciaOptions);
	tableFrecuencia.draw(graphDataFrecuencia, tableFrecuenciaOptions);	
	chartDonaciones.draw(graphDataDonaciones, chartDonacionesOptions);
	tableDonaciones.draw(graphDataDonaciones, tableDonacionesOptions);	
};

function setNumeroDonantes()
{
	let numDonantes = 0 
	for(i = 0; i < graphDataTipo.getNumberOfRows(); i++)
	{
		numDonantes += graphDataTipo.getValue(i, 1);
	}
	$("#numDonantes").html("Número de donantes activos: "+numDonantes);
}

function setNumeroDonaciones()
{
	let numDonaciones = 0 
	for(i = 0; i < graphDataDonaciones.getNumberOfRows(); i++)
	{
		numDonaciones += graphDataDonaciones.getValue(i, 1);
	}
	$("#numDonaciones").html("Número de donaciones: "+numDonaciones);
}