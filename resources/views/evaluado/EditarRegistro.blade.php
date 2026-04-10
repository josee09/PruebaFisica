@extends('home')
@section('titulo')
    {{-- 21-4-23 creación de Vista para edición de registros del personal --}}
@stop
@section('contenido')

    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2> Formulario de edición | PERSONAL </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br/>
                    <form method="POST" id="demo-form2" action="{{ route('registro.update', $evaluado->id) }}"
                          data-parsley-validate class="form-horizontal form-label-left">
                        @csrf
                        {{-- {{ method_field('PUT') }}  --}}
                        @method('PUT')

                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Nombres: <span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 ">
                                <input name="nombre" id="nombre" onkeypress="validarLetras(event)" type="text"
                                       style="text-transform: uppercase;" maxlength="30" minlength="3"
                                       class="form-control @error('nombre') is-invalid @enderror"
                                       title="Ingrese un nombre válido (min: 3, max:30, solo letras)"
                                       value="{{old('nombre')  ?? $evaluado->nombre}}" required>
                                @error('nombre')
                                <span class="invalid-feedback" role="alert">
												<i style="color: red">{{ $message }}</i>
											</span>
                                @enderror
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Apellidos: <span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 ">
                                <input name="apellido" id="apellido" onkeypress="validarLetras(event)" type="text"
                                       style="text-transform: uppercase;" maxlength="30" minlength="3"
                                       class="form-control @error('apellido') is-invalid @enderror"
                                       value="{{old('apellido')  ?? $evaluado->apellido}}"
                                       title="Ingrese un apellido válido" required>
                                @error('apellido')
                                <span class="invalid-feedback" role="alert">
													<i style="color: red">{{ $message }}</i>
												</span>
                                @enderror
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">No. Identidad: <span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 ">
                                <input id=dni name="dni" type="text" onkeypress="validarNumeros(event)" maxlength="13"
                                       minlength="13" class="@error('dni') is-invalid @enderror form-control" required
                                       value="{{old('dni')  ?? $evaluado->dni}}" title="Ingrese una identidad válida"
                                       placeholder="Ingrese DNI sin guiones">
                                @error('dni')
                                <span class="invalid-feedback" role="alert">
													<i style="color: red">{{ $message }}</i>
											</span>
                                @enderror
                            </div>
                            <div class="col-md-1 mb-3 ">
                                <button type="button" class="btn btn-info mb-0" name="btnDniEvaluado"
                                        id="btnDniEvaluado"><i
                                        class="fas fa-search"></i></button>
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Sexo: <span class="required">*</span>
                            </label>
                            <div class="form-check form-check-inline ">
                                <input class="form-control form-check-input" type="radio" id="sexoM" name="sexo" value="M" {{ $evaluado->sexo == 'M' ? 'checked' : ''}} required><span>MASCULINO</span>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-control form-check-input" type="radio" id="sexoF" name="sexo" value="F" {{ $evaluado->sexo == 'F' ? 'checked' : ''}}><span>FEMENINO</span>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Fecha de nacimiento: <span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 ">
                                <input name="fechanac" id="fechanac" class="date-picker form-control" placeholder="yyyy-mm-dd"
                                       type="text" style="text-transform: uppercase;" required="required"
                                       value="{{old('fechanac')  ?? $evaluado->fechanac}}" type="text"
                                       onfocus="this.type='date'" onmouseover="this.type='date'"
                                       onclick="this.type='date'"
                                       onblur="this.type='text'" onmouseout="timeFunctionLong(this)" max="{{ date('Y-m-d') }}">
                                @error('fechanac')
                                    <span class="invalid-feedback" role="alert" style="display: block;">
                                        <i style="color: red">{{ $message }}</i>
                                    </span>
                                @enderror
                                <script>
                                    function timeFunctionLong(input) {
                                        setTimeout(function () {
                                            input.type = 'text';
                                        }, 60000);
                                    }
                                </script>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Grado policial: <span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 ">
                                <select class="form-control" id="grado" type="text" style="text-transform: uppercase;"
                                        name="grado" required
                                        value="{{old('grado')  ?? $evaluado->grado}}">
                                    <optgroup label="Escala Superior">
                                        <option
                                            value="General-Director"{{$evaluado->grado == Str::upper("General-Director") ? 'selected' : ''}}>
                                            General Director
                                        </option>
                                        <option
                                            value="Comisionado-General"{{$evaluado->grado == Str::upper("Comisionado-General") ? 'selected' : ''}}>
                                            Comisionado General
                                        </option>
                                    <optgroup label="Escala Ejecutiva">
                                        <option
                                            value="Comisionado"{{$evaluado->grado == Str::upper("Comisionado") ? 'selected' : ''}}>
                                            Comisionado
                                        </option>
                                        <option
                                            value="Sub-Comisionado"{{$evaluado->grado == Str::upper("Sub-Comisionado") ? 'selected' : ''}}>
                                            Sub-Comisionado
                                        </option>
                                        <option value="Comisario"{{$evaluado->grado == Str::upper("Comisario") ? 'selected' : ''}}>
                                            Comisario
                                        </option>
                                    <optgroup label="Escala Inspección">
                                        <option
                                            value="Sub-Comisario"{{$evaluado->grado == Str::upper("Sub-Comisario") ? 'selected' : ''}}>
                                            Sub-Comisario
                                        </option>
                                        <option value="Inspector"{{$evaluado->grado == Str::upper("Inspector") ? 'selected' : ''}}>
                                            Inspector
                                        </option>
                                        <option
                                            value="Sub-Inspector"{{$evaluado->grado == Str::upper("Sub-Inspector") ? 'selected' : ''}}>
                                            Sub-Inspector
                                        </option>
                                    <optgroup label="Escala Básica">
                                        <option
                                            value="Sub-Oficial-III"{{$evaluado->grado == Str::upper("Sub-Oficial-III") ? 'selected' : ''}}>
                                            Sub-Oficial III
                                        </option>
                                        <option
                                            value="Sub-Oficial-II"{{$evaluado->grado == Str::upper("Sub-Oficial-II") ? 'selected' : ''}}>
                                            Sub-Oficial II
                                        </option>
                                        <option
                                            value="Sub-Oficial-I"{{$evaluado->grado == Str::upper("Sub-Oficial-I") ? 'selected' : ''}}>
                                            Sub-Oficial I
                                        </option>
                                        <option
                                            value="Policía-Clase-III"{{$evaluado->grado == Str::upper("Policía-Clase-III") ? 'selected' : ''}}>
                                            Policía Clase III
                                        </option>
                                        <option
                                            value="Policía-Clase-II"{{$evaluado->grado == Str::upper("Policía-Clase-II") ? 'selected' : ''}}>
                                            Policía Clase II
                                        </option>
                                        <option
                                            value="Policía-Clase-I"{{$evaluado->grado == Str::upper("Policía-Clase-I") ? 'selected' : ''}}>
                                            Policía Clase I
                                        </option>
                                        <option
                                            value="Policía-Técnico-III"{{$evaluado->grado == Str::upper("Policía-Técnico-III") ? 'selected' : ''}}>
                                            Policía Técnico III
                                        </option>
                                        <option
                                            value="Policía-Técnico-II"{{$evaluado->grado == Str::upper("Policía-Técnico-II") ? 'selected' : ''}}>
                                            Policía Técnico II
                                        </option>
                                        <option
                                            value="Policía-Técnico-I"{{$evaluado->grado == Str::upper("Policía-Técnico-I") ? 'selected' : ''}}>
                                            Policía Técnico I
                                        </option>
                                        <option
                                            value="Policía-Técnico"{{$evaluado->grado == Str::upper("Policía-Técnico") ? 'selected' : ''}}>
                                            Policía Técnico
                                        </option>
                                        <option
                                            value="Agente-Policía"{{$evaluado->grado == Str::upper("Agente-Policía") ? 'selected' : ''}}>
                                            Agente Policía
                                        </option>
                                        <option
                                            value="Aspirante-Policía"{{$evaluado->grado == Str::upper("Aspirante-Policía") ? 'selected' : ''}}>
                                            Aspirante a Policía
                                        </option>
                                    </optgroup>
                                    <optgroup label="Escala de Cadetes">
                                        <option value="Alférez"{{$evaluado->grado == Str::upper("Alférez") ? 'selected' : ''}}>
                                            Alférez
                                        </option>
                                        <option value="Cadete"{{$evaluado->grado == Str::upper("Cadete") ? 'selected' : ''}}>
                                            Cadete
                                        </option>
                                        <option
                                            value="Aspirante-Cadete"{{$evaluado->grado == Str::upper("Aspirante-Cadete") ? 'selected' : ''}}>
                                            Aspirante a Cadete
                                        </option>
                                </select>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Categoría <span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 ">
                                <select class="form-control" id="categoria" type="text"
                                        style="text-transform: uppercase;" name="categoria" required>
                                    <option value="Regular"{{$evaluado->categoria == "Regular" ? 'selected' : ''}}>
                                        Regular
                                    </option>
                                    <option value="Servicios"{{$evaluado->categoria == "Servicios" ? 'selected' : ''}}>
                                        De los Servicios
                                    </option>
                                    <option value="OAuxiliar"{{$evaluado->categoria == "OAuxiliar" ? 'selected' : ''}}>
                                        Oficial Auxiliar
                                    </option>
                                    <option value="Auxiliar"{{$evaluado->categoria == "Auxiliar" ? 'selected' : ''}}>
                                        Auxiliar
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Direccion de asignación: <span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 ">
                                <select class="form-control" id="lugarasig" type="text"
                                        style="text-transform: uppercase;"
                                        name="lugarasig" required>
                                    <option></option>
                                    @foreach($lugarAsig as $lugarK => $lugarV)
                                        <option
                                            value="{{$lugarK}}" {{ $evaluado->lugarasig == $lugarK ? 'selected' : '' }}>
                                            {{$lugarV}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Promoción: </label>
                            <div class="col-md-6 col-sm-6 ">
                                <input type="text" style="text-transform: uppercase;" maxlength="10"
                                       onkeypress="validarNumeros(event)"
                                       class="@error('promocion') is-invalid @enderror form-control"
                                       title="Ingrese su promoción válida" name="promocion"
                                       id="promocion"
                                       value="{{old('promocion') ?? $evaluado->promocion}}">
                                @error('promocion')
                                <span class="invalid-feedback" role="alert">
													<i style="color: red">{{ $message }}</i>
											</span>
                                @enderror
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">No. Serie/Chapa: </label>
                            <div class="col-md-6 col-sm-6 ">
                                <input trimEnd() type="text" class="form-control @error('chapa') is-invalid @enderror"
                                       style="text-transform: uppercase;" maxlength="10"
                                       title="Ingrese un Nro. chapa válido" name="serie" id="serie"
                                       value="{{old('serie') ?? $evaluado->serie}}">
                                @error('chapa')
                                <span class="invalid-feedback" role="alert">
                      <i style="color: red">{{ $message }}</i>
                  </span>
                                @enderror
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Correo Electrónico:</label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" name="email" id="email" type="email"
                                       value="{{ old('email') ?? $evaluado->email }}">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Teléfono:</label>
                            <div class="col-md-6 col-sm-6">
                                <input type="text" name="telefono" class="form-control"
                                       value="{{ old('telefono') ?? $evaluado->telefono }}">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Cuenta de Usuario Vinculada:</label>
                            <div class="col-md-6 col-sm-6">
                                <select name="user_id" class="form-control">
                                    <option value="">-- Sin Vincular --</option>
                                    @foreach($usuarios as $user)
                                        <option value="{{ $user->id }}" {{ ($evaluado->user_id == $user->id) ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Asocie esta ficha de personal con una cuenta de acceso al sistema.</small>
                            </div>
                        </div>

                        <div class="ln_solid"></div>
                        <div class="item form-row">
                            <div class="col-md-12 text-right">
                                <a type="button" class="btn btn-danger" href="{{route('registros.index')}}">
                                    Cancelar </a>
                                <button type="submit" class="btn btn-primary"> Guardar</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('btnDniEvaluado').addEventListener("click", async function (e) {
            e.preventDefault();
            const dni = document.getElementById('dni').value;
            const token = '{{csrf_token()}}'; // Supongamos que esta función obtiene el token de alguna manera
            const data = {dni: dni, _token: token};
            try {

                const response = await fetch("{{route('registro.buscarSic')}}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify(data)
                });


                if (response.status !== 201) {
                    alert("No se encontro evaluado " + dni);
                } else {
                    const responseData = await response.json();
                    if(responseData.sexo === 'M'){
                        document.getElementById('sexoM').checked = true
                    } else {
                        document.getElementById('sexoF').checked = true
                    }
                    document.getElementById('nombre').value = responseData.nombre;
                    document.getElementById('apellido').value = responseData.apellido;
                    document.getElementById('fechanac').value = responseData.fechanac;
                    document.getElementById('grado').value = responseData.grado;
                    document.getElementById('categoria').value = responseData.categoria;
                    document.getElementById('lugarasig').value = responseData.lugarasig;
                    document.getElementById('promocion').value = responseData.promocion;
                    document.getElementById('serie').value = responseData.serie;



                }

            } catch (error) {
                console.log("Error al realizar la petición: " + error);
            }
        });
    </script>
@stop
