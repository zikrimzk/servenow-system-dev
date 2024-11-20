<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\TaskerController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\ClientController;
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

    // Admin - First Time Login
    Route::get('/admin-first-time-login-{id}', [RouteController::class, 'adminFirstTimeNav'])->name('admin-first-time');
    Route::post('/admin-first-time-login-process-{id}', [AuthenticateController::class, 'adminFirstTimeLogin'])->name('admin-first-time-update');


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
    Route::get('/tasker-details-{id}', [RouteController::class, 'taskerUpdateNav'])->name('admin-tasker-update-form');
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

// Admin - First Time Login
Route::get('/tasker-first-time-login-{id}', [RouteController::class, 'taskerFirstTimeNav'])->name('tasker-first-time');
Route::post('/tasker-first-time-login-process-{id}', [AuthenticateController::class, 'taskerFirstTimeLogin'])->name('tasker-first-time-update');

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

    Route::get('/card-verification-{id}', [TaskerController::class, 'taskerCardVerification'])->name('tasker-card-ver');
    Route::get('/face-verification', [TaskerController::class, 'taskerFaceVerification'])->name('tasker-face-ver');
    Route::get('/verification-success', [TaskerController::class, 'verificationSuccess'])->name('tasker-ver-success');


});
/* Tasker Route End */

Route::get('/', [RouteController::class, 'gotoIndex'])->name('serve-now-home');

Route::get('/login-option', [RouteController::class, 'loginOptionNav'])->name('servenow-login-option');

Route::get('/register-client', [RouteController::class, 'clientRegisterFormNav'])->name('client-register-form');

Route::post('/create-client', [ClientController::class, 'createClient'])->name('client-create');

Route::get('/login', [RouteController::class, 'clientLoginNav'])->name('client-login');

Route::post('/client-authentication', [AuthenticateController::class, 'authenticateClient'])->name('client-auth');




Route::prefix('client')->middleware('auth:client')->group(function () {

    // Client - Dashboard
    Route::get('/search-services', [RouteController::class, 'clientSearchServicesNav'])->name('client-home');



    

});











// Route::get('/get-states', [RouteController::class, 'getStates'])->name('get-states');
Route::get('/get-areas/{state}', [RouteController::class, 'getAreas'])->name('get-area');



