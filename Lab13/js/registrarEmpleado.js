function nextDatosContacto(){
		document.getElementById("datosContacto").style.display = "block";
		document.getElementById("datosPersonales").style.display = "none";
		document.getElementById("progressBar").style.width = "32%";

}

function nextDatosContrat(){
		document.getElementById("datosContacto").style.display = "none";
		document.getElementById("datosContratacion").style.display = "block";
		document.getElementById("progressBar").style.width = "48%";
}

function nextDatosNom(){
		document.getElementById("datosNomina").style.display = "block";
		document.getElementById("datosContratacion").style.display = "none";
		document.getElementById("progressBar").style.width = "54%";
}

function nextBenefN(){
		document.getElementById("datosNomina").style.display = "none";
		document.getElementById("benefNomina").style.display = "block";
		document.getElementById("progressBar").style.width = "70%";
}

function nextArch(){
		document.getElementById("benefNomina").style.display = "none";
		document.getElementById("archivosEmp").style.display = "block";
		document.getElementById("progressBar").style.width = "90%";
}

function submitEmpleados(){
		document.getElementById("archivosEmp").style.display = "none";
		document.getElementById("registroExitoso").style.display = "block";
		document.getElementById("progressBar").style.width = "100%";
}
		