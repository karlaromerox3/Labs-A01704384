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



function insertar_zombie($nombreZ="", $estado=""){
    $conexion_bd = conectar_bd();

    //preparar la consulta
    //$dml = 'INSERT INTO zombie (nombre) VALUES(?)';
    $dml = 'CALL nuevoZombie(?)';
    if ( !($statement = $conexion_bd->prepare($dml)) ) {
        die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
        return 0;
    }

    //Unir los parametros de la funcion con los parametros de la consulta
    if (!$statement->bind_param("s", $nombreZ)) {
        die("Error en vinculación: (" . $statement->errno . ") " . $statement->error);
        return 0;
    }

    ///Ejecutar inserción
    if(!$statement->execute())
    { die("Error en ejecución: (".$statement->errno.") ".$statement->error);
      return 0;
    }

    //OBTENER EL ULTIMO ID PARA PONER SU ESTADO
    $id = getLast();

    insertarEstado($id,$estado);


    desconectar_bd($conexion_bd);
    return 1;
}

function getLast(){
    $consulta = 'SELECT idZombie as id FROM zombie ORDER BY idZombie DESC LIMIT 1';
    $conexion_bd = conectar_bd();

    $resultados = $conexion_bd->query($consulta);
    $last ="";
     while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
         $last .= $row["id"];
     }

     mysqli_free_result($resultados); //Liberar la memoria

     desconectar_bd($conexion_bd);

     return $last;
}


function insertarEstado($idZ, $estado){
    $conexion_bd = conectar_bd();

    //preparar la consulta
    $dml = 'CALL nuevoEstado(?,?)';
    if ( !($statement = $conexion_bd->prepare($dml)) ) {
        die("Error: (" . $conexion_bd->errno . ") " . $conexion_bd->error);
        return 0;
    }

    //Unir los parametros de la funcion con los parametros de la consulta
    if (!$statement->bind_param("ii", $idZ, $estado)) {
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


function totalZombies(){
    $conexion_bd = conectar_bd();

     $resultado =  '<h3>Total de zombies registrados:  ';

    $consulta = 'SELECT count(Z.idZombie) as total FROM zombie as Z';


    $resultados = $conexion_bd->query($consulta);

     while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
         $resultado .= ''.$row['total'].'</h3>';

     }

     mysqli_free_result($resultados); //Liberar la memoria

     desconectar_bd($conexion_bd);
     return $resultado;

}


function cpeZombies($estado=""){
    $conexion_bd = conectar_bd();

    $resultado = totalZombies();
    $resultado .= '<br>';
     $resultado .=  '<table class="highlight">
                        <thead>
                            <tr>
                                <th>Estado</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>';

    $consulta = 'SELECT E.nombre as est, count(T.idZombie) as cantidad FROM estado as E, tiene as T WHERE E.idEstado = T.idEstado ';

    if ($estado != "") {
        $consulta .= " AND T.idEstado = ".$estado." GROUP BY E.nombre";
    }else{
        $consulta .= " GROUP BY E.nombre";
    }

    $resultados = $conexion_bd->query($consulta);

     while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
         $resultado .= '<tr>';
         $resultado .= '<td>'.$row['est'].'</td>';
         $resultado .= '<td>'.$row['cantidad'].'</td>';

     }

     mysqli_free_result($resultados); //Liberar la memoria

     desconectar_bd($conexion_bd);

     $resultado .= "</tbody></table>";
     return $resultado;
}


//consulta por fecha de registro
function zprZombies(){
    $conexion_bd = conectar_bd();
    $resultado =  '<h5>"Todos los registros de actualización de estado de zombis del más reciente al más antiguo por la fecha de su registro."</h5>';
     $resultado .=  '<table class="highlight">
                        <thead>
                            <tr>
                                <th>Zombie</th>
                                <th>Estado</th>
                                <th>Fecha de actualización</th>
                                <th>Fecha de registro</th>
                            </tr>
                        </thead>
                        <tbody>';

    $consulta = 'SELECT  Z.idZombie as idZ, Z.nombre as nombreZ, Z.fechaCreacion as fechaC, E.nombre as estadoZ, T.fecha as fecha FROM zombie as Z, estado as E, tiene as T WHERE Z.idZombie = T.idZombie AND E.idEstado = T.idEstado ORDER BY Z.fechaCreacion DESC';


    $resultados = $conexion_bd->query($consulta);

     while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
         $resultado .= '<tr>';
         $resultado .= '<td>'.$row['nombreZ'].'</td>';
         $resultado .= '<td>'.$row['estadoZ'].'</td>';
         $resultado .= '<td>'.$row['fecha'].'</td>';
          $resultado .= '<td>'.$row['fechaC'].'</td>';
         $resultado .= '</tr>';
     }

     mysqli_free_result($resultados); //Liberar la memoria

     desconectar_bd($conexion_bd);

     $resultado .= "</tbody></table>";
     return $resultado;
}
