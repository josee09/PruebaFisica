<?php
// 25-4-23 creación de Controlador para registro de usuarios del sistema
namespace App\Http\Controllers;
use App\Models\OrgSIG;
use Illuminate\Http\Request;
use App\Models\User; //Modelo Usuario
use Carbon\Carbon; //metodo para dar formato a fechas
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str; //método convierte la cadena dada a mayúsculas (SIN OMITIR ACENTOS NI Ñ)
use Illuminate\Support\Facades\DB; //clase DB

class UserController extends Controller
{
    /** LISTA DE REGISTROS *****************************************************************/
    public function registrousuario(){
        //mostrar registros
        $Usuario = User::where('id',  '!=', 1)->orderBYDesc('created_at')->get();
        return view('usuario/ListaUsuario')->with('Usuario',$Usuario);
    }

    /** CREAR NUEVO REGISTRO ***************************************************************/
    public function createUsuario(Request $request){
        $lugarAsig = OrgSIG::all()->pluck('DENOMINACION','CLAVE_SIG');
        return view('usuario/NuevoUsuario', compact('lugarAsig'));
    }

    /** GUARDAR NUEVO REGISTRO**************************************************************/
    public function store(Request $request){
        if($request->password === $request->password_confirmation){
            $Usuario= User::where('email', $request->email)->first(); //trae los email de los usuarios (sin importar el usuario que lo registra)
                if ($Usuario){ // condicion para no repetir el EMAIL (sin importar el usuario que lo registra)
                    session()->flash('error', '¡Hay un registro existente con este correo electrónico!');
                    return back()
                    -> withErrors(['email' => 'Por favor verifique los datos.'])
                    -> withInput(['firstname'=> $request->firstname, 'lastname'=> $request->lastname, 'grado'=> $request->grado, 'udep'=> $request->udep, 'assignment'=> $request->assignment, 'address'=> $request->address, 'department'=> $request->department, 'name'=> $request->name, 'email'=> $request->email, 'password'=> $request->password]);
            }
            $existingUser = User::where('name', $request->name)->first(); //trae los nombres de los susuarios sin importar quien los registro
                if ($existingUser) { //condion para no repetir el NOMBRE (sin importar el usuario que lo halla registrado)
                    session()->flash('error', '¡Hay un registro existente con este nombre!');
                    return back()
                    ->withErrors(['name' => 'Por favor verifique los datos.'])
                    -> withInput(['firstname'=> $request->firstname, 'lastname'=> $request->lastname, 'grado'=> $request->grado, 'udep'=> $request->udep, 'assignment'=> $request->assignment, 'address'=> $request->address, 'department'=> $request->department, 'name'=> $request->name, 'email'=> $request->email, 'password'=> $request->password]);
            }

            //empieza el guardado del usuario si todo esta correcto
            $Usuario = new User ();
            $password=$request->password;
            $Usuario->firstname=Str::upper($request->firstname);
            $Usuario->lastname=Str::upper($request->lastname);
            $Usuario->grado=$request->grado;
            $Usuario->udep=$request->udep;
            $Usuario->assignment=Str::upper($request->assignment);
            $Usuario->address=Str::upper($request->address);
            $Usuario->department=Str::upper($request->department);
            $Usuario ->name=Str::upper($request->name);
            $Usuario ->email=$request->email;
            $Usuario ->password=Hash::make($password);

            $Usuario -> save();
            $Usuario = User::all();
            session()->flash('mensaje', '¡Registro creado con éxito!'); //sesion flash de alerta
            return redirect()->route('registrousuario');
        }else{
            session()->flash('error', '¡Contraseñas no coinciden!');
            return back()
                -> withErrors(['password' => 'Por favor verifique los datos.', 'password_confirmation' => 'Por favor verifique los datos.'])
                -> withInput(['firstname'=> $request->firstname, 'lastname'=> $request->lastname, 'grado'=> $request->grado, 'udep'=> $request->udep, 'assignment'=> $request->assignment, 'address'=> $request->address, 'department'=> $request->department, 'name'=> $request->name, 'email'=> $request->email, 'password'=> $request->password]);        }

    }

    /** Display the specified resource. */
    public function show(Request $request){ }

    /** EDITAR REGISTRO*********************************************************************/
    public function edit(User $Usuario){
        $lugarAsig = OrgSIG::all()->pluck('DENOMINACION','CLAVE_SIG');
        return view('usuario/EditarUsuario', compact('Usuario','lugarAsig'));
    }

    /** ACTUALIZAR REGISTRO****************************************************************/
    public function update(User $Usuario, Request $request ){
        //evaluar la confirmación de contraseña coincida con la contraseña
        if($request->password === $request->password_confirmation){

            //evaluar que el correo no coincida con un correo de otro usuario
            $Usuario = User::where('email', $request->email)->whereNotIn('id', [$request->id_user])->first(); //trae los email de los usuarios (sin importar el usuario que lo registra)
            if ($Usuario){ // condicion para no repetir el EMAIL (sin importar el usuario que lo registra)
                session()->flash('error', '¡Hay un registro existente con este correo electrónico!');
                return back()
                -> withErrors(['email' => 'Por favor verifique los datos.'])
                -> withInput(['firstname'=> $request->firstname, 'lastname'=> $request->lastname, 'grado'=> $request->grado, 'udep'=> $request->udep, 'assignment'=> $request->assignment, 'address'=> $request->address, 'department'=> $request->department, 'name'=> $request->name, 'email'=> $request->email, 'password'=> $request->password, 'password_confirmation'=> $request->password_confirmation]);
            }
            //evaluar que el nombre no coincida con un nombre de otro usuario
            $existingUser = User::where('name', $request->name)
            ->whereNotIn('id', [$request->id_user])
            ->first(); //trae los nombres de los susuarios sin importar quien los registro
                if ($existingUser) { //condion para no repetir el NOMBRE (sin importar el usuario que lo halla registrado)
                    session()->flash('error', '¡Hay un registro existente con este nombre!');
                    return back()
                    ->withErrors(['name' => 'Por favor verifique los datos.'])
                    -> withInput(['firstname'=> $request->firstname, 'lastname'=> $request->lastname, 'grado'=> $request->grado, 'udep'=> $request->udep, 'assignment'=> $request->assignment, 'address'=> $request->address, 'department'=> $request->department, 'name'=> $request->name, 'email'=> $request->email, 'password'=> $request->password, 'password_confirmation'=> $request->password_confirmation]);
            }
            //request de datos
            $Usuario = User::where('email', $request->email)->first();
                $Usuario->fill([
                    'firstname' => Str::upper($request->input('firstname')),
                    'lastname' => Str::upper($request->input('lastname')),
                    'grado' => $request->input('grado'),
                    'assignment' => $request->input('assignment'),
                    'address'=>$request->input('address'),
                    'udep'=> $request->input('udep'),
                    'department' => $request->input('department'),
                    'name' => Str::upper($request->input('name')),
                    'email' => $request->input('email'),

                ]);
            //si el campo de contraseña no es nuelo, hace un $request del campo password
            if (!empty($request->input('password'))) {
                $Usuario->password = Hash::make($request->input('password'));
            }
            //guardado de datos
            $Usuario->save();
            session()->flash('mensaje', '¡Registro actualizado con éxito!'); //sesion flash de alerta
            return redirect()->route('registrousuario');
        }else{
            return back()
                -> withErrors(['password' => 'Por favor verifique los datos.', 'password_confirmation' => 'Por favor verifique los datos.'])
                -> withInput(['firstname'=> $request->firstname, 'lastname'=> $request->lastname, 'grado'=> $request->grado, 'udep'=> $request->udep, 'assignment'=> $request->assignment, 'address'=> $request->address, 'department'=> $request->department, 'name'=> $request->name, 'email'=> $request->email, 'password'=> $request->password, 'password_confirmation'=> $request->password_confirmation]);
            }
    }

    /** ELIMINAR REGISTRO*****************************************************************/
    public function destroy(User $Usuario){
        $Usuario->delete();
        session()->flash('mensaje', '¡Registro  borrado con éxito!');
        return redirect()->route('registrousuario');
    }
     /** ASIGNAR ROL A REGISTRO***********************************************************/
    public function Roles (User $Usuario){
        $Role = Role::all();
        $User = User::all();
        return view('usuario/asignarUsuario', compact('Usuario', 'Role'));
    }

    public function RolesUpdate (Request $request, User $Usuario){
        $Usuario->roles()->sync($request->Role);
        session()->flash('mensaje', '¡Rol asiganado con éxito!');
        return redirect()->route('registrousuario');
    }

}
