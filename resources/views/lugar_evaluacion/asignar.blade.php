@extends('home')
@section('titulo')
{{-- 24-4-23 creación de Vista para asignar rol --}}
@stop
@section('contenido')

    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_title">
            <h2> Formulario de asignación de roles | USUARIOS </h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />
            <form id="demo-form2" method="POST" action="{{ route('Usuario.roles.update', $Usuario->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                @csrf
                {{-- {{ mehod_field(´PUT') }} --}}
                @method('PUT')
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align"for="name">Nombre del Usuario: <span class="required"></span>
                    </label>
                    <div class="col-md.6 col-sm-6">
                            <input type="text" trimEnd() class="form-control"   
                            maxlength="30"  id="name" name="name" value="{{old('name') ?? $Usuario->name}}" required readonly>
                     </div>
                    </div> 
                            <h2> Formulario de asignación | ROLES </h2>
                            <div class="clearfix"></div>
                            </div>
                            {{-- ciclo para visualizar los permisos de la tala permissions --}}
                        @foreach( $Role as  $Role)
                            <div>
                                <label>
                                    <input type="checkbox" name="Role[]" value="{{ $Role->id }}" class="m-1">                                       
                                    {{ $Role->name }}
                                </label>
                            </div>
                        @endforeach
            <div class="ln_solid"></div>
            <div class="item form-row">
                <div class="col-md-12 text-right">
            <a type="button" class="btn btn-danger" href="{{route('registrousuario')}}"> Cancelar </a>
            <button type="submit" class="btn btn-primary" > Asignar Rol </button>
        </div>
        </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@stop        