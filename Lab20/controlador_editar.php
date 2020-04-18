<?php
  session_start();
  require_once("model.php");
  $titulo="Editar";
  $fecha = htmlspecialchars($_GET["fecha"]);

  include("html/_header.html");

  $clave = recuperar_campo($fecha, "Clave");
  $rfc = recuperar_campo($fecha, "RFC");
  $numero = recuperar_campo($fecha, "Numero");
  $cantidad = recuperar_campo($fecha, "Cantidad");
  include("html/_forma_editar.html");

  include("html/_footer.html");
?>
