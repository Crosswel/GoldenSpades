<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'total', '...']; // adiciona os campos que tiveres

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
