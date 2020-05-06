<?php
    session_start();
    require_once("model.php");
    $lugar = htmlspecialchars($_POST["lugar"]);
    $tipo = htmlspecialchars($_POST["tipo_incidente"]);

    echo consultar_incidentes($lugar, $tipo);
?>
