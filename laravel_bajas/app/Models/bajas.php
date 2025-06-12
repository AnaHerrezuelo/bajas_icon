<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema(
 *     schema="Baja",
 *     type="object",
 *     title="Baja",
 *     required={"id_baja", "fecha_inicio", "fecha_fin", "duracion", "motivo", "trabajador"},
 *     @OA\Property(property="id_baja", type="integer", example=1),
 *     @OA\Property(property="fecha_inicio", type="string", format="date", example="2025-06-06"),
 *     @OA\Property(property="fecha_fin", type="string", format="date", example="2025-07-06"),
 *     @OA\Property(property="duracion", type="string", example="1 mes"),
 *     @OA\Property(property="motivo", type="string", example="Accidente laboral"),
 *     @OA\Property(property="comentario", type="string", example="Caída"),
 *     @OA\Property(property="trabajador", type="integer", example=1),
 *     @OA\Property(property="estado", type="boolean", example=true)
 *      @OA\Property(property="cancelada", type="boolean", example=false)
 * )
 */

class bajas extends Model
{
    //
    protected $table = 'bajas'; 

    protected $primaryKey = 'id_baja'; //para que me coja el id_baja y no asuma un id
    protected $fillable = ['fecha_inicio', 'fecha_fin','duracion', 'motivo', 'comentario', 'trabajador', 'estado', 'cancelada']; //para poder insertar nuevos datos
    //public $timestamps = false; // si  no tengo las tablas create at ni update at
    const CREATED_AT = null;
    const UPDATED_AT = 'updated_at';


    public function bajas_fk1() {
        return $this->belongsTo(trabajadores::class, 'trabajador', 'id_trabajador');
        //añado el nombre del modelo al q quiero unirlo, luego el id de la tabla de bajas y luego el id de la tabla de trabajadores
    }


    
}
