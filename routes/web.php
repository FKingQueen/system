<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UpdateAccountController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AccountSettingController;
use App\Http\Controllers\User\FarmerListController;
use App\Http\Controllers\User\CropCalendarController;
use App\Http\Controllers\User\CropMonitoringController;

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
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    //Farmer List
    Route::get('/farmerList', [App\Http\Controllers\User\FarmerListController::class, 'farmerList'])->name('farmerList');
    Route::get('/farmerList/ajax/{id}', [App\Http\Controllers\User\FarmerListController::class, 'farmerListAjax'])->name('farmerListAjax');
    Route::post('/addFarmer', [App\Http\Controllers\User\FarmerListController::class, 'addFarmer'])->name('addFarmer');
    Route::post('/updateFarmer/{id}', [App\Http\Controllers\User\FarmerListController::class, 'updateFarmer'])->name('updateFarmer');
    Route::post('/deleteFarmer/{id}', [App\Http\Controllers\User\FarmerListController::class, 'deleteFarmer'])->name('deleteFarmer');
    //Farmer Profile
    Route::get('/farmerList/farmerProfile/{id}', [App\Http\Controllers\User\FarmerProfileController::class, 'farmerProfile'])->name('farmerProfile');
    Route::post('/compose/{id}', [App\Http\Controllers\User\FarmerProfileController::class, 'compose'])->name('compose');
    Route::post('/updateCrop/{id}', [App\Http\Controllers\User\FarmerProfileController::class, 'updateCrop'])->name('updateCrop');
    Route::post('/deleteCrop/{id}', [App\Http\Controllers\User\FarmerProfileController::class, 'deleteCrop'])->name('deleteCrop');
    Route::post('/uploadActivity/{id}', [App\Http\Controllers\User\FarmerProfileController::class, 'uploadActivity'])->name('uploadActivity');
    //Crop Calendar
    Route::get('/cropCalendar', [App\Http\Controllers\User\CropCalendarController::class, 'cropCalendar'])->name('cropCalendar');
    //Crop Monitoring
    Route::get('/cropMonitoring', [App\Http\Controllers\User\CropMonitoringController::class, 'cropMonitoring'])->name('cropMonitoring');
    //Yield Monitoring
    Route::get('/yieldMonitoring', [App\Http\Controllers\User\YieldMonitoringController::class, 'yieldMonitoring'])->name('yieldMonitoring');
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