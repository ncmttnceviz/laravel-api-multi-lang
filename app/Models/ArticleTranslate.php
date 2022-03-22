<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method where(string $string, mixed $id)
 */
class ArticleTranslate extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'content',
        'article_id'
    ];

    protected $visible = [
        'id',
        'slug',
        'title',
        'content',
        'article_id'
    ];
}
