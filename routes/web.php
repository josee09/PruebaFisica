<?php

use App\Http\Controllers\EvaluadoController;

//evaluado
use App\Http\Controllers\MedicoController;

//medico
use App\Http\Controllers\UserController;

//usuario
use App\Http\Controllers\EventosPrincipalController;

//eventos principales
use App\Http\Controllers\EventosAlternoController;

//eventos principales
use App\Http\Controllers\BitaUsuarioController;

//bitacora usuario
use App\Http\Controllers\BitaPersonalController;

//bitacora personal
use App\Http\Controllers\ResultadoPruebaController;

//Evaluación fisica
use App\Http\Controllers\RolesController;

//Roles de Usuario
use App\Http\Controllers\PermisosController;

//Permisos de Usuario
use App\Models\Medico;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use \App\Http\Controllers\LugarEvaluacionController;
use App\Http\Controllers\ReportesController;
use \App\Http\Controllers\TernaEvaluadoraController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Auth::routes();
Route::get('/', function () {
    return view('auth.login');
}); //dirige login antes que home

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//REGISTRO DE PERSONAL
    Route::get('/registros', [EvaluadoController::class, 'index'])->name('registros.index'); // lista de registros
    Route::get('/registro/create', [EvaluadoController::class, 'create'])->name('registro.create'); // crear registro
    Route::post('/registro/store', [EvaluadoController::class, 'store'])->name('registro.store'); // almacenar registro
    Route::get('/registros/{evaluado}/edit', [EvaluadoController::class, 'edit'])->name('registro.edit'); // editar registro
    Route::put('/registros/{evaluado}', [EvaluadoController::class, 'update'])->name('registro.update'); // actualizar registro
    Route::delete('/registro/{evaluado}', [EvaluadoController::class, 'destroy'])->name('registro.destroy'); // eliminar registro
    Route::post('/evaluado/buscar', [EvaluadoController::class, 'buscarEvaluado'])->name('registro.search'); // busca registro
    Route::post('/registro/createDni', [EvaluadoController::class, 'crearEvaluadoDni'])->name('registro.dniCreate'); // crea registro de evaluado
    Route::post('/registro/buscarSic', [EvaluadoController::class, 'buscarSic'])->name('registro.buscarSic'); // crea registro de evaluado


//EVALUACIÓN MEDICA
    Route::get('/medica/evaluacion/', [MedicoController::class, 'index'])->name('medica.index'); // lista de registros
    Route::get('/medica/create', [MedicoController::class, 'create'])->name('medica.create'); // lista de registros
    Route::match(['get', 'post'], 'medica/show/{medico?}', [MedicoController::class, 'show'])->name('medica.show');// pantalla para ver formulas antes de creacion o actualizacion de evaluacion medica
    Route::post('/medica/store', [MedicoController::class, 'store'])->name('medica.store'); // lista de registros
    Route::get('/medica/edit/{medico}', [MedicoController::class, 'edit'])->name('medica.edit'); // lista de registros
    Route::put('/medica/update/{medico}', [MedicoController::class, 'update'])->name('medica.update'); // lista de registros
    Route::delete('/medica/{medico}/destroy', [MedicoController::class, 'destroy'])->name('medica.destroy'); // lista de registros
// Route::get('/medica/{medico}/view', [MedicoController::class, 'view'])->name('medica.view'); // lista de registros
    Route::get('/medica/pdf/{medico} ', [MedicoController::class, 'pdf'])->name('medica.pdf'); // pdf de registros de medica
    Route::put('/medica/{resultado}', [MedicoController::class, 'updateFirma'])->name('FirmaMedica.update'); // actualizar registro con pdf ----

//EVALUACIÓN PRINCIPALES
    Route::get('/principales', [EventosPrincipalController::class, 'index'])->name('principal.index'); // lista de registros
    Route::get('/principales/evaluacion/fisica', [EventosPrincipalController::class, 'registro'])->name('registro.registro'); // registro y visualiazacion
    Route::get('/principal/create', [EventosPrincipalController::class, 'create'])->name('principal.create'); // crear registro
    Route::post('/principal/store', [EventosPrincipalController::class, 'store'])->name('principal.store'); // crear registro
    Route::post('/principal/store/ajax', [EventosPrincipalController::class, 'storeAjax'])->name('principal.storeAjax'); // crear registro
    Route::put('/principal/{principal}', [EventosPrincipalController::class, 'update'])->name('principal.update'); // actualizar registro
    Route::get('/principal/show/{id}', [EventosPrincipalController::class, 'show'])->name('principal.show'); // evaluación de registro
    Route::delete('/principal/{principal}', [EventosPrincipalController::class, 'destroy'])->name('principal.destroy'); // eliminar registro
    Route::put('/categoria', [EventosPrincipalController::class, 'updateCategoria'])->name('categoria.update'); // actualizar registro
    Route::get('/principal/pdf', [EventosPrincipalController::class, 'pdf'])->name('principal.pdf'); // pdf de registros
    Route::post('/evaluado/medica/buscar', [EventosPrincipalController::class, 'evaluacionesMedicas'])->name('principal.evaluado'); // eliminar registro

//EVALUACIÓN ALTERNOS
    Route::get('/alternos', [EventosAlternoController::class, 'index'])->name('alterno.index'); // lista de registros
    Route::get('/alterno/create/{principal}', [EventosAlternoController::class, 'create'])->name('alterno.create'); // lista de registros
    Route::post('/alterno/store', [EventosAlternoController::class, 'store'])->name('alterno.store'); // crear registro
    Route::put('/alterno/{alterno}', [EventosAlternoController::class, 'update'])->name('alterno.update'); // actualizar registro
    Route::delete('/alterno/{id}', [EventosAlternoController::class, 'destroy'])->name('alterno.destroy'); // eliminar registro

//EVALUACIÓN FISICA
    Route::get('/pueba/fisica', [ResultadoPruebaController::class, 'index'])->name('fisica.index'); // lista de registros
    Route::get('/pueba/fisica/create', [ResultadoPruebaController::class, 'create'])->name('fisica.create'); // lista de registros
    Route::post('/pueba/fisica/store', [ResultadoPruebaController::class, 'store'])->name('fisica.store'); // crear registro
    Route::put('/pueba/fisica/{resultado}', [ResultadoPruebaController::class, 'update'])->name('fisica.update'); // actualizar registro con pdf ----
    Route::delete('/pueba/fisica/{resultado}', [ResultadoPruebaController::class, 'destroy'])->name('fisica.destroy'); // eliminar registro
    Route::get('/pueba/fisica/pdf/{resultado}', [ResultadoPruebaController::class, 'pdf'])->name('fisica.pdf'); // pdf de registros
    Route::get('/pueba/fisica/firmas/{archivo}', function ($archivo) {
        $pathToFile = public_path('firmas/' . $archivo);
        return response()->file($pathToFile);
    })->name('fisica.show');

//REGISTRO DE USUARIOS
    Route::get('/usuario/ListaUsuarios', [UserController::class, 'registrousuario'])->name('registrousuario');//Lista de Usuarios
    Route::get('/usuario/NuevoUsuario', [UserController::class, 'createUsuario'])->name('NuevoUsuario'); //--crear nuevo usuario
    Route::post('/NuevoUsuario/store', [UserController::class, 'store'])->name('Usuario.store');//almancenar nuevo usuario
    Route::get('/usuario/{Usuario}/edit', [UserController::class, 'edit'])->name('Usuario.edit');//editar registro usuario
    Route::put('/usuario/{Usuario}', [UserController::class, 'update'])->name('Usuario.update');//actualizar registro usuario
    Route::delete('/usuario/ListaUsuario{Usuario}', [UserController::class, 'destroy'])->name('Usuario.destroy');//-- elimianr usuario

//VISTAS DE BITACORAS
    //bitacoras de usuario
    Route::get('bitacora/usuario', [BitaUsuarioController::class, 'index'])->name('bitacorausuario'); //listado para la bitacora de usuarios
    Route::delete('/bitacora/usuario/destroy', [BitaUsuarioController::class, 'destroy'])->name('bitacorausuario.destroy');//-- eliminar registro en Bitacora
    //bitacora de registro de personal
    Route::get('bitacora/personal', [BitaPersonalController::class, 'index'])->name('bitacorapersonal'); //listado para la bitacora de registro de personal
// Route::delete('/bitacora/personal{bita_usuario}', [BitaPersonalController::class, 'destroy'])->name('bitacorapersonal.destroy');//-- eliminar registro en Bitacora

//Insercios de datos para evaluados mediante excel
    Route::get('/registro/excel', [EvaluadoController::class, 'registroexcel'])->name('registro.excel');//ruta para la vista de registro excel
    Route::post('Importar/excel', [EvaluadoController::class, 'importExcel'])->name('importar.excel'); //ruta de guardaddo para la vista de registro excel
    Route::get('/descargar-Excel', [EvaluadoController::class, 'descargarExcel'])->name('descargarExcel');//ruta de descarga para el documento de excel

//Ruta para los roles y permisos
    Route::get('Administrador/Roles', [RolesController::class, 'index'])->name('Roles.index');// ruta para el llamado de la vista de roles
    Route::get('/Administrador/Roles/nuevo', [RolesController::class, 'show'])->name('Roles.show'); //Visualizar los permisos de los roles
    Route::get('Administrador/Roles/Permisos', [RolesController::class, 'create'])->name('Roles.create');// llamado para creacion de nuevos roles
    Route::post('/Administrador/Roles/store', [RolesController::class, 'store'])->name('Roles.store');//almancenar nuevo ROL
    Route::get('Administrador/Roles/Permisos/editar/{role}', [RolesController::class, 'edit'])->name('Roles.edit');//visualizar edicion de ROL
    Route::put('/Administrador/Roles/update/{role}', [RolesController::class, 'update'])->name('Roles.update');//actualizar registro ROL
    Route::delete('Administrador/Roles/Permisos/eliminar/{role}', [RolesController::class, 'destroy'])->name('Role.destroy');// Ruta para eliminar de ROL

//RUTAS DE ASIGNACION DE ROLES AL USUARIO
    Route::get('Administrador/Roles/Usuario/{Usuario}', [UserController::class, 'Roles'])->name('Usuario.roles'); //ir a la vista de Asiganacion de rol para usuario
    Route::put('Administrador/Roles/Usuario/{Usuario}', [UserController::class, 'RolesUpdate'])->name('Usuario.roles.update'); //guardado  de rol para usuario

//RUTAS DE REPORTES
    Route::get('/Reportes', [ReportesController::class, 'index'])->name('Reportes.index');
    Route::get('/Reportes/Ver-Reporte', [ReportesController::class, 'verReporte'])->name('Reportes.Ver-Reporte');
});


/**
 * Grupo de rutas que se encargan del manejo del controlador y vista de los lugares de asignacion, es necesario estar
 * autenticado para acceder dichas rutas
 */
Route::group(['middleware' => ['auth']], function () {
    Route::controller(LugarEvaluacionController::class)->group(function () {
        Route::get('lugares-evaluacion', 'index')->name('lugares-evaluacion.index');
        Route::get('lugares-evaluacion/nuevo', 'create')->name('lugares-evaluacion.create');
        Route::post('lugares-evaluacion/nuevo', 'store')->name('lugares-evaluacion.store');
        Route::get('lugares-evaluacion/editar/{lugar}', 'edit')->name('lugares-evaluacion.edit');
        Route::put('lugares-evaluacion/editar/{lugar}', 'update')->name('lugares-evaluacion.update');
        Route::get('lugares-evaluacion/asignar/{id}', 'show')->name('lugares-evaluacion.show');
        Route::post('lugares-evaluacion/asignar/{id}', 'asignarTipoPrueba')->name('lugares-evaluacion.asignar');
        Route::delete('lugares-evaluacion/deshabilitar/{lugar}', 'destroy')->name('lugares-evaluacion.destroy');
    });
});

/**
 * Grupo de rutas que se encargan del manejo del controlador y vista de la terna evaluadora, es necesario estar
 * autenticado para acceder dichas rutas
 */
Route::group(['middleware' => ['auth']], function () {
    Route::controller(TernaEvaluadoraController::class)->group(function () {
        Route::get('terna-evaluadora', 'index')->name('terna-evaluadora.index');
        Route::get('terna-evaluadora/nuevo', 'create')->name('terna-evaluadora.create');
        Route::post('terna-evaluadora/nuevo', 'store')->name('terna-evaluadora.store');
        Route::post('terna-evaluadora/buscar', 'buscarTerna')->name('terna-evaluadora.search');
        Route::get('terna-evaluadora/editar/{terna}', 'edit')->name('terna-evaluadora.edit');
        Route::put('terna-evaluadora/editar/{terna}', 'update')->name('terna-evaluadora.update');
        Route::get('terna-evaluadora/asignar/{id}', 'show')->name('terna-evaluadora.show');
        Route::post('terna-evaluadora/asignar/{id}', 'vincularEvaluados')->name('terna-evaluadora.asignar');
        Route::delete('terna-evaluadora/deshabilitar/{lugar}', 'destroy')->name('terna-evaluadora.destroy');
    });

    Route::controller(\App\Http\Controllers\TernaPruebaFisicaController::class)->group(function () {
        Route::get('terna-pruebas-fisicas', 'index')->name('terna.pruebas.index');
        Route::get('terna-pruebas-fisicas/evento/{terna_id}/{evento}', 'registrarEvento')->name('terna.pruebas.evento');
        Route::get('terna-pruebas-fisicas/resumen/{terna_id}', 'resumenEvaluacion')->name('terna.pruebas.resumen');
        Route::post('terna-pruebas-fisicas/store', 'storeResultados')->name('terna.pruebas.store');
        Route::post('terna-pruebas-fisicas/update-individual', 'updateIndividual')->name('terna.pruebas.updateIndividual');
        Route::post('terna-pruebas-fisicas/finalizar', 'finalizarPrueba')->name('terna.pruebas.finalizar');
        Route::post('terna-pruebas-fisicas/obtener-puntaje', 'obtenerPuntaje')->name('terna.pruebas.puntaje');
    });
});
