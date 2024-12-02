<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Tasker;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use App\Models\TaskerTimeSlot;
use Carbon\Carbon;
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
        //$check = TaskerTimeSlot::where('slot_id', $request->slot_id)->where('tasker_id', Auth::user()->id)->where('slot_day', $request->slot_day)->exists();
        $timeslotsFt = TimeSlot::where('slot_category', 1)->get();
        // $timeslotsPt = TimeSlot::where('slot_category', 2)->get();

        foreach ($timeslotsFt as $ft) {
            $data = new TaskerTimeSlot();
            $data->slot_id = $ft->id;
            $data->tasker_id = Auth::user()->id;
            $date = '12/02/2024';  // Invalid format for 'Y-m-d'
            $formattedDate = Carbon::createFromFormat('m/d/Y', $date)->toDateString();
            $data->slot_date = $formattedDate;
            $data->slot_status = 1;
            $data->save();
        }
    }

    // Tasker - Create Time Slot Process
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
        return back()->with('success', 'Slot has been updated successfully !');
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
}
