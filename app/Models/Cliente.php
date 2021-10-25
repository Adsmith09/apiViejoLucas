<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = "cliente";
    protected $fillable = array('nombres', 'apellidos', 'dni', 'correo', 'telefono', 'vigencia');
    public $timestamps = false;

    public function direccion()
    {
        return $this->hasMany('App\Models\Direccion', 'idCliente');
    }
    
    public function usuario()
    {
        return $this->hasMany('App\Models\Usuario', 'idCliente');
    }
    

    //////////////////////////////////////

    
}
