# Apartment Service Management System - Project Context

## Overview
Sistem manajemen layanan apartemen dengan 3 role: **admin**, **pekerja** (worker), **guest** (penyewa). Guest bisa request jasa (laundry, cleaning, AC, maintenance/repair), admin assign ke pekerja, pekerja eksekusi & report, guest bayar via saldo/koin.

---

## Database Models & Relationships

### Core Models

| Model | Table | Key Fields | Purpose |
|-------|-------|------------|---------|
| **User** | `users` | `role` (admin/pekerja/guest), `status` (penyewa/pemilik/agent), `daerah`, `apartment_location_id`, `apartment_tower_id`, `balance`, `coin_balance`, `apartment_unit_number`, `phone` | Semua user (3 role) + profil apartemen |
| **Service** | `services` | `slug` (laundry/cleaning/ac/maintenance-repair), `base_price`, `is_active` | Master jenis jasa |
| **ServiceRequest** | `service_requests` | `user_id`, `service_id`, `worker_id`, `assigned_by`, `status`, `cost`, `total_price`, `daerah`, `apartment_location_id`, `apartment_tower_id`, service-specific fields | Transaksi utama + lokasi layanan |
| **TopupRequest** | `topup_requests` | `user_id`, `payment_method_id`, `amount`, `status` (pending/approved/rejected) | Request isi saldo |
| **PaymentMethod** | `payment_methods` | `type` (bank_transfer/qris), `bank_name`, `qr_image` | Metode pembayaran topup |

### ServiceRequest AC Types
- `ac-cleaning` — Cuci AC (fixed price upfront)
- `ac-refill` — Isi Freon (fixed price upfront)
- `ac-repair` — Perbaikan AC (survey → admin set price → guest approve)
- `ac-full-service` — Full Service AC (survey → admin set price → guest approve)

### Apartment Location Models
| Model | Table | Key Fields | Purpose |
|-------|-------|------------|---------|
| **ApartmentLocation** | `apartment_locations` | `name`, `is_active` | Master lokasi apartemen (dikelola admin) |
| **ApartmentTower** | `apartment_towers` | `apartment_location_id`, `name`, `is_active` | Tower di dalam lokasi (cascading dropdown) |

### Pricing Models (Admin-managed)
| Model | Table | Key Fields |
|-------|-------|------------|
| **LaundryPricing** | `laundry_pricings` | `type` (cuci/cuci_setrika/setrika), `duration` (reguler/express), `price_per_kg` |
| **CleaningPricing** | `cleaning_pricings` | `price_per_hour` (single active rate per hour) |
| **AcPricing** | `ac_pricings` | `type` (ac-cleaning/ac-refill/ac-repair), `price` |
| **RepairPricing** | — | **No database table** — PHP class with constants `CATEGORIES` & `SEVERITIES` only (used for form validation) |

### Cleaning Configuration Models (Admin-managed)
| Model | Table | Key Fields | Purpose |
|-------|-------|------------|---------|
| **CleaningArea** | `cleaning_areas` | `name`, `is_active` | Ruangan/area yang dibersihkan (kamar mandi, dapur, dll) |
| **CleaningAddon** | `cleaning_addons` | `name`, `price`, `is_active` | Tambahan layanan (cuci jendela, oven, dll) |

### Detail & Mutation Models
| Model | Table | Purpose |
|-------|-------|---------|
| **MaintenanceDetail** | `maintenance_details` | Detail survey kerusakan (damage_category, severity, location, urgency) |
| **ServiceRequestPhoto** | `service_request_photos` | Foto before/after |
| **ServiceRequestFeedback** | `service_request_feedbacks` | Rating & komentar guest ke pekerja |
| **BalanceMutation** | `balance_mutations` | Log perubahan saldo (credit/debit) |
| **CoinMutation** | `coin_mutations` | Log perubahan koin (earn/spend) |
| **CoinSetting** | `coin_settings` | Tier reward: `min_amount` → `coin_reward` |
| **CoinRedemptionProduct** | `coin_redemption_products` | Produk tukar koin (name, coin_cost, stock) |
| **CoinRedemption** | `coin_redemptions` | Request tukar koin guest |
| **ProductListing** | `product_listings` | Marketplace barang (admin post, guest lihat + WA link) |

### Pivot Tables
| Table | Purpose |
|-------|---------|
| `cleaning_area_service_request` | Many-to-many: ServiceRequest ↔ CleaningArea |
| `cleaning_addon_service_request` | Many-to-many: ServiceRequest ↔ CleaningAddon (dengan `snapshot_price`) |

---

## User Roles & Access Control

### Middleware: `EnsureUserHasRole` (`role:admin,pekerja,guest`)
- **admin**: Full CRUD pricing, assign pekerja, approve/reject topup & harga MnR, manage workers, **kelola lokasi unit & tower**
- **pekerja**: Terima tugas, input survey/berat, complete tugas, upload foto after
- **guest**: Request jasa, topup saldo, lihat riwayat, feedback, redeem koin, marketplace, **edit profil lengkap (status, daerah, lokasi, tower)**

### Role Helpers (User model)
```php
$user->isAdmin()    // role === 'admin'
$user->isPekerja()  // role === 'pekerja'
$user->isGuest()    // role === 'guest'
```

### Apartment Profile Fields (User)
| Field | Type | Description |
|-------|------|-------------|
| `status` | string | `penyewa` \| `pemilik` \| `agent` (required) |
| `daerah` | string | Saat ini hanya `Jakarta` (required) |
| `apartment_location_id` | FK | Lokasi unit (required, relasi ke apartment_locations) |
| `apartment_tower_id` | FK | Tower (required, relasi ke apartment_towers, must match location) |
| `apartment_unit_number` | string | Nomor unit, optional |

---

## Service Request Status Flow

```
pending → assigned → in_progress → [waiting_approval (MnR only)] → completed
              ↓              ↓
            rejected    waiting_payment (Laundry only) → in_progress → completed
```

| Status | Meaning | Who Can Act |
|--------|---------|-------------|
| `pending` | Baru dibuat guest, menunggu admin assign | Admin assign |
| `assigned` | Sudah di-assign ke pekerja, menunggu ACC | Pekerja accept |
| `in_progress` | Pekerja sudah ACC, sedang dikerjakan | Pekerja: survey/weigh/complete |
| `waiting_approval` | **MnR only** - Harga final dikirim admin, menunggu guest approve | Guest: approve/reject price |
| `waiting_payment` | **Laundry only** - Selesai dicuci, menunggu guest bayar sebelum diantar | Guest: bayar via `payLaundry` |
| `completed` | Selesai, saldo dipotong, koin reward diberikan | - |
| `rejected` | Dibatalkan (guest/admin) | - |

---

### ServiceRequest Helper Methods (Model)
```php
// ServiceRequest.php
$serviceRequest->isAcRepair()       // ac_type === 'ac-repair'
$serviceRequest->isAcFullService()  // ac_type === 'ac-full-service'
$serviceRequest->requiresSurveyPricing() // true untuk MnR, ac-repair, ac-full-service
$serviceRequest->isPriceApproved()  // price_approved_at !== null
$serviceRequest->isWaitingPayment() // status === 'waiting_payment'
$serviceRequest->isLaundryPaid()    // laundry_paid_at !== null
$serviceRequest->calculateTotalPrice()  // laundry: weight × rate; cleaning: hours × rate + addons
```

---

## Service-Specific Logic

### Laundry
- Guest pilih: `type` (cuci/cuci_setrika/setrika) + `duration` (reguler/express)
- Harga: `snapshot_price_per_kg` dari LaundryPricing (locked saat create)
- Pekerja input `billable_weight` (min 1kg) → auto hitung `total_price`
- **NEW Flow**: Pekerja `readyForPayment` (status → `waiting_payment`) → Guest `payLaundry` via `LaundryPaymentService` (saldo dipotong, `laundry_paid_at` terisi) → Pekerja `confirmDelivered` (upload foto after, status → `completed`, reward koin)

### Cleaning
- Guest pilih: `cleaning_duration_hours` (1-12 jam), `cleaning_area_ids` (minimal 1 area wajib), `cleaning_addon_ids` (opsional)
- Harga: `snapshot_cleaning_price_per_hour` dari CleaningPricing (single active rate, locked saat create)
- Total = `cleaning_duration_hours` × `snapshot_cleaning_price_per_hour` + Σ `snapshot_price` addons
- Guest bayar saat complete (saldo dipotong di `TaskController@complete`)

### AC
- Guest pilih: `ac_type` (ac-cleaning/ac-refill/ac-repair/ac-full-service)
- **ac-cleaning & ac-refill**: Harga fixed upfront (`snapshot_ac_price` dari AcPricing, locked saat create), bayar saat complete
- **ac-repair & ac-full-service**: **MnR-style flow** — tidak ada harga upfront (`snapshot_ac_price` = null)
  1. Pekerja `survey` → isi `survey_notes`
  2. Admin `setPrice` → set `total_price`, status → `waiting_approval`
  3. Guest `approvePrice` → saldo dipotong via `RepairPaymentService`, status → `in_progress`
  4. Guest `rejectPrice` → status → `rejected`

### Maintenance & Repair (MnR)
- Guest pilih: `damage_category` (dari RepairPricing::CATEGORIES) + `urgency`
- **Tidak ada harga upfront** — `snapshot_repair_price` = null
- Pekerja `survey` → isi `damage_category`, `severity` (ringan/sedang/berat)
- Admin `setPrice` → **manual input harga** (tidak ada lagi harga acuan dari tabel), set `total_price`, status → `waiting_approval`
- Guest `approvePrice` → saldo dipotong via `RepairPaymentService`, status → `in_progress`
- Guest `rejectPrice` → status → `rejected`

---

## Key Services

### RepairPaymentService
```php
charge(ServiceRequest $serviceRequest): bool
```
- Atomic: lock row, cek `price_approved_at` (idempotent), cek saldo, potong saldo, create BalanceMutation, update status ke `in_progress`
- Return `false` kalau saldo tidak cukup

### LaundryPaymentService (NEW)
```php
charge(ServiceRequest $serviceRequest): bool
```
- Atomic: lock row, cek `laundry_paid_at` (idempotent), cek saldo, potong saldo, create BalanceMutation, update `laundry_paid_at` = now()
- Return `false` kalau saldo tidak cukup
- Dipanggil dari `GuestServiceRequestController@payLaundry` saat guest bayar laundry

### CoinRewardService
```php
awardForServiceRequest(ServiceRequest $sr, User $guest, float $amountSpent): ?CoinMutation
```
- Cari tier `CoinSetting` aktif dengan `min_amount` <= `amountSpent` (highest match)
- Tambah `coin_balance` guest, create CoinMutation type `earn`
- Dipanggil di `TaskController@complete` untuk SEMUA jenis jasa (termasuk MnR pakai `total_price`)
- Untuk laundry dipanggil di `TaskController@confirmDelivered` setelah guest bayar & worker konfirmasi antar

---

## Routes Structure

### Public
- `GET /` → welcome
- `GET /product-listings` → public marketplace

### Auth (routes/auth.php)
- Standard Laravel Breeze: register, login, email verification, password reset, logout

### Dashboard (role-based redirect)
- `GET /dashboard` → redirect by role:
  - admin → `admin.dashboard`
  - pekerja → `worker.tasks.index`
  - guest → `guest.home`

### Guest Routes (`guest.*`, prefix `/guest`, middleware `auth, role:guest`)
| Route | Controller | Purpose |
|-------|------------|---------|
| `GET /home` | closure | Guest dashboard (3 properti terbaru slider + services grid) |
| `GET /service-requests` | GuestServiceRequestController@index | List request guest |
| `GET /service-requests/category/{category}` | @category | Category landing |
| `GET /service-requests/create` | @create | Form buat request |
| `POST /service-requests` | @store | Submit request (dengan validasi lokasi wajib) |
| `GET /service-requests/{sr}` | @show | Detail request (termasuk lokasi, payment laundry, approve/reject MnR) |
| `DELETE /service-requests/{sr}` | @destroy | Cancel (pending/assigned only) |
| `POST /service-requests/{sr}/approve-price` | @approvePrice | Approve harga MnR |
| `POST /service-requests/{sr}/reject-price` | @rejectPrice | Reject harga MnR |
| `POST /service-requests/{sr}/pay-laundry` | @payLaundry | **Bayar tagihan laundry (status waiting_payment)** |
| `GET /services/{slug}` | @serviceDetail | Detail per jenis jasa + pricelist + form order dengan cascading dropdown lokasi |
| `POST /service-requests/{sr}/feedback` | FeedbackController@store | Rating pekerja |
| `GET /topups` | GuestTopupController@index | Riwayat topup |
| `GET /topups/create` | @create | Form topup |
| `POST /topups` | @store | Submit topup |
| `GET /balance` | @balance | Riwayat mutasi saldo + koin |
| `GET /profile` | GuestProfileController@edit | Edit profil lengkap (status, daerah, lokasi, tower, unit) |
| `PATCH /profile` | @update | Update profil lengkap |
| `DELETE /profile` | @destroy | Hapus akun |
| `GET /coin-redemptions` | GuestCoinRedemptionController@index | List produk & riwayat redeem |
| `POST /coin-redemptions` | @store | Request redeem |
| `DELETE /coin-redemptions/{cr}` | @cancel | Batalkan redeem (processing only) |

### Admin Routes (`admin.*`, prefix `/admin`, middleware `auth, role:admin`)
| Route | Controller | Purpose |
|-------|------------|---------|
| `GET /` | DashboardController@index | Stats: pending/assigned/in_progress counts, topup pending, worker count |
| `GET /workers` | WorkerController@index | List pekerja |
| `POST /workers` | @store | Tambah pekerja (name, email, password, phone, unit) |
| `GET /payment-methods` | PaymentMethodController@index | CRUD metode bayar |
| `GET /topups` | TopupController@index | List topup pending |
| `POST /topups/{tr}/approve` | @approve | Approve topup (+ saldo + mutation) |
| `POST /topups/{tr}/reject` | @reject | Reject topup (w/ note) |
| `GET /service-requests` | ServiceRequestController@index | List all (filter by status) |
| `GET /service-requests/{sr}` | @show | Detail + assign worker form |
| `POST /service-requests/{sr}/assign` | @assign | Assign pekerja + notif |
| `POST /service-requests/{sr}/set-price` | @setPrice | Set harga MnR + notif guest |
| `resource laundry-pricings` | LaundryPricingController | CRUD pricing laundry |
| `GET /cleaning-pricings` | CleaningPricingController@edit | **Edit tarif cleaning per jam (single active rate)** |
| `PUT /cleaning-pricings` | CleaningPricingController@update | Update tarif cleaning per jam |
| `resource ac-pricings` | AcPricingController | CRUD pricing AC |
| `CRUD repair-pricings` | RepairPricingController | **REMOVED** — MnR pricing now fully manual (no reference price table) |
| `resource cleaning-areas` | CleaningAreaController | **CRUD area cleaning (kamar mandi, dapur, dll)** |
| `resource cleaning-addons` | CleaningAddonController | **CRUD addon cleaning (cuci jendela, oven, dll)** |
| `GET /apartment-locations` | ApartmentLocationController@index | **List lokasi & tower** |
| `POST /apartment-locations` | @storeLocation | **Tambah lokasi unit** |
| `DELETE /apartment-locations/{apartmentLocation}` | @destroyLocation | **Hapus lokasi (jika tidak ada user)** |
| `POST /apartment-locations/{apartmentLocation}/towers` | @storeTower | **Tambah tower ke lokasi** |
| `DELETE /apartment-towers/{apartmentTower}` | @destroyTower | **Hapus tower (jika tidak ada user)** |
| `CRUD product-listings` | ProductListingController | CRUD marketplace |
| `resource coin-settings` | CoinSettingController | CRUD tier reward koin |
| `CRUD coin-redemption-products` | CoinRedemptionProductController | CRUD produk tukar koin |
| `GET /coin-redemptions` | CoinRedemptionController@index | List request redeem guest |
| `GET /coin-redemptions/{cr}` | @show | Detail redeem |
| `POST /coin-redemptions/{cr}/approve` | @approve | Approve redeem (kurangi koin, kurangi stock) |
| `POST /coin-redemptions/{cr}/reject` | @reject | Reject redeem |

### Worker Routes (`worker.*`, prefix `/worker`, middleware `auth, role:pekerja`)
| Route | Controller | Purpose |
|-------|------------|---------|
| `GET /tasks` | TaskController@index | List tugas assigned |
| `GET /tasks/{sr}` | @show | Detail tugas (termasuk lokasi unit guest) |
| `POST /tasks/{sr}/accept` | @accept | ACC tugas (status → in_progress, collected_at untuk laundry) |
| `POST /tasks/{sr}/survey` | @survey | Input survey MnR (damage_category, severity, dll) |
| `POST /tasks/{sr}/weigh` | @weigh | Input berat laundry (hitung total_price) |
| `POST /tasks/{sr}/ready-for-payment` | @readyForPayment | **Laundry selesai cuci → status waiting_payment** |
| `POST /tasks/{sr}/confirm-delivered` | @confirmDelivered | **Konfirmasi laundry sudah diantar → completed + reward koin** |
| `POST /tasks/{sr}/complete` | @complete | Selesai tugas non-laundry (potong saldo guest, reward koin, upload foto after) |

---

## Notifications

| Notification | Trigger | Recipient | Channel |
|--------------|---------|-----------|---------|
| **TaskAssignedNotification** | Admin assign pekerja | Pekerja | Database |
| **PriceSetNotification** | Admin setPrice MnR | Guest | Database |
| **SurveyReportedNotification** | Pekerja submit survey | Admin (assigned_by) | Database |

---

## Important Business Rules

1. **Saldo & Koin**: Guest wajib punya saldo cukup untuk bayar jasa (kecuali MnR yg dibayar saat approvePrice). Topup butuh approval admin.
2. **Harga Locked**: Saat guest create request, harga disnapshot dari pricing aktif (laundry/cleaning/AC). MnR tidak snapshot.
3. **Minimum Laundry Weight**: 1kg (billable_weight < 1 dibulatkan ke 1).
4. **Coin Reward**: Berdasarkan tier CoinSetting (min_amount → coin_reward). Dipakai amountSpent = total_price (MnR) atau cost (lainnya).
5. **Photo Upload**: Max 5 foto per request (before saat create, after saat complete).
6. **Soft Deletes**: User pakai SoftDeletes.
7. **Idempotent Payment**: `RepairPaymentService::charge()` aman dipanggil berulang (cek `price_approved_at`).

---

## Key Files to Understand

### Controllers (Business Logic)
- `app/Http/Controllers/Guest/ServiceRequestController.php` — Create request all services, approve/reject price MnR, **payLaundry, cascading dropdown lokasi, cleaning areas/addons**
- `app/Http/Controllers/Admin/ServiceRequestController.php` — Assign worker, setPrice MnR
- `app/Http/Controllers/Worker/TaskController.php` — Accept, survey, weigh, **readyForPayment, confirmDelivered**, complete (payment + coin reward)
- `app/Http/Controllers/Admin/TopupController.php` — Approve/reject topup (saldo mutation)
- `app/Http/Controllers/Guest/TopupController.php` — Guest topup + balance history
- `app/Http/Controllers/Auth/RegisteredUserController.php` — **Register dengan cascading dropdown lokasi/tower**
- `app/Http/Controllers/Guest/ProfileController.php` — **Profil guest lengkap dengan cascading dropdown**
- `app/Http/Controllers/Admin/ApartmentLocationController.php` — **CRUD lokasi unit & tower (admin)**
- `app/Http/Controllers/Admin/CleaningPricingController.php` — **Edit tarif cleaning per jam**
- `app/Http/Controllers/Admin/CleaningAreaController.php` — **CRUD area cleaning**
- `app/Http/Controllers/Admin/CleaningAddonController.php` — **CRUD addon cleaning**

### Services
- `app/Services/RepairPaymentService.php` — Atomic charge untuk MnR
- `app/Services/LaundryPaymentService.php` — **Atomic charge untuk laundry (idempotent, cek laundry_paid_at)**
- `app/Services/CoinRewardService.php` — Reward koin berdasarkan tier

### Models (Relations & Helpers)
- `app/Models/User.php` — Role helpers, all relationships, **apartment location/tower relations**
- `app/Models/ServiceRequest.php` — Status helpers (isWaitingPayment, isLaundryPaid), service type checks, calculateTotalPrice (laundry + **cleaning**), **lokasi relations**, **cleaningAreas, cleaningAddons**
- `app/Models/RepairPricing.php` — **PHP class (non-Eloquent) dengan constants: `CATEGORIES` & `SEVERITIES` untuk validasi form** — **no database table**
- `app/Models/CoinSetting.php` — Tier reward logic
- `app/Models/ApartmentLocation.php` — **Master lokasi, relasi ke towers & users**
- `app/Models/ApartmentTower.php` — **Tower, relasi ke location & users**
- `app/Models/CleaningPricing.php` — **Single active rate per jam (price_per_hour)**
- `app/Models/CleaningArea.php` — **Area cleaning (name, is_active), relasi ke ServiceRequest**
- `app/Models/CleaningAddon.php` — **Addon cleaning (name, price, is_active), relasi ke ServiceRequest dengan pivot snapshot_price**

### Middleware
- `app/Http/Middleware/EnsureUserHasRole.php` — Role-based access

### Requests
- `app/Http/Requests/ProfileUpdateRequest.php` — **Validasi profil dengan rule tower harus match location**

---

## Views Structure (Blade)

```
resources/views/
├── layouts/
│   ├── app.blade.php            # Main layout (authenticated)
│   ├── guest.blade.php          # Guest layout
│   ├── navigation.blade.php
│   └── oregonet-auth.blade.php  # **Auth layout (login/register)**
├── admin/
│   ├── dashboard.blade.php
│   ├── service-requests/{index,show}.blade.php
│   ├── topups/index.blade.php
│   ├── workers/index.blade.php
│   ├── *pricings*/{index,create,edit}.blade.php
│   ├── product-listings/index.blade.php
│   ├── coin-settings/{index,create,edit}.blade.php
│   ├── coin-redemptions/{index,show}.blade.php
│   ├── coin-redemption-products/{index,create,edit}.blade.php
│   ├── apartment-locations/index.blade.php  # **Kelola lokasi & tower**
│   ├── cleaning-pricings/edit.blade.php  # **Edit tarif cleaning per jam**
│   ├── cleaning-areas/{index,create,edit}.blade.php  # **CRUD area cleaning**
│   └── cleaning-addons/{index,create,edit}.blade.php  # **CRUD addon cleaning**
│   # repair-pricings/ DELETED — MnR pricing now fully manual
├── guest/
│   ├── home.blade.php           # **Hero + services grid + marketplace slider (3 properti terbaru) + steps + trust**
│   ├── balance.blade.php
│   ├── profile.blade.php        # **Profil lengkap dengan cascading dropdown**
│   ├── topups/{index,create}.blade.php
│   ├── service-requests/{index,create,show,category,service-detail}.blade.php
│   ├── coin-redemptions/index.blade.php
│   └── product-listings.blade.php
├── worker/
│   └── tasks/{index,show}.blade.php  # **Detail tugas dengan lokasi, readyForPayment, confirmDelivered**
├── profile/
│   └── partials/{update-profile-information-form,update-password-form,delete-user-form}.blade.php
└── auth/
    ├── login.blade.php          # **Custom login (oregonet-auth layout)**
    └── register.blade.php       # **Custom register dengan cascading dropdown**
```

---

## Testing Notes
- Tests in `tests/Feature/` (Auth, Profile)
- Run: `php artisan test` or `./vendor/bin/phpunit`

---

## Environment & Dependencies
- Laravel 11+
- PHP 8.2+
- SQLite/MySQL/PostgreSQL
- Vite + Tailwind CSS (frontend)
- Laravel Breeze (auth scaffolding)

---

## Common Gotchas for AI Agents

1. **MnR Flow is Different**: No upfront price → worker survey → admin setPrice → guest approve → then in_progress
2. **Price Snapshots**: Laundry/Cleaning/AC prices locked at request creation via `snapshot_*` fields
3. **Coin Reward Base**: MnR uses `total_price`, others use `cost` (see TaskController@complete line 168)
4. **Balance Mutations**: Every saldo change creates BalanceMutation (audit trail)
5. **Role Middleware**: Always check `role:xxx` in routes; controllers assume middleware already ran
6. **Soft Deletes**: User model uses SoftDeletes — queries may need `withTrashed()` sometimes
7. **File Storage**: Photos stored in `storage/app/public/` — run `php artisan storage:link`
8. **Decimal Casting**: Prices cast to `decimal:2` in models
9. **Cascading Dropdown**: Register, profile & order form use JS to populate tower based on selected location — tower must belong to selected location (validated in RegisteredUserController, ProfileUpdateRequest & ServiceRequestController)
10. **Apartment Fields Required**: Guest registration now requires status, daerah, apartment_location_id, apartment_tower_id
11. **Admin Location Delete Protection**: Cannot delete location/tower if users are still assigned to them
12. **Laundry Payment Flow**: NEW status `waiting_payment` — worker calls `readyForPayment` after weighing → guest pays via `payLaundry` → worker calls `confirmDelivered` → completed + coin reward
13. **Service Request Location**: All service requests now require `daerah`, `apartment_location_id`, `apartment_tower_id` (defaults from guest profile, cascading dropdown on order form)
14. **Idempotent Payments**: Both `RepairPaymentService::charge()` and `LaundryPaymentService::charge()` are idempotent (check `price_approved_at` / `laundry_paid_at`)
15. **Cleaning Pricing Changed**: Now per-hour rate (`price_per_hour`) + areas (required) + addons (optional) — no more fixed price per type. Total = hours × rate + Σ addon prices. Uses `CleaningPricing::current()` for active rate.
16. **Cleaning Areas Required**: Guest must select at least 1 cleaning area when creating cleaning request
17. **RepairPricing Removed**: `repair_pricings` table & Eloquent model deleted. `RepairPricing` is now a plain PHP class with `CATEGORIES` & `SEVERITIES` constants only. Admin sets MnR price manually in `setPrice` (no suggested/reference price). `RepairPricingController` & views deleted. Admin sidebar no longer has Repair pricing menu.

---

## Database Migrations (Complete List)

| Migration File | Purpose |
|----------------|---------|
| `0001_01_01_000000_create_users_table.php` | Base users table |
| `0001_01_01_000001_create_cache_table.php` | Laravel cache table |
| `0001_01_01_000002_create_jobs_table.php` | Laravel jobs table |
| `2026_09_16_000001_add_role_and_balance_to_users_table.php` | Add `role`, `balance` to users |
| `2026_09_16_000002_create_payment_methods_table.php` | Payment methods (bank/qris) |
| `2026_09_16_000003_create_topup_requests_table.php` | Topup requests |
| `2026_09_16_000004_create_balance_mutations_table.php` | Balance mutation log |
| `2026_09_16_000005_create_services_table.php` | Master services (laundry, cleaning, ac, maintenance-repair) |
| `2026_09_16_000006_create_service_requests_table.php` | Core service_requests table |
| `2026_09_16_000007_create_maintenance_details_table.php` | MnR survey details |
| `2026_09_16_000008_create_service_request_photos_table.php` | Before/after photos |
| `2026_09_16_000009_create_product_listings_table.php` | Marketplace listings |
| `2026_09_16_000010_add_assignment_columns_to_service_requests_table.php` | `worker_id`, `assigned_by`, `assigned_at`, `accepted_at`, `completed_at` |
| `2026_09_16_000011_create_service_request_feedbacks_table.php` | Guest feedback to workers |
| `2026_09_16_000012_laundry_features.php` | Laundry fields (type, duration, price_per_kg, weight, total_price, collected_at, weighed_at) |
| `2026_09_17_000013_create_cleaning_pricings_table.php` | Cleaning pricing (type, price) |
| `2026_09_17_133707_add_cleaning_fields_to_service_requests_table.php` | Cleaning fields (cleaning_type, snapshot_cleaning_price) |
| `2026_09_17_144859_create_ac_pricings_table.php` | AC pricing (type, price) |
| `2026_09_17_144927_add_ac_columns_to_service_requests_table.php` | AC fields (ac_type, snapshot_ac_price) |
| `2026_09_18_140138_create_coin_settings_table.php` | Coin reward tiers (min_amount → coin_reward) |
| `2026_09_18_140246_create_coin_mutations_table.php` | Coin mutation log |
| `2026_09_18_140328_add_coin_balance_to_users_table.php` | Add `coin_balance` to users |
| `2026_09_18_155957_add_notif_seen_at_to_users_table.php` | Add `notif_seen_at` to users |
| `2026_09_18_162646_create_coin_redemption_products_table.php` | Coin redemption products |
| `2026_09_18_162735_create_coin_redemptions_table.php` | Guest coin redemption requests |
| `2026_09_18_211024_create_repair_pricings_table.php` | MnR pricing (category, severity, price) — **TABLE NO LONGER USED** (model now plain PHP class) |
| `2026_09_18_211029_add_repair_flow_to_service_requests.php` | MnR fields (survey, price_approval, status waiting_approval) |
| `2026_09_22_112129_create_apartment_locations_table.php` | Master apartment locations |
| `2026_09_22_112210_create_apartment_towers_table.php` | Apartment towers (FK to locations) |
| `2026_09_22_112255_add_registration_fields_to_users_table.php` | User profile: status, daerah, location_id, tower_id |
| `2026_09_22_140505_add_waiting_payment_status_to_service_requests_table.php` | Add `waiting_payment` status + `laundry_paid_at` |
| `2026_09_22_150947_add_location_fields_to_service_requests_table.php` | ServiceRequest: daerah, apartment_location_id, apartment_tower_id |
| `2026_09_22_153114_repair_location_fields_on_service_requests_table.php` | Fix FK constraints for location fields |
| `2026_09_23_072715_update_cleaning_pricings_to_per_hour.php` | CleaningPricing: drop type/price → add price_per_hour (single active rate) |
| `2026_09_23_072745_create_cleaning_areas_table.php` | CleaningArea model (name, is_active) |
| `2026_09_23_072835_create_cleaning_area_service_request_table.php` | Pivot: ServiceRequest ↔ CleaningArea |
| `2026_09_23_072859_create_cleaning_addons_table.php` | CleaningAddon model (name, price, is_active) |
| `2026_09_23_072929_create_cleaning_addon_service_request_table.php` | Pivot: ServiceRequest ↔ CleaningAddon (with snapshot_price) |
| `2026_09_23_073006_update_cleaning_fields_on_service_requests_table.php` | ServiceRequest: drop cleaning_type/snapshot_cleaning_price → add cleaning_duration_hours, snapshot_cleaning_price_per_hour |

---

## Quick Reference: Creating New Service Type

1. Add slug to `Service` model/constants
2. Create pricing model + migration (if fixed pricing) or use MnR pattern
3. Add fields to `ServiceRequest` migration (`snapshot_xxx_price`, `xxx_type`, etc.)
4. Update `ServiceRequestController@store` validation & create logic
5. Update `TaskController@complete` cost calculation match
6. Add views for guest create/service-detail
7. Add admin pricing CRUD if needed

---

*Generated from codebase analysis on 2026-09-19; updated 2026-09-22 with apartment location/tower system, cascading dropdowns, updated auth views, laundry payment flow (waiting_payment status), and marketplace slider on home; updated 2026-09-23 with cleaning pricing per-hour, cleaning areas & addons, admin CRUD for cleaning config; updated 2026-09-23 with AC full-service, AC repair/AC full-service survey pricing flow, ServiceRequest helper methods, and complete migration list; updated 2026-09-24 with RepairPricing removed (now plain PHP class), MnR pricing fully manual, RepairPricingController & views deleted*