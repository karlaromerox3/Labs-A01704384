<?php
    //función para conectarnos a la BD
  function conectar_bd() {
      $conexion_bd = mysqli_connect("localhost","root","","Lab14");
      if ($conexion_bd == NULL) {
          die("No se pudo conectar con la base de datos");
      }
      return $conexion_bd;
    }

     //función para desconectarse de una bd
     //@param $conexion: Conexión de la bd que se va a cerrar
  function desconectar_bd($conexion_bd) {
       mysqli_close($conexion_bd);
    }



   //Consulta las entregas a proveedores
   function consultar_materiales($materiales="",$proveedores="",$proyectos="") {
    echo "Hola Mundo";
     $conexion_bd = conectar_bd();

     $resultado =  "<table><thead><tr><th>Fecha</th><th>Proyecto</th><th>Proveedor</th><th>Material</th><th>Cantidad</th></tr></thead>";

    $consulta = 'Select E.fecha as fecha, P.Denominacion as proyecto , Prov.RazonSocial as proveedor, M.Descripcion as material, E.Cantidad as cantidad From entregan as E, proyectos as P, proveedores as Prov, materiales as M WHERE E.Clave = M.Clave AND E.Numero = P.Numero AND E.RFC = Prov.RFC';

     if ($materiales != "") {
        $consulta .= " AND M.Clave = ".$materiales;
    }
    if ($proveedores != "") {
        $consulta .= " AND E.RFC = '".$proveedores."'";
    }

    if ($proyectos != "") {
        $consulta .= " AND P.Numero = ".$proyectos;
    }

    $resultados = $conexion_bd->query($consulta);
     while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
         $resultado .= "<tr>";
         $resultado .= '<td><a href="controlador_editar.php?fecha='.$row['fecha'].'">'.$row["fecha"]."</td>"; //Se puede usar el índice de la consulta
         $resultado .= "<td>".$row['proyecto']."</td>"; //o el nombre de la columna
         $resultado .= "<td>".$row['proveedor']."</td>";
         $resultado .= "<td>".$row['material']."</td>";
         $resultado .= "<td>".$row['cantidad']."</td>";
         $resultado .= "</tr>";
     }

     mysqli_free_result($resultados); //Liberar la memoria

     desconectar_bd($conexion_bd);

     $resultado .= "</tbody></table>";
     return $resultado;
   }


   //Crea un select con los datos de una consulta
  //$id: Campo en una tabla que contiene el id
  //$columna_descripcion: Columna de una tabla con una descripción
  //$tabla: La tabla a consultar en la bd
  function crear_select($id, $descripcion, $tabla, $required, $seleccion = 0)
  {
    $conexion_bd = conectar_bd();
    $resultado = "<label  for='".$tabla."'>".$tabla."</label>";
    $resultado .= "<select id='".$tabla."' name='".$tabla."' ";
    if($required)
    {
      $resultado .= "required";
    }
    $resultado .= "><option value='' disabled selected>Selecciona una opción</option>";

    $consulta = "SELECT $id, $descripcion FROM $tabla";
    $resultados = $conexion_bd->query($consulta);
    while($row = mysqli_fetch_array($resultados, MYSQLI_BOTH))
    {
      $resultado .= "<option value='".$row["$id"]."' ";
      if($seleccion === $row["$id"])
      {
        $resultado .= "selected";
      }
      $resultado .= ">".$row["$descripcion"]."</option>";
    }

    desconectar_bd($conexion_bd);
    $resultado .= "</select><br/>";
    return $resultado;
  }

  //Funcion para insertar en la tabla entregan
  //@param $Clave: id de materiales
  //@param $RFC: id de proveedores
  //@param $Numero: id clave de proyectos
  //@param $Fecha: fecha de la entrega
  //@param $Cantidad: cantidad de material entregado
  function insertar_entrega($clave, $RFC, $numero, $fecha,$cantidad) {
    $conexion_bd = conectar_bd();

    //Preparar la consulta
    $dml = 'INSERT INTO Entregan (Clave, RFC, Numero,Fecha, Cantidad) VALUES (?,?,?,?,?) ';
    if ( !($statement = $conexion_bd->prepare($dml)) ) {
        die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
        return 0;
    }

    //Unir los parametros de la funcion con los parametros de la consulta
    if (!$statement->bind_param("isisd", $clave,$RFC,$numero, $fecha, $cantidad)) {
        die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
        return 0;
    }

    ///Ejecutar inserción
    if(!$statement->execute())
    { die("Error en ejecución: (".$statement->errno.") ".$statement->error);
      return 0;
    }

    desconectar_bd($conexion_bd);
    return 1;
  }

 //modificar una entrega
  function editar($clave, $rfc, $numero, $fecha, $cantidad) {
   $conexion_bd = conectar_bd();

    //Prepara la consulta
    $dml_editar = 'UPDATE Entregan SET Clave=(?), RFC=(?), Numero=(?), Cantidad=(?) WHERE Fecha=(?)';
    if ( !($statement = $conexion_bd->prepare($dml_editar)) ) {
      die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
      return 0;
    }

    //Unir los parámetros de la función con los parámetros de la consulta
    //El primer argumento de bind_param es el formato de cada parámetro
    if (!$statement->bind_param("isids", $clave, $rfc, $numero, $cantidad, $fecha)) {
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


   function recuperar_campo($fecha, $campo) {
    $conexion_bd = conectar_bd();

    $consulta = "SELECT $campo FROM Entregan WHERE Fecha='$fecha'";
    $resultados = $conexion_bd->query($consulta);
    while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
      desconectar_bd($conexion_bd);
      return $row["$campo"];
    }

    desconectar_bd($conexion_bd);
    return 0;
    }



?>
