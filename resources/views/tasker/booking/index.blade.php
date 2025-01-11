@extends('tasker.layouts.main')

@section('content')
    <style>
        /* General Calendar Styles */
        .fc-toolbar {
            background-color: #f8f9fa;
            /* Light grey toolbar for a clean look */
            border-bottom: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
        }

        /* Header Toolbar Buttons */
        .fc-toolbar .fc-button {
            background-color: #142c4d !important;
            /* Primary blue color for buttons */
            border: none;
            color: rgb(255, 255, 255) !important;
            padding: 5px 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .fc-toolbar .fc-button:hover {
            background-color: #0056b3;
        }

        /* Day and Time Slots */
        .fc-timegrid-slot {
            border-bottom: 1px solid #e9ecef;
            /* Subtle lines for time slots */
        }

        .fc-day-today {
            background-color: #ffffff !important;
            /* Light blue for the current day */
        }

        /* Event Styles */
        .fc-event {
            border-radius: 10px;
            /* Rounded corners for events */
            font-size: 12px;
            padding: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* Subtle shadow for depth */
        }

        .fc-event:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            /* Slightly enhanced shadow on hover */
        }

        /* Modal Design */
        #eventDetailsModal .modal-header {
            border-bottom: none;
        }

        #eventDetailsModal .modal-footer {
            border-top: none;
        }

        /* Unavailable Slot Styling */
        .event-unavailable {
            background-color: #d9534f !important;
            color: white !important;
            opacity: 0.8;
            pointer-events: none;
        }

        /* Smooth Hover Animation for Events */
        .fc-event {
            background-color: #005d88 !important;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .fc-event:hover {
            transform: scale(1.03);
        }

        #eventDetailsModal {
            border-radius: 10px;
            overflow: hidden;
        }

        #eventDetailsModal input,
        #eventDetailsModal textarea {
            border-radius: 5px;
            border: 1px solid #ced4da;
            padding: 10px;
            width: 100%;
        }

        .fc-toolbar .fc-button:hover {
            background-color: #142c4d !important;
            color: #fff !important;
            transform: scale(1.03);
        }


        /* List View Events */
        .fc-list-event td {
            color: white !important;
            transition: background-color 0.3s ease, box-shadow 0.3s ease !important;
            padding: 10px 15px !important;
            margin-bottom: 8px !important;
        }

        .event-success td {
            background-color: #1e8357 !important;
            color: white !important;
            transition: background-color 0.3s ease, box-shadow 0.3s ease !important;
            padding: 10px 15px !important;
            margin-bottom: 8px !important;
        }

        .fc-list .fc-list-event:hover td {
            background-color: #142c4d !important;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15) !important;
            color: white !important;
            transform: scale(1.02) !important;


        }

        /* Adjust Event Title in List View */
        .fc-list-event-title {
            font-weight: 500;
            font-size: 12px;
        }

        /* Adjust Time in List View */
        .fc-list-event-time {
            font-weight: 400;
            font-size: 12px;
            color: #ddd;
        }
    </style>
    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">

            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item">Bookings</li>
                                <li class="breadcrumb-item" aria-current="page">My Booking</li>

                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">My Booking</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <div class="row">
                <!-- [ sample-page ] start -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body position-relative">
                            <div id="calendar" class="calendar"></div>
                        </div>
                    </div>
                </div>
                <!-- [ sample-page ] end -->
            </div>

            <!-- Modal Approve Start Here -->
            <div class="modal fade" id="confirmModal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12 mb-4">
                                    <div class="d-flex justify-content-center align-items-center mb-3">
                                        <i class="ti ti-info-circle text-warning" style="font-size: 100px"></i>
                                    </div>

                                </div>
                                <div class="col-sm-12">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <h2>Reschedule Confirmation</h2>
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-3">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <p class="fw-normal f-18 text-center">Are you sure you want to reschedule this
                                            booking ?</p>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <p><strong>New Start Time:</strong> <span id="newStartTime"></span></p>
                                    </div>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <p><strong>New End Time:</strong> <span id="newEndTime"></span></p>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="d-flex justify-content-between gap-3 align-items-center">
                                        <button type="button" class="btn btn-light btn-pc-default exitBtn"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-primary"
                                            id="confirmRescheduleBtn">Confirm</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Approve End Here -->


            <!-- Modal for displaying event details -->
            <div class="modal fade" id="eventDetailsModal" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="eventDetailsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="eventDetailsModalLabel">Booking Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label for="modalEventTask" class="form-label">Task</label>
                                        <input type="text" class="form-control" id="modalEventTask" readonly />
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label for="modalEventTitle" class="form-label">Client Name</label>
                                        <input type="text" class="form-control" id="modalEventTitle" readonly />
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label for="modalEventPhoneNo" class="form-label">Phone No</label>
                                        <input type="text" class="form-control" id="modalEventPhoneNo" readonly />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label for="modalEventStart" class="form-label">Start Time</label>
                                        <input type="text" class="form-control" id="modalEventStart" readonly />
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label for="modalEventEnd" class="form-label">End Time</label>
                                        <input type="text" class="form-control" id="modalEventEnd" readonly />
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label for="modalEventDescription" class="form-label">Address</label>
                                        <textarea id="modalEventDescription" class="form-control" cols="20" rows="5" readonly></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label for="modalEventNote" class="form-label">Task Note</label>
                                        <textarea id="modalEventNote" class="form-control" cols="30" rows="5" readonly></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label for="modalEventStatus" class="form-label">Status</label>
                                        <input type="text" class="form-control" id="modalEventStatus" readonly />
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <div class="d-grid">
                                        <button type="button" class="btn btn-danger" id="rejectBookingChange"
                                            data-booking-id="#" data-option="2">Unable to Serve</button>
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <div class="d-grid">
                                        <button type="button" class="btn btn-success" id="confirmBookingChange"
                                            data-booking-id="#" data-option="1">Confirm
                                            Booking</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer justify-content-start align-items-center gap-1">
                            <a href="#" class="btn btn-outline-secondary" id="callButton">Contact
                                Client</a>
                            <a href="#" class="btn btn-outline-secondary" id="getDirection" target="_blank">Get
                                Direction</a>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>
    <!-- [ Main Content ] end -->


    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script>
        // Format Date 
        function formatDateLocal(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        // Format Time
        function formatDateTime(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');

            let hours = date.getHours();
            const minutes = String(date.getMinutes()).padStart(2, '0');
            const ampm = hours >= 12 ? 'PM' : 'AM';

            hours = hours % 12;
            hours = hours ? hours : 12;

            return `${day}-${month}-${year}, ${hours}:${minutes} ${ampm}`;
        }

        //Get Calendar range from today to next 7 days (notUsed)
        function getValidRange() {
            const today = new Date();
            const sevenDaysFromToday = new Date();
            sevenDaysFromToday.setDate(today.getDate() + 7);

            return {
                start: formatDateLocal(today),
                end: formatDateLocal(sevenDaysFromToday)
            };
        }

        //Calander Code 
        let validRange = getValidRange();
        let calendarInstance = null;

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            const taskerId = '{{ Auth::user()->id }}';

            let currentLoadedDate = null;
            let allowedStartTimes = [];

            function fetchAvailability(date) {
                return fetch(`{{ route('get-calander-range-tasker') }}?taskerid=${taskerId}&date=${date}`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.start_time || !data.end_time) {
                            console.log('No availability found for this tasker on this date.');
                            return {
                                startTime: '07:00:00',
                                endTime: '21:00:00',
                                unavailableSlots: [],
                                allowedTimes: [],
                            };
                        }

                        allowedStartTimes = data.allowed_times || [];
                        return {
                            startTime: data.start_time,
                            endTime: data.end_time,
                            unavailableSlots: data.unavailable_slots || [],
                            allowedTimes: data.allowed_times || [],
                        };
                    })
                    .catch(error => {
                        console.error('Error fetching tasker availability:', error);
                        return {
                            startTime: null,
                            endTime: null,
                            unavailableSlots: [],
                            allowedTimes: [],
                        };
                    });
            }

            function initializeCalendar(initialData) {
                const {
                    startTime,
                    endTime,
                    unavailableSlots,
                    allowedTimes
                } = initialData;

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'timeGridDay',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'timeGridDay,dayGridMonth,listWeek',
                    },
                    themeSystem: 'bootstrap',
                    dragScroll: true,
                    longPressDelay: 300,
                    eventStartEditable: true,
                    eventDurationEditable: true,
                    height: 'auto',
                    // validRange: validRange,
                    slotMinTime: '07:00:00',
                    slotMaxTime: '21:00:00',
                    editable: true,
                    selectable: true,
                    eventResize: function(info) {
                        info.revert();
                        alert('Resizing is disabled');
                    },
                    datesSet: function(info) {
                        const currentDate = info.startStr.split('T')[0];
                        console.log(currentDate);
                        fetchAvailability(currentDate).then(availability => {
                            if (!availability.startTime || !availability.endTime) {
                                // Disable business hours and constraints for this day
                            } else {
                                // Enable business hours and constraints for this day
                                calendar.setOption('businessHours', [{
                                    daysOfWeek: [0, 1, 2, 3, 4, 5,
                                        6
                                    ], // Apply to all days
                                    startTime: availability.startTime,
                                    endTime: availability.endTime,
                                }]);
                                calendar.setOption('eventConstraint', 'businessHours');
                            }
                        });
                    },
                    eventSources: [{
                            events: function(fetchInfo, successCallback, failureCallback) {
                                // Fetch events dynamically for tasker bookings
                                fetch('{{ route('get-tasker-bookings') }}')
                                    .then(response => response.json())
                                    .then(data => {
                                        // Assuming 'data' is an array of event objects from the backend
                                        const events = data.map(event => ({
                                            id: event.id,
                                            title: event.title,
                                            description: event.description,
                                            status: event.status,
                                            start: event.start,
                                            end: event.end,
                                            task: event.task,
                                            name: event.name,
                                            phoneno: event.phoneno,
                                            lat: event.lat,
                                            long: event.long,
                                            note: event.note,
                                            className: event.className,
                                            editable: event.editable,
                                            overlap: event.overlap,
                                            clickable: true
                                        }));
                                        successCallback(events);
                                    })
                                    .catch(error => {
                                        console.error('Error fetching tasker bookings:', error);
                                        failureCallback(error);
                                    });
                            }
                        },
                        {
                            events: function(fetchInfo, successCallback, failureCallback) {
                                fetch('{{ route('get-unavailable-slot') }}')
                                    .then(response => response.json())
                                    .then(data => {
                                        const events = data.map(event => ({
                                            id: event.id,
                                            title: event.title,
                                            start: event.start,
                                            end: event.end,
                                            className: 'event-unavailable',
                                            editable: false,
                                            overlap: false,
                                            clickable: false
                                        }));
                                        successCallback(events);

                                    })
                                    .catch(error => {
                                        console.error('Error fetching tasker slots:', error);
                                        failureCallback(error);
                                    });
                            }
                        }
                    ],

                    eventDidMount: function(info) {
                        info.el.style.borderRadius = '8px';
                        info.el.style.backgroundColor = '#007bff';
                        info.el.style.color = '#fff';
                    },
                    eventClick: function(info) {
                        if (info.event.extendedProps.clickable === false) {
                            info.jsEvent.preventDefault();
                        } else {
                            const eventDescription = info.event.extendedProps.description || '';
                            const eventNote = info.event.extendedProps.note || 'No Task Note';
                            const eventStatus = info.event.extendedProps.status;
                            const callButton = document.getElementById('callButton');
                            const getdirection = document.getElementById('getDirection');
                            const confirmBookingChange = document.getElementById(
                                'confirmBookingChange');
                            const rejectBookingChange = document.getElementById(
                                'rejectBookingChange');
                            confirmBookingChange.style.display = 'none';
                            rejectBookingChange.style.display = 'none';


                            var newStatus = null;
                            if (eventStatus == 1) {
                                newStatus = 'To Pay';
                            } else if (eventStatus == 2) {
                                newStatus = 'Paid';
                                confirmBookingChange.style.display = 'block';
                                rejectBookingChange.style.display = 'block';
                            } else if (eventStatus == 3) {
                                newStatus = 'Confirmed';
                            } else if (eventStatus == 4) {
                                newStatus = 'Rescheduled';
                                confirmBookingChange.style.display = 'block';
                                rejectBookingChange.style.display = 'block';
                            } else if (eventStatus == 5) {
                                newStatus = 'Cancelled';
                            } else if (eventStatus == 6) {
                                newStatus = 'Completed';
                            }
                            document.getElementById('modalEventTitle').value = info.event.extendedProps
                                .name;
                            document.getElementById('modalEventTask').value = info.event.extendedProps
                                .task;
                            document.getElementById('modalEventPhoneNo').value = info.event
                                .extendedProps
                                .phoneno;
                            document.getElementById('modalEventStart').value = formatDateTime(info.event
                                    .start)
                                .toLocaleString();
                            document.getElementById('modalEventEnd').value = formatDateTime(info.event
                                    .end)
                                .toLocaleString();
                            document.getElementById('modalEventDescription').value = eventDescription;
                            document.getElementById('modalEventNote').value = eventNote;
                            document.getElementById('modalEventStatus').value = newStatus;

                            confirmBookingChange.setAttribute('data-booking-id', info.event.id);
                            rejectBookingChange.setAttribute('data-booking-id', info.event.id);


                            callButton.href = `tel:${info.event.extendedProps.phoneno}`
                            getdirection.href =
                                `https://www.waze.com/live-map/directions?z=10&to=ll.${info.event.extendedProps.lat}%2C${info.event.extendedProps.long}`

                            const modalElement = document.getElementById('eventDetailsModal');
                            const modal = new bootstrap.Modal(modalElement);
                            modal.show();

                        }

                    },
                    eventDrop: eventDropHandler,
                    // eventResize: eventResizeHandler,
                    dateClick: function(info) {
                        calendar.changeView('timeGridDay', info.dateStr);
                    },
                });

                calendar.render();
                calendarInstance = calendar;

            }

            let eventToUpdate = null;
            let confirmClicked = false;

            function isValidDropOrResize(date, taskerId) {
                // Extract the date in 'YYYY-MM-DD' format
                const draggedDate = date.toLocaleDateString('en-CA');

                // Fetch availability for the selected day
                return fetchAvailability(draggedDate).then(availability => {
                    // If no start or end time is available, prevent the drop or resize
                    if (!availability.startTime || !availability.endTime) {
                        console.error('No availability for the selected day!');
                        return false;
                    }

                    // Get the dragged time in 'HH:mm' format
                    const draggedTime = date.toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit',
                        hour12: false,
                    }).padStart(5, '0');

                    // Fetch allowed start times from the availability data
                    const allowedTimes = availability.allowedTimes.map(time =>
                        String(time).padStart(5, '0')
                    );

                    // Validate if the dragged time is within the allowed times
                    return allowedTimes.some(time => time === draggedTime);
                }).catch(error => {
                    console.error('Error fetching availability:', error);
                    return false; // Prevent drop if error occurs while fetching availability
                });
            }

            function eventDropHandler(info) {
                const droppedDate = info.event.start; // Get the start date and time of the event

                isValidDropOrResize(droppedDate).then(isValid => {
                    if (!isValid) {
                        alert('Invalid drop ! Please try another day and time.');
                        info.revert();
                    } else {
                        // Proceed with the valid drop
                        console.log(`Event dropped successfully at ${droppedDate}`);
                        // Show modal for event confirmation
                        eventToUpdate = info;
                        document.getElementById('newStartTime').textContent = formatDateTime(info.event
                            .start);
                        document.getElementById('newEndTime').textContent = formatDateTime(info.event.end);
                        new bootstrap.Modal(document.getElementById('confirmModal')).show();
                    }
                });
            }

            // function eventResizeHandler(info) {
            //     if (!isValidDropOrResize(info.event.start) || !isValidDropOrResize(info.event.end)) {
            //         alert('Invalid resize time. Please follow the allowed time intervals.');
            //         info.revert(); // Revert changes if resize time is invalid
            //     } else {
            //         // Store the event and show the confirmation modal
            //         eventToUpdate = info; // Ensure this line runs correctly
            //         console.log('Event to update (resize):', eventToUpdate); // Debugging
            //         document.getElementById('newStartTime').textContent = info.event.start.toLocaleString();
            //         document.getElementById('newEndTime').textContent = info.event.end.toLocaleString();
            //         new bootstrap.Modal(document.getElementById('confirmModal')).show();
            //     }
            // }

            // Event listener for confirming the reschedule
            document.getElementById('confirmRescheduleBtn').addEventListener('click', function() {
                confirmClicked = true;

                if (eventToUpdate) {
                    console.log('Updating event:', eventToUpdate); // Debugging
                    updateEventTime(eventToUpdate);
                } else {
                    console.warn('No event to update!');
                }

                // Close the modal
                const modalElement = document.getElementById('confirmModal');
                const modal = bootstrap.Modal.getInstance(modalElement);
                modal.hide();
            });

            $('.exitBtn').on('click', function() {
                // Ensure eventToUpdate is valid
                if (eventToUpdate) {
                    eventToUpdate.revert();
                } else {
                    console.warn('No event to update!');
                }
            });

            $('#confirmModal').on('hidden.bs.modal', function() {
                if (!confirmClicked) {
                    if (eventToUpdate) {
                        eventToUpdate.revert();
                    } else {
                        console.warn('No event to revert!');
                    }
                }
                confirmClicked = false;
            });

            function updateEventTime(info) {
                // Ensure the event exists before accessing its properties
                if (!info || !info.event) {
                    console.error('No event provided to update.');
                    return; // Exit early if event is not available
                }

                const start = info.event.start ? info.event.start.toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: false
                }) : null;

                const end = info.event.end ? info.event.end.toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: false
                }) : null;

                const date = formatDateLocal(info.event.start)

                if (!start || !end) {
                    console.error('Event start or end time is missing.');
                    return; // Exit early if start or end time is missing
                }

                const eventId = info.event.id;
                console.log('Updating event time for ID:', eventId, 'Start:', start, 'End:', end);

                // Send the updated event times to the backend
                fetch(`{{ route('reschedule-booking-tasker') }}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            id: eventId,
                            start,
                            end,
                            date,
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            // alert('Event rescheduled successfully !');
                        } else if (data.status === 'error') {
                            // alert(
                            //     'Oops !, You cannot reschedule to this date because there is no time slots generated.'
                            // );
                            info.revert();
                        } else {
                            console.error('Failed to update event:', data.message);
                            info.revert(); // Revert changes if update fails
                        }
                    })
                    .catch(error => {
                        console.error('Error updating event:', error);
                        info.revert(); // Revert changes if an error occurs
                    });
            }

            const initialDate = formatDateLocal(new Date());
            currentLoadedDate = initialDate;
            fetchAvailability(initialDate).then(data => {
                initializeCalendar(data);
            });
        });

        //AJAX: CONFIRM BOOKING
        $('#confirmBookingChange').on('click', function() {
            const $buttonConfirm = $(this);
            const $buttonReject = $('#rejectBookingChange');
            const bookingID = event.target.getAttribute('data-booking-id');
            const option = event.target.getAttribute('data-option');

            $buttonConfirm.prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm me-2"></span> Confirming...'
            );
            $buttonReject.prop('disabled', true);

            fetch(`{{ route('confirmation-booking-tasker') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        id: bookingID,
                        option: option
                    }),
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'success') {
                        console.log('Event updated successfully in the database:', data.updated_booking);
                        if (calendarInstance) {
                            calendarInstance.refetchEvents();
                            $('#eventDetailsModal').modal('hide');
                            $buttonConfirm.prop('disabled', false).html('Confirm Booking');
                            $buttonReject.prop('disabled', false).html('Unable to Serve');

                        }
                    } else {
                        console.error('Failed to update event:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error updating event:', error);
                });
        });

        //AJAX: REJECT BOOKING
        $('#rejectBookingChange').on('click', function() {
            const $buttonRejectTwo = $(this);
            const $buttonConfirmTwo = $('#confirmBookingChange');
            const bookingID = event.target.getAttribute('data-booking-id');
            const option = event.target.getAttribute('data-option');

            $buttonRejectTwo.prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm me-2"></span> Loading...'
            );
            $buttonConfirmTwo.prop('disabled', true);


            fetch(`{{ route('confirmation-booking-tasker') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        id: bookingID,
                        option: option
                    }),
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'success') {
                        console.log('Event updated successfully in the database:', data.updated_booking);
                        if (calendarInstance) {
                            calendarInstance.refetchEvents();
                            $('#eventDetailsModal').modal('hide');
                            $buttonConfirmTwo.prop('disabled', false).html('Confirm Booking');
                            $buttonRejectTwo.prop('disabled', false).html('Unable to Serve');
                        }
                    } else {
                        console.error('Failed to update event:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error updating event:', error);
                });
        });
    </script>
@endsection
<!--Created By: Muhammad Zikri B. Kashim (6/11/2024)-->
<!--Updated By: Muhammad Zikri B. Kashim (11/01/2025)-->
