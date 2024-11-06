<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\RouteController;

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

Route::get('/admin/login',[RouteController::class,'loginNav'])->name('admin-login');
Route::get('/admin/home',[RouteController::class,'homeNav'])->name('admin-home');
Route::get('/admin/admin-management',[RouteController::class,'adminManagementNav'])->name('admin-management');
Route::post('/admin/create-admin',[AdministratorController::class,'createAdmin'])->name('admin-create'); 
Route::post('/admin/update-admin-{id}',[AdministratorController::class,'updateAdmin'])->name('admin-update'); 
Route::get('/admin/delete-admin-{id}',[AdministratorController::class,'deleteAdmin'])->name('admin-delete'); 

Route::get('/admin/service-type-management',[RouteController::class,'serviceTypeManagementNav'])->name('admin-service-type-management'); 





