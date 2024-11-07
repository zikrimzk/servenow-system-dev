<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Tasker;
use Illuminate\Http\Request;

class TaskerController extends Controller
{
    public function createTasker(Request $req)
    {
        try
        { 
            $taskers = $req->validate([
                'tasker_firstname' => 'required|string',
                'tasker_lastname' => 'required|string',
                'tasker_phoneno' => 'required|string|min:10',
                'email' => 'required|email',
                'password' => 'required|same:cpassword|min:8|max:15',
                'cpassword' => 'required|min:8|max:15',
            ],
            [], [
                'tasker_firstname' => 'First Name',
                'tasker_lastname' => 'Last Name',
                'tasker_phoneno' => 'Phone Number',
                'email' => 'Email Address',
                'password' => 'Password',
                'cpassword' => 'Confirm Password'
            ]);

            $taskers['password'] = bcrypt( $taskers['password']);
            $taskers['tasker_code'] = 'SNT'.rand(1,10000);

            Tasker::create($taskers);

            return redirect(route('tasker-login'))->with('success','Your Tasker account has been successfully created! Please log in with your registered credentials.');

        }
        catch(Exception $e)
        {
            return redirect(route('tasker-register-form'))->with('error','Error : '.$e->getMessage());
        }
    }

    public function adminCreateTasker(Request $req)
    {
        try
        {
            $taskers = $req->validate([
                'tasker_code' => 'required',
                'tasker_firstname' => 'required|string',
                'tasker_lastname' => 'required|string',
                'tasker_phoneno' => 'required|string|min:10',
                'email' => 'required|email',
                'password' => 'required|min:8|max:15',
                'tasker_status' => 'required'
            ],
            [], [
                'tasker_code' => 'Tasker Code',
                'tasker_firstname' => 'First Name',
                'tasker_lastname' => 'Last Name',
                'tasker_phoneno' => 'Phone Number',
                'email' => 'Email Address',
                'password' => 'Password',
                'tasker_status' => 'Tasker Status'

            ]);

            $taskers['password'] = bcrypt( $taskers['password']);

            Tasker::create($taskers);

            return redirect(route('admin-tasker-management'))->with('success','The Tasker account has been successfully created! Please remind the Tasker to complete their profile and update their password upon logging in.');

        }
        catch(Exception $e)
        {
            return redirect(route('admin-tasker-management'))->with('error','Error : '.$e->getMessage());
        }
    }

    public function adminUpdateTasker(Request $req,$id)
    {
        try
        {
            $taskers = $req->validate([
                'tasker_code' => 'required',
                'tasker_firstname' => 'required|string',
                'tasker_lastname' => 'required|string',
                'tasker_phoneno' => 'required|string|min:10',
                'email' => 'required|email',
                'tasker_status' => 'required',
                'tasker_icno' => '',
                'tasker_dob' => '',
                'tasker_workingloc_state' => '',
                'tasker_workingloc_area' => '',

            ],
            [], [
                'tasker_code' => 'Tasker Code',
                'tasker_firstname' => 'First Name',
                'tasker_lastname' => 'Last Name',
                'tasker_phoneno' => 'Phone Number',
                'email' => 'Email Address',
                'tasker_status' => 'Tasker Status',
                'tasker_icno' => 'IC number',
                'tasker_dob' => 'Date of Birth',
                'tasker_workingloc_state' => 'Working State',
                'tasker_workingloc_area' => 'Working Area',

            ]);

            Tasker::whereId($id)->update($taskers);

            return redirect(route('admin-tasker-management'))->with('success','The Tasker details has been successfully updated !');

        }
        catch(Exception $e)
        {
            return redirect(route('admin-tasker-management'))->with('error','Error : '.$e->getMessage());
        }
    }
}
