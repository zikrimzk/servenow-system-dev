<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Client;
use App\Models\Tasker;
use Illuminate\Http\Request;
use App\Models\Administrator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;

class AuthenticateController extends Controller
{
    // Admin - Login Web Process
    public function authenticateClient(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('client')->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'client_status' => 0
        ])) {

            return redirect()->route('client-home');

        } elseif (Auth::guard('client')->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'client_status' => 1
        ])) {
            Auth::guard('client')->logout();
            $client = Client::where('email', $credentials['email'])->first();
            return redirect()->route('client-first-time', Crypt::encrypt($client->id));
        }elseif (Auth::guard('client')->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'client_status' => 2
        ])) {
            Auth::guard('admin')->logout();
            return back()->with('error', 'Your account is currently inactive. For further assistance, please contact the administrator.');
        } elseif (Auth::guard('client')->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'client_status' => 3
        ])) {
            Auth::guard('client')->logout();
            return back()->with('error', 'Your account has been deactivated. Please reach out to the administrator for further assistance.');
        }

        return redirect()->route('client-login')->with('error', 'The provided credentials do not match our records. Please try again !');
    }

    // Tasker - Login Web Process
    public function authenticateTasker(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('tasker')->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'tasker_status' => 4 // Tasker Password Need To Change
        ])) {

            Auth::guard('tasker')->logout();
            $tasker = Tasker::where('email', $credentials['email'])->first();
            return redirect()->route('tasker-first-time', Crypt::encrypt($tasker->id));
        } elseif (Auth::guard('tasker')->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'tasker_status' => 0 //Tasker Incomplete Profile
        ])) {
            return redirect()->route('tasker-home');
        } elseif (Auth::guard('tasker')->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'tasker_status' => 1 //Tasker Not Verified
        ])) {
            return redirect()->route('tasker-home');
        } elseif (Auth::guard('tasker')->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'tasker_status' => 2 //Tasker Active
        ])) {
            return redirect()->route('tasker-home');
        } elseif (Auth::guard('tasker')->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'tasker_status' => 3 // Tasker Inactive
        ])) {
            Auth::guard('tasker')->logout();
            return redirect()->route('tasker-login')->with('error', 'The provided credentials are inactive. Please contact the administrator for further details.');
        } elseif (Auth::guard('tasker')->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'tasker_status' => 5 // Tasker Banned
        ])) {
            Auth::guard('tasker')->logout();
            return redirect(route('tasker-login'))->with('error', 'The provided credentials are banned. Please contact the administrator for further details.');
        }

        return redirect()->route('tasker-login')->with('error', 'The provided credentials do not match our records. Please try again !');
    }


    // Tasker - Login API Process
    public function authenticateTaskerApi(Request $request)
    {
        // Validate the request data
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt to authenticate the tasker
        if (Auth::guard('tasker')->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'tasker_status' => 4 // Tasker Password Need To Change
        ])) {
            // Return a success response with the tasker's data
            $tasker = Tasker::where('email', $credentials['email'])->first();
            return response()->json([
                'success' => true,
                'tasker' => $tasker,
                'token' => $tasker->createToken('tasker-token')->plainTextToken,
            ]);
        } elseif (Auth::guard('tasker')->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'tasker_status' => 0 //Tasker Incomplete Profile
        ])) {
            $tasker = Tasker::where('email', $credentials['email'])->first();
            return response()->json([
                'success' => true,
                'tasker' => $tasker,
                'token' => $tasker->createToken('tasker-token')->plainTextToken,
            ]);
        } elseif (Auth::guard('tasker')->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'tasker_status' => 1 //Tasker Not Verified
        ])) {
            $tasker = Tasker::where('email', $credentials['email'])->first();
            return response()->json([
                'success' => true,
                'tasker' => $tasker,
                'token' => $tasker->createToken('tasker-token')->plainTextToken,
            ]);
        } elseif (Auth::guard('tasker')->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'tasker_status' => 2 //Tasker Active
        ])) {
            $tasker = Tasker::where('email', $credentials['email'])->first();
            return response()->json([
                'success' => true,
                'tasker' => $tasker,
                'token' => $tasker->createToken('tasker-token')->plainTextToken,
            ]);
        } elseif (Auth::guard('tasker')->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'tasker_status' => 3 // Tasker Inactive
        ])) {
            Auth::guard('tasker')->logout();
            return response()->json([
                'success' => false,
                'error' => 'The provided credentials are inactive. Please contact the administrator for further details.',
            ], 401);
        } elseif (Auth::guard('tasker')->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'tasker_status' => 5 // Tasker Banned
        ])) {
            Auth::guard('tasker')->logout();
            return response()->json([
                'success' => false,
                'error' => 'The provided credentials are banned. Please contact the administrator for further details.',
            ], 401);
        } else {
            // Return an error response
            return response()->json([
                'success' => false,
                'error' => 'Please enter the correct credentials !',
            ], 401);
        }
    }

    // Admin - Login Web Process
    public function authenticateAdmin(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('admin')->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'admin_status' => 0
        ])) {
            Auth::guard('admin')->logout();
            $admin = Administrator::where('email', $credentials['email'])->first();
            return redirect()->route('admin-first-time', Crypt::encrypt($admin->id));
        } elseif (Auth::guard('admin')->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'admin_status' => 1
        ])) {
            return redirect()->route('admin-home');
        } elseif (Auth::guard('admin')->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'admin_status' => 2
        ])) {
            Auth::guard('admin')->logout();
            return back()->with('error', 'Your account is currently inactive. For further assistance, please contact the administrator.');
        } elseif (Auth::guard('admin')->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'admin_status' => 3
        ])) {
            Auth::guard('admin')->logout();
            return back()->with('error', 'Your account has been deactivated. Please reach out to the administrator for further assistance.');
        }

        return redirect()->route('admin-login')->with('error', 'The provided credentials do not match our records. Please try again !');
    }

    // Tasker - Logout Process
    public function logoutClient(Request $request): RedirectResponse
    {
        Auth::guard('client')->logout();
        return redirect()->route('client-login')->with('success', 'You have successfully logged out.');
    }

    // Tasker - Logout Process
    public function logoutTasker(Request $request): RedirectResponse
    {
        Auth::guard('tasker')->logout();
        return redirect()->route('tasker-login')->with('success', 'You have successfully logged out.');
    }

    // Admin - Logout Process
    public function logoutAdmin(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin-login')->with('success', 'You have successfully logged out.');
    }

    // Admin - First Time Login Process
    public function adminFirstTimeLogin(Request $req, $id)
    {
        try {
            $validated = $req->validate(
                [
                    'oldPass' => 'required | min:8',
                    'newPass' => 'required | min:8',
                    'renewPass' => 'required | same:newPass',
                ],
                [],
                [
                    'oldPass' => 'Old Password',
                    'newPass' => 'New Password',
                    'renewPass' => 'Comfirm Password',

                ]
            );
            $admin = Administrator::where('id', Crypt::decrypt($id))->first();

            $check = Hash::check($validated['oldPass'], $admin->password, []);
            if ($check) {
                Administrator::where('id', Crypt::decrypt($id))->update(['password' => bcrypt($validated['renewPass']), 'admin_status' => 1]);
                return redirect()->route('admin-login')->with('success', 'Password has been updated successfully. Please log in using your new credentials.');
            } else {
                return back()->with('error', 'Please enter the correct password !');
            }
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // Tasker - First Time Login Process
    public function taskerFirstTimeLogin(Request $req, $id)
    {
        try {

            $validated = $req->validate(
                [
                    'oldPass' => 'required | min:8',
                    'newPass' => 'required | min:8',
                    'renewPass' => 'required | same:newPass',
                ],
                [],
                [
                    'oldPass' => 'Old Password',
                    'newPass' => 'New Password',
                    'renewPass' => 'Comfirm Password',

                ]
            );
            $tasker = Tasker::where('id', Crypt::decrypt($id))->first();

            $check = Hash::check($validated['oldPass'], $tasker->password, []);
            if ($check) {
                Tasker::where('id', Crypt::decrypt($id))->update(['password' => bcrypt($validated['renewPass']), 'tasker_status' => 0]);
                return redirect()->route('tasker-login')->with('success', 'Password has been updated successfully. Please log in using your new credentials.');
            } else {
                return back()->with('error', 'Please enter the correct password !');
            }
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // Client - First Time Login Process
    public function clientFirstTimeLogin(Request $req, $id)
    {
        try {

            $validated = $req->validate(
                [
                    'oldPass' => 'required | min:8',
                    'newPass' => 'required | min:8',
                    'renewPass' => 'required | same:newPass',
                ],
                [],
                [
                    'oldPass' => 'Old Password',
                    'newPass' => 'New Password',
                    'renewPass' => 'Comfirm Password',

                ]
            );
            $client = Client::where('id', Crypt::decrypt($id))->first();

            $check = Hash::check($validated['oldPass'], $client->password, []);
            if ($check) {
                Client::where('id', Crypt::decrypt($id))->update(['password' => bcrypt($validated['renewPass']), 'client_status' => 0]);
                return redirect()->route('client-login')->with('success', 'Password has been updated successfully. Please log in using your new credentials.');
            } else {
                return back()->with('error', 'Please enter the correct password !');
            }
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
