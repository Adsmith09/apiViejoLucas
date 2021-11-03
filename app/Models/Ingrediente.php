<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingrediente extends Model
{
    protected $table = "ingrediente";
    protected $fillable = array('nombre', 'precio', 'vigencia');
    public $timestamps = false;
}
