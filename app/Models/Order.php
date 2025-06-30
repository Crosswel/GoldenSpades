<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'metodo',
        'estado',
        'endereco',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
{
    return $this->hasMany(OrderItem::class);
}



}
