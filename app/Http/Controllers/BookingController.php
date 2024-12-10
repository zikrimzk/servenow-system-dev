<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Tasker;
use App\Models\Booking;
use Illuminate\Http\Request;
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
            $checkout= DB::table('taskers as a')
            ->join('services as b','a.id','=','b.tasker_id')
            ->join('service_types as c','b.service_type_id','=','c.id')
            ->where('a.id','=', $request->id)
            ->where('b.id','=', $request->svid)
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
            ],[],[
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

            $tasker_id= $request->tasker_id;
            $slot = DB::table('tasker_time_slots as a')
            ->join('time_slots as b','a.slot_id','=','b.id')
            ->where('a.tasker_id','=', $tasker_id)
            ->where('a.slot_date','=',$booking['booking_date'])
            ->whereBetween('b.time', [$booking['booking_time_start'], $new_end_time])
            ->where('a.slot_status','=',1)
            ->select('a.id as tasker_time_id','b.id as time_id','a.slot_date','a.slot_status','a.slot_id','b.time','b.slot_category')
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
}
