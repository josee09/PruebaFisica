@extends('home')
@section('titulo')
{{-- 18-4-23 creación de Vista para visualizar registros de personal --}}
@stop
@section('contenido')

<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
            <div class="x_title">
                <h2> Lista de registros | EVENTOS ALTERNOS</h2>
                <div class="clearfix"></div>
            </div>
            {{-- eventos alternos --}}
            <datalist id="natacion" name="natacion">
                @foreach ($natacion as $natacion)
                <option value="{{$natacion->tiempo}}"></option>
                @endforeach
            </datalist>
            <datalist id="caminata" name="caminata">
                @foreach ($caminata as $caminata)
                <option value="{{$caminata->tiempo}}"></option>
                @endforeach
            </datalist>
            <datalist id="ciclismo" name="ciclismo">
                @foreach ($ciclismo as $ciclismo)
                <option value="{{$ciclismo->tiempo}}"></option>
                @endforeach
            </datalist>
            <datalist id="barra" name="barra">
                @foreach ($barra as $barra)
                <option value="{{$barra->repeticiones}}"></option>
                @endforeach
            </datalist>

            <div class="x_content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            <table id="datatable-responsive"
                                class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th scope="col" style="text-align: center">Fecha de Registro</th>
                                        <th scope="col" style="text-align: center">No. Identidad</th>
                                        <th scope="col" style="text-align: center">Nombre</th>
                                        <th scope="col" style="text-align: center">Natación</th>
                                        <th scope="col" style="text-align: center">Caminata</th>
                                        <th scope="col" style="text-align: center">Ciclismo</th>
                                        <th scope="col" style="text-align: center">Barra</th>
                                        {{-- No incluir el botón de acciones aquí --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($alterno as $alterno)
                                    <input type="hidden" name="id_principal" value="{{$alterno->principal->id}}">
                                    <tr>
                                        {{-- formato de fecha d/m/y --}}
                                        <th scope="row"><center>
                                                {{\Carbon\Carbon::parse($alterno->created_at)->format('d/m/Y')}}
                                            </center></th>
                                        <td><center>{{$alterno->evaluado->dni}}</center></td>
                                        <td><center>{{$alterno->evaluado->nombre}} {{$alterno->evaluado->apellido}}</center></td>
                                        <td><center>{{$alterno->natacion}}</center></td>
                                        <td><center>{{$alterno->caminata}}</center></td>
                                        <td><center>{{$alterno->ciclismo}}</center></td>
                                        <td><center>{{$alterno->barra}}</center></td>
                                        {{-- No incluir el código del botón de acciones aquí --}}
                                        {{-- Modal para editar registro --}}
                                        @include('alternos/EditarAlterno')
                                    </tr>
                                    @endforeach
                                <tbody>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
        </div>
    </div>
</div>

{{-- validación JavaScript --}}
<script>
    // Confirmacion de borrado
    function confirmDelete(button) {
        var id = button.getAttribute('data-id');
        if (confirm('¿Está seguro de que desea eliminar este registro?')) {
            var url = '{{ route("alterno.destroy", ":id") }}';
            url = url.replace(':id', id);
            document.getElementById('delete-form').setAttribute('action', url);
            document.getElementById('delete-form').submit();
        }
        return false;
    }
</script>

@stop
