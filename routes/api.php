<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgetPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
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




Route::post('/register/insert', [RegisterController::class, 'Register'])->name('Register');
Route::post('/register/validate', [RegisterController::class, 'ValidateRegister'])->name('ValidateRegister');
Route::post('/forgot_password', [ForgetPasswordController::class, 'ForgetPassword'])->name('password.email');
Route::post('/reset-password', [ResetPasswordController::class, 'ResetPassword'])->name('password.reset');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'GetResetPassword'])->name('password.reset');



