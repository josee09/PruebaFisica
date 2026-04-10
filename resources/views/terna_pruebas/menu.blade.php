@extends('home')

@section('titulo')
    EVALUACIÓN DE CAMPO - {{ $fecha ?? date('d-m-Y') }}
@stop

@section('contenido')
<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-users"></i> EVALUACIÓN EN CAMPO - {{ mb_strtoupper($terna->descripcion) }}</h2>
                <div class="clearfix"></div>
            </div>
            
            <div class="x_content">
                <div class="text-center" style="padding: 20px 0;">
                    <h3 style="color: #26b99a; font-weight: 700;">SELECCIONE EL EVENTO A EVALUAR</h3>
                    <p class="text-muted">La evaluación se realizará de forma individual para el personal asignado.</p>
                </div>

                <div class="row" style="margin-top: 30px;">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="row text-center">
                            <!-- PECHADAS -->
                            <div class="col-md-4 col-sm-4 col-xs-12 mb-3">
                                <a href="{{ route('terna.pruebas.evento', [$terna->id, 'pechadas']) }}" class="btn-evento-std">
                                    <div class="icon-box"><i class="fa fa-child"></i></div>
                                    <div class="label-box">PECHADAS</div>
                                </a>
                            </div>
                            <!-- ABDOMINALES -->
                            <div class="col-md-4 col-sm-4 col-xs-12 mb-3">
                                <a href="{{ route('terna.pruebas.evento', [$terna->id, 'abdominales']) }}" class="btn-evento-std">
                                    <div class="icon-box"><i class="fa fa-refresh"></i></div>
                                    <div class="label-box">ABDOMINALES</div>
                                </a>
                            </div>
                            <!-- CARRERA -->
                            <div class="col-md-4 col-sm-4 col-xs-12 mb-3">
                                <a href="{{ route('terna.pruebas.evento', [$terna->id, 'carrera']) }}" class="btn-evento-std">
                                    <div class="icon-box"><i class="fa fa-road"></i></div>
                                    <div class="label-box">CARRERA</div>
                                </a>
                            </div>
                        </div>

                        <div class="ln_solid" style="margin: 40px 0;"></div>

                        <!-- SECCIÓN FINALIZAR -->
                        <div class="text-center" style="padding-bottom: 30px;">
                            <h4 style="font-weight: 700; margin-bottom: 20px;">CIERRE DE JORNADA</h4>
                            <form action="{{ route('terna.pruebas.finalizar') }}" method="POST" id="formFinalizar">
                                @csrf
                                <input type="hidden" name="terna_id" value="{{ $terna->id }}">
                                <button type="button" onclick="confirmarFinalizacion()" class="btn btn-danger btn-lg" style="padding: 15px 50px; border-radius: 10px; font-weight: 800; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                    <i class="fa fa-flag-checkered"></i> FINALIZAR PRUEBA FÍSICA Y VER RESUMEN
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-evento-std {
        display: block;
        background: #f7f9fa;
        border: 2px solid #e6e9ed;
        border-radius: 12px;
        padding: 25px;
        color: #2d3748 !important;
        text-decoration: none !important;
        transition: all 0.2s ease;
        margin-bottom: 20px;
    }
    .btn-evento-std:hover {
        background: #26b99a;
        color: white !important;
        border-color: #26b99a;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(38, 185, 154, 0.3);
    }
    .btn-evento-std .icon-box {
        font-size: 45px;
        margin-bottom: 10px;
    }
    .btn-evento-std .label-box {
        font-weight: 800;
        font-size: 16px;
        letter-spacing: 0.5px;
    }
    .btn-evento-std:hover .icon-box i {
        transform: scale(1.1);
        transition: 0.2s;
    }
    .mb-3 { margin-bottom: 15px; }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmarFinalizacion() {
    Swal.fire({
        title: 'FIN DE EVENTO DE PRUEBA',
        text: '¿DESEA FINALIZAR LA PRUEBA FISICA? AL DARLE SI SE ENVIARA A EVALUACION',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, finalizar',
        cancelButtonText: 'No',
        borderRadius: '15px'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formFinalizar').submit();
        }
    })
}
</script>
@stop
