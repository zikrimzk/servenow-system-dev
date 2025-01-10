<?php

namespace App\Http\Controllers;

use App\Mail\ServiceApplicationNotification;
use Exception;
use Carbon\Carbon;
use App\Models\Service;
use App\Models\ServiceType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\TaskerServiceApproved;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ServiceController extends Controller
{

    // Admin - Service Type Start
    public function createServiceType(Request $req)
    {
        $data = $req->validate([
            'servicetype_name' => 'required|string',
            'servicetype_desc' => '',
            'servicetype_status' => 'required'

        ], [], [
            'servicetype_name' => 'Type Name',
            'servicetype_desc' => 'Description',
            'servicetype_status' => 'Status'
        ]);

        ServiceType::create($data);
        return redirect(route('admin-service-type-management'))->with('success', 'Service type has been added successfully !');
    }

    public function updateServiceType(Request $req, $id)
    {
        try {
            $data = $req->validate([
                'servicetype_name' => 'required|string',
                'servicetype_desc' => '',
                'servicetype_status' => 'required'

            ], [], [
                'servicetype_name' => 'Type Name',
                'servicetype_desc' => 'Description',
                'servicetype_status' => 'Status'
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


    //Tasker - Create Service
    // Check by : Zikri (10/01/2025)
    public function createService(Request $req)
    {
        $servicetype = ServiceType::where('id', $req->service_type_id)->first();
        $check = Service::where('tasker_id', Auth::user()->id)->where('service_type_id', $req->service_type_id)->where('service_status', '!=', 4)->exists();
        if (!$check) {
            $data = $req->validate([
                'service_rate' => 'required',
                'service_rate_type' => 'required',
                'service_type_id' => 'required',
                'service_desc' => 'required'

            ], [], [
                'service_rate' => 'Service Rate',
                'service_rate_type' => 'Service Rate Type',
                'service_type_id' => 'Service Type',
                'service_desc' => 'Description'
            ]);
            $data['service_status'] = 0;
            $data['tasker_id'] = Auth::user()->id;
            Service::create($data);

            $servicetype = ServiceType::where('id', $req->service_type_id)->first();

            Mail::to(Auth::user()->email)->send(new ServiceApplicationNotification([
                'name' => Str::headline(Auth::user()->tasker_firstname . ' ' . Auth::user()->tasker_lastname),
                'service_name' => $servicetype->servicetype_name,
                'date' => Carbon::now()->format('d F Y g:i A'),
                'service_rate' =>  $data['service_rate'],
                'service_rate_type' => $data['service_rate_type'],
                'service_desc' => $data['service_desc'],
                'service_status' => $data['service_status']
            ]));

            return back()->with('success', 'Your service has been successfully submitted! Please allow up to 3 business days for our administrators to review your application. We’ll notify you once it’s been processed.');
        } else {
            return back()->with('error', 'You have already submitted the application for these services. Please submit a new application for different services.');
        }
    }

    //Tasker - Update Service
    // Check by : Zikri (10/01/2025)
    public function updateService(Request $req, $id)
    {
        try {

            $data = $req->validate([
                'service_rate' => 'required',
                'service_rate_type' => 'required',
                'service_type_id' => 'required',
                'service_status' => 'required',
                'service_desc' => 'required'

            ], [], [
                'service_rate' => 'Service Rate',
                'service_rate_type' => 'Service Rate Type',
                'service_type_id' => 'Service Type',
                'service_status' => 'Status',
                'service_desc' => 'Description'

            ]);
            $oridata = Service::whereId($id)->first();
            $message = null;
            if ($oridata->service_rate != $data['service_rate'] || $oridata->service_rate_type != $data['service_rate_type']) {
                $data['service_status'] = 0;
                $servicetype = ServiceType::where('id', $req->service_type_id)->first();

                Mail::to(Auth::user()->email)->send(new ServiceApplicationNotification([
                    'name' => Str::headline(Auth::user()->tasker_firstname . ' ' . Auth::user()->tasker_lastname),
                    'service_name' => $servicetype->servicetype_name,
                    'date' => Carbon::now()->format('d F Y g:i A'),
                    'service_rate' =>  $data['service_rate'],
                    'service_rate_type' => $data['service_rate_type'],
                    'service_desc' => $data['service_desc'],
                    'service_status' => $data['service_status']
                ]));

                $message = 'Your service has been successfully submitted! Please allow up to 3 business days for our administrators to review your updated application. We’ll notify you once it’s been processed.';
            } else {
                $message = 'Service details has been successfully updated !';
            }
            Service::whereId($id)->update($data);
            return back()->with('success', $message);
        } catch (Exception $e) {
            return back()->with('error', 'Error : ' . $e->getMessage());
        }
    }

    //Tasker - Remove Service
    // Check by : Zikri (10/01/2025)
    public function deleteService($id)
    {
        try {
            Service::where('id', $id)->delete();
            return back()->with('success', 'Service has been deleted successfully !');
        } catch (Exception $e) {
            return back()->with('error', 'The operation cannot be completed as it is restricted. You may only change the status to "Inactive".');
        }
    }

    //Tasker - Service Management End


    // Admin - Service Management Start

    public function adminApproveService($id)
    {
        try {
            Service::where('id', $id)->update(['service_status' => 1]);

            $datas = DB::table('taskers as a')
                ->join('services as b', 'a.id', '=', 'b.tasker_id')
                ->join('service_types as c', 'b.service_type_id', '=', 'c.id')
                ->where('b.id', '=', $id)
                ->get();


            foreach ($datas as $data) {
                Mail::to($data->email)->send(new TaskerServiceApproved([
                    'name' => Str::headline($data->tasker_firstname . ' ' . $data->tasker_lastname),
                    'service_name' => $data->servicetype_name,
                    'approval_date' => Carbon::now()->format('d F Y g:i A'),
                    'service_rate' => $data->service_rate,
                    'service_rate_type' => $data->service_rate_type,
                    'service_desc' => $data->service_desc,
                    'service_status' => $data->service_status
                ]));
            }

            return redirect(route('admin-service-management'))->with('success', 'Service has been approved !');
        } catch (Exception $e) {
            return redirect(route('admin-service-management'))->with('error', 'Error : ' . $e->getMessage());
        }
    }

    public function adminApproveMultipleService(Request $request)
    {
        try {
            $seviceIds = $request->input('selected_service');

            Service::whereIn('id', $seviceIds)->update(['service_status' => 1]);

            $datas = DB::table('taskers as a')
                ->join('services as b', 'a.id', '=', 'b.tasker_id')
                ->join('service_types as c', 'b.service_type_id', '=', 'c.id')
                ->whereIn('b.id', $seviceIds)
                ->get();


            foreach ($datas as $data) {
                Mail::to($data->email)->send(new TaskerServiceApproved([
                    'name' => Str::headline($data->tasker_firstname . ' ' . $data->tasker_lastname),
                    'service_name' => $data->servicetype_name,
                    'approval_date' => Carbon::now()->format('d F Y g:i A'),
                    'service_rate' => $data->service_rate,
                    'service_rate_type' => $data->service_rate_type,
                    'service_desc' => $data->service_desc,
                    'service_status' => $data->service_status
                ]));
            }
            return response()->json(['success' => 'All selected services has been approved !', 'service' => $seviceIds]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error : ' . $e->getMessage()]);
        }
    }

    public function adminRejectService($id)
    {
        try {
            Service::where('id', $id)->update(['service_status' => 3]);

            $datas = DB::table('taskers as a')
                ->join('services as b', 'a.id', '=', 'b.tasker_id')
                ->join('service_types as c', 'b.service_type_id', '=', 'c.id')
                ->where('b.id', '=', $id)
                ->get();

            foreach ($datas as $data) {
                Mail::to($data->email)->send(new TaskerServiceApproved([
                    'name' => Str::headline($data->tasker_firstname . ' ' . $data->tasker_lastname),
                    'service_name' => $data->servicetype_name,
                    'approval_date' => Carbon::now()->format('d F Y g:i A'),
                    'service_rate' => $data->service_rate,
                    'service_rate_type' => $data->service_rate_type,
                    'service_desc' => $data->service_desc,
                    'service_status' => $data->service_status
                ]));
            }
            return redirect(route('admin-service-management'))->with('success', 'Service has been rejected !');
        } catch (Exception $e) {
            return redirect(route('admin-service-management'))->with('error', 'Error : ' . $e->getMessage());
        }
    }

    public function adminRejectMultipleService(Request $request)
    {
        try {
            $seviceIds = $request->input('selected_service');

            Service::whereIn('id', $seviceIds)->update(['service_status' => 3]);

            $datas = DB::table('taskers as a')
                ->join('services as b', 'a.id', '=', 'b.tasker_id')
                ->join('service_types as c', 'b.service_type_id', '=', 'c.id')
                ->whereIn('b.id', $seviceIds)
                ->get();


            foreach ($datas as $data) {
                Mail::to($data->email)->send(new TaskerServiceApproved([
                    'name' => Str::headline($data->tasker_firstname . ' ' . $data->tasker_lastname),
                    'service_name' => $data->servicetype_name,
                    'approval_date' => Carbon::now()->format('d F Y g:i A'),
                    'service_rate' => $data->service_rate,
                    'service_rate_type' => $data->service_rate_type,
                    'service_desc' => $data->service_desc,
                    'service_status' => $data->service_status
                ]));
            }

            return response()->json(['success' => 'All selected services has been rejected !', 'service' => $seviceIds]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error : ' . $e->getMessage()]);
        }
    }

    public function adminTerminateService($id)
    {
        try {
            Service::where('id', $id)->update(['service_status' => 4]);

            $datas = DB::table('taskers as a')
                ->join('services as b', 'a.id', '=', 'b.tasker_id')
                ->join('service_types as c', 'b.service_type_id', '=', 'c.id')
                ->where('b.id', '=', $id)
                ->get();

            foreach ($datas as $data) {
                Mail::to($data->email)->send(new TaskerServiceApproved([
                    'name' => Str::headline($data->tasker_firstname . ' ' . $data->tasker_lastname),
                    'service_name' => $data->servicetype_name,
                    'approval_date' => Carbon::now()->format('d F Y g:i A'),
                    'service_rate' => $data->service_rate,
                    'service_rate_type' => $data->service_rate_type,
                    'service_desc' => $data->service_desc,
                    'service_status' => $data->service_status
                ]));
            }

            return redirect(route('admin-service-management'))->with('success', 'Service has been terminated !');
        } catch (Exception $e) {
            return redirect(route('admin-service-management'))->with('error', 'Error : ' . $e->getMessage());
        }
    }

    public function adminTerminateMultipleService(Request $request)
    {
        try {
            $seviceIds = $request->input('selected_service');
            Service::whereIn('id', $seviceIds)->update(['service_status' => 4]);

            $datas = DB::table('taskers as a')
                ->join('services as b', 'a.id', '=', 'b.tasker_id')
                ->join('service_types as c', 'b.service_type_id', '=', 'c.id')
                ->whereIn('b.id', $seviceIds)
                ->get();

            foreach ($datas as $data) {
                Mail::to($data->email)->send(new TaskerServiceApproved([
                    'name' => Str::headline($data->tasker_firstname . ' ' . $data->tasker_lastname),
                    'service_name' => $data->servicetype_name,
                    'approval_date' => Carbon::now()->format('d F Y g:i A'),
                    'service_rate' => $data->service_rate,
                    'service_rate_type' => $data->service_rate_type,
                    'service_desc' => $data->service_desc,
                    'service_status' => $data->service_status
                ]));
            }
            return response()->json(['success' => 'All selected services has been terminated !', 'service' => $seviceIds]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error : ' . $e->getMessage()]);
        }
    }
}
