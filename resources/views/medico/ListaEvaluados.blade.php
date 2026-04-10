@extends('home')

@section('titulo')
{{-- 25-4-23 creación de Vista para visualizar registros de evaluaciones medicas al personal --}}
@stop
<style>
    /* Estilo de la sección de la agenda de citas */
    .calendar {
        background-color: #f5f5f5;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 0px;
    }

    .calendar-header {
        background-color: #007bff;
        /* Color de encabezado */
        color: #08965b;
        padding: 10px;
        text-align: center;
        border-radius: 5px 5px 0 0;
    }

    .calendar-content {
        padding: 20px;
        background-color: #fff;
        border-radius: 0 0 5px 5px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    }



    #event-name,
    #event-date {
        width: 100%;
        padding: 10px;
        margin: 5px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    #person-name {
        width: 100%;
        padding: 10px;
        margin: 5px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    #add-event-button {
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        cursor: pointer;
        margin-top: 10px;
    }

    .event-list {
        margin-top: 2em;
    }
</style>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

@section('contenido')
<div class="col-md-12 col-sm-12">
    <div class="x_panel">
        <div class="x_title">
            <h2> Lista de registros | EVALUACIÓN MÉDICA </h2>
            <div align="right">
                @can('medica.create')
                <a type="button" class="btn btn-primary" align="right" href="{{ route('medica.create') }}">
                    <i class="fas fa-plus"></i> Nuevo Registro Medico</a>
                @endcan
            </div>
            <div class="clearfix"></div>
        </div>
        <style>
            /* Aplicar mayúsculas a todas las celdas de la tabla */
            table.table td {
                text-transform: uppercase;
            }
        </style>
        <div class="x_content">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box table-responsive">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"
                            cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" style="text-align: center">Fecha Registro</th>
                                    <th scope="col" style="text-align: center">No. Identidad</th>
                                    <th scope="col" style="text-align: center">Nombre</th>
                                    <th scope="col" style="text-align: center">Periodo</th>
                                    <th scope="col" style="text-align: center">Estado</th>
                                    <th scope="col" style="text-align: center">Grado</th>
                                    <th scope="col" style="text-align: center">Lugar_Asignacion</th>
                                    <th scope="col" style="text-align: center">Chapa</th>
                                    <th scope="col" style="text-align: center">Promocion</th>
                                    <th scope="col" style="text-align: center">Médico Evaluador</th>
                                    <th scope="col" style="text-align: center">Hoja de Control</th>
                                    <th scope="col" style="text-align: center">Observacion</th>
                                    <th scope="col" style="text-align: center">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $nombresCompletos = [];
                                ?>
                                @foreach ($medicos as $medico)
                                <tr>

                                    {{-- formato de fecha d/m/Y --}}
                                    <th scope="row" data-order="Desc">
                                        <center> {{\Carbon\Carbon::parse($medico->created_at)->format('d/m/Y') }}
                                        </center>
                                    </th>
                                    <td>
                                        <center>{{$medico->evaluado->dni}}</center>
                                    </td>
                                    <td>
                                        <center>{{$medico->evaluado->nombre}} {{$medico->evaluado->apellido}}</center>
                                        <?php
                                            $nombreCompleto = $medico->evaluado->nombre . ' ' . $medico->evaluado->apellido;
                                            $nombresCompletos[] = $nombreCompleto;
                                        ?>
                                    </td>
                                    <td>
                                        <center>{{$medico->periodo}}</center>
                                    </td>
                                    <td>
                                        <center>{{$medico->condicion}}</center>
                                    </td>
                                    <td>
                                        <center>{{ $medico->evaluado->grado }}</center>
                                    </td>
                                    <td>
                                        <center>{{ $medico->evaluado->lugarAsignacion->LUGAR_ASIG ?? $medico->evaluado->lugarasig}}</center>
                                    </td>
                                    <td>
                                        <center>{{ $medico->evaluado->chapa }}</center>
                                    </td>
                                    <td>
                                        <center>{{ $medico->evaluado->promocion }}</center>
                                    </td>
                                    <td>
                                        <center>{{$medico->medico}}</center>
                                    </td>

                                    @if ($medico->doc_firma)
                                    <td>
                                        <center><a style="color: white" type="button" class="btn  btn-danger"
                                                data-toggle="modal" data-target="#modalFirma{{ $medico->id }}"
                                                id="modalFirma"><i class="fa fa-file-pdf-o"></a>
                                        </center>
                                    </td>
                                    <!-- MODAL PARA VISUALIZAR DOCUMENTO HOJA DE CONTROL FIRMADA -->
                                    <div class="modal fade bs-example-modal-lg" id="modalFirma{{ $medico->id }}"
                                        tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalFirmaLabel">Hoja de control |
                                                        EVALUACIÓN MÉDICA</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    @if ($medico->doc_firma)
                                                    <embed
                                                        src="{{ asset('storage/Firmas_Medicas/' . $medico->doc_firma) }}"
                                                        type="application/pdf" width="100%" height="650px">
                                                    @else
                                                    <p>No se encontró una firma para mostrar.</p>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    @if ($medico->doc_firma)
                                                    <p> {{ $medico->doc_firma }}</p><a
                                                        href="{{ asset('storage/Firmas_Medicas/' . $medico->doc_firma) }}"
                                                        download class="btn btn-primary">Descargar</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--  FIN MODAL PARA VISUALIZAR DOCUMENTO HOJA DE CONTROL FIRMADA -->
                                    @else
                                    <td>
                                        <center><a href="{{ route('medica.pdf', $medico->id) }}"><u>Visualizar</u><i
                                                    class="far fa-file-pdf" style="color: red;"></i></a></center>
                                    </td>

                                    @endif
                                    <style>
                                        .text-red-underline {
                                            color: red;
                                            text-decoration: underline;
                                        }
                                    </style>

                                    <td>
                                        <center><span class="text-red-underline">{{$medico->observaciones}}</span>
                                        </center>
                                    </td>


                                    <td>
                                        <center>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-custom dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                    style="font-size: 16px; font-weight: bold; background-color: #8B4513; color: white;">
                                                    <i class="fas fa-cog"></i> Acciones
                                                </button>




                                                <div class="dropdown-menu">
                                                    {{-- <a class="dropdown-item"
                                                        href="{{route('medica.view', $medico->id)}}">Visualizar</a> --}}
                                                    @if (is_null($medico->doc_firma))
                                                    <a class="dropdown-item" data-toggle='modal'
                                                        data-target="#NuevaFirmaMedica{{ $medico->id}}" id="NuevaFirma"
                                                        style="font-size: 16px; font-weight: bold;">
                                                        <i class="fas fa-signature"></i> Agregar Documento con Firmas
                                                    </a>

                                                    @endif

                                                    {{-- @php
                                                    $principal=DB::table('eventos_principals')->where('id_medico',
                                                    $medico->id)->first();
                                                    @endphp --}}
                                                    {{-- @if (is_null($principal)) --}}
                                                    <a class="dropdown-item"
                                                        href="{{ route('medica.edit', $medico->id) }}"
                                                        style="font-size: 16px; font-weight: bold;">
                                                        <i class="fas fa-edit"></i> Editar
                                                    </a>

                                                    <div class="dropdown-divider"></div>
                                                    <form method="POST" id="delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        @can('medica.destroy')
                                                        <a class="dropdown-item" type="submit" class="btn btn-danger"
                                                            data-id="{{ $medico->id }}"
                                                            onclick="return confirmDelete(this)"
                                                            style="font-size: 16px; font-weight: bold;">
                                                            <i class="fas fa-trash"></i> Eliminar
                                                        </a>
                                                        @endcan
                                                    </form>
                                                </div>
                                    </td>

                    </div>
                    </center>
                    {{-- Confirmar borrado --}}
                    <script>
                        function confirmDelete(button) {
                        var id = button.getAttribute('data-id');
                        if (confirm('¿Está seguro de que desea eliminar este registro?, esto incluira cualquier evaluación física correspondiente a esta evaluación médica.')) {
                          var url = '{{ route("medica.destroy", ":id") }}';
                          url = url.replace(':id', id);
                          document.getElementById('delete-form').setAttribute('action', url);
                          document.getElementById('delete-form').submit();
                        }
                        return false;
                      }
                    </script>
                    </td>
                    </tr>
                    {{-- Modal para agregar doc de firmas --}}
                    @include('medico/GuardarFirmas')
                    @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<style>
    .selected-event {
        background-color: rgb(152, 164, 230);
        /* Cambia esto al color que desees */
    }
</style>
</head>

<style>
    .centered-title {
        text-align: center;
        /* Centra el texto horizontalmente */
        margin-top: 15em;
        /* Agrega 4 saltos de línea (equivalente a 4 veces la altura de una línea) antes del título */
    }
</style>


<head>
    <meta charset="UTF-8">
    <title>Agenda de Citas</title>
    <style>
        .event-today {
            color: red;
        }

        .event-alert {
            background-color: rgb(248, 248, 6);
            color: black;
            padding: 5px;
            border-radius: 5px;
            display: inline-block;
            margin-left: 10px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #046096;
            text-align: left;
            padding: 15px;
        }

        th {
            background-color: #cae7f8;
        }
    </style>
</head>

<body>
    <div class="calendar">
        <div class="calendar-header">
            {{-- <h2>Agenda de Citas</h2> --}}
        </div>
        <div class="calendar-content">
            <h3 class="centered-title">Agenda de citas</h3>
            <form id="event-form">
                <br>
                <label for="person-name">Nombre de la Persona:</label>
                <select name="person-name" id="person-name" required>
                    <option value="">Selecciona una persona</option>
                    @foreach ($nombresCompletos as $nombreCompleto)
                    <option value="{{ $nombreCompleto }}">{{ $nombreCompleto }}</option>
                    @endforeach
                </select>
                <label for="event-name">Detalle de cita:</label>
                <input type="text" id="event-name" required>
                <label for="event-date">Fecha y Hora:</label>
                <input type="datetime-local" id="event-date" required>
                <button type="button" id="add-event-button">Agregar Cita</button>
            </form>
        </div>
        <div class="event-list">
            <h3>Citas de Hoy</h3>
            <table>
                <thead>
                    <tr>
                        <th style="text-align: center;">Nombre</th>
                        <th style="text-align: center;">Detalle</th>
                        <th style="text-align: center;">Fecha y Hora</th>
                        <th style="text-align: center;">Acción</th>
                    </tr>
                </thead>
                <tbody id="events-list-today">
                    <!-- Lista de eventos de hoy aquí -->
                </tbody>
            </table>
        </div>
        <div class="event-list">
            <h3>Citas Proximas</h3>
            <table>
                <thead>
                    <tr>
                        <th style="text-align: center;">Nombre</th>
                        <th style="text-align: center;">Detalle</th>
                        <th style="text-align: center;">Fecha y Hora</th>
                        <th style="text-align: center;">Acción</th>
                    </tr>
                </thead>
                <tbody id="events-list">
                    <!-- Lista de eventos aquí -->
                </tbody>
            </table>
            <button type="button" id="clear-events" style="pointer-events: none; cursor: default;">
                <i class="far fa-calendar"></i> <!-- Agrega el icono de calendario aquí -->
            </button>
        </div>
        <div class="event-list">
            <h3>Historial de citas realizadas</h3>
            <table>
                <thead>
                    <tr>
                        <th style="text-align: center;">Nombre</th>
                        <th style="text-align: center;">Detalle</th>
                        <th style="text-align: center;">Fecha y Hora</th>
                        <th style="text-align: center;">Acción</th>
                    </tr>
                </thead>
                <tbody id="past-events-list">
                    <!-- Lista de eventos pasados aquí -->
                </tbody>
            </table>
        </div>
    </div>

    <style>


        table th, table td {
            width: 25%; /* Divide el ancho en 4 columnas iguales */
            text-align: center;
        }
    </style>



    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const eventForm = document.getElementById("event-form");
            const eventNameInput = document.getElementById("event-name");
            const eventDateInput = document.getElementById("event-date");
            const personNameSelect = document.getElementById("person-name");
            const eventList = document.getElementById("events-list");
            const eventListToday = document.getElementById("events-list-today");
            const pastEventsList = document.getElementById("past-events-list");
            const clearEventsButton = document.getElementById("clear-events");

            let selectedEvent = null;

            function isEventToday(eventDate) {
                const today = new Date();
                const eventDateObj = new Date(eventDate);
                return (
                    eventDateObj.getDate() === today.getDate() &&
                    eventDateObj.getMonth() === today.getMonth() &&
                    eventDateObj.getFullYear() === today.getFullYear()
                );
            }

            function isEventPast(eventDate) {
                const today = new Date();
                const eventDateObj = new Date(eventDate);
                return eventDateObj < today;
            }

            function addEventToList(eventName, eventDate, personName) {
                const events = JSON.parse(localStorage.getItem("events")) || [];
                const event = { eventName, eventDate, personName };
                events.push(event);
                localStorage.setItem("events", JSON.stringify(events));

                const eventItem = document.createElement("tr");
                eventItem.innerHTML = `
                    <td>${personName}</td>
                    <td>${eventName}</td>
                    <td>${eventDate}</td>
                    <td><button data-event-id="${events.length - 1}" class="delete-event-button">Eliminar</button></td>
                `;

                if (isEventToday(eventDate)) {
                    eventItem.classList.add("event-today");
                    eventListToday.appendChild(eventItem);
                } else if (isEventPast(eventDate)) {
                    eventItem.classList.add("event-past");
                    pastEventsList.appendChild(eventItem);
                } else {
                    eventList.appendChild(eventItem);
                }

                const deleteButton = eventItem.querySelector(".delete-event-button");
                deleteButton.addEventListener("click", () => {
                    removeEvent(deleteButton.getAttribute("data-event-id"));
                });
            }

            function removeEvent(eventId) {
                const events = JSON.parse(localStorage.getItem("events")) || [];
                if (eventId >= 0 && eventId < events.length) {
                    events.splice(eventId, 1);
                    localStorage.setItem("events", JSON.stringify(events));
                    refreshEventList();
                }
            }

            function refreshEventList() {
                eventList.innerHTML = "";
                eventListToday.innerHTML = "";
                pastEventsList.innerHTML = "";
                const storedEvents = JSON.parse(localStorage.getItem("events")) || [];
                storedEvents.forEach((event, index) => {
                    const { eventName, eventDate, personName } = event;
                    const eventItem = document.createElement("tr");
                    eventItem.innerHTML = `
                        <td>${personName}</td>
                        <td>${eventName}</td>
                        <td>${eventDate}</td>
                        <td><button data-event-id="${index}" class="delete-event-button">Eliminar</button></td>
                    `;

                    if (isEventToday(eventDate)) {
                        eventItem.classList.add("event-today");
                        eventListToday.appendChild(eventItem);
                    } else if (isEventPast(eventDate)) {
                        eventItem.classList.add("event-past");
                        pastEventsList.appendChild(eventItem);
                    } else {
                        eventList.appendChild(eventItem);
                    }

                    const deleteButton = eventItem.querySelector(".delete-event-button");
                    deleteButton.addEventListener("click", () => {
                        removeEvent(deleteButton.getAttribute("data-event-id"));
                    });
                });
            }

            function deleteSelectedEvent() {
                if (selectedEvent !== null) {
                    const eventId = parseInt(selectedEvent.getAttribute("data-event-id"), 10);
                    removeEvent(eventId);
                    selectedEvent = null;
                }
            }

            clearEventsButton.addEventListener("click", () => {
                deleteSelectedEvent();
                deleteTodayEvents();
            });

            function deleteTodayEvents() {
                const todayEventItems = Array.from(eventListToday.getElementsByTagName("tr"));
                todayEventItems.forEach((eventItem) => {
                    eventListToday.removeChild(eventItem);
                });
            }

            document.getElementById("add-event-button").addEventListener("click", function (e) {
                e.preventDefault();
                const eventName = eventNameInput.value;
                const eventDate = eventDateInput.value;
                const personName = personNameSelect.value;

                if (eventName.trim() === '' || eventDate.trim() === '' || personName.trim() === '') {
                    alert('Por favor, complete todos los campos antes de agregar la cita.');
                } else {
                    addEventToList(eventName, eventDate, personName);

                    eventNameInput.value = "";
                    eventDateInput.value = "";
                    personNameSelect.value = "";
                }
            });

            refreshEventList();
        });
    </script>
</body>
@stop
