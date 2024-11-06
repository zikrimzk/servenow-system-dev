<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Administrator;
use App\Models\ServiceType;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class RouteController extends Controller
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

                $button = 
                    '
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
                                        setTimeout(function() {
                                            location.href="'.route("admin-delete",$row->id).'";
                                        }, 1000);
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

    public function serviceTypeManagementNav(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table('service_types')
                ->select('id', 'servicetype_name', 'servicetype_desc','servicetype_status')
                ->get();

            $table = DataTables::of($data)->addIndexColumn();

            $table->addColumn('servicetype_status', function ($row) {

                if ($row->servicetype_status == 1) {
                    $status = '<span class="badge rounded-pill text-bg-success">Show</span>';
                } else if ($row->servicetype_status == 2) {
                    $status = '<span class="badge rounded-pill text-bg-danger">Hide</span>';
                } 
                return $status;
            });

            $table->addColumn('action', function ($row) {

                $button = 
                    '
                          <a href="#" class="avtar avtar-xs btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#updateServiceTypeModal-'.$row->id.'">
                            <i class="ti ti-edit f-20"></i>
                          </a>
                          <a href="#" class="avtar avtar-xs  btn-light-danger deleteServiceType-'.$row->id.'" data-bs-toggle="modal"
                            data-bs-target="#deleteAdmin">
                            <i class="ti ti-trash f-20"></i>
                          </a>

                            <script>
                                document.querySelector(".deleteServiceType-'.$row->id.'").addEventListener("click", function () {
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
                                    text: "This action cannot be undone.",
                                    icon: "warning",
                                    showCancelButton: true,
                                    confirmButtonText: "Yes, delete it!",
                                    cancelButtonText: "No, cancel!",
                                    reverseButtons: true
                                })
                                .then((result) => {
                                    if (result.isConfirmed) {
                                        setTimeout(function() {
                                            location.href="'.route("admin-servicetype-delete",$row->id).'";
                                        }, 1000);
                                    } 
                                });
                            });
                        </script>
                    ';

                return $button;
            });

            $table->rawColumns(['servicetype_status','action']);

            return $table->make(true);
        }
        return view('administrator.service.servicetype-index', [
            'title' => 'Service Type Management',
            'stypes' => ServiceType::get(),
        ]);
    }
}
