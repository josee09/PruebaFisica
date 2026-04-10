@extends('home')
@section('titulo')
    {{-- 24-4-23 creación de Vista para cerar un nuevo registro de usuario --}}
@stop
@section('contenido')

    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2> Formulario de registro | TERNAS EVALUADORAS </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br/>
                    <form id="demo-form2" method="POST"
                          @if($isNuevo)
                              action="{{ route('terna-evaluadora.store') }}"
                          @else
                              action="{{ route('terna-evaluadora.update',$terna) }}"
                          @endif
                          data-parsley-validate
                          class="form-horizontal form-label-left">
                        @csrf
                        @if(!$isNuevo)
                            @method('PUT')
                        @endif
                        <!-- NOMBRE TERNA EVALUADORA -->
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Grupo Terna Evaluadora: <span
                                    class="required">*</span></label>
                            <div class="col-md-8 col-sm-8 ">
                                <input name="descripcion" id="descripcion" type="text"
                                       style="text-transform: uppercase;" maxlength="30" minlength="3"
                                       class="form-control"
                                       value="{{old('descripcion') ?? $terna->descripcion }}"
                                       title="Ingrese un nombre válido (min: 3, max:30, solo letras)" required>
                            </div>
                        </div>
                        <!-- JEFE DE EQUIPO EVALUADOR  -->
                        <div class="item form-group align-items-end">
                            <label class="col-form-label col-md-2 col-sm-2 label-align">Oficial Jefe Equipo Evaluador:
                                <span
                                    class="required">*</span></label>
                            <div class="col-md-3 col-sm-3 ">
                                <label>DNI</label>
                                <row>
                                    <input type="hidden" name="idOJEE" id="idOJEE"
                                           value="{{old('idOJEE') ?? $terna->OJEE_id}}">
                                    <input name="dniOJEE" id="dniOJEE" type="text"
                                           style="text-transform: uppercase;" maxlength="30" minlength="3"
                                           class="form-control"
                                           value="{{old('dniOJEE') ?? $terna->evaluadorJefe->dni ?? ''}}"
                                           title="Ingrese un nombre válido (min: 3, max:30, solo letras)" required>
                                </row>
                            </div>
                            <button type="button" class="btn btn-info mb-0" name="btnOJEE" id="btnOJEE"><i
                                    class="fas fa-search"></i></button>
                            <div class="col-md-6 col-sm-6 ">
                                <label>Nombre</label>
                                <input readonly disabled name="OJEE" id="OJEE" type="text"
                                       style="text-transform: uppercase;" maxlength="30" minlength="3"
                                       class="form-control"
                                       @if($isNuevo)
                                           value="{{old('OJEE')}}"
                                       @else
                                           value="{{old('OJEE') ?? $terna->evaluadorJefe->nombreCompletoRango() ?? '' }}"
                                       @endif
                                       title="Ingrese un nombre válido (min: 3, max:30, solo letras)" required>
                            </div>
                        </div>
                        <!-- EVALUADOR 1 -->
                        <div class="item form-group align-items-end">
                            <label class="col-form-label col-md-2 col-sm-2 label-align">Evaluador N1: <span
                                    class="required">*</span></label>
                            <div class="col-md-3 col-sm-3 ">
                                <label>DNI</label>
                                <row>
                                    <input type="hidden" name="idE1" id="idE1"
                                           value="{{old('idE1') ?? $terna->E1_id ?? '' }}">
                                    <input name="dniE1" id="dniE1" type="text"
                                           style="text-transform: uppercase;" maxlength="30" minlength="3"
                                           class="form-control"
                                           value="{{old('dniE1') ?? $terna->evaluador1->dni ?? '' }}"
                                           title="Ingrese un nombre válido (min: 3, max:30, solo letras)" required>
                                </row>
                            </div>
                            <button type="button" class="btn btn-info mb-0" name="btnE1" id="btnE1"><i
                                    class="fas fa-search"></i></button>
                            <div class="col-md-6 col-sm-6 ">
                                <label>Nombre</label>
                                <input readonly disabled name="E1" id="E1" type="text"
                                       style="text-transform: uppercase;" maxlength="30" minlength="3"
                                       class="form-control"
                                       @if($isNuevo)
                                           value="{{old('E1')}}"
                                       @else
                                           value="{{old('E1') ?? $terna->evaluador1->nombreCompletoRango() ?? '' }}"
                                       @endif
                                       title="Ingrese un nombre válido (min: 3, max:30, solo letras)" required>
                            </div>
                        </div>
                        <!-- EVALUADOR 2 -->
                        <div class="item form-group align-items-end">
                            <label class="col-form-label col-md-2 col-sm-2 label-align">Evaluador N2: <span
                                    class="required">*</span></label>
                            <div class="col-md-3 col-sm-3 ">
                                <label>DNI</label>
                                <row>
                                    <input type="hidden" name="idE2" id="idE2"
                                           value="{{old('idE2') ?? $terna->E2_id ?? '' }}">
                                    <input name="dniE2" id="dniE2" type="text"
                                           style="text-transform: uppercase;" maxlength="30" minlength="3"
                                           class="form-control"
                                           value="{{old('dniE2') ?? $terna->evaluador2->dni ?? '' }}"
                                           title="Ingrese un nombre válido (min: 3, max:30, solo letras)" required>
                                </row>
                            </div>
                            <button type="button" class="btn btn-info mb-0" name="btnE2" id="btnE2"><i
                                    class="fas fa-search"></i></button>
                            <div class="col-md-6 col-sm-6 ">
                                <label>Nombre</label>
                                <input readonly disabled name="E2" id="E2" type="text"
                                       style="text-transform: uppercase;" maxlength="30" minlength="3"
                                       class="form-control"
                                       @if($isNuevo)
                                           value="{{old('E2')}}"
                                       @else
                                           value="{{old('E2') ?? $terna->evaluador2->nombreCompletoRango() ?? '' }}"
                                       @endif
                                       title="Ingrese un nombre válido (min: 3, max:30, solo letras)" required>
                            </div>
                        </div>
                        <!-- EVALUADOR 3 -->
                        <div class="item form-group align-items-end">
                            <label class="col-form-label col-md-2 col-sm-2 label-align">Evaluador N3: </label>
                            <div class="col-md-3 col-sm-3 ">
                                <label>DNI</label>
                                <row>
                                    <input type="hidden" name="idE3" id="idE3"
                                           value="{{old('idE3') ?? $terna->E3_id ?? '' }}">
                                    <input name="dniE3" id="dniE3" type="text"
                                           style="text-transform: uppercase;" maxlength="30" minlength="3"
                                           class="form-control"
                                           value="{{old('dniE3') ?? $terna->evaluador3?->dni ?? '' }}"
                                           title="Ingrese un nombre válido (min: 3, max:30, solo letras)" >
                                </row>
                            </div>
                            <button type="button" class="btn btn-info mb-0" name="btnE3" id="btnE3"><i
                                    class="fas fa-search"></i></button>
                            <div class="col-md-6 col-sm-6 ">
                                <label>Nombre</label>
                                <input readonly disabled name="E3" id="E3" type="text"
                                       style="text-transform: uppercase;" maxlength="30" minlength="3"
                                       class="form-control"
                                       @if($isNuevo)
                                           value="{{old('E3')}}"
                                       @else
                                           value="{{old('E3') ?? $terna->evaluador3?->nombreCompletoRango() ?? '' }}"
                                       @endif
                                       title="Ingrese un nombre válido (min: 3, max:30, solo letras)" >
                            </div>
                        </div>
                        <!-- EVALUADOR 4 -->
                        <div class="item form-group align-items-end">
                            <label class="col-form-label col-md-2 col-sm-2 label-align">Evaluador N4: </label>
                            <div class="col-md-3 col-sm-3 ">
                                <label>DNI</label>
                                <row>
                                    <input type="hidden" name="idE4" id="idE4"
                                           value="{{old('idE4') ?? $terna->E4_id ?? '' }}">
                                    <input name="dniE4" id="dniE4" type="text"
                                           style="text-transform: uppercase;" maxlength="30" minlength="3"
                                           class="form-control"
                                           value="{{old('dniE4') ?? $terna->evaluador4?->dni ?? '' }}"
                                           title="Ingrese un nombre válido (min: 3, max:30, solo letras)" >
                                </row>
                            </div>
                            <button type="button" class="btn btn-info mb-0" name="btnE4" id="btnE4"><i
                                    class="fas fa-search"></i></button>
                            <div class="col-md-6 col-sm-6 ">
                                <label>Nombre</label>
                                <input readonly disabled name="E4" id="E4" type="text"
                                       style="text-transform: uppercase;" maxlength="30" minlength="3"
                                       class="form-control"
                                       @if($isNuevo)
                                           value="{{old('E4')}}"
                                       @else
                                           value="{{old('E4') ?? $terna->evaluador4?->nombreCompletoRango() ?? '' }}"
                                       @endif
                                       title="Ingrese un nombre válido (min: 3, max:30, solo letras)" >
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="item form-row">
                            <div class="col-md-12 text-right">
                                <a type="button" class="btn btn-danger" href="{{route('terna-evaluadora.index')}}">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function makeRequest(btnId, dniId, outputId, idHidden) {
            document.getElementById(btnId).addEventListener("click", async function (e) {
                e.preventDefault();
                var dni = document.getElementById(dniId).value;
                var token = '{{csrf_token()}}'; // Supongamos que esta función obtiene el token de alguna manera
                var data = {dni: dni, _token: token};
                try {
                    var response = await fetch("{{route('registro.search')}}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify(data)
                    });
                    var responseData = await response.json();
                    console.log(responseData)
                    if (responseData.length === 0) {
                        alert("Evaluador no encontrado");
                    } else {
                        document.getElementById(outputId).value = responseData[0].nombreCompleto;
                        document.getElementById(idHidden).value = responseData[0].id;
                    }

                } catch (error) {
                    console.error("Error al realizar la petición:", error);
                }
            });
        }

        makeRequest("btnE1", "dniE1", "E1", "idE1");
        makeRequest("btnE2", "dniE2", "E2", "idE2");
        makeRequest("btnE3", "dniE3", "E3", "idE3");
        makeRequest("btnE4", "dniE4", "E4", "idE4");
        makeRequest("btnOJEE", "dniOJEE", "OJEE", "idOJEE");

    </script>
@stop
