<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'event_date',
        'location',
        'is_online',
        'meeting_link',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'datetime',
            'is_online' => 'boolean',
            'is_active' => 'boolean',
        ];
    }
}
