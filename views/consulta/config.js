document.addEventListener('DOMContentLoaded', function () {

    var calendarEl = document.getElementById('calendar');
    if (calendarEl) {
        var calendar = new FullCalendar.Calendar(calendarEl, {
            headerToolbar: {
                left: "prev,next today",
                center: "title",
                right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth"
            },
            initialView: "dayGridMonth",
            
        });
    calendar.render();
    }

    calendar.render();
    });