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
            <div>
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="alert-heading">
                                <i class="fas fa-check-circle"></i>
                                Success
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <p class="mb-0">{{ session('success') }}</p>
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="alert-heading">
                                <i class="fas fa-info-circle"></i>
                                Error
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <p class="mb-0">{{ session('error') }}</p>
                    </div>
                @endif
            </div>
            <!-- End Alert -->

            <div class="row">

                <!-- Date Tab Start -->
                <div class="col-md-12">
                    <div class="card shadow shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <!-- Previous Button -->
                                <button class="avtar avtar-xs btn btn-light mx-2" id="prev-btn">
                                    <i class="fas fa-angle-left"></i>
                                </button>

                                <!-- List Group (Dates) -->
                                <div class="list-group list-group-horizontal overflow-auto flex-grow-1" id="list-tab"
                                    role="tablist" style="white-space: nowrap;">
                                    <!-- Tabs will be dynamically populated -->
                                </div>

                                <!-- Next Button -->
                                <button class="avtar avtar-xs btn btn-light mx-2" id="next-btn">
                                    <i class="fas fa-angle-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Date Tab End -->

                <!-- Time Slot Start -->
                <div class="col-md-12">
                    <div class="mail-content">
                        <div class="card shadow shadow-sm">
                            <div class="card-body">
                                <div class="tab-content" id="nav-tabContent">
                                    <!-- Tabs will be dynamically generated -->
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <!-- Time Slot End -->
            </div>

            <!-- Modal Time Slot Update Start Here -->
            @foreach ($data as $d)
                <form action="{{ route('tasker-timeslot-update', $d->id) }}" method="POST">
                    @csrf
                    <div class="modal fade" id="updateTimeSlot-{{ $d->id }}" data-bs-keyboard="false" tabindex="-1"
                        aria-hidden="true">
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
        // Next Prev Button 
        document.addEventListener('DOMContentLoaded', () => {
            const listGroup = document.getElementById('list-tab');
            const prevBtn = document.getElementById('prev-btn');
            const nextBtn = document.getElementById('next-btn');

            // Scroll by 200px to the left
            prevBtn.addEventListener('click', () => {
                listGroup.scrollBy({
                    left: -200,
                    behavior: 'smooth'
                });
            });

            // Scroll by 200px to the right
            nextBtn.addEventListener('click', () => {
                listGroup.scrollBy({
                    left: 200,
                    behavior: 'smooth'
                });
            });
        });

        // Initialize on page load
        document.addEventListener("DOMContentLoaded", function() {
            // Populate tabs dynamically
            populateWeekTabs();

            // Refresh the tabs every day (optional: ensures the list updates if the app remains open)
            const refreshInterval = 24 * 60 * 60 * 1000; // 24 hours
            setInterval(populateWeekTabs, refreshInterval);
        });

        //Formating time from 24-hour format to 12-hour format
        function formatTimeTo12Hour(time) {
            const [hours, minutes] = time.split(':').map(Number);
            const period = hours >= 12 ? 'PM' : 'AM';
            const adjustedHours = hours % 12 || 12;
            return `${adjustedHours}:${minutes.toString().padStart(2, '0')} ${period}`;
        }
        //Formating date 
        function formatDateLocal(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Month is 0-based
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        // AJAX : FETCHING TASKER TIME SLOT 
        function getTaskerTimeSlots(date, container) {
            const url = "{{ route('get-tasker-timeslot', ':date') }}".replace(':date', encodeURIComponent(date));
            jQuery.ajax({
                url: url,
                type: "GET",
                success: function(result) {
                    console.log("AJAX success:", result); // Debug log
                    const data = result.data;
                    let html = '';

                    if (data.length >= 1) {
                        data.forEach(function(item) {
                            const formattedTime = formatTimeTo12Hour(item.time);
                            html += `
                                <div class="card mb-3 border-1">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <!-- Time Slot Information -->
                                            <div class="col-8">
                                                <h6 class="mb-1">${formattedTime}</h6>
                                                ${
                                                    item.slot_status == 1 
                                                    ? '<span class="badge bg-success">Available</span>'
                                                    : item.slot_status == 2
                                                        ? '<span class="badge bg-warning">Booked</span>'
                                                        : '<span class="badge bg-danger">Unavailable</span>'
                                                }
                                            </div>

                                            <!-- Actions -->
                                            <div class="col-4 text-end">
                                                ${item.slot_status != 2
                                                    ? `
                                                                <a href="#" class="btn btn-light-primary btn-sm" 
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#updateTimeSlot-${item.taskerTimeSlotID}">
                                                                    <i class="ti ti-edit"></i> Edit
                                                                </a>`
                                                    : `
                                                                <button class="btn btn-outline-secondary btn-sm disabled">
                                                                    <i class="ti ti-edit"></i> Edit
                                                                </button>`
                                                }
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                    } else {
                        html += `
                            <div class="mb-3 mt-3 text-center text-muted fst-italic">
                                No time slots were generated for this date.
                            </div>
                        `;
                    }



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
            today.setHours(0, 0, 0, 0);
            // Generate tabs for the next 7 days starting from today
            for (let i = 0; i < 30; i++) {
                const date = new Date(today); // Salin tarikh semasa
                date.setDate(today.getDate() + i); // Tambah hari

                const formattedDate = formatDateLocal(date); // Format yyyy-mm-dd
                const listDate = date.toLocaleDateString('en-GB', {
                    day: 'numeric', // Hari tanpa sifar di depan
                    month: 'long', // Nama penuh bulan
                    year: 'numeric' // Tahun 4 digit
                });


                // Buat tab
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
                    <div class="row align-items-center my-2 mb-3">
                        <!-- Date Section -->
                        <div class="col-md-8">
                            <h5 class="mb-0">${date.toLocaleDateString('en-GB', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' })}</h5>
                        </div>

                        <!-- Generate Slot Button -->
                        <div class="col-md-4 text-md-end text-start mt-2 mt-md-0">
                            <a href="${generateUrl}" class="btn btn-light-primary btn-sm">
                                <i class="fas fa-calendar-plus me-2 f-16"></i> 
                                <span class="f-14">Generate Slot</span>
                            </a>
                        </div>
                    </div>

                    <div class="tasker-timeslots">
                        <div class="d-flex justify-content-center align-items-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
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
<!--Updated By: Muhammad Zikri B. Kashim (10/01/2025)-->
