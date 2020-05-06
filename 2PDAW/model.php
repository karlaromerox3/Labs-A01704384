<?php
function conectar_bd(){
    $conexion_bd = mysqli_connect("mysql1008.mochahost.com", "dawbdorg_1704384", "1704384", "dawbdorg_A01704384");
    if($conexion_bd == NULL)
    die("La base de datos está en mantenimiento, vuelve a intentarlo más tarde...");


    $conexion_bd->set_charset("utf8");
    return $conexion_bd;
}

//desconectarse de la bd
 function desconectar_bd($conexion_bd){
    mysqli_close($conexion_bd);
}



function consultar_incidentes(){
    $conexion_bd = conectar_bd();

     $resultado =  '<table class="highlight">
                        <thead>
                            <tr>
                                <th>Lugar</th>
                                <th>Incidente</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>';

    $consulta = 'SELECT DISTINCT L.nombre as lugar, T.nombre as incidente, I.fecha as fecha FROM lugar as L, tipo_incidente as T, incidente as I WHERE L.idLugar = I.idLugar AND I.idTipo = T.idTipo ORDER BY I.fecha DESC';


    $resultados = $conexion_bd->query($consulta);

     while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
         $resultado .= '<tr>';
         $resultado .= '<td>'.$row['lugar'].'</td>';
         $resultado .= '<td>'.$row['incidente'].'</td>';
         $resultado .= '<td>'.$row['fecha'].'</td></tr>';
     }

     mysqli_free_result($resultados); //Liberar la memoria

     desconectar_bd($conexion_bd);

     $resultado .= "</tbody></table>";
     return $resultado;
}


  function crear_select($id, $descripcion, $tabla, $required, $seleccion = 0)
  {
    $conexion_bd = conectar_bd();
    $resultado = "<label  for='".$tabla."'>".$tabla."</label>";
    $resultado .= "<div class='input-field col s12'><select id='".$tabla."' name='".$tabla."' ";
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
    $resultado .= "</select></div><br/>";
    return $resultado;
  }



function insertar_incidente($lugar="", $tipo=""){
    $conexion_bd = conectar_bd();

    //preparar la consulta
    //$dml = 'INSERT INTO zombie (nombre) VALUES(?)';
    $dml = 'CALL nuevoIncidente(?,?)';
    if ( !($statement = $conexion_bd->prepare($dml)) ) {
        die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
        return 0;
    }

    //Unir los parametros de la funcion con los parametros de la consulta
    if (!$statement->bind_param("ii", $lugar,$tipo)) {
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
