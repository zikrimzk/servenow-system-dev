<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Tasker;
use App\Models\Booking;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use App\Models\TaskerTimeSlot;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
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
                'booking_note' => '',
                'booking_rate' => 'required',
                'service_id' => 'required',
            ], [], [
                'booking_date' => 'Booking Date',
                'booking_address' => 'Booking Address',
                'booking_time_start' => 'Start Booking Time',
                'booking_time_end' => 'End Booking Time',
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
                ->where('a.booking_status', '=', 1)
                ->select(
                    'a.id as bookingID',
                    'a.booking_date',
                    'a.booking_address',
                    'a.booking_time_start',
                    'a.booking_time_end',
                    'a.booking_note',
                    'a.booking_rate',
                    'a.booking_status',
                    'd.servicetype_name',
                    'b.client_firstname',
                    'b.email',
                    'b.client_phoneno',
                )
                ->get();
            // dd($bookings);
            $events = $bookings->map(function ($booking) {
                return [
                    'title' => $booking->client_firstname,
                    'start' => $booking->booking_date . 'T' . $booking->booking_time_start,
                    'end' => $booking->booking_date . 'T' . $booking->booking_time_end,
                    'id' => $booking->bookingID,
                    'status' => $booking->booking_status,
                    'className' => 'event-success'
                ];
            });

            return response()->json($events);
        } catch (Exception $e) {
            // dd($e->getMessage());
            return back()->with('error', $e->getMessage());
        }
    }

    public function getRangeTimeSlotsForTaskerCalander(Request $request)
    {
        try {
            // Fetch all slots with statuses
            $slots = DB::table('tasker_time_slots as a')
                ->join('time_slots as b', 'a.slot_id', '=', 'b.id')
                ->where('a.tasker_id', $request->taskerid)
                ->where('a.slot_date', '=', $request->date)
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
 
            return response()->json([
                'start_time' => $startTime,
                'end_time' =>  $new_end_time,
                'unavailable_slots' => $unavailability,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to fetch your time. Please try again.'], 500);
        }
    }


    public function rescheduleBookingTimeFunction(Request $request)
    {
        // Find the booking by ID
        $booking = Booking::find($request->id);

        // Update the start and end times
        $booking->booking_time_start = \Carbon\Carbon::parse($request->start)->format('H:i:s');
        $booking->booking_time_end = \Carbon\Carbon::parse($request->end)->format('H:i:s');

        // Save the updated booking
        $booking->save();

        // Return a response confirming the update
        return response()->json([
            'status' => 'success',
            'message' => 'Event updated successfully',
            'updated_booking' => $booking
        ]);
    }
}
