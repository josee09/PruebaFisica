@extends('home')
@section('titulo')
    {{-- 18-5-23 creación de Vista para registro de evantos principales --}}
@stop
@section('contenido')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2> Formulario de registro | EVENTOS PRUEBA FÍSICA </h2>
                    <form id="CategoriaTipo" method="POST" action="{{ route('categoria.update') }}"
                          data-parsley-validate
                          class="form-horizontal form-label-left">
                        @csrf
                        @method('PUT')
                        <div align="right">
                            <label>
                                <input type="checkbox" id="categoriaCheckbox"
                                       {{ $categoria->tipo_categoria === 1 ? 'checked' : '' }}
                                       onchange="updateCategoriaValue()"> Evaluar sin categoría
                            </label>
                            <input type="hidden" id="categoria" name="categoria"
                                   value="{{ $categoria->tipo_categoria }}"/>
                        </div>
                    </form>
                    <div class="clearfix"></div>
                    <div class="x_content">
                        <br/>
                        <!-- Adding the title here with large and italicized style -->
                        <h1 style="font-size: 36px; font-style: italic; text-align: center; color: black; font-weight: bold;">
                            Eventos Principales</h1>
                    </div>
                </div>


                {{-- REGISTRO DE EVENTO PRINCIPAL --}}
                <div class="x_content">
                    <br/>
                    <form id="NuevoPrincipal" method="POST" action="{{ route('principal.store') }}"
                          data-parsley-validate class="form-horizontal form-label-left">
                        @csrf
                        <div>
                            <div class="item form-group align-items-end d-flex">
                                <div class="col-md-2 mb-3">
                                    <label>DNI del evaluado:</label>
                                    <input type="text" maxlength="13" minlength="1"
                                           placeholder="Ingrese DNI del evaluado"
                                           onkeypress="validarNumeros(event)" class="form-control" required
                                           name="dniEvaluado" id="dniEvaluado">
                                </div>
                                <div class="col-md-1 mb-3 ">
                                    <button type="button" class="btn btn-info mb-0" name="btnDniEvaluado"
                                            id="btnDniEvaluado"><i
                                            class="fas fa-search"></i></button>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label>No. de evaluación médica:</label>
                                    <select class="form-control" id="evaluacionMedica" name="id_medico" type="text"
                                            style="text-transform: uppercase;" required>
                                        <option disabled>Seleccione evaluacion</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3 ">
                                    <label>Evaluado:</label>
                                    <input readonly disabled name="nomEvaluado" id="nomEvaluado" type="text"
                                           style="text-transform: uppercase;" maxlength="30" minlength="3"
                                           class="form-control"
                                           title="Ingrese un nombre válido (min: 3, max:30, solo letras)" required>
                                </div>
                            </div>
                            <div class="item form-group">
                                <div class="col-md-2 mb-3">
                                    <label>Flexiones de brazo:</label>
                                    <input id="pechada_" type="text" maxlength="3" minlength="1"
                                           onkeypress="validarNumeros(event)" name="pechada" placeholder="00"
                                           class="form-control" title="Ingrese no. de repeticiones valido"
                                           list="pechada"
                                           value="{{old('pechada')}}">
                                    <datalist id="pechada" name="pechada">
                                        @foreach ($pechada as $pechada)
                                            <option value="{{$pechada->repeticiones}}"></option>
                                        @endforeach
                                    </datalist>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label>Flexiones de abdomen:</label>
                                    <input id="abdominal_" type="text" maxlength="3" minlength="1"
                                           onkeypress="validarNumeros(event)" name="abdominal" placeholder="00"
                                           class="form-control" title="Ingrese no. de repeticiones valido"
                                           list="abdominal"
                                           value="{{old('abdominal')}}">
                                    <datalist id="abdominal" name="abdominal">
                                        @foreach ($abdominal as $abdominal)
                                            <option value="{{$abdominal->repeticiones}}"></option>
                                        @endforeach
                                    </datalist>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label>Carrera 3.2km</label>
                                    <input id="carrera_" type="text" maxlength="5" minlength="5"
                                           oninput="validarCarrera()"
                                           name="carrera" placeholder="00:00"
                                           class="form-control" title="Ingrese tiempo valido (minutos:segundos)"
                                           list="carrera" value="{{old('carrera')}}"></br>
                                    <datalist id="carrera" name="carrera">
                                        @foreach ($carrera as $carrera)
                                            <option value="{{$carrera->tiempo}}"></option>
                                        @endforeach
                                    </datalist>
                                </div>
                                <div class="col-md-3">
                                    <label class="col-form-label">Tipo de Evaluación:<span
                                            class="required">*</span></label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-control form-check-input" type="radio" name="evaluacion"
                                                   value="DIAGNÓSTICA" checked><span>Diagnóstica</span>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-control form-check-input" type="radio" name="evaluacion"
                                                   value="ACUMULATIVA"><span>Acumulativa</span>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-control form-check-input" type="radio" name="evaluacion"
                                                   value="ASCENSO"><span>Ascenso</span>
                                        </div>
                                    </div>
                                </div>
                                {{--                                <div class="col-md-3">--}}
                                {{--                                    <label class="col-form-label">Tipo de Evaluación:<span--}}
                                {{--                                            class="required">*</span></label>--}}
                                {{--                                    <div>--}}
                                {{--                                        <div class="form-check form-check-inline">--}}
                                {{--                                            <input class="form-control form-check-input" type="radio" name="evaluacion"--}}
                                {{--                                                   value="DIAGNÓSTICA" checked><span>Diagnóstica</span>--}}
                                {{--                                        </div>--}}
                                {{--                                        <div class="form-check form-check-inline">--}}
                                {{--                                            <input class="form-control form-check-input" type="radio" name="evaluacion"--}}
                                {{--                                                   value="ACUMULATIVA"><span>Acumulativa</span>--}}
                                {{--                                        </div>--}}
                                {{--                                        <div class="form-check form-check-inline">--}}
                                {{--                                            <input class="form-control form-check-input" type="radio" name="evaluacion"--}}
                                {{--                                                   value="ASCENSO"><span>Ascenso</span>--}}
                                {{--                                        </div>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                            </div>
                            {{-- eventos alternos --}}
                            <datalist id="natacion" name="natacion"> @foreach ($natacion as $natacion)
                                    <option value="{{$natacion->tiempo}}"></option>
                                @endforeach </datalist>
                            <datalist id="caminata" name="caminata"> @foreach ($caminata as $caminata)
                                    <option value="{{$caminata->tiempo}}"></option>
                                @endforeach </datalist>
                            <datalist id="ciclismo" name="ciclismo"> @foreach ($ciclismo as $ciclismo)
                                    <option value="{{$ciclismo->tiempo}}"></option>
                                @endforeach </datalist>
                            <datalist id="barra" name="barra"> @foreach ($barra as $barra)
                                    <option value="{{$barra->repeticiones}}"></option>
                                @endforeach </datalist>

                            <div class="item form-group">
                                <div class="col-md-6 col-sm-6 ">
                                    <button type="submit" id="btnGuardarPrincipal" class="btn btn-primary" disabled>
                                        Guardar
                                    </button>
                                </div>
                                <div class="col-md-6 col-sm-6 ">
                                    <button type="button" id="btnModalGuardarBlanco" class="btn btn-primary"
                                            data-toggle="modal" data-target="#modalEvaBlanco">
                                        Generar Evaluacion en Blanco
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-4">
                    <div class="alert alert-info">
                        Si selecciona solo 2 eventos principales, debe agregar 1 evento alterno
                        solo se permiten 3 eventos.
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>




    {{-- LISTA DE EVENTOS --}}
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2> Lista de registros | EVENTOS PRUEBA FÍSICA </h2>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="datatable-responsive"
                                   class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th scope="col" style="text-align: center">Fecha de Registro</th>
                                    <th scope="col" style="text-align: center">T. Evaluacion</th>
                                    <th scope="col" style="text-align: center">No. Identidad</th>
                                    <th scope="col" style="text-align: center">Nombre</th>
                                    <th scope="col" style="text-align: center">F. Brazo</th>
                                    <th scope="col" style="text-align: center">F. Abdomen</th>
                                    <th scope="col" style="text-align: center">Carrera 3.2km</th>
                                    <th scope="col" style="text-align: center">E. Alterno</th>
                                    <th scope="col" style="text-align: center">Opciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($principal as $principal)
                                    <tr>
                                        <th scope="row">
                                            <center> {{\Carbon\Carbon::parse($principal->created_at)->format('d/m/Y')}}</center>
                                        </th>
                                        <td>
                                            <center>{{$principal->evaluacion}}</center>
                                        </td>
                                        <td>
                                            <center>{{$principal->evaluado->dni}}</center>
                                        </td>
                                        <td>
                                            <center>{{$principal->evaluado->nombre}} {{$principal->evaluado->apellido}}</center>
                                        </td>
                                        <td>
                                            <center>{{$principal->pechada}}</center>
                                        </td>
                                        <td>
                                            <center>{{$principal->abdominal}}</center>
                                        </td>
                                        <td>
                                            <center>{{$principal->carrera}}</center>
                                        </td>
                                        @if(DB::table('eventos_alternos')->where('id_principal', $principal->id)->exists())
                                            @php
                                                $alterno = DB::table('eventos_alternos')->where('id_principal', $principal->id)->first();
                                                $valor = '';
                                                if ($alterno->natacion) { $valor .= 'Natación | '.  $alterno->natacion; };
                                                if ($alterno->caminata) { $valor .= 'Caminata | '.  $alterno->caminata; };
                                                if ($alterno->ciclismo) { $valor .= 'Ciclismo | '. $alterno->ciclismo; };
                                                if ($alterno->barra) { $valor .= 'Barra | '.  $alterno->barra; }
                                                if ($alterno->is_icb) { $valor .= '<br><i>Incapacidad por cumplimiento del deber</i>'; }
                                            @endphp
                                            <td>
                                                <center>{!! $valor !!}</center>
                                            </td>
                                        @elseif($principal->tipo_evento != 'NORMAL')
                                            <td>
                                                <center><strong><i>{{$principal->tipo_evento}}</i></strong></center>
                                            </td>
                                        @else
                                            <td>
                                                <center></center>
                                            </td>
                                        @endif
                                        <td>
                                            <center>
                                                <div class="btn-group">
                                                    @if($principal->tipo_evento == 'NORMAL')
                                                        <button type="button" class="btn btn-custom dropdown-toggle"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false"
                                                                style="font-size: 16px; font-weight: bold; background: linear-gradient(to right, #b3dafa, #aefd8f); color: rgb(7, 7, 7);">
                                                            <i class="fas fa-cog"></i> Eventos Alternos
                                                        </button>
                                                        <div class="dropdown-menu">

                                                            @php
                                                                $nullCount = 0;
                                                                if ($principal->pechada === null) { $nullCount++; };
                                                                if ($principal->abdominal === null) { $nullCount++; };
                                                                if ($principal->carrera === null) { $nullCount++; };

                                                                $alternos = DB::table('eventos_alternos')->where('id_principal', $principal->id)->exists();
                                                                if($alternos) {$alterno=DB::table('eventos_alternos')->where('id_principal', $principal->id)->first();}
                                                            @endphp

                                                            @if ($nullCount >= 1)
                                                                @if($alternos)
                                                                    <a class="dropdown-item" data-toggle='modal'
                                                                       data-target="#EditarAlterno{{ $alterno->id }}"
                                                                       style="font-size: 16px; font-weight: bold;">Editar
                                                                        Evento Alterno</a>

                                                                @else
                                                                    <a class="dropdown-item" data-toggle='modal'
                                                                       data-target="#NuevoAlterno{{ $principal->id}}"
                                                                       id="NuevoAlterno"
                                                                       style="font-size: 16px; font-weight: bold;">Agregar
                                                                        Evento Alterno</a>
                                                                    <div class="dropdown-divider"></div>
                                                                @endif
                                                            @endif

                                                            <a class="dropdown-item" data-toggle='modal'
                                                               data-target="#ModalEditar{{ $principal->id}}"
                                                               style="font-size: 16px; font-weight: bold;">Editar Evento
                                                                Principal</a>
                                                            <form method="POST" id="delete-form2-{{ $principal->id }}"
                                                                  action="{{ route('alterno.destroy', $principal->id) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <input type="hidden" name="principal_id"
                                                                       value="{{ $principal->id }}">
                                                                <a class="dropdown-item" type="button"
                                                                   data-id="{{ $principal->id }}"
                                                                   onclick="return confirmDelete2(this)"
                                                                   style="font-size: 16px; font-weight: bold;">Eliminar
                                                                    Evento Alterno</a>
                                                            </form>

                                                        </div>
                                                    @endif
                                                    <a href="{{ route('principal.show', $principal->id) }}"
                                                       class="btn btn-custom"
                                                       style="font-size: 16px; font-weight: bold; background: linear-gradient(to right, #8B4513, #FFFF00); color: rgb(8, 8, 8);">
                                                        <i class="fas fa-check-circle" style="color: #ff5e00;"></i>
                                                        Evaluar
                                                    </a>
                                            </center>
                                        </td>
                                        @include('principales/ModalEditar')
                                        @include('alternos/NuevoAlterno')
                                        @include('alternos/EditarAlterno')
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
    </div>
    </div>
    <div class="modal fade" id="modalEvaBlanco" tabindex="-1" role="dialog" aria-labelledby="modalEvaBlancoLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEvaBlancoLabel">PRUEBA FISICA EN BLANCO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-6">
                        <label class="col-form-label">Tipo de Constancia:<span
                                class="required">*</span></label>
                        <div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="typoConstancia"
                                       id="typoConstanciaInca" value="incapacidad">
                                <label class="form-check-label" for="incapacidad">
                                    INCAPACIDAD MEDICA
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="typoConstancia"
                                       id="typoConstanciaLegal" value="incapacidad">
                                <label class="form-check-label" for="incapacidad">
                                    TRAMITE LEGAL
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="typoConstancia"
                                       id="typoConstanciaNoApto" value="incapacidad">
                                <label class="form-check-label" for="incapacidad">
                                    NO APTO
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="typoConstancia"
                                       id="typoConstanciaExcesoPesoGrasa" value="incapacidad">
                                <label class="form-check-label" for="incapacidad">
                                    NO APTO EXCESO DE PESO O GRASA
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button id="btnGuardarBlanco" type="button" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Confirmacion de borrado de evento alterno
        function confirmDelete2(button) {
            var id = button.getAttribute('data-id');
            if (confirm('¿Está seguro de que desea eliminar este registro de evento alterno?')) {
                var form = document.getElementById('delete-form2-' + id);
                form.submit();
            }
            return false;
        }
    </script>


    <script>
        // validación de campos
        const pechada = document.getElementById('pechada_');
        const abdominal = document.getElementById('abdominal_');
        const carrera = document.getElementById('carrera_');

        const boton = document.getElementById('btnGuardarPrincipal');
        const botonGuardarBlanco = document.getElementById('btnGuardarBlanco');
        const botonGenerarBlanco = document.getElementById('btnModalGuardarBlanco');
        [pechada, abdominal, carrera].forEach(campo => {
            campo.addEventListener('input', () => {
                if (pechada.value || abdominal.value || carrera.value) {
                    boton.disabled = false;
                    botonGuardarBlanco.disabled = true;
                    botonGenerarBlanco.disabled = true;
                } else {
                    boton.disabled = true;
                    botonGuardarBlanco.disabled = false;
                    botonGenerarBlanco.disabled = false;
                }
            });
        });
    </script>

    <script>
        // actualizar tipo de evaluacion
        function updateCategoriaValue() {
            var categoriaCheckbox = document.getElementById('categoriaCheckbox');
            var categoriaInput = document.getElementById('categoria');
            categoriaInput.value = categoriaCheckbox.checked ? 1 : 0;
            document.getElementById('CategoriaTipo').submit();
        }
    </script>

    <script>
        //var evaluaciones
        document.getElementById('btnDniEvaluado').addEventListener("click", async function (e) {
            e.preventDefault();
            const dni = document.getElementById('dniEvaluado').value;
            const token = '{{csrf_token()}}'; // Supongamos que esta función obtiene el token de alguna manera
            const data = {dni: dni, _token: token};
            try {
                const em = document.getElementById('evaluacionMedica')

                // Mantener el primer elemento
                const primerElemento = em.options[0];
                while (em.options.length > 1) {
                    em.remove(1);
                }
                em.insertBefore(primerElemento, em.firstChild);

                const response = await fetch("{{route('principal.evaluado')}}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify(data)
                });
                const responseData = await response.json();
                const evaMed = responseData.evaluacionesMedicas;
                if (evaMed.length === 0) {
                    alert("No se encontraron evaluaciones medicas de " + dni);
                } else {
                    //document.getElementById(outputId).value = responseData[0].nombreCompleto;
                    //document.getElementById(idHidden).value = responseData[0].id;


                    for (const rd of evaMed) {
                        const option = document.createElement("option");
                        option.text = `${rd.fecha} - ${rd.periodo}`;
                        option.value = rd.id;
                        em.add(option);
                        em.value = rd.id;
                        document.getElementById('nomEvaluado').value = rd.grado + ' ' + rd.nombre + ' ' + rd.apellido
                    }


                }

            } catch (error) {
                console.error("Error al realizar la petición:", error);
            }
        });
    </script>

    <script>
        function getSelectedRadioButtonValue(name) {
            const radios = document.getElementsByName(name);

            for (let i = 0; i < radios.length; i++) {
                if (radios[i].checked) {
                    return radios[i].value;
                }
            }

            // Return null if no radio button is selected
            return null;
        }

        //EVALUACION EN BLANCO
        document.getElementById('btnGuardarBlanco').addEventListener("click", async function (e) {
            e.preventDefault();
            console.log('PROBANDO GUARDAR MODAL')
            const dni = document.getElementById('dniEvaluado').value;
            const typoConstanciaInca = document.getElementById('typoConstanciaInca').checked;
            const typoConstanciaLegal = document.getElementById('typoConstanciaLegal').checked;
            const em = document.getElementById('evaluacionMedica').value
            const token = '{{csrf_token()}}'; // Supongamos que esta función obtiene el token de alguna manera
            let tipo_evento = 'NORMAL';

            //MODIFICAR AQUI PARA EL TEMA DE LOS EVENTOS
            if (typoConstanciaInca) {
                tipo_evento = 'INCAPACIDAD'
            } else if (typoConstanciaLegal) {
                tipo_evento = 'LEGAL'
            }
            const tipoEval = getSelectedRadioButtonValue('evaluacion');
            const data = {
                _token: token,
                dniEvaluado: dni,
                id_medico: em,
                evaluacion: tipoEval,
                tipo_evento: tipo_evento,
            };

            try {

                const response = await fetch("{{route('principal.storeAjax')}}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify(data)
                });
                const responseData = await response.json();

                console.log(responseData)
                if (response.status === 201) {
                    alert(responseData.mensaje);
                    location.replace("{{route('registro.registro')}}");
                } else {
                    alert(responseData.error);
                }

            } catch (error) {
                console.error("Error al realizar la petición:", error);
            }
        });
    </script>
@stop

