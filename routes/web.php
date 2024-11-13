<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\TaskerController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\AdministratorController;
use App\Models\Service;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/* Admin Route Start */
Route::prefix('admin')->group(function () {
    // Admin - Login
    Route::get('/login', [RouteController::class, 'adminLoginNav'])->name('admin-login');

    // Admin - Auth Process
    Route::post('/admin-authentication', [AuthenticateController::class, 'authenticateAdmin'])->name('auth-admin');

}); 

Route::prefix('admin')->middleware('auth:admin')->group(function () {

    // Admin - Dashboard
    Route::get('/home', [RouteController::class, 'adminHomeNav'])->name('admin-home');

    // Admin - Account Profile
    Route::get('/profile', [RouteController::class, 'adminprofileNav'])->name('admin-profile');
    Route::post('/update-profile-{id}', [AdministratorController::class, 'adminUpdateProfile'])->name('admin-update-profile');
    Route::post('/update-password-{id}', [AdministratorController::class, 'adminUpdatePassword'])->name('admin-update-password');

    // Admin - Logout
    Route::get('/admin-logout', [AuthenticateController::class, 'logoutAdmin'])->name('admin-logout');

    // Admin - Administrator Management
    Route::get('/admin-management', [RouteController::class, 'adminManagementNav'])->name('admin-management');
    Route::post('/create-admin', [AdministratorController::class, 'createAdmin'])->name('admin-create');
    Route::post('/update-admin-{id}', [AdministratorController::class, 'updateAdmin'])->name('admin-update');
    Route::get('/delete-admin-{id}', [AdministratorController::class, 'deleteAdmin'])->name('admin-delete');

    // Admin - Service Type Management
    Route::get('/service-type-management', [RouteController::class, 'serviceTypeManagementNav'])->name('admin-service-type-management');
    Route::post('/create-service-type', [ServiceController::class, 'createServiceType'])->name('admin-servicetype-create');
    Route::post('/update-service-type-{id}', [ServiceController::class, 'updateServiceType'])->name('admin-servicetype-update');
    Route::get('/delete-service-type-{id}', [ServiceController::class, 'deleteServiceType'])->name('admin-servicetype-delete');

    // Admin - Tasker Management
    Route::get('/tasker-management', [RouteController::class, 'taskerManagementNav'])->name('admin-tasker-management');
    Route::post('/create-tasker', [TaskerController::class, 'adminCreateTasker'])->name('admin-tasker-create');
    Route::get('/update-tasker-detaiils-{id}', [RouteController::class, 'taskerUpdateNav'])->name('admin-tasker-update-form');
    Route::post('/update-tasker-{id}', [TaskerController::class, 'adminUpdateTasker'])->name('admin-tasker-update');

    // Admin - Service Management
    Route::get('/service-management', [RouteController::class, 'adminServiceManagementNav'])->name('admin-service-management');
    Route::get('/approve-service-{id}', [ServiceController::class, 'adminApproveService'])->name('admin-approve-service');
    Route::get('/reject-service-{id}', [ServiceController::class, 'adminRejectService'])->name('admin-reject-service');
    Route::get('/terminate-service-{id}', [ServiceController::class, 'adminTerminateService'])->name('admin-terminate-service');

 
});
/* Admin Route End */



/* Tasker Route Start */

// Tasker - Login 
Route::get('/login-tasker', [RouteController::class, 'taskerLoginNav'])->name('tasker-login');

// Tasker - Registration Form [General]
Route::get('/register-tasker', [RouteController::class, 'taskerRegisterFormNav'])->name('tasker-register-form');

// Tasker - Registration Process
Route::post('/tasker-registration', [TaskerController::class, 'createTasker'])->name('tasker-create');

// Tasker - Auth Process
Route::post('/tasker-authentication', [AuthenticateController::class, 'authenticateTasker'])->name('auth-tasker');

Route::prefix('tasker')->middleware('auth:tasker')->group(function () {

    // Tasker - Dashboard
    Route::get('/home', [RouteController::class, 'taskerhomeNav'])->name('tasker-home');

    // Tasker - Logout
    Route::get('/tasker-logout', [AuthenticateController::class, 'logoutTasker'])->name('tasker-logout'); 

    // Tasker - Account Profile
    Route::get('/profile', [RouteController::class, 'taskerprofileNav'])->name('tasker-profile');
    Route::post('/update-profile-{id}', [TaskerController::class, 'taskerUpdateProfile'])->name('tasker-update-profile'); 
    Route::post('/update-password-{id}', [TaskerController::class, 'taskerUpdatePassword'])->name('tasker-update-password');



    //Tasker - Service Management
    Route::get('/service-management', [RouteController::class, 'taskerServiceManagementNav'])->name('tasker-service-management'); 
    Route::post('/create-service', [ServiceController::class, 'createService'])->name('tasker-service-create'); 
    Route::post('/update-service-{id}', [ServiceController::class, 'updateService'])->name('tasker-service-update'); 
    Route::get('/delete-service-{id}', [ServiceController::class, 'deleteService'])->name('tasker-service-delete'); 

});
/* Tasker Route End */












// Route::get('/get-states', [RouteController::class, 'getStates'])->name('get-states');
Route::get('/get-areas/{state}', [RouteController::class, 'getAreas'])->name('get-area');

