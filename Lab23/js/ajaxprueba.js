
//------------------------------
//------Botones de prueba-------
//-----------------------------
function avanzaPrueba(masMenos) {
	//Asignar porcentaje completado
	let calcPtg = $("#cantPruebaComplt").val();
  let edadB = $("#edadBenef").val();
  $("#progressBarPrueba").width(calcPtg+"%");




	var pond = $("#pondrAct").val();
	var arr = pond.split(" ", $("#contadorAct").val());
	var valor = [];

	for (var i = 0; i < $("#contadorAct").val(); i++) {
		if (arr[i]) {
			valor.push($('input:radio[name='+arr[i]+']:checked').val());
		}
	}
	// Reemplazar valores vacios dentro del arreglo por ceros
  var valores = Array.from(valor, v => v === undefined ? 0 : v);

	if (masMenos == "mas"){
		if ($("#seccionActual").val() <= 46) {
			$.get("controller_registro.php", {
				btnprueba : "mas",
				seccion : $("#seccionActual").val(),
				contadorAct : $("#contadorAct").val(),
				arrPond : valores
			}).done(function (data) {
					$("#tablaPrueba").html(data);
			});
			$(".alertTerminado").css("display", "none");
	} else {
		$("#sigPrueba").addClass("disabled");
		$("#sigPrueba").attr("disabled");
		$(".alertTerminado").show()
		}
	} else if (masMenos == "menos") {
		if ($("#seccionActual").val() > 1) {
			$.get("controller_registro.php", {
				btnprueba : "menos",
				seccion : $("#seccionActual").val(),
				contadorAct : $("#contadorAct").val(),
				arrPond : valores
			}).done(function (data) {
					$("#tablaPrueba").html(data);
			});
			$(".alertTerminado").css("display", "none");
	} else {
		$("#antPrueba").addClass("disabled");
		$("#antPrueba").attr("disabled");
		$(".alertTerminado").show()
		}
	}
}


$("#sigPrueba").click(function(){
	avanzaPrueba("mas");
});

$("#antPrueba").click(function(){
	avanzaPrueba("menos");
});
