<?php
// 17-4-23 creación de Controlador para evaluaciones médicas

namespace App\Http\Controllers;

use App\Models\LugarEvaluacion;
use Illuminate\Http\Request;
use App\Models\Medico;
use App\Models\Evaluado;
use App\Models\EventosPrincipal;
use App\Models\EventosAlterno;
use App\Models\ResultadoPrueba;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class MedicoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /** LISTA DE REGISTROS *****************************************************************/
    public function index(Request $request)
    {
        abort_if(Gate::denies('medica.index'), Response::HTTP_FORBIDDEN);
        $user = Auth::user();

        if ($user->can('medica.depto_operaciones')) {
            $medico = Medico::whereHas('evaluado', function ($query) use ($user) {
                return $query->where('lugarasig', '=', $user->udep);
            })->get();
        } else {
            $medico = Medico::with('evaluado')->get();
        }

        return view('medico/ListaEvaluados')->with('medicos', $medico);
    }

    /** CREAR NUEVO REGISTRO ***************************************************************/
    public function create(Request $request)
    {
        $lugarEvaluacion = LugarEvaluacion::where('medica', '=', true)
            ->where('activo', '=', 1)->get();

        $evaluado = Evaluado::all();

        return view('medico/NuevaMedica', compact('lugarEvaluacion'))->with('evaluado', $evaluado);
    }

    /** GUARDAR NUEVO REGISTRO *************************************************************/
    public function store(Request $request)
    {
        $evaluado = Evaluado::where('dni', $request->dni)->first();

        if (!$evaluado) {
            session()->flash('error', '¡DNI no encontrado!');
            return redirect()->route('medica.create')
                ->withErrors(['dni' => 'Por favor verifique los datos.'])
                ->withInput($request->except('_token'));
        }

        // Validar si ya existe un registro médico para este evaluado en la misma fecha
        $existingMedico = Medico::where('id_evaluado', $evaluado->id)
            ->whereDate('created_at', Carbon::now()->toDateString())
            ->first();

        if ($existingMedico) {
            session()->flash('error', '¡Ya existe un registro médico para este evaluado en la misma fecha!');
            return redirect()->route('medica.create')
                ->withErrors(['dni' => 'Ya existe un registro médico para este evaluado en la misma fecha.'])
                ->withInput($request->except('_token'));
        }

        $excesoCalculo = $request->Exceso;

        if (isset($request->sa) && isset($request->smm) && isset($request->srmg)) {
            if (is_numeric($request->sa) && is_numeric($request->smm) && is_numeric($request->srmg)) {
                $excesoCalculo = $request->srmg;
            }
        }

        $medico = new Medico([
            'periodo' => Str::upper($request->Periodo),
            'pulso' => $request->pulso,
            'saturacion' => $request->saturacion,
            'presion' => $request->Presion,
            'presion2' => $request->Presion2,
            'presion3' => $request->Presion3,
            'altura' => $request->Altura,
            'abdomen' => $request->Abdomen,
            'cuello' => $request->Cuello,
            'mediabocue' => $request->Mediabocue,
            'factoabdocue' => $request->Mediabocue,
            'factoaltu' => $request->Factoaltu,
            'grasa' => $request->Grasa,
            'musculo' => $request->musculo,
            'pesoreal' => $request->Pesoreal,
            'pesoideal' => $request->Pesoideal,
            'exceso' => $excesoCalculo,
            'condicion' => $request->condicion,
            'medico' => Str::upper($request->Medico),
            'grado_policial' => $request->grado,
            'observaciones' => Str::upper($request->observaciones),
            'lugar' => Str::upper($request->lugar),
            'equipo' => $request->equipo,
            'id_evaluado' => $evaluado->id,
            'user_id' => auth()->user()->id,
            'lugar_id' => $request->lugar,
            'sa' => $request->sa,
            'smm' => $request->smm,
            'srmg' => $request->srmg
        ]);

        $medico->save();

        session()->flash('mensaje', '¡Registro Médico creado con éxito!');
        return redirect()->route('medica.index');
    }

    /** VISUALIZAR EVALUACION MEDICA ******************************************************/
    public function show(Request $request, ?Medico $medico = null)
    {
        $resultado = Evaluado::where('dni', $request->dni)->first();

        if (!$resultado) {
            session()->flash('error', '¡DNI no encontrada!');
            return redirect()->route('medica.create')
                ->withErrors(['dni' => 'Por favor verifique los datos.'])
                ->withInput($request->except('_token'));
        }

        // ✅ VALIDAR ALTURA (aquí era donde se te borraba el nombre)
        if ($request->input('Altura') < 141 || $request->input('Altura') > 203) {
            return redirect()->back()
                ->withErrors(['Altura' => 'Altura min:141 max:203, por favor verifique los datos.'])
                ->withInput($request->except('_token'));
        }

        $cuello = (float) $request->input('Cuello');
        $abdomen = (float) $request->input('Abdomen');
        $altura = (float) $request->input('Altura');
        $peso = (float) $request->input('Peso');

        $edad = \Carbon\Carbon::parse($resultado->fechanac)->age;
        $alturaM = $altura / 100;

        $mecabdocue = round(($abdomen - $cuello) / 2.54, 2);
        $mecabdocue2 = ($abdomen - $cuello);

        $parte_entera_mecabdocue = intval($mecabdocue2);
        $parte_decimal_mecabdocuello = $mecabdocue2 - $parte_entera_mecabdocue;

        if ($parte_decimal_mecabdocuello <= 0.24) {
            $parte_decimal_mecabdocuello = 0;
        } elseif ($parte_decimal_mecabdocuello <= 0.49) {
            $parte_decimal_mecabdocuello = 0.25;
        } elseif ($parte_decimal_mecabdocuello <= 0.74) {
            $parte_decimal_mecabdocuello = 0.50;
        } elseif ($parte_decimal_mecabdocuello <= 0.99) {
            $parte_decimal_mecabdocuello = 0.75;
        }

        $factoabdocue = DB::table('tbl_factor_abdomencuello')
            ->where('pulgada', $parte_entera_mecabdocue)
            ->where('residuo', $parte_decimal_mecabdocuello)
            ->value('resultado');

        if ($factoabdocue === null) {
            session()->flash('error', '¡Error al calcular factor abdomen-cuello!');
            return redirect()->back()
                ->withErrors(['Cuello' => 'Por favor verifique los datos.', 'Abdomen' => 'Por favor verifique los datos.'])
                ->withInput($request->except('_token'));
        }

        $alturraft = round(($altura / 2.54), 2);
        $parte_entera_altura = intval($alturraft);
        $parte_decimal_altura = round($alturraft - $parte_entera_altura, 2);

        if ($parte_decimal_altura <= 0.24) {
            $parte_decimal_altura = 0;
        } elseif ($parte_decimal_altura <= 0.49) {
            $parte_decimal_altura = 0.25;
        } elseif ($parte_decimal_altura <= 0.74) {
            $parte_decimal_altura = 0.50;
        } elseif ($parte_decimal_altura <= 0.99) {
            $parte_decimal_altura = 0.75;
        }

        $factoraltura = DB::table('tbl_factor_altura')
            ->where('pulgada', $parte_entera_altura)
            ->where('residuo', $parte_decimal_altura)
            ->value('resultado');

        if ($factoraltura === null) {
            session()->flash('error', '¡Error al calcular factor altura!');
            return redirect()->back()
                ->withErrors(['Altura' => 'Por favor verifique los datos.'])
                ->withInput($request->except('_token'));
        }

        $sexo = $resultado->sexo;

        $tabla = ($sexo === 'M') ? 'tbl_peso_ideal_m' : 'tbl_peso_ideal_f';
        if ($edad >= 17 && $edad <= 20) {
            $edadCondicion = 20;
        } elseif ($edad >= 21 && $edad <= 27) {
            $edadCondicion = 27;
        } elseif ($edad >= 28 && $edad <= 39) {
            $edadCondicion = 39;
        } else {
            $edadCondicion = 40;
        }

        $pesoideal = DB::table($tabla)
            ->where('edad', $edadCondicion)
            ->where('altura', $alturaM)
            ->value('peso_ideal');

        if ($pesoideal === null) {
            session()->flash('error', '¡Error al calcular peso ideal!');
            return redirect()->back()
                ->withErrors(['Peso' => 'Por favor verifique los datos.'])
                ->withInput($request->except('_token'));
        }

        $exceso = (float) $peso - (float) $pesoideal;
        $porcuello = (float) $factoraltura - (float) $factoabdocue;

        return view('medico/VisualizarMedica', [
            'request' => $request,
            'mecabdocue' => $mecabdocue,
            'pesoideal' => $pesoideal,
            'exceso' => $exceso,
            'alturaM' => $alturaM,
            'factoraltura' => $factoraltura,
            'factoabdocue' => $factoabdocue,
            'porcuello' => $porcuello,
            'resultado' => $resultado,
            'medico' => $medico,
        ]);
    }

    /** EDITAR REGISTRO********************************************************************/
    public function edit(Medico $medico)
    {
        return view('medico/EditarMedica', compact('medico'));
    }

    /** ACTUALIZAR REGISTRO **************************************************************/
    public function update(Request $request, Medico $medico)
    {
        $dni = Evaluado::where('dni', $request->dni)->first();
        $id = $dni ? $dni->id : null;

        $excesoCalculo = $request->Exceso;

        if (isset($request->sa) && isset($request->smm) && isset($request->srmg)) {
            if (is_numeric($request->sa) && is_numeric($request->smm) && is_numeric($request->srmg)) {
                $excesoCalculo = $request->srmg;
            }
        }

        $medico->update([
            'periodo' => $request->Periodo,
            'pulso' => $request->pulso,
            'saturacion' => $request->saturacion,
            'presion' => $request->Presion,
            'presion2' => $request->Presion2,
            'presion3' => $request->Presion3,
            'altura' => $request->Altura,
            'abdomen' => $request->Abdomen,
            'cuello' => $request->Cuello,
            'mediabocue' => $request->Mediabocue,
            'factoabdocue' => $request->Mediabocue,
            'factoaltu' => $request->Factoaltu,
            'grasa' => $request->Grasa,
            'musculo' => $request->musculo,
            'pesoreal' => $request->Pesoreal,
            'pesoideal' => $request->Pesoideal,
            'exceso' => $excesoCalculo,
            'condicion' => $request->condicion,
            'medico' => Str::upper($request->Medico),
            'grado_policial' => $request->grado,
            'observaciones' => Str::upper($request->observaciones),
            'lugar' => Str::upper($request->lugar),
            'equipo' => $request->equipo,
            'doc_firma' => null,
            'id_evaluado' => $id,
            'sa' => $request->sa,
            'smm' => $request->smm,
            'srmg' => $request->srmg
        ]);

        $medico->save();
        session()->flash('mensaje', '¡Registro actualizado con éxito!');
        return redirect()->route('medica.index');
    }

    /** ACTUALIZAR DOCUMENTO DE FIRMAS ****************************************************/
    public function updateFirma(Request $request)
    {
        $medico = Medico::findOrFail($request->id_medico);

        if ($request->hasFile('doc_firma')) {
            $archivo = $request->file('doc_firma');
            $nombreArchivo = Str::upper(Str::slug($request->doc_nombre)) . '.' . $archivo->getClientOriginalExtension();
            $archivo->storeAs('Firmas_Medicas', $nombreArchivo, 'public');

            $medico->fill([
                'doc_firma' => $nombreArchivo,
            ]);

            $medico->update();
        }

        session()->flash('mensaje', '¡Hoja de control agregada con éxito!');
        return redirect()->route('medica.index');
    }

    /** ELIMINAR REGISTRO *****************************************************************/
    public function destroy(Medico $medico)
    {
        $principal = EventosPrincipal::where('id_medico', $medico->id)->first();

        if ($principal) {
            if (ResultadoPrueba::where('id_principal', $principal->id)->first()) {
                ResultadoPrueba::where('id_principal', $principal->id)->delete();
            }
            if (EventosAlterno::where('id_principal', $principal->id)->first()) {
                EventosAlterno::where('id_principal', $principal->id)->delete();
            }
            if (EventosPrincipal::where('id_medico', $medico->id)->first()) {
                EventosPrincipal::where('id_medico', $medico->id)->delete();
            }
        }

        $medico->delete();
        session()->flash('mensaje', '¡Registro borrado con éxito!');
        return redirect()->route('medica.index');
    }

    /** GENERAR PDF ********************************************************************/
    public function pdf($medico)
    {
        $medico = Medico::find($medico);
        $evaluado = Evaluado::find($medico->id_evaluado);
        $lugarEvalucion = LugarEvaluacion::find($medico->lugar_id);
        $date = Carbon::now();

        $nombre = 'EVALUACIÓN-MEDICA' . '-' . $evaluado->dni . '-' . \Carbon\Carbon::parse($medico->created_at)->format('d-m-Y') . '.pdf';

        $data = [
            'evaluado' => $evaluado,
            'medico' => $medico,
            'date' => $date,
            'lugarEvalucion' => $lugarEvalucion
        ];

        $pdf = Pdf::loadView('medico.pdf', $data);
        $pdf->setPaper('letter', 'landscape');

        return $pdf->stream($nombre);
    }
}
