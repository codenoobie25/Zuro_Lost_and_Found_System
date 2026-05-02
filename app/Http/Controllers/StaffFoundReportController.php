<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StaffFoundReportController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'source_item_id' => ['required', 'string'],
            'manual_title' => ['nullable', 'string', 'max:255'],
            'manual_description' => ['nullable', 'string', 'max:5000'],
            'image' => ['required', 'image', 'max:5120'],
            'category' => ['required', 'string', 'max:100'],
            'custom_category' => ['nullable', 'string', 'max:100', 'required_if:category,other'],
            'color' => ['nullable', 'string', 'max:100'],
            'location' => ['required', 'string', 'max:255'],
            'date_found' => ['nullable', 'date'],
            'tags' => ['nullable', 'string', 'max:500'],
        ]);

        if ($validated['source_item_id'] === 'not_listed') {
            $request->validate([
                'manual_title' => ['required', 'string', 'max:255'],
                'manual_description' => ['required', 'string', 'max:5000'],
            ]);

            $title = trim((string) $validated['manual_title']);
            $description = trim((string) $validated['manual_description']);
        } else {
            $sourceItem = Item::query()
                ->whereKey($validated['source_item_id'])
                ->where('status', 'lost')
                ->first();

            if (! $sourceItem) {
                return back()->withInput()->with('error', 'The selected lost item is no longer available.');
            }

            $title = $sourceItem->title;
            $description = $sourceItem->description;
        }

        $resolvedCategory = $validated['category'] === 'other'
            ? trim((string) ($validated['custom_category'] ?? ''))
            : $validated['category'];

        if (!Schema::hasTable('items')) {
            return back()->withInput()->with('error', 'Items table is not set up yet. Please run the items migration first.');
        }

        $imagePath = $request->file('image')->store('found-items', 'public');

        $payload = [];

        // Insert only into columns that exist, so this works with evolving schema.
        if (Schema::hasColumn('items', 'title')) {
            $payload['title'] = $title;
        }
        if (Schema::hasColumn('items', 'description')) {
            $payload['description'] = $description;
        }
        if (Schema::hasColumn('items', 'image_path')) {
            $payload['image_path'] = $imagePath;
        }
        if (Schema::hasColumn('items', 'category')) {
            $payload['category'] = $resolvedCategory;
        }
        if (Schema::hasColumn('items', 'color')) {
            $payload['color'] = $validated['color'] ?? null;
        }
        if (Schema::hasColumn('items', 'location')) {
            $payload['location'] = $validated['location'];
        }
        if (Schema::hasColumn('items', 'date_found')) {
            $payload['date_found'] = $validated['date_found'] ?? now()->toDateString();
        }
        if (Schema::hasColumn('items', 'tags')) {
            $payload['tags'] = $validated['tags'] ?? null;
        }
        if (Schema::hasColumn('items', 'status')) {
            $payload['status'] = 'found';
        }
        if (Schema::hasColumn('items', 'reported_by')) {
            $payload['reported_by'] = $request->user()->id;
        }
        if (Schema::hasColumn('items', 'created_at')) {
            $payload['created_at'] = now();
        }
        if (Schema::hasColumn('items', 'updated_at')) {
            $payload['updated_at'] = now();
        }

        if (empty($payload)) {
            return back()->withInput()->with('error', 'Items table columns are not ready for saving reports yet.');
        }

        DB::table('items')->insert($payload);

        return back()->with('status', 'Found item report submitted successfully.');
    }
}
