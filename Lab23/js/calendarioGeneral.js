var calendar;

$( window ).on( "load",
function() {
    $('.fc-day-grid-event').attr('target', '_blank');
});

document.addEventListener('DOMContentLoaded', function() {
	var calendarEl = document.getElementById('calendar');

	if(window.innerWidth < 992)
		document.getElementById("calendar").style.width = "100%";
	else if(window.innerWidth >= 992)
		document.getElementById("calendar").style.width = "50%";


	calendar = new FullCalendar.Calendar(calendarEl, {
	  plugins: [ 'dayGrid', 'googleCalendar', 'bootstrap', 'interaction' ],
	  googleCalendarApiKey: 'AIzaSyBTo7Po2NgsECx-1tL_WD5OPJDyUdOuDjY',

  	  events: {
    	googleCalendarId: 'cmggeneral19@gmail.com'
  	  },

	  themeSystem: "bootstrap",
	  aspectRatio: 1.4,
	  locale: 'es',
	  navLinks: true,
	  eventLimit: 2,
	  navLinkDayClick: function(date, jsEvent) {
		console.log('day', date.toISOString());
		console.log('coords', jsEvent.pageX, jsEvent.pageY);
	  }
	});

		calendar.render();
		if(window.innerWidth < 1800)
			calendarEl.style.width = "100%";
		else if(window.innerWidth >= 1200)
			calendarEl.style.width = "60%";
      });



document.body.onresize = function()
{
	if(window.innerWidth < 1200)
		document.getElementById("calendar").style.width = "100%";
	else if(window.innerWidth >= 1200)
		document.getElementById("calendar").style.width = "50%";
}



