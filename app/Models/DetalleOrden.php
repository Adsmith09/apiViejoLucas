<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleOrden extends Model
{
    protected $table = "detalle_orden";
    protected $fillable = array('cantidad', 'precio', 'vigencia', 'idDetalleProducto');
    public $timestamps = false;
    
    public function orden()
    {
        return $this->hasMany('App\Models\Orden', 'idDetalleOrden');
    }

    ///////////////////////////////

    public function detalleProducto() {
        return $this->belongsTo('App\Models\DetalleProducto', 'idDetalleProducto');
    }

    
}
