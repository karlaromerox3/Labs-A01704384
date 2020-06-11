function hasNumber(myString) {
  return /\d/.test(myString);
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
function validarNombres($nombre)
{
  if($nombre.prop("validity").valid && !hasNumber($nombre.val()) && !isNullOrWhitespace($nombre.val()))
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

function validarTexto($texto)
{
  if($texto.prop("validity").valid)
  if($texto.prop("validity").valid)
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

function validarNumeros($numero)
{
  if($numero.prop("validity").valid & !isNaN($numero.val()))
  {
    $numero.addClass("is-valid");
    $numero.removeClass("is-invalid");
    return true;
  }
  else
  {
    $numero.addClass("is-invalid");
    return false;
  }
}

/*
  OBTENER DATOS
*/

$nombreCompleto = $("#nombreCompleto");
$nombreCompleto.keyup(function(){
  //si el campo no está vacio verificarlo.
  if($nombreCompleto.val() === null | $nombreCompleto.val() === "")
  {
    $nombreCompleto.prop("required", false);
    $nombreCompleto.removeClass("is-invalid");
    $nombreCompleto.removeClass("is-valid");

  }
  else
  {
    $nombreCompleto.prop("required", true);
    validarNombres($nombreCompleto);
  }
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

$tipoSangre = $("#tipoSangre");
$tipoSangre.change(function (){
  validarSelect($tipoSangre);
});

//VALIDAR ANTECEDENTES
$antecedentes = $("#antecedentes");
$antecedentes.keyup(function(){
  //si el campo NSS no está vacio verificarlo.
  if(!($antecedentes.val() === null | $antecedentes.val() === ""))
    {
      $antecedentes.prop("required", true);
      $antecedentes.removeClass("is-invalid");
      $antecedentes.removeClass("is-valid");

    }else{
    $antecedentes.prop("required", true);
    validarTexto($antecedentes);
  }
});

$idDiagnostico = $("#diagnosticos");
$idDiagnostico.change(function (){
  validarSelect($idDiagnostico);
});

// VALIDAR DIAGNÓSTICO MOTRIZ 
$diagnosticoMotriz = $("#diagnosticoMotriz");
$diagnosticoMotriz.keyup(function(){
  //si el campo NSS no está vacio verificarlo.
  if(!($diagnosticoMotriz.val() === null | $diagnosticoMotriz.val() === ""))
    {
      $diagnosticoMotriz.prop("required", true);
      $diagnosticoMotriz.removeClass("is-invalid");
      $diagnosticoMotriz.removeClass("is-valid");

    }else{
    $diagnosticoMotriz.prop("required", true);
    validarNombres($diagnosticoMotriz);
  }
});

//VALIDAR EDAD MENTAL 
$edadMental = $("#edadMental");
$edadMental.keyup(function(){
  if($edadMental.val() === null | $edadMental.val() === "")
  {
    $edadMental.prop("required", false);
    $edadMental.removeClass("is-invalid");
    $edadMental.removeClass("is-valid");
  }
  else
  {
    $edadMental.prop("required", true);
    validarNumeros($edadMental);
  }
});

$fechaIngreso = $("#fechaIngreso");
function validarFechaIng(){
  //si el campo no está vacio verificarlo.
  if($fechaIngreso.val() === null | $fechaIngreso.val() === "")
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
$fechaIngreso.keyup(validarFechaIng);

$idMotivoIngreso = $("#motivosIngreso");
$idMotivoIngreso.change(function (){
  validarSelect($idMotivoIngreso);
});

$nombreCanaliza = $("#nombreCanaliza");
$nombreCanaliza.keyup(function(){
  if($nombreCanaliza.val() === null | $nombreCanaliza.val() === "")
  { 
    $nombreCanaliza.prop("required", false);
    $nombreCanaliza.removeClass("is-invalid");
    $nombreCanaliza.removeClass("is-valid");
    
  }
  else
  {
    console.log($nombreCanaliza.val());
    $nombreCanaliza.prop("required", true);
    validarNombres($nombreCanaliza);
  }
});

// VALIDAR CONSIDERACIONES INGRESO 
$consideracionesIngreso = $("#consideracionesIngreso");
$consideracionesIngreso.keyup(function(){
  if(!($consideracionesIngreso.val() === null | $consideracionesIngreso.val() === ""))
    {
      $consideracionesIngreso.prop("required", true);
      $consideracionesIngreso.removeClass("is-invalid");
      $consideracionesIngreso.removeClass("is-valid");

    }else{
    $consideracionesIngreso.prop("required", true);
    validarNombres($consideracionesIngreso);
  }
});

// VALIDAR VINCULOS FAM
$vinculosFam = $("#vinculosFam");
$vinculosFam.keyup(function(){
  if(!($vinculosFam.val() === null | $vinculosFam.val() === ""))
    {
      $vinculosFam.prop("required", true);
      $vinculosFam.removeClass("is-invalid");
      $vinculosFam.removeClass("is-valid");

    }else{
    $vinculosFam.prop("required", true);
    validarNombres($vinculosFam);
  }
});

// VALIDAR CONVIVENCIAS 
$convivencias = $("#convivencias");
$convivencias.keyup(function(){
  if(!($convivencias.val() === null | $convivencias.val() === ""))
    {
      $convivencias.prop("required", true);
      $convivencias.removeClass("is-invalid");
      $convivencias.removeClass("is-valid");

    }else{
    $convivencias.prop("required", true);
    validarTexto($convivencias);
  }
});

// VALIDAR TUTELA
$tutela = $("#tutela");
$tutela.keyup(function(){
  if(!($tutela.val() === null | $tutela.val() === ""))
    {
      $tutela.prop("required", true);
      $tutela.removeClass("is-invalid");
      $tutela.removeClass("is-valid");

    }else{
    $tutela.prop("required", true);
    validarNombres($tutela);
  }
});

// VALIDAR SITUACION JURIDICA 
$situacionJuridica = $("#situacionJuridica");
$situacionJuridica.keyup(function(){
  if(!($situacionJuridica.val() === null | $situacionJuridica.val() === ""))
    {
      $situacionJuridica.prop("required", true);
      $situacionJuridica.removeClass("is-invalid");
      $situacionJuridica.removeClass("is-valid");

    }else{
    $situacionJuridica.prop("required", true);
    validarNombres($situacionJuridica);
  }
});

$idEscolaridad = $("#escolaridad");
$idEscolaridad.change(function (){
  validarSelect($idEscolaridad);
});


// validar grado escolar
$gradoEscolar = $("#gradoEscolar");
$gradoEscolar.keyup(function(){
  if(!($gradoEscolar.val() === null | $gradoEscolar.val() === ""))
    {
      $gradoEscolar.prop("required", true);
      $gradoEscolar.removeClass("is-invalid");
      $gradoEscolar.removeClass("is-valid");

    }else{
    $gradoEscolar.prop("required", true);
    validarNombres($gradoEscolar);
  }
}); 

/**************************************
  NAVEGABILIDAD EN EL FORM
**************************************/

function modDatosPersonal(id){

  let valido = true;

  //Si no pasa alguna validación obligatoria dejar de ejecutar la función
  if(!validarNombres($nombreCompleto) | !validarFecha($fechaNacimiento) | !validarSelect($tipoSangre))
    return;

  if(!valido)
    return;

  //esperar a que cargue el progressbar
  setTimeout(function(){$("#"+id).submit()}, 800);
  $('#guardarPersonal').html(" <span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>Cargando...");
	$('#guardarPersonal').prop("disabled", true);
};

function modDatosIngreso(id){
  let valido = true;

  //Si no pasa alguna validación obligatoria dejar de ejecutar la función
  if(!validarFecha($fechaIngreso) | !validarSelect($idMotivoIngreso) | !validarSelect($idDiagnostico))
    return;

  if(!($diagnosticoMotriz.val() === null | $diagnosticoMotriz.val() === ""))
  {
    $diagnosticoMotriz.prop("required", true);

    if(!validarNombres($diagnosticoMotriz))
      return;
  }

  if(!($edadMental.val() === null | $edadMental.val() === ""))
  {
    $edadMental.prop("required", true);

    if(!validarNumeros($edadMental))
      return;
  }

  if(!($nombreCanaliza.val() === null | $nombreCanaliza.val() === ""))
  {
    $nombreCanaliza.prop("required", true);

    if(!validarNombres($nombreCanaliza))
      return;
  }

  if(!($consideracionesIngreso.val() === null | $consideracionesIngreso.val() === ""))
  {
    $consideracionesIngreso.prop("required", true);

    if(!validarNombres($consideracionesIngreso))
      return;
  }

  if(!valido)
    return;

  //esperar a que cargue el progressbar
  setTimeout(function(){$("#"+id).submit()}, 800);
  $('#subir').html(" <span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>Cargando...");
	$('#subir').prop("disabled", true);

}

function modDatosFamiliares(id){
  let valido = true;

  if(!($antecedentes.val() === null | $antecedentes.val() === ""))
  {
    $antecedentes.prop("required", true);

    if(!validarTexto($antecedentes))
    return;

  }

  if(!($vinculosFam.val() === null | $vinculosFam.val() === ""))
  {
    $vinculosFam.prop("required", true);

    if(!validarNombres($vinculosFam))
      return;
  }

  if(!($convivencias.val() === null | $convivencias.val() === ""))
  {
    $convivencias.prop("required", true);

    if(!validarTexto($convivencias))
      return;
  }

  if(!($tutela.val() === null | $tutela.val() === ""))
  {
    $tutela.prop("required", true);

    if(!validarNombres($tutela))
      return;
  }  

  if(!($situacionJuridica.val() === null | $situacionJuridica.val() === ""))
  {
    $situacionJuridica.prop("required", true);

    if(!validarNombres($situacionJuridica))
      return;
  }

  if(!valido)
    return;

    setTimeout(function(){$("#"+id).submit()}, 800);
  $('#subir').html(" <span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>Cargando...");
	$('#subir').prop("disabled", true);
}

function modDatosAcad(id){

  let valido = true;

  //Si no pasa alguna validación obligatoria dejar de ejecutar la función
  if(!validarSelect($idEscolaridad))
    return;

  if(!($gradoEscolar.val() === null | $gradoEscolar.val() === ""))
  {
    $gradoEscolar.prop("required", true);

    if(!validarNombres($gradoEscolar))
      return;
  }
  
  if(!valido)
    return;

    setTimeout(function(){$("#"+id).submit()}, 800);
    $('#subir').html(" <span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>Cargando...");
	$('#subir').prop("disabled", true);
}

function modArchivos(id){
  
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
  validarFechaIng($(this).val());
});


