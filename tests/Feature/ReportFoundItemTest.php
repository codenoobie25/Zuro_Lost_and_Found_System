<?php

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\withoutMiddleware;

test('report found item can use a lost item from the dropdown', function () {
    Storage::fake('public');
    withoutMiddleware(ValidateCsrfToken::class);

    $user = User::factory()->create();
    $lostItem = Item::query()->create([
        'title' => 'Blue Backpack',
        'description' => 'A blue backpack with a front zipper pocket.',
        'image_path' => 'lost-items/example.jpg',
        'category' => 'bags-backpacks',
        'color' => 'Blue',
        'location' => 'Library',
        'date_found' => now()->toDateString(),
        'tags' => 'backpack, blue',
        'status' => 'lost',
        'reported_by' => $user->id,
    ]);

    $response = actingAs($user)->post('/user/report-found', [
        'source_item_id' => (string) $lostItem->id,
        'image' => UploadedFile::fake()->create('found.jpg', 100, 'image/jpeg'),
        'category' => 'bags-backpacks',
        'color' => 'Blue',
        'location' => 'Main hallway',
        'date_found' => now()->toDateString(),
        'tags' => 'backpack, blue',
    ]);

    $response->assertSessionHasNoErrors()->assertRedirect();

    assertDatabaseHas('items', [
        'title' => 'Blue Backpack',
        'description' => 'A blue backpack with a front zipper pocket.',
        'status' => 'found',
        'reported_by' => $user->id,
    ]);
});

test('report found item can be entered manually when the item is not listed', function () {
    Storage::fake('public');
    withoutMiddleware(ValidateCsrfToken::class);

    $user = User::factory()->create();

    $response = actingAs($user)->post('/user/report-found', [
        'source_item_id' => 'not_listed',
        'manual_title' => 'Silver Umbrella',
        'manual_description' => 'A silver umbrella with a curved black handle.',
        'image' => UploadedFile::fake()->create('found.jpg', 100, 'image/jpeg'),
        'category' => 'umbrellas',
        'color' => 'Silver',
        'location' => 'Cafeteria',
        'date_found' => now()->toDateString(),
        'tags' => 'umbrella, silver',
    ]);

    $response->assertSessionHasNoErrors()->assertRedirect();

    assertDatabaseHas('items', [
        'title' => 'Silver Umbrella',
        'description' => 'A silver umbrella with a curved black handle.',
        'status' => 'found',
        'reported_by' => $user->id,
    ]);
});
