<?php
//
//------------------------------------------------------------
 //        --- FUNCIONES GENERALES---
//-------------------------------------------------------------

	//conectarse a la bd
	function conectar_bd()
	{
		//conexion para servidor
		$conexion_bd = mysqli_connect("hogaresfaustinollamas.org", "hogaresf_gestioncmg", "S&st3m&-d@w", "hogaresf_gestioncmg");
		//$conexion_bd = mysqli_connect("localhost", "root", "", "CMG");

		if($conexion_bd == NULL)
			die("La base de datos CMG está en mantenimiento, vuelve a intentarlo más tarde...");


		$conexion_bd->set_charset("utf8");

		return $conexion_bd;
	}

	//desconectarse de la bd
	function desconectar_bd($conexion_bd)
	{
		mysqli_close($conexion_bd);
	}

	//función para crear los botones del sidebar de manera dinámica dependiendo de la página en la que esté el usuario.
	//$btn[0] es el nombre del botón y $btn[1] el path a donde lleva el botón
	function botones_sidebar($botones)
	{
		foreach($botones as $btn)
		{
			if(isset($btn[2]))
				echo "<a data-target=".$btn[1]." data-toggle='modal' href='".$btn[1]."' class='list-group-item list-group-item-action'>".$btn[0]."</a>";
			else
				echo "<a href='".$btn[1]."' class='list-group-item list-group-item-action'>".$btn[0]."</a>";
		}
	}

	//función para poner estilos dependiendo del path del css pasado
	function agregar_estilos($estilos)
	{
		foreach($estilos as $style)
		{
			echo "<link href='".$style."' rel='stylesheet'>";
		}
	}

	//función para poner scripts dependiendo del path del js pasado
	function agregar_js($scripts)
	{
		foreach($scripts as $js)
		{
			echo "<script type='text/javascript' src='".$js."'></script>";
		}
	}

	//Consultar un campo de una tabla a partir de su llave
	 //$llave es el valor de la llave del registro que se quiere recuperar
	 //$tabla es el nombre de la tabla pasado como string
	 //$nombreLlave es el nombre de la llave de la tabla (como aparece en la bd) pasado como string
	 //$campo es el nombre del campo que se quiere recuperar (como aparece en la bd) pasado como string
	 function recuperar($llave, $tabla, $nombreLlave, $campo) {

		$conexion_bd = conectar_bd();


		$consulta = "SELECT $campo FROM $tabla WHERE $nombreLlave ='$llave'";
		$resultados = $conexion_bd->query($consulta);
		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
			desconectar_bd($conexion_bd);
			return $row["$campo"];
		}

		desconectar_bd($conexion_bd);
		return 0;
	  }

	//funcion para regresar el url de un string
	function urlify($string){
		$string = strtr($string,'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ', 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
		$string = str_replace(" ", "%20", $string);
		$string = str_replace(",", "%2C", $string);
		$string = str_replace("#", "%23", $string);
		return $string;
	 }

	//crear select dinámico
	function crear_select($llave, $descripcion, $tabla, $required, $seleccion = 0, $label = "", $busqueda = false)
	{

		$conexion_bd = conectar_bd();

		//poner el label recibido como parametro o por default el nombre de la tabla
		if($label === "")
			$resultado = "<label  for='".$tabla."'>".$tabla."</label>";
		else
			$resultado = "<label  for='".$tabla."'>".$label."</label>";

		$resultado .= "<div class='form-group'><select class='form-control mx-auto' id='".$tabla."' name='".$tabla."' ";
		if($required)
		{
			$resultado .= "required";
		}
		$resultado .= "><option value='' ";
		//si el select es para una busqueda no lleva el disabled para poder buscar sin filtro
		if(!$busqueda)
			$resultado .= "disabled";
		$resultado .= " selected>";
		if($busqueda)
			$resultado .=" Sin filtro";
		else
			$resultado .= "Selecciona una opción";

		$resultado .="</option>";

		$consulta = "SELECT $llave, $descripcion FROM $tabla";
		$resultados = $conexion_bd->query($consulta);
		while($row = mysqli_fetch_array($resultados, MYSQLI_BOTH))
		{
			$resultado .= "<option value='".$row["$llave"]."' ";
			if($seleccion === $row["$llave"])
			{
				$resultado .= "selected";
			}
			$resultado .= ">".$row["$descripcion"]."</option>";
		}

		desconectar_bd($conexion_bd);
		$resultado .= "</select><div class='invalid-feedback'>Escoge una opción válida</div></div>";
		return $resultado;
	}


	 //funcion para calcular la edad
    function calculaEdad($fNacimiento){
        $nacimiento = new DateTime($fNacimiento);
        $hoy   = new DateTime('today');
        return $nacimiento->diff($hoy)->y;
	}

	//obtener todas los registros de un campo de una tabla
    function obtener_registros($tabla, $campo, $idStatus = "", $id = false)
    {
        $conexion_bd = conectar_bd();
        $array = "";
		$consulta = 'SELECT '.$campo.' FROM '.$tabla;
		if($idStatus != "")
			$consulta .= ' WHERE idStatus='.$idStatus;
        if($id){
            $consulta .= ' ORDER BY '.$campo;
        }
        $resultados = $conexion_bd->query($consulta);
        while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)){
            $array .= $row["$campo"].",";
        }
        mysqli_free_result($resultados);
        desconectar_bd($conexion_bd);
        $array = explode(",", $array);
        return $array;
	}


	//AGREGAR OPCION A DROPDOWN
	function registrarOpcion($tabla, $campo, $opcion){
		$conexion_bd = conectar_bd();

	  $agregar = "INSERT INTO $tabla($campo) VALUES(?)";

	  if ( !($statement = $conexion_bd->prepare($agregar))) {
		die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
		return 0;
	  }

	  //Unir parámetros de consulta
	  if (!$statement->bind_param("s", $opcion)) {
		die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
		return 0;
	  }

	  //Ejecutar consulta
	  if (!$statement->execute()) {
		die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
		return 0;
	  }

	  desconectar_bd($conexion_bd);
	  return 1;
	}


//------------------------------------------------------------
 //        --- FUNCIONES PARA MEDICOS---
//-------------------------------------------------------------
	//agregar un médico a la bd
	function agregar_medico($especialidad, $nombre, $apellido, $direccion, $telefono, $celular, $correo, $hospital, $consultorio, $extension)
	{
		$conexion_bd = conectar_bd();

		//preparar consulta
		$dml_insertar = 'INSERT INTO medico (idEspecialidad, nombre, apellido, direccion, telefono, celular, correo, hospital, consultorio, extension) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		if(!($statement = $conexion_bd->prepare($dml_insertar)))
		{
			die("Error: (".$conexion_bd->errno.") ".$conexion_bd->error);
			return 0;
		}


		//unir parámetros de la función con la consulta
		//el primer arg es el formato de cada parámetro
		if(!$statement->bind_param("isssssssss", $especialidad, $nombre, $apellido, $direccion, $telefono, $celular, $correo, $hospital, $consultorio, $extension))
		{
			die("Error en vinculación: (".$statement->errno.") ".$statement->error);
			return 0;
		}

		//Ejecutar inserción
		if(!$statement->execute())
		{
			die("Error en ejecución: (".$statement->errno.") ".$statement->error);
			return 0;
		}

		desconectar_bd($conexion_bd);
		return 1;
	}

	//modificar a un medico
	function modificar_medico($idMedico, $especialidad, $nombre, $apellido, $direccion, $telefono, $celular, $correo, $hospital, $consultorio, $extension)
	{
		$conexion_bd = conectar_bd();

		//Prepara la consulta
		$dml_editar = 'UPDATE medico SET idEspecialidad=(?), nombre=(?), apellido=(?), direccion=(?), telefono=(?), celular=(?), correo=(?), hospital=(?), consultorio=(?), extension =(?) WHERE idMedico=(?)';
		if ( !($statement = $conexion_bd->prepare($dml_editar)) ) {
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
		}

		//Unir los parámetros de la función con los parámetros de la consulta
		//El primer argumento de bind_param es el formato de cada parámetro
		if (!$statement->bind_param("isssssssssi", $especialidad, $nombre, $apellido, $direccion, $telefono, $celular, $correo, $hospital, $consultorio, $extension, $idMedico)) {
			die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		//Executar la consulta
		if (!$statement->execute()) {
		  die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		desconectar_bd($conexion_bd);
		  return 1;
	}

	//Eliminar a un médico
	function eliminar_medico($idMedico, $idEspecialidad)
	{
		$conexion_bd = conectar_bd();

		//Prepara la consulta
		$dml_eliminar = 'DELETE FROM medico WHERE idMedico=(?) AND idEspecialidad=(?)';
		if ( !($statement = $conexion_bd->prepare($dml_eliminar)) ) {
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
		}

		//Unir los parámetros de la función con los parámetros de la consulta
		//El primer argumento de bind_param es el formato de cada parámetro
		if (!$statement->bind_param("ii", $idMedico, $idEspecialidad)) {
			die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		//Executar la consulta
		if (!$statement->execute()) {
		  die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		desconectar_bd($conexion_bd);
		return 1;
	}


		function consultarMedicos($idEspecialidad=""){
		$conexion_bd = conectar_bd();

		$resultado = "<table class='table table-hover table-striped table-responsive-md btn-table'><thead><tr><th>Nombre</th><th>Especialidad</th><th colspan='3'>Acciones</th></tr></thead><tbody>";

		$consulta = 'SELECT M.idMedico as idMedico, E.nombre as especialidad, M.nombre as nombre, M.apellido as apellido, M.direccion as dir, M.telefono as tel, M.celular as cel, M.correo as correo, M.hospital as hospital, M.consultorio as consultorio, M.extension ';
		$consulta .= ' FROM medico as M, especialidad as E ';
		$consulta .= ' WHERE M.idEspecialidad = E.idEspecialidad ';

		if($idEspecialidad != "")
			$consulta .= ' AND M.idEspecialidad = '.$idEspecialidad;

		$resultados = $conexion_bd->query($consulta);

		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH))
		{
			$resultado .= "<br><tr>";

			$resultado .= "<td>".$row['nombre']." ".$row['apellido']."</td>";
			$resultado .= "<td>".$row['especialidad']."</td>";

			//botones
			$resultado .= "<td>";
			$resultado .= "<a data-tooltip='tooltip' title='Detalles' href='#modal".$row['idMedico']."' data-placement='top' class='btn btn-outline-info' data-toggle='modal' ><i class='fas fa-search-plus'></i></a>";
			//si tiene permisos de editar y eliminar que salgan los botones
			if($_SESSION["usuario"] === "Administradora")
			{
				$resultado .= "<a data-tooltip='tooltip' title='Modificar' data-placement='top' href='../Medicos/modificarMedico.php?id=".$row["idMedico"]."' class='btn btn-outline-secondary'><i class='fas fa-pencil-alt'></i></a>";

				$resultado .= "<a data-tooltip='tooltip' title='Eliminar' data-placement='top' href='#modalEliminar".$row['idMedico']."' class='btn btn-outline-danger' data-toggle='modal'><i class='fas fa-trash-alt'></i></button>";
			}
			$resultado .= "</td>";

			$resultado .= "</tr>";
			$direccion = urlify($row['dir']);
	  		include("Medicos/modalEliminarMedico.html");
      		include("Medicos/modalMedicos.html");
		}

		mysqli_free_result($resultados);
		desconectar_bd($conexion_bd);

		$resultado .= "</tbody></table>";

		return $resultado;
	}




//------------------------------------------------------------
 //        --- FUNCIONES PARA DONANTES---
//-------------------------------------------------------------
	//crear tabla de donantes
	//crear tabla de donantes
	function consultarDonantes($idTipo="", $idDonante="", $idStatus ="", $nombre = "")
	{
		$conexion_bd = conectar_bd();

		$resultado = "<table class='table table-hover table-striped table-responsive-md btn-table'><thead><tr><th>Nombre</th><th>Tipo</th><th>Frecuencia de donaciones</th><th colspan='3'>Acciones</th></tr></thead><tbody>";

		$consulta = 'SELECT D.nombreDonante as nombre, T.nombre as tipo, D.idDonante as idDonante, F.nombre as frecuencia';
		$consulta .= ' FROM donantes as D, tipodeDonante as T, status as S, frecuenciaDonante as F';
		$consulta .= ' WHERE D.idTipo = T.idTipo AND S.idStatus = D.idStatus AND D.idFrecuencia = F.idFrecuencia';

		if($idTipo != "")
			$consulta .= ' AND D.idTipo = '.$idTipo;

		if($idDonante != "")
			$consulta .= ' AND D.idDonante = '.$idDonante;

		if($idStatus != "")
			$consulta .= ' AND D.idStatus = '.$idStatus;

		if($nombre != "")
			$consulta .= ' AND D.nombreDonante LIKE "%'.$nombre.'%" ';

		$resultados = $conexion_bd->query($consulta);
		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH))
		{
			$resultado .= "<tr>";

			$resultado .= "<td>".$row['nombre']."</td>";
			$resultado .= "<td>".$row['tipo']."</td>";

			$resultado .= "<td>".$row['frecuencia']."</td>";

			//botones
			$resultado .= "<td>";
			$resultado .= "<a title= 'Ver Más' href='verDetalleDonante.php?id=".$row['idDonante']."' class='btn btn-outline-info'><i class='fas fa-search-plus'></i></a>";
			//si tiene permisos de editar y eliminar que salgan los botones
			if($_SESSION["usuario"] === "Administradora")
			{
				$resultado .= "<a title='Modificar Datos' href='modificarDonante.php?id=".$row['idDonante'];

				if($idStatus == "2")
					$resultado .= "&egresado=1";


				$resultado .= "' class='btn btn-outline-secondary'><i class='fas fa-pencil-alt'></i></a>";

				if($idStatus == "1")
					$resultado .= "<a title='Dar de Baja' data-toggle='modal'  href='#modal".$row['idDonante']."' class='btn btn-outline-danger'><i class='fas fa-trash-alt'></i></a>";
			}
			$resultado .= "</td>";

      $resultado .= "</tr>";

      include("donantes/modalDarDeBajaDonante.html");
		}

		mysqli_free_result($resultados);
		desconectar_bd($conexion_bd);

		$resultado .= "</tbody></table>";

		return $resultado;
	}


	//agregar un donante a la bd
	function agregar_donante($idTipo, $idFrecuencia, $fechaRegistro, $contactoInterno, $nombreDonante, $correoParticular, $telefonoParticular, $extensionParticular,
							$celularParticular, $fechaNacParticular, $razonSocial, $rfc, $direccionEntidad, $cpEntidad)
	{
		$conexion_bd = conectar_bd();

		//preparar consulta
		$dml_insertar = 'INSERT INTO donantes (idTipo, idFrecuencia, fechaRegistro, contactoInterno, nombreDonante, correoParticular, telefonoParticular, extensionParticular, ';
		$dml_insertar .= 'celularParticular, fechaNacParticular, razonSocial, RFCEntidad, direccionEntidad, cpEntidad) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		if(!($statement = $conexion_bd->prepare($dml_insertar)))
		{
			die("Error: (".$conexion_bd->errno.") ".$conexion_bd->error);
			return 0;
		}


		//unir parámetros de la función con la consulta
		//el primer arg es el formato de cada parámetro
		if(!$statement->bind_param("iisssssisssssi", $idTipo, $idFrecuencia, $fechaRegistro, $contactoInterno, $nombreDonante, $correoParticular, $telefonoParticular, $extensionParticular,
		$celularParticular, $fechaNacParticular, $razonSocial, $rfc, $direccionEntidad, $cpEntidad))
		{
			die("Error en vinculación: (".$statement->errno.") ".$statement->error);
			return 0;
		}

		//Ejecutar inserción
		if(!$statement->execute())
		{
			die("Error en ejecución: (".$statement->errno.") ".$statement->error);
			return 0;
		}

		desconectar_bd($conexion_bd);
		return 1;
	}

	//modificar a un donante
	function modificar_donante($idDonante, $idTipo, $idFrecuencia, $contactoInterno, $nombreDonante, $correoParticular, $telefonoParticular, $extensionParticular,
	$celularParticular, $fechaNacParticular, $razonSocial, $RFCEntidad, $direccionEntidad, $cpEntidad, $motivoFinDonaciones)
	{
		$conexion_bd = conectar_bd();
		//Prepara la consulta
		$dml_editar = 'UPDATE donantes SET idTipo=(?), idFrecuencia=(?), contactoInterno=(?), nombreDonante=(?), correoParticular=(?), telefonoParticular=(?), extensionParticular=(?), ';
		$dml_editar .= ' celularParticular=(?), fechaNacParticular=(?), razonSocial=(?), RFCEntidad=(?), direccionEntidad=(?), cpEntidad=(?), motivoFinDonaciones=(?) ';
		$dml_editar .= ' WHERE idDonante=(?)';
		if ( !($statement = $conexion_bd->prepare($dml_editar)) ) {
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
		}

		//Unir los parámetros de la función con los parámetros de la consulta
		//El primer argumento de bind_param es el formato de cada parámetro
		if (!$statement->bind_param("iissssisssssisi", $idTipo, $idFrecuencia, $contactoInterno, $nombreDonante, $correoParticular, $telefonoParticular, $extensionParticular,
		$celularParticular, $fechaNacParticular, $razonSocial, $RFCEntidad, $direccionEntidad, $cpEntidad, $motivoFinDonaciones, $idDonante)) {
			die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		//Executar la consulta
		if (!$statement->execute()) {
		  die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		desconectar_bd($conexion_bd);
		  return 1;
  }

  //dar de baja a un donante
	function egresar_donante($fechaEgreso, $motivo, $idDonante)
	{
		$conexion_bd = conectar_bd();

		//Prepara la consulta
    $dml_editar = 'UPDATE donantes SET fechaFinDonaciones=(?), motivoFinDonaciones=(?), idStatus = 2 WHERE idDonante=(?)';

		if ( !($statement = $conexion_bd->prepare($dml_editar)) ) {
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
		}

		//Unir los parámetros de la función con los parámetros de la consulta
		//El primer argumento de bind_param es el formato de cada parámetro
		if (!$statement->bind_param("ssi", $fechaEgreso, $motivo, $idDonante)) {
			die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		//Executar la consulta
		if (!$statement->execute()) {
		  die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		desconectar_bd($conexion_bd);
		  return 1;
	}


	function verDonaciones($idDonante)
	{
		$conexion_bd = conectar_bd();

		$resultado = "<table class='table table-hover table-striped table-responsive-md btn-table'><thead><tr><th>Tipo de donación</th><th>Valor/Descripción</th><th>Fecha</th><th colspan='2'>Acciones</th></tr></thead><tbody>";

		$consulta = 'SELECT d.idDonacion as idDonacion, d.idTipoDonacion as idTipo, t.nombre as tipo, d.valor as valor, d.descripcion as descripcion, d.fecha as fecha';
		$consulta .= ' FROM donacion as d, tipoDonacion as t';
		$consulta .= ' WHERE d.idTipoDonacion = t.idTipoDonacion AND d.idDonante = '.$idDonante;

		$resultados = $conexion_bd->query($consulta);
		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH))
		{
			$resultado .= "<tr>";

			$resultado .= "<td>".$row['tipo']."</td>";

			if($row['idTipo'] == 1)
				$resultado .= "<td>$".number_format($row['valor'],2)."</td>";
			else
				$resultado .= "<td>".$row['descripcion']."</td>";

			$resultado .= "<td>".date_format(date_create($row['fecha']), "d/m/Y")."</td>";
			//botones
			$resultado .= "<td>";
			//si tiene permisos de editar y eliminar que salgan los botones
			if($_SESSION["usuario"] === "Administradora")
			{
				$resultado .= "<a title='Modificar Donación' href='modificarDonacion.php?idDonante=".$idDonante."&idDonacion=".$row['idDonacion']."' class='btn btn-outline-secondary'><i class='fas fa-pencil-alt'></i></a>";
				$resultado .= "<a title='Eliminar Donación' data-toggle='modal'  href='#modalDonacion".$row['idDonacion']."' class='btn btn-outline-danger'><i class='fas fa-trash-alt'></i></a>";
			}
			$resultado .= "</td></tr>";
			include("donantes/modalEliminarDonacion.html");
		}

		mysqli_free_result($resultados);
		desconectar_bd($conexion_bd);

		$resultado .= "</tbody></table>";


		return $resultado;
	}

	//agregar una donacion a la bd
	function agregar_donacion($idDonante, $idTipoDonacion, $valor, $descripcion, $fecha)
	{
		$conexion_bd = conectar_bd();

		//preparar consulta
		$dml_insertar = 'INSERT INTO donacion (idDonante, idTipoDonacion, valor, descripcion, fecha) VALUES (?, ?, ?, ?, ?)';
		if(!($statement = $conexion_bd->prepare($dml_insertar)))
		{
			die("Error: (".$conexion_bd->errno.") ".$conexion_bd->error);
			return 0;
		}


		//unir parámetros de la función con la consulta
		//el primer arg es el formato de cada parámetro
		if(!$statement->bind_param("iidss", $idDonante, $idTipoDonacion, $valor, $descripcion, $fecha))
		{
			die("Error en vinculación: (".$statement->errno.") ".$statement->error);
			return 0;
		}

		//Ejecutar inserción
		if(!$statement->execute())
		{
			die("Error en ejecución: (".$statement->errno.") ".$statement->error);
			return 0;
		}

		desconectar_bd($conexion_bd);
		return 1;
	}

	//modificar a un donante
	function modificar_donacion($idDonacion, $idTipoDonacion, $fecha, $valor, $descripcion)
	{
		$conexion_bd = conectar_bd();
		//Prepara la consulta
		$dml_editar = 'UPDATE donacion SET idTipoDonacion=(?), fecha=(?), valor=(?), descripcion=(?) ';
		$dml_editar .= ' WHERE idDonacion=(?)';
		if ( !($statement = $conexion_bd->prepare($dml_editar)) ) {
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
		}

		//Unir los parámetros de la función con los parámetros de la consulta
		//El primer argumento de bind_param es el formato de cada parámetro
		if (!$statement->bind_param("isdsi", $idTipoDonacion, $fecha,$valor, $descripcion, $idDonacion)) {
			die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		//Executar la consulta
		if (!$statement->execute()) {
		  die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		desconectar_bd($conexion_bd);
		  return 1;
  }

  //Eliminar a un médico
	function eliminar_donacion($idDonacion)
	{
		$conexion_bd = conectar_bd();

		//Prepara la consulta
		$dml_eliminar = 'DELETE FROM donacion WHERE idDonacion=(?)';
		if ( !($statement = $conexion_bd->prepare($dml_eliminar)) ) {
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
		}

		//Unir los parámetros de la función con los parámetros de la consulta
		//El primer argumento de bind_param es el formato de cada parámetro
		if (!$statement->bind_param("i", $idDonacion)) {
			die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		//Executar la consulta
		if (!$statement->execute()) {
		  die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		desconectar_bd($conexion_bd);
		return 1;
	}

	function verContactos($idDonante)
	{
		$conexion_bd = conectar_bd();

		$resultado = "";

		$consulta = 'SELECT *';
		$consulta .= ' FROM contactoDonante';
		$consulta .= ' WHERE idStatus = 1 AND idDonante = '.$idDonante;

		$resultados = $conexion_bd->query($consulta);
		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH))
		{
			$resultado .= "<div class='card text-center' style='width: 18rem;'><div class='card-body'>";
			$resultado .= "<h5 class='card-title'><i class='fas fa-user'></i> ".$row['nombre']."</h5>";

			$resultado .= "<h6 class='card-subtitle mb-2 text-muted'>";
			if($row['cargo'] != null)
				$resultado .= "<strong>Cargo: </strong>".$row['cargo']."</h6><hr/>";
			else
				$resultado .= "<strong>Cargo: </strong>-</h6><hr/>";

			$resultado .= "<p class='card-text'><ul class='no-bullets'>";

			if($row['correo'] != null)
				$resultado .= "<li><strong>Correo:</strong> ".$row['correo']."</li>";
			else
				$resultado .= "<li><strong>Correo:</strong> -</li>";

			if($row['telefono'] != null)
				$resultado .= "<li><strong>Teléfono:</strong> ".$row['telefono']."</li>";
			else
				$resultado .= "<li><strong>Teléfono:</strong> -</li>";

			if($row['extension'] != null)
				$resultado .= "<li><strong>Extensión:</strong> ".$row['extension']."</li>";
			else
				$resultado .= "<li><strong>Extensión:</strong> -</li>";

			if($row['celular'] != null)
				$resultado .= "<li><strong>Celular:</strong> ".$row['celular']."</li>";
			else
				$resultado .= "<li><strong>Celular:</strong> -</li>";

			if($row['fechaNacimiento'] != null)
				$resultado .= "<li><strong>Cumpleaños:</strong> ".date_format(date_create($row['fechaNacimiento']), "d/m/Y")."</li>";
			else
				$resultado .= "<li><strong>Cumpleaños:</strong> -</li>";


			$resultado .= "</ul></p>";


			//si tiene permisos de editar y eliminar que salgan los botones
			if($_SESSION["usuario"] === "Administradora")
			{
				$resultado .= "<hr/> <a title='Modificar Contacto' href='modificarContacto.php?idDonante=".$idDonante."&idContacto=".$row['idContacto']."' class='btn btn-outline-secondary'><i class='fas fa-pencil-alt'></i></a>";
				$resultado .= "<a title='Dar de Baja Contacto' data-toggle='modal'  href='#modal".$row['idContacto']."' class='btn btn-outline-danger'><i class='fas fa-trash-alt'></i></a>";
			}
			$resultado .= "</div></div>";

			include("donantes/modalEliminarContacto.html");
		}

		mysqli_free_result($resultados);
		desconectar_bd($conexion_bd);


		return $resultado;
	}

	//agregar un contacto a la bd
	function agregar_contacto($idDonante, $nombre, $cargo, $correo, $telefono, $extension, $celular, $fechaNacimiento)
	{
		$conexion_bd = conectar_bd();

		//preparar consulta
		$dml_insertar = 'INSERT INTO contactoDonante (idDonante, nombre, cargo, correo, telefono, extension, celular, fechaNacimiento) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
		if(!($statement = $conexion_bd->prepare($dml_insertar)))
		{
			die("Error: (".$conexion_bd->errno.") ".$conexion_bd->error);
			return 0;
		}


		//unir parámetros de la función con la consulta
		//el primer arg es el formato de cada parámetro
		if(!$statement->bind_param("issssiss", $idDonante, $nombre, $cargo, $correo, $telefono, $extension, $celular, $fechaNacimiento))
		{
			die("Error en vinculación: (".$statement->errno.") ".$statement->error);
			return 0;
		}

		//Ejecutar inserción
		if(!$statement->execute())
		{
			die("Error en ejecución: (".$statement->errno.") ".$statement->error);
			return 0;
		}

		desconectar_bd($conexion_bd);
		return 1;
	}

	//modificar a un contacto
	function modificar_contacto($idContacto, $nombre, $cargo, $correo, $telefono, $extension, $celular, $fechaNacimiento)
	{
		$conexion_bd = conectar_bd();
		//Prepara la consulta
		$dml_editar = 'UPDATE contactoDonante SET nombre=(?), cargo=(?), correo=(?), telefono=(?), extension=(?), celular=(?), fechaNacimiento=(?) ';
		$dml_editar .= ' WHERE idContacto=(?)';
		if ( !($statement = $conexion_bd->prepare($dml_editar)) ) {
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
		}

		//Unir los parámetros de la función con los parámetros de la consulta
		//El primer argumento de bind_param es el formato de cada parámetro
		if (!$statement->bind_param("ssssissi", $nombre, $cargo, $correo, $telefono, $extension, $celular, $fechaNacimiento, $idContacto)) {
			die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		//Executar la consulta
		if (!$statement->execute()) {
		  die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		desconectar_bd($conexion_bd);
		  return 1;
  }

  function egresar_contacto($idContacto)
	{
		$conexion_bd = conectar_bd();
		//Prepara la consulta
		$dml_editar = 'UPDATE contactoDonante SET idStatus = 2 ';
		$dml_editar .= ' WHERE idContacto=(?)';
		if ( !($statement = $conexion_bd->prepare($dml_editar)) ) {
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
		}

		//Unir los parámetros de la función con los parámetros de la consulta
		//El primer argumento de bind_param es el formato de cada parámetro
		if (!$statement->bind_param("i",$idContacto)) {
			die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		//Executar la consulta
		if (!$statement->execute()) {
		  die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		desconectar_bd($conexion_bd);
		  return 1;
  }

	function obtener_idDonante($idTipo, $fecha, $nombre)
	{
		$conexion_bd = conectar_bd();


		$consulta = "SELECT idDonante FROM $tabla WHERE $nombreLlave ='$llave'";
		$resultados = $conexion_bd->query($consulta);
		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
			desconectar_bd($conexion_bd);
			return $row["$campo"];
		}

		desconectar_bd($conexion_bd);
		return 0;
	}




//---------------------------------------------------------------
//-----------------------------EMPLEADOS-------------------------
//---------------------------------------------------------------

	function modificarPersonales($id, $nombre,$fechaNacimiento,$estadoNacimiento,$curp, $rfc,$segsocial, $infonavit, $puesto){
		$conexion_bd = conectar_bd();

		//Prepara la consulta
		$dml_editar = 'UPDATE empleado SET nombre=(?), fechaNacimiento=(?), idEstadoM=(?), idPuesto=(?), curp=(?), rfc=(?), segSocial=(?), infonavit=(?) WHERE idEmpleado=(?)';
		if ( !($statement = $conexion_bd->prepare($dml_editar)) ) {
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
		}

		//Unir los parámetros de la función con los parámetros de la consulta
		//El primer argumento de bind_param es el formato de cada parámetro
		if (!$statement->bind_param("ssiissiii", $nombre, $fechaNacimiento, $estadoNacimiento, $puesto, $curp, $rfc, $segsocial, $infonavit, $id)) {
			die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		//Executar la consulta
		if (!$statement->execute()) {
		  die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		desconectar_bd($conexion_bd);
		  return 1;
	}

	function modificar_DContacto($direccion,$tel,$cel,$correo,$id){
		$conexion_bd = conectar_bd();

		//Prepara la consulta
		$dml_editar = 'UPDATE empleado SET direccion=(?), telefono=(?), celular=(?), correo=(?) WHERE idEmpleado=(?)';
		if ( !($statement = $conexion_bd->prepare($dml_editar)) ) {
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
		}

		//Unir los parámetros de la función con los parámetros de la consulta
		//El primer argumento de bind_param es el formato de cada parámetro
		if (!$statement->bind_param("ssssi", $direccion, $tel, $cel, $correo, $id)) {
			die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		//Executar la consulta
		if (!$statement->execute()) {
		  die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		desconectar_bd($conexion_bd);
		  return 1;
	}

	function modificarContratacion($fechaI, $voluntario, $diasT, $horaEntrada, $horaSalida, $id){
		$conexion_bd = conectar_bd();

		//Prepara la consulta
		$dml_editar = 'UPDATE empleado SET  fechaI=(?), voluntario=(?), diasT=(?), horaEntrada=(?), horaSalida=(?) WHERE idEmpleado=(?)';
		if ( !($statement = $conexion_bd->prepare($dml_editar)) ) {
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
		}

		//Unir los parámetros de la función con los parámetros de la consulta
		//El primer argumento de bind_param es el formato de cada parámetro
		if (!$statement->bind_param("sisssi", $fechaI, $voluntario, $diasT, $horaEntrada, $horaSalida, $id)) {
			die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		//Executar la consulta
		if (!$statement->execute()) {
		  die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		desconectar_bd($conexion_bd);
		  return 1;
	}

	function obtenerIdBN($id=""){
		$conexion_bd = conectar_bd();
		$consulta = 'SELECT idBenefN as idBN FROM benef_empleado WHERE idEmpleado = '.$id;

		$resultados = $conexion_bd->query($consulta);
     	while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
     		$resultado = $row['idBN'];
     	}

     	desconectar_bd($conexion_bd);
     	return $resultado;
	}



	function modificarNomina($idEstCivil, $escolaridad, $nBeneficiarios, $id){
		$conexion_bd = conectar_bd();

		//Prepara la consulta
		$dml_editar = 'UPDATE empleado SET idEstCivil=(?), escolaridad=(?), nBeneficiarios=(?) WHERE idEmpleado=(?)';
		if ( !($statement = $conexion_bd->prepare($dml_editar)) ) {
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
		}

		//Unir los parámetros de la función con los parámetros de la consulta
		//El primer argumento de bind_param es el formato de cada parámetro
		if (!$statement->bind_param("isii", $idEstCivil, $escolaridad, $nBeneficiarios, $id)) {
			die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		//Executar la consulta
		if (!$statement->execute()) {
		  die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		desconectar_bd($conexion_bd);
		  return 1;
	}


   function consultar_empleados($puesto="",$empleado="", $status="", $nombre="") {
     $conexion_bd = conectar_bd();

    $resultado =  "<div class=\"row\"><div class=\"miTabla table-wrapper-scroll-y my-custom-scrollbar mx-auto text-center\"><table class='table table-hover table-striped table-responsive-md btn-table'><thead><tr><th scope=\"col\">Nombre</th><th scope=\"col\">Puesto</th><th scope=\"col\">Celular</th><th scope=\"col\">Acciones</th></tr></thead>";

    $consulta = 'Select E.voluntario as vol, E.idEmpleado as id, E.Nombre as nombre, P.nombre as puesto, E.celular as celular From empleado as E, puesto as P, status as S WHERE E.idPuesto = P.idPuesto AND E.idStatus = S.idStatus';
    //$consulta .= 'E.estado = "activo"';
    if ($empleado != "") {
        $consulta .= ' AND E.idEmpleado = '.$empleado;
    }

    if ($puesto != "") {
        $consulta .= " AND E.idPuesto = ".$puesto;
    }


    if ($status != "") {
        $consulta .= " AND E.idStatus = ".$status;
	}

	if($nombre != "")
			$consulta .= ' AND E.Nombre LIKE "%'.$nombre.'%" ';

    $consulta .= ' ORDER BY E.idEmpleado ASC ';

    $resultados = $conexion_bd->query($consulta);
     while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
         $resultado .= "<tr>";
         $resultado .= '<td>'.$row["nombre"].'</a></td>'; //Se puede usar el índice de la consulta
         $resultado .= "<td>".$row['puesto']."</td>";
         $resultado .= "<td><a href=\"tel:+52".$row['celular']."\">".$row['celular']."</td>";
         //botones
         $resultado .= "<td>";
		 $resultado .= "<a data-tooltip='tooltip' data-placement='top' href=\"verEmpleado.php?id=".$row['id']."\" title='Ver Más' class=\"btn btn-outline-info\"><i class='fas fa-search-plus'></i></a>&nbsp";
		 //si tiene permisos de editar y eliminar que salgan los botones
		 if($_SESSION["usuario"] === "Administradora"){

            if($status === "1"){
            	//BOTON MODIFICAR
            	$resultado .= "<a href='modificarEmpleado.php?editar=general&id=".$row['id']."&voluntario=".$row['vol']."' data-tooltip='tooltip' data-placement='top' title='Modificar' class='btn btn-outline-secondary'><i class='fas fa-pencil-alt'></i></a>&nbsp";
            	//BOTON EGRESAR
                $resultado .= '<button type="button" data-tooltip="tooltip" data-placement="top" title="Egresar" class="btn btn-outline-danger" data-toggle="modal" data-target="#modal'.$row['id'].'"><i class="fas fa-trash-alt"></i></button>&nbsp';
                //Crear el modal
                include("empleados/modalEgreso.html");
                              //fin del modal
                }else{
                	$resultado .= "<a href='modificarEgreso.php?id=".$row['id']."' class='btn btn-outline-secondary'><i class='fas fa-pencil-alt'></i></a>&nbsp";
                    $resultado .= '<button type="button" class="btn btn-outline-success" title="Reingresar" data-toggle="modal" data-target="#modal'.$row['id'].'">
                    <i class="fas fa-redo-alt"></i></button>';
                    //Crear el modal
                     include("empleados/modalReingreso.html");
                                  //fin del modal
                }
		 }
		 $resultado .= "</td>";
         $resultado .= "</tr>";


     }

     mysqli_free_result($resultados); //Liberar la memoria

     desconectar_bd($conexion_bd);

     $resultado .= "</tbody></table></div>";
     return $resultado;
   }

   //Consulta el detalle de cada empleado
   function detalle_empleado($id="") {
     $conexion_bd = conectar_bd();

    $resultado =  '<div class="container-fluid">';

    $consulta = 'Select E.idEmpleado as id, E.Nombre as nombre, E.voluntario as vol, E.nBeneRegistrados as registrados, E.idStatus as status, E.nBeneficiarios as nBenef, P.nombre as puesto, E.fechaI as fechaIngreso, E.fechaNacimiento as fechaNacimiento, EM.nombre as eNacimiento, E.curp as curp, E.rfc as rfc, E.segSocial as segsocial, E.infonavit as infonavit, E.direccion as direccion, E.correo as correo, E.celular as celular, E.telefono as tel, E.diasT as diasT, E.horaEntrada as entrada, E.horaSalida as salida, EC.nombre as estcivil, E.escolaridad as escolaridad ';
    $consulta .=' From empleado as E, puesto as P, estadocivil as EC, estadom as EM';
    $consulta .= ' WHERE E.idEmpleado = '.$id.' AND E.idEstCivil = EC.idEstCivil AND E.idEstadoM = EM.idEstadoM AND E.idPuesto = P.idPuesto ';




    $resultados = $conexion_bd->query($consulta);
     while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
        //DATOS INICIALES
        //calcular edad


         $edad = calculaEdad($row['fechaNacimiento']);
         $resultado .= '<h1 class="mt-4 text-primary" align="center" >'.$row['nombre'].'</h1>';
         $resultado .= '<center><h6 class="text-primary">'.$row['puesto'].'</h6>';
         $resultado .= ' <h6 class="text-primary">Fecha de Ingreso: '.date("d-m-Y", strtotime($row['fechaIngreso'])).'</h6></center>';
         //ver si está egresado:
         if($row['status']==2){
         	$resultado .= '<a href="#datosEgreso"><div class="alert alert-danger"  role="alert">
            					<center><h4>EMPLEADO INACTIVO</h4></center>
          					</div></a>';
         }
         $resultado .= '<hr />';

        //DATOS PERSONALES
         $resultado .= '<div class="container-fluid text-left"><div id="info"><div class="row "><div class="col-md-5">
         					<h4 class="text-center"><span class="badge badge-primary">Información Personal</span></h4>
         					<ul >';
         $resultado .= '<li class="pink-hover"><strong>Edad:   </strong>'.$edad.'</li>';
         $resultado .= '<li class="pink-hover"><strong>Fecha de nacimiento:  </strong>'.date("d-m-Y", strtotime($row['fechaNacimiento'])).'</li>';
         $resultado .= '<li class="pink-hover"><strong>Estado de nacimiento:   </strong>'.$row['eNacimiento'].'</li>';
         $resultado .= '<li class="pink-hover"><strong>CURP:   </strong>'.$row['curp'].'</li>';
         $resultado .= '<li class="pink-hover"><strong>RFC:   </strong>'.$row['rfc'].'</li>';
         $resultado .= '<li class="pink-hover"><strong>No. de seguro social:   </strong>'.$row['segsocial'].'</li>
         				<li class="pink-hover"><strong>No. de infonavit:   </strong>'.$row['infonavit'].'</li>
                        </ul>
                        </div>';
         if($row['status']!=2){
	         	$resultado .= '<div class="col-md-1"> <a data-tooltip="tooltip" data-placement="top" title="Modificar Datos Personales" href="modificarEmpleado.php?editar=personal&id='.$row["id"].'" class="btn btn-outline-secondary"><i class="fas fa-pencil-alt"></i></a></div>';
	         }


        //INFORMACION DE CONTACTO
         $resultado .= '<div class="col-md-5">
           					<h4 class="text-center"><span class="badge badge-secondary">Información de Contacto</span></h4>
                        <ul>';
         $resultado .= '<li class="pink-hover"><strong>Dirección:   </strong> '.$row['direccion'].'</li>';
         $resultado .= '<li class="pink-hover"><strong>Celular:</strong><a href="tel:+52'.$row['celular'].'">    '.$row['celular'].'</a></li>';
         $resultado .= '<li class="pink-hover"><strong>Teléfono:</strong> '.$row['tel'].'</li>
         				<li class="pink-hover"><strong>Correo:</strong> '.$row['correo'].'</li>
         				</ul>
                        </div>';
        if($row['status']!=2){
	         	$resultado .= '<div class="col-md-1"> <a data-tooltip="tooltip" data-placement="top" title="Modificar Datos de Contacto" href="modificarEmpleado.php?editar=contacto&id='.$row["id"].'" class="btn btn-outline-secondary"><i class="fas fa-pencil-alt"></i></a></div>';
	         }
        $resultado .= '</div><hr/>';
        //INFORMACION DE CONTRATACION
         $resultado .= '<div class="row">
                        <div class="col-md-5"><h4 class="text-center">
                        <span class="badge badge-secondary">Información de Contratación</span></h4>
                        <ul>';
         $resultado .= '<li class="pink-hover"><strong>Salario diario actual   :</strong>  $'.ultimoSalario($id).'</li>';
         $resultado .= '<li class="pink-hover"><strong>Días que labora:</strong>'.$row['diasT'].'</li>';
         $resultado .= '<li class="pink-hover"><strong>Horario laboral:</strong> De '.$row['entrada'].' a '.$row['salida'].'</li>';
                        //horas semanales de trabajo pendiente por operacion y falta de datos
         $resultado .= '</ul>
                        </div>';
         if($row['status']!=2){
	         	$resultado .= '<div class="col-md-1"> <a data-tooltip="tooltip" data-placement="top" title="Modificar Datos de Contratación" href="modificarEmpleado.php?editar=contratacion&id='.$row["id"].'" class="btn btn-outline-secondary"><i class="fas fa-pencil-alt"></i></a></div>';
	     }


        //INFORMACION DE NOMINA SOLO SI NO ES VOLUNTARIO
         if($row['vol'] == 0 || $row['vol'] == NULL){
	         $resultado .= '<div class="col-md-5">
	                        <h4 class="text-center"><span class="badge badge-secondary">Información de Tarjeta de Nómina</span></h4>
	                        <ul>';
	         $resultado .= '<li class="pink-hover"><strong>Estado Civil:  </strong>'.$row['estcivil'].'</li>';
	         $resultado .= '<li class="pink-hover"><strong>Escolaridad:   </strong>'.$row['escolaridad'].'</li>';
	         $resultado .= '<li class="pink-hover"><strong># Beneficiarios:  </strong>'.$row['nBenef'].'</li>
	                        </ul>
	                        </div>';
	         if($row['status']!=2){
	         	$resultado .= '<div class="col-md-1"> <a data-tooltip="tooltip" data-placement="top" title="Modificar Datos de Tarjeta de Nómina" href="modificarEmpleado.php?editar=nomina&id='.$row["id"].'" class="btn btn-outline-secondary"><i class="fas fa-pencil-alt"></i></a></div>';
	         }
	         $resultado .= '</div><hr/>';

	         if($row['status']==2){
         		$resultado .= '<div class="alert alert-danger"  role="alert">
            					<a name="datosEgreso"><center><h4>DATOS DE EGRESO</h4></center></a>

          						</div>';

          		$resultado .= verDatosEgreso($id);
         	 }

	         $resultado .= ver_BeneficiariosNomina($id, $row['status'], $row['registrados'],$row['nBenef']);
	         $resultado .= '<div class="row"> <div class="col-md-6">';

	         $resultado .= verSalarios($id, $row['status'],$row['fechaIngreso']);
				$resultado .= '</div><div class="col-md-6">';
			  $resultado .= verAusentismos($id, $row['status']);
			 $resultado .= '</div>';
         }
         $resultado .= '</div><hr/>';
         $resultado .= verVacaciones($id, $row['status'],$row['fechaIngreso']);

         $resultado .= verArchivosEmp($id);
         include("modalAI.html");
         include("modalAC.html");
        }
     mysqli_free_result($resultados); //Liberar la memoria

     desconectar_bd($conexion_bd);

     return $resultado;
   }

   function verArchivosEmp($id="", $st=""){
	   $resultado = '<hr/><center><h2 class="mt-4 text-white" ><span class="badge badge-primary"> ARCHIVOS </span></h2></center><br/>
	   				 <div class="row justify-content-center">

	   						<center><h2 class=" text-white" ><span class="badge badge-primary"><i class="fas fa-arrow-alt-circle-right"></i> Archivos de ingreso </span></h2>
	   						<span class="badge text-white">Archivos que respaldan el ingreso o que son opcionales (como licencia de manejo).</span><br>
	   						';
	   						if($st != 2){
	   							$resultado .= '<input class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#modalAI" value="SUBIR ARCHIVOS"><br/><br/>';
	   						}

	   						$resultado .= desplegarArchivosEmp($id,"ingreso");
	   						$resultado .= '</center>';
	   	//fin del row
	   	$resultado .= '</div><hr/>';
	   	$resultado .= '<div class="row justify-content-center">

	   					<center><h2 class=" text-white" ><span class="badge badge-primary"><i class="fas fa-undo"></i> Archivos continuos </span></h2>
	   					<span class="badge text-white">Archivos que se suben con regluaridad (como evaluaciones de desempeño).</span><br>
	   					';
	   					if($st != 2){
	   							$resultado .= '<input class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#modalAC" value="SUBIR ARCHIVOS"><br/><br/>';
	   						}

	   					$resultado .= desplegarArchivosEmp($id,"continuos");
	   					$resultado .= '</center>';
	   	//fin del row
	   	$resultado .= '</div>';

	   return $resultado;
   }

   function verDatosEgreso($id){
   	$conexion_bd = conectar_bd();
	$consulta = 'SELECT E.fegreso as fecha, E.motivoegreso as motivo FROM empleado as E WHERE E.idEmpleado = '.$id;
	$resultados = $conexion_bd->query($consulta);
     while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
     	$resultado = ' <div class="container">
     						<a data-tooltip="tooltip" data-placement="top" title="Modificar Datos de Egreso" href="modificarEgreso.php?id='.$id.'" class="btn btn-outline-secondary float-right"><i class="fas fa-pencil-alt"></i></a> <br/>
					      <i class="far fa-calendar-alt"></i>
					      <label for="fechaEgreso">Ultimo día trabajado:</label>
					      <input type="date" class="form-control" placeholder="" name="fechaEgreso" value= "'.$row['fecha'].'" readonly>


					      <label for="motivoEgreso">Motivo de egreso:</label>
					      <textarea class="form-control" name="motivoEgreso" rows="5" readonly>'.$row['motivo'].'</textarea>
					      <center><h4 class="mt-4 text-white" ><span class="badge badge-primary">Archivos de Egreso</span></h4></center>

					    ';
		$resultado .= desplegarArchivosEmp($id, "egreso");
		$resultado .= '</div>
					    <hr>';
    }
   	mysqli_free_result($resultados); //Liberar la memoria

    desconectar_bd($conexion_bd);
    return $resultado;
   }

   function ver_BeneficiariosNomina($id="", $st="", $reg="", $nBenef=""){
   		 $conexion_bd = conectar_bd();

   		 $consulta = 'SELECT B.idBenefN as idB, B.nombre as nombre, B.parentesco as parentesco, B.rfc as rfc, B.direccion as direccion, R.porcentaje as porcentaje FROM beneficiarionomina as B, benef_empleado as R WHERE R.idEmpleado = '.$id.' AND B.idBenefN = R.idBenefN';


   		 $resultados = $conexion_bd->query($consulta);
   		 $contador = 1;
   		 $resultado="";
   		 $resultado =  '<div class="container-fluid"><center><h2 class="mt-4 text-white" ><span class="badge badge-primary"> BENEFICIARIOS DE NÓMINA </span></h2></center>';
   		 $faltan = $nBenef - $reg;

   		 for ($i=0; $i<$faltan ; $i++){
   		 	$resultado .= '<br/><center><a href="registrarBenefN.php?id='.$id.'&edit=0" class="btn btn-primary" >Registrar Beneficiario<i class="material-icons">add_circle_outline</i></a></center> <br>';
   		 }
   		 $resultado .= '<div class="d-flex justify-content-around flex-wrap flex-row-reverse">';
     	 while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
     	 	if(sizeof($row) != 0){
	     	 	$resultado .= '
	     	 				<div class="card card text-center" style="width: 18rem;">
  								<div class="card-body">';

		        $resultado .= '<h5 class="card-title text-primary"><strong>'.$row['nombre'].'</h5></strong>';
		        $resultado .= '<h6 class="card-subtitle mb-2 text-muted">PARENTESCO   : </strong>'.$row['parentesco'].'</h6>';
		        $resultado .= '<p class="card-text"><strong>DIRECCIÓN : </strong>'.$row['direccion'].'</p>';
		        $resultado .= '<p class="card-text"><strong>RFC : </strong>'.$row['rfc'].'</p>';
		        //horas semanales de trabajo pendiente por operacion y falta de datos
		        $resultado .= '<p class="card-text"><strong>PORCENTAJE   : </strong>'.$row['porcentaje'].'%</p>';


		     	$contador ++;
		     	if($st == 1){
	     	 		$resultado .= '<hr/><a data-tooltip="tooltip" data-placement="top" title="Modificar" href="modificarBN.php?idBN='.$row['idB'].'&idE='.$id.'" class="btn btn-outline-secondary"><i class="fas fa-pencil-alt"></i></a>';
	     }			$resultado .= '<a  data-tooltip="tooltip" data-placement="top"  title="Eliminar" class="btn btn-outline-danger" data-toggle="modal" data-target="#modalEliminarBN'.$row['idB'].' " href="eliminar.php?id='.$id.'"><i class="fas fa-trash-alt"></i></a>';
	     			$resultado .= '</div></div>';
	     			include("empleados/modalEliminarBN.html");
		    }else if (sizeof($row) == 0){

		     	$resultado .= '<h3 class="mt-4 text-primary" > No hay Beneficiarios de nómina </h3></div><hr/>';
			}
		}


		$resultado.= '</div></div></center><hr/>';
     	 mysqli_free_result($resultados); //Liberar la memoria

     	 desconectar_bd($conexion_bd);
     	 return $resultado;

   }

   function verSalarios($id="",$st,$fingreso){
   	 $conexion_bd = conectar_bd();

    $resultado =  '<div class="row justify-content-center"><center><h2 class="mt-4 text-white" ><span class="badge badge-primary"> HISTÓRICO DE SALARIOS </span></h2></center></div><div class="row"><div class="mx-auto text-center"><table class="table table-hover table-striped table-responsive-md btn-table"><thead><tr><th scope="col">Salario Diario</th><th scope="col">Compensaciones</th><th scope="col">Fecha</th>';
    if($st == 1){
    	$resultado .='<th scope="col">Acciones</th>';
    }

    $resultado .= '</tr></thead>';

    $consulta = 'SELECT S.idSalario as idS, S.salarioDiario as salario, S.compensacion as compensaciones, S.fecha as fecha FROM salario as S WHERE  S.idEmpleado = '.$id.' ORDER BY S.fecha DESC';

    $resultados = $conexion_bd->query($consulta);
	while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
		 $resultado .= "<tr>";
         $resultado .= '<td>$ '.$row["salario"].'</a></td>'; //Se puede usar el índice de la consulta
         $resultado .= "<td>$ ".$row['compensaciones']."</td>";
         $resultado .= "<td>".$row['fecha']."</td>";
         $resultado .= '<td>';
         if($st == 1){
         	//botones de edición

         $resultado .= '';
         $resultado .= "<a data-tooltip='tooltip' data-placement='top' title='Modificar' href='modificarSalario.php?idS=".$row['idS']."&id=".$id."
         ' class='btn btn-outline-secondary'><i class='fas fa-pencil-alt'></i></a>";
		 $resultado .= '<a  data-tooltip="tooltip" data-placement="top" title="Eliminar" class="btn btn-outline-danger" data-toggle="modal" data-target="#modalEliminarSalario'.$row['idS'].'" href="registrarAusentismo.php?id='.$id.'"><i class="fas fa-trash-alt"></i></a>';
		}
		$resultado .= verSalariosConArchivos($row['idS'], $id);
		 $resultado .= '</td>';
         $resultado .= '</tr>';
         include("empleados/modalEliminarSalario.html");


	}
	$resultado .= '</table>';
	if($st == 1){
		$resultado .= '<div class="text-right ">
            		<a class="btn btn-primary " href="registrarSueldo.php?id='.$id.'">Registrar Salario
             		<i class="material-icons">add_circle_outline</i>
            		</a></div>';
	}

    $resultado .= '</div></div><hr/>';
    desconectar_bd($conexion_bd);
     	 return $resultado;
   }

   function verSalariosConArchivos($idS, $id){
   	$conexion_bd = conectar_bd();
   	$consulta = 'SELECT A.pathArchivo FROM salario as S, archivoempleado as A WHERE S.idSalario = '.$idS.' AND S.idArchivo = A.idArchivo';
   	 $resultados = $conexion_bd->query($consulta);
   	 $resultado = "";
	while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
		if($row["pathArchivo"] != null){
			//BOTÓN PARA DESCARGAR LOS ARCHIVOS
			$resultado .= "<a data-tooltip='tooltip' title='Descargar hoja de incremento salarial' data-placement='top' class='btn btn-outline-secondary' href='descargarArchivo.php?id=".$id."&path=".$row['pathArchivo']."'><i class='fas fa-download'></i></a>";
		}else $resultado .= "";
	}
	desconectar_bd($conexion_bd);

   	return $resultado;
   }

   function verVacacionesConArchivos($idV, $id){
   	$conexion_bd = conectar_bd();
   	$consulta = 'SELECT A.pathArchivo FROM vacaciones as V, archivoempleado as A WHERE V.idVacaciones = '.$idV.' AND V.idArchivo = A.idArchivo';
   	 $resultados = $conexion_bd->query($consulta);
   	 $resultado = "";
	while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
		if($row["pathArchivo"] != null){
			//BOTÓN PARA DESCARGAR LOS ARCHIVOS
			$resultado .= "<a data-tooltip='tooltip' title='Descargar firma de vacaciones' data-placement='top' class='btn btn-outline-secondary' href='descargarArchivo.php?id=".$id."&path=".$row['pathArchivo']."'><i class='fas fa-download'></i></a>";
		}else $resultado .= "";
	}
	desconectar_bd($conexion_bd);

   	return $resultado;
   }

   function verAusentismosConArchivos($idA, $id){
   	$conexion_bd = conectar_bd();
   	$consulta = 'SELECT A.pathArchivo FROM ausentismo as Au, archivoempleado as A WHERE Au.idAusentimo = '.$idA.' AND Au.idArchivo = A.idArchivo';
   	 $resultados = $conexion_bd->query($consulta);
   	 $resultado = "";
	while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
		if($row["pathArchivo"] != null){
			//BOTÓN PARA DESCARGAR LOS ARCHIVOS
			$resultado .= "<a data-tooltip='tooltip' title='Descargar justificante' data-placement='top' class='btn btn-outline-secondary' href='descargarArchivo.php?id=".$id."&path=".$row['pathArchivo']."'><i class='fas fa-download'></i></a>";
		}else $resultado .= "";
	}
	desconectar_bd($conexion_bd);

   	return $resultado;
   }

   function eliminarBN($id="", $idB=""){
   		$conexion_bd = conectar_bd();

		//Prepara la consulta
		$dml_eliminar = 'DELETE FROM benef_empleado WHERE idEmpleado = (?) AND idBenefN = (?)';
		if ( !($statement = $conexion_bd->prepare($dml_eliminar)) ) {
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
		}

		//Unir los parámetros de la función con los parámetros de la consulta
		//El primer argumento de bind_param es el formato de cada parámetro
		if (!$statement->bind_param("ii", $id, $idB)) {
			die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		//Executar la consulta
		if (!$statement->execute()) {
		  die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		//Prepara la consulta
		$dml_eliminar = 'DELETE FROM beneficiarionomina WHERE idBenefN = (?)';
		if ( !($statement = $conexion_bd->prepare($dml_eliminar)) ) {
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
		}

		//Unir los parámetros de la función con los parámetros de la consulta
		//El primer argumento de bind_param es el formato de cada parámetro
		if (!$statement->bind_param("i", $idB)) {
			die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		//Executar la consulta
		if (!$statement->execute()) {
		  die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		restarBN($id);

		desconectar_bd($conexion_bd);
		return 1;
   }


	function modificar_Salario($salario,$compensaciones,$id,$infonavit,$idE){
		$conexion_bd = conectar_bd();

		//Prepara la consulta
		$dml_editar = 'UPDATE salario SET salarioDiario=(?), compensacion=(?) WHERE idSalario=(?)';
		if ( !($statement = $conexion_bd->prepare($dml_editar)) ) {
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
		}

		//Unir los parámetros de la función con los parámetros de la consulta
		//El primer argumento de bind_param es el formato de cada parámetro
		if (!$statement->bind_param("iii", $salario, $compensaciones, $id)) {
			die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		//Executar la consulta
		if (!$statement->execute()) {
		  die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		actualizarInfonavit($infonavit, $idE);

		desconectar_bd($conexion_bd);
		  return 1;
	}

	function actualizarArch($tabla, $nombreId, $id, $idArchivo){
		$conexion_bd = conectar_bd();

		//Prepara la consulta
		$dml_editar = 'UPDATE '. $tabla .' SET idArchivo=(?) WHERE '.$nombreId.'=(?)';
		if ( !($statement = $conexion_bd->prepare($dml_editar)) ) {
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
		}

		//Unir los parámetros de la función con los parámetros de la consulta
		//El primer argumento de bind_param es el formato de cada parámetro
		if (!$statement->bind_param("ii", $idArchivo, $id)) {
			die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		//Executar la consulta
		if (!$statement->execute()) {
		  die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		desconectar_bd($conexion_bd);
		  return 1;
	}


   function eliminarSalario($id=""){
   		$conexion_bd = conectar_bd();

		//Prepara la consulta
		$dml_eliminar = 'DELETE FROM salario WHERE idSalario = (?)';
		if ( !($statement = $conexion_bd->prepare($dml_eliminar)) ) {
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
		}

		//Unir los parámetros de la función con los parámetros de la consulta
		//El primer argumento de bind_param es el formato de cada parámetro
		if (!$statement->bind_param("i", $id)) {
			die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		//Executar la consulta
		if (!$statement->execute()) {
		  die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		desconectar_bd($conexion_bd);
		return 1;
   }

   function verVacaciones($id="", $st,$fingreso){
   	 $conexion_bd = conectar_bd();

    $resultado =  '<div class="row justify-content-center"><center><h2 class="mt-4 text-white" ><span class="badge badge-primary"> HISTÓRICO DE VACACIONES </span></h2></center></div><div class="row"><div class=" mx-auto text-center"><table class="table table-hover table-striped table-responsive-md btn-table"><thead><tr><th scope="col">Fecha registro</th><th scope="col">Antigüedad</th><th scope="col"># Dias</th><th scope="col">Fecha Salida</th><th scope="col">Fecha Regreso</th>';
    if($st == 1){
    	$resultado .='<th scope="col">Acciones</th>';
    }

    $resultado .= '</tr></thead>';
    $consulta = 'SELECT V.idVacaciones as idV, V.fecha as fecha, V.antiguedad as antiguedad, V.diasVacaciones as dias, V.fechaSalida as salida, V.fechaRegreso as regreso FROM vacaciones as V WHERE V.idEmpleado = '.$id.' ORDER BY V.fecha DESC';

    $resultados = $conexion_bd->query($consulta);
	while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
		 $resultado .= "<tr>";
         $resultado .= '<td>'.$row["fecha"].'</a></td>'; //Se puede usar el índice de la consulta
         $resultado .= "<td>".$row['antiguedad']."</td>";
         $resultado .= "<td>".$row['dias']."</td>";
         $resultado .= "<td>".$row['salida']."</td>";
         $resultado .= "<td>".$row['regreso']."</td>";
         $resultado .= '<td>';
         if($st == 1){
         	//botones de edición

         	$resultado .= "<a href='modificarVacacion.php?idV=".$row['idV']."&id=".$id."' data-tooltip='tooltip' data-placement='top' title='Modificar' class='btn btn-outline-secondary'><i class='fas fa-pencil-alt'></i></a>";
		 	$resultado .= '<a  data-tooltip="tooltip" data-placement="top" title="Eliminar" class="btn btn-outline-danger" data-toggle="modal" data-target="#modalEliminarVacacion'.$row['idV'].' " href="registrarAusentismo.php?id='.$id.'"><i class="fas fa-trash-alt"></i></a>';


         	include("empleados/modalEliminarVacacion.html");
         }
         $resultado .= verVacacionesConArchivos($row['idV'],$id);
         $resultado .= '</td>';
         	$resultado .= '</tr>';
	}

	$resultado .= '</table>';

	if($st == 1){
		$resultado .= '<div class="text-right ">
            		<a class="btn btn-primary " data-toggle="modal" data-target="#modalV'.$id.'" href="registrarVacaciones.php?id='.$id.'">Registrar Vacaciones
             		<i class="material-icons">add_circle_outline</i>
            		</a></div>';
	}
	$resultado .= '</div></div>';
	include("empleados/modalVacaciones.html");


	desconectar_bd($conexion_bd);
     	 return $resultado;
   }

   function modificar_vacacion($idV,$dias,$fechaSalida,$fechaRegreso){
   		$conexion_bd = conectar_bd();

		//Prepara la consulta
		$dml_editar = 'UPDATE vacaciones SET diasVacaciones=(?), fechaSalida=(?), fechaRegreso=(?) WHERE idVacaciones=(?)';
		if ( !($statement = $conexion_bd->prepare($dml_editar)) ) {
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
		}

		//Unir los parámetros de la función con los parámetros de la consulta
		//El primer argumento de bind_param es el formato de cada parámetro
		if (!$statement->bind_param("issi", $dias, $fechaSalida, $fechaRegreso, $idV)) {
			die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		//Executar la consulta
		if (!$statement->execute()) {
		  die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		desconectar_bd($conexion_bd);
		  return 1;
   }

   function eliminarVacacion($id=""){
   		$conexion_bd = conectar_bd();

		//Prepara la consulta
		$dml_eliminar = 'DELETE FROM vacaciones WHERE idVacaciones = (?)';
		if ( !($statement = $conexion_bd->prepare($dml_eliminar)) ) {
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
		}

		//Unir los parámetros de la función con los parámetros de la consulta
		//El primer argumento de bind_param es el formato de cada parámetro
		if (!$statement->bind_param("i", $id)) {
			die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		//Executar la consulta
		if (!$statement->execute()) {
		  die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		desconectar_bd($conexion_bd);
		return 1;
   }


   function agregar_vacaciones($id,$ant,$dias,$fechaSalida, $fechaRegreso){
   	$conexion_bd = conectar_bd();
   	$dml_insertar = 'INSERT INTO vacaciones (idEmpleado, antiguedad, diasVacaciones, fechaSalida, fechaRegreso) ';
		$dml_insertar .= ' VALUES (?, ?, ?, ?, ?)';
		if(!($statement = $conexion_bd->prepare($dml_insertar)))
		{
			die("Error: (".$conexion_bd->errno.") ".$conexion_bd->error);
			return 0;
		}


		//unir parámetros de la función con la consulta
		//el primer arg es el formato de cada parámetro
		if(!$statement->bind_param("issss", $id,$ant,$dias,$fechaSalida, $fechaRegreso))
		{
			die("Error en vinculación: (".$statement->errno.") ".$statement->error);
			return 0;
		}

		//Ejecutar inserción
		if(!$statement->execute())
		{
			die("Error en ejecución: (".$statement->errno.") ".$statement->error);
			return 0;
		}

		desconectar_bd($conexion_bd);
		return 1;
   }

   function verAusentismos($id="", $st){
   	$conexion_bd = conectar_bd();

    $resultado =  '<div class="row justify-content-center"><center><h2 class="mt-4 text-white" ><span class="badge badge-primary"> AUSENTISMOS </h2></span></center></div><div class="row"><div class=" mx-auto text-center"><table class="table table-hover table-striped table-responsive-md btn-table"><thead><tr><th scope="col">Fecha</th><th scope="col">Motivo</th>';
    if($st == 1){
    	$resultado .='<th scope="col">Acciones</th>';
    }

    $resultado .= '</tr></thead>';

    $consulta = 'SELECT A.idAusentimo as idA, A.fecha as fecha, A.motivoAus as motivo FROM ausentismo as A WHERE A.idEmpleado = '.$id.' ORDER BY A.fecha DESC';

    $resultados = $conexion_bd->query($consulta);
	while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
		 $resultado .= "<tr>";
         $resultado .= '<td>'.$row["fecha"].'</a></td>'; //Se puede usar el índice de la consulta
         $resultado .= "<td>".$row['motivo']."</td>";
         if($st == 1){
         	//botones de edición
         	$resultado .= '<td>';
         	$resultado .= "<a href='modificarAusentismo.php?idA=".$row['idA']."&id=".$id."' data-tooltip='tooltip' data-placement='top' title='Modificar' class='btn btn-outline-secondary'><i class='fas fa-pencil-alt'></i></a>";
		 	$resultado .= '<a  data-tooltip="tooltip" data-placement="top"  title="Eliminar" class="btn btn-outline-danger" data-toggle="modal" data-target="#modalEliminarAus'.$row['idA'].' " href=""><i class="fas fa-trash-alt"></i></a>';


         	include("empleados/modalEliminarAus.html");
         }
         $resultado .= verAusentismosConArchivos($row['idA'],$id);
         $resultado .= '</td>';
         	$resultado .= '</tr>';
	}
	$resultado .= '</table>';
	if($st == 1){
		$resultado .= '<div class="text-right ">
            		<a class="btn btn-primary " data-toggle="modal" data-target="#modal'.$id.'" href="registrarAusentismo.php?id='.$id.'">Registrar Ausentismo
             		<i class="material-icons">add_circle_outline</i>
            		</a></div>';
	}
	$resultado .= '</div></div><hr/>';
    include("empleados/modalAusentismos.html");
	desconectar_bd($conexion_bd);
     	 return $resultado;
   }

   function modificar_ausentismo($idA,$fecha,$motivo){
   		$conexion_bd = conectar_bd();

		//Prepara la consulta
		$dml_editar = 'UPDATE ausentismo SET fecha=(?), motivoAus=(?) WHERE idAusentimo=(?)';
		if ( !($statement = $conexion_bd->prepare($dml_editar)) ) {
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
		}

		//Unir los parámetros de la función con los parámetros de la consulta
		//El primer argumento de bind_param es el formato de cada parámetro
		if (!$statement->bind_param("ssi", $fecha, $motivo, $idA)) {
			die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		//Executar la consulta
		if (!$statement->execute()) {
		  die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		desconectar_bd($conexion_bd);
		  return 1;
   }

   function eliminarAus($id=""){
   		$conexion_bd = conectar_bd();

		//Prepara la consulta
		$dml_eliminar = 'DELETE FROM ausentismo WHERE idAusentimo = (?)';
		if ( !($statement = $conexion_bd->prepare($dml_eliminar)) ) {
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
		}

		//Unir los parámetros de la función con los parámetros de la consulta
		//El primer argumento de bind_param es el formato de cada parámetro
		if (!$statement->bind_param("i", $id)) {
			die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		//Executar la consulta
		if (!$statement->execute()) {
		  die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		desconectar_bd($conexion_bd);
		return 1;
   }

   function agregar_ausentismo($id,$fecha,$motivo){
   	$conexion_bd = conectar_bd();
   	$dml_insertar = 'INSERT INTO ausentismo (idEmpleado, fecha, motivoAus) ';
		$dml_insertar .= ' VALUES (?, ?, ?)';
		if(!($statement = $conexion_bd->prepare($dml_insertar)))
		{
			die("Error: (".$conexion_bd->errno.") ".$conexion_bd->error);
			return 0;
		}


		//unir parámetros de la función con la consulta
		//el primer arg es el formato de cada parámetro
		if(!$statement->bind_param("iss", $id, $fecha, $motivo))
		{
			die("Error en vinculación: (".$statement->errno.") ".$statement->error);
			return 0;
		}

		//Ejecutar inserción
		if(!$statement->execute())
		{
			die("Error en ejecución: (".$statement->errno.") ".$statement->error);
			return 0;
		}

		desconectar_bd($conexion_bd);
		return 1;
   }
   //Egresar un empleado
   function egresarEmpleado($id, $fechaEgreso, $motivoEgreso){
    $conexion_bd = conectar_bd();


    $estado="inactivo";
    $status = "2";
    //Prepara la consulta
    $dml_egresar = 'UPDATE empleado SET idStatus=(?), fegreso=(?), motivoegreso=(?), estado=(?) WHERE idEmpleado=(?)';

    if ( !($statement = $conexion_bd->prepare($dml_egresar)) ) {
        die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
        return 0;
    }
    //Unir los parámetros de la función con los parámetros de la consulta
    //El primer argumento de bind_param es el formato de cada parámetro

    if (!$statement->bind_param("isssi", $status,$fechaEgreso, $motivoEgreso, $estado, $id)) {

        die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
        return 0;
    }
   //Executar la consulta
    if (!$statement->execute()) {
        die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
        return 0;
    }
    desconectar_bd($conexion_bd);
    return 1;
   }

   //modificar a un medico
	function modificar_egresoEmpleado($idEmpleado, $fechaEgreso, $motivoEgreso){
		$conexion_bd = conectar_bd();

		//Prepara la consulta
		$dml_editar = 'UPDATE empleado SET fegreso=(?), motivoegreso=(?) WHERE idEmpleado=(?)';
		if ( !($statement = $conexion_bd->prepare($dml_editar)) ) {
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
		}

		//Unir los parámetros de la función con los parámetros de la consulta
		//El primer argumento de bind_param es el formato de cada parámetro
		if (!$statement->bind_param("ssi", $fechaEgreso, $motivoEgreso, $idEmpleado)) {
			die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		//Executar la consulta
		if (!$statement->execute()) {
		  die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		desconectar_bd($conexion_bd);
		  return 1;
	}


   //Reingresar un empleado
    function reingresarEmpleado($id, $fechaReingreso){
    $conexion_bd = conectar_bd();


    $status = "1";
   	$estado = "activo";
    //Prepara la consulta
    $dml_reingresar = 'UPDATE empleado SET fechaI=(?), estado=(?), idStatus=(?) WHERE idEmpleado=(?)';

    if ( !($statement = $conexion_bd->prepare($dml_reingresar)) ) {
        die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
        return 0;
    }
    //Unir los parámetros de la función con los parámetros de la consulta
    //El primer argumento de bind_param es el formato de cada parámetro

    if (!$statement->bind_param("ssii", $fechaReingreso, $estado, $status, $id)) {

        die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
        return 0;
    }
   //Executar la consulta
    if (!$statement->execute()) {
        die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
        return 0;
    }
    desconectar_bd($conexion_bd);
    return 1;
   }

   function agregar_empleado($nombre, $fechaNacimiento, $estadoNacimiento, $curp, $rfc, $segsocial, $direccion, $tel, $cel, $correo, $fechaI, $puesto, $voluntario, $diasT, $horaEntrada, $horaSalida, $estcivil, $escolaridad, $nbenef){
   		$conexion_bd = conectar_bd();
   		$status = "1";
   		$estado = "activo";
		//preparar consulta
		$dml_insertar = 'INSERT INTO empleado (idPuesto, idEstCivil, idStatus, idEstadoM, estado, nombre, fechaNacimiento, curp, rfc, segSocial, direccion, telefono, celular, correo, fechaI, ';
		$dml_insertar .= ' voluntario, diasT, horaEntrada, horaSalida, escolaridad, nBeneficiarios) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		if(!($statement = $conexion_bd->prepare($dml_insertar)))
		{
			die("Error: (".$conexion_bd->errno.") ".$conexion_bd->error);
			return 0;
		}


		//unir parámetros de la función con la consulta
		//el primer arg es el formato de cada parámetro
		if(!$statement->bind_param("iiiisssssisssssissssi", $puesto, $estcivil, $status, $estadoNacimiento,$estado, $nombre, $fechaNacimiento,  $curp, $rfc, $segsocial, $direccion, $tel, $cel, $correo, $fechaI, $voluntario, $diasT, $horaEntrada, $horaSalida, $escolaridad, $nbenef))
		{
			die("Error en vinculación: (".$statement->errno.") ".$statement->error);
			return 0;
		}

		//Ejecutar inserción
		if(!$statement->execute())
		{
			die("Error en ejecución: (".$statement->errno.") ".$statement->error);
			return 0;
		}

		desconectar_bd($conexion_bd);
		return 1;
   }

   function agregar_BN($nombreBN,$parentesco,$rfc,$direccion,$porcentaje,$id){
   		$conexion_bd = conectar_bd();

		//preparar consulta
		$dml_insertar = 'INSERT INTO beneficiarionomina (nombre, parentesco, rfc, direccion)';
		$dml_insertar .= ' VALUES (?, ?, ?, ?)';
		if(!($statement = $conexion_bd->prepare($dml_insertar)))
		{
			die("Error: (".$conexion_bd->errno.") ".$conexion_bd->error);
			return 0;
		}

		//unir parámetros de la función con la consulta
		//el primer arg es el formato de cada parámetro
		if(!$statement->bind_param("ssss", $nombreBN, $parentesco, $rfc, $direccion))
		{
			die("Error en vinculación: (".$statement->errno.") ".$statement->error);
			return 0;
		}

		//Ejecutar inserción
		if(!$statement->execute())
		{
			die("Error en ejecución: (".$statement->errno.") ".$statement->error);
			return 0;
		}

		//obtener el ultimo beneficiario insertado
		$idB = idLastRecord("beneficiarionomina","idBenefN");
		//insertar relacion
		//preparar consulta
		$dml_insertar = 'INSERT INTO benef_empleado ( idBenefN, idEmpleado, porcentaje)';
		$dml_insertar .= ' VALUES (?, ?, ?)';
		if(!($statement = $conexion_bd->prepare($dml_insertar)))
		{
			die("Error: (".$conexion_bd->errno.") ".$conexion_bd->error);
			return 0;
		}

		//unir parámetros de la función con la consulta
		//el primer arg es el formato de cada parámetro
		if(!$statement->bind_param("iid", $idB, $id, $porcentaje))
		{
			die("Error en vinculación: (".$statement->errno.") ".$statement->error);
			return 0;
		}

		//Ejecutar inserción
		if(!$statement->execute())
		{
			die("Error en ejecución: (".$statement->errno.") ".$statement->error);
			return 0;
		}
		sumarBN($id);
		desconectar_bd($conexion_bd);
		return 1;
   }

   function restarBN($idE=""){
   	 $conexion_bd = conectar_bd();
   	 $registrados = recuperar($idE, "empleado", "idEmpleado", "nBeneRegistrados");
   	 $registrados -= 1;
	 //Prepara la consulta
	 $dml_reingresar = 'UPDATE empleado SET nBeneRegistrados=(?) WHERE idEmpleado =(?)';

    if ( !($statement = $conexion_bd->prepare($dml_reingresar)) ) {
        die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
        return 0;
    }
    //Unir los parámetros de la función con los parámetros de la consulta
    //El primer argumento de bind_param es el formato de cada parámetro

    if (!$statement->bind_param("ii", $registrados, $idE)) {

        die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
        return 0;
    }
   //Executar la consulta
    if (!$statement->execute()) {
        die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
        return 0;
    }
    desconectar_bd($conexion_bd);
    return 1;
   }

   function sumarBN($idE=""){
   	 $conexion_bd = conectar_bd();
   	 $registrados = recuperar($idE, "empleado", "idEmpleado", "nBeneRegistrados");
   	 $registrados += 1;
	 //Prepara la consulta
	 $dml_reingresar = 'UPDATE empleado SET nBeneRegistrados=(?) WHERE idEmpleado =(?)';

    if ( !($statement = $conexion_bd->prepare($dml_reingresar)) ) {
        die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
        return 0;
    }
    //Unir los parámetros de la función con los parámetros de la consulta
    //El primer argumento de bind_param es el formato de cada parámetro

    if (!$statement->bind_param("ii", $registrados, $idE)) {

        die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
        return 0;
    }
   //Executar la consulta
    if (!$statement->execute()) {
        die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
        return 0;
    }
    desconectar_bd($conexion_bd);
    return 1;
   }

      function modificar_BN($nombreBN,$parentesco,$rfc,$direccion,$porcentaje,$id, $idBN){
   		$conexion_bd = conectar_bd();

		//preparar consulta
		$dml_insertar = 'UPDATE beneficiarionomina SET nombre=(?), parentesco=(?), rfc=(?), direccion=(?) WHERE idBenefN = (?)';
		if(!($statement = $conexion_bd->prepare($dml_insertar)))
		{
			die("Error: (".$conexion_bd->errno.") ".$conexion_bd->error);
			return 0;
		}

		//unir parámetros de la función con la consulta
		//el primer arg es el formato de cada parámetro
		if(!$statement->bind_param("ssssi", $nombreBN, $parentesco, $rfc, $direccion, $idBN))
		{
			die("Error en vinculación: (".$statement->errno.") ".$statement->error);
			return 0;
		}

		//Ejecutar inserción
		if(!$statement->execute())
		{
			die("Error en ejecución: (".$statement->errno.") ".$statement->error);
			return 0;
		}


		//insertar relacion
		//preparar consulta
		$dml_insertar = 'UPDATE benef_empleado set porcentaje = (?) WHERE idEmpleado=(?) AND idBenefN =(?)';

		if(!($statement = $conexion_bd->prepare($dml_insertar)))
		{
			die("Error: (".$conexion_bd->errno.") ".$conexion_bd->error);
			return 0;
		}

		//unir parámetros de la función con la consulta
		//el primer arg es el formato de cada parámetro
		if(!$statement->bind_param("dii", $porcentaje, $id, $idBN))
		{
			die("Error en vinculación: (".$statement->errno.") ".$statement->error);
			return 0;
		}

		//Ejecutar inserción
		if(!$statement->execute())
		{
			die("Error en ejecución: (".$statement->errno.") ".$statement->error);
			return 0;
		}

		desconectar_bd($conexion_bd);
		return 1;
   }

   function agregar_salario($salario,$compensaciones,$id,$infonavit){
   		$conexion_bd = conectar_bd();

		//preparar consulta
		$dml_insertar = 'INSERT INTO salario (idEmpleado,salarioDiario, compensacion)';
		$dml_insertar .= ' VALUES (?, ?,?)';
		if(!($statement = $conexion_bd->prepare($dml_insertar)))
		{
			die("Error: (".$conexion_bd->errno.") ".$conexion_bd->error);
			return 0;
		}

		//unir parámetros de la función con la consulta
		//el primer arg es el formato de cada parámetro
		if(!$statement->bind_param("idd", $id, $salario, $compensaciones))
		{
			die("Error en vinculación: (".$statement->errno.") ".$statement->error);
			return 0;
		}

		//Ejecutar inserción
		if(!$statement->execute())
		{
			die("Error en ejecución: (".$statement->errno.") ".$statement->error);
			return 0;
		}
		actualizarInfonavit($infonavit,$id);
		desconectar_bd($conexion_bd);
		return 1;
   }

   function actualizarInfonavit($infonavit,$id){
   	//actualizar el infonavit
   		$conexion_bd = conectar_bd();
		//preparar consulta
		$dml_insertar = 'UPDATE empleado SET infonavit=(?) WHERE idEmpleado=(?)';
		if(!($statement = $conexion_bd->prepare($dml_insertar)))
		{
			die("Error: (".$conexion_bd->errno.") ".$conexion_bd->error);
			return 0;
		}

		//unir parámetros de la función con la consulta
		//el primer arg es el formato de cada parámetro
		if(!$statement->bind_param("ii", $infonavit, $id))
		{
			die("Error en vinculación: (".$statement->errno.") ".$statement->error);
			return 0;
		}

		//Ejecutar inserción
		if(!$statement->execute())
		{
			die("Error en ejecución: (".$statement->errno.") ".$statement->error);
			return 0;
		}

		desconectar_bd($conexion_bd);
		return 1;
   }

   function agregar_voluntario($nombre,$fechaNacimiento,$estadoNacimiento,$curp, $rfc,$segsocial,$direccion,$tel,$cel,$correo,$fechaI,$puesto,$voluntario,$diasT,$horaEntrada, $horaSalida){
   	   	$conexion_bd = conectar_bd();
   		$status = "1";
   		$estado = "activo";
   		$estadocivil="1";
		//preparar consulta
		$dml_insertar = 'INSERT INTO empleado (idPuesto, idEstCivil, idStatus, estado, nombre, fechaNacimiento, estadoNacimiento, curp, rfc, segSocial, direccion, telefono, celular, correo, fechaI, ';
		$dml_insertar .= ' voluntario, diasT, horaEntrada, horaSalida) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		if(!($statement = $conexion_bd->prepare($dml_insertar)))
		{
			die("Error: (".$conexion_bd->errno.") ".$conexion_bd->error);
			return 0;
		}


		//unir parámetros de la función con la consulta
		//el primer arg es el formato de cada parámetro
		if(!$statement->bind_param("iiissssssisssssisss", $puesto, $estadocivil, $status, $estado, $nombre, $fechaNacimiento, $estadoNacimiento, $curp, $rfc, $segsocial, $direccion, $tel, $cel, $correo, $fechaI, $voluntario, $diasT, $horaEntrada, $horaSalida))
		{
			die("Error en vinculación: (".$statement->errno.") ".$statement->error);
			return 0;
		}

		//Ejecutar inserción
		if(!$statement->execute())
		{
			die("Error en ejecución: (".$statement->errno.") ".$statement->error);
			return 0;
		}

		desconectar_bd($conexion_bd);
		return 1;
   }

	//obtiene el id del ultimo registro en la tabla

	function idLastRecord($tabla,$id){
		$conexion_bd = conectar_bd();

		$consulta = "SELECT $id FROM $tabla ORDER BY $id DESC LIMIT 1";
		$resultados = $conexion_bd->query($consulta);
			while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
				desconectar_bd($conexion_bd);
				return $row["$id"];
			}

		desconectar_bd($conexion_bd);
		return 0;
	}

	//obtiene el id del ultimo registro en la tabla

	function ultimoSalario($id){
		$conexion_bd = conectar_bd();

		$consulta = "SELECT salarioDiario as salario FROM salario WHERE idEmpleado = ".$id." ORDER BY fecha DESC LIMIT 1";
		$resultados = $conexion_bd->query($consulta);
			while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
				desconectar_bd($conexion_bd);
				return $row["salario"];
			}

		desconectar_bd($conexion_bd);
		return 0;
	}




//------------------------------------------------------------
 //        --- INICIAR SESION---
//-------------------------------------------------------------

	  // funcion para checar la contraseña

 function getQuery($user){
      $conexion_bd = conectar_bd();
      $query = "SELECT password FROM usuario WHERE usuario='$user'";

    $result = mysqli_query($conexion_bd, $query);
      while($row=mysqli_fetch_array($result,MYSQLI_BOTH)){
        $password["password"]= $row["password"];

      }

      mysqli_free_result($result);
      desconectar_bd($conexion_bd);

      return $password["password"];
}

//------------------------------------------------------------
 //        --- CUENTAS---
//-------------------------------------------------------------

  function autenticar_bd($username, $password)
  {
    $conexion_bd = conectar_bd();
    $query = "SELECT p.nombre as per, u.nombre as nom, u.id as id
              FROM usuario u, desempenia d, rol r, obtiene o, permiso p
              WHERE u.id = d.usuario_id
              AND d.rol_id = r.id
              AND o.rol_id = r.id
              AND o.permiso_id = p.id
              AND u.usuario = '$username'
              AND u.password = '$password'";

    $result = mysqli_query($conexion_bd, $query);
    while ($row = mysqli_fetch_array($result, MYSQLI_BOTH)) {
      if($row["per"] == "registrar")
      {
        $_SESSION["registrar"] = 1;
      }
      if($row["per"] == "ver")
      {
        $_SESSION["ver"] = 1;
      }
      if($row["per"] == "administrar")
      {
        $_SESSION["administrar"] = 1;
      }
      $_SESSION["nombre"] = $row["nom"];
      $_SESSION["idUsuario"] = $row["id"];


    }

    desconectar_bd($conexion_bd);

  }

  //busquedas usuarios

	function consultar_u($rol="",$idU="", $nombre=""){
			$conexion_bd = conectar_bd();

		$resultado="<br/><table class='table table-hover table-striped table-responsive-md btn-table'><thead><tr><th>Nombre</th><th>Usuario</th><th>Rol</th><th>Opciones</th></tr></thead>";


				$consulta = 'SELECT u.id as id, u.usuario as usuario, u.nombre as nombre, r.nombre as rol';
		$consulta .= ' FROM usuario as u, desempenia as d, rol as r';
		$consulta .= ' WHERE u.id=d.usuario_id AND r.id=d.rol_id';

		if ($rol != "") {
				$consulta .= " AND d.rol_id=".$rol;
			}

			if($idU != ""){
				$consulta .= ' AND d.usuario_id = '.$idU;
			}
			if($nombre != "")
				$consulta .= ' AND u.nombre LIKE "%'.$nombre.'%" ';

			$consulta .= ' ORDER BY u.id';


		$resultados = $conexion_bd->query($consulta);

			while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {

			$resultado .= "<tr>";
			$resultado .= "<td>".$row['nombre']."</td>";
			$resultado .= "<td>".$row['usuario']."</td>"; //o el nombre de la columna

			$resultado .= "<td>".$row['rol']."</td>";
			$resultado .= "<td>"."<a class='btn btn-outline-secondary'href='../controladores/controlador_editarU.php?id=".$row['id']."'class='btn btn-outline-secondary' data-tooltip='tooltip' title='Modificar' data-placement='top'><i class='fas fa-pencil-alt'></i></a>";
			$resultado .= "    ";
					$resultado .= "    ";
				$tituloModal = str_replace(' ', ' ', $row['usuario']);
			$resultado .= "<a class='btn btn-outline-danger' data-toggle='modal' href='#".$tituloModal."'class='btn btn-outline-danger'><i class='fas fa-trash-alt' data-tooltip='tooltip' title='Egresar' data-placement='top'></i></a>";

			include("../usuarios/modalEliminarUsuario.html");
			$resultado .= "</tr>";


		}

		mysqli_free_result($resultados); //Liberar la memoria

		desconectar_bd($conexion_bd);

		$resultado .= "</tbody></table>";
		return $resultado;
	}

	function consultar_porRol($rol=""){
			$conexion_bd = conectar_bd();

		$resultado="<br/><table class='table table-hover table-striped table-responsive-md btn-table'><thead><tr><th>Nombre</th><th>Usuario</th><th>Rol</th><th>Opciones</th></tr></thead>";


				$consulta = 'SELECT u.id as id, u.usuario as usuario, u.nombre as nombre, r.nombre as rol';
		$consulta .= ' FROM usuario as u, desempenia as d, rol as r';
		$consulta .= ' WHERE u.id=d.usuario_id ';

		if ($rol != "") {
				$consulta .= " AND r.id=d.rol_id=".$rol;
			}
			$consulta .= ' ORDER BY u.id';


		$resultados = $conexion_bd->query($consulta);

			while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {

			$resultado .= "<tr>";
			$resultado .= "<td>".$row['nombre']."</td>";
			$resultado .= "<td>".$row['usuario']."</td>"; //o el nombre de la columna

			$resultado .= "<td>".$row['rol']."</td>";
			$resultado .= "<td>"."<a href='../controladores/controlador_editarU.php?id=".$row['id']."'><i class='fas fa-pencil-alt'></i></a>";
				$tituloModal = str_replace(' ', ' ', $row['usuario']);
			$resultado .= "<a class='btn' data-toggle='modal' data-target='#".$tituloModal."'>";
			$resultado.="<i class='fas fa-trash-alt'></i></button>"."</td>";
			include("../usuarios/modalEliminarUsuario.html");
			$resultado .= "</tr>";

		}

		mysqli_free_result($resultados); //Liberar la memoria

		desconectar_bd($conexion_bd);

		$resultado .= "</tbody></table>";
		return $resultado;
	}

	function insertar_usuario($usuario,$password,$nombre,$rol) {
		$conexion_bd = conectar_bd();

		//Prepara la consulta
		$dml = 'INSERT INTO usuario (usuario,password,nombre) VALUES (?,?,?)';
		if ( !($statement = $conexion_bd->prepare($dml)) ) {
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
		}

		//Unir los parámetros de la función con los parámetros de la consulta
		//El primer argumento de bind_param es el formato de cada parámetro
		if (!$statement->bind_param("sss", $usuario, $password, $nombre)) {
			die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		//Executar la consulta
		if (!$statement->execute()) {
		die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		//************
		//***Insertar el rol****
		//************

		//obtener el id del usuario
		$resultados = $conexion_bd->query("SELECT * from usuario ORDER BY id DESC LIMIT 1");
		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
			$resultado = $row["id"];
		}
		$id_u = $resultado;



		//insercion del rol en la bd
		$dml = 'INSERT INTO desempenia (usuario_id,rol_id) VALUES (?,?)';
		if ( !($statement = $conexion_bd->prepare($dml)) ) {
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
		}

		//Unir los parámetros de la función con los parámetros de la consulta
		//El primer argumento de bind_param es el formato de cada parámetro
		if (!$statement->bind_param("ii", $id_u, $rol)) {
			die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		//Executar la consulta
		if (!$statement->execute()) {
		die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		desconectar_bd($conexion_bd);
		return 1;
	}

	//consultar cuentas
	function consultar_usuarios() {
		$conexion_bd = conectar_bd();

		$resultado =  "<br/><table class='table table-hover table-striped table-responsive-md btn-table'><thead><tr><th>Nombre</th><th>Usuario</th><th>Rol</th><th>Acciones</th></tr></thead>";

		$consulta = 'SELECT u.id as id, u.usuario as usuario, u.nombre as nombre, r.nombre as rol';
		$consulta .= ' FROM usuario as u, desempenia as d, rol as r';
		$consulta .= ' WHERE u.id=d.usuario_id AND r.id=d.rol_id';
		$consulta .= ' ORDER BY u.id';


		$resultados = $conexion_bd->query($consulta);


		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {

			$resultado .= "<tr>";
			$resultado .= "<td>".$row['nombre']."</td>";
			$resultado .= "<td>".$row['usuario']."</td>"; //o el nombre de la columna

			$resultado .= "<td>".$row['rol']."</td>";
			$resultado .= "<td>"."<a class='btn btn-outline-secondary'href='../controladores/controlador_editarU.php?id=".$row['id']."'class='btn btn-outline-secondary' data-tooltip='tooltip' title='Modificar' data-placement='top'><i class='fas fa-pencil-alt'></i></a>";
				$tituloModal = str_replace(' ', ' ', $row['usuario']);
			$resultado .= "<a class='btn btn-outline-danger' data-toggle='modal' href='#".$tituloModal."'class='btn btn-outline-danger'><i class='fas fa-trash-alt' data-tooltip='tooltip' title='Egresar' data-placement='top'></i></a>";


			include("modalEliminarUsuario.html");
			$resultado .= "</tr>";


		}

		mysqli_free_result($resultados); //Liberar la memoria

		desconectar_bd($conexion_bd);

		$resultado .= "</tbody></table>";
		return $resultado;
	}





	//Consultar un campo de una tabla a partir de su llave
	//$llave es el valor de la llave del registro que se quiere recuperar
	//$tabla es el nombre de la tabla pasado como string
	//$nombreLlave es el nombre de la llave de la tabla (como aparece en la bd) pasado como string
	//$campo es el nombre del campo que se quiere recuperar (como aparece en la bd) pasado como string
	function recuperar_dos_llaves($llaveuno, $llavedos, $tabla, $nombreLlaveuno, $nombrellavedos, $campo) {

	 $conexion_bd = conectar_bd();

	 $consulta = "SELECT $campo as campo FROM $tabla WHERE $nombreLlaveuno ='$llaveuno' and $nombrellavedos ='$llavedos'";

	 $resultados = $conexion_bd->query($consulta);
	 while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
		 return  $row['campo'];

	 }

	 desconectar_bd($conexion_bd);
	 return 0;
	 }


    function editar_usuario($idUsuario,$usuario,$password,$nombre,$rol) {
    $conexion_bd = conectar_bd();

    //Prepara la consulta
    $dml = 'UPDATE usuario SET usuario=(?), password=(?), nombre= (?) WHERE id=(?)';
    if ( !($statement = $conexion_bd->prepare($dml)) ) {
        die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
        return 0;
    }

    //Unir los parámetros de la función con los parámetros de la consulta
    //El primer argumento de bind_param es el formato de cada parámetro
    if (!$statement->bind_param("sssi", $usuario, $password, $nombre, $idUsuario)) {
        die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
        return 0;
    }

    //Executar la consulta
    if (!$statement->execute()) {
      die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
        return 0;
    }


    //editar rol en la bd
    $dml = 'UPDATE desempenia SET rol_id=(?) WHERE usuario_id =(?)';
    if ( !($statement = $conexion_bd->prepare($dml)) ) {
        die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
        return 0;
    }

    //Unir los parámetros de la función con los parámetros de la consulta
    //El primer argumento de bind_param es el formato de cada parámetro
    if (!$statement->bind_param("ii", $rol, $idUsuario)) {
        die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
        return 0;
    }

    //Executar la consulta
    if (!$statement->execute()) {
      die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
        return 0;
    }
    $_SESSION["Usuario"] = $usuario;
    $_SESSION["Contraseña"] = $password;
    $_SESSION["nombre"] = $nombre;
    autenticar_bd($usuario, $password);
    desconectar_bd($conexion_bd);
      return 1;
  }

  	//Eliminar a un usuario
	function eliminar_cuentaE($idUsuario){
		$conexion_bd = conectar_bd();

		//preparar la consulta para borrar de la tabla usuario
		$dml2_eliminar = 'DELETE FROM usuario WHERE id=(?)';
		if ( !($statement = $conexion_bd->prepare($dml2_eliminar))) {
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
		}

		//Unir los parámetros de la función con los parámetros de la consulta
		//El primer argumento de bind_param es el formato de cada parámetro
		if (!$statement->bind_param("i", $idUsuario)) {
			die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		//Executar la consulta
		if (!$statement->execute()) {
		  die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		desconectar_bd($conexion_bd);
		return 1;

	}



	//editar usuario personal

	function editar_usuarioP($idUsuario,$password) {
	$conexion_bd = conectar_bd();

	//Prepara la consulta
	$dml = 'UPDATE usuario SET password=(?) WHERE id=(?)';
	if ( !($statement = $conexion_bd->prepare($dml)) ) {
		die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
		return 0;
	}

	//Unir los parámetros de la función con los parámetros de la consulta
	//El primer argumento de bind_param es el formato de cada parámetro
	if (!$statement->bind_param("si", $password, $idUsuario)) {
		die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
		return 0;
	}

	//Executar la consulta
	if (!$statement->execute()) {
	die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
		return 0;
	}


	$_SESSION["Contraseña"] = $password;

	// autenticar_bd($usuario, $password);
	desconectar_bd($conexion_bd);
	return 1;
	}

	//editar cuenta personal
	function editar_usuarioPer($idUsuario, $pass) {
	$conexion_bd = conectar_bd();

	//Prepara la consulta
	$dml = 'UPDATE usuario SET password=(?) WHERE id=(?)';
	if ( !($statement = $conexion_bd->prepare($dml)) ) {
		die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
		return 0;
	}

	//Unir los parámetros de la función con los parámetros de la consulta
	//El primer argumento de bind_param es el formato de cada parámetro
	if (!$statement->bind_param("si", $pass, $idUsuario)) {
		die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
		return 0;
	}

	//Executar la consulta
	if (!$statement->execute()) {
	die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
		return 0;
	}


	$_SESSION["Contraseña"] = $pass;

	// autenticar_bd($usuario, $password);
	desconectar_bd($conexion_bd);
	return 1;
	}

	function recuperar_id($user) {

		$conexion_bd = conectar_bd();


		$consulta = "SELECT id FROM usuario WHERE usuario ='$user'";
		$resultados = $conexion_bd->query($consulta);
		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
			desconectar_bd($conexion_bd);
			return $row["id"];
		}

		desconectar_bd($conexion_bd);
		return 0;
	}

	function recuperar_idC($pass) {


		$conexion_bd = conectar_bd();

		$consulta = "SELECT id FROM usuario WHERE password ='$pass'";
		$resultados = $conexion_bd->query($consulta);
		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
			desconectar_bd($conexion_bd);
			return $row["id"];
		}

		desconectar_bd($conexion_bd);
		return 0;
	}

	function buscarUsuarioRepetido($user){
		$conexion_bd = conectar_bd();

		$busqueda="SELECT * FROM usuario WHERE usuario='$user'";
		$resultados = mysqli_query($conexion_bd,$busqueda);

		if(mysqli_num_rows($resultados)>0){
			return 1;

		}else{
			return 0;
		}

		desconectar_bd($conexion_bd);

	}




//------buscarUsuario---------------------------------------------------------
//-----------------------------PRUEBAS---------------------------
//---------------------------------------------------------------

	// Recuperar areas y actividades del banco de datos de pruebas y generar tabla
	function crear_tabla_prueba ($idseccion, $idprueba) {
		$conexion_bd = conectar_bd();

	$nombreseccion = recuperar($idseccion, "seccion", "ID", "nombre");
	$nombreCat = recuperar($idseccion, "seccion", "ID", "categoria");
	$resultado = " <div class='d-flex flex-row justify-content-center'>
	    						<h3>".$nombreCat."</h3></div>";
	$resultado .= "<input type='hidden' name='seccionActual' id='seccionActual' value='".$idseccion."'>
								<table class='table table-borderless'>
										<thead>
											<tr>
												<td scope='col'>#</td>
												<th scope='col'>".$nombreseccion."</th>
												<th scope='col' title='No lo logra'><i class='material-icons fails'>close</i></th>
												<th scope='col' title='En proceso'><i class='material-icons tries'>hourglass_empty</i></th>
												<th scope='col' title='Lo logra'><i class='material-icons succeed'>check</i></th>
												<th scope='col'><a style='color: white;' title='Agregar observacion sección' data-toggle='modal'  href='#ModalSec".$idseccion."' class='btn btn-outline'> <i class='material-icons'>comment</i></a>";

												$observacion = recuperar_observ_seccion($idprueba, $_SESSION["benefactual"], $idseccion);
												if ($observacion != "") {
													$resultado .= "<i class='material-icons'>check</i>";
												}

											$resultado .= "</th>
											</tr>
										</thead>";

	$consulta = "SELECT nombre_actividad, id_prueba, id_beneficiaria, v.id_seccion as vsec, v.id_actividad as vact, calificacion from actividad a, valorar_actividad v WHERE a.ID = v.id_actividad and v.id_seccion = ".$idseccion." and id_prueba = ".$idprueba;

	$consulta = "SELECT nombre_actividad, vac.id_prueba as vacprueba, vac.id_beneficiaria as vacbenef, vac.id_seccion as vsec, vac.id_actividad as vact, calificacion, vac.observacion as actobserv, vsec.observacion as secobserv, s.nombre as nombreSeccion from actividad a, valorar_actividad vac, valorar_seccion vsec, seccion s WHERE s.ID = vsec.id_seccion and a.ID = vac.id_actividad and vsec.id_seccion = vac.id_seccion and vac.id_prueba = vsec.id_prueba and vac.id_beneficiaria = vsec.id_beneficiaria and vac.id_prueba =".$idprueba." and vac.id_seccion = ".$idseccion;

	$array = array();
	$i = 1;
	$idSeccionPrevia = 0;
	$idSeccionActual = 0;

	$resultados = $conexion_bd->query($consulta);
	while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
		$idSeccionActual = $row['vsec'];
			$resultado .= "<tr>

				<td scope='row'>".$i."</td>
				<td>".$row['nombre_actividad']."</td>
				<td>
					<div class='form-check form-check-inline'>
						<input class='form-check-input' type='radio' name='".$row['vacprueba'].$row['vacbenef'].$row['vsec'].$row['vact']."' ";
						if ($row['calificacion'] == 1) {
							$resultado .= "checked";
						}
						$resultado .= " value=1>

					</div>
				</td>
				<td>
					<div class='form-check form-check-inline'>
					<input class='form-check-input' type='radio' name='".$row['vacprueba'].$row['vacbenef'].$row['vsec'].$row['vact']."' ";
					if ($row['calificacion'] == 2) {
						$resultado.= "checked";
					}
					$resultado .= " value=2>
					</div>
				</td>
				<td>
					<div class='form-check form-check-inline'>
					<input class='form-check-input' type='radio' name='".$row['vacprueba'].$row['vacbenef'].$row['vsec'].$row['vact']."' ";
					if ($row['calificacion'] == 3) {
						$resultado.= "checked";
					}
					$resultado .= " value=3>
					</div>
				</td>
				<td>
				<a title='Agregar observacion actividad' data-toggle='modal'  href='#ModalAct".$row['vact']."' class='btn btn-outline'> <i class='material-icons'>comment</i></a>";
				if (isset($row['actobserv'])) {
					$resultado .= "<i class='material-icons'>check</i>";
				}

				$resultado .= "</td>
										</tr>";
			$i += 1;
			$resultado .= "</tr> ";

			array_push($array,$row['vacprueba'].$row['vacbenef'].$row['vsec'].$row['vact']." ");

			include("pruebas/_modal_observacion_act.html");

			if ($idSeccionPrevia !== $idSeccionActual) {
				include("pruebas/_modal_observacion_sec.html");
			}

			$idSeccionPrevia = $idSeccionActual;

	}
			$idBeneficiaria =	$_SESSION["benefactual"];
			$porcentaje_completado = calcular_porcentaje_prueba($idBeneficiaria, $idprueba);
			$resultado .= "<input type='hidden' name='cantPruebaComplt' id='cantPruebaComplt' value='".round($porcentaje_completado, 1)."'>";
			$resultado .= "<input type='hidden' name='contadorAct' id='contadorAct' value='".($i-1)."'>";
			$resultado .= "<input type='hidden' name='pondrAct' id='pondrAct' value='".implode($array)."'>";

			$fechaNac = recuperar($_SESSION["benefactual"], "beneficiarias", "idBeneficiaria", "fechaNacimiento");
			$today = date("Y-m-d");
			$diff = date_diff(date_create($fechaNac), date_create($today));
			$edad = $diff->format('%y');
			$resultado .= "<input type='hidden' name='edadBenef' id='edadBenef' value='".$edad."'>";


		mysqli_free_result($resultados); //Liberar la memoria

		desconectar_bd($conexion_bd);
		$resultado .= "</tbody></table>";
		return $resultado;
	}

	function sanitize($s) {
	return htmlspecialchars($s);
	}

	function recuperar_observ_seccion($idprueba, $idbenef, $idseccion) {

	 $conexion_bd = conectar_bd();

	 $consulta = "SELECT observacion FROM valorar_seccion WHERE id_prueba ='$idprueba' and id_beneficiaria ='$idbenef' and id_seccion ='$idseccion'";

	 $resultados = $conexion_bd->query($consulta);
	 while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
		 return  $row['observacion'];
	 }

	 desconectar_bd($conexion_bd);
	 return 0;
	 }


	function crear_modal($act=0, $sec=0) {
		$conexion_bd = conectar_bd();

		$consulta = 'SELECT ';
		if ($act != 0) {
			$consulta .= 'nombre_actividad from actividad where ID ='.$act;
		} else if ($sec != 0) {
			$consulta .= 'nombre from seccion where ID ='.$sec;
		}

		$resultado = '';

		$resultados = $conexion_bd->query($consulta);
		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
			$resultado .= "<label class='mr-3 ml-3 mt-3 mb-3' for='ejemplo'>Descripción de actividad/seccion: ";
			if ($act != 0) {
				$resultado .= $row['nombre_actividad'];
			} else if ($sec != 0) {
				$resultado .= $row['nombre'];
			}
				$resultado .= "</label>";

		}

		$resultado .= " <br>
								<div class='dflex flex-row'>
								<div class='form-group'>
									<textarea class='form-control mr-auto ml-auto texti' size='1' aria-label='textarea' id='textobservacion' rows='3'></textarea>
								</div>
								</div>
							</div>";

		mysqli_free_result($resultados); //Liberar la memoria
		desconectar_bd($conexion_bd);
		return $resultado;
	}

	//Generar card de beneficiaria
	function crear_card_beneficiaria ($idBeneficiaria) {
		$conexion_bd = conectar_bd();


		$pathImagen = obtenerImagen($idBeneficiaria.'_imagenIngreso_');

		$stringpath = '"../beneficiarias/avatar.jpg"';

			$resultado = "<div class='row d-flex justify-content-center '>
											<div class='card mb-3 border-top-0 border-left-0 col-xs-4 cardCompleta'>
												<div class='row no-gutters'>
													<div class='col-md-4'>
														<img src='../beneficiarias/archivosBeneficiarias/".$pathImagen."' class='card-img rounded-circle foto-prueba' alt='Imagen de Ingreso'";
						$resultado .= " onerror='this.onerror=null;this.src=".$stringpath.";'>
													</div>
													<div class='col-8'>
														<div class='card-body'>";

		$consulta = 'SELECT nombreCompleto, detalleDiagnostico, diagnosticoMotriz, fechaNacimiento, fechaIngreso from beneficiarias where idBeneficiaria = '.$idBeneficiaria;
		$resultados = $conexion_bd->query($consulta);
		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {

			if (isset($_SESSION["enPrueba"]) && $_SESSION["enPrueba"] == 1) {
					$resultado .= "<h5 class='card-title'><a style='color:#F0037F;' data-toggle='modal' data-target='.modalBeneficiaria' id='linkBeneficiaria' href='' >".$row['nombreCompleto']."</a></h5>";
			} else {
				$resultado .= "<h5 class='card-title'><a style='color:#F0037F;' href='../beneficiarias/verBeneficiaria.php?idBeneficiaria=".$idBeneficiaria."'>".$row['nombreCompleto']."</a></h5>";
			}
			$resultado .= "<p class='card-text' style='color:#0A0D52;'> ";
			$fechaNac = $row["fechaNacimiento"];
			$today = date("Y-m-d");
			$diff = date_diff(date_create($fechaNac), date_create($today));
			$edad = $diff->format('%y');

			$resultado .= "Edad: ".$edad." años";

			$resultado .= "<br>DX Intelectual: ";
			if (isset($row['detalleDiagnostico'])) {
				$resultado .= $row['detalleDiagnostico'];
			} else {
				$resultado .= "Sin información";
			}
			$resultado .= "<br>DX Motriz: ";
			if (isset($row['diagnosticoMotriz'])) {
				$resultado .= $row['diagnosticoMotriz'];
			} else {
				$resultado .= "Sin información";
			}


				$row['fechaIngreso'] = (new DateTime($row['fechaIngreso']))->format('d-m-Y');
				$resultado .= "<p class='card-text'><small class='text-muted'>Fecha de ingreso: ".$row['fechaIngreso']."</small></p>";

		}

		$resultado .= "</div></div></div></div></div>";
		mysqli_free_result($resultados); //Liberar la memoria
		desconectar_bd($conexion_bd);
		return $resultado;
	}

	//Generar card para mostrar las diferentes pruebas de una beneficiaria
	function crear_card_pruebas_disponibles ($idBeneficiaria, $idprueba, $numPruebas) {
		$conexion_bd = conectar_bd();

		$verificar_prueba_terminada = recuperar($idprueba, "valorar_seccion", "id_prueba", "terminada");

		$resultado = "<div class='p-2 mr-2 ml-2'>
									<div class='card'>";

		$consulta = 'SELECT fecha, evaluador from valorar_seccion where id_beneficiaria ='.$idBeneficiaria.' and id_prueba ='.$idprueba.' limit 1';
		$resultados = $conexion_bd->query($consulta);
		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
			$fecha = convertir_fecha($row['fecha']);
			$resultado .= "<h5 class='card-header cardMostrarPrueba'>&nbsp ";
			if ($numPruebas >= 2) {
				$resultado .= '<input class="form-check-input" type="checkbox" value="'.$idprueba.'" name="cardPruebas" id="cardPruebas">';
			}
			$resultado .= '<input type="hidden" name="fechaPruebas" id="fechaPruebas" value="'.$row["fecha"].'">';

			$resultado .= " ".$fecha."</h5>";
			$resultado .= "<div class='card-body cardCompleta'>
									<h5 class='card-title elegirPrueba'>Evaluador: ".$row['evaluador']."</h5>";
		}

		$resultado .= "<div class='d-flex justify-content-center'>
													<div class='p-2'>
														<p class='card-text'>Porcentaje de la <br>prueba completada</p>
													</div>
													<div class='p-2'>
														<br>";

		if ($verificar_prueba_terminada == 0) {
			$porcentaje_completado = calcular_porcentaje_prueba($idBeneficiaria, $idprueba);
			$resultado .= "<h5>".round($porcentaje_completado, 1)."%</h5>";
		}
		else {
			$resultado .= "<h5>TERMINADA</h5>";
		}
		$resultado .=     	 "</div>
										</div>
										<br>
										<div class='d-flex justify-content-end'>
											<a href='controller_verPrueba.php?prueb=".$idprueba."' class='btn btn-outline-black btnEmpezarPrueba'>Ver Prueba</a>
										</div>
										</div>
									</div>
									</div>";


		desconectar_bd($conexion_bd);
		mysqli_free_result($resultados); //Liberar la memoria
		return $resultado;
	}

	function prueba_terminada ($idprueba) {
		$conexion_bd = conectar_bd();

		//Prepara la consulta
		$dml = 'UPDATE valorar_seccion SET terminada=(?) WHERE id_prueba=(?)';

		if ( !($statement = $conexion_bd->prepare($dml)) ) {
				die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
				return 0;
		}
		$terminado = 1;

		//Unir los parámetros de la función con los parámetros de la consulta
		//El primer argumento de bind_param es el formato de cada parámetro
		if (!$statement->bind_param("ii", $terminado, $idprueba)) {
				die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
				return 0;
		}

		//Executar la consulta
		if (!$statement->execute()) {
			die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
				return 0;
		}
		desconectar_bd($conexion_bd);
	}

	function prueba_NO_terminada ($idprueba) {
		$conexion_bd = conectar_bd();

		//Prepara la consulta
		$dml = 'UPDATE valorar_seccion SET terminada=(?) WHERE id_prueba=(?)';

		if ( !($statement = $conexion_bd->prepare($dml)) ) {
				die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
				return 0;
		}
		$terminado = 0;

		//Unir los parámetros de la función con los parámetros de la consulta
		//El primer argumento de bind_param es el formato de cada parámetro
		if (!$statement->bind_param("ii", $terminado, $idprueba)) {
				die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
				return 0;
		}

		//Executar la consulta
		if (!$statement->execute()) {
			die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
				return 0;
		}
		desconectar_bd($conexion_bd);
	}

	function eliminar_prueba ($idprueba) {
		$conexion_bd = conectar_bd();

		//ELIMINAR DE VALORAR SECCION
		$dml_eliminar_sec = 'DELETE FROM valorar_seccion WHERE id_prueba=(?)';
		if ( !($statement = $conexion_bd->prepare($dml_eliminar_sec)) ) {
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
		}

		//Unir los parámetros de la función con los parámetros de la consulta
		//El primer argumento de bind_param es el formato de cada parámetro
		if (!$statement->bind_param("i", $idprueba)) {
			die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		//Executar la consulta
		if (!$statement->execute()) {
			die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		//ELIMINAR DE VALORAR ACTIVIDAD
		$dml_eliminar_act = 'DELETE FROM valorar_actividad WHERE id_prueba=(?)';
		if ( !($statement = $conexion_bd->prepare($dml_eliminar_act)) ) {
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
		}

	//Unir los parámetros de la función con los parámetros de la consulta
	//El primer argumento de bind_param es el formato de cada parámetro
	if (!$statement->bind_param("i",$idprueba)) {
			die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
			return 0;
	}

	//Executar la consulta
	if (!$statement->execute()) {
		die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
			return 0;
	}

	desconectar_bd($conexion_bd);
		return 1;
}


function recuperar_pruebas($idBeneficiaria) {
	$conexion_bd = conectar_bd();
	$resultado = array();
	$consulta = 'SELECT distinct id_prueba from valorar_actividad where id_beneficiaria ='.$idBeneficiaria;
	$resultados = $conexion_bd->query($consulta);
	while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
		array_push($resultado, $row['id_prueba']);
	}

	desconectar_bd($conexion_bd);
	mysqli_free_result($resultados);
	return $resultado;
}

function convertir_fecha ($fecha) {
	$fecha = explode(" ", $fecha, 2);
	$fecha =  explode("-", $fecha[0], 3);
	setlocale(LC_TIME, 'es_ES');
	$mes = $fecha[1];
	$dateObj = DateTime::createFromFormat('!m', $mes);
	// Store the month name to variable
	$mes = strftime("%B", $dateObj->getTimestamp());


	return $fecha[2]." de ".$mes." del ".$fecha[0];
}




function recuperar_seccion_json ($idprueba, $idseccion) {
	$conexion_bd = conectar_bd();


	$consulta = 'SELECT s.nombre as nomsec, vs.calificacion_seccion as calif from valorar_seccion vs, seccion s where vs.id_prueba = '.$idprueba.' AND vs.id_seccion = s.ID and vs.id_seccion ='.$idseccion;
;
	$resultados = $conexion_bd->query($consulta);
	while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
		$resultado = '{"name":"'.$row["nomsec"].'","color":"';
			 if ($row["calif"] == 0) {
			 	$resultado .= '#dcdcdd';
			} elseif ($row["calif"] == 1) {
				$resultado .= '#ffadad';
			} elseif ($row["calif"] == 2) {
				$resultado .= '#ffd6a5';
			} elseif ($row["calif"] == 3) {
				$resultado .= '#caffbf';
			}
			 $resultado .= '","children":[';
	}

	desconectar_bd($conexion_bd);
	mysqli_free_result($resultados);
	return $resultado;
}



function recuperar_actividades_json($idprueba, $idseccion) {
	$conexion_bd = conectar_bd();

	$resultado = recuperar_seccion_json ($idprueba, $idseccion);

	// $resultado .= '{';

	$consulta = 'SELECT a.nombre_actividad as nomact, va.calificacion as calif from actividad a, valorar_actividad va where va.id_prueba = '.$idprueba.' AND va.id_actividad = a.ID and va.id_seccion ='.$idseccion;

	$resultados = $conexion_bd->query($consulta);

	while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {

		$resultado .= '{"name":"'.$row["nomact"].'","size":10,"color":"';
			 if ($row["calif"] == 0) {
			 	$resultado .= '#dcdcdd';
			} elseif ($row["calif"] == 1) {
				$resultado .= '#ffadad';
			} elseif ($row["calif"] == 2) {
				$resultado .= '#ffd6a5';
			} elseif ($row["calif"] == 3) {
				$resultado .= '#caffbf';
			}
			$resultado .= '"},';

	}
	//Se elimina la ultima coma del resultado
	$resultado = substr($resultado, 0, -1);
	$resultado .= ']},';

	desconectar_bd($conexion_bd);
	mysqli_free_result($resultados);
	return $resultado;
}



//Actualiza los datos del plan de seguimiento de la beneficiaria, ingresando sus logros y $prerequisito con base en la llave primaria
function llenar_plan_seguimiento ($id_prueba, $id_beneficiaria, $id_seccion, $prerequisito, $logro) {
	$conexion_bd = conectar_bd();

	$dml = 'UPDATE valorar_seccion SET prerequisito_objetivo=(?), logro_dificultad=(?)  WHERE id_prueba=(?) and
	id_beneficiaria=(?) and id_seccion=(?) ';

		if ( !($statement = $conexion_bd->prepare($dml)) ) {
				die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
				return 0;
		}

		//Unir los parámetros de la función con los parámetros de la consulta
		//El primer argumento de bind_param es el formato de cada parámetro
		if (!$statement->bind_param("ssiii", $prerequisito, $logro, $id_prueba, $id_beneficiaria, $id_seccion)) {
			die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		//Executar la consulta
		if (!$statement->execute()) {
			die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		desconectar_bd($conexion_bd);
		return 1;
	}



	function agregar_observacion_act ($observ, $idprueba, $idbeneficiaria, $idseccion, $idact) {
		$conexion_bd = conectar_bd();

		//Prepara la consulta
		$dml = 'UPDATE valorar_actividad SET observacion=(?)  WHERE id_prueba=(?) and
		id_beneficiaria=(?) and id_seccion=(?) and id_actividad=(?)';

		if ( !($statement = $conexion_bd->prepare($dml)) ) {
				die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
				return 0;
		}

		//Unir los parámetros de la función con los parámetros de la consulta
		//El primer argumento de bind_param es el formato de cada parámetro
		if (!$statement->bind_param("siiii", $observ, $idprueba, $idbeneficiaria, $idseccion, $idact)) {
				die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
				return 0;
		}

		//Executar la consulta
		if (!$statement->execute()) {
			die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
				return 0;
		}

		desconectar_bd($conexion_bd);
			return 1;
	}

	function agregar_observacion_sec ($observ, $idprueba, $idbeneficiaria, $idseccion) {
		$conexion_bd = conectar_bd();

		//Prepara la consulta
		$dml = 'UPDATE valorar_seccion SET observacion=(?)  WHERE id_prueba=(?) and
		id_beneficiaria=(?) and id_seccion=(?)';

		if ( !($statement = $conexion_bd->prepare($dml)) ) {
				die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
				return 0;
		}

		//Unir los parámetros de la función con los parámetros de la consulta
		//El primer argumento de bind_param es el formato de cada parámetro
		if (!$statement->bind_param("siii", $observ, $idprueba, $idbeneficiaria, $idseccion)) {
				die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
				return 0;
		}

		//Executar la consulta
		if (!$statement->execute()) {
			die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
				return 0;
		}

		desconectar_bd($conexion_bd);
			return 1;
	}



	function calcular_porcentaje_prueba($idBeneficiaria, $idprueba) {
		$conexion_bd = conectar_bd();

		$suma = 0.0;
		$consulta = 'SELECT calificacion from valorar_actividad where id_beneficiaria ='.$idBeneficiaria.' AND id_prueba ='.$idprueba;
		$resultados = $conexion_bd->query($consulta);
		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
			if($row['calificacion'] != 0) {
				$suma++;
			}
		}
		$fechaNac = recuperar($idBeneficiaria, "beneficiarias", "idBeneficiaria", "fechaNacimiento");
	  $fechaPrueba = recuperar($idprueba, "valorar_actividad", "id_prueba", "fecha");
	  $diff = date_diff(date_create($fechaNac), date_create($fechaPrueba));
	  $edad = $diff->format('%y');

		if ($edad < 4) {
			$suma /= (307-212);
		} else {
				$suma /= (307-95);
		}
		$suma *= 100;
		desconectar_bd($conexion_bd);
		mysqli_free_result($resultados); //Liberar la memoria
		return $suma;
	}

		function calcular_seccion($benefActual) {
			$edadBenef = calculaEdad(recuperar($benefActual, "beneficiarias", "idBeneficiaria", "fechaNacimiento"));
			if ($edadBenef > 6) {
				$seccionActual = 20;
			} else {
				$seccionActual = 1;
			}
			return $seccionActual;
		}

		//update de la actividad de la prueba que esta llevando a cabo.
		function actualizar_actividad($idprueba, $idbenef, $idseccion, $idactividad, $calificacion, $observacion='') {
			$conexion_bd = conectar_bd();

			//Prepara la consulta
			$dml = 'UPDATE valorar_actividad SET calificacion=(?)  WHERE id_prueba=(?) and
			id_beneficiaria=(?) and id_seccion=(?) and id_actividad=(?) ';

			if ( !($statement = $conexion_bd->prepare($dml)) ) {
					die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
					return 0;
			}

			//Unir los parámetros de la función con los parámetros de la consulta
			//El primer argumento de bind_param es el formato de cada parámetro
			if (!$statement->bind_param("iiiii", $calificacion, $idprueba, $idbenef, $idseccion, $idactividad)) {
					die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
					return 0;
			}

			//Executar la consulta
			if (!$statement->execute()) {
				die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
					return 0;
			}

			desconectar_bd($conexion_bd);
				return 1;
		}



		//Update de la actividad de la prueba que esta llevando a cabo.
		function actualizar_seccion($idprueba, $idbenef, $idseccion, $calificacion_seccion, $observacion='') {
			$conexion_bd = conectar_bd();

			//Prepara la consulta
			$dml = 'UPDATE valorar_seccion SET calificacion_seccion=(?)  WHERE id_prueba=(?) and
			id_beneficiaria=(?) and id_seccion=(?) ';

			if ( !($statement = $conexion_bd->prepare($dml)) ) {
					die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
					return 0;
			}

			//Unir los parámetros de la función con los parámetros de la consulta
			//El primer argumento de bind_param es el formato de cada parámetro
			if (!$statement->bind_param("iiii", $calificacion_seccion, $idprueba, $idbenef, $idseccion)) {
					die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
					return 0;
			}

			//Executar la consulta
			if (!$statement->execute()) {
				die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
					return 0;
			}

			desconectar_bd($conexion_bd);
				return 1;
		}



	//Insertar en tabla valorar_seccion para creacion de nueva prueba
	function insertar_seccion($idprueba, $idbenef, $idseccion, $calif_seccion, $evaluador, $date, $observacion='') {
		$conexion_bd = conectar_bd();

		//Prepara la consulta
		$dml = 'INSERT INTO valorar_seccion (id_prueba, id_beneficiaria, id_seccion, calificacion_seccion, fecha, evaluador, terminada) VALUES (?, ?, ?, ?, ?, ?, ?)';

			if ( !($statement = $conexion_bd->prepare($dml)) ) {
					die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
					return 0;
			}

			$no_terminada = 0;

			//Unir los parámetros de la función con los parámetros de la consulta
			//El primer argumento de bind_param es el formato de cada parámetro
			if (!$statement->bind_param("iiiissi", $idprueba, $idbenef, $idseccion, $calif_seccion, $date, $evaluador, $no_terminada)) {
					die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
					return 0;
			}

			//Executar la consulta
			if (!$statement->execute()) {
				die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
					return 0;
			}

			desconectar_bd($conexion_bd);
				return 1;
		}

		//Insertar en tabla valorar_seccion para creacion de nueva prueba
		function insertar_actividad($idprueba, $idbenef, $idseccion, $idact,  $calif_act, $date, $observacion='') {
			$conexion_bd = conectar_bd();


			//Prepara la consulta
			$dml = 'INSERT INTO valorar_actividad (id_prueba, id_beneficiaria, id_seccion, id_actividad, fecha, calificacion) VALUES (?, ?, ?, ?, ?, ?)';

			if ( !($statement = $conexion_bd->prepare($dml)) ) {
					die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
					return 0;
			}

			//Unir los parámetros de la función con los parámetros de la consulta
			//El primer argumento de bind_param es el formato de cada parámetro
			if (!$statement->bind_param("iiiisi", $idprueba, $idbenef, $idseccion, $idact, $date, $calif_act)) {
					die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
					return 0;
			}

			//Executar la consulta
			if (!$statement->execute()) {
				die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
					return 0;
			}

			desconectar_bd($conexion_bd);
				return 1;
		}

		function recuperar_ultima_prueba() {
			$conexion_bd = conectar_bd();

			$consulta = 'SELECT id_prueba from valorar_actividad order by id_prueba desc limit 1';
			$resultados = $conexion_bd->query($consulta);
			while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
				return $row;
				desconectar_bd($conexion_bd);
			}

			desconectar_bd($conexion_bd);
			return 0;
		}

		function insert_act_sec ($inicio, $final, $pruebaActual, $noseccion, $date) {
			for ($i=$inicio; $i <= $final; $i++) {
				insertar_actividad($pruebaActual, $_SESSION["benefactual"], $noseccion, $i, 0, $date);
			}
			insertar_seccion($pruebaActual, $_SESSION["benefactual"], $noseccion, 0, $_SESSION["nombre"], $date);
		}

		function recuperar_id_actividad ($idprueba, $idbenef, $idseccion) {
			$conexion_bd = conectar_bd();

			$consulta = 'SELECT id_actividad from valorar_actividad where  id_prueba='.$idprueba.' and id_beneficiaria='.$idbenef.' and id_seccion ='.$idseccion.' limit 1';
			$resultados = $conexion_bd->query($consulta);
			while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
				return $row[0];
				desconectar_bd($conexion_bd);
			}

			desconectar_bd($conexion_bd);
			return 0;
		}




		//Funcion para crear cada seccion del plan de seguimiento dependiendo del area y de la habilidad a evaluar
		function crear_plan($AreaHab, $id, $idSeccion, $idPrueba, $deshabilitar=0) {
			$conexion_bd = conectar_bd();

			$consulta = "SELECT prerequisito_objetivo as objetivo, logro_dificultad as dific from valorar_seccion WHERE id_prueba=".$idPrueba." AND id_seccion = ".$idSeccion;

			$resultado = '
			<div class="flex-row d-flex justify-content-center ">
				<div class="p-2 w-75">
					<div class="accordion PlanSeccion">
						<div class="card PlanSeccion">
							<div class="card-header" id="headingOne">
								<h2 class="mb-0">
									<div class="flex-row d-flex justify-content-center">
										<button onclick="mostrar_boton_guardar()" class="btn btn-link PlanSeccion CatFormatBtn" type="button" data-toggle="collapse" data-target="#'.$id.'" aria-expanded="true" aria-controls="collapseOne" title="Mostrar boton de guardar"';
										if ($deshabilitar == 1) {
											$resultado .= "disabled";
										}
										$resultado .= ">".$AreaHab;"</button>";

			$resultados = $conexion_bd->query($consulta);
			while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {

				if ($row['objetivo'] != "" || $row['dific'] != "" ) {
					$resultado .=	'<i class="large material-icons">beenhere</i>';
				}
				$resultado .=	'</div>
											</h2>
										</div>
										<div id="'.$id.'" class="collapse interior mostrarTodo" aria-labelledby="headingOne">
											<form action="controller_plan.php" method="POST" onsubmit="">
												<input type="hidden" name="idSec" id="idSec" value="'.$idSeccion.'">
												<div class="flex-row d-flex justify-content-center">
													<div class="p-2 flex-fill">
														Pre-requisitos/Objetivos';


				if ($row['objetivo'] != NULL && $row['dific'] == NULL) {
					$resultado .= '<textarea class="form-control planSeg" rows="4" maxlength="300" name="textPlanObj'.$idSeccion.'" id="textPlanObj'.$idSeccion.'">';
					$resultado .= $row['objetivo'].'</textarea></div>';
					$resultado .=	'<div class="p-2 flex-fill">
													Logros y Dificultades
													<textarea class="form-control planSeg" rows="4" maxlength="300"  name="textPlanDif'.$idSeccion.'" id="textPlanDif'.$idSeccion.'">';
					$resultado .= '</textarea></div>';

				} elseif ($row['dific'] != NULL && $row['objetivo'] == NULL) {
					$resultado .= '<textarea class="form-control planSeg" rows="4" maxlength="300" name="textPlanObj'.$idSeccion.'" id="textPlanObj'.$idSeccion.'">';
					$resultado .= '</textarea></div>';
					$resultado .=	'<div class="p-2 flex-fill">
													Logros y Dificultades
													<textarea class="form-control planSeg" rows="4" maxlength="300"  name="textPlanDif'.$idSeccion.'" id="textPlanDif'.$idSeccion.'">';
					$resultado .= $row['dific'].'</textarea></div>';

				} elseif ($row['dific'] != NULL && $row['objetivo'] != NULL)  {
					$resultado .= '<textarea class="form-control planSeg" rows="4" maxlength="300" name="textPlanObj'.$idSeccion.'" id="textPlanObj'.$idSeccion.'">';
					$resultado .= $row['objetivo'].'</textarea></div>';
					$resultado .=	'<div class="p-2 flex-fill">
													Logros y Dificultades
													<textarea class="form-control planSeg" rows="4" maxlength="300"  name="textPlanDif'.$idSeccion.'" id="textPlanDif'.$idSeccion.'">';
					$resultado .= $row['dific'].'</textarea></div>';

				} else {
					$resultado .= '<textarea class="form-control planSeg" rows="4" maxlength="300" name="textPlanObj'.$idSeccion.'" id="textPlanObj'.$idSeccion.'">';
					$resultado .= '</textarea></div>';
					$resultado .=	'<div class="p-2 flex-fill">
													Logros y Dificultades
													<textarea class="form-control planSeg" rows="4" maxlength="300"  name="textPlanDif'.$idSeccion.'" id="textPlanDif'.$idSeccion.'">';
					$resultado .= '</textarea></div>';
				}
			}
			$resultado .=	'
									</div>
									<div class="d-flex flex-row justify-content-end guardar_boton_prueba">
										<button type="submit" class="btn btn-outline-success guardar_boton_prueba">Guardar</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>';

			mysqli_free_result($resultados); //Liberar la memoria
			desconectar_bd($conexion_bd);
			return $resultado;
		}

	//---ver prueba
	function obtenerDatosPrueba($idPrueba, $nombreColumnas, $idSeccion = "")
	{

		$conexion_bd = conectar_bd();

		if($idSeccion != "")
		{
			$consulta = '(SELECT  "sin calificar" as descripcion, ';
			$consulta .= ' CASE when count(n.calificacion) > 0 then count(n.calificacion) else 0 end as "# de actividades" ';
			$consulta .= ' FROM seccion, `valorar_actividad` AS n';
			$consulta .= ' WHERE n.id_prueba = '.$idPrueba.' and id_seccion = '.$idSeccion.' and n.id_seccion = seccion.ID and calificacion = 0)';
			$consulta .= ' UNION (SELECT  "no lo logra" as descripcion, ';
			$consulta .= ' CASE	when count(n.calificacion) > 0 then count(n.calificacion) else 0 end as "# de actividades" ';
			$consulta .= ' FROM seccion, `valorar_actividad` AS n';
			$consulta .= ' WHERE n.id_prueba = '.$idPrueba.' and id_seccion = '.$idSeccion.' and n.id_seccion = seccion.ID and calificacion = 1)';
			$consulta .= ' UNION (SELECT  "en proceso" as descripcion, ';
			$consulta .= ' CASE	when count(n.calificacion) > 0 then count(n.calificacion) else 0 end as "# de actividades" ';
			$consulta .= ' FROM seccion, `valorar_actividad` AS n';
			$consulta .= ' WHERE n.id_prueba = '.$idPrueba.' and id_seccion = '.$idSeccion.' and n.id_seccion = seccion.ID and calificacion = 2)';
			$consulta .= ' UNION (SELECT  "lo logra" as descripcion, ';
			$consulta .= ' CASE	when count(n.calificacion) > 0 then count(n.calificacion) else 0 end as "# de actividades" ';
			$consulta .= ' FROM seccion, `valorar_actividad` AS n';
			$consulta .= ' WHERE n.id_prueba = '.$idPrueba.' and id_seccion = '.$idSeccion.' and n.id_seccion = seccion.ID and calificacion = 3)';
		}
		else
		{
			$consulta = 'SELECT prueba.id_seccion as seccion, actividad.nombre_actividad as actividad, observacion,';
			$consulta .= ' CASE WHEN calificacion = 0 then "sin calificar" WHEN calificacion = 1 then "no lo logra" WHEN calificacion = 2 then "en proceso" WHEN calificacion = 3 THEN "lo logra" END AS "logro"';
			$consulta .= ' FROM `valorar_actividad` as prueba, actividad';
			$consulta .= ' WHERE prueba.id_actividad = actividad.ID';
			$consulta .= ' AND prueba.id_prueba ='.$idPrueba;
		}

		$resultado = "";

		$resultados = $conexion_bd->query($consulta);
		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH))
		{
			for($i = 0; $i < sizeof($nombreColumnas); $i++)
			{
				$resultado .= $row[$nombreColumnas[$i]];

				if($i+1 < sizeof($nombreColumnas))
					$resultado .= ";";
			}
			$resultado .= "_";
		}

		mysqli_free_result($resultados);
		desconectar_bd($conexion_bd);


		return $resultado;
	  }


//------------------------------------------------------------
//------------------ BENEFICIARIAS----------------------------
//------------------------------------------------------------
	// CONSULTAR BENEFICIARIAS
	function consultarBeneficiarias($idMotivoIngreso="", $idDiagnostico="", $idMotivoEgreso="", $idDestino="", $idBeneficiaria="", $idStatus="", $nombre=""){

		$conexion_bd = conectar_bd();

		if($idStatus === "1"){
			$resultado =  "<table class='table table-hover table-striped table-responsive btn-table'><thead><tr><th>Nombre</th><th>Tipo de Sangre</th><th>Fecha de ingreso</th><th>Motivo de ingreso</th><th>Diagnóstico Intelectual</th><th colspan='3'>Acciones</th></tr></thead>";

			$consulta = 'Select idBeneficiaria, nombreCompleto, tipoSangre, fechaIngreso, M.motivoIngreso as motivoIngreso, D.diagnostico as diagnostico From beneficiarias as B, motivosIngreso as M, diagnosticos as D, status as S Where M.idMotivoIngreso = B.idMotivoIngreso AND D.idDiagnostico = B.idDiagnostico AND B.idStatus =S.idStatus';

			if ($idMotivoIngreso != "") {
				$consulta .= " AND M.idMotivoIngreso= ".$idMotivoIngreso;
			}

			if ($idDiagnostico != "") {
				$consulta .= " AND D.idDiagnostico= ".$idDiagnostico;
			}

		} else {

			$resultado =  "<table class='table table-hover table-striped table-responsive btn-table'><thead><tr><th>Nombre</th><th>Tipo de Sangre</th><th>Fecha de egreso</th><th>Motivo de egreso</th><th>Destino</th><th colspan='3'>Acciones</th></tr></thead>";

			$consulta = 'SELECT idBeneficiaria, nombreCompleto, tipoSangre, fechaEgreso, motivoEgreso, nombreDestino FROM beneficiarias as B, motivosEgreso as M, destinos as D WHERE idStatus = 2 AND B.idMotivoEgreso = M.idMotivoEgreso AND D.idDestino = B.idDestino';

			if ($idMotivoEgreso != "") {
				$consulta .= " AND M.idMotivoEgreso= ".$idMotivoEgreso;
			}

			if ($idDestino != "") {
				$consulta .= " AND D.idDestino= ".$idDestino;
			}
		}

		if ($idBeneficiaria != "") {
			$consulta .= " AND B.idBeneficiaria = ".$idBeneficiaria;
		}

		if ($idStatus != "") {
			$consulta .= " AND B.idStatus = ".$idStatus;
		}

		if($nombre != "")
				$consulta .= ' AND nombreCompleto LIKE "%'.$nombre.'%" ';


		$resultados = $conexion_bd->query($consulta);
		$resultado .= "<br>";

		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)){

			if($idStatus === "1"){
				$resultado .= "<tr>";
				$resultado .= "<td>".$row['nombreCompleto']."</td>";
				$resultado .= "<td>".$row['tipoSangre']."</td>";
				$resultado .= "<td>".date("d-m-Y", strtotime($row['fechaIngreso']))."</td>";
				$resultado .= "<td>".$row['motivoIngreso']."</td>";
				$resultado .= "<td>".$row['diagnostico']."</td>";
				$resultado .= "<td>";

				// VER MAS DE BENEFICIARIA
				$resultado .="<a href='../beneficiarias/verBeneficiaria.php?idBeneficiaria=".$row['idBeneficiaria']."' class='btn btn-outline-info'><i class='fas fa-search-plus' data-tooltip='tooltip' title='Ver más' data-placement='top'></i></a>";

				if($_SESSION["usuario"] === "Administradora"){
					// MODIFICAR DATOS DE BENEFICIARIA
					$resultado .="<a href='modificarBeneficiaria.php?editar=general&idBeneficiaria=".$row['idBeneficiaria']."' class='btn btn-outline-secondary' data-tooltip='tooltip' title='Modificar' data-placement='top'><i class='fas fa-pencil-alt'></i></a>";
					// EGRESAR BENEFICIARIA
					$tituloModal =  str_replace(' ', '', $row['nombreCompleto']);
					$resultado .= "<a data-toggle='modal' href='#modal".$tituloModal."' class='btn btn-outline-danger'><i class='fas fa-trash-alt' data-tooltip='tooltip' title='Egresar' data-placement='top'></i></a>";
					// INCLUIR MODAL DE EGRESO
					include("beneficiarias/egresar.html");
				}
			} else {
				$resultado .= "<tr>";
				$resultado .= "<td>".$row['nombreCompleto']."</td>";
				$resultado .= "<td>".$row['tipoSangre']."</td>";
				$resultado .= "<td>".date("d-m-Y", strtotime($row['fechaEgreso']))."</td>";
				$resultado .= "<td>".$row['motivoEgreso']."</td>";
				$resultado .= "<td>".$row['nombreDestino']."</td>";
				$resultado .= "<td>";

				// VER MAS DE BENEFICIARIA -- pasar beneficiariaActiva===0
				$resultado .= "<a href='verBeneficiaria.php?idBeneficiaria=".$row['idBeneficiaria']."' class='btn btn-outline-info'><i class='fas fa-search-plus' data-tooltip='tooltip' title='Ver más' data-placement='top'></i></a>";
				//if($_SESSION["usuario"] === "Administradora")
				//{
				// MODIFICAR DATOS DE BENEFICIARIA
				$resultado .= "<a href='modificarBeneficiaria.php?editar=egreso&idBeneficiaria=".$row['idBeneficiaria']."' class='btn btn-outline-secondary'><i class='fas fa-pencil-alt' data-tooltip='tooltip' title='Modificar' data-placement='top'></i></a>";

				// REINGRESAR BENEFICIARIA
				$tituloModal =  str_replace(' ', '', $row['nombreCompleto']);
				$resultado .= "<a data-toggle='modal' href='#modal".$tituloModal."' class='btn btn-outline-success'> <i class='fas fa-redo-alt' data-tooltip='tooltip' title='Reingresar' data-placement='top'></i></a>";
				// INCLUIR MODAL DE EGRESO
				include("beneficiarias/reingresar.html");
			}
			$resultado .= "</td>";
			$resultado .= "</tr>";
		}

		$resultado .= "</tbody></table><br>";
		return $resultado;

		mysqli_free_result($resultados); //Liberar la memoria

		desconectar_bd($conexion_bd);
	}



	//Función para ingresar una nueva beneficiaria

	function registrarBeneficiaria($nombreCompleto, $fechaNacimiento, $tipoSangre, $numCurp, $antecedentes, $idDiagnostico, $diagnosticoMotriz, $edadMental, $fechaIngreso, $idMotivoIngreso, $nombreCanalizador, $consideracionesIngreso, $vinculosFam, $convivencias, $tutela, $situacionJuridica, $idEscolaridad, $gradoEscolar){
		$conexion_bd = conectar_bd();

		//Preparar consulta

		$registrar = 'INSERT INTO beneficiarias (idStatus, nombreCompleto, fechaNacimiento, tipoSangre, numCurp, antecedentes, idDiagnostico, diagnosticoMotriz, edadMental, fechaIngreso, idMotivoIngreso, nombreCanalizador, consideracionesIngreso, vinculosFam, convivencias, tutela, situacionJuridica, idEscolaridad, gradoEscolar) VALUES(1, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';


		if ( !($statement = $conexion_bd->prepare($registrar))) {
		die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
		return 0;
		}

		//Unir los parámetros
		if (!$statement->bind_param("sssssisisissssssis", $nombreCompleto, $fechaNacimiento, $tipoSangre, $numCurp, $antecedentes, $idDiagnostico, $diagnosticoMotriz, $edadMental, $fechaIngreso, $idMotivoIngreso, $nombreCanalizador, $consideracionesIngreso, $vinculosFam, $convivencias, $tutela, $situacionJuridica, $idEscolaridad, $gradoEscolar)){
		die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
		return 0;
		}


		//Ejecutar el registro de la beneficiaria
		if (!$statement->execute()) {
		die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
		return 0;
		}

		    desconectar_bd($conexion_bd);
    		return 1;
	}

	function enviarCorreo($nombreEnvía, $recipiente, $texto) {
		$email = new \SendGrid\Mail\Mail();
		$email->setFrom("a01704889@itesm.mx", "$nombreEnvía");
		$email->setSubject("Esta es la segunda prueba");
		$email->addTo("$nombreEnvía", "EXAMPLE recipient");
		$email->addContent("text/plain", "and easy to do anywhere, even with PHP");
		$email->addContent(
				"text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
		);
		$sendgrid = new \SendGrid('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');
		try {
				$response = $sendgrid->send($email);
				print $response->statusCode() . "\n";
				print_r($response->headers());
				print $response->body() . "\n";
		} catch (Exception $e) {
				echo 'Caught exception: '. $e->getMessage() ."\n";
	}
	}

	//Función para modificar los datos personales de una beneficiaria
function modificarPersonal($idBeneficiaria, $nombreCompleto, $fechaNacimiento, $tipoSangre, $numCurp){

    $conexion_bd = conectar_bd();

    //Preparar la consulta
    $modificar = 'UPDATE beneficiarias SET nombreCompleto=(?), fechaNacimiento=(?), tipoSangre=(?), numCurp=(?) WHERE idBeneficiaria=(?)';

    if ( !($statement = $conexion_bd->prepare($modificar))) {
      die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
      return 0;
    }

    //Unir parámetros de consulta
    if (!$statement->bind_param("ssssi", $nombreCompleto, $fechaNacimiento, $tipoSangre, $numCurp, $idBeneficiaria)) {
      die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
      return 0;
    }

    //Ejecutar consulta
    if (!$statement->execute()) {
      die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
      return 0;
    }

    desconectar_bd($conexion_bd);
    return 1;
  }

	//Función para modificar los datos de ingreso de una beneficiaria

	function modificarIngreso($idBeneficiaria, $idDiagnostico, $diagnosticoMotriz, $edadMental, $fechaIngreso, $idMotivoIngreso, $nombreCanalizador, $consideracionesIngreso){

		$conexion_bd = conectar_bd();

		//Preparar la consulta
		$modificar = 'UPDATE beneficiarias SET idDiagnostico=(?), diagnosticoMotriz=(?), edadMental=(?), fechaIngreso=(?), idMotivoIngreso=(?), nombreCanalizador=(?), consideracionesIngreso=(?) WHERE idBeneficiaria=(?)';

		if ( !($statement = $conexion_bd->prepare($modificar))) {
		die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
		return 0;
		}

		//Unir parámetros de consulta
		if (!$statement->bind_param("isisissi", $idDiagnostico, $diagnosticoMotriz, $edadMental, $fechaIngreso, $idMotivoIngreso, $nombreCanalizador, $consideracionesIngreso,  $idBeneficiaria)) {
		die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
		return 0;
		}

		//Ejecutar consulta
		if (!$statement->execute()) {
		die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
		return 0;
		}

		desconectar_bd($conexion_bd);
		return 1;
	}

	//Función para modificar los datos familiares de una beneficiaria

	function modificarFamiliares($idBeneficiaria, $antecedentes, $vinculosFam, $convivencias, $tutela,  $situacionJuridica){

		$conexion_bd = conectar_bd();

		//Preparar la consulta
		$modificar = 'UPDATE beneficiarias SET antecedentes=(?), vinculosFam=(?), convivencias=(?), tutela=(?), situacionJuridica=(?) WHERE idBeneficiaria=(?)';

		if ( !($statement = $conexion_bd->prepare($modificar))) {
		die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
		return 0;
		}

		//Unir parámetros de consulta
		if (!$statement->bind_param("sssssi", $antecedentes, $vinculosFam, $convivencias, $tutela,  $situacionJuridica, $idBeneficiaria)) {
		die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
		return 0;
		}

		//Ejecutar consulta
		if (!$statement->execute()) {
		die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
		return 0;
		}

		desconectar_bd($conexion_bd);
		return 1;
	}

	//Función para modificar los datos escolares de una beneficiaria

	function modificarAcademico($idBeneficiaria, $idEscolaridad, $gradoEscolar){

		$conexion_bd = conectar_bd();

		//Preparar la consulta
		$modificar = 'UPDATE beneficiarias SET idEscolaridad=(?), gradoEscolar=(?) WHERE idBeneficiaria=(?)';

		if ( !($statement = $conexion_bd->prepare($modificar))) {
		die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
		return 0;
		}

		//Unir parámetros de consulta
		if (!$statement->bind_param("isi", $idEscolaridad, $gradoEscolar, $idBeneficiaria)) {
		die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
		return 0;
		}
		//Ejecutar consulta
		if (!$statement->execute()) {
		die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
		return 0;
		}
		desconectar_bd($conexion_bd);
		return 1;
	}

	//Función para egresar a una beneficiaria

	function egresarBeneficiaria($idBeneficiaria, $fechaEgreso, $idMotivoEgreso, $consideracionesEgreso, $idDestino, $especificacionesDestino, $nombreReceptor, $logros){
		$conexion_bd = conectar_bd();

		//Preparar la consulta
		$egresar = 'UPDATE beneficiarias SET fechaEgreso=(?), idMotivoEgreso=(?), consideracionesEgreso=(?), idDestino=(?), especificacionesDestino=(?), nombreReceptor=(?), logros=(?), idStatus = 2 WHERE idBeneficiaria=(?)';

		if ( !($statement = $conexion_bd->prepare($egresar))) {
		die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
		return 0;
		}

		//Unir parámetros de consulta
		if (!$statement->bind_param("sisisssi", $fechaEgreso, $idMotivoEgreso, $consideracionesEgreso, $idDestino, $especificacionesDestino, $nombreReceptor, $logros, $idBeneficiaria)) {
		die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
		return 0;
		}

		//Ejecutar consulta
		if (!$statement->execute()) {
		die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
		return 0;
		}

		desconectar_bd($conexion_bd);
		return 1;
	}

	function reingresarBeneficiaria($idBeneficiaria, $fechaReingreso, $motivoReingreso){
		$conexion_bd = conectar_bd();

		//Preparar la consulta
		$reingresar = 'UPDATE beneficiarias SET fechaIngreso=(?), motivoReingreso=(?), idStatus = 1 WHERE idBeneficiaria=(?)';

		if ( !($statement = $conexion_bd->prepare($reingresar))) {
		die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
		return 0;
		}

		//Unir parámetros de consulta
		if (!$statement->bind_param("ssi", $fechaReingreso, $motivoReingreso, $idBeneficiaria)) {
		die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
		return 0;
		}

		//Ejecutar consulta
		if (!$statement->execute()) {
		die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
		return 0;
		}

		desconectar_bd($conexion_bd);
		return 1;
	}

	//Función para modificar los datos de egreso de una beneficiaria

	function modificarEgreso($idBeneficiaria, $fechaEgreso, $idMotivoEgreso, $consideracionesEgreso, $idDestino, $especificacionesDestino, $nombreReceptor, $logros){

		$conexion_bd = conectar_bd();

		//Preparar la consulta
		$modificar = 'UPDATE beneficiarias SET fechaEgreso=(?), idMotivoEgreso=(?), consideracionesEgreso=(?),  idDestino=(?), especificacionesDestino=(?), nombreReceptor=(?), logros=(?) WHERE idBeneficiaria=(?)';

		if ( !($statement = $conexion_bd->prepare($modificar))) {
		die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
		return 0;
		}

		//Unir parámetros de consulta
		if (!$statement->bind_param("sisisssi", $fechaEgreso, $idMotivoEgreso, $consideracionesEgreso, $idDestino, $especificacionesDestino, $nombreReceptor, $logros, $idBeneficiaria)) {
		die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
		return 0;
		}

		//Ejecutar consulta
		if (!$statement->execute()) {
		die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
		return 0;
		}

		desconectar_bd($conexion_bd);
		return 1;
	}


	//Obtener el campo a modificar

	function obtenerCampo($idBeneficiaria, $campo){
	$conexion_bd = conectar_bd();

		$consultar = "SELECT $campo FROM beneficiarias WHERE idBeneficiaria='$idBeneficiaria'";
		$resultados = $conexion_bd->query($consultar);
		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
		closeDB($conexion_bd);
		return $row["$campo"];
		}

		desconectar_bd($conexion_bd);
		return 0;
	}


//------------------------------------------------------------
//----------------------- REPORTES----------------------------
//------------------------------------------------------------

  function datosReporte($consulta, $nombreColumnas)
  {

	$conexion_bd = conectar_bd();

	$resultado = "";

	$resultados = $conexion_bd->query($consulta);
	while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH))
	{
		for($i = 0; $i < sizeof($nombreColumnas); $i++)
		{
			$resultado .= $row[$nombreColumnas[$i]];

			if($i+1 < sizeof($nombreColumnas))
				$resultado .= ";";
		}
		$resultado .= "_";
	}

	mysqli_free_result($resultados);
	desconectar_bd($conexion_bd);


	return $resultado;
  }

  function cardsReportes()
  {
	$conexion_bd = conectar_bd();

		$resultado = "";

		$consulta = 'SELECT * FROM plantillaReporte';

		$contador = 1;

		$resultados = $conexion_bd->query($consulta);
		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH))
		{
			if($_SESSION["usuario"] != "Administradora" && $contador > 4)
				break;

			$resultado .= "<div class='card text-center' style='width: 20rem;'><div class='card-body'>";
			$resultado .= "<h4 class='tituloReporte'><i class='fas fa-file-contract'></i></h4><h4 class='card-title tituloReporte'> ".$row['idPlantilla'].". ".$row['nombre']."</h4><hr/>";

			$resultado .= "<p class='card-text'><strong>Descripción:</strong> ".$row['descripcion']."</p>";

			$resultado .= "<hr/> <a href='verReporte.php?plantillaReporte=".$row['idPlantilla']."' class='btn btn-outline-info'>Generar Reporte</a>";

			$resultado .= "</div></div>";
			$contador++;
		}

		mysqli_free_result($resultados);
		desconectar_bd($conexion_bd);


		return $resultado;
  }

  //CONSULTAR CUMPLEAÑOS DE EMPLEADOS
  function consultarCumpleañosE(){
  	$conexion_bd = conectar_bd();

	$consulta = "SELECT E.nombre as nombre, E.correo as correo FROM empleado as E where DATE_FORMAT(fechaNacimiento, '%m-%d') = DATE_FORMAT(NOW()- INTERVAL 5 HOUR, '%m-%d') AND idStatus=1";

	$resultados = $conexion_bd->query($consulta);

	if(mysqli_num_rows($resultados)>0){
		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)){

			$resultado = "<h5>".$row['nombre'].' (empleado)'."</h5>";

			if($row['correo'] != null){
				$resultado .= "<a class='btn btn-sm btn-primary' href='mailto:".$row['correo'].'?Subject=Feliz cumpleaños de parte de CMG.&body=Gracias a tu arduo trabajo y tu increíble actitud, nuestra organización ha logrado ser un mejor lugar, por ello te deseamos un feliz cumpleaños!.%0D%0AQue este año venga lleno de salud y prosperidad para ti y tus seres queridos.'."'>";
				$resultado .= "<i class='fas fa-envelope'></i> Enviar Correo</a>";
			} else {
				$resultado .= "<p>-- no tiene correo --</p>";
			}


			$resultado .= "<hr>";
		}
	} else {
		$resultado = "";
	}

	mysqli_free_result($resultados); //Liberar la memoria

	desconectar_bd($conexion_bd);

	return $resultado;
  }

     //CONSULTAR CUMPLEAÑOS DE DONANTEs
  function consultarCumpleañosD(){
  	$conexion_bd = conectar_bd();

	$consulta = "SELECT D.nombreDonante as nombre, D.correoParticular as correo  FROM donantes as D where DATE_FORMAT(fechaNacParticular, '%m-%d') = DATE_FORMAT(NOW()- INTERVAL 5 HOUR, '%m-%d') AND idStatus=1";

	$resultados = $conexion_bd->query($consulta);

	if(mysqli_num_rows($resultados)>0){
		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)){

			$resultado = "<h5>".$row['nombre'].' (donante)'."</h5>";

			if($row['correo'] != null){
				$resultado .= "<a class='btn btn-sm btn-primary' onclick='return check(this);' href='mailto:".$row['correo'].'?Subject=Feliz cumpleaños de parte de CMG.&body=Gracias a usted, nuestra organización ha logrado ser un mejor lugar, por ello le deseamos un feliz cumpleaños!.%0D%0AQue este año venga lleno de salud y prosperidad para usted y sus seres queridos.'."'>";
				$resultado .= "<i class='fas fa-envelope'></i> Enviar Correo</a>";
			} else {
				$resultado .= "<p>-- no tiene correo --</p>";
			}
			$resultado .= "<hr>";
		}
	} else {
		$resultado = "";
	}

	mysqli_free_result($resultados); //Liberar la memoria

	desconectar_bd($conexion_bd);

	return $resultado;
  }

  //FUNCIÓN QUE CARGA LA INFORMACIÓN DE LOS ARCHIVOS A LA BD
  function cargarArchivo($categoria, $pathArchivo, $comentarios, $idBeneficiaria ){
  	$conexion_bd = conectar_bd();

  	$consulta = "INSERT INTO archivosBeneficiarias(categoria, pathArchivo, comentarios, idBeneficiaria) VALUES(?, ?, ?, ?)";

  	if ( !($statement = $conexion_bd->prepare($consulta))) {
      die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
      return 0;
    }

    //Unir parámetros de consulta
    if (!$statement->bind_param("sssi", $categoria, $pathArchivo, $comentarios, $idBeneficiaria)) {
      die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
      return 0;
    }

    //Ejecutar consulta
    if (!$statement->execute()) {
      die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
      return 0;
    }

  	desconectar_bd($conexion_bd);
  	return 1;
  }

  //FUNCIÓN QUE CARGA LA INFORMACIÓN DE LOS ARCHIVOS A LA BD
  function cargarArchivoEmp($categoria, $pathArchivo, $comentarios, $id ){
  	$conexion_bd = conectar_bd();

  	$consulta = "INSERT INTO archivoempleado(categoria, pathArchivo, comentarios, idEmpleado) VALUES(?, ?, ?, ?)";

  	if ( !($statement = $conexion_bd->prepare($consulta))) {
      die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
      return 0;
    }

    //Unir parámetros de consulta
    if (!$statement->bind_param("sssi", $categoria, $pathArchivo, $comentarios, $id)) {
      die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
      return 0;
    }

    //Ejecutar consulta
    if (!$statement->execute()) {
      die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
      return 0;
    }

  	desconectar_bd($conexion_bd);
  	return 1;
  }

  //FUNCIÓN QUE DESPLIEGA LOS ARCHIVOS GUARDADOS EN BD
  function desplegarArchivos($idBeneficiaria="", $categoria=""){

  	$conexion_bd = conectar_bd();

  	if ($categoria != "ingreso" || $categoria != "egreso") {
  		$resultado = "<div class='tablaArchivos table-wrapper-scroll-y-1 my-custom-scrollbar-1 mx-auto text-center'><table class='table table-hover table-striped table-responsive-md btn-table'><thead><tr><th>Nombre</th><th>Descripción</th><th colspan='3'>Acciones</th></tr></thead><tbody>";
    }

    if ($categoria == "ingreso" || $categoria == "egreso") {
    	$resultado = "<table class='tablaArchivos table table-hover table-striped table-responsive-md btn-table'><thead><tr><th>Nombre</th><th>Fecha</th><th colspan='3'>Acciones</th></tr></thead><tbody>";
    }

  	$consulta = 'SELECT idArchivo, pathArchivo, comentarios, categoria, fechaCarga, idBeneficiaria FROM archivosBeneficiarias';

  	if ($idBeneficiaria != "") {
			$consulta .= " WHERE idBeneficiaria = ".$idBeneficiaria;
		}

	if ($categoria != "") {
			$consulta .= " AND categoria = ". "'" . $categoria . "'";
		}

	$consulta .= "ORDER BY fechaCarga DESC";

  	//echo "$consulta";

  	$resultados = $conexion_bd->query($consulta);

		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH))
		{

			$resultado .= "<tr><td>".$row['pathArchivo']."</td>";

			if ($categoria == "dxIntelectual" || $categoria == "dxMotriz" || $categoria == "escolar" || $categoria == "medico") {
				$resultado .= "<td>".$row['comentarios']."</td>";
			} else {
				$resultado .= "<td>".$row['fechaCarga']."</td>";
			}
			//botones
			$resultado .= "<td>";
			//BOTÓN PARA VER LOS ARCHIVOS
			$resultado .= "<a class='btn btn-outline-info' target='_blank' data-tooltip='tooltip' title='Ver archivo' data-placement='top'href='archivosBeneficiarias/".$row['pathArchivo']."'><i class='fas fa-search-plus'></i></a>";

			//BOTÓN PARA DESCARGAR LOS ARCHIVOS
			$resultado .= "<a data-tooltip='tooltip' title='Descargar' data-placement='top' class='btn btn-outline-secondary' href='descargarArchivo.php?idBeneficiaria=".$row['idBeneficiaria']."&path=".$row['pathArchivo']."'><i class='fas fa-download'></i></a>";

			//SI ES ADMINISTRADOR EL QUE LOGGEA
			if($_SESSION["usuario"] === "Administradora")
			{
				//BOTÓN PARA ELIMINAR LOS ARCHIVOS
				$resultado .= "<a data-tooltip='tooltip' title='Eliminar' data-placement='top' class='btn btn-outline-danger' href='eliminarArchivo.php?id=".$row['idBeneficiaria']."&path=".$row['pathArchivo']."&categoria=".$row['categoria']."&idArchivo=".$row['idArchivo']."'><i class='fas fa-trash-alt'></i></a>";

			}
			$resultado .= "</td>";
			$resultado .= "</tr>";
		}

	mysqli_free_result($resultados);
	desconectar_bd($conexion_bd);

  	$resultado .= "</tbody></table></div>";

	return $resultado;
  }

  //FUNCIÓN QUE DESPLIEGA LOS ARCHIVOS GUARDADOS EN BD
  function desplegarArchivosEmp($id="", $categoria=""){

  	$conexion_bd = conectar_bd();
  	//ver otros archivos
  	if ($categoria != "ingreso" || $categoria != "egreso") {
  		$resultado = "<div class='miTabla table-wrapper-scroll-y my-custom-scrollbar'><table class='table table-hover table-striped table-responsive-md btn-table'><thead><tr><th>Nombre</th><th>Descripción</th><th>Fecha</th><th colspan='3'>Acciones</th></tr></thead><tbody>";
    }
    //Ver de ingreso o egreso
    if ($categoria == "ingreso" || $categoria == "egreso") {
    	$resultado = "<div class='miTabla table-wrapper-scroll-y my-custom-scrollbar'><table class='table table-hover table-striped table-responsive-md btn-table'><thead><tr><th>Nombre</th><th>Descripción</th><th colspan='3'>Acciones</th></tr></thead><tbody>";
    }

  	$consulta = 'SELECT pathArchivo, comentarios, categoria, fecha as fechaCarga, idEmpleado FROM archivoempleado';

  	if ($id != "") {
			$consulta .= " WHERE idEmpleado = ".$id;
		}

	if ($categoria != "") {
			$consulta .= " AND categoria = ". "'" . $categoria . "'";
		}

	$consulta .= "ORDER BY fecha DESC";

	if ($categoria == "ingreso") {
				$cnt=0;

			} else {
				$cnt='A';

			}
  	//echo "$consulta";

  	$resultados = $conexion_bd->query($consulta);

		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH))
		{

			$resultado .= "<td>".$row['pathArchivo']."</td>";

			if ($categoria == "ingreso") {

				$resultado .= "<td>".$row['comentarios']."</td>";
			} else{
				$resultado .= "<td>".$row['comentarios']."</td>";
				$resultado .= "<td>".$row['fechaCarga']."</td>";
			}
			$cnt++;
			//botones
			$resultado .= "<td>";
			//BOTÓN PARA VER LOS ARCHIVOS
			$resultado .= "<a class='btn btn-outline-info' target='_blank' data-tooltip='tooltip' title='Ver archivo' data-placement='top'href='archivosEmpleados/".$row['pathArchivo']."'><i class='fas fa-search-plus'></i></a>";

			//BOTÓN PARA DESCARGAR LOS ARCHIVOS
			$resultado .= "<a data-tooltip='tooltip' title='Descargar' data-placement='top' class='btn btn-outline-secondary' href='descargarArchivo.php?id=".$row['idEmpleado']."&path=".$row['pathArchivo']."'><i class='fas fa-download'></i></a>";

			//SI ES ADMINISTRADOR EL QUE LOGGEA
			if($_SESSION["usuario"] === "Administradora")
			{
				//BOTÓN PARA ELIMINAR LOS ARCHIVOS
				$resultado .= "<a data-tooltip='tooltip' title='Eliminar' data-placement='top' class='btn btn-outline-danger' data-toggle='modal' data-target='#modalEliminarArchivo".$id."".$cnt."' href='' ><i class='fas fa-trash-alt'></i></button>";
			}
			$resultado .= "</td>";
			$resultado .= "</tr>";

			include("modalEliminarArchivo.html");
		}

	mysqli_free_result($resultados);
	desconectar_bd($conexion_bd);

  	$resultado .= "</tbody></table></div>";

	return $resultado;
  }

  //FUNCIÓN QUE ELIMINA LOS ARCHIVOS DE LA BD
  function eliminarArchivoEmp($id, $pathArchivo,$categoria){

  		$conexion_bd = conectar_bd();

		//Prepara la consulta
		$eliminar = 'DELETE FROM archivoempleado WHERE idEmpleado = (?) AND pathArchivo = (?) AND categoria=(?)';

		if ( !($statement = $conexion_bd->prepare($eliminar)) ) {
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
		}

		//Unir los parámetros de la función con los parámetros de la consulta
		if (!$statement->bind_param("iss", $id, $pathArchivo,$categoria)) {
			die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		//Executar la consulta
		if (!$statement->execute()) {
		  die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		desconectar_bd($conexion_bd);
		return 1;
  }

  //FUNCIÓN QUE ELIMINA LOS ARCHIVOS DE LA BD
  function eliminarArchivo($idBeneficiaria, $pathArchivo, $categoria, $idArchivo){

  		$conexion_bd = conectar_bd();

		//Prepara la consulta
		$eliminar = 'DELETE FROM archivosBeneficiarias WHERE idBeneficiaria = (?) AND pathArchivo = (?) AND categoria = (?) AND idArchivo = (?)';

		if ( !($statement = $conexion_bd->prepare($eliminar)) ) {
			die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
			return 0;
		}

		//Unir los parámetros de la función con los parámetros de la consulta
		if (!$statement->bind_param("issi", $idBeneficiaria, $pathArchivo, $categoria, $idArchivo)) {
			die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		//Executar la consulta
		if (!$statement->execute()) {
		  die("Error en ejecución: (" . $statement->errno . ") " . $statement->error);
			return 0;
		}

		desconectar_bd($conexion_bd);
		return 1;
  }

  //FUNCIÓN QUE DESPLIEGA IMAGENES ESPECIFICAS
  function obtenerImagen($path){

  	$conexion_bd = conectar_bd();

  	$consulta = "SELECT pathArchivo FROM archivosBeneficiarias WHERE pathArchivo LIKE '$path%'";

  	//echo "$consulta";

  	$resultados = $conexion_bd->query($consulta);

		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH))
		{
			$resultado = $row['pathArchivo'];
		}

	mysqli_free_result($resultados);
	desconectar_bd($conexion_bd);



	if (isset($resultado)) {
		return $resultado;
	}

  }

  	// TABLA DONDE SE DESPLIEGAN LAS IMÁGENES

	function verFotos($idBeneficiaria)
	{
		$conexion_bd = conectar_bd();

		$resultado = "<table class='table table-hover table-striped table-responsive-md btn-table'><thead><tr><th>Imagen</th><th>Descripción</th><th colspan='2'>Acciones</th></tr></thead><tbody>";

		// $consulta = "SELECT pathArchivo, comentarios, idBeneficiaria FROM archivosBeneficiarias WHERE pathArchivo LIKE '$idBeneficiaria%'";
		$consulta = "SELECT idArchivo, pathArchivo, comentarios, idBeneficiaria FROM archivosBeneficiarias WHERE pathArchivo LIKE '$idBeneficiaria%' AND categoria='seguimiento'";


		$resultados = $conexion_bd->query($consulta);

		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH))
		{
			$resultado .= "<td>"."<img src='imagenesBeneficiarias/".$row['pathArchivo']."' class='img-fluid' alt='Imagen' id='fotoBenef'>"."</td>";
			$resultado .= "<td>".$row['comentarios']."</td>";

			//botones
			$resultado .= "<td>";
			//BOTÓN PARA DESCARGAR LOS ARCHIVOS
			$resultado .= "<a data-tooltip='tooltip' title='Descargar' data-placement='top' class='btn btn-outline-info' href='descargarImagen.php?idBeneficiaria=".$row['idBeneficiaria']."&path=".$row['pathArchivo']."'><i class='fas fa-download'></i></a>";

			//SI ES ADMINISTRADOR EL QUE LOGGEA
			if($_SESSION["usuario"] === "Administradora")
			{
				//BOTÓN PARA ELIMINAR LOS ARCHIVOS
				$resultado .= "<a data-tooltip='tooltip' title='Eliminar' data-placement='top' class='btn btn-outline-danger' href='eliminarImagen.php?id=".$row['idBeneficiaria']."&path=".$row['pathArchivo']."&categoria="."&idArchivo=".$row['idArchivo']."'><i class='fas fa-trash-alt'></i></button>";
			}
			$resultado .= "</td>";
			$resultado .= "</tr>";
		}
		mysqli_free_result($resultados);
		desconectar_bd($conexion_bd);

		$resultado .= "</tbody></table>";

		return $resultado;
	}


	// BUSCAR OPCION REPETIDA DE DROPDOWN
	function buscarOpcionRepetida($tabla, $campo, $opcion){
		$conexion_bd = conectar_bd();

		$busqueda="SELECT * FROM $tabla WHERE $campo='$opcion'";
		$resultados = mysqli_query($conexion_bd,$busqueda);

		if(mysqli_num_rows($resultados)>0){
			return 1;

		}else{
			return 0;
		}

		desconectar_bd($conexion_bd);

	}

		// BUSCAR OPCION REPETIDA DE DROPDOWN
	function buscarArchivoExistente($path, $archivo){

		$conexion_bd = conectar_bd();

		$busqueda="SELECT * FROM archivosBeneficiarias WHERE pathArchivo LIKE '$path%'";

		$resultados = $conexion_bd->query($busqueda);

		if(mysqli_num_rows($resultados)>0){
			//$resultado = "<span class='badge'>* Ya existe una carga del archivo $archivo.</span>";
			$resultado = "<div class='alert alert-primary' role='alert'>* Ya existe una carga del archivo $archivo.</div>";
		}else{
			$resultado = "";
		}

		mysqli_free_result($resultados);
		desconectar_bd($conexion_bd);

		echo "$resultado";
	}

		// BUSCAR OPCION REPETIDA DE DROPDOWN
	function buscarArchivoExistenteEmp($path, $archivo){

		$conexion_bd = conectar_bd();

		$busqueda="SELECT * FROM archivoempleado WHERE pathArchivo LIKE '$path%'";

		$resultados = $conexion_bd->query($busqueda);

		if(mysqli_num_rows($resultados)>0){
			//$resultado = "<span class='badge'>* Ya existe una carga del archivo $archivo.</span>";
			$resultado = "<div class='alert alert-primary' role='alert'>* Ya existe una carga del archivo $archivo.</div>";
		}else{
			$resultado = "";
		}

		mysqli_free_result($resultados);
		desconectar_bd($conexion_bd);

		echo "$resultado";
	}

// Mostrar el porcentaje de BN
	function porcentajeFaltante($id){

		$conexion_bd = conectar_bd();

		$busqueda="SELECT porcentaje FROM benef_empleado WHERE idEmpleado = ".$id." ";

		$resultados = $conexion_bd->query($busqueda);
		$suma = 0;
		while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)){
			$suma += $row['porcentaje'];
		}
		$max = 100 - $suma;
		$resultado = "<div class='alert alert-primary' role='alert'>* El pocentaje debe ser menor o igual a ".$max.".</div>";

		mysqli_free_result($resultados);
		desconectar_bd($conexion_bd);

		echo $resultado;
		return $suma;
	}

?>
