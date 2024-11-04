<?php

namespace App\Http\Controllers;

use App\Models\Administrator;
use Exception;
use Illuminate\Http\Request;

class AdministratorController extends Controller
{

    public function loginNav()
    {
        return view('administrator.login', [
            'title' => 'Admin Dashboard'
        ]);
    }

    public function homeNav()
    {
        return view('administrator.index', [
            'title' => 'Admin Dashboard'
        ]);
    }

    public function adminManagementNav()
    {
        return view('administrator.admin.index', [
            'title' => 'Admin Management'
        ]);
    }

    public function createAdmin(Request $req)
    {
        try
        {
            $data = $req->validate([
                'admin_code' => 'required | unique:administrators',
                'admin_firstname' => 'required | string',
                'admin_lastname' => 'required | string',
                'admin_phoneno' => 'required | min:10',
                'email' => 'required | unique:administrators',
                'admin_status' => 'required',
                'admin_password' => 'required',
            ]);

            $data['admin_password'] = bcrypt($data['admin_password']);
            Administrator::create($data);

            return redirect(route('admin-management'))->with('success','Administrator has been registered successfully !');
        }
        catch(Exception $e)
        {
            return redirect(route('admin-management'))->with('error','Error : ' .$e->getMessage());
        }        
        
    }
}
