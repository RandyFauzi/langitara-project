<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\PublicHomeController;
use App\Http\Controllers\Public\TemplateController;
use App\Http\Controllers\Public\PricingController;
use App\Http\Controllers\Public\TemplateAssetController;

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

    // Template Assets Route
    Route::get('templates/{slug}/assets/{type}/{file}', [TemplateAssetController::class, 'show'])->name('templates.assets');

    // Public Invitation Access
    Route::get('/invitation/{slug}', [\App\Http\Controllers\Public\PublicInvitationController::class, 'show'])->name('invitation.show');

    // Public API Routes (grouped for logic separation)
    Route::post('/rsvp', [\App\Http\Controllers\Public\PublicRsvpController::class, 'store'])->name('rsvp.store');
});

// Payment Routes
Route::get('/checkout/{package:slug}', [App\Http\Controllers\PaymentController::class, 'checkout'])->name('checkout');
Route::post('/payment/snap-token', [App\Http\Controllers\PaymentController::class, 'createSnapToken'])->name('payment.snap-token')->middleware('auth');
Route::get('/checkout/finish', [App\Http\Controllers\PaymentController::class, 'finish'])->name('checkout.finish');

// Payment Status Routes (requires auth)
Route::middleware('auth')->group(function () {
    Route::get('/payment/status', [App\Http\Controllers\PaymentController::class, 'status'])->name('payment.status');
    Route::post('/payment/{userPackage}/continue', [App\Http\Controllers\PaymentController::class, 'continuePayment'])->name('payment.continue');
    Route::delete('/payment/{userPackage}/cancel', [App\Http\Controllers\PaymentController::class, 'cancelPayment'])->name('payment.cancel');
});

// Midtrans Webhook (exclude from CSRF)
Route::post('/payment/notification', [App\Http\Controllers\PaymentController::class, 'notification'])->name('payment.notification');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [App\Http\Controllers\Auth\AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\AuthController::class, 'login']);
    Route::get('/register', [App\Http\Controllers\Auth\AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [App\Http\Controllers\Auth\AuthController::class, 'register']);
});

Route::post('/logout', [App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('logout')->middleware('auth');


// Dashboard Routes (User)
Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.', 'middleware' => ['auth']], function () {
    Route::get('/', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('index');
    Route::get('/account', [App\Http\Controllers\User\UserAccountController::class, 'index'])->name('account');
    Route::put('/account', [App\Http\Controllers\User\UserAccountController::class, 'update'])->name('account.update');
    Route::get('/account/password', [App\Http\Controllers\User\UserAccountController::class, 'password'])->name('account.password');
    Route::put('/account/password', [App\Http\Controllers\User\UserAccountController::class, 'updatePassword'])->name('account.password.update');
});

// Editor Routes (Authenticated Users)
Route::middleware(['auth'])->group(function () {
    Route::group(['as' => 'editor.'], function () {
        // Main Editor UI
        Route::get('/editor/{slug}', [\App\Http\Controllers\EditorController::class, 'edit'])->name('edit');
        Route::post('/editor/{slug}', [\App\Http\Controllers\EditorController::class, 'update'])->name('update');
        Route::post('/editor/{slug}/publish', [\App\Http\Controllers\EditorController::class, 'publish'])->name('publish');
        Route::post('/editor/{slug}/music', [\App\Http\Controllers\EditorController::class, 'updateMusic'])->name('music.update');
        Route::delete('/editor/{slug}/music', [\App\Http\Controllers\EditorController::class, 'destroyMusic'])->name('music.destroy');
        Route::post('/editor/media/upload', [\App\Http\Controllers\EditorController::class, 'uploadImage'])->name('media.upload');

        // Guest Management Routes
        Route::get('/editor/{slug}/guests', [\App\Http\Controllers\User\GuestController::class, 'index'])->name('guests.index');
        Route::post('/editor/{slug}/guests', [\App\Http\Controllers\User\GuestController::class, 'store'])->name('guests.store');
        Route::put('/editor/{slug}/guests/{guest}', [\App\Http\Controllers\User\GuestController::class, 'update'])->name('guests.update');
        Route::delete('/editor/{slug}/guests/{guest}', [\App\Http\Controllers\User\GuestController::class, 'destroy'])->name('guests.destroy');
        Route::get('/editor/{slug}/guests/{guest}/link', [\App\Http\Controllers\User\GuestController::class, 'getLink'])->name('guests.link');
        Route::get('/editor/{slug}/guests/template', [\App\Http\Controllers\User\GuestController::class, 'downloadTemplate'])->name('guests.template');
        Route::post('/editor/{slug}/guests/import', [\App\Http\Controllers\User\GuestController::class, 'import'])->name('guests.import');

        // RSVP Stats & Wishes Management
        Route::get('/editor/{slug}/stats', [\App\Http\Controllers\User\GuestController::class, 'stats'])->name('stats');
        Route::get('/editor/{slug}/wishes', [\App\Http\Controllers\User\GuestController::class, 'wishes'])->name('wishes.index');
        Route::patch('/editor/{slug}/wishes/{rsvp}/toggle', [\App\Http\Controllers\User\GuestController::class, 'toggleWishVisibility'])->name('wishes.toggle');
        Route::delete('/editor/{slug}/wishes/{rsvp}', [\App\Http\Controllers\User\GuestController::class, 'destroyWish'])->name('wishes.destroy');
    });
});

// Admin Routes
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'role:admin']], function () {
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
    Route::patch('/user-packages/{userPackage}/status', [App\Http\Controllers\Admin\UserController::class, 'updatePackageStatus'])->name('user-packages.update-status');
    Route::patch('/users/{user}/package', [App\Http\Controllers\Admin\UserController::class, 'changeUserPackage'])->name('users.change-package');

    // Invitations Module
    Route::resource('invitations', App\Http\Controllers\Admin\InvitationController::class)->only(['index', 'show', 'create', 'store']);
    Route::get('/invitations/{invitation}/editor', [App\Http\Controllers\Admin\InvitationEditorPageController::class, 'show'])->name('invitations.editor');
    Route::post('/invitations/{invitation}/impersonate', [App\Http\Controllers\Admin\InvitationController::class, 'impersonate'])->name('invitations.impersonate');

    // Activity Logs
    Route::get('/activity-logs', [App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('activity-logs.index');
    Route::get('/activity-logs/{log}', [App\Http\Controllers\Admin\ActivityLogController::class, 'show'])->name('activity-logs.show');

    // RSVP Module
    Route::resource('rsvps', App\Http\Controllers\Admin\RsvpController::class)->only(['index', 'show']);

    // Templates
    Route::resource('templates', \App\Http\Controllers\Admin\TemplateController::class);
    Route::patch('templates/{template}/toggle', [\App\Http\Controllers\Admin\TemplateController::class, 'toggleStatus'])->name('templates.toggle');
    Route::get('templates/{id}/preview', [\App\Http\Controllers\Admin\TemplateController::class, 'preview'])->name('templates.preview');

    // Music
    Route::resource('songs', \App\Http\Controllers\Admin\SongController::class)->except(['create', 'edit', 'show']);



});
