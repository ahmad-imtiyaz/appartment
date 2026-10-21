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
    | Contact
    |--------------------------------------------------------------------------
    */

    'contact' => [
        'title' => 'Chat Admin',
        'desc'  => 'Top up issue or balance not received? Chat on WhatsApp.',
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

    'service_info' => [
        'view_detail' => 'View Details',
        'view_process'=> 'View Process',
        'close'       => 'Close',
        'got_it'      => 'Got it',
    ],

    /*
    |--------------------------------------------------------------------------
    | Laundry Info (View Details / View Process popups)
    |--------------------------------------------------------------------------
    */

    'laundry_info' => [
        'process_title'    => 'How Laundry Works',
        'process_subtitle' => 'We pick up, wash, and deliver!',
        'steps' => [
            'pickup'  => ['title' => 'Laundry Pickup',  'desc' => 'We collect your laundry from your apartment.'],
            'wash'    => ['title' => 'Washing',         'desc' => 'Your laundry is processed according to your chosen service.'],
            'done'    => ['title' => 'Laundry Ready',   'desc' => 'We let you know when your laundry is ready.'],
            'pay'     => ['title' => 'Pay in the App',  'desc' => 'Pay once your laundry is done.'],
            'deliver' => ['title' => 'Delivery',        'desc' => 'Clean laundry is delivered to your apartment.'],
        ],

        'detail_title'     => 'Laundry Service Details',
        'detail_subtitle'  => 'Important information before ordering.',
        'points' => [
            'min_order'   => ['title' => 'Minimum Order',  'desc' => 'Minimum 2 kg per order.'],
            'final_price' => ['title' => 'Final Price',    'desc' => 'The final price is shown in the app after your laundry is weighed.'],
            'duration'    => ['title' => 'Duration',       'desc' => 'Regular 3 days or Express 1 day.'],
            'payment'     => ['title' => 'Payment',        'desc' => 'Pay through the app once your laundry is done.'],
            'notes'       => ['title' => 'Clothing Notes', 'desc' => 'Add special notes when placing your order.'],
        ],
    ],

    'repair_info' => [
        'process_title'    => 'Repair & Maintenance Details',
        'process_subtitle' => 'Apartment repairs with transparent pricing.',
        'steps' => [
            'order'    => ['title' => 'Place an Order',  'desc' => 'Choose the type of damage and a visit schedule.'],
            'survey'   => ['title' => 'Free Survey',     'desc' => 'A technician comes to inspect the damage free of charge.'],
            'estimate' => ['title' => 'Cost Breakdown',  'desc' => 'You receive a repair cost breakdown before deciding.'],
            'pay'      => ['title' => 'Approve & Pay',   'desc' => 'Approve the bill and pay in the app, or decline with no repair charge.'],
            'repair'   => ['title' => 'Repair Begins',   'desc' => 'The technician starts working once payment is confirmed.'],
        ],

        'detail_title'     => 'Repair & Maintenance Details',
        'detail_subtitle'  => 'Choose the damage category and urgency level that match your unit\'s condition.',
        'grid_title'       => 'Damage Categories',
        'grid' => [
            'cat_luntur'    => ['title' => 'Faded Paint',   'desc' => 'Peeling or damaged paint.'],
            'kebocoran'     => ['title' => 'Leaks',         'desc' => 'Pipes, faucets, or water seepage.'],
            'listrik'       => ['title' => 'Electrical',    'desc' => 'Lights, switches, or sockets.'],
            'ac'            => ['title' => 'AC',            'desc' => 'Dirty, not cooling, or faulty AC.'],
            'pintu_jendela' => ['title' => 'Door/Window',   'desc' => 'Hinges, locks, or hard to open.'],
            'furniture'     => ['title' => 'Furniture',     'desc' => 'Cabinets, tables, chairs, and more.'],
            'lainnya'       => ['title' => 'Other',         'desc' => 'Other damage inside the apartment unit.'],
        ],
    ],

    'ac_info' => [
        'process_title'    => 'AC Service Process',
        'process_subtitle' => 'Cool air again, hassle-free!',
        'steps' => [
            'order'    => ['title' => 'Place an Order',     'desc' => 'Choose the AC service type, schedule, and location.'],
            'check'    => ['title' => 'Technician Arrives', 'desc' => 'The technician arrives on schedule and checks your AC free of charge.'],
            'estimate' => ['title' => 'Cost Breakdown',     'desc' => 'Repair & Full Service only: you receive a cost breakdown to approve before work begins.'],
            'work'     => ['title' => 'AC Work',            'desc' => 'The technician services your AC according to the selected service.'],
            'pay'      => ['title' => 'Payment',            'desc' => 'AC Cleaning & Freon Refill are automatically deducted from your balance once done. Repair & Full Service are paid when you approve the cost breakdown.'],
        ],
        'process_note' => [
            'title' => 'Make Sure Your Balance Is Sufficient',
            'desc'  => 'Make sure your app balance covers the service payment.',
        ],

        'detail_title'     => 'AC Service Details',
        'detail_subtitle'  => 'Choose the service that matches the condition of the AC in your unit.',
        'grid_title'       => 'Service Types',
        'grid' => [
            'ac-cleaning'     => ['title' => 'AC Cleaning',  'desc' => 'Cleans the filter, evaporator, and outdoor unit. Fixed price.'],
            'ac-refill'       => ['title' => 'Freon Refill', 'desc' => 'Tops up freon for an AC that isn\'t cooling well. Fixed price.'],
            'ac-repair'       => ['title' => 'AC Repair',    'desc' => 'AC dead, leaking, or showing errors. Free survey, cost after inspection.'],
            'ac-full-service' => ['title' => 'Full Service', 'desc' => 'Cleaning, freon, electrical & component check. Free survey, cost after inspection.'],
        ],
    ],

    'cleaning_info' => [
        'process_title'    => 'Cleaning Service Process',
        'process_subtitle' => 'A clean apartment, hassle-free!',
        'steps' => [
            'order'   => ['title' => 'Place an Order',       'desc' => 'Choose the duration, extra tasks, schedule, and location.'],
            'arrive'  => ['title' => 'Cleaner Arrives',      'desc' => 'The cleaner arrives at the scheduled time.'],
            'clean'   => ['title' => 'Cleaning',             'desc' => 'Cleaning is done according to the selected service.'],
            'confirm' => ['title' => 'Completion Confirmed', 'desc' => 'The cleaner confirms the job is complete.'],
            'pay'     => ['title' => 'Automatic Payment',    'desc' => 'The service fee is automatically deducted from your app balance once the cleaner confirms the job is complete.'],
        ],
        'process_note' => [
            'title' => 'Make Sure Your Balance Is Sufficient',
            'desc'  => 'Make sure your app balance covers the service payment.',
        ],

        'detail_title'     => 'Cleaning Job Details',
        'detail_subtitle'  => 'Apartment unit cleaning for the duration you choose.',
        'areas_title'      => 'Areas Cleaned',
        'areas' => [
            'living'   => ['title' => 'Living & Family Room', 'desc' => 'Dusting furniture and tables, sweeping and mopping the floor.'],
            'bedroom'  => ['title' => 'Bedroom',              'desc' => 'Making the bed, wiping furniture, sweeping and mopping the floor.'],
            'bathroom' => ['title' => 'Bathroom',             'desc' => 'Cleaning the toilet, sink, mirror, shower area, and floor.'],
            'kitchen'  => ['title' => 'Kitchen',              'desc' => 'Wiping the countertop, cabinet exteriors, and the outside of the stove.'],
            'balcony'  => ['title' => 'Balcony',              'desc' => 'Sweeping and mopping the floor and wiping easy-to-reach surfaces.'],
            'common'   => ['title' => 'Common Areas',         'desc' => 'Dusting easy-to-reach surfaces and removing light trash.'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Progress notices (order detail)
    |--------------------------------------------------------------------------
    */

    'progress' => [
        'pending'  => 'Your order has been received and is being reviewed by admin. We will assign a worker shortly.',
        'assigned' => 'A worker has been assigned to your order. Waiting for the worker to confirm.',
        'pricing'  => 'The survey is complete. Admin is calculating the final price, please wait for price approval.',

        'laundry' => [
            'pickup'    => 'The worker is on the way to your location to pick up your laundry.',
            'washing'   => 'Your laundry has been weighed (:weight) and is being washed.',
            'completed' => 'Your laundry has been delivered to your unit. Order complete, thank you!',
        ],
        'cleaning' => [
            'working'   => 'The worker is on the way to your location to clean your unit.',
            'completed' => 'Unit cleaning is done. Order complete, thank you!',
        ],
        'ac' => [
            'cleaning'  => 'The technician is on the way to your location to clean your AC.',
            'refill'    => 'The technician is on the way to your location to refill your AC freon.',
            'working'   => 'Price approved. The technician is servicing your AC.',
            'completed' => 'AC service is done. Order complete, thank you!',
        ],
        'maintenance-repair' => [
            'survey'    => 'The worker is on the way to your location to inspect the damage.',
            'working'   => 'Price approved. The worker is carrying out the repair.',
            'completed' => 'The repair is done. Order complete, thank you!',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Cancel / Reject Order
    |--------------------------------------------------------------------------
    */

    'cancel' => [
        'title'            => 'Cancel Order',
        'subtitle'         => 'Choose a reason for cancelling order #:id',
        'note_label'       => 'Write your reason',
        'note_placeholder' => 'Example: I will be out of town',
        'confirm'          => 'Yes, Cancel Order',
        'back'             => 'Back',
        'only_pending'     => 'Orders can only be cancelled while still being processed by admin. Once a worker is assigned, the order cannot be cancelled.',
        'reason_required'  => 'Please choose a cancellation reason.',
        'note_required'    => 'Please write your cancellation reason.',
        'cancelled_title'  => 'Order Cancelled',
        'rejected_title'   => 'Order Rejected by Admin',
        'reason'           => 'Reason',
    ],

    'cancel_reasons' => [
        // guest
        'wrong_service'    => 'Chose the wrong service',
        'schedule_changed' => 'My schedule changed',
        'change_details'   => 'Want to change order details',
        'no_longer_needed' => 'No longer need the service',
        'other'            => 'Other',
        // admin
        'worker_busy'      => 'Workers are currently busy',
        'location_too_far' => 'Your location is too far',
    ],

    /*
    |--------------------------------------------------------------------------
    | Flash Messages
    |--------------------------------------------------------------------------
    */

    'flash' => [
        'request_created'          => 'Your ":service" request has been submitted and is waiting for admin processing.',
        'request_cancelled'        => 'Your ":service" order has been cancelled.',
        'cancel_not_allowed'       => 'This order can no longer be cancelled because a worker has already been assigned.',
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

        'withdraw_sent' => 'Withdrawal request sent. Your balance is on hold until admin transfers the funds.',
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
        'urgency_title'      => 'Urgency Level',
        'order_data_title'   => 'Order Details',
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
        'processing_hint'      => 'Want faster confirmation? You can contact the admin directly via the WhatsApp link on the main menu.',
        'processing_hint_link' => 'Open main menu',
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

        'pending_banner_title' => 'Top up in progress',
        'pending_banner_desc'  => ':count request(s) totaling :amount are being verified by admin. Your balance will be updated automatically once approved.',
        'pending_note'         => 'Being verified by admin. Your balance will increase once approved.',

        'status' => [
            'pending'  => 'Processing',
            'approved' => 'Completed',
            'rejected' => 'Rejected',
        ],
    ],

    'withdraw' => [
        'title'          => 'Withdraw Balance',
        'subtitle'       => 'Send your balance to your bank account',
        'info'           => 'Minimum withdrawal :min. Admin fee :fee. Your balance is held on request and refunded if rejected.',
        'amount'         => 'Withdrawal Amount',
        'min_placeholder' => 'Minimum Rp:min',
        'fee'            => 'Admin Fee',
        'net'            => 'You Receive',
        'bank_name'      => 'Bank Name',
        'account_number' => 'Account No.',
        'account_holder' => 'Account Holder',
        'submit'         => 'Submit Withdrawal',
        'history_title'  => 'Withdrawal History',
        'history_subtitle' => 'Your balance withdrawal requests',
        'new'            => 'New Withdrawal',
        'empty_title'    => 'No withdrawals yet',
        'pending_note'   => 'Being processed by admin. Funds will be sent to your account.',
        'refunded'       => 'Your balance has been refunded.',
        'status' => [
            'pending'  => 'Processing',
            'approved' => 'Completed',
            'rejected' => 'Rejected',
        ],
    ],

];
