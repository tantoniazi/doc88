<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use SoftDeletes;

    protected $table = 'pedido';
    
    public function cliente()
    {
        return $this->hasOne(App\Model\Cliente::class);
    }


    public function pastel()
    {
        return $this->hasMany(App\Model\Pastel::class);
    }
}