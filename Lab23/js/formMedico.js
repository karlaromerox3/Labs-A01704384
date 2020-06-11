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

$nombre = $("#nombres");
$nombre.keyup(function (){
	validarNombres($nombre);
});

$apellido = $("#apellidos");
$apellido.keyup(function (){
	validarNombres($apellido);
});

$id = $("#especialidad");
$id.change(function (){
	validarSelect($id);
});

$direccion = $("#direccion");
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

$telefono = $("#tel");
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
});
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

$celular = $("#cel");
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
});

$correo = $("#email");
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

$hospital = $("#hospital");
$hospital.keyup(function(){
	//si el campo no está vacio verificarlo.
	if($hospital.val() === null | $hospital.val() === "")
	{	
		$hospital.prop("required", false);
		$hospital.removeClass("is-invalid");
		$hospital.removeClass("is-valid");
		
	}
	else
	{
		$hospital.prop("required", true);
		validarTexto($hospital);
	}
});

$consultorio = $("#consultorio");
$consultorio.keyup(function(){
	//si el campo no está vacio verificarlo.
	if($consultorio.val() === null | $consultorio.val() === "")
	{	
		$consultorio.prop("required", false);
		$consultorio.removeClass("is-invalid");
		$consultorio.removeClass("is-valid");
		
	}
	else
	{
		$consultorio.prop("required", true);
		validarTexto($consultorio);
	}
});


function submitForm(id)
{
	let valido = true;

	//Si no pasa alguna validación obligatoria dejar de ejecutar la función
	if(!validarSelect($id) | !validarNombres($nombre))
		valido = false;

	//si el campo apellido no está vacio verificarlo.
	if(!($apellido.val() === null | $apellido.val() === ""))
	{
		$apellido.prop("required", true);
		
		if(!validarNombres($apellido))
			valido = false;
	}

	//si el campo direccion no está vacio verificarlo.
	if(!($direccion.val() === null | $direccion.val() === ""))
	{
		$direccion.prop("required", true);
		
		if(!validarTexto($direccion))
			valido = false;
	}

	//si el campo hospital no está vacio verificarlo.
	if(!($hospital.val() === null | $hospital.val() === ""))
	{
		$hospital.prop("required", true);
		
		if(!validarTexto($hospital))
			valido = false;
	}

	//si el campo consultorio no está vacio verificarlo.
	if(!($consultorio.val() === null | $consultorio.val() === ""))
	{
		$consultorio.prop("required", true);
		
		if(!validarTexto($consultorio))
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

	//si el campo correo no está vacio verificarlo.
	if(!($correo.val() === null | $correo.val() === ""))
	{
		$correo.prop("required", true);
		
		if(!validarCorreo($correo))
			valido = false;
	}

	if(!valido)
		return;

	//esperar a que cargue el progressbar
	setTimeout(function(){$("#"+id).submit()}, 800);
	$('#subir').html(" <span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>Cargando...");
	$('#subir').prop("disabled", true);
}


