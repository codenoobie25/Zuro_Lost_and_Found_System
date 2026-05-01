<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StaffLostReportController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'image' => ['required', 'image', 'max:5120'],
            'category' => ['required', 'string', 'max:100'],
            'custom_category' => ['nullable', 'string', 'max:100', 'required_if:category,other'],
            'color' => ['nullable', 'string', 'max:100'],
            'location' => ['required', 'string', 'max:255'],
            'date_found' => ['nullable', 'date'],
            'tags' => ['nullable', 'string', 'max:500'],
        ]);

        $resolvedCategory = $validated['category'] === 'other'
            ? trim((string) ($validated['custom_category'] ?? ''))
            : $validated['category'];

        if (!Schema::hasTable('items')) {
            return back()->withInput()->with('error', 'Items table is not set up yet. Please run the items migration first.');
        }

        $imagePath = $request->file('image')->store('lost-items', 'public');

        $payload = [];

        if (Schema::hasColumn('items', 'title')) {
            $payload['title'] = $validated['title'];
        }
        if (Schema::hasColumn('items', 'description')) {
            $payload['description'] = $validated['description'];
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
            $payload['status'] = 'lost';
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

        return back()->with('status', 'Lost item report submitted successfully.');
    }
}
