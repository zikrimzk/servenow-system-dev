@extends('tasker.layouts.main')

@section('content')
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
                                <h2 class="mb-4">My Booking</h2>
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
                                        <input type="text" class="form-control" id="modalEventTask">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label for="modalEventTitle" class="form-label">Client Name</label>
                                        <input type="text" class="form-control" id="modalEventTitle">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label for="modalEventPhoneNo" class="form-label">Phone No</label>
                                        <input type="text" class="form-control" id="modalEventPhoneNo">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label for="modalEventTitle" class="form-label">Start Time</label>
                                        <input type="text" class="form-control" id="modalEventStart">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label for="modalEventTitle" class="form-label">End Time</label>
                                        <input type="text" class="form-control" id="modalEventEnd">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label for="modalEventTitle" class="form-label">Address</label>
                                        <textarea id="modalEventDescription" class="form-control" cols="20" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-end align-items-center gap-3">
                            <div>
                                <a href="#" class="btn btn-success" id="callButton">Contact
                                    Client</a>
                                <a href="#" class="btn btn-primary" id="getDirection" target="_blank">Get
                                    Direction</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>
    <!-- [ Main Content ] end -->



    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script>
        function formatDateLocal(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Month is 0-based
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        function getValidRange() {
            const today = new Date();
            const sevenDaysFromToday = new Date();
            sevenDaysFromToday.setDate(today.getDate() + 7);

            return {
                start: formatDateLocal(today), // Use the custom formatting function
                end: formatDateLocal(sevenDaysFromToday) // Use the custom formatting function
            };
        }

        let validRange = getValidRange();

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            const taskerId = '{{ Auth::user()->id }}'; // Replace with dynamic tasker ID

            let currentLoadedDate = null; // Tracks the last fetched date to prevent repeated requests
            let allowedStartTimes = []; // Stores valid drop times dynamically

            function fetchAvailability(date) {
                console.log('Fetching availability for:', date); // Debug log
                return fetch(`{{ route('get-calander-range-tasker') }}?taskerid=${taskerId}&date=${date}`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.start_time || !data.end_time) {
                            console.log('No availability found for this tasker.');
                            return {
                                startTime: null,
                                endTime: null,
                                unavailableSlots: [],
                                allowedTimes: [],
                            };
                        }

                        allowedStartTimes = data.allowed_times || []; // Set allowed times dynamically
                        return {
                            startTime: data.start_time,
                            endTime: data.end_time,
                            unavailableSlots: Array.isArray(data.unavailable_slots) ? data.unavailable_slots :
                            [],
                            allowedTimes: allowedStartTimes,
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
                    // plugins: [FullCalendar.Interaction],
                    themeSystem: 'bootstrap',
                    dragScroll: true, // Enables scrolling during drag
                    longPressDelay: 300, // Time delay before drag starts on touch devices
                    eventStartEditable: true, // Allow dragging
                    eventDurationEditable: true, // Allow resizing
                    height: 'auto',
                    validRange: validRange,
                    slotMinTime: '07:00:00',
                    slotMaxTime: '20:00:00',
                    editable: true, // Allow dragging and resizing events
                    selectable: true,
                    businessHours: [{
                        daysOfWeek: [0, 1, 2, 3, 4, 5, 6],
                        startTime: startTime || '07:00:00',
                        endTime: endTime || '20:00:00',
                    }],
                    eventConstraint: 'businessHours',
                    // events: '{{ route('get-tasker-bookings') }}', // Fetch bookings dynamically
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
                                            clickable: true


                                            // You can add any other fields that FullCalendar needs, such as description, id, etc.
                                        }));

                                        // Pass the events to FullCalendar
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
                                // Fetch events dynamically for tasker bookings
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
                        info.el.style.borderRadius = '8px'; // Rounded corners
                        info.el.style.backgroundColor = '#007bff'; // Light primary blue
                        info.el.style.color = '#fff'; // Text color white
                    },
                    eventClick: function(info) {
                        if (info.event.extendedProps.clickable === false) {
                            info.jsEvent.preventDefault();
                        } else {
                            const eventDescription = info.event.extendedProps.description || '';
                            const callButton = document.getElementById('callButton');
                            const getdirection = document.getElementById('getDirection');
                            document.getElementById('modalEventTitle').value = info.event.extendedProps
                                .name;
                            document.getElementById('modalEventTask').value = info.event.extendedProps
                                .task;
                            document.getElementById('modalEventPhoneNo').value = info.event
                                .extendedProps
                                .phoneno;
                            document.getElementById('modalEventStart').value = info.event.start
                                .toLocaleString();
                            document.getElementById('modalEventEnd').value = info.event.end
                                .toLocaleString();
                            document.getElementById('modalEventDescription').value = eventDescription;

                            callButton.href = `tel:${info.event.extendedProps.phoneno}`
                            getdirection.href =
                                `https://www.waze.com/live-map/directions?z=10&to=ll.${info.event.extendedProps.lat}%2C${info.event.extendedProps.long}`

                            // Show the modal
                            const modalElement = document.getElementById('eventDetailsModal');
                            const modal = new bootstrap.Modal(modalElement);
                            modal.show();

                        }

                    },
                    eventDrop: eventDropHandler,
                    eventResize: eventResizeHandler,
                    dateClick: function(info) {
                        calendar.changeView('timeGridDay', info.dateStr);
                    },
                });

                calendar.render();

            }

            let eventToUpdate = null;
            let confirmClicked = false;

            function isValidDropOrResize(date) {
                if (allowedStartTimes.length === 0) {
                    console.error('Allowed start times array is empty!');
                    return false; // Prevent dragging
                }

                // Format dragged time
                const draggedTime = date.toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: false,
                }).padStart(5, '0');

                // Ensure allowedStartTimes values are strings and pad them
                const formattedAllowedTimes = allowedStartTimes.map(time =>
                    String(time).padStart(5, '0')
                );

                // Check if the dragged time matches any allowed slot
                return formattedAllowedTimes.some(time => time === draggedTime);
            }

            function eventDropHandler(info) {
                if (!isValidDropOrResize(info.event.start)) {
                    alert('Invalid drop time. Please follow the allowed time intervals.');
                    info.revert(); // Revert changes if drop time is invalid
                } else {
                    // Store the event and show the confirmation modal
                    eventToUpdate = info; // Ensure this line runs correctly
                    console.log('Event to update (drop):', eventToUpdate); // Debugging
                    document.getElementById('newStartTime').textContent = info.event.start.toLocaleString();
                    document.getElementById('newEndTime').textContent = info.event.end.toLocaleString();
                    new bootstrap.Modal(document.getElementById('confirmModal')).show();
                }
            }

            function eventResizeHandler(info) {
                if (!isValidDropOrResize(info.event.start) || !isValidDropOrResize(info.event.end)) {
                    alert('Invalid resize time. Please follow the allowed time intervals.');
                    info.revert(); // Revert changes if resize time is invalid
                } else {
                    // Store the event and show the confirmation modal
                    eventToUpdate = info; // Ensure this line runs correctly
                    console.log('Event to update (resize):', eventToUpdate); // Debugging
                    document.getElementById('newStartTime').textContent = info.event.start.toLocaleString();
                    document.getElementById('newEndTime').textContent = info.event.end.toLocaleString();
                    new bootstrap.Modal(document.getElementById('confirmModal')).show();
                }
            }

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
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            console.log('Event updated successfully in the database:', data.updated_booking);
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
    </script>
@endsection
<!--Created By: Muhammad Zikri B. Kashim (6/11/2024)-->
