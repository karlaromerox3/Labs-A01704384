function hasNumber(myString) {
	return /\d/.test(myString);
}
function isNullOrWhitespace( input ) {
	return !input || !input.trim();
}
function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}

function isTime(hora){
	return /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/.test(hora);
}

function isDate(date)
{
	return /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/.test(date);
}

function isRFC(rfc)
{
	return /^(([ÑA-Z|ña-z|&amp;]{3}|[A-Z|a-z]{4})\d{2}((0[1-9]|1[012])(0[1-9]|1\d|2[0-8])|(0[13456789]|1[012])(29|30)|(0[13578]|1[02])31)(\w{2})([A|a|0-9]{1}))$|^(([ÑA-Z|ña-z|&amp;]{3}|[A-Z|a-z]{4})([02468][048]|[13579][26])0229)(\w{2})([A|a|0-9]{1})$/.test(rfc);
}

function isCURP(curp){
	return /^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/.test(curp);
}
function isNSS(segsocial){
	return /^(\d{2})(\d{2})(\d{2})\d{5}$/.test(segsocial);
}

/*
	FUNCIONES PARA VALIDACIONES
*/
function validarNombres($nombre)
{
	if($nombre.prop("validity").valid & !hasNumber($nombre.val()) & !isNullOrWhitespace($nombre.val()))
	{
		$nombre.addClass("is-valid");
		$nombre.removeClass("is-invalid");
		return true;
	}
	else
	{
		$nombre.addClass("is-invalid");
		return false;
	}
}

function validarSelect($id)
{
	if($id.val() != null & $id.prop("validity").valid)
	{
		$id.addClass("is-valid");
		$id.removeClass("is-invalid");
		return true;
	}
	else
	{
		$id.addClass("is-invalid");
		return false;
	}
}

function validarCorreo($correo)
{
	if($correo.prop("validity").valid & isEmail($correo.val()) & !isNullOrWhitespace($correo.val()))
	{
		$correo.addClass("is-valid");
		$correo.removeClass("is-invalid");
		return true;
	}
	else
	{
		$correo.addClass("is-invalid");
		return false;
	}
}

function validarNumeros($tel)
{
	if($tel.prop("validity").valid & !isNaN($tel.val()))
	{
		$tel.addClass("is-valid");
		$tel.removeClass("is-invalid");
		return true;
	}
	else
	{
		$tel.addClass("is-invalid");
		return false;
	}
}

function validarFecha($fecha)
{
  console.log($fecha.val());
  let valorFecha = $fecha.val().split("-").reverse().join("-");
  console.log($fecha.val().split("-").reverse().join("-"))
  if($fecha.prop("validity").valid & isDate($fecha.val()) & ((new Date(valorFecha)) < (new Date())) & !isNullOrWhitespace($fecha.val()))
  {
    $fecha.addClass("is-valid");
    $fecha.removeClass("is-invalid");
    return true;
  }
  else
  {
    $fecha.addClass("is-invalid");
    return false;
  }
}


function validarRFC($rfc)
{
	if($rfc.prop("validity").valid & isRFC($rfc.val()) & !isNullOrWhitespace($rfc.val()))
	{
		$rfc.addClass("is-valid");
		$rfc.removeClass("is-invalid");
		return true;
	}
	else
	{
		$rfc.addClass("is-invalid");
		return false;
	}
}

function validarCURP($curp)
{
	if($curp.prop("validity").valid & isCURP($curp.val()) & !isNullOrWhitespace($curp.val()))
	{
		$curp.addClass("is-valid");
		$curp.removeClass("is-invalid");
		return true;
	}
	else
	{
		$curp.addClass("is-invalid");
		return false;
	}
}
function validarSS($segSocial)
{
	if($segSocial.prop("validity").valid & isNSS($segSocial.val()) & !isNullOrWhitespace($segSocial.val()))
	{
		$segSocial.addClass("is-valid");
		$segSocial.removeClass("is-invalid");
		return true;
	}
	else
	{
		$segSocial.addClass("is-invalid");
		return false;
	}
}

function validarDireccion($dir)
{
	if($dir.prop("validity").valid & !isNullOrWhitespace($dir.val()))
	{
		$dir.addClass("is-valid");
		$dir.removeClass("is-invalid");
		return true;
	}
	else
	{
		$dir.addClass("is-invalid");
		return false;
	}
}
function validarHora($hora)
{
	if($hora.prop("validity").valid & isTime($hora.val()) & !isNullOrWhitespace($hora.val()))
	{
		$hora.addClass("is-valid");
		$hora.removeClass("is-invalid");
		return true;
	}
	else
	{
		$hora.addClass("is-invalid");
		return false;
	}
}


/*
	OBTENER DATOS
*/




$nombreEmpleado = $("#nombreEmpleado");
$nombreEmpleado.keyup(function(){
	//si el campo no está vacio verificarlo.
	if($nombreEmpleado.val() === null | $nombreEmpleado.val() === "")
	{
		$nombreEmpleado.prop("required", false);
		$nombreEmpleado.removeClass("is-invalid");
		$nombreEmpleado.removeClass("is-valid");

	}
	else
	{
		$nombreEmpleado.prop("required", true);
		validarNombres($nombreEmpleado);
	}
});

$estadom = $("#estadom");
$estadom.change(function (){
	validarSelect($estadom);
});


$fechaNacimiento = $("#fechaNacimiento");
function validarFechaNac(){
	//si el campo no está vacio verificarlo.
	if($fechaNacimiento.val() === null | $fechaNacimiento.val() === "")
	{
		$fechaNacimiento.prop("required", false);
		$fechaNacimiento.removeClass("is-invalid");
		$fechaNacimiento.removeClass("is-valid");

	}
	else
	{
		$fechaNacimiento.prop("required", true);
		validarFecha($fechaNacimiento);
	}
}
$fechaNacimiento.keyup(validarFechaNac);



$rfc = $("#rfc");
$rfc.keyup(function(){
	//si el campo no está vacio verificarlo.
	if($rfc.val() === null | $rfc.val() === "")
	{
		$rfc.prop("required", false);
		$rfc.removeClass("is-invalid");
		$rfc.removeClass("is-valid");

	}
	else
	{
		$rfc.prop("required", true);
		validarRFC($rfc);
	}
});

$curp = $("#curp");
$curp.keyup(function(){
	//si el campo no está vacio verificarlo.
	if($curp.val() === null | $curp.val() === "")
	{
		$curp.prop("required", false);
		$curp.removeClass("is-invalid");
		$curp.removeClass("is-valid");

	}
	else
	{
		$curp.prop("required", true);
		validarCURP($curp);
	}
});

$segSocial = $("#segSocial");
$segSocial.keyup(function(){
	//si el campo NSS no está vacio verificarlo.
	if(!($segSocial.val() === null | $segSocial.val() === ""))
		{
			$segSocial.prop("required", true);
			$segSocial.removeClass("is-invalid");
			$segSocial.removeClass("is-valid");

		}else{
		$segSocial.prop("required", true);
		validarSS($segSocial);
	}
});

$calle = $("#calle");
$calle.keyup(function(){
	//si el campo NSS no está vacio verificarlo.
	if(!($calle.val() === null | $calle.val() === ""))
		{
			$calle.prop("required", true);
			$calle.removeClass("is-invalid");
			$calle.removeClass("is-valid");

		}else{
		$calle.prop("required", true);
		validarNombres($calle);
	}
});

$colonia = $("#colonia");
$colonia.keyup(function(){
	//si el campo NSS no está vacio verificarlo.
	if(!($colonia.val() === null | $colonia.val() === ""))
		{
			$colonia.prop("required", true);
			$colonia.removeClass("is-invalid");
			$colonia.removeClass("is-valid");

		}else{
		$colonia.prop("required", true);
		validarNombres($colonia);
	}
});

$ciudad = $("#ciudad");
$ciudad.keyup(function(){
	//si el campo NSS no está vacio verificarlo.
	if(!($ciudad.val() === null | $ciudad.val() === ""))
		{
			$ciudad.prop("required", true);
			$ciudad.removeClass("is-invalid");
			$ciudad.removeClass("is-valid");

		}else{
		$ciudad.prop("required", true);
		validarNombres($ciudad);
	}
});

$estado = $("#estado");
$estado.keyup(function(){
	//si el campo NSS no está vacio verificarlo.
	if(!($estado.val() === null | $estado.val() === ""))
		{
			$estado.prop("required", true);
			$estado.removeClass("is-invalid");
			$estado.removeClass("is-valid");

		}else{
		$estado.prop("required", true);
		validarNombres($estado);
	}
});

$numeroInt = $("#numeroInt");
$numeroInt.keyup(function(){
	if($numeroInt.val() === null | $numeroInt.val() === "")
	{
		$numeroInt.prop("required", false);
		$numeroInt.removeClass("is-invalid");
		$numeroInt.removeClass("is-valid");
	}
	else
	{
		$numeroInt.prop("required", true);
		validarNumeros($numeroInt);
	}
});


$numeroExt = $("#numeroExt");
$numeroExt.keyup(function(){
	if($numeroExt.val() === null | $numeroInt.val() === "")
	{
		$numeroExt.prop("required", false);
		$numeroExt.removeClass("is-invalid");
		$numeroExt.removeClass("is-valid");
	}
	else
	{
		$numeroExt.prop("required", true);
		validarNumeros($numeroExt);
	}
});

$cp = $("#cp");
$cp.keyup(function(){
	if($cp.val() === null | $cp.val() === "")
	{
		$cp.prop("required", false);
		$cp.removeClass("is-invalid");
		$cp.removeClass("is-valid");
	}
	else
	{
		$cp.prop("required", true);
		validarNumeros($cp);
	}
});

$correo = $("#correo");
$correo.keyup(function(){
	if($correo.val() === null | $correo.val() === "")
	{
		$correo.prop("required", false);
		$correo.removeClass("is-invalid");
		$correo.removeClass("is-valid");
	}
	else
	{
		$correo.prop("required", true);
		validarCorreo($correo);
	}
});

$tel = $("#tel");
$tel.keyup(function(){
	if($tel.val() === null | $tel.val() === "")
	{
		$tel.prop("required", false);
		$tel.removeClass("is-invalid");
		$tel.removeClass("is-valid");
	}
	else
	{
		$tel.prop("required", true);
		validarNumeros($tel);
	}
});



$cel = $("#cel");
$cel.keyup(function(){
	if($cel.val() === null | $cel.val() === "")
	{
		$cel.prop("required", false);
		$cel.removeClass("is-invalid");
		$cel.removeClass("is-valid");
	}
	else
	{
		$cel.prop("required", true);
		validarNumeros($cel);
	}
});

$fechaIngreso = $("#fechaIngreso");
function validarFechaIngreso(){
	//si el campo no está vacio verificarlo.
	if($fechaIngreso.val() === null | $fechaNacimiento.val() === "")
	{
		$fechaIngreso.prop("required", false);
		$fechaIngreso.removeClass("is-invalid");
		$fechaIngreso.removeClass("is-valid");

	}
	else
	{
		$fechaIngreso.prop("required", true);
		validarFecha($fechaIngreso);
	}
}
$fechaIngreso.keyup(validarFechaIngreso);

$idPuesto = $("#puesto");
$idPuesto.change(function (){
	validarSelect($idPuesto);
});

$idEstCivil = $("#estadocivil");
$idEstCivil.change(function (){
	validarSelect($idEstCivil);
});

$horaInicio = $("#horaInicio");
$horaInicio.change(function(){
	//si el campo no está vacio verificarlo.
	if($horaInicio.val() === null | $horaInicio.val() === "")
	{
		$horaInicio.prop("required", false);
		$horaInicio.removeClass("is-invalid");
		$horaInicio.removeClass("is-valid");

	}
	else
	{
		$horaInicio.prop("required", true);
		console.log($horaInicio.val());
		validarHora($horaInicio);
	}
});

$horaFin = $("#horaFin");
$horaFin.change(function(){
	//si el campo no está vacio verificarlo.
	if($horaFin.val() === null | $horaFin.val() === "")
	{
		$horaFin.prop("required", false);
		$horaFin.removeClass("is-invalid");
		$horaFin.removeClass("is-valid");

	}
	else
	{
		$horaFin.prop("required", true);
		validarHora($horaFin);
	}
});




/**************************************
	NAVEGABILIDAD EN EL FORM
**************************************/
function backDatosPersonales(){
	document.getElementById("datosContacto").style.display = "none";
	document.getElementById("datosPersonales2").style.display = "block";
	document.getElementById("progressBar").style.width = "25%";

}

function backDatosPersonales2(){
	document.getElementById("datosPersonales2").style.display = "none";
	document.getElementById("datosPersonales").style.display = "block";
	document.getElementById("progressBar").style.width = "0%";

}

function backDatosContratacion(){
	document.getElementById("datosContacto").style.display = "block";
	document.getElementById("datosContratacion").style.display = "none";

	document.getElementById("progressBar").style.width = "50%";

}

function backDatosNomina(){
	document.getElementById("datosContratacion").style.display = "block";
		document.getElementById("progressBar").style.width = "50%";
		document.getElementById("datosNomina").style.display = "none";

}

function nextDatosContacto(){

	//Si no pasa alguna validación obligatoria dejar de ejecutar la función
	 document.getElementById('submitV').style.visibility = "hidden";

	if(!validarSelect($idPuesto) |!validarNombres($nombreEmpleado) | !validarFecha($fechaNacimiento) | !validarSelect($estadom) | !validarRFC($rfc) | !validarCURP($curp))

		return;



	//si el campo NSS no está vacio verificarlo.
	if(!($segSocial.val() === null | $segSocial.val() === ""))
	{
		$segSocial.prop("required", true);

		if(!validarSS($segSocial))
			return;
	}
	document.getElementById("datosContacto").style.display = "block";
	document.getElementById("datosPersonales2").style.display = "none";
	document.getElementById("progressBar").style.width = "50%";

}

function nextDatosPers2(){

	//Si no pasa alguna validación obligatoria dejar de ejecutar la función
	//document.getElementById('submitV').style.visibility = "hidden";

	if(!validarSelect($idPuesto) |!validarNombres($nombreEmpleado) | !validarFecha($fechaNacimiento) | !validarSelect($estadom))

		return;



	//si el campo NSS no está vacio verificarlo.
	if(!($segSocial.val() === null | $segSocial.val() === ""))
	{
		$segSocial.prop("required", true);

		if(!validarSS($segSocial))
			return;
	}
	document.getElementById("datosPersonales2").style.display = "block";
	document.getElementById("datosPersonales").style.display = "none";
	document.getElementById("progressBar").style.width = "25%";

}

function nextDatosContrat(){
	//Si no pasa alguna validación obligatoria dejar de ejecutar la función

	if( !validarNombres($calle)  | !validarNombres($colonia) | !validarNombres($ciudad) | !validarNombres($estado) | !validarNumeros($cp) )
		return;

	//si el campo curp no está vacio verificarlo.
	if(!($numeroExt.val() === null | $numeroExt.val() === ""))
	{
		$numeroExt.prop("required", true);

		if(!validarNumeros($numeroExt))
			return;
	}
	//si el campo curp no está vacio verificarlo.
	if(!($numeroInt.val() === null | $numeroInt.val() === ""))
	{
		$numeroInt.prop("required", true);

		if(!validarNumeros($numeroInt))
			return;
	}

	//si el campo cel no está vacio verificarlo.
	if(!($cel.val() === null | $cel.val() === ""))
	{
		$cel.prop("required", true);

		if(!validarNumeros($cel))
			return;
	}

	//si el campo rfc no está vacio verificarlo.
	if(!($tel.val() === null | $tel.val() === ""))
	{
		$tel.prop("required", true);

		if(!validarNumeros($tel))
			return;
	}

	//si el campo NSS no está vacio verificarlo.
	if(!($correo.val() === null | $correo.val() === ""))
	{
		$correo.prop("required", true);

		if(!validarCorreo($correo))
			return;
	}
		document.getElementById("datosContacto").style.display = "none";
		document.getElementById("datosContratacion").style.display = "block";
		document.getElementById("progressBar").style.width = "60%";
}

function nextDatosNom(){
	//Si no pasa alguna validación obligatoria dejar de ejecutar la función
	if(!validarFecha($fechaIngreso))
		return;

	//si el campo NSS no está vacio verificarlo.
	if(!($horaInicio.val() === null | $horaInicio.val() === ""))
	{
		$horaInicio.prop("required", true);

		if(!validarHora($horaInicio))
			return;
	}
	//si el campo horaFin no está vacio verificarlo.
	if(!($horaInicio.val() === null | $horaInicio.val() === ""))
	{
		$horaInicio.prop("required", true);

		if(!validarHora($horaInicio))
			return;
	}
	var vol=0;
	if( vol == 1){
		console.log("es 1");
		document.getElementById("datosContratacion").style.display = "none";
		document.getElementById("progressBar").style.width = "75%";
		document.getElementById("archivosEmp").style.display = "block";
	}else if( vol == 0) {
		document.getElementById("datosContratacion").style.display = "none";
		document.getElementById("progressBar").style.width = "75%";
		document.getElementById("datosNomina").style.display = "block";
	}

}

function submitForm(id){
	let valido = true;
	if($("#voluntarioBool").val() == 1){
		if(!validarSelect($idPuesto) | !validarFecha($fechaIngreso))
		valido = false;

	//si el campo NSS no está vacio verificarlo.
	if(!($horaInicio.val() === null | $horaInicio.val() === ""))
	{
		$horaInicio.prop("required", true);

		if(!validarHora($horaInicio))
			return;
	}
	//si el campo horaFin no está vacio verificarlo.
	if(!($horaInicio.val() === null | $horaInicio.val() === ""))
	{
		$horaInicio.prop("required", true);

		if(!validarHora($horaInicio))
			return;
	}


	var vol=0;
	if( vol == 1){
		console.log("es 1");
		document.getElementById("datosContratacion").style.display = "none";
		document.getElementById("progressBar").style.width = "100%";
		$('#submitV').html(" <span class='spinner-horder spinner-border-sm' role='status' aria-hidden='true'></span>Cargando...");
		$('#submitV').prop("disabled", true);
	}

	}else if( vol == 0) {
		document.getElementById("datosContratacion").style.display = "none";
		document.getElementById("progressBar").style.width = "75%";
		document.getElementById("datosNomina").style.display = "block";

	}else{
		if(!validarSelect($idEstCivil) )
		valido = false;
	}
	//Si no pasa alguna validación obligatoria dejar de ejecutar la función

	if(!valido)
		return;
	//document.getElementById("datosNomina").style.display = "none";
	document.getElementById("progressBar").style.width = "100%";
	//esperar a que cargue el progressbar
	setTimeout(function(){$("#"+id).submit()}, 800);
	//document.getElementById("benefNomina").style.display = "block";
	$('#subir').html(" <span class='spinner-horder spinner-border-sm' role='status' aria-hidden='true'></span>Cargando...");
	$('#subir').prop("disabled", true);

}

/*function nextArch(){

		document.getElementById("benefNomina").style.display = "none";
		document.getElementById("progressBar").style.width = "90%";
		document.getElementById("archivosEmp").style.display = "block";
}

function submitEmpleados(){

		document.getElementById("archivosEmp").style.display = "none";
		document.getElementById("registroExitoso").style.display = "block";
		document.getElementById("progressBar").style.width = "100%";
}*/


$("#voluntario").click(function () {
    if ($(this).prop("checked")) {

		document.getElementById('registrarEmpleado').action = "../controladores/empleados/controlador_insertarVoluntario.php";
		document.getElementById('btnNomina').style.visibility = "hidden";
		document.getElementById('btnBackNom').style.visibility = "hidden";
		document.getElementById('submitV').style.visibility = "visible";
        $("#voluntarioBool").val("1");
        vol = 1;
    }
    else {
        $("#voluntarioBool").val("0");
        document.getElementById('registrarEmpleado').action = "../controladores/empleados/controlador_insertarEmpleado.php";
        document.getElementById('btnNomina').style.visibility = "visible";
        document.getElementById('submitV').style.visibility = "hidden";
        vol = 0;
    }
});

var diasT = new Array();

function llenarDiasT(dia){

	if ($.isEmptyObject(diasT)){
		diasT.unshift(dia);
	}else{
		diasT.push(dia);
	}
	console.log(diasT);
	document.getElementById("diasT").value = diasT;
}

function quitarDiasT(indexReducido){
	if(indexReducido==0){
		diasT.shift();
	}else
	diasT.splice(indexReducido,1);
	console.log(diasT);
	document.getElementById("diasT").value = diasT;
}



function obtenerDia(checkbox){
	switch(checkbox.id){
		case "lunes":
			if(checkbox.checked == true){
				llenarDiasT("Lunes");
			}
			else{
				quitarDiasT(0);
			}
		break;
		case "martes":
			if(checkbox.checked == true){
			llenarDiasT("Martes");
			}
			else{
				quitarDiasT(1);
			}
		break;
		case "miercoles":
			if(checkbox.checked == true){
			llenarDiasT("Miercoles");
			}
			else{
				quitarDiasT(2);
			}
		break;
		case "jueves":
			if(checkbox.checked == true){
			llenarDiasT("Jueves");
			}
			else{
				quitarDiasT(3);
			}
		break;
		case "viernes":
			if(checkbox.checked == true){
			llenarDiasT("Viernes");
			}
			else{
				quitarDiasT(4);
			}
		break;
		case "sabado":
			if(checkbox.checked == true){
			llenarDiasT("Sabado");
			}
			else{
				quitarDiasT(5);
			}
		break;
		case "domingo":
			if(checkbox.checked == true){
			llenarDiasT("Domingo");
			}
			else{
				quitarDiasT(6);
			}
		break;
	}
}

var selectedDate;
$(function() {
	$('#fechaNacimiento').daterangepicker({
	  singleDatePicker: true,
	  showDropdowns: true,
	  autoUpdateInput: false,
	  minYear: 1901,
	  maxYear: parseInt(moment().format('YYYY'),10),
	  "locale": {
        "format": "DD-MM-YYYY",
        "separator": " - ",
        "applyLabel": "Aceptar",
        "cancelLabel": "Cancelar",
        "fromLabel": "Desde",
        "toLabel": "Hasta",
        "customRangeLabel": "Personalizado",
        "weekLabel": "W",
        "daysOfWeek": [
            "Dom",
            "Lun",
            "Mar",
            "Mier",
            "Jue",
            "Vie",
            "Sab"
        ],
        "monthNames": [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        ],
        "firstDay": 1
    },
	});
  });
$('#fechaNacimiento').on('apply.daterangepicker', function(ev, picker) {
	$(this).val(picker.endDate.format('DD-MM-YYYY'));
	selectedDate= picker.endDate.format('MM-DD-YYYY');
	validarFechaNac($(this).val());
});


var selectedDate;
$(function() {
	$('#fechaIngreso').daterangepicker({
	  singleDatePicker: true,
	  showDropdowns: true,
	  autoUpdateInput: false,
	  minYear: 1901,
	  maxYear: parseInt(moment().format('YYYY'),10),
	  "locale": {
        "format": "DD-MM-YYYY",
        "separator": " - ",
        "applyLabel": "Aceptar",
        "cancelLabel": "Cancelar",
        "fromLabel": "Desde",
        "toLabel": "Hasta",
        "customRangeLabel": "Personalizado",
        "weekLabel": "W",
        "daysOfWeek": [
            "Dom",
            "Lun",
            "Mar",
            "Mier",
            "Jue",
            "Vie",
            "Sab"
        ],
        "monthNames": [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        ],
        "firstDay": 1
    },
	});
  });
$('#fechaIngreso').on('apply.daterangepicker', function(ev, picker) {
	$(this).val(picker.endDate.format('DD-MM-YYYY'));
	selectedDate= picker.endDate.format('MM-DD-YYYY');
	validarFechaIngreso($(this).val());
});
