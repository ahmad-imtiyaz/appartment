<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductListing;
use App\Models\ServiceRequest;
use App\Models\TopupRequest;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Jumlah service request yang masih pending
        $pendingRequests = ServiceRequest::where('status', 'pending')->count();

        // Jumlah top up yang masih pending
        $pendingTopups = TopupRequest::where('status', 'pending')->count();

        // Jumlah user dengan role pekerja
        $totalWorkers = User::where('role', 'pekerja')->count();

        // Jumlah product listing yang aktif
        $activeListings = ProductListing::where('is_active', true)->count();

        return view('admin.dashboard', compact(
            'pendingRequests',
            'pendingTopups',
            'totalWorkers',
            'activeListings'
        ));
    }
}
