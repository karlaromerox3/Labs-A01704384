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

$motivo = $("#motivoEgreso");
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

$fechaEgreso = $("#fechaEgreso");
function validarFechaNac(){
  //si el campo no está vacio verificarlo.
  if($fechaEgreso.val() === null | $fechaEgreso.val() === "")
  {
    $fechaEgreso.prop("required", false);
    $fechaEgreso.removeClass("is-invalid");
    $fechaEgreso.removeClass("is-valid");

  }
  else
  {
    $fechaEgreso.prop("required", true);
    validarFecha($fechaEgreso);
  }
}
$fechaEgreso.keyup(validarFechaNac);


function submitForm(id){
    let valido = true;

    if(!validarNombres($motivo)  | !validarFecha($fechaEgreso) )
        valido = false;
    //Si no pasa alguna validación obligatoria dejar de ejecutar la función

    if(valido == false)
        return;
    else{
      setTimeout(function(){$("#"+id).submit()}, 800);
      $('#subir').html(" <span class='spinner-horder spinner-border-sm' role='status' aria-hidden='true'></span>Cargando...");
        $('#subir').prop("disabled", true);
    }


}




