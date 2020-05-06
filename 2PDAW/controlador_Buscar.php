<?php
    session_start();
    require_once("model.php");
    $estado = htmlspecialchars($_POST["estado"]);

    echo cpeZombies($estado);
?>
