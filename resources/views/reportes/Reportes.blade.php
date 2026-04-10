@extends('home')

@section('titulo')
    {{-- 6-6-24 creación de Vista para visualizar reportes de resultados --}}
@endsection

@section('contenido')

<div class="col-md-12 col-sm-12">
    <div class="x_panel">

        <div class="x_title">
            <h2>Resultados de pruebas</h2>
            <div class="clearfix"></div>
        </div>

        <div class="x_content">

            {{-- FORMULARIO DE BÚSQUEDA --}}
            <form action="{{ route('Reportes.index') }}" method="GET">
                @csrf

                <div class="row">

                    <div class="col-md-6 col-sm-12 form-group">
                        <label>Escoger fecha de evaluación <span class="required">*</span></label>
                        <input type="date"
                               name="fecha"
                               id="fecha"
                               class="form-control"
                               value="{{ old('fecha') }}"
                               required>
                    </div>

                    <div class="col-md-4 col-sm-12 form-group">
                        <label>DNI del oficial evaluador <span class="required">*</span></label>
                        <input type="text"
                               class="form-control"
                               name="dni-ofi-eva"
                               maxlength="13"
                               required>
                    </div>

                    <div class="col-md-2 col-sm-12 form-group" style="margin-top:25px;">
                        <button type="submit" class="btn btn-primary btn-block">Buscar</button>
                    </div>

                </div>
            </form>

            <hr>

            {{-- TOTALES + BOTÓN WORD --}}
            <div class="row">

                <div class="col-md-2 col-sm-6 form-group">
                    <label>Total evaluados</label>
                    <input type="text" class="form-control text-center" readonly value="{{ $totalEvaluados ?? '' }}">
                </div>

                <div class="col-md-2 col-sm-6 form-group">
                    <label>Total aprobados</label>
                    <input type="text" class="form-control text-center" readonly value="{{ $totalAprobados ?? '' }}">
                </div>

                <div class="col-md-2 col-sm-6 form-group">
                    <label>Total reprobados</label>
                    <input type="text" class="form-control text-center" readonly value="{{ $totalReprobados ?? '' }}">
                </div>

                <div class="col-md-2 col-sm-6 form-group">
                    <label>Total no evaluados</label>
                    <input type="text" class="form-control text-center" readonly value="{{ $totalNoEvaluados ?? '' }}">
                </div>

                <div class="col-md-2 col-sm-12 form-group" style="margin-top:25px;">
                    <button type="button"
                            class="btn btn-primary btn-block"
                            onclick="window.location.href='{{ route('Reportes.Ver-Reporte') }}'">
                        WORD
                    </button>
                </div>

            </div>

            {{-- DATOS --}}
            <div class="row">

                <div class="col-md-6 col-sm-12 form-group">
                    <label>Terna evaluadora</label>
                    <input type="text" class="form-control" readonly value="{{ $nombreTerna ?? '' }}">
                </div>

                <div class="col-md-6 col-sm-12 form-group">
                    <label>Oficial evaluador</label>
                    <input type="text" class="form-control" readonly value="{{ ($gradoOficial ?? '') . ' ' . ($nombreOficial ?? '') }}">
                </div>

            </div>

            <hr>

            {{-- TABLA --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" style="width:100%;">
                            <thead>
                                <tr>
                                    <th class="text-center">Grado</th>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Calificación</th>
                                    <th class="text-center">Observación</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($resultados as $resultado)
                                    <tr>
                                        <td class="text-center">{{ $resultado->grado }}</td>
                                        <td>{{ $resultado->nombre_completo }}</td>
                                        <td class="text-center">{{ $resultado->npesoexc }}</td>
                                        <td class="text-center">{{ $resultado->estado }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>{{-- x_content --}}
    </div>{{-- x_panel --}}
</div>

@endsection
