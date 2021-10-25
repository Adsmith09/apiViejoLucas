<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    protected $table = "carrito";
    protected $fillable = array('cantidad', 'vigencia', 'idUsuario', 'idProducto');
    public $timestamps = false;

    


    //////////////////////////////7

    public function usuario() {
        return $this->belongsTo('App\Models\Usuario', 'idUsuario');
    }

    public function producto() {
        return $this->belongsTo('App\Models\Producto', 'idProducto');
    }




}
