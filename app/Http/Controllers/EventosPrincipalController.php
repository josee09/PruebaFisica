<?php
// 18-5-23 creación de Controlador para eventos principales de prueba fisica
namespace App\Http\Controllers;

use App\Models\Evaluado;

//Modelo Evaluado
use App\Models\EventosAlterno;

//Modelo eventos alternos
use App\Models\EventosPrincipal;

//Modelo eventos alternos
use App\Models\ResultadoPrueba;

//Modelo resultado prueba
use App\Models\Medico;

//Modelo medico
use App\Models\TernaEvaluadora;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

//clase DB
use Barryvdh\DomPDF\Facade\Pdf;

//PDF
use Dompdf\Dompdf;

//PDF
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

///método para dar fromato a fechas

class EventosPrincipalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /** LISTA DE REGISTROS *************************************************************/
    public function index()
    {
        $user = Auth::user();

        if ($user->can('prueba.fisica.depto_operaciones')) {
            $principal = EventosPrincipal::whereHas('evaluado', function ($query) use ($user) {
                return $query->where('lugarasig', '=', $user->udep);
            })->distinct('id')->orderByDesc('created_at')->get();
        } else {
            $principal = EventosPrincipal::distinct('id')->orderByDesc('created_at')->get();
        }
        return view('principales/Principal')->with('principal', $principal);
    }

    /** LISTA DE REGISTROS Y GUARDADO *************************************************/
    public function registro()
    {
        $user = Auth::user();

        //evaluados
        $evaluado = Evaluado::distinct('dni')->get();
        //registros medicos filtrados por condicion
        $idsRelacionados = EventosPrincipal::pluck('id_medico')->toArray();
        $medico = Medico::whereNotIn('id', $idsRelacionados)
            ->where('condicion', 'Apto')
            ->get();


        //eventos principales filtrados por resultados de prueba
        if ($user->can('prueba.fisica.depto_operaciones')) {
            $principal = EventosPrincipal::whereHas('evaluado', function ($query) use ($user) {
                return $query->where('lugarasig', '=', $user->udep);
            })
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('resultado_pruebas')
                        ->whereRaw('resultado_pruebas.id_principal = eventos_principals.id');
                })->orderByDesc('created_at')->get();

        } else {
            $principal = EventosPrincipal::whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('resultado_pruebas')
                    ->whereRaw('resultado_pruebas.id_principal = eventos_principals.id');
            })->orderByDesc('created_at')->get();
        }

        //DATOS UTILIZADOS EN EL DATALIST PARA LA PREDICCION AUTOMATICA DE TIEMPOS Y CANTIDES
        $carrera = DB::table('tbl_carr_o_ebr')->where('edad', "17")->get();
        $abdominal = DB::table('tbl_abdo_o_ebr')->where('edad', "17")->get();
        $pechada = DB::table('tbl_fb_o_ebr')->where('edad', "17")->get();
        $natacion = DB::table('tbl_natacion')->where('edad', "17")->get();
        $caminata = DB::table('tbl_caminata')->where('edad', "17")->get();
        $ciclismo = DB::table('tbl_ciclismo')->where('edad', "17")->get();
        $barra = DB::table('tbl_barras')->where('edad', "17")->get();
        $categoria = DB::table('tbl_categoria')->first();

        return view('principales/NuevoPrincipal', [
            'principal' => $principal,
            'carrera' => $carrera,
            'abdominal' => $abdominal,
            'pechada' => $pechada,
            'natacion' => $natacion,
            'caminata' => $caminata,
            'ciclismo' => $ciclismo,
            'barra' => $barra,
            'categoria' => $categoria]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function evaluacionesMedicas(Request $request): \Illuminate\Http\JsonResponse
    {
        $dni = $request->only('dni');

        $result = DB::table('medicos')
            ->join('evaluados', 'medicos.id_evaluado', '=', 'evaluados.id')
            ->select(
                'medicos.id as id',
                DB::raw('DATE(medicos.created_at) as fecha'),
                'evaluados.id as evaluadoId',
                'nombre',
                'apellido',
                'periodo',
                'grado'
            )
            ->where('evaluados.dni', $dni)
            ->where('medicos.condicion', 'APTO')
            ->whereNotIn('medicos.id', function ($query) {
                $query->select('id_medico')
                    ->from('eventos_principals')
                    ->whereColumn('medicos.id_evaluado', 'eventos_principals.id_evaluado');
            })
            ->orderBy('medicos.created_at')
            ->get();

        return response()->json(['evaluacionesMedicas' => $result]);
    }

    public function storeAjax(Request $request)
    {
        $medico = Medico::all()->where('id', $request->id_medico)->first();
        // validar que exista el id medico
        if ($medico) {
            if (EventosPrincipal::all()->where('id_medico', $medico->id)->first()) {
                return response()
                    ->json(['error' => '¡Registro médico ya cuenta con un registro de eventos fisicos!'])
                    ->setStatusCode(Response::HTTP_CONFLICT);
            }
            // validar que exista el id_evaluado
            if (Evaluado::all()->where('id', $medico->id_evaluado)->first()) {
                //evaluar si existe un registro del evaluado el mismo dia
                if (EventosPrincipal::where('id_evaluado', $medico->id_evaluado)->whereDate('created_at', '=', date('Y-m-d'))->first()) {
                    session()->flash('error', '');
                    return response()
                        ->json(['error' => '¡DNI ya cuenta con una evaluación de la misma fecha!'])
                        ->setStatusCode(Response::HTTP_CONFLICT);
                }

                if (is_null($request->input('tipo_evento')) || $request->input('tipo_evento') == 'NORMAL') {
                    //evaluar que los campos de evento no esten nulos
                    if (is_null($request->input('pechada')) && is_null($request->input('abdominal')) && is_null($request->input('carrera'))) {
                        return response()
                            ->json(['error' => 'Por favor verifique los datos de los eventos'])
                            ->setStatusCode(Response::HTTP_CONFLICT);
                    }
                }
                //guardar
                EventosPrincipal::create([
                    'id_evaluado' => $medico->id_evaluado,
                    'evaluacion' => $request['evaluacion'],
                    'pechada' => $request['pechada'] ?? null,
                    'abdominal' => $request['abdominal'] ?? null,
                    'carrera' => $request['carrera'] ?? null,
                    'id_medico' => $request['id_medico'],
                    'user_id' => auth()->user()->id,
                    'tipo_evento' => $request['tipo_evento']
                ]);

                return response()
                    ->json(['mensaje' => '¡Registro creado con éxito!'])
                    ->setStatusCode(Response::HTTP_CREATED);
            } else {
                return response()
                    ->json(['error' => '¡DNI no se encuentra registrada!'])
                    ->setStatusCode(Response::HTTP_NOT_FOUND);
            }
        } else {
            session()->flash('error', '');
            return response()
                ->json(['error' => '¡Registro médico no encontrado!'])
                ->setStatusCode(Response::HTTP_NOT_FOUND);
        }
    }

    /** GUARDAR NUEVO REGISTRO ********************************************************/
    public function store(Request $request)
    {
        $medico = Medico::all()->where('id', $request->id_medico)->first();
        // validar que exista el id medico
        if ($medico) {
            if (EventosPrincipal::all()->where('id_medico', $medico->id)->first()) {
                session()->flash('error', '¡Registro médico ya cuenta con un registro de eventos fisicos!');
                return redirect()->route('registro.registro')
                    ->withErrors(['id_medico' => 'Por favor verifique los datos.'])
                    ->withInput(['id_medico' => $request->id_medico, 'id_medico' => $request->id_medico]);
            }
            // validar que exista el id_evaluado
            if (Evaluado::all()->where('id', $medico->id_evaluado)->first()) {
                //evaluar si existe un registro del evaluado el mismo dia
                if (EventosPrincipal::where('id_evaluado', $medico->id_evaluado)->whereDate('created_at', '=', date('Y-m-d'))->first()) {
                    session()->flash('error', '¡DNI ya cuenta con una evaluación de la misma fecha!');
                    return redirect()->route('registro.registro')->withErrors(['id_medico' => 'Por favor verifique los datos.'])->withInput(['id_medico' => $request->id_medico]);
                }
                //evaluar que los campos de evento no esten nulos
                if (is_null($request->input('pechada')) && is_null($request->input('abdominal')) && is_null($request->input('carrera'))) {
                    session()->flash('error', '¡Campos de evaluación vacios¡');
                    return redirect()->route('registro.registro')->withErrors(['id_medico' => 'Por favor verifique los datos.'])->withInput(['id_medico' => $request->id_medico]);
                }
                //guardar
                EventosPrincipal::create([
                    'id_evaluado' => $medico->id_evaluado,
                    'evaluacion' => $request['evaluacion'],
                    'pechada' => $request['pechada'],
                    'abdominal' => $request['abdominal'],
                    'carrera' => $request['carrera'],
                    'id_medico' => $request['id_medico'],
                    'user_id' => auth()->user()->id,
                ]);
                session()->flash('mensaje', '¡Registro creado con éxito!');
                return redirect()->route('registro.registro');
            } else {
                session()->flash('error', '¡DNI no se encuentra registrada!');
                return redirect()->route('registro.registro')->withErrors(['id_medico' => 'Por favor verifique los datos.'])->withInput(['id_medico' => $request->id_medico]);
            }
        } else {
            session()->flash('error', '¡Registro médico no encontrado!');
            return redirect()->route('registro.registro')->withErrors(['id_medico' => 'Por favor verifique los datos.'])->withInput(['id_medico' => $request->id_medico]);
        }
    }

    /** MOSTRAR EVALUACIÓN FISICA ******************************************************/
    public function show($id, Request $request)
    {
        $categoria = DB::table('tbl_categoria')->first();
        //Extraer datos requeridos---------------------------------------------------------------------
        //evento principal
        $principal = EventosPrincipal::find($id);
        $id_evaluado = $principal->id_evaluado;
        $pechada = $principal->pechada;
        $abdominal = $principal->abdominal;
        $carrera = $principal->carrera;
        $id_medico = $principal->id_medico;
        $tipoEvaluacion = $principal->evaluacion;
        //evaluado
        $evaluado = Evaluado::find($id_evaluado);
        $categoria = $evaluado->categoria;
        $edad = \Carbon\Carbon::parse($evaluado->fechanac)->age;
        $sexo = $evaluado->sexo;
        //evento alterno
        $alterno = EventosAlterno::where('id_principal', $id)->first();
        $barras = null;
        if (is_null($alterno)) {
            $id_alterno = null;
            $natacion = null;
            $caminata = null;
            $ciclismo = null;
            $barra = null;
        } else {
            $id_alterno = $alterno->id;
            $natacion = $alterno->natacion;
            $caminata = $alterno->caminata;
            $ciclismo = $alterno->ciclismo;
            $barra = $alterno->barra;
        };
        //evaluacion medica
        $medico = Medico::find($id_medico);
        $pesoexc = $medico->exceso;

        //1 no se tomara en cuenta la categoria del personal,
        //0 se tomara en cuenta la categoria del personal
        $evCategoria = DB::table('tbl_categoria')->where('id', 1)->value('tipo_categoria');

        //Validacion de datos---------------------------------------------------------------------------
        //rango de edad
        if ($edad <= 21) {
            $edad = 17;
        } else {
            if ($edad <= 26) {
                $edad = 22;
            } else {
                if ($edad <= 31) {
                    $edad = 27;
                } else {
                    if ($edad <= 36) {
                        $edad = 32;
                    } else {
                        if ($edad <= 40) {
                            $edad = 37;
                        } else {
                            if ($edad <= 45) {
                                $edad = 41;
                            } else {
                                if ($edad <= 50) {
                                    $edad = 46;
                                } else {
                                    if ($edad >= 51) {
                                        $edad = 51;
                                    } else {
                                        session()->flash('error', 'Rango de edad no valido');
                                        return redirect()->route('registro.registro');
                                    }
                                }
                            }
                        }
                    }
                }
            }
        };
        //Definir columna segun sexo
        if ($sexo === "F") {
            $sexo = 'nota_fem';
        } else {
            if ($sexo === "M") {
                $sexo = 'nota_mas';
            }
        };

        // Notas ---------------------------------------------------------------------------------------------
        if ($evCategoria === 0) { //se evalua segun categoria

            if ($categoria == "Regular") { //escala regular
                //rango de flexiones de brazo
                if ($pechada || $pechada === 0) {
                    if ($pechada === 0) {
                        $npechada = 0;
                    } else {
                        if ($pechada >= 68) {
                            $pechada = 68;
                        }
                        $npechada = DB::table('tbl_fb_o_ebr')->where('edad', $edad)->where('repeticiones', $pechada)->value($sexo);
                    }
                } else {
                    $npechada = null;
                }

                //rango de flexiones de abdominal
                if ($abdominal || $abdominal === 0) {
                    if ($abdominal === 0) {
                        $nabdominal = 0;
                    } else {
                        if ($abdominal) {
                            if ($abdominal >= 78) {
                                $abdominal = 78;
                            }
                        }
                        $nabdominal = DB::table('tbl_abdo_o_ebr')->where('edad', $edad)->where('repeticiones', $abdominal)->value($sexo);
                    }
                } else {
                    $nabdominal = null;
                }

                //rango de carrera
                if ($carrera || $carrera === 0) {
                    if ($carrera === "00:00") {
                        $ncarrera = 0;
                    } else {
                        if ($carrera >= "27:54") {
                            $carrera = "27:54";
                        }
                        if ($carrera <= "10:54") {
                            $carrera = "10:54";
                        }
                        //EN CASO DE QUE HAGA MENOS TIEMPO
                        if ($carrera <= "16:00") {
                            $carrera = "16:00";
                        }
                        //tbl_carr_o_ebs_pa -> tabla carrera de los servicios auxiliar
                        //tbl_carr_o_ebr -> tabla carrera regular
                        $ncarrera = DB::table('tbl_carr_o_ebs_pa')->where('edad', $edad)->whereRaw("TIME_TO_SEC(tiempo) <= TIME_TO_SEC('$carrera')")
                            ->orderByRaw("TIME_TO_SEC(tiempo) DESC")->limit(1)->value($sexo);
                    }
                } else {
                    $ncarrera = null;
                }

            } else {  //esscala de los servicios y auxiliares

                //rango de flexiones de brazo
                if ($pechada || $pechada === 0) {
                    if ($pechada === 0) {
                        $npechada = 0;
                    } else {
                        if ($pechada >= 50) {
                            $pechada = 50;
                        }
                        $npechada = DB::table('tbl_fb_o_ebs_pa')->where('edad', $edad)->where('repeticiones', $pechada)->value($sexo);
                    }
                } else {
                    $npechada = null;
                }

                //rango de flexiones de abdomen
                if ($abdominal || $abdominal === 0) {
                    if ($abdominal === 0) {
                        $nabdominal = 0;
                    } else {
                        if ($abdominal) {
                            if ($abdominal >= 57) {
                                $abdominal = 57;
                            }
                        }
                        $nabdominal = DB::table('tbl_abdo_o_ebs_pa')->where('edad', $edad)->where('repeticiones', $abdominal)->value($sexo);
                    }
                } else {
                    $nabdominal = null;
                }

                //rango de carrera
                if ($carrera || $carrera === 0) {
                    if ($carrera === "00:00") {
                        $ncarrera = 0;
                    } else {
                        if ($carrera) {
                            if ($carrera >= "36:10") {
                                $carrera = "36:10";
                            }
                        }
                        if ($carrera <= "16:00") {
                            $carrera = "16:00";
                        }
                        $ncarrera = DB::table('tbl_carr_o_ebs_pa')->where('edad', $edad)->whereRaw("TIME_TO_SEC(tiempo) <= TIME_TO_SEC('$carrera')")
                            ->orderByRaw("TIME_TO_SEC(tiempo) DESC")->limit(1)->value($sexo);
                    }
                } else {
                    $ncarrera = null;
                }
            }
        } else {
            //rango de flexiones de brazo
            if ($pechada || $pechada === 0) {
                if ($pechada === 0) {
                    $npechada = 0;
                } else {
                    if ($pechada >= 50) {
                        $pechada = 50;
                    }
                    $npechada = DB::table('tbl_fb_o_ebs_pa')->where('edad', $edad)->where('repeticiones', $pechada)->value($sexo);
                }
            } else {
                $npechada = null;
            }

            //rango de flexiones de abdomen
            if ($abdominal || $abdominal === 0) {
                if ($abdominal === 0) {
                    $nabdominal = 0;
                } else {
                    if ($abdominal) {
                        if ($abdominal >= 57) {
                            $abdominal = 57;
                        }
                    }
                    $nabdominal = DB::table('tbl_abdo_o_ebs_pa')->where('edad', $edad)->where('repeticiones', $abdominal)->value($sexo);
                }
            } else {
                $nabdominal = null;
            }

            //rango de carrera
            if ($carrera || $carrera === 0) {
                if ($carrera === "00:00") {
                    $ncarrera = 0;
                } else {
                    if ($carrera) {
                        if ($carrera >= "36:10") {
                            $carrera = "36:10";
                        }
                    }
                    if ($carrera <= "16:00") {
                        $carrera = "16:00";
                    }
                    $ncarrera = DB::table('tbl_carr_o_ebs_pa')->where('edad', $edad)->whereRaw("TIME_TO_SEC(tiempo) <= TIME_TO_SEC('$carrera')")
                        ->orderByRaw("TIME_TO_SEC(tiempo) DESC")->limit(1)->value($sexo);
                }
            } else {
                $ncarrera = null;
            }
        }

        //alternos
        if ($alterno) {
            $tbarra = null;
            $tcaminata = null;
            $tciclismo = null;
            $tnatacion = null;

            //rango de natacion
            if ($natacion) {
                if ($natacion === "00:00") {
                    $nnatacion = 0;
                } else {
                    if ($natacion >= "23:24") {
                        $tnatacion = "23:24";
                    } elseif ($natacion <= "14:00") {
                        $tnatacion = "14:00";
                    } else {
                        $tnatacion = $natacion;
                    }
                    //rango de edad para natacion
                    if ($edad <= 31) {
                        $edad = 17;
                    } else {
                        if ($edad <= 41) {
                            $edad = 32;
                        } else {
                            if ($edad >= 42) {
                                $edad = 42;
                            }
                        }
                    }
                    //natacion
                    $nnatacion = DB::table('tbl_natacion')
                        ->where('edad', $edad)
                        ->whereRaw("TIME_TO_SEC(tiempo) <= TIME_TO_SEC('$tnatacion')")
                        ->orderByRaw("TIME_TO_SEC(tiempo) DESC")
                        ->limit(1)
                        ->value($sexo);
                }
            } else {
                $nnatacion = null;
            }
            //rango de caminata
            if ($caminata) {
                if ($caminata === "00:00") {
                    $ncaminata = 0;
                } else {
                    if ($caminata >= "44:30") {
                        $tcaminata = "44:30";
                    } elseif ($caminata <= "33:00") {
                        $tcaminata = "33:00";
                    } else {
                        $tcaminata = $caminata;
                    }
                    $ncaminata = DB::table('tbl_caminata')
                        ->where('edad', $edad)
                        ->whereRaw("TIME_TO_SEC(tiempo) <= TIME_TO_SEC('$tcaminata')")
                        ->orderByRaw("TIME_TO_SEC(tiempo) DESC")
                        ->limit(1)
                        ->value($sexo);
                }
            } else {
                $ncaminata = null;
            }
            //rango de natacion
            if ($ciclismo) {
                if ($ciclismo === "00:00") {
                    $nciclismo = 0;
                } else {
                    if ($ciclismo >= "35:24") {
                        $tciclismo = "35:24";
                    } elseif ($ciclismo <= "22:00") {
                        $tciclismo = "22:00";
                    } else {
                        $tciclismo = $ciclismo;
                    }
                    $nciclismo = DB::table('tbl_ciclismo')
                        ->where('edad', $edad)
                        ->whereRaw("TIME_TO_SEC(tiempo) <= TIME_TO_SEC('$tciclismo')")
                        ->orderByRaw("TIME_TO_SEC(tiempo) DESC")
                        ->limit(1)
                        ->value($sexo);
                }
            } else {
                $nciclismo = null;
            }
            //rango de barra
            if ($barra) {
                if ($barra === "00:00") {
                    $nbarra = 0;
                } else {
                    if ($barra >= 20) {
                        $tbarra = 20;
                    } elseif ($barra <= 0) {
                        $tbarra = 1;
                    } else {
                        $tbarra = $barra;
                    }
                    $nbarra = DB::table('tbl_barras')->where('edad', $edad)
                        ->where('repeticiones', $tbarra)->value($sexo);
                }
            } else {
                $nbarra = null;
            }

        } else {
            $nnatacion = null;
            $ncaminata = null;
            $nciclismo = null;
            $nbarra = null;
        }
        // Calculo de notas ---------------------------------------------------------------------------------
        // variables de calculo
        // enventos principales
        $npechada1 = $npechada;
        $nabdominal1 = $nabdominal;
        $ncarrera1 = $ncarrera;
        //eventos alternos
        $nnatacion1 = $nnatacion;
        $ncaminata1 = $ncaminata;
        $nciclismo1 = $nciclismo;
        $nbarra1 = $nbarra;
        //a las variables nulos se les asigna cero para realizar calculo
        $npechada1 = $npechada1 ?? 0;
        $nabdominal1 = $nabdominal1 ?? 0;
        $ncarrera1 = $ncarrera1 ?? 0;
        $nnatacion1 = $nnatacion1 ?? 0;
        $ncaminata1 = $ncaminata1 ?? 0;
        $nciclismo1 = $nciclismo1 ?? 0;
        $nbarra1 = $nbarra1 ?? 0;
        //nivelacion de las notas en los eventos alternos
        if (!isset($alterno->is_icb) || !$alterno->is_icb) {
            if ($nnatacion1 >= 70) {
                $nnatacion1 = 70;
                $nnatacion = 70;
            }
            if ($ncaminata1 >= 70) {
                $ncaminata1 = 70;
                $ncaminata = 70;
            }
            if ($nciclismo1 >= 70) {
                $nciclismo1 = 70;
                $nciclismo = 70;
            }
            if ($nbarra1 >= 70) {
                $nbarra1 = 70;
                $nbarra = 70;
            }
        }

        $npromedio = round(($npechada1 + $nabdominal1 + $ncarrera1 + $nnatacion1 + $ncaminata1 + $nciclismo1 + $nbarra1) / 3, 2);

//        //exceso de libras
//        if ($pesoexc > 5) {
//            if ($npromedio == 0) {
//                $npesoexc = 0;
//            } else {
//                $npesoexc = $npromedio - ($pesoexc - 5);
//            }
//        } else {
//            $npesoexc = $npromedio;
//        }
        /*
         * TODO - CAMBIO SOLICITADO POR COMISARIO FUNEZ DE QUE AL MOMENTO DE MOSTRAR EL SOBREPESO NO SALGA LAS
         * 5 LIBRAS QUE SE PERDONAN, SOLO EL VALOR DE PENALIZACION. QUITAR LOS NUMEROS NEGATIVOS
         */

        if ($pesoexc >= 5) {
            if ($npromedio == 0) {
                $npesoexc = 0;
            } else {
                $pesoexc -= 5;
                $npesoexc = $npromedio - $pesoexc;
            }
        } else {
            $pesoexc = 0;
            $npesoexc = $npromedio;
        }

        $estado = $npesoexc < 70 ? 'REPROBADO' : 'APROBADO';

        $eventos = [
            'npechada' => $npechada,
            'abdominal' => $nabdominal,
            'carrera' => $ncarrera,
            'nnatacion' => $nnatacion,
            'ncaminata' => $ncaminata,
            'nciclismo' => $nciclismo,
            'nbarra' => $nbarra,
        ];

        if ($tipoEvaluacion == 'ASCENSO') {
            foreach ($eventos as $eventosName => $eventosValue) {
                if (isset($eventosValue) && $eventosValue < 70) {
                    $estado = 'REPROBADO';
                    $npesoexc = 'REPROBADO';
                    break;
                }
            }
        }

// Procede según sea necesario...


        $terna = TernaEvaluadora::all();
        //datos
        return view('resultado_prueba/EvaluacionFisica', ['evaluado' => $evaluado, 'principal' => $principal,
            'id_alterno' => $id_alterno, 'estado' => $estado,
            'natacion' => $natacion, 'caminata' => $caminata, 'ciclismo' => $ciclismo, 'barra' => $barra,
            'nabdominal' => $nabdominal, 'npechada' => $npechada, 'ncarrera' => $ncarrera,
            'nnatacion' => $nnatacion, 'ncaminata' => $ncaminata, 'nciclismo' => $nciclismo, 'nbarra' => $nbarra,
            'npromedio' => $npromedio, 'npesoexc' => $npesoexc, 'medico' => $medico, 'ternasEvaluadoras' => $terna,
            'pesoexc' => $pesoexc
        ]);
    }

    /** ACTUALIZAR REGISTRO ************************************************************/
    public function update(EventosPrincipal $principal, Request $request)
    {
        $emptyCount = 0;
        $alterno = EventosAlterno::where('id_principal', $request->id_principal)->first();
        // Validaciones de eventos principales y alternos------------------------------------------
        if ($request->input('pechada')) {
            $emptyCount++;
        }
        if ($request->input('abdominal')) {
            $emptyCount++;
        }
        if ($request->input('carrera')) {
            $emptyCount++;
        }

        if ($emptyCount === 3) {
            if ($alterno) {
                session()->flash('error', 'No se puede agregar dos eventos principales porque ya existe un evento alterno.');
                return redirect()->route('registro.registro');
            }
        }

        if ($emptyCount === 0) {
            session()->flash('error', 'Por favor, complete uno de los campos antes de actualizar.');
            return redirect()->route('registro.registro');
        }

        $principal->fill([
            'pechada' => $request->input('pechada'),
            'abdominal' => $request->input('abdominal'),
            'carrera' => $request->input('carrera'),
        ]);
        //actualizar
        $principal->update();
        session()->flash('mensaje', '¡Registro actualizado con éxito!'); //sesion flash de alerta
        return redirect()->route('registro.registro');
    }

    /** ACTUALIZAR TIPO DE EVALUACION SEGUN CATEGORIA***********************************/
    public function updateCategoria(Request $request)
    {
        $valor = $request->input('categoria');
        DB::table('tbl_categoria')->where('id', 1)->update(['tipo_categoria' => $valor]);
        session()->flash('mensaje', 'Cambio de evaluación según categoria del personal.');
        return redirect()->route('registro.registro');
    }

    /** ELIMINAR REGISTRO **************************************************************/
    public function destroy(EventosPrincipal $principal)
    {
        $principal->alterno()->delete(); //borrar registro en casacada
        $principal->delete();
        session()->flash('mensaje', '¡Registro eliminado con éxito!');
        return redirect()->route('registro.registro');
    }
}
