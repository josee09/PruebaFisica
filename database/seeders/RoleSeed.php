<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        Administrador => acceso a todo este se convierte en el super usuario
        */
        $admin = Role::create(['name' => 'Administrador']);
        $medico = Role::create(['name' => 'Medico']);
        $evaluador = Role::create(['name' => 'Evaluador']);
        $nutricionista = Role::create(['name' => 'Nutricionista']);
        $operaciones = Role::create(['name' => 'Operaciones']);
        // PERMISO PARA LA PAGINA PRINCIPAL
        Permission::create(['name' => 'home', 'description' => 'vista pagina principal'])->assignRole([$admin, $medico, $evaluador,$operaciones]); // vista de entrada

        // PERMIOSSOS PARA PERFILES  PARA REGISTRO DE EVALUADOS
        Permission::create(['name' => 'registros.index', 'description' => 'visualizacion de personal evaluado'])->assignRole([$admin, $medico, $evaluador,$operaciones]); //listado de pesonal para la evaluacion
        Permission::create(['name' => 'registro.create', 'description' => 'creacion de nuevo personal a evaluar'])->assignRole($admin, $medico, $evaluador,$operaciones); //crear nuevos registros de personal a evaluar
        Permission::create(['name' => 'registro.edit', 'description' => 'edicion de informacion de personal registrado'])->assignRole($admin,$operaciones); // pagina de edicion de personal que se
        Permission::create(['name' => 'registro.destroy', 'description' => 'eliminacion de personal registrado'])->assignRole($admin); // eliminacion de personal registrado
        Permission::create(['name' => 'registro.depto_operaciones', 'description' => 'Departamento de operaciones personal registrado'])->assignRole($operaciones); // eliminacion de personal registrado


        //    PERMISOS PARA EL SUPER USUARIO MODELO DE USUARIO
        Permission::create(['name' => 'registrousuario', 'description' => 'visualizacion de usuarios'])->assignRole([$admin]); //listado de usuarios
        Permission::create(['name' => 'NuevoUsuario', 'description' => 'creacion de nuevo usuario'])->assignRole($admin); //crear nuevos usuarios
        Permission::create(['name' => 'Usuario.edit', 'description' => 'edicion de usuario'])->assignRole($admin); // pagina de edicion de usuarios
        Permission::create(['name' => 'Usuario.destroy', 'description' => 'eliminacion de usuario'])->assignRole($admin); // eliminacion de usuarios


        // PERMIOSOS PARA EL SUPER USUARIO MODELO DE EVALUACION MEDICA

        Permission::create(['name' => 'medica.index', 'description' => 'Visualizacion de Listado Pruebas Medicas'])->assignRole([$admin, $medico, $nutricionista,$operaciones]); //listado de usuarios
        Permission::create(['name' => 'medica.create', 'description' => 'Creación de Pruebas Medicas'])->assignRole([$admin, $medico, $nutricionista]); //creacion de pruebas medicas
        Permission::create(['name' => 'medica.edit', 'description' => 'Edicion de Pruebas Medicas'])->assignRole([$admin, $medico, $nutricionista]); //edicion de pruebas medicas
        Permission::create(['name' => 'medica.destroy', 'description' => 'Eliminacion de Pruebas medicas'])->assignRole([$admin, $medico, $nutricionista]); //listado de usuarios
        Permission::create(['name' => 'medica.pdf', 'description' => 'creacion de reportes medicos'])->assignRole([$admin, $medico, $nutricionista,$operaciones]);//creacion de reporteria modulo medica
        Permission::create(['name' => 'medica.depto_operaciones', 'description' => 'Departamento de operaciones personal registrado medica'])->assignRole($operaciones); // eliminacion de personal registrado


        // PERMIOSOS PARA EL SUPER USUARIO MODELO DE BIOIMPEDAANCIA
        Permission::create(['name' => 'bioimpedancia.index', 'description' => 'Visualizacion de Listado Pruebas Medicas'])->assignRole([$admin, $nutricionista]); //listado de usuarios
        Permission::create(['name' => 'bioimpedancia.create', 'description' => 'Creación de Pruebas Medicas'])->assignRole([$admin, $nutricionista]); //creacion de pruebas medicas
        Permission::create(['name' => 'bioimpedancia.edit', 'description' => 'Edicion de Pruebas Medicas'])->assignRole([$admin, $nutricionista]); //edicion de pruebas medicas
        Permission::create(['name' => 'bioimpedancia.destroy', 'description' => 'Eliminacion de Pruebas medicas'])->assignRole([$admin, $nutricionista]); //listado de usuarios
        Permission::create(['name' => 'bioimpedancia.pdf', 'description' => 'creacion de reportes medicos'])->assignRole([$admin, $nutricionista]);//creacion de reporteria modulo medica


        // PERMISOS PARA EL SUPER USUARIO MODELO DE PRUEBA FISICA evento principal
        Permission::create(['name' => 'prueba.fisica', 'description' => 'acceso a pruebas fisicas'])->assignRole($admin, $evaluador,$operaciones);
        Permission::create(['name' => 'principal.create', 'description' => 'creacion de eventos principales prueba fisica'])->assignRole([$admin, $evaluador]); //listado de usuarios
        Permission::create(['name' => 'principal.update', 'description' => 'edicion de eventos principales prueba fisica'])->assignRole([$admin, $evaluador]); //listado de usuarios
        Permission::create(['name' => 'principal.destroy', 'description' => 'eliminacion de prueba fisica'])->assignRole([$admin, $evaluador]); //listado de usuarios
        Permission::create(['name' => 'prueba.fisica.depto_operaciones', 'description' => 'Departamento de operaciones personal registrado prueba fisica'])->assignRole($operaciones); // eliminacion de personal registrado


        // PERMISOS PARA EL SUPER USUARIO MODELO DE PRUEBA FISICA evento alterno
        Permission::create(['name' => 'alterno.index', 'description' => 'visualizacion de eventos alternos de prueba fisica'])->assignRole([$admin, $medico, $nutricionista, $evaluador]); //listado de usuarios
        Permission::create(['name' => 'alterno.create', 'description' => 'creacion de eventos alternos de prueba fisica'])->assignRole([$admin, $medico, $nutricionista, $evaluador]); //listado de usuarios
        Permission::create(['name' => 'alterno.update', 'description' => 'edicion de eventos alternos de prueba fisica'])->assignRole([$admin, $medico, $nutricionista, $evaluador]); //listado de usuarios
        Permission::create(['name' => 'alterno.destoy', 'description' => 'eliminacion de eventos alternos de prueba fisica'])->assignRole([$admin, $medico, $nutricionista, $evaluador]); //elimanacion de evento alterno


        //PERMISOS PARA EL SUPER USUARIO MODELO DE BITACORIA
        Permission::create(['name' => 'bitacoras', 'description' => 'visualizacion de bitacoria'])->assignRole([$admin,]);
        Permission::create(['name' => 'bitacora.destroy', 'description' => 'eliminacion de registros de bitacoria'])->assignRole($admin);//eliminacion de registros para bitacora en usuarios
        Permission::create(['name' => 'bitacorapersonal', 'description' => 'listado de registro bitacoria de personal evaluado'])->assignRole($admin);

        //PERMISOS PARA ROLES Y PERMISOS
        Permission::create(['name' => 'Roles.index', 'description' => 'llamado de vista para roles'])->assignRole($admin);
        Permission::create(['name' => 'Roles.create', 'description' => 'creación de nuevos roles'])->assignRole($admin);
        Permission::create(['name' => 'Roles.edit', 'description' => 'edición de roles'])->assignRole($admin);
        Permission::create(['name' => 'Role.destroy', 'description' => 'elimiación de roles'])->assignRole($admin);
        Permission::create(['name' => 'Usuario.roles', 'description' => 'asignación de roles'])->assignRole($admin);

// PERMISOS PARA CREACION DE LUGARES DE EVALUACION
        Permission::create(['name' => 'lugares-evaluacion.index', 'description' => 'acceso a lugares de evaluacion'])->assignRole($admin, $evaluador);
        Permission::create(['name' => 'lugares-evaluacion.create', 'description' => 'mostrar ventana creacion de eventos principales lugares de evaluacion'])->assignRole([$admin, $evaluador]); //listado de usuarios
        Permission::create(['name' => 'lugares-evaluacion.store', 'description' => 'creacion de eventos principales lugares de evaluacion'])->assignRole([$admin, $evaluador]); //listado de usuarios
        Permission::create(['name' => 'lugares-evaluacion.update', 'description' => 'edicion de eventos principales lugares de evaluacion'])->assignRole([$admin, $evaluador]); //listado de usuarios
        Permission::create(['name' => 'lugares-evaluacion.destroy', 'description' => 'eliminacion de lugares de evaluacion'])->assignRole([$admin, $evaluador]); //listado de usuarios
        Permission::create(['name' => 'lugares-evaluacion.edit', 'description' => 'mostrar ventana edicion de eventos principales lugares de evaluacion'])->assignRole([$admin, $evaluador]); //listado de usuarios
        Permission::create(['name' => 'lugares-evaluacion.show', 'description' => 'mostrar datos de lugares de evaluacion'])->assignRole([$admin, $evaluador]); //listado de usuarios
        Permission::create(['name' => 'lugares-evaluacion.asignar', 'description' => 'asignacion de lugares de evaluacion'])->assignRole([$admin, $evaluador]); //listado de usuarios

// PERMISOS PARA CREACION DE TERNAS
        Permission::create(['name' => 'ternas.index', 'description' => 'acceso a ternas de evaluacion'])->assignRole($admin, $evaluador);
        Permission::create(['name' => 'ternas.create', 'description' => 'creacion ternas de evaluacion'])->assignRole([$admin, $evaluador]); //listado de usuarios
        Permission::create(['name' => 'ternas.update', 'description' => 'edicion ternas de evaluacion'])->assignRole([$admin, $evaluador]); //listado de usuarios
        Permission::create(['name' => 'ternas.destroy', 'description' => 'eliminacion de ternas de evaluacion'])->assignRole([$admin, $evaluador]); //listado de usuarios
        Permission::create(['name' => 'ternas.edit', 'description' => 'edicion ternas de evaluacion'])->assignRole([$admin, $evaluador]); //listado de usuarios
        Permission::create(['name' => 'ternas.show', 'description' => 'mostrar datos de ternas de evaluacion'])->assignRole([$admin, $evaluador]); //listado de usuarios
        Permission::create(['name' => 'ternas.asignar', 'description' => 'asignacion de ternas de evaluacion'])->assignRole([$admin, $evaluador]); //listado de usuarios

    }

}
