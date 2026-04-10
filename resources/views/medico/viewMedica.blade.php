@extends('home')

@section('titulo')
{{-- 21-6-23 creación de Vista para Visualizar Evaluaciones Médicas --}}
@stop
{{-- PDF  --}}
@section('contenido')
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Formulario de visualizar Evaluación | Médica</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form id="demo-form2" method="POST" enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left" readonly>
          <br>
          <div class="col-md-3 mb-4">
            <label>No. de identidad:</label>
            <input id="dni" name="dni" readonly type="text" value="{{ $data['dni'] }}" class="form-control" readonly>
          </div>
          <div class="col-md-4 mb-5">
            <label>Nombre:</label>
            <input id="name" name="name" readonly type="text" value="{{ $data['nombre'] . ' ' . $data['apellido'] }}" class="form-control" readonly>
          </div>
          <div class="col-md-3 mb-3">
            <label>Periodo:</label>
            <input id="Periodo" name="Periodo" readonly type="text" value="{{ $medico->periodo }}" class="form-control" readonly>
          </div>
          <div class="clearfix"></div>
          <div class="col-md-1 mb-3">
            <label>Edad:</label>
            <input id="Edad" name="Edad" readonly type="text" value="{{ \Carbon\Carbon::parse($data['fechanac'])->age }}" class="form-control" style="text-align: center;" readonly>
          </div>
          <div class="col-md-1 mb-3">
            <label>Sexo:</label>
            <input id="Sexo" name="Sexo" readonly type="text" value="{{ $data['sexo'] }}" class="form-control" style="text-align: center;" readonly>
            @if( $data['sexo'] === 'F')
            <span>Femenino</span>
            @elseif( $data['sexo'] === 'M')
            <span>Masculino</span>
            @endif
          </div>
          <div class="clearfix"></div>
          <label><h2>Medidas Principales</h2></label>
          <div class="clearfix"></div>
          <div class="col-md-3 mb-2">
            <label>Pulso cardíaco:</label>
            <input id="pulso" readonly name="pulso" value="{{ $medico->pulso }}" type="text" class="form-control" style="text-align: center;" readonly>
          </div>
          <div class="col-md-3 mb-2">
            <label>Oximetría:</label>
            <input id="saturacion" readonly name="saturacion" value="{{ $medico->saturacion }}" type="text" class="form-control" style="text-align: center;" readonly>
          </div>
          <div class="col-md-3 mb-2">
            <label>Presion arterial:</label>
            <input id="Presion" readonly name="Presion" value="{{ $medico->presion }}" type="text" class="form-control" style="text-align: center;" readonly>
          </div>
          <div class="col-md-3 mb-2">
            <label>Altura en METROS:</label>
            <input id="Altura" readonly name="Altura" value="{{ $medico->altura }}" type="text" class="form-control" style="text-align: center;" readonly>
          </div>
          <div class="col-md-3 mb-3">
            <label>Medida de abdomen:</label>
            <input id="Abdomen" readonly name="Abdomen" value="{{ $medico->abdomen }}" type="text" class="form-control" style="text-align: center;" readonly>
          </div>
          <div class="col-md-3 mb-3">
            <label>Medida de Cuello:</label>
            <input id="Cuello" readonly name="Cuello" value="{{ $medico->cuello }}" type="text" class="form-control" style="text-align: center;" readonly>
          </div>
          <div class="clearfix"></div>
          <br>
          <label><h2>Factores de acumulación Cuello-Abdomen</h2></label>
          <div class="clearfix"></div>
          <div class="col-md-3 mb-2">
            <label>Medida de Abdomen-Cuello:</label>
            <input id="Mediabocue" readonly name="Mediabocue" value="{{ $medico->mediabocue }}" type="text" class="form-control" style="text-align: center;" readonly>
          </div>
          <div class="col-md-3 mb-2">
            <label>Factor Abdomen-Cuello:</label>
            <input id="factoabdocue" readonly name="factoabdocue" value="{{ $medico->factoabdocue }}" type="text" class="form-control" style="text-align: center;" readonly>
          </div>
          <div class="col-md-3 mb-2">
            <label>Factor de Altura:</label>
            <input id="Factoaltu" readonly name="Factoaltu" value="{{ $medico->factoaltu }}" type="text" class="form-control" style="text-align: center;" readonly>
          </div>
          <div class="col-md-3 mb-2">
            <label>Porcentaje de grasa en el cuello:</label>
            <input id="Grasa" readonly name="Grasa" value="{{ $medico->grasa }}" type="text" class="form-control" style="text-align: center;" readonly>
          </div>
          <div class="clearfix"></div>
          <br>
          <label><h2>Pesos Real, Ideal, Sobrepeso</h2></label>
          <div class="clearfix"></div>
          <div class="col-md-3 mb-3">
            <label>Peso Real:</label>
            <input id="Pesoreal" readonly name="Pesoreal" value="{{ $medico->pesoreal }}" type="text" class="form-control" style="text-align: center;" readonly>
          </div>
          <div class="col-md-3 mb-3">
            <label>Peso ideal:</label>
            <input id="Pesoideal" readonly name="Pesoideal" value="{{ $medico->pesoideal }}" type="text" class="form-control" style="text-align: center;" readonly>
          </div>
          <div class="col-md-3 mb-3">
            <label>Excedente de peso:</label>
            <input id="Exceso" readonly name="Exceso" type="text" value="{{ $medico->exceso }}" class="form-control" style="text-align: center;" readonly>
          </div>
          <div class="col-md-6 mb-6">
            @if ($medico->exceso < 0)
              <label class="deficit-peso"><h2>Tiene déficit de peso: {{ $medico->exceso }}</h2></label>
            @elseif ($medico->exceso == 0)
              <label class="ideal-peso"><h2>Usted se encuentra en su peso ideal: Libras.{{ $medico->exceso }}</h2></label>
            @else
              <label class="deficit-peso"><h2>Usted tiene un exceso de peso: Libras. {{ $medico->exceso }}</h2></label>
            @endif
            <input id="condicion" name="condicion" type="text" value="{{ $medico->exceso < -5 || $medico->exceso > 5 ? 'No apto' : 'Apto' }}" class="form-control text-uppercase" readonly>
          </div>
          <div class="clearfix"></div>
          <div class="col-md-5 mb-5">
            <label>Medico Evaluador:</label>
            <input id="Medico" readonly name="Medico" type="text" value="{{ $medico->medico }}" class="form-control text-uppercase" readonly>
          </div>
          <div class="col-md-5 mb-5">
            <label>Grado policial de medico:</label>
            <input id="grado" readonly name="grado" type="text" value="{{ $medico->grado_policial }}" class="form-control text-uppercase" readonly>
          </div>
          <div class="clearfix"></div>
          <label for="observaciones">Observaciones:</label><br>
          <textarea id="observaciones" name="observaciones" rows="4" cols="500" style="width: 1000px; height: 100px;" oninput="this.value = this.value.toUpperCase();" style="text-transform: uppercase;" readonly>{{ $medico->observaciones }}</textarea>
        </form>
      </div>
    </div>
  </div>
</div>
{{-- botones de cancelación y de guardado --}}
<div class="clearfix"></div>
<div class="ln_solid"></div>
<div class="item form-group">
  <div class="col-md-12 col-sm-12">
    <a type="button" class="btn btn-danger" href="{{route('medica.index')}}">Cancelar</a>
  </div>
</div>
</div>
@stop
