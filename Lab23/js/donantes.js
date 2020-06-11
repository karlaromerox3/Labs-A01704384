/*
	FUNCIONES PARA GENERALES
*/
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

function isDate(date)
{
	return /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/.test(date);
}

function isRFC(rfc)
{
	return /^(([ÑA-Z|ña-z|&amp;]{3}|[A-Z|a-z]{4})\d{2}((0[1-9]|1[012])(0[1-9]|1\d|2[0-8])|(0[13456789]|1[012])(29|30)|(0[13578]|1[02])31)(\w{2})([A|a|0-9]{1}))$|^(([ÑA-Z|ña-z|&amp;]{3}|[A-Z|a-z]{4})([02468][048]|[13579][26])0229)(\w{2})([A|a|0-9]{1})$/.test(rfc);
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

function validarTexto($texto)
{
	if($texto.prop("validity").valid & !isNullOrWhitespace($texto.val()))
	{
		$texto.addClass("is-valid");
		$texto.removeClass("is-invalid");
		return true;
	}
	else
	{
		$texto.addClass("is-invalid");
		return false;
	}
}

$id = $("#tipodeDonante");
$id.change(function (){
	validarSelect($id);
});

$frecuencia = $("#frecuenciaDonante");
$frecuencia.change(function (){
	validarSelect($frecuencia);
});

$nombre = $("#nombreDonante");
$nombre.keyup(function (){
	validarNombres($nombre);
});




$contacto = $("#contactoInterno");
$contacto.keyup(function(){
	//si el campo no está vacio verificarlo.
	if($contacto.val() === null | $contacto.val() === "")
	{
		$contacto.prop("required", false);
		$contacto.removeClass("is-invalid");
		$contacto.removeClass("is-valid");

	}
	else
	{
		$contacto.prop("required", true);
		validarNombres($contacto);
	}
});

$correo = $("#correoParticular");
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
})

$telefono = $("#telefonoParticular");
$telefono.keyup(function(){
	if($telefono.val() === null | $telefono.val() === "")
	{
		$telefono.prop("required", false);
		$telefono.removeClass("is-invalid");
		$telefono.removeClass("is-valid");
	}
	else
	{
		$telefono.prop("required", true);
		validarNumeros($telefono);
	}
})

$extension = $("#extensionParticular");
$extension.keyup(function(){
	if($extension.val() === null | $extension.val() === "")
	{
		$extension.prop("required", false);
		$extension.removeClass("is-invalid");
		$extension.removeClass("is-valid");
	}
	else
	{
		$extension.prop("required", true);
		validarNumeros($extension);
	}
})

$celular = $("#celularParticular");
$celular.keyup(function(){
	if($celular.val() === null | $celular.val() === "")
	{
		$celular.prop("required", false);
		$celular.removeClass("is-invalid");
		$celular.removeClass("is-valid");
	}
	else
	{
		$celular.prop("required", true);
		validarNumeros($celular);
	}
})

$fecha = $("#fechaNacParticular");


function validarFechaNac(){
	//si el campo no está vacio verificarlo.
	if($fecha.val() === null | $fecha.val() === "")
	{
		$fecha.prop("required", false);
		$fecha.removeClass("is-invalid");
		$fecha.removeClass("is-valid");

	}
	else
	{
		$fecha.prop("required", true);
		validarFecha($fecha);
	}
}
$fecha.keyup(validarFechaNac);

$razonSocial = $("#razonSocial");
$razonSocial.keyup(function(){
	//si el campo no está vacio verificarlo.
	if($razonSocial.val() === null | $razonSocial.val() === "")
	{
		$razonSocial.prop("required", false);
		$razonSocial.removeClass("is-invalid");
		$razonSocial.removeClass("is-valid");

	}
	else
	{
		$razonSocial.prop("required", true);
		validarNombres($razonSocial);
	}
});

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


$direccion = $("#direccionEntidad");
$direccion.keyup(function(){
	//si el campo no está vacio verificarlo.
	if($direccion.val() === null | $direccion.val() === "")
	{
		$direccion.prop("required", false);
		$direccion.removeClass("is-invalid");
		$direccion.removeClass("is-valid");

	}
	else
	{
		$direccion.prop("required", true);
		validarTexto($direccion);
	}
});

$cp = $("#cpEntidad");
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
})



/*
	FUNCIONES PARA NAVEGACIÓN EN EL FORMULARIO
*/
//tipo 1 es para donantes particulares y 2 para entidades
function backDatosFacturacion(){
	document.getElementById("donanteParticular").style.opacity = 0;
	document.getElementById("donanteParticular").style.position = "absolute";
	document.getElementById("donanteParticular").style.width = "1%";

	document.getElementById("donanteEmpresa").style.opacity = 0;
	document.getElementById("donanteEmpresa").style.position = "absolute";
	document.getElementById("donanteEmpresa").style.width = "1%";

	document.getElementById("botonesDonantes").style.visibility = "hidden";

	document.getElementById("datosFacturacion").style.opacity = 100;
	document.getElementById("datosFacturacion").style.position = "relative";
	document.getElementById("datosFacturacion").style.width = "100%";

	document.getElementById("progressBar").style.width = "33%";

}

function backDonanteGeneral(){
	document.getElementById("datosFacturacion").style.opacity = 0;
	document.getElementById("datosFacturacion").style.position = "absolute";
	document.getElementById("datosFacturacion").style.width = "1%";

	document.getElementById("donanteGeneral").style.opacity = 100;
	document.getElementById("donanteGeneral").style.position = "relative";
	document.getElementById("donanteGeneral").style.width = "100%";

	document.getElementById("progressBar").style.width = "0%";

}

function nextDatos(){
	let valido = true;

	//Si no pasa alguna validación obligatoria dejar de ejecutar la función
	if(!validarSelect($id) | !validarNombres($nombre) | !validarSelect($frecuencia))
		valido = false;
	
	if(!($correo.val() === null | $correo.val() === ""))
	{
		$correo.prop("required", true);
		
		if(!validarCorreo($correo))
			valido = false;
	}

	//si el campo contacto no está vacio verificarlo.
	if(!($contacto.val() === null | $contacto.val() === ""))
	{
		$contacto.prop("required", true);

		if(!validarNombres($contacto))
			valido = false;
	}
	
	if(!valido)
		return;

	document.getElementById("donanteGeneral").style.opacity = 0;
	document.getElementById("donanteGeneral").style.position = "absolute";
	document.getElementById("donanteGeneral").style.width = "1%";

	document.getElementById("datosFacturacion").style.opacity = 100;
	document.getElementById("datosFacturacion").style.position = "relative";
	document.getElementById("datosFacturacion").style.width = "100%";

	
	document.getElementById("progressBar").style.width = "33%";
}

function acabarRegistro(id)
{
	let valido = true;

	//si el campo razonSocial no está vacio verificarlo.
	if(!($razonSocial.val() === null | $razonSocial.val() === ""))
	{
		$razonSocial.prop("required", true);
		
		if(!validarNombres($razonSocial))
			valido = false;
	}

	//si el campo rfc no está vacio verificarlo.
	if(!($rfc.val() === null | $rfc.val() === ""))
	{
		$rfc.prop("required", true);
		
		if(!validarRFC($rfc))
			valido = false;
	}

	if(!valido)
		return;

	document.getElementById("datosFacturacion").style.opacity = 0;
	document.getElementById("datosFacturacion").style.position = "absolute";
	document.getElementById("datosFacturacion").style.width = "1%";
	document.getElementById("botonesDonantes").style.visibility = "visible";
	switch($id.val())
	{	//si es Empresa, Gobierno o Fundación, solo se muestra la sección de entidad
		case '1': case '2': case '6':
			submitForm(id);
		break;
		//si es Particular, Cargo a tarjeta o fundación, solo se muestra la sección de particular
		case '3': case '4': case '5':
			document.getElementById("donanteParticular").style.opacity = 100;
			document.getElementById("donanteParticular").style.position = "relative";
			document.getElementById("donanteParticular").style.width = "100%";

			document.getElementById("donanteEmpresa").style.opacity = 0;
			document.getElementById("donanteEmpresa").style.position = "absolute";
			document.getElementById("donanteEmpresa").style.width = "1%";
		break;
		//si es otros contactos, se muestran las dos secciones
		case '7': default:
			document.getElementById("donanteEmpresa").style.opacity = 100;
			document.getElementById("donanteEmpresa").style.position = "relative";
			document.getElementById("donanteEmpresa").style.width = "100%";

			document.getElementById("donanteParticular").style.opacity = 100;
			document.getElementById("donanteParticular").style.position = "relative";
			document.getElementById("donanteParticular").style.width = "100%";
		break;
	}

	document.getElementById("progressBar").style.width = "66%";
}

function submitForm(id){
	let valido = true;

	//si el campo telefono no está vacio verificarlo.
	if(!($telefono.val() === null | $telefono.val() === ""))
	{
		$telefono.prop("required", true);

		if(!validarNumeros($telefono))
			valido = false;
	}

	//si el campo extension no está vacio verificarlo.
	if(!($extension.val() === null | $extension.val() === ""))
	{
		$extension.prop("required", true);

		if(!validarNumeros($extension))
			valido = false;
	}

	//si el campo celular no está vacio verificarlo.
	if(!($celular.val() === null | $celular.val() === ""))
	{
		$celular.prop("required", true);

		if(!validarNumeros($celular))
			valido = false;
	}

	//si el campo fecha no está vacio verificarlo.
	if(!($fecha.val() === null | $fecha.val() === ""))
	{
		$fecha.prop("required", true);

		if(!validarFecha($fecha))
			valido = false;
	}

	//si el campo direccion no está vacio verificarlo.
	if(!($direccion.val() === null | $direccion.val() === ""))
	{
		$direccion.prop("required", true);
		
		if(!validarTexto($direccion))
			valido = false;
	}

	//si el campo cp no está vacio verificarlo.
	if(!($cp.val() === null | $cp.val() === ""))
	{
		$cp.prop("required", true);

		if(!validarNumeros($cp))
			valido = false;
	}
	if(!valido)
		return;

	document.getElementById("progressBar").style.width = "100%";
	//esperar a que cargue el progressbar
	setTimeout(function(){$("#"+id).submit()}, 800);
	$('#subir').html(" <span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>Cargando...");
	$('#subir').prop("disabled", true);

}




/*
	FUNCIONES PARA DATEPICKER
*/
var selectedDate;
$(function() {
	$('#fechaNacParticular').daterangepicker({
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
$('#fechaNacParticular').on('apply.daterangepicker', function(ev, picker) {
	$(this).val(picker.endDate.format('DD-MM-YYYY'));
	selectedDate= picker.endDate.format('MM-DD-YYYY');
	validarFechaNac($(this).val());
});
