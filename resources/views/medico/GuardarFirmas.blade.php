{{-- MODAL PARA GUARDAR DOCUMENTO HOJA DE CONTROL FIRMADA --}}
<div class="modal fade bs-example-modal-lg" id="NuevaFirmaMedica{{ $medico->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h2 class="modal-title" id="myModalLabel">Registro de documentos | HOJA INDIVIDUAL DE EVALUACIÓN MÉDICA</h2>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
            </div>
            <br>
            <div class="col-xs-8 col-sm-12 col-md-12">
                <form enctype="multipart/form-data" id="DocumentoFirmasMedicas" method="POST" action="{{ route('FirmaMedica.update', $medico->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                    @csrf
                    @method('PUT')
                    <input name="id_medico" id="id_medico" type="hidden" value="{{ $medico->id }}">
                        <div class="modal-body" id="cont_modal">
                            <div class="item form-group">
                                <label class="col-form-label label-align">Nombre: </label>
                                    <div class="col-md-8 col-sm-8 "> 
                                    <input  name="doc_nombre" id="doc_nombre"  onkeypress="validarLetras(event)" style="text-transform: uppercase;" class="form-control" 
                                    value="FIRMA-EVALUACIÓN-MÉDICA-{{ $medico->evaluado->dni }}-{{\Carbon\Carbon::parse($medico->create_at)->format('d-m-Y')}}" readonly="readonly">
                                    </div>
                            </div>
                            <div class="item form-group">
                                <label class="col-form-label label-align">Documento: <span class="required">*</span></label>
                                <div class="col-md-8 col-sm-8 "> 
                                    <input type="file" accept=".pdf" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" name="doc_firma" id="doc_firma"   required>
                                </div>
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
    {{-- FIN MODAL PARA GUARDAR DOCUMENTO HOJA DE CONTROL FIRMADA --}}