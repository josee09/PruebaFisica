@extends('home')
@section('titulo')
{{-- 28-4-23 creación de Vista para visualizar registros de bitacora de usuarios --}}
@stop
@section('contenido')
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
            <div class="x_title">
                <h2> Bitácora | USUARIOS </h2>
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
                                        <th scope="col" style="text-align: center">Usuario</th>
                                        <th scope="col" style="text-align: center">Campo Modificado</th>
                                        <th scope="col" style="text-align: center">Valor Nuevo</th>
                                        <th scope="col" style="text-align: center">Valor Antiguo</th>
                                        <th scope="col" style="text-align: center">Acción</th>  
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- ciclo de traida para usuarios modalidad bitacora --}}
                                    @foreach ( $bita_usuario as $bita_usuario )
                                    <tr>
                                        <th><center>{{ $bita_usuario->fecha }}</center></th>
                                        <th><center>{{ $bita_usuario->usuario }}</center></th>
                                        <th><center>{{ $bita_usuario->campo_modificado }}</center></th>
                                        <th><center>{{ $bita_usuario->valor_nuevo }}</center></th>
                                        <th><center>{{ $bita_usuario->valor_viejo }}</center></th>
                                        <th><center>{{ $bita_usuario->accion }}</center></th>
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