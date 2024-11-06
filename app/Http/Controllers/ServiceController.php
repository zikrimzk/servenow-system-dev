<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\ServiceType;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function createServiceType(Request $req)
    {
        try
        {
            $data = $req->validate([
                'servicetype_name'=>'required|string',
                'servicetype_desc'=>'string',
                'servicetype_status'=>'required'

            ]);

            ServiceType::create($data);
            return redirect(route('admin-service-type-management'))->with('success', 'Service type has been added successfully !');
        }
        catch(Exception $e)
        {
            return redirect(route('admin-service-type-management'))->with('error', 'Error : ' . $e->getMessage());
        }
    }

    public function updateServiceType(Request $req,$id)
    {
        try
        {
            $data = $req->validate([
                'servicetype_name'=>'required|string',
                'servicetype_desc'=>'string',
                'servicetype_status'=>'required'
            ]);

            ServiceType::whereId($id)->update($data);
            return redirect(route('admin-service-type-management'))->with('success', 'Service type has been updated successfully !');
        }
        catch(Exception $e)
        {
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
}
