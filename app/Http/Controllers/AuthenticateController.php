<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Client;
use App\Models\Tasker;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Administrator;
use App\Mail\AuthenticateMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Password;

class AuthenticateController extends Controller
{
    // Admin - Login Web Process
    //Check by : Zikri (21/1/2025)
    public function authenticateClient(Request $request): RedirectResponse
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email|exists:clients',
                'password' => 'required',
            ]);

            $remember = $request->boolean('remember');

            if (Client::where('email', $credentials['email'])->where('email_verified', 1)->exists()) {
                if (Auth::guard('client')->attempt([
                    'email' => $credentials['email'],
                    'password' => $credentials['password'],
                    'client_status' => 0
                ], $remember)) {

                    return redirect()->route('client-home');
                } elseif (Auth::guard('client')->attempt([
                    'email' => $credentials['email'],
                    'password' => $credentials['password'],
                    'client_status' => 1
                ], $remember)) {
                    Auth::guard('client')->logout();
                    $client = Client::where('email', $credentials['email'])->first();
                    return redirect()->route('client-first-time', Crypt::encrypt($client->id));
                } elseif (Auth::guard('client')->attempt([
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

                return back()->with('error', 'The provided credentials do not match our records. Please try again !');
            } else {
                return back()->with('error', 'Oops, looks like your account is not verified. Please check your email for futher steps.');
            }
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // Tasker - Login Web Process
    //Check by : Zikri (21/1/2025)
    public function authenticateTasker(Request $request): RedirectResponse
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email|exists:taskers',
                'password' => 'required',
            ]);
            $remember = $request->boolean('remember');

            if (Tasker::where('email', $credentials['email'])->where('email_verified', 1)->exists()) {
                if (Auth::guard('tasker')->attempt([
                    'email' => $credentials['email'],
                    'password' => $credentials['password'],
                    'tasker_status' => 4 // Tasker Password Need To Change
                ], $remember)) {

                    Auth::guard('tasker')->logout();
                    $tasker = Tasker::where('email', $credentials['email'])->first();
                    return redirect()->route('tasker-first-time', Crypt::encrypt($tasker->id));
                } elseif (Auth::guard('tasker')->attempt([
                    'email' => $credentials['email'],
                    'password' => $credentials['password'],
                    'tasker_status' => 0 //Tasker Incomplete Profile
                ], $remember)) {
                    return redirect()->route('tasker-profile');
                } elseif (Auth::guard('tasker')->attempt([
                    'email' => $credentials['email'],
                    'password' => $credentials['password'],
                    'tasker_status' => 1 //Tasker Not Verified
                ], $remember)) {
                    return redirect()->route('tasker-profile');
                } elseif (Auth::guard('tasker')->attempt([
                    'email' => $credentials['email'],
                    'password' => $credentials['password'],
                    'tasker_status' => 2 //Tasker Active
                ], $remember)) {
                    return redirect()->route('tasker-home');
                } elseif (Auth::guard('tasker')->attempt([
                    'email' => $credentials['email'],
                    'password' => $credentials['password'],
                    'tasker_status' => 3 // Tasker Inactive
                ])) {
                    Auth::guard('tasker')->logout();
                    return back()->with('error', 'The provided credentials are inactive. Please contact the administrator for further details.');
                } elseif (Auth::guard('tasker')->attempt([
                    'email' => $credentials['email'],
                    'password' => $credentials['password'],
                    'tasker_status' => 5 // Tasker Banned
                ])) {
                    Auth::guard('tasker')->logout();
                    return back()->with('error', 'The provided credentials are banned. Please contact the administrator for further details.');
                }

                return back()->with('error', 'The provided credentials do not match our records. Please try again !');
            } else {
                return back()->with('error', 'Oops, looks like your account is not verified. Please check your email for futher steps.');
            }
        } catch (Exception $e) {

            return back()->with('error', $e->getMessage());
        }
    }


    // Tasker - Login API Process
    public function authenticateTaskerApi(Request $request)
    {
        // Validate the request data
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Tasker::where('email', $credentials['email'])->where('email_verified', 1)->exists()) {
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
        } else {

            return response()->json([
                'success' => false,
                'error' => 'Oops, looks like your account is not verified. Please check your email for futher steps.',
            ], 401);
        }
    }

    // Admin - Login Web Process
    //Check by : Zikri (21/1/2025)
    public function authenticateAdmin(Request $request): RedirectResponse
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email|exists:administrators',
                'password' => 'required',
            ]);

            if (Administrator::where('email', $credentials['email'])->where('email_verified', 1)->exists()) {
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

                return back()->with('error', 'The provided credentials do not match our records. Please try again !');
            } else {
                return back()->with('error', 'Oops, looks like your account is not verified. Please check your email for futher steps.');
            }
        } catch (Exception $e) {

            return back()->with('error', $e->getMessage());
        }
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


    // User - Email Notification
    private function sendAccountNotification($data, $userType, $option, $link)
    {
        // Users Name
        if ($userType == 1) {
            $name = $data->admin_firstname . ' ' . $data->admin_lastname;
        } elseif ($userType == 2) {
            $name = $data->tasker_firstname . ' ' . $data->tasker_lastname;
        } elseif ($userType == 3) {
            $name = $data->client_firstname . ' ' . $data->client_lastname;
        }

        Mail::to($data->email)->send(new AuthenticateMail([
            'users' => $userType,
            'name' => Str::headline($name),
            'date' => Carbon::now()->format('d F Y g:i A'),
            'option' => $option,
            'link' => $link

        ]));
    }

    public function verifyEmail(Request $request, $option)
    {
        try {
            $email = $request->input('email');
            $email = Crypt::decrypt($email);
            if ($option == 1) {
                $user = Administrator::where('email', $email)->first();

                Administrator::where('email', $user->email)->update([
                    'email_verified' => 1
                ]);

                $this->sendAccountNotification($user, $option, 4, null);

                return redirect(route('admin-login'))->with('success', 'Your account has been successfully verified! Please log in with your credentials to access your account.');
            } elseif ($option == 2) {
                $user = Tasker::where('email', $email)->first();

                Tasker::where('email', $user->email)->update([
                    'email_verified' => 1
                ]);

                $this->sendAccountNotification($user, $option, 4, null);

                return redirect(route('tasker-login'))->with('success', 'Your account has been successfully verified! Please log in with your credentials to access your account.');
            } elseif ($option == 3) {
                $user = Client::where('email', $email)->first();

                Client::where('email', $user->email)->update([
                    'email_verified' => 1
                ]);
                $this->sendAccountNotification($user, $option, 4, null);

                return redirect(route('client-login'))->with('success', 'Your account has been successfully verified! Please log in with your credentials to access your account.');
            } else {
                return redirect(route('servenow-home'));
            }
            if (!$user) {
                return redirect(route('servenow-home'));
            }
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // Reset Password - Verify Email
    public function resetPasswordEmailVerify(Request $request, $option)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->input('email');

        // Check each table for the email
        if ($option == 1) {
            $user = Administrator::where('email', $email)->first();
        } elseif ($option == 2) {
            $user = Tasker::where('email', $email)->first();
        } elseif ($option == 3) {
            $user = Client::where('email', $email)->first();
        } else {
            return back()->with('error', 'Oops, Invalid Url !');
        }

        if (!$user) {
            return back()->with('error', 'Email address not found in our records.');
        } else {
            // Generate a secure token
            $token = Str::random(64);

            // Insert token into password_resets table
            DB::table('password_resets')->updateOrInsert(
                ['email' => $email],
                [
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]
            );

            $resetLink = route('reset-password-change-form', ['option' => $option, 'token' => $token, 'email' => $email]);

            $this->sendAccountNotification($user, $option, 2, $resetLink);

            return back()->with('success', 'Password reset link sent successfully. Please check your email.');
        }
    }

    // Reset Password - Change Password
    public function resetPasswordProcess(Request $request, $option)
    {
        try {
            $tokenData = DB::table('password_resets')
                ->where('token', $request->input('token'))
                ->where('email', $request->input('email'))
                ->first();

            $user_link = null;

            if ($option == 1) {
                $user_link = route('admin-login');

                if (!$tokenData) {
                    return redirect($user_link)->with('error', 'Invalid or expired token');
                }

                if (Carbon::parse($tokenData->created_at)->addHour()->isPast()) {
                    return redirect($user_link)->with('message', 'Token has expired');
                }

                DB::table('administrator')->where('email', $request->input('email'))->update([
                    'password' => bcrypt($request->input('renewPass'))
                ]);

                $user = Administrator::where('email', $request->input('email'))->first();
            } elseif ($option == 2) {
                $user_link = route('tasker-login');

                if (!$tokenData) {
                    return redirect($user_link)->with('error', 'Invalid or expired token');
                }

                if (Carbon::parse($tokenData->created_at)->addHour()->isPast()) {
                    return redirect($user_link)->with('message', 'Token has expired');
                }

                DB::table('taskers')->where('email', $request->input('email'))->update([
                    'password' => bcrypt($request->input('renewPass'))
                ]);

                $user = Tasker::where('email', $request->input('email'))->first();
            } elseif ($option == 3) {

                $user_link = route('client-login');

                if (!$tokenData) {
                    return redirect($user_link)->with('error', 'Invalid or expired token');
                }

                if (Carbon::parse($tokenData->created_at)->addHour()->isPast()) {
                    return redirect($user_link)->with('message', 'Token has expired');
                }

                DB::table('clients')->where('email', $request->input('email'))->update([
                    'password' => bcrypt($request->input('renewPass'))
                ]);

                $user = Client::where('email', $request->input('email'))->first();
            }

            DB::table('password_resets')->where('email', $request->input('email'))->delete();

            $this->sendAccountNotification($user, $option, 3, null);

            return redirect($user_link)->with('success', 'Password has been reset successfully');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
