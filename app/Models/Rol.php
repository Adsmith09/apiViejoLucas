<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = "rol";
    protected $fillable = array('rol');
    public $timestamps = false;

    public function usuario()
    {
        return $this->hasMany('App\Models\Usuario', 'idRol');
    }
}
