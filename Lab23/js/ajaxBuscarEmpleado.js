function sendRequest(tabla)
{
    $userInput = $("#userInput"+tabla);
    $ajaxResponse = $("#ajaxResponse"+tabla);

    $.get("../controladores/empleados/controlador_ajaxEmpleado.php",{
        Tabla: tabla,
        pattern: $userInput.val(),
		status: $("#status").val()
    }).done(function (data) {

        $ajaxResponse.html(data);
        $ajaxResponse.css("visibility","visible");
    });

    buscar(false, true);
}

function selectValue(tabla)
{
    let list = document.getElementById("list");
    let userInput = document.getElementById("userInput"+tabla);
    let input = document.getElementById(tabla);
    let ajaxResponse = document.getElementById("ajaxResponse"+tabla);
    userInput.value = list.options[list.selectedIndex].text;
    input.value = list.options[list.selectedIndex].value;
    ajaxResponse.style.visibility = "hidden";
    $("#ajaxResponse"+tabla).empty();
    userInput.focus();
    buscar();
}

//Función que detonará la petición asíncrona como se hace ahora con la librería jquery
function buscar(reset, porNombre = null) {
    //$.post manda la petición asíncrona por el método post. También existe $.get
    if(porNombre == null)
    {
        $.post("../controladores/empleados/controlador_buscaEmpleado.php", {
            puesto: $("#puesto").val(),
            idEmpleado: $("#empleado").val(),
            status: $("#status").val(),
			nombre: $("#userInputempleado").val()
        }).done(function (data) {
            $("#resultados_consulta").html(data);
            if(reset)
            {
                $("#puesto").val("");
                $("#userInputempleado").val("");
                $("#empleado").val("");
            }
        });
    }
    else
    {
        $("#empleado").val("");
        $.post("../controladores/empleados/controlador_buscaEmpleado.php", {
            puesto: $("#puesto").val(),
            idEmpleado: $("#empleado").val(),
            status: $("#status").val(),
			nombre: $("#userInputempleado").val()
        }).done(function (data) {
            $("#resultados_consulta").html(data);
            if(reset)
            {
                $("#puesto").val("");
                $("#userInputempleado").val("");
                $("#empleado").val("");
            }
        });
    }
}

//Asignar al botón buscar, la función buscar()
$("#todoEmp").click(function(){
    $("#puesto").val("");
    $("#userInputempleado").val("");
    $("#empleado").val("");
    buscar(true);
});

$("#empleado").change(function(){
    buscar(false);
});

$("#puesto").change(function(){
    buscar(false);
});

$("#status").change(function(){
    buscar(false);
});

function clearName()
{
	$("#userInputempleado").val("");
	sendRequest("empleado");
}
