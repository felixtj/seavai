<?php

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\EmailVerificationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])->name('home');

// ── Google OAuth ──────────────────────────────────────────────────────────────
Route::get('/auth/google',          [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// ── Email Auth (guests only) ──────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login',   [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register',[RegisterController::class, 'register']);

    Route::get('/forgot-password',        [PasswordResetController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password',       [PasswordResetController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password',        [PasswordResetController::class, 'resetPassword'])->name('password.update');
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// ── Email Verification ────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/email/verify',             [EmailVerificationController::class, 'notice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
         ->middleware('signed')->name('verification.verify');
    Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])
         ->middleware('throttle:6,1')->name('verification.send');
});

// ── Protected app routes ──────────────────────────────────────────────────────
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard',  fn () => view('app.dashboard'))->name('dashboard');
    Route::get('/onboarding', fn () => view('app.onboarding'))->name('onboarding');
});

// ── Public pages ──────────────────────────────────────────────────────────────
Route::get('/privacy', fn () => view('privacy'))->name('privacy');

// ── Demo / clickable prototype (no auth, no DB) ──────────────────────────────
Route::prefix('demo')->name('demo.')->group(function () {
    Route::get('/', fn () => redirect()->route('demo.login'));
    Route::get('/login',        [DemoController::class, 'login'])->name('login');
    Route::get('/onboarding',   [DemoController::class, 'onboarding'])->name('onboarding');
    Route::get('/dashboard',    [DemoController::class, 'dashboard'])->name('dashboard');
    Route::get('/resume',       [DemoController::class, 'resume'])->name('resume');
    Route::get('/jobs',         [DemoController::class, 'jobs'])->name('jobs');
    Route::get('/jobs/{id}',    [DemoController::class, 'jobShow'])->name('jobs.show');
    Route::get('/matches',      [DemoController::class, 'matches'])->name('matches');
    Route::post('/chat',        [DemoController::class, 'chat'])->name('chat');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn () => redirect()->route('admin.dashboard'));
    Route::get('/dashboard',                [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/stats',          [AdminController::class, 'stats'])->name('dashboard.stats');
    Route::get('/jobs',                     [AdminController::class, 'jobs'])->name('jobs');
    Route::get('/jobs/{job}/drawer',        [AdminController::class, 'jobDrawer'])->name('jobs.drawer');
    Route::patch('/jobs/{job}/status',      [AdminController::class, 'updateStatus'])->name('jobs.status');
});
