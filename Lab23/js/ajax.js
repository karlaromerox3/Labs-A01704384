

function sendRequest(tabla)
{
	$userInput = $("#userInput_"+tabla);
	$ajaxResponse = $("#ajaxResponse_"+tabla);

	$.get("../controladores/donantes/controlador_ajaxDonantes.php",{
		Tabla: tabla,
		pattern: $userInput.val(),
		status: $("#status").val()
	}).done(function (data) {

		$ajaxResponse.html(data);
		$ajaxResponse.css("visibility","visible");
	});

	buscarDonantes(false, true);
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
	buscarDonantes(false);
}

/*
	busqueda por ajax de donantes
	--------------------------------------
*/
function buscarDonantes(reset, porNombre = null)
{
	if(porNombre == null)
	{
		$.post("../controladores/donantes/controlador_buscarDonante.php", {
			donantes: $("#donantes").val(),
			tipodeDonante: $("#tipodeDonante").val(),
			status: $("#status").val(),
			nombre: $("#userInput_donantes").val()
		}).done(function (data) {
			$("#resultados_consulta").html(data);
			if(reset)
			{
				$("#donantes").val("");
				$("#userInput_donantes").val("");
				$("#tipodeDonante").val("");
			}
		});
	}
	else
	{
		$("#donantes").val("");
		$.post("../controladores/donantes/controlador_buscarDonante.php", {

			donantes: $("#donantes").val(),
			tipodeDonante: $("#tipodeDonante").val(),
			status: $("#status").val(),
			nombre: $("#userInput_donantes").val()
		}).done(function (data) {
			$("#resultados_consulta").html(data);
			if(reset)
			{
				$("#donantes").val("");
				$("#userInput_donantes").val("");
				$("#tipodeDonante").val("");
			}
		});
	}
}

$("#buscar").click(function(){
	$("#donantes").val("");
	$("#userInput_donantes").val("");
	$("#tipodeDonante").val("");
	buscarDonantes(true);
});

$("#tipodeDonante").change(function(){
	buscarDonantes(false);
});

$("#status").change(function(){
	buscarDonantes(false);
});

//------------------------------




function clearName()
{
	$("#userInput_donantes").val("");
	sendRequest("donantes");
}
