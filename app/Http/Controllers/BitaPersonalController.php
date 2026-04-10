<?php
// 2-5-23 creación de Controlador para bitacora de personal
namespace App\Http\Controllers;

use App\Models\BitaPersonal;
use Illuminate\Http\Request;

class BitaPersonalController extends Controller
{
    /**
     *LISTA DE REGISTROS BITACORA ****************************************************************
     */
    public function index()
    {
        $bita_personal = BitaPersonal::all();
        return view('bitacora/bita_personal')->with('bita_personal',$bita_personal);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(bita_personal $bita_personal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(bita_personal $bita_personal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, bita_personal $bita_personal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(bita_personal $bita_personal)
    {
        //
    }
}
