<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    protected $table = 'article';
    protected $fillable = [
        'title',
        'slug',
        'image',
        'description',
        'meta_keywords',
        'meta_description',
        'status',
    ];
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}