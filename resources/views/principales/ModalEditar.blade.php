

  <div class="modal fade bs-example-modal-lg" id="ModalEditar{{ $principal->id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
            <h2 class="modal-title" id="myModalLabel">Formulario de edición | EVENTOS PRINCIPALES </h2>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
            </div>
            <br>
            <div class="col-xs-8 col-sm-12 col-md-12">
                <form id="EditarPrincipal" method="POST" action="{{ route('principal.update', $principal->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_principal" value="{{$principal->id}}">
                        <div class="modal-body" id="cont_modal">
                            <div class="item form-group">
                                <label class="col-form-label label-align">Nombre: </label>
                                    <div class="col-md-8 col-sm-8 ">
                                    <input name="nombre" id="nombre" style="text-transform: uppercase;" class="form-control"
                                    value="{{old('nombre') ?? $principal->evaluado->nombre .' '. $principal->evaluado->apellido}}" readonly>
                                    </div>
                            </div>
                        </div>
                        <br>
                        <div class="col-xs-4 col-sm-4 col-md-4" >
                            <label>Flexiones de brazo:</label>
                            <input id="pechada1" type="text" maxlength="3" minlength="1" onkeypress="validarNumeros(event)" name="pechada" placeholder="00"
                            class="form-control" title="Ingrese no. de repeticiones valido" list="pechada" value="{{old('pechada')  ?? $principal->pechada}}" >
                            <datalist id="pechada" name="pechada">
                                @foreach ($pechada as $pechada)
                                <option value="{{$pechada}}"></option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <label>Flexiones de abdomen:</label>
                            <input id="abdominal1" type="text" maxlength="3" minlength="1" onkeypress="validarNumeros(event)" name="abdominal" placeholder="00"
                            class="form-control" title="Ingrese no. de repeticiones valido" list="abdominal" value="{{old('abdominal')  ?? $principal->abdominal}}" >
                            <datalist id="abdominal" name="abdominal">
                                @foreach ($abdominal as $abdominal)
                                <option value="{{$abdominal}}"></option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4" >
                            <label>Carrera 3.2 km</label>
                            <input id="carrera1" type="text" maxlength="5" minlength="5" onkeypress="validarTiempos(event)" name="carrera" placeholder="00:00"
                            class="form-control" title="Ingrese tiempo valido (minutos:segundos)" list="carrera" value="{{old('carrera')  ?? $principal->carrera}}" ></br>
                            <datalist id="carrera" name="carrera">
                                @foreach ($carrera as $carrera)
                                <option value="{{$carrera}}"></option>
                                @endforeach
                            </datalist>
                        </div>
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btnEditarPrincipal" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

{{-- validación de campos con JavaScript --}}
<script>
    // validación de campos
    const pechada1 = document.getElementById('pechada1');
    const abdominal1 = document.getElementById('abdominal1');
    const carrera1 = document.getElementById('carrera1');

    const boton1 = document.getElementById('btnEditarPrincipal');
    [pechada1, abdominal1, carrera1].forEach(campo1 => {
      campo1.addEventListener('input', () => {
        if(pechada1.value || abdominal1.value || carrera1.value){
          boton1.disabled=false;
        } else {
          boton1.disabled=true;
        }
        });
      });
  </script>
