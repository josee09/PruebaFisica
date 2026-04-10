@extends('home')
@section('titulo')
    {{-- 21-6-23 creación de Vista para Crear nuevas evaluaciones medicas --}}
@stop

@section('contenido')
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    </head>

    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2> Formulario de registro | EVALUACIÓN MÉDICA</h2>
                    <div class="clearfix"></div>
                </div>

                <form id="demo-form2"
                      action="{{ route('medica.show') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      data-parsley-validate
                      class="form-horizontal form-label-left">

                    <div class="x_content">
                        @csrf

                        <div class="item form-group align-items-end d-flex">
                            <div class="col-md-2 mb-3">
                                <label>DNI del evaluado:</label>
                                <input type="text"
                                       maxlength="13"
                                       minlength="1"
                                       placeholder="Ingrese DNI del evaluado"
                                       onkeypress="validarNumeros(event)"
                                       class="form-control @error('dni') is-invalid @enderror"
                                       required
                                       name="dni"
                                       id="dni"
                                       value="{{ old('dni') }}">

                                @error('dni')
                                <span class="invalid-feedback" role="alert">
                                    <i style="color:red">{{ $message }}</i>
                                </span>
                                @enderror
                            </div>

                            <div class="col-md-1 mb-3 ">
                                <button type="button" class="btn btn-info mb-0" name="btnDniEvaluado" id="btnDniEvaluado">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>

                            <div class="col-md-6 mb-3 ">
                                <label>Evaluado:</label>

                                {{-- Visible --}}
                                <input readonly
                                       id="nomEvaluado"
                                       type="text"
                                       style="text-transform: uppercase;"
                                       maxlength="60"
                                       class="form-control"
                                       value="{{ old('nomEvaluadoHidden') }}">

                                {{-- ID del evaluado (NO es DNI, es el id de la tabla evaluados) --}}
                                <input type="hidden"
                                       name="dniEvaluado"
                                       id="dniEvaluado"
                                       value="{{ old('dniEvaluado') }}">

                                {{-- Nombre persistente --}}
                                <input type="hidden"
                                       name="nomEvaluadoHidden"
                                       id="nomEvaluadoHidden"
                                       value="{{ old('nomEvaluadoHidden') }}">

                                @error('dniEvaluado')
                                <span class="invalid-feedback d-block" role="alert">
                                    <i style="color:red">{{ $message }}</i>
                                </span>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-2">
                                <label class="col-form-label">Periodo: <span class="required">*</span></label>
                                <div>
                                    <div class="form-check form-check-inline ">
                                        <input class="form-control form-check-input"
                                               type="radio"
                                               name="periodo"
                                               value="Ordinario"
                                               {{ old('periodo', 'Ordinario') == 'Ordinario' ? 'checked' : '' }}>
                                        <span>Ordinario</span>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-control form-check-input"
                                               type="radio"
                                               name="periodo"
                                               value="Extraordinario"
                                               {{ old('periodo', 'Ordinario') == 'Extraordinario' ? 'checked' : '' }}>
                                        <span>Extraordinario</span>
                                    </div>
                                </div>

                                @error('periodo')
                                <small style="color:red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        {{-- DATOS PRINCIPALES --}}
                        <div class="ln_solid"></div>
                        {{-- FIN DATOS PRINCIPALES --}}

                        {{-- DATOS DE EVALUACION --}}
                        <div class="item form-row">
                            <div class="cold-md-12 col-sm-12">
                                <div class="col-md-4 mb-2">
                                    <label>Frecuencia cardíaca (Pulso):</label>
                                    <input id="pulso" name="pulso" type="text"
                                           onkeypress="validarNumeros(event)"
                                           class="form-control @error('pulso') is-invalid @enderror"
                                           placeholder="Número de latidos del corazón por minuto"
                                           maxlength="3" minlength="2"
                                           value="{{ old('pulso') }}">

                                    @error('pulso')
                                    <small style="color:red">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-2">
                                    <label>Oximetría:</label>
                                    <input id="saturacion" name="saturacion" type="text"
                                           onkeypress="validarSaturacion(event)"
                                           class="form-control @error('saturacion') is-invalid @enderror"
                                           placeholder="Ejemplo: 85%" maxlength="4" minlength="2"
                                           value="{{ old('saturacion') }}">

                                    @error('saturacion')
                                    <small style="color:red">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-2">
                                    <label>Presión arterial 1:<span class="required">*</span></label>
                                    <input id="Presion" name="Presion" type="text"
                                           onkeypress="validarPresion(event)"
                                           class="form-control @error('Presion') is-invalid @enderror"
                                           placeholder="Ejemplo: 120/80" maxlength="7" minlength="2"
                                           value="{{ old('Presion') }}" required>

                                    @error('Presion')
                                    <small style="color:red">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-2">
                                    <label>Presión arterial 2:</label>
                                    <input id="Presion2" name="Presion2" type="text"
                                           onkeypress="validarPresion(event)"
                                           class="form-control @error('Presion2') is-invalid @enderror"
                                           placeholder="Ejemplo: 120/80" maxlength="7" minlength="2"
                                           value="{{ old('Presion2') }}">
                                    @error('Presion2')
                                    <small style="color:red">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-2">
                                    <label>Presión arterial 3:</label>
                                    <input id="Presion3" name="Presion3" type="text"
                                           onkeypress="validarPresion(event)"
                                           class="form-control @error('Presion3') is-invalid @enderror"
                                           placeholder="Ejemplo: 120/80" maxlength="7" minlength="2"
                                           value="{{ old('Presion3') }}">
                                    @error('Presion3')
                                    <small style="color:red">{{ $message }}</small>
                                    @enderror
                                </div>
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
                                    <input id="Altura" name="Altura" type="text"
                                           onkeypress="validarNumeros(event)"
                                           class="form-control @error('Altura') is-invalid @enderror"
                                           maxlength="3" minlength="3"
                                           value="{{ old('Altura') }}" required>

                                    @error('Altura')
                                    <span class="invalid-feedback" role="alert">
                                        <i style="color: red">{{ $message }}</i>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-2">
                                    <label>Peso en LB:<span class="required">*</span></label>
                                    <input id="Peso" name="Peso" type="text"
                                           onkeypress="validarNumeros(event)"
                                           class="form-control @error('Peso') is-invalid @enderror"
                                           maxlength="3" minlength="2"
                                           value="{{ old('Peso') }}" required>

                                    @error('Peso')
                                    <small style="color:red">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <center>
                                    <br>
                                    <legend>Medidas Abdomen y Cuello:</legend>
                                </center>

                                <div class="col-md-6 mb-2">
                                    <label>Medida de Cuello en Pulg:<span class="required">*</span></label>
                                    <input id="Cuello" name="Cuello" type="text"
                                           class="form-control @error('Cuello') is-invalid @enderror"
                                           maxlength="5" minlength="1"
                                           value="{{ old('Cuello') }}" required>

                                    @error('Cuello')
                                    <span class="invalid-feedback" role="alert">
                                        <i style="color: red">{{ $message }}</i>
                                    </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-2">
                                    <label>Medida de Abdomen en Pulg:<span class="required">*</span></label>
                                    <input id="Abdomen" name="Abdomen" type="text"
                                           class="form-control @error('Abdomen') is-invalid @enderror"
                                           maxlength="5" minlength="1"
                                           value="{{ old('Abdomen') }}" required>

                                    @error('Abdomen')
                                    <span class="invalid-feedback" role="alert">
                                        <i style="color: red">{{ $message }}</i>
                                    </span>
                                    @enderror
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
                                       style="text-transform: uppercase;"
                                       maxlength="30" minlength="3"
                                       value="{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}"
                                       readonly>
                            </div>

                            <div class="col-md-3 mb-2">
                                <label>Grado policial: <span class="required">*</span></label>
                                <input id="grado" name="grado" type="text" class="form-control"
                                       style="text-transform: uppercase;"
                                       maxlength="30" minlength="3"
                                       value="{{ auth()->user()->grado }}" readonly>
                            </div>

                            <div class="col-md-3 mb-2">
                                <div class="control-group">
                                    <label for="select-console">Lugar de Evaluacion: <span class="required">*</span></label>

                                    <select id="select-console"
                                            class="demo-consoles"
                                            placeholder="Seleccione lugar..."></select>

                                    <input type="hidden" id="lugar" name="lugar" value="{{ old('lugar') }}">

                                    @error('lugar')
                                    <small style="color:red">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-2 mb-2">
                                <label>Equipo Evaluador:</label>
                                <input type="text"
                                       maxlength="3" minlength="1"
                                       onkeypress="validarNumeros(event)"
                                       class="form-control @error('equipo') is-invalid @enderror"
                                       value="{{ old('equipo') }}"
                                       list="equipo"
                                       name="equipo">
                                @error('equipo')
                                <small style="color:red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- BOTONES --}}
                    <div class="ln_solid"></div>
                    <div class="item form-row">
                        <div class="col-md-12 text-right">
                            <a type="button" class="btn btn-danger" href="{{ route('medica.index') }}">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Evaluar</button>
                        </div>
                    </div>
                    {{-- FIN BOTONES --}}
                </form>
            </div>
        </div>
    </div>

    <script>
        var eventHandler = function (name) {
            return function () {
                $('#lugar').val(arguments[0]);
            };
        };

        $('#select-console').selectize({
            options: [
                @foreach ($lugarEvaluacion as $lugar)
                { value: "{{$lugar->id}}", name: "{{$lugar->descripcion}}" },
                @endforeach
            ],
            labelField: 'name',
            searchField: ['name'],
            sortField: 'name',
            onChange: eventHandler('onChange'),
        });

        (function restoreLugar(){
            var oldLugar = "{{ old('lugar') }}";
            if(oldLugar){
                var control = $('#select-console')[0].selectize;
                control.setValue(oldLugar, true);
                $('#lugar').val(oldLugar);
            }
        })();
    </script>

    <script>
        // ✅ Si vuelve con error, siempre intenta restaurar el nombre:
        // 1) primero desde old('nomEvaluadoHidden')
        // 2) si está vacío, vuelve a buscar usando el DNI
        document.addEventListener('DOMContentLoaded', async () => {
            const dniInput = document.getElementById('dni');
            const nomInput = document.getElementById('nomEvaluado');
            const nomHidden = document.getElementById('nomEvaluadoHidden');
            const idHidden = document.getElementById('dniEvaluado');

            // Pintar lo que venga de old()
            const oldNombre = @json(old('nomEvaluadoHidden'));
            const oldId = @json(old('dniEvaluado'));

            if (oldNombre) {
                nomInput.value = oldNombre;
                nomHidden.value = oldNombre;
            }
            if (oldId) {
                idHidden.value = oldId;
            }

            // Si NO hay nombre pero SÍ hay DNI, re-buscar automático
            if (!nomHidden.value && dniInput.value) {
                await buscarEvaluadoPorDni(dniInput.value);
            }
        });

        async function buscarEvaluadoPorDni(dni) {
            const token = '{{ csrf_token() }}';
            const data = { dni: dni, _token: token };

            const response = await fetch("{{ route('registro.search') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json"
                },
                body: JSON.stringify(data)
            });

            const responseData = await response.json();

            if (responseData.length === 0) {
                // No borres lo que el usuario tenga, solo avisa si quieres
                // alert("No se encontró evaluado " + dni);
                return;
            }

            const nombre = responseData[0].nombreCompleto;
            const id = responseData[0].id;

            document.getElementById('nomEvaluado').value = nombre;
            document.getElementById('dniEvaluado').value = id;
            document.getElementById('nomEvaluadoHidden').value = nombre;
        }

        document.getElementById('btnDniEvaluado').addEventListener("click", async function (e) {
            e.preventDefault();
            const dni = document.getElementById('dni').value;
            if(!dni) return;

            try {
                await buscarEvaluadoPorDni(dni);
            } catch (error) {
                console.error("Error al realizar la petición:", error);
            }
        });
    </script>
@stop
