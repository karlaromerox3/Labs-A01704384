 <?php
  session_start();
   require_once("model.php");
   include("_header.html");
   include("mensaje.html");
   include("_inicio.html");
   include("_formaBuscar.html");

  echo '<div id="resultados_consulta">';
  echo consultar_incidentes();
  echo '</div>';

   include("_footer.html");
 ?>
