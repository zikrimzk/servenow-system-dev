<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function getBookingTime($date,$taskerid)
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
}
