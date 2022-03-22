<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method where(string $string, mixed $shortCode)
 */
class Language extends Model
{
    use HasFactory;

    protected $fillable = [
        'short_code',
        'title',
        'is_main'
    ];

    protected $visible = [
        'id',
        'short_code',
        'title'
    ];
}
