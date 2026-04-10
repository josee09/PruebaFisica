@extends('home')
@section('titulo')
    {{-- 19-4-23 creación de Vista para registro del personal --}}
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
                    <h2> Formulario de registro | PERSONAL </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br/>
                    <form id="demo-form2" method="POST" action="{{ route('registro.store') }}" data-parsley-validate
                          class="form-horizontal form-label-left">
                        @csrf
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Nombres: <span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 ">
                                <input name="nombre" id="nombre" onkeypress="validarLetras(event)" type="text"
                                       style="text-transform: uppercase;" maxlength="30" minlength="3"
                                       class="form-control @error('nombre') is-invalid @enderror"
                                       value="{{old('nombre')}}"
                                       title="Ingrese un nombre válido (min: 3, max:30, solo letras)" required>
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
                                       value="{{old('apellido')}}"
                                       title="Ingrese un apellido válido (min: 3, max:30, solo letras)" required>
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
                                <input name="dni" id="dni" type="text" pattern="[0-9]{13}" maxlength="13" minlength="13"
                                       onkeypress="validarNumeros(event)"
                                       class="form-control @error('dni') is-invalid @enderror" value="{{old('dni')}}"
                                       title="Ingrese una identidad válida (sin guiones, solo números)"
                                       placeholder="Ingrese DNI sin guiones" required>
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
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Sexo: <span
                                    class="required">*</span>
                            </label>
                            <div class="form-check form-check-inline ">
                                <input class="form-control form-check-input" type="radio" id="sexoM" name="sexo" value="M" {{
                                old('sexo')=='M' ? 'checked' : '' }} required><span>MASCULINO</span>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-control form-check-input" type="radio" name="sexo" id="sexoF" value="F" {{
                                old('sexo')=='F' ? 'checked' : '' }}><span>FEMENINO</span>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Fecha de nacimiento: <span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 ">
                                <input name="fechanac" id="fechanac" class="date-picker form-control" value="{{old('fechanac')}}"
                                       placeholder="dd-mm-yyyy" type="text" style="text-transform: uppercase;"
                                       required="required" type="text" onfocus="this.type='date'"
                                       onmouseover="this.type='date'" onclick="this.type='date'"
                                       onblur="this.type='text'"
                                       onmouseout="timeFunctionLong(this)" aria-valuemin="01-01-1990" max="{{ date('Y-m-d') }}">
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
                                        name="grado" required>
                                    <option></option>
                                    <optgroup label="Escala Superior">
                                        <option value="General-Director" {{ old('grado')=="General-Director" ? 'selected'
                                        : '' }}>General Director
                                        </option>
                                        <option value="Comisionado-General" {{ old('grado')=="Comisionado-General"
                                        ? 'selected' : '' }}>Comisionado General
                                        </option>
                                    </optgroup>
                                    <optgroup label="Escala Ejecutiva">
                                        <option value="Comisionado" {{ old('grado')=="Comisionado" ? 'selected' : '' }}>
                                            Comisionado
                                        </option>
                                        <option value="Sub-Comisionado" {{ old('grado')=="Sub-Comisionado" ? 'selected' : ''
                                        }}>Sub-Comisionado
                                        </option>
                                        <option value="Comisario" {{ old('grado')=="Comisario" ? 'selected' : '' }}>
                                            Comisario
                                        </option>
                                    </optgroup>
                                    <optgroup label="Escala Inspección">
                                        <option
                                            value="Sub-Comisario" {{ old('grado')=="Sub-Comisario" ? 'selected' : '' }}>
                                            Sub-Comisario
                                        </option>
                                        <option value="Inspector" {{ old('grado')=="Inspector" ? 'selected' : '' }}>
                                            Inspector
                                        </option>
                                        <option
                                            value="Sub-Inspector" {{ old('grado')=="Sub-Inspector" ? 'selected' : '' }}>
                                            Sub-Inspector
                                        </option>
                                    </optgroup>
                                    <optgroup label="Escala Básica">
                                        <option value="Sub-Oficial-III" {{ old('grado')=="Sub-Oficial-III" ? 'selected' : ''
                                        }}>Sub-Oficial III
                                        </option>
                                        <option value="Sub-Oficial-II" {{ old('grado')=="Sub-Oficial-II" ? 'selected' : ''
                                        }}>Sub-Oficial II
                                        </option>
                                        <option
                                            value="Sub-Oficial-I" {{ old('grado')=="Sub-Oficial-I" ? 'selected' : '' }}>
                                            Sub-Oficial I
                                        </option>
                                        <option value="Policía-Clase-III" {{ old('grado')=="Policía-Clase-III" ? 'selected'
                                        : '' }}>Policía Clase III
                                        </option>
                                        <option value="Policía-Clase-II" {{ old('grado')=="Policía-Clase-II" ? 'selected'
                                        : '' }}>Policía Clase II
                                        </option>
                                        <option value="Policía-Clase-I" {{ old('grado')=="Policía-Clase-I" ? 'selected' : ''
                                        }}>Policía Clase I
                                        </option>
                                        <option value="Policía-Técnico-III" {{ old('grado')=="Policía-Técnico-III"
                                        ? 'selected' : '' }}>Policía Técnico III
                                        </option>
                                        <option value="Policía-Técnico-II" {{ old('grado')=="Policía-Técnico-II"
                                        ? 'selected' : '' }}>Policía Técnico II
                                        </option>
                                        <option value="Policía-Técnico-I" {{ old('grado')=="Policía-Técnico-I" ? 'selected'
                                        : '' }}>Policía Técnico I
                                        </option>
                                        <option
                                            value="Policía-Técnico"{{old('grado')== "Policía-Técnico" ? 'selected' : ''}}>
                                            Policía Técnico
                                        </option>
                                        <option value="Agente-Policía" {{ old('grado')=="Agente-Policía" ? 'selected' : ''
                                        }}>Agente Policía
                                        </option>
                                        <option value="Aspirante-Policía" {{ old('grado')=="Aspirante-Policía" ? 'selected'
                                        : '' }}>Aspirante a Policía
                                        </option>
                                    </optgroup>
                                    <optgroup label="Escala de Cadetes">
                                        <option value="Alférez" {{ old('grado')=="Alférez" ? 'selected' : '' }}>Alférez
                                        </option>
                                        <option value="Cadete" {{ old('grado')=="Cadete" ? 'selected' : '' }}>Cadete
                                        </option>
                                        <option value="Aspirante-Cadete" {{ old('grado')=="Aspirante-Cadete" ? 'selected'
                                        : '' }}>Aspirante a Cadete
                                        </option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="categoria">Categoría <span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 ">
                                <select class="form-control" id="categoria" type="text"
                                        style="text-transform: uppercase;"
                                        name="categoria" required>
                                    <option></option>
                                    <option value="Regular" {{ old('categoria')=="Regular" ? 'selected' : '' }}>
                                        Regular
                                    </option>
                                    <option value="Servicios" {{ old('categoria')=="Servicios" ? 'selected' : '' }}>De
                                        los Servicios
                                    </option>
                                    <option value="OAuxiliar" {{ old('categoria')=="OAuxiliar" ? 'selected' : '' }}>
                                        Oficial Auxiliar
                                    </option>
                                    <option value="Auxiliar" {{ old('categoria')=="Auxiliar" ? 'selected' : '' }}>
                                        Auxiliar
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="lugarasig">Direccion de
                                asignación:
                                <span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 ">
                                <select class="form-control" id="lugarasig" type="text"
                                        style="text-transform: uppercase;"
                                        name="lugarasig" required>
                                    <option></option>
                                    @foreach($lugarAsig as $lugarK => $lugarV)
                                        <option
                                            value="{{$lugarK}}" {{ old('lugarasig') == $lugarK ? 'selected' : '' }}>
                                            {{$lugarV}}
                                        </option>
                                    @endforeach



                                </select>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Promoción: </label>
                            <div class="col-md-6 col-sm-6 ">
                                <input name="promocion" id="promocion" type="text"
                                       style="text-transform: uppercase;" maxlength="10"
                                       class="@error('promocion') is-invalid @enderror form-control"
                                       title="Ingrese su promoción válida" value="{{old('promocion')}}">
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
                                <input name="serie" id="serie" type="text"
                                       class="form-control @error('serie') is-invalid @enderror"
                                       style="text-transform: uppercase;" maxlength="10"
                                       title="Ingrese un Nro. de serie válido" value="{{old('serie')}}">
                                @error('serie')
                                <span class="invalid-feedback" role="alert">
                                <i style="color: red">{{ $message }}</i>
                            </span>
                                @enderror
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Correo Electrónico: <span
                                    class="required"></span></label>
                            <div class="col-md-6 col-sm-6 ">
                                <input class="form-control" name="email" id="email" type="email"
                                       value="{{ old('email') }}">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Teléfono: <span
                                    class="required"></span></label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" name="telefono" id="telefono" type="text"
                                       value="{{ old('telefono') }}">
                            </div>
                        </div>

                        <div class="ln_solid"></div>
                        <div class="item form-row">
                            <div class="col-md-12 text-right">
                                <a type="button" class="btn btn-danger" href="{{route('registros.index')}}">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Guardar
                                </button>
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
                    document.getElementById('nombre').value = responseData.nombre;
                    document.getElementById('apellido').value = responseData.apellido;
                    document.getElementById('fechanac').value = responseData.fechanac;
                    document.getElementById('grado').value = responseData.grado;
                    document.getElementById('categoria').value = responseData.categoria;
                    document.getElementById("lugarasig").value = responseData.CLAVEORGA;
                    console.log(responseData.lugarasig)
                    document.getElementById('promocion').value = responseData.promocion;
                    document.getElementById('serie').value = responseData.serie;
                    if(responseData.sexo === 'M'){
                        document.getElementById('sexoM').checked = true
                    } else {
                        document.getElementById('sexoF').checked = true
                    }


                }

            } catch (error) {
                console.log("Error al realizar la petición: " + error);
            }
        });
    </script>
@stop
