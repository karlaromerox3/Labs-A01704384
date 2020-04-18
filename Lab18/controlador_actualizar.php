<?php
  session_start();
  require_once("model.php");

  $material = htmlspecialchars($_POST["Materiales"]);
  $proveedor = htmlspecialchars($_POST["Proveedores"]);
  $proyecto = htmlspecialchars($_POST["Proyectos"]);
  $fecha = htmlspecialchars($_POST["fecha"]);
  $cantidad = htmlspecialchars($_POST["cantidad"]);

  if(isset($material) && isset($proveedor) && isset($proyecto) && isset($fecha) && isset($cantidad))
  {
    if(editar($material, $proveedor, $proyecto, $fecha, $cantidad))
    {
      $_SESSION["mensaje"] = "Se edito la entrega!";
    }
    else
    {
      $_SESSION["warning"] = "Hubo un error al editar la entrega!";
    }
  }

  header("location:index.php");
?>
