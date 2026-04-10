@extends('home')
@section('titulo')
{{-- 09-06-23 creación de Vista para listado de roles --}}
@stop
@section('contenido')
<div class="clearfix"></div>
  <div class="row">
    <div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
      <div class="x_title">
        <h2> Lista de registros | ROLES </h2>
            <div align="right">

                <a type="button" class="btn  btn-primary" href="{{route('Roles.create')}}">Nuevo Registro</a>

            </div>
        <div class="clearfix"></div>
      </div>
        <div class="x_content">
          <div class="row">
              <div class="col-sm-12">
                <div class="card-box table-responsive">
                  <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th scope="col" style="text-align: center">Id</th>
                        <th scope="col" style="text-align: center">Fecha de Creación</th>
                        <th scope="col" style="text-align: center">Nombre</th>
                        <th scope="col" style="text-align: center">Opciones</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($role as $role )
                        <tr>
                            <td><center>{{ $role->id }}</center></td>
                            <td scope="row"><center>{{\Carbon\Carbon::parse($role->created_at)->format('d/m/Y')}}</center></td>
                            <td><center>{{$role->name}}</center></td>
                            <td><center>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-custom dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    style="font-size: 16px; font-weight: bold; background-color: #8B4513; color: white;">
                                    <i class="fas fa-cog"></i> Acciones
                                </button>
                                  <div class="dropdown-menu">

                                    <a class="dropdown-item" href="{{ route('Roles.edit', $role->id) }}" class="btn btn-success">Editar</a>

                                {{-- formulario para eliminacion de roles --}}
                                <div class="dropdown-divider"></div>
                                <form method="POST" id="delete-form" action="{{ route('Role.destroy', $role->id)}}">
                                    @csrf
                                    @method('DELETE')

                                    <a class="dropdown-item" type="submit" class="btn btn-danger" data-id="{{ $role->id }}" onclick="return confirmDelete(this)">Eliminar</a>

                                  </form>
                                  </div>
                            </center>
                            <script>
                                function confirmDelete(button) {
                                  var id = button.getAttribute('data-id');
                                  if (confirm('¿Está seguro de que desea eliminar este ROL?')) {
                                    var url = '{{ route("Role.destroy", ":id") }}';
                                    url = url.replace(':id', id);
                                    document.getElementById('delete-form').setAttribute('action', url);
                                    document.getElementById('delete-form').submit();
                                  }
                                  return false;
                                }
                              </script>
                        </td>
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

