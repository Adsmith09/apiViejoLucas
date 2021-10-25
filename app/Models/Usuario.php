<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = "usuario";
    protected $fillable = array('usuario', 'contraseña', 'vigencia', 'idCliente', 'idEmpleado', 'idRol');
    public $timestamps = false;
    
    
    public function carrito()
    {
        return $this->hasMany('App\Models\Carrito', 'idUsuario');
    }
    
    public function orden()
    {
        return $this->hasMany('App\Models\Orden', 'idUsuario');
    }
    
    
    ////////////////////////////////
    
    public function cliente() {
        return $this->belongsTo('App\Models\Cliente', 'idCliente');
    }
    
    public function empleado() {
        return $this->belongsTo('App\Models\Empleado', 'idEmpleado');
    }

    public function rol() {
        return $this->belongsTo('App\Models\Rol', 'idRol');
    }
}
