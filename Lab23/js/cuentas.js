function validatePswd(){
	
	let password = document.getElementById("password");
	let confirmation = document.getElementById("confirmation");
	let estado=1;

	let letter = document.getElementById("letter");
	let capital = document.getElementById("capital");
	let number = document.getElementById("number");
	let length = document.getElementById("length");


	let message = document.getElementById("confirmationMsg");

	let safe = "#66cc66";
	let notSafe = "#ff6666";

	if (password.value == confirmation.value) {

		confirmationMsg.innerHTML = "&#10004; Las contraseñas coinciden";
		//$_SESSION["cuenta"]="puede";
	} else {

		confirmationMsg.innerHTML = "&#9888; Las contraseñas no coinciden";

		estado=0;
				//$_SESSION["cuenta"]="nopuede";

	}

	let lowercase = /[a-z]/g;
	if (password.value.match(lowercase)) {
		letter.classList.remove("invalid");
		letter.classList.add("valid");
	} else {
		letter.classList.remove("valid");
		letter.classList.add("invalid");
	}

	let numbers = /[0-9]/g;
	if (password.value.match(numbers)) {
		number.classList.remove("invalid");
		number.classList.add("valid");
	} else {
		number.classList.remove("valid");
		number.classList.add("invalid");
	}

	let uppercase= /[A-Z]/g;
	if (password.value.match(uppercase)) {
		capital.classList.remove("invalid");
		capital.classList.add("valid");
	} else {
		capital.classList.remove("valid");
		capital.classList.add("invalid");
	}

	if (password.value.length>=8) {
		length.classList.remove("invalid");
		length.classList.add("valid");
	} else {
		length.classList.remove("valid");
		length.classList.add("invalid");
	}
}

function showRestrictions(){
		document.getElementById("restrictions").style.display = "block";
	}

function hideRestrcitions(){
		document.getElementById("restrictions").style.display = "none";
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

function validarUsuario($nombre)
		{
	if($nombre.prop("validity").valid & hasNumber($nombre.val()) & !isNullOrWhitespace($nombre.val()))
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
  if($id.val() != null && $id.prop("validity").valid)
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

$usuario = $("#usuario");
$usuario.keyup(function (){
  validarUsuario($usuario);
});

$nombre2= $("#nombre");
$nombre2.keyup(function(){
	validarNombres($nombre2);
});

$rol2=$("#rol");
$rol2.change(function (){
	validarSelect($rol2);
});

//DESPLEGAR IMAGEN DE PERFIL DEL USUARIO
function triggerClick(e) {
  document.querySelector('#profileImage').click();
}
function displayImage(e) {
  if (e.files[0]) {
    let reader = new FileReader();
    reader.onload = function(e){
      document.querySelector('#profileDisplay').setAttribute('src', e.target.result);
    }
    reader.readAsDataURL(e.files[0]);
  }
}