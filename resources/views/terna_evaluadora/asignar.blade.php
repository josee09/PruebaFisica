@extends('home')
@section('titulo')
    Asignación de Evaluados a Terna
@stop
@section('contenido')
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{ $terna->descripcion }} | ASIGNACIÓN </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form id="asignarForm" method="POST" action="{{ route('terna-evaluadora.asignar', $terna->id) }}">
                        @csrf
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label for="periodo"><strong>Periodo de Evaluación:</strong></label>
                                <input type="text" name="periodo" class="form-control" placeholder="Ej: I-2024" required>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <label><strong>Buscar Evaluado por DNI o Nombre:</strong></label>
                                <input type="text" id="dniSearch" class="form-control" placeholder="Escriba DNI o Nombre para filtrar...">
                            </div>
                        </div>

                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-striped jambo_table bulk_action">
                                <thead>
                                    <tr class="headings">
                                        <th>
                                            {{-- Se puede poner un checkbox de selección masiva aquí si se desea --}}
                                        </th>
                                        <th class="column-title">DNI</th>
                                        <th class="column-title">Nombre</th>
                                        <th class="column-title">Grado</th>
                                    </tr>
                                </thead>
                                <tbody id="evaluadosList">
                                    @php
                                        $asignadosIds = $terna->evaluadosAsignados->pluck('id')->toArray();
                                    @endphp
                                    @foreach($evaluados as $evaluado)
                                        <tr class="even pointer">
                                            <td class="a-center ">
                                                <input type="checkbox" name="evaluados[]" value="{{ $evaluado->id }}"
                                                    {{ in_array($evaluado->id, $asignadosIds) ? 'checked' : '' }}>
                                            </td>
                                            <td>{{ $evaluado->dni }}</td>
                                            <td>{{ $evaluado->nombre }} {{ $evaluado->apellido }}</td>
                                            <td>{{ $evaluado->grado }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="ln_solid"></div>
                        <div class="text-right">
                            <a href="{{ route('terna-evaluadora.index') }}" class="btn btn-danger">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar Asignaciones</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('dniSearch').addEventListener('keyup', function() {
            let filter = this.value.toUpperCase();
            let rows = document.querySelector("#evaluadosList").rows;
            
            for (let i = 0; i < rows.length; i++) {
                let dni = rows[i].cells[1].textContent.toUpperCase();
                let nombre = rows[i].cells[2].textContent.toUpperCase();
                if (dni.indexOf(filter) > -1 || nombre.indexOf(filter) > -1) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }      
            }
        });
    </script>
@stop