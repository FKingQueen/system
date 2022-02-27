<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UpdateAccountController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AccountSettingController;
use App\Http\Controllers\User\FarmerListController;

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

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

// User Registration
Route::post('/registration', [App\Http\Controllers\Admin\RegistrationApprovalController::class, 'registration'])->name('registration');

Route::group(['middleware' => 'auth'], function() {
    // Account Setting
    Route::get('/accountSetting', [App\Http\Controllers\AccountSettingController::class, 'accountSetting'])->name('accountSetting');
    Route::post('/changeProfile/{id}', [App\Http\Controllers\AccountSettingController::class, 'changeProfile'])->name('changeProfile');

    // Update Account
    Route::post('/updateAccount/{id}', [App\Http\Controllers\AccountSettingController::class, 'updateAccount'])->name('updateAccount');
    Route::post('/updatePassword/{id}', [App\Http\Controllers\AccountSettingController::class, 'updatePassword'])->name('updatePassword');

    //Farmer List
    Route::get('/farmerList', [App\Http\Controllers\User\FarmerListController::class, 'farmerList'])->name('farmerList');

});

Route::group(['middleware' => 'isUser'], function() {
    //Farmer List
    Route::get('/farmerList', [App\Http\Controllers\User\FarmerListController::class, 'farmerList'])->name('farmerList');
    Route::get('/farmerList/ajax/{id}', [App\Http\Controllers\User\FarmerListController::class, 'farmerListAjax'])->name('farmerListAjax');
    Route::post('/addFarmer', [App\Http\Controllers\User\FarmerListController::class, 'addFarmer'])->name('addFarmer');
    //Farmer Profile
    Route::get('/farmerList/farmerProfile/{id}', [App\Http\Controllers\User\FarmerProfileController::class, 'farmerProfile'])->name('farmerProfile');
    Route::post('/compose/{id}', [App\Http\Controllers\User\FarmerProfileController::class, 'compose'])->name('compose');
});


Route::group(['middleware' => 'isAdmin'], function () {
    // Registration Approval
    Route::get('/registrationApproval', [App\Http\Controllers\Admin\RegistrationApprovalController::class, 'registrationApproval'])->name('registrationApproval');
    Route::post('/approved/{id}', [App\Http\Controllers\Auth\RegisterController::class, 'approved'])->name('approved');
    // User Management
    Route::get('/userMangement', [App\Http\Controllers\Admin\UserManagementController::class, 'userManagement'])->name('userManagement');
    Route::post('/userUpdate/{id}', [App\Http\Controllers\Admin\UserManagementController::class, 'userUpdate'])->name('userUpdate');
    Route::post('/userchangePassword/{id}', [App\Http\Controllers\Admin\UserManagementController::class, 'userchangePassword'])->name('userchangePassword');
});