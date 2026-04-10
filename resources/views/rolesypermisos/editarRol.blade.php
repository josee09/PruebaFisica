@extends('home')
@section('titulo')
{{-- 13-06-23 creación de Vista para creacion de edicion de roles --}}
@stop
@section('contenido')
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
            <div class="x_title">
                <h2> Formulario de nuevos | ROLES </h2>
                <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br>
                    <form id="permissions" name="permissions" method="POST" action="{{ route('Roles.update', $Role->id) }}"  data-parsley-validate class="form-horizontal form-label-left">
                        @csrf
                        {{-- {{ mehod_field(´PUT') }} --}}
                        @method('PUT')
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="Nombre rol">Nombre de ROL sin espacios en blanco: <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6">
                                    <input type="tex" trimEnd() class="form-control @error('name') is-invalid @enderror"   
                                    maxlength="30" value="{{old('name') ?? $Role->name}}" title="Ya hay un ROL con ese NOMBRE" id="name" name="name"
                                    value="{{old('name')}}" required>
                                    @error('ROL')
                                    <span class="invalid-feedback" role="alert">
                                       <i style="color: red">{{ $message }}</i>
                                    </span>
                               @enderror
                             </div>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <div class="x_title">
                                <h2> Formulario de permisos | ROLES </h2>
                                <div class="clearfix"></div>
                                </div>
                                {{-- ciclo para visualizar los permisos de la tala permissions --}}
                                <div class="row">
                                    @foreach($permissions as $permission)
                                    <div class="col-md-6 col-sm-12">
                                        <label><h6>
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="m-1" {{ $Role->permissions->contains($permission->id) ? 'checked' : '' }}>
                                            {{ $permission->description }}
                                        </h6></label>
                                    </div>
                                    @endforeach
                                </div>
                            <div class="ln_solid"></div>
                            <div class="item form-group">
                                <div class="col-md-6 col-sm-6 offset-md-3">
                                    <a type="button" class="btn btn-danger" href="{{route('Roles.index')}}">Cancelar</a>
                              

                                <button type="submit" class="btn btn-primary" >Guardar</button>
                            </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop