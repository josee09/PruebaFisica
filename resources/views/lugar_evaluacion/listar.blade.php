@extends('home')
@section('titulo')
    {{-- 24-4-23 creación de Vista para visualizar registros de usuario --}}
@stop
@section('contenido')

    <!-- page content -->
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
            <div class="x_title">
                <h2> Lista de registros | LUGARES DE EVALUACION </h2>
                <div align="right">

                    <a type="button" class="btn btn-primary" href="{{route('lugares-evaluacion.create')}}">Nuevo
                        Registro</a>

                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            <table id="datatable-responsive"
                                   class="table table-striped table-bordered dt-responsive nowrap"
                                   cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th scope="col" style="text-align: center">Lugar de evaluacion</th>
                                    <th scope="col" style="text-align: center">Tipo de evaluacion</th>
                                    <th scope="col" style="text-align: center">Estado</th>
                                    <th scope="col" style="text-align: center">Opciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($lugares as $lugarEvaluacion)
                                    <tr>
                                        <td>
                                            <center>{{$lugarEvaluacion->descripcion}}</center>
                                        </td>
                                        <td>
                                            <center>
                                                @if($lugarEvaluacion->medica)
                                                    <span class="badge badge-success">MEDICA</span>
                                                @endif
                                                @if($lugarEvaluacion->fisica)
                                                    <span class="badge badge-primary">FISICA</span>
                                                @endif
                                            </center>
                                        </td>
                                        <td>
                                            <center>
                                                @if($lugarEvaluacion->activo)
                                                    <span class="badge badge-success">HABILITADO</span>
                                                @else
                                                    <span class="badge badge-secondary">DESHABILITADO</span>

                                                @endif
                                            </center>
                                        </td>
                                        <td>
                                            <center>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-custom dropdown-toggle"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false"
                                                            style="font-size: 16px; font-weight: bold; background-color: #8B4513; color: white;">
                                                        <i class="fas fa-cog"></i> Acciones
                                                    </button>
                                                    <div class="dropdown-menu">

                                                        <a class="dropdown-item"
                                                           href="{{route('lugares-evaluacion.edit', $lugarEvaluacion->id)}}"
                                                           style="font-size: 16px; font-weight: bold;">Editar</a>

{{--                                                        <a class="dropdown-item"--}}
{{--                                                           href="{{route('lugares-evaluacion.asignar', $lugarEvaluacion->id)}}"--}}
{{--                                                           style="font-size: 16px; font-weight: bold;">Asignar Tipo de--}}
{{--                                                            Prueba</a>--}}

                                                        <div class="dropdown-divider"></div>

                                                        <form method="POST" id="delete-form"
                                                              action="{{ route('lugares-evaluacion.destroy', $lugarEvaluacion->id)}}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a class="dropdown-item btn btn-danger" type="submit"
                                                               data-id="{{ $lugarEvaluacion->id }}"
                                                               onclick="return confirmDelete(this)"
                                                               style="font-size: 16px; font-weight: bold;">Deshabilitar</a>
                                                        </form>

                                                    </div>
                                                </div>
                                            </center>
                                        </td>
{{--                                        Confirmar borrado--}}
                                        <script>
                                            function confirmDelete(button) {
                                                var id = button.getAttribute('data-id');
                                                if (confirm('¿Está seguro de que desea eliminar este registro?')) {
                                                    var url = '{{ route("lugares-evaluacion.destroy", ":id") }}';
                                                    url = url.replace(':id', id);
                                                    document.getElementById('delete-form').setAttribute('action', url);
                                                    document.getElementById('delete-form').submit();
                                                }
                                                return false;
                                            }
                                        </script>
                                    </tr>
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
@stop
