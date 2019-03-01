<script src="lib/controladores/usoInsumosProceso.js"></script>
<script src="lib/controladores/llantasEditarCorteBanda.js"></script>
<div ng-controller="usoInsumosProceso">
    <div ng-controller="llantasEditarCorteBanda">
<?php
/**
 * Created by PhpStorm.
 * User: Andres
 * Date: 27/02/2019
 * Time: 20:10
 */
if (strtolower($USUARIO->getRol()->getNombre())!='operario' && strtolower($USUARIO->getRol()->getNombre())!='operario cb'){
    require_once dirname(__FILE__) . '/../Clases/Corte_Banda.php';
    if (isset($_GET['id']) && isset($_GET['idCorteBanda'])) {
        $object = new Corte_Banda("id", $_GET['idCorteBanda'], null, null);
        //$llanta = new Llanta("id", $_GET['id'], null, null);
        if ($object->getIdPuestoTrabajo()!=null) {
            ?>
                    <input type="hidden" name="idEmpleado" value="<?= $USUARIO->getIdEmpleadoUsuario(); ?>">
                    <input type="hidden" name="idLlanta" value="<?= $_GET['id'] ?>">
                    <input type="hidden" name="idCorteBanda" value="<?= $_GET['idCorteBanda'] ?>">
                    <input type="hidden" name="numeroProceso" value="6">
                    <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                        <h3 class="text-uppercase mdl-color-text--blue">EDITAR CORTE DE BANDA</h3>
                        <span class="text text-uppercase text-nowrap">RP: {{ html.data.llanta.rp }}</span>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" id="paddinTop20" ng-show="html.components.loadSpinner">
                        <div class="mdl-spinner mdl-js-spinner is-active"></div>
                    </div>
                    <!--FORM-->
                    <div class="col-sm-12 col-md-12 col-lg-12" id="paddinTop30">
                        <div class="col-sm-12 col-md-3 col-lg-3"></div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <form name="frmCorteBanda" ng-submit="" novalidate>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">* Puesto de trabajo</span>
                                        <select class="form-control" id="idPuestoTrabajo" name="idPuestoTrabajo">
                                            <option value="{{ html.data.puestoTrabajo.id }}">{{ html.data.puestoTrabajo.nombre }}</option>
                                        </select>
                                        <span class="input-group-btn">
                                            <button class="btn btn-success" type="button" id="btnOpenPuestoTrabajo" href="/#dlgUsarInsumosProceso" data-toggle="modal">Abrir</button>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">* Empates:</span>
                                        <input class="form-control has-success" id="txtEmpates" name="empates" ng-model="html.forms.dataFrmCorteBanda.empates" type="number" min="0" max="100" step="any">
                                    </div>
                                    <div class="alert alert-danger text-center" ng-show="html.forms.dataFrmCorteBanda.empates==null && frmCorteBanda.$submitted">Debes dijitar el numero de empates realizados en este corte</div>
                                </div>
                                <div class="form-group" ng-show="html.components.viewPhotoCorteBanda">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <div class="thumbnail">
                                                <img class="card-img-top" id="imgVerTerminacion" style="height: 300px;" ng-src="{{ html.data.img.dataURL }}">
                                                <div class="caption">
                                                    <button class="btn btn-warning" id="btnEliminarImgTerminacion" type="button" ng-click="deletePhoto()">Borrar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">* Foto:</span>
                                        <input class="form-control btn btn-default" id="fotoCorteBanda" type="file" name="fotoCorteBanda" ng-model="html.forms.dataFrmCorteBanda.foto" required accept="image/*" onchange="angular.element(this).scope().setFotoCorteBanda(this.files)" uploader-model="file">
                                    </div>
                                    <div class="alert alert-danger text-center" ng-show="html.forms.dataFrmCorteBanda.foto==null && frmCorteBanda.$submitted">Debes subir una foto que evidencie el proceso de corte de banda</div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">Observaciones: </span>
                                        <textarea class="form-control form-control-sm" name="txtObservaciones" id="txtObservaciones" placeholder="Dijita algunas observaciones sobre el corte de la banda que se registrara" ng-model="html.forms.dataFrmCorteBanda.observaciones"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary hidden" id="btnResetFrmCorteBanda" name="btnResetFrmCorteBanda" type="button" ng-click="resetFrmCorteBanda();">Reiniciar</button>
                                    <button class="btn btn-danger" id="btnCancelarFrmCorteBanda" name="btnCancelarFrmCorteBanda" type="button" ng-click="prevPage();">Cancelar</button>
                                    <button class="btn btn-success" id="btnModificarFrmCorteBanda" name="btnModificarCorteBanda" type="submit">Modificar</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-12 col-md-3 col-lg-3"></div>
                    </div>
                    <!--END FORM-->
                    <!--DLG USOS INSUMOS-->
                    <div class="modal fade" id="dlgUsarInsumosProceso">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button class="close" id="btnCloseDlgAddCorte" data-dismiss="modal">&times;</button>
                                    <h3 class="text text-primary">REGISTRAR USOS DE INSUMOS Y/O HERRAMIENTAS</h3>
                                    <h4 class="text text-muted">{{ page.data.puestoTrabajo.nombre }}</h4>
                                    <div class="row col-md-12" id="paddinTop20" ng-show="page.components.loadSpinnerDialog">
                                        <div class="mdl-spinner mdl-js-spinner is-active"></div>
                                    </div>
                                    <div class="row col-md-12" id="paddinTop20" ng-show="page.components.alertDialog.status">
                                        <div class="alert alert-{{ page.components.alertDialog.color }}">{{ page.components.alertDialog.mjs }}</div>
                                    </div>
                                </div>
                                <!--GESTION INSUMOS-->
                                <div class="modal-header">
                                    <div role="tabpanel">
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li class="active" role="presentacion" ng-click="cleanNovedadPuestoTrabajo()">
                                                <a href="/#lista" aria-control="" data-toggle="tab" role="tab">Insumos y/o herramientas</a>
                                            </li>
                                            <li role="presentacion" ng-click="limpiarUsarYTerminarInsumo()">
                                                <a href="/#enviarNovedad" aria-control="" data-toggle="tab" role="tab">Enviar novedad</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <!--LIST INSUMOS-->
                                            <div role="tabpanel" class="tab-pane active" id="lista">
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="col-sm-12 col-lg-1" id="paddinTop20">
                                                        <button ng-show="page.components.btnRecargarInsumosPuestoTrabajo" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab btn-info" id="btnRecargarListaInsumos" type="button" ng-click="cargarInsumosPuestoTrabajo(page.data.puestoTrabajo.id);">
                                                            <i class="fa fa-refresh"></i>
                                                        </button>
                                                    </div>
                                                    <div class="col-sm-12 col-lg-10">
                                                        <strong class="text text-success control-label"><h2>INSUMOS Y/O HERRAMIENTAS</h2></strong>
                                                    </div>
                                                    <div class="col-sm-12 col-lg-1 hide" id="paddinTop20">
                                                        <button ng-show="page.components.btnUsarVariosInsumos" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab btn-success" id="btnUsarVariosInsumos" type="button" href="/#_UsarVariosInsumos" aria-control="" data-toggle="tab" role="tab">
                                                            <i class="fa fa-check"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!--BUSCADOR-->
                                                <div class="col-lg-12" style="padding-top: 20px;">
                                                    <div class="form-group">
                                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                                            <input class="mdl-textfield__input" id="txtFiltroInsumos" name="txtFiltroInsumos" ng-model="page.components.txtFiltroInsumos">
                                                            <span class="mdl-textfield__label" for="txtFiltroInsumos" style="display: inline-flex;">
                                                                <span class="material-icons">search</span><span> Buscar insumos o herramientas</span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--END BUSCADOR-->
                                                <!--TABLE-->
                                                <div class="col-lg-12" ng-show="page.data.insumos.length>0" id="paddinTop20">
                                                    <center>
                                                        <div class="table-responsive">
                                                            <table class="mdl-data-table mdl-js-data-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="mdl-data-table__cell--non-numeric" ng-click="orden='foto'">
                                                                            <span class="fa fa-camera-retro"></span>
                                                                        </th>
                                                                        <th class="mdl-data-table__cell--non-numeric" ng-click="orden='insumo.nombrepuc'">Insumo</th>
                                                                        <th ng-click="orden='cantidadpuestotrabajo'">Cantidad recibida</th>
                                                                        <th ng-click="orden='remainingStock'">Cantidad disponible</th>
                                                                        <th class="mdl-data-table__cell--non-numeric" ng-click="orden='nombreEstado'">Estado</th>
                                                                        <th class="mdl-data-table__cell--non-numeric">Acciones</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr ng-repeat="dato in page.data.insumos | filter: page.components.txtFiltroInsumos | orderBy: orden">
                                                                        <td class="mdl-data-table__cell--non-numeric">
                                                                            <div class="thumbnail">
                                                                                <img ng-hide="dato.notImage" class="img-responsive" style="width: 50px;" src="system/Uploads/Imgs/Productos/{{ dato.insumo.foto }}">
                                                                                <img ng-show="dato.notImage" class="img-responsive" style="width: 50px;" src="design/pics/imagenes/not_image.jpg" data-toggle="tooltip" title="Este producto no cuenta con una imagen">
                                                                            </div>
                                                                        </td>
                                                                        <td class="mdl-data-table__cell--non-numeric">{{ dato.nombrepuc }}</td>
                                                                        <td>{{ dato.cantidadpuestotrabajo }}</td>
                                                                        <td>{{ dato.remainingStock }}</td>
                                                                        <td class="mdl-data-table__cell--non-numeric">{{ dato.nombreEstado }}</td>
                                                                        <td class="mdl-data-table__cell--non-numeric">
                                                                            <h4>
                                                                                <a ng-show="!getUsado(dato) && dato.remainingStock>1" href="/#usarInsumo_{{ dato.id }}" aria-control="" data-toggle="tab" rol="tab"><span class="text-success fa fa-handshake-o" title="Registrar uso"></span></a>
                                                                                <a ng-show="dato.btnUsar && dato.remainingStock<1" id="paddingLeft10" ng-click="seleccionarInsumoUsarYTerminar(dato)" href='/#_TerminarInsumo' title='Terminar insumo' aria-control="" data-toggle="tab" role="tab"><span class="text-danger fa fa-flag-checkered"></span></a>
                                                                            </h4>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </center>
                                                </div>
                                                <!--END TABLE-->
                                            </div>
                                            <!--End LIST INSUMOS-->
                                            <!--------------------------------------------->
                                            <!--Registro de novedad-->
                                            <div role="tabpanel" class="tab-pane" id="enviarNovedad">
                                                <div class="col-sm-12 col-lg-12" id="paddinTop10">
                                                    <div class="col-md-12 col-sm-12 table-responsive" >
                                                        <strong class="text text-success control-label"><h2>ENVIAR NOVEDAD</h2></strong>
                                                    </div>
                                                    <div class="row col-md-12 text-capitalize" id="paddinTop20">
                                                        <div class="col-md-1"></div>
                                                        <div class="col-md-10">
                                                            <form class="form-horizontal" name="formularioNovedad" id="formularioNovedad" ng-submit="registrarNovedad(this.formularioNovedad)">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon">* Novedad:</span>
                                                                            <textarea class="form-control has-primary" name="txtNovedad" id="txtNovedad" ng-model="page.data.novedadPuestoTrabajo.novedad" placeholder="Escribre la novedad que deseas enviar sobre este puesto de trabajo" rows="5"></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12 col-lg-12" ng-show="page.data.novedadPuestoTrabajo.novedad==null && formularioNovedad.$submitted">
                                                                        <div class="alert alert-danger">Debes rellenar este campo</div>
                                                                    </div>
                                                                    <div class="form-group" id="paddinTop30">
                                                                        <div id="btnEnviaNovedadPuestoTrabajo" class="col-md-12">
                                                                            <input class="btn btn-info" id="btnRegistrarNovedad" type="submit" name="accion" value="Enviar" ng-disabled="page.data.novedadPuestoTrabajo.novedad==null || page.data.novedadPuestoTrabajo.novedad==''">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="col-md-1"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--Fin Registro de novedad-->
                                            <!--------------------------------------------->
                                            <!--Usar insumo-->
                                            <div ng-repeat="dato in page.data.insumos" role="tabpanel" class="tab-pane" id="usarInsumo_{{ dato.id }}">
                                                <div class="col-sm-12 col-lg-12" id="paddinTop10">
                                                    <div class="col-md-12 col-sm-12 table-responsive" >
                                                        <strong class="text text-success control-label"><h2>USAR INSUMO O HERRAMIENTA</h2></strong>
                                                    </div>
                                                    <div class="row col-md-12">
                                                        <div class="col-md-12 page-header" id="paddinTop-20">
                                                            <div class="col-sm-12 col-lg-12 table-responsive">
                                                                <div class="thumbnail">
                                                                    <img ng-hide="dato.notImage" class="img-responsive" style="width: 150px;" src="system/Uploads/Imgs/Productos/{{ dato.foto }}">
                                                                    <img ng-show="dato.notImage" class="img-responsive" style="width: 150px;" src="design/pics/imagenes/not_image.jpg" data-toggle="tooltip" title="Este producto no cuenta con una imagen">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-lg-12 text-justify">
                                                                <label class="text-nowrap text-uppercase">Insumo o herramienta: </label><span class="text text-muted"> {{ dato.nombrepuc }}</span>
                                                            </div>
                                                            <div class="col-sm-12 col-lg-6 text-justify">
                                                                <label class="text-nowrap text-uppercase">Cantidad asignada: </label><span class="text text-muted"> {{ dato.cantidadpuestotrabajo }}</span>
                                                            </div>
                                                            <div class="col-sm-12 col-lg-6 text-justify">
                                                                <label class="text-nowrap text-uppercase">Cantidad disponible: </label><span class="text text-muted"> {{ dato.remainingStock }}</span>
                                                            </div>
                                                            <div class="col-sm-12 col-lg-12 text-justify" style="padding-top: 10px">
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">* Peso banda (<span class="text-muted small">Cantidad usada</span>): </span>
                                                                        <input class="form-control" id="stockUsed" name="txtStockUsed" ng-model="dato.stockUsed" type="number" step="any">
                                                                    </div>
                                                                    <div class="alert alert-danger" ng-show="dato.stockUsed==null">Este campo no puede estar vacio</div>
                                                                    <div class="alert alert-danger" ng-show="dato.stockUsed==0">La cantidad usada debe ser superior a cero</div>
                                                                    <div class="alert alert-danger" ng-show="dato.stockUsed>dato.remainingStock">No puedes usar una cantidad superior a la disponible</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-lg-12 text-center" id="paddinTop10">
                                                            <label class="text text-nowrap text-uppercase">Esta seguro de registrar este uso?</label>
                                                        </div>
                                                        <div class="col-sm-12 col-lg-12" id="paddinTop20">
                                                            <div class="col-md-12">
                                                                <button id="btnRegresarLista" class="btn btn-default" type="button" href="/#lista" aria-control="" data-toggle="tab" role="tab">Regresar a los insumos</button>
                                                                <button ng-disabled="dato.stockUsed==null || dato.stockUsed==0 || dato.stockUsed>dato.remainingStock" class="btn btn-info" id="btnUsarInsumo" type="button" name="accion" ng-click="usarInsumo(dato.id, dato.stockUsed, true)" href="/#lista" aria-control="" data-toggle="tab" role="tab">Usar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--Fin usar insumo-->
                                            <!--------------------------------------------->
                                            <!--Usar y Terminar insumo-->
                                            <div role="tabpanel" class="tab-pane" id="UsarYTerminarInsumo">
                                                <div class="col-sm-12 col-lg-12" id="paddinTop10">
                                                    <div class="col-md-12 col-sm-12 table-responsive" >
                                                        <strong class="text text-success control-label"><h2>Usar y terminar insumo</h2></strong>
                                                    </div>
                                                    <form name="frmUsarYTerminar" id="frmUsarYTerminar" ng-submit="UsarYTerminarInsumo(insumoUsarYTerminar.id, true)">
                                                        <div class="row col-md-12">
                                                            <div class="col-sm-12 col-lg-12 page-header" id="paddinTop-20">
                                                                <div class="col-sm-12 col-lg-12 table-responsive">
                                                                    <div class="thumbnail">
                                                                        <img ng-hide="insumoUsarYTerminar.insumo[0].notImage" class="img-responsive" style="width: 150px;" src="system/Uploads/Imgs/Productos/{{ insumoUsarYTerminar.insumo[0]['foto'] }}">
                                                                        <img ng-show="insumoUsarYTerminar.insumo[0].notImage" class="img-responsive" style="width: 150px;" src="design/pics/imagenes/not_image.jpg" data-toggle="tooltip" title="Este producto no cuenta con una imagen">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-6 text-justify">
                                                                    <label class="text-nowrap text-uppercase">Insumo: </label><span class="text text-muted"> {{ insumoUsarYTerminar.insumo[0].nombrePuc }}</span>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-6 text-justify">
                                                                    <label class="text-nowrap text-uppercase">Presentacion: </label><span class="text text-muted"> {{ insumoUsarYTerminar.insumo[0].nombrePresentacion }}</span>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-6 text-justify">
                                                                    <label class="text-nowrap text-uppercase">Unidad medida: </label><span class="text text-muted"> {{ insumoUsarYTerminar.insumo[0].nombreUnidadMedida }}</span>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-6 text-justify">
                                                                    <label class="text-nowrap text-uppercase">Proveedor: </label><span class="text text-muted"> {{ insumoUsarYTerminar.insumo[0].nombreProveedor }}</span>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-12 text-justify">
                                                                    <label class="text-nowrap text-uppercase">Cantidad a usar y terminar: </label><span class="text text-muted"> {{ insumoUsarYTerminar.cantidad }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-lg-12">
                                                                <div class="col-sm-12 col-lg-12">
                                                                    <div class="form-group" ng-show="html.fotoTerminacion">
                                                                        <div class="row">
                                                                            <div class="col-sm-12 col-md-12">
                                                                                <div class="thumbnail">
                                                                                    <img class="card-img-top" id="imgVerTerminacion" style="height: 300px;" ng-src="{{ thumb.dataURL }}">
                                                                                    <div class="caption">
                                                                                        <button class="btn btn-warning" id="btnEliminarImgTerminacion" type="button" ng-click="deleteImg()">Borrar</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon">Foto:</span>
                                                                            <input id="file" type="file" class="form-control btn btn-default" name="file" required="" accept="image/*" onchange="angular.element(this).scope().photoChanged(this.files)" uploader-model="file">
                                                                        </div>
                                                                    </div>
                                                                    <div class="alert alert-danger text-center" id="paddinTop10" ng-show="html.imgTerminacion=='' && frmUsarYTerminar.$submitted && html.imgTerminacion==null">Debes subir una foto que evidencie la terminacion de la herramienta</div>
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon">Observaciones:</span>
                                                                            <!--<textarea class="form-control" id="txtObservacionesUsaryTerminarInsumo" name="txtUsarYTerminarInsumo" required="" ng-model="terminacionInsumo.observaciones" placeholder="Escribe algunas observaciones"></textarea>-->
                                                                            <textarea class="form-control" id="txtObservacionesUsaryTerminarInsumo" name="txtUsarYTerminarInsumo" ng-model="terminacionInsumo.observaciones" placeholder="Escribe algunas observaciones"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-lg-12 text-center" id="paddinTop10">
                                                                <label class="text text-nowrap text-uppercase">Esta seguro de usar y terminar este insumo?</label>
                                                            </div>
                                                            <div class="col-sm-12 col-lg-12" id="paddinTop20">
                                                                <div class="col-md-12">
                                                                    <button id="btnRegresarLista_2" class="btn btn-default" type="button" href="/#lista" aria-control="" data-toggle="tab" role="tab" ng-click="limpiarUsarYTerminarInsumo()">Regresar</button>
                                                                    <button ng-disabled="html.btnUsarYTerminarInsumo" class="btn btn-info" id="btnUsarYTerminarInsumo" type="submit" name="accion">Aceptar</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <!--Fin usar y terminar insumo-->
                                            <!--------------------------------------------->
                                            <!--Terminar insumo-->
                                            <div role="tabpanel" class="tab-pane" id="_TerminarInsumo">
                                                <div class="col-sm-12 col-lg-12" id="paddinTop10">
                                                    <div class="col-md-12 col-sm-12 table-responsive" >
                                                        <strong class="text text-success control-label"><h2>TERMINAR INSUMO O HERRAMIENTA</h2></strong>
                                                    </div>
                                                    <form name="frmTerminar" id="frmTerminar" ng-submit="UsarYTerminarInsumo(insumoUsarYTerminar.id, false)">
                                                        <div class="row col-md-12">
                                                            <div class="col-sm-12 col-lg-12 page-header" id="paddinTop-20">
                                                                <div class="col-sm-12 col-lg-12 table-responsive">
                                                                    <div class="thumbnail">
                                                                        <img ng-hide="insumoUsarYTerminar.notImage" class="img-responsive" style="width: 150px;" src="system/Uploads/Imgs/Productos/{{ insumoUsarYTerminar.foto }}">
                                                                        <img ng-show="insumoUsarYTerminar.notImage" class="img-responsive" style="width: 150px;" src="design/pics/imagenes/not_image.jpg" data-toggle="tooltip" title="Este producto no cuenta con una imagen">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-12 text-justify">
                                                                    <label class="text-nowrap text-uppercase">Insumo: </label><span class="text text-muted"> {{ insumoUsarYTerminar.nombrepuc }}</span>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-12 text-justify" ng-show="insumoUsarYTerminar.remainingStock==null">
                                                                    <label class="text-nowrap text-uppercase">Cantidad a terminar: </label><span class="text text-muted"> {{ insumoUsarYTerminar.cantidadpuestotrabajo }}</span>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-12 text-justify" ng-show="insumoUsarYTerminar.remainingStock!=null">
                                                                    <label class="text-nowrap text-uppercase">Cantidad a terminar: </label><span class="text text-muted">{{ insumoUsarYTerminar.cantidadpuestotrabajo }}/{{ insumoUsarYTerminar.remainingStock }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-lg-12">
                                                                <div class="col-sm-12 col-lg-12">
                                                                    <div class="form-group" ng-show="page.components.fotoTerminacion">
                                                                        <div class="row">
                                                                            <div class="col-sm-12 col-md-12">
                                                                                <div class="thumbnail">
                                                                                    <img class="card-img-top" id="imgInsumoTerminacion" style="height: 300px;" ng-src="{{ page.data.imgs.fotoTerminacionUrl }}">
                                                                                    <div class="caption">
                                                                                        <button class="btn btn-warning" id="btnEliminarImgTerminacion" type="button" ng-click="deleteImg()">Borrar</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon">* Foto:</span>
                                                                            <input id="fotoTerminación" type="file" class="form-control btn btn-default" name="fotoTerminacion" required="" accept="image/*" onchange="angular.element(this).scope().photoChanged(this.files)" uploader-model="file">
                                                                        </div>
                                                                    </div>
                                                                    <div class="alert alert-danger text-center" id="paddinTop10" ng-show="page.data.imgs.fotoTerminacion=='' && frmUsarYTerminar.$submitted && page.data.imgs.fotoTerminacino==null">Debes subir una foto que evidencie la terminación del insumo o la herramienta</div>
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon">* Observaciones:</span>
                                                                            <textarea class="form-control" id="txtObservacionesUsaryTerminarInsumo" name="txtUsarYTerminarInsumo" required="" ng-model="terminacionInsumo.observaciones" placeholder="Escribe algunas observaciones"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-lg-12 text-center" id="paddinTop10">
                                                                <label class="text text-nowrap text-uppercase">Esta seguro de dar por terminado este insumo o herramienta?</label>
                                                            </div>
                                                            <div class="col-sm-12 col-lg-12" id="paddinTop20">
                                                                <div class="col-md-12">
                                                                    <button id="btnRegresarLista_2" class="btn btn-default" type="button" href="/#lista" aria-control="" data-toggle="tab" role="tab" ng-click="limpiarUsarYTerminarInsumo()">Regresar</button>
                                                                    <button ng-disabled="page.components.btnUsarTerminaInsumo" class="btn btn-info" id="btnUsarYTerminarInsumo" type="submit" name="accion">Aceptar</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <!--Fin terminar insumo-->
                                            <!--------------------------------------------->
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button data-toggle="tab" role="tab" href="/#form" class="btn btn-success">Regresar</button>
                                </div>
                                <!--END GESTION INSUMOS-->
                            </div>
                        </div>
                        <div class="mdl-tooltip" for="btnRecargarListaInsumos">Recargar listado</div>
                        <!--<div id="toast-content" class="mdl-js-snackbar mdl-snackbar">
                            <div class="mdl-snackbar__text"></div>
                            <button class="mdl-snackbar__action" type="button"></button>
                        </div>-->
                        <div id="toast-content-dialog" class="mdl-js-snackbar mdl-snackbar">
                            <div class="mdl-snackbar__text"></div>
                            <button class="mdl-snackbar__action" type="button"></button>
                        </div>
                    </div>
                    <!--END DLG USOS INSUMOS-->
                </div>
            </div>
            <?php
        } else {
            ?>
                    <input type="hidden" name="idLlanta" value="<?= $_GET['id'] ?>">
                    <input type="hidden" name="idCorteBanda" value="<?= $_GET['idCorteBanda'] ?>">
                    <!--<input type="hidden" name="idProceso" value="<?= $_GET['idCorteBanda'] ?>">
                    <input type="hidden" name="metodoProceso" value="getCorteBandaEditar">-->
                    <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" id="paddinTop20" ng-show="html.components.loadSpinner">
                            <div class="mdl-spinner mdl-js-spinner is-active"></div>
                        </div>
                        <div class="alert alert-warning">
                            <h3 class="text-uppercase">AÚN NO SE HA REGISTRADO EL CORTE DE BANDA, POR LO TANTO NO ES POSIBLE EDITAR DICHOS DATOS, INTENTALO MAS TARDE</h3>
                        </div>
                        <button class="btn btn-primary" type="button" ng-click="prevPage();">Regresar</button>
                    </div>
                </div>
            </div>
            <?php
        }
    } else header("Location: principal.php?CON=system/pages/unknowData.php");
} else header("Location: principal.php?CON=system/pages/accesoDenegado.php");
?>
<div id="toast-content" class="mdl-js-snackbar mdl-snackbar">
    <div class="mdl-snackbar__text"></div>
    <button class="mdl-snackbar__action" type="button"></button>
</div>