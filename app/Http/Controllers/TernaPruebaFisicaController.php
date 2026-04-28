<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TernaEvaluadora;
use App\Models\EventosPrincipal;
use App\Models\Evaluado;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Medico;

class TernaPruebaFisicaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        if (!$user->hasRole('Evaluador') && !$user->hasRole('Administrador')) {
            abort(403, 'Acceso no autorizado.');
        }
        
        // Buscar el registro de Evaluado que corresponde a este Usuario
        $evaluador = Evaluado::where('user_id', $user->id)->first();
        
        if (!$evaluador && !$user->hasRole('Administrador')) {
            return redirect()->route('home')->with('error', 'No tiene un registro de evaluador vinculado.');
        }

        // Si es Admin, podemos dejarle ver la primera terna o todas (para pruebas)
        // Pero para el Evaluador OJEE, buscamos su terna específica
        if ($user->hasRole('Administrador')) {
            $terna = TernaEvaluadora::first();
        } else {
            $terna = TernaEvaluadora::where('OJEE_id', $evaluador->id)->first();
        }

        if (!$terna) {
            return redirect()->route('home')->with('error', 'No tiene una terna asignada como Jefe de Equipo.');
        }

        $evaluados = $terna->evaluadosAsignados;

        return view('terna_pruebas.menu', compact('terna', 'evaluados'));
    }

    public function registrarEvento($terna_id, $evento)
    {
        $terna = TernaEvaluadora::findOrFail($terna_id);
        $evaluados = $terna->evaluadosAsignados;
        return view('terna_pruebas.evaluacion_evento', compact('terna', 'evaluados', 'evento'));
    }

    public function storeResultados(Request $request)
    {
        $evaluado_id = $request->input('evaluado_id');
        $terna_id = $request->input('terna_id');
        $evento = $request->input('evento'); 
        $cantidad = $request->input('cantidad');

        $columna = $evento;
        if ($evento === 'pechadas') {
            $columna = 'pechada';
        } elseif ($evento === 'abdominales') {
            $columna = 'abdominal';
        }

        $terna = TernaEvaluadora::findOrFail($terna_id);
        
        $terna->evaluadosAsignados()->updateExistingPivot($evaluado_id, [
            $columna => $cantidad,
            'updated_at' => now()
        ]);

        if ($request->ajax()) {
            $evaluado = Evaluado::find($evaluado_id);
            return response()->json([
                'success' => true,
                'mensaje' => 'Resultado guardado para ' . mb_strtoupper($evaluado->nombre),
                'evento' => $evento
            ]);
        }

        return redirect()->route('terna.pruebas.evento', [$terna_id, $evento])
                         ->with('mensaje', 'Resultado guardado para este evaluado.');
    }

    public function resumenEvaluacion($terna_id)
    {
        $terna = TernaEvaluadora::findOrFail($terna_id);
        $evaluados = $terna->evaluadosAsignados;
        $fecha = date('d-m-Y');

        foreach ($evaluados as $evaluado) {
            $evaluado->resultadoFinal = $this->calcularCalificacionFinal($evaluado);
        }

        return view('terna_pruebas.resumen', compact('terna', 'evaluados', 'fecha'));
    }

    private function calcularCalificacionFinal($evaluado)
    {
        $pivot = $evaluado->pivot;
        if (!$pivot || !$pivot->pechada || !$pivot->abdominal || !$pivot->carrera) {
            return ['calificacion' => 0, 'observacion' => 'INCOMPLETO'];
        }

        $p = $this->calcularScoreIndividual($evaluado, 'pechadas', $pivot->pechada);
        $a = $this->calcularScoreIndividual($evaluado, 'abdominales', $pivot->abdominal);
        $c = $this->calcularScoreIndividual($evaluado, 'carrera', $pivot->carrera);

        $promedio = round(($p + $a + $c) / 3, 2);

        // Penalización por sobrepeso (lógica de EventosPrincipalController)
        $medico = Medico::where('id_evaluado', $evaluado->id)->latest()->first();
        $pesoexc = $medico ? $medico->exceso : 0;
        
        $final = $promedio;
        $obs = "APROBADO";

        if ($pesoexc >= 5) {
            $penalizacion = $pesoexc - 5;
            $final = $promedio - $penalizacion;
            if ($penalizacion > 0) $obs = "SOBREPESO";
        }

        if ($final < 70) {
            $obs = $obs == "SOBREPESO" ? "SOBREPESO/REPO" : "REPROBADO";
        }

        return ['calificacion' => max(0, $final), 'observacion' => $obs];
    }

    public function finalizarPrueba(Request $request)
    {
        $terna_id = $request->input('terna_id');
        $terna = TernaEvaluadora::find($terna_id);
        
        if ($terna) {
            foreach ($terna->evaluadosAsignados as $evaluado) {
                $terna->evaluadosAsignados()->updateExistingPivot($evaluado->id, ['estado' => 'completado']);
            }
        }

        return redirect()->route('terna.pruebas.resumen', [$terna_id])->with('mensaje', 'Prueba finalizada exitosamente.');
    }

    public function updateIndividual(Request $request)
    {
        $evaluado_id = $request->input('evaluado_id');
        $terna_id = $request->input('terna_id');

        $terna = TernaEvaluadora::findOrFail($terna_id);
        $terna->evaluadosAsignados()->updateExistingPivot($evaluado_id, [
            'pechada' => $request->input('pechada'),
            'abdominal' => $request->input('abdominal'),
            'carrera' => $request->input('carrera'),
            'updated_at' => now()
        ]);

        return redirect()->route('terna.pruebas.resumen', [$terna_id])->with('mensaje', 'Resultados actualizados correctamente.');
    }

    public function obtenerPuntaje(Request $request)
    {
        $evaluado = Evaluado::find($request->evaluado_id);
        if (!$evaluado) return response()->json(['puntaje' => 0]);

        $puntaje = $this->calcularScoreIndividual($evaluado, $request->evento, $request->valor);
        
        return response()->json(['puntaje' => $puntaje ?? 0]);
    }

    private function calcularScoreIndividual($evaluado, $evento, $valor)
    {
        if (!$valor) return 0;

        $sexoColumn = ($evaluado->sexo === 'F') ? 'nota_fem' : 'nota_mas';
        $categoria = $evaluado->categoria;
        $edadRaw = Carbon::parse($evaluado->fechanac)->age;
        $edad = $edadRaw;

        // Normalizar edad según rangos del sistema
        if ($edadRaw <= 21) $edad = 17;
        elseif ($edadRaw <= 26) $edad = 22;
        elseif ($edadRaw <= 31) $edad = 27;
        elseif ($edadRaw <= 36) $edad = 32;
        elseif ($edadRaw <= 40) $edad = 37;
        elseif ($edadRaw <= 45) $edad = 41;
        elseif ($edadRaw <= 50) $edad = 46;
        else $edad = 51;

        $puntaje = 0;

        if ($categoria == "Regular") {
            if ($evento == 'pechadas') {
                $val = min($valor, 68);
                $puntaje = DB::table('tbl_fb_o_ebr')->where('edad', $edad)->where('repeticiones', $val)->value($sexoColumn);
            } elseif ($evento == 'abdominales') {
                $val = min($valor, 78);
                $puntaje = DB::table('tbl_abdo_o_ebr')->where('edad', $edad)->where('repeticiones', $val)->value($sexoColumn);
            } elseif ($evento == 'carrera') {
                // Para carrera se usa tbl_carr_o_ebs_pa según EventosPrincipalController para Regular también en algunos casos?
                // Re-revisando EventosPrincipalController:387
                $puntaje = DB::table('tbl_carr_o_ebs_pa')->where('edad', $edad)
                    ->whereRaw("TIME_TO_SEC(tiempo) <= TIME_TO_SEC('$valor')")
                    ->orderByRaw("TIME_TO_SEC(tiempo) DESC")->limit(1)->value($sexoColumn);
            }
        } else { // Servicios y Auxiliares
            if ($evento == 'pechadas') {
                $val = min($valor, 50);
                $puntaje = DB::table('tbl_fb_o_ebs_pa')->where('edad', $edad)->where('repeticiones', $val)->value($sexoColumn);
            } elseif ($evento == 'abdominales') {
                $val = min($valor, 57);
                $puntaje = DB::table('tbl_abdo_o_ebs_pa')->where('edad', $edad)->where('repeticiones', $val)->value($sexoColumn);
            } elseif ($evento == 'carrera') {
                $val = $valor;
                if ($val > "36:10") $val = "36:10";
                $puntaje = DB::table('tbl_carr_o_ebs_pa')->where('edad', $edad)
                    ->whereRaw("TIME_TO_SEC(tiempo) <= TIME_TO_SEC('$val')")
                    ->orderByRaw("TIME_TO_SEC(tiempo) DESC")->limit(1)->value($sexoColumn);
            }
        }

        return $puntaje ?? 0;
    }
}
