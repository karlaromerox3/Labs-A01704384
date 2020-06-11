<?php
session_start();
	/*
		verificar que la sesión sea activa. (el timeout está en segundos)
	*/
	$time = $_SERVER['REQUEST_TIME'];
	$timeout_duration = 30;
	if (isset($_SESSION['LAST_ACTIVITY']) && 
	($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
		echo "<script>
		alert('Tu sesión ha expirado. Por favor vuelve a iniciar sesión.');
		window.location.href='../controladores/cerrarSesion.php';
		</script>";
	}
	$_SESSION['LAST_ACTIVITY'] = $time;		
require_once("../model.php");

    // 	PARAMETROS PARA CONSULTAR BENEFICIARIAS ACTIVAS DESDE GENERAL
	if(isset($_POST["beneficiarias"]))
		$idBeneficiaria = htmlspecialchars($_POST["beneficiarias"]);
	else
		$idBeneficiaria = "";

	echo consultarBeneficiariasGeneral($idBeneficiaria);

?>