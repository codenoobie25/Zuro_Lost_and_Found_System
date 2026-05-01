<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Item;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserClaimController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'item_id' => ['required', 'integer', 'exists:items,id'],
            'reason' => ['nullable', 'string', 'max:1000'],
        ]);

        $item = Item::findOrFail($validated['item_id']);

        if ($item->status !== 'found') {
            return redirect()->back()->with('error', 'Only found items can be claimed.');
        }

        $existingPending = Claim::where('item_id', $item->id)
            ->where('user_id', $request->user()->id)
            ->where('status', 'pending')
            ->exists();

        if ($existingPending) {
            return redirect()->back()->with('error', 'You already submitted a pending claim for this item.');
        }

        Claim::create([
            'item_id' => $item->id,
            'user_id' => $request->user()->id,
            'reason' => $validated['reason'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('status', 'Your claim has been submitted and is pending staff review.');
    }
}
