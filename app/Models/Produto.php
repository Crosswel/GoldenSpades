<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'imagem',
        'preco',
        'categoria',
        'descricao',
        'quantidade'
    ];

    // garante que o Eloquent trata os timestamps
    public $timestamps = true;
}
