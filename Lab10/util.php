<?php
    function aprobado($nombre, $apeido, $promedio, $estado){
        if($promedio >= 85 && ($estado == "Queretaro" || $estado == "Nuevo Leon")){
            $resp = "Felicidades";
            $foto = "https://cdn0.iconfinder.com/data/icons/social-messaging-ui-color-shapes/128/check-circle-green-512.png";
            $msj =  " podemos determinar que usted es elegible para una beca dada por el gobierno federal, en la cual usted recibirá ayuda económica para continuar sus estudios. Lo felicitamos por su esfuerzo y lo exhortamos a que siga asi";
            
        }else{
            $resp = "Lo sentimos";
            $foto = "https://cdn.pixabay.com/photo/2017/02/12/21/29/false-2061131_960_720.png";
            $msj =  " podemos determinar que usted no es elegible para una beca dada por el gobierno federal, ya que es necesario que tenga un promedio más alto o que en su estado ya se haya agotado el presupuesto para las becas. Le recomendamos verificar en la oficina más cercana qué puede hacer para seguir con el proceso.";
        }
        include("_defbeca.html");
    }
?>