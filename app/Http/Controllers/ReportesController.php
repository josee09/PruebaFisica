<?php
// 6/6/2024 Creacion del controller para los reportes de resultados (By EMM)
namespace App\Http\Controllers;

use App\Models\Evaluado;
use App\Models\ResultadoPrueba;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Symfony\Component\HttpFoundation\Response;
use App\Models\TernaEvaluadora;

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Style\Font;
use IntlDateFormatter;

class ReportesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //Esta linea verifica si el usuario actual tiene el permiso acorde a su rol para acceder a la pagina de listado de registro,
        //en caso de no tenerlos se mostrara una pantalla 403 de prohibido *
        abort_if(Gate::denies('Reportes.index'), Response::HTTP_FORBIDDEN);

        //Se llamara al metodo BuscarInformacion y recogera los datos buscados para ser almacenado en una variable
        $data = $this->BuscarInformacion($request);

        //Esta linea session almacenara/guardara la informacion proporcionada al ingresar la fecha y el dni del oficial evaluador (en sus respectivos inputs),
        //esto sera utilizado para crear el reporte de evaluacion correspondiente de la busqueda.
        session(['fecha' => $request->input('fecha'), 'dni-ofi-eva' => $request->input('dni-ofi-eva')]);

        //por ultimo se regresa la informacion a la vista de Reportes para ser ordenados.
        return view('reportes.Reportes', $data);
    }

    public function verReporte(Request $request)
    {
        //*
        abort_if(Gate::denies('Reportes.index'), Response::HTTP_FORBIDDEN);
        
        //Estas lineas re-utiliza la informacion ingresada con anterioridad al realizar la busqueda mediante una fecha y el dni del oficial evaluador.
        $request->merge([
            'fecha' => session('fecha'),
            'dni-ofi-eva' => session('dni-ofi-eva')
        ]);

        //Para ser usada en el metodo BuscarInformacion y realice la misma busqueda que se hizo con el metodo index.
        $data = $this->BuscarInformacion($request);

        $phpWord = new PhpWord();
        //La linea anterior es para crear un nuevo phpWord y esta linea es para el tema de la fecha que este en español.
        Carbon::setLocale('es');

        //Este es el diseño de hoja del documento, en este caso de tipo legal.
        $sectionStyle = [
            'pageSizeW' => \PhpOffice\PhpWord\Shared\Converter::inchToTwip(8.5), // Ancho en pulgadas
            'pageSizeH' => \PhpOffice\PhpWord\Shared\Converter::inchToTwip(14),  // Alto en pulgadas
            'orientation' => 'portrait',  // Puede ser 'portrait' (vertical) o 'landscape' (horizontal)
        ];

        $section = $phpWord->addSection($sectionStyle);

        //... en esta parte se tomara la fecha hora de tegucigalpa para evitar inconveniente por horas de mas o menos
        $fechaActual = Carbon::now('America/Tegucigalpa');
        $fechaActual = Carbon::now()->isoFormat('DD [de] MMMM [del] YYYY');

        //seccion para el header o encabezado del documento...
        $header = $section->addHeader();

        $imageEncabezado = public_path('images/Encabezado.png');
        $header->addImage($imageEncabezado, ['width' => 400, 'height' => 50, 'alignment' => 'center', 'wrappingStyle' => 'behind', 'marginTop' => -40]);
        //... fin de seccion del header o encabezado.
        
        //Estilos tipo letra, tamaño letra, alineamiento, mayuscula y negrita.
        $fontStyle = [
            'name' => 'Times New Roman',
            'size' => 12,
            'lineHeight' => 0.9
        ];
        $fontStyleMayus = [
            'name' => 'Times New Roman',
            'size' => 12,
            'lineHeight' => 0.9,
            'allCaps' => true
        ];
        $fontStylePala = [
            'name' => 'Times New Roman',
            'size' => 12,
            'lineHeight' => 0.9,
            'bold' => true
        ];
        //...Fin de estilos.


        //=============================================CUERPO DEL DOCUMENTO=============================================
        $section->addText('República de Honduras', $fontStyle, ['alignment' => 'center']);
        $section->addText('Secretaría de Seguridad', $fontStyle, ['alignment' => 'center']);
        $section->addText('Dirección General Policía Nacional', $fontStyle, ['alignment' => 'center']);
        $section->addText('Dirección de Planeamiento, Procedimientos Operativos y Mejora Continua', $fontStylePala, ['alignment' => 'center']);
        $section->addTextBreak(1, [], $fontStyle);

        //LUGAR Y FECHA DEL DOCUMENTO
        $section->addText('El Ocotal, F.M.', $fontStyle, ['alignment' => 'right']);
        $section->addText($fechaActual, $fontStyle, ['alignment' => 'right']);
        //ESTA LINEA ES PARA HACER UN SALTO DE LINEA = $section->addTextBreak(1);

        //AQUIEN VA DIRIGIDO
        $section->addText('Señor', $fontStyle, ['alignment' => 'both']);
        $section->addText('Director de Planeamiento, Procedimientos Operativos y Mejora Continua', $fontStyle, ['alignment' => 'both']);
        $section->addText('XXXXXXXX XXXXXXXX', $fontStyle, ['alignment' => 'both']);
        $section->addText('XXXXXXXX XXXXXXXX XXXXXXXX XXXXXXXX', $fontStyle, ['alignment' => 'both']);
        $section->addText('Su Oficina.', $fontStyle, ['alignment' => 'both']);
        $section->addTextBreak(1);

        //PRESENTACION
        $section->addText('Sirva la presente para enviarle un cordial y respetuoso saludo, deseandole el mejor de los éxitos en sus delicadas funciones diarias.', $fontStyle, ['alignment' => 'both']);
        $section->addText('Asi mismo, con todo respeto me dirijo a esa superioridad, a fin de remitir los resultados obtenidos en XXXXXXXX, que se practicó a ' . $data['totalEvaluados'] . ' funcionarios, dirigida a la categoría de XXXXX, realizada en las instalaciones de la Dirección Nacional de Fuerzas Especiales, el día ' . $data['fechaPrueba'] . ' del presente año.', $fontStyle, ['alignment' => 'both']);
        $section->addText('NOTA: Se anexa cuadro con los resultados obtenidos, hojas de evaluación y hojas de grasa corporal de los evaluados.', $fontStyle, ['alignment' => 'both']);
        //$section->addTextBreak(1);

        //EVALUADORES
        $section->addText('COMISIÓN EVALUADORA', $fontStylePala);
        $section->addText('Terna Evaluadora: ' . $data['nombreTerna'], $fontStyleMayus);
        $section->addText('Oficial Evaluador: ' . $data['gradoOficial'] . ' ' . $data['nombreOficial'], $fontStyleMayus);
        foreach ($data['integrantesTerna'] as $index => $integrante) {
            $section->addText('Evaluador ' . ($index + 1) . ':  ' . $integrante['grado'] . ' ' . $integrante['nombre_completo'] , $fontStyleMayus);
        }
        //$section->addTextBreak(1);

        //RESULTADOS
        $section->addText('RESUMEN', $fontStylePala, ['alignment' => 'center']);
        $table2 = $section->addTable(['borderSize' => 6, 'borderColor' => '999999', 'cellMargin' => 80]);
        $table2->addRow();
        $table2->addCell(3500)->addText('Aprobados', $fontStylePala, ['alignment' => 'center']);
        $table2->addCell(3500)->addText('Reprobados', $fontStylePala, ['alignment' => 'center']);
        $table2->addCell(3500)->addText('No Apto', $fontStylePala, ['alignment' => 'center']);
        $table2->addCell(3500)->addText('Exceso de Peso o Grasa', $fontStylePala, ['alignment' => 'center']);
        $table2->addCell(3500)->addText('No se presento', $fontStylePala, ['alignment' => 'center']);
        $table2->addCell(3500)->addText('Total General', $fontStylePala, ['alignment' => 'center']);

        $table2->addRow();
        $table2->addCell(3500)->addText('XX', null, $fontStyle, ['alignment' => 'center']);
        $table2->addCell(3500)->addText('XX', null, $fontStyle, ['alignment' => 'center']);
        $table2->addCell(3500)->addText('XX', null, $fontStyle, ['alignment' => 'center']);
        $table2->addCell(3500)->addText('XX', null, $fontStyle, ['alignment' => 'center']);
        $table2->addCell(3500)->addText('XX', null, $fontStyle, ['alignment' => 'center']);
        $table2->addCell(3500)->addText('XX', null, $fontStyle, ['alignment' => 'center']);
        //ESTAS LINEAS COMENTADAS SON PARA EXTRAER LA INFORMACION TOTALIZADA DE LOS EVALUADOS, SE USARA DESPUES 
        // $table2->addCell(3500)->addText($data['totalEvaluados'], null, $fontStyle);
        // $table2->addCell(3500)->addText($data['totalAprobados'], null, $fontStyle);
        // $table2->addCell(3500)->addText($data['totalReprobados'], null, $fontStyle);
        // $table2->addCell(3500)->addText($data['totalNoEvaluados'], null, $fontStyle);
        // $table2->addCell(3500)->addText($data['totalReprobados'], null, $fontStyle);
        // $table2->addCell(3500)->addText($data['totalNoEvaluados'], null, $fontStyle);
        $section->addTextBreak(1);

        //OBSERVACION Y DESPEDIDA
        $section->addText('OBSERVACIÓN: ', $fontStylePala, ['alignment' => 'both']);
        $section->addText('Sin otro particular, reitero a esa Superioridad mis más altas muestras de Subordinación y respeto.', $fontStyle, ['alignment' => 'both']);
        $section->addTextBreak(1);

        $table = $section->addTable();
        $table->addRow();
        $table->addCell(4000)->addText('DIOS', $fontStylePala, ['align' => 'left']);
        $table->addCell(4000)->addText('PATRIA', $fontStylePala, ['align' => 'center']);
        $table->addCell(4000)->addText('SERVICIO', $fontStylePala, ['align' => 'right']);

        $section->addTextBreak(1);
        $section->addText($data['gradoOficial'], $fontStyleMayus, ['alignment' => 'center']);
        $section->addTextBreak(1);
        $section->addText($data['nombreOficial'], $fontStylePala, ['allCaps' => true, 'alignment' => 'center']);
        $section->addText('JEFE EQUIPO DE EVALUACION FISICA', $fontStyle, ['alignment' => 'center']);
        $section->addPageBreak();

        //SALTO DE PAGINA Y TABLA DE LOS EVALUADOS
        $table = $section->addTable(['borderSize' => 6, 'borderColor' => '999999', 'cellMargin' => 80]);

        $table->addRow();
        $table->addCell(16400, ['gridSpan' => 5])->addText('RESULTADOS OBTENIDOS', $fontStyle, ['alignment' => 'center']);
        $table->addRow();
        $table->addCell(800)->addText('N°', $fontStylePala, ['alignment' => 'center']);
        $table->addCell(3000)->addText('GRADO', $fontStylePala, ['alignment' => 'center']);
        $table->addCell(5000)->addText('NOMBRE EVALUADO', $fontStylePala, ['alignment' => 'center']);
        $table->addCell(3600)->addText('CALIFICACIÓN', $fontStylePala, ['alignment' => 'center']);
        $table->addCell(4000)->addText('OBSERVACIÓN', $fontStylePala, ['alignment' => 'center']);

        $counter = 1;
        foreach ($data['resultados'] as $resultado) {
            $table->addRow();
            $table->addCell(800)->addText($counter, $fontStyle, ['alignment' => 'center']);
            $table->addCell(3000)->addText($resultado->grado, $fontStyle, ['alignment' => 'center']);
            $table->addCell(5000)->addText($resultado->nombre_completo, $fontStyle, ['alignment' => 'center']);
            $table->addCell(3600)->addText($resultado->npesoexc, $fontStyle, ['alignment' => 'center']);
            $table->addCell(4000)->addText($resultado->estado, $fontStyle, ['alignment' => 'center']);
            $counter++;
        }

        //FIRMA DE OFICIAL
        $section->addTextBreak(1);
        $table = $section->addTable();
        $table->addRow();
        $table->addCell(4000)->addText('DIOS', $fontStylePala, ['align' => 'left']);
        $table->addCell(4000)->addText('PATRIA', $fontStylePala, ['align' => 'center']);
        $table->addCell(4000)->addText('SERVICIO', $fontStylePala, ['align' => 'right']);

        $section->addTextBreak(2);
        $section->addText($data['gradoOficial'], $fontStyleMayus, ['alignment' => 'center']);
        $section->addTextBreak(2);
        $section->addText($data['nombreOficial'], $fontStylePala, ['allCaps' => true, 'alignment' => 'center']);
        $section->addText('JEFE EQUIPO DE EVALUACION FISICA', $fontStyle, ['alignment' => 'center']);

        //CREACION Y DESCARGA DEL DOCUMENTO
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $fileName = 'Reporte_Evaluacion_'. $data['fechaPrueba'] . '.docx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $objWriter->save($temp_file);

        return response()->download($temp_file, $fileName)->deleteFileAfterSend(true);
    }

    public function BuscarInformacion(Request $request)
    {

        //Obtener el usuario autenticado
        $user = Auth::user();
        //Ya en esta parte se obtiene los datos ingresados por el usuario que en este caso es la fecha y el dni del oficial evaluador
        $fecha = $request->input('fecha');
        $dniOficial = $request->input('dni-ofi-eva');

        //La fecha se descompone en un rango en especifico (inicio y fin) al igual que se convierte en formato fecha idependiente
        $fechaInicio = Carbon::parse($fecha)->startOfDay();
        $fechaFin = Carbon::parse($fecha)->endOfDay();

        //Si el usuario tiene el permiso acorde a su rol se realizara lo siguiente
        if($user->can('Reportes.index')){
            //Obtendra la informacion de la tabla resultado_pruebas y se usa el join para enlazar/combinar la informacion de esa tabla junto con la tabla
            //evaluados; la informacion que se obtendra es el nombre, apellido y el grado de la tabla evaluados, y se obtendra la informacion de npesoexc
            //(posiblemente sea nota peso exceso) y de estado el cual mostrara si aprobo o no la prueba fisica, de igual forma se obtendra la fecha de la prueba de evaluacion.
            $resultados = DB::table('resultado_pruebas')
                ->join('evaluados', 'resultado_pruebas.id_evaluado', '=', 'evaluados.id')
                ->where('resultado_pruebas.dniOficial', $dniOficial)
                ->whereBetween('resultado_pruebas.created_at', [$fechaInicio, $fechaFin])
                ->select('evaluados.nombre','evaluados.apellido', 'evaluados.grado', 'resultado_pruebas.npesoexc', 'resultado_pruebas.estado','resultado_pruebas.created_at')
                ->orderBy(DB::raw("CAST(REPLACE(npesoexc, '%', '')AS UNSIGNED)"), 'desc')
                ->get()
                //En esta parte se concatenara el nombre y apellido del evaluado para ser mostrado en la tabla.
                ->map(function ($item){
                    $item->nombre_completo = $item->nombre . ' ' . $item->apellido;
                    return $item;
                });
            
            //Si la busqueda resulta vacia se regresara la informacion vacia y desde la vista blade mostrara un mensaje de no se encontro resultados.
            if($resultados->isEmpty()){
                $nombreOficial = "";
                $totalEvaluados = $totalAprobados = $totalReprobados = $totalNoEvaluados = 0;
                $nombreTerna = '';
                $fechaPrueba = "";
                $gradoOficial = "";
                $integrantesTerna = [];
            }else{
                //En esta parte se contara la cantidad de evaluados, cantidad de personal que aprobo la prueba fisica, tambien los que reprobaron y tambien se contara
                //la cantidad de personal que no fue evaluado, en la cual se incluye el personal incapacitado y los que realizaron la prueba por cuestiones legales.
                $totalEvaluados = $resultados->count();
                $totalAprobados = $resultados->where('estado', 'APROBADO')->count();
                $totalReprobados = $resultados->where('estado', 'REPROBADO')->count();
                $totalNoEvaluados = $resultados->whereBetween('estado', ['INCAPACIDAD','LEGAL'])->count();

                //Se obtendra el id del oficial evaluador de la tabla evaluados esto para ser usado...
                $idEvaluador = DB::table('evaluados')
                ->where('dni', $dniOficial)
                ->value('id');

                //... en estas lineas para obtener el nombre de la terna que pertenece dicho oficial, dicho nombre se encuentra en la tabla ternas_evaluadoras.
                $nombreTerna = DB::table('ternas_evaluadoras')
                ->where('OJEE_id', $idEvaluador)
                ->value('descripcion');

                //En esta parte se reutiliza el id del Oficial evaluador para obtener el nombre del mismo asi como su grado policial...
                $evaluado = Evaluado::where('id', $idEvaluador)
                ->select('nombre', 'apellido', 'grado')
                ->first();
                //... y en esta parte concatenara el nombre o mostrarara el espacio vacio si es que se realiza la busqueda o no, para ello se usa el isset; el isset mas que todo es para cuando uno ingresa al modulo
                //sin realizar ninguna busqueda asi que NO BORRAR EL ISSET.
                if(isset($evaluado)){
                    $nombreOficial = $evaluado->nombre . ' ' . $evaluado->apellido;
                    $gradoOficial = $evaluado->grado;
                    $fechaPrueba = Carbon::parse($resultados->first()->created_at)->isoFormat('DD [de] MMMM [del] YYYY');
                } else {
                    $nombreOficial = "";
                    $gradoOficial = "";
                    $fechaPrueba = "";
                }

                //En esta parte del codigo se extraera los id de los diferentes evaluadores de la terna, para ser usada...
                $terna = DB::table('ternas_evaluadoras')
                    ->where('OJEE_id', $idEvaluador)
                    ->select('E1_id', 'E2_id', 'E3_id', 'E4_id')
                    ->first();

                //... en este codigo el cual extraera el nombre, apellido y grado policial los evaluadores de la terna.
                $integrantesTerna = DB::table('evaluados')
                    ->whereIn('id', [$terna->E1_id, $terna->E2_id, $terna->E3_id, $terna->E4_id])
                    ->select('nombre','apellido', 'grado')
                    ->get()
                    ->map(function($item){
                        return [
                            'grado' => $item->grado,
                            'nombre_completo' => $item->nombre . ' ' . $item->apellido
                        ];
                    })->toArray();
            }
        }else{
            $totalEvaluados = $totalAprobados = $totalReprobados = $totalNoEvaluados = 0;
            $nombreTerna = '';
            $gradoOficial = "";
            $resultados = collect();
            $integrantesTerna = [];
        }
        //Por ultimo se regresa toda la informacion procesada en este controller.
        return compact('resultados','totalEvaluados','totalAprobados','totalReprobados','totalNoEvaluados', 'nombreTerna', 'nombreOficial', 'gradoOficial', 'fechaPrueba', 'integrantesTerna');
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
    public function show(ResultadoPrueba $resultadoPrueba)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ResultadoPrueba $resultadoPrueba)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ResultadoPrueba $resultadoPrueba)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ResultadoPrueba $resultadoPrueba)
    {
        //
    }
}
