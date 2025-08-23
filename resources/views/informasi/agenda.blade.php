<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda Kegiatan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite('resources/css/app.css')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js'></script>

    <style>

        .modal-header-custom {
            background-color: #0a2463;
            color: white;
            border-bottom: none;
        }

        .fc-event {
            cursor: pointer;
        }

        #calendar {
            font-size: 0.85rem;
            max-width: 900px;
            margin: 0 auto;
        }

        .fc .fc-toolbar-title {
            font-size: 1.2rem;
        }

        .fc .fc-daygrid-day-number {
            font-size: 0.8rem;
            padding: 2px;
        }

        .fc .fc-event {
            font-size: 0.75rem;
        }
    </style>
</head>

<body class="bg-light">
    <x-navbar />

    <header class="position-relative"
        style="height: 250px; background: url('{{ asset('pictures/agenda.jpg') }}') top center / cover no-repeat;">
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark" style="opacity: 0.7;"></div>
        <div class="position-absolute top-50 start-50 translate-middle text-white text-center">
            <h1 style="font-size: 40px;" class="fw-bold">Agenda Kegiatan</h1>
        </div>
    </header>

    <main class="container my-5">
        <div class="bg-white p-4 p-md-5 rounded-4 shadow">
            <div id="calendar"></div>
        </div>
    </main>

    {{-- Reusable Modal Structure for Event Details --}}
    <div class="modal fade" id="eventDetailModal" tabindex="-1" aria-labelledby="eventDetailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4 overflow-hidden shadow-lg">
                <div class="modal-header modal-header-custom">
                    <h5 class="modal-title w-100 text-center" id="eventDetailModalLabel">Detail Kegiatan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="p-4 bg-white">
                        <h2 class="fw-bold text-center mb-4" id="modal-title"></h2>
                        <img id="modal-image" src="" class="img-fluid rounded-3 w-100 mb-4"
                            style="max-height: 300px; object-fit: cover;" alt="Event Image">

                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-calendar-event fs-4 me-3 text-dark"></i>
                            <span id="modal-date"></span>
                        </div>
                        <div class="d-flex align-items-center mb-4">
                            <i class="bi bi-geo-alt fs-4 me-3 text-dark"></i>
                            <span id="modal-location"></span>
                        </div>
                        <p id="modal-description"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-footer />

    {{-- JavaScript Libraries --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Custom JavaScript to initialize FullCalendar and handle modal --}}
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const eventModal = new bootstrap.Modal(document.getElementById('eventDetailModal'));

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'id',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,listWeek'
            },
            
            events: '/public-events', // Fetch events from the public API

            eventClick: function(info) {
                info.jsEvent.preventDefault();
                
                // Only open the detail modal if the event is an 'agenda'
                if (info.event.extendedProps.type === 'agenda') {
                    const event = info.event;
                    const props = event.extendedProps;

                    document.getElementById('modal-title').textContent = event.title;
                    document.getElementById('modal-date').textContent = event.start.toLocaleDateString(
                        'id-ID', {
                            day: 'numeric',
                            month: 'long',
                            year: 'numeric'
                        });
                    document.getElementById('modal-location').textContent = props.location;
                    document.getElementById('modal-description').textContent = props.description;
                    document.getElementById('modal-image').src = props.image;

                    eventModal.show();
                }
            }
        });

        calendar.render();
    });
</script>
</body>

</html>
