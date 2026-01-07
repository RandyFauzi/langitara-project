<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\PublicHomeController;
use App\Http\Controllers\Public\TemplateController;
use App\Http\Controllers\Public\PricingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::group(['as' => 'public.'], function () {
    Route::get('/', [PublicHomeController::class, 'index'])->name('home');

    Route::get('/templates', [TemplateController::class, 'index'])->name('templates.index');
    Route::get('/templates/{slug}', [TemplateController::class, 'show'])->name('templates.show');

    Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');

    Route::view('/about', 'pages.public.about')->name('about');
});

// Auth Routes (Placeholder)
Route::get('/login', function () {
    return 'Login Page';
})->name('login');
Route::get('/register', function () {
    return 'Register Page';
})->name('register');

// Dashboard Routes (Placeholder)
Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.', 'middleware' => ['auth']], function () {
    Route::get('/', function () {
        return 'User Dashboard';
    })->name('index');
});

// Admin Routes
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Orders Module
    Route::get('/orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');

    // Packages Module
    Route::get('/packages', [App\Http\Controllers\Admin\PackageController::class, 'index'])->name('packages.index');
    Route::post('/packages', [App\Http\Controllers\Admin\PackageController::class, 'store'])->name('packages.store');
    Route::put('/packages/{package}', [App\Http\Controllers\Admin\PackageController::class, 'update'])->name('packages.update');
    Route::patch('/packages/{package}/toggle', [App\Http\Controllers\Admin\PackageController::class, 'toggleStatus'])->name('packages.toggle');
    Route::delete('/packages/{package}', [App\Http\Controllers\Admin\PackageController::class, 'destroy'])->name('packages.destroy');

    // Promos Module
    Route::resource('promos', App\Http\Controllers\Admin\PromoController::class);

    // Users Module
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::post('/users/{user}/reset-password', [App\Http\Controllers\Admin\UserController::class, 'resetPassword'])->name('users.reset-password');

    // Invitations Module
    Route::resource('invitations', App\Http\Controllers\Admin\InvitationController::class)->only(['index', 'show']);
    Route::post('/invitations/{invitation}/impersonate', [App\Http\Controllers\Admin\InvitationController::class, 'impersonate'])->name('invitations.impersonate');

    // Activity Logs
    Route::get('/activity-logs', [App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activity-logs.index');
    Route::get('/activity-logs/{log}', [App\Http\Controllers\Admin\ActivityLogController::class, 'show'])->name('activity-logs.show');

    // RSVP Module
    Route::resource('rsvps', App\Http\Controllers\Admin\RsvpController::class)->only(['index', 'show']);

    // Templates
    Route::resource('templates', \App\Http\Controllers\Admin\TemplateController::class);
    Route::get('templates/{id}/preview', [\App\Http\Controllers\Admin\TemplateController::class, 'preview'])->name('templates.preview');

    // Music
    Route::resource('songs', \App\Http\Controllers\Admin\SongController::class)->except(['create', 'edit', 'show']);

});

// Admin Routes (Placeholder)
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'role:admin']], function () {
    Route::get('/', function () {
        return 'Admin Dashboard';
    })->name('index');
});
