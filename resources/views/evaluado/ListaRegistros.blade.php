@extends('home')
@section('titulo')
    {{-- 18-4-23 creación de Vista para visualizar registros de personal --}}
@stop
@section('contenido')

    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <style>
            /* Anula los estilos predeterminados de btn-success y define tu propio color */
            .btn-success {
                background-color: #008000;
                /* Verde fuerte (#008000) */
                border-color: #008000;
            }

            .btn-success:hover {
                background-color: #006400;
                /* Cambia el color al pasar el mouse si lo deseas */
                border-color: #006400;
            }

            /* Estilo para todas las tablas */
            .custom-table {
                width: 100%;
                border-collapse: collapse;
            }

            .custom-table th,
            .custom-table td {
                border: 1px solid #1f1e1e;
                padding: 10px;
                text-align: center;
            }

            .custom-table th {
                background-color: #a3a0a09c;
            }

            .custom-table tr:nth-child(odd) {
                background-color: hsl(0, 0%, 100%);
            }

            .custom-table tr:hover {
                background-color: #7d807e;
            }

            /* Estilo para el título por lugar de asignación */
            .custom-table-title {
                text-align: center;
                font-weight: bold;
                font-size: 30px;
                font-style: italic;
                color: #3498db; /* Color azul claro */
                margin-bottom: 15px; /* Agrega un margen inferior para separar el título de las tablas */
            }

            /* Estilo para el contador en la esquina izquierda */
            .contador {
                font-size: 20px;
                font-weight: bold; /* Agrega negrita al contador */
                float: left; /* Alinea el contador a la izquierda */
                margin-right: 1px; /* Agrega un margen a la derecha para separar el contador del título */
            }
        </style>
    </head>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="x_panel">
                <div class="x_title">
                    {{--FORMULARIO DONDE SE MOSTRARA LOS DATOS--}}
                    <h2> Lista de registros | PERSONAL </h2>
                    <div align="right">
                        <a type="button" class="btn btn-success" align="right" href="{{ route('registro.excel') }}">
                            <i class="fas fa-file-excel"></i> Registro Excel
                        </a>
                        <a type="button" class="btn btn-primary" align="right" href="{{route('registro.create')}}">
                            <i class="fas fa-plus"></i> Nuevo Registro
                        </a>
                        <a type="button" class="btn btn-primary" align="right" data-toggle="modal"
                           data-target="#exampleModal" style="color: #fff !important;">
                            <i class="fas fa-plus"></i> Nuevo Registro SIG
                        </a>
                        <div class="clearfix"></div>
                    </div>
                </div>
                {{--FILTROS (EMM)--}}
                <div class="x_content">
                    <div class="row">
                        {{--Primer Filtro--}}
                        <div class="col-md-5">
                            <div class="form-group">
                                {{--Por tema de la carga masiva de datos que tendra el aplicativo, el filtro mediante nombre-apellido, No de identidad o lugar de asignacion sera mediante recarga de pagina--}}
                                <form method="GET" action="{{ route('registros.index') }}">
                                    <label for="search">Buscar por Nombre o Apellido:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="search" id="search" value="{{ request('search') }}"
                                               placeholder="Nombre o Apellido...">
                                        <div class="input-group-append">
                                            @if (request()->filled('search'))
                                                <button onclick="window.location ='{{ route('registros.index') }}'" class="btn btn-secondary" type="button">
                                                    <i class="fas fa-times"></i> Borrar
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        {{--Segundo Filtro--}}
                        <div class="col-md-5">
                            <div class="form-group">
                                <form method="GET" action="{{ route('registros.index') }}">
                                    <label for="search">Buscar por Identidad:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="searchDNI" id="searchDNI" value="{{ request('searchDNI') }}"
                                            placeholder="No Identidad...">
                                        <div class="input-group-append">
                                            @if (request()->filled('searchDNI'))
                                                <button onclick="window.location = '{{ route('registros.index') }}'" class="btn btn-secondary" type="button">
                                                    <i class="fas fa-times"></i> Borrar
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        {{--Tercer Filtro--}}
                        <div class="col-md-5">
                            <div class="form-group">
                                <form method="GET" action="{{ route('registros.index') }}">
                                    <label for="search">Buscar por Lugar asignado:</label>
                                    <div class="select-group">
                                        <select class="form-control" name="LugarAsignado" id="search-lug-asig" onchange="this.form.submit()">
                                            <option value="">Seleccione</option>
                                            {{-- Foreach para tomar los nombres de los lugares de asignacion que existan en la BD --}}
                                            @foreach ($lugaresAsignacion as $claveSig => $lugarAsignacion)
                                                <option value="{{ $claveSig }}" {{ $searchLugarAsignado == $claveSig ? 'selected' : '' }}>
                                                    {{ $lugarAsignacion }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{--Filtro para mostrar x cantidad de filas en las tablas--}}
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="select-group">
                                    <form method="GET" action="{{ route('registros.index') }}">
                                        <label for="label1" style="font-size: 13pt;">Mostrar </label>
                                        <select name="Rows" id="rowsPerPage" style="font-size: 13pt;" onchange="this.form.submit()">
                                            <option value="10" {{ request('Rows') == 10 ? 'selected' : '' }}>10</option>
                                            <option value="20" {{ request('Rows') == 20 ? 'selected' : '' }}>20</option>
                                            <option value="30" {{ request('Rows') == 30 ? 'selected' : '' }}>30</option>
                                        </select>
                                        <label for="label2" style="font-size: 13pt;"> filas por tabla </label>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mostrar mensaje cuando no se encuentren resultados -->
                    @if ($evaluado->isEmpty())
                        <div id="no-results-message" style="text-align: center; margin-top: 10px; font-weight: bold; color: red;">
                            No se encontraron resultados.
                        </div>
                    @else
                        <!-- Iterar sobre los registros agrupados por lugar de asignación -->
                        @foreach ($evaluado->groupBy('lugarasig') as $lugarAsignacion => $registros)
                            <h3 id="LugAsig" data-table-id="{{ 'table_' . Str::slug($lugarAsignacion) }}" class="custom-table-title">{{ $registros[0]->lugarAsignacion->DENOMINACION ?? $lugarAsignacion }} <span class="contador">({{ $registros->count() }} registros)</span>
                            </h3> <!-- Agregar contador -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card-box table-responsive">
                                        <table class="custom-table" id="{{ 'table_' . Str::slug($lugarAsignacion) }}">
                                            <thead>
                                            <tr>
                                                <th scope="col" style="text-align: center">Fecha Registro</th>
                                                <th scope="col" style="text-align: center">No. Identidad</th>
                                                <th scope="col" style="text-align: center">Nombre</th>
                                                <th scope="col" style="text-align: center">Apellido</th>
                                                <th scope="col" style="text-align: center">Sexo</th>
                                                <th scope="col" style="text-align: center">Fecha de Nacimiento</th>
                                                <th scope="col" style="text-align: center">Edad</th>
                                                <th scope="col" style="text-align: center">Correo Electrónico</th>
                                                <th scope="col" style="text-align: center">Telefono</th>
                                                <th scope="col" style="text-align: center">Grado-Policial</th>
                                                <th scope="col" style="text-align: center">Clasificacion</th>
                                                <th scope="col" style="text-align: center">Promoción</th>
                                                <th scope="col" style="text-align: center">Chapa</th>
                                                <th scope="col" style="text-align: center">Opciones</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($registros as $registro)
                                                <tr>
                                                    {{-- formato de fecha d/m/y --}}
                                                    <th scope="row" data-order="Desc">
                                                        <center>{{\Carbon\Carbon::parse($registro->created_at)->format('d/m/y')}}</center>
                                                    </th>
                                                    <td>
                                                        <center>{{$registro->dni}}</center>
                                                    </td>
                                                    <td>
                                                        <center>{{$registro->nombre}}</center>
                                                    </td>
                                                    <td>
                                                        <center>{{$registro->apellido}}</center>
                                                    </td>
                                                    <td>
                                                        <center>{{$registro->sexo}}</center>
                                                    </td>
                                                    <td>
                                                        <center>{{\Carbon\Carbon::parse($registro->fechanac)->format('d/m/Y')}}</center>
                                                    </td>
                                                    <td>
                                                        <center>{{\Carbon\Carbon::parse($registro->fechanac)->age}}</center>
                                                    </td>
                                                    <td>
                                                        <center>{{$registro->email}}</center>
                                                    </td>
                                                    <td>
                                                        <center>{{$registro->telefono}}</center>
                                                    </td>
                                                    <td>
                                                        <center>{{ strtoupper($registro->grado) }}</center>
                                                    </td>
                                                    <td>
                                                        <center>{{$registro->categoria}}</center>
                                                    </td>
                                                    <td>
                                                        <center>{{$registro->promocion}}</center>
                                                    </td>
                                                    <td>
                                                        <center>{{ strtoupper($registro->chapa) }}</center>
                                                    </td>
                                                    {{--NO TOCAR SON LOS BOTONES DE ACCIONES--}}
                                                    <td>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-custom dropdown-toggle"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false"
                                                                    style="font-size: 16px; font-weight: bold; background-color: #8B4513; color: white;">
                                                                <i class="fas fa-cog"></i> Acciones
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item"
                                                                href="{{ route('registro.edit', $registro->id) }}"
                                                                style="font-size: 16px; font-weight: bold;">Editar
                                                                    Registro</a>
                                                                <form method="POST" id="delete-form"
                                                                    action="{{ route('registro.destroy', $registro->id) }}">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="dropdown-item"
                                                                            type="submit"
                                                                            data-id="{{ $registro->id }}"
                                                                            onclick="return confirmDelete(this)"
                                                                            style="font-size: 16px; font-weight: bold;">
                                                                        Eliminar Registro
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <br> <!-- Agrega un salto de línea entre las tablas -->
                        @endforeach
                    @endif

                    {{--BOTON DE PAGINACION (Referencia en AppServiceProvider)--}}
                    <div class="card-footer">
                        {{ $evaluado->appends(['Rows' => request('Rows')])->links() }}
                    </div>
                </div>
            </div>
        </div>
        <div>
        </div>
    </div>

    {{-- Confirmar borrado --}}
    <script>
        function confirmDelete(button) {
            var id = button.getAttribute('data-id');
            if (confirm('¿Está seguro de que desea eliminar este registro, incluyendo sus evaluaciones registradas?')) {
                var url = '{{ route("registro.destroy", ":id") }}';
                url = url.replace(':id', id);
                document.getElementById('delete-form').setAttribute('action', url);
                document.getElementById('delete-form').submit();
            }
            return false;
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- MODAL DE CREAR USUARIOS SIG -->
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">CREACION DE EVALUADO DATOS SIG</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="item form-group">
                        <label class="col-form-label col-md-4 col-sm-4 label-align">No. Identidad: <span
                                class="required">*</span></label>
                        <div class="col-md-8 col-sm-8 ">
                            <input id=dni name="dni" type="text" onkeypress="validarNumeros(event)" maxlength="13"
                                   minlength="13" class="@error('dni') is-invalid @enderror form-control" required
                                   value="" title="Ingrese una identidad válida"
                                   placeholder="Ingrese DNI sin guiones">
                            @error('dni')
                            <span class="invalid-feedback" role="alert">
													<i style="color: red">{{ $message }}</i>
											</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="btnDniEvaluado">Crear evaluado</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        //var evaluaciones
        document.getElementById('btnDniEvaluado').addEventListener("click", async function (e) {
            e.preventDefault();
            const dni = document.getElementById('dni').value;
            const token = '{{csrf_token()}}'; // Supongamos que esta función obtiene el token de alguna manera
            const data = {dni: dni, _token: token};
            try {

                const response = await fetch("{{route('registro.dniCreate')}}", {
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
                    alert("Se creo al evaludado " + dni + " - " + responseData.grado + " "
                        + responseData.nombre + " " + responseData.apellido)
                    //document.getElementById('nomEvaluado').value = responseData[0].nombreCompleto;
                    //document.getElementById('dniEvaluado').value = responseData[0].id;


                }

            } catch (error) {
                console.error("Error al realizar la petición:", error);
            }
        });
    </script>
@stop
