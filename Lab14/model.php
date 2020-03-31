<?php
    //función para conectarnos a la BD
  function conectar_bd() {
      $conexion_bd = mysqli_connect("localhost","root","","lab14");
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



   //Consulta los casos de coronavirus
   function consultar_materiales($materiales="",$proveedores="",$proyectos="") {
     $conexion_bd = conectar_bd();

     $resultado =  "<table><thead><tr><th>Fecha</th><th>Proyecto</th><th>Proveedor</th><th>Material</th><th>Cantidad</th></tr></thead>";

    $consulta = 'Select E.fecha as fecha, P.Denominacion as proyecto , Prov.RazonSocial as proveedor, M.Descripcion as material, E.Cantidad as cantidad From entregan as E, proyectos as P, proveedores as Prov, materiales as M WHERE E.Clave = M.Clave AND E.Numero = P.Numero AND E.RFC = Prov.RFC';

     if ($materiales != "") {
        $consulta .= " AND M.Clave = ".$materiales;
    }
    if ($proveedores != "") {
        $consulta .= " AND Prov.RFC = ".$proveedores;
    }

    if ($proyectos != "") {
        $consulta .= " AND P.Numero = ".$proyectos;
    }

    $resultados = $conexion_bd->query($consulta);
     while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
         $resultado .= "<tr>";
         $resultado .= "<td>".$row["fecha"]."</td>"; //Se puede usar el índice de la consulta
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
  function crear_select($id, $columna_descripcion, $tabla) {
    $conexion_bd = conectar_bd();

    $resultado = '<div class="input-field"><select name="'.$tabla.'"><option value="" disabled selected>Selecciona una opción</option>';
    $consulta = "SELECT $id, $columna_descripcion FROM $tabla";
    $resultados = $conexion_bd->query($consulta);
    while ($row = mysqli_fetch_array($resultados, MYSQLI_BOTH)) {
        $resultado .= '<option value="'.$row["$id"].'">'.$row["$columna_descripcion"].'</option>';
    }

    desconectar_bd($conexion_bd);
    $resultado .=  '</select><label>'.$tabla.'...</label></div>';
    return $resultado;
  }


?>
