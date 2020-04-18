<?php
    session_start();
    require_once("model.php");
    $materiales = htmlspecialchars($_POST["materiales"]);
    $proveedores = htmlspecialchars($_POST["proveedores"]);
    $proyectos = htmlspecialchars($_POST["proyectos"]);
    echo consultar_materiales($materiales,$proveedores,$proyectos);
?>
