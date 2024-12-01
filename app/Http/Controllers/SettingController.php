<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Tasker;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use App\Models\TaskerTimeSlot;
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
    public function taskerCreateTimeSlot(Request $request)
    {
        $check = TaskerTimeSlot::where('slot_id', $request->slot_id)->where('tasker_id', Auth::user()->id)->where('slot_day', $request->slot_day)->exists();

        if (!$check) {
            $data = $request->validate(
                [
                    'slot_id' => 'required',
                    'tasker_id' => '',
                    'slot_status' => 'required',
                    'slot_day' => 'required',

                ],
                [],
                [
                    'slot_id' => 'Slot',
                    'tasker_id' => 'Tasker',
                    'slot_status' => 'Status',
                    'slot_day' => 'Day',
                ]
            );

            $data['tasker_id'] = Auth::user()->id;

            TaskerTimeSlot::create($data);
            return back()->with('success', 'Slot has been added successfully !');
        } else {
            return back()->with('error', 'Operation failed because of duplicate time slot. Please key in another slot !');
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
            ],200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update your working type. Please try again.'
            ], 500); // Return a 500 status code for server error
        }
    }
}
