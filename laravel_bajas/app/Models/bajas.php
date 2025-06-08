<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class bajas extends Model
{
    //
    protected $table = 'bajas'; 

    protected $primaryKey = 'id_baja'; //para que me coja el id_baja y no asuma un id
    protected $fillable = ['fecha_inicio', 'fecha_fin','duracion', 'motivo', 'comentario', 'trabajador']; //para poder insertar nuevos datos
    public $timestamps = false; // no tengo las tablas create at ni update at


    public function bajas_fk1() {
        return $this->belongsTo(trabajadores::class, 'trabajador', 'id_trabajador');
        //añado el nombre del modelo al q quiero unirlo, luego el id de la tabla de bajas y luego el id de la tabla de trabajadores
    }


    
}
