<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = [
        'visitor_key',
        'ip_address',
        'user_agent',
        'visit_date',
        'hits',
    ];

    protected function casts(): array
    {
        return [
            'visit_date' => 'date',
            'hits' => 'integer',
        ];
    }
}
