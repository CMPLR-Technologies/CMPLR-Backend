<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\ForgetPasswordController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogSettingsController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserBlogController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsersettingController;
use Illuminate\Support\Facades\Route;

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

// Search
Route::get('search/{query}', [SearchController::class, 'search']);

// Follow/Unfollow blog
Route::post('/user/follow', [UserBlogController::class, 'follow'])->middleware('auth:api');

Route::delete('/user/follow', [UserBlogController::class, 'unfollow'])->middleware('auth:api');

// Create/Delete blog
Route::post('/blog', [UserBlogController::class, 'create'])->middleware('auth:api');
Route::delete('/blog/{url}', [UserBlogController::class, 'destroy'])->middleware('auth:api');

Route::post('/register/insert', [RegisterController::class, 'Register'])->name('Register');
Route::post('/register/validate', [RegisterController::class, 'ValidateRegister'])->name('ValidateRegister')->middleware('cors:api');
Route::post('/forgot_password', [ForgetPasswordController::class, 'ForgetPassword'])->name('password.email');
Route::post('/reset-password', [ResetPasswordController::class, 'ResetPassword'])->name('password.reset');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'GetResetPassword'])->name('password.reset');

Route::post('/login', [LoginController::class, 'Login']);
Route::post('/logout', [LoginController::class, 'Logout'])->middleware('auth:api');

Route::post('email/verification-notification', [EmailVerificationController::class, 'SendVerificationEmail'])->name('verification.send')->middleware('auth:api');
Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'Verify'])->name('verification.verify')->middleware('auth:api');

// Settings routes
Route::middleware('auth:api')->group(function () {
    Route::get('blog/{blog}/settings', [BlogSettingsController::class, 'getBlogSettings'])->name('getBlogSettings');
    Route::put('blog/{blog}/settings/save', [BlogSettingsController::class, 'saveBlogSettings'])->name('saveBlogSettings');
    Route::put('blog/{blog}/settings/theme', [BlogSettingsController::class, 'editBlogTheme'])->name('editBlogTheme');


    Route::get('/settings', [UsersettingController::class, 'AccountSettings'])->name('GetAccountSetting');
    Route::get('info', [UserController::class, 'GetUserInfo'])->name('GetUser_Info');

    Route::get('/settings', [UsersettingController::class, 'AccountSettings'])->name('GetAccountSetting');
    Route::put('/settings', [UsersettingController::class, 'UpdateSettings'])->name('UpdateAccountSetting');
    Route::put('/settings/change-email', [UsersettingController::class, 'ChangeEmail'])->name('Change Email');
    Route::put('/settings/change-password',[UsersettingController::class, 'ChangePassword'])->name('Change Password');
});
//blogs
Route::middleware(['auth:api'])->group(function () {
    Route::get('/blog/{blog_name}/followers', [BlogController::class, 'GetFollowers'])->name('GetBlogFollowers');
});


// Google
Route::get('auth/google', [GoogleController::class, 'GoogleLogin'])->middleware('web');
Route::any('auth/callback', [GoogleController::class, 'handleGoogleCallback'])->middleware('web');
