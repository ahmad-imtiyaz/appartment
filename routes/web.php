<?php

use App\Http\Controllers\Admin\DashboardController;
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
| Default
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Public Product Listings
|--------------------------------------------------------------------------
*/

Route::get('/product-listings', [AdminProductListingController::class, 'publicIndex'])
    ->name('product-listings.index');

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
|
| Setelah login, user diarahkan berdasarkan role:
| admin    -> Admin Dashboard
| pekerja  -> Worker Tasks
| guest    -> Guest Home
|
*/

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if ($user->role === 'pekerja') {
        return redirect()->route('worker.tasks.index');
    }

    if ($user->role === 'guest') {
        return redirect()->route('guest.home');
    }

    abort(403, 'Role tidak dikenali.');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Guest (role: guest) — Penyewa Apartemen
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:guest'])
    ->prefix('guest')
    ->name('guest.')
    ->group(function () {

        /*
        | Guest Home
        */

        Route::get('/home', function () {
            return view('guest.home');
        })->name('home');

        /*
        | Service Requests
        */

        Route::get('/service-requests', [GuestServiceRequestController::class, 'index'])
            ->name('service-requests.index');

        Route::get('/service-requests/category/{category}', [GuestServiceRequestController::class, 'category'])
            ->name('service-requests.category');

        Route::get('/service-requests/create', [GuestServiceRequestController::class, 'create'])
            ->name('service-requests.create');

        Route::post('/service-requests', [GuestServiceRequestController::class, 'store'])
            ->name('service-requests.store');

        Route::get('/service-requests/{serviceRequest}', [GuestServiceRequestController::class, 'show'])
            ->name('service-requests.show');

        Route::delete('/service-requests/{serviceRequest}', [GuestServiceRequestController::class, 'destroy'])
            ->name('service-requests.destroy');

        /*
        | Service Detail (per service type)
        */

        Route::get('/services/{slug}', [GuestServiceRequestController::class, 'serviceDetail'])
            ->name('services.show');

        /*
        | Feedback
        */

        Route::post('/service-requests/{serviceRequest}/feedback', [FeedbackController::class, 'store'])
            ->name('service-requests.feedback');

        /*
        | Top Up
        */

        Route::get('/topups', [GuestTopupController::class, 'index'])
            ->name('topups.index');

        Route::get('/topups/create', [GuestTopupController::class, 'create'])
            ->name('topups.create');

        Route::post('/topups', [GuestTopupController::class, 'store'])
            ->name('topups.store');

        /*
        | Balance
        */

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

        /*
        | Admin Dashboard
        */

        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');

        /*
        | Workers
        */

        Route::get('/workers', [WorkerController::class, 'index'])
            ->name('workers.index');

        Route::post('/workers', [WorkerController::class, 'store'])
            ->name('workers.store');

        /*
        | Payment Methods
        */

        Route::get('/payment-methods', [AdminPaymentMethodController::class, 'index'])
            ->name('payment-methods.index');

        Route::post('/payment-methods', [AdminPaymentMethodController::class, 'store'])
            ->name('payment-methods.store');

        Route::put('/payment-methods/{paymentMethod}', [AdminPaymentMethodController::class, 'update'])
            ->name('payment-methods.update');

        Route::delete('/payment-methods/{paymentMethod}', [AdminPaymentMethodController::class, 'destroy'])
            ->name('payment-methods.destroy');

        /*
        | Top Ups
        */

        Route::get('/topups', [AdminTopupController::class, 'index'])
            ->name('topups.index');

        Route::post('/topups/{topupRequest}/approve', [AdminTopupController::class, 'approve'])
            ->name('topups.approve');

        Route::post('/topups/{topupRequest}/reject', [AdminTopupController::class, 'reject'])
            ->name('topups.reject');

        /*
        | Service Requests
        */

        Route::get('/service-requests', [AdminServiceRequestController::class, 'index'])
            ->name('service-requests.index');

        Route::get('/service-requests/{serviceRequest}', [AdminServiceRequestController::class, 'show'])
            ->name('service-requests.show');

        Route::post('/service-requests/{serviceRequest}/assign', [AdminServiceRequestController::class, 'assign'])
            ->name('service-requests.assign');

        /*
        | Product Listings
        */

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

        /*
        | Worker Tasks
        */

        Route::get('/tasks', [TaskController::class, 'index'])
            ->name('tasks.index');

        Route::get('/tasks/{serviceRequest}', [TaskController::class, 'show'])
            ->name('tasks.show');

        Route::post('/tasks/{serviceRequest}/accept', [TaskController::class, 'accept'])
            ->name('tasks.accept');

        Route::post('/tasks/{serviceRequest}/complete', [TaskController::class, 'complete'])
            ->name('tasks.complete');
    });

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
