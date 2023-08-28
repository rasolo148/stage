document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin],
        initialView: 'dayGridMonth',
        events: [
            {
                title: 'Event 1',
                start: '2023-08-10T10:00:00',
                end: '2023-08-10T12:00:00'
            },
            {
                title: 'Event 2',
                start: '2023-08-15T15:30:00',
                end: '2023-08-15T17:00:00'
            },
            // Add more events here...
        ]
    });

    calendar.render();
});
