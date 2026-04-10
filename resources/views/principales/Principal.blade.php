@extends('home')
@section('titulo')
    {{-- 18-5-23 creación de Vista para registro de evantos principales --}}
@stop
@section('contenido')
<div class="clearfix"></div> 
  <div class="row">
    <div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
      <div class="x_title">
        <h2> Lista de registros | EVENTOS PRINCIPALES </h2> 
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        {{-- <p>Descargar reporte en formato:
          <a style=" color: white" type="button" class="btn  btn-danger" tabindex="0" href="{{route('principal.pdf')}}"><i class="fa fa-file-pdf-o"></i></a>
        </p> --}}
        

        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="row">
            <div class="col-sm-12">
              <div class="card-box table-responsive">
                <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                        <th scope="col" style="text-align: center">Fecha de Registro</th>
                        <th scope="col" style="text-align: center">No. Identidad</th>
                        <th scope="col" style="text-align: center">Nombre</th>
                        <th scope="col" style="text-align: center">F. Brazo</th>
                        <th scope="col" style="text-align: center">F. Abdomen</th>
                        <th scope="col" style="text-align: center">Carrera 3.2km</th>
                       </tr>
                    </thead>
                    <tbody>
                    @foreach ($principal as $principal)
                    <tr>
                        <th scope="row"><center>{{ \Carbon\Carbon::parse($principal->created_at)->format('d/m/Y') }}</center></th>
                        <td><center>{{ $principal->evaluado->dni }}</center></td>
                        <td><center>{{ $principal->evaluado->nombre }} {{ $principal->evaluado->apellido }}</center></td>
                        <td><center>{{ $principal->pechada }}</center></td>
                        <td><center>{{ $principal->abdominal }}</center></td>
                        <td><center>{{ $principal->carrera }}</center></td>
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
@stop	

