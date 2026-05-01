<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image_path',
        'category',
        'color',
        'location',
        'date_found',
        'tags',
        'status',
        'reported_by',
    ];

    protected function casts(): array
    {
        return [
            'date_found' => 'date',
        ];
    }

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function claims(): HasMany
    {
        return $this->hasMany(Claim::class);
    }
}
