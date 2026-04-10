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
                <h2> Formulario de registro | USUARIOS </h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br />
                <form id="demo-form2" method="POST" action="{{ route('Usuario.store') }}" data-parsley-validate
                    class="form-horizontal form-label-left">
                    @csrf
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Nombres: <span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 ">
                            <input name="firstname" id="firstname" onkeypress="validarLetras(event)" type="text"
                                style="text-transform: uppercase;" maxlength="30" minlength="3" class="form-control"
                                value="{{old('firstname')}}"
                                title="Ingrese un nombre válido (min: 3, max:30, solo letras)" required>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Apellidos: <span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 ">
                            <input name="lastname" id="lastname" onkeypress="validarLetras(event)" type="text"
                                style="text-transform: uppercase;" maxlength="30" minlength="3" class="form-control"
                                value="{{old('lastname')}}"
                                title="Ingrese un apellido válido (min: 3, max:30, solo letras)" required>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Grado policial: <span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <select class="form-control" id="grado" style="text-transform: uppercase;" name="grado"
                                required>
                                <option></option>
                                <optgroup label="Auxiliar">
                                    <option value="Médico-General" {{ old('grado')=="Médico-General" ? 'selected' : ''
                                        }}>Médico General</option>
                                    <option value="Médico-Especialista" {{ old('grado')=="Médico-Especialista"
                                        ? 'selected' : '' }}>Médico Especialista</option>
                                    {{-- <option value="Médico-Nutricionista" {{ old('grado')=="Médico-Nutricionista"
                                        ? 'selected' : '' }}>Médico Nutricionista</option> --}}
                                </optgroup>
                                <optgroup label="Escala Superior">
                                    <option value="General-Director" {{ old('grado')=="General-Director" ? 'selected'
                                        : '' }}>General Director</option>
                                    <option value="Comisionado-General" {{ old('grado')=="Comisionado-General"
                                        ? 'selected' : '' }}>Comisionado General</option>
                                </optgroup>
                                <optgroup label="Escala Ejecutiva">
                                    <option value="Comisionado" {{ old('grado')=="Comisionado" ? 'selected' : '' }}>
                                        Comisionado</option>
                                    <option value="Sub-Comisionado" {{ old('grado')=="Sub-Comisionado" ? 'selected' : ''
                                        }}>Sub-Comisionado</option>
                                    <option value="Comisario" {{ old('grado')=="Comisario" ? 'selected' : '' }}>
                                        Comisario</option>
                                </optgroup>
                                <optgroup label="Escala Inspección">
                                    <option value="Sub-Comisario" {{ old('grado')=="Sub-Comisario" ? 'selected' : '' }}>
                                        Sub-Comisario</option>
                                    <option value="Inspector" {{ old('grado')=="Inspector" ? 'selected' : '' }}>
                                        Inspector</option>
                                    <option value="Sub-Inspector" {{ old('grado')=="Sub-Inspector" ? 'selected' : '' }}>
                                        Sub-Inspector</option>
                                </optgroup>
                                <optgroup label="Escala Básica">
                                    <option value="Sub-Oficial-III" {{ old('grado')=="Sub-Oficial-III" ? 'selected' : ''
                                        }}>Sub-Oficial III</option>
                                    <option value="Sub-Oficial-II" {{ old('grado')=="Sub-Oficial-II" ? 'selected' : ''
                                        }}>Sub-Oficial II</option>
                                    <option value="Sub-Oficial-I" {{ old('grado')=="Sub-Oficial-I" ? 'selected' : '' }}>
                                        Sub-Oficial I</option>
                                    <option value="Policía-Clase-III" {{ old('grado')=="Policía-Clase-III" ? 'selected'
                                        : '' }}>Policía Clase III</option>
                                    <option value="Policía-Clase-II" {{ old('grado')=="Policía-Clase-II" ? 'selected'
                                        : '' }}>Policía Clase II</option>
                                    <option value="Policía-Clase-I" {{ old('grado')=="Policía-Clase-I" ? 'selected' : ''
                                        }}>Policía Clase I</option>
                                    <option value="Policía-Técnico-III" {{ old('grado')=="Policía-Técnico-III"
                                        ? 'selected' : '' }}>Policía Técnico III</option>
                                    <option value="Policía-Técnico-II" {{ old('grado')=="Policía-Técnico-II"
                                        ? 'selected' : '' }}>Policía Técnico II</option>
                                    <option value="Policía-Técnico-I" {{ old('grado')=="Policía-Técnico-I" ? 'selected'
                                        : '' }}>Policía Técnico I</option>
                                    <option
                                        value="Policía-Técnico"{{old('grado') == "Policía-Técnico" ? 'selected' : ''}}>
                                        Policía Técnico
                                    </option>
                                    <option value="Agente-Policía" {{ old('grado')=="Agente-Policía" ? 'selected' : ''
                                        }}>Agente Policía</option>
                                </optgroup>
                            </select>



                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Direccion de asignación: <span
                                class="required">*</span></label>
                        <div class="item form-group col-md-6 col-sm-6">
                                <select class="form-control" id="udep" type="text"
                                        style="text-transform: uppercase;"
                                        name="udep" required>
                                    <option></option>
                                    @foreach($lugarAsig as $lugarK => $lugarV)
                                        <option
                                            value="{{$lugarK}}" {{ old('udep') == $lugarK ? 'selected' : '' }}>
                                            {{$lugarV}}
                                        </option>
                                    @endforeach



                                </select>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Asignación policial: <span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 ">
                            <input name="assignment" id="assignment" onkeypress="validarLetras(event)" type="text"
                                style="text-transform: uppercase;" maxlength="40" minlength="3" class="form-control"
                                value="{{old('assignment')}}"
                                title="Ingrese una asignación policial válida (min: 3, max:40, solo letras)" required>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Dirección policial: <span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 ">
                            <input name="address" id="address" onkeypress="validarLetras(event)" type="text"
                                style="text-transform: uppercase;" maxlength="40" minlength="3" class="form-control"
                                value="{{old('address')}}"
                                title="Ingrese una dirección policial válida (min: 3, max:40, solo letras)" required>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Departamento policial:<span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 ">
                            <input name="department" id="department" onkeypress="validarLetras(event)" type="text"
                                style="text-transform: uppercase;" maxlength="40" minlength="3" class="form-control"
                                value="{{old('department')}}"
                                title="Ingrese una departamento policial válido (min: 3, max:40, solo letras)" required>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Nombre Usuario: <span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 ">
                            <input name="name" id="name" autocomplete="off" onkeypress="validarLetras(event)"
                                type="text" style="text-transform: uppercase;" maxlength="30" minlength="3"
                                class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}"
                                title="Ingrese un nombre válido (min: 3, max:30, solo letras)" required>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <i style="color: red">{{ $message }}</i>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Correo Electrónico: <span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 ">
                            <input class="form-control @error('email') is-invalid @enderror" name="email" id="email"
                                required="required" type="email" value="{{ old('email') }}">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <i style="color: red">{{ $message }}</i>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Contraseña: <span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 ">
                            <input class="form-control @error('password') is-invalid @enderror" type="password"
                                id="password" name="password"
                                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&amp;*]).{8,}"
                                value="{{ old('password') }}"
                                title="Mínimo 8 caracteres, incluidas letras mayúsculas y minúsculas, un número y un carácter único"
                                required="">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <i style="color: red">{{ $message }}</i>
                            </span>
                            @enderror
                            <span style="position: absolute;right:15px;top:7px;" onclick="hideshow()">
                                <i id="slash" class="fa fa-eye-slash"></i>
                                <i id="eye" class="fa fa-eye"></i>
                            </span>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Confirmar contraseña: <span
                                class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 ">
                            <input class="form-control @error('password_confirmation') is-invalid @enderror"
                                type="password" id="password_confirmation" name="password_confirmation"
                                pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*]).{8,}$"
                                value="{{ old('password_confirmation') }}"
                                title="Mínimo 8 caracteres, incluidas letras mayúsculas y minúsculas, número y carácter espdecial"
                                required="">
                            @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                <i style="color: red">{{ $message }}</i>
                            </span>
                            @enderror
                            {{-- <span style="position: absolute;right:15px;top:7px;" onclick="hideshow1()">
                                <i id="slash1" class="fa fa-eye-slash"></i>
                                <i id="eye1" class="fa fa-eye"></i>
                            </span> --}}
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="item form-row">
                        <div class="col-md-12 text-right">
                            <a type="button" class="btn btn-danger" href="{{route('registrousuario')}}">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

{{-- funcion de javascrip para el muestreo de la contraseña antes de guardarña --}}
<script>
    function hideshow(){
              var password = document.getElementById("password");
              var slash = document.getElementById("slash");
              var eye = document.getElementById("eye");

              if(password.type === 'password'){
                password.type = "text";
                slash.style.display = "block";
                eye.style.display = "none";
              }
              else{
                password.type = "password";
                slash.style.display = "none";
                eye.style.display = "block";
              }
            }
</script>
{{-- <script>
    function hideshow1(){
              var password = document.getElementById("password_confirmation");
              var slash = document.getElementById("slash1");
              var eye = document.getElementById("eye1");

              if(password.type === 'password'){
                password.type = "text";
                slash.style.display = "block";
                eye.style.display = "none";
              }
              else{
                password.type = "password";
                slash.style.display = "none";
                eye.style.display = "block";
              }
            }
</script> --}}

@stop
