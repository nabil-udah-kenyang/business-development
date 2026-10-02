<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PromotedListing extends Model
{
    protected $fillable = [
        'catalog_type',
        'catalog_slug',
        'name',
        'price',
        'seller',
        'category',
        'location',
        'views',
        'listing_type',
        'condition',
        'image',
        'fee',
        'position',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'fee' => 'integer',
            'position' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function scopeVisible(Builder $query, string $catalogType): Builder
    {
        return $query
            ->where('catalog_type', $catalogType)
            ->where('is_active', true)
            ->orderBy('position')
            ->orderByDesc('created_at');
    }

}
