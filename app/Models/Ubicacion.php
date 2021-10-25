<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    protected $table = "ubicacion";
    protected $fillable = array('ubicacion', 'vigencia');
    public $timestamps = false;

    public function empleado()
    {
        return $this->hasMany('App\Models\Empleado', 'idUbicacion');
    }
}
