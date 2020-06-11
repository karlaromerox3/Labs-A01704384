/*
$(function() {
	$('input[name="daterange"]').daterangepicker({
	  opens: 'left'
	}, function(start, end, label) {
	  console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
	});
  });
*/
  $('input[name="daterange"]').daterangepicker({
	"showDropdowns": true,
	autoUpdateInput: false,
    ranges: {
        'Hoy': [moment(), moment()],
        'Ultimos 30 dias': [moment().subtract(29, 'days'), moment()],
		'Este Mes': [moment().startOf('month'), moment().endOf('month')],
		'Ultimos 6 Meses': [moment().subtract(6, 'month'), moment()],
		'Ultimo Año': [moment().subtract(1, 'year'), moment()]
    },
    "locale": {
        "format": "MM/DD/YYYY",
        "separator": " - ",
        "applyLabel": "Aceptar",
        "cancelLabel": "Cancelar",
        "fromLabel": "Desde",
        "toLabel": "Hasta",
        "customRangeLabel": "Personalizado",
        "weekLabel": "W",
        "daysOfWeek": [
            "Dom",
            "Lun",
            "Mar",
            "Mier",
            "Jue",
            "Vie",
            "Sab"
        ],
        "monthNames": [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        ],
        "firstDay": 1
    },
	"alwaysShowCalendars": true,

}, function(start, end, label) {
  console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
});

$('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
	$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
});

$('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
	$(this).val('');
});
