<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class notificaciones extends Model
{
    //
    protected $table = 'notificaciones'; 
    protected $primaryKey = 'fecha';
    protected $fillable = ['baja', 'fecha']; 
    public $timestamps = false;
}
