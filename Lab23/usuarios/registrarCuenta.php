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


		$titulo = "Registrar Cuenta";
		$registrando = 1;
		$_SESSION["enPrueba"] = 0;

		$titulo = "Cuentas Empleados";


		//poner los botones del sidebar como [nombreBtn, path]
		$botones = [
			["Cuentas", "#modalCuentas",1]
		];

		//poner los paths de los estilos que va a tener la página
		$estilos = [

			"../css/styles.css",
			"../css/prueba.css",
			"../css/registrarDonante.css",
			"../css/styles1.css"

		];

		$scripts=[
			 "../js/cuentas.js",
			 "../js/donantes.js"

		];

		include("../partials/_header.html");
		include("../partials/_mensajes.html");


		include("registrarCuenta.html");


			$location="Inicio";
			$href="../usuarios/vistaAdmin.php";
			$idModal="modalSalir";
			include("../partials/_modal_preguntar_salir.html");

			$location="Cuentas";
			$href="consultarCuentas.php";
			$idModal="modalCuentas";
			include("../partials/_modal_preguntar_salir.html");

			$location="Cuenta Personal";
			$href="../usuarios/modificarCuentaPersonal.php";
			$idModal="cuentaPersonal";
			include("../partials/_modal_preguntar_salir.html");

			$location="Cerrar sesión";
			$href="../controladores/cerrarSesion.php";
			$idModal="cerrarSesion";
			include("../partials/_modal_preguntar_salir.html");

			$location="Configuración de Usuarios";
			$href="../usuarios/consultarCuentas.php";
			$idModal="modalUsuarios";
			include("../partials/_modal_preguntar_salir.html");


		include("../partials/_footer.html")

?>
