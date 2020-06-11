google.charts.load('current', {'packages':['corechart','table', 'controls']});


google.charts.setOnLoadCallback(drawIntelectual);
google.charts.setOnLoadCallback(drawMotriz);

var graphDataIntelectual, chartIntelectual, chartIntelectualOptions, tableIntelectual, tableIntelectualOptions, chartMotriz, chartMotrizOptions, tableMotriz, tableMotriz;





function drawIntelectual()
{

	var jsonData = $.ajax({
		url: "../reportes/getData.php?id=3&tablaNum=1",
		dataType: "json",
		async: false
		}).responseText;
	jsonData = JSON.parse(jsonData);
	console.log(jsonData);
	
	// Create our data table out of JSON data loaded from server.
	graphDataIntelectual = new google.visualization.DataTable(jsonData);
	console.log(graphDataIntelectual);

	chartIntelectual = new google.visualization.PieChart(document.getElementById('chartIntelectual_div'));
	chartIntelectualOptions = {
		title: 'Porcentaje de niñas por diagnóstico intelectual',
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
	

	tableIntelectual = new google.visualization.Table(document.getElementById('tableIntelectual_div'));
	tableIntelectualOptions = {
		showRowNumber: true, 
		width: '100%', 
		height: '100%', 
		allowHtml: true, 
		'cssClassNames': cssClassNames
	};


	chartIntelectual.draw(graphDataIntelectual, chartIntelectualOptions);
	tableIntelectual.draw(graphDataIntelectual, tableIntelectualOptions);
	setNumeroBenef();	
}


function drawMotriz()
{
	
	var jsonData = $.ajax({
		url: "../reportes/getData.php?id=3&tablaNum=2",
		dataType: "json",
		async: false
		}).responseText;
	jsonData = JSON.parse(jsonData);
	console.log(jsonData);
	
	// Create our data table out of JSON data loaded from server.
	graphDataMotriz = new google.visualization.DataTable(jsonData);
	console.log(graphDataMotriz);


	chartMotriz = new google.visualization.PieChart(document.getElementById('chartMotriz_div'));
	chartMotrizOptions = {
		title: 'Porcentaje de niñas por diagnóstico motriz',
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
	

	tableMotriz = new google.visualization.Table(document.getElementById('tableMotriz_div'));
	tableMotrizOptions = {
		showRowNumber: true, 
		width: '100%', 
		height: '100%', 
		allowHtml: true, 
		'cssClassNames': cssClassNames
	};


	chartMotriz.draw(graphDataMotriz, chartMotrizOptions);
	tableMotriz.draw(graphDataMotriz, tableMotrizOptions);	
}



window.onresize = function () {
	chartIntelectual.draw(graphDataIntelectual, chartIntelectualOptions);
	tableIntelectual.draw(graphDataIntelectual, tableIntelectualOptions);
	chartMotriz.draw(graphDataMotriz, chartMotrizOptions);
	tableMotriz.draw(graphDataMotriz, tableMotrizOptions);	
};

function setNumeroBenef()
{
	let numBenef = 0 
	for(i = 0; i < graphDataIntelectual.getNumberOfRows(); i++)
	{
		numBenef += graphDataIntelectual.getValue(i, 1);
	}
	$("#numBenef").html("Número de beneficiarias activas: "+numBenef);
}