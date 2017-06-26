<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    protected $table = 'vendas';
    
    protected $fillable = [
        'id_vendedores', 'valor_venda', 'valor_comissao', 'created_at', 'updated_at'
    ];
}
