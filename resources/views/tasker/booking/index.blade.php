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
        // document.addEventListener('DOMContentLoaded', function() {
        //     var calendarEl = document.getElementById('calendar');

        //     // Fetch tasker availability dynamically
        //     const taskerId = '{{ Auth::user()->id }}'; // Replace with dynamic tasker ID
        //     localStorage.setItem('currDate', formatDateLocal(new Date()));
        //     const currDate = localStorage.getItem('currDate');
        //     fetch('{{ route('get-calander-range-tasker') }}?taskerid=' + taskerId + '&date=' + currDate)
        //         .then(response => response.json())
        //         .then(data => {

        //             if (!data.start_time || !data.end_time) {
        //                 console.log('No availability found for this tasker.');
        //                 return;
        //             }
        //             // Get start and end times
        //             const startTime = data.start_time;
        //             const endTime = data.end_time;

        //             // Safely access unavailable_slots
        //             const unavailableSlots = Array.isArray(data.unavailable_slots) ? data.unavailable_slots :
        //         [];

        //             // Create events for unavailable slots
        //             const unavailableEvents = unavailableSlots.map(slot => ({
        //                 title: 'Unavailable',
        //                 start: currDate + 'T' + slot.slot_time,
        //                 end: currDate + 'T' + slot.slot_time,
        //                 overlap: false,
        //                 className: 'event-unavailable',
        //                 editable: false,
        //             }));

        //             // Initialize FullCalendar
        //             var calendar = new FullCalendar.Calendar(calendarEl, {
        //                 initialView: 'timeGridDay',
        //                 headerToolbar: {
        //                     left: 'prev,next today',
        //                     center: 'title',
        //                     right: 'timeGridDay,dayGridMonth,listWeek',
        //                 },
        //                 themeSystem: 'bootstrap',
        //                 navLinks: true,
        //                 height: 'auto',
        //                 slotMinTime: '07:00:00', // Earliest possible time
        //                 slotMaxTime: '20:00:00', // Latest possible time
        //                 slotDuration: '00:30:00', // 30-minute intervals
        //                 slotLabelInterval: '00:30:00',
        //                 editable: true,
        //                 selectable: true,
        //                 businessHours: [{
        //                     daysOfWeek: [0, 1, 2, 3, 4, 5, 6], // All days
        //                     startTime: startTime, // Start time from API
        //                     endTime: endTime, // End time from API
        //                 }, ],
        //                 eventConstraint: "businessHours",
        //                 events: '{{ route('get-tasker-bookings') }}', // Fetch bookings dynamically
        //                 eventSources: [{
        //                     events: unavailableEvents, // Block unavailable times
        //                 }, ],
        //                 // Listen for date change event
        //                 dateDidChange: function() {
        //                     // Trigger your custom action on date change
        //                     console.log("Date changed!");
        //                     calendar.refetchEvents(); // Refresh the events
        //                 },
        //                 // Prevent selecting or dragging into unavailable slots
        //                 selectAllow: function(selectInfo) {
        //                     const selectedStartTime = selectInfo.startStr.slice(11);
        //                     const selectedEndTime = selectInfo.endStr.slice(11);

        //                     // Ensure selection is within available time range
        //                     if (
        //                         selectedStartTime >= startTime &&
        //                         selectedEndTime <= endTime
        //                     ) {
        //                         // Check against unavailable slots
        //                         const isUnavailable = unavailableEvents.some(event => {
        //                             return (
        //                                 selectedStartTime >= event.start.split('T')[
        //                                 1] &&
        //                                 selectedStartTime < event.end.split('T')[1]
        //                             );
        //                         });

        //                         return !isUnavailable; // Allow only if not in unavailable range
        //                     }

        //                     return false;
        //                 },
        //                 eventDidMount: function(info) {
        //                     info.el.style.borderRadius = '8px'; // Rounded corners
        //                     info.el.style.backgroundColor = '#007bff'; // Light primary blue
        //                     info.el.style.color = '#fff'; // Text color white
        //                     info.el.style.textAlign = 'center'; // Center text

        //                 },
        //                 eventClick: function(info) {
        //                     const details = `
    //                         Booking Details:
    //                         - Title: ${info.event.title}
    //                         - Start: ${info.event.start.toLocaleString()}
    //                         - End: ${info.event.end.toLocaleString()}
    //                     `;
        //                     alert(details);
        //                 },
        //                 datesSet: function(info) {
        //                     const currentDate = calendar
        //                         .getDate(); // Get the currently visible date (based on current view)
        //                     const selectedDate = formatDateLocal(
        //                         currentDate); // Get the currentDate // Format to YYYY-MM-DD
        //                     localStorage.setItem('currDate', selectedDate);
        //                     console.log('Current View Date:',
        //                         selectedDate);

        //                 },


        //             });


        //             calendar.render();
        //         })
        //         .catch(error => {
        //             console.error('Error fetching tasker availability:', error);
        //         });

        // });

        // document.addEventListener('DOMContentLoaded', function() {
        //     var calendarEl = document.getElementById('calendar');
        //     const taskerId = '{{ Auth::user()->id }}'; // Replace with dynamic tasker ID

        //     let currentLoadedDate = null; // Tracks the last fetched date to prevent repeated requests

        //     function fetchAvailability(date) {
        //         console.log('Fetching availability for:', date); // Debug log
        //         return fetch(`{{ route('get-calander-range-tasker') }}?taskerid=${taskerId}&date=${date}`)
        //             .then(response => response.json())
        //             .then(data => {
        //                 if (!data.start_time || !data.end_time) {
        //                     console.log('No availability found for this tasker.');
        //                     return {
        //                         startTime: null,
        //                         endTime: null,
        //                         unavailableSlots: []
        //                     };
        //                 }

        //                 return {
        //                     startTime: data.start_time,
        //                     endTime: data.end_time,
        //                     unavailableSlots: Array.isArray(data.unavailable_slots) ? data.unavailable_slots :
        //                     [],
        //                 };
        //             })
        //             .catch(error => {
        //                 console.error('Error fetching tasker availability:', error);
        //                 return {
        //                     startTime: null,
        //                     endTime: null,
        //                     unavailableSlots: []
        //                 };
        //             });
        //     }

        //     function initializeCalendar(initialData) {
        //         const {
        //             startTime,
        //             endTime,
        //             unavailableSlots
        //         } = initialData;

        //         var calendar = new FullCalendar.Calendar(calendarEl, {
        //             initialView: 'timeGridDay',
        //             headerToolbar: {
        //                 left: 'prev,next today',
        //                 center: 'title',
        //                 right: 'timeGridDay,dayGridMonth,listWeek',
        //             },
        //             themeSystem: 'bootstrap',
        //             height: 'auto',
        //             slotMinTime: '07:00:00',
        //             slotMaxTime: '20:00:00',
        //             slotDuration: '00:30:00',
        //             slotLabelInterval: '00:30:00',
        //             editable: true,
        //             selectable: true,
        //             businessHours: [{
        //                 daysOfWeek: [0, 1, 2, 3, 4, 5, 6],
        //                 startTime: startTime || '07:00:00',
        //                 endTime: endTime || '20:00:00',
        //             }, ],
        //             eventConstraint: "businessHours",
        //             events: '{{ route('get-tasker-bookings') }}', // Fetch bookings dynamically
        //             eventSources: [{
        //                 events: unavailableSlots.map(slot => ({
        //                     title: 'Unavailable',
        //                     start: `${currentLoadedDate}T${slot.slot_time}`,
        //                     end: `${currentLoadedDate}T${slot.slot_time}`,
        //                     overlap: false,
        //                     className: 'event-unavailable',
        //                     editable: false,
        //                 })),
        //             }, ],
        //             eventDidMount: function(info) {
        //                 info.el.style.borderRadius = '8px'; // Rounded corners
        //                 info.el.style.backgroundColor = '#007bff'; // Light primary blue
        //                 info.el.style.color = '#fff'; // Text color white
        //                 info.el.style.textAlign = 'center'; // Center text

        //             },
        //             datesSet: function(info) {
        //                 const newDate = formatDateLocal(info.start);
        //                 if (newDate !== currentLoadedDate) {
        //                     currentLoadedDate =
        //                         newDate; // Update loaded date to avoid duplicate fetches
        //                     fetchAvailability(newDate).then(newData => {
        //                         calendar.getEventSources().forEach(source => source
        //                             .remove()); // Remove all event sources
        //                         calendar.addEventSource(
        //                             '{{ route('get-tasker-bookings') }}'
        //                             ); // Re-add dynamic bookings
        //                         calendar.addEventSource({
        //                             events: newData.unavailableSlots.map(slot => ({
        //                                 title: 'Unavailable',
        //                                 start: `${newDate}T${slot.slot_time}`,
        //                                 end: `${newDate}T${slot.slot_time}`,
        //                                 overlap: false,
        //                                 className: 'event-unavailable',
        //                                 editable: false,
        //                             })),
        //                         });
        //                         calendar.setOption('businessHours', [{
        //                             daysOfWeek: [0, 1, 2, 3, 4, 5, 6],
        //                             startTime: newData.startTime || '07:00:00',
        //                             endTime: newData.endTime || '20:00:00',
        //                         }, ]);
        //                     });
        //                 }
        //             },
        //         });

        //         calendar.render();
        //     }

        //     // Fetch initial data for today's date
        //     const initialDate = formatDateLocal(new Date());
        //     currentLoadedDate = initialDate;
        //     fetchAvailability(initialDate).then(data => {
        //         initializeCalendar(data);
        //     });
        // });

        // document.addEventListener('DOMContentLoaded', function() {
        //     var calendarEl = document.getElementById('calendar');
        //     const taskerId = '{{ Auth::user()->id }}'; // Replace with dynamic tasker ID

        //     let currentLoadedDate = null; // Tracks the last fetched date to prevent repeated requests

        //     function fetchAvailability(date) {
        //         console.log('Fetching availability for:', date); // Debug log
        //         return fetch(`{{ route('get-calander-range-tasker') }}?taskerid=${taskerId}&date=${date}`)
        //             .then(response => response.json())
        //             .then(data => {
        //                 if (!data.start_time || !data.end_time) {
        //                     console.log('No availability found for this tasker.');
        //                     return {
        //                         startTime: null,
        //                         endTime: null,
        //                         unavailableSlots: [],
        //                     };
        //                 }

        //                 return {
        //                     startTime: data.start_time,
        //                     endTime: data.end_time,
        //                     unavailableSlots: Array.isArray(data.unavailable_slots) ? data.unavailable_slots :
        //                     [],
        //                 };
        //             })
        //             .catch(error => {
        //                 console.error('Error fetching tasker availability:', error);
        //                 return {
        //                     startTime: null,
        //                     endTime: null,
        //                     unavailableSlots: [],
        //                 };
        //             });
        //     }

        //     function initializeCalendar(initialData) {
        //         const {
        //             startTime,
        //             endTime,
        //             unavailableSlots
        //         } = initialData;

        //         var calendar = new FullCalendar.Calendar(calendarEl, {
        //             initialView: 'timeGridDay',
        //             headerToolbar: {
        //                 left: 'prev,next today',
        //                 center: 'title',
        //                 right: 'timeGridDay,dayGridMonth,listWeek',
        //             },
        //             themeSystem: 'bootstrap',
        //             height: 'auto',
        //             slotMinTime: '07:00:00',
        //             slotMaxTime: '20:00:00',
        //             slotDuration: '00:30:00',
        //             slotLabelInterval: '00:30:00',
        //             editable: true,
        //             selectable: true,
        //             businessHours: [{
        //                 daysOfWeek: [0, 1, 2, 3, 4, 5, 6],
        //                 startTime: startTime || '07:00:00',
        //                 endTime: endTime || '20:00:00',
        //             }, ],
        //             eventConstraint: 'businessHours',
        //             events: '{{ route('get-tasker-bookings') }}', // Fetch bookings dynamically
        //             eventSources: [{
        //                 events: unavailableSlots.map(slot => ({
        //                     title: 'Unavailable',
        //                     start: `${currentLoadedDate}T${slot.slot_time}`,
        //                     end: `${currentLoadedDate}T${slot.slot_time}`,
        //                     overlap: false,
        //                     className: 'event-unavailable',
        //                     editable: false,
        //                 })),
        //             }, ],
        //             eventDidMount: function(info) {
        //                 info.el.style.borderRadius = '8px'; // Rounded corners
        //                 info.el.style.backgroundColor = '#007bff'; // Light primary blue
        //                 info.el.style.color = '#fff'; // Text color white
        //             },
        //             eventClick: function(info) {
        //                 const details = `
    //                         Booking Details:
    //                         - Title: ${info.event.title}
    //                         - Start: ${info.event.start.toLocaleString()}
    //                         - End: ${info.event.end.toLocaleString()}
    //                     `;
        //                 alert(details); // Show alert when an event is clicked
        //             },
        //             datesSet: function(info) {
        //                 const newDate = formatDateLocal(info.start);

        //                 // Check if the new date differs from the currently loaded date
        //                 if (newDate !== currentLoadedDate) {
        //                     currentLoadedDate = newDate;

        //                     fetchAvailability(newDate).then(newData => {
        //                         calendar.getEventSources().forEach(source => source
        //                             .remove()); // Remove all event sources
        //                         calendar.addEventSource(
        //                             '{{ route('get-tasker-bookings') }}'
        //                         ); // Re-add dynamic bookings
        //                         calendar.addEventSource({
        //                             events: newData.unavailableSlots.map(slot => ({
        //                                 title: 'Unavailable',
        //                                 start: `${newDate}T${slot.slot_time}`,
        //                                 end: `${newDate}T${slot.slot_time}`,
        //                                 overlap: false,
        //                                 className: 'event-unavailable',
        //                                 editable: false,
        //                             })),
        //                         });

        //                         // Update business hours dynamically
        //                         calendar.setOption('businessHours', [{
        //                             daysOfWeek: [0, 1, 2, 3, 4, 5, 6],
        //                             startTime: newData.startTime || '07:00:00',
        //                             endTime: newData.endTime || '20:00:00',
        //                         }, ]);
        //                     });
        //                 }
        //             },
        //             dateClick: function(info) {
        //                 // When clicking on a date in the month view, switch to the timeGridDay view
        //                 calendar.changeView('timeGridDay', info.dateStr);
        //             },
        //         });

        //         calendar.render();
        //     }

        //     // Fetch initial data for today's date
        //     const initialDate = formatDateLocal(new Date());
        //     currentLoadedDate = initialDate;
        //     fetchAvailability(initialDate).then(data => {
        //         initializeCalendar(data);
        //     });
        // });

        // document.addEventListener('DOMContentLoaded', function() {
        //     var calendarEl = document.getElementById('calendar');
        //     const taskerId = '{{ Auth::user()->id }}'; // Replace with dynamic tasker ID

        //     let currentLoadedDate = null; // Tracks the last fetched date to prevent repeated requests

        //     function fetchAvailability(date) {
        //         console.log('Fetching availability for:', date); // Debug log
        //         return fetch(`{{ route('get-calander-range-tasker') }}?taskerid=${taskerId}&date=${date}`)
        //             .then(response => response.json())
        //             .then(data => {
        //                 if (!data.start_time || !data.end_time) {
        //                     console.log('No availability found for this tasker.');
        //                     return {
        //                         startTime: null,
        //                         endTime: null,
        //                         unavailableSlots: [],
        //                     };
        //                 }

        //                 return {
        //                     startTime: data.start_time,
        //                     endTime: data.end_time,
        //                     unavailableSlots: Array.isArray(data.unavailable_slots) ? data.unavailable_slots :
        //                     [],
        //                 };
        //             })
        //             .catch(error => {
        //                 console.error('Error fetching tasker availability:', error);
        //                 return {
        //                     startTime: null,
        //                     endTime: null,
        //                     unavailableSlots: [],
        //                 };
        //             });
        //     }

        //     function initializeCalendar(initialData) {
        //         const {
        //             startTime,
        //             endTime,
        //             unavailableSlots
        //         } = initialData;

        //         var calendar = new FullCalendar.Calendar(calendarEl, {
        //             initialView: 'timeGridDay',
        //             headerToolbar: {
        //                 left: 'prev,next today',
        //                 center: 'title',
        //                 right: 'timeGridDay,dayGridMonth,listWeek',
        //             },
        //             themeSystem: 'bootstrap',
        //             height: 'auto',
        //             slotMinTime: '07:00:00',
        //             slotMaxTime: '20:00:00',
        //             slotDuration: '00:30:00',
        //             slotLabelInterval: '00:30:00',
        //             editable: true, // Allow dragging and resizing events
        //             selectable: true,
        //             businessHours: [{
        //                 daysOfWeek: [0, 1, 2, 3, 4, 5, 6],
        //                 startTime: startTime || '07:00:00',
        //                 endTime: endTime || '20:00:00',
        //             }],
        //             eventConstraint: 'businessHours',
        //             events: '{{ route('get-tasker-bookings') }}', // Fetch bookings dynamically
        //             eventSources: [{
        //                 events: unavailableSlots.map(slot => ({
        //                     title: 'Unavailable',
        //                     start: `${currentLoadedDate}T${slot.slot_time}`,
        //                     end: `${currentLoadedDate}T${slot.slot_time}`,
        //                     overlap: false,
        //                     className: 'event-unavailable',
        //                     editable: false,
        //                 })),
        //             }],
        //             eventDidMount: function(info) {
        //                 info.el.style.borderRadius = '8px'; // Rounded corners
        //                 info.el.style.backgroundColor = '#007bff'; // Light primary blue
        //                 info.el.style.color = '#fff'; // Text color white
        //             },
        //             eventClick: function(info) {
        //                 const details = `
    //                 Booking Details:
    //                 - Title: ${info.event.title}
    //                 - Start: ${info.event.start.toLocaleString()}
    //                 - End: ${info.event.end.toLocaleString()}
    //             `;
        //                 alert(details); // Show alert when an event is clicked
        //             },
        //             eventDrop: function(info) {
        //                 const start = info.event.start.toLocaleTimeString([], {
        //                     hour: '2-digit',
        //                     minute: '2-digit',
        //                     second: '2-digit',
        //                     hour12: false // Use 24-hour format
        //                 });

        //                 const end = info.event.end.toLocaleTimeString([], {
        //                     hour: '2-digit',
        //                     minute: '2-digit',
        //                     second: '2-digit',
        //                     hour12: false // Use 24-hour format
        //                 });
        //                 const eventId = info.event.id;

        //                 // Update database via AJAX
        //                 fetch(`{{ route('reschedule-booking-tasker') }}`, {
        //                         method: 'POST',
        //                         headers: {
        //                             'Content-Type': 'application/json',
        //                             'X-CSRF-TOKEN': '{{ csrf_token() }}',
        //                         },
        //                         body: JSON.stringify({
        //                             id: eventId,
        //                             start,
        //                             end,
        //                         }),
        //                     })
        //                     .then(response => response.json())
        //                     .then(data => {
        //                         if (data.status === 'success') {
        //                             console.log('Event updated successfully in the database:', data
        //                                 .updated_booking);
        //                         } else {
        //                             console.error('Failed to update event:', data.message);
        //                             info.revert(); // Revert changes if update fails
        //                         }
        //                     })
        //                     .catch(error => {
        //                         console.error('Error updating event:', error);
        //                         info.revert(); // Revert changes if an error occurs
        //                     });
        //             },
        //             datesSet: function(info) {
        //                 const newDate = formatDateLocal(info.start);

        //                 // Check if the new date differs from the currently loaded date
        //                 if (newDate !== currentLoadedDate) {
        //                     currentLoadedDate = newDate;

        //                     fetchAvailability(newDate).then(newData => {
        //                         calendar.getEventSources().forEach(source => source
        //                             .remove()); // Remove all event sources
        //                         calendar.addEventSource(
        //                             '{{ route('get-tasker-bookings') }}'
        //                         ); // Re-add dynamic bookings
        //                         calendar.addEventSource({
        //                             events: newData.unavailableSlots.map(slot => ({
        //                                 title: 'Unavailable',
        //                                 start: `${newDate}T${slot.slot_time}`,
        //                                 end: `${newDate}T${slot.slot_time}`,
        //                                 overlap: false,
        //                                 className: 'event-unavailable',
        //                                 editable: false,
        //                             })),
        //                         });

        //                         // Update business hours dynamically
        //                         calendar.setOption('businessHours', [{
        //                             daysOfWeek: [0, 1, 2, 3, 4, 5, 6],
        //                             startTime: newData.startTime || '07:00:00',
        //                             endTime: newData.endTime || '20:00:00',
        //                         }]);
        //                     });
        //                 }
        //             },
        //             dateClick: function(info) {
        //                 // When clicking on a date in the month view, switch to the timeGridDay view
        //                 calendar.changeView('timeGridDay', info.dateStr);
        //             },
        //         });

        //         calendar.render();
        //     }

        //     // Fetch initial data for today's date
        //     const initialDate = formatDateLocal(new Date());
        //     currentLoadedDate = initialDate;
        //     fetchAvailability(initialDate).then(data => {
        //         initializeCalendar(data);
        //     });
        // });


        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            const taskerId = '{{ Auth::user()->id }}'; // Replace with dynamic tasker ID

            let currentLoadedDate = null; // Tracks the last fetched date to prevent repeated requests

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
                            };
                        }

                        return {
                            startTime: data.start_time,
                            endTime: data.end_time,
                            unavailableSlots: Array.isArray(data.unavailable_slots) ? data.unavailable_slots :
                            [],
                        };
                    })
                    .catch(error => {
                        console.error('Error fetching tasker availability:', error);
                        return {
                            startTime: null,
                            endTime: null,
                            unavailableSlots: [],
                        };
                    });
            }

            function initializeCalendar(initialData) {
                const {
                    startTime,
                    endTime,
                    unavailableSlots
                } = initialData;

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'timeGridDay',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'timeGridDay,dayGridMonth,listWeek',
                    },
                    themeSystem: 'bootstrap',
                    height: 'auto',
                    slotMinTime: '07:00:00',
                    slotMaxTime: '20:00:00',
                    slotDuration: '00:30:00',
                    slotLabelInterval: '00:30:00',
                    editable: true, // Allow dragging and resizing events
                    selectable: true,
                    businessHours: [{
                        daysOfWeek: [0, 1, 2, 3, 4, 5, 6],
                        startTime: startTime || '07:00:00',
                        endTime: endTime || '20:00:00',
                    }],
                    eventConstraint: 'businessHours',
                    events: '{{ route('get-tasker-bookings') }}', // Fetch bookings dynamically
                    eventSources: [{
                        events: unavailableSlots.map(slot => ({
                            title: 'Unavailable',
                            start: `${currentLoadedDate}T${slot.slot_time}`,
                            end: `${currentLoadedDate}T${slot.slot_time}`,
                            overlap: false,
                            className: 'event-unavailable',
                            editable: false,
                        })),
                    }],
                    eventDidMount: function(info) {
                        info.el.style.borderRadius = '8px'; // Rounded corners
                        info.el.style.backgroundColor = '#007bff'; // Light primary blue
                        info.el.style.color = '#fff'; // Text color white
                    },
                    eventClick: function(info) {
                        const details = `
                    Booking Details:
                    - Title: ${info.event.title}
                    - Start: ${info.event.start.toLocaleString()}
                    - End: ${info.event.end.toLocaleString()}
                `;
                        alert(details); // Show alert when an event is clicked
                    },
                    eventDrop: function(info) {
                        updateEventTime(info);
                    },
                    eventResize: function(info) {
                        updateEventTime(info);
                    },
                    datesSet: function(info) {
                        const newDate = formatDateLocal(info.start);

                        if (newDate !== currentLoadedDate) {
                            currentLoadedDate = newDate;

                            fetchAvailability(newDate).then(newData => {
                                calendar.getEventSources().forEach(source => source.remove());
                                calendar.addEventSource('{{ route('get-tasker-bookings') }}');
                                calendar.addEventSource({
                                    events: newData.unavailableSlots.map(slot => ({
                                        title: 'Unavailable',
                                        start: `${newDate}T${slot.slot_time}`,
                                        end: `${newDate}T${slot.slot_time}`,
                                        overlap: false,
                                        className: 'event-unavailable',
                                        editable: false,
                                    })),
                                });

                                calendar.setOption('businessHours', [{
                                    daysOfWeek: [0, 1, 2, 3, 4, 5, 6],
                                    startTime: newData.startTime || '07:00:00',
                                    endTime: newData.endTime || '20:00:00',
                                }]);
                            });
                        }
                    },
                    dateClick: function(info) {
                        calendar.changeView('timeGridDay', info.dateStr);
                    },
                });

                calendar.render();
            }

            // Function to update event start and end time in the database
            function updateEventTime(info) {
                const start = info.event.start.toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: false // Use 24-hour format
                });

                const end = info.event.end.toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: false // Use 24-hour format
                });
                const eventId = info.event.id;

                // Send updated event times to the backend
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
