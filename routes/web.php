<?php

use App\Http\Controllers\Admin\CoinRedemptionController as AdminCoinRedemptionController;
use App\Http\Controllers\Admin\CoinRedemptionProductController;
use App\Http\Controllers\Admin\CoinSettingController;
use App\Http\Controllers\Admin\CleaningAreaController;
use App\Http\Controllers\Admin\CleaningAddonController;
use App\Http\Controllers\Admin\CleaningPricingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PaymentMethodController as AdminPaymentMethodController;
use App\Http\Controllers\Admin\ProductListingController as AdminProductListingController;
use App\Http\Controllers\Admin\ServiceRequestController as AdminServiceRequestController;
use App\Http\Controllers\Admin\TopupController as AdminTopupController;
use App\Http\Controllers\Admin\WorkerController;
use App\Http\Controllers\Guest\CoinRedemptionController as GuestCoinRedemptionController;
use App\Http\Controllers\Guest\FeedbackController;
use App\Http\Controllers\Guest\ProfileController as GuestProfileController;
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
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Language / Locale
|--------------------------------------------------------------------------
|
| Route ini berada di luar middleware auth agar halaman login,
| register, dan halaman publik lainnya juga dapat mengganti bahasa.
|
*/

Route::get('/lang/{locale}', [\App\Http\Controllers\LocaleController::class, 'switch'])
    ->name('lang.switch');

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
| Guest (role: guest) — Penyewa Apartemen
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:guest'])
    ->prefix('guest')
    ->name('guest.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Guest Home
        |--------------------------------------------------------------------------
        */

        Route::get('/home', function () {
            $listings = \App\Models\ProductListing::where('is_active', true)
                ->latest()
                ->take(3)
                ->get();

            return view('guest.home', compact('listings'));
        })->name('home');

        /*
        |--------------------------------------------------------------------------
        | Service Requests
        |--------------------------------------------------------------------------
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

        Route::post('/service-requests/{serviceRequest}/approve-price', [GuestServiceRequestController::class, 'approvePrice'])
            ->name('service-requests.approve-price');

        Route::post('/service-requests/{serviceRequest}/reject-price', [GuestServiceRequestController::class, 'rejectPrice'])
            ->name('service-requests.reject-price');

        Route::post('/service-requests/{serviceRequest}/pay-laundry', [GuestServiceRequestController::class, 'payLaundry'])
            ->name('service-requests.pay-laundry');

        /*
        |--------------------------------------------------------------------------
        | Service Detail (per service type)
        |--------------------------------------------------------------------------
        */

        Route::get('/services/{slug}', [GuestServiceRequestController::class, 'serviceDetail'])
            ->name('services.show');

        /*
        |--------------------------------------------------------------------------
        | Feedback
        |--------------------------------------------------------------------------
        */

        Route::post('/service-requests/{serviceRequest}/feedback', [FeedbackController::class, 'store'])
            ->name('service-requests.feedback');

        /*
        |--------------------------------------------------------------------------
        | Top Up
        |--------------------------------------------------------------------------
        */

        Route::get('/topups', [GuestTopupController::class, 'index'])
            ->name('topups.index');

        Route::get('/topups/create', [GuestTopupController::class, 'create'])
            ->name('topups.create');

        Route::post('/topups', [GuestTopupController::class, 'store'])
            ->name('topups.store');

        /*
        |--------------------------------------------------------------------------
        | Balance
        |--------------------------------------------------------------------------
        */

        Route::get('/balance', [GuestTopupController::class, 'balance'])
            ->name('balance');

        /*
        |--------------------------------------------------------------------------
        | Profile
        |--------------------------------------------------------------------------
        */

        Route::get('/profile', [GuestProfileController::class, 'edit'])
            ->name('profile.edit');

        Route::patch('/profile', [GuestProfileController::class, 'update'])
            ->name('profile.update');

        Route::delete('/profile', [GuestProfileController::class, 'destroy'])
            ->name('profile.destroy');

        /*
        |--------------------------------------------------------------------------
        | Coin Redemptions
        |--------------------------------------------------------------------------
        */

        Route::get('/coin-redemptions', [GuestCoinRedemptionController::class, 'index'])
            ->name('coin-redemptions.index');

        Route::post('/coin-redemptions', [GuestCoinRedemptionController::class, 'store'])
            ->name('coin-redemptions.store');

        Route::delete('/coin-redemptions/{coinRedemption}', [GuestCoinRedemptionController::class, 'cancel'])
            ->name('coin-redemptions.cancel');
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
        |--------------------------------------------------------------------------
        | Admin Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | Profile
        |--------------------------------------------------------------------------
        */

        Route::get('/profile', [ProfileController::class, 'edit'])
            ->name('profile.edit');

        Route::patch('/profile', [ProfileController::class, 'update'])
            ->name('profile.update');

        Route::delete('/profile', [ProfileController::class, 'destroy'])
            ->name('profile.destroy');

        /*
        |--------------------------------------------------------------------------
        | Workers
        |--------------------------------------------------------------------------
        */

        Route::get('/workers', [WorkerController::class, 'index'])
            ->name('workers.index');

        Route::post('/workers', [WorkerController::class, 'store'])
            ->name('workers.store');

        /*
        |--------------------------------------------------------------------------
        | Payment Methods
        |--------------------------------------------------------------------------
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
        |--------------------------------------------------------------------------
        | Top Ups
        |--------------------------------------------------------------------------
        */

        Route::get('/topups', [AdminTopupController::class, 'index'])
            ->name('topups.index');

        Route::post('/topups/{topupRequest}/approve', [AdminTopupController::class, 'approve'])
            ->name('topups.approve');

        Route::post('/topups/{topupRequest}/reject', [AdminTopupController::class, 'reject'])
            ->name('topups.reject');

        /*
        |--------------------------------------------------------------------------
        | Service Requests
        |--------------------------------------------------------------------------
        */

        Route::get('/service-requests', [AdminServiceRequestController::class, 'index'])
            ->name('service-requests.index');

        Route::get('/service-requests/{serviceRequest}', [AdminServiceRequestController::class, 'show'])
            ->name('service-requests.show');

        Route::post('/service-requests/{serviceRequest}/assign', [AdminServiceRequestController::class, 'assign'])
            ->name('service-requests.assign');

        Route::post('/service-requests/{serviceRequest}/set-price', [AdminServiceRequestController::class, 'setPrice'])
            ->name('service-requests.set-price');

        /*
        |--------------------------------------------------------------------------
        | Laundry Pricing
        |--------------------------------------------------------------------------
        */

        Route::resource('laundry-pricings', \App\Http\Controllers\Admin\LaundryPricingController::class)
            ->parameters(['laundry-pricings' => 'pricing'])
            ->except(['show', 'update']);

        Route::put('/laundry-pricings/{pricing}', [\App\Http\Controllers\Admin\LaundryPricingController::class, 'update'])
            ->name('laundry-pricings.update');



        /*
        |--------------------------------------------------------------------------
        | MnR / Repair Pricing
        |--------------------------------------------------------------------------
        */

        Route::get('repair-pricings', [\App\Http\Controllers\Admin\RepairPricingController::class, 'index'])
            ->name('repair-pricings.index');

        Route::get('repair-pricings/create', [\App\Http\Controllers\Admin\RepairPricingController::class, 'create'])
            ->name('repair-pricings.create');

        Route::post('repair-pricings', [\App\Http\Controllers\Admin\RepairPricingController::class, 'store'])
            ->name('repair-pricings.store');

        Route::get('repair-pricings/{pricing}/edit', [\App\Http\Controllers\Admin\RepairPricingController::class, 'edit'])
            ->name('repair-pricings.edit');

        Route::put('repair-pricings/{pricing}', [\App\Http\Controllers\Admin\RepairPricingController::class, 'update'])
            ->name('repair-pricings.update');

        Route::patch('repair-pricings/{pricing}/toggle', [\App\Http\Controllers\Admin\RepairPricingController::class, 'toggle'])
            ->name('repair-pricings.toggle');

        Route::delete('repair-pricings/{pricing}', [\App\Http\Controllers\Admin\RepairPricingController::class, 'destroy'])
            ->name('repair-pricings.destroy');

        /*
        |--------------------------------------------------------------------------
        | Cleaning Pricing
        |--------------------------------------------------------------------------
        */

        Route::get('/cleaning-pricings', [CleaningPricingController::class, 'edit'])
            ->name('cleaning-pricings.index');

        Route::put('/cleaning-pricings', [CleaningPricingController::class, 'update'])
            ->name('cleaning-pricings.update');

        /*
        |--------------------------------------------------------------------------
        | Cleaning Areas
        |--------------------------------------------------------------------------
        */

        Route::resource('cleaning-areas', CleaningAreaController::class)
            ->except(['show']);

        /*
        |--------------------------------------------------------------------------
        | Cleaning Addons
        |--------------------------------------------------------------------------
        */

        Route::resource('cleaning-addons', CleaningAddonController::class)
            ->except(['show']);

        /*
        |--------------------------------------------------------------------------
        | AC Pricing
        |--------------------------------------------------------------------------
        */

        Route::resource('ac-pricings', \App\Http\Controllers\Admin\AcPricingController::class)
            ->parameters(['ac-pricings' => 'pricing'])
            ->except(['show', 'update']);

        Route::put('/ac-pricings/{pricing}', [\App\Http\Controllers\Admin\AcPricingController::class, 'update'])
            ->name('ac-pricings.update');

        /*
|--------------------------------------------------------------------------
| Apartment Locations & Towers
|--------------------------------------------------------------------------
*/

        Route::get('/apartment-locations', [\App\Http\Controllers\Admin\ApartmentLocationController::class, 'index'])
            ->name('apartment-locations.index');

        Route::post('/apartment-locations', [\App\Http\Controllers\Admin\ApartmentLocationController::class, 'storeLocation'])
            ->name('apartment-locations.store');

        Route::delete('/apartment-locations/{apartmentLocation}', [\App\Http\Controllers\Admin\ApartmentLocationController::class, 'destroyLocation'])
            ->name('apartment-locations.destroy');

        Route::post('/apartment-locations/{apartmentLocation}/towers', [\App\Http\Controllers\Admin\ApartmentLocationController::class, 'storeTower'])
            ->name('apartment-locations.towers.store');

        Route::delete('/apartment-towers/{apartmentTower}', [\App\Http\Controllers\Admin\ApartmentLocationController::class, 'destroyTower'])
            ->name('apartment-towers.destroy');

        /*
        |--------------------------------------------------------------------------
        | Product Listings
        |--------------------------------------------------------------------------
        */

        Route::get('/product-listings', [AdminProductListingController::class, 'index'])
            ->name('product-listings.index');

        Route::post('/product-listings', [AdminProductListingController::class, 'store'])
            ->name('product-listings.store');

        Route::put('/product-listings/{productListing}', [AdminProductListingController::class, 'update'])
            ->name('product-listings.update');

        Route::delete('/product-listings/{productListing}', [AdminProductListingController::class, 'destroy'])
            ->name('product-listings.destroy');

        /*
        |--------------------------------------------------------------------------
        | Coin Settings
        |--------------------------------------------------------------------------
        */

        Route::resource('coin-settings', \App\Http\Controllers\Admin\CoinSettingController::class)
            ->parameters(['coin-settings' => 'coinSetting'])
            ->except(['show']);

        /*
        |--------------------------------------------------------------------------
        | Coin Redemption Products
        |--------------------------------------------------------------------------
        */

        Route::get('/coin-redemption-products', [CoinRedemptionProductController::class, 'index'])
            ->name('coin-redemption-products.index');

        Route::get('/coin-redemption-products/create', [CoinRedemptionProductController::class, 'create'])
            ->name('coin-redemption-products.create');

        Route::post('/coin-redemption-products', [CoinRedemptionProductController::class, 'store'])
            ->name('coin-redemption-products.store');

        Route::get('/coin-redemption-products/{coinRedemptionProduct}/edit', [CoinRedemptionProductController::class, 'edit'])
            ->name('coin-redemption-products.edit');

        Route::put('/coin-redemption-products/{coinRedemptionProduct}', [CoinRedemptionProductController::class, 'update'])
            ->name('coin-redemption-products.update');

        Route::delete('/coin-redemption-products/{coinRedemptionProduct}', [CoinRedemptionProductController::class, 'destroy'])
            ->name('coin-redemption-products.destroy');

        /*
        |--------------------------------------------------------------------------
        | Coin Redemptions (Guest Requests)
        |--------------------------------------------------------------------------
        */

        Route::get('/coin-redemptions', [AdminCoinRedemptionController::class, 'index'])
            ->name('coin-redemptions.index');

        Route::get('/coin-redemptions/{coinRedemption}', [AdminCoinRedemptionController::class, 'show'])
            ->name('coin-redemptions.show');

        Route::post('/coin-redemptions/{coinRedemption}/approve', [AdminCoinRedemptionController::class, 'approve'])
            ->name('coin-redemptions.approve');

        Route::post('/coin-redemptions/{coinRedemption}/reject', [AdminCoinRedemptionController::class, 'reject'])
            ->name('coin-redemptions.reject');
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
        |--------------------------------------------------------------------------
        | Worker Tasks
        |--------------------------------------------------------------------------
        */

        Route::get('/tasks', [TaskController::class, 'index'])
            ->name('tasks.index');

        Route::get('/tasks/{serviceRequest}', [TaskController::class, 'show'])
            ->name('tasks.show');

        Route::post('/tasks/{serviceRequest}/accept', [TaskController::class, 'accept'])
            ->name('tasks.accept');

        Route::post('/tasks/{serviceRequest}/weigh', [TaskController::class, 'weigh'])
            ->name('tasks.weigh');

        Route::post('/tasks/{serviceRequest}/ready-for-payment', [TaskController::class, 'readyForPayment'])
            ->name('tasks.ready-for-payment');

        Route::post('/tasks/{serviceRequest}/confirm-delivered', [TaskController::class, 'confirmDelivered'])
            ->name('tasks.confirm-delivered');

        Route::post('/tasks/{serviceRequest}/complete', [TaskController::class, 'complete'])
            ->name('tasks.complete');

        Route::post('/tasks/{serviceRequest}/survey', [TaskController::class, 'survey'])
            ->name('tasks.survey');

        /*
        |--------------------------------------------------------------------------
        | Profile
        |--------------------------------------------------------------------------
        */

        Route::get('/profile', [ProfileController::class, 'edit'])
            ->name('profile.edit');

        Route::patch('/profile', [ProfileController::class, 'update'])
            ->name('profile.update');

        Route::delete('/profile', [ProfileController::class, 'destroy'])
            ->name('profile.destroy');
    });

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
