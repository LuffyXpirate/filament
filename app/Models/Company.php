<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'logo',
        'email',
        'contact',
        'address',
        'facebook',
        'youtube',
    ];
protected $table = 'company';

    
}
