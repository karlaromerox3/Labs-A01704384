var calendar;

document.addEventListener('DOMContentLoaded', function() {
	var calendarEl = document.getElementById('calendar');


		document.getElementById('calendar').style.width = "100%";
		document.getElementById("calendar").style.height = "100%";



	calendar = new FullCalendar.Calendar(calendarEl, {
		  height: 650,

	  plugins: [ 'dayGrid', 'bootstrap', 'interaction' ],
	  themeSystem: "bootstrap",
	  aspectRatio: 1.8,
	  locale: 'es',
	  navLinks: true,
	  navLinkDayClick: function(date, jsEvent) {
		console.log('day', date.toISOString());
		console.log('coords', jsEvent.pageX, jsEvent.pageY);
	  },
	  dateClick: function(info)
	  {
		  addCalendarEvent(info);
	  },
	  header: {
		left: '',
		center: 'title',
		right: 'today prev,next'
	  },
	  height:'auto'
	});

	calendar.render();
	calendar.setOption('height', 700);

  });
