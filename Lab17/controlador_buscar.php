<?php
    session_start();
    require_once("model.php");
    $materiales = htmlspecialchars($_GET["materiales"]);
    $proveedores = htmlspecialchars($_GET["proveedores"]);
    $proyectos = htmlspecialchars($_GET["proyectos"]);
    echo consultar_materiales($materiales,$proveedores,$proyectos);
?>
