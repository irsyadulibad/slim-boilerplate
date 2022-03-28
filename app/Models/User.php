<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    protected $hidden = [];
}
