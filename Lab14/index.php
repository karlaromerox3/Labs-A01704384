 <?php
   require_once("model.php");

   include("_header.html");
   include("_form.html");


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

  echo $proveedores;


  echo consultar_materiales($materiales,$proveedores,$proyectos);

   include("_footer.html");
 ?>

