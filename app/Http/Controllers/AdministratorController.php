<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Administrator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Http;

class AdministratorController extends Controller
{

    // Admin - Register Admin
    // Check by : Zikri (12/01/2025)
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

        return back()->with('success', 'Administrator has been registered successfully !');
    }

    // Admin - Update Admin
    // Check by : Zikri (12/01/2025)
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

            return back()->with('success', 'Administrator details has been updated successfully !');
        } catch (Exception $e) {
            return back()->with('error', 'Error : ' . $e->getMessage());
        }
    }

    // Admin - Update Multiple Admin
    // Check by : Zikri (12/01/2025)
    public function updateMultipleAdminStatus(Request $req)
    {
        try {
            $adminIds = $req->input('selected_admin');
            $updatedStatus = $req->input('admin_status');

            Administrator::whereIn('id', $adminIds)->update(['admin_status' => $updatedStatus]);

            return response()->json([
                'message' => 'All selected administrator status has been updated successfully !',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Oops! Something went wrong. Please try again later.',
            ]);
        }
    }

    // Admin - Soft Delete Admin
    // Check by : Zikri (12/01/2025)
    public function deleteAdmin($adminId)
    {
        try {
            Administrator::where('id', $adminId)->update(['admin_status' => 3]);
            return back()->with('success', 'Administrator account has been deactivated !');
        } catch (Exception $e) {
            return back()->with('error', 'Error : ' . $e->getMessage());
        }
    }

    // Admin - Update Profile
    // Check by : Zikri (12/01/2025)
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
            $filename = time() . '_' . $user->admin_code . '_profile' . '.' . $file->getClientOriginalExtension();

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

        // Set the active tab to Bank Details (profile-1) in the session
        session()->flash('active_tab', 'profile-1');

        return back()->with('success', 'Administrator profile has been updated successfully !');
    }

    // Admin - Update Password
    // Check by : Zikri (12/01/2025)
    public function adminUpdatePassword(Request $req, $id)
    {
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
        // Set the active tab to Bank Details (profile-2) in the session
        session()->flash('active_tab', 'profile-2');

        $check = Hash::check($validated['oldPass'], Auth::user()->password, []);
        if ($check) {
            Administrator::where('id', $id)->update(['password' => bcrypt($validated['renewPass'])]);
            return back()->with('success', 'Password has been updated successfully !');
        } else {
            return back()->with('error', 'Please enter the correct password !');
        }
    }

    public function showCardLogs(Request $request)
    {
        $response = Http::withHeaders([
            'Authorization' => env("EKYC_API_KEY"),
        ])->withoutVerifying()
            ->get(env('API_EKYC_URL') . '/card-logs');
        $data = $response->json();


        if ($response->successful()) {
            $data = $response->json();

            // dd($data);

            if (isset($data['data']) && !empty($data['data'])) {
                $logs = $data['data'];
            } else {
                $logs = [];
            }
        } else {
            $logs = [];
        }


        if ($request->ajax()) {

            return DataTables::of($logs)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    if ($row['status'] == 'success') {
                        return '<span class="badge bg-success p-2 fw-bold">SUCCESS</span>';
                    } elseif ($row['status'] == 'failed') {
                        return '<span class="badge bg-danger p-2 fw-bold">FAILED</span>';
                    }
                    return '<span class="badge bg-warning fw-bold">ERROR</span>';
                })
                ->addColumn('res', function ($row) {
                    if ($row['status'] == 'success') {
                        return '<span class="badge bg-light-success p-3 fw-bold " style="word-wrap: break-word; white-space: normal; text-align: left;">' . $row['response'] . '</span>';
                    } elseif ($row['status'] == 'failed') {
                        return '<span class="badge bg-light-danger p-3 fw-bold " style="word-wrap: break-word; white-space: normal; text-align: left;">' . $row['response'] . '</span>';
                    }

                    return '<span class="badge bg-danger">ERROR</span>';
                })
                ->rawColumns(['status', 'res'])
                ->make(true);
        }


        return view('administrator.ekyc.card-log', [
            'title' => 'e-KYC Card Log'
        ]);
    }

    public function showFaceLogs(Request $request)
    {
        $response = Http::withHeaders([
            'Authorization' => env("EKYC_API_KEY"),
        ])->withoutVerifying()
            ->get(env('API_EKYC_URL') . '/face-logs');
        $data = $response->json();

        if ($response->successful()) {
            $data = $response->json();
            // dd($data);
            if (isset($data['data']) && !empty($data['data'])) {
                $logs = $data['data'];
            } else {
                $logs = [];
            }
        } else {
            $logs = [];
        }


        if ($request->ajax()) {
            return DataTables::of($logs)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    if ($row['status'] == 'SUCCESS') {
                        return '<span class="badge bg-success p-2 fw-bold">SUCCESS</span>';
                    } elseif ($row['status'] == 'FAILED') {
                        return '<span class="badge bg-danger p-2 fw-bold">FAILED</span>';
                    }
                    return '<span class="badge bg-warning fw-bold">ERROR</span>';
                })
                ->addColumn('res', function ($row) {
                    if ($row['status'] == 'SUCCESS') {
                        return '<span class="badge bg-light-success p-3 fw-bold">' . $row['response'] . '</span>';
                    } elseif ($row['status'] == 'FAILED') {
                        return '<span class="badge bg-light-danger p-3 fw-bold">' . $row['response'] . '</span>';
                    }
                    return '<span class="badge bg-danger fw-bold">ERROR</span>';
                })
                ->rawColumns(['status', 'res'])
                ->make(true);
        }


        return view('administrator.ekyc.face-log', [
            'title' => 'e-KYC Face Log'
        ]);
    }
}
