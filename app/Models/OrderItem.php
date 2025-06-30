<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'produto_id',
        'quantidade',
        'preco'
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
