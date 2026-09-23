<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Navigation
    |--------------------------------------------------------------------------
    */

    'nav' => [
        'home'        => 'Beranda',
        'services'    => 'Jasa',
        'marketplace' => 'Properti',
        'profile'     => 'Profil',
    ],

    /*
    |--------------------------------------------------------------------------
    | Language
    |--------------------------------------------------------------------------
    */

    'lang' => [
        'switch_to_id' => 'Ganti ke Bahasa Indonesia',
        'switch_to_en' => 'Ganti ke Bahasa Inggris',
    ],

    /*
    |--------------------------------------------------------------------------
    | Header
    |--------------------------------------------------------------------------
    */

    'header' => [
        'tagline'       => 'Layanan Apartemen',
        'notifications' => 'Notifikasi',
        'welcome'       => 'Selamat datang,',
        'balance'       => 'Saldo',
        'points'        => 'Poin Oregonet',
        'points_unit'   => 'poin',
        'top_up'        => 'Top Up',
        'change_point'  => 'Tukar Poin',
    ],

    /*
    |--------------------------------------------------------------------------
    | Home
    |--------------------------------------------------------------------------
    */

    'home' => [
        'our_services'       => 'Layanan Kami',
        'services_subtitle'  => 'Pilih layanan sesuai kebutuhan hunian Anda',
        'laundry'            => 'Laundry',
        'cleaning'           => 'Kebersihan',
        'repair'             => 'Perbaikan',
        'repair_maintenance' => 'Perbaikan & Perawatan',
        'ac'                 => 'AC',
        'laundry_desc'       => 'Cuci, setrika, reguler & express',
        'cleaning_desc'      => 'Reguler, menyeluruh, pindahan',
        'repair_desc'        => 'Listrik, pipa, furnitur & lainnya',
        'ac_desc'            => 'Cuci AC, isi freon, perbaikan',
        'request_service'    => 'Ajukan Jasa',
        'promo_small'        => 'Lebih dari Sekadar Layanan,',
        'promo_headline'     => 'Kami Peduli Kenyamanan Anda',
        'marketplace_title'    => 'Jual & Beli',
        'marketplace_subtitle' => 'Info properti & barang dari penghuni lain',
        'see_all'               => 'Lihat Semua',

        'how_title'          => 'Cara Kerja',
        'step1_title'        => 'Pilih Layanan',
        'step1_desc'         => 'Tentukan jasa yang Anda butuhkan',
        'step2_title'        => 'Petugas Datang',
        'step2_desc'         => 'Tim kami menangani di unit Anda',
        'step3_title'        => 'Selesai',
        'step3_desc'         => 'Bayar dari saldo & beri penilaian',

        'trust_pro'          => 'Petugas Profesional',
        'trust_fast'         => 'Respon Cepat',
        'trust_safe'         => 'Pembayaran Aman',
    ],

    /*
    |--------------------------------------------------------------------------
    | Services
    |--------------------------------------------------------------------------
    */

    'services' => [
        'laundry'            => 'Laundry',
        'cleaning'           => 'Kebersihan',
        'maintenance-repair' => 'Perbaikan & Perawatan',
        'ac'                 => 'AC',
    ],

    /*
    |--------------------------------------------------------------------------
    | Status
    |--------------------------------------------------------------------------
    */

    'status' => [
        'pending'          => 'Menunggu',
        'assigned'         => 'Ditugaskan',
        'in_progress'      => 'Dikerjakan',
        'waiting_approval' => 'Menunggu Persetujuan',
        'waiting_payment'  => 'Menunggu Pembayaran',
        'completed'        => 'Selesai',
        'rejected'         => 'Ditolak',
        'cancelled'        => 'Dibatalkan',
    ],

    /*
    |--------------------------------------------------------------------------
    | Flash Messages
    |--------------------------------------------------------------------------
    */

    'flash' => [
        'request_created'          => 'Permintaan jasa ":service" berhasil diajukan, menunggu diproses admin.',
        'request_cancelled'        => 'Pesanan ":service" berhasil dibatalkan.',
        'cancel_not_allowed'       => 'Hanya pesanan pending atau assigned yang bisa dibatalkan.',
        'no_price_waiting'         => 'Tidak ada harga yang menunggu persetujuan.',
        'insufficient_balance'     => 'Saldo tidak cukup. Silakan top up terlebih dahulu.',
        'price_approved'           => 'Harga disetujui, saldo telah dipotong. Pekerjaan akan dilanjutkan.',
        'price_rejected'           => 'Harga ditolak. Silakan ajukan permintaan baru jika masih diperlukan.',

        'laundry_ready_for_payment' => 'Laundry Anda sudah siap. Silakan bayar sebelum diantar.',
        'laundry_paid'               => 'Pembayaran berhasil. Laundry akan segera diantar.',
        'laundry_no_payment_waiting' => 'Tidak ada tagihan laundry yang menunggu pembayaran.',
        'laundry_already_paid'       => 'Laundry ini sudah dibayar.',
        'laundry_delivered'          => 'Laundry ditandai selesai & sudah diterima guest.',

        'feedback_only_completed'  => 'Feedback hanya bisa diisi untuk tugas yang sudah selesai.',
        'feedback_already'         => 'Feedback untuk tugas ini sudah pernah diisi.',
        'feedback_thanks'          => 'Terima kasih atas feedback-nya!',

        'topup_sent'               => 'Pengajuan top up terkirim, menunggu verifikasi admin.',

        'coin_product_unavailable' => 'Produk tidak tersedia untuk ditukarkan.',
        'coin_insufficient'        => 'Koin Anda tidak mencukupi untuk menukarkan produk ini.',
        'coin_redeem_success'      => 'Permintaan penukaran koin berhasil diajukan. Menunggu persetujuan admin.',
        'coin_cancel_not_allowed'  => 'Hanya penukaran dengan status "Sedang Proses" yang bisa dibatalkan.',
        'coin_cancel_success'      => 'Penukaran koin dibatalkan, koin dikembalikan ke akun Anda.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Common
    |--------------------------------------------------------------------------
    */

    'common' => [
        'orders_count' => ':count pesanan',
        'items_count'  => ':count item',
        'back_to_list' => '← Kembali ke Daftar',
        'fix_errors'   => 'Silakan perbaiki kesalahan berikut:',
    ],

    /*
    |--------------------------------------------------------------------------
    | Urgency
    |--------------------------------------------------------------------------
    */

    'urgency' => [
        'low' => [
            'label' => 'Rendah',
            'desc'  => 'Bisa ditunda',
        ],

        'medium' => [
            'label' => 'Sedang',
            'desc'  => '1-2 hari',
        ],

        'high' => [
            'label' => 'Tinggi',
            'desc'  => 'Segera / darurat',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Damage Categories
    |--------------------------------------------------------------------------
    */

    'damage_categories' => [
        'cat_luntur'    => 'Cat Luntur',
        'kebocoran'     => 'Kebocoran',
        'listrik'       => 'Listrik',
        'ac'             => 'AC',
        'pintu_jendela' => 'Pintu / Jendela',
        'furniture'     => 'Furnitur',
        'lainnya'       => 'Lainnya',
    ],

    'damage_categories_long' => [
        'cat_luntur'    => 'Cat Luntur / Rontok',
        'kebocoran'     => 'Kebocoran Air / Pipa',
        'listrik'       => 'Kelistrikan (lampu mati, saklar, stop kontak)',
        'ac'             => 'AC (tidak dingin, bocor, error)',
        'pintu_jendela' => 'Pintu / Jendela (sulit dibuka, kaca pecah)',
        'furniture'     => 'Furnitur Bawaan (rak, lemari, meja rusak)',
        'lainnya'       => 'Lainnya',
    ],

    /*
    |--------------------------------------------------------------------------
    | Laundry
    |--------------------------------------------------------------------------
    */

    'laundry_types' => [
        'cuci'         => 'Cuci',
        'cuci_setrika' => 'Cuci & Setrika',
        'setrika'      => 'Setrika',
    ],

    'laundry_durations' => [
        'reguler' => [
            'label' => 'Reguler',
            'desc'  => '3 Hari',
        ],

        'express' => [
            'label' => 'Express',
            'desc'  => '1 Hari',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Cleaning
    |--------------------------------------------------------------------------
    */

    'cleaning_types' => [
        'cleaning-regular'  => 'Kebersihan Reguler',
        'cleaning-deep'     => 'Kebersihan Menyeluruh',
        'cleaning-postmove' => 'Setelah Pindahan',
    ],

    /*
    |--------------------------------------------------------------------------
    | AC
    |--------------------------------------------------------------------------
    */

    'ac_types' => [
        'ac-cleaning' => 'Cuci AC',
        'ac-refill'   => 'Isi Freon',
        'ac-repair'   => 'Perbaikan AC',
    ],

    /*
    |--------------------------------------------------------------------------
    | Photos
    |--------------------------------------------------------------------------
    */

    'photo_types' => [
        'before' => 'Sebelum',
        'after'  => 'Sesudah',
    ],

    /*
    |--------------------------------------------------------------------------
    | Category
    |--------------------------------------------------------------------------
    */

    'category_titles' => [
        'laundry'  => 'Layanan Laundry',
        'cleaning' => 'Layanan Kebersihan',
        'repair'   => 'Perbaikan & Perawatan',
        'ac'       => 'AC',
    ],

    'category_options' => [
        'laundry-weight'    => 'Per Berat',
        'laundry-item'      => 'Per Item',
        'laundry-vip'       => 'VIP',
        'laundry-curtain'   => 'Gorden',
        'laundry-ironing'   => 'Setrika Saja',
        'laundry-express'   => 'Express',

        'cleaning-regular'  => 'Kebersihan Reguler',
        'cleaning-deep'     => 'Kebersihan Menyeluruh',
        'cleaning-postmove' => 'Setelah Pindahan',

        'repair-plumbing'   => 'Pipa & Air',
        'repair-electric'   => 'Listrik',
        'repair-furniture'  => 'Furnitur',

        'ac-cleaning'       => 'Cuci AC',
        'ac-refill'         => 'Isi Freon',
        'ac-repair'         => 'Perbaikan AC',
    ],

    'category' => [
        'active_orders' => 'Pesanan :title Aktif',
        'no_orders'     => 'Belum ada pesanan :title',
        'new_request'   => '+ Ajukan :title Baru',
    ],

    /*
    |--------------------------------------------------------------------------
    | Form
    |--------------------------------------------------------------------------
    */

    'form' => [
        'schedule_optional'           => 'Jadwal (Opsional)',
        'schedule_hint'               => 'Kosongkan untuk segera diproses',
        'notes'                       => 'Catatan',
        'notes_placeholder'           => 'Contoh: unit A-1203, kunci di lobi, dsb.',
        'maintenance_details'         => 'Detail Maintenance & Repair',
        'damage_category'             => 'Kategori Kerusakan',
        'damage_location'             => 'Lokasi Kerusakan',
        'damage_location_placeholder' => 'Contoh: Kamar mandi, dapur, AC unit 1',
        'urgency'                     => 'Tingkat Urgensi',
        'photos_title'                => 'Foto Kerusakan (Opsional, maks. 5)',
        'photos_hint'                 => 'Maksimal 5 foto, masing-masing maks. 2MB',

        'location_title'         => 'Lokasi Layanan',
        'daerah'                 => 'Daerah',
        'choose_daerah'          => 'Pilih daerah',
        'daerah_hint'            => 'Saat ini layanan baru tersedia untuk area Jakarta.',
        'apartment_location'     => 'Lokasi Unit',
        'choose_location'        => 'Pilih lokasi unit',
        'apartment_tower'        => 'Tower',
        'choose_location_first'  => 'Pilih lokasi unit dahulu',
        'choose_tower'           => 'Pilih tower',
    ],

    /*
    |--------------------------------------------------------------------------
    | Service Request Index
    |--------------------------------------------------------------------------
    */

    'index' => [
        'title'          => 'Layanan Jasa',
        'choose_service' => 'Pilih Layanan',
        'active_orders'  => 'Pesanan Aktif',
        'no_requests'    => 'Belum ada permintaan jasa',
        'order_no'       => 'Order No. :number',
        'give_feedback'  => 'Beri Feedback →',
    ],

    /*
    |--------------------------------------------------------------------------
    | Create Service Request
    |--------------------------------------------------------------------------
    */

    'create' => [
        'title'           => 'Ajukan Jasa Baru',
        'service_type'    => 'Jenis Jasa',
        'choose_service'  => '-- Pilih Jasa --',
        'custom_price'    => 'Harga custom',
        'choose_category' => '-- Pilih Kategori --',
        'submit'          => 'Ajukan Permintaan',
    ],

    /*
    |--------------------------------------------------------------------------
    | Service Detail
    |--------------------------------------------------------------------------
    */

    'detail' => [
        'default_description' => 'Layanan terbaik untuk apartemen Anda',

        'laundry_title'        => 'Pilih Jenis Laundry',
        'laundry_subtitle'     => 'Jenis layanan cuci yang kamu inginkan',

        'duration_title'       => 'Pilih Durasi',
        'duration_subtitle'    => 'Lama pengerjaan cucian',

        'price_per_kg'         => 'Harga per Kilogram',
        'choose_type_duration' => 'Pilih jenis & durasi',

        'price_may_change'     => '⚠️ Harga bisa berubah setelah ditimbang',

        'final_price_note'     => '⚠️ Harga final akan ditentukan setelah Worker menimbang pakaian Anda.',

        'cleaning_title'       => 'Pilih Jenis Kebersihan',
        'cleaning_subtitle'    => 'Jenis layanan kebersihan yang kamu inginkan',

        'ac_title'             => 'Pilih Jenis Layanan AC',
        'ac_subtitle'          => 'Jenis layanan AC yang kamu inginkan',

        'selected_service'     => 'Layanan Terpilih',

        'make_order'           => 'Buat Pesanan',
        'submit_order'         => 'Ajukan Pesanan',

        'order_list'           => 'Daftar Pesanan',
        'no_orders'            => 'Belum ada pesanan :service',
        'order_number'         => 'Order #:number',
        'cancel'               => 'Batalkan',
        'confirm_cancel'       => 'Batalkan pesanan #:id?',
    ],

    /*
    |--------------------------------------------------------------------------
    | Service Request Show
    |--------------------------------------------------------------------------
    */

    'show' => [
        'title'              => 'Detail Permintaan',
        'submitted'          => 'Diajukan',
        'scheduled'          => 'Dijadwalkan',
        'assigned'           => 'Ditugaskan',
        'worker'             => 'Pekerja',
        'accepted_by_worker'  => 'Diterima pekerja',
        'completed'          => 'Selesai',
        'cost'               => 'Biaya',
        'weight'             => 'Berat',
        'your_notes'          => 'Catatan Anda',
        'worker_notes'        => 'Catatan Pekerja',
        'location'           => 'Lokasi',
        'urgency'            => 'Urgensi',

        'price_approval'      => 'Persetujuan Harga',
        'survey_done'        => 'Survey sudah selesai, berikut harga final dari tim kami.',
        'current_balance'    => 'Saldo Anda saat ini: :amount',
        'approve_pay'        => 'Setujui & Bayar',
        'reject'             => 'Tolak',

        'confirm_reject'     => 'Tolak harga ini? Permintaan akan dibatalkan dan Anda perlu mengajukan ulang.',

        'in_progress_note'    => 'Mohon menunggu, permintaan Anda sedang dalam proses.',
        'laundry_payment'     => 'Pembayaran Laundry',
        'laundry_ready'       => 'Laundry Anda sudah selesai dicuci. Silakan bayar sebelum diantar:',
        'laundry_already_paid' => 'Anda sudah membayar laundry ini. Menunggu diantar ke unit Anda.',
        'pay_now'             => 'Bayar Sekarang',

        'photos'             => 'Foto',

        'feedback_title'     => 'Feedback untuk Pekerja',
        'feedback_thanks'    => 'Terima kasih sudah memberikan feedback!',
        'rating'             => 'Rating',
        'comment_optional'   => 'Komentar (Opsional)',
        'comment_placeholder' => 'Tulis pengalaman Anda...',
        'send_feedback'      => 'Kirim Feedback',

        'pending_note'       => 'Mohon menunggu, permintaan Anda dalam proses.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Balance
    |--------------------------------------------------------------------------
    */

    'balance' => [
        'title'           => 'Saldo & Riwayat Mutasi',
        'current_balance' => 'Saldo Saat Ini',
        'your_coins'      => 'Koin Anda',
        'coin_unit'       => 'Koin',

        'filter_aria'     => 'Filter mutasi',

        'tab_all'         => 'Semua',
        'tab_balance'     => 'Saldo',
        'tab_coin'        => 'Koin',

        'empty_all'      => 'Belum ada riwayat mutasi',
        'empty_balance'  => 'Belum ada riwayat mutasi saldo',
        'empty_coin'     => 'Belum ada riwayat mutasi koin',

        'in'             => 'Masuk',
        'out'            => 'Keluar',

        'unit_balance'   => 'Saldo',
        'unit_coin'      => 'Koin',
    ],

    /*
    |--------------------------------------------------------------------------
    | Marketplace
    |--------------------------------------------------------------------------
    */

    'market' => [
        'title'           => 'Jual Beli',
        'subtitle'        => 'Marketplace Penghuni',
        'tagline'         => 'Temukan atau tawarkan barang di lingkungan apartemenmu.',
        'active_items'    => 'Item Aktif',
        'categories'      => 'Kategori',
        'all'             => 'Semua',
        'section_title'   => 'Info Jual & Beli',
        'empty'           => 'Belum ada info jual-beli',
        'negotiable'      => 'Nego',
        'chat_wa'         => 'Chat WA',
        'invalid_contact' => 'Kontak Tidak Valid',
    ],

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    'profile' => [
        'title'                => 'Profil',
        'resident_profile'     => 'Profil Penghuni',
        'updated'              => 'Profil berhasil diperbarui.',
        'info_title'           => 'Informasi Profil',

        'name'                 => 'Nama',
        'name_placeholder'     => 'Masukkan nama',

        'email'                => 'Email',
        'email_placeholder'    => 'Masukkan email',

        'save'                 => 'Simpan Perubahan',

        'delete_title'         => 'Hapus Akun',
        'delete_warning'       => 'Setelah akun dihapus, semua data akan hilang secara permanen.',

        'confirm_password'     => 'Konfirmasi Password',
        'password_placeholder' => 'Masukkan password',

        'confirm_delete'       => 'Yakin ingin menghapus akun? Tindakan ini tidak bisa dibatalkan.',

        'delete_button'        => 'Hapus Akun',
        'logout'               => 'Logout',
    ],

    /*
    |--------------------------------------------------------------------------
    | Coin Redemption
    |--------------------------------------------------------------------------
    */

    'coin' => [
        'title'             => 'Penukaran Koin',
        'tab_products'      => 'Produk Tersedia',
        'tab_history'       => 'Riwayat Penukaran',
        'no_products'       => 'Belum ada produk yang bisa ditukarkan',
        'no_history'        => 'Belum ada riwayat penukaran',
        'stock'             => 'Stok: :count',
        'out_of_stock'      => 'Stok Habis',
        'insufficient_coin' => 'Koin Tidak Cukup',
        'redeem_now'        => 'Tukar Sekarang',
        'confirm_redeem'    => 'Yakin ingin menukarkan :cost koin untuk :name?',
        'status_processing' => 'Sedang Proses',
        'status_completed'  => 'Berhasil Ditukarkan',
        'status_cancelled'  => 'Dibatalkan',
        'admin_note_label'  => 'Catatan:',
        'confirm_cancel'    => 'Yakin ingin membatalkan penukaran ini? Koin akan dikembalikan.',
        'cancel'            => 'Batalkan',
    ],

    /*
    |--------------------------------------------------------------------------
    | Top Up
    |--------------------------------------------------------------------------
    */

    'topup' => [

        // Halaman create
        'title'              => 'Top Up Saldo',
        'subtitle'           => 'Tambahkan saldo akun Anda',
        'current_balance'    => 'Saldo Saat Ini',
        'form_title'         => 'Ajukan Top Up',
        'form_subtitle'      => 'Isi data pembayaran di bawah',

        'payment_method'     => 'Metode Pembayaran',
        'choose_method'      => '-- Pilih Metode --',
        'type_bank_transfer' => 'Transfer Bank',
        'type_qris'          => 'QRIS',

        'account_details'    => 'Detail Rekening',
        'bank_name'          => 'Nama Bank',
        'account_number'     => 'No. Rekening',
        'account_holder'     => 'Atas Nama',
        'bank_hint'          => 'Transfer ke rekening di atas, kemudian upload bukti transfer.',

        'scan_qr'            => 'Scan QR Code',
        'qris_hint'          => 'Scan menggunakan aplikasi e-wallet atau banking.',
        'qris_not_uploaded'  => 'QRIS belum diupload admin',

        'amount'             => 'Nominal',
        'amount_placeholder' => 'Minimal Rp10.000',

        'proof'              => 'Bukti Transfer',
        'proof_hint'         => 'Format JPG/PNG, maksimal 2MB.',

        'submit'             => 'Ajukan Top Up',

        // Halaman riwayat
        'history_title'       => 'Riwayat Top Up',
        'history_subtitle'    => 'Daftar transaksi penambahan saldo',
        'new_topup'           => 'Top Up Baru',
        'recent_transactions' => 'Transaksi Terakhir',
        'recent_subtitle'     => 'Riwayat top up saldo Anda',
        'empty_title'         => 'Belum ada riwayat top up',
        'empty_desc'          => 'Transaksi top up Anda akan muncul di sini.',
        'topup_amount'        => 'Nominal Top Up',
        'rejection_reason'    => 'Alasan Penolakan',
        'approved_at'         => 'Disetujui:',

        'status' => [
            'pending'  => 'Menunggu',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
        ],
    ],

];
