<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    protected $table = 'category';
    protected $fillable = [
        'nep_title',
        'eng_title',
        'slug',
        'position',
        'meta_keywords',
        'meta_description',
        'status',
    ];
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }
}
