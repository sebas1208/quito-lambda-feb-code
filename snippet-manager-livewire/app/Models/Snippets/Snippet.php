<?php

namespace App\Models\Snippets;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property array $tags
 * @property string $language
 * @property string $title
 * @property string $code
 */
class Snippet extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'language',
        'code',
        'tags',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'tags' => 'array',
    ];

    public function getLanguageLabel(): string
    {
        return Language::from($this->language)->label();
    }
}
