
function sendRequest(tabla)
{
	$userInput = $("#userInput_"+tabla);
	$ajaxResponse = $("#ajaxResponse_"+tabla);

	$.get("../controladores/controlador_buscarUAjax.php",{
		Tabla: tabla,
		pattern: $userInput.val()
	}).done(function (data) {

		$ajaxResponse.html(data);
		$ajaxResponse.css("visibility","visible");
	});

	buscarUsuario(false, true);
}

function selectValue(tabla)
{
	let list = document.getElementById("list");
	let userInput = document.getElementById("userInput_"+tabla);
	let input = document.getElementById(tabla);
	let ajaxResponse = document.getElementById("ajaxResponse_"+tabla);
	userInput.value = list.options[list.selectedIndex].text;
	input.value = list.options[list.selectedIndex].value;
	console.log(input.value);
	ajaxResponse.style.visibility = "hidden";
	$("#ajaxResponse_"+tabla).empty();
	userInput.focus();
	buscarUsuario(false);
}

/*
	busqueda por ajax de usuarios
	-----------------
*/
function buscarUsuario(reset, porNombre = null)
{
	if(porNombre == null)
	{
		$.post("../controladores/controlador_buscarU.php", {
			usuario: $("#usuario").val(),
			rol: $("#rol").val(),
			nombre: $("#userInput_usuario").val()
		}).done(function (data) {
			$("#resultados_consulta").html(data);
			if(reset)
			{
				$("#usuario").val("");
				$("#userInput_usuario").val("");
				$("#rol").val("");
			}
		});
	}
	else
	{
		$("#usuario").val("");
		$.post("../controladores/controlador_buscarU.php", {
			usuario: $("#usuario").val(),
			rol: $("#rol").val(),
			nombre: $("#userInput_usuario").val()
		}).done(function (data) {
			$("#resultados_consulta").html(data);
			if(reset)
			{
				$("#usuario").val("");
				$("#userInput_usuario").val("");
				$("#rol").val("");
			}
		});
	}
}

$("#buscar").click(function(){
	$("#usuario").val("");
	$("#userInput_usuario").val("");
	$("#rol").val("");
	buscarUsuario(true);
});

$("#rol").change(function(){
	buscarUsuario(false);
});

function clearName()
{
	$("#userInput_usuario").val("");
	sendRequest("usuario");
}
