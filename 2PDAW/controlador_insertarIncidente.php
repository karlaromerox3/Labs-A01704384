<?php
    session_start();
    require_once("model.php");

    $lugar = htmlspecialchars($_POST["lugar"]);
    $tipo = htmlspecialchars($_POST["tipo_incidente"]);


    if(isset($lugar) && isset($tipo))
    {
        if(insertar_incidente($lugar, $tipo))
        {
            $_SESSION["mensaje"] = "Se registro un nuevo incidente!";
        }
        else
        {
            $_SESSION["warning"] = "Hubo un error al registrar el incidente!";
        }
    }

    header("location:index.php");
?>
