
//Función que detonará la petición asíncrona como se hace ahora con la librería jquery
function buscar() {
    //$.post manda la petición asíncrona por el método post. También existe $.get
    $.post("controlador_Buscar.php", {
        lugar: document.getElementById("lugar").value,
        tipo_incidente: document.getElementById("tipo_incidente").value
    }).done(function (data) {
        $("#resultados_consulta").html(data);
    });
}

//Asignar al botón buscar, la función buscar()
document.getElementById("buscar").onclick = buscar;
