<?php

namespace App\Http\Controllers;

use App\Models\Evaluado;
use App\Models\LugarEvaluacion;
use App\Models\TernaEvaluadora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class TernaEvaluadoraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('ternas.index'), Response::HTTP_FORBIDDEN);
        $ternaEvaluadora = TernaEvaluadora::with(['evaluador1', 'evaluador2', 'evaluador3', 'evaluador4', 'evaluadorJefe'])->get();
        return view('terna_evaluadora.listar')->with('ternasEvaluadoras', $ternaEvaluadora);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('ternas.create'), Response::HTTP_FORBIDDEN);
        return view('terna_evaluadora.nuevo',
            ['terna' => new TernaEvaluadora(), 'url' => 'terna-evaluadora.store',
                'isNuevo' => true]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('ternas.create'), Response::HTTP_FORBIDDEN);

        $validator = Validator::make($request->all(),
            [
                'idE1' => 'required|string',
                'idE2' => 'required|string',
                'idE3' => 'nullable|string',
                'idE4' => 'nullable|string',
                'idOJEE' => 'required|string',
            ],
            [
                'idE1.required' => 'El dni evaluador 1 es obligatorio',
                'idE1.string' => 'El dni evaluador 1 solo puede ser texto',
                'idE2.required' => 'El dni evaluador 2 es obligatorio',
                'idE2.string' => 'El dni evaluador 2 solo puede ser texto',
                'idE3.required' => 'El dni evaluador 3 es obligatorio',
                'idE3.string' => 'El dni evaluador 3 solo puede ser texto',
                'idE4.required' => 'El dni evaluador 4 es obligatorio',
                'idE4.string' => 'El dni evaluador 4 solo puede ser texto',
                'idOJEE.required' => 'El dni evaluadorOJEE es obligatorio',
                'idOJEE.string' => 'El dni evaluadorOJEE solo puede ser texto',

            ]);

        if ($validator->fails()) {
            $msg = "";

            foreach ($validator->errors()->getMessages() as $clave => $mensajes) {
                // Iterar sobre los mensajes asociados a cada clave
                foreach ($mensajes as $mensaje) {
                    $msg .= $mensaje . "\n";
                }
                $msg .= "\n";
            }

            session()->flash('error', $msg);
            return redirect()->route('terna-evaluadora.create')
                ->withErrors($msg)
                ->withInput($request->all());
        }

        $evaluadores = $request->only('descripcion', 'idE1', 'idE2', 'idE3', 'idE4', 'idOJEE');


        TernaEvaluadora::create(
            ['descripcion' => $evaluadores['descripcion'],
                'E1_id' => $evaluadores['idE1'],
                'E2_id' => $evaluadores['idE2'],
                'E3_id' => $evaluadores['idE3'],
                'E4_id' => $evaluadores['idE4'],
                'OJEE_id' => $evaluadores['idOJEE'],
            ]);
        return redirect()->route('terna-evaluadora.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        abort_if(Gate::denies('ternas.index'), Response::HTTP_FORBIDDEN);
        $terna = TernaEvaluadora::with('evaluadosAsignados')->findOrFail($id);
        $evaluados = Evaluado::all(); // Lista simple
        
        return view('terna_evaluadora.asignar', compact('terna', 'evaluados'));
    }

    public function vincularEvaluados(Request $request, $terna_id)
    {
        $terna = TernaEvaluadora::findOrFail($terna_id);
        $evaluados_ids = $request->input('evaluados', []);
        $periodo = $request->input('periodo');
        $fecha = date('Y-m-d');

        // Formatear datos para la tabla pivot con campos extra
        $syncData = [];
        foreach ($evaluados_ids as $id) {
            $syncData[$id] = [
                'periodo' => $periodo,
                'fecha_asignacion' => $fecha,
                'estado' => 'asignado'
            ];
        }

        // Usamos sync para actualizar la lista completa de la terna en la tabla intermedia
        $terna->evaluadosAsignados()->sync($syncData);

        return redirect()->route('terna-evaluadora.index')
                         ->with('mensaje', 'Se han asignado ' . count($syncData) . ' policías a la terna "' . $terna->descripcion . '" correctamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TernaEvaluadora $terna)
    {
        abort_if(Gate::denies('ternas.edit'), Response::HTTP_FORBIDDEN);
        return view('terna_evaluadora.nuevo', ['terna' => $terna, 'isNuevo' => false]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TernaEvaluadora $terna)
    {
        abort_if(Gate::denies('ternas.update'), Response::HTTP_FORBIDDEN);
        $validator = Validator::make($request->all(),
            [
                'idE1' => 'required|string',
                'idE2' => 'required|string',
                'idE3' => 'nullable|string',
                'idE4' => 'nullable|string',
                'idOJEE' => 'required|string',
            ],
            [
                'idE1.required' => 'El dni evaluador 1 es obligatorio',
                'idE1.string' => 'El dni evaluador 1 solo puede ser texto',
                'idE2.required' => 'El dni evaluador 2 es obligatorio',
                'idE2.string' => 'El dni evaluador 2 solo puede ser texto',
                'idE3.required' => 'El dni evaluador 3 es obligatorio',
                'idE3.string' => 'El dni evaluador 3 solo puede ser texto',
                'idE4.required' => 'El dni evaluador 4 es obligatorio',
                'idE4.string' => 'El dni evaluador 4 solo puede ser texto',
                'idOJEE.required' => 'El dni evaluadorOJEE es obligatorio',
                'idOJEE.string' => 'El dni evaluadorOJEE solo puede ser texto',

            ]);

        if ($validator->fails()) {
            $msg = "";

            foreach ($validator->errors()->getMessages() as $clave => $mensajes) {
                // Iterar sobre los mensajes asociados a cada clave
                foreach ($mensajes as $mensaje) {
                    $msg .= $mensaje . "\n";
                }
                $msg .= "\n";
            }

            session()->flash('error', $msg);
            return redirect()->route('terna-evaluadora.edit')
                ->withErrors($msg)
                ->withInput($request->all());
        }

        $evaluadores = $request->only('descripcion', 'idE1', 'idE2', 'idE3', 'idE4', 'idOJEE');

        $terna->update(
            ['descripcion' => $evaluadores['descripcion'],
                'E1_id' => $evaluadores['idE1'],
                'E2_id' => $evaluadores['idE2'],
                'E3_id' => $evaluadores['idE3'],
                'E4_id' => $evaluadores['idE4'],
                'OJEE_id' => $evaluadores['idOJEE'],
            ]
        );
        return redirect()->route('terna-evaluadora.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $lugar)
    {
        TernaEvaluadora::where('id', $lugar)->delete();
        return redirect()->route('terna-evaluadora.index')->with('success', 'Terna eliminada correctamente');
    }

    public function buscarTerna(Request $request)
    {
        abort_if(Gate::denies('ternas.create'), Response::HTTP_FORBIDDEN);

        $validator = Validator::make($request->all(),
            [
                'id' => 'required|string',
            ],
            [
                'id.required' => 'El dni es obligatorio',
                'id.string' => 'El dni no es valido',
            ]);

        if ($validator->fails()) {
            return Response()->json($validator->errors()->getMessages())->setStatusCode(Response::HTTP_NO_CONTENT);
        }

        $id = $request->only('id');
        return Response()->json(TernaEvaluadora::with(['evaluador1', 'evaluador2', 'evaluador3', 'evaluador4', 'evaluadorJefe'])
            ->where('id', '=', $id)->get());
    }
}
