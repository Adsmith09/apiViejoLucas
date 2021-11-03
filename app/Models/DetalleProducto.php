<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleProducto extends Model
{
    protected $table = "detalle_producto";
    protected $fillable = array('idIngrediente', 'precio', 'cantidad', 'idProducto');
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
        return $this->belongsTo('App\Models\Ingrediente', 'idIngrediente');
    }

}
