<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleProducto extends Model
{
    protected $table = "detalle_producto";
    protected $fillable = array('carne', 'queso', 'huevo', 'platanoFrito', 'jamon', 'piña', 'tocino', 'salcHuachana', 'lechuga', 'tomate', 'vigencia', 'idProducto', 'idAdicional');
    public $timestamps = false;

    public function detalleOrden()
    {
        return $this->hasMany('App\Models\DetalleOrden', 'idDetalleProducto');
    }
    
    ///////////////////////////////////////////////////////////////
    
    public function producto() {
        return $this->belongsTo('App\Models\Producto', 'idProducto');
    }

    public function adicional() {
        return $this->belongsTo('App\Models\Adicional', 'idAdicional');
    }

}
