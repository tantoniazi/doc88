<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PedidoXPastel extends Model
{
    use SoftDeletes;

    protected $table = 'pedido_x_pastel';
  
    public $fillable = ['pedido_id' , 'pastel_id'];

}