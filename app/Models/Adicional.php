<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adicional extends Model
{
    protected $table = "adicional";
    protected $fillable = array('mermelada_tocino','aji', 'mayonesa', 'mostaza', 'vigencia');
    public $timestamps = false;
    
    public function detalleProducto()
    {
        return $this->hasMany('App\Models\DetalleProducto', 'idAdicional');
    }

    //////////////////////////
    
}
