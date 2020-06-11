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


$nombre = $("#nombre");
$nombre.keyup(function (){
	validarNombres($nombre);
});

$cargo = $("#cargo");
$cargo.keyup(function(){
	//si el campo no está vacio verificarlo.
	if($cargo.val() === null | $cargo.val() === "")
	{	
		$cargo.prop("required", false);
		$cargo.removeClass("is-invalid");
		$cargo.removeClass("is-valid");
		
	}
	else
	{
		$cargo.prop("required", true);
		validarTexto($cargo);
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
})

$telefono = $("#telefono");
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

$extension = $("#extension");
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

$celular = $("#celular");
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

$fecha = $("#fechaNacimiento");
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


function submitForm(id)
{
	let valido = true;

	//Si no pasa alguna validación obligatoria dejar de ejecutar la función
	if(!validarNombres($nombre))
		valido = false;
	
	//si el campo cargo no está vacio verificarlo.
	if(!($cargo.val() === null | $cargo.val() === ""))
	{
		$cargo.prop("required", true);
		
		if(!validarTexto($cargo))
			valido = false;
	}

	if(!($correo.val() === null | $correo.val() === ""))
	{
		$correo.prop("required", true);
		
		if(!validarCorreo($correo))
			valido = false;
	}
	
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

	if(!valido)
		return;

	$("#"+id).submit();
	$('#subir').html(" <span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>Cargando...");
	$('#subir').prop("disabled", true);
}


/*
	FUNCIONES PARA DATEPICKER
*/
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