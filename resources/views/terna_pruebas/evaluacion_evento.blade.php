@extends('home')

@section('titulo')
    LISTADO DE PERSONAL A EVALUAR - EVENTO {{ strtoupper($evento) }}
@stop

@section('contenido')
<style>
    .card-evaluado {
        border: 1px solid #e6e9ed;
        border-radius: 8px;
        background: white;
        margin-bottom: 25px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .card-evaluado.is-open {
        border-color: #26b99a;
        box-shadow: 0 8px 25px rgba(38, 185, 154, 0.15);
    }
    .card-header-click {
        padding: 20px 25px;
        cursor: pointer;
        transition: background 0.2s;
        position: relative;
    }
    .card-header-click:hover {
        background: #fcfcfc;
    }
    .card-body-collapsible {
        display: none;
        padding: 0 25px 25px 25px;
        border-top: 1px solid #f7fafc;
    }
    .toggle-icon {
        position: absolute;
        right: 25px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 20px;
        color: #73879c;
        transition: transform 0.3s;
    }
    .card-evaluado.is-open .toggle-icon {
        transform: translateY(-50%) rotate(180deg);
        color: #26b99a;
    }
    .input-busqueda {
        height: 50px;
        border: 1px solid #ccd0d4;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 500;
        padding-left: 45px;
        box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
    }
    .input-busqueda:focus {
        border-color: #26b99a;
        box-shadow: 0 0 8px rgba(38, 185, 154, 0.2);
    }
    .search-icon {
        position: absolute;
        left: 20px;
        top: 15px;
        font-size: 16px;
        color: #73879c;
    }
    .input-cantidad {
        height: 60px;
        border: 1px solid #ccd0d4;
        border-radius: 8px;
        font-size: 30px;
        font-weight: 800;
        text-align: center;
        background: #ffffff;
    }
    .btn-guardar {
        background: #26b99a;
        color: white;
        border-radius: 6px;
        font-weight: 700;
        padding: 12px 30px;
        font-size: 14px;
        border: 1px solid #169f85;
        transition: all 0.2s;
        text-transform: uppercase;
    }
    .btn-guardar:hover {
        background: #169f85;
        color: white;
    }
    .info-label {
        font-size: 13px;
        font-weight: 700;
        color: #718096;
        text-transform: uppercase;
        margin-bottom: 2px;
    }
    .info-value {
        font-size: 18px;
        font-weight: 800;
        color: #1a202c;
        margin-bottom: 15px;
        word-break: break-all;
    }
    .status-badge {
        font-size: 12px;
        font-weight: 800;
        padding: 4px 12px;
        border-radius: 20px;
        text-transform: uppercase;
    }
    .sticky-search {
        position: sticky;
        top: 0;
        z-index: 1000;
        background: rgba(248, 250, 252, 0.9);
        padding: 15px 0;
        backdrop-filter: blur(5px);
    }
    @media (max-width: 767px) {
        .text-right-mobile { text-align: right !important; }
        .text-center-mobile { text-align: center !important; }
        .mt-mobile-10 { margin-top: 10px; }
        .info-value { font-size: 15px; }
        .card-evaluado { margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .input-cantidad { font-size: 24px; }
    }
    @media (min-width: 768px) {
        .text-right-desktop { text-align: right !important; }
        .text-center-desktop { text-align: center !important; }
    }
    
    /* Notificaciones Toast */
    #toast-container {
        position: fixed;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 9999;
        pointer-events: none;
    }
    .toast-msg {
        background: #2d3748;
        color: white;
        padding: 12px 25px;
        border-radius: 50px;
        font-weight: 700;
        margin-top: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 10px;
        border: 1px solid #26b99a;
    }
    .toast-msg.show {
        opacity: 1;
        transform: translateY(0);
    }
</style>

@php
    $estados = [];
    foreach($evaluados as $e) {
        $comp = false;
        $pivot = $e->pivot;
        if ($pivot) {
            $val = '';
            if ($evento == 'pechadas') $val = $pivot->pechada;
            elseif ($evento == 'abdominales') $val = $pivot->abdominal;
            elseif ($evento == 'carrera') $val = $pivot->carrera;
            if ($val !== null && $val !== '') $comp = true;
        }
        $estados[$e->id] = $comp;
    }
@endphp

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        
        <!-- BARRA DE BUSQUEDA SEGÚN MOCKUP -->
        <div class="sticky-search">
            <div class="row" style="display: flex; align-items: center;">
                <div class="col-xs-2">
                    <a href="{{ route('terna.pruebas.index') }}" class="btn btn-default" style="border-radius: 12px; height: 60px; display: flex; align-items: center; justify-content: center; border: 3px solid #2d3748;">
                        <i class="fa fa-arrow-left fa-2x"></i>
                    </a>
                </div>
                <div class="col-xs-8" style="position: relative;">
                    <i class="fa fa-search search-icon"></i>
                    <input type="text" id="inputBusqueda" class="form-control input-busqueda" placeholder="BUSCAR POR DNI O NOMBRE...">
                </div>
                <div class="col-xs-2">
                    <button type="button" onclick="limpiarBusqueda()" class="btn btn-warning" style="border-radius: 12px; height: 60px; width: 100%; border: 3px solid #2d3748; background: #ecc94b; color: #2d3748;">
                        <i class="fa fa-eraser fa-2x"></i>
                    </button>
                </div>
            </div>
        </div>

        <div id="contenedorTarjetas" style="margin-top: 30px;">
            @foreach($evaluados as $evaluado)
            @php
                $valorPrevio = '';
                $completado = $estados[$evaluado->id];
                $pivot = $evaluado->pivot;
                if ($pivot) {
                    if ($evento == 'pechadas') $valorPrevio = $pivot->pechada;
                    elseif ($evento == 'abdominales') $valorPrevio = $pivot->abdominal;
                    elseif ($evento == 'carrera') $valorPrevio = $pivot->carrera;
                }
            @endphp
            
            <div class="card-evaluado-item" data-dni="{{ $evaluado->dni }}" data-nombre="{{ mb_strtoupper($evaluado->nombre . ' ' . $evaluado->apellido) }}">
                <div class="card-evaluado">
                    <!-- Barra de Estado -->
                    <div class="card-header-status" style="background: {{ $completado ? '#38a169' : '#ecc94b' }}; color: white; padding: 10px 25px; font-weight: 800; display: flex; justify-content: space-between;">
                        <span class="status-text"><i class="fa @if($completado) fa-check-circle @else fa-clock-o @endif"></i> {{ $completado ? 'CALIFICADO' : 'PENDIENTE' }}</span>
                        <span>{{ strtoupper($evento) }}</span>
                    </div>

                    <div style="padding: 30px;">
                    <div class="card-header-click">
                        <i class="fa fa-chevron-down toggle-icon"></i>
                        <!-- Información Principal (Visible siempre) -->
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="info-label">GRADO</div>
                                <div class="info-value" style="margin-bottom: 5px;">{{ mb_strtoupper($evaluado->grado) }}</div>
                            </div>
                            <div class="col-xs-6 text-right">
                                <div class="info-label">CATEGORÍA</div>
                                <div class="info-value" style="margin-bottom: 5px;">{{ mb_strtoupper($evaluado->categoria) }}</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <div class="info-label">NOMBRE COMPLETO</div>
                                <div class="info-value" style="font-size: 22px; margin-bottom: 0; color: #26b99a;">{{ mb_strtoupper($evaluado->nombre . ' ' . $evaluado->apellido) }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body-collapsible">
                        <form action="{{ route('terna.pruebas.store') }}" method="POST" class="form-evaluacion">
                            @csrf
                            <input type="hidden" name="evaluado_id" value="{{ $evaluado->id }}">
                            <input type="hidden" name="terna_id" value="{{ $terna->id }}">
                            <input type="hidden" name="evento" value="{{ $evento }}">

                            <div class="row info-row" style="margin-top: 15px;">
                                <div class="col-xs-6">
                                    <div class="info-label">EDAD</div>
                                    <div class="info-value" style="font-size: 16px;">{{ \Carbon\Carbon::parse($evaluado->fechanac)->age }} AÑOS</div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="info-label">SEXO</div>
                                    <div class="info-value" style="font-size: 16px;">{{ $evaluado->sexo == 'M' ? 'MASCULINO' : 'FEMENINO' }}</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="info-label">DNI</div>
                                    <div class="info-value" style="font-size: 16px;">{{ $evaluado->dni }}</div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <span class="status-badge @if($completado) label-success @else label-default @endif">
                                        ESTADO MÉDICO: APTO
                                    </span>
                                </div>
                            </div>

                            <hr style="border-top: 1px dashed #e6e9ed; margin: 20px 0;">

                            <!-- Área de Evaluación -->
                            <div class="row" style="align-items: center; display: flex;">
                                <div class="col-xs-8">
                                    <label class="info-label" style="display: block; font-size: 14px;">{{ $evento == 'carrera' ? 'TIEMPO (MM:SS)' : 'CANTIDAD' }}</label>
                                    <input type="text" name="cantidad" value="{{ $valorPrevio }}" 
                                        class="form-control input-cantidad" 
                                        data-evaluado-id="{{ $evaluado->id }}"
                                        oninput="actualizarPuntajeLocal(this)"
                                        onkeypress="{{ $evento == 'carrera' ? 'validarTiempos(event)' : 'validarNumeros(event)' }}"
                                        maxlength="{{ $evento == 'carrera' ? 5 : 3 }}">
                                </div>
                                <div class="col-xs-4 text-center">
                                    <div id="puntaje-{{ $evaluado->id }}" style="font-size: 45px; font-weight: 900; color: #2d3748;">
                                        @if($completado) 100% @else --% @endif
                                    </div>
                                </div>
                            </div>

                            <div class="text-center" style="margin-top: 25px;">
                                <button type="submit" class="btn btn-guardar btn-block">
                                    {{ $completado ? 'ACTUALIZAR DATOS' : 'GUARDAR EVALUACIÓN' }}
                                </button>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Escuchar el input de búsqueda
    $('#inputBusqueda').on('keyup', function() {
        const valor = $(this).val().toLowerCase();
        
        $('.card-evaluado-item').each(function() {
            const dni = $(this).data('dni').toString().toLowerCase();
            const nombre = $(this).data('nombre').toLowerCase();
            
            if (dni.includes(valor) || nombre.includes(valor)) {
                $(this).fadeIn();
            } else {
                $(this).hide();
            }
        });
    });

    // Lógica de Acordeón
    $('.card-header-click').on('click', function() {
        const currentCard = $(this).closest('.card-evaluado');
        const currentBody = currentCard.find('.card-body-collapsible');
        const isOpen = currentCard.hasClass('is-open');

        // Cerrar todos los demás
        $('.card-evaluado').not(currentCard).removeClass('is-open').find('.card-body-collapsible').slideUp();

        // Alternar el actual
        if (isOpen) {
            currentCard.removeClass('is-open');
            currentBody.slideUp();
        } else {
            currentCard.addClass('is-open');
            currentBody.slideDown();
        }
    });

    // Cargar puntajes iniciales si ya tienen valor
    $('.input-cantidad').each(function() {
        if (this.value) {
            actualizarPuntajeLocal(this);
        }
    });
    // Manejo de guardado por AJAX
    $('.form-evaluacion').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const card = form.closest('.card-evaluado');
        const header = card.find('.card-header-status');
        const statusText = card.find('.status-text');
        const submitBtn = form.find('button[type="submit"]');
        
        // Bloquear botón para evitar doble envío
        submitBtn.prop('disabled', true).css('opacity', '0.7');

        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    // Actualizar UI sin recargar
                    header.css('background', '#38a169');
                    statusText.html('<i class="fa fa-check-circle"></i> CALIFICADO');
                    submitBtn.text('ACTUALIZAR DATOS');
                    
                    showToast(response.mensaje);
                }
            },
            error: function() {
                showToast('Error al conectar con el servidor');
            },
            complete: function() {
                submitBtn.prop('disabled', false).css('opacity', '1');
            }
        });
    });
});

function showToast(mensaje) {
    if (!$('#toast-container').length) {
        $('body').append('<div id="toast-container"></div>');
    }
    
    const toast = $('<div class="toast-msg"><i class="fa fa-check-circle" style="color:#ed8936"></i> ' + mensaje + '</div>');
    $('#toast-container').append(toast);
    
    setTimeout(() => toast.addClass('show'), 100);
    
    setTimeout(() => {
        toast.removeClass('show');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

function limpiarBusqueda() {
    $('#inputBusqueda').val('').trigger('keyup');
}

async function actualizarPuntajeLocal(input) {
    const valor = input.value;
    const evaluadoId = input.dataset.evaluadoId;
    const evento = "{{ $evento }}";
    const display = document.getElementById('puntaje-' + evaluadoId);

    if (valor === '' || (evento !== 'carrera' && isNaN(valor))) {
        display.innerText = '--%';
        display.style.color = '#2d3748';
        return;
    }

    try {
        const response = await fetch("{{ route('terna.pruebas.puntaje') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                evaluado_id: evaluadoId,
                evento: evento,
                valor: valor
            })
        });

        const data = await response.json();
        const puntaje = data.puntaje;

        display.innerText = (puntaje || 0) + '%';
        display.style.color = (puntaje >= 70) ? '#38a169' : '#e53e3e';
        
    } catch (error) {
        console.error('Error calculando puntaje:', error);
    }
}

function validarNumeros(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) evt.preventDefault();
}

function validarTiempos(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 58)) evt.preventDefault();
}
</script>
@stop
