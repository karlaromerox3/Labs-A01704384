$(function() {

  // Get the form fields and hidden div
  var checkbox = $("#infona");
  var hidden = $("#hidden_fields");

  // Hide the fields.
  // Use JS to do this in case the user doesn't have JS
  // enabled.
  hidden.hide();

  // Setup an event listener for when the state of the
  // checkbox changes.
  checkbox.change(function() {
    // Check to see if the checkbox is checked.
    // If it is, show the fields and populate the input.
    // If not, hide the fields.
    if (checkbox.is(':checked')) {
      // Show the hidden fields.
      $("#infonavit").prop("required", true);
      hidden.show();

    } else {
      // Make sure that the hidden fields are indeed
      // hidden.
      hidden.hide();
      $("#infonavit").prop("required", false);
      // You may also want to clear the value of the
      // hidden fields here. Just in case somebody
      // shows the fields, enters data to them and then
      // unticks the checkbox.
      //
      // This would do the job:
      //
       $("#infonavit").val("");
    }
  });
});

$( document ).ready(function() {
  var checkbox = $("#infona");
  var hidden = $("#hidden_fields");
    console.log( "ready!" );
    if (checkbox.is(':checked')) {
      // Show the hidden fields.
      $("#infonavit").prop("required", true);
      hidden.show();

    } else {
      // Make sure that the hidden fields are indeed
      // hidden.
      hidden.hide();
      $("#infonavit").prop("required", false);
      // You may also want to clear the value of the
      // hidden fields here. Just in case somebody
      // shows the fields, enters data to them and then
      // unticks the checkbox.
      //
      // This would do the job:
      //
       $("#infonavit").val("");
    }
});


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

$infonavit = $("#infonavit");
$infonavit.keyup(function(){
  if($infonavit.val() === null | $infonavit.val() === "")
  {
    $infonavit.prop("required", false);
    $infonavit.removeClass("is-invalid");
    $infonavit.removeClass("is-valid");
  }
  else
  {
    $infonavit.prop("required", true);
    validarNumeros($infonavit);
  }
});

function submit(id){
    let valido = true;
     console.log("Hello Friend");

    //si el campo NSS no está vacio verificarlo.
    if(!($infonavit.val() === null | $infonavit.val() === "")){
        $infonavit.prop("required", true);

        if(!validarNumeros($infonavit))
            valido = false;
    }
    console.log("Hello Friend");


    if(valido==false)
        return;
    else{
      //esperar a que cargue el progressbar
    setTimeout(function(){$("#"+id).submit()}, 800);
    $('#subir').html(" <span class='spinner-horder spinner-border-sm' role='status' aria-hidden='true'></span>Cargando...");
    $('#subir').prop("disabled", true);
    }



}






