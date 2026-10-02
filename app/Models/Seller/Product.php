<?php

namespace App\Models\Seller;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'user_id',
        'store_id',
        'code',
        'name',
        'slug',
        'type',
        'category',
        'price',
        'description',
        'specifications',
        'location',
        'image',
        'images',
        'status',
        'views',
        'approved_at',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'views' => 'integer',
            'images' => 'array',
            'approved_at' => 'datetime',
        ];
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
