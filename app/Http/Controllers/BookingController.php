<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
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
                    'b.client_lastname',
                    'b.email',
                    'b.client_phoneno',
                    'b.latitude',
                    'b.longitude',
                )
                ->get();
            // dd($bookings);
            $events = $bookings->map(function ($booking) {
                return [
                    'title' => $booking->client_firstname . ' (' . $booking->servicetype_name . ')',
                    'start' => $booking->booking_date . 'T' . $booking->booking_time_start,
                    'end' => $booking->booking_date . 'T' . $booking->booking_time_end,
                    'description' => $booking->booking_address,
                    'id' => $booking->bookingID,
                    'status' => $booking->booking_status,
                    'task' => $booking->servicetype_name,
                    'name' => $booking->client_firstname . ' '. $booking->client_lastname,
                    'phoneno' => $booking->client_phoneno,
                    'lat' => $booking->latitude,
                    'long' => $booking->longitude,
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
        $oldStartTime = $booking->booking_time_start;
        $oldEndTime = $booking->booking_time_end;

        // Update the booking start and end times
        $booking->booking_time_start = Carbon::parse($request->start)->format('H:i:s');
        $booking->booking_time_end = Carbon::parse($request->end)->format('H:i:s');
        $booking->save();

        // Calculate new end time for slot adjustment (minus one hour)
        $newEndTime = date('H:i:s', strtotime('-1 hour', strtotime(Carbon::parse($request->end)->format('H:i:s'))));

        // 1. Set old slots back to available (status = 1)
        DB::table('tasker_time_slots as a')
            ->join('time_slots as b', 'a.slot_id', '=', 'b.id')
            ->where('a.tasker_id', '=', Auth::user()->id)
            ->where('a.slot_date', '=', $booking['booking_date'])
            ->whereBetween('b.time', [$oldStartTime, date('H:i:s', strtotime('-1 hour', strtotime(Carbon::parse($oldEndTime)->format('H:i:s'))))])
            ->update(['a.slot_status' => 1]);

        // 2. Set new slots to booked (status = 2)
        $newSlots = DB::table('tasker_time_slots as a')
            ->join('time_slots as b', 'a.slot_id', '=', 'b.id')
            ->where('a.tasker_id', '=', Auth::user()->id)
            ->where('a.slot_date', '=', $booking['booking_date'])
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
}
