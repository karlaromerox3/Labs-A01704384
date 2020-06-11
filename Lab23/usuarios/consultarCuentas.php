<?php
		session_start();
		require_once("../model.php");

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

		$titulo = "Cuentas Empleados";


		/*if(!isset($_SESSION["nombre"]))  {
		$titulo = "Favor de Iniciar Sesión";
		header("location:../controladores/controlador_cerrarSesion.php");
	} else {
		*/
		
		//poner los botones del sidebar como [nombreBtn, path]
		$botones = [
			["Empleados", "../empleados/consultarEmpleado.php"],
			["Beneficiarias", "../beneficiarias/consultarBeneficiarias.php?status=activas"],
			["Donantes", "../donantes/consultarDonantes.php"],
			["Reportes", "../reportes/generarReporte.php"]
		];
	
		//poner los paths de los estilos que va a tener la página
		$estilos = [
			"../css/styles.css",
			"../css/tablaConScroll.css",
			"https://use.fontawesome.com/releases/v5.7.0/css/all.css"
		];

		$scripts = [
			"../js/mensajes.js",
			"../js/ajaxBuscarU.js"
					];

		include("../partials/_header.html");
		
		include("../partials/_mensajes.html");
		include("consultarCuentas.html");
		
	
		
		include("../partials/_footer.html");
	

?>