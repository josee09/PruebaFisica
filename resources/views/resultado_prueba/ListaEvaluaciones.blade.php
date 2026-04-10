@extends('home')
@section('titulo')
    {{-- 8-6-23 creación de Vista para visualizar registros de evaluaciones fisicas --}}
@stop
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.18.0/font/bootstrap-icons.css">


</head>
@section('contenido')
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Lista de registros | EVALUACIÓN FÍSICA</h2>
                    <div class="clearfix"></div>
                </div>
                <style>
                    /* Aplicar mayúsculas a todas las celdas de la tabla */
                    table.table td {
                        text-transform: uppercase;
                    }
                </style>
                <div class="x_content">
                    <div class="row">
                        <div class="col-sm-12">
                            <form action="{{route('fisica.index')}}">
                                <div class="item form-group align-items-end d-flex">
                                    <div class="col-md-2 mb-3">
                                        <label>DIRECCION DE ASIGNACION</label>
                                        <select class="form-control" id="asignado" name="asignado" type="text"
                                                style="text-transform: uppercase;">
                                            <option value="" selected disabled></option>
                                            @foreach($lugarAsig as $key => $lugar)
                                                <option value="{{$key}}">{{$lugar}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label>GRADO DEL EVALUADO</label>
                                        <select class="form-control" id="grado" name="grado" type="text"
                                                style="text-transform: uppercase;">
                                            <option value="" selected disabled></option>
                                            @foreach($grados as $key => $grado)
                                                <option value="{{$key}}">{{$grado}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label>TIPO DE EVALUACION</label>
                                        <select class="form-control" id="tipo" name="tipo" type="text"
                                                style="text-transform: uppercase;">
                                            <option value="" selected disabled></option>
                                            <option value="ASCENSO">ASCENSO</option>
                                            <option value="DIAGNÓSTICA">DIAGNÓSTICA</option>
                                            <option value="ACUMULATIVA">ACUMULATIVA</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label>AÑO DE EVALUACION</label>
                                        <input name="anyo" id="anyo" type="text"
                                               style="text-transform: uppercase;" maxlength="30" minlength="3"
                                               class="form-control"
                                               title="Ingrese un nombre válido (min: 3, max:30, solo letras)">
                                    </div>
                                    <div class="col-md-1 mb-3 ">
                                        <button type="submit" class="btn btn-info mb-0"><i
                                                class="fas fa-search"></i></button>
                                        <button type="button" id="btnClear" class="btn btn-danger mb-0"><i
                                                class="fas fa-trash"></i></button>
                                    </div>

                                </div>
                            </form>

                            <div class="card-box table-responsive">
                                <table id="datatable-responsive"
                                       class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                       width="100%">
                                    <thead>
                                    <tr>
                                        <th scope="col" style="text-align: center">Fecha de Registro</th>
                                        <th scope="col" style="text-align: center">No. Identidad</th>
                                        <th scope="col" style="text-align: center">Nombre</th>
                                        <th scope="col" style="text-align: center">Evaluación</th>
                                        <th scope="col" style="text-align: center">Año</th>
                                        <th scope="col" style="text-align: center">Nota_Promedio</th>
                                        <th scope="col" style="text-align: center">Condicion</th>
                                        <th scope="col" style="text-align: center">Grado</th>
                                        <th scope="col" style="text-align: center">Lugar_Asignacion</th>
                                        <th scope="col" style="text-align: center">chapa</th>
                                        <th scope="col" style="text-align: center">Promocion</th>
                                        <th scope="col" style="text-align: center">Hoja de Control</th>
                                        <th scope="col" style="text-align: center">Opciones</th>
                                        <!-- Nuevas columnas agregadas -->
                                        <th scope="col" style="text-align: center">Nota_Pechada</th>
                                        <th scope="col" style="text-align: center">Nota_Abdominal</th>
                                        <th scope="col" style="text-align: center">Nota_Carrera</th>
                                        <th scope="col" style="text-align: center">Nota_Natación</th>
                                        <th scope="col" style="text-align: center">Nota_Caminata</th>
                                        <th scope="col" style="text-align: center">Nota_Ciclismo</th>
                                        <th scope="col" style="text-align: center">Nota_Barra</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($resultado as $resultado)
                                        <tr>
                                            <th scope="row" data-order="Desc">
                                                <center>{{ \Carbon\Carbon::parse($resultado->created_at)->format('d/m/Y') }}</center>
                                            </th>
                                            <td>
                                                <center>{{ $resultado->evaluado->dni }}</center>
                                            </td>
                                            <td>
                                                <center>{{ $resultado->evaluado->nombre }} {{ $resultado->evaluado->apellido }}</center>
                                            </td>
                                            <td>
                                                <center>{{ $resultado->evaluacion }}</center>
                                            </td>
                                            <td>
                                                <center>{{ $resultado->fecha }}</center>
                                            </td>
                                            <td>
                                                <center>{{ $resultado->npesoexc }}</center>
                                            </td>
                                            <td>
                                                <center>{{ $resultado->estado }}</center>
                                            </td>
                                            <td>
                                                <center>{{ $resultado->evaluado->grado }}</center>
                                            </td>
                                            <td>
                                                <center>{{ $resultado->evaluado->lugarAsignacion->LUGAR_ASIG ?? $resultado->evaluado->lugarasig }}</center>
                                            </td>
                                            <td>
                                                <center>{{ $resultado->evaluado->chapa }}</center>
                                            </td>
                                            <td>
                                                <center>{{ $resultado->evaluado->promocion }}</center>
                                            </td>
                                            @if ($resultado->doc_firma)
                                                <td>
                                                    <center><a style="color: white" type="button"
                                                               class="btn  btn-danger" data-toggle="modal"
                                                               data-target="#modalFirma{{ $resultado->id }}"
                                                               id="modalFirma"><i class="fa fa-file-pdf-o"></a></center>
                                                </td>
                                            @else
                                                <td>
                                                    <center><a href="{{route('fisica.pdf', $resultado->id)}}"><u>Visualizar</u><i
                                                                class="far fa-file-pdf" style="color: red;"></i></a>
                                                    </center>
                                                </td>

                                            @endif
                                            <td>
                                                <center>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-custom dropdown-toggle"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false"
                                                                style="font-size: 16px; font-weight: bold; background-color: #8B4513; color: white;">
                                                            <i class="fas fa-cog"></i> Acciones
                                                        </button>
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            @if ($resultado->doc_obs)
                                                                <a class="dropdown-item" data-toggle='modal'
                                                                   data-target="#DocObs{{ $resultado->id}}" id="DocObs">Visualizar
                                                                    Prescripción Médica</a>
                                                            @endif
                                                            @if (is_null($resultado->doc_firma))
                                                                <a class="dropdown-item" data-toggle='modal'
                                                                   data-target="#NuevaFirma{{ $resultado->id }}"
                                                                   id="NuevaFirma"
                                                                   style="font-size: 16px; font-weight: bold;">
                                                                    <i class="fas fa-plus"></i> Agregar Documento con
                                                                    Firmas
                                                                    @endif
                                                                    <form method="POST" id="delete-form"
                                                                          action="{{ route('fisica.destroy', $resultado->id) }}">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <a class="dropdown-item" type="submit"
                                                                           data-id="{{ $resultado->id }}"
                                                                           onclick="return confirmDelete(this)"
                                                                           style="font-size: 16px; font-weight: bold;">
                                                                            <i class="fas fa-trash"></i> Eliminar
                                                                            Registro
                                                                    </form>
                                                        </div>
                                                    </div>
                                                </center>
                                            </td>
                                            <!-- Nuevas columnas agregadas -->
                                            <td>
                                                <center>{{ $resultado->npechada }}</center>
                                            </td>
                                            <td>
                                                <center>{{ $resultado->nabdominal }}</center>
                                            </td>
                                            <td>
                                                <center>{{ $resultado->ncarrera }}</center>
                                            </td>
                                            <td>
                                                <center>{{ $resultado->nnatacion }}</center>
                                            </td>
                                            <td>
                                                <center>{{ $resultado->ncaminata }}</center>
                                            </td>
                                            <td>
                                                <center>{{ $resultado->nciclismo }}</center>
                                            </td>
                                            <td>
                                                <center>{{ $resultado->nbarra }}</center>
                                            </td>
                                        </tr>

                                        <!-- MODAL PARA VISUALIZAR DOCUMENTO PRESCRIPCIÓN MÉDICA -->
                                        <div class="modal fade bs-example-modal-lg" id="DocObs{{ $resultado->id }}"
                                             tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalFirmaLabel">Prescripción médica
                                                            | {{ $resultado->evaluado->nombre}} {{$resultado->evaluado->apellido}}</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        @if ($resultado->doc_obs)
                                                            <embed
                                                                src="{{ asset('storage/Obs_Fisicas/' . $resultado->doc_obs) }}"
                                                                type="application/pdf" width="100%" height="650px">
                                                        @else
                                                            <p>No se encontró una firma para mostrar.</p>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        @if ($resultado->doc_obs)
                                                            <p> {{ $resultado->doc_obs }}</p><a
                                                                href="{{ asset('storage/Obs_Fisicas/' . $resultado->doc_obs) }}"
                                                                download class="btn btn-primary">Descargar</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--  FIN MODAL PARA VISUALIZAR DOCUMENTO PRESCRIPCIÓN MÉDICA -->

                                        <!-- MODAL PARA VISUALIZAR DOCUMENTO HOJA DE CONTROL FIRMADA -->
                                        <div class="modal fade bs-example-modal-lg" id="modalFirma{{ $resultado->id }}"
                                             tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalFirmaLabel">Hoja de control |
                                                            EVALUACIÓN FÍSICA</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        @if ($resultado->doc_firma)
                                                            <embed
                                                                src="{{ asset('storage/Firmas_Fisicas/' . $resultado->doc_firma) }}"
                                                                type="application/pdf" width="100%" height="650px">
                                                        @else
                                                            <p>No se encontró una firma para mostrar.</p>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        @if ($resultado->doc_firma)
                                                            <p> {{ $resultado->doc_firma }}</p><a
                                                                href="{{ asset('storage/Firmas_Fisicas/' . $resultado->doc_firma) }}"
                                                                download class="btn btn-primary">Descargar</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--  FIN MODAL PARA VISUALIZAR DOCUMENTO HOJA DE CONTROL FIRMADA -->

                                        {{-- Modal para agregar doc de firmas --}}
                                        @include('resultado_prueba/GuardarFirmas')

                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
        </div>
    </div>





    {{-- validación JavaScript --}}
    <script>
        // Confirmacion de borrado
        function confirmDelete(button) {
            var id = button.getAttribute('data-id');
            if (confirm('¿Está seguro de que desea eliminar este registro?')) {
                var url = '{{ route("fisica.destroy", ":id") }}';
                var url = '{{ route("fisica.destroy", ":id") }}';
                url = url.replace(':id', id);
                document.getElementById('delete-form').setAttribute('action', url);
                document.getElementById('delete-form').submit();
            }
            return false;
        }
    </script>

    <script>
        const btnClear = document.getElementById('btnClear');
        btnClear.addEventListener('click', function () {
            location.href = '{{route('fisica.index')}}';
        })
    </script>

@stop

