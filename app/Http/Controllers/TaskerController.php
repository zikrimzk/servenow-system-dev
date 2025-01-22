<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Tasker;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\Geocoder\Geocoder;
use App\Mail\AuthenticateMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;

class TaskerController extends Controller
{

    protected $geocoder;

    public function __construct(Geocoder $geocoder)
    {
        $this->geocoder = $geocoder;
    }

    private function sendAccountNotification($data, $userType, $option, $link)
    {
        // Users Name
        if ($userType == 1) {
            $name = $data->admin_firstname . ' ' . $data->admin_lastname;
        } elseif ($userType == 2) {
            $name = $data->tasker_firstname . ' ' . $data->tasker_lastname;
        } elseif ($userType == 3) {
            $name = $data->client_firstname . ' ' . $data->client_lastname;
        }

        Mail::to($data->email)->send(new AuthenticateMail([
            'users' => $userType,
            'name' => Str::headline($name),
            'date' => Carbon::now()->format('d F Y g:i A'),
            'option' => $option,
            'link' => $link

        ]));
    }


    public function createTasker(Request $req)
    {
        $taskers = $req->validate(
            [
                'tasker_firstname' => 'required|string',
                'tasker_lastname' => 'required|string',
                'tasker_phoneno' => 'required|string|min:10',
                'email' => 'required|email|unique:taskers',
                'password' => 'required|same:cpassword|min:8',
                'cpassword' => 'required|min:8',
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

        //Send Email Verification Link
        $data = Tasker::where('email', $taskers['email'])->first();
        $verifyLink = route('user-verify-email', ['option' => 2, 'email' => Crypt::encrypt($data->email)]);
        $this->sendAccountNotification($data, 2, 1, $verifyLink);

        return redirect(route('tasker-login'))->with('success', 'Your Tasker account has been successfully created! Please check your email to verify and activate your account.');
    }

    public function adminCreateTasker(Request $req)
    {

        $taskers = $req->validate(
            [
                'tasker_code' => 'required',
                'tasker_firstname' => 'required|string',
                'tasker_lastname' => 'required|string',
                'tasker_phoneno' => 'required|string|min:10',
                'email' => 'required|email|unique:taskers',
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

        //Send Email Verification Link
        $data = Tasker::where('email', $taskers['email'])->first();
        $verifyLink = route('user-verify-email', ['option' => 2, 'email' => Crypt::encrypt($data->email)]);
        $this->sendAccountNotification($data, 2, 1, $verifyLink);

        return redirect(route('admin-tasker-management'))->with('success', 'The Tasker account has been successfully created! Please remind the Tasker to verify their email, complete their profile and update their password upon logging in.');
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
                'tasker_icno' => '',
                'tasker_dob' => '',
                'tasker_address_one' => '',
                'tasker_address_two' => '',
                'tasker_address_poscode' => '',
                'tasker_address_state' => '',
                'tasker_address_area' => '',
                'tasker_workingloc_state' => '',
                'tasker_workingloc_area' => '',
                'working_radius' => '',
                'tasker_account_bank' => '',
                'tasker_account_number' => '',
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
                'working_radius' => 'Working Radius',
                'tasker_account_bank' => 'Account Bank',
                'tasker_account_number' => 'Account Number',
                'tasker_status' => 'Status',

            ]
        );

        $ori = Tasker::whereId($id)->first();

        if ($ori->tasker_workingloc_state != $taskers['tasker_workingloc_state'] || $ori->tasker_workingloc_area != $taskers['tasker_workingloc_area']) {
            $address = $taskers['tasker_workingloc_area'] . ',' . $taskers['tasker_workingloc_state'];
            $result = $this->geocoder->getCoordinatesForAddress($address);
            $taskers['latitude'] = $result['lat'];
            $taskers['longitude'] = $result['lng'];
        }


        Tasker::whereId($id)->update($taskers);

        return redirect(route('admin-tasker-management'))->with('success', 'The Tasker details has been successfully updated !');
    }


    public function updateMultipleTaskerStatus(Request $req)
    {
        try {
            $taskerIds = $req->input('selected_tasker');
            $updatedStatus = $req->input('tasker_status');

            Tasker::whereIn('id', $taskerIds)->update(['tasker_status' => $updatedStatus]);

            return response()->json([
                'message' => 'All selected tasker status has been updated successfully !',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Oops! Something went wrong. Please try again later.',
            ]);
        }
    }

    // Tasker e-KYC Process 1
    // Check by : Zikri (12/01/2025)
    public function taskerCardVerification($data)
    {
        return view('ekyc.card-verification', [
            'title' => 'Card Verification',
            'data' => $data
        ]);
    }

    // Tasker e-KYC Process 2
    // Check by : Zikri (12/01/2025)
    public function taskerFaceVerification()
    {
        return view('ekyc.face-verification', [
            'title' => 'Face Verification'
        ]);
    }

    // Tasker e-KYC Process 3
    // Check by : Zikri (12/01/2025)
    public function verificationSuccess(Request $request)
    {
        try {
            $idno = $request->query('idno');
            $idno = str_replace('-', '', $idno);
            $userData = Tasker::where('tasker_icno', $idno)->update(['tasker_status' => 2]);
            return redirect(route('tasker-profile'))->with('success', 'Verification has been successfully completed. Please set up your task preferences at Task Preferences > Preferences.');
        } catch (Exception) {
            return back()->with('error', 'Something went wrong !');
        }
    }

    // Tasker Update Profile [Personal Details]
    // Check by : Zikri (12/01/2025)
    public function taskerUpdateProfilePersonal(Request $req)
    {
        // Set the active tab to Bank Details (profile-1) in the session
        session()->flash('active_tab', 'profile-1');

        // Validate the request
        if ($req->isUploadPhoto == 'true') {
            $taskers = $req->validate(
                [
                    'tasker_photo' => 'required|image|mimes:jpeg,png,jpg',
                    'tasker_firstname' => 'required|string',
                    'tasker_lastname' => 'required|string',
                    'tasker_phoneno' => 'required|string|min:10',
                    'email' => 'required|email',
                    'tasker_bio' => '',
                    'tasker_icno' => 'required',
                    'tasker_dob' => 'required',
                    'tasker_status' => '',

                ],
                [],
                [
                    'tasker_photo' => 'Profile Photo',
                    'tasker_firstname' => 'First Name',
                    'tasker_lastname' => 'Last Name',
                    'tasker_phoneno' => 'Phone Number',
                    'email' => 'Email Address',
                    'tasker_bio' => 'Tasker Bio',
                    'tasker_icno' => 'IC number',
                    'tasker_dob' => 'Date of Birth',
                    'tasker_status' => 'Status',
                ]
            );
            $user = Auth::user();

            // Generate a custom name for the file
            $file = $req->file('tasker_photo');
            $filename = time() . '_' . $user->tasker_code . '_profile' . '.' . $file->getClientOriginalExtension();

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
                    'tasker_status' => '',

                ],
                [],
                [
                    'tasker_firstname' => 'First Name',
                    'tasker_lastname' => 'Last Name',
                    'tasker_phoneno' => 'Phone Number',
                    'email' => 'Email Address',
                    'tasker_bio' => 'Tasker Bio',
                    'tasker_icno' => 'IC number',
                    'tasker_dob' => 'Date of Birth',
                    'tasker_status' => 'Status',
                ]
            );
        }

        Tasker::whereId(Auth::user()->id)->update($taskers);
        $ori = Tasker::whereId(Auth::user()->id)->first();

        if (
            $ori->tasker_firstname != null &&
            $ori->tasker_lastname != null &&
            $ori->tasker_phoneno != null &&
            $ori->email != null &&
            $ori->tasker_icno != null &&
            $ori->tasker_dob != null &&
            $ori->tasker_address_one != null &&
            $ori->tasker_address_two != null &&
            $ori->tasker_address_poscode != null &&
            $ori->tasker_address_state != null &&
            $ori->tasker_address_area != null &&
            $ori->tasker_account_bank != null &&
            $ori->tasker_account_number != null &&
            $ori->tasker_status == 0
        ) {
            $taskers['tasker_status'] = 1;
            $message = 'Tasker profile has been successfully updated. Please proceed to account verification to start earning.';
            Tasker::whereId(Auth::user()->id)->update($taskers);
        } else {
            $message = 'Tasker personal details have been successfully updated!';
        }


        return back()->with('success', $message);
    }

    // Tasker Update Profile [Address]
    // Check by : Zikri (12/01/2025)
    public function taskerUpdateProfileAddress(Request $req)
    {
        // Set the active tab to Bank Details (profile-1) in the session
        session()->flash('active_tab', 'profile-2');

        // Validate the request
        $taskers = $req->validate(
            [
                'tasker_address_one' => 'required',
                'tasker_address_two' => 'required',
                'tasker_address_poscode' => 'required',
                'tasker_address_state' => 'required',
                'tasker_address_area' => 'required',
            ],
            [],
            [
                'tasker_address_one' => 'Address Line 1',
                'tasker_address_two' => 'Address Line 2',
                'tasker_address_poscode' => 'Postal Code',
                'tasker_address_state' => 'State',
                'tasker_address_area' => 'Area',
            ]
        );
        Tasker::whereId(Auth::user()->id)->update($taskers);

        $ori = Tasker::whereId(Auth::user()->id)->first();

        if (
            $ori->tasker_firstname != null &&
            $ori->tasker_lastname != null &&
            $ori->tasker_phoneno != null &&
            $ori->email != null &&
            $ori->tasker_icno != null &&
            $ori->tasker_dob != null &&
            $ori->tasker_address_one != null &&
            $ori->tasker_address_two != null &&
            $ori->tasker_address_poscode != null &&
            $ori->tasker_address_state != null &&
            $ori->tasker_address_area != null &&
            $ori->tasker_account_bank != null &&
            $ori->tasker_account_number != null &&
            $ori->tasker_status == 0
        ) {
            $taskers['tasker_status'] = 1;
            $message = 'Tasker profile has been successfully updated. Please proceed to account verification to start earning.';
            Tasker::whereId(Auth::user()->id)->update($taskers);
            // Set the active tab to Bank Details (profile-3) in the session
            session()->flash('active_tab', 'profile-1');
        } else {
            $message = 'Tasker address has been successfully updated !';
        }

        return back()->with('success', $message);
    }

    // Tasker Update Profile [Bank Details]
    // Check by : Zikri (12/01/2025)
    public function taskerUpdateProfileBank(Request $req)
    {
        // Set the active tab to Bank Details (profile-3) in the session
        session()->flash('active_tab', 'profile-3');

        // Validate the request
        $taskers = $req->validate(
            [
                'tasker_account_bank' => 'required',
                'tasker_account_number' => 'required|numeric',
            ],
            [],
            [
                'tasker_account_bank' => 'Bank Name',
                'tasker_account_number' => 'Account Number',
            ]
        );

        Tasker::whereId(Auth::user()->id)->update($taskers);

        $ori = Tasker::whereId(Auth::user()->id)->first();

        // Check if all fields are filled and update status
        if (
            $ori->tasker_firstname != null &&
            $ori->tasker_lastname != null &&
            $ori->tasker_phoneno != null &&
            $ori->email != null &&
            $ori->tasker_icno != null &&
            $ori->tasker_dob != null &&
            $ori->tasker_address_one != null &&
            $ori->tasker_address_two != null &&
            $ori->tasker_address_poscode != null &&
            $ori->tasker_address_state != null &&
            $ori->tasker_address_area != null &&
            $ori->tasker_account_bank != null &&
            $ori->tasker_account_number != null &&
            $ori->tasker_status == 0
        ) {
            $taskers['tasker_status'] = 1;
            $message = 'Tasker profile has been successfully updated. Please proceed to account verification to start earning.';
            Tasker::whereId(Auth::user()->id)->update($taskers);
            // Set the active tab to Bank Details (profile-3) in the session
            session()->flash('active_tab', 'profile-1');
        } else {
            $message = 'Tasker bank details have been successfully updated!';
        }

        // Return back with success message
        return back()->with('success', $message);
    }

    // Tasker Update Password
    // Check by : Zikri (12/01/2025)
    public function taskerUpdatePassword(Request $req, $id)
    {
        // Set the active tab to Bank Details (profile-4) in the session
        session()->flash('active_tab', 'profile-4');

        // Validate the request
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

    // Tasker Update Working Location
    // Check by : Zikri (10/01/2025)
    public function taskerUpdateLocation(Request $req, $id)
    {
        $taskers = $req->validate(
            [
                'tasker_workingloc_state' => 'required',
                'tasker_workingloc_area' => 'required',
                'working_radius' => 'required',

            ],
            [],
            [
                'tasker_workingloc_state' => 'Working State',
                'tasker_workingloc_area' => 'Working Area',
                'working_radius' => 'Working Radius'
            ]
        );


        $address = $taskers['tasker_workingloc_area'] . ',' . $taskers['tasker_workingloc_state'];
        $result = $this->geocoder->getCoordinatesForAddress($address);
        $taskers['latitude'] = $result['lat'];
        $taskers['longitude'] = $result['lng'];
        Tasker::whereId($id)->update($taskers);
        return back()->with('success', 'Tasker location have been saved !');
    }
}
