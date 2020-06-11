function hasNumber(myString) {
  return /\d/.test(myString);
}

function isDate(date)
{
    return /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/.test(date);
}
function isNullOrWhitespace( input ) {
    return !input || !input.trim();
}

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

$motivo = $("#motivo");
$motivo.keyup(function(){
  //si el campo no está vacio verificarlo.
  if($motivo.val() === null | $motivo.val() === "")
  {
    $motivo.prop("required", false);
    $motivo.removeClass("is-invalid");
    $motivo.removeClass("is-valid");

  }
  else
  {
    $motivo.prop("required", true);
    validarNombres($motivo);
  }
});

$fecha = $("#fecha");
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


function submitForm(id){
    let valido = true;

    if(!validarNombres($motivo)  | !validarFecha($fecha) )
        valido = false;
    //Si no pasa alguna validación obligatoria dejar de ejecutar la función

    if(!valido)
        return;

    setTimeout(function(){$("#"+id).submit()}, 800);
    $('#subir').html(" <span class='spinner-horder spinner-border-sm' role='status' aria-hidden='true'></span>Cargando...");
      $('#subir').prop("disabled", true);

}



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
  validarFechaNac($(this).val());
});
