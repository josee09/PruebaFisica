@extends('home')
@section('titulo')
{{-- 24-4-23 creación de Vista para visualizar registros de usuario --}}
@stop
@section('contenido')

<!-- page content -->
<div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
        <div class="x_title">
            <h2> Lista de registros | USUARIO </h2>
            <div align="right">

                <a type="button" class="btn btn-primary" href="{{route('NuevoUsuario')}}">Nuevo Registro</a>

            </div>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box table-responsive">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"
                            cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" style="text-align: center">Fecha Registro</th>
                                    <th scope="col" style="text-align: center">Correo Electrónico</th>
                                    <th scope="col" style="text-align: center">Usuario</th>
                                    <th scope="col" style="text-align: center">Nombre</th>
                                    <th scope="col" style="text-align: center">Rol</th>
                                    <th scope="col" style="text-align: center">Asignación Policial</th>
                                    <th scope="col" style="text-align: center">Grado Policial</th>
                                    <th scope="col" style="text-align: center">Direccion de Asignación</th>

                                    <th scope="col" style="text-align: center">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($Usuario as $Usuario)
                                <tr>
                                    @php
                                    $Rol = DB::table('model_has_roles')->where('model_id', $Usuario->id)->first();
                                    if ($Rol) {
                                    $nombreRol = DB::table('roles')->where('id', $Rol->role_id)->first();
                                    }else {
                                    $nombreRol = Null;
                                    }
                                    @endphp
                                    <th scope="row">
                                        <center>{{\Carbon\Carbon::parse($Usuario->created_at)->format('d/m/Y')}}
                                        </center>
                                    </th>
                                    <td>
                                        <center>{{$Usuario->email}}</center>
                                    </td>
                                    <td>
                                        <center>{{$Usuario->name}}</center>
                                    </td>
                                    <td>
                                        <center>{{$Usuario->firstname}} {{$Usuario->lastname}}</center>
                                    </td>
                                    <td>
                                        <center>@if ($nombreRol)
                                            {{$nombreRol->name}}
                                            @else
                                            No Asignado
                                            @endif
                                        </center>
                                    </td>
                                    <td>
                                        <center>{{$Usuario->assignment}}</center>
                                    </td>
                                    <td>
                                        <center>{{$Usuario->grado}}</center>
                                    </td>
                                    <td>
                                        <center>{{$Usuario->udep}}</center>
                                    </td>

                                    <td>
                                        <center>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-custom dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                    style="font-size: 16px; font-weight: bold; background-color: #8B4513; color: white;">
                                                    <i class="fas fa-cog"></i> Acciones
                                                </button>
                                                <div class="dropdown-menu">

                                                    <a class="dropdown-item"
                                                        href="{{route('Usuario.edit', $Usuario->id)}}"
                                                        style="font-size: 16px; font-weight: bold;">Editar</a>

                                                    <a class="dropdown-item"
                                                        href="{{route('Usuario.roles', $Usuario->id)}}"
                                                        style="font-size: 16px; font-weight: bold;">Asignar Rol</a>

                                                    <div class="dropdown-divider"></div>

                                                    <form method="POST" id="delete-form"
                                                        action="{{ route('Usuario.destroy', $Usuario->id)}}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a class="dropdown-item btn btn-danger" type="submit"
                                                            data-id="{{ $Usuario->id }}"
                                                            onclick="return confirmDelete(this)"
                                                            style="font-size: 16px; font-weight: bold;">Eliminar</a>
                                                    </form>

                                                </div>
                                            </div>
                                        </center>
                                        {{-- Confirmar borrado --}}
                                        <script>
                                            function confirmDelete(button) {
                                var id = button.getAttribute('data-id');
                                if (confirm('¿Está seguro de que desea eliminar este registro?')) {
                                  var url = '{{ route("Usuario.destroy", ":id") }}';
                                  url = url.replace(':id', id);
                                  document.getElementById('delete-form').setAttribute('action', url);
                                  document.getElementById('delete-form').submit();
                                }
                                return false;
                              }
                                        </script>
                                </tr>
                                @endforeach
                                </tr>
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
