<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            //mostrar registros de los roles
            $roles = Role::all();
            // retorna a la vista de roles 
            return view('rolesypermisos/roles')->with('role', $roles);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //llamado para la creacion de los permisos para el nuevo rol
        $permissions = Permission::all();
        //retorno para el llamado de creacion de nuevos roles
        return view('rolesypermisos/nuevoRol', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $existingROL = Role::where('name', $request->Nombre_rol)->first(); //trae los nombres de los ROLES sin importar quien los registro
        if ($existingROL) { //condion para no repetir el NOMBRE DEL ROL (sin importar el usuario que lo halla registrado)
        return back()
        ->withErrors(['ROL' => 'Ya existe un ROL con este NOMBRE'])
        ->withInput();
        }

        $role = Role::create($request->all());
        $role->permissions()->attach($request->permissions);
        // $role->permissions()->sync($request->permissions);
            
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        session()->flash('mensaje', '¡ROL creado con éxito!'); //sesion flash de alerta
        return redirect()->route('Roles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show( role $Role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(role $Role , Permission $permissions)
    {
        $permissions = Permission::all();
        return view('rolesypermisos/editarRol', compact('Role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, role $role)
    {
        // validacion nombre de Rol no se repita
        $existingROL = Role::where('name', $request->Nombre_rol)->first(); //trae los nombres de los ROLES sin importar quien los registro
        if ($existingROL) { //condion para no repetir el NOMBRE DEL ROL (sin importar el usuario que lo halla registrado)
        return back()
        ->withErrors(['ROL' => 'Ya existe un ROL con este NOMBRE'])
        ->withInput();
        }
        
        // actualizacion de los roles 
        $role->update($request->all());
        $role->permissions()->sync($request->permissions);
        
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        // redireccion a la pagina de listao de ROles
        session()->flash('mensaje', '¡ROl modificado con éxito!'); //sesion flash de alerta
        return redirect()->route('Roles.index');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(role $role)
    {
        $role->delete();
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        session()->flash('mensaje', '¡ROl a sido eliminado con exito!'); //sesion flash de alerta
        return redirect()->route('Roles.index');
    }
}
