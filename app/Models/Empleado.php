<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = "empleado";
    protected $fillable = array('nombres', 'apellidos', 'dni', 'correo', 'telefono', 'vigencia', 'idUbicacion');
    public $timestamps = false;

    public function envio()
    {
        return $this->hasMany('App\Models\Envio', 'idEmpleado');
    }

    public function usuario()
    {
        return $this->hasMany('App\Models\Usuario', 'idEmpleado');
    }


    ////////////////////////////////////
    
    public function ubicacion() {
        return $this->belongsTo('App\Models\Ubicacion', 'idUbicacion');
    }

   
}
