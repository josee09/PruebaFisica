@extends('home')
@section('titulo')
    {{-- 24-4-23 creación de Vista para visualizar registros de usuario --}}
@stop
@section('contenido')

    <!-- page content -->
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
            <div class="x_title">
                <h2> Lista de registros | TERNAS EVALUADORAS </h2>
                <div align="right">

                    <a type="button" class="btn btn-primary" href="{{route('terna-evaluadora.create')}}">Nuevo
                        Registro</a>

                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            <table id="datatable-responsive"
                                   class="table table-striped table-bordered dt-responsive nowrap"
                                   cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th scope="col" style="text-align: center">Descripcion</th>
                                    <th scope="col" style="text-align: center">Jefe Evaluador</th>
                                    <th scope="col" style="text-align: center">Evaluador 1</th>
                                    <th scope="col" style="text-align: center">Evaluador 2</th>
                                    <th scope="col" style="text-align: center">Evaluador 3</th>
                                    <th scope="col" style="text-align: center">Evaluador 4</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($ternasEvaluadoras as $terna)
                                    <tr>
                                        <td>
                                            <center>{{$terna->descripcion}}</center>
                                        </td>
                                        <td>
                                            <center>{{$terna->evaluadorJefe->nombreCompletoRango()}}</center>
                                        </td>
                                        <td>
                                            <center>{{$terna->evaluador1->nombreCompletoRango()}}</center>
                                        </td>
                                        <td>
                                            <center>{{$terna->evaluador2->nombreCompletoRango()}}</center>
                                        </td>
                                        @isset($terna->evaluador3)
                                        <td>
                                            <center>{{$terna->evaluador3->nombreCompletoRango()}}</center>
                                        </td>
                                        @endisset

                                        @empty($terna->evaluador3)
                                         <td>
                                            <center> </center>
                                        </td>
                                        @endempty
                                       
                                        @isset($terna->evaluador4)
                                        <td>
                                            <center>{{$terna->evaluador4->nombreCompletoRango()}}</center>
                                        </td>
                                        @endisset

                                        @empty($terna->evaluador4)
                                        <td>
                                            <center> </center>
                                        </td>
                                        @endempty
                                        
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
                                                           href="{{route('terna-evaluadora.edit', $terna->id)}}"
                                                           style="font-size: 16px; font-weight: bold;">Editar</a>

                                                        <a class="dropdown-item"
                                                           href="{{route('terna-evaluadora.asignar', $terna->id)}}"
                                                           style="font-size: 16px; font-weight: bold;">Asignar
                                                            Evaluados</a>

                                                        <div class="dropdown-divider"></div>

                                                        <form method="POST" id="delete-form"
                                                              action="{{ route('terna-evaluadora.destroy', $terna->id)}}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a class="dropdown-item btn btn-danger" type="submit"
                                                               data-id="{{ $terna->id }}"
                                                               onclick="return confirmDelete(this)"
                                                               style="font-size: 16px; font-weight: bold;">Borrar</a>
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
                                                    var url = '{{ route("terna-evaluadora.destroy", ":id") }}';
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
