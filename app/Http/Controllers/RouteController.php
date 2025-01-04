<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Client;
use App\Models\Review;
use App\Models\Tasker;
use App\Models\Booking;
use App\Models\Service;
use App\Models\TimeSlot;
use App\Models\ReviewReply;
use App\Models\ServiceType;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Administrator;
use Illuminate\Support\Facades\DB;
use App\Models\CancelRefundBooking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Pagination\LengthAwarePaginator;


class RouteController extends Controller
{


    /**** General Route Function - Start ****/

    // Get Area API
    public function getAreas($state)
    {
        $states = json_decode(file_get_contents(public_path('assets/json/state.json')), true);
        $areas = [];

        foreach ($states['states'] as $item) {
            if (strtolower($item['name']) == strtolower($state)) {
                $areas = $item['areas'];
                break;
            }
        }

        return response()->json($areas);
    }

    // Get Bank API
    public function getBank()
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 0);
        curl_setopt($curl, CURLOPT_URL, 'https://toyyibpay.com/index.php/api/getBank');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($curl);
        $info = curl_getinfo($curl);
        curl_close($curl);

        return response()->json($result);
    }

    /**** General Route Function - End ****/




    /**** Client Route Function - Start ****/

    //All Client Route Here ....

    //Client -Landing Page




    public function gotoIndex()
    {
        if (!Auth::guard('client')->check()) {
            return view('client.index', [
                'title' => 'Welcome !',
                'service' => ServiceType::all()
            ]);
        } else {
            return redirect(route('client-home'));
        }
    }

    //Client -LoginOrSignUp Option
    public function loginOptionNav()
    {
        return view('client.login-option', [
            'title' => 'Select Your Option'
        ]);
    }

    //Client- Sign Up Form
    public function clientRegisterFormNav()
    {
        $states = json_decode(file_get_contents(public_path('assets/json/state.json')), true);
        return view('client.register-client', [
            'title' => 'Sign Up Now !',
            'states' => $states
        ]);
    }

    // Client - First Time Login Form Navigation
    public function clientFirstTimeNav($id)
    {
        $client = Client::where('id', Crypt::decrypt($id))->first();

        return view('client.first-time', [
            'title' => 'First Time Login',
            'client' => $client
        ]);
    }

    //Client - Login Form
    public function clientLoginNav()
    {
        if (!Auth::guard('client')->check()) {

            return view('client.login', [
                'title' => 'Login to your account'
            ]);
        } else {
            return redirect(route('client-home'));
        }
    }
    //Client - Homepage Login
    public function clientSearchServicesNav()
    {
        return view('client.search-auth', [
            'title' => 'Search Your Services',
            'service' => ServiceType::all()

        ]);
    }
    //Client - Profile Homepage
    public function clientprofileNav()
    {
        $states = json_decode(file_get_contents(public_path('assets/json/state.json')), true);

        return view('client.account.profile-client', [
            'title' => 'My Profile',
            'states' => $states
        ]);
    }

    public function clientBooking($id)
    {
        // try {

        // Fetch taskers and calculate road distances
        $svtasker = DB::table('services as a')
            ->join('service_types as b', 'a.service_type_id', '=', 'b.id')
            ->join('taskers as c', 'a.tasker_id', '=', 'c.id')
            ->where('b.id', '=', $id)
            ->where('a.service_status', '=', 1)
            ->select(
                'a.id as svID',
                'b.id as typeID',
                'c.id as taskerID',
                'a.service_rate_type',
                'a.service_rate',
                'a.service_status',
                'a.service_desc',
                'b.servicetype_name',
                'b.servicetype_status',
                'c.tasker_firstname',
                'c.tasker_lastname',
                'c.tasker_rating',
                'c.tasker_photo',
                'c.latitude as tasker_lat',
                'c.longitude as tasker_lng',
                'c.tasker_bio'
            )
            ->get();

        $sv = ServiceType::whereId($id)->first();

        $timeSlot = DB::table('time_slots as a')
            ->join('tasker_time_slots as b', 'a.id', '=', 'b.slot_id')
            ->where('b.slot_status', '=', 1)
            ->select('b.slot_id', 'a.time', 'b.tasker_id')
            ->get();

        $states = json_decode(file_get_contents(public_path('assets/json/state.json')), true);

        $review = DB::table('reviews as a')
            ->join('bookings as b', 'a.booking_id', '=', 'b.id')
            ->join('services as c', 'b.service_id', '=', 'c.id')
            ->join('taskers as d', 'c.tasker_id', '=', 'd.id')
            ->join('service_types as e', 'c.service_type_id', '=', 'e.id')
            ->join('clients as f', 'b.client_id', '=', 'f.id')
            ->select(
                'a.id as reviewID',
                'c.id as serviceID',
                'd.id as taskerID',
                'd.tasker_photo',
                'a.review_rating',
                'a.review_description',
                'a.review_imageOne',
                'a.review_imageTwo',
                'a.review_imageThree',
                'a.review_imageFour',
                'a.review_type',
                'a.review_status',
                'a.review_date_time',
                'f.client_firstname',
                'f.client_lastname',
                'f.client_area',
                'f.client_state'
            )
            ->get();

        return view('client.booking.index', [
            'title' => 'Describe your task',
            'tasker' => $svtasker,
            'sv' => $sv,
            'states' => $states,
            'time' => $timeSlot,
            'review' => $review
        ]);
        // } catch (Exception $e) {
        //     return back()->withErrors(['error' => $e->getMessage()]);
        // }
    }

    public function clientPaymentStatusNav(Request $request)
    {
        $data = [
            'status_id' => $request->query('status_id'),
            'billcode' => $request->query('billcode'),
            'order_id' => $request->query('order_id'),
            'msg' => $request->query('msg'),
            'transaction_id' => $request->query('transaction_id'),
            'current_date' => Carbon::now()->format('Y-m-d'),
            'current_time' => Carbon::now()->format('H:i:s'),
        ];

        return view('client.booking.payment-return', [
            'title' => 'Payment',
            'datas' => $data
        ]);
    }

    public function clientPaymentNav(Request $request)
    {
        return redirect('https://dev.toyyibpay.com/' . $request->billcode);
    }

    public function clientPaymentCallbackNav(Request $request)
    {

        Transaction::where('booking_order_id', $request->order_id)
            ->update([
                'trans_refno' => $request->refno,
                'trans_status' => $request->status,
                'trans_reason' => $request->reason,
                'trans_billcode' => $request->billcode,
                'trans_amount' => $request->amount,
                'trans_transaction_time' => $request->transaction_time,
            ]);

        if ($request->status == '1') {
            $status_payment = 2;
        } else {
            $status_payment = 1;
        }

        Booking::where('booking_order_id', $request->order_id)
            ->update([
                'booking_status' => $status_payment
            ]);
    }


    public function clientBookingHistoryNav()
    {
        $booking = DB::table('bookings as a')
            ->join('services as c', 'a.service_id', '=', 'c.id')
            ->join('service_types as d', 'c.service_type_id', '=', 'd.id')
            ->join('taskers as e', 'c.tasker_id', '=', 'e.id')
            ->select(
                'a.id as bookingID',
                'a.booking_date',
                'a.booking_address',
                'a.booking_latitude',
                'a.booking_longitude',
                'a.booking_time_start',
                'a.booking_time_end',
                'a.booking_status',
                'a.booking_note',
                'a.booking_rate',
                'a.booking_order_id',
                'a.client_id',
                'a.service_id',
                'a.created_at',
                'a.updated_at',
                'c.service_rate',
                'c.service_rate_type',
                'c.service_desc',
                'c.service_status',
                'c.service_type_id',
                'd.servicetype_name',
                'd.servicetype_desc',
                'd.servicetype_status',
                'e.id as taskerID',
                'e.tasker_code',
                'e.tasker_photo',
                'e.tasker_firstname',
                'e.tasker_lastname',
                'e.tasker_phoneno',
                'e.email'
            )
            ->where('a.client_id', Auth::user()->id)
            ->orderBy('booking_date', 'desc')
            ->orderBy('booking_status', 'asc')
            ->get();

        // Grouping berdasarkan booking_date
        $groupedBookings = $booking->groupBy('booking_date');
        $toServeBookings = collect($booking)
            ->whereIn('booking_status', [1, 2, 3, 4])
            ->groupBy('booking_date');

        $groupedBookings = $booking->groupBy('booking_date');
        $completed = collect($booking)
            ->whereIn('booking_status', [6])
            ->groupBy('booking_date');

        $groupedBookings = $booking->groupBy('booking_date');
        $cancelled = collect($booking)
            ->whereIn('booking_status', [5])
            ->groupBy('booking_date');

        $groupedBookings = $booking->groupBy('booking_date');
        $refund = collect($booking)
            ->whereIn('booking_status', [7, 8, 9, 10])
            ->groupBy('booking_date');

        $review = Review::all();
        $refunds = DB::table('cancel_refund_bookings')->get();
        // dd($refunds->booking_id);

        $bank = json_decode(file_get_contents(public_path('assets/json/bank.json')), true);

        return view('client.booking.booking-history', [
            'title' => 'My Booking History',
            'book' => $groupedBookings,
            'toServeBooking' => $toServeBookings,
            'completed' => $completed,
            'cancelled' => $cancelled,
            'refund' => $refund,
            'review' => $review,
            'bank' => $bank,
            'refunds' => $refunds
        ]);
    }

    public function clientViewReview()
    {
        return view('client.booking.view-review', [
            'title' => 'My Review',
        ]);
    }



    /**** Client Route Function - End ****/




    /**** Tasker Route Function - Start ****/

    // Tasker - Registration Form Navigation
    public function taskerRegisterFormNav()
    {
        return view('tasker.register-tasker', [
            'title' => 'Tasker Registration'
        ]);
    }

    // Tasker - First Time Login Form Navigation
    public function taskerFirstTimeNav($id)
    {
        $tasker = Tasker::where('id', Crypt::decrypt($id))->first();

        return view('tasker.first-time', [
            'title' => 'First Time Login',
            'tasker' => $tasker
        ]);
    }

    // Tasker - Login Form Navigation
    public function taskerLoginNav()
    {
        if (!Auth::guard('tasker')->check()) {
            return view('tasker.login', [
                'title' => 'Tasker Login'
            ]);
        } else {
            return redirect(route('tasker-home'));
        }
    }

    // Tasker - Dashboard Navigation
    public function taskerhomeNav()
    {
        return view('tasker.index', [
            'title' => 'Tasker Dashboard'
        ]);
    }

    // Tasker - Profile Navigation
    public function taskerprofileNav()
    {
        $states = json_decode(file_get_contents(public_path('assets/json/state.json')), true);
        return view('tasker.account.profile', [
            'title' => 'Tasker Profile',
            'states' => $states
        ]);
    }

    // Tasker - Service Management Navigation
    public function taskerServiceManagementNav(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table('services as a')
                ->join('service_types as b', 'a.service_type_id', 'b.id')
                ->select('a.id', 'b.servicetype_name', 'a.service_rate', 'a.service_rate_type', 'a.service_status', 'a.tasker_id')
                ->where('a.tasker_id', '=', Auth::user()->id)
                ->get();

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('service_rate', function ($row) {

                $rate = $row->service_rate . ' / ' . $row->service_rate_type;
                return $rate;
            });

            $table->addColumn('service_status', function ($row) {

                if ($row->service_status == 0) {
                    $status = ' <span class="badge text-bg-warning text-white">Pending</span>';
                } else if ($row->service_status == 1) {
                    $status = '<span class="badge text-bg-success text-white">Active</span>';
                } else if ($row->service_status == 2) {
                    $status = '<span class="badge text-bg-danger text-white">Inactive</span>';
                } else if ($row->service_status == 3) {
                    $status = '<span class="badge bg-danger">Rejected</span>';
                } else if ($row->service_status == 4) {
                    $status = '<span class="badge bg-light-danger">Terminated</span>';
                }

                return $status;
            });

            $table->addColumn('action', function ($row) {

                if ($row->service_status == 0) {
                    $button =
                        '
                          <a href="#" class="avtar avtar-xs  btn-light-danger deleteService-' . $row->id . '">
                            <i class="ti ti-trash f-20"></i>
                          </a>

                        <script>
                        document.querySelector(".deleteService-' . $row->id . '").addEventListener("click", function () {
                            const swalWithBootstrapButtons = Swal.mixin({
                            customClass: {
                                confirmButton: "btn btn-success",
                                cancelButton: "btn btn-danger"
                            },
                            buttonsStyling: false
                            });
                            swalWithBootstrapButtons
                            .fire({
                                title: "Are you sure?",
                                text: "This action cannot be undone.",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonText: "Yes, delete it!",
                                cancelButtonText: "No, cancel!",
                                reverseButtons: true
                            })
                            .then((result) => {
                                if (result.isConfirmed) {
                                    setTimeout(function() {
                                        location.href="' . route("tasker-service-delete", $row->id) . '";
                                    }, 1000);
                                } 
                            });
                        });
                        </script>
                    ';
                } else if ($row->service_status == 1 || $row->service_status == 2 || $row->service_status == 3) {
                    $button =
                        '
                      <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                        data-bs-target="#updateServiceModal-' . $row->id . '">
                        <i class="ti ti-edit f-20"></i>
                      </a>
                      <a href="#" class="avtar avtar-xs  btn-light-danger deleteService-' . $row->id . '">
                        <i class="ti ti-trash f-20"></i>
                      </a>

                    <script>
                        document.querySelector(".deleteService-' . $row->id . '").addEventListener("click", function () {
                            const swalWithBootstrapButtons = Swal.mixin({
                            customClass: {
                                confirmButton: "btn btn-success",
                                cancelButton: "btn btn-danger"
                            },
                            buttonsStyling: false
                            });
                            swalWithBootstrapButtons
                            .fire({
                                title: "Are you sure?",
                                text: "This action cannot be undone.",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonText: "Yes, delete it!",
                                cancelButtonText: "No, cancel!",
                                reverseButtons: true
                            })
                            .then((result) => {
                                if (result.isConfirmed) {
                                    setTimeout(function() {
                                        location.href="' . route("tasker-service-delete", $row->id) . '";
                                    }, 1000);
                                } 
                            });
                        });
                    </script>
                ';
                } else if ($row->service_status == 4) {
                    $button = 'Remarks : Make new application';
                }

                return $button;
            });

            $table->rawColumns(['service_rate', 'service_status', 'action']);

            return $table->make(true);
        }

        return view('tasker.service.index', [
            'title' => 'Service Management',
            'services' => Service::get(),
            'types' => ServiceType::where('servicetype_status', 1)->get()
        ]);
    }

    // Admin - Time Slot Setting
    public function taskerTimeSlotNav()
    {
        $data = DB::table('tasker_time_slots as a')
            ->join('time_slots as b', 'a.slot_id', '=', 'b.id')
            ->select('a.id', 'a.slot_status', 'a.slot_date', 'a.slot_id', 'b.time', 'b.slot_category')
            ->get();

        return view('tasker.task-preference.time-slot-index', [
            'title' => 'Manage Time Slot',
            'slots' => TimeSlot::all(),
            'data' => $data
        ]);
    }

    public function taskerVisibleLocNav()
    {
        $states = json_decode(file_get_contents(public_path('assets/json/state.json')), true);

        return view('tasker.task-preference.visibility-location', [
            'title' => 'Manage Visibility & Location',
            'states' => $states
        ]);
    }

    public function taskerBookingManagementNav(Request $request)
    {
        return view('tasker.booking.index', [
            'title' => 'My Booking',
        ]);
    }

    // Admin - Booking List

    public function taskerBookingListNav(Request $request)
    {
        $data = DB::table('bookings as a')
            ->join('services as b', 'a.service_id', 'b.id')
            ->join('service_types as c', 'b.service_type_id', 'c.id')
            ->join('taskers as d', 'b.tasker_id', 'd.id')
            ->join('clients as e', 'a.client_Id', 'e.id')
            ->select(
                'a.id as bookingID',
                'b.id as serviceID',
                'c.id as typeID',
                'd.id as taskerID',
                'a.booking_date',
                'a.booking_address',
                'a.booking_time_start',
                'a.booking_time_end',
                'a.booking_status',
                'a.booking_note',
                'a.booking_rate',
                'a.booking_order_id',
                'c.servicetype_name',
                'e.client_firstname',
                'e.client_lastname',
                'e.client_phoneno',
                'e.email as client_email',

            )
            ->whereNotIn('a.booking_status', [7, 8, 9, 10])
            ->where('b.tasker_id', Auth::user()->id)
            ->orderbyDesc('a.booking_date');

        // if ($request->has('startDate') && $request->has('endDate') && $request->input('startDate') != '' && $request->input('endDate') != '') {
        //     $startDate = Carbon::parse($request->input('startDate'))->format('Y-m-d');
        //     $endDate = Carbon::parse($request->input('endDate'))->format('Y-m-d');

        //     if ($startDate && $endDate) {
        //         $data->whereBetween('a.booking_date', [$request->startDate, $request->endDate]);
        //     }
        // }
        // $data->whereBetween('a.booking_date', ['2024-12-30', '2024-12-31']);
        $data = $data->get();
        // dd($data);

        if ($request->ajax()) {

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('client', function ($row) {
                $client = Str::headline($row->client_firstname . ' ' . $row->client_lastname);
                return $client;
            });

            $table->addColumn('booking_date', function ($row) {

                $date = Carbon::parse($row->booking_date)->format('d F Y');
                return $date;
            });

            $table->addColumn('booking_time', function ($row) {

                $startTime = Carbon::parse($row->booking_time_start)->format('g:i A');
                $endTime = Carbon::parse($row->booking_time_end)->format('g:i A');
                $time = $startTime . ' - ' . $endTime;
                return $time;
            });

            $table->addColumn('booking_status', function ($row) {

                if ($row->booking_status == 1) {
                    $status = '<span class="badge bg-warning">To Pay</span>';
                } else if ($row->booking_status == 2) {
                    $status = '<span class="badge bg-light-success">Paid</span>';
                } else if ($row->booking_status == 3) {
                    $status = '<span class="badge bg-success">Confirmed</span>';
                } else if ($row->booking_status == 4) {
                    $status = '<span class="badge bg-warning">Rescheduled</span>';
                } else if ($row->booking_status == 5) {
                    $status = '<span class="badge bg-danger">Cancelled</span>';
                } else if ($row->booking_status == 6) {
                    $status = '<span class="badge bg-success">Completed</span>';
                } else if ($row->booking_status == 6) {
                    $status = '<span class="badge bg-success">Completed</span>';
                }
                return $status;
            });

            $table->addColumn('booking_amount', function ($row) {

                if ($row->booking_status == 1) {
                    $amount = '<span class="text-warning"> ' . $row->booking_rate . '</span>';
                } else if ($row->booking_status == 2 || $row->booking_status == 3 || $row->booking_status == 4 || $row->booking_status == 6) {
                    $amount = '<span class="text-success"> ' . $row->booking_rate . '</span>';
                } else if ($row->booking_status == 5) {
                    $amount = '<span class="text-danger"> ' . $row->booking_rate . '</span>';
                }
                return $amount;
            });

            $table->addColumn('action', function ($row) {

                if ($row->booking_status == 1 || $row->booking_status == 2 || $row->booking_status == 3 || $row->booking_status == 4) {
                    $button =
                        '
                        <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#viewBookingDetails-' . $row->bookingID . '">
                            <i class="ti ti-eye f-20"></i>
                        </a>
                       
                    ';
                    // ' <a href="#" class="avtar avtar-xs btn-light-secondary" data-bs-toggle="modal" 
                    //         data-bs-target="#updatebooking-' . $row->bookingID . '">
                    //         <i class="ti ti-edit f-20"></i>
                    //     </a>'
                } else if ($row->booking_status == 5 || $row->booking_status == 6) {
                    $button =
                        '
                        <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#viewBookingDetails-' . $row->bookingID . '">
                            <i class="ti ti-eye f-20"></i>
                        </a>
                    ';
                }

                return $button;
            });

            $table->rawColumns(['client', 'booking_date', 'booking_time', 'booking_status', 'booking_amount', 'action']);

            return $table->make(true);
        }
        return view('tasker.booking.booking-list-index', [
            'title' => 'All Booking List',
            'books' => $data,
        ]);
    }

    public function taskerRefundBookingListNav(Request $request)
    {
        $data = DB::table('bookings as a')
            ->join('cancel_refund_bookings as f', 'a.id', 'f.booking_id')
            ->join('services as b', 'a.service_id', 'b.id')
            ->join('service_types as c', 'b.service_type_id', 'c.id')
            ->join('taskers as d', 'b.tasker_id', 'd.id')
            ->join('clients as e', 'a.client_Id', 'e.id')
            ->select(
                'a.id as bookingID',
                'b.id as serviceID',
                'c.id as typeID',
                'd.id as taskerID',
                'f.id as refundID',
                'a.booking_date',
                'a.booking_address',
                'a.booking_time_start',
                'a.booking_time_end',
                'a.booking_status',
                'a.booking_note',
                'a.booking_rate',
                'a.booking_order_id',
                'c.servicetype_name',
                'd.tasker_firstname',
                'd.tasker_lastname',
                'd.tasker_phoneno',
                'd.email as tasker_email',
                'd.tasker_code',
                'e.client_firstname',
                'e.client_lastname',
                'e.client_phoneno',
                'e.email as client_email',
                'f.cr_reason',
                'f.cr_status',
                'f.cr_date',
                'f.cr_amount',
                'f.cr_bank_name',
                'f.cr_account_name',
                'f.cr_account_number'
            )
            ->whereIn('a.booking_status', [7, 8])
            ->where('b.tasker_id', Auth::user()->id)
            ->orderbyDesc('a.booking_date')
            ->get();

        if ($request->ajax()) {

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('client', function ($row) {
                $client = Str::headline($row->client_firstname . ' ' . $row->client_lastname);
                return $client;
            });

            $table->addColumn('booking_date', function ($row) {

                $date = Carbon::parse($row->booking_date)->format('d F Y');
                return $date;
            });

            $table->addColumn('booking_time', function ($row) {

                $startTime = Carbon::parse($row->booking_time_start)->format('g:i A');
                $endTime = Carbon::parse($row->booking_time_end)->format('g:i A');
                $time = $startTime . ' - ' . $endTime;
                return $time;
            });

            $table->addColumn('refund_amount', function ($row) {

                if ($row->booking_status == 7) {
                    $amount = '<span class="text-warning text-center"> ' . $row->cr_amount . '</span>';
                } else if ($row->booking_status == 8) {
                    $amount = '<span class="text-danger text-center"> ' . $row->cr_amount . '</span>';
                }
                return $amount;
            });


            $table->addColumn('booking_status', function ($row) {

                if ($row->booking_status == 7) {
                    $status = '<span class="badge bg-light-warning">Pending Refund</span>';
                } else if ($row->booking_status == 8) {
                    $status = '<span class="badge bg-light-success">Refunded</span>';
                }
                return $status;
            });

            $table->addColumn('action', function ($row) {

                $button =
                    '
                        <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#viewBookingDetails-' . $row->bookingID . '">
                            <i class="ti ti-eye f-20"></i>
                        </a>
                    ';


                return $button;
            });

            $table->rawColumns(['client', 'booking_date', 'booking_time', 'refund_amount', 'booking_status', 'action']);

            return $table->make(true);
        }
        return view('tasker.booking.refund-list-index', [
            'title' => 'Refund Booking List',
            'books' => $data,
        ]);
    }
    public function taskerReviewManagementNav(Request $request)
    {
        $data = DB::table('bookings as a')
            ->join('reviews as f', 'a.id', 'f.booking_id')
            ->join('services as b', 'a.service_id', 'b.id')
            ->join('service_types as c', 'b.service_type_id', 'c.id')
            ->join('taskers as d', 'b.tasker_id', 'd.id')
            ->join('clients as e', 'a.client_Id', 'e.id')
            ->select(
                'a.id as bookingID',
                'b.id as serviceID',
                'c.id as typeID',
                'd.id as taskerID',
                'f.id as reviewID',
                'a.booking_date',
                'a.booking_address',
                'a.booking_time_start',
                'a.booking_time_end',
                'a.booking_status',
                'a.booking_note',
                'a.booking_rate',
                'a.booking_order_id',
                'c.servicetype_name',
                'd.tasker_firstname',
                'd.tasker_lastname',
                'd.tasker_phoneno',
                'd.email as tasker_email',
                'd.tasker_code',
                'e.client_firstname',
                'e.client_lastname',
                'e.client_phoneno',
                'e.email as client_email',
                'f.review_status',
                'f.review_rating',
                'f.review_description',
                'f.review_date_time',
                'f.review_imageOne',
                'f.review_imageTwo',
                'f.review_imageThree',
                'f.review_imageFour',
                'f.review_type',
            )
            ->where('d.id', Auth::user()->id);

        // Apply date range filter before calling get()
        if ($request->has('startDate') && $request->has('endDate') && $request->input('startDate') != '' && $request->input('endDate') != '') {
            $startDate = Carbon::parse($request->input('startDate'))->format('Y-m-d');
            $endDate = Carbon::parse($request->input('endDate'))->format('Y-m-d');

            if ($startDate && $endDate) {
                $data->whereBetween(DB::raw("DATE(f.review_date_time)"), [$startDate, $endDate]);
            }
        }

        if ($request->has('status_filter') && $request->input('status_filter') != '') {
            $data->where('f.review_status', $request->input('status_filter'));
        }

        if ($request->has('media_filter') && $request->input('media_filter') != '') {
            if ($request->input('media_filter') == '1') {
                // Filter for reviews that have at least one image
                $data->where(function ($query) {
                    $query->whereNotNull('f.review_imageOne')
                        ->orWhereNotNull('f.review_imageTwo')
                        ->orWhereNotNull('f.review_imageThree')
                        ->orWhereNotNull('f.review_imageFour');
                });
            } elseif ($request->input('media_filter') == '2') {
                // Filter for reviews that have no images
                $data->where(function ($query) {
                    $query->whereNull('f.review_imageOne')
                        ->whereNull('f.review_imageTwo')
                        ->whereNull('f.review_imageThree')
                        ->whereNull('f.review_imageFour');
                });
            }
        }

        if ($request->has('rating_filter') && $request->input('rating_filter') != '') {
            $ratingFilter = $request->input('rating_filter');
            if ($ratingFilter == '1') {
                $data->orderByDesc('f.review_rating'); // Highest rating first
            } elseif ($ratingFilter == '2') {
                $data->orderBy('f.review_rating'); // Lowest rating first
            }
        } else {
            $data->orderByDesc('f.review_date_time');
        }

        $data = $data->get();

        if ($request->ajax()) {

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('booking_order_id', function ($row) {
                $orderid = '<button class="btn btn-link link-primary" data-bs-toggle="modal" data-bs-target="#viewBookingDetails-' . $row->bookingID . '">' . $row->booking_order_id . '</button>';
                return $orderid;
            });

            $table->addColumn('client', function ($row) {
                $client = Str::headline($row->client_firstname . ' ' . $row->client_lastname);
                return $client;
            });

            $table->addColumn('review_rating', function ($row) {

                $rating = '';
                for ($i = 1; $i <= $row->review_rating; $i++) {
                    $rating .= '<i class="fas fa-star text-warning"></i>';
                }
                return $rating;
            });


            $table->addColumn('review_date_time', function ($row) {

                $datetime = Carbon::parse($row->review_date_time)->setTimezone('Asia/Kuala_Lumpur')->format('d F Y g:i A');
                return $datetime;
            });

            $table->addColumn('review_description', function ($row) {
                // Define maximum rows and columns
                $maxRows = 3;
                $maxCols = 18;

                // Calculate the maximum number of characters that can fit
                $maxCharsPerRow = $maxCols;
                $maxTotalChars = $maxRows * $maxCharsPerRow;

                // Truncate the description to fit within the maximum allowed size
                $description = strlen($row->review_description) > $maxTotalChars
                    ? substr($row->review_description, 0, $maxTotalChars) . '...'
                    : $row->review_description;

                // Create the textarea element
                return '<textarea class="form-control" rows="' . $maxRows . '" cols="' . $maxCols . '" readonly style="resize: none;">'
                    . htmlspecialchars($description)
                    . '</textarea>';
            });

            $table->addColumn('review_status', function ($row) {

                if ($row->review_status == 1) {
                    $status = '<span class="badge bg-success">Show</span>';
                } else if ($row->review_status == 2) {
                    $status = '<span class="badge bg-danger">Hide</span>';
                }

                return $status;
            });

            $table->addColumn('action', function ($row) {
                $button =
                    '
                        <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#viewReviewDetails-' . $row->reviewID . '">
                            <i class="ti ti-eye f-20"></i>
                        </a>
                        <a href="#" class="avtar avtar-xs btn-light-warning" data-bs-toggle="modal"
                            data-bs-target="#replyReview-' . $row->reviewID . '">
                            <i class="ti ti-repeat f-20"></i>
                        </a>
                    ';
                return $button;
            });

            $table->rawColumns(['booking_order_id', 'client', 'review_rating', 'review_date_time', 'review_description', 'review_status', 'action']);

            return $table->make(true);
        }

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $totalreview = $data->count();


        // Count total reviews by month
        $totalreviewsbymonth = DB::table('bookings as a')
            ->join('reviews as f', 'a.id', 'f.booking_id')
            ->join('services as b', 'a.service_id', 'b.id')
            ->join('service_types as c', 'b.service_type_id', 'c.id')
            ->join('taskers as d', 'b.tasker_id', 'd.id')
            ->whereMonth('f.review_date_time', $currentMonth)
            ->whereYear('f.review_date_time', $currentYear)
            ->where('d.id', auth()->user()->id)
            ->count();

        // Count total reviews by year

        $totalreviewsbyyear = DB::table('bookings as a')
            ->join('reviews as f', 'a.id', 'f.booking_id')
            ->join('services as b', 'a.service_id', 'b.id')
            ->join('service_types as c', 'b.service_type_id', 'c.id')
            ->join('taskers as d', 'b.tasker_id', 'd.id')
            ->whereYear('f.review_date_time', $currentYear)
            ->where('d.id', auth()->user()->id)
            ->count();

        // Count total unreviewed bookings
        $totalcompletedBooking = DB::table('bookings as a')
            ->join('services as b', 'a.service_id', 'b.id')
            ->join('service_types as c', 'b.service_type_id', 'c.id')
            ->join('taskers as d', 'b.tasker_id', 'd.id')
            ->where('a.booking_status', 6)
            ->where('d.id', auth()->user()->id)
            ->count();

        $totalunreview = $totalcompletedBooking - $totalreview;

        // Count total average rating
        $averageRating = DB::table('bookings as a')
            ->join('reviews as f', 'a.id', 'f.booking_id')
            ->join('services as b', 'a.service_id', 'b.id')
            ->join('service_types as c', 'b.service_type_id', 'c.id')
            ->join('taskers as d', 'b.tasker_id', 'd.id')
            ->where('d.id', auth()->user()->id)
            ->avg('f.review_rating');

        // Count Percentage of Positive and Negative Reviews and Nuetral Reviews
        $csat =
            $totalreview > 0
            ? number_format(
                ($data->where('review_rating', '>=', 4)->count() / $totalreview) * 100,
                2,
            )
            : 0;
        $neutralrev =
            $totalreview > 0
            ? number_format(
                ($data->where('review_rating', '=', 3)->count() / $totalreview) * 100,
                2,
            )
            : 0;
        $negrev =
            $totalreview > 0
            ? number_format(
                ($data->where('review_rating', '<', 3)->count() / $totalreview) * 100,
                2,
            )
            : 0;

        $reply = DB::table('reviews as a')
            ->join('bookings as b', 'a.booking_id', 'b.id')
            ->join('services as c', 'b.service_id', 'c.id')
            ->join('taskers as d', 'c.tasker_id', 'd.id')
            ->join('review_replies as e', 'a.id', 'e.review_id')
            ->whereNotNull('e.reply_message')
            ->get();

        // dd($reply);

        return view('tasker.performance.review-index', [
            'title' => 'Review Management',
            'data' => $data,
            'totalreviewsbymonth' => $totalreviewsbymonth,
            'totalreviewsbyyear' => $totalreviewsbyyear,
            'totalunreview' => $totalunreview,
            'averageRating' => $averageRating,
            'csat' => $csat,
            'negrev' => $negrev,
            'neutralrev' => $neutralrev,
            'reply' => $reply
        ]);
    }

    public function taskerPerformanceAnalysisNav()
    {
        $bookings = DB::table('bookings as a')
            ->join('services as b', 'a.service_id', 'b.id')
            ->where('b.tasker_id', auth()->user()->id)
            ->get();

        $completedBookings = $bookings->where('booking_status', 6)->count();
        // $completedBookings = 201;

        // Calculate progress
        if ($completedBookings <= 20) {
            $progress = ($completedBookings / 20) * 100;
        } elseif ($completedBookings <= 80) {
            $progress = (($completedBookings - 20) / 60) * 100;
        } else {
            $progress = 100; // Max progress for Experienced Tasker
        }

        $taskerId = auth()->user()->id;

        // Get the current date and calculate the two previous months' ranges
        $twoMonthsAgo = now()->subMonths(2)->startOfMonth();
        $lastMonth = now()->subMonth()->startOfMonth();
        $endLastMonth = now()->subMonth()->endOfMonth();

        // label for the chart
        $dateLabel = [
            'currentDate' => now()->format('d F Y'),
            'lastMonth' => $lastMonth->format('F Y'),
            'twoMonthsAgo' => $twoMonthsAgo->format('F Y'),
        ];

        $taskers = DB::table('taskers')
            ->leftJoin('services', 'taskers.id', '=', 'services.tasker_id')
            ->leftJoin('bookings', 'services.id', '=', 'bookings.service_id')
            ->leftJoin('reviews', 'bookings.id', '=', 'reviews.booking_id')
            ->leftJoin('cancel_refund_bookings', 'bookings.id', '=', 'cancel_refund_bookings.booking_id')
            ->select(
                'taskers.tasker_code',
                'taskers.id',
                DB::raw("CONCAT(taskers.tasker_firstname, ' ', taskers.tasker_lastname) AS tasker_name"),
                DB::raw("AVG(reviews.review_rating) AS average_rating"),
                DB::raw("
                CASE 
                    WHEN AVG(reviews.review_rating) >= 4 THEN '1'
                    WHEN AVG(reviews.review_rating) >= 3 THEN '2'
                    ELSE '3'
                END AS satisfaction_reaction
            "),
                // 'taskers.tasker_selfrefund_count AS total_self_cancel_refunds',
                DB::raw("COUNT(CASE WHEN cancel_refund_bookings.cr_penalized = '1' THEN 1 END) AS total_self_cancel_refunds"),
                DB::raw("COUNT(CASE WHEN bookings.booking_status = '6' THEN 1 END) AS total_completed_bookings"),
                DB::raw("
                    ROUND(
                        (
                            (AVG(reviews.review_rating) / 5 * 60) -- Ratings contribute 60%
                            + (CASE WHEN AVG(reviews.review_rating) >= 4 THEN 15 ELSE 0 END) -- Satisfaction bonus (15%)
                            - LEAST(taskers.tasker_selfrefund_count * 2.5, 25) -- Refund penalty capped at 25%
                        ), 2
                    ) AS performance_score_percentage
                "),
            )
            ->groupBy('taskers.id')
            ->where('taskers.id', $taskerId);

        $pastPerformance = DB::table('taskers')
            ->leftJoin('services', 'taskers.id', '=', 'services.tasker_id')
            ->leftJoin('bookings', 'services.id', '=', 'bookings.service_id')
            ->leftJoin('reviews', 'bookings.id', '=', 'reviews.booking_id')
            ->leftJoin('cancel_refund_bookings', 'bookings.id', '=', 'cancel_refund_bookings.booking_id')
            ->select(
                DB::raw("DATE_FORMAT(bookings.booking_date, '%Y-%m') AS month"),
                DB::raw("AVG(reviews.review_rating) AS average_rating"),
                DB::raw("
                    ROUND(
                        (
                            (AVG(reviews.review_rating) / 5 * 60) -- Ratings contribute 60%
                            + (CASE WHEN AVG(reviews.review_rating) >= 4 THEN 15 ELSE 0 END) -- Satisfaction bonus (15%)
                            - LEAST(SUM(CASE WHEN cancel_refund_bookings.cr_penalized = '1' THEN 1 ELSE 0 END) * 2.5, 25) -- Refund penalty capped at 25%
                        ), 2
                    ) AS performance_score_percentage
                ")
            )
            ->where('taskers.id', $taskerId)
            ->whereBetween('bookings.booking_date', [$twoMonthsAgo, $endLastMonth])
            ->groupBy(DB::raw("DATE_FORMAT(bookings.booking_date, '%Y-%m')"))
            ->get();

        $taskers = $taskers->first();

        $taskerMonthlyRefunds = DB::table('taskers')
            ->leftJoin('services', 'taskers.id', '=', 'services.tasker_id')
            ->leftJoin('bookings', 'services.id', '=', 'bookings.service_id')
            ->leftJoin('reviews', 'bookings.id', '=', 'reviews.booking_id')
            ->leftJoin('cancel_refund_bookings', 'bookings.id', '=', 'cancel_refund_bookings.booking_id')
            ->select(
                DB::raw("DATE_FORMAT(bookings.booking_date, '%Y-%m') AS month"), // Extract year and month
                DB::raw("COUNT(cancel_refund_bookings.id) AS total_refunds"),   // Total refunds
                DB::raw("SUM(CASE WHEN cancel_refund_bookings.cr_penalized = '1' THEN 1 ELSE 0 END) AS penalized_refunds"), // Penalized refunds
            )
            ->where('taskers.id', $taskerId)
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->get();

        return view('tasker.performance.performance-analysis-index', [
            'title' => 'Performance Analysis',
            'completedBookings' => $completedBookings,
            'progress' => $progress,
            'taskers' => $taskers,
            'pastPerformance' => $pastPerformance,
            'date' => $dateLabel,
            'taskerMonthlyRefunds' => $taskerMonthlyRefunds
        ]);
    }
    /**** Tasker Route Function - End ****/




    /**** Administrator Route Function - Start ****/

    // Admin - First Time Login Navigation
    public function adminFirstTimeNav($id)
    {
        $admin = Administrator::where('id', Crypt::decrypt($id))->first();

        return view('administrator.first-time', [
            'title' => 'First Time Login',
            'admin' => $admin
        ]);
    }

    // Admin - Login Navigation
    public function adminLoginNav()
    {
        if (!Auth::guard('admin')->check()) {
            return view('administrator.login', [
                'title' => 'Admin Login'
            ]);
        } else {
            return redirect(route('admin-home'));
        }
    }

    // Admin - Dashboard Navigation
    public function adminHomeNav()
    {
        return view('administrator.index', [
            'title' => 'Admin Dashboard'
        ]);
    }

    // Admin - Profile Navigation
    public function adminprofileNav()
    {
        return view('administrator.admin.profile', [
            'title' => 'Administrator Profile',
        ]);
    }

    // Admin - Admin Management Navigation
    //Updated by: Zikri (5/12/2024)
    public function adminManagementNav(Request $request)
    {
        $data = DB::table('administrators')
            ->select('id', 'admin_firstname', 'admin_lastname', 'admin_phoneno', 'email', 'admin_status')
            ->orderBy('created_at', 'desc');

        if ($request->has('status_filter') && $request->input('status_filter') != '') {
            $data->having('admin_status', '=', $request->status_filter);
        }

        // Filter by first letter of the name
        if ($request->has('name_filter') && $request->input('name_filter') != '') {
            $letter = $request->input('name_filter');
            $data->where('admin_firstname', 'LIKE', "$letter%");
        }

        $data = $data->get();

        if ($request->ajax()) {
            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" class="user-checkbox form-check-input" value="' . $row->id . '">';
            });

            $table->addColumn('admin_fullname', function ($row) {
                return Str::headline($row->admin_firstname . ' ' . $row->admin_lastname);
            });

            $table->addColumn('admin_status', function ($row) {

                if ($row->admin_status == 0) {
                    $status = '<span class="text-warning"><i class="fas fa-circle f-10 m-r-10"></i> Not Activated</span>';
                } else if ($row->admin_status == 1) {
                    $status = '<span class="text-success"><i class="fas fa-circle f-10 m-r-10"></i> Active</span>';
                } else if ($row->admin_status == 2) {
                    $status = '<span class="text-danger"><i class="fas fa-circle f-10 m-r-10"></i> Inactive</span>';
                } else if ($row->admin_status == 3) {
                    $status = '<span class="text-danger"><i class="fas fa-circle f-10 m-r-10"></i> Deactivated</span>';
                }
                return $status;
            });

            $table->addColumn('action', function ($row) {
                if ($row->admin_status == 3) {
                    $button =
                        '
                        <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#updateAdminModal-' . $row->id . '">
                            <i class="ti ti-edit f-20"></i>
                        </a>
                    ';
                } else {
                    $button =
                        '
                        <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#updateAdminModal-' . $row->id . '">
                            <i class="ti ti-edit f-20"></i>
                        </a>
                        <a href="#" class="avtar avtar-xs  btn-light-danger" data-bs-toggle="modal"
                            data-bs-target="#deleteModal-' . $row->id . '">
                            <i class="ti ti-trash f-20"></i>
                        </a>
                    ';
                }

                return $button;
            });

            $table->rawColumns(['checkbox', 'admin_fullname', 'admin_status', 'action']);

            return $table->make(true);
        }
        $alphabet = range('A', 'Z');

        //calculation for admin not activated
        $notActivated = Administrator::where('admin_status', 0)->count();

        //calculation for admin activated
        $activated = Administrator::where('admin_status', 1)->count();

        //calculation for admin inactive
        $inactive = Administrator::where('admin_status', 2)->count();

        //calculation for admin deactivated
        $deactivated = Administrator::where('admin_status', 3)->count();


        return view('administrator.admin.index', [
            'title' => 'Admin Management',
            'admins' => Administrator::get(),
            'alphabet' => $alphabet,
            'notActivated' => $notActivated,
            'activated' => $activated,
            'inactive' => $inactive,
            'deactivated' => $deactivated
        ]);
    }

    // Admin - Tasker Management Navigation
    //Updated by: Zikri (5/12/2024)
    public function taskerManagementNav(Request $request)
    {
        $data = DB::table('taskers')
            ->select('id', 'tasker_code', 'tasker_firstname', 'tasker_lastname', 'email', 'tasker_status', 'tasker_phoneno')
            ->orderBy('created_at', 'desc');

        if ($request->ajax()) {

            // Filter by status
            if ($request->has('status_filter') && $request->input('status_filter') != '') {
                $data->having('tasker_status', '=', $request->status_filter);
            }

            // Filter by first letter of the name
            if ($request->has('name_filter') && $request->input('name_filter') != '') {
                $letter = $request->input('name_filter');
                $data->where('tasker_firstname', 'LIKE', "$letter%");
            }
            $data = $data->get();


            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" class="user-checkbox form-check-input" value="' . $row->id . '">';
            });

            $table->addColumn('tasker_fullname', function ($row) {
                return Str::headline($row->tasker_firstname . ' ' . $row->tasker_lastname);
            });

            $table->addColumn('tasker_status', function ($row) {
                if ($row->tasker_status == 0) {
                    $status = '<span class="text-warning"><i class="fas fa-circle f-10 m-r-10"></i>Incomplete Profile</span>';
                } else if ($row->tasker_status == 1) {
                    $status = '<span class="text-warning"><i class="fas fa-circle f-10 m-r-10"></i>Not Verified</span>';
                } else if ($row->tasker_status == 2) {
                    $status = '<span class="text-success"><i class="fas fa-circle f-10 m-r-10"></i>Active</span>';
                } else if ($row->tasker_status == 3) {
                    $status = '<span class="text-danger"><i class="fas fa-circle f-10 m-r-10"></i>Inactive</span>';
                } else if ($row->tasker_status == 4) {
                    $status = '<span class="text-warning"><i class="fas fa-circle f-10 m-r-10"></i>Password Reset Needed</span>';
                } else if ($row->tasker_status == 5) {
                    $status = '<span class="text-danger"><i class="fas fa-circle f-10 m-r-10"></i>Banned</span>';
                }

                return $status;
            });

            $table->addColumn('action', function ($row) {

                if ($row->tasker_status == 0 || $row->tasker_status == 4) {
                    $button =
                        '
                        <button class="btn avtar avtar-xs btn-light-primary" disabled>
                            <i class="ti ti-edit f-20"></i>
                        </button>
                    ';
                } else {
                    $button =
                        '
                        <a href="#taskermodal" data-bs-toggle="modal" data-bs-target="#updateTaskerModal-' . $row->id . '" class="avtar avtar-xs btn-light-primary">
                            <i class="ti ti-edit f-20"></i>
                        </a>
                    ';
                }

                return $button;
            });

            $table->rawColumns(['tasker_fullname', 'checkbox', 'tasker_status', 'action']);
            return $table->make(true);
        }

        $states = json_decode(file_get_contents(public_path('assets/json/state.json')), true);
        $bank = json_decode(file_get_contents(public_path('assets/json/bank.json')), true);

        $alphabet = range('A', 'Z');

        //calculation of incomplete profile taskers
        $incompleteTaskers = Tasker::where('tasker_status', 0)->count();

        //calculation of unverified taskers
        $unverifiedTaskers = Tasker::where('tasker_status', 1)->count();

        //calculation of total active taskers
        $activeTaskers = Tasker::where('tasker_status', 2)->count();

        //calculation of total inactive taskers
        $inactiveTaskers = Tasker::where('tasker_status', 3)->count();

        //calculation of total password reset needed taskers
        $resetTaskers = Tasker::where('tasker_status', 4)->count();

        //calculation of total banned taskers
        $bannedTaskers = Tasker::where('tasker_status', 5)->count();

        return view('administrator.tasker.index', [
            'title' => 'Tasker Management',
            'taskers' => Tasker::get(),
            'states' => $states,
            'bank' => $bank,
            'alphabet' => $alphabet,
            'incompleteTaskers' => $incompleteTaskers,
            'unverifiedTaskers' => $unverifiedTaskers,
            'activeTaskers' => $activeTaskers,
            'inactiveTaskers' => $inactiveTaskers,
            'resetTaskers' => $resetTaskers,
            'bannedTaskers' => $bannedTaskers
        ]);
    }

    // Admin - Tasker Profile Navigation
    //Updated by: Zikri (5/12/2024)
    public function taskerUpdateNav($id)
    {
        $data = Tasker::where('tasker_code', Crypt::decrypt($id))->first();
        $states = json_decode(file_get_contents(public_path('assets/json/state.json')), true);

        return view('administrator.tasker.update-tasker', [
            'title' => $data->tasker_firstname . ' profile',
            'tasker' => $data,
            'states' => $states,
        ]);
    }

    // Admin - Tasker Management Navigation
    //Updated by: Zikri (5/12/2024)
    public function clientManagementNav(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table('clients')
                ->select('id', 'client_firstname', 'client_lastname', 'client_phoneno', 'email', 'client_status', 'client_state')
                ->orderBy('created_at', 'desc');

            // Filter by status
            if ($request->has('status_filter') && $request->input('status_filter') != '') {
                $data->having('client_status', '=', $request->status_filter);
            }

            // Filter by first letter of the name
            if ($request->has('name_filter') && $request->input('name_filter') != '') {
                $letter = $request->input('name_filter');
                $data->where('client_firstname', 'LIKE', "$letter%");
            }
            $data = $data->get();


            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" class="user-checkbox form-check-input" value="' . $row->id . '">';
            });

            $table->addColumn('client_fullname', function ($row) {
                return Str::headline($row->client_firstname . ' ' . $row->client_lastname);
            });

            $table->addColumn('client_status', function ($row) {
                if ($row->client_status == 0) {
                    $status = '<span class="badge bg-light-success">Newly Registered</span>';
                } else if ($row->client_status == 1) {
                    $status = '<span class="badge bg-light-danger">Admin Referal</span>';
                } else if ($row->client_status == 2) {
                    $status = '<span class="text-success"><i class="fas fa-circle f-10 m-r-10"></i> Active</span>';
                } else if ($row->client_status == 3) {
                    $status = '<span class="text-danger"><i class="fas fa-circle f-10 m-r-10"></i> Inactive</span>';
                } else if ($row->client_status == 4) {
                    $status = '<span class="text-danger"><i class="fas fa-circle f-10 m-r-10"></i> Deactivated</span>';
                }
                return $status;
            });

            $table->addColumn('client_state', function ($row) {
                $state = Str::ucfirst($row->client_state);
                return $state;
            });

            $table->addColumn('action', function ($row) {
                if ($row->client_status == 4) {
                    $button =
                        '
                        <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#updateClientModal-' . $row->id . '">
                            <i class="ti ti-edit f-20"></i>
                        </a>
                    ';
                } else {
                    $button =
                        '
                        <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#updateClientModal-' . $row->id . '">
                            <i class="ti ti-edit f-20"></i>
                        </a>
                        <a href="#" class="avtar avtar-xs  btn-light-danger" data-bs-toggle="modal"
                            data-bs-target="#deleteModal-' . $row->id . '">
                            <i class="ti ti-trash f-20"></i>
                        </a>
                    ';
                }

                return $button;
            });

            $table->rawColumns(['checkbox', 'client_fullname', 'client_status', 'client_state', 'action']);
            return $table->make(true);
        }

        //calculation of total active clients
        $activeClients = Client::where('client_status', 2)->count();

        //calculation of total inactive clients
        $inactiveClients = Client::where('client_status', 3)->count();

        //calculation of total deactivated clients
        $deactivatedClients = Client::where('client_status', 4)->count();

        //calculation of total clients
        $totalClients = Client::count();

        //calculation of total newly registered clients
        $nRegisterClients = Client::where('client_status', 0)->count();

        $states = json_decode(file_get_contents(public_path('assets/json/state.json')), true);
        $alphabet = range('A', 'Z');
        return view('administrator.client.index', [
            'title' => 'Client Management',
            'clients' => Client::get(),
            'states' => $states,
            'alphabet' => $alphabet,
            'activeClients' => $activeClients,
            'inactiveClients' => $inactiveClients,
            'deactivatedClients' => $deactivatedClients,
            'totalClients' => $totalClients,
            'nRegisterClients' => $nRegisterClients
        ]);
    }

    // Admin - Service Type Management Navigation
    //Updated by: Zikri (5/12/2024)
    public function serviceTypeManagementNav(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table('service_types')
                ->select('id', 'servicetype_name', 'servicetype_desc', 'servicetype_status')
                ->get();

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('servicetype_status', function ($row) {

                if ($row->servicetype_status == 1) {
                    $status = '<span class="badge rounded-pill text-bg-success">Show</span>';
                } else if ($row->servicetype_status == 2) {
                    $status = '<span class="badge rounded-pill text-bg-danger">Hide</span>';
                }
                return $status;
            });

            $table->addColumn('action', function ($row) {
                $isReferenced = DB::table('services')->where('service_type_id', $row->id)->exists();
                $buttonEdit =
                    '
                    <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                        data-bs-target="#updateServiceTypeModal-' . $row->id . '">
                        <i class="ti ti-edit f-20"></i>
                    </a>
                ';
                if (!$isReferenced) {
                    $buttonRemove =
                        '
                    <a href="#" class="avtar avtar-xs  btn-light-danger" data-bs-toggle="modal"
                        data-bs-target="#deleteModal-' . $row->id . '">
                        <i class="ti ti-trash f-20"></i>
                    </a>
                    ';
                } else {
                    $buttonRemove = '';
                }

                return $buttonEdit . $buttonRemove;
            });

            $table->rawColumns(['servicetype_status', 'action']);

            return $table->make(true);
        }
        return view('administrator.service.servicetype-index', [
            'title' => 'Service Type Management',
            'stypes' => ServiceType::get(),
        ]);
    }

    // Admin - Service Approval Navigation
    //Updated by: Zikri (31/12/2024)
    public function adminServiceManagementNav(Request $request)
    {

        try {

            if ($request->ajax()) {

                $data = DB::table('services as a')
                    ->join('service_types as b', 'a.service_type_id', 'b.id')
                    ->join('taskers as c', 'a.tasker_id', 'c.id')
                    ->select('a.id', 'b.servicetype_name', 'a.service_rate', 'a.service_rate_type', 'a.service_status', 'a.created_at', 'c.tasker_code', 'c.tasker_firstname')
                    ->orderBy('a.service_status', 'asc')
                    ->orderBy('a.created_at', 'desc');

                if ($request->has('status_filter') && $request->input('status_filter') != '') {
                    $data->having('service_status', '=', $request->status_filter);
                }

                $data = $data->get();

                $table = DataTables::of($data)->addIndexColumn();

                $table->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="service-checkbox form-check-input" value="' . $row->id . '">';
                });

                $table->addColumn('tasker', function ($row) {

                    $tasker = '<a href="#taskerDetailsModal" data-bs-toggle="modal" data-bs-target="#taskerDetailsModal-' . $row->tasker_code . '" class="btn btn-link">' . $row->tasker_code . '</a>';
                    return $tasker;
                });

                $table->addColumn('service_rate', function ($row) {

                    $rate = $row->service_rate . ' / ' . $row->service_rate_type;
                    return $rate;
                });

                $table->addColumn('service_status', function ($row) {

                    if ($row->service_status == 0) {
                        $status = ' <span class="badge text-bg-warning text-white">Pending</span>';
                    } else if ($row->service_status == 1) {
                        $status = '<span class="badge text-bg-success text-white">Active</span>';
                    } else if ($row->service_status == 2) {
                        $status = '<span class="badge text-bg-secondary text-white">Inactive</span>';
                    } else if ($row->service_status == 3) {
                        $status = '<span class="badge bg-danger">Rejected</span>';
                    } else if ($row->service_status == 4) {
                        $status = '<span class="badge bg-light-danger">Terminated</span>';
                    }

                    return $status;
                });

                $table->addColumn('action', function ($row) {

                    if ($row->service_status == 0) {
                        $button =
                            '
                            <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                                data-bs-target="#viewDescModal-' . $row->id . '">
                                <i class="ti ti-eye f-20"></i>
                            </a>
                            <a href="#" class="avtar avtar-xs btn-light-success" data-bs-toggle="modal" 
                                data-bs-target="#approveModal-' . $row->id . '">
                                <i class="ti ti-check f-20"></i>
                            </a>
                        ';
                    } else if ($row->service_status == 1) {
                        $button =
                            '
                            <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                                data-bs-target="#viewDescModal-' . $row->id . '">
                                <i class="ti ti-eye f-20"></i>
                            </a>
                            <a href="#" class="avtar avtar-xs btn-light-danger " data-bs-toggle="modal" 
                                data-bs-target="#terminateModal-' . $row->id . '">
                                <i class="ti ti-x f-20"></i>
                            </a>
                    ';
                    } else if ($row->service_status == 2 || $row->service_status == 3 || $row->service_status == 4) {
                        $button =
                            '
                            <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                                data-bs-target="#viewDescModal-' . $row->id . '">
                                <i class="ti ti-eye f-20"></i>
                            </a>
                        ';
                    }

                    return $button;
                });

                $table->rawColumns(['checkbox', 'tasker', 'service_rate', 'service_status', 'action']);

                return $table->make(true);
            }

            //calculation for total no of services enrolled
            $totalService = DB::table('services')->count();

            //calculation for total no of pending services
            $totalPendingService = DB::table('services')
                ->where('service_status', 0)
                ->count();

            //calculation for total no of active services
            $totalActiveService = DB::table('services')
                ->where('service_status', 1)
                ->count();

            //calculation for total no of inactive services
            $totalInactiveService = DB::table('services')
                ->where('service_status', 2)
                ->count();

            //calculation for total no of rejected services
            $totalRejectedService = DB::table('services')
                ->where('service_status', 3)
                ->count();

            //calculation for total no of terminated services
            $totalTerminatedService = DB::table('services')
                ->where('service_status', 4)
                ->count();

            //calculation for top 10 taskers
            $taskerServiceCounts = DB::table('services as a')
                ->join('taskers as c', 'a.tasker_id', '=', 'c.id')
                ->select('c.tasker_code', 'c.tasker_firstname', DB::raw('COUNT(a.id) as service_count'))
                ->groupBy('a.tasker_id', 'c.tasker_code', 'c.tasker_firstname')
                ->orderBy('service_count', 'desc')
                ->take(10) // Optional: Limit to the top 10 taskers
                ->get();

            //calculation for popular service types
            $popularServiceTypes = DB::table('services as a')
                ->join('service_types as b', 'a.service_type_id', '=', 'b.id')
                ->select('b.servicetype_name', DB::raw('COUNT(a.id) as service_count'))
                ->groupBy('b.servicetype_name')
                ->orderBy('service_count', 'desc')
                ->get();

            return view('administrator.service.index', [
                'title' => 'Service Approval',
                'services' => Service::get(),
                'types' => ServiceType::where('servicetype_status', 1)->get(),
                'totalService' => $totalService,
                'totalPendingService' => $totalPendingService,
                'totalActiveService' => $totalActiveService,
                'totalInactiveService' => $totalInactiveService,
                'totalRejectedService' => $totalRejectedService,
                'totalTerminatedService' => $totalTerminatedService,
                'taskerServiceCounts' => $taskerServiceCounts,
                'popularServiceTypes' => $popularServiceTypes,
                'taskers' => Tasker::get(),
            ]);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // Admin - Time Slot Setting
    //Updated by: Zikri (5/12/2024)
    public function adminTimeSlotNav(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table('time_slots')
                ->select('id', 'time', 'slot_category')
                ->orderBy('time', 'asc')
                ->orderBy('slot_category', 'asc')
                ->get();

            $table = DataTables::of($data)->addIndexColumn();


            $table->addColumn('slot_category', function ($row) {
                $cat = null;
                if ($row->slot_category == 1) {
                    $cat = '<span class="badge badge text-bg-primary">Full Time</span>';
                } else if ($row->slot_category == 2) {
                    $cat = '<span class="badge badge bg-light-primary">Part Time</span>';
                }

                return $cat;
            });

            $table->addColumn('action', function ($row) {
                $isReferenced = DB::table('tasker_time_slots')->where('slot_id', $row->id)->exists();
                $editButton = '
                    <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                        data-bs-target="#updateSlotModal-' . $row->id . '">
                        <i class="ti ti-edit f-20"></i>
                    </a>';

                if (!$isReferenced) {
                    $deleteButton = '
                        <a href="#" class="avtar avtar-xs btn-light-danger" data-bs-toggle="modal"
                            data-bs-target="#deleteModal-' . $row->id . '">
                            <i class="ti ti-trash f-20"></i>
                        </a>';
                } else {
                    $deleteButton = '';
                }
                return $editButton . $deleteButton;
            });
            $table->rawColumns(['slot_category', 'action']);

            return $table->make(true);
        }
        return view('administrator.setting.time-slot-index', [
            'title' => 'Time Slot Setting',
            'slots' => TimeSlot::all()
        ]);
    }

    // Admin - System Setting
    // Uncompleted
    public function adminSystemSettingNav()
    {
        return view('administrator.setting.system-index', [
            'title' => 'System Settings',

        ]);
    }

    // Admin - Extract State from Address
    //Updated by: Zikri (2/1/2025)
    private function extractState($address)
    {
        // Match the postal code (5 digits) followed by the state at the end
        $pattern = '/\d{5}\s*([A-Za-z\s]+)$/';
        if (preg_match($pattern, $address, $matches)) {
            return trim($matches[1]); // Return the state
        }
        return 'Unknown'; // Default if no match is found
    }

    // Admin Booking Management
    //Updated by: Zikri (2/1/2025)
    public function adminBookingManagementNav(Request $request)
    {
        $data = DB::table('bookings as a')
            ->join('services as b', 'a.service_id', 'b.id')
            ->join('service_types as c', 'b.service_type_id', 'c.id')
            ->join('taskers as d', 'b.tasker_id', 'd.id')
            ->join('clients as e', 'a.client_Id', 'e.id')
            ->select(
                'a.id as bookingID',
                'b.id as serviceID',
                'c.id as typeID',
                'd.id as taskerID',
                'a.booking_date',
                'a.booking_address',
                'a.booking_time_start',
                'a.booking_time_end',
                'a.booking_status',
                'a.booking_note',
                'a.booking_rate',
                'a.booking_order_id',
                'c.servicetype_name',
                'd.tasker_firstname',
                'd.tasker_lastname',
                'd.tasker_phoneno',
                'd.email as tasker_email',
                'd.tasker_code',
                'e.client_firstname',
                'e.client_lastname',
                'e.client_phoneno',
                'e.email as client_email',

            )
            ->whereNotIn('a.booking_status', [7, 8, 9, 10])
            ->orderbyDesc('a.booking_date');

        if ($request->has('startDate') && $request->has('endDate') && $request->input('startDate') != '' && $request->input('endDate') != '') {
            $startDate = Carbon::parse($request->input('startDate'))->format('Y-m-d');
            $endDate = Carbon::parse($request->input('endDate'))->format('Y-m-d');

            if ($startDate && $endDate) {
                $data->whereBetween('a.booking_date', [$request->startDate, $request->endDate]);
            }
        }

        if ($request->has('tasker_filter') && $request->input('tasker_filter') != '') {
            $data->where('d.id', $request->input('tasker_filter'));
        }

        if ($request->has('status_filter') && $request->input('status_filter') != '') {
            $data->where('a.booking_status', $request->input('status_filter'));
        }

        if ($request->has('state_filter') && $request->input('state_filter') != '') {
            $stateFilter = $request->input('state_filter');
            $data->whereRaw("TRIM(SUBSTRING_INDEX(a.booking_address, ' ', -1)) = ?", [$stateFilter]);
        }

        $data = $data->get();

        if ($request->ajax()) {

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" class="booking-checkbox form-check-input" value="' . $row->bookingID . '">';
            });

            $table->addColumn('tasker', function ($row) {
                $tasker = '<a href="' . route('admin-tasker-update-form', Crypt::encrypt($row->tasker_code)) . '" class="btn btn-link">' . $row->tasker_code . '</a>';
                return $tasker;
            });

            $table->addColumn('client', function ($row) {
                $client = Str::headline($row->client_firstname . ' ' . $row->client_lastname);
                return $client;
            });

            $table->addColumn('booking_date', function ($row) {

                $date = Carbon::parse($row->booking_date)->format('d F Y');
                return $date;
            });

            $table->addColumn('booking_time', function ($row) {

                $startTime = Carbon::parse($row->booking_time_start)->format('g:i A');
                $endTime = Carbon::parse($row->booking_time_end)->format('g:i A');
                $time = $startTime . ' - ' . $endTime;
                return $time;
            });

            $table->addColumn('booking_status', function ($row) {

                if ($row->booking_status == 1) {
                    $status = '<span class="badge bg-warning">To Pay</span>';
                } else if ($row->booking_status == 2) {
                    $status = '<span class="badge bg-light-success">Paid</span>';
                } else if ($row->booking_status == 3) {
                    $status = '<span class="badge bg-light-success">Confirmed</span>';
                } else if ($row->booking_status == 4) {
                    $status = '<span class="badge bg-warning">Rescheduled</span>';
                } else if ($row->booking_status == 5) {
                    $status = '<span class="badge bg-danger">Cancelled</span>';
                } else if ($row->booking_status == 6) {
                    $status = '<span class="badge bg-success">Completed</span>';
                }
                return $status;
            });

            $table->addColumn('action', function ($row) {

                if ($row->booking_status == 1 || $row->booking_status == 2 || $row->booking_status == 3 || $row->booking_status == 4) {
                    $button =
                        '
                        <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#viewBookingDetails-' . $row->bookingID . '">
                            <i class="ti ti-eye f-20"></i>
                        </a>
                        <a href="#" class="avtar avtar-xs btn-light-secondary" data-bs-toggle="modal" 
                            data-bs-target="#updatebooking-' . $row->bookingID . '">
                            <i class="ti ti-edit f-20"></i>
                        </a>
                    ';
                } else if ($row->booking_status == 5 || $row->booking_status == 6) {
                    $button =
                        '
                        <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#viewBookingDetails-' . $row->bookingID . '">
                            <i class="ti ti-eye f-20"></i>
                        </a>
                    ';
                }

                return $button;
            });

            $table->rawColumns(['checkbox', 'tasker', 'client', 'booking_date', 'booking_time', 'booking_status', 'action']);

            return $table->make(true);
        }

        // Default values for calculations
        $totalBooking = 0;
        $totalUnpaid = 0;
        $totalConfirmed = 0;
        $totalCompleted = 0;
        $totalCancelled = 0;
        $totalCompletedAmount = '0.00';
        $totalCancelledAmount = '0.00';
        $totalFloatingAmount = '0.00';

        $stateCounts = [];
        $completedCounts = [];
        $unpaidCounts = [];
        $cancelledCounts = [];

        // Check if there is data
        if ($data->isNotEmpty()) {
            // Calculate totals
            $totalBooking = $data->count();
            $totalUnpaid = $data->where('booking_status', 1)->count();
            $totalConfirmed = $data->where('booking_status', 3)->count();
            $totalCompleted = $data->where('booking_status', 6)->count();
            $totalCancelled = $data->where('booking_status', 5)->count();

            $totalCompletedAmount = number_format($data->where('booking_status', 6)->sum('booking_rate'), 2);
            $totalCancelledAmount = number_format($data->where('booking_status', 5)->sum('booking_rate'), 2);
            $totalFloatingAmount = number_format($data->whereIn('booking_status', [1, 2, 3, 4])->sum('booking_rate'), 2);
        }

        $bookings = DB::table('bookings')
            ->select('booking_address', 'booking_status')
            ->get();

        if ($bookings->isNotEmpty()) {
            // Initialize counts for each state and status
            foreach ($bookings as $booking) {
                $state = $this->extractState($booking->booking_address);

                if (!isset($stateCounts[$state])) {
                    $stateCounts[$state] = 0;
                    $completedCounts[$state] = 0;
                    $unpaidCounts[$state] = 0;
                    $cancelledCounts[$state] = 0;
                }

                // Increment total bookings for the state
                $stateCounts[$state]++;

                // Increment based on booking status
                switch ($booking->booking_status) {
                    case 6: // Completed
                        $completedCounts[$state]++;
                        break;
                    case 1: // Unpaid
                        $unpaidCounts[$state]++;
                        break;
                    case 5: // Cancelled
                        $cancelledCounts[$state]++;
                        break;
                }
            }
        }

        // Prepare data for the chart
        $dataChart = [
            'states' => array_keys($stateCounts),
            'totalBookings' => array_values($stateCounts),
            'completedBookings' => array_values($completedCounts),
            'unpaidBookings' => array_values($unpaidCounts),
            'cancelledBookings' => array_values($cancelledCounts),
        ];

        $states = json_decode(file_get_contents(public_path('assets/json/state.json')), true);

        // Monthly Chart Data
        $monthlyData = Booking::selectRaw("
            YEAR(booking_date) as year,
            MONTH(booking_date) as month,
            SUM(CASE WHEN booking_status = 6 THEN booking_rate ELSE 0 END) as completedAmount,
            SUM(CASE WHEN booking_status IN (1, 2, 3) THEN booking_rate ELSE 0 END) as floatingAmount,
            SUM(CASE WHEN booking_status = 5 THEN booking_rate ELSE 0 END) as cancelledAmount
        ")
            ->groupBy('year', 'month')
            ->get();

        $monthlyChartData = [
            'labels' => [],
            'completed' => [],
            'floating' => [],
            'cancelled' => [],
        ];

        // Format monthly data for the chart
        foreach ($monthlyData as $dataChartTwo) {
            $monthYear = Carbon::create($dataChartTwo->year, $dataChartTwo->month)->format('F Y');
            $monthlyChartData['labels'][] = $monthYear;
            $monthlyChartData['completed'][] = $dataChartTwo->completedAmount;
            $monthlyChartData['floating'][] = $dataChartTwo->floatingAmount;
            $monthlyChartData['cancelled'][] = $dataChartTwo->cancelledAmount;
        }

        // Yearly Chart Data
        $yearlyData = Booking::selectRaw("
            YEAR(booking_date) as year,
            SUM(CASE WHEN booking_status = 6 THEN booking_rate ELSE 0 END) as completedAmount,
            SUM(CASE WHEN booking_status IN (1, 2, 3) THEN booking_rate ELSE 0 END) as floatingAmount,
            SUM(CASE WHEN booking_status = 5 THEN booking_rate ELSE 0 END) as cancelledAmount
        ")
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();

        $yearlyChartData = [
            'labels' => $yearlyData->pluck('year')->toArray() ?? [],
            'completed' => $yearlyData->pluck('completedAmount')->toArray() ?? [],
            'floating' => $yearlyData->pluck('floatingAmount')->toArray() ?? [],
            'cancelled' => $yearlyData->pluck('cancelledAmount')->toArray() ?? [],
        ];


        // dd($yearlyChartData);


        return view('administrator.booking.index', [
            'title' => 'Booking Management',
            'books' => $data,
            'totalBooking' => $totalBooking,
            'totalUnpaid' => $totalUnpaid,
            'totalConfirmed' => $totalConfirmed,
            'totalCompleted' => $totalCompleted,
            'totalCancelled' => $totalCancelled,
            'stateCounts' => $stateCounts,
            'dataChart' => $dataChart,
            'states' => $states,
            'totalCompletedAmount' => $totalCompletedAmount,
            'totalCancelledAmount' => $totalCancelledAmount,
            'totalFloatingAmount' => $totalFloatingAmount,
            'monthlyChartData' => $monthlyChartData,
            'yearlyChartData' => $yearlyChartData,
        ]);
    }

    // Admin Refund Booking List 
    //Updated by: Zikri (2/1/2025)
    public function adminBookingRefundListNav(Request $request)
    {
        $data = DB::table('bookings as a')
            ->join('cancel_refund_bookings as f', 'a.id', 'f.booking_id')
            ->join('services as b', 'a.service_id', 'b.id')
            ->join('service_types as c', 'b.service_type_id', 'c.id')
            ->join('taskers as d', 'b.tasker_id', 'd.id')
            ->join('clients as e', 'a.client_Id', 'e.id')
            ->select(
                'a.id as bookingID',
                'b.id as serviceID',
                'c.id as typeID',
                'd.id as taskerID',
                'f.id as refundID',
                'a.booking_date',
                'a.booking_address',
                'a.booking_time_start',
                'a.booking_time_end',
                'a.booking_status',
                'a.booking_note',
                'a.booking_rate',
                'a.booking_order_id',
                'c.servicetype_name',
                'd.tasker_firstname',
                'd.tasker_lastname',
                'd.tasker_phoneno',
                'd.email as tasker_email',
                'd.tasker_code',
                'e.client_firstname',
                'e.client_lastname',
                'e.client_phoneno',
                'e.email as client_email',
                'f.cr_reason',
                'f.cr_status',
                'f.cr_date',
                'f.cr_amount',
                'f.cr_bank_name',
                'f.cr_account_name',
                'f.cr_account_number'
            )
            ->whereIn('a.booking_status', [8, 10])
            ->orderbyDesc('a.booking_date');

        if ($request->has('startDate') && $request->has('endDate') && $request->input('startDate') != '' && $request->input('endDate') != '') {
            $startDate = Carbon::parse($request->input('startDate'))->format('Y-m-d');
            $endDate = Carbon::parse($request->input('endDate'))->format('Y-m-d');

            if ($startDate && $endDate) {
                $data->whereBetween('f.cr_date', [$request->startDate, $request->endDate]);
            }
        }

        if ($request->has('tasker_filter') && $request->input('tasker_filter') != '') {
            $data->where('d.id', $request->input('tasker_filter'));
        }

        if ($request->has('status_filter') && $request->input('status_filter') != '') {
            $data->where('f.cr_status', $request->input('status_filter'));
        }

        if ($request->has('state_filter') && $request->input('state_filter') != '') {
            $stateFilter = $request->input('state_filter');
            $data->whereRaw("TRIM(SUBSTRING_INDEX(a.booking_address, ' ', -1)) = ?", [$stateFilter]);
        }

        $data = $data->get();

        if ($request->ajax()) {

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('booking_order_id', function ($row) {
                $orderid = '<button class="btn btn-link link-primary" data-bs-toggle="modal" data-bs-target="#viewBookingDetails-' . $row->bookingID . '">' . $row->booking_order_id . '</button>';
                return $orderid;
            });

            $table->addColumn('tasker', function ($row) {
                $tasker = '<a href="' . route('admin-tasker-update-form', Crypt::encrypt($row->tasker_code)) . '" class="btn btn-link">' . $row->tasker_code . '</a>';
                return $tasker;
            });

            $table->addColumn('client', function ($row) {
                $client = Str::headline($row->client_firstname . ' ' . $row->client_lastname);
                return $client;
            });

            $table->addColumn('booking_date', function ($row) {

                $date = Carbon::parse($row->booking_date)->format('d F Y');
                return $date;
            });

            $table->addColumn('booking_time', function ($row) {

                $startTime = Carbon::parse($row->booking_time_start)->format('g:i A');
                $endTime = Carbon::parse($row->booking_time_end)->format('g:i A');
                $time = $startTime . ' - ' . $endTime;
                return $time;
            });

            $table->addColumn('refund_amount', function ($row) {

                if ($row->booking_status == 8) {
                    $amount = '<h6 class="text-danger text-start"> (-) ' . $row->cr_amount . '</h6>';
                } else if ($row->booking_status == 10) {
                    $amount = '<h6 class="text-success text-start"> (+) ' . $row->cr_amount . '</h6>';
                }
                return $amount;
            });


            $table->addColumn('booking_status', function ($row) {

                if ($row->booking_status == 8) {
                    $status = '<span class="badge bg-light-success">Refunded</span>';
                } else if ($row->booking_status == 10) {
                    $status = '<span class="badge bg-light-danger">Rejected</span>';
                }
                return $status;
            });

            $table->addColumn('action', function ($row) {

                $button =
                    '
                        <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#viewRefundDetails-' . $row->bookingID . '">
                            <i class="ti ti-eye f-20"></i>
                        </a>
                    ';


                return $button;
            });

            $table->rawColumns(['booking_order_id', 'tasker', 'client', 'booking_date', 'booking_time', 'refund_amount', 'booking_status', 'action']);

            return $table->make(true);
        }

        // Default values for calculations
        $totalRefund = 0;
        $totalApprovedRefund = 0;
        $totalRejectedRefund = 0;
        $totalPendingRefund = 0;
        $totalApprovedAmount = '0.00';
        $totalRejectedAmount = '0.00';

        // Check if $data is not empty
        if ($data->isNotEmpty()) {
            // Calculate totals
            $totalRefund = $data->count();
            $totalApprovedRefund = $data->where('cr_status', 2)->count();
            $totalRejectedRefund = $data->where('cr_status', 3)->count();

            // Calculate amounts
            $totalApprovedAmount = number_format($data->where('cr_status', 2)->sum('cr_amount'), 2);
            $totalRejectedAmount = number_format($data->where('cr_status', 3)->sum('cr_amount'), 2);
        }

        // Fetch all data with joins and ensure it's handled properly if empty
        $dataAll = DB::table('bookings as a')
            ->join('cancel_refund_bookings as f', 'a.id', '=', 'f.booking_id')
            ->join('services as b', 'a.service_id', '=', 'b.id')
            ->join('service_types as c', 'b.service_type_id', '=', 'c.id')
            ->join('taskers as d', 'b.tasker_id', '=', 'd.id')
            ->join('clients as e', 'a.client_id', '=', 'e.id')
            ->whereIn('a.booking_status', [7, 8, 9, 10])
            ->orderByDesc('a.booking_date')
            ->get();

        if ($dataAll->isNotEmpty()) {
            // Calculate total pending refunds if $dataAll is not empty
            $totalPendingRefund = $dataAll->whereIn('cr_status', [0, 1])->count();
        }

        // Fetch state data
        $states = json_decode(file_get_contents(public_path('assets/json/state.json')), true);



        return view('administrator.booking.refunded-list-index', [
            'title' => 'Refund Booking List',
            'books' => $data,
            'totalRefund' => $totalRefund,
            'totalApprovedRefund' => $totalApprovedRefund,
            'totalRejectedRefund' => $totalRejectedRefund,
            'totalPendingRefund' => $totalPendingRefund,
            'totalApprovedAmount' => $totalApprovedAmount,
            'totalRejectedAmount' => $totalRejectedAmount,
            'states' => $states
        ]);
    }

    // Admin Refund Booking Request
    //Updated by: Zikri (3/1/2025)
    public function adminBookingRefundReqNav(Request $request)
    {
        $data = DB::table('bookings as a')
            ->join('cancel_refund_bookings as f', 'a.id', 'f.booking_id')
            ->join('services as b', 'a.service_id', 'b.id')
            ->join('service_types as c', 'b.service_type_id', 'c.id')
            ->join('taskers as d', 'b.tasker_id', 'd.id')
            ->join('clients as e', 'a.client_Id', 'e.id')
            ->select(
                'a.id as bookingID',
                'b.id as serviceID',
                'c.id as typeID',
                'd.id as taskerID',
                'f.id as refundID',
                'a.booking_date',
                'a.booking_address',
                'a.booking_time_start',
                'a.booking_time_end',
                'a.booking_status',
                'a.booking_note',
                'a.booking_rate',
                'a.booking_order_id',
                'c.servicetype_name',
                'd.tasker_firstname',
                'd.tasker_lastname',
                'd.tasker_phoneno',
                'd.email as tasker_email',
                'd.tasker_code',
                'e.client_firstname',
                'e.client_lastname',
                'e.client_phoneno',
                'e.email as client_email',
                'f.cr_reason',
                'f.cr_status',
                'f.cr_date',
                'f.cr_amount',
                'f.cr_bank_name',
                'f.cr_account_name',
                'f.cr_account_number'
            )
            ->whereIn('a.booking_status', [7, 9])
            ->orderbyDesc('a.booking_date')
            ->get();

        if ($request->ajax()) {

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('booking_order_id', function ($row) {
                $orderid = '<button class="btn btn-link link-primary" data-bs-toggle="modal" data-bs-target="#viewBookingDetails-' . $row->bookingID . '">' . $row->booking_order_id . '</button>';
                return $orderid;
            });

            $table->addColumn('tasker', function ($row) {
                $tasker = '<a href="' . route('admin-tasker-update-form', Crypt::encrypt($row->tasker_code)) . '" class="btn btn-link">' . $row->tasker_code . '</a>';
                return $tasker;
            });

            $table->addColumn('client', function ($row) {
                $client = Str::headline($row->client_firstname . ' ' . $row->client_lastname);
                return $client;
            });

            $table->addColumn('booking_date', function ($row) {

                $date = Carbon::parse($row->booking_date)->format('d F Y');
                return $date;
            });

            $table->addColumn('booking_time', function ($row) {

                $startTime = Carbon::parse($row->booking_time_start)->format('g:i A');
                $endTime = Carbon::parse($row->booking_time_end)->format('g:i A');
                $time = $startTime . ' - ' . $endTime;
                return $time;
            });

            $table->addColumn('booking_status', function ($row) {

                if ($row->booking_status == 7) {
                    $status = '<span class="badge bg-light-warning">Pending Refund</span>';
                } else if ($row->booking_status == 9) {
                    $status = '<span class="badge bg-light-danger">Require Update</span>';
                }

                return $status;
            });

            $table->addColumn('action', function ($row) {

                $button =
                    '
                        <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#viewRefundDetails-' . $row->bookingID . '">
                            <i class="ti ti-eye f-20"></i>
                        </a>
                    ';


                return $button;
            });

            $table->rawColumns(['booking_order_id', 'tasker', 'client', 'booking_date', 'booking_time', 'booking_status', 'action']);

            return $table->make(true);
        }

        return view('administrator.booking.refund-req-index', [
            'title' => 'Refund Request',
            'books' => $data
        ]);
    }

    public function adminReviewManagementNav(Request $request)
    {
        $data = DB::table('bookings as a')
            ->join('reviews as f', 'a.id', 'f.booking_id')
            ->join('services as b', 'a.service_id', 'b.id')
            ->join('service_types as c', 'b.service_type_id', 'c.id')
            ->join('taskers as d', 'b.tasker_id', 'd.id')
            ->join('clients as e', 'a.client_Id', 'e.id')
            ->select(
                'a.id as bookingID',
                'b.id as serviceID',
                'c.id as typeID',
                'd.id as taskerID',
                'f.id as reviewID',
                'a.booking_date',
                'a.booking_address',
                'a.booking_time_start',
                'a.booking_time_end',
                'a.booking_status',
                'a.booking_note',
                'a.booking_rate',
                'a.booking_order_id',
                'c.servicetype_name',
                'd.tasker_firstname',
                'd.tasker_lastname',
                'd.tasker_phoneno',
                'd.email as tasker_email',
                'd.tasker_code',
                'e.client_firstname',
                'e.client_lastname',
                'e.client_phoneno',
                'e.email as client_email',
                'f.review_status',
                'f.review_rating',
                'f.review_description',
                'f.review_date_time',
                'f.review_imageOne',
                'f.review_imageTwo',
                'f.review_imageThree',
                'f.review_imageFour',
                'f.review_type',
            );

        // Apply date range filter before calling get()
        if ($request->has('startDate') && $request->has('endDate') && $request->input('startDate') != '' && $request->input('endDate') != '') {
            $startDate = Carbon::parse($request->input('startDate'))->format('Y-m-d');
            $endDate = Carbon::parse($request->input('endDate'))->format('Y-m-d');

            if ($startDate && $endDate) {
                $data->whereBetween(DB::raw("DATE(f.review_date_time)"), [$startDate, $endDate]);
            }
        }

        if ($request->has('tasker_filter') && $request->input('tasker_filter') != '') {
            $data->where('d.id', $request->input('tasker_filter'));
        }


        if ($request->has('status_filter') && $request->input('status_filter') != '') {
            $data->where('f.review_status', $request->input('status_filter'));
        }

        if ($request->has('media_filter') && $request->input('media_filter') != '') {
            if ($request->input('media_filter') == '1') {
                // Filter for reviews that have at least one image
                $data->where(function ($query) {
                    $query->whereNotNull('f.review_imageOne')
                        ->orWhereNotNull('f.review_imageTwo')
                        ->orWhereNotNull('f.review_imageThree')
                        ->orWhereNotNull('f.review_imageFour');
                });
            } elseif ($request->input('media_filter') == '2') {
                // Filter for reviews that have no images
                $data->where(function ($query) {
                    $query->whereNull('f.review_imageOne')
                        ->whereNull('f.review_imageTwo')
                        ->whereNull('f.review_imageThree')
                        ->whereNull('f.review_imageFour');
                });
            }
        }


        if ($request->has('rating_filter') && $request->input('rating_filter') != '') {
            $ratingFilter = $request->input('rating_filter');
            if ($ratingFilter == '1') {
                $data->orderByDesc('f.review_rating'); // Highest rating first
            } elseif ($ratingFilter == '2') {
                $data->orderBy('f.review_rating'); // Lowest rating first
            }
        } else {
            $data->orderByDesc('f.review_date_time');
        }

        $data = $data->get();

        if ($request->ajax()) {

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('booking_order_id', function ($row) {
                $orderid = '<button class="btn btn-link link-primary" data-bs-toggle="modal" data-bs-target="#viewBookingDetails-' . $row->bookingID . '">' . $row->booking_order_id . '</button>';
                return $orderid;
            });

            $table->addColumn('client', function ($row) {
                $client = Str::headline($row->client_firstname . ' ' . $row->client_lastname);
                return $client;
            });

            $table->addColumn('review_rating', function ($row) {

                $rating = '';
                for ($i = 1; $i <= $row->review_rating; $i++) {
                    $rating .= '<i class="fas fa-star text-warning"></i>';
                }
                return $rating;
            });

            $table->addColumn('review_date_time', function ($row) {

                $datetime = Carbon::parse($row->review_date_time)->setTimezone('Asia/Kuala_Lumpur')->format('d F Y g:i A');
                return $datetime;
            });


            $table->addColumn('review_description', function ($row) {
                // Define maximum rows and columns
                $maxRows = 3;
                $maxCols = 18;

                // Calculate the maximum number of characters that can fit
                $maxCharsPerRow = $maxCols;
                $maxTotalChars = $maxRows * $maxCharsPerRow;

                // Truncate the description to fit within the maximum allowed size
                $description = strlen($row->review_description) > $maxTotalChars
                    ? substr($row->review_description, 0, $maxTotalChars) . '...'
                    : $row->review_description;

                // Create the textarea element
                return '<textarea class="form-control" rows="' . $maxRows . '" cols="' . $maxCols . '" readonly style="resize: none;">'
                    . htmlspecialchars($description)
                    . '</textarea>';
            });

            $table->addColumn('review_status', function ($row) {

                if ($row->review_status == 1) {
                    $status = '<span class="badge bg-success">Show</span>';
                } else if ($row->review_status == 2) {
                    $status = '<span class="badge bg-danger">Hide</span>';
                }

                return $status;
            });

            $table->addColumn('action', function ($row) {
                $button =
                    '
                        <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#viewReviewDetails-' . $row->reviewID . '">
                            <i class="ti ti-eye f-20"></i>
                        </a>
                         <a href="#" class="avtar avtar-xs btn-light-danger" data-bs-toggle="modal"
                            data-bs-target="#replyReview-' . $row->reviewID . '">
                            <i class="ti ti-repeat f-20"></i>
                        </a>
                    ';
                return $button;
            });

            $table->rawColumns(['booking_order_id', 'client', 'review_rating', 'review_date_time', 'review_description', 'review_status', 'action']);

            return $table->make(true);
        }

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $totalreview = $data->count();

        // Initialize variables with default values to handle empty data scenarios
        $totalreviewsbymonth = 0;
        $totalreviewsbyyear = 0;
        $totalcompletedBooking = 0;
        $totalunreview = 0;
        $averageRating = 0.00;
        $csat = 0.00;
        $neutralrev = 0.00;
        $negrev = 0.00;
        $growthRate = 0.00;
        $topService = null;
        $reply = collect();

        // Current month and year for filtering
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Count total reviews by month
        $totalreviewsbymonth = DB::table('bookings as a')
            ->join('reviews as f', 'a.id', '=', 'f.booking_id')
            ->whereMonth('f.review_date_time', $currentMonth)
            ->whereYear('f.review_date_time', $currentYear)
            ->count();

        // Count total reviews by year
        $totalreviewsbyyear = DB::table('bookings as a')
            ->join('reviews as f', 'a.id', '=', 'f.booking_id')
            ->whereYear('f.review_date_time', $currentYear)
            ->count();

        // Count total completed bookings
        $totalcompletedBooking = DB::table('bookings')
            ->where('booking_status', 6)
            ->count();

        // Calculate total unreviewed bookings
        $totalunreview = max(0, $totalcompletedBooking - $totalreviewsbyyear);

        // Calculate total average rating
        $averageRating = DB::table('reviews')
            ->avg('review_rating');
        $averageRating = $averageRating ? number_format($averageRating, 2) : '0.00';

        // CSAT, Neutral, and Negative Review Percentages
        $totalreview = DB::table('reviews')->count();

        if ($totalreview > 0) {
            $csat = number_format(
                DB::table('reviews')->where('review_rating', '>=', 4)->count() / $totalreview * 100,
                2
            );
            $neutralrev = number_format(
                DB::table('reviews')->where('review_rating', '=', 3)->count() / $totalreview * 100,
                2
            );
            $negrev = number_format(
                DB::table('reviews')->where('review_rating', '<', 3)->count() / $totalreview * 100,
                2
            );
        }

        // Calculate Growth Rate by last month
        $currentMonthReviews = DB::table('reviews')
            ->whereMonth('review_date_time', $currentMonth)
            ->count();
        $lastMonthReviews = DB::table('reviews')
            ->whereMonth('review_date_time', Carbon::now()->subMonth()->month)
            ->count();
        $growthRate = $lastMonthReviews > 0
            ? number_format((($currentMonthReviews - $lastMonthReviews) / $lastMonthReviews) * 100, 2)
            : 0.00;

        // Get top service type with most reviews
        $topService = DB::table('reviews as a')
            ->join('bookings as b', 'a.booking_id', '=', 'b.id')
            ->join('services as c', 'b.service_id', '=', 'c.id')
            ->join('service_types as d', 'c.service_type_id', '=', 'd.id')
            ->select('d.servicetype_name', DB::raw('count(*) as total_reviews'))
            ->groupBy('d.servicetype_name')
            ->orderByDesc('total_reviews')
            ->first();

        // Get reviews with replies
        $reply = DB::table('reviews as a')
            ->join('review_replies as e', 'a.id', '=', 'e.review_id')
            ->whereNotNull('e.reply_message')
            ->get();

        return view('administrator.performance.review-index', [
            'title' => 'Review Management',
            'data' => $data,
            'totalreviewsbymonth' => $totalreviewsbymonth,
            'totalreviewsbyyear' => $totalreviewsbyyear,
            'totalunreview' => $totalunreview,
            'averageRating' => $averageRating,
            'csat' => $csat,
            'negrev' => $negrev,
            'neutralrev' => $neutralrev,
            'growthRate' => $growthRate,
            'topService' => $topService,
            'reply' => $reply,
        ]);
    }

    public function adminTaskerPerformanceNav(Request $request)
    {
        $taskers = DB::table('taskers')
            ->leftJoin('services', 'taskers.id', '=', 'services.tasker_id')
            ->leftJoin('bookings', 'services.id', '=', 'bookings.service_id')
            ->leftJoin('reviews', 'bookings.id', '=', 'reviews.booking_id')
            ->leftJoin('cancel_refund_bookings', 'bookings.id', '=', 'cancel_refund_bookings.booking_id')
            ->select(
                'taskers.tasker_code',
                'taskers.id',
                DB::raw("CONCAT(taskers.tasker_firstname, ' ', taskers.tasker_lastname) AS tasker_name"),
                DB::raw("AVG(reviews.review_rating) AS average_rating"),
                DB::raw("
                CASE 
                    WHEN AVG(reviews.review_rating) >= 4 THEN '1'
                    WHEN AVG(reviews.review_rating) >= 3 THEN '2'
                    ELSE '3'
                END AS satisfaction_reaction
            "),
                // 'taskers.tasker_selfrefund_count AS total_self_cancel_refunds',
                DB::raw("COUNT(CASE WHEN cancel_refund_bookings.cr_penalized = '1' THEN 1 END) AS total_self_cancel_refunds"),
                DB::raw("COUNT(CASE WHEN bookings.booking_status = '6' THEN 1 END) AS total_completed_bookings"),
                DB::raw("
                    ROUND(
                        (
                            (AVG(reviews.review_rating) / 5 * 60) -- Ratings contribute 60%
                            + (CASE WHEN AVG(reviews.review_rating) >= 4 THEN 15 ELSE 0 END) -- Satisfaction bonus (15%)
                            - LEAST(taskers.tasker_selfrefund_count * 2.5, 25) -- Refund penalty capped at 25%
                        ), 2
                    ) AS performance_score_percentage
                "),
            )
            ->groupBy('taskers.id');



        if ($request->has('startDate') && $request->has('endDate') && $request->input('startDate') != '' && $request->input('endDate') != '') {
            $startDate = Carbon::parse($request->input('startDate'))->format('Y-m-d');
            $endDate = Carbon::parse($request->input('endDate'))->format('Y-m-d');

            if ($startDate && $endDate) {
                $taskers->whereBetween('bookings.booking_date', [$request->startDate, $request->endDate]);
            }
        }
        if ($request->has('rating_filter') && $request->input('rating_filter') != '') {
            $taskers->havingRaw('ROUND(AVG(reviews.review_rating)) = ?', [$request->rating_filter]);
        }

        if ($request->has('reaction_filter') && $request->input('reaction_filter') != '') {
            $taskers->having('satisfaction_reaction', '=', $request->reaction_filter);
        }

        if ($request->has('penalized_filter') && $request->input('penalized_filter') != '') {
            if ($request->input('penalized_filter') == 1) {
                $taskers->orderBy('total_self_cancel_refunds', 'asc');
            } else  if ($request->input('penalized_filter') == 2) {
                $taskers->orderBy('total_self_cancel_refunds', 'desc');
            }
        }

        if ($request->has('score_filter_min') && $request->input('score_filter_min') != '' && $request->has('score_filter_max') && $request->input('score_filter_max') != '') {
            $scoreMin = $request->input('score_filter_min');
            $scoreMax = $request->input('score_filter_max');

            if (!empty($scoreMin) && !empty($scoreMax)) {
                $taskers->havingRaw(
                    'performance_score_percentage BETWEEN ? AND ?',
                    [$scoreMin, $scoreMax]
                );
            }
        }
        $data = $taskers->get();

        // Overall performance
        $overallPerformance = $data->isNotEmpty() ? $data->avg('performance_score_percentage') : 0;

        // Handle highest performers
        $highestPerformers = $data->isNotEmpty()
            ? $data
            ->filter(function ($tasker) {
                return $tasker->performance_score_percentage !== null && $tasker->performance_score_percentage >= 60;
            })
            ->sortByDesc('performance_score_percentage')
            ->values()
            ->map(function ($tasker, $index) {
                return [
                    'name' => $tasker->tasker_name ?? 'N/A',
                    'score' => $tasker->performance_score_percentage ?? 0,
                ];
            })
            : collect([]); // Return empty collection if no data

        // Handle lowest performers
        $lowestPerformers = $data->isNotEmpty()
            ? $data
            ->filter(function ($tasker) {
                return $tasker->performance_score_percentage !== null && $tasker->performance_score_percentage < 40;
            })
            ->sortBy('performance_score_percentage')
            ->values()
            ->map(function ($tasker, $index) {
                return [
                    'name' => $tasker->tasker_name ?? 'N/A',
                    'score' => $tasker->performance_score_percentage ?? 0,
                ];
            })
            : collect([]); // Return empty collection if no data

        if ($request->ajax()) {

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" class="tasker-checkbox form-check-input" value="' . $row->id . '">';
            });

            $table->addColumn('tasker_code', function ($row) {
                $tasker = '<a href="#taskerDetailsModal" data-bs-toggle="modal" data-bs-target="#taskerDetailsModal-' . $row->tasker_code . '" class="btn btn-link">' . $row->tasker_code . '</a>';
                return $tasker;
            });

            $table->addColumn('average_rating', function ($row) {
                $averageRating = round($row->average_rating * 2) / 2; // Round to nearest 0.5
                $fullStars = floor($averageRating); // Number of full stars
                $halfStar = $averageRating - $fullStars > 0 ? 1 : 0; // Check if there's a half star
                $emptyStars = 5 - $fullStars - $halfStar; // Remaining empty stars

                $stars = '';
                for ($i = 0; $i < $fullStars; $i++) {
                    $stars .= '<i class="fas fa-star text-warning"></i>'; // Full star icon
                }
                if ($halfStar) {
                    $stars .= '<i class="fas fa-star-half-alt text-warning"></i>'; // Half star icon
                }
                for ($i = 0; $i < $emptyStars; $i++) {
                    $stars .= '<i class="far fa-star text-muted"></i>'; // Empty star icon
                }

                return $stars;
            });

            $table->addColumn('satisfaction_reaction', function ($row) {
                if ($row->satisfaction_reaction == 1) {
                    // Happy
                    return '<i class="fas fa-smile text-success f-22" title="Happy"></i>';
                } elseif ($row->satisfaction_reaction == 2) {
                    // Neutral 
                    return '<i class="fas fa-meh text-warning f-22" title="Neutral"></i>';
                } elseif ($row->satisfaction_reaction == 3) {
                    // Unhappy 
                    return '<i class="fas fa-frown text-danger f-22" title="Unhappy"></i>';
                } else {
                    // Default for no reaction
                    return '<i class="fas fa-question-circle text-muted f-22" title="No Reaction"></i>';
                }
            });

            $table->addColumn('total_self_cancel_refunds', function ($row) {

                $cancelRefunds = '<span class="badge bg-danger">' . $row->total_self_cancel_refunds . '</span>';
                return $cancelRefunds;
            });


            $table->addColumn('total_completed_bookings', function ($row) {

                $completedBookings = '<span class="badge bg-success">' . $row->total_completed_bookings . '</span>';
                return $completedBookings;
            });

            $table->addColumn('p_score', function ($row) {
                $scorePercentage = $row->performance_score_percentage;
                $progressColor = 'bg-success';

                if ($scorePercentage >= 70) {
                    $progressColor = 'bg-success';
                } elseif ($scorePercentage >= 40) {
                    $progressColor = 'bg-warning';
                } else {
                    $progressColor = 'bg-danger';
                }

                return '
                    <div class="progress" style="height: 25px;">
                        <div class="progress-bar ' . $progressColor . '" role="progressbar" style="width: ' . $scorePercentage . '%;" aria-valuenow="' . $scorePercentage . '" aria-valuemin="0" aria-valuemax="100">
                            ' . $scorePercentage . '%
                        </div>
                    </div>
                ';
            });

            $table->rawColumns(['checkbox', 'tasker_code', 'average_rating', 'satisfaction_reaction', 'total_self_cancel_refunds', 'total_completed_bookings', 'p_score']);

            return $table->make(true);
        }
        $taskers = DB::table('taskers')
            ->leftJoin('services', 'taskers.id', '=', 'services.tasker_id')
            ->leftJoin('bookings', 'services.id', '=', 'bookings.service_id')
            ->leftJoin('reviews', 'bookings.id', '=', 'reviews.booking_id')
            ->leftJoin('cancel_refund_bookings', 'bookings.id', '=', 'cancel_refund_bookings.booking_id')
            ->select(
                'taskers.tasker_code',
                'taskers.id',
                DB::raw("CONCAT(taskers.tasker_firstname, ' ', taskers.tasker_lastname) AS tasker_name"),
                DB::raw("AVG(reviews.review_rating) AS average_rating"),
                DB::raw("CASE 
            WHEN AVG(reviews.review_rating) >= 4 THEN '1'
            WHEN AVG(reviews.review_rating) >= 3 THEN '2'
            ELSE '3'
         END AS satisfaction_reaction"),
                DB::raw("COUNT(CASE WHEN cancel_refund_bookings.cr_penalized = '1' THEN 1 END) AS total_self_cancel_refunds"),
                DB::raw("COUNT(CASE WHEN bookings.booking_status = '6' THEN 1 END) AS total_completed_bookings"),
                DB::raw("ROUND(
            (
                (AVG(reviews.review_rating) / 5 * 60) -- Ratings contribute 60%
                + (CASE WHEN AVG(reviews.review_rating) >= 4 THEN 15 ELSE 0 END) -- Satisfaction bonus (15%)
                - LEAST(taskers.tasker_selfrefund_count * 2.5, 25) -- Refund penalty capped at 25%
            ), 2
        ) AS performance_score_percentage"),
                DB::raw("LAST_DAY(bookings.booking_date) AS last_booking_date") // Last day of the month
            )
            ->whereNotNull('bookings.booking_date') // Only consider valid dates

            ->groupBy('taskers.id', 'taskers.tasker_code', 'last_booking_date');
        // dd($taskers->get());

        $data = $taskers->get();

        // Calculate monthly labels
        $monthlyLabels = collect(range(1, 12))->map(function ($month) {
            return Carbon::create()->month($month)->format('F');
        });

        // Calculate monthly scores
        $monthlyScores = collect(range(1, 12))->map(function ($month) use ($data) {
            return $data->isNotEmpty()
                ? $data->filter(function ($item) use ($month) {
                    return $item->last_booking_date !== null && Carbon::parse($item->last_booking_date)->month === $month;
                })->avg('performance_score_percentage') ?? 0
                : 0; // Handle no data
        });

        // Group data by year and month
        $groupedData = $data->isNotEmpty()
            ? $data->groupBy(function ($item) {
                return $item->last_booking_date !== null
                    ? Carbon::parse($item->last_booking_date)->year
                    : 'N/A'; // Handle null dates
            })
            : collect([]); // Return empty collection if no data

        // Prepare data for the chart
        $chartData = $groupedData->map(function ($items, $year) {
            $monthlyScores = collect(range(1, 12))->map(function ($month) use ($items) {
                return $items->filter(function ($item) use ($month) {
                    return $item->last_booking_date !== null && Carbon::parse($item->last_booking_date)->month === $month;
                })->avg('performance_score_percentage') ?? 0;
            });

            return [
                'year' => $year,
                'scores' => $monthlyScores,
            ];
        })->values();

        // Calculate yearly averages
        $yearlyAverages = $chartData->isNotEmpty()
            ? $chartData
            ->sortByDesc('year')
            ->take(3)
            ->map(function ($data) {
                $validScores = collect($data['scores'])->filter(function ($score) {
                    return $score > 0;
                });
                $average = $validScores->isNotEmpty() ? $validScores->avg() : 0;

                return [
                    'year' => $data['year'],
                    'average_performance' => round($average, 2),
                ];
            })
            ->sortBy('year')
            ->values()
            : collect([]);

        return view('administrator.performance.tasker-performance-index', [
            'title' => 'Tasker Performance',
            'data' => $data,
            'overallPerformance' => $overallPerformance,
            'monthlyLabels' => $monthlyLabels,
            'chartData' => $chartData,
            'monthlyScores' => $monthlyScores,
            'highestPerformers' => $highestPerformers,
            'lowestPerformers' => $lowestPerformers,
            'yearlyAverages' => $yearlyAverages,
            'taskers' => Tasker::get()

        ]);
    }



    public function cardVerificationLog(Request $request) 
    {
        return view('administrator.ekyc.card-log',[
            'title' => 'e-KYC Card Log'
        ]);
    }

    public function faceVerificationLog(Request $request)
    {
        return view('administrator.ekyc.face-log',[
            'title' => 'e-KYC Face Log'
        ]);
    }

}
