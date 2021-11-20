<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\ForgetPasswordController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\UserBlogController;
use App\Http\Controllers\UsersettingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/




//Follow/Unfollow blog
Route::post('/user/follow', 'App\Http\Controllers\UserBlogConroller@follow');
Route::delete('/user/follow', 'App\Http\Controllers\UserBlogConroller@unfollow');

Route::get('blog/{id}/settings', [BlogSettingController::class, 'getBlogSettings'])->name('getBlogSettings')->middleware('auth:api');

Route::post('/register/insert', [RegisterController::class, 'Register'])->name('Register');
Route::post('/register/validate', [RegisterController::class, 'ValidateRegister'])->name('ValidateRegister');
Route::post('/forgot_password', [ForgetPasswordController::class, 'ForgetPassword'])->name('password.email');
Route::post('/reset-password', [ResetPasswordController::class, 'ResetPassword'])->name('password.reset');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'GetResetPassword'])->name('password.reset');

Route::post('login', [LoginController::class, 'Login']);
Route::post('logout', [LoginController::class, 'Logout'])->middleware('auth:api');

Route::post('email/verification-notification', [EmailVerificationController::class, 'SendVerificationEmail'])->name('verification.send')->middleware('auth:api');
Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'Verify'])->name('verification.verify')->middleware('auth:api');

// setting routes
Route::middleware('auth:api')->group(function () {
    Route::get('/settings/account', [UsersettingController::class, 'AccountSettings'])->name('GetAccountSetting');
    Route::get('/settings/dashboard', [UsersettingController::class, 'DashboardSetting'])->name('GetDashboardSetting');
    Route::get('/settings',[UsersettingController::class, 'AccountSettings'])->name('GetAccountSetting');
    Route::get('/info',[UserController::class, 'GetUserInfo'])->name('GetUser_Info');

});


// google
Route::get('auth/google', [GoogleController::class, 'Googlelogin']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);


// Create/Delete blog
Route::post('/blog', [UserBlogController::class, 'create']);
Route::delete('/blog/{url}', [UserBlogController::class, 'destroy']);