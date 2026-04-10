<?php
// 2-5-23 creación de Controlador para bitacora de usuario
namespace App\Http\Controllers;

use App\Models\BitaUsuario;
use Illuminate\Http\Request;

class BitaUsuarioController extends Controller
{
    /**
     *LISTA DE REGISTROS BITACORA ****************************************************************
     */
    public function index()
    {
        $bita_usuario = BitaUsuario::orderBy('fecha', 'desc')->get();
        return view('bitacora/bita_usuario')->with('bita_usuario',$bita_usuario);
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
    public function show(bita_usuario $bita_usuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(bita_usuario $bita_usuario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, bita_usuario $bita_usuario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(bita_usuario $bita_usuario)
    {
        {
            $bita_usuario->delete();
            return redirect()->route('bitacorausuario');
        }
    }
}
