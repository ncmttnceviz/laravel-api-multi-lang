<?php

namespace App\Models;

use App\Http\Traits\HandleLanguage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @method find(mixed $id)
 */
class Article extends Model
{
    use HasFactory, HandleLanguage;

    protected $with = 'translate';

    protected $fillable = [
        'image',
        'category_id'
    ];

    protected $visible = [
        'id',
        'image',
        'category_id'
    ];

    public function translate() : Relation
    {
        return $this->HasOne(ArticleTranslate::class)->where('language_id',$this->getCurrentLang());
    }
}
