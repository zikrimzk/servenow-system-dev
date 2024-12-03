@extends('tasker.layouts.main')

@section('content')
    <div class="pc-container">
        <div class="pc-content">

            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item">Task Preferences</li>
                                <li class="breadcrumb-item" aria-current="page">Time Slot</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-4">Time Slot</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- Start Alert -->
            <svg xmlns="http://www.w3.org/2000/svg" style="display: none">
                <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                    <path
                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z">
                    </path>
                </symbol>

                <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                    <path
                        d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z">
                    </path>
                </symbol>
            </svg>
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                        <use xlink:href="#check-circle-fill"></use>
                    </svg>
                    <div> {{ session('success') }} </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                        <use xlink:href="#exclamation-triangle-fill"></use>
                    </svg>
                    <div> {{ session('error') }} </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <!-- End Alert -->

            <div class="row">

                <div class="col-sm-12">
                    <div class="mail-wrapper">
                        <!-- Mobile View Date Canvas Start -->
                        <div class="offcanvas-xxl offcanvas-start mail-offcanvas" tabindex="-1" id="offcanvas_mail">
                            <div class="offcanvas-header">
                                <button class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvas_mail"
                                    aria-label="Close"></button>
                            </div>

                            <div class="offcanvas-body p-0">
                                <div id="mail-menulist" class="show collapse collapse-horizontal">
                                    <div class="mail-menulist">
                                        <div class="card shadow shadow-sm">
                                            <div class="card-header">
                                                <h5 class="text-dark">
                                                    <i class="ti ti-calendar-time me-2"></i>Date
                                                </h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="list-group list-group-flush" id="list-tab" role="tablist">
                                                    <!-- Tabs will be dynamically populated -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Mobile View Date Canvas End -->

                        <div class="mail-content">

                            <!-- Note Start -->
                            <div class="d-sm-flex align-items-center">
                                <ul class="list-inline me-auto mb-3">
                                    <li class="list-inline-item align-bottom">
                                        <a href="#" class="d-xxl-none avtar avtar-s btn-link-secondary"
                                            data-bs-toggle="offcanvas" data-bs-target="#offcanvas_mail">
                                            <i class="ti ti-menu-2 f-24"></i>
                                        </a>
                                    </li>
                                </ul>

                                <div class="alert alert-primary">
                                    <div class="d-flex align-items-center">
                                        <i class="ti ti-info-circle h2 f-w-400 mb-0 text-primary"></i>
                                        <div class="flex-grow-1 ms-3">
                                            <strong>Note:</strong>
                                            Make sure to click <strong>Generate</strong> for each date. If you are unable to
                                            perform the service at a particular time, change the slot availability.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Note End -->

                            <!-- Choose Working Type Start -->
                            <div class="d-block">
                                <form action="{{ route('tasker-type-change') }}" method="POST" id="formtoggle">
                                    @csrf
                                    <div class="card shadow shadow-sm">
                                        <div class="card-header bg-primary">
                                            <h6 class="mb-0 text-white">Preferred Working Type</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-md-6">
                                                    <div class="fw-semibold">
                                                        Choose your working type
                                                    </div>
                                                    <small class=" form-text text-muted ">
                                                        Full time - (7:30 AM to 7:30 PM), Part time - (2:30 PM to 7:30 PM)
                                                    </small>
                                                </div>

                                                <div class="col-md-6">
                                                    <select name="tasker_worktype" class="form-select" id="workingtype">
                                                        @if (Auth::user()->tasker_worktype == null)
                                                            <option value="" selected>- Select -</option>
                                                            <option value="1">Full Time </option>
                                                            <option value="2">Part Time</option>
                                                        @elseif(Auth::user()->tasker_worktype == 1)
                                                            <option value="" disabled>- Select -</option>
                                                            <option value="1" selected>Full Time</option>
                                                            <option value="2">Part Time</option>
                                                        @elseif(Auth::user()->tasker_worktype == 2)
                                                            <option value="" disabled>- Select -</option>
                                                            <option value="1">Full Time</option>
                                                            <option value="2" selected>Part Time</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- Choose Working Type End -->

                            <!-- Time Slot Start -->
                            <div class="card shadow shadow-sm">
                                <div class="card-body">
                                    <div class="tab-content" id="nav-tabContent">
                                        <!-- Tabs will be dynamically generated -->
                                    </div>
                                </div>
                            </div>
                            <!-- Time Slot End -->

                        </div>
                    </div>
                </div>

            </div>

            <!-- Modal Time Slot Update Start Here -->
            @foreach ($data as $d)
                <form action="{{ route('tasker-timeslot-update', $d->id) }}" method="POST">
                    @csrf
                    <div class="modal fade" id="updateTimeSlot-{{ $d->id }}" data-bs-keyboard="false"
                        tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="mb-0">Update Availability</h5>
                                    <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default ms-auto"
                                        data-bs-dismiss="modal">
                                        <i class="ti ti-x f-20"></i>
                                    </a>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label">Slot</label>
                                                <input type="text" name="slot_id" class="form-control" id=""
                                                    value="{{ $d->time }}" readonly />
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label class="form-label">Status</label>
                                                <select name="slot_status"
                                                    class="form-control @error('slot_status') is-invalid @enderror">
                                                    @if ($d->slot_status == 1)
                                                        <option value="1" selected>Available</option>
                                                        <option value="0">Unavailable</option>
                                                    @else
                                                        <option value="1">Available</option>
                                                        <option value="0" selected>Unavailable</option>
                                                    @endif
                                                </select>
                                                @error('slot_status')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-end">
                                    <div class="flex-grow-1 text-end">
                                        <button type="reset" class="btn btn-link-danger btn-pc-default"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>
            @endforeach
            <!-- Modal Time Slot Update End  Here -->
            
        </div>
    </div>
    <!-- [ Main Content ] end -->



    <script type="text/javascript">
        $(document).ready(function() {

            $('#formtoggle').on('submit', function(e) {
                e.preventDefault();
                jQuery.ajax({
                    url: "{{ route('tasker-type-change') }}",
                    data: $('#formtoggle').serialize(),
                    type: "POST",
                    success: function(result) {
                        console.log(result); // Log the JSON response
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", xhr.responseText); // Log error details
                        alert("Something went wrong: " + xhr
                            .responseText); // Show error to user
                    }
                });
            });

            $('#workingtype').on('change', function() {
                $('#formtoggle').submit();
            });

        });

        document.addEventListener('DOMContentLoaded', function() {
            @if ($errors->any())
                var modal = new bootstrap.Modal(document.getElementById('addSlotModal'));
                modal.show();
            @endif
        });

        // Initialize on page load
        document.addEventListener("DOMContentLoaded", function() {
            // Populate tabs dynamically
            populateWeekTabs();

            // Refresh the tabs every day (optional: ensures the list updates if the app remains open)
            const refreshInterval = 24 * 60 * 60 * 1000; // 24 hours
            setInterval(populateWeekTabs, refreshInterval);
        });


        function getTaskerTimeSlots(date, container) {
            const url = "{{ route('get-tasker-timeslot', ':date') }}".replace(':date', encodeURIComponent(date));
            jQuery.ajax({
                url: url,
                type: "GET",
                success: function(result) {
                    console.log("AJAX success:", result); // Debug log
                    const data = result.data;
                    let html = '';

                    data.forEach(function(item) {
                        html += `
                    <div class="card p-4 border border-1 mt-3">
                        <div class="card-body">
                            ${item.slot_status == 1 
                                ? '<span class="badge text-bg-success">Available</span>'
                                : '<span class="badge text-bg-danger">Unavailable</span>'
                            }
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-truncate fw-semibold">${item.time}</span>
                                </div>
                                <div>
                                    <a href="#" class="avtar avtar-s btn-link-secondary" data-bs-toggle="modal" data-bs-target="#updateTimeSlot-${item.taskerTimeSlotID}">
                                        <i class="ti ti-edit f-18"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                    });

                    // Update the specific container with the fetched data
                    container.innerHTML = html;
                },
                error: function(xhr, status, error) {
                    container.innerHTML = '<p class="text-danger">Failed to load time slots.</p>';
                }
            });
        }

        const populateWeekTabs = () => {
            const today = new Date(); // Current date
            const listGroup = document.getElementById('list-tab');
            const tabContent = document.getElementById('nav-tabContent');

            // Clear existing content
            listGroup.innerHTML = '';
            tabContent.innerHTML = '';

            // Generate tabs for the next 7 days starting from today
            for (let i = 0; i < 7; i++) {
                const date = new Date(today);
                date.setDate(today.getDate() + i); // Increment date
                const formattedDate = date.toISOString().split('T')[0]; // Format as yyyy-mm-dd
                const listDate = date.toLocaleDateString('en-GB', {
                    day: 'numeric', // day without leading zero
                    month: 'long', // full month name
                    year: 'numeric' // 4-digit year
                });

                // Create the tab
                const tabId = `list-${i + 1}`;
                const tab = document.createElement('a');
                tab.className = 'list-group-item list-group-item-action';
                tab.id = tabId;
                tab.dataset.bsToggle = 'list';
                tab.href = `#list-mail-${i + 1}`;
                tab.role = 'tab';
                tab.innerHTML =
                    `
                    <div class="row justify-content-center align-items-center">
                        <div class="col-sm-12 mb-2">               
                            <span>${date.toLocaleDateString('en-GB', { weekday: 'long' })}</span>
                        </div>
                        <div class="col-sm-12">
                           <span class="fw-semibold">${listDate}</span>
                        </div>
                    </div>
                    `;
                listGroup.appendChild(tab);

                // Create the tab pane
                const tabPane = document.createElement('div');
                const taskerTimeslotCreateUrl = "{{ route('tasker-timeslot-create', ':date') }}";
                const generateUrl = taskerTimeslotCreateUrl.replace(':date', formattedDate);
                tabPane.className = 'tab-pane fade';
                tabPane.id = `list-mail-${i + 1}`;
                tabPane.role = 'tabpanel';
                tabPane.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center my-2 mb-3">
                        <h5>${date.toLocaleDateString('en-GB', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' })}</h5>
                        <a href="${generateUrl}" class="btn btn-primary btn-sm">
                            <i class="ti ti-plus"></i> Generate
                        </a>
                    </div>
                    <div class="tasker-timeslots">Loading...</div>
                `;
                getTaskerTimeSlots(formattedDate, tabPane.querySelector('.tasker-timeslots'));
                tabContent.appendChild(tabPane);
            }

            // Restore active tab after creating tabs
            restoreActiveTab();
        };

        function restoreActiveTab() {
            const activeTab = localStorage.getItem("activeTab");
            const savedDay = localStorage.getItem("selectedDay");

            if (activeTab) {
                const activeTabElement = document.getElementById(activeTab);
                if (activeTabElement) {
                    new bootstrap.Tab(activeTabElement).show(); // Activate the saved tab
                }
            }

            const dayInput = document.querySelector('.day'); // Hidden input for the day
            if (savedDay && dayInput) {
                dayInput.value = savedDay; // Restore the hidden input value
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            const tabListContainer = document.getElementById('list-tab');

            // Populate tabs dynamically
            populateWeekTabs();

            // Add click event listener for dynamically generated tabs
            tabListContainer.addEventListener("click", function(event) {
                if (event.target.matches('[data-bs-toggle="list"]') || event.target.closest(
                        '[data-bs-toggle="list"]')) {
                    const tab = event.target.closest('[data-bs-toggle="list"]');
                    const selectedDay = tab.querySelector('span').textContent
                        .toLowerCase(); // Get the day from span
                    const dayInput = document.querySelector('.day'); // Hidden input for the day

                    if (dayInput) {
                        dayInput.value = selectedDay; // Update the hidden input value
                    }
                    localStorage.setItem("activeTab", tab.id); // Store the active tab ID
                    localStorage.setItem("selectedDay", selectedDay); // Store the selected day
                }
            });
        });
    </script>
@endsection
<!--Created By: Muhammad Zikri B. Kashim (26/11/2024)-->
