@if(!empty($alterno))
    <div class="modal fade bs-example-modal-lg" id="EditarAlterno{{ $alterno->id }}" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h2 class="modal-title" id="myModalLabel">Formulario de edición | EVENTOS ALTERNOS </h2>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>
                <br>
                <div class="col-xs-8 col-sm-12 col-md-12">
                    <form id="EditarAlterno" method="POST" action="{{ route('alterno.update', $alterno->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-body" id="cont_modal">
                            {{-- <input type="hidden" name="id_principal" value="{{$principal->id}}"> --}}
                            <div class="item form-group">
                                <label class="col-form-label label-align">Nombre: </label>
                                <div class="col-md-8 col-sm-8 ">
                                    <input name="nombre" id="nombre" style="text-transform: uppercase;"
                                           class="form-control"
                                           value="{{old('nombre') ??  (isset($principal->evaluado) ? $principal->evaluado->nombre .' '. $principal->evaluado->apellido : '')}}"
                                           readonly>
                                </div>
                                <div class="form-group form-check">
                                    @if(old('isIcb') !== null)
                                        <input type="checkbox" class="form-check-input" id="isIcb"
                                               name="isIcb" {{ old('isIcb') == 'on' ? 'checked' : ''}}>
                                    @elseif(isset($alterno->is_icb))
                                        <input type="checkbox" class="form-check-input" id="isIcb"
                                               name="isIcb" {{  $alterno->is_icb ? 'checked' : ''}}>
                                    @else
                                        <input type="checkbox" class="form-check-input" id="isIcb"
                                               name="isIcb">
                                    @endif

                                    <label class="form-check-label" for="isIcb">Incapacidad por cumplimiento del
                                        deber</label>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="col-xs-4 col-sm-4 col-md-3">
                            <label>Natación: </label>
                            <input id="natacion1" type="text" maxlength="5" minlength="5"
                                   onkeypress="validarTiempos(event)" name="natacion" placeholder="00:00"
                                   class="form-control" title="Ingrese tiempo valido (minutos:segundos)" list="natacion"
                                   value="{{old('natacion') ?? $alterno->natacion}}">
                            <datalist id="natacion" name="natacion">
                                @foreach ($natacion as $natacion)
                                    <option value="{{$natacion}}"></option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-3">
                            <label>Caminata:</label>
                            <input id="caminata1" type="text" maxlength="5" minlength="5"
                                   onkeypress="validarTiempos(event)" name="caminata" placeholder="00:00"
                                   class="form-control" title="Ingrese tiempo valido (minutos:segundos)" list="caminata"
                                   value="{{old('caminata') ?? $alterno->caminata}}">
                            <datalist id="caminata" name="caminata">
                                @foreach ($caminata as $caminata)
                                    <option value="{{$caminata}}"></option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-3">
                            <label>Ciclismo:</label>
                            <input id="ciclismo1" type="text" pattern="[0-9:]+" onkeypress="validarTiempos(event)"
                                   name="ciclismo" placeholder="00:00"
                                   class="form-control" title="Ingrese tiempo valido (minutos:segundos)" list="ciclismo"
                                   value="{{old('ciclismo') ?? $alterno->ciclismo}}">
                            <datalist id="ciclismo" name="ciclismo">
                                @foreach ($ciclismo as $ciclismo)
                                    <option value="{{$ciclismo}}"></option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-3">
                            <label>Barra:</label>
                            <input id="barra1" type="text" maxlength="3" minlength="1"
                                   onkeypress="validarNumeros(event)" name="barra" placeholder="00"
                                   class="form-control" title="Ingrese no. de repeticiones valido" list="barra"
                                   value="{{old('barra') ?? $alterno->barra}}"><br>
                            <datalist id="barra" name="barra">
                                @foreach ($barra as $barra)
                                    <option value="{{$barra}}"></option>
                                @endforeach
                            </datalist>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="btnEditarAlterno" class="btn btn-primary">Guardar</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    {{-- validación de campos con JavaScript --}}
    <script>
        // validación de campos
        const natacion1 = document.getElementById('natacion1');
        const caminata1 = document.getElementById('caminata1');
        const ciclismo1 = document.getElementById('ciclismo1');
        const barra1 = document.getElementById('barra1');


        const boton3 = document.getElementById('btnEditarAlterno');
        [natacion1, caminata1, ciclismo1, barra1].forEach(campo3 => {
            campo3.addEventListener('input', () => {
                if (natacion1.value || caminata1.value || ciclismo1.value || barra1.value) {
                    boton3.disabled = false;
                } else {
                    boton3.disabled = true;
                }
            });
        });
    </script>

@endif
