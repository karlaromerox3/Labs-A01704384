function nextDatosIngreso(){
	let valido = true;
	if($("#nombreBenef").val() == ''){
		valido = false;
		$("#errorNombreBenef").html("El nombre de la beneficiaria no puede estar vacío")
	}
	if (valido){
		document.getElementById("datosIngreso").style.display = "block";
		document.getElementById("datosPersonales").style.display = "none";
		document.getElementById("progressBar").style.width = "20%";
	}
};

function nextDatosFam(){
	let valido = true;
	if($("#fechaIngreso").val() == ''){
		valido = false;
		$("#errorFechaIngreso").html("Debe seleccionar la fecha de ingreso")
	}
	if (valido){
		document.getElementById("datosIngreso").style.display = "none";
		document.getElementById("datosFamiliares").style.display = "block";
		document.getElementById("progressBar").style.width = "40%";
	}
};

function nextDatosAcad(){
	let valido = true;
	if (valido){
		document.getElementById("datosAcademicos").style.display = "block";
		document.getElementById("datosFamiliares").style.display = "none";
		document.getElementById("progressBar").style.width = "60%";
	}
};

function nextArchivos(){
	let valido = true;
	if (valido){
		document.getElementById("archivosVarios").style.display = "block";
		document.getElementById("datosAcademicos").style.display = "none";
		document.getElementById("progressBar").style.width = "80%";
	}
};

function submitBeneficiarias(){
$.ajax({
	url: 'verBeneficiaria.php',
	method: 'post',
	data: $("form-data").serialize(),
	success: function(response){
		document.getElementById("registroExitoso").style.display = "block";
		document.getElementById("progressBar").style.width = "100%";
		document.getElementById("archivosVarios").style.display = "none";
	}
})
};

function prevDatosIngreso(){
		document.getElementById("datosIngreso").style.display = "none";
		document.getElementById("datosPersonales").style.display = "block";
		document.getElementById("progressBar").style.width = "0%";
};

function prevDatosFam(){
		document.getElementById("datosIngreso").style.display = "block";
		document.getElementById("datosFamiliares").style.display = "none";
		document.getElementById("progressBar").style.width = "20%";
};

function prevDatosAcad(){
		document.getElementById("datosAcademicos").style.display = "none";
		document.getElementById("datosFamiliares").style.display = "block";
		document.getElementById("progressBar").style.width = "40%";
};

function prevArchivos(){
		document.getElementById("archivosVarios").style.display = "none";
		document.getElementById("datosAcademicos").style.display = "block";
		document.getElementById("progressBar").style.width = "60%";
};
