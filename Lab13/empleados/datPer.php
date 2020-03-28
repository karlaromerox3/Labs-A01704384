<?php

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fotoEmpleado"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fotoEmpleado"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["fotoEmpleado"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fotoEmpleado"]["tmp_name"], $target_file)) {

        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }


    //checking data

    if(!(isset($_POST["nombreEmp"]) && isset($_POST["apellidoPatEmp"]) && isset($_POST["apellidoMatEmp"])
       && isset($_POST["fechaNacimiento"]) && isset($_POST["rfcEmp"]) && isset($_POST["curpEmp"]) && isset($_POST["segsocialEmp"]))){
        die("Checar datos");
    }

    $foto = "uploads/".$_FILES["fotoEmpleado"]["name"];
    $nombreEmp = htmlspecialchars($_POST["nombreEmp"]);
    $apellidoPatEmp = htmlspecialchars($_POST["apellidoPatEmp"]);
    $apellidoMatEmp = htmlspecialchars($_POST["apellidoMatEmp"]);
    $fechaNacimiento = htmlspecialchars($_POST["fechaNacimiento"]);
    $edad = (int)date('Y-m-d') - (int)$fechaNacimiento;
    $rfcEmp = htmlspecialchars($_POST["rfcEmp"]);
    $curpEmp = htmlspecialchars($_POST["curpEmp"]);
    $segsocialEmp = htmlspecialchars($_POST["segsocialEmp"]);

    include("_sidebars.html");
    include("_verEmpleado.html");
    include("_footer.html");

?>
