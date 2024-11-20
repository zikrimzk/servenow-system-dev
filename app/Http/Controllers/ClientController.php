<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    //Client Function Here ...
    public function createClient(Request $req)
    {
        $client = $req -> validate([
            'client_firstname'=>'required|string',
            'client_lastname'=>'required|string',
            'client_phoneno'=>'required|string|min:10|max:11',
            'email'=>'required|email|unique:clients',
            'password'=>'required|same:cpassword|min:8',
            'cpassword'=>'required|min:8',
            'client_state'=>'required',
        ],[],
        [
            'client_firstname'=>'First name',
            'client_lastname'=>'Last name',
            'client_phoneno'=>'Phone number',
            'email'=>'Email',
            'password'=>'Password',
            'cpassword'=>'Confirm password',
            'client_state'=>'State',

        ]);

        $client['password'] = bcrypt($client['password']);
        $path = 'profile_photos/default-profile.png';
        $client['client_photo'] = $path;
        Client::create($client);

        return redirect(route('client-login'))->with('success', 'Your account has been successfully created! Please log in with your registered credentials.');
    }
}
