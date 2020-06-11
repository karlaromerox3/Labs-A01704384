<?php
		require_once("../model.php");
		session_start();
if(!($_SESSION["entro"])){

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

		$titulo = "Cuenta Personal";
		$registrando = 1;

		//poner los botones del sidebar como [nombreBtn, path]
		if($_SESSION["usuario"] === "Administradora")
		{
			$botones = [
				["Empleados", "#modalEmpleados",1],
				["Beneficiarias", "#modalBeneficiarias",1],
				["Donantes", "#modalDonantes",1],
				["Reportes", "#modalReportes",1]

			];
		}
		else
		{
			$botones = [
				["Beneficiarias", "#modalBeneficiarias",1]
			];
		}
		//poner los paths de los estilos que va a tener la página
		$estilos = [
			"../css/styles.css",
			"../css/prueba.css",
			"../css/styles1.css"

		];

		$scripts = [
			"../js/modificarCuenta.js",
			"../js/cuentas.js"



		];
		include("../partials/_header.html");
		include("../partials/_mensajes.html");

			//echo $_SESSION["este"];


		include("modificarCuentaPersonal.html");



			$location="Inicio";
			$href="../usuarios/vistaAdmin.php";
			$idModal="modalSalir";
			include("../partials/_modal_preguntar_salir.html");

			$location="Empleados";
			$href="../empleados/consultarEmpleado.php";
			$idModal="modalEmpleados";
			include("../partials/_modal_preguntar_salir.html");

			$location="Beneficiarias";
			$href="../beneficiarias/consultarBeneficiarias.php?status=activas";
			$idModal="modalBeneficiarias";
			include("../partials/_modal_preguntar_salir.html");

			$location="Donantes";
			$href="../donantes/consultarDonantes.php";
			$idModal="modalDonantes";
			include("../partials/_modal_preguntar_salir.html");

			$location="Reportes";
			$href="../reportes/generarReporte.php";
			$idModal="modalReportes";
			include("../partials/_modal_preguntar_salir.html");


						$location="Cuentas";
						$href="consultarCuentas.php";
						$idModal="modalCuentas";
						include("../partials/_modal_preguntar_salir.html");

						$location="Configuración de Usuarios";
						$href="../usuarios/consultarCuentas.php";
						$idModal="modalUsuarios";
						include("../partials/_modal_preguntar_salir.html");

						$location="Cuenta Personal";
						$href="../usuarios/modificarCuentaPersonal.php";
						$idModal="cuentaPersonal";
						include("../partials/_modal_preguntar_salir.html");

						$location="Cerrar sesión";
						$href="../controladores/cerrarSesion.php";
						$idModal="cerrarSesion";
						include("../partials/_modal_preguntar_salir.html");




		include("../partials/_footer.html")

?>
