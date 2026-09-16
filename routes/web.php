<?php

use App\Http\Controllers\Admin\PaymentMethodController as AdminPaymentMethodController;
use App\Http\Controllers\Admin\ProductListingController as AdminProductListingController;
use App\Http\Controllers\Admin\ServiceRequestController as AdminServiceRequestController;
use App\Http\Controllers\Admin\TopupController as AdminTopupController;
use App\Http\Controllers\Admin\WorkerController;
use App\Http\Controllers\Guest\FeedbackController;
use App\Http\Controllers\Guest\ServiceRequestController as GuestServiceRequestController;
use App\Http\Controllers\Guest\TopupController as GuestTopupController;
use App\Http\Controllers\Worker\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

// TODO: kalau info jual-beli mau bisa dilihat tanpa login juga, bikin controller
// khusus buat display-only-nya (misal Public\ProductListingController@index).
// Untuk sekarang belum ada endpoint publiknya.

/*
|--------------------------------------------------------------------------
| Guest (role: guest) — penyewa apartemen
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:guest'])
    ->prefix('guest')
    ->name('guest.')
    ->group(function () {
        Route::get('/service-requests', [GuestServiceRequestController::class, 'index'])
            ->name('service-requests.index');
        Route::post('/service-requests', [GuestServiceRequestController::class, 'store'])
            ->name('service-requests.store');

        Route::post('/service-requests/{serviceRequest}/feedback', [FeedbackController::class, 'store'])
            ->name('service-requests.feedback');

        Route::get('/topups', [GuestTopupController::class, 'index'])
            ->name('topups.index');
        Route::post('/topups', [GuestTopupController::class, 'store'])
            ->name('topups.store');
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
        Route::post('/tasks/{serviceRequest}/accept', [TaskController::class, 'accept'])
            ->name('tasks.accept');
        Route::post('/tasks/{serviceRequest}/complete', [TaskController::class, 'complete'])
            ->name('tasks.complete');
    });

require __DIR__.'/auth.php';
