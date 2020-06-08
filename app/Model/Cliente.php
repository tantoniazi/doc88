<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use SoftDeletes;

    protected $table = 'cliente';

    public $fillable = [
        'nome' , 
        'email' ,
        'telefone' ,
        'data_nascimento' ,
        'endereco' ,
        'complemento' ,
        'bairro' ,
        'cep' 
    ];
    public function pedido()
    {
        return $this->belongsTo(App\Model\Pedido::class);
    }
}