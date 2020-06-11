$(document).ready(function() {
  update_progress_bar();
  $('textarea').each(function(){
            $(this).val($(this).val().trim());
        }
    );
});

$("#subir").click(function(){
  $('#subir').html(" <span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>Cargando...");
	$('#subir').prop("disabled", true);
})

function recuperarPruebasAComparar() {
  let idPruebas = [];
  $.each($("input[name='cardPruebas']:checked"), function(){
                idPruebas.push($(this).val());
              });
  if (idPruebas.length >= 2) {
    $('.modalComparar').modal('toggle');
    const checkboxes = document.querySelectorAll('input[name="cardPruebas"]:checked');
    let idsprueba = [];
    checkboxes.forEach((checkbox) => {
    idsprueba.push(checkbox.value);
    });
    let uno = idsprueba[0];
    let dos = idsprueba[1];
    let str = "compararPrueba.php?PruebaUno="+uno+"&PruebaDos="+dos;
    $("#hrefComparar").attr("href", str);

  } else {
    $('.toast').toast({ delay: 4000 });
    $('.toast').toast('show');
  }
}

$("#compararPrueba").click(recuperarPruebasAComparar);

function update_progress_bar() {
  let calcPtg = $("#cantPruebaComplt").val();
  let edadB = $("#edadBenef").val();
  $("#progressBarPrueba").width(calcPtg+"%");
}

function mostrar_plan_trabajo () {
  $(".guardar_boton_prueba").css('display','none');
  $("#exportar_btn").prop("disabled", false);
  $('.toast').toast({ delay: 4000 });
  $('.toast').toast('show');
}

function mostrar_boton_guardar() {
  $(".guardar_boton_prueba").css('display','block');
  $("#exportar_btn").prop("disabled", true);
}

$("#mostrar_todo_boton").click(mostrar_plan_trabajo);
$("#mostrar_todo_boton").click(mostrar_plan_trabajo);


function guardar_prueba () {
  update_progress_bar();
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

  $.get("controller_guardar_prueba.php", {
    btnprueba : "menos",
    seccion : $("#seccionActual").val(),
    contadorAct : $("#contadorAct").val(),
    arrPond : valores
  }).done(function (data) {
      $("#toast").html(data);
      $('.toast').toast({ delay: 2000 });
      $('.toast').toast('show');
  });
}


function irCategoria(cat) {
	guardar_prueba();
  update_progress_bar();
	$.get("controller_categoria.php", {
		catAct : $("#"+cat).val()

	}).done(function (data) {
			$("#tablaPrueba").html(data);
	});
}


$(".btnSalir").click(guardar_prueba);

// Agregar busqueda por catedoria dentro de prueba
//---------------AREAS----------------
$("#btnMotora").click(function(){
	irCategoria("Motora");
});
$("#btnAcad").click(function(){
	irCategoria("Academica");
});
$("#btnSocial").click(function(){
	irCategoria("Social");
});
//---------------HABILIDADES----------------
$("#btnHAcad").click(function(){
	irCategoria("HAcad");
});
$("#btnHComu").click(function(){
	irCategoria("HComu");
});
$("#btnHSocial").click(function(){
	irCategoria("HSocial");
});

$("#btnHAutocuid").click(function(){
	irCategoria("HAutocuid");
});
$("#btnHVida").click(function(){
	irCategoria("HVida");
});
$("#btnHAutodirec").click(function(){
	irCategoria("HAutodirec");
});

$("#btnHRecurs").click(function(){
	irCategoria("HRecurs");
});
$("#btnHOcio").click(function(){
	irCategoria("HOcio");
});
$("#btnHTrabajo").click(function(){
	irCategoria("HTrabajo");
});

$("#btnHSalud").click(function(){
	irCategoria("HSalud");
});
