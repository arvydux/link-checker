<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'redirects',
        'redirect_amount',
        'keywords'.
        'checked_at',
    ];

    protected $casts = [
        'redirects' => 'array',
    ];
}
