<?php
	session_start();
	require_once("../model.php");

	 if( $_SESSION["entro"]){
	 	if($_SESSION["empleado"]=="administrador"){
	 		 include("../Error404.html");
	 		 exit;
	 	}


	 }else{
	 	echo "<script>
              alert('Debe iniciar sesión para poder acceder');
              window.location.href='../index.php';
              </script>";
	 	}

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
	}
	$_SESSION['LAST_ACTIVITY'] = $time;

	$_SESSION["usuario"] = "Empleado General";
	$titulo = "Casa María Goretti";
	$_SESSION["enPrueba"] = 0;

	//poner los botones del sidebar como [nombreBtn, path]
	$botones = [
			["Beneficiarias", "../beneficiarias/consultarBeneficiarias.php?status=activas"],

		["Reportes", "../reportes/generarReporte.php"]

	];

	//poner los paths de los estilos que va a tener la página
	$estilos = [
		"../css/styles.css",
		"../css/map.css",
		"../css/consultar.css",
		'https://use.fontawesome.com/releases/v5.0.6/css/all.css',
		'../node_modules/@fullcalendar/core/main.css',
		'../node_modules/@fullcalendar/daygrid/main.css',
		'../node_modules/@fullcalendar/bootstrap/main.css',
		"../css/calendario.css",
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
		"../beneficiarias/ajaxBeneficiarias.js",
		"../Medicos/medicos.js"
	];

	include("../partials/_header.html");

	include("principalEmpleado.html");


	include("../partials/_footer.html")

?>
