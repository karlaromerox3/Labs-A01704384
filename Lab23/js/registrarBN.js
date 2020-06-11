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

/*
    OBTENER DATOS
*/




$nombreBN = $("#nombreBN");
$nombreBN.keyup(function(){
    //si el campo no está vacio verificarlo.
    if($nombreBN.val() === null | $nombreBN.val() === "")
    {
        $nombreBN.prop("required", false);
        $nombreBN.removeClass("is-invalid");
        $nombreBN.removeClass("is-valid");

    }
    else
    {
        $nombreBN.prop("required", true);
        validarNombres($nombreBN);
    }
});

$parentesco = $("#parentesco");
$parentesco.keyup(function(){
    //si el campo no está vacio verificarlo.
    if($parentesco.val() === null | $parentesco.val() === "")
    {
        $parentesco.prop("required", false);
        $parentesco.removeClass("is-invalid");
        $parentesco.removeClass("is-valid");

    }
    else
    {
        $parentesco.prop("required", true);
        validarNombres($parentesco);
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









function submitForm(id){
    let valido = true;

    //Si no pasa alguna validación obligatoria dejar de ejecutar la función
    if(!validarNombres($nombreBN) | !validarNombres($parentesco))
        valido = false;
    //si el campo rfc no está vacio verificarlo.
    if(!($rfc.val() === null | $rfc.val() === ""))
    {
        $rfc.prop("required", true);

        if(!validarRFC($rfc))
            valido = false;
    }

    if (id === "registrarBN"){
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


        if(!validarNombres($calle)  | !validarNombres($colonia) | !validarNumeros($cp))
            valido = false;


    }


    if(!valido)
        return;
        //document.getElementById("datosNomina").style.display = "none";
        document.getElementById("progressBar").style.width = "100%";
        //esperar a que cargue el progressbar
        setTimeout(function(){$("#"+id).submit()}, 800);
        $('#subir').html(" <span class='spinner-horder spinner-border-sm' role='status' aria-hidden='true'></span>Cargando...");
        $('#subir').prop("disabled", true);

}


