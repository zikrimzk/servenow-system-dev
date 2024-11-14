<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Tasker;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TaskerController extends Controller
{
    public function createTasker(Request $req)
    {
        $taskers = $req->validate(
            [
                'tasker_firstname' => 'required|string',
                'tasker_lastname' => 'required|string',
                'tasker_phoneno' => 'required|string|min:10',
                'email' => 'required|email',
                'password' => 'required|same:cpassword|min:8|max:15',
                'cpassword' => 'required|min:8|max:15',
            ],
            [],
            [
                'tasker_firstname' => 'First Name',
                'tasker_lastname' => 'Last Name',
                'tasker_phoneno' => 'Phone Number',
                'email' => 'Email Address',
                'password' => 'Password',
                'cpassword' => 'Confirm Password'
            ]
        );

        $taskers['password'] = bcrypt($taskers['password']);
        $taskers['tasker_code'] = 'SNT' . rand(1, 10000);
        $path = 'profile_photos/default-profile.png';
        $taskers['tasker_photo'] = $path;
        Tasker::create($taskers);

        return redirect(route('tasker-login'))->with('success', 'Your Tasker account has been successfully created! Please log in with your registered credentials.');
    }

    public function adminCreateTasker(Request $req)
    {

        $taskers = $req->validate(
            [
                'tasker_code' => 'required',
                'tasker_firstname' => 'required|string',
                'tasker_lastname' => 'required|string',
                'tasker_phoneno' => 'required|string|min:10',
                'email' => 'required|email',
                'password' => 'required|min:8|max:15',
                'tasker_status' => 'required'
            ],
            [],
            [
                'tasker_code' => 'Tasker Code',
                'tasker_firstname' => 'First Name',
                'tasker_lastname' => 'Last Name',
                'tasker_phoneno' => 'Phone Number',
                'email' => 'Email Address',
                'password' => 'Password',
                'tasker_status' => 'Tasker Status'

            ]
        );
        $path = 'profile_photos/default-profile.png';
        $taskers['tasker_photo'] = $path;
        $taskers['password'] = bcrypt($taskers['password']);

        Tasker::create($taskers);

        return redirect(route('admin-tasker-management'))->with('success', 'The Tasker account has been successfully created! Please remind the Tasker to complete their profile and update their password upon logging in.');
    }

    public function adminUpdateTasker(Request $req, $id)
    {
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
                'tasker_workingloc_state' => 'required',
                'tasker_workingloc_area' => 'required',
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
                'tasker_workingloc_state' => 'Working State',
                'tasker_workingloc_area' => 'Working Area',
                'tasker_status' => 'Status',

            ]
        );

        Tasker::whereId($id)->update($taskers);

        return redirect(route('admin-tasker-management'))->with('success', 'The Tasker details has been successfully updated !');
    }

    public function taskerUpdateProfile(Request $req, $id)
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
                    'tasker_workingloc_state' => 'required',
                    'tasker_workingloc_area' => 'required',
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
                    'tasker_workingloc_state' => 'Working State',
                    'tasker_workingloc_area' => 'Working Area',
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
                    'tasker_workingloc_state' => 'required',
                    'tasker_workingloc_area' => 'required',
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
                    'tasker_workingloc_state' => 'Working State',
                    'tasker_workingloc_area' => 'Working Area',
                    'tasker_status' => 'Status',
                    'tasker_photo' => 'Profile Photo',

                ]
            );
        }

        $ori = Tasker::whereId($id)->first();
        if ($ori->tasker_status == 0 || $ori->tasker_status == 1) {
            $taskers['tasker_status'] = 1;
            $message = 'Tasker profile has been successfully updated. Please proceed to account verification to start earning.';
        } elseif ($ori->tasker_status == 2 || $ori->tasker_status == 3 ) {
            $taskers['tasker_status'] = 2;
            $message = 'Tasker profile has been successfully updated !';
        } 
        
        Tasker::whereId($id)->update($taskers);

        return redirect(route('tasker-profile'))->with('success', $message);
    }

    public function taskerUpdatePassword(Request $req, $id)
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
            return back()->with('success', 'Password has been updated successfully !');
        } else {
            return back()->with('error', 'Please enter the correct password !');
        }
    }
}
