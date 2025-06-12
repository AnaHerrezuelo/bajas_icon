<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema(
 *     schema="Notificacion",
 *     type="object",
 *     title="Notificación",
 *     required={"baja", "fecha"},
 *     @OA\Property(property="baja", type="integer", example=1),
 *     @OA\Property(property="fecha", type="string", format="date", example="2025-06-09")
 * )
 */

class notificaciones extends Model
{
    //
    protected $table = 'notificaciones'; 
    protected $primaryKey = 'fecha';
    protected $fillable = ['baja', 'fecha']; 
    public $timestamps = false;
}
