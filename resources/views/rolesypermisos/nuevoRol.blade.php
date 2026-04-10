@extends('home')
@section('titulo')
{{-- 12-06-23 creación de Vista para creacion de nuevos roles --}}
@stop
@section('contenido')
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
            <div class="x_title">
                <h2> Formulario de registro | ROLES </h2>
                <div class="clearfix"></div>
            </div>
                <div class="x_content">
                    <br />
                    <form id="permissions" name="Nombre_rol" method="POST" action="{{ route('Roles.store') }}" data-parsley-validate class="form-horizontal form-label-left">
                        @csrf
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="Nombre rol">Nombre de ROL sin espacios en blanco: <span class="required">*</span></label>
                            <div class="col-md.6 col-sm-6">
                                    <input type="tex" trimEnd() class="form-control @error('name') is-invalid @enderror"   
                                    maxlength="30" id="name" name="name" placeholder="Ingrese el nombre del nuevo ROL" value="{{old('name')}}" required>
                                    @error('ROL')
                                    <span class="invalid-feedback" role="alert">
                                       <i style="color: red">{{ $message }}</i>
                                    </span>
                               @enderror
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-6">
                            <div class="x_title">
                                <h2> Formulario de permisos | ROLES </h2>
                                <div class="clearfix"></div>
                                </div>
                                {{-- ciclo para visualizar los permisos de la tala permissions --}}
                            <div class="row">
                                @foreach( $permissions as  $permissions)
                            <div class="col-md-6 col-sm-12">
                                    <label><h6>
                                        <input type="checkbox" name="permissions[]" value="{{ $permissions->id }}" class="m-1">
                                        {{ $permissions->description }}
                                    </h6></label>
                                </div>
                            @endforeach
                        </div>        
                        <div class="ln_solid"></div>
                        <div class="item form-row">
                            <div class="col-md-12 text-right">
                            <a type="button" class="btn btn-danger" href="{{route('Roles.index')}}">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                        </div> 

                    </form>
                </div>
        </div>
    </div>
</div>
@stop