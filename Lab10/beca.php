<?php 
  require_once("util.php");

  if ( !(isset($_POST["nombre"]) && isset($_POST["apeido"]) && isset($_POST["ciudad"]) && isset($_POST["estado"]) && isset($_POST["email"]) && isset($_POST["tel"]) && isset($_POST["promedio"]))) {
    die();
  }

  $nombre = htmlspecialchars($_POST["nombre"]);
  $apeido = htmlspecialchars($_POST["apeido"]);
  $ciudad = htmlspecialchars($_POST["ciudad"]);
  $estado = htmlspecialchars($_POST["estado"]);
  $email = htmlspecialchars($_POST["email"]);
  $tel = htmlspecialchars($_POST["tel"]);
  $promedio = htmlspecialchars($_POST["promedio"]);
  
  include("_header.html");  

  aprobado($nombre, $apeido, $promedio, $estado);

  include("_footer.html"); 
?> 