 <?php
  session_start();
   require_once("model.php");
   $titulo = "Consultas a una BD";
   include("html/_header.html");
   include("html/_retro.html");
   include("html/_forma_Buscar.html");
   include("html/btn_registrar.html");


   if (isset($_POST["Materiales"])) {
      $materiales = htmlspecialchars($_POST["Materiales"]);
  } else {
      $materiales = "";
  }

    if (isset($_POST["Proveedores"])) {
      $proveedores = htmlspecialchars($_POST["Proveedores"]);
  } else {
      $proveedores = "";
  }

  if (isset($_POST["Proyectos"])) {
      $proyectos = htmlspecialchars($_POST["Proyectos"]);
  } else {
      $proyectos = "";
  }


  echo consultar_materiales($materiales,$proveedores,$proyectos);

   include("html/_footer.html");
 ?>

