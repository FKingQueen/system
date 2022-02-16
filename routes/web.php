<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UpdateAccountController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AccountSettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/login', [App\Http\Controllers\LoginController::class, 'login'])->name('login');

// Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register');

// Account Setting
Route::get('/accountSetting', [App\Http\Controllers\AccountSettingController::class, 'accountSetting'])->name('accountSetting');

// Update Account
Route::post('/updateAccount/{id}', [App\Http\Controllers\AccountSettingController::class, 'updateAccount'])->name('updateAccount');

// Registration Approval
Route::get('/registrationApproval', [App\Http\Controllers\Admin\RegistrationApprovalController::class, 'registrationApproval'])->name('registrationApproval');
Route::post('/registration', [App\Http\Controllers\Admin\RegistrationApprovalController::class, 'registration'])->name('registration');
Route::post('/approved/{id}', [App\Http\Controllers\Auth\RegisterController::class, 'approved'])->name('approved');

// User Management
Route::get('/userMangement', [App\Http\Controllers\Admin\UserManagementController::class, 'userManagement'])->name('userManagement');
Route::post('/userUpdate/{id}', [App\Http\Controllers\Admin\UserManagementController::class, 'userUpdate'])->name('userUpdate');

