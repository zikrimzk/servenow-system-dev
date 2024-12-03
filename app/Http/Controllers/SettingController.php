<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Tasker;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use App\Models\TaskerTimeSlot;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{


    // Admin - Create Time Slot Process
    public function adminCreateTimeSlot(Request $request)
    {
        $check = TimeSlot::where('time', $request->time)->where('slot_category', $request->slot_category)->exists();
        if (!$check) {
            $data = $request->validate(
                [
                    'time' => 'required',
                    'slot_category' => 'required',
                ],
                [],
                [
                    'time' => 'Start Time',
                    'slot_category' => 'Category',
                ]
            );

            TimeSlot::create($data);
            return back()->with('success', 'Slot has been added successfully !');
        } else {
            return back()->with('error', 'Operation failed because of duplicate time slot. Please key in another slot !');
        }
    }

    // Admin - Update Time Slot Process
    public function adminUpdateTimeSlot(Request $request, $id)
    {
        $check = TimeSlot::where('time', $request->time)->where('slot_category', $request->slot_category)->exists();
        if (!$check) {
            $data = $request->validate(
                [
                    'time' => 'required',
                    'slot_category' => 'required',
                ],
                [],
                [
                    'time' => 'Start Time',
                    'slot_category' => 'Category',
                ]
            );

            TimeSlot::whereId($id)->update($data);
            return back()->with('success', 'Slot has been updated successfully !');
        } else {
            return back()->with('error', 'Operation failed because of duplicate time slot. Please key in another slot !');
        }
    }

    // Admin - Delete Time Slot Process
    public function adminDeleteTimeSlot($id)
    {
        try {
            $timeSlot = TimeSlot::find($id);
            $timeSlot->delete();
            return back()->with('success', 'Slot has been deleted successfully !');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // Tasker - Create Time Slot Process
    public function taskerCreateTimeSlot($date)
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
                    return back()->with('error', 'All slots for ' . $formattedDate . ' has been generated. No need to generate again.');
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
                    return back()->with('error', 'All slots for ' . $formattedDate . ' has been generated. No need to generate again.');
                }
            }
        }

        $datePrompt = Carbon::createFromFormat('Y-m-d', $date);
        $formattedDate = $datePrompt->format('l, d F Y');
        return back()->with('success', 'Slot for ' . $formattedDate . ' has been generated successfully!');
    }

    // Tasker - Update Time Slot Process
    public function taskerUpdateTimeSlot(Request $request, $id)
    {
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
        return back()->with('success', 'Slot availability has been updated successfully !');
    }

    // Tasker - Visibility Change 
    public function taskerVisibleToggle()
    {
        if (Auth::user()->tasker_working_status == 0) {
            Tasker::whereId(Auth::user()->id)->update(['tasker_working_status' => 1]);
            $message = 'You are now visible to clients !';
        } else if (Auth::user()->tasker_working_status == 1) {
            Tasker::whereId(Auth::user()->id)->update(['tasker_working_status' => 0]);
            $message = 'You are now invisible to clients !';
        }

        return response()->json(['message' => $message]);
    }

    // Tasker - Working Type Change 
    public function taskerTypeToggle(Request $req)
    {
        try {
            Tasker::whereId(Auth::user()->id)->update(['tasker_worktype' => $req->tasker_worktype]);

            return response()->json([
                'success' => true,
                'message' => 'Your working type has been successfully updated!'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update your working type. Please try again.'
            ], 500); // Return a 500 status code for server error
        }
    }

    public function getTaskerTimeSlot($date)
    {
        try {
            $data = TaskerTimeSlot::where('tasker_id', Auth::user()->id)->where('slot_date', $date)->get();
            $data = DB::table('tasker_time_slots as a')
                ->join('time_slots as b', 'a.slot_id', '=', 'b.id')
                ->where('a.tasker_id', Auth::user()->id)
                ->where('a.slot_date', '=', $date)
                ->select('a.id as taskerTimeSlotID', 'a.slot_status', 'a.slot_date', 'b.id as timeSlotID', 'b.time', 'b.slot_category')
                ->get();

            return response()->json(['data' => $data], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to fetch your time. Please try again.'], 500); // Return a 500 status code for server error
        }
    }
}
