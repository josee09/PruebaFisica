<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLugarAsignacionRequest;
use App\Http\Requests\StoreLugarEvaluacionRequest;
use App\Http\Requests\UpdateLugarAsignacionRequest;
use App\Http\Requests\UpdateLugarEvaluacionRequest;
use App\Models\LugarAsignacion;
use App\Models\LugarEvaluacion;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class LugarAsignacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('lugares-evaluacion.index'), Response::HTTP_FORBIDDEN);
        $lugaresEvaluacion = LugarEvaluacion::all();
        return view('lugar_evaluacion.listar')->with('lugares', $lugaresEvaluacion);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('lugares-evaluacion.create'), Response::HTTP_FORBIDDEN);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLugarEvaluacionRequest $request)
    {
        abort_if(Gate::denies('lugares-evaluacion.update'), Response::HTTP_FORBIDDEN);

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
    public function edit(LugarEvaluacion $lugarEvaluacion)
    {
        abort_if(Gate::denies('lugares-evaluacion.edit'), Response::HTTP_FORBIDDEN);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLugarEvaluacionRequest $request, LugarEvaluacion $lugarEvaluacion)
    {
        abort_if(Gate::denies('lugares-evaluacion.update'), Response::HTTP_FORBIDDEN);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LugarEvaluacion $lugarEvaluacion)
    {
        abort_if(Gate::denies('lugares-evaluacion.destroy'), Response::HTTP_FORBIDDEN);

    }

    /**
     * Asigna the specified resource from storage.
     */
    public function asignarTipoPrueba(LugarEvaluacion $lugarEvaluacion)
    {
        abort_if(Gate::denies('lugares-evaluacion.asignar'), Response::HTTP_FORBIDDEN);

    }
}
