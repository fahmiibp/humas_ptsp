import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
window.initContentCalendar = function (events = []) {
    const calendarEl = document.getElementById("calendar");
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
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "",
        },
        buttonText: {
            today: "Hari Ini",
        },
        dayMaxEvents: true,
        eventDisplay: "block",
        eventContent(arg) {
            console.log(arg.event.extendedProps);

            const time = arg.event.extendedProps.jam ?? "";

            return {
                html: `

        <div class="calendar-event-custom">


            <div class="event-title">
                ${arg.event.title}
            </div>



            ${
                time
                    ? `
                    <div class="event-time">
                        ${time.substring(0, 5)}
                    </div>
                    `
                    : ""
            }


        </div>

        `,
            };
        },
        dateClick(info) {
            window.location.href =
                "/admin/konten-medsos/create?tanggal=" + info.dateStr;
        },
        eventClick(info) {
            const event = info.event;
            const data = event.extendedProps;
            const statusClass =
                {
                    Draft: "bg-slate-100 text-slate-700",
                    Review: "bg-yellow-100 text-yellow-700",
                    "Siap Tayang": "bg-blue-100 text-blue-700",
                    Published: "bg-green-100 text-green-700",
                    Ditolak: "bg-red-100 text-red-700",
                }[data.status] ?? "bg-gray-100 text-gray-700";
            const modal = document.createElement("div");
            modal.className =
                "fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 backdrop-blur-sm";
            modal.innerHTML = `


<div class="w-full max-w-lg rounded-2xl bg-white shadow-xl overflow-hidden">


    <div class="p-6">


        <div class="flex justify-between items-start">


            <div>


                <div class="flex gap-2">


                    <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-600">

                        ${data.platform ?? "-"}

                    </span>



                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">

                        ${data.status ?? "-"}

                    </span>


                </div>


                <h2 class="mt-4 text-xl font-bold text-gray-900">

                    ${event.title}

                </h2>


            </div>




            <button
            id="closeModal"
            class="text-gray-400 hover:text-gray-700">

                ✕

            </button>



        </div>



        <div class="mt-6 space-y-4">


            <div>


                <p class="text-xs text-gray-500">
                    Jadwal Tayang
                </p>


                <p class="font-medium text-gray-900">

                    ${data.tanggal ?? "-"}

                    ${data.jam ? " • " + data.jam : ""}

                </p>


            </div>




            <div>


                <p class="text-xs text-gray-500">
                    Platform
                </p>


                <p class="font-medium">

                    ${data.platform ?? "-"}

                </p>


            </div>




            <div>


                <p class="text-xs text-gray-500">
                    Format
                </p>


                <p class="font-medium">

                    ${data.format ?? "-"}

                </p>


            </div>




            <div>


                <p class="text-xs text-gray-500">
                    Hashtag
                </p>


                <p class="font-medium text-blue-600">

                    ${data.hashtag ?? "-"}

                </p>


            </div>



        </div>


    </div>



    <div class="flex justify-end gap-3 border-t bg-gray-50 px-6 py-4">


        <button
        id="deleteContent"
        class="rounded-xl bg-red-500 px-4 py-2 text-sm text-white">

            Delete

        </button>



        <button
        id="editContent"
        class="rounded-xl bg-blue-600 px-4 py-2 text-sm text-white">

            Edit

        </button>


    </div>


</div>


`;
            document.body.appendChild(modal);
            document.getElementById("closeModal").onclick = () =>
                modal.remove();
            document.getElementById("editContent").onclick = () => {
                window.location.href =
                    "/admin/konten-medsos/" + event.id + "/edit";
            };
            document.getElementById("deleteContent").onclick = () => {
                if (confirm("Apakah yakin ingin menghapus konten ini?")) {
                    fetch(
                        "/admin/konten-medsos/" + event.id + "/calendar-delete",
                        {
                            method: "DELETE",
                            headers: {
                                "X-CSRF-TOKEN": document
                                    .querySelector('meta[name="csrf-token"]')
                                    .getAttribute("content"),
                            },
                        },
                    )
                        .then((response) => response.json())
                        .then((result) => {
                            if (result.success) {
                                modal.remove();
                                window.location.reload();
                            }
                        });
                }
            };
        },
        eventDidMount(info) {
            const status = info.event.extendedProps.status ?? "";

            const color =
                {
                    Draft: "#94a3b8",
                    Review: "#f59e0b",
                    "Siap Tayang": "#3b82f6",
                    Published: "#22c55e",
                    Ditolak: "#ef4444",
                }[status] ?? "#64748b";

            info.el.style.backgroundColor = color;

            info.el.style.borderColor = color;

            info.el.style.borderRadius = "8px";

            info.el.style.padding = "3px 6px";
        },
    });

    window.contentCalendar.render();
    function applyFilters() {
        const status = document.getElementById("filterStatus")?.value ?? "all";
        const platform =
            document.getElementById("filterPlatform")?.value ?? "all";
        const filteredEvents = events.filter((event) => {
            const statusMatch =
                status === "all" || event.extendedProps.status === status;
            const platformMatch =
                platform === "all" || event.extendedProps.platform === platform;
            return statusMatch && platformMatch;
        });
        window.contentCalendar.removeAllEvents();
        window.contentCalendar.addEventSource(filteredEvents);
    }
    document
        .getElementById("filterStatus")
        ?.addEventListener("change", applyFilters);
    document
        .getElementById("filterPlatform")
        ?.addEventListener("change", applyFilters);
};
