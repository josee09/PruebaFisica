@extends('home')
@section('titulo')
    {{-- 8-6-23 creación de Vista para evaluación fisica --}}
@stop
@section('contenido')
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2> Evaluación | FÍSICA </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form enctype="multipart/form-data" id="demo-form2" method="POST"
                          action="{{ route('fisica.store') }}"
                          data-parsley-validate class="form-horizontal form-label-left">
                        @csrf
                        <div>
                            @if ($id_alterno)
                                <input type="hidden" name="id_alterno" id="id_alterno" value="{{ $id_alterno }}">
                            @endif
                            <input type="hidden" name="id_principal" id="id_principal" value="{{ $principal->id }}">
                        </div>
                        {{-- OPCIONES DE EVALUACION --}}
                        <div class="item form-row mb-3">
                            <div class="col-md-3">
                                <label class="col-form-label">Evaluación:<span class="required">*</span></label>
                                <div>
                                    {{$principal->evaluacion}}
                                    <input type="hidden" name="evaluacion" id="evaluacion"
                                           value="{{ $principal->evaluacion }}">
                                    {{--                                    <div class="form-check form-check-inline">--}}
                                    {{--                                        <input class="form-control form-check-input" type="radio" name="evaluacion"--}}
                                    {{--                                               value="DIAGNÓSTICA" checked><span>Diagnóstica</span>--}}
                                    {{--                                    </div>--}}
                                    {{--                                    <div class="form-check form-check-inline">--}}
                                    {{--                                        <input class="form-control form-check-input" type="radio" name="evaluacion"--}}
                                    {{--                                               value="ACUMULATIVA"><span>Acumulativa</span>--}}
                                    {{--                                    </div>--}}
                                    {{--                                    <div class="form-check form-check-inline">--}}
                                    {{--                                        <input class="form-control form-check-input" type="radio" name="evaluacion"--}}
                                    {{--                                               value="ASCENSO"><span>Ascenso</span>--}}
                                    {{--                                    </div>--}}
                                </div>
                            </div>
                            <div class="col-md-3 ">
                                <label class="col-form-label">Periodo: <span class="required">*</span></label>
                                <div>
                                    <div class="form-check form-check-inline ">
                                        <input class="form-control form-check-input" type="radio" name="periodo"
                                               value="Ordinario" checked><span>Ordinario</span>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-control form-check-input" type="radio" name="periodo"
                                               value="Extraordinario"><span>Extraordinario</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label class="col-form-label">Año correspondiente: <span
                                        class="required">*</span></label>
                                <input name="fecha" class="form-control" placeholder="YYYY" type="text"
                                       pattern="[1-9][0-9]{3}" maxlength="4" minlength="4"
                                       onkeypress="validarNumeros(event)"
                                       min="1950" max="{{ date('Y') }}" required value="{{ old('fecha') }}">
                            </div>

                        </div>
                        <div class="ln_solid"></div>
                        {{-- FIN OPCIONES DE EVALUACION --}}
                        {{-- MOSTRAR DATOS PERSONALES --}}
                        <div class="item form-row mb-3">
                            <div class="col-md-2 mb-2">
                                <label>No. de identidad:</label>
                                <input id="dni" name="dni" type="text" readonly class="form-control"
                                       value="{{ $evaluado->dni }}">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Nombre: </label>
                                <div>
                                    <input id="apellido" name="apellido" type="text" readonly class="form-control"
                                           value="{{ $evaluado->nombre . ' ' . $evaluado->apellido }}">
                                </div>
                            </div>
                            <div class="col-md-1 mb-2">
                                <label>Edad: </label>
                                <div>
                                    <input id="edad" name="edad" type="text" readonly class="form-control"
                                           value="{{ old('fechanac') ?? \Carbon\Carbon::parse($evaluado->fechanac)->age }}">
                                </div>
                            </div>
                            <div class="col-md-1 mb-2">
                                <label>Sexo: </label>
                                <div>
                                    <input id="sexo" name="sexo" type="text" readonly class="form-control"
                                           value="{{ $evaluado->sexo }}">
                                </div>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label>Categoría: </label>
                                <div>
                                    <input id="categoria" name="categoria" type="text" readonly class="form-control"
                                           value="{{ $evaluado->categoria }}">
                                </div>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label>Grado: </label>
                                <div>
                                    <input id="grado" name="grado" type="text" readonly class="form-control"
                                           value="{{ $evaluado->grado }}">
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                        </div>

                        {{-- FIN MOSTRAR DATOS PERSONALES --}}

                        {{-- EVENTOS PRINCIPALES --}}
                        <div class="ln_solid"></div>
                        <center>
                            <legend>Eventos Principales:</legend>
                        </center>
                        <div class="item form-row mb-3">
                            <div class="col-md-3 mb-2">
                                <label for="pechada">Flexiones de brazo:</label>
                                <input type="text" name="pechada" class="form-control" id="pechada"
                                       value="{{ $principal->pechada }}" style="text-align:center;" readonly="readonly">
                            </div>
                            {{-- NOTA --}}
                            <div class="col-md-1 mb-2">
                                <label>%</label>
                                <input type="text" name="npechada" class="form-control" id="npechada"
                                       value="{{ $npechada }}" readonly="readonly"
                                       style="text-align:center; color: {{ $npechada >= 70 || $npechada === null ? '' : '#ffffff' }}; background-color: {{ $npechada >= 70 || $npechada === null ? '#A8EBA5' : '#DE4B4B' }};">
                            </div>

                            <div class="col-md-3 mb-2">
                                <label>Flexiones de abdomen:</label>
                                <input type="text" name="abdominal" class="form-control" id="abdominal"
                                       value="{{ $principal->abdominal }}" style="text-align:center;"
                                       readonly="readonly">
                            </div>
                            {{-- NOTA --}}
                            <div class="col-md-1 mb-2">
                                <label>%</label>
                                <input type="text" name="nabdominal" class="form-control" id="nabdominal"
                                       value="{{ $nabdominal }}" readonly="readonly"
                                       style="text-align:center; color: {{ $nabdominal >= 70 || $nabdominal === null ? '' : '#ffffff' }}; background-color: {{ $nabdominal >= 70 || $nabdominal === null ? '#A8EBA5' : '#DE4B4B' }};">
                            </div>

                            <div class="col-md-3 mb-2">
                                <label>Carrera 3.2 KM</label>
                                <input type="text" name="carrera" class="form-control" id="carrera"
                                       value="{{ $principal->carrera }}" style="text-align:center;" readonly="readonly">
                            </div>
                            {{-- NOTA --}}
                            <div class="col-md-1 mb-2">
                                <label>%</label>
                                <input type="text" name="ncarrera" class="form-control" id="ncarrera"
                                       value="{{ $ncarrera }}" readonly="readonly"
                                       style="text-align:center; color: {{ $ncarrera >= 70 || $ncarrera === null ? '' : '#ffffff' }}; background-color: {{ $ncarrera >= 70 || $ncarrera === null ? '#A8EBA5' : '#DE4B4B' }};">
                            </div>
                        </div>
                        <br>

                        {{-- EVENTOS ALTERNOS --}}
                        <center>
                            <legend>Eventos Alternos:</legend>
                        </center>
                        <div class=" item form-row mb-3">
                            <div class="col-md-2 mb-2">
                                <label>Natación:</label>
                                <input type="text" name="natacion" class="form-control" id="natacion"
                                       value="{{ $natacion }}" style="text-align:center;" readonly="readonly">
                            </div>
                            {{-- NOTA --}}
                            <div class="col-md-1 mb-2">
                                <label for="nnatacion">%</label>
                                <input type="text" name="nnatacion" class="form-control" id="nnatacion"
                                       readonly="readonly"
                                       value="{{ $nnatacion }}"
                                       style="text-align:center; color: {{ $nnatacion >= 70 || $nnatacion === null ? '' : '#ffffff' }}; background-color: {{ $nnatacion >= 70 || $nnatacion === null ? '#A8EBA5' : '#DE4B4B' }};">
                            </div>

                            <div class="col-md-2 mb-2">
                                <label>Caminata 4,8000 mts:</label>
                                <input type="text" name="caminata" class="form-control" id="caminata"
                                       value="{{ $caminata }}" style="text-align:center;" readonly="readonly">
                            </div>
                            {{-- NOTA --}}
                            <div class="col-md-1 mb-2">
                                <label for="ncaminata">%</label>
                                <input type="text" name="ncaminata" class="form-control" id="ncaminata"
                                       value="{{ $ncaminata }}" readonly="readonly"
                                       style="text-align:center; color: {{ $ncaminata >= 70 || $ncaminata === null ? '' : '#ffffff' }}; background-color: {{ $ncaminata >= 70 || $ncaminata === null ? '#A8EBA5' : '#DE4B4B' }};">
                            </div>

                            <div class="col-md-2 mb-2">
                                <label>Ciclismo 10 km:</label>
                                <input type="text" name="ciclismo" class="form-control" id="ciclismo"
                                       value="{{ $ciclismo }}" style="text-align:center;" readonly="readonly">
                            </div>
                            {{-- NOTA --}}
                            <div class="col-md-1 mb-2">
                                <label>%</label>
                                <input type="text" name="nciclismo" class="form-control" id="nciclismo"
                                       value="{{ $nciclismo }}"
                                       style="text-align:center; color: {{ $nciclismo >= 70 || $nciclismo === null ? '' : '#ffffff' }}; background-color: {{ $nciclismo >= 70 || $nciclismo === null ? '#A8EBA5' : '#DE4B4B' }};"
                                       readonly="readonly">
                            </div>

                            <div class="col-md-2 mb-2">
                                <label>Barra:</label>
                                <input type="text" name="barra" class="form-control" id="barra" value="{{ $barra }}"
                                       style="text-align:center;" readonly="readonly">
                            </div>
                            {{-- NOTA --}}
                            <div class="col-md-1 mb-2">
                                <label>%</label>
                                <input type="text" name="nbarra" class="form-control" id="nbarra" value="{{ $nbarra }}"
                                       style="text-align:center; color: {{ $nbarra >= 70 || $nbarra === null ? '' : '#ffffff' }}; background-color: {{ $nbarra >= 70 || $nbarra === null ? '#A8EBA5' : '#DE4B4B' }};"
                                       readonly="readonly">
                            </div>
                        </div>
                        {{-- FIN EVENTOS ALTERNOS --}}
                        {{-- RESULTADO --}}


                        <div class="ln_solid"></div>
                        <center>
                            <legend>Resultados:</legend>
                        </center>
                        <div class=" item form-row mb-3">
                            <div class="col-md-3 mb-2">
                                <label>Nota obtenida</label>
                                <input type="text" name="npromedio" class="form-control" id="npromedio"
                                       value="{{ $npromedio }}%" readonly="readonly" style="text-align: center;">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>Exceso de peso</label>
                                {{--                                @if ($medico->exceso <= 0)--}}
                                {{--                                    <input type="text" name="pesoexc" class="form-control"--}}
                                {{--                                           id="pesoexc" value="Lb.{{ $medico->exceso }}" readonly="readonly"--}}
                                {{--                                           style="text-align: center;">--}}
                                {{--                                @else--}}
                                {{--                                    <input type="text" name="pesoexc" class="form-control" id="pesoexc"--}}
                                {{--                                           value="Lb. {{ $medico->exceso }}" readonly="readonly"--}}
                                {{--                                           style="text-align: center;">--}}
                                {{--                                @endif--}}
                                @if ($pesoexc <= 0)
                                    <input type="text" name="pesoexc" class="form-control"
                                           id="pesoexc" value="Lb.{{ $pesoexc }}" readonly="readonly"
                                           style="text-align: center;">
                                @else
                                    <input type="text" name="pesoexc" class="form-control" id="pesoexc"
                                           value="Lb. {{ $pesoexc }}" readonly="readonly"
                                           style="text-align: center;">
                                @endif
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="npesoexc">Nota final:</label>
                                <input type="text" name="npesoexc" class="form-control" id="npesoexc"
                                       value="{{ $npesoexc }}{{is_numeric($npesoexc)?'%':''}}" readonly="readonly"
                                       style="text-align: center;">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>Estado:<span class="required"></span></label>
                                <input type="text" name="estado" class="form-control" id="estado"
                                       value="{{$principal->tipo_evento != 'NORMAL' ? $principal->tipo_evento : $estado }}" readonly="readonly"
                                       style="text-align: center; color: {{ $npesoexc >= 70 && $npesoexc != 'REPROBADO' ? '' : '#ffffff' }}; background-color: {{ $npesoexc >= 70 && $npesoexc != 'REPROBADO' ? '#A8EBA5' : '#DE4B4B' }}">

                            </div>
                            {{-- OBS --}}
                            <div class="col-md-12 mb-2">
                                <label class="control-label col-md-12 col-sm-12 ">Observaciones: (en caso de
                                    prescripción
                                    médica indique el caso y adjunte documentación.)</label>
                                @php
                                    $obs = '';
                                    $obs .= $medico->observaciones."\n";
                                    if($principal->tipo_evento == 'INCAPACIDAD'){
                                                $obs .= 'INCAPACIDAD MEDICA'."\n";
                                    }
                                    elseif($principal->tipo_evento == 'LEGAL'){
                                           $obs .=  'SOLICITUD DE NOTA MÍNIMA POR RESOLUCIÓN'."\n";
                                    }
                                @endphp
                                <textarea class="resizable_textarea form-control" style="height: 60px;" name="obs"
                                          id="obs">{{ $obs }}
                                </textarea>
                            </div>
                            <div class="col-md-10 mb-2">
                                <input type="file" accept=".pdf" data-role="magic-overlay" data-target="#pictureBtn"
                                       data-edit="insertImage" name="doc_obs" id="doc_obs">
                            </div>
                        </div>


                        {{-- FIN RESULTADO --}}

                        {{-- EVALUADORES --}}
                        <div class="ln_solid"></div>
                        <center>
                            <legend>Evaluadores</legend>
                        </center>
                        <div class="ln_solid"></div>
                        <div>
                            <div class="form-group row">
                                <label for="terna" class="col-sm-3 col-form-label">Seleccione Terna Evaluadora: </label>
                                <div class="col-sm-9">
                                    <select id="terna" class="form-control">
                                        <option selected>Seleccione Terna...</option>
                                        @foreach ($ternasEvaluadoras as $terna)
                                            <option value="{{$terna->id}}">{{$terna->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="item form-row mb-3">
                            <div class="col-md-3 mb-2">
                                <label>Evaluador N°.1:<span class="required">*</span></label>
                                <input type="text" onkeypress="validarLetras(event)" style="text-transform: uppercase;"
                                       maxlength="40" minlength="3" class="form-control" title="Ingrese el evaluador 1"
                                       name="evaluador1" id="evaluador1" value="{{old('evaluador1')}}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>GRADO N°.1:<span class="required">*</span></label>
                                <input type="text" onkeypress="validarLetras(event)" style="text-transform: uppercase;"
                                       maxlength="40" minlength="3" class="form-control" title="Ingrese el grado "
                                       name="grado1" id="grado1" value="{{old('grado1')}}">
                            </div>

                            <div class="col-md-3 mb-2">
                                <label>Evaluador N°.2:</label>
                                <input type="text" onkeypress="validarLetras(event)" style="text-transform: uppercase;"
                                       maxlength="40" minlength="3" class="form-control" title="Ingrese el evaluador 2"
                                       name="evaluador2" id="evaluador2" value="{{old('evaluador2')}}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>GRADO N°.2:<span class="required">*</span></label>
                                <input type="text" onkeypress="validarLetras(event)" style="text-transform: uppercase;"
                                       maxlength="40" minlength="3" class="form-control" title="Ingrese el grado "
                                       name="grado2" id="grado2" value="{{old('grado2')}}">
                            </div>
                        </div>

                        <div class="item form-row mb-3">
                            <div class="col-md-3 mb-2">
                                <label>Evaluador N°.3:</label>
                                <input type="text" onkeypress="validarLetras(event)" style="text-transform: uppercase;"
                                       maxlength="40" minlength="3" class="form-control" title="Ingrese el evaluador 3"
                                       name="evaluador3" id="evaluador3" value="{{ old('evaluador3') }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>GRADO N°.3:<span class="required">*</span></label>
                                <input type="text" onkeypress="validarLetras(event)" style="text-transform: uppercase;"
                                       maxlength="40" minlength="3" class="form-control" title="Ingrese el grado "
                                       name="grado3" id="grado3" value="{{old('grado3')}}">
                            </div>

                            <div class="col-md-3 mb-2">
                                <label>Evaluador N°.4:</label>
                                <input type="text" onkeypress="validarLetras(event)" style="text-transform: uppercase;"
                                       maxlength="40" minlength="3" class="form-control" title="Ingrese el evaluador 4"
                                       name="evaluador4" id="evaluador4" value="{{ old('evaluador4') }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>GRADO N°.4:<span class="required">*</span></label>
                                <input type="text" onkeypress="validarLetras(event)" style="text-transform: uppercase;"
                                       maxlength="40" minlength="3" class="form-control" title="Ingrese el grado "
                                       name="grado4" id="grado4" value="{{old('grado4')}}">
                            </div>
                        </div>

                        {{-- agregar select de rango --}}
                        <div class="col-md-3 mb-2">
                            <label>Oficial Jefe:<span class="required">*</span></label>
                            <input type="text" onkeypress="validarLetras(event)" style="text-transform: uppercase;"
                                   maxlength="40" minlength="3" class="form-control" title="Ingrese su oficial jefe"
                                   name="oficialjefe" id="oficialjefe" value="{{ old('oficialjefe') }}" required>
                        </div>

                        <div class="col-md-3 mb-2">
                            <label>GRADO Oficial Jefe:<span class="required">*</span></label>
                            <input type="text" onkeypress="validarLetras(event)" style="text-transform: uppercase;"
                                   maxlength="40" minlength="3" class="form-control" title="Ingrese el grado "
                                   name="grado5" id="grado5" value="{{old('grado5')}}">
                        </div>
                        {{-- NO BORRAR ESTE DIV A MENOS QUE ENCUENTREN OTRA FORMA HACER QUE FUNCIONE--}}
                        <div>
                            <input type="text" name="dniOficial" id="dniOficial" value="{{'dniOficial'}}" style="display: none">
                        </div>
                </div>
                {{-- FIN EVALUADORES --}}

                {{-- BOTONES --}}
                <div class="ln_solid"></div>
                <div class=" item form-row mb-3">
                    <div class="col-md-12 text-right">
                        <a type="button" class="btn btn-danger" href="{{ route('registro.registro') }}">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
                {{-- FIN BOTONES --}}
                </form>
            </div>
        </div>
    </div>
    </div>
    <script>
        document.getElementById('terna').addEventListener("change", async function (e) {
            console.log('terna', e.target.value)
            e.preventDefault();
            var dni = e.target.value;
            var token = '{{csrf_token()}}'; // Supongamos que esta función obtiene el token de alguna manera
            var data = {id: dni, _token: token};
            try {
                var response = await fetch("{{route('terna-evaluadora.search')}}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(data)
                });
                var responseData = await response.json();
                console.log(responseData)
                if (responseData.length === 0) {
                    alert("Terna no encontrada");
                } else {
                    document.getElementById('evaluador1').value = responseData[0].evaluador1.nombre + ' ' + responseData[0].evaluador1.apellido;
                    document.getElementById('grado1').value = responseData[0].evaluador1.grado;
                    document.getElementById('evaluador2').value = responseData[0].evaluador2.nombre + ' ' + responseData[0].evaluador2.apellido;
                    document.getElementById('grado2').value = responseData[0].evaluador2.grado;
                    document.getElementById('evaluador3').value = (responseData[0].evaluador3?.nombre ?? '') + ' ' + (responseData[0].evaluador3?.apellido ?? '' );
                    document.getElementById('grado3').value = responseData[0].evaluador3?.grado ?? '' ;
                    document.getElementById('evaluador4').value = (responseData[0].evaluador4?.nombre ?? '') + ' ' + (responseData[0].evaluador4?.apellido ?? '') ;
                    document.getElementById('grado4').value = responseData[0].evaluador4?.grado ?? '' ;
                    document.getElementById('oficialjefe').value = responseData[0].evaluador_jefe.nombre + ' ' + responseData[0].evaluador_jefe.apellido;
                    document.getElementById('grado5').value = responseData[0].evaluador_jefe.grado;
                    document.getElementById('dniOficial').value = responseData[0].evaluador_jefe.dni;
                }

            } catch (error) {
                console.error("Error al realizar la petición:", error);
            }
        });
    </script>
@stop
