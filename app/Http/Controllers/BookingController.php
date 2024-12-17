<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Client;
use App\Models\Tasker;
use App\Models\Booking;
use App\Models\TimeSlot;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\Geocoder\Geocoder;
use App\Models\TaskerTimeSlot;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{

    protected $geocoder;

    public function __construct(Geocoder $geocoder)
    {
        $this->geocoder = $geocoder;
    }

    public function getCoordinates(Request $request)
    {
        try {
            if ($request->useProfileAddress == 'true') {
                $client = Client::where('id', auth()->id())->first();
                $address = $client->client_address_one . ', '
                    . $client->client_address_two . ', '
                    . $client->client_area  . ', '
                    . $client->client_postcode . ' '
                    . $client->client_state;
                $address = Str::headline($address);
                return response()->json([
                    'status' => 'success',
                    'latitude' => $client->latitude,
                    'longitude' => $client->longitude,
                    'address' => $address,
                ]);
            } else {
                $address = $request->address;
                $address = Str::headline($address);
                $result = $this->geocoder->getCoordinatesForAddress($address);
                return response()->json([
                    'status' => 'success',
                    'latitude' => $result['lat'],
                    'longitude' => $result['lng'],
                    'address' => $address,
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function fetchTaskers(Request $request, $id)
    {
        try {
            // Retrieve latitude and longitude
            $clientLat = $request->latitude;
            $clientLng = $request->longitude;

            // API Key for Google Directions API
            $apiKey = env('GOOGLE_MAPS_GEOCODING_API_KEY', '');

            // Fetch taskers within a 30 km radius
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
                    'c.tasker_rating',
                    'c.tasker_photo',
                    'c.latitude as tasker_lat',
                    'c.longitude as tasker_lng'
                )
                ->get();
            // Filter taskers within a specified distance
            $svtasker = $svtasker->map(function ($tasker) use ($clientLat, $clientLng, $apiKey) {
                $taskerLat = $tasker->tasker_lat;
                $taskerLng = $tasker->tasker_lng;

                //Call Google Directions API
                // $url = "https://maps.googleapis.com/maps/api/directions/json?origin=$clientLat,$clientLng&destination=$taskerLat,$taskerLng&key=$apiKey";
                // $response = file_get_contents($url);
                // $data = json_decode($response, true);

                // Get road distance
                if (!empty($data['routes']) && isset($data['routes'][0]['legs'][0]['distance']['value'])) {
                    $distanceInMeters = $data['routes'][0]['legs'][0]['distance']['value'];
                    $tasker->road_distance = $distanceInMeters / 1000; // Convert to kilometers
                } else {
                    $tasker->road_distance = null; // If failed
                }

                return $tasker;
            });
            // ->filter(function ($tasker) {
            //     // Filter only taskers within 40 km
            //     return $tasker->road_distance !== null && $tasker->road_distance <= 4000;
            // })
            // ->sortBy('road_distance'); // Optional: Sort by nearest distance

            return response()->json([
                'status' => 'success',
                'taskers' => $svtasker,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function getBookingTime($date, $taskerid)
    {
        try {
            $data = DB::table('tasker_time_slots as a')
                ->join('time_slots as b', 'a.slot_id', '=', 'b.id')
                ->where('a.tasker_id', $taskerid)
                ->where('a.slot_date', '=', $date)
                ->where('a.slot_status', '=', 1)
                ->select('a.id as taskerTimeSlotID', 'a.slot_date', 'b.id as timeSlotID', 'b.time')
                ->get();

            return response()->json(['data' => $data], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to fetch your time. Please try again.'], 500);
        }
    }

    public function getTaskerDetail(Request $request)
    {
        try {
            // $data = Tasker::where('id', $request->id)->get();
            $checkout = DB::table('taskers as a')
                ->join('services as b', 'a.id', '=', 'b.tasker_id')
                ->join('service_types as c', 'b.service_type_id', '=', 'c.id')
                ->where('a.id', '=', $request->id)
                ->where('b.id', '=', $request->svid)
                ->get();

            return response([
                'taskerservice' => $checkout,
            ], 200);
        } catch (Exception $e) {
            return response([
                'message' => 'Error : ' . $e->getMessage()
            ], 500);
        }
    }

    public function clientBookFunction(Request $request)
    {
        try {
            $booking = $request->validate([
                'booking_date' => 'required',
                'booking_address' => 'required',
                'booking_time_start' => 'required',
                'booking_time_end' => 'required',
                'booking_latitude' => 'required',
                'booking_longitude' => 'required',
                'booking_note' => '',
                'booking_rate' => 'required',
                'service_id' => 'required',
            ], [], [
                'booking_date' => 'Booking Date',
                'booking_address' => 'Booking Address',
                'booking_time_start' => 'Start Booking Time',
                'booking_time_end' => 'End Booking Time',
                'booking_latitude' => 'Coordinate [Latitude]',
                'booking_longitude' => 'Coordinate [Longitude]',
                'booking_note' => 'Booking Note',
                'booking_rate' => 'Booking Rate',
                'service_id' => 'Service',
            ]);
            $booking['client_id'] = Auth::user()->id;
            $new_end_time = date('H:i:s', strtotime('-1 hour', strtotime($booking['booking_time_end'])));

            $tasker_id = $request->tasker_id;
            $slot = DB::table('tasker_time_slots as a')
                ->join('time_slots as b', 'a.slot_id', '=', 'b.id')
                ->where('a.tasker_id', '=', $tasker_id)
                ->where('a.slot_date', '=', $booking['booking_date'])
                ->whereBetween('b.time', [$booking['booking_time_start'], $new_end_time])
                ->where('a.slot_status', '=', 1)
                ->select('a.id as tasker_time_id', 'b.id as time_id', 'a.slot_date', 'a.slot_status', 'a.slot_id', 'b.time', 'b.slot_category')
                ->get();

            foreach ($slot as $s) {
                DB::table('tasker_time_slots')
                    ->where('id', '=', $s->tasker_time_id)
                    ->update(['slot_status' => 2]);
            }
            Booking::create($booking);

            return back()->with('success', 'Successfully Booked');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function getBookingsDetails()
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
                if ($booking->booking_status == 3) {
                    $className = 'event-success';
                } elseif ($booking->booking_status == 6) {
                    $className = 'event-unavailable';
                }
                return [
                    'title' => $booking->client_firstname . ' (' . $booking->servicetype_name . ')',
                    'start' => $booking->booking_date . 'T' . $booking->booking_time_start,
                    'end' => $booking->booking_date . 'T' . $booking->booking_time_end,
                    'description' => $booking->booking_address,
                    'id' => $booking->bookingID,
                    'status' => $booking->booking_status,
                    'task' => $booking->servicetype_name,
                    'name' => $booking->client_firstname . ' ' . $booking->client_lastname,
                    'phoneno' => $booking->client_phoneno,
                    'lat' => $booking->booking_latitude,
                    'long' => $booking->booking_longitude,
                    'note' => $booking->booking_note,
                    'className' => $className
                ];
            });

            return response()->json($events);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function getTaskerUnavailableSlot()
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
                    'title' => 'Unavailable',
                    'start' => $slot->slot_date . 'T' . $slot->slot_time,
                    'end' => $slot->slot_date . 'T' . date('H:i:s', strtotime('+1 hour', strtotime($slot->slot_time))),
                    'id' => $slot->slotID,
                    'status' => $slot->slot_status,
                    'className' => 'event-unavailable',
                    'editable' => false,
                    'overlap' => false,
                    'clickable' => false
                ];
            });
            return response()->json($events);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to fetch your time. Please try again.'], 500);
        }
    }

    public function getRangeTimeSlotsForTaskerCalander(Request $request)
    {
        try {
            // Fetch all slots with statuses
            $slots = DB::table('tasker_time_slots as a')
                ->join('time_slots as b', 'a.slot_id', '=', 'b.id')
                ->where('a.tasker_id', $request->taskerid)
                // ->where('a.slot_date', '=', $request->date)
                ->select(
                    'a.slot_status',
                    'b.time as slot_time'
                )
                ->get();

            // Extract the min/max times for available slots
            $availability = $slots->whereIn('slot_status', [1, 2]);
            $unavailability = $slots->where('slot_status', 0)->map(function ($slot) {
                return ['slot_time' => $slot->slot_time];
            })->values();

            $startTime = $availability->isNotEmpty() ? $availability->min('slot_time') : '07:00:00';
            $endTime = $availability->isNotEmpty() ? $availability->max('slot_time') : '07:30:00';
            $new_end_time = date('H:i:s', strtotime('+1 hour', strtotime($endTime)));
            // dd($endTime,$new_end_time);
            $allowedTimes = DB::table('tasker_time_slots as a')
                ->join('time_slots as b', 'a.slot_id', '=', 'b.id')
                ->where('a.tasker_id', $request->taskerid)
                ->where('a.slot_date', '=', $request->date)
                ->where('a.slot_status', '!=', 0)
                ->select(
                    'b.time as slot_time'
                )
                ->orderBy('slot_time', 'asc')
                ->get()
                ->pluck('slot_time');


            return response()->json([
                'start_time' => $startTime,
                'end_time' =>  $new_end_time,
                'unavailable_slots' => $unavailability,
                'allowed_times' => $allowedTimes
            ], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to fetch your time. Please try again.'], 500);
        }
    }

    public function rescheduleBookingTimeFunction(Request $request)
    {
        // Find the booking by ID
        $booking = Booking::find($request->id);

        // Get the old time range
        $oldDate = $booking->booking_date;
        $oldStartTime = $booking->booking_time_start;
        $oldEndTime = $booking->booking_time_end;

        // Update the booking start and end times
        $booking->booking_date = $request->date;
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

    public function changeBookingStatus(Request $request)
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
                ]);
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
                ]);
            }
        } catch (Exception $e) {
            // Catch errors and return a JSON response with a proper error message.
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500); // HTTP status code 500 for server errors.
        }
    }
    public function clientCancelBooking($id,$taskerid, $option)
    {
        try {

            $booking = Booking::findOrFail($id);

            if ($option == 1) {
                $booking->booking_status = 5;
                $booking->save();
                $oldDate = $booking->booking_date;
                $oldStartTime = $booking->booking_time_start;
                $oldEndTime = $booking->booking_time_end;

                DB::table('tasker_time_slots as a')
                    ->join('time_slots as b', 'a.slot_id', '=', 'b.id')
                    ->where('a.tasker_id', '=', $taskerid)
                    ->where('a.slot_date', '=', $oldDate)
                    ->whereBetween('b.time', [$oldStartTime, date('H:i:s', strtotime('-1 hour', strtotime(Carbon::parse($oldEndTime)->format('H:i:s'))))])
                    ->update(['a.slot_status' => 1]);
                $message = 'Your booking cancellation request has been processed successfully !';
            } else if ($option == 2) {
                // refund process here
                $booking->booking_status = 7;
                $booking->save();
                $message = 'Your refund request has been successfully processed. Please note, it may take up to 5 working days for the amount to reflect in your account.';
            }
            return back()->with('success', $message);
        } catch (Exception $e) {
            // Catch errors and return a JSON response with a proper error message.
            return back()->with('error', 'Opps , there was an unexpected error to execute the operation. Please try again.');
        }
    }
}
