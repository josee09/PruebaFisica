<div class="modal fade bs-example-modal-lg" id="NuevoAlterno{{ $principal->id }}" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h2 class="modal-title" id="myModalLabel">Formulario de registro | EVENTOS ALTERNOS </h2>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
            </div>
            <br>
            <div class="col-xs-8 col-sm-12 col-md-12">
                <form id="NuevoAlterno" method="POST" action="{{ route('alterno.store', $principal->id)}}">
                    @csrf
                    <input type="hidden" name="id_principal" value="{{$principal->id}}">
                    <div class="modal-body" id="cont_modal">
                        <div class="item form-group">
                            <label class="col-form-label label-align">Nombre: </label>
                            <div class="col-md-8 col-sm-8 ">
                                <input name="nombre" style="text-transform: uppercase;" class="form-control"
                                       value="{{old('nombre') ?? $principal->evaluado->nombre .' '. $principal->evaluado->apellido}}"
                                       readonly>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="isIcb" name="isIcb" {{ old('isIcb') == 'on' ? 'checked' : ''}}>
                                <label class="form-check-label" for="isIcb">Incapacidad por cumplimiento del deber</label>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="col-xs-4 col-sm-4 col-md-3">
                        <label>Natación: </label>
                        <input id="natacion_" type="text" maxlength="5" minlength="5" onkeypress="validarTiempos(event)"
                               name="natacion" placeholder="00:00"
                               class="form-control" title="Ingrese tiempo valido (minutos:segundos)" list="natacion"
                               value="{{old('natacion')}}">
                        <datalist id="natacion" name="natacion">
                            @foreach ($natacion as $natacion)
                                <option value="{{$natacion}}"></option>
                            @endforeach
                        </datalist>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-3">
                        <label>Caminata:</label>
                        <input id="caminata_" type="text" maxlength="5" minlength="5" onkeypress="validarTiempos(event)"
                               name="caminata" placeholder="00:00"
                               class="form-control" id="caminata" title="Ingrese tiempo valido (minutos:segundos)"
                               list="caminata" value="{{old('caminata')}}">
                        <datalist id="caminata" name="caminata">
                            @foreach ($caminata as $caminata)
                                <option value="{{$caminata}}"></option>
                            @endforeach
                        </datalist>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-3">
                        <label>Ciclismo:</label>
                        <input id="ciclismo_" type="text" maxlength="5" minlength="5" onkeypress="validarTiempos(event)"
                               name="ciclismo" placeholder="00:00"
                               class="form-control" title="Ingrese tiempo valido (minutos:segundos)" list="ciclismo"
                               value="{{old('ciclismo')}}">
                        <datalist id="ciclismo" name="ciclismo">
                            @foreach ($ciclismo as $ciclismo)
                                <option value="{{$ciclismo}}"></option>
                            @endforeach
                        </datalist>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-3">
                        <label>Barra:</label>
                        <input id="barra_" type="text" maxlength="3" minlength="1" onkeypress="validarNumeros(event)"
                               name="barra" placeholder="00"
                               class="form-control" title="Ingrese no. de repeticiones valido" list="barra"
                               value="{{old('barra')}}"></br>
                        <datalist id="barra" name="barra">
                            @foreach ($barra as $barra)
                                <option value="{{$barra}}"></option>
                            @endforeach
                        </datalist>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="submit" id="btnGuardarAlterno" class="btn btn-primary">Guardar</button>
            </div>
            </form>
        </div>
    </div>
</div>

{{-- validación de campos con JavaScript --}}
{{-- validación de campos con JavaScript --}}
<script>
    // validación de campos
    const natacion = document.getElementById('natacion_');
    const caminata = document.getElementById('caminata_');
    const ciclismo = document.getElementById('ciclismo_');
    const barra = document.getElementById('barra_');


    const boton2 = document.getElementById('btnGuardarAlterno');
    [natacion, caminata, ciclismo, barra].forEach(campo2 => {
        campo2.addEventListener('input', () => {
            if (natacion.value || caminata.value || ciclismo.value || barra.value) {
                boton2.disabled = false;
            } else {
                boton2.disabled = true;
            }
        });
    });
</script>


