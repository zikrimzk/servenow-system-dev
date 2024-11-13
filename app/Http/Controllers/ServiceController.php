<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Service;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{

    // Admin - Service Type Start
    public function createServiceType(Request $req)
    {
        try {
            $data = $req->validate([
                'servicetype_name' => 'required|string',
                'servicetype_desc' => 'string',
                'servicetype_status' => 'required'

            ]);

            ServiceType::create($data);
            return redirect(route('admin-service-type-management'))->with('success', 'Service type has been added successfully !');
        } catch (Exception $e) {
            return redirect(route('admin-service-type-management'))->with('error', 'Error : ' . $e->getMessage());
        }
    }

    public function updateServiceType(Request $req, $id)
    {
        try {
            $data = $req->validate([
                'servicetype_name' => 'required|string',
                'servicetype_desc' => 'string',
                'servicetype_status' => 'required'
            ]);

            ServiceType::whereId($id)->update($data);
            return redirect(route('admin-service-type-management'))->with('success', 'Service type has been updated successfully !');
        } catch (Exception $e) {
            return redirect(route('admin-service-type-management'))->with('error', 'Error : ' . $e->getMessage());
        }
    }

    public function deleteServiceType($id)
    {
        try {
            ServiceType::where('id', $id)->delete();
            return redirect(route('admin-service-type-management'))->with('success', 'Service type has been deleted successfully !');
        } catch (Exception $e) {
            return redirect(route('admin-service-type-management'))->with('error', 'Error : ' . $e->getMessage());
        }
    }
    // Admin - Service Type End


    //Tasker - Service Management Start

    public function createService(Request $req)
    {
        try {
            $data = $req->validate([
                'service_rate' => 'required',
                'service_rate_type' => 'required',
                'service_type_id' => 'required',
                'service_desc'=> ''
                
            ], [], [
                'service_rate' => 'Service Rate',
                'service_rate_type' => 'Service Rate Type',
                'service_type_id' => 'Service Type',
                'service_desc'=> 'Description'
            ]);
            $data['service_status'] = 0;
            $data['tasker_id'] = Auth::user()->id;
            Service::create($data);
            return redirect(route('tasker-service-management'))->with('success', 'Your service has been successfully submitted! Please allow up to 3 business days for our administrators to review your application. We’ll notify you once it’s been processed.');
        } catch (Exception $e) {
            return redirect(route('tasker-service-management'))->with('error', 'Error : ' . $e->getMessage());
        }
    }

    public function updateService(Request $req, $id)
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
            return redirect(route('tasker-service-management'))->with('success', $message);
        } catch (Exception $e) {
            return redirect(route('tasker-service-management'))->with('error', 'Error : ' . $e->getMessage());
        }
    }

    public function deleteService($id)
    {
        try {
            Service::where('id', $id)->delete();
            return redirect(route('tasker-service-management'))->with('success', 'Service has been deleted successfully !');
        } catch (Exception $e) {
            return redirect(route('tasker-service-management'))->with('error', 'Error : ' . $e->getMessage());
        }
    }

    //Tasker - Service Management End


    // Admin - Service Management Start

    public function adminApproveService($id)
    {
        try
        {
            Service::where('id',$id)->update(['service_status'=> 1]);
            return redirect(route('admin-service-management'))->with('success', 'Service has been approved !');

        }
        catch(Exception $e)
        {
            return redirect(route('admin-service-management'))->with('error', 'Error : ' . $e->getMessage());
        }

    }

    public function adminRejectService($id)
    {
        try
        {
            Service::where('id',$id)->update(['service_status'=> 3]);
            return redirect(route('admin-service-management'))->with('success', 'Service has been terminated !');
        }
        catch(Exception $e)
        {
            return redirect(route('admin-service-management'))->with('error', 'Error : ' . $e->getMessage());
        }

    }

    public function adminTerminateService($id)
    {
        try
        {
            Service::where('id',$id)->update(['service_status'=> 4]);
            return redirect(route('admin-service-management'))->with('success', 'Service has been terminated !');
        }
        catch(Exception $e)
        {
            return redirect(route('admin-service-management'))->with('error', 'Error : ' . $e->getMessage());
        }

    }

}
