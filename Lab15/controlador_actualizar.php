<?php
  session_start();
  require_once("model.php");
  $titulo = "Modificar Entrega"

  $_POST["fecha"] = htmlspecialchars($_POST["fecha"]);
  $_POST["Proyecto"] = htmlspecialchars($_POST["proyecto"]);
  $_POST["Proveedor"] = htmlspecialchars($_POST["proveedor"]);
  $_POST["Material"] = htmlspecialchars($_POST["material"]);
  $_POST["Cantidad"] = htmlspecialchars($_POST["cantidad"]);

  if(isset($_POST["lugar"])) {
      if (editar_entrgea($_POST["fecha"], $_POST["proyecto"],$_POST["proveedor"], $_POST["material"], $_POST["cantidad"])) {
          $_SESSION["mensaje"] = "Se editó el caso";
      } else {
          $_SESSION["warning"] = "Ocurrió un error al editar el caso";
      }
  }

  header("location:index.php");
?>
