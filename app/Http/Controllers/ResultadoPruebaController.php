<?php
// 18-5-23 creación de Controlador para evaluacion fisica
namespace App\Http\Controllers;

use App\Models\GradosSIG;
use App\Models\Medico;
use App\Models\OrgSIG;
use App\Models\ResultadoPrueba;
use App\Models\Evaluado;

//Modelo Evaluado
use App\Models\EventosAlterno;

//Modelo eventos alternos
use App\Models\EventosPrincipal;

//Modelo eventos alternos
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

//método convierte la *cadena dada a mayúsculas (SIN OMITIR ACENTOS NI Ñ)
use Illuminate\Support\Facades\DB;

//clase DB
use Barryvdh\DomPDF\Facade\Pdf;

//PDF
use Dompdf\Dompdf;

//PDF
use Carbon\Carbon;

///método para dar fromato a fechas
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ResultadoPruebaController extends Controller
{

    /** LISTA DE REGISTROS *****************************************************************/
    public function index(Request $request)
    {
        abort_if(Gate::denies('prueba.fisica'), Response::HTTP_FORBIDDEN);
        $user = Auth::user();

        $filtroTmp = $request->only(['asignado', 'grado', 'tipo', 'anyo']);
        $filtroRes = [];
        $filtroEva = [];

// Mapeo de claves de $filtroTmp a $filtroRes y $filtroEva
        $mapaRes = [
            'anyo' => 'fecha',
            'tipo' => 'evaluacion'
        ];

        $mapaEva = [
            'asignado' => 'lugarasig'
        ];

        foreach ($mapaRes as $claveTmp => $claveRes) {
            if (isset($filtroTmp[$claveTmp])) {
                $filtroRes[$claveRes] = $filtroTmp[$claveTmp];
            }
        }

        foreach ($mapaEva as $claveTmp => $claveEva) {
            if (isset($filtroTmp[$claveTmp])) {
                $filtroEva[$claveEva] = $filtroTmp[$claveTmp];
            }
        }

        if (isset($filtroTmp['grado'])) {
            $gradoSig = GradosSIG::where('CLAVE_SIG',$filtroTmp['grado'])->first();
            if (isset($gradoSig)) {
                $filtroEva['grado'] = $gradoSig['GRADO'];
                $filtroEva['categoria'] = $gradoSig['CATEGORIA'];
            }
        }

        if ($user->can('prueba.fisica.depto_operaciones')) {
            $resultado = ResultadoPrueba::with('evaluado')
                ->where($filtroRes)
                ->whereHas('evaluado', function ($query) use ($filtroEva, $user) {
                    return $query->where('lugarasig', '=', $user->udep)
                        ->where($filtroEva);
                })->get();
        } else {
            $resultado = ResultadoPrueba::with('evaluado')
                ->where($filtroRes)
                ->whereHas('evaluado', function ($query) use ($filtroEva) {
                    return $query->where($filtroEva);
                })->get();
        }

        //->orderByDesc('')
        $grados = GradosSIG::where('categoria','<>','Auxiliar')->pluck('DESCRIPCION','CLAVE_SIG');
        $lugarAsig = OrgSIG::pluck('DENOMINACION','CLAVE_SIG');

        return view('resultado_prueba/ListaEvaluaciones',
            ['resultado' => $resultado, 'grados' => $grados, 'lugarAsig' => $lugarAsig]);
    }

    /** CREAR NUEVO REGISTRO ***************************************************************/

    public function create()
    {
        $evaluado = Evaluado::distinct('dni')->get();
        $categoria = DB::table('tbl_categoria')->first();
        return view('resultado_prueba/CrearEvaluacion', ['evaluado' => $evaluado, 'categoria' => $categoria]);
    }

    /** GUARDAR NUEVO REGISTRO *************************************************************/
    public function store(Request $request)
    {


        //verif;icar si existe un documento pdf obs

        $evaluado = Evaluado::all()->where('dni', $request->dni)->first();
        if ($request->hasFile('doc_obs')) {
            $archivo = $request->file('doc_obs');
            $nombreArchivo = 'PRESCRIPCION-MEDICA-' . Str::upper(Str::slug($request['evaluacion'])) . '-' . Str::slug($request->dni) . '-' . Str::slug($request['fecha']) . '.' . $archivo->getClientOriginalExtension();
            $archivo->storeAs('Obs_Fisicas', $nombreArchivo, 'public');
        } else {
            $nombreArchivo = null;
        }
        $id = $evaluado->id;
        // dd($request);

        ResultadoPrueba::create([

            'id_evaluado' => $id,
            'evaluacion' => $request['evaluacion'],
            'fecha' => $request['fecha'],
            'periodo' => $request['periodo'],
            'npechada' => $request['npechada'],
            'nabdominal' => $request['nabdominal'],
            'ncarrera' => $request['ncarrera'],
            'nnatacion' => $request['nnatacion'],
            'ncaminata' => $request['ncaminata'],
            'nciclismo' => $request['nciclismo'],
            'nbarra' => $request['nbarra'],
            'npromedio' => $request['npromedio'],
            'pesoexc' => $request['pesoexc'],
            'npesoexc' => $request['npesoexc'],
            'grado1' => Str::upper($request['grado1']),
            'grado2' => Str::upper($request['grado2']),
            'grado3' => Str::upper($request['grado3']),
            'grado4' => Str::upper($request['grado4']),
            'grado5' => Str::upper($request['grado5']),
            'estado' => $request['estado'],
            'obs' => $request['obs'],
            'oficialjefe' => Str::upper($request['oficialjefe']),
            'evaluador1' => Str::upper($request['evaluador1']),
            'evaluador2' => Str::upper($request['evaluador2']),
            'evaluador3' => Str::upper($request['evaluador3']),
            'doc_obs' => $nombreArchivo,
            'evaluador4' => Str::upper($request['evaluador4']),
            'id_principal' => $request['id_principal'],
            'id_alterno' => $request['id_alterno'],
            'user_id' => auth()->user()->id,
            'dniOficial' => $request['dniOficial'],
        ]);
        session()->flash('mensaje', 'Evaluación creado con éxito!');
        return redirect()->route('registro.registro');
    }

    /** Display the specified resource.*/
    public function show(ResultadoPrueba $resultadoPrueba)
    {
    }

    /** Show the form for editing the specified resource.*/
    public function edit(ResultadoPrueba $resultadoPrueba)
    {
    }


    /** *ACTUALIZAR REGISTRO **************************************************************/
    public function update(Request $request)
    {
        $resultado = ResultadoPrueba::findOrFail($request->id_resultado);


        // Guardar el archivo
        if ($request->hasFile('doc_firma')) {
            $archivo = $request->file('doc_firma');
            $nombreArchivo = Str::upper(Str::slug($request->doc_nombre)) . '.' . $archivo->getClientOriginalExtension();
            $archivo->storeAs('Firmas_Fisicas', $nombreArchivo, 'public');

            // Actualizar los campos en el modelo
            $resultado->fill([
                'doc_firma' => $nombreArchivo,
            ]);
            $resultado->update();
        }
        session()->flash('mensaje', '¡Registro actualizado con éxito!'); //sesion flash de alerta
        return redirect()->route('fisica.index');
    }

    /** ELIMINAR REGISTRO *****************************************************************/
    public function destroy(ResultadoPrueba $resultado)
    {
        $resultado->delete();
        session()->flash('mensaje', '¡Registro eliminado con éxito!');
        return redirect()->route('fisica.index');
    }

    //GENERAR PDF**************************************************************************/
    public function pdf($resultado)
    {
        $resultado = ResultadoPrueba::find($resultado);
        $id_evaluado = $resultado->id_evaluado;
        $id_principal = $resultado->id_principal;
        $id_alterno = $resultado->id_alterno;
        $evaluado = Evaluado::find($id_evaluado);
        $principal = EventosPrincipal::find($id_principal);
        $alterno = EventosAlterno::find($id_alterno);
        $date = Carbon::now();

        $nombre = 'EVALUACIÓN-' . $resultado->evaluacion . '-' . $evaluado->dni . '-' . $resultado->fecha . '.pdf';
        $data = [
            'evaluado' => $evaluado,
            'principal' => $principal,
            'alterno' => $alterno,
            'resultado' => $resultado,
            'date' => $date
        ];

        $pdf = PDF::loadView('resultado_prueba.pdf', $data);
        $pdf->setPaper('legal', 'portrait');
        return $pdf->stream($nombre);


    }

}
