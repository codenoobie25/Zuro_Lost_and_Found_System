<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class StaffDashboardController extends Controller
{
    public function index(): View
    {
        $today = Carbon::now('Asia/Manila');
        $totalUsers = DB::table('users')->count();

        $totalItems = 0;
        $lostItems = 0;
        $foundItemsWaitingClaim = 0;

        if (Schema::hasTable('items')) {
            $totalItems = DB::table('items')->count();
            $lostItems = DB::table('items')->where('status', 'lost')->count();
            $foundItemsWaitingClaim = DB::table('items')->where('status', 'found')->count();
        }

        return view('staff.staff_dashboard', [
            'generatedAt' => $today,
            'totalItems' => $totalItems,
            'lostItems' => $lostItems,
            'foundItemsWaitingClaim' => $foundItemsWaitingClaim,
            'totalUsers' => $totalUsers,
        ]);
    }
}
