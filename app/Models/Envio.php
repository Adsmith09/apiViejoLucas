<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Envio extends Model
{
    protected $table = "envio";
    protected $fillable = array('costoEnvio', 'lugarEnvio', 'vigencia', 'idOrden', 'idEmpleado');
    public $timestamps = false;
    
    
    public function resumen()
    {
        return $this->hasMany('App\Models\Resumen', 'idEnvio');
    }
    
    //////////////////////////7
    
    public function orden() {
        return $this->belongsTo('App\Models\Orden', 'idOrden');
    }

    public function empleado() {
        return $this->belongsTo('App\Models\Empleado', 'idEmpleado');
    }
}
