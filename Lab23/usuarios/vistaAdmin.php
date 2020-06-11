<?php
	require_once("../model.php");
	session_start();
	 if( $_SESSION["entro"]){
	 	if($_SESSION["empleado"]=="empleado preferente" || $_SESSION["empleado"]=="empleado general"){
	 		 include("../Error404.html");
	 		 exit;
	 	}

	 }else{
	 	echo "<script>
              alert('Debe iniciar sesión para poder acceder');
              window.location.href='../index.php';
              </script>";
	 	}


//------------------------------------------------------------------------------------------------------
// CORREOS

// require '../vendor/autoload.php';
//
// $email = new \SendGrid\Mail\Mail();
// $email->setFrom("gestioncmg@hogaresfaustinollamas.org", "CMG");
// $email->setSubject("Esta es la segunda prueba");
// $email->addTo("a01704889@itesm.mx", "EXAMPLE recipient");
// $email->addContent("text/plain", "and easy to do anywhere, even with PHP");
// $email->addContent(
// 		"text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
// );
// $sendgrid = new \SendGrid('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');
// try {
// 		$response = $sendgrid->send($email);
// 		print $response->statusCode() . "\n";
// 		print_r($response->headers());
// 		print $response->body() . "\n";
// } catch (Exception $e) {
// 		echo 'Caught exception: '. $e->getMessage() ."\n";
// }

//------------------------------------------------------------------------------------------------------


	/*
		verificar que la sesión sea activa. (el timeout está en segundos)
	*/
	$time = $_SERVER['REQUEST_TIME'];
	$timeout_duration = 1800;
	if (isset($_SESSION['LAST_ACTIVITY']) &&
	($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
		echo "<script>
		alert('Tu sesión ha expirado. Por favor vuelve a iniciar sesión.');
		window.location.href='../controladores/cerrarSesion.php';
		</script>";
		//header("location:../controladores/cerrarSesion.php");
	}
	$_SESSION['LAST_ACTIVITY'] = $time;


	$_SESSION["usuario"] = "Administradora";
	$_SESSION["enPrueba"] = 0;

	$titulo = "Casa María Goretti";

	//poner los botones del sidebar como [nombreBtn, path]
	$botones = [
		["Empleados", "../empleados/consultarEmpleado.php"],
		["Beneficiarias", "../beneficiarias/consultarBeneficiarias.php"],
		["Donantes", "../donantes/consultarDonantes.php"],
		["Reportes", "../reportes/generarReporte.php"]
	];

	//poner los paths de los estilos que va a tener la página
	$estilos = [
		"../css/styles.css",
		"../css/map.css",
		'https://use.fontawesome.com/releases/v5.0.6/css/all.css',
		'../node_modules/@fullcalendar/core/main.css',
		'../node_modules/@fullcalendar/daygrid/main.css',
		'../node_modules/@fullcalendar/bootstrap/main.css',
		"../css/calendario.css",
		"../css/consultar.css",
		"../css/tablaConScroll.css"
	];

	$scripts = [
		'../node_modules/@fullcalendar/core/main.js',
		'../node_modules/@fullcalendar/core/locales/es.js',
		'../node_modules/@fullcalendar/daygrid/main.js',
		'../node_modules/@fullcalendar/bootstrap/main.js',
		'../node_modules/@fullcalendar/interaction/main.js',
		'../node_modules/@fullcalendar/google-calendar/main.js',
		"../js/calendarioGeneral.js",
		"../js/mensajes.js",
		"../Medicos/medicos.js"
	];

	include("../partials/_header.html");
	include("../partials/_mensajes.html");

	include("principalAdministrador.html");


	include("../partials/_footer.html");

?>
