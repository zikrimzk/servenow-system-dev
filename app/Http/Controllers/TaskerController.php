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
                'tasker_email' => 'required|email',
                'tasker_password' => 'required|same:tasker_cpassword|min:8|max:15',
                'tasker_cpassword' => 'required|min:8|max:15',
            ],
            [], [
                'tasker_firstname' => 'First Name',
                'tasker_lastname' => 'Last Name',
                'tasker_phoneno' => 'Phone Number',
                'tasker_email' => 'Email Address',
                'tasker_password' => 'Password',
                'tasker_cpassword' => 'Confirm Password'
            ]);

            $taskers['tasker_password'] = bcrypt( $taskers['tasker_password']);
            $taskers['tasker_code'] = 'SNT'.rand(1,10000);

            Tasker::create($taskers);

            return redirect(route('tasker-login'))->with('success','Your Tasker account has been successfully created! Please log in with your registered credentials.');

        }
        catch(Exception $e)
        {
            return redirect(route('tasker-register-form'))->with('error','Error : '.$e->getMessage());
        }
    }
}
