import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";

window.initContentCalendar = function (events = []) {
    let calendarEl = document.getElementById("calendar");

    if (!calendarEl) {
        return;
    }

    if (window.contentCalendar) {
        window.contentCalendar.destroy();
    }

    window.contentCalendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, interactionPlugin],

        initialView: "dayGridMonth",

        locale: "id",

        height: "auto",

        events: events,

        // Hilangkan toolbar bawaan FullCalendar
        headerToolbar: false,

        dayMaxEvents: true,

        eventDisplay: "block",

        dateClick(info) {
            alert("Tanggal dipilih: " + info.dateStr);
        },

        eventClick(info) {
            alert("Konten: " + info.event.title);
        },
    });

    window.contentCalendar.render();
};
