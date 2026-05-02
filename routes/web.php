<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaffLostReportController;
use App\Http\Controllers\StaffFoundReportController;
use App\Http\Controllers\StaffDashboardController;
use App\Http\Controllers\UserClaimController;
use App\Http\Controllers\ClaimController;
use App\Models\Claim;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

if (! function_exists('build_item_query')) {
    function build_item_query(Request $request): array
    {
        $query = Item::query()->with('reporter')->latest();

        $search = trim((string) $request->query('search', ''));
        if ($search !== '') {
            $query->where(function ($itemQuery) use ($search) {
                $itemQuery->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('location', 'like', '%' . $search . '%')
                    ->orWhere('tags', 'like', '%' . $search . '%');
            });
        }

        $status = trim((string) $request->query('status', ''));
        if (in_array($status, ['lost', 'found', 'claimed', 'returned'], true)) {
            $query->where('status', $status);
        }

        $category = trim((string) $request->query('category', ''));
        if ($category !== '') {
            $query->where('category', 'like', '%' . $category . '%');
        }

        return [
            'items' => $query->get(),
            'search' => $search,
            'status' => $status,
            'category' => $category,
        ];
    }
}

if (! function_exists('build_lost_items')) {
    function build_lost_items()
    {
        return Item::query()
            ->where('status', 'lost')
            ->latest()
            ->get(['id', 'title', 'description']);
    }
}

Route::get('/', function () {
    return view('welcome');
});
Route::redirect('/', '/login');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/search-items', function (Request $request) {
        return view('admin.search_items', build_item_query($request));
    })->name('admin.search-items');

    Route::get('/admin/inventory', function (Request $request) {
        return view('admin.inventory', build_item_query($request));
    })->name('admin.inventory');
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.manage-users');
    Route::patch('/admin/users/{user}/role', [AdminUserController::class, 'updateRole'])->name('admin.users.role.update');
    Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

    Route::get('/admin/reports', [AdminReportController::class, 'index'])->name('admin.reports');
    Route::get('/admin/reports/export', [AdminReportController::class, 'exportPdf'])->name('admin.reports.export');
});

// Staff
Route::middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/staff/dashboard', [StaffDashboardController::class, 'index'])->name('staff.dashboard');

    Route::get('/staff/search-items', function (Request $request) {
        return view('staff.search_items', build_item_query($request));
    })->name('staff.search-items');

    Route::get('/staff/inventory', function (Request $request) {
        return view('staff.inventory', build_item_query($request));
    })->name('staff.inventory');

    Route::get('/staff/report-found', function () {
        return view('staff.report_found', [
            'lostItems' => build_lost_items(),
        ]);
    })->name('staff.report-found');
    Route::get('/staff/report_found', function () {
        return redirect()->route('staff.report-found');
    });
    Route::post('/staff/report-found', [StaffFoundReportController::class, 'store'])->name('staff.report-found.store');

    Route::get('/staff/verify_claims', [ClaimController::class, 'index'])->name('staff.verify-claims');
    Route::get('/verify-claims', function () {
        return redirect()->route('staff.verify-claims');
    });
    Route::patch('/claims/{claim}/verify', [ClaimController::class, 'verify'])->name('claims.verify');
    Route::patch('/claims/{claim}/reject', [ClaimController::class, 'reject'])->name('claims.reject');
});

// User
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function (Request $request) {
        $userId = $request->user()->id;

        $myReportsCount = 0;
        $myClaimsCount = 0;
        $availableItemsCount = 0;
        $lostItemsCount = 0;

        if (Schema::hasTable('items')) {
            if (Schema::hasColumn('items', 'reported_by')) {
                $myReportsCount = Item::query()
                    ->where('reported_by', $userId)
                    ->count();
            }

            if (Schema::hasColumn('items', 'status')) {
                $availableItemsCount = Item::query()->where('status', 'found')->count();
                $lostItemsCount = Item::query()->where('status', 'lost')->count();
            }
        }

        if (Schema::hasTable('claims')) {
            $myClaimsCount = Claim::query()
                ->where('user_id', $userId)
                ->count();
        }

        return view('users.users_dashboard', [
            'myReportsCount' => $myReportsCount,
            'myClaimsCount' => $myClaimsCount,
            'availableItemsCount' => $availableItemsCount,
            'lostItemsCount' => $lostItemsCount,
        ]);
    })->name('dashboard');

    Route::get('/user/search-items', function (Request $request) {
        return view('users.search_items', build_item_query($request));
    })->name('user.search-items');

    Route::get('/user/Report-found', function () {
        return view('users.report_found', [
            'lostItems' => build_lost_items(),
        ]);
    })->name('user.report-found');
    Route::post('/user/report-found', [StaffFoundReportController::class, 'store'])->name('user.report-found.store');

    Route::get('/user/Report-lost', function () {
        return view('users.report_lost');
    })->name('user.report-lost');
    Route::post('/user/report-lost', [StaffLostReportController::class, 'store'])->name('user.report-lost.store');
    Route::post('/user/claims', [UserClaimController::class, 'store'])->name('user.claims.store');

    Route::redirect('/users/dashboard', '/dashboard');
});
require __DIR__ . '/auth.php';
