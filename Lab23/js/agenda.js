
document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
          plugins: [ 'dayGrid', 'googleCalendar', 'bootstrap', 'interaction' ],
          googleCalendarApiKey: 'AIzaSyCMHLcLpEp8wHPTBAs7pJEL9a7nn3HhEoc',
  			events: {
    		googleCalendarId: 'cmggeneral19@gmail.com',
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
      });



document.body.onresize = function()
{
	if(window.innerWidth < 992)
		document.getElementById("calendar").style.width = "100%";
	else if(window.innerWidth >= 992)
		document.getElementById("calendar").style.width = "40%";
}