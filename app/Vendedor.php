<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model
{
    protected $table = 'vendedores';
    
    protected $fillable = [
        'nome', 'email', 'comissao', 'created_at', 'updated_at'
    ];
    
}
