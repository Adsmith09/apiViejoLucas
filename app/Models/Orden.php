<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    protected $table = "orden";
    protected $fillable = array('fecha', 'total', 'vigencia', 'idModoPago', 'idUsuario', 'idDetalleOrden');
    public $timestamps = false;
    
    public function envio()
    {
        return $this->hasMany('App\Models\Envio', 'idOrden');
    }

    public function resumen()
    {
        return $this->hasMany('App\Models\Resumen', 'idOrden');
    }
    
    //////////////////////////

    public function modoPago() {
        return $this->belongsTo('App\Models\ModoPago', 'idModoPago');
    }

    public function usuario() {
        return $this->belongsTo('App\Models\Usuario', 'idUsuario');
    }

    public function detalleOrden() {
        return $this->belongsTo('App\Models\DetalleOrden', 'idDetalleOrden');
    }
}
