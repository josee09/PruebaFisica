@extends('home')

@section('titulo')
    RESUMEN DE EVALUACIÓN - {{ $fecha ?? date('d-m-Y') }}
@stop

@section('contenido')
<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-file-text-o"></i> RESUMEN DE EVALUACIÓN - {{ mb_strtoupper($terna->descripcion) }}</h2>
                <div class="clearfix"></div>
            </div>
            
            <div class="x_content">
                <div class="text-center" style="margin-bottom: 20px;">
                    <h3 style="color: #26b99a; font-weight: 700;">RESULTADOS FINALES DE LA JORNADA</h3>
                </div>

                <div class="table-responsive">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th style="text-align: center">EVALUADO</th>
                                <th style="text-align: center">CALIFICACIÓN</th>
                                <th style="text-align: center">OBSERVACIÓN</th>
                                <th style="text-align: center">OPCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($evaluados as $evaluado)
                            <tr>
                                <td style="text-align: left; padding-left: 20px;">
                                    <strong>{{ mb_strtoupper($evaluado->nombre . ' ' . $evaluado->apellido) }}</strong>
                                    <br>
                                    <small class="text-muted">{{ mb_strtoupper($evaluado->grado) }} | DNI: {{ $evaluado->dni }}</small>
                                </td>
                                <td>
                                    <span style="font-weight: 900; font-size: 18px; color: {{ $evaluado->resultadoFinal['calificacion'] >= 70 ? '#169f85' : '#d9534f' }}">
                                        {{ $evaluado->resultadoFinal['calificacion'] }}%
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $obs = $evaluado->resultadoFinal['observacion'];
                                        $clase = 'badge-secondary';
                                        if ($obs == 'APROBADO') $clase = 'label-success';
                                        elseif ($obs == 'REPROBADO') $clase = 'label-danger';
                                        elseif (strpos($obs, 'SOBREPESO') !== false) $clase = 'label-warning';
                                    @endphp
                                    <span class="label {{ $clase }}" style="font-size: 12px; padding: 5px 10px;">{{ $obs }}</span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm btn-edit-individual" 
                                        data-id="{{ $evaluado->id }}"
                                        data-nombre="{{ mb_strtoupper($evaluado->nombre . ' ' . $evaluado->apellido) }}"
                                        data-pechada="{{ $evaluado->pivot->pechada ?? 0 }}"
                                        data-abdominal="{{ $evaluado->pivot->abdominal ?? 0 }}"
                                        data-carrera="{{ $evaluado->pivot->carrera ?? '00:00' }}">
                                        <i class="fa fa-pencil"></i> EDITAR
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="ln_solid"></div>

                <div class="text-center" style="margin-top: 20px; padding-bottom: 20px;">
                    <a href="{{ route('terna.pruebas.index') }}" class="btn btn-primary">
                        <i class="fa fa-home"></i> VOLVER AL MENÚ DE TERNAS
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Edición Individual -->
<div class="modal fade" id="modalEditarIndividual" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="font-weight: 800;">EDITAR RESULTADOS</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
            </div>
            <form action="{{ route('terna.pruebas.updateIndividual') }}" method="POST">
                @csrf
                <input type="hidden" name="evaluado_id" id="input_evaluado_id">
                <input type="hidden" name="terna_id" value="{{ $terna->id }}">
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <p id="modalNombreEvaluado" style="color: #26b99a; font-weight: 700; font-size: 16px;"></p>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label>PECHADAS</label>
                            <input type="text" name="pechada" id="input_pechada" class="form-control" onkeypress="validarNumeros(event)" maxlength="3" style="font-weight: 800; font-size: 18px; text-align: center;">
                        </div>
                        <div class="col-md-4">
                            <label>ABDOMINALES</label>
                            <input type="text" name="abdominal" id="input_abdominal" class="form-control" onkeypress="validarNumeros(event)" maxlength="3" style="font-weight: 800; font-size: 18px; text-align: center;">
                        </div>
                        <div class="col-md-4">
                            <label>CARRERA</label>
                            <input type="text" name="carrera" id="input_carrera" class="form-control" onkeypress="validarTiempos(event)" maxlength="5" style="font-weight: 800; font-size: 18px; text-align: center;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                    <button type="submit" class="btn btn-success">GUARDAR CAMBIOS</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Estilo para todas las tablas (Copiado de ListaRegistros para consistencia) */
    .custom-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .custom-table th,
    .custom-table td {
        border: 1px solid #e6e9ed;
        padding: 12px;
        text-align: center;
        vertical-align: middle;
    }

    .custom-table th {
        background-color: #f9f9f9;
        color: #73879c;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 12px;
    }

    .custom-table tr:nth-child(even) {
        background-color: #fcfcfc;
    }

    .custom-table tr:hover {
        background-color: #f5f5f5;
    }

    .label {
        display: inline-block;
        border-radius: 4px;
        color: white;
        font-weight: 700;
        padding: 2px 8px;
    }
    .label-success { background-color: #26b99a; }
    .label-danger { background-color: #d9534f; }
    .label-warning { background-color: #f0ad4e; }
</style>

<script>
$(document).ready(function() {
    $('.btn-edit-individual').click(function() {
        const id = $(this).data('id');
        const nombre = $(this).data('nombre');
        const pechada = $(this).data('pechada');
        const abdominal = $(this).data('abdominal');
        const carrera = $(this).data('carrera');

        $('#input_evaluado_id').val(id);
        $('#modalNombreEvaluado').text(nombre);
        $('#input_pechada').val(pechada);
        $('#input_abdominal').val(abdominal);
        $('#input_carrera').val(carrera);

        $('#modalEditarIndividual').modal('show');
    });
});
</script>
@stop
