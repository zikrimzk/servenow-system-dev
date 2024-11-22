<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    //Client Function Here ...
    public function createClient(Request $req)
    {
        $client = $req->validate(
            [
                'client_firstname' => 'required|string',
                'client_lastname' => 'required|string',
                'client_phoneno' => 'required|string|min:10|max:11',
                'email' => 'required|email|unique:clients',
                'password' => 'required|same:cpassword|min:8',
                'cpassword' => 'required|min:8',
                'client_state' => 'required',
            ],
            [],
            [
                'client_firstname' => 'First name',
                'client_lastname' => 'Last name',
                'client_phoneno' => 'Phone number',
                'email' => 'Email',
                'password' => 'Password',
                'cpassword' => 'Confirm password',
                'client_state' => 'State',

            ]
        );

        $client['password'] = bcrypt($client['password']);
        $path = 'profile_photos/default-profile.png';
        $client['client_photo'] = $path;
        Client::create($client);

        return redirect(route('client-login'))->with('success', 'Your account has been successfully created! Please log in with your registered credentials.');
    }

    //Client Update Info
    public function clientUpdateProfile(Request $req, $clientId)
    {
        // dd($req);

        if ($req->isUploadPhoto == 'true') {
            $data = $req->validate(
                [
                    'client_firstname' => 'required | string',
                    'client_lastname' => 'required | string',
                    'client_phoneno' => 'required | min:10',
                    'email' => 'required',
                    'client_photo' => 'image|mimes:jpeg,png,jpg',

                ],
                [],
                [
                    'client_firstname' => 'First Name',
                    'client_lastname' => 'Last Name',
                    'client_phoneno' => 'Phone Number',
                    'email' => 'Email Address',
                    'client_status' => 'Account Status',
                    'client_photo' => 'Profile Photo',

                ]
            );

            $user = auth()->user();

            // Generate a custom name for the file
            $file = $req->file('client_photo');
            $filename = $user->id . '_profile' . '.' . $file->getClientOriginalExtension();

            // Store the file with the custom filename
            $path = $file->storeAs('profile_photos/clients', $filename, 'public');

            // Save the file path in the database
            $data['client_photo'] = $path;
        } else {
            $data = $req->validate(
                [
                    'client_firstname' => 'required | string',
                    'client_lastname' => 'required | string',
                    'client_phoneno' => 'required | min:10',
                    'email' => 'required',

                ],
                [],
                [
                    'client_firstname' => 'First Name',
                    'client_lastname' => 'Last Name',
                    'client_phoneno' => 'Phone Number',
                    'email' => 'Email Address',
                    'client_status' => 'Account Status',

                ]
            );
        }

        Client::where('id', $clientId)->update($data);

        return redirect(route('client-profile'))->with('success', 'Client profile has been updated successfully !');
    }

    public function clientUpdatePassword(Request $req, $id)
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
            Client::where('id', $id)->update(['password' => bcrypt($validated['renewPass'])]);
            return back()->with('success', 'Password has been updated successfully !');
        } else {
            return back()->with('error', 'Please enter the correct password !');
        }
    }
}
