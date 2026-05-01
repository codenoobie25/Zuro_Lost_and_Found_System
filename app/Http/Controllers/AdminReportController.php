<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class AdminReportController extends Controller
{
    public function index(): View
    {
        return view('admin.reports', $this->buildReportData());
    }

    public function exportPdf()
    {
        $data = $this->buildReportData();

        $pdf = Pdf::loadView('admin.reports_pdf', $data)
            ->setPaper('a4', 'portrait');

        return $pdf->download('zoru-admin-report-' . now()->format('Y-m-d') . '.pdf');
    }

    private function buildReportData(): array
    {
        $today = Carbon::now('Asia/Manila');
        $totalUsers = DB::table('users')->count();
        $adminUsers = DB::table('users')->where('role', 'admin')->count();
        $staffUsers = DB::table('users')->where('role', 'staff')->count();
        $regularUsers = DB::table('users')->where('role', 'user')->count();

        $totalItems = 0;
        $lostItems = 0;
        $foundItems = 0;
        $claimedItems = 0;
        $pendingClaims = 0;
        $verifiedClaims = 0;
        $rejectedClaims = 0;
        $itemsReturned = 0;
        $activeLostItems = 0;
        $itemCategories = collect([
            ['name' => 'Wallet', 'count' => 0],
            ['name' => 'Electronics', 'count' => 0],
            ['name' => 'Bag', 'count' => 0],
        ]);
        $activityLabels = collect(range(6, 0))->map(function ($offset) use ($today) {
            return $today->copy()->subDays($offset)->format('M d');
        });
        $activityItems = collect(array_fill(0, 7, 0));
        $activityClaims = collect(array_fill(0, 7, 0));

        if (Schema::hasTable('items')) {
            $totalItems = DB::table('items')->count();
            $lostItems = DB::table('items')->where('status', 'lost')->count();
            $foundItems = DB::table('items')->where('status', 'found')->count();
            $claimedItems = DB::table('items')->where('status', 'claimed')->count();
            $itemsReturned = DB::table('items')->where('status', 'returned')->count();
            $activeLostItems = DB::table('items')->where('status', 'lost')->count();

            if (Schema::hasColumn('items', 'category')) {
                $itemCategories = DB::table('items')
                    ->select('category', DB::raw('count(*) as total'))
                    ->groupBy('category')
                    ->orderByDesc('total')
                    ->limit(3)
                    ->get()
                    ->map(fn($row) => ['name' => $row->category ?? 'Uncategorized', 'count' => (int) $row->total]);
            }

            if (Schema::hasColumn('items', 'created_at')) {
                $activityData = DB::table('items')
                    ->selectRaw('DATE(created_at) as report_date, count(*) as total')
                    ->where('created_at', '>=', $today->copy()->subDays(6)->startOfDay())
                    ->groupBy('report_date')
                    ->orderBy('report_date')
                    ->get()
                    ->keyBy('report_date');

                $claimData = collect();
                if (Schema::hasTable('claims') && Schema::hasColumn('claims', 'created_at')) {
                    $claimData = DB::table('claims')
                        ->selectRaw('DATE(created_at) as report_date, count(*) as total')
                        ->where('created_at', '>=', $today->copy()->subDays(6)->startOfDay())
                        ->groupBy('report_date')
                        ->orderBy('report_date')
                        ->get()
                        ->keyBy('report_date');
                }

                $dates = collect(range(6, 0))->map(function ($offset) use ($today) {
                    return $today->copy()->subDays($offset)->format('Y-m-d');
                });

                $activityLabels = $dates->map(fn($date) => Carbon::parse($date)->format('M d'));
                $activityItems = $dates->map(fn($date) => (int) ($activityData[$date]->total ?? 0));
                $activityClaims = $dates->map(fn($date) => (int) ($claimData[$date]->total ?? 0));
            }

            if (Schema::hasTable('claims')) {
                $pendingClaims = Schema::hasColumn('claims', 'status') ? DB::table('claims')->where('status', 'pending')->count() : 0;
                $verifiedClaims = Schema::hasColumn('claims', 'status') ? DB::table('claims')->where('status', 'verified')->count() : 0;
                $rejectedClaims = Schema::hasColumn('claims', 'status') ? DB::table('claims')->where('status', 'rejected')->count() : 0;
            }
        }

        $successRate = $pendingClaims + $verifiedClaims > 0
            ? round(($verifiedClaims / max($pendingClaims + $verifiedClaims + $rejectedClaims, 1)) * 100, 1)
            : 0.0;

        return [
            'generatedAt' => $today,
            'totalItems' => $totalItems,
            'lostItems' => $lostItems,
            'foundItems' => $foundItems,
            'claimedItems' => $claimedItems,
            'totalClaims' => $pendingClaims + $verifiedClaims + $rejectedClaims,
            'pendingClaims' => $pendingClaims,
            'verifiedClaims' => $verifiedClaims,
            'rejectedClaims' => $rejectedClaims,
            'itemsReturned' => $itemsReturned,
            'activeLostItems' => $activeLostItems,
            'successRate' => $successRate,
            'totalUsers' => $totalUsers,
            'adminUsers' => $adminUsers,
            'staffUsers' => $staffUsers,
            'regularUsers' => $regularUsers,
            'itemCategories' => $itemCategories,
            'activityLabels' => $activityLabels,
            'activityItems' => $activityItems,
            'activityClaims' => $activityClaims,
        ];
    }
}
