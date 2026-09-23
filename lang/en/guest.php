<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Navigation
    |--------------------------------------------------------------------------
    */

    'nav' => [
        'home'        => 'Home',
        'services'    => 'Services',
        'marketplace' => 'Marketplace',
        'profile'     => 'Profile',
    ],

    /*
    |--------------------------------------------------------------------------
    | Language
    |--------------------------------------------------------------------------
    */

    'lang' => [
        'switch_to_id' => 'Switch to Indonesian',
        'switch_to_en' => 'Switch to English',
    ],

    /*
    |--------------------------------------------------------------------------
    | Header
    |--------------------------------------------------------------------------
    */

    'header' => [
        'tagline'       => 'Apartment Services',
        'notifications' => 'Notifications',
        'welcome'       => 'Welcome,',
        'balance'       => 'Balance',
        'points'        => 'Oregonet Point',
        'points_unit'   => 'points',
        'top_up'        => 'Top Up',
        'change_point'  => 'Redeem Points',
    ],

    /*
    |--------------------------------------------------------------------------
    | Home
    |--------------------------------------------------------------------------
    */

    'home' => [
        'our_services'       => 'Our Services',
        'services_subtitle'  => 'Choose the service that fits your home',
        'laundry'            => 'Laundry',
        'cleaning'           => 'Cleaning',
        'repair'             => 'Repair',
        'repair_maintenance' => 'Repair & Maintenance',
        'ac'                 => 'Air Conditioner',
        'laundry_desc'       => 'Wash, iron, regular & express',
        'cleaning_desc'      => 'Regular, deep, post move-in',
        'repair_desc'        => 'Electrical, plumbing, furniture & more',
        'ac_desc'            => 'AC cleaning, freon refill, repair',
        'request_service'    => 'Request a Service',
        'promo_small'        => 'More Than Just Services,',
        'promo_headline'     => 'We Care About Your Comfort',

        'marketplace_title'    => 'Buy & Sell',
        'marketplace_subtitle' => 'Property & items from other residents',
        'see_all'              => 'View All',

        'how_title'          => 'How It Works',
        'step1_title'        => 'Choose a Service',
        'step1_desc'         => 'Pick the service you need',
        'step2_title'        => 'Worker Arrives',
        'step2_desc'         => 'Our team handles it at your unit',
        'step3_title'        => 'Done',
        'step3_desc'         => 'Pay from balance & leave a rating',

        'trust_pro'          => 'Professional Staff',
        'trust_fast'         => 'Fast Response',
        'trust_safe'         => 'Secure Payment',
    ],

    /*
    |--------------------------------------------------------------------------
    | Services
    |--------------------------------------------------------------------------
    */

    'services' => [
        'laundry'            => 'Laundry',
        'cleaning'           => 'Cleaning',
        'maintenance-repair' => 'Repair & Maintenance',
        'ac'                 => 'Air Conditioner',
    ],

    /*
    |--------------------------------------------------------------------------
    | Status
    |--------------------------------------------------------------------------
    */

    'status' => [
        'pending'          => 'Pending',
        'assigned'         => 'Assigned',
        'in_progress'      => 'In Progress',
        'waiting_approval' => 'Waiting Approval',
        'waiting_payment'  => 'Waiting Payment',
        'completed'        => 'Completed',
        'rejected'         => 'Rejected',
        'cancelled'        => 'Cancelled',
    ],

    /*
    |--------------------------------------------------------------------------
    | Flash Messages
    |--------------------------------------------------------------------------
    */

    'flash' => [
        'request_created'          => 'Your ":service" request has been submitted and is waiting for admin processing.',
        'request_cancelled'        => 'Your ":service" order has been cancelled.',
        'cancel_not_allowed'       => 'Only pending or assigned orders can be cancelled.',
        'no_price_waiting'         => 'There is no price waiting for approval.',
        'insufficient_balance'     => 'Insufficient balance. Please top up first.',
        'price_approved'           => 'Price approved and your balance has been deducted. The work will continue.',
        'price_rejected'           => 'Price rejected. Please submit a new request if you still need the service.',

        'laundry_ready_for_payment' => 'Your laundry is ready. Please pay before it can be delivered.',
        'laundry_paid'               => 'Payment successful. Your laundry will be delivered soon.',
        'laundry_no_payment_waiting' => 'There is no laundry payment waiting.',
        'laundry_already_paid'       => 'This laundry has already been paid.',
        'laundry_delivered'          => 'Laundry marked as delivered and received by the guest.',

        'feedback_only_completed'  => 'Feedback can only be given for completed tasks.',
        'feedback_already'         => 'Feedback for this task has already been submitted.',
        'feedback_thanks'          => 'Thank you for your feedback!',

        'topup_sent'               => 'Top up request sent, waiting for admin verification.',

        'coin_product_unavailable' => 'This product is not available for redemption.',
        'coin_insufficient'        => 'You do not have enough coins to redeem this product.',
        'coin_redeem_success'      => 'Coin redemption request submitted. Waiting for admin approval.',
        'coin_cancel_not_allowed'  => 'Only redemptions with the "Processing" status can be cancelled.',
        'coin_cancel_success'      => 'Coin redemption cancelled, your coins have been refunded.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Common
    |--------------------------------------------------------------------------
    */

    'common' => [
        'orders_count' => ':count orders',
        'items_count'  => ':count items',
        'back_to_list' => '← Back to List',
        'fix_errors'   => 'Please fix the following errors:',
    ],

    /*
    |--------------------------------------------------------------------------
    | Urgency
    |--------------------------------------------------------------------------
    */

    'urgency' => [
        'low' => [
            'label' => 'Low',
            'desc'  => 'Can wait',
        ],

        'medium' => [
            'label' => 'Medium',
            'desc'  => '1-2 days',
        ],

        'high' => [
            'label' => 'High',
            'desc'  => 'Urgent / emergency',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Damage Categories
    |--------------------------------------------------------------------------
    */

    'damage_categories' => [
        'cat_luntur'    => 'Peeling Paint',
        'kebocoran'     => 'Leak',
        'listrik'       => 'Electrical',
        'ac'            => 'AC',
        'pintu_jendela' => 'Door / Window',
        'furniture'     => 'Furniture',
        'lainnya'       => 'Other',
    ],

    'damage_categories_long' => [
        'cat_luntur'    => 'Faded / Peeling Paint',
        'kebocoran'     => 'Water / Pipe Leak',
        'listrik'       => 'Electrical (dead light, switch, socket)',
        'ac'            => 'AC (not cooling, leaking, error)',
        'pintu_jendela' => 'Door / Window (hard to open, broken glass)',
        'furniture'     => 'Built-in Furniture (broken shelf, cabinet, table)',
        'lainnya'       => 'Other',
    ],

    /*
    |--------------------------------------------------------------------------
    | Laundry
    |--------------------------------------------------------------------------
    */

    'laundry_types' => [
        'cuci'         => 'Wash',
        'cuci_setrika' => 'Wash & Iron',
        'setrika'      => 'Iron',
    ],

    'laundry_durations' => [
        'reguler' => [
            'label' => 'Regular',
            'desc'  => '3 Days',
        ],

        'express' => [
            'label' => 'Express',
            'desc'  => '1 Day',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Cleaning
    |--------------------------------------------------------------------------
    */

    'cleaning_types' => [
        'cleaning-regular'  => 'Regular Cleaning',
        'cleaning-deep'     => 'Deep Cleaning',
        'cleaning-postmove' => 'Post Move-in',
    ],

    /*
    |--------------------------------------------------------------------------
    | AC
    |--------------------------------------------------------------------------
    */

    'ac_types' => [
        'ac-cleaning' => 'AC Cleaning',
        'ac-refill'   => 'Freon Refill',
        'ac-repair'   => 'AC Repair',
    ],

    /*
    |--------------------------------------------------------------------------
    | Photos
    |--------------------------------------------------------------------------
    */

    'photo_types' => [
        'before' => 'Before',
        'after'  => 'After',
    ],

    /*
    |--------------------------------------------------------------------------
    | Category
    |--------------------------------------------------------------------------
    */

    'category_titles' => [
        'laundry'  => 'Laundry Services',
        'cleaning' => 'Cleaning Services',
        'repair'   => 'Repair & Maintenance',
        'ac'       => 'Air Conditioner',
    ],

    'category_options' => [
        'laundry-weight'    => 'By Weight',
        'laundry-item'      => 'By Item',
        'laundry-vip'       => 'VIP',
        'laundry-curtain'   => 'Curtains',
        'laundry-ironing'   => 'Ironing Only',
        'laundry-express'   => 'Express',

        'cleaning-regular'  => 'Regular Cleaning',
        'cleaning-deep'     => 'Deep Cleaning',
        'cleaning-postmove' => 'Post Move-in',

        'repair-plumbing'   => 'Plumbing',
        'repair-electric'   => 'Electrical',
        'repair-furniture'  => 'Furniture',

        'ac-cleaning'       => 'AC Cleaning',
        'ac-refill'        => 'Freon Refill',
        'ac-repair'        => 'AC Repair',
    ],

    'category' => [
        'active_orders' => 'Active :title Orders',
        'no_orders'     => 'No :title orders yet',
        'new_request'   => '+ New :title Request',
    ],

    /*
    |--------------------------------------------------------------------------
    | Form
    |--------------------------------------------------------------------------
    */

    'form' => [
        'schedule_optional'           => 'Schedule (Optional)',
        'schedule_hint'               => 'Leave empty to process immediately',
        'notes'                       => 'Notes',
        'notes_placeholder'           => 'Example: unit A-1203, key at the lobby, etc.',
        'maintenance_details'         => 'Maintenance & Repair Details',
        'damage_category'             => 'Damage Category',
        'damage_location'             => 'Damage Location',
        'damage_location_placeholder' => 'Example: Bathroom, kitchen, AC unit 1',
        'urgency'                     => 'Urgency Level',
        'photos_title'                => 'Damage Photos (Optional, max 5)',
        'photos_hint'                 => 'Maximum 5 photos, up to 2MB each',

        'location_title'        => 'Service Location',
        'daerah'                => 'Area',
        'choose_daerah'         => 'Select area',
        'daerah_hint'           => 'Services are currently available only in the Jakarta area.',
        'apartment_location'    => 'Unit Location',
        'choose_location'       => 'Select unit location',
        'apartment_tower'       => 'Tower',
        'choose_location_first' => 'Select a unit location first',
        'choose_tower'          => 'Select tower',
    ],

    /*
    |--------------------------------------------------------------------------
    | Service Request Index
    |--------------------------------------------------------------------------
    */

    'index' => [
        'title'          => 'Services',
        'choose_service' => 'Choose a Service',
        'active_orders'  => 'Active Orders',
        'no_requests'    => 'No service requests yet',
        'order_no'       => 'Order No. :number',
        'give_feedback'  => 'Give Feedback →',
    ],

    /*
    |--------------------------------------------------------------------------
    | Create Service Request
    |--------------------------------------------------------------------------
    */

    'create' => [
        'title'           => 'New Service Request',
        'service_type'    => 'Service Type',
        'choose_service'  => '-- Choose a Service --',
        'custom_price'    => 'Custom price',
        'choose_category' => '-- Choose a Category --',
        'submit'          => 'Submit Request',
    ],

    /*
    |--------------------------------------------------------------------------
    | Service Detail
    |--------------------------------------------------------------------------
    */

    'detail' => [
        'default_description' => 'The best service for your apartment',

        'laundry_title'        => 'Choose Laundry Type',
        'laundry_subtitle'     => 'The type of washing service you want',

        'duration_title'       => 'Choose Duration',
        'duration_subtitle'    => 'How long the laundry takes',

        'price_per_kg'         => 'Price per Kilogram',
        'choose_type_duration' => 'Choose type & duration',

        'price_may_change'     => '⚠️ Price may change after weighing',

        'final_price_note'     => '⚠️ The final price will be set after the Worker weighs your clothes.',

        'cleaning_title'       => 'Choose Cleaning Type',
        'cleaning_subtitle'    => 'The type of cleaning service you want',

        'ac_title'             => 'Choose AC Service Type',
        'ac_subtitle'          => 'The type of AC service you want',

        'selected_service'     => 'Selected Service',

        'make_order'           => 'Place an Order',
        'submit_order'         => 'Submit Order',

        'order_list'           => 'Order List',
        'no_orders'            => 'No :service orders yet',
        'order_number'         => 'Order #:number',
        'cancel'               => 'Cancel',
        'confirm_cancel'       => 'Cancel order #:id?',
    ],

   /*
    |--------------------------------------------------------------------------
    | Service Request Show
    |--------------------------------------------------------------------------
    */

    'show' => [
        'title'              => 'Request Details',
        'submitted'          => 'Submitted',
        'scheduled'          => 'Scheduled',
        'assigned'           => 'Assigned',
        'worker'             => 'Worker',
        'accepted_by_worker' => 'Accepted by worker',
        'completed'          => 'Completed',
        'cost'               => 'Cost',
        'weight'             => 'Weight',
        'your_notes'         => 'Your Notes',
        'worker_notes'       => 'Worker Notes',
        'location'           => 'Location',
        'urgency'            => 'Urgency',

        'price_approval'     => 'Price Approval',
        'survey_done'        => 'The survey has been completed, here is the final price from our team:',
        'current_balance'    => 'Your current balance: :amount',
        'approve_pay'        => 'Approve & Pay',
        'reject'             => 'Reject',

        'confirm_reject'     => 'Reject this price? The request will be cancelled and you will need to submit it again.',

        'in_progress_note'    => 'Please wait, your request is currently being processed.',
        'laundry_payment'      => 'Laundry Payment',
        'laundry_ready'        => 'Your laundry has been washed. Please pay before it is delivered:',
        'laundry_already_paid' => 'You have already paid for this laundry. Waiting to be delivered to your unit.',
        'pay_now'              => 'Pay Now',

        'photos'             => 'Photos',

        'feedback_title'     => 'Feedback for the Worker',
        'feedback_thanks'    => 'Thank you for your feedback!',
        'rating'             => 'Rating',
        'comment_optional'   => 'Comment (Optional)',
        'comment_placeholder' => 'Write about your experience...',
        'send_feedback'      => 'Send Feedback',

        'pending_note'       => 'Please wait, your request is being processed.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Balance
    |--------------------------------------------------------------------------
    */

    'balance' => [
        'title'           => 'Balance & Transaction History',
        'current_balance' => 'Current Balance',
        'your_coins'      => 'Your Coins',
        'coin_unit'       => 'Coins',

        'filter_aria'     => 'Filter transactions',

        'tab_all'         => 'All',
        'tab_balance'     => 'Balance',
        'tab_coin'        => 'Coins',

        'empty_all'       => 'No transaction history yet',
        'empty_balance'   => 'No balance transaction history yet',
        'empty_coin'      => 'No coin transaction history yet',

        'in'              => 'In',
        'out'             => 'Out',

        'unit_balance'    => 'Balance',
        'unit_coin'       => 'Coins',
    ],

    /*
    |--------------------------------------------------------------------------
    | Marketplace
    |--------------------------------------------------------------------------
    */

    'market' => [
        'title'           => 'Buy & Sell',
        'subtitle'        => 'Resident Marketplace',
        'tagline'         => 'Find or offer items within your apartment community.',
        'active_items'    => 'Active Items',
        'categories'      => 'Categories',
        'all'             => 'All',
        'section_title'   => 'Buy & Sell Info',
        'empty'           => 'No listings yet',
        'negotiable'      => 'Negotiable',
        'chat_wa'         => 'Chat WA',
        'invalid_contact' => 'Invalid Contact',
    ],

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    'profile' => [
        'title'                => 'Profile',
        'resident_profile'     => 'Resident Profile',
        'updated'              => 'Profile updated successfully.',
        'info_title'           => 'Profile Information',

        'name'                 => 'Name',
        'name_placeholder'     => 'Enter your name',

        'email'                => 'Email',
        'email_placeholder'    => 'Enter your email',

        'save'                 => 'Save Changes',

        'delete_title'         => 'Delete Account',
        'delete_warning'       => 'Once your account is deleted, all data will be permanently removed.',

        'confirm_password'     => 'Confirm Password',
        'password_placeholder' => 'Enter your password',

        'confirm_delete'       => 'Are you sure you want to delete your account? This action cannot be undone.',

        'delete_button'        => 'Delete Account',
        'logout'               => 'Logout',
    ],

    /*
    |--------------------------------------------------------------------------
    | Coin Redemption
    |--------------------------------------------------------------------------
    */

    'coin' => [
        'title'             => 'Coin Redemption',
        'tab_products'      => 'Available Products',
        'tab_history'       => 'Redemption History',
        'no_products'       => 'No products available for redemption yet',
        'no_history'        => 'No redemption history yet',
        'stock'             => 'Stock: :count',
        'out_of_stock'      => 'Out of Stock',
        'insufficient_coin' => 'Insufficient Coins',
        'redeem_now'        => 'Redeem Now',
        'confirm_redeem'    => 'Are you sure you want to redeem :cost coins for :name?',
        'status_processing' => 'Processing',
        'status_completed'  => 'Successfully Redeemed',
        'status_cancelled'  => 'Cancelled',
        'admin_note_label'  => 'Note:',
        'confirm_cancel'    => 'Are you sure you want to cancel this redemption? Your coins will be refunded.',
        'cancel'            => 'Cancel',
    ],

    /*
    |--------------------------------------------------------------------------
    | Top Up
    |--------------------------------------------------------------------------
    */

    'topup' => [

        // Create page
        'title'              => 'Top Up Balance',
        'subtitle'           => 'Add balance to your account',
        'current_balance'    => 'Current Balance',
        'form_title'         => 'Submit Top Up',
        'form_subtitle'      => 'Fill in the payment details below',

        'payment_method'     => 'Payment Method',
        'choose_method'      => '-- Choose Method --',
        'type_bank_transfer' => 'Bank Transfer',
        'type_qris'          => 'QRIS',

        'account_details'    => 'Account Details',
        'bank_name'          => 'Bank Name',
        'account_number'     => 'Account No.',
        'account_holder'     => 'Account Holder',
        'bank_hint'          => 'Transfer to the account above, then upload the transfer proof.',

        'scan_qr'            => 'Scan QR Code',
        'qris_hint'          => 'Scan using your e-wallet or banking app.',
        'qris_not_uploaded'  => 'QRIS has not been uploaded by admin',

        'amount'             => 'Amount',
        'amount_placeholder' => 'Minimum Rp10,000',

        'proof'              => 'Transfer Proof',
        'proof_hint'         => 'JPG/PNG format, maximum 2MB.',

        'submit'             => 'Submit Top Up',

        // History page
        'history_title'       => 'Top Up History',
        'history_subtitle'    => 'List of balance top up transactions',
        'new_topup'           => 'New Top Up',
        'recent_transactions' => 'Recent Transactions',
        'recent_subtitle'     => 'Your balance top up history',
        'empty_title'         => 'No top up history yet',
        'empty_desc'          => 'Your top up transactions will appear here.',
        'topup_amount'        => 'Top Up Amount',
        'rejection_reason'    => 'Rejection Reason',
        'approved_at'         => 'Approved:',

        'status' => [
            'pending'  => 'Pending',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
        ],
    ],

];
