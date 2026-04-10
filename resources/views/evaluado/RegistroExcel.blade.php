@extends('home')
@section('titulo')
    {{-- 18/05/2023 creación de Vista para ingreso registro mediante Excel --}}
@stop
@section('contenido')
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  </head>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Importar registros | PERSONAL </h2>
                    <div align="right">
                        <style>
                            /* Anula los estilos predeterminados de btn-success y define tu propio color */
                            .btn-success {
                                background-color: #008000; /* Verde fuerte (#008000) */
                                border-color: #008000;
                            }

                            .btn-success:hover {
                                background-color: #006400; /* Cambia el color al pasar el mouse si lo deseas */
                                border-color: #006400;
                            }
                        </style>
                        <a type="button" class="btn  btn-success" align="right"
                            href="{{ route('descargarExcel') }}"><i class="fa fa-download"></i> Descargar Formato de Importación</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <p>Ingrese el documento de excel establecido para el registro de personal a evaluar</p>
                    <form action="{{ route('importar.excel') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <input class="form-control" type="file" id="excel" name="excel">
                        {{-- @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif --}}
                        <br>
                        <p>
                            Pasos para registrar personal por metodo de excel:
                            <br>
                            1. Dar clic en el botón de Descargar formato de importación.
                            <br>
                            2. Debe llenar el documento según las estipulaciones establecidas dentro del documento.
                            <br>
                            3. El formato de guardado del documento debe ser ".CSV delimitado por comas" para evitar errores.
                            <br>
                            4. Dar clic en el botón de EXAMINAR.
                            <br>
                            5. Buscar y elegir el documento previamente guardado.
                            <br>
                            6. Dar clic en el botón de IMPORTAR.
                            <br>
                            Observación:<br>
                            Se mostraran errores en las columnas que poseean error o no estén guardadas conforme al formato
                            <br>
                            Se guardaran los registros que estén de manera correcta; aquellos que presenten incorformidad no seran almacenados.
                        </p>

                        <div class="ln_solid"></div>
                        <div class="col-md-12 text-right">
                            <a type="button" class="btn btn-danger" href="{{ route('registros.index') }}">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Guardar
                            </button>
                        </div>
                        </div>
                    </form>
                    <br>
                </div>
            </div>
        </div>
    </div>

@stop
