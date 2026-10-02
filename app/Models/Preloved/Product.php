<?php

namespace App\Models\Preloved;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $table = 'preloved_products';

    protected $fillable = [
        'user_id',
        'code',
        'name',
        'slug',
        'category',
        'price',
        'condition',
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
}
