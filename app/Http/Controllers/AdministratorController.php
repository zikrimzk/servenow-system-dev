<?php

namespace App\Http\Controllers;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Administrator;

class AdministratorController extends Controller
{

    public function createAdmin(Request $req)
    {
        try {
            $data = $req->validate([
                'admin_code' => 'required | unique:administrators',
                'admin_firstname' => 'required | string',
                'admin_lastname' => 'required | string',
                'admin_phoneno' => 'required | min:10',
                'email' => 'required | unique:administrators',
                'admin_status' => 'required',
                'admin_password' => 'required',
            ],[], 
            [
                'admin_code'=> 'Admin Code',
                'admin_firstname' => 'First Name',
                'admin_lastname' => 'Last Name',
                'admin_phoneno' => 'Phone Number',
                'email' => 'Email Address',
                'admin_status' => 'Account Status',
                'admin_password' => 'Password'
            ]);
            
            $data['admin_firstname'] = Str::upper($data['admin_firstname']);
            $data['admin_lastname'] = Str::upper($data['admin_lastname']);
            $data['admin_password'] = bcrypt($data['admin_password']);
            Administrator::create($data);

            return redirect(route('admin-management'))->with('success', 'Administrator has been registered successfully !');
        } catch (Exception $e) {
            return redirect(route('admin-management'))->with('error', 'Error : ' . $e->getMessage());
        }
    }

    public function updateAdmin(Request $req, $adminId)
    {
        try {
            $data = $req->validate([
                'admin_code' => 'required ',
                'admin_firstname' => 'required | string',
                'admin_lastname' => 'required | string',
                'admin_phoneno' => 'required | min:10',
                'email' => 'required',
                'admin_status' => 'required',
            ],[], 
            [
                'admin_code'=> 'Admin Code',
                'admin_firstname' => 'First Name',
                'admin_lastname' => 'Last Name',
                'admin_phoneno' => 'Phone Number',
                'email' => 'Email Address',
                'admin_status' => 'Account Status',
            ]);

            $data['admin_firstname'] = Str::upper($data['admin_firstname']);
            $data['admin_lastname'] = Str::upper($data['admin_lastname']);
            Administrator::where('id', $adminId)->update($data);

            return redirect(route('admin-management'))->with('success', 'Administrator details has been updated successfully !');
        } catch (Exception $e) {
            return redirect(route('admin-management'))->with('error', 'Error : ' . $e->getMessage());
        }
    }


    public function deleteAdmin($adminId)
    {
        try {
            Administrator::where('id', $adminId)->delete();
            return redirect(route('admin-management'))->with('success', 'Administrator has been deleted successfully !');
        } catch (Exception $e) {
            return redirect(route('admin-management'))->with('error', 'Error : ' . $e->getMessage());
        }
    }
}
