<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Tasker;
use App\Models\Service;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TaskerAPIController extends Controller
{

    public function getTaskerDetail()
    {
        try {
            $data = Tasker::where('id', Auth::user()->id)->get();
            return response([
                'data' => $data
            ], 201);
        } catch (Exception $e) {
            return response([
                'message' => 'Error : ' . $e->getMessage()
            ], 301);
        }

    }
    // Tasker Update Profile
    // NOTE : API ni ada function file() untuk upload profile photo, implementation flutter tak pasti macamana 
    public function taskerUpdateProfileAPI(Request $req, $id)
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

        return response([
            'message' => $message
        ], 201);
    }

    // Tasker Update Password
    public function taskerUpdatePasswordAPI(Request $req, $id)
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
            return response([
                'message' => 'Password has been updated successfully !'
            ], 201);

        } else {
            return response([
                'message' => 'Password entered is incorrect. Please try again !'
            ], 301);
        }
    }
    
    // Create Service API
    public function createServiceAPI(Request $req)
    {
        try {
            $data = $req->validate([
                'service_rate' => 'required',
                'service_rate_type' => 'required',
                'service_type_id' => 'required',
                'service_desc' => ''

            ], [], [
                'service_rate' => 'Service Rate',
                'service_rate_type' => 'Service Rate Type',
                'service_type_id' => 'Service Type',
                'service_desc' => 'Description'
            ]);
            $data['service_status'] = 0;
            $data['tasker_id'] = Auth::user()->id;
            Service::create($data);

            return response([
                'message' => 'Your service has been successfully submitted! Please allow up to 3 business days for our administrators to review your application. We’ll notify you once it’s been processed.'
            ], 201);
           
        } catch (Exception $e) {
            return response([
                'message' => 'Error : ' . $e->getMessage()
            ], 301);
        }
    }

    public function getAllServiceType()
    {
        try {
            $servicetype = ServiceType::where('servicetype_status', 1)->get();
            return response([
                'servicetype' => $servicetype
            ], 201);
        } catch (Exception $e) {
            return response([
                'message' => 'Error : ' . $e->getMessage()
            ], 301);
        }
    }

    public function getAllServiceAPI()
    {
        try {
            $service = Service::where('tasker_id', Auth::user()->id)->get();
            return response([
                'service' => $service
            ], 201);
        } catch (Exception $e) {
            return response([
                'message' => 'Error : ' . $e->getMessage()
            ], 301);
        }
    }

    public function getSingleServiceAPI($id)
    {
        try {
            $service = Service::whereId($id)->where('tasker_id', Auth::user()->id)->first();
            return response([
                'service' => $service
            ], 201);
        } catch (Exception $e) {
            return response([
                'message' => 'Error : ' . $e->getMessage()
            ], 301);
        }
    }

    // Update Service API
    public function updateServiceAPI(Request $req, $id)
    {
        try {
           
            $data = $req->validate([
                'service_rate' => 'required',
                'service_rate_type' => 'required',
                'service_type_id' => 'required',
                'service_status' => 'required',
                'service_desc'=> ''

            ], [], [
                'service_rate' => 'Service Rate',
                'service_rate_type' => 'Service Rate Type',
                'service_type_id' => 'Service Type',
                'service_status' => 'Status',
                'service_desc'=> 'Description'

            ]);
            $oridata = Service::whereId($id)->first();
            $message = null;
            if( $oridata->service_rate != $data['service_rate'] || $oridata->service_rate_type != $data['service_rate_type'] )
            {
                $data['service_status'] = 0;
                $message = 'Your service has been successfully submitted! Please allow up to 3 business days for our administrators to review your updated application. We’ll notify you once it’s been processed.';
            }
            else
            {
                $message = 'Service details has been successfully updated !';
            }
            Service::whereId($id)->update($data);

            return response([
                'message' => $message
            ], 201);

        } catch (Exception $e) {
            return response([
                'message' => 'Error : ' . $e->getMessage()
            ], 301);
        }
    }

    // Delete Service API
    public function deleteServiceAPI($id)
    {
        try {
            Service::where('id', $id)->delete();
            return response([
                'message' => 'Service has been deleted successfully !'
            ], 201);
        } catch (Exception $e) {
            return response([
                'message' => 'Error : ' . $e->getMessage()
            ], 301);
        }
    }


    // Get State API
    public function getStateAPI()
    {
        try {
            $state = json_decode(file_get_contents(public_path('assets/json/state.json')), true);
            return response([
                'state' => $state
            ], 201);
        } catch (Exception $e) {
            return response([
                'message' => 'Error : ' . $e->getMessage()
            ], 301);
        }
    }
    
    // Get Area API
    public function getAreasAPI($state)
    {
        $states = json_decode(file_get_contents(public_path('assets/json/state.json')), true);
        $areas = [];

        foreach ($states['states'] as $item) {
            if (strtolower($item['name']) == strtolower($state)) {
                $areas = $item['areas'];
                break;
            }
        }

        return response()->json($areas);
    }


}
