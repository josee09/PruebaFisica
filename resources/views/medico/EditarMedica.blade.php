@extends('home')

@section('titulo')
    {{-- 21-6-23 creación de Vista para editar nuevas evaluaciones medicas --}}
@stop

@section('contenido')
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2> Formulario de edición | EVALUACIÓN MÉDICA </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form action="{{ route('medica.show', $medico->id) }}" method="POST">
                        {{-- CSRF Token --}}
                        @csrf
                        {{-- DATOS PRINCIPALES --}}
                        <div class="item form-row">
                            {{-- <div class="col-md-3 col-sm-4 form-group"> --}}
                            <div class="col-md-3 mb-1">
                                <label>No. Identidad:<span class="required">*</span></label>
                                <input id="dni" name="dni" type="text" class="form-control" list="dni"
                                       value="{{ $medico->evaluado->dni }}" readonly>
                            </div>
                            {{-- </div> --}}
                            {{-- <div class="col-md-3 col-sm-4 form-group"> --}}
                            <div class="col-md-3 mb-1">
                                <label>Nombre:<span class="required">*</span></label>
                                <input id="nombre" name="nombre" type="text" class="form-control" list="dni"
                                       value="{{ $medico->evaluado->nombre }} {{ $medico->evaluado->apellido }}"
                                       readonly>
                            </div>
                            {{-- </div> --}}
                            {{-- <div class="col-md-3 col-sm-4 form-group"> --}}
                            <div class="col-md-3 mb-2">
                                <label class="col-form-label">Periodo: <span class="required">*</span></label>
                                <div>
                                    <div class="form-check form-check-inline ">
                                        <input class="form-control form-check-input " type="radio" name="periodo"
                                               value="ORDINARIO"
                                               {{ old('periodo') == 'ORDINARIO' ? 'checked' : ''}} checked><span>Ordinario</span>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-control form-check-input" type="radio" name="periodo"
                                               value="EXTRAORDINARIO" {{ old('periodo') == 'EXTRAORDINARIO' ? 'checked' : ''}}><span>Extraordinario</span>
                                    </div>
                                </div>
                            </div>
                            {{-- </div> --}}
                        </div>
                        <div class="ln_solid"></div>
                        {{-- FIN DATOS PRINCIPALES --}}
                        {{-- DATOS DE EVALUACION --}}
                        <div class="item form-row">
                            <div class="cold-md-12 col-sm-12">
                                <div class="col-md-4 mb-2">
                                    <label>Frecuencia cardíaca (Pulso):</label>
                                    <input id="pulso" name="pulso" type="text" onkeypress="validarNumeros(event)"
                                           class="form-control" title="Número de latidos del corazón por minuto"
                                           maxlength="3" minlength="2" value="{{ $medico->pulso}}">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label>Oximetría:</label>
                                    <input id="saturacion" name="saturacion" type="text"
                                           onkeypress="validarSaturacion(event)" class="form-control"
                                           title="Ejemplo: 85%" maxlength="4" minlength="2"
                                           value="{{ $medico->saturacion }}">
                                </div>

                                <div class="col-md-4 mb-2">
                                    <label>Presión arterial:<span class="required">*</span></label>
                                    <input id="Presion" name="Presion" type="text" onkeypress="validarPresion(event)"
                                           class="form-control" title="Ejemplo: 120/80" maxlength="7" minlength="2"
                                           value="{{ $medico->presion }}" required>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label>Presión arterial 2:</label>
                                    <input id="Presion2" name="Presion2" type="text" onkeypress="validarPresion(event)"
                                           class="form-control" placeholder="Ejemplo: 120/80" maxlength="7"
                                           minlength="2" value="{{ $medico->presion2 }}">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label>Presión arterial 3:</label>
                                    <input id="Presion3" name="Presion3" type="text" onkeypress="validarPresion(event)"
                                           class="form-control" placeholder="Ejemplo: 120/80" maxlength="7"
                                           minlength="2" value="{{ $medico->presion3 }}">
                                </div>
                            </div>
                        </div>
                        <div class="item form-row">
                            <div class="cold-md-12 col-sm-12">
                                <div class="col-md-6 ">
                                    <center>
                                        <br>
                                        <legend>Medidas Principales:</legend>
                                    </center>

                                    <div class="col-md-6 mb-2">
                                        <label>Altura en CM:<span class="required">*</span></label>
                                        <input id="Altura" name="Altura" type="text" onkeypress="validarNumeros(event)"
                                               class="form-control @error('Altura') is-invalid @enderror"
                                               title="Altura min:141', 'max:203" maxlength="3" minlength="3"
                                               value="{{$medico->altura * 100}}" required>
                                        @error('Altura')
                                        <span class="invalid-feedback" role="alert">
                                  <i style="color: red">{{ $message }}</i>
                                </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label>Peso en LB:<span class="required">*</span></label>
                                        <input id="Peso" name="Peso" type="text" onkeypress="validarNumeros(event)"
                                               class="form-control" maxlength="3" minlength="2"
                                               value="{{$medico->pesoreal}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <center>
                                        <br>
                                        <legend>Medidas Abdomen y Cuello:</legend>
                                    </center>

                                    <div class="col-md-6 mb-2">
                                        <label>Medida de Cuello en CM:<span class="required">*</span></label>
                                        <input id="Cuello" name="Cuello" type="text"
                                               class="form-control @error('Cuello') is-invalid @enderror" maxlength="5"
                                               minlength="1" value="{{$medico->cuello}}" required>
                                        @error('Cuello')
                                        <span class="invalid-feedback" role="alert">
                                    <i style="color: red">{{ $message }}</i>
                                </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <label>Medida de Abdomen en CM:<span class="required">*</span></label>
                                        <input id="Abdomen" name="Abdomen" type="text"
                                               class="form-control @error('Abdomen') is-invalid @enderror" maxlength="5"
                                               minlength="1" value="{{$medico->abdomen}}" required>
                                        @error('Abdomen')
                                        <span class="invalid-feedback" role="alert">
                                    <i style="color: red">{{ $message }}</i>
                                </span>
                                        @enderror
                                    </div>


                                </div>
                            </div>
                        </div>
                </div>
                {{-- FIN DATOS DE EVALUACION --}}
                <div class="ln_solid"></div>

                <div class="item form-row">
                    <div class="cold-md-6 col-sm-12">
                        <center>
                            <legend>Médico Evaluador:</legend>
                        </center>
                        <div class="col-md-4 mb-2">
                            <label>Nombre: <span class="required">*</span></label>
                            <input id="Medico" name="Medico" type="text" class="form-control"
                                   onkeypress="validarLetras(event)" style="text-transform: uppercase;" maxlength="30"
                                   minlength="3" value="{{ $medico->medico }}" readonly>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>Grado policial: <span class="required">*</span></label>
                            <input id="grado" name="grado" type="text" class="form-control"
                                   onkeypress="validarLetras(event)" style="text-transform: uppercase;" maxlength="30"
                                   minlength="3" value="{{ $medico->grado_policial }}" readonly>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>Lugar: <span class="required">*</span></label>
                            <div>
                                <input id="lugar" name="lugar" type="text" class="form-control"
                                       onkeypress="validarLetras(event)" style="text-transform: uppercase;"
                                       maxlength="30" minlength="3" value="{{ $medico->lugar }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-2 mb-2">
                            <label>Equipo Evaluador:</label>
                            <input type="text" maxlength="3" minlength="1" onkeypress="validarNumeros(event)"
                                   class="form-control" value="{{ $medico->equipo }}" list="equipo" name="equipo"
                                   readonly>
                        </div>
                    </div>
                </div>
                {{-- BOTONES --}}
                <div class="ln_solid"></div>
                <div class="item form-row">
                    <div class="col-md-12 text-right">
                        <a type="button" class="btn btn-danger" href="{{route('medica.index')}}">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Evaluar</button>
                    </div>
                </div>
                {{-- FIN BOTONES --}}
                </form>
            </div>
        </div>
    </div>
@stop
