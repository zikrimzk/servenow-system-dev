<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Geocoder\Geocoder;

class ClientController extends Controller
{

    protected $geocoder;

    public function __construct(Geocoder $geocoder)
    {
        $this->geocoder = $geocoder;
    }



    public function adminCreateClient(Request $req)
    {

        $clients = $req->validate(
            [
                'client_firstname' => 'required|string',
                'client_lastname' => 'required|string',
                'client_phoneno' => 'required|string|min:10|max:11',
                'email' => 'required|email|unique:clients',
                'password' => 'required|min:8',
                'client_state' => 'required',
                'client_status' => 'required',
            ],
            [],
            [
                'client_firstname' => 'First name',
                'client_lastname' => 'Last name',
                'client_phoneno' => 'Phone number',
                'email' => 'Email',
                'password' => 'Password',
                'client_state' => 'State',
                'client_status' => 'Status',
            ]
        );
        $path = 'profile_photos/default-profile.png';
        $clients['client_photo'] = $path;
        $clients['password'] = bcrypt($clients['password']);

        Client::create($clients);
        return back()->with('success', 'The Client account has been successfully created! Please remind theClient to update their password upon logging in.');
    }

    public function adminUpdateClient(Request $req, $id)
    {
        try {

            $Clients = $req->validate(
                [
                    'client_firstname' => 'required|string',
                    'client_lastname' => 'required|string',
                    'client_phoneno' => 'required|string|min:10|max:11',
                    'email' => 'required|email',
                    'client_status' => 'required',
                    'client_address_one' => '',
                    'client_address_two' => '',
                    'client_postcode' => '',
                    'client_state' => '',
                    'client_area' => '',
                ],
                [],
                [
                    'client_firstname' => 'First name',
                    'client_lastname' => 'Last name',
                    'client_phoneno' => 'Phone number',
                    'email' => 'Email',
                    'client_status' => 'Status',
                    'client_address_one' => 'Address Line 1',
                    'client_address_two' => 'Address Line 2',
                    'client_postcode' => 'Postcode',
                    'client_state' => 'State',
                    'client_area' => 'Area'
                ]
            );

            Client::whereId($id)->update($Clients);

            return back()->with('success', 'The Client details has been successfully updated !');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function adminDeleteClient($id)
    {
        try {
            Client::where('id', $id)->update(['client_status' => 4]);
            return back()->with('success', 'Client account has been deactivated !');
        } catch (Exception $e) {
            return back()->with('error', 'Error : ' . $e->getMessage());
        }
    }
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

    public function clientUpdateAddress(Request $req, $id)
    {
        // Validate Data
        $validated = $req->validate(
            [
                'client_address_one' => 'required|string',
                'client_address_two' => 'required|string',
                'client_postcode' => 'required|string',
                'client_state' => 'required|string',
                'client_area' => 'required|string',
            ],
            [],
            [
                'client_address_one' => 'Address Line 1',
                'client_address_two' => 'Address Line 2',
                'client_postcode' => 'required|string',
                'client_state' => 'State',
                'client_area' => 'City'
            ]
        );

        try {

            $address = $validated['client_address_one'] . ',' . $validated['client_address_two'] . ',' . $validated['client_area'] . ',' . $validated['client_postcode'] . ',' . $validated['client_state'];
            $result = $this->geocoder->getCoordinatesForAddress($address);
            $validated['latitude'] = $result['lat'];
            $validated['longitude'] = $result['lng'];
            //Address Update 
            Client::where('id', $id)->update([
                'client_address_one' => $validated['client_address_one'],
                'client_address_two' => $validated['client_address_two'],
                'client_postcode' => $validated['client_postcode'],
                'client_state' => $validated['client_state'],
                'client_area' => $validated['client_area'],
                'latitude'=>$validated['latitude'],
                'longitude'=>$validated['longitude']
            ]);

            // Suceess Update Address
            return back()->with('success', 'Address was successfully updated!');
        } catch (\Exception $e) {
            // Failde Update address
            return back()->with('error', 'Address not updated: ' . $e->getMessage());
        }
    }
}
