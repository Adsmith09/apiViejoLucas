<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    protected $table = "direccion";
    protected $fillable = array('calle', 'numero', 'referencia', 'ciudad', 'vigencia', 'idCliente');
    public $timestamps = false;
    
    public function cliente() {
        return $this->belongsTo('App\Models\Cliente', 'idCliente');
    }
}
