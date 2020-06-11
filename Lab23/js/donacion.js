/*
	FUNCIONES PARA GENERALES
*/
function isPrice(myString) {
	return /^\d{1,12}(.\d{1,2})?$/.test(myString);
}
function isNullOrWhitespace( input ) {
	return !input || !input.trim();
}
function isDate(date)
{
	return /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/.test(date);
}

/*
	FUNCIONES PARA VALIDACIONES
*/ 

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

function validarPrecio($precio)
{
	if($precio.prop("validity").valid & isPrice($precio.val()))
	{
		$precio.addClass("is-valid");
		$precio.removeClass("is-invalid");
		return true;
	}
	else
	{
		$precio.addClass("is-invalid");
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

$idTipoDonacion = $("#tipoDonacion");
$idTipoDonacion.change(function (){
	validarSelect($idTipoDonacion);
});

$fecha = $("#fecha");


function validarFechaHistorico(){
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
$fecha.keyup(validarFechaHistorico);



$valor = $("#valor");
$valor.keyup(function(){
	//si el campo no está vacio verificarlo.
	if($valor.val() === null | $valor.val() === "")
	{	
		$valor.prop("required", false);
		$valor.removeClass("is-invalid");
		$valor.removeClass("is-valid");
		
	}
	else
	{
		$valor.prop("required", true);
		validarPrecio($valor);
	}
});

$descripcion = $("#descripcion");
$descripcion.keyup(function(){
	//si el campo no está vacio verificarlo.
	if($descripcion.val() === null | $descripcion.val() === "")
	{	
		$descripcion.prop("required", false);
		$descripcion.removeClass("is-invalid");
		$descripcion.removeClass("is-valid");
		
	}
	else
	{
		$descripcion.prop("required", true);
		validarTexto($descripcion);
	}
});


/*
	FUNCIONES PARA NAVEGACIÓN EN EL FORMULARIO
*/

function backTipoDonacion(){
	document.getElementById("donacionEspecie").style.opacity = 0;
	document.getElementById("donacionEspecie").style.position = "absolute";
	document.getElementById("donacionEspecie").style.width = "1%";

	document.getElementById("donacionEfectivo").style.opacity = 0;
	document.getElementById("donacionEfectivo").style.position = "absolute";
	document.getElementById("donacionEfectivo").style.width = "1%";

	document.getElementById("botonesDonacion").style.visibility = "hidden";

	document.getElementById("tipoDeDonacion").style.opacity = 100;
	document.getElementById("tipoDeDonacion").style.position = "relative";
	document.getElementById("tipoDeDonacion").style.width = "100%";

	document.getElementById("progressBar").style.width = "0%";

}

function nextDatos(){
	let valido = true;

	//Si no pasa alguna validación obligatoria dejar de ejecutar la función
	if(!validarSelect($idTipoDonacion) | !validarFecha($fecha))
		return;

	document.getElementById("tipoDeDonacion").style.opacity = 0;
	document.getElementById("tipoDeDonacion").style.position = "absolute";
	document.getElementById("tipoDeDonacion").style.width = "1%";

	document.getElementById("botonesDonacion").style.visibility = "visible";
	switch($idTipoDonacion.val())
	{	//si es efectivo
		case '1':
			document.getElementById("donacionEfectivo").style.opacity = 100;
			document.getElementById("donacionEfectivo").style.position = "relative";
			document.getElementById("donacionEfectivo").style.width = "100%";

			document.getElementById("donacionEspecie").style.opacity = 0;
			document.getElementById("donacionEspecie").style.position = "absolute";
			document.getElementById("donacionEspecie").style.width = "1%";
		break;
		//si es especie
		case '2':
			document.getElementById("donacionEspecie").style.opacity = 100;
			document.getElementById("donacionEspecie").style.position = "relative";
			document.getElementById("donacionEspecie").style.width = "100%";

			document.getElementById("donacionEfectivo").style.opacity = 0;
			document.getElementById("donacionEfectivo").style.position = "absolute";
			document.getElementById("donacionEfectivo").style.width = "1%";
		break;
	}
	
	document.getElementById("progressBar").style.width = "50%";
}

function submitForm(id)
{
	let valido = true;

	//si el campo direccion no está vacio verificarlo.
	if(!($valor.val() === null | $valor.val() === ""))
	{
		$valor.prop("required", true);
		
		if(!validarPrecio($valor))
			valido = false;
	}

	//si el campo cp no está vacio verificarlo.
	if(!($descripcion.val() === null | $descripcion.val() === ""))
	{
		$descripcion.prop("required", true);
		
		if(!validarTexto($descripcion))
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
	$('#fecha').daterangepicker({
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
$('#fecha').on('apply.daterangepicker', function(ev, picker) {
	$(this).val(picker.endDate.format('DD-MM-YYYY'));
	selectedDate= picker.endDate.format('MM-DD-YYYY');
	validarFechaHistorico($(this).val());
});
