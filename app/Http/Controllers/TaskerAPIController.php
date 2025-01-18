<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Review;
use App\Models\Tasker;
use App\Models\Booking;
use App\Models\Service;
use App\Models\TimeSlot;
use App\Models\ReviewReply;
use App\Models\ServiceType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\Geocoder\Geocoder;
use App\Models\TaskerTimeSlot;
use App\Models\MonthlyStatement;
use App\Mail\AdminRefundApproval;
use Illuminate\Support\Facades\DB;
use App\Models\CancelRefundBooking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\TaskerClientBookingStatus;
use App\Mail\ServiceApplicationNotification;

class TaskerAPIController extends Controller
{

    protected $geocoder;

    public function __construct(Geocoder $geocoder)
    {
        $this->geocoder = $geocoder;
    }

    public function getTaskerDetail()
    {
        try {
            $data = Tasker::where('id', Auth::user()->id)->get();
            return response([
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response([
                'message' => 'Error : ' . $e->getMessage()
            ], 500);
        }
    }

    //Tasker Dashboard 
    public function taskerGetDashboardAPI()
    {
        try {
            $totalearningsAll = 0;
            $totalearningsThisMonth = 0;
            $totalearningsThisYear = 0;
            $totalBookingCount = 0;
            $totalPenaltyCount = 0;
            $totalAVGrating = 0;
            $thismonthcompleted = 0;
            $thismonthfloating = 0;
            $thismonthCancelled = 0;
            $thisyearcompleted = 0;
            $thisyearfloating = 0;
            $thisyearCancelled = 0;
            $currMonth = Carbon::now()->month;
            $currYear = Carbon::now()->year;


            $totalearningsAll = DB::table('bookings as a')
                ->join('services as b', 'a.service_id', 'b.id')
                ->where('b.tasker_id', Auth::user()->id)
                ->where('booking_status', 6)
                ->sum('booking_rate');

            $totalearningsThisMonth = DB::table('bookings as a')
                ->join('services as b', 'a.service_id', 'b.id')
                ->where('b.tasker_id', Auth::user()->id)
                ->whereMonth('booking_date', $currMonth)
                ->whereYear('booking_date', $currYear)
                ->where('booking_status', 6)
                ->sum('booking_rate');

            $totalearningsThisYear = DB::table('bookings as a')
                ->join('services as b', 'a.service_id', 'b.id')
                ->where('b.tasker_id', Auth::user()->id)
                ->whereYear('booking_date', $currYear)
                ->where('booking_status', 6)
                ->sum('booking_rate');

            $totalearningsAll = number_format($totalearningsAll * 0.97, 2);
            $totalearningsThisMonth = number_format($totalearningsThisMonth * 0.97, 2);
            $totalearningsThisYear = number_format($totalearningsThisYear * 0.97, 2);


            $totalBookingCount = DB::table('bookings as a')
                ->join('services as b', 'a.service_id', 'b.id')
                ->where('b.tasker_id', Auth::user()->id)
                ->where('booking_status', 6)
                ->count();

            $totalPenaltyCount = DB::table('cancel_refund_bookings as a')
                ->join('bookings as b', 'a.booking_id', 'b.id')
                ->join('services as c', 'b.service_id', 'c.id')
                ->where('c.tasker_id', Auth::user()->id)
                ->where('cr_penalized', 1)
                ->count();

            $totalAVGrating = DB::table('bookings as a')
                ->join('reviews as f', 'a.id', 'f.booking_id')
                ->join('services as b', 'a.service_id', 'b.id')
                ->join('service_types as c', 'b.service_type_id', 'c.id')
                ->join('taskers as d', 'b.tasker_id', 'd.id')
                ->where('d.id', auth()->user()->id)
                ->avg('f.review_rating');

            $totalAVGrating = number_format($totalAVGrating, 1);

            $confirmBookingData = DB::table('bookings as a')
                ->join('services as b', 'a.service_id', 'b.id')
                ->join('service_types as c', 'b.service_type_id', 'c.id')
                ->where('b.tasker_id', Auth::user()->id)
                ->where('booking_status', 3)
                ->get();

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
                ->orderby('a.booking_date')
                ->orderby('a.booking_time_start');


            $thismonthcompleted = $data->whereYear('booking_date', $currYear)->whereMonth('booking_date', $currMonth)->where('booking_status', 6)->count();
            $thismonthfloating =  $data->whereYear('booking_date', $currYear)->whereMonth('booking_date', $currMonth)->whereIn('booking_status', [1, 2, 3, 4])->count();
            $thismonthCancelled =  $data->whereYear('booking_date', $currYear)->whereMonth('booking_date', $currMonth)->where('booking_status', 5)->count();

            $thisyearcompleted =  $data->whereYear('booking_date', $currYear)->where('booking_status', 6)->count();
            $thisyearfloating =  $data->whereYear('booking_date', $currYear)->whereIn('booking_status', [1, 2, 3, 4])->count();
            $thisyearCancelled =  $data->whereYear('booking_date', $currYear)->where('booking_status', 5)->count();


            // Monthly Chart Data
            $monthlyData = Booking::selectRaw("
                YEAR(booking_date) as year,
                MONTH(booking_date) as month,
                SUM(CASE WHEN booking_status = 6 THEN booking_rate ELSE 0 END) as completedAmount,
                SUM(CASE WHEN booking_status IN (1, 2, 3, 4) THEN booking_rate ELSE 0 END) as floatingAmount,
                SUM(CASE WHEN booking_status = 5 THEN booking_rate ELSE 0 END) as cancelledAmount
            ")
                ->join('services as b', 'bookings.service_id', '=', 'b.id')
                ->where('b.tasker_id', Auth::user()->id)
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
                SUM(CASE WHEN booking_status IN (1, 2, 3, 4) THEN booking_rate ELSE 0 END) as floatingAmount,
                SUM(CASE WHEN booking_status = 5 THEN booking_rate ELSE 0 END) as cancelledAmount
            ")
                ->join('services as b', 'bookings.service_id', '=', 'b.id')
                ->where('b.tasker_id', Auth::user()->id)
                ->groupBy('year')
                ->orderBy('year', 'asc')
                ->get();

            $yearlyChartData = [
                'labels' => $yearlyData->pluck('year')->toArray() ?? [],
                'completed' => $yearlyData->pluck('completedAmount')->toArray() ?? [],
                'floating' => $yearlyData->pluck('floatingAmount')->toArray() ?? [],
                'cancelled' => $yearlyData->pluck('cancelledAmount')->toArray() ?? [],
            ];

            $data = $data = DB::table('bookings as a')
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
                ->orderby('a.booking_date')
                ->orderby('a.booking_time_start')
                ->get();

            return response()->json([
                'status' => 'success',
                'books' =>  $data,
                'totalearningsAll' => $totalearningsAll,
                'totalearningsThisMonth' => $totalearningsThisMonth,
                'totalearningsThisYear' => $totalearningsThisYear,
                'totalBookingCount' =>  $totalBookingCount,
                'totalPenaltyCount' => $totalPenaltyCount,
                'totalAVGrating' => $totalAVGrating,
                'confirmBookingData' => $confirmBookingData,
                'thismonthcompleted' => $thismonthcompleted,
                'thismonthfloating' => $thismonthfloating,
                'thismonthCancelled' => $thismonthCancelled,
                'thisyearcompleted' => $thisyearcompleted,
                'thisyearfloating' => $thisyearfloating,
                'thisyearCancelled' => $thisyearCancelled,
                'monthlyChartData' => $monthlyChartData,
                'yearlyChartData' => $yearlyChartData,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    // Tasker Update Profile
    // NOTE : API ni ada function file() untuk upload profile photo, implementation flutter tak pasti macamana 
    public function taskerUpdateProfileAPI(Request $req, $id)
    {
        if ($req->isUploadPhoto == 'true') {
            $taskers = $req->validate(
                [
                    'tasker_firstname' => 'required|string',
                    'tasker_lastname' => 'required|string',
                    'tasker_phoneno' => 'required|string|min:10',
                    'email' => 'required|email',
                    'tasker_bio' => '',
                    'tasker_icno' => 'required',
                    'tasker_dob' => 'required',
                    'tasker_address_one' => 'required',
                    'tasker_address_two' => 'required',
                    'tasker_address_poscode' => 'required',
                    'tasker_address_state' => 'required',
                    'tasker_address_area' => 'required',
                    // 'tasker_workingloc_state' => 'required',
                    // 'tasker_workingloc_area' => 'required',
                    'tasker_status' => '',
                    'tasker_photo' => 'required|image|mimes:jpeg,png,jpg',

                ],
                [],
                [
                    'tasker_code' => 'Tasker Code',
                    'tasker_firstname' => 'First Name',
                    'tasker_lastname' => 'Last Name',
                    'tasker_phoneno' => 'Phone Number',
                    'email' => 'Email Address',
                    'tasker_bio' => 'Tasker Bio',
                    'tasker_icno' => 'IC number',
                    'tasker_dob' => 'Date of Birth',
                    'tasker_address_one' => 'Address Line 1',
                    'tasker_address_two' => 'Address Line 2',
                    'tasker_address_poscode' => 'Postal Code',
                    'tasker_address_state' => 'State',
                    'tasker_address_area' => 'Area',
                    // 'tasker_workingloc_state' => 'Working State',
                    // 'tasker_workingloc_area' => 'Working Area',
                    'tasker_status' => 'Status',
                    'tasker_photo' => 'Profile Photo',


                ]
            );
            $user = auth()->user();

            // Generate a custom name for the file
            $file = $req->file('tasker_photo');
            $filename = $user->tasker_code . '_profile' . '.' . $file->getClientOriginalExtension();

            // Store the file with the custom filename
            $path = $file->storeAs('profile_photos/taskers', $filename, 'public');

            // Save the file path in the database
            $taskers['tasker_photo'] = $path;
        } else {
            $taskers = $req->validate(
                [
                    'tasker_firstname' => 'required|string',
                    'tasker_lastname' => 'required|string',
                    'tasker_phoneno' => 'required|string|min:10',
                    'email' => 'required|email',
                    'tasker_bio' => '',
                    'tasker_icno' => 'required',
                    'tasker_dob' => 'required',
                    'tasker_address_one' => 'required',
                    'tasker_address_two' => 'required',
                    'tasker_address_poscode' => 'required',
                    'tasker_address_state' => 'required',
                    'tasker_address_area' => 'required',
                    // 'tasker_workingloc_state' => 'required',
                    // 'tasker_workingloc_area' => 'required',
                    'tasker_status' => '',
                ],
                [],
                [
                    'tasker_code' => 'Tasker Code',
                    'tasker_firstname' => 'First Name',
                    'tasker_lastname' => 'Last Name',
                    'tasker_phoneno' => 'Phone Number',
                    'email' => 'Email Address',
                    'tasker_bio' => 'Tasker Bio',
                    'tasker_icno' => 'IC number',
                    'tasker_dob' => 'Date of Birth',
                    'tasker_address_one' => 'Address Line 1',
                    'tasker_address_two' => 'Address Line 2',
                    'tasker_address_poscode' => 'Postal Code',
                    'tasker_address_state' => 'State',
                    'tasker_address_area' => 'Area',
                    // 'tasker_workingloc_state' => 'Working State',
                    // 'tasker_workingloc_area' => 'Working Area',
                    'tasker_status' => 'Status',
                    'tasker_photo' => 'Profile Photo',

                ]
            );
        }

        $ori = Tasker::whereId($id)->first();
        if ($ori->tasker_status == 0 || $ori->tasker_status == 1) {
            $taskers['tasker_status'] = 1;
            $message = 'Tasker profile has been successfully updated. Please proceed to account verification to start earning.';
        } elseif ($ori->tasker_status == 2 || $ori->tasker_status == 3) {
            $taskers['tasker_status'] = 2;
            $message = 'Tasker profile has been successfully updated !';
        }

        Tasker::whereId($id)->update($taskers);

        return response([
            'message' => $message
        ], 201);
    }

    // Tasker Update Password
    public function taskerUpdatePasswordAPI(Request $req, $id)
    {
        $validated = $req->validate(
            [
                'oldPass' => 'required | min:8',
                'newPass' => 'required | min:8',
                'renewPass' => 'required | same:newPass',
            ],
            [],
            [
                'oldPass' => 'Old Password',
                'newPass' => 'New Password',
                'renewPass' => 'Comfirm Password',

            ]
        );
        $check = Hash::check($validated['oldPass'], Auth::user()->password, []);
        if ($check) {
            Tasker::where('id', $id)->update(['password' => bcrypt($validated['renewPass'])]);
            return response([
                'message' => 'Password has been updated successfully !'
            ], 201);
        } else {
            return response([
                'message' => 'Password entered is incorrect. Please try again !'
            ], 301);
        }
    }

    //Fetch All Service Type
    // Check by : Zikri (11/01/2025)
    public function getAllServiceType()
    {
        try {
            $servicetype = ServiceType::where('servicetype_status', 1)->get();
            return response([
                'servicetype' => $servicetype
            ], 201);
        } catch (Exception $e) {
            return response([
                'message' => 'Error : ' . $e->getMessage()
            ], 301);
        }
    }

    //Fetch All Service Details
    // Check by : Zikri (11/01/2025)
    public function getAllServiceAPI()
    {
        try {
            $service = Service::where('tasker_id', Auth::user()->id)->get();
            return response([
                'service' => $service
            ], 201);
        } catch (Exception $e) {
            return response([
                'message' => 'Error : ' . $e->getMessage()
            ], 301);
        }
    }

    //Fetch Single Service Details
    // Check by : Zikri (11/01/2025)
    public function getSingleServiceAPI($id)
    {
        try {
            $service = Service::whereId($id)->where('tasker_id', Auth::user()->id)->first();
            return response([
                'service' => $service
            ], 201);
        } catch (Exception $e) {
            return response([
                'message' => 'Error : ' . $e->getMessage()
            ], 301);
        }
    }

    // Create Service API
    // Check by : Zikri (11/01/2025)
    public function createServiceAPI(Request $req)
    {
        try {

            $servicetype = ServiceType::where('id', $req->service_type_id)->first();
            $check = Service::where('tasker_id', Auth::user()->id)->where('service_type_id', $req->service_type_id)->where('service_status', '!=', 4)->exists();
            if (!$check) {
                $data = $req->validate([
                    'service_rate' => 'required',
                    'service_rate_type' => 'required',
                    'service_type_id' => 'required',
                    'service_desc' => 'required'

                ], [], [
                    'service_rate' => 'Service Rate',
                    'service_rate_type' => 'Service Rate Type',
                    'service_type_id' => 'Service Type',
                    'service_desc' => 'Description'
                ]);
                $data['service_status'] = 0;
                $data['tasker_id'] = Auth::user()->id;
                Service::create($data);

                $servicetype = ServiceType::where('id', $req->service_type_id)->first();

                Mail::to(Auth::user()->email)->send(new ServiceApplicationNotification([
                    'name' => Str::headline(Auth::user()->tasker_firstname . ' ' . Auth::user()->tasker_lastname),
                    'service_name' => $servicetype->servicetype_name,
                    'date' => Carbon::now()->format('d F Y g:i A'),
                    'service_rate' =>  $data['service_rate'],
                    'service_rate_type' => $data['service_rate_type'],
                    'service_desc' => $data['service_desc'],
                    'service_status' => $data['service_status']
                ]));

                return response([
                    'message' => 'Your service has been successfully submitted! Please allow up to 3 business days for our administrators to review your application. We’ll notify you once it’s been processed.'
                ], 201);
            } else {
                return response([
                    'message' => 'You have already submitted the application for these services. Please submit a new application for different services.'
                ], 201);
            }
        } catch (Exception $e) {
            return response([
                'message' => 'Error : ' . $e->getMessage()
            ], 301);
        }
    }

    // Update Service API
    // Check by : Zikri (11/01/2025)
    public function updateServiceAPI(Request $req, $id)
    {
        try {

            $data = $req->validate([
                'service_rate' => 'required',
                'service_rate_type' => 'required',
                'service_type_id' => 'required',
                'service_status' => 'required',
                'service_desc' => 'required'

            ], [], [
                'service_rate' => 'Service Rate',
                'service_rate_type' => 'Service Rate Type',
                'service_type_id' => 'Service Type',
                'service_status' => 'Status',
                'service_desc' => 'Description'

            ]);
            $oridata = Service::whereId($id)->first();
            $message = null;
            if ($oridata->service_rate != $data['service_rate'] || $oridata->service_rate_type != $data['service_rate_type']) {
                $data['service_status'] = 0;
                $servicetype = ServiceType::where('id', $req->service_type_id)->first();

                Mail::to(Auth::user()->email)->send(new ServiceApplicationNotification([
                    'name' => Str::headline(Auth::user()->tasker_firstname . ' ' . Auth::user()->tasker_lastname),
                    'service_name' => $servicetype->servicetype_name,
                    'date' => Carbon::now()->format('d F Y g:i A'),
                    'service_rate' =>  $data['service_rate'],
                    'service_rate_type' => $data['service_rate_type'],
                    'service_desc' => $data['service_desc'],
                    'service_status' => $data['service_status']
                ]));

                $message = 'Your service has been successfully submitted! Please allow up to 3 business days for our administrators to review your updated application. We’ll notify you once it’s been processed.';
            } else {
                $message = 'Service details has been successfully updated !';
            }

            Service::whereId($id)->update($data);

            return response([
                'message' => $message
            ], 201);
        } catch (Exception $e) {
            return response([
                'message' => 'Error : ' . $e->getMessage()
            ], 301);
        }
    }

    // Delete Service API
    // Check by : Zikri (11/01/2025)
    public function deleteServiceAPI($id)
    {
        try {
            Service::where('id', $id)->delete();
            return response([
                'message' => 'Service has been deleted successfully !'
            ], 201);
        } catch (Exception $e) {
            return response([
                'message' => 'The operation cannot be completed as it is restricted. You may only change the status to "Inactive".'
            ], 301);
        }
    }

    // Task Preferences > Visibility & Location - Visibility Change 
    // Check by : Zikri (11/01/2025)
    public function taskerVisibleToggleAPI()
    {
        try {
            if (Auth::user()->tasker_working_status == 0) {
                Tasker::whereId(Auth::user()->id)->update(['tasker_working_status' => 1]);
                $message = 'You are now visible to clients !';
            } else if (Auth::user()->tasker_working_status == 1) {
                Tasker::whereId(Auth::user()->id)->update(['tasker_working_status' => 0]);
                $message = 'You are now invisible to clients !';
            }
            return response([
                'message' => $message
            ], 200);
        } catch (Exception $e) {
            return response([
                'message' => 'Error : ' . $e->getMessage()
            ], 500);
        }
    }

    // Task Preferences > Visibility & Location - Update Location API
    // Check by : Zikri (11/01/2025)
    public function taskerUpdateLocationAPI(Request $req)
    {
        $id = Auth::user()->id;
        try {

            $taskers = $req->validate(
                [
                    'tasker_workingloc_state' => 'required',
                    'tasker_workingloc_area' => 'required',
                    'working_radius' => 'required',

                ],
                [],
                [
                    'tasker_workingloc_state' => 'Working State',
                    'tasker_workingloc_area' => 'Working Area',
                    'working_radius' => 'Working Radius'
                ]
            );


            $address = $taskers['tasker_workingloc_area'] . ',' . $taskers['tasker_workingloc_state'];
            $result = $this->geocoder->getCoordinatesForAddress($address);
            $taskers['latitude'] = $result['lat'];
            $taskers['longitude'] = $result['lng'];
            Tasker::whereId($id)->update($taskers);

            return response([
                'message' => 'Tasker working preferences have been saved !',
            ], 201);
        } catch (Exception $e) {
            return response([
                'message' => 'Error : ' . $e->getMessage()
            ], 500);
        }
    }

    // Update Type API
    // Check by : Zikri (11/01/2025)
    public function taskerTypeToggleAPI(Request $req)
    {
        try {
            Tasker::whereId(Auth::user()->id)->update(['tasker_worktype' => $req->tasker_worktype]);

            return response()->json([
                'message' => 'Your working type has been successfully updated !'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update your working type. Please try again !'
            ], 500);
        }
    }

    // Task Preferences > Time Slot - Time Slot API
    // Check by : Zikri (11/01/2025)
    public function taskerCreateTimeSlotAPI($date)
    {
        $isFull = Tasker::where('tasker_status', 2)->where('tasker_worktype', 1)->where('id', Auth::user()->id)->exists();
        $isPart = Tasker::where('tasker_status', 2)->where('tasker_worktype', 2)->where('id', Auth::user()->id)->exists();

        if ($isFull) // Full-Time
        {
            $timeslotsFt = TimeSlot::where('slot_category', 1)->get();

            foreach ($timeslotsFt as $ft) {
                $check = TaskerTimeSlot::where('slot_id', $ft->id)->where('tasker_id', Auth::user()->id)->where('slot_date', $date)->exists();
                if (!$check) {
                    $data = new TaskerTimeSlot();
                    $data->slot_id = $ft->id;
                    $data->tasker_id = Auth::user()->id;
                    $data->slot_date = $date;
                    $data->slot_status = 1;
                    $data->save();
                } else {
                    $datePrompt = Carbon::createFromFormat('Y-m-d', $date);
                    $formattedDate = $datePrompt->format('l, d F Y');
                    return response()->json([
                        'error' => 'All slots for ' . Carbon::createFromFormat('Y-m-d', $date)->format('l, d F Y') . ' has been generated. No need to generate again.',
                    ], 400);
                }
            }
        } elseif ($isPart) // Part-Time
        {
            $timeslotsPt = TimeSlot::where('slot_category', 2)->get();

            foreach ($timeslotsPt as $pt) {
                $check = TaskerTimeSlot::where('slot_id', $pt->id)->where('tasker_id', Auth::user()->id)->where('slot_date', $date)->exists();
                if (!$check) {
                    $data = new TaskerTimeSlot();
                    $data->slot_id = $pt->id;
                    $data->tasker_id = Auth::user()->id;
                    $data->slot_date = $date;
                    $data->slot_status = 1;
                    $data->save();
                } else {
                    $datePrompt = Carbon::createFromFormat('Y-m-d', $date);
                    $formattedDate = $datePrompt->format('l, d F Y');
                    return response()->json([
                        'error' => 'All slots for ' . Carbon::createFromFormat('Y-m-d', $date)->format('l, d F Y') . ' has been generated. No need to generate again.',
                    ], 400);
                }
            }
        } else {
            return response()->json([
                'error' => 'Please make sure you are verified in order to generate time slots. If you have any questions, please contact us.',
            ], 400);
        }

        $datePrompt = Carbon::createFromFormat('Y-m-d', $date);
        $formattedDate = $datePrompt->format('l, d F Y');
        return response()->json([
            'success' => 'Slot for ' . Carbon::createFromFormat('Y-m-d', $date)->format('l, d F Y') . ' has been generated successfully!',
        ], 201);
    }

    // Task Preferences > Time Slot - Get Time Slot API
    // Check by : Zikri (11/01/2025)
    public function getTaskerTimeSlotAPI($date)
    {
        try {
            $data = TaskerTimeSlot::where('tasker_id', Auth::user()->id)->where('slot_date', $date)->get();
            $data = DB::table('tasker_time_slots as a')
                ->join('time_slots as b', 'a.slot_id', '=', 'b.id')
                ->where('a.tasker_id', Auth::user()->id)
                ->where('a.slot_date', '=', $date)
                ->select('a.id as taskerTimeSlotID', 'a.slot_status', 'a.slot_date', 'b.id as timeSlotID', 'b.time', 'b.slot_category')
                ->get();

            return response()->json([
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch your time. Please try again.'
            ], 500);
        }
    }

    //  Task Preferences > Time Slot - Update Time Slot Availability
    // Check by : Zikri (11/01/2025)
    public function taskerUpdateTimeSlotAPI(Request $request, $id)
    {
        try {
            $data = $request->validate(
                [
                    'slot_status' => 'required',
                ],
                [],
                [
                    'slot_status' => 'Status',
                ]
            );

            TaskerTimeSlot::whereId($id)->update($data);

            return response()->json([
                'data' => 'Slot availability has been updated successfully !'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch your time. Please try again.'
            ], 500);
        }
    }

    // Get Booking Details
    // Check by : Zikri (11/01/2025)
    public function getBookingsDetailsAPI()
    {
        try {
            // $bookings = Booking::all();
            $bookings = DB::table('bookings as a')
                ->join('clients as b', 'a.client_id', '=', 'b.id')
                ->join('services as c', 'a.service_id', '=', 'c.id')
                ->join('service_types as d', 'c.service_type_id', '=', 'd.id')
                ->join('taskers as e', 'c.tasker_id', '=', 'e.id')
                ->where('e.id', '=', Auth::user()->id)
                ->whereIn('a.booking_status', [1, 2, 3, 4, 6])
                ->select(
                    'a.id as bookingID',
                    'a.booking_date',
                    'a.booking_address',
                    'a.booking_latitude',
                    'a.booking_longitude',
                    'a.booking_time_start',
                    'a.booking_time_end',
                    'a.booking_note',
                    'a.booking_rate',
                    'a.booking_status',
                    'd.servicetype_name',
                    'b.client_firstname',
                    'b.client_lastname',
                    'b.email',
                    'b.client_phoneno',
                    'b.latitude',
                    'b.longitude',
                )
                ->get();
            // dd($bookings);
            $events = $bookings->map(function ($booking) {
                $className = '';
                $editable = true;

                if ($booking->booking_status == 3) {
                    $className = 'event-success';
                    $editable = false;
                } elseif ($booking->booking_status == 6) {
                    $className = 'event-unavailable';
                    $editable = false;
                }
                return [
                    'id' => $booking->bookingID,
                    'title' => $booking->client_firstname . ' (' . $booking->servicetype_name . ')',
                    'date' => $booking->booking_date,
                    'startTime' => $booking->booking_time_start,
                    'endTime' => $booking->booking_time_end,
                    'address' => $booking->booking_address,
                    'status' => $booking->booking_status,
                    'task' => $booking->servicetype_name,
                    'client_name' => $booking->client_firstname . ' ' . $booking->client_lastname,
                    'client_phoneno' => $booking->client_phoneno,
                    'lat' => $booking->booking_latitude,
                    'long' => $booking->booking_longitude,
                    'booking_note' => $booking->booking_note,
                    'className' => $className,
                    'editable' => $editable,
                ];
            });
            return response()->json([
                'booking' => $events
            ], 200);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // Get Tasker Unavailable Slot
    // Check by : Zikri (11/01/2025)
    public function getTaskerUnavailableSlotAPI()
    {
        try {
            // Fetch all slots with statuses
            $slots = DB::table('tasker_time_slots as a')
                ->join('time_slots as b', 'a.slot_id', '=', 'b.id')
                ->where('a.tasker_id', Auth::user()->id)
                ->where('a.slot_status', 0)
                ->select(
                    'a.id as slotID',
                    'a.slot_status',
                    'a.slot_date',
                    'b.time as slot_time'
                )
                ->get();

            $events = $slots->map(function ($slot) {
                return [
                    'slot_id' => $slot->slotID,
                    'title' => 'Unavailable',
                    'date' => $slot->slot_date,
                    'startTime' => $slot->slot_time,
                    'endTime' =>  date('H:i:s', strtotime('+1 hour', strtotime($slot->slot_time))),
                    'slot_status' => $slot->slot_status,
                    'editable' => false,
                ];
            });
            return response()->json($events);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to fetch your time. Please try again.'], 500);
        }
    }

    // Tasker | Admin - Send Email Notification for booking status update
    // Check by : Zikri (11/01/2025)
    private function sendBookingStatusEmail($data, $userType)
    {
        // Booking Status
        if ($data->booking_status == 2) {
            $status = 'Paid';
        } elseif ($data->booking_status == 3) {
            $status = 'Confirmed';
        } elseif ($data->booking_status == 4) {
            $status = 'Rescheduled';
        } elseif ($data->booking_status == 5) {
            $status = 'Cancelled';
        } elseif ($data->booking_status == 6) {
            $status = 'Completed';
        } else {
            $status = 'Undefined Status';
        }

        // Booking Note
        if ($data->booking_note != null) {
            $note = $data->booking_note;
        } else {
            $note = '-';
        }

        // User Name
        if ($userType == 1) {

            $name = $data->client_firstname . ' ' . $data->client_lastname;
        } elseif ($userType == 2) {

            $name = $data->tasker_firstname . ' ' . $data->tasker_lastname;
        }

        Mail::to($data->email)->send(new TaskerClientBookingStatus([
            'users' => $userType,
            'name' => Str::headline($name),
            'service_name' => $data->servicetype_name,
            'booking_order_id' => $data->booking_order_id,
            'change_date' => Carbon::now()->format('d F Y g:i A'),
            'booking_date' => $data->booking_date,
            'booking_time_start' => Carbon::parse($data->booking_time_start)->format('g:i A'),
            'booking_time_end' => Carbon::parse($data->booking_time_end)->format('g:i A'),
            'booking_rate' => $data->booking_rate,
            'booking_address' => $data->booking_address,
            'booking_status' => $status,
            'booking_note' => $note,

        ]));
    }

    // Tasker | Admin - Send Email Notification for Refund booking status update
    // Done by Muhammad Zikri (12/01/2025)
    private function sendRefundStatusEmail($data, $userType)
    {
        // Booking Status
        if ($data->cr_status == 0) {
            $status = 'Require Update';
        } elseif ($data->cr_status == 1) {
            $status = 'Process';
        } elseif ($data->cr_status == 2) {
            $status = 'Approved';
        } elseif ($data->cr_status == 3) {
            $status = 'Rejected';
        } else {
            $status = 'Undefined Status';
        }

        // Booking Note
        if ($data->booking_note != null) {
            $note = $data->booking_note;
        } else {
            $note = '-';
        }
        // User Name
        if ($userType == 1 || $userType == 3 || $userType == 5) {

            $name = $data->client_firstname . ' ' . $data->client_lastname;
        } elseif ($userType == 2 || $userType == 4) {

            $name = $data->tasker_firstname . ' ' . $data->tasker_lastname;
        }

        Mail::to($data->email)->send(new AdminRefundApproval([
            'users' => $userType,
            'name' => Str::headline($name),
            'service_name' => $data->servicetype_name,
            'booking_order_id' => $data->booking_order_id,
            'change_date' => Carbon::now()->format('d F Y g:i A'),
            'booking_date' => $data->booking_date,
            'booking_time_start' => Carbon::parse($data->booking_time_start)->format('g:i A'),
            'booking_time_end' => Carbon::parse($data->booking_time_end)->format('g:i A'),
            'booking_rate' => $data->booking_rate,
            'booking_address' => $data->booking_address,
            'booking_note' => $note,
            'cr_status' => $status,
            'cr_date' => $data->cr_date,
            'cr_reason' => $data->cr_reason,
            'cr_amount' => $data->cr_amount,
            'cr_bank_name' => $data->cr_bank_name,
            'cr_account_number' => $data->cr_account_number,
        ]));
    }

    // Booking Reschedule API   
    // Check by : Zikri (11/01/2025)
    public function rescheduleBookingTimeFunctionAPI(Request $request)
    {
        // Find the booking by ID
        $booking = Booking::find($request->id);

        // Get the old time range
        $oldDate = $booking->booking_date;
        $oldStartTime = $booking->booking_time_start;
        $oldEndTime = $booking->booking_time_end;

        $checkTimeSlot = TaskerTimeSlot::where('tasker_id', Auth::user()->id)->where('slot_date', $request->date)->exists();

        if ($checkTimeSlot) {
            // Update the booking start and end times
            $booking->booking_date = $request->date;
            $booking->booking_status = 4;
            $booking->booking_time_start = Carbon::parse($request->start)->format('H:i:s');
            $booking->booking_time_end = Carbon::parse($request->end)->format('H:i:s');
            $booking->save();

            // Calculate new end time for slot adjustment (minus one hour)
            $newEndTime = date('H:i:s', strtotime('-1 hour', strtotime(Carbon::parse($request->end)->format('H:i:s'))));

            // 1. Set old slots back to available (status = 1)
            DB::table('tasker_time_slots as a')
                ->join('time_slots as b', 'a.slot_id', '=', 'b.id')
                ->where('a.tasker_id', '=', Auth::user()->id)
                ->where('a.slot_date', '=', $oldDate)
                ->whereBetween('b.time', [$oldStartTime, date('H:i:s', strtotime('-1 hour', strtotime(Carbon::parse($oldEndTime)->format('H:i:s'))))])
                ->update(['a.slot_status' => 1]);

            // 2. Set new slots to booked (status = 2)
            $newSlots = DB::table('tasker_time_slots as a')
                ->join('time_slots as b', 'a.slot_id', '=', 'b.id')
                ->where('a.tasker_id', '=', Auth::user()->id)
                ->where('a.slot_date', '=', $request->date)
                ->whereBetween('b.time', [Carbon::parse($request->start)->format('H:i:s'), $newEndTime])
                ->where('a.slot_status', '=', 1)
                ->select('a.id as tasker_time_id', 'b.time')
                ->get();

            foreach ($newSlots as $slot) {
                DB::table('tasker_time_slots')
                    ->where('id', '=', $slot->tasker_time_id)
                    ->update(['slot_status' => 2]);
            }

            // 3. Send an email to client 
            $datasClient = DB::table('clients as a')
                ->join('bookings as b', 'a.id', '=', 'b.client_id')
                ->join('services as c', 'b.service_id', '=', 'c.id')
                ->join('service_types as d', 'c.service_type_id', '=', 'd.id')
                ->where('b.id', $booking->id)
                ->get();

            foreach ($datasClient as $data) {
                $this->sendBookingStatusEmail($data, 1);
            }

            // Return a response confirming the update
            return response()->json([
                'status' => 'success',
                'message' => 'Event rescheduled successfully',
                'updated_booking' => $booking
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Oops !, You cannot reschedule to this date because there is no time slots generated !',
            ]);
        }
    }

    // Tasker Change Booking Status API
    // Check by : Zikri (11/01/2025)
    public function taskerChangeBookingStatusAPI(Request $request)
    {
        try {
            $booking = Booking::findOrFail($request->id);
            if ($request->option == 1) {
                $booking->booking_status = 3;
                $booking->save();

                $datasClient = DB::table('clients as a')
                    ->join('bookings as b', 'a.id', '=', 'b.client_id')
                    ->join('services as c', 'b.service_id', '=', 'c.id')
                    ->join('service_types as d', 'c.service_type_id', '=', 'd.id')
                    ->where('b.id', $request->id)
                    ->get();

                foreach ($datasClient as $data) {
                    $this->sendBookingStatusEmail($data, 1);
                }

                return response()->json([
                    'status' => 'success',
                    'message' => 'Booking Confirmed!',
                    'updated_booking' => $booking,
                ], 200);
            } else if ($request->option == 2) {
                $booking->booking_status = 9;
                $booking->save();

                $oldDate = $booking->booking_date;
                $oldStartTime = $booking->booking_time_start;
                $oldEndTime = $booking->booking_time_end;

                DB::table('tasker_time_slots as a')
                    ->join('time_slots as b', 'a.slot_id', '=', 'b.id')
                    ->where('a.tasker_id', '=', Auth::user()->id)
                    ->where('a.slot_date', '=', $oldDate)
                    ->whereBetween('b.time', [$oldStartTime, date('H:i:s', strtotime('-1 hour', strtotime(Carbon::parse($oldEndTime)->format('H:i:s'))))])
                    ->update(['a.slot_status' => 1]);

                $formattedDate = Carbon::parse(Carbon::now())
                    ->format('Y-m-d');
                $reason = 'Tasker: ' . Auth()->user()->tasker_firstname . ' ' . Auth()->user()->tasker_lastname . ' unable to serve the services. Full refund requested by tasker.';
                $validated = [
                    'cr_date' => $formattedDate,
                    'cr_reason' => $reason,
                    'cr_status' => 0,
                    'cr_amount' => $booking->booking_rate,
                    'cr_bank_name' => '-',
                    'cr_account_name' => '-',
                    'cr_account_number' => '-',
                    'booking_id' => $request->id,
                ];
                CancelRefundBooking::create($validated);

                $refund = CancelRefundBooking::where('booking_id', $request->id)->first();
                $refundid = $refund->id;

                $dataClient = DB::table('bookings as a')
                    ->join('services as b', 'a.service_id', '=', 'b.id')
                    ->join('cancel_refund_bookings as c', 'a.id', '=', 'c.booking_id')
                    ->join('clients as d', 'a.client_id', '=', 'd.id')
                    ->join('service_types as e', 'b.service_type_id', '=', 'e.id')
                    ->where('c.id', $refundid)
                    ->get();

                foreach ($dataClient as $data) {
                    $this->sendRefundStatusEmail($data, 5);
                }

                return response()->json([
                    'status' => 'success',
                    'message' => 'Refund Request will be processed. Please inform the client to update their bank information in their booking history refund section.',
                    'updated_booking' => $refundid,
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // Tasker Fetch Booking List
    // Check by : Zikri (11/01/2025)
    public function getBookingListAPI()
    {
        try {
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
                ->orderbyDesc('a.booking_date')
                ->get();

            // Default values for calculations
            $totalBooking = 0;
            $totalUnpaid = 0;
            $totalConfirmed = 0;
            $totalCompleted = 0;
            $totalCancelled = 0;
            $totalCompletedAmount = '0.00';
            $totalCompletedAmountThisMonth = '0.00';
            $totalCancelledAmount = '0.00';
            $totalFloatingAmount = '0.00';
            $currentMonth = Carbon::now()->format('m');

            // Check if there is data
            if ($data->isNotEmpty()) {
                $totalBooking = $data->count();
                $totalUnpaid = $data->where('booking_status', 1)->count();
                $totalConfirmed = $data->where('booking_status', 3)->count();
                $totalCompleted = $data->where('booking_status', 6)->count();
                $totalCancelled = $data->where('booking_status', 5)->count();

                $totalCompletedAmount = number_format($data->where('booking_status', 6)->sum('booking_rate'), 2);
                $totalCancelledAmount = number_format($data->where('booking_status', 5)->sum('booking_rate'), 2);
                $totalFloatingAmount = number_format($data->whereIn('booking_status', [1, 2, 3, 4])->sum('booking_rate'), 2);
            }

            // Monthly Chart Data
            $monthlyData = Booking::selectRaw("
                YEAR(booking_date) as year,
                MONTH(booking_date) as month,
                SUM(CASE WHEN booking_status = 6 THEN booking_rate ELSE 0 END) as completedAmount,
                SUM(CASE WHEN booking_status IN (1, 2, 3, 4) THEN booking_rate ELSE 0 END) as floatingAmount,
                SUM(CASE WHEN booking_status = 5 THEN booking_rate ELSE 0 END) as cancelledAmount
            ")
                ->join('services as b', 'bookings.service_id', '=', 'b.id')
                ->where('b.tasker_id', Auth::user()->id)
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
                SUM(CASE WHEN booking_status IN (1, 2, 3, 4) THEN booking_rate ELSE 0 END) as floatingAmount,
                SUM(CASE WHEN booking_status = 5 THEN booking_rate ELSE 0 END) as cancelledAmount
            ")
                ->join('services as b', 'bookings.service_id', '=', 'b.id')
                ->where('b.tasker_id', Auth::user()->id)
                ->groupBy('year')
                ->orderBy('year', 'asc')
                ->get();

            $yearlyChartData = [
                'labels' => $yearlyData->pluck('year')->toArray() ?? [],
                'completed' => $yearlyData->pluck('completedAmount')->toArray() ?? [],
                'floating' => $yearlyData->pluck('floatingAmount')->toArray() ?? [],
                'cancelled' => $yearlyData->pluck('cancelledAmount')->toArray() ?? [],
            ];
            return response()->json([
                'status' => 'success',
                'data' => $data,
                'totalBooking' => $totalBooking,
                'totalUnpaid' => $totalUnpaid,
                'totalConfirmed' => $totalConfirmed,
                'totalCompleted' => $totalCompleted,
                'totalCancelled' => $totalCancelled,
                'totalCompletedAmount' => $totalCompletedAmount,
                'totalCancelledAmount' => $totalCancelledAmount,
                'totalFloatingAmount' => $totalFloatingAmount,
                'totalCompletedAmountThisMonth' => $totalCompletedAmountThisMonth,
                'monthlyChartData' => $monthlyChartData,
                'yearlyChartData' => $yearlyChartData,

            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // Tasker Fetch Refund List
    // Check by : Zikri (11/01/2025)
    public function getRefundListAPI()
    {
        try {
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
                    'f.cr_penalized',
                    'f.cr_bank_name',
                    'f.cr_account_name',
                    'f.cr_account_number'
                )
                ->whereIn('a.booking_status', [7, 8, 9])
                ->where('b.tasker_id', Auth::user()->id)
                ->orderbyDesc('a.booking_date')
                ->get();

            // Default values for calculations
            $totalRefund = 0;
            $totalPendingRefund = 0;
            $totalSelfRefund = 0;
            $totalApprovedAmount = '0.00';
            $totalPenalizedAmount = '0.00';
            $totalPendingAmount = '0.00';

            // Check if $data is not empty
            if ($data->isNotEmpty()) {
                // Calculate totals
                $totalRefund = $data->count();
                $totalSelfRefund = $data->where('cr_penalized', 1)->count();

                // Calculate amounts
                $totalApprovedAmount = number_format($data->where('cr_status', 2)->sum('cr_amount'), 2);
                $totalPenalizedAmount = number_format($data->where('cr_penalized', 1)->sum('cr_amount'), 2);
            }

            // Fetch all data with joins and ensure it's handled properly if empty
            $dataAll = DB::table('bookings as a')
                ->join('cancel_refund_bookings as f', 'a.id', '=', 'f.booking_id')
                ->join('services as b', 'a.service_id', '=', 'b.id')
                ->join('service_types as c', 'b.service_type_id', '=', 'c.id')
                ->join('taskers as d', 'b.tasker_id', '=', 'd.id')
                ->join('clients as e', 'a.client_id', '=', 'e.id')
                ->whereIn('a.booking_status', [7, 8, 9, 10])
                ->where('b.tasker_id', Auth::user()->id)
                ->orderByDesc('a.booking_date')
                ->get();

            if ($dataAll->isNotEmpty()) {
                // Calculate total pending refunds if $dataAll is not empty
                $totalPendingRefund = $dataAll->whereIn('cr_status', [0, 1])->count();
                $totalPendingAmount = number_format($dataAll->whereIn('cr_status', [0, 1])->sum('cr_amount'), 2);
            }
            return response()->json([
                'status' => 'success',
                'data' => $data,
                'totalRefund' => $totalRefund,
                'totalPendingRefund' => $totalPendingRefund,
                'totalSelfRefund' => $totalSelfRefund,
                'totalApprovedAmount' => $totalApprovedAmount,
                'totalPenalizedAmount' => $totalPenalizedAmount,
                'totalPendingAmount' => $totalPendingAmount

            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // Tasker Fetch Review List
    // Check by : Zikri (11/01/2025)
    public function getReviewListAPI()
    {
        try {
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
                ->where('d.id', Auth::user()->id)
                ->get();

            $totalreview = 0;
            $rating5Count = 0;
            $rating4Count = 0;
            $rating3Count = 0;
            $rating2Count = 0;
            $rating1Count = 0;



            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
            $totalreview = $data->count();
            $rating5Count = $data->where('review_rating', '=', 5)->count();
            $rating4Count = $data->where('review_rating', '=', 4)->count();
            $rating3Count = $data->where('review_rating', '=', 3)->count();
            $rating2Count = $data->where('review_rating', '=', 2)->count();
            $rating1Count = $data->where('review_rating', '=', 1)->count();


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
            return response()->json([
                'status' => 'success',
                'data' => $data,
                'rating5Count' => $rating5Count,
                'rating4Count' => $rating4Count,
                'rating3Count' => $rating3Count,
                'rating2Count' => $rating2Count,
                'rating1Count' => $rating1Count,
                'totalreviewsbymonth' => $totalreviewsbymonth,
                'totalreviewsbyyear' => $totalreviewsbyyear,
                'totalunreview' => $totalunreview,
                'averageRating' => $averageRating,
                'csat' => $csat,
                'negrev' => $negrev,
                'neutralrev' => $neutralrev,
                'reply' => $reply
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // Tasker Update Review Status
    // Check by : Zikri (11/01/2025)
    public function taskerReviewUpdateStatusAPI(Request $request, $id)
    {
        try {
            $review = Review::find($id);
            $review->review_status = $request->review_status;
            $review->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Review status updated successfully !'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // Tasker Reply Review 
    // Check by : Zikri (11/01/2025)
    public function taskerReplyReviewAPI(Request $request, $id)
    {
        try {
            $data = [
                'reply_by' => 2,
                'reply_message' => $request->reply_message,
                'reply_date_time' => date('Y-m-d H:i:s'),
                'review_id' => $id,
            ];

            ReviewReply::create($data);
            return response()->json([
                'status' => 'success',
                'message' => 'Review reply sent successfully !'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // Tasker Fetch Performance Analysis
    // Check by : Zikri (11/01/2025)
    public function getPerformanceAnalysisAPI()
    {
        try {
            $bookings = DB::table('bookings as a')
                ->join('services as b', 'a.service_id', 'b.id')
                ->where('b.tasker_id', auth()->user()->id)
                ->get();

            $completedBookings = $bookings->where('booking_status', 6)->count();

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

            return response()->json([
                'status' => 'success',
                'completedBookings' => $completedBookings,
                'taskers' => $taskers,
                'pastPerformance' => $pastPerformance,
                'date' => $dateLabel,
                'taskerMonthlyRefunds' => $taskerMonthlyRefunds
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // Tasker Fetch Monthly Statement
    // Check by : Zikri (11/01/2025)
    public function geteStatementAPI()
    {
        try {

            $data = DB::table('taskers as a')
                ->join('monthly_statements as b', 'a.id', 'b.tasker_id')
                ->select(
                    'a.id as taskerID',
                    'b.id as statementID',
                    'a.tasker_firstname',
                    'a.tasker_lastname',
                    'a.tasker_phoneno',
                    'a.email',
                    'a.tasker_code',
                    'b.start_date',
                    'b.end_date',
                    'b.file_name',
                    'b.statement_status',
                    'b.total_earnings'
                )
                ->where('a.id', Auth::user()->id)
                ->get();

            $tobeReleased = MonthlyStatement::where('tasker_id', Auth::user()->id)->where('statement_status', 0)->sum('total_earnings');

            //calculation of amount have been released
            $currentYear = now()->year;

            $releasedAll = MonthlyStatement::where('tasker_id', Auth::user()->id)->where('statement_status', 1)->sum('total_earnings');

            $releasedthisyear = MonthlyStatement::where('tasker_id', Auth::user()->id)->where('statement_status', 1)->whereYear('end_date', $currentYear)->sum('total_earnings');

            $monthlyLabels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];


            $monthlyReleasedAmounts = MonthlyStatement::where('tasker_id', Auth::user()->id)->selectRaw('MONTH(end_date) as month, SUM(total_earnings) as total')
                ->where('statement_status', 1)
                ->whereYear('end_date', $currentYear) // Filter records for the current year
                ->groupBy('month')
                ->pluck('total', 'month')
                ->toArray();

            $monthlyReleasedAmounts = array_replace(array_fill(1, 12, 0), $monthlyReleasedAmounts);
            $monthlyReleasedAmountsWithLabels = [];
            foreach ($monthlyReleasedAmounts as $monthIndex => $amount) {
                $monthlyReleasedAmountsWithLabels[$monthlyLabels[$monthIndex - 1]] = $amount; // $monthIndex is 1-based
            }

            // dd($monthlyReleasedAmountsWithLabels);

            $yearlyLabels = MonthlyStatement::where('tasker_id', Auth::user()->id)->selectRaw('YEAR(end_date) as year')
                ->distinct()
                ->orderBy('year')
                ->pluck('year')
                ->toArray();

            $yearlyReleasedAmounts = MonthlyStatement::where('tasker_id', Auth::user()->id)->selectRaw('YEAR(end_date) as year, SUM(total_earnings) as total')
                ->where('statement_status', 1)
                ->groupBy('year')
                ->pluck('total', 'year')
                ->toArray();


            return response()->json([
                'status' => 'success',
                'data' => $data,
                'tobeReleased' => $tobeReleased,
                'releasedthisyear' => $releasedthisyear,
                'releasedAll' => $releasedAll,
                'monthlyLabels' => $monthlyLabels,
                'monthlyReleasedAmounts' => $monthlyReleasedAmountsWithLabels,
                'yearlyLabels' => $yearlyLabels,
                'yearlyReleasedAmounts' => $yearlyReleasedAmounts,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // Get State API
    public function getStateAPI()
    {
        try {
            $state = json_decode(file_get_contents(public_path('assets/json/state.json')), true);
            return response([
                'state' => $state
            ], 201);
        } catch (Exception $e) {
            return response([
                'message' => 'Error : ' . $e->getMessage()
            ], 301);
        }
    }

    // Get Area API
    public function getAreasAPI($state)
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
}
