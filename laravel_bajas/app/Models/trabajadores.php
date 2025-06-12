<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema(
 *     schema="Trabajador",
 *     type="object",
 *     title="Trabajador",
 *     required={"id_trabajador", "dni", "nombre", "apellido1", "apellido2", "correo"},
 *     @OA\Property(property="id_trabajador", type="integer", example=1),
 *     @OA\Property(property="dni", type="string", example="11111111A"),
 *     @OA\Property(property="nombre", type="string", example="Aaaa"),
 *     @OA\Property(property="apellido1", type="string", example="Apellido1Aaa"),
 *     @OA\Property(property="apellido2", type="string", example="Apellido2Aaaa"),
 *     @OA\Property(property="ano_nac", type="string", format="date", example="1990-01-01"),
 *     @OA\Property(property="correo", type="string", format="email", example="aaaaa@gmail.com"),
 *     @OA\Property(property="direccion", type="string", example="C/ AAAA"),
 *     @OA\Property(property="telefono", type="string", example="111111111"),
 *     @OA\Property(property="departamento", type="string", example="IT"),
 *     @OA\Property(property="puesto", type="string", example="Desarrollador")
 * )
 */

class trabajadores extends Model
{
    //
    protected $table = 'trabajadores'; 
    protected $primaryKey = 'id_trabajador';
}
