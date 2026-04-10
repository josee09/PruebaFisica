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
                    <h2> Formulario de edición | LUGARES DE EVALUACION </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br/>
                    <form id="demo-form2" method="POST" action="{{ route('lugares-evaluacion.update', $lugar->id) }}"
                          data-parsley-validate
                          class="form-horizontal form-label-left">
                        @csrf
                        @method('PUT')
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Nombre: <span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 ">
                                <input name="descripcion" id="descripcion" onkeypress="validarLetras(event)" type="text"
                                       style="" maxlength="30" minlength="3"
                                       class="form-control"
                                       value="{{old('descripcion') ?? $lugar->descripcion}}"
                                       title="Ingrese un nombre válido (min: 3, max:30, solo letras)" required>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Tipo de prueba: <span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 d-flex align-items-center">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="chkFisica" name="chkFisica"
                                           value="1" {{ $lugar->fisica ? "checked" : ""}}>
                                    <label class="form-check-label" for="chkFisica">Fisica</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="chkMedica" name="chkMedica"
                                           value="1" {{ $lugar->medica ? "checked" : ""}}>
                                    <label class="form-check-label" for="chkMedica">Medica</label>
                                </div>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Estado del lugar: <span
                                    class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 d-flex align-items-center">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="rbEstado" type="radio" id="rbEstadoActivo"
                                           value="1" {{ $lugar->activo ? "checked" : ""}}>
                                    <label class="form-check-label" for="rbEstadoActivo">Habilitado</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="rbEstado" type="radio" id="rbEstadoInactivo"
                                           value="0" {{ !$lugar->activo ? "checked" : ""}}>
                                    <label class="form-check-label" for="rbEstadoInactivo">Deshabilitado</label>
                                </div>
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="item form-row">
                            <div class="col-md-12 text-right">
                                <a type="button" class="btn btn-danger" href="{{route('lugares-evaluacion.index')}}">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop
