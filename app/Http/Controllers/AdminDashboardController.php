<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $totalUsers = DB::table('users')->count();

        $totalItems = 0;
        $lostItems = 0;
        $foundItemsWaitingClaim = 0;

        // Keep dashboard safe even if item tables are not migrated yet.
        if (Schema::hasTable('items')) {
            $totalItems = DB::table('items')->count();

            if (Schema::hasColumn('items', 'status')) {
                $lostItems = DB::table('items')->where('status', 'lost')->count();
                $foundItemsWaitingClaim = DB::table('items')->where('status', 'found')->count();
            }
        }

        return view('admin.admin_dashboard', [
            'totalItems' => $totalItems,
            'lostItems' => $lostItems,
            'foundItemsWaitingClaim' => $foundItemsWaitingClaim,
            'totalUsers' => $totalUsers,
        ]);
    }
}
