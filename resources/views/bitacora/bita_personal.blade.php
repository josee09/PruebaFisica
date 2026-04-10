@extends('home')
@section('titulo')
{{-- 28-4-23 creación de Vista para visualizar registros de bitacora del peresonal --}}
@stop
@section('contenido')

<div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
        <div class="x_title">
            <h2> Bitácora | REGISTRO PERSONAL EVALUADO</h2>
            <div></br></br></div>
                 <div class="clearfix"></div>
        </div>
        <div class="x_content"> 
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box table-responsive">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                <th scope="col" style="text-align: center">Fecha</th>
                                <th scope="col" style="text-align: center">No. Identidad</th>
                                <th scope="col" style="text-align: center">Campo Modificado</th>
                                <th scope="col" style="text-align: center">Valor Nuevo</th>
                                <th scope="col" style="text-align: center">Valor Antiguo</th>
                                <th scope="col" style="text-align: center">Acción</th>  
                            </tr>
                        </thead>
                        <tbody>
                            {{-- ciclo de traida de datos para el personal modalidad bitacora --}}
                            @foreach ( $bita_personal->reverse() as $bita_personal )
                            <tr>
                                <th><center>{{ $bita_personal->fecha }}</center></th>
                                <th><center>{{ $bita_personal->dni }}</center></th>
                                <th><center>{{ $bita_personal->campo_modificado}}</center></th>
                                <th><center>{{ $bita_personal->valor_nuevo }}</center></th>
                                <th><center>{{ $bita_personal->valor_viejo }}</center></th>
                                <th><center>{{ $bita_personal->accion }}</center></th>
                            </tr>    
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<div>
</div>
</div>
</div>

@stop