<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\trabajadores; //hay que pasar la ruta desde models
use App\Models\bajas;
use App\Models\notificaciones;

use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Mail;
use App\Mail\EnviarMail;

/**
* @OA\Info(
*             title="API Bajas laborales", 
*             version="12.17.0",
*             description="Bajas"
* )
*
* @OA\Server(url="http://localhost:8000")
*/

class bajasApiController extends Controller
{
/**
 * @OA\Get(
 *     path="/index",
 *     tags={"Bajas"},
 *     summary="Lista de bajas activas y todas las bajas",
 *     @OA\Response(
 *         response=200,
 *         description="tabla",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="datosBajasActivas",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/Baja")
 *             ),
 *             @OA\Property(
 *                 property="datosBajasTodas",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/Baja")
 *             ),
 *             @OA\Property(
 *                 property="datosTrabajadores",
 *                 type="array",
 *                 @OA\Items(ref="#/components/schemas/Trabajador")
 *             )
 *         )
 *     )
 * )
 */





    public function index() {
        $fechaActual = Carbon::today();

        $datosTrabajadores = trabajadores::all(); //hay que pasar los datos de models a una variable

        //saca todas las bajas
        $datosBajasTodas = bajas::all(); 
        $datosBajasTodas = bajas::orderBy('fecha_inicio', 'asc')->get();

        //Saca solo las bajas activas
        bajas::where('fecha_fin', '<', $fechaActual)->where('cancelada', true)->update(['estado' => 0]);

        $datosBajasActivas = bajas::where('estado', 1)->orderBy('fecha_inicio', 'asc')->get();

               return response()->json([ 'datosTrabajadores' => $datosTrabajadores, 'datosBajasTodas' => $datosBajasTodas,
            'datosBajasActivas' => $datosBajasActivas,
        ]);
    }

    /**
     * Mostrar los detalles de una baja
     *
     * @OA\Get(
     *     path="/baja/{id_baja}",
     *     tags={"BajasEspecíficas"},
     *     summary="Obtener una baja por su ID",
     *     @OA\Parameter(
     *         name="id_baja",
     *         in="path",
     *         description="ID de la baja",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Datos de la baja específica",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", ref="#/components/schemas/Baja")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Baja no encontrada")
     * )
     */



    public function baja($id_baja) {
        $bajaEsp = bajas::with('bajas_fk1')->findOrFail($id_baja);//with muestra solo los datos del id_baja
        return response()->json(['data' => $bajaEsp]);
    }

    /**
     * Crear una nueva baja
     *
     * @OA\Post(
     *     path="/insertarBaja",
     *     tags={"insertarbaja"},
     *     summary="Crear una nueva baja laboral",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"dni", "fecha_inicio", "fecha_fin", "motivo"},
     *             @OA\Property(property="dni", type="string", description="DNI del trabajador", example="11111111A"),
     *             @OA\Property(property="fecha_inicio", type="string", format="date", example="2025-07-01"),
     *             @OA\Property(property="fecha_fin", type="string", format="date", example="2025-08-01"),
     *             @OA\Property(property="motivo", type="string", example="Accidente laboral"),
     *             @OA\Property(property="comentario", type="string", example="Rotura del ligamento cruzado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Baja creada correctamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", ref="#/components/schemas/Baja")
     *         )
     *     ),
     *     @OA\Response(response=400, description="Error en los datos enviados"),
     *     @OA\Response(response=409, description="Baja duplicada"),
     *     @OA\Response(response=500, description="Error en servidor")
     * )
     */


    public function insertarBaja(Request $request){
        $fechaActual = Carbon::today()->format('Y-m-d'); //saco la fecha de hoy
        $fechaActual2 = Carbon::now()->format('Y-m-d H:i:s'); //saco la fecha de hoy

        //verifico que existe el trabajador antes de insertar la nueva baja
        $existeTrabajador = trabajadores::where('dni', $request->input('dni'))->first();
        if(!$existeTrabajador) {
            return response()->json(['error' => 'El DNI del trabajador no existe'], 404);
        }else{
            $idtrabajadorObjeto = trabajadores::where('dni', $request->trabajador)->first();
            $trabajador = $idtrabajadorObjeto->id_trabajador; 
        }

        $trabajadorEnBaja = bajas::where('trabajador',$trabajador )->where('estado', true)->exists();;
        if($trabajadorEnBaja) {
            return back()->withErrors(['trabajador' => 'este trabajador ya está en una baja, no puede tener otra'])->withInput();
        }

/**/ 
//esto tengo que mirarlo desde la base de datos
        $bajaduplicada = bajas::where([
            ['fecha_inicio', $request->input('fecha_inicio')],
            ['fecha_fin', $request->input('fecha_fin')],
            ['motivo', $request->input('motivo')],
            ['comentario', $request->input('comentario')],
            ['trabajador', $trabajador->id_trabajador]
        ])->exists();

        if ($bajaduplicada) {
            return response()->json(['error' => 'Esta baja ya existe'], 409);
        }
     

        try{
            //valido los valores, menos el de trabajador porque ya está validado en existetrabajador
            $validarData = $request->validate([
                'fecha_inicio' => 'required|date|after_or_equal:'.$fechaActual,
                'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
                'motivo' => 'required|string|max:255',
                'comentario' => 'nullable|string',
            ]);


            // Convertimos las fechas a objetos Carbon para poder hacer la cuenta
            $fechaInicio = Carbon::parse($validarData['fecha_inicio']);
            $fechaFin = Carbon::parse($validarData['fecha_fin']);
            // Calculamos la diferencia directamente
            $diferencia = $fechaInicio->diff($fechaFin);
            // Formateamos el resultado
            $duracion = sprintf("%d años, %d meses, %d días", 
                        $diferencia->y, 
                        $diferencia->m, 
                        $diferencia->d);




            //creo la nueva baja
            $bajaNueva = bajas::create([
                'fecha_inicio' => $validarData['fecha_inicio'],
                'fecha_fin' => $validarData['fecha_fin'],
                'duracion' => $duracion,
                'motivo' => $validarData['motivo'],
                'comentario' => $validarData['comentario'],
                'trabajador' => $trabajador,
                'estado' => 1,
                'cancelada' => false    
            ]);

            $notiNueva = notificaciones::create([
                'baja' => $bajaNueva['id_baja'],
                'fecha' => $fechaActual2
            ]);


            //meto los datos de la baja nueva en una variable para poder pasarlo por el email
            $datosEmail = [
                'fecha_inicio' => $bajaNueva->fecha_inicio,
                'fecha_fin' => $bajaNueva->fecha_fin,
                'motivo' => $bajaNueva->motivo,
                'dni' => $idtrabajadorObjeto->dni
            ];

            try{
                Mail::to('analiangxin.herrezuelo.ab@gmail.com')->send(new EnviarMail($datosEmail));
            }catch (\Exception $emailException) {
                // Log del error pero continuar con el redirect
                \Log::error('Error al enviar email: '.$emailException->getMessage());
            }

            //una vez termina todo el proceso volvemos al index
            return response()->json(['data' => $bajaNueva], 201);

        }catch(\Illuminate\Validation\ValidationException $e){
            return response()->json(['error' => 'Validación fallida', 'details' => $e->errors()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error del servidor', 'details' => $e->getMessage()], 500);
        }
    }// end insertar baja

    
/**
     * Cancelo una baja
     * @OA\Get(
     *     path="/cancelarBaja",
     *     tags={"cancelarBaja"},
     *     summary="cancelo una baja",
     *     @OA\Parameter(
     *         name="id_baja",
     *         in="path",
     *         required=true,
     *         description="id de la baja a cancelar",
     *         @OA\Schema(type="integer", example=5)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Baja cancelada y correo enviado correctamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="baja", type="object",
     *                 @OA\Property(property="fecha_inicio", type="string", format="date", example="2025-06-06"),
     *                 @OA\Property(property="fecha_fin", type="string", format="date", example="2025-06-10"),
     *                 @OA\Property(property="motivo", type="string", example="Prueba manual"),
     *                 @OA\Property(property="dni", type="string", example="12345678A"),
     *                 @OA\Property(property="nombre", type="string", example="Ana"),
     *                 @OA\Property(property="apellido1", type="string", example="H"),
     *                 @OA\Property(property="apellido2", type="string", example="H")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Baja no encontrada"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error al cancelar la baja o enviar el correo"
     *     )
     * )
     */


    public function cancelarBaja($id_baja){
        $bajaEsp = bajas::with('bajas_fk1')->findOrFail($id_baja);
        $bajaEsp->update(['estado' => 0, 'cancelada' => true  ]);


        $datosEmailCancelar = [
            'fecha_inicio' => $bajaEsp->fecha_inicio,
            'fecha_fin' => $bajaEsp->fecha_fin,
            'motivo' => $bajaEsp->motivo,
            'dni' => $bajaEsp->bajas_fk1->dni,
            'nombre' => $bajaEsp->bajas_fk1->nombre,
            'apellido1' => $bajaEsp->bajas_fk1->apellido1,
            'apellido2' => $bajaEsp->bajas_fk1->apellido2,
        ];
        

        //  dd($datosEmailCancelar);


            try{
                Mail::to('analiangxin.herrezuelo.ab@gmail.com')->send(new EnviarMailCancelarBaja($datosEmailCancelar));
            }catch (\Exception $emailException) {
                // da el error pero continua con el redirect
                \Log::error('Error al enviar email: '.$emailException->getMessage());
            }


            return response()->json(['baja' => $datosEmailCancelar]);
    }

}
