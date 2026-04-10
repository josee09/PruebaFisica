<?php
// 17-4-23 creación de Controlador para registro de personal
namespace App\Http\Controllers;

use App\Models\Evaluado;
use App\Models\User;

//Modelo Evaluado
use App\Models\GradosSIG;
use App\Models\OrgSIG;
use App\Models\ResultadoPrueba;

//Modelo resultado prueba
use App\Models\EventosAlterno;

//Modelo eventos alternos
use App\Models\EventosPrincipal;

//Modelo eventos alternos
use App\Models\Medico;

//Para la paginacion de la pantalla de Lista de Registros
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\View\View;

//Modelo Medico
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

//método convierte la cadena dada a mayúsculas (SIN OMITIR ACENTOS NI Ñ)
use App\Imports\ExcelImportEvaluado;

//llamado del modelo de ImportExcel que utiliza para el documento
use LaravelIdea\Helper\App\Models\_IH_evaluado_C;
use Maatwebsite\Excel\Facades\Excel;

//los datos correposndientes a los documentos de tipo Excel
use Illuminate\Support\Facades\Validator;

//uso de validaciones para los campos del documetno Excel
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Scalar\String_;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Http;

//traer datos de los usuarios conectados


/**
 *
 */
class EvaluadoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param String $dni
     * @return object
     * @throws Exception Obtiene los datos del funcionario usando el Sistima Integral de Gestion SIC
     */
    private function obtenerDatosSIG(string $dni): object
    {
        $url = "http://10.20.124.2/sig/api/sicDni/$dni";

        $response = Http::post($url, [
            'usuario' => 'PRUEBA-FISICA',
            'password' => '12345678',
        ]);

        if ($response->successful()) {
            $responseData = $response->json();

            // Process your data here. For instance, you can transform it into an object.
            $dataObject = (object)$responseData['data'];

            // Use $dataObject as needed
            return $dataObject;
        } else {
            // Handle error
            // You could throw an exception or return an appropriate response
            throw new Exception('Error fetching data from the API.');
        }
    }

    private function generarUsuario(string $dni)
    {
        try {

            $datos = $this->obtenerDatosSIG($dni);

            $grados = GradosSIG::where('CLAVE_SIG', $datos->datos_generales['AREAPERS'])->first();

            //$lugarAsig = OrgSIG::where('CLAVE_SIG', $datos->datos_generales['CLAVEORGA'])->first();

            $chapa = null;
            $promocion = null;
            if (isset($datos->Informacion_Complementaria) && count($datos->Informacion_Complementaria) > 0) {
                foreach ($datos->Informacion_Complementaria as &$ic) {
                    switch ($ic['CALSEID']) {
                        case "06":
                            $chapa = $ic['NUMEROID'];
                            break;
                        case "11":
                            $promocion = $ic['NUMEROID'];
                            break;
                    }
                }

            }

            $datosEvaluado = [
                'dni' => $dni,
                'nombre' => $datos->datos_generales['NOMBRES'],
                'apellido' => $datos->datos_generales['APELLIDOS'],
                'sexo' => $datos->datos_generales['SEXO'] == 1 ? 'M' : 'F',
                'fechanac' => $datos->datos_generales['FECHANACIM'],
                //'email' => '',
                //'telefono' => '',
                'AREAPERS' => $datos->datos_generales['AREAPERS'],
                'grado' => $grados->GRADO,
                'CLAVEORGA' => $datos->datos_generales['CLAVEORGA'],
                'categoria' => $grados->CATEGORIA,
                'lugarasig' => $datos->datos_generales['CLAVEORGA'],
                'serie' => $chapa,
                'promocion' => $promocion,
                'user_id' => auth()->user()->id,
            ];
            return $datosEvaluado;
        } catch (Exception $e) {
            throw new Exception('No se puedo acceder a la informacion');
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function buscarSic(Request $request): JsonResponse
    {
        abort_if(Gate::denies(['ternas.create', 'medica.create']), Response::HTTP_FORBIDDEN);

        $validator = Validator::make($request->all(),
            [
                'dni' => 'required|string',
            ],
            [
                'dni.required' => 'El dni es obligatorio',
                'dni.string' => 'El dni no es valido',
            ]);

        if ($validator->fails()) {
            return Response()->json($validator->errors()->getMessages())->setStatusCode(Response::HTTP_NOT_ACCEPTABLE);
        }

        $dni = $request->only('dni')['dni'];

        try {
            return Response()->json($this->generarUsuario($dni))->setStatusCode(Response::HTTP_CREATED);
        } catch (Exception $e) {
            return Response()->json()->setStatusCode(Response::HTTP_NO_CONTENT);
        }

    }
    /**
     * @param String $dni
     * @return evaluado | bool
     */
    private function storeSig(string $dni): bool|Evaluado
    {
        try {
            $datosEvaluado = $this->generarUsuario($dni);

            $evaluado = Evaluado::whereDni($dni)->first();
            if (!isset($evaluado)) {
                $evaluado = Evaluado::create($datosEvaluado);
            } else {
                $evaluado->update($datosEvaluado);
            }

            return $evaluado;

        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function crearEvaluadoDni(Request $request): JsonResponse
    {
        abort_if(Gate::denies(['ternas.create', 'medica.create']), Response::HTTP_FORBIDDEN);

        $validator = Validator::make($request->all(),
            [
                'dni' => 'required|string',
            ],
            [
                'dni.required' => 'El dni es obligatorio',
                'dni.string' => 'El dni no es valido',
            ]);

        if ($validator->fails()) {
            return Response()->json($validator->errors()->getMessages())->setStatusCode(Response::HTTP_NO_CONTENT);
        }

        $dni = $request->only('dni');

        $evaluado = ($this->storeSig($dni['dni']));

        if (!$evaluado) {
            return Response()->json()->setStatusCode(Response::HTTP_NO_CONTENT);
        } else {
            return Response()->json($evaluado)->setStatusCode(Response::HTTP_CREATED);
        }


    }

    /** LISTA DE REGISTROS (DDDDDDD)*****************************************************************/
    public function index(Request $request)
    {
        //TODO PRUEBAS DEL METODO DE CREACION DE USUARIOS DESDE SIG
        //$this->storeSig();
        //Esta linea verifica si el usuario actual tiene el permiso acorde a su rol para acceder a la pagina de listado de registro,
        //en caso de no tenerlos se mostrara una pantalla 403 de prohibido
        abort_if(Gate::denies('registros.index'), Response::HTTP_FORBIDDEN);

        //Obtener el usuario autenticado
        $user = Auth::user();

        //Por defecto sera paginado en 10 filas de informacion y estaran los demas parametros de busqueda.
        $rowsPerPage = $request->input('Rows', 10);
        $search = $request->input('search', '');
        $searchDni = $request->input('searchDNI','');
        $searchLugarAsignado = $request->input('LugarAsignado', '');

        //En esta parte se realiza una consulta a la BD para obtener los registros de busqueda por cualquiera de los 3 metodos
        $evaluados = Evaluado::distinct('dni')
            //esta parte realizara el lugar de asignacion
            ->when($user->can('registro.depto_operaciones'), function($query) use ($user){
                return $query->where('lugarasig', '=', $user->udep);
            })
            //en esta parte ejecutara la busqueda mediante el nombre o apellido para recargar la pagina y que de vuelva la busqueda
            ->when($search, function($query) use ($search){
                return $query->where(function ($query) use ($search) {
                    $query->where('nombre', 'like', "%$search%")
                          ->orWhere('apellido', 'like', "%$search%");
                });
            })
            //en esta parte ejecuta la busqueda por el No de identidad del evaluado
            ->when($searchDni, function($query) use ($searchDni){
                return $query->where('dni', 'like', "%$searchDni%");
            })
            //y por ultimo en esta parte se hace una busqueda utilizando un select el cual devolvera toda la tabla del lugar de asignacion que desee buscar
            ->when($searchLugarAsignado, function($query) use ($searchLugarAsignado) {
                return $query->where('lugarasig', '=', $searchLugarAsignado);
            })
            ->orderBy('lugarasig')//ordenara de forma ascendente por medio del lugar de asignacion
            ->orderByDesc('created_at')// para posteriormente ser ordenada de forma descendente guiandose de la fecha de creacion
            ->paginate($rowsPerPage); //para que al final sea paginada en base a 10 filas de forma predeterminada o la cantidad que estime el usuario mediante el select de filas.

            //En esta parte se obtiene todos los lugares de asignacion disponibles para ser mostrados en el select del vista blade
            $lugaresAsignacion = OrgSIG::whereIn('CLAVE_SIG', Evaluado::distinct('lugarasig')->pluck('lugarasig'))->pluck('DENOMINACION', 'CLAVE_SIG');
        // por ultimo enviamos los datos mediante este return para que posteriormente sea renderizado.
        return view('evaluado.ListaRegistros', [
            'evaluado' => $evaluados,
            'lugaresAsignacion' => $lugaresAsignacion,
            'search' => $search,
            'searchDN' => $searchDni,
            'searchLugarAsignado' => $searchLugarAsignado,
        ]);
    }

    /** CREAR NUEVO REGISTRO ***************************************************************/
    public function create(Request $request)
    {
        $lugarAsig = OrgSIG::all()->pluck('DENOMINACION','CLAVE_SIG');
        return view('evaluado/NuevoRegistro', compact('lugarAsig'));

    }

    /** GUARDAR NUEVO REGISTRO *************************************************************/
    public function store(Request $request)
    {
        $request->validate([
            'fechanac' => 'required|date|before_or_equal:today'
        ], [
            'fechanac.before_or_equal' => 'La fecha de nacimiento no puede ser una fecha futura.'
        ]);

        $evaluado = Evaluado::all()->where('dni', $request->dni)->first(); //trae los dni del personal (sin importar el usuario que lo registra)
        //$evaluado= $user->evaluados()->where('dni', $request->dni)->first(); //trae los dni del personal (del usuario que lo registra)
        if ($evaluado) { // condicion para no repetir DNI(sin importar el usuario que lo registra)
            session()->flash('error', '¡DNI existente!');
            return back()
                ->withErrors(['dni' => 'Por favor verifique los datos.'])
                ->withInput(['dni' => $request->dni, 'nombre' => $request->nombre, 'apellido' => $request->apellido, 'lugarasig' => $request->lugarasig, 'chapa' => $request->chapa, 'grado' => $request->grado, 'fechanac' => $request->fechanac, 'promocion' => $request->promocion, 'sexo' => $request->sexo, 'categoria' => $request->categoria]);
        }
        //guardar
        Evaluado::create([
            'dni' => $request['dni'],
            'nombre' => Str::upper($request['nombre']),
            'apellido' => Str::upper($request['apellido']),
            'sexo' => Str::upper($request['sexo']),
            'fechanac' => $request['fechanac'],
            'email' => $request['email'],
            'telefono' => $request['telefono'],
            'grado' => Str::upper($request['grado']),
            'categoria' => $request['categoria'],
            'lugarasig' => Str::upper($request['lugarasig']),
            // 'chapa' => $request['chapa'],
            'promocion' => $request['promocion'],
            'user_id' => auth()->user()->id,
        ]);

        session()->flash('mensaje', '¡Registro creado con éxito!'); // Mensaje flash de sesión
        return redirect()->route('registros.index');
    }

    /** Display the specified resource*/
    public function show(evaluado $evaluado)
    {
    }

    /** EDITAR REGISTRO *******************************************************************/
    public function edit(Evaluado $evaluado)
    {
        $lugarAsig = OrgSIG::all()->pluck('DENOMINACION','CLAVE_SIG');
        $usuarios = User::orderBy('name')->get();
        return view('evaluado/EditarRegistro', compact('evaluado','lugarAsig', 'usuarios'));
    }

    /** *ACTUALIZAR REGISTRO *************************************************************/
    public function update(Evaluado $evaluado, Request $request)
    {
        $data = $request->validate($evaluado->rules()); //validar que sea un registro unico mediante reglas
        //actualizar
        $evaluado->fill([
            'nombre' => Str::upper($request->input('nombre')),
            'apellido' => Str::upper($request->input('apellido')),
            'dni' => $request->input('dni'),
            'lugarasig' => Str::upper($request->input('lugarasig')),
            // 'chapa'=>Str::upper($request->input('chapa')),
            'grado' => Str::upper($request->input('grado')),
            'fechanac' => $request->input('fechanac'),
            'promocion' => $request->input('promocion'),
            'sexo' => Str::upper($request->input('sexo')),
            'categoria' => $request->input('categoria'),
            'email' => $request->input('email'),
            'telefono' => $request->input('telefono'),
            'user_id' => $request->input('user_id'),
        ]);
        $evaluado->update($data);
        session()->flash('mensaje', '¡Registro actualizado con éxito!'); //sesion flash de alerta
        return redirect()->route('registros.index');
    }

    /** ELIMINAR REGISTRO *****************************************************************/
    public function destroy(Evaluado $evaluado)
    {
        //elilimar evaluaciones existentes del evaluado
        if (ResultadoPrueba::where('id_evaluado', $evaluado->id)->first()) {
            ResultadoPrueba::where('id_evaluado', $evaluado->id)->delete();
        }
        if (EventosAlterno::where('id_evaluado', $evaluado->id)->first()) {
            EventosAlterno::where('id_evaluado', $evaluado->id)->delete();
        }
        if (EventosPrincipal::where('id_evaluado', $evaluado->id)->first()) {
            EventosPrincipal::where('id_evaluado', $evaluado->id)->delete();
        }
        if (Medico::where('id_evaluado', $evaluado->id)->first()) {
            Medico::where('id_evaluado', $evaluado->id)->delete();
        }
        $evaluado->delete();
        session()->flash('mensaje', '¡Registro eliminado con éxito!');
        return redirect()->route('registros.index');
    }

    /**
     * INYECCION DE DATOS A TRAVEZ DE DOCUMENTO EXCEL (XLXS, CVS) *************************
     * @param \App\Models\Evaluado $evaluado
     * @return \Illuminate\Http\Response
     */

    public function registroexcel()
    {
        return view('/evaluado/RegistroExcel');
    }

    public function importExcel(Request $request)
    {
        if ($request->hasFile('excel')) {
            $archivo = $request->file('excel');

            $extension = $archivo->getClientOriginalExtension();
            if ($extension != 'csv') {
                return redirect()->route('registro.excel')->with('error', 'Solo se permiten archivos  EXCEL.CSV');
            }

            $import = new ExcelImportEvaluado();
            $data = Excel::toArray($import, $archivo);

            $id_user = Auth::id();
            $validRecords = []; // Array para almacenar los registros válidos

            foreach ($data[0] as $row) {
                $rowValidator = Validator::make($row, [
                    'nombre' => 'required|string',
                    'apellido' => 'required|string',
                    'dni' => 'required|numeric|unique:evaluados',
                    'lugarasig' => 'required|string',
                    // 'serie' => '|string',
                    'grado' => 'required|string',
                    'fechanac' => 'required|date',
                    'sexo' => 'required|in:M,F',
                    'categoria' => 'required|string',
                ]);
                if ($rowValidator->fails()) {
                    // Procesar los errores de validación de la fila
                    $errors = $rowValidator->errors()->all();
                    $errorMessage = "Error en la Columna: " . implode(", ", $errors);
                } else {
                    $dniExistente = Evaluado::where('dni', $row['dni'])->exists();
                    if ($dniExistente) {
                        $errorMessage = "Error en la columna DNI: el DNI {$row['dni']} ya se encuentra registrado";
                    } else {
                        // Guardar el registro válido en el array
                        $validRecords[] = $row;
                    }
                }
            }
            // Guardar todos los registros válidos en la base de datos
            foreach ($validRecords as $row) {
                $evaluado = new Evaluado;
                $fechaNacimiento = date('Y-m-d', strtotime($row['fechanac']));
                $evaluado->nombre = mb_strtoupper($row['nombre']);
                $evaluado->apellido = strtoupper($row['apellido']);
                $evaluado->dni = $row['dni'];
                $evaluado->lugarasig = $row['lugarasig'];
                // $evaluado->chapa = $row['chapa'];
                $evaluado->grado = $row['grado'];
                $evaluado->fechanac = $fechaNacimiento;
                $evaluado->email = $row['email'];
                $evaluado->telefono = $row['telefono'];
                $evaluado->promocion = $row['promocion'];
                $evaluado->sexo = $row['sexo'];
                $evaluado->categoria = $row['categoria'];
                $evaluado->user_id = $id_user;
                $evaluado->save();
            }
            // Redirigir a otra vista si no hay errores
            if (empty($errorMessage)) {
                session()->flash('mensaje', '¡Importación creada con éxito!'); //sesion flash de alerta
                return redirect()->route('registros.index');
            } else {
                return redirect()->route('registro.excel')->with('error', $errorMessage);
            }
        } else {
            session()->flash('error', '¡Documento requerido!');
            return back()
                ->withErrors(['excel' => 'Por favor verifique los datos.'])
                ->withInput(['excel' => $request->excel]);
        }
    }

    public function descargarExcel()
    {
        //ruta del archivo que va a descargar
        $filePath = base_path('public/file/FormatoImportacion.xlsx');

        //tipo de archivo que debe descargar en este caso tipo XLSX
        $headers = array('Content-Type' => 'text/xlsx',);
        //nombre del archivo del formato que va a descargar
        $nombreArchivo = 'FormatoImportacion.xlsx';
        //retorno que empieza la descarga
        return Response()->download($filePath, $nombreArchivo, $headers);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function buscarEvaluado(Request $request)
    {
        abort_if( (Gate::denies('medica.create')  && Gate::denies('ternas.create') ) , Response::HTTP_FORBIDDEN);

        $validator = Validator::make($request->all(),
            [
                'dni' => 'required|string',
            ],
            [
                'dni.required' => 'El dni es obligatorio',
                'dni.string' => 'El dni no es valido',
            ]);

        if ($validator->fails()) {
            return Response()->json($validator->errors()->getMessages())->setStatusCode(Response::HTTP_NO_CONTENT);
        }

        $dni = $request->only('dni');
        return Response()->json(Evaluado::select(DB::raw("id,CONCAT(grado,' ',nombre,' ',apellido) AS nombreCompleto"))->where('dni', '=', $dni)->get());
    }
}

