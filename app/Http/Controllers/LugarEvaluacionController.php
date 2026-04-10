<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLugarEvaluacionRequest;
use App\Http\Requests\UpdateLugarEvaluacionRequest;
use App\Models\LugarEvaluacion;
use Illuminate\Support\Facades\Gate;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

/**
 *  Clase encargada de la creacion y modificacion de los lugares de evaluacion de la prueba fisica y
 *  de la evaluacion medica.
 */
class LugarEvaluacionController extends Controller
{
    /**
     * Muestra la vista con el listado de los lugares de evalucion y su estado.
     */
    public function index()
    {
        abort_if(Gate::denies('lugares-evaluacion.index'), Response::HTTP_FORBIDDEN);
        $lugaresEvaluacion = LugarEvaluacion::all();
        return view('lugar_evaluacion.listar')->with('lugares', $lugaresEvaluacion);
    }

    /**
     * Muestra la vista con la cual se crea los lugares de asignacion
     */
    public function create()
    {
        abort_if(Gate::denies('lugares-evaluacion.create'), Response::HTTP_FORBIDDEN);
        return view('lugar_evaluacion.nuevo')->with('lugares', 'nada');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLugarEvaluacionRequest $request)
    {
        abort_if(Gate::denies('lugares-evaluacion.store'), Response::HTTP_FORBIDDEN);

        $validator = Validator::make($request->all(),
            [
                'descripcion' => 'required|string',
                'chkFisica' => 'boolean',
                'chkMedica' => 'boolean',
                'rbEstado' => 'required|boolean',
            ],
            [
                'descripcion.required' => 'El nombre es obligatorio',
                'descripcion.string' => 'El nombre solo puede ser texto',
                'chkFisica.boolean' => 'El tipo de prueba solo puede ser true o false',
                'chkMedica.boolean' => 'El tipo de prueba solo puede ser true o false',
                'rbEstado.required' => 'El estado del lugar es obligatorio',
                'rbEstado.boolean' => 'El estado del lugar solo puede ser true o false',
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
            return redirect()->route('lugares-evaluacion.create')
                ->withErrors($msg)
                ->withInput($request->all());
        }
        $lugar = $request->only('descripcion', 'chkFisica', 'chkMedica', 'rbEstado',);

        LugarEvaluacion::create(
            ['descripcion' => $lugar['descripcion'],
                'fisica' => (boolean)($lugar['chkFisica'] ?? false),
                'medica' => (boolean)($lugar['chkMedica'] ?? false),
                'activo' => (boolean)$lugar['rbEstado'],
            ]);
        return redirect()->route('lugares-evaluacion.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(LugarEvaluacion $lugarEvaluacion)
    {
        abort_if(Gate::denies('lugares-evaluacion.show'), Response::HTTP_FORBIDDEN);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LugarEvaluacion $lugar)
    {
        abort_if(Gate::denies('lugares-evaluacion.edit'), Response::HTTP_FORBIDDEN);
        return view('lugar_evaluacion.editar', compact('lugar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLugarEvaluacionRequest $request, LugarEvaluacion $lugar)
    {
        abort_if(Gate::denies('lugares-evaluacion.update'), Response::HTTP_FORBIDDEN);
        $lugar->update([
            'descripcion' => $request['descripcion'],
            'fisica' => (boolean)($request['chkFisica'] ?? false),
            'medica' => (boolean)($request['chkMedica'] ?? false),
            'activo' => (boolean)$request['rbEstado'],
        ]);
        return redirect()->route('lugares-evaluacion.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LugarEvaluacion $lugar)
    {
        abort_if(Gate::denies('lugares-evaluacion.destroy'), Response::HTTP_FORBIDDEN);
        $lugar->update([
            'activo' => false,
        ]);
        return redirect()->route('lugares-evaluacion.index');
    }

    /**
     * Asigna the specified resource from storage.
     */
    public function asignarTipoPrueba(LugarEvaluacion $lugarEvaluacion)
    {
        abort_if(Gate::denies('lugares-evaluacion.asignar'), Response::HTTP_FORBIDDEN);

    }
}
