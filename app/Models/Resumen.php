<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resumen extends Model
{
    protected $table = "resumen";
    protected $fillable = array('pagoTotal', 'vigencia', 'idOrden', 'idEnvio');
    public $timestamps = false;
    
    
    
    //////////////////////////
    
    public function orden() {
        return $this->belongsTo('App\Models\Orden', 'idOrden');
    }

    public function envio() {
        return $this->belongsTo('App\Models\Envio', 'idEnvio');
    }
}
