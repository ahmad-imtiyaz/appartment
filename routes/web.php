<?php

use App\Http\Controllers\Admin\PaymentMethodController as AdminPaymentMethodController;
use App\Http\Controllers\Admin\ProductListingController as AdminProductListingController;
use App\Http\Controllers\Admin\ServiceRequestController as AdminServiceRequestController;
use App\Http\Controllers\Admin\TopupController as AdminTopupController;
use App\Http\Controllers\Admin\WorkerController;
use App\Http\Controllers\Guest\FeedbackController;
use App\Http\Controllers\Guest\ServiceRequestController as GuestServiceRequestController;
use App\Http\Controllers\Guest\TopupController as GuestTopupController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Worker\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Default (bawaan Breeze)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Public product listings (accessible to everyone)
Route::get('/product-listings', [AdminProductListingController::class, 'publicIndex'])
    ->name('product-listings.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Guest (role: guest) — penyewa apartemen
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:guest'])
    ->prefix('guest')
    ->name('guest.')
    ->group(function () {

        // Home / dashboard guest — dipakai sebagai landing tab "Home" di bottom navbar
        Route::get('/home', function () {
            return view('guest.home');
        })->name('home');

        Route::get('/service-requests', [GuestServiceRequestController::class, 'index'])
            ->name('service-requests.index');

        // Halaman kategori jasa (Laundry, Cleaning, Repair & Maintenance, AC)
        Route::get('/service-requests/category/{category}', [GuestServiceRequestController::class, 'category'])
            ->name('service-requests.category');

        Route::get('/service-requests/create', [GuestServiceRequestController::class, 'create'])
            ->name('service-requests.create');
        Route::post('/service-requests', [GuestServiceRequestController::class, 'store'])
            ->name('service-requests.store');
        Route::get('/service-requests/{serviceRequest}', [GuestServiceRequestController::class, 'show'])
            ->name('service-requests.show');

        Route::post('/service-requests/{serviceRequest}/feedback', [FeedbackController::class, 'store'])
            ->name('service-requests.feedback');

        Route::get('/topups', [GuestTopupController::class, 'index'])
            ->name('topups.index');
        Route::get('/topups/create', [GuestTopupController::class, 'create'])
            ->name('topups.create');
        Route::post('/topups', [GuestTopupController::class, 'store'])
            ->name('topups.store');

        Route::get('/balance', [GuestTopupController::class, 'balance'])
            ->name('balance');
    });

/*
|--------------------------------------------------------------------------
| Admin (role: admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::get('/workers', [WorkerController::class, 'index'])
            ->name('workers.index');
        Route::post('/workers', [WorkerController::class, 'store'])
            ->name('workers.store');

        Route::get('/payment-methods', [AdminPaymentMethodController::class, 'index'])
            ->name('payment-methods.index');
        Route::post('/payment-methods', [AdminPaymentMethodController::class, 'store'])
            ->name('payment-methods.store');
        Route::put('/payment-methods/{paymentMethod}', [AdminPaymentMethodController::class, 'update'])
            ->name('payment-methods.update');
        Route::delete('/payment-methods/{paymentMethod}', [AdminPaymentMethodController::class, 'destroy'])
            ->name('payment-methods.destroy');

        Route::get('/topups', [AdminTopupController::class, 'index'])
            ->name('topups.index');
        Route::post('/topups/{topupRequest}/approve', [AdminTopupController::class, 'approve'])
            ->name('topups.approve');
        Route::post('/topups/{topupRequest}/reject', [AdminTopupController::class, 'reject'])
            ->name('topups.reject');

        Route::get('/service-requests', [AdminServiceRequestController::class, 'index'])
            ->name('service-requests.index');
        Route::get('/service-requests/{serviceRequest}', [AdminServiceRequestController::class, 'show'])
            ->name('service-requests.show');
        Route::post('/service-requests/{serviceRequest}/assign', [AdminServiceRequestController::class, 'assign'])
            ->name('service-requests.assign');

        Route::get('/product-listings', [AdminProductListingController::class, 'index'])
            ->name('product-listings.index');
        Route::post('/product-listings', [AdminProductListingController::class, 'store'])
            ->name('product-listings.store');
        Route::put('/product-listings/{productListing}', [AdminProductListingController::class, 'update'])
            ->name('product-listings.update');
        Route::delete('/product-listings/{productListing}', [AdminProductListingController::class, 'destroy'])
            ->name('product-listings.destroy');
    });

/*
|--------------------------------------------------------------------------
| Worker / Pekerja (role: pekerja)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:pekerja'])
    ->prefix('worker')
    ->name('worker.')
    ->group(function () {
        Route::get('/tasks', [TaskController::class, 'index'])
            ->name('tasks.index');
        Route::get('/tasks/{serviceRequest}', [TaskController::class, 'show'])
            ->name('tasks.show');
        Route::post('/tasks/{serviceRequest}/accept', [TaskController::class, 'accept'])
            ->name('tasks.accept');
        Route::post('/tasks/{serviceRequest}/complete', [TaskController::class, 'complete'])
            ->name('tasks.complete');
    });

require __DIR__.'/auth.php';
