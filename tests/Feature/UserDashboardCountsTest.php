<?php

use App\Models\Claim;
use App\Models\Item;
use App\Models\User;
use function Pest\Laravel\actingAs;

it('shows live dashboard counters from the database', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();

    Item::query()->create([
        'title' => 'User Lost 1',
        'description' => 'Lost report by user 1',
        'image_path' => 'lost-items/lost-1.jpg',
        'category' => 'bags-backpacks',
        'color' => 'Black',
        'location' => 'Library',
        'date_found' => now()->toDateString(),
        'tags' => 'bag',
        'status' => 'lost',
        'reported_by' => $user->id,
    ]);

    Item::query()->create([
        'title' => 'User Found 1',
        'description' => 'Found report by user 1',
        'image_path' => 'found-items/found-1.jpg',
        'category' => 'electronics',
        'color' => 'White',
        'location' => 'Cafeteria',
        'date_found' => now()->toDateString(),
        'tags' => 'phone',
        'status' => 'found',
        'reported_by' => $user->id,
    ]);

    Item::query()->create([
        'title' => 'Other Lost 1',
        'description' => 'Lost report by other user',
        'image_path' => 'lost-items/lost-2.jpg',
        'category' => 'ids-cards',
        'color' => null,
        'location' => 'Hallway',
        'date_found' => now()->toDateString(),
        'tags' => 'id',
        'status' => 'lost',
        'reported_by' => $otherUser->id,
    ]);

    Item::query()->create([
        'title' => 'Other Found 1',
        'description' => 'Found report by other user',
        'image_path' => 'found-items/found-2.jpg',
        'category' => 'keys',
        'color' => 'Silver',
        'location' => 'Gym',
        'date_found' => now()->toDateString(),
        'tags' => 'key',
        'status' => 'found',
        'reported_by' => $otherUser->id,
    ]);

    $userClaimedItem = Item::query()->create([
        'title' => 'Claim target',
        'description' => 'An item to claim',
        'image_path' => 'found-items/found-3.jpg',
        'category' => 'wallets-purses',
        'color' => 'Brown',
        'location' => 'Office',
        'date_found' => now()->toDateString(),
        'tags' => 'wallet',
        'status' => 'found',
        'reported_by' => $otherUser->id,
    ]);

    Claim::query()->create([
        'item_id' => $userClaimedItem->id,
        'user_id' => $user->id,
        'reason' => 'This is mine',
        'status' => 'pending',
    ]);

    Claim::query()->create([
        'item_id' => $userClaimedItem->id,
        'user_id' => $otherUser->id,
        'reason' => 'Other claim',
        'status' => 'pending',
    ]);

    $response = actingAs($user)->get('/dashboard');

    $response->assertOk();
    $response->assertViewHas('myReportsCount', 2);
    $response->assertViewHas('myClaimsCount', 1);
    $response->assertViewHas('availableItemsCount', 3);
    $response->assertViewHas('lostItemsCount', 2);

    Item::query()->create([
        'title' => 'User Lost 2',
        'description' => 'Another lost item by user',
        'image_path' => 'lost-items/lost-3.jpg',
        'category' => 'documents',
        'color' => null,
        'location' => 'Registrar',
        'date_found' => now()->toDateString(),
        'tags' => 'doc',
        'status' => 'lost',
        'reported_by' => $user->id,
    ]);

    $secondClaimItem = Item::query()->create([
        'title' => 'Second claim target',
        'description' => 'Second item to claim',
        'image_path' => 'found-items/found-4.jpg',
        'category' => 'books-notebooks',
        'color' => 'Blue',
        'location' => 'Room 101',
        'date_found' => now()->toDateString(),
        'tags' => 'notebook',
        'status' => 'found',
        'reported_by' => $otherUser->id,
    ]);

    Claim::query()->create([
        'item_id' => $secondClaimItem->id,
        'user_id' => $user->id,
        'reason' => 'Second claim by user',
        'status' => 'pending',
    ]);

    $updatedResponse = actingAs($user)->get('/dashboard');

    $updatedResponse->assertOk();
    $updatedResponse->assertViewHas('myReportsCount', 3);
    $updatedResponse->assertViewHas('myClaimsCount', 2);
    $updatedResponse->assertViewHas('availableItemsCount', 4);
    $updatedResponse->assertViewHas('lostItemsCount', 3);
});
