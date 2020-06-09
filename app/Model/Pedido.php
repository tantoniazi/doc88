<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use SoftDeletes;

    protected $table = 'pedido';
    

    public function get(array $params) : Collection
    {
        return $this->select('*')
            ->join('cliente','pedido.cliente_id','=','cliente.id')
            ->join('pedido_x_pastel','pedido.id','=','pedido_x_pastel.pedido_id')
            ->join('pastel','pastel.id','=','pedido_x_pastel.pastel_id')
            ->where('pedido.id','=', $params['id'])
            ->where('pedido.cliente_id','=', $params['cliente_id'])
            ->get();
    }

    public $fillable = [
        'cliente_id'
    ];
}