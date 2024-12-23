<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Tasker;
use App\Models\Booking;
use App\Models\Service;
use App\Models\TimeSlot;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use App\Models\TaskerTimeSlot;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TaskerAPIController extends Controller
{

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

    // Create Service API
    public function createServiceAPI(Request $req)
    {
        try {
            $data = $req->validate([
                'service_rate' => 'required',
                'service_rate_type' => 'required',
                'service_type_id' => 'required',
                'service_desc' => ''

            ], [], [
                'service_rate' => 'Service Rate',
                'service_rate_type' => 'Service Rate Type',
                'service_type_id' => 'Service Type',
                'service_desc' => 'Description'
            ]);
            $data['service_status'] = 0;
            $data['tasker_id'] = Auth::user()->id;
            Service::create($data);

            return response([
                'message' => 'Your service has been successfully submitted! Please allow up to 3 business days for our administrators to review your application. We’ll notify you once it’s been processed.'
            ], 201);
        } catch (Exception $e) {
            return response([
                'message' => 'Error : ' . $e->getMessage()
            ], 301);
        }
    }

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

    // Update Service API
    public function updateServiceAPI(Request $req, $id)
    {
        try {

            $data = $req->validate([
                'service_rate' => 'required',
                'service_rate_type' => 'required',
                'service_type_id' => 'required',
                'service_status' => 'required',
                'service_desc' => ''

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
    public function deleteServiceAPI($id)
    {
        try {
            Service::where('id', $id)->delete();
            return response([
                'message' => 'Service has been deleted successfully !'
            ], 201);
        } catch (Exception $e) {
            return response([
                'message' => 'Error : ' . $e->getMessage()
            ], 301);
        }
    }

    // Task Preferences > Visibility & Location - Visibility Change 
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
    public function taskerUpdateLocationAPI(Request $req)
    {
        $id = Auth::user()->id;
        try {
            $taskers = $req->validate(
                [
                    'tasker_workingloc_state' => 'required',
                    'tasker_workingloc_area' => 'required',
                ],
                [],
                [
                    'tasker_workingloc_state' => 'Working State',
                    'tasker_workingloc_area' => 'Working Area',
                ]
            );


            Tasker::where('id', $id)->update($taskers);
            return response([
                'message' => 'Tasker working location have been saved !',
            ], 201);
        } catch (Exception $e) {
            return response([
                'message' => 'Error : ' . $e->getMessage()
            ], 500);
        }
    }

    // Task Preferences > Time Slot - Update Type API
    public function taskerTypeToggleAPI(Request $req)
    {
        try {
            Tasker::whereId(Auth::user()->id)->update(['tasker_worktype' => $req->tasker_worktype]);

            return response()->json([
                'message' => 'Your working type has been successfully updated!'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update your working type. Please try again.'
            ], 500);
        }
    }

    // Task Preferences > Time Slot - Time Slot API
    public function taskerCreateTimeSlotAPI($date)
    {
        $isFull = Tasker::where('tasker_status', 2)->where('tasker_worktype', 1)->where('id', Auth::user()->id)->exists();
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
        } else // Part-Time
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
        }

        $datePrompt = Carbon::createFromFormat('Y-m-d', $date);
        $formattedDate = $datePrompt->format('l, d F Y');
        return response()->json([
            'success' => 'Slot for ' . Carbon::createFromFormat('Y-m-d', $date)->format('l, d F Y') . ' has been generated successfully!',
        ], 201);
    }

    // Task Preferences > Time Slot - Get Time Slot API
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

    // Get Booking Details
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
                    'startTime'=> $booking->booking_time_start,
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
                    'startTime'=>$slot->slot_time,
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

    // Booking Reschedule API   
    public function rescheduleBookingTimeFunctionAPI(Request $request)
    {
        // Find the booking by ID
        $booking = Booking::find($request->id);

        // Get the old time range
        $oldDate = $booking->booking_date;
        $oldStartTime = $booking->booking_time_start;
        $oldEndTime = $booking->booking_time_end;

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

        // Return a response confirming the update
        return response()->json([
            'status' => 'success',
            'message' => 'Event rescheduled successfully',
            'updated_booking' => $booking
        ]);
    }

    // Tasker Change Booking Status API
    public function taskerChangeBookingStatusAPI(Request $request)
    {
        try {
            $booking = Booking::findOrFail($request->id);
            if ($request->option == 1) {
                $booking->booking_status = 3;
                $booking->save();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Booking Confirmed!',
                    'updated_booking' => $booking,
                ],200);
            } else if ($request->option == 2) {
                $booking->booking_status = 5;
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

                return response()->json([
                    'status' => 'success',
                    'message' => 'Booking Cancelled!',
                    'updated_booking' => $booking,
                ],200);
            }
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
