<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Administrator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;

class AuthenticateController extends Controller
{
    public function authenticateTasker(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('tasker')->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password']
        ])) {
            $request->session()->regenerate();
            return redirect()->intended(route('tasker-home'));
        }

        return redirect(route('tasker-login'))->with('error', 'The provided credentials do not match our records. Please try again !');
    }

    public function authenticateAdmin(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('admin')->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'admin_status'=> 0
        ])) {
            Auth::guard('admin')->logout();
            
            $admin = Administrator::where('email',$credentials['email'])->first();
            return redirect()->route('admin-first-time',Crypt::encrypt($admin->id));

        }elseif(Auth::guard('admin')->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'admin_status'=> 1
        ])){
            return redirect()->intended(route('admin-home'));
        }

        return redirect(route('admin-login'))->with('error', 'The provided credentials do not match our records. Please try again !');
    }


    public function logoutTasker(Request $request): RedirectResponse
    {
        Auth::guard('tasker')->logout();

        // $request->session()->invalidate();
        // $request->session()->regenerateToken();

        return redirect(route('tasker-login'))->with('success', 'You have successfully logged out.');
    }
    
    public function logoutAdmin(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        // $request->session()->invalidate();
        // $request->session()->regenerateToken();

        return redirect(route('admin-login'))->with('success', 'You have successfully logged out.');
    }
}
