<?php
// 18-5-23 creación de Controlador para eventos alternos de prueba fisica
namespace App\Http\Controllers;

use App\Models\Evaluado;

//Modelo Evaluado
use App\Models\EventosAlterno;

//Modelo eventos alternos
use App\Models\EventosPrincipal;

//Modelo eventos alternos
use App\Models\ResultadoPrueba;

//Modelo resultado prueba
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

//clase DB
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

///método para dar fromato a fechas
use Illuminate\Support\Str;

//método convierte la cadena dada a mayúsculas (SIN OMITIR ACENTOS NI Ñ)

class EventosAlternoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /** LISTA DE REGISTROS *************************************************************************/
    public function index()
    {
        $user = Auth::user();

        $evaluado = Evaluado::distinct('dni')->get();
        $principal = EventosPrincipal::distinct('id')->get();
        $alterno = EventosAlterno::distinct('id')->get();
        $natacion = DB::table('tbl_natacion')->where('edad', "17")->get();
        $caminata = DB::table('tbl_caminata')->where('edad', "17")->get();
        $ciclismo = DB::table('tbl_ciclismo')->where('edad', "17")->get();
        $barra = DB::table('tbl_barras')->where('edad', "17")->get();

        if ($user->can('prueba.fisica.depto_operaciones')) {
            $alterno = EventosAlterno::distinct('id')->whereHas('evaluado', function ($query) use ($user) {
                return $query->where('lugarasig', '=', $user->udep);
            })->distinct('id')->orderByDesc('created_at')->get();
        } else {
            $alterno = EventosAlterno::distinct('id')->get();
        }

        return view('alternos/Alterno', ['evaluado' => $evaluado,
            'principal' => $principal,
            'alterno' => $alterno,
            'natacion' => $natacion,
            'caminata' => $caminata,
            'ciclismo' => $ciclismo,
            'barra' => $barra]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /** GUARDAR NUEVO REGISTRO **********************************************************************/
    public function store(Request $request)
    {
        // evaluar ---------------------------------------------------------------------------------
        // que no exista un evento alterno para ese evento principal
        $alterno = EventosAlterno::where('id_principal', $request['id_principal'])->first();
        if ($alterno) {
            session()->flash('error', 'No puede registrar un nuevo evento alterno porque ya existe un evento alterno para esta evaluación.'); //sesion flash de alerta
            return redirect()->route('registro.registro');
        }

        //que no existan 3 eventos principales registrados
        $principal = EventosPrincipal::find($request['id_principal']);
        $id_evaluado = $principal->id_evaluado;
        $pechada = $principal->pechada;
        $abdominal = $principal->abdominal;
        $carrera = $principal->carrera;

        $emptyCount = 0;
        if ($pechada) {
            $emptyCount++;
        }
        if ($abdominal) {
            $emptyCount++;
        }
        if ($carrera) {
            $emptyCount++;
        }

        if ($emptyCount === 3) {
            session()->flash('error', 'No puede registrar un nuevo evento alterno porque ya existen tres eventos principales para evaluar.');
            return redirect()->route('registro.registro');
        }

        //que no almacene mas de 1 evento alterno
        $emptyCount = 0;
        if ($request->input('natacion')) {
            $emptyCount++;
        }
        if ($request->input('caminata')) {
            $emptyCount++;
        }
        if ($request->input('ciclismo')) {
            $emptyCount++;
        }
        if ($request->input('barra')) {
            $emptyCount++;
        }

        if ($emptyCount != 1) {
            session()->flash('error', 'Por favor, complete solo uno de los campos.');
            return redirect()->route('registro.registro');
        }

        $isIcb = $request->input('isIcb');
        if (isset($isIcb) and $isIcb == 'on') {
            $isIcb = true;
        } else {
            $isIcb = false;
        }
        //guardar
        EventosAlterno::create([
            'natacion' => $request->input('natacion'),
            'caminata' => $request->input('caminata'),
            'ciclismo' => $request->input('ciclismo'),
            'barra' => $request->input('barra'),
            'id_principal' => $request->input('id_principal'),
            'id_evaluado' => $id_evaluado,
            'user_id' => auth()->user()->id,
            'is_icb' => $isIcb
        ]);

        session()->flash('mensaje', '¡Evento alterno agregado con éxito!');
        return redirect()->route('registro.registro');

    }

    /**
     * Display the specified resource.
     */
    public function show(EventosAlterno $eventosAlterno)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EventosAlterno $eventosAlterno)
    {
        //
    }

    /** ACTUALIZAR REGISTRO ************************************************************************/
    public function update(EventosAlterno $alterno, Request $request)
    {
        //validafr que llene campo  requerido
        $emptyCount = 0;
        if ($request->input('natacion')) {
            $emptyCount++;
        }
        if ($request->input('caminata')) {
            $emptyCount++;
        }
        if ($request->input('ciclismo')) {
            $emptyCount++;
        }
        if ($request->input('barra')) {
            $emptyCount++;
        }
        if ($emptyCount != 1) {
            session()->flash('error', 'Por favor, complete solo uno de los campos.');
            return back();
        }

        $isIcb = $request->input('isIcb');
        if (isset($isIcb) and $isIcb == 'on') {
            $isIcb = true;
        } else {
            $isIcb = false;
        }

        //actualziar
        $alterno->fill([
            'natacion' => $request->input('natacion'),
            'caminata' => $request->input('caminata'),
            'ciclismo' => $request->input('ciclismo'),
            'barra' => $request->input('barra'),
            'is_icb' => $isIcb
        ]);

        $alterno->update();
        session()->flash('mensaje', '¡Registro actualizado con éxito!');
        return back();
    }

    /** ELIMINAR REGISTRO 12-6-23*******************************************************************/
    public function destroy($id)
    {
        //buscar alterno con id_principal
        $alterno = EventosAlterno::where('id_principal', $id)->first();
        $alterno->delete();
        session()->flash('mensaje', '¡Registro eliminado con éxito!');
        return back();
    }

}
