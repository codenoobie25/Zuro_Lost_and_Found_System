<?php

namespace App\Http\Controllers;

use App\Models\Claim;
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
        $foundItems = 0;
        $pendingClaims = 0;
        $verifiedClaims = 0;

        if (Schema::hasTable('items')) {
            $totalItems = DB::table('items')->count();

            if (Schema::hasColumn('items', 'status')) {
                $foundItems = DB::table('items')->where('status', 'found')->count();
            }

            if (Schema::hasTable('claims') && Schema::hasColumn('claims', 'status')) {
                $pendingClaims = Claim::where('status', 'pending')->count();
                $verifiedClaims = Claim::where('status', 'verified')->count();
            }
        }

        return view('staff.staff_dashboard', [
            'generatedAt' => $today,
            'totalItems' => $totalItems,
            'foundItems' => $foundItems,
            'pendingClaims' => $pendingClaims,
            'verifiedClaims' => $verifiedClaims,
            'totalUsers' => $totalUsers,
        ]);
    }
}
