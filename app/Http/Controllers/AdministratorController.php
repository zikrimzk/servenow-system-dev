<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Administrator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdministratorController extends Controller
{

    public function createAdmin(Request $req)
    {

        $data = $req->validate(
            [
                'admin_code' => 'required | unique:administrators',
                'admin_firstname' => 'required | string',
                'admin_lastname' => 'required | string',
                'admin_phoneno' => 'required | min:10',
                'email' => 'required | unique:administrators',
                'admin_status' => 'required',
                'password' => 'required',
            ],
            [],
            [
                'admin_code' => 'Admin Code',
                'admin_firstname' => 'First Name',
                'admin_lastname' => 'Last Name',
                'admin_phoneno' => 'Phone Number',
                'email' => 'Email Address',
                'admin_status' => 'Account Status',
                'password' => 'Password'
            ]
        );

        $path = 'profile_photos/default-profile-admin.png';
        $data['admin_photo'] = $path;

        $data['password'] = bcrypt($data['password']);
        Administrator::create($data);

        return redirect(route('admin-management'))->with('success', 'Administrator has been registered successfully !');
    }

    public function updateAdmin(Request $req, $adminId)
    {
        try {
            $data = $req->validate(
                [
                    'admin_code' => 'required ',
                    'admin_firstname' => 'required | string',
                    'admin_lastname' => 'required | string',
                    'admin_phoneno' => 'required | min:10',
                    'email' => 'required',
                    'admin_status' => 'required',
                ],
                [],
                [
                    'admin_code' => 'Admin Code',
                    'admin_firstname' => 'First Name',
                    'admin_lastname' => 'Last Name',
                    'admin_phoneno' => 'Phone Number',
                    'email' => 'Email Address',
                    'admin_status' => 'Account Status',
                ]
            );

            Administrator::where('id', $adminId)->update($data);

            return redirect(route('admin-management'))->with('success', 'Administrator details has been updated successfully !');
        } catch (Exception $e) {
            return redirect(route('admin-management'))->with('error', 'Error : ' . $e->getMessage());
        }
    }

    public function adminUpdateProfile(Request $req, $adminId)
    {
        if ($req->isUploadPhoto == 'true') {
            $data = $req->validate(
                [
                    'admin_firstname' => 'required | string',
                    'admin_lastname' => 'required | string',
                    'admin_phoneno' => 'required | min:10',
                    'email' => 'required',
                    'admin_photo' => 'image|mimes:jpeg,png,jpg',

                ],
                [],
                [
                    'admin_firstname' => 'First Name',
                    'admin_lastname' => 'Last Name',
                    'admin_phoneno' => 'Phone Number',
                    'email' => 'Email Address',
                    'admin_status' => 'Account Status',
                    'admin_photo' => 'Profile Photo',

                ]
            );

            $user = auth()->user();

            // Generate a custom name for the file
            $file = $req->file('admin_photo');
            $filename = $user->admin_code . '_profile' . '.' . $file->getClientOriginalExtension();

            // Store the file with the custom filename
            $path = $file->storeAs('profile_photos/admins', $filename, 'public');

            // Save the file path in the database
            $data['admin_photo'] = $path;
        } else {
            $data = $req->validate(
                [
                    'admin_firstname' => 'required | string',
                    'admin_lastname' => 'required | string',
                    'admin_phoneno' => 'required | min:10',
                    'email' => 'required',

                ],
                [],
                [
                    'admin_firstname' => 'First Name',
                    'admin_lastname' => 'Last Name',
                    'admin_phoneno' => 'Phone Number',
                    'email' => 'Email Address',
                    'admin_status' => 'Account Status',

                ]
            );
        }

        Administrator::where('id', $adminId)->update($data);

        return redirect(route('admin-profile'))->with('success', 'Administrator profile has been updated successfully !');
    }

    public function adminUpdatePassword(Request $req,$id)
    {
        $validated = $req->validate([
            'oldPass' => 'required | min:8',
            'newPass' => 'required | min:8',
            'renewPass' => 'required | same:newPass',
        ],[],
        [
            'oldPass' => 'Old Password',
            'newPass' => 'New Password',
            'renewPass' => 'Comfirm Password',

        ]);
        $check = Hash::check($validated['oldPass'], Auth::user()->password, []);
        if($check)
        {
            Administrator::where('id', $id)->update(['password'=> bcrypt($validated['renewPass'])]);
            return back()->with('success','Password has been updated successfully !');
        }
        else{
            return back()->with('error','Please enter the correct password !');
        }

    }

    public function deleteAdmin($adminId) 
    {
        try {
            Administrator::where('id', $adminId)->update(['admin_status'=> 3]);
            return back()->with('success', 'Administrator account has been deactivated !');
        } catch (Exception $e) {
            return back()->with('error', 'Error : ' . $e->getMessage());
        }
    }
}
