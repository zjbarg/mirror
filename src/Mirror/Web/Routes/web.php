<?php

use Illuminate\Support\Facades\Route;
use Mirror\Web\EndPoints\Auth;

Route::view('/', 'welcome');

Route::middleware('guest')->group(function () {
    Route::get('register', [Auth\Registration\RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [Auth\Registration\RegisteredUserController::class, 'store']);
    Route::get('login', [Auth\Session\AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [Auth\Session\AuthenticatedSessionController::class, 'store']);
    Route::get('forgot-password', [Auth\PasswordReset\PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [Auth\PasswordReset\PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [Auth\PasswordReset\NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [Auth\PasswordReset\NewPasswordController::class, 'store'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::view('dashboard', 'dashboard')->middleware(['auth'])->name('dashboard');
    Route::get('confirm-password', [Auth\PasswordReset\ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('confirm-password', [Auth\PasswordReset\ConfirmablePasswordController::class, 'store']);
    Route::post('logout', [Auth\Session\AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
