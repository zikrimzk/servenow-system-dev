<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\TaskerController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\AdministratorController;

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
    // Admin Login
    Route::get('/login', [RouteController::class, 'adminLoginNav'])->name('admin-login');
});

Route::prefix('admin')->group(function () {

    // Admin - Dashboard
    Route::get('/home', [RouteController::class, 'adminHomeNav'])->name('admin-home');

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
    
});
/* Admin Route End */



/* Tasker Route Start */
Route::get('/login-tasker', [RouteController::class, 'taskerLoginNav'])->name('tasker-login');
Route::get('/register-tasker', [RouteController::class, 'taskerRegisterFormNav'])->name('tasker-register-form');
Route::post('/tasker-registration', [TaskerController::class, 'createTasker'])->name('tasker-create');

Route::prefix('tasker')->group(function () {

    // Tasker - Dashboard
    Route::get('/home', [RouteController::class, 'taskerhomeNav'])->name('tasker-home');

});
/* Tasker Route End */