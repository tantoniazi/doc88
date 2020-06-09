<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pastel extends Model
{
    use SoftDeletes;


    protected $table = 'pastel';
    public function pedido()
    {
        return $this->belongsTo(App\Model\Pedido::class);
    }

    public $fillable = [
        'nome' ,
        'preco' ,
        'foto'
    ];
}