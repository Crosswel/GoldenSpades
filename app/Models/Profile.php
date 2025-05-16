<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'address', // adicione aqui os campos permitidos
        // exemplo: 'user_id', 'phone', 'bio'
    ];
}
