document.getElementById("tipoReporte").onchange = function() {
	switch(document.getElementById("tipoReporte").value)
	{
		//Beneficiarias ingresadas y donaciones
		case '1': case '3':
			document.getElementById("daterange").disabled = false;
			document.getElementById("fecha").hidden = false;
			break;
		case '2': default:
			document.getElementById("daterange").disabled = true;
			document.getElementById("fecha").hidden = true;
			break;
	}
};
