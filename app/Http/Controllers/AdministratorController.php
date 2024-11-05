<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Administrator;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

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

    public function adminManagementNav(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table('administrators')
                ->select('id', 'admin_firstname', 'admin_lastname', 'admin_phoneno', 'email', 'admin_status')
                ->get();

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('admin_status', function ($row) {

                if ($row->admin_status == 0) {
                    $status = '<span class="text-warning"><i class="fas fa-circle f-10 m-r-10"></i> Not Activated</span>';
                } else if ($row->admin_status == 1) {
                    $status = '<span class="text-success"><i class="fas fa-circle f-10 m-r-10"></i> Active</span>';
                } else {
                    $status = '<span class="text-danger"><i class="fas fa-circle f-10 m-r-10"></i> Inactive</span>';
                }

                return $status;
            });

            $table->addColumn('action', function ($row) {

                $button = '
                          <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#updateAdminModal-'.$row->id.'">
                            <i class="ti ti-edit f-20"></i>
                          </a>
                          <a href="#" class="avtar avtar-xs  btn-light-danger deleteAdmin-'.$row->id.'" data-bs-toggle="modal"
                            data-bs-target="#deleteAdmin">
                            <i class="ti ti-trash f-20"></i>
                          </a>

                            <script>
                                document.querySelector(".deleteAdmin-'.$row->id.'").addEventListener("click", function () {
                                const swalWithBootstrapButtons = Swal.mixin({
                                customClass: {
                                    confirmButton: "btn btn-success",
                                    cancelButton: "btn btn-danger"
                                },
                                buttonsStyling: false
                                });
                                swalWithBootstrapButtons
                                .fire({
                                    title: "Are you sure?",
                                    text: "Once deleted, the admin will permanently lose access to the system, and all related data will be removed. This action cannot be undone.",
                                    icon: "warning",
                                    showCancelButton: true,
                                    confirmButtonText: "Yes, delete it!",
                                    cancelButtonText: "No, cancel!",
                                    reverseButtons: true
                                })
                                .then((result) => {
                                    if (result.isConfirmed) {
                                    swalWithBootstrapButtons.fire("Deleted!", "Administrator details has been deleted.", "success");
                                    setTimeout(function() {
                                        location.href="'.route("admin-delete",$row->id).'";
                                    }, 1000);
                                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                                    swalWithBootstrapButtons.fire("Cancelled", "Operation Cancelled)", "error");
                                    }
                                });
                            });
                        </script>
                          ';

                return $button;
            });

            $table->rawColumns(['admin_status', 'action']);

            return $table->make(true);
        }
        return view('administrator.admin.index', [
            'title' => 'Admin Management',
            'admins' => Administrator::get()
        ]);
    }

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
            ]);
            $data['admin_firstname'] = Str::upper($data['admin_firstname']);
            $data['admin_lastname'] = Str::upper($data['admin_lastname']);
            Administrator::where('id', $adminId)->update($data);

            return redirect(route('admin-management'))->with('success', 'Administrator details has been updated successfully !');
        } catch (Exception $e) {
            return redirect(route('admin-management'))->with('error', 'Error : ' . $e->getMessage());
        }
    }


    public function deleteAdmin(Request $req, $adminId)
    {
        try {
            Administrator::where('id', $adminId)->delete();
            return redirect(route('admin-management'))->with('success', 'Administrator has been deleted successfully !');
        } catch (Exception $e) {
            return redirect(route('admin-management'))->with('error', 'Error : ' . $e->getMessage());
        }
    }
}
