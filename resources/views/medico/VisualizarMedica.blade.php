@extends('home')

@section('titulo')
    {{-- 21-6-23 creación de Vista para Crear nuevas evaluaciones medicas --}}
@stop

@section('contenido')
    <div class="clearfix">

    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2> Evaluación | MÉDICA</h2>
                    <div class="clearfix"></div>
                </div>
                <form id="demo-form2"
                      action="{{ $medico && $medico->id ? route('medica.update', $medico->id) : route('medica.store') }}"
                      method="POST" enctype="multipart/form-data" data-parsley-validate
                      class="form-horizontal form-label-left">
                    <div class="x_content">

                        {{-- CSRF Token --}}
                        @csrf
                        {{-- Método PUT para actualización o POST para creación --}}
                        @method($medico && $medico->id ? 'PUT' : 'POST')
                        {{-- MOSTRAR DATOS PERSONALES --}}
                        <div class=" item form-row mb-3">
                            <div class="col-md-2 mb-2">
                                <label>No. de identidad:</label>
                                <input id="dni" name="dni" type="text" readonly class="form-control"
                                       value="{{ $request->input('dni') }}">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Nombre: </label>
                                <div>
                                    <input id="apellido" name="apellido" type="text" readonly class="form-control"
                                           value="{{ $resultado->nombre . ' ' . $resultado->apellido }}">
                                </div>
                            </div>
                            <div class="col-md-1 mb-2">
                                <label>Edad: </label>
                                <div>
                                    <input id="edad" name="edad" type="text" readonly class="form-control"
                                           value="{{ old('fechanac') ?? \Carbon\Carbon::parse($resultado->fechanac)->age }}">
                                </div>
                            </div>
                            <div class="col-md-1 mb-2">
                                <label>Sexo: </label>
                                <div>
                                    <input id="sexo" name="sexo" type="text" readonly class="form-control"
                                           value="{{ $resultado->sexo }}">
                                </div>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label>Grado: </label>
                                <div>
                                    <input id="grado" name="grado" type="text" readonly class="form-control"
                                           value="{{ $resultado->grado }}">
                                </div>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label>Periodo: </label>
                                <div>
                                    <input id="Periodo" name="Periodo" type="text" readonly class="form-control"
                                           value="{{ $request->input('periodo') }}">
                                </div>
                            </div>
                        </div>
                        {{-- FIN MOSTRAR DATOS PERSONALES --}}
                        {{-- MEDIDAS PRINCIPALES --}}
                        <div class="ln_solid"></div>
                        <center>
                            <legend>Presion alterial:</legend>
                        </center>
                        <div class=" item form-row mb-3">
                            <div class="col-md-4 mb-2">
                                <label>Pulso cardíaco:</label>
                                <input id="pulso" readonly name="pulso" value="{{ $request->input('pulso') }}"
                                       type="text"
                                       class="form-control" style="text-align: center;" readonly>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Oximetría:</label>
                                <input id="saturacion" readonly name="saturacion"
                                       value="{{ $request->input('saturacion') }}" type="text" class="form-control"
                                       style="text-align: center;" readonly>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Presión arterial: </label>
                                <input id="Presion" readonly name="Presion" value="{{ $request->input('Presion') }}"
                                       type="text" class="form-control" style="text-align: center;">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Presión arterial 2:</label>
                                <input id="Presion2" readonly name="Presion2" type="text"
                                       onkeypress="validarPresion(event)" class="form-control"
                                       placeholder="Ejemplo: 120/80" maxlength="7" minlength="2"
                                       value="{{ $request->input('Presion2') }}">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Presión arterial 3:</label>
                                <input id="Presion3" readonly name="Presion3" type="text"
                                       onkeypress="validarPresion(event)" class="form-control"
                                       placeholder="Ejemplo: 120/80" maxlength="7" minlength="2"
                                       value="{{ $request->input('Presion3') }}">
                            </div>
                        </div>
                        <center>
                            <legend>Medidas Principales:</legend>
                        </center>
                        <div class=" item form-row mb-3">
                            <div class="col-md-4 mb-2">
                                <label>Altura en mts: </label>
                                <input id="Altura" readonly name="Altura" value="{{ $alturaM }}" type="text"
                                       class="form-control" style="text-align: center;">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Medida de abdomen:</label>
                                <input id="Abdomen" readonly name="Abdomen" value="{{ $request->input('Abdomen') }}"
                                       type="text" class="form-control" style="text-align: center;">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label>Medida de Cuello:</label>
                                <input id="Cuello" readonly name="Cuello" value="{{ $request->input('Cuello') }}"
                                       type="text" class="form-control" style="text-align: center;">
                            </div>
                        </div>
                        {{-- FIN MEDIDAS PRINCIPALES --}}
                        {{-- FACTORES DE ACUMULACION --}}
                        <center>
                            <legend>Factores de acumulación Cuello-Abdomen:</legend>
                        </center>
                        <div class=" item form-row mb-3">
                            <div class="col-md-3 mb-2">

                                <label>Medida de Abdomen-Cuello (cm):</label>
                                <input id="Mediabocue" readonly name="Mediabocue"
                                       value="{{ number_format($mecabdocue * 2.54, 1) }}" type="text"
                                       class="form-control"
                                       style="text-align: center;">

                            </div>
                            <div class="col-md-3 mb-2">
                                <label>Factor Abdomen-Cuello:</label>
                                <input id="factoabdocue" readonly name="factoabdocue" value="{{ $factoabdocue }}"
                                       type="text" class="form-control" style="text-align: center;">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>Factor de Altura:</label>
                                <input id="Factoaltu" readonly name="Factoaltu" value="{{ $factoraltura }}" type="text"
                                       class="form-control" style="text-align: center;">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>Porcentaje de grasa en el cuello:</label>
                                <input id="Grasa" readonly name="Grasa" value="{{ $factoabdocue - $factoraltura}}"
                                       type="text" class="form-control" style="text-align: center;">
                            </div>
                        </div>
                        {{-- FIN FACTORES DE ACUMULACION --}}
                        {{-- RESULTADOS--}}
                        <div class="ln_solid"></div>
                        <center>
                            <legend>Resultados:</legend>
                        </center>
                        <div class=" item form-row mb-3">
                            <div class="col-md-3 mb-2">
                                <label>Peso Real:</label>
                                <input id="Pesoreal" readonly name="Pesoreal" value="{{ $request->input('Peso') }}"
                                       type="text" class="form-control" style="text-align: center;">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>Peso ideal:</label>
                                <input id="Pesoideal" readonly name="Pesoideal" value="{{ $pesoideal }}" type="text"
                                       class="form-control" style="text-align: center;">
                            </div>
                            <div class="col-md-3 mb-2">
                                @if ($exceso < 0)
                                    <label>Déficit de peso:</label>
                                    <span>Necesita subir de peso: {{ abs($exceso) }} libras</span>
                                @else
                                    <label>Sobrepeso:</label>
                                @endif
                                <input id="Exceso" readonly name="Exceso" type="text" value="{{ $exceso }}"
                                       class="form-control" style="text-align: center; background-color: #aef8be;">


                            </div>
                            <div class="col-md-3 mb-2">
                                <label>CONDICION:</label>
                                <select class="form-control" id="condicion" type="text"
                                        style="text-transform: uppercase;"
                                        name="condicion" required>
                                    <option></option>
                                    <option value="APTO" {{ $exceso < 30 ? 'selected' : '' }}>APTO</option>
                                    <option value="NO APTO" {{ $exceso>= 30 ? 'selected' : '' }}>NO APTO</option>
                                </select>
                                <div class="message-table">
                                    @if ($exceso > 30)
                                        <div class="message-row">
                                            <div class="message-cell">
                                        <span class="message-text">Necesita bajar de peso: {{ abs($exceso) }}
                                            libras</span>
                                            </div>
                                            <div class="message-cell">
                                        <span class="message-text">Su índice de masa corporal está por arriba del
                                            1%</span>
                                            </div>
                                            <div class="message-cell">
                                                <span class="message-not-apt">USTED NO ES APTO ❌ 😞</span>
                                            </div>
                                        </div>
                                    @elseif ($exceso >= 0 && $exceso <= 30)
                                        <div class="message-row">
                                            <div class="message-cell">
                                                <span
                                                    class="message-text">Tiene sobrepeso: {{ abs($exceso) }} libras</span>
                                            </div>
                                            <div class="message-cell">
                                        <span class="message-text">Su índice de masa corporal está por arriba del
                                            1%</span>
                                            </div>
                                            <div class="message-cell">
                                                <span class="message-apt">USTED ES APTO ✔ 😃</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="message-row">
                                            <div class="message-cell">
                                                <span class="message-text">Necesita subir de peso: {{ abs($exceso) }} libras</span>
                                            </div>
                                            <div class="message-cell">
                                                <span class="message-text">Su índice de masa corporal está por debajo del 1%</span>
                                            </div>
                                            <div class="message-cell">
                                                <span class="message-apt">USTED ES APTO ✔ 😃</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>


                            <style>
                                .message-table {
                                    display: table;
                                    width: 100%;
                                    border-collapse: collapse;
                                }

                                .message-row {
                                    display: table-row;
                                }

                                .message-cell {
                                    display: table-cell;
                                    padding: 10px;
                                    border: 1px solid #e9b407;
                                }

                                .message-text {
                                    color: #1d1c1c;
                                }

                                .message-apt {
                                    color: #08f828;
                                    font-weight: bold;
                                    text-transform: uppercase;
                                }

                                .message-not-apt {
                                    color: #fa1c03;
                                    font-weight: bold;
                                    text-transform: uppercase;
                                }
                            </style>
                        </div>
                        <style>
                            .text-red {
                                color: red;
                            }
                        </style>
                        <div class="col-md-12 mb-2">
                            <label class="control-label col-md-12 col-sm-12 ">Observaciones: </label>
                            <div class="input-group">
                                <textarea class="resizable_textarea form-control text-red" style="height: 60px;"
                                          name="observaciones" id="observaciones">{{ $medico->observaciones ?? '' }}
                                </textarea>
                                <div class="input-group-append">
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            var exceso = {{ $exceso }};
                                            var textarea = document.getElementById('observaciones');

                                            if (exceso < 0 && textarea.value.indexOf("👨‍⚕️ EVALUAR NUTRICIONISTA") === -1) {
                                                textarea.value += "\n👨‍⚕️ EVALUAR NUTRICIONISTA";
                                            }
                                        });
                                    </script>

                                </div>
                            </div>
                        </div>

                        <style>
                            .text-red {
                                color: red;
                            }

                            .input-group-append {
                                display: flex;
                                align-items: center;
                                padding: 5px;
                            }
                        </style>

                    </div>

                    <style>
                        .text-red {
                            color: red;
                        }
                    </style>

                    {{--        @can('bioimpedancia.index')--}}


                            <center>
                                <legend>Bioimpedancia: </legend>
                            </center>
                            <div class="item form-row mb-3">
                                <!-- % Musculo -->
                                <div class="col-md-3 mb-2">
                                        <label>Sobrepeso Actual</label>
                                    <input id="sa" name="sa" type="number" step=".01" min="-500" max="500" maxlength="4" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control"
                                       value="{{ $medico->sa ?? old('sa') }}">
                                </div>
                                <!-- Sobre Peso -->
                                <div class="col-md-3 mb-2">
                                    <label>Sobrepeso Masa Magra:</label>
                                    <input id="smm" name="smm" value="{{ $medico->smm ?? old('smm') }}"  type="number" step=".01" min="-500" max="500" maxlength="4" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control"
                                        style="text-align: center;">
                                </div>
                                <!-- Libras de masa muscular (Primera vez calculado) -->
                                <div class="col-md-3 mb-2">
                                    <label>Sobrepeso Real por Masa Grasa</label>
                                    <input id="srmg" name="srmg"  value="{{$medico->srmg ?? old('srmg')}}" type="number" step=".01" min="-500" max="500" maxlength="4" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                        class="form-control" style="text-align: center;">
                                </div>
                            </div>

{{--                            <div class="item form-row mb-3">--}}
{{--                                <!-- Libras de masa muscular (Copia del primer cálculo) -->--}}
{{--                                <div class="col-md-3 mb-2">--}}
{{--                                    <label>Libras de masa muscular:</label>--}}
{{--                                    <input id="libras_masa_copia" readonly name="libras_masa_copia" value="{{ $exceso * $medico->musculo ?? $exceso * old('musculo') }}"--}}
{{--                                        type="text" class="form-control" style="text-align: center;">--}}
{{--                                </div>--}}
{{--                                <!-- Sobre Peso -->--}}
{{--                                <div class="col-md-3 mb-2">--}}
{{--                                    <label>Sobre Peso:</label>--}}
{{--                                    <input id="exceso" readonly name="exceso" value="{{ $exceso }}" type="text" class="form-control"--}}
{{--                                        style="text-align: center;">--}}
{{--                                </div>--}}
{{--                                <!-- Sobre peso real por masa grasa -->--}}
{{--                                <div class="col-md-3 mb-2">--}}
{{--                                    <label>Sobre peso real por masa grasa:<span class="required">*</span></label>--}}
{{--                                    <input id="sobrepeso_masa_grasa" readonly name="sobrepeso_masa_grasa" value="" type="text"--}}
{{--                                        class="form-control" style="text-align: center;">--}}
{{--                                </div>--}}

{{--                                <!-- Grasa visceral -->--}}
{{--                                <div class="col-md-3 mb-2">--}}
{{--                                    <label>Grasa visceral:<span class="required">*</span></label>--}}
{{--                                    <input id="grasa_visceral" name="grasa_visceral" type="text" onkeypress="validarNumeros(event)"--}}
{{--                                        class="form-control" maxlength="3" minlength="2" value="{{ $medico->grasa_visceral ?? old('grasa_visceral') }}">--}}
{{--                                </div>--}}
{{--                            </div>--}}


                    {{--        <script>--}}
                    {{--            document.addEventListener("DOMContentLoaded", function () {--}}
                    {{--    const musculoInput = document.getElementById("musculo");--}}
                    {{--    const grasaInput = document.getElementById("exceso");--}}
                    {{--    const librasMasaInput = document.getElementById("libras_masa");--}}
                    {{--    const librasMasaCopiaInput = document.getElementById("libras_masa_copia");--}}
                    {{--    const sobrepesoMasaGrasaInput = document.getElementById("sobrepeso_masa_grasa");--}}

                    {{--    const updateValues = () => {--}}

                    {{--        const musculoValuePercentage = parseFloat(musculoInput.value) || 0;--}}
                    {{--        const musculoValueDecimal = musculoValuePercentage / 100; // Convert percentage to decimal--}}
                    {{--        const grasaValue = Math.abs(grasaInput.value) || 0;--}}
                    {{--        const librasMasaValue = (musculoValueDecimal * grasaValue).toFixed(2);--}}
                    {{--        librasMasaInput.value = librasMasaValue;--}}
                    {{--        librasMasaCopiaInput.value = librasMasaValue; // Copia el valor calculado del primer campo--}}

                    {{--        // Calculate the result and set it to the sobrepeso_masa_grasa field--}}
                    {{--        const sobrepesoMasaGrasaValue = Math.abs( grasaValue - librasMasaValue  ).toFixed(2);--}}
                    {{--        sobrepesoMasaGrasaInput.value = sobrepesoMasaGrasaValue;--}}
                    {{--    };--}}

                    {{--    musculoInput.addEventListener("input", updateValues);--}}
                    {{--    grasaInput.addEventListener("input", updateValues);--}}
                    {{--});--}}
                    {{--        </script>--}}
                    {{--        @endcan--}}

                    <!-- Rest of your HTML code here -->






                    {{-- FIN RESULTADOS --}}
                    <div class="ln_solid"></div>
                    <center>
                        <legend>Evaluadores</legend>
                    </center>
                    <div class=" item form-row mb-3">
                        <div class="col-md-3 mb-2">
                            <label>Nombre de médico:</label>
                            <input id="Medico" readonly name="Medico" type="text"
                                   value="{{ $request->input('Medico') }}"
                                   class="form-control text-uppercase">
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>Grado policial de médico:</label>
                            <input id="grado" readonly name="grado" type="text" value="{{ $request->input('grado') }}"
                                   class="form-control text-uppercase">
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>Lugar de evaluación:</label>
                            <input id="lugar" readonly name="lugar" type="text" value="{{ $request->input('lugar') }}"
                                   class="form-control text-uppercase">
                        </div>
                        <div class="col-md-3 mb-2">
                            <label>Equipo evaluador:</label>
                            <input id="equipo" readonly name="equipo" type="text"
                                   value="{{ $request->input('equipo') }}"
                                   class="form-control text-uppercase">
                        </div>
                    </div>
                    {{-- FIN EVALUADORES --}}
                    {{-- BOTONES --}}
                    <div class="ln_solid"></div>
                    <div class=" item form-row mb-3">
                        <div class="col-md-12 text-right">
                            <a type="button" class="btn btn-danger" href="{{ route('medica.index') }}">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                    {{-- FIN BOTONES --}}
                </form>
            </div>
        </div>
    </div>
    </div>
@stop
