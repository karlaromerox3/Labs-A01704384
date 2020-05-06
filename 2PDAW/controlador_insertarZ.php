<?php
    session_start();
    require_once("model.php");

    $nombreZ = htmlspecialchars($_POST["nombreZ"]);
    $estado = htmlspecialchars($_POST["estado"]);


    if(isset($nombreZ) && isset($estado))
    {
        if(insertar_zombie($nombreZ, $estado))
        {
            $_SESSION["mensaje"] = "Se registro un zombie nuevo!";
        }
        else
        {
            $_SESSION["warning"] = "Hubo un error al registrar el zombie!";
        }
    }

    header("location:index.php");
?>
