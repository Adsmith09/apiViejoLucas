<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModoPago extends Model
{
    protected $table = "modo_pago";
    protected $fillable = array('tipo', 'fraccionPago', 'montoEfectivo');
    public $timestamps = false;

    public function orden()
    {
        return $this->hasMany('App\Models\Orden', 'idModoPago');
    }

    ////////////////////////////////
}
