<?php
  session_start();
  require_once("model.php");
  $titulo = "Modificar Entrega"

  $_POST["lugar"] = htmlspecialchars($_POST["lugar"]);
  $_POST["caso_id"] = htmlspecialchars($_POST["caso_id"]);

  if(isset($_POST["lugar"])) {
      if (editar_caso($_POST["caso_id"], $_POST["lugar"])) {
          $_SESSION["mensaje"] = "Se editó el caso";
      } else {
          $_SESSION["warning"] = "Ocurrió un error al editar el caso";
      }
  }

  header("location:index.php");
?>
