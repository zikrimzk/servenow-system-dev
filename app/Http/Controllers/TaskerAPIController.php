<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskerAPIController extends Controller
{

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
}
