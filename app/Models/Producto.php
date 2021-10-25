<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = "producto";
    protected $fillable = array('nombre', 'descripcion', 'categoria', 'precio', 'imagen', 'vigencia');
    public $timestamps = false;
    
    public function carrito()
    {
        return $this->hasMany('App\Models\Carrito', 'idProducto');
    }
    
    public function detalleProducto()
    {
        return $this->hasMany('App\Models\DetalleProducto', 'idProducto');
    }
    
    ////////////////////////////
}
