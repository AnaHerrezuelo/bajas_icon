<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\trabajadores; //hay que pasar la ruta desde models
use App\Models\bajas;
use App\Models\notificaciones;

use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Mail;
use App\Mail\EnviarMail;

class bajasController extends Controller
{
    public function index() {
        $fechaActual = Carbon::today();

        $datosTrabajadores = trabajadores::all(); //hay que pasar los datos de models a una variable

        //saca todas las bajas
        $datosBajasTodas = bajas::all(); 
        $datosBajasTodas = bajas::orderBy('fecha_inicio', 'asc')->get();

        //Saca solo las bajas activas
        bajas::where('fecha_fin', '<', $fechaActual)->update(['estado' => 0]);
        $datosBajasActivas = bajas::where('estado', 1)->orderBy('fecha_inicio', 'asc')->get();

        return view('index', compact('datosBajasActivas', 'datosTrabajadores', 'datosBajasTodas')); //hay que poner el nombre de la vista a la que lo queremos mandar
    }

    public function baja($id_baja) {
        $bajaEsp = bajas::with('bajas_fk1')->findOrFail($id_baja);//with muestra solo los datos del id_baja
        return view('baja', compact('bajaEsp'), ['id_baja' => $id_baja]); //aquí paso el id_baja par poder usar la info
    }

    public function cuestionarioBaja (){
        return view('cuestionarioBaja');
    }


    public function insertarBaja(Request $request){
        $fechaActual = Carbon::today()->format('Y-m-d'); //saco la fecha de hoy
        $fechaActual2 = Carbon::now()->format('Y-m-d H:i:s'); //saco la fecha de hoy

        //verifico que existe el trabajador antes de insertar la nueva baja
        $existeTrabajador = trabajadores::where('dni', $request->trabajador)->exists();
        if(!$existeTrabajador) {
            return back()->withErrors(['trabajador' => 'El DNI del trabajador no existe'])->withInput();
        }else{
            $idtrabajadorObjeto = trabajadores::where('dni', $request->trabajador)->first();
            $trabajador = $idtrabajadorObjeto->id_trabajador; 
        }

/**/ 
//esto tengo que mirarlo desde la base de datos
        $bajaduplicada = bajas::where('fecha_inicio', $request->fecha_inicio)
                ->where('fecha_fin', $request->fecha_fin)
                ->where('motivo', $request->motivo)
                ->where('comentario', $request->comentario)
                ->where('trabajador', $trabajador)->exists();

        if ($bajaduplicada) {
            return back()->withErrors(['Esta baja ya existe'])->withInput();
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
                'trabajador' => $trabajador
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
            return redirect('/index');
            //return redirect('/index')->with('success', 'Baja correcta y notificación enviada') ;

        }catch(\Illuminate\Validation\ValidationException $e){
                return back()->withError('algo ha fallado')
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error general'.$e->getMessage());
        }
    }// end insertar baja

}
