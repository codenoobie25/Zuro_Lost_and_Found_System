<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class ClaimController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status', 'pending');
        $allowedStatuses = ['pending', 'verified', 'rejected', 'completed'];
        if (!in_array($status, $allowedStatuses, true)) {
            $status = 'pending';
        }

        $claims = collect();
        $counts = [
            'pending' => 0,
            'verified' => 0,
            'rejected' => 0,
            'completed' => 0,
        ];

        if (Schema::hasTable('claims') && Schema::hasColumn('claims', 'status')) {
            $counts['pending'] = Claim::where('status', 'pending')->count();
            $counts['verified'] = Claim::where('status', 'verified')->count();
            $counts['rejected'] = Claim::where('status', 'rejected')->count();
            $counts['completed'] = $counts['verified'] + $counts['rejected'];

            $claimsQuery = Claim::with(['item', 'user', 'reviewer'])->latest();

            if ($status === 'completed') {
                $claimsQuery->whereIn('status', ['verified', 'rejected']);
            } else {
                $claimsQuery->where('status', $status);
            }

            $claims = $claimsQuery->get();
        }

        return view('staff.verify_claims', compact('claims', 'counts', 'status'));
    }

    public function verify(Request $request, Claim $claim): RedirectResponse
    {
        if ($claim->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending claims can be verified.');
        }

        DB::transaction(function () use ($claim, $request) {
            $claim->update([
                'status' => 'verified',
                'reviewed_by' => $request->user()->id,
                'reviewed_at' => now(),
            ]);

            if ($claim->item) {
                $claim->item->update(['status' => 'claimed']);
            }
        });

        return redirect()->back()->with('success', 'Claim verified successfully.');
    }

    public function reject(Request $request, Claim $claim): RedirectResponse
    {
        if ($claim->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending claims can be rejected.');
        }

        DB::transaction(function () use ($claim, $request) {
            $claim->update([
                'status' => 'rejected',
                'reviewed_by' => $request->user()->id,
                'reviewed_at' => now(),
            ]);

            if ($claim->item && $claim->item->status === 'claimed') {
                $claim->item->update(['status' => 'found']);
            }
        });

        return redirect()->back()->with('success', 'Claim rejected successfully.');
    }
}
