<?php

use App\Models\Claim;
use App\Models\Item;
use App\Models\User;

it('shows live found and pending claim counts on the staff dashboard', function () {
    $staff = User::factory()->create([
        'role' => 'staff',
    ]);

    $foundItem = Item::create([
        'title' => 'Blue Backpack',
        'description' => 'A blue backpack left in the library.',
        'image_path' => 'items/blue-backpack.jpg',
        'category' => 'bags',
        'color' => 'blue',
        'location' => 'Library',
        'date_found' => now()->toDateString(),
        'tags' => 'backpack,library',
        'status' => 'found',
        'reported_by' => $staff->id,
    ]);

    $lostItem = Item::create([
        'title' => 'Red Wallet',
        'description' => 'A red wallet found near the cafeteria.',
        'image_path' => 'items/red-wallet.jpg',
        'category' => 'wallets',
        'color' => 'red',
        'location' => 'Cafeteria',
        'date_found' => now()->toDateString(),
        'tags' => 'wallet,red',
        'status' => 'lost',
        'reported_by' => $staff->id,
    ]);

    Claim::create([
        'item_id' => $foundItem->id,
        'user_id' => $staff->id,
        'reason' => 'This is my backpack.',
        'status' => 'pending',
    ]);

    Claim::create([
        'item_id' => $lostItem->id,
        'user_id' => $staff->id,
        'reason' => 'Verified claim for testing.',
        'status' => 'verified',
        'reviewed_by' => $staff->id,
        'reviewed_at' => now(),
    ]);

    $this->actingAs($staff)
        ->get('/staff/dashboard')
        ->assertOk()
        ->assertViewHas('foundItems', 1)
        ->assertViewHas('pendingClaims', 1)
        ->assertViewHas('verifiedClaims', 1)
        ->assertViewHas('totalItems', 2);
});
