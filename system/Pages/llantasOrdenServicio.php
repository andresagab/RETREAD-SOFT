<?php
if (strtolower($USUARIO->getRol()->getNombre())=='operario' || strtolower($USUARIO->getRol()->getNombre())=='operario cb') {
    $btnRegistrar='hide';
    $btnEliminarRegistro='hide';
}
else {
    $btnRegistrar='';
    $btnEliminarRegistro='';
}
?>
<div class="col-md-12 table-responsive" ng-controller="llantasOS">
    <div class="hide" id="btnCargarOS" ng-click="cargarOrdenServicio(<?= $objeto->getId() ?>);loadDimensiones();"></div>
    <div ng-hide="llantas" ng-show="elementos.barraCargaListaLlantas" class="col-md-12 text-center">
        <div class="mdl-spinner mdl-js-spinner is-active"></div>
    </div>
    <!--Tabla de registro-->
    <center class="" id="paddinTop10">
        <table class="mdl-data-table mdl-js-data-table">
            <thead>
                <tr class="text-uppercase">
                    <th ng-click="ordenar='consecutivo'">N°</th>
                    <th ng-click="ordenar='rp'">RP</th>
                    <th ng-click="ordenar='serie'">Serie</th>
                    <th class="mdl-data-table__cell--non-numeric" ng-click="ordenar='nombremarca'">Marca</th>
                    <th class="mdl-data-table__cell--non-numeric" ng-click="ordenar='nombregravado'">Gravado</th>
                    <th class="mdl-data-table__cell--non-numeric" ng-click="ordenar='referenciaoriginal'">Diseño original</th>
                    <th class="mdl-data-table__cell--non-numeric" ng-click="ordenar='dimension'">Dimension</th>
                    <th class="mdl-data-table__cell--non-numeric" ng-click="ordenar='referenciasolicitada'">Diseño solicitado</th>
                    <th class="mdl-data-table__cell--non-numeric" ng-click="ordenar='nombreEstado'">Estado</th>
                    <th class="mdl-data-table__cell--non-numeric" ng-click="ordenar='nombreUrgente'">Urgente</th>
                    <th ng-click="ordenar='salida.valor'">Valor</th>
                    <th><span ng-hide="ObjetoOrdenServicio.btnAcciones" class="fa fa-plus <?= $btnRegistrar ?>" id="btnAdicionarLlanta" href="/#_FormularioLlanta_A" data-toggle="modal" ng-click="abrirModalDialogFormularioLlanta_A();"></span></th>
                    <div class="mdl-tooltip" for="btnAdicionarLlanta">Adicionar llanta</div>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="objeto in llantas | orderBy: ordenar" ng-show="llantas" style="background: {{ objeto.colorEstado }}; color: {{ objeto.colorLetraEstado }};">
                    <td>{{ objeto.consecutivo }}</td>
                    <td>
                        <h4 ng-dblclick="openProcesoRencauche(objeto.id);">{{ objeto.rp }}</h4>
                    </td>
                    <td>{{ objeto.serie }}</td>
                    <td class="mdl-data-table__cell--non-numeric">{{ objeto.nombremarca }}</td>
                    <td class="mdl-data-table__cell--non-numeric">{{ objeto.nombregravado }}</td>
                    <td class="mdl-data-table__cell--non-numeric">{{ objeto.referenciaoriginal }}</td>
                    <td class="mdl-data-table__cell--non-numeric">{{ objeto.dimension }}</td>
                    <td class="mdl-data-table__cell--non-numeric">{{ objeto.referenciasolicitada }}</td>
                    <td class="mdl-data-table__cell--non-numeric">{{ objeto.nombreEstado }}</td>
                    <td class="mdl-data-table__cell--non-numeric" style="background: {{ objeto.colorUrgente }}">{{ objeto.nombreUrgente }}</td>
                    <td>{{ objeto.salida.valor }}</td>
                    <td>
                      <h3>
                          <span ng-hide="ObjetoOrdenServicio.btnAcciones" class="<?= $btnRegistrar ?>">
                              <a href="principal.php?CON=system/Pages/llantasFormulario.php&id={{ objeto.id }}" title="Editar registro" class="text-success">
                                  <span class="material-icons">edit</span>
                              </a>
                          </span>
                          <span id="paddingLeft10"  ng-show="!objeto.procesado" class="<?= $btnEliminarRegistro ?>">
                              <a href="/#dlgEliminarLlanta_{{ objeto.id }}" data-toggle="modal" title="Eliminar registro" class="text-danger">
                                  <span class="material-icons">delete</span>
                              </a>
                          </span>
                          <span id="paddingLeft10"  class="<?= $btnRegistrar ?>" ng-show="objeto.rencauchada_rechazada">
                              <a href="/#dlgRegistrarSalida" data-toggle="modal" title="Registrar salida de la llanta" ng-click="setLlantaSalida(objeto)">
                                  <span class="material-icons" style="color: {{ objeto.colorIcon }}">call_end</span>
                              </a>
                          </span>
                          <span id="paddingLeft10" >
                              <a href="principal.php?CON=system/Pages/procesoServicio.php&id={{ objeto.id }}" id="btnLlantaRencauche_{{ objeto.id }}" title="Proceso de rencauche">
                                  <span class="material-icons">airplay</span>
                              </a>
                          </span>
                          <span id="paddingLeft10" ng-show="objeto.idCorteBanda!=null">
                              <a href="principal.php?CON=system/Pages/llantasEditarCorteBanda.php&id={{ objeto.id }}&idCorteBanda={{ objeto.idCorteBanda }}" id="btnLlantaEditarCorteBanda_{{ objeto.id }}" title="Editar corte de banda" class="mdl-color-text--orange-900">
                                  <span class="material-icons">border_color</span>
                              </a>
                          </span>
                          <span id="paddingLeft10" class="<?= $btnRegistrar ?>">
                              <a title="Imprimir tiquete" ng-click="printTicket(objeto)" href>
                                  <span class="material-icons" style="color: {{ objeto.colorIcon }}">note</span>
                              </a>
                          </span>
                          <span id="paddingLeft10" class="<?= $btnRegistrar ?>">
                              <input type="checkbox" ng-change="selectedPrint(objeto, chkItem);" ng-model="chkItem" name="itemPrint_{{ objeto.id }}" title="Seleccionar para imprimir">
                          </span>
                      </h3>
                    </td>
                </tr>
            </tbody>
        </table>
    </center>
    <!--Fin Tabla de registro-->
    <!------------------------------------------------------------------------->
    <!--Formulario llanta-->
    <div class='modal fade' id='_FormularioLlanta_A'>
        <div class='modal-dialog modal-lg'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' id="btnCerrarDialogFormularioLlanta_A" data-dismiss='modal' ng-click="cleanLlanta();">&times;</button>
                    <h3 class="text text-primary">REGISTRAR LLANTA</h3>
                </div>
                <form id="frmFormularioLlantaOS_A" name="frmformularioLlantaOS_A" ng-submit="registrarLlanta();">
                    <div class="modal-footer">
                        <div class="col-sm-12 col-lg-12 text-center" ng-show="elementos.barraCarga" id="paddinBottom10">
                            <div class="col-sm-1 col-lg-2"></div>
                            <div class="col-sm-10 col-lg-8">
                                <div class="mdl-progress mdl-js-progress mdl-progress__indeterminate"></div>
                            </div>
                            <div class="col-sm-1 col-lg-2"></div>
                        </div>
                        <div class="col-sm-12 col-lg-12" ng-show="elementos.alertaDialog">
                            <div class="alert alert-{{ elementos.colorAlertaDialog }} text-center">{{ elementos.mjsAlertaDialog }}</div>
                        </div>
                        <div class="col-sm-12 col-lg-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">* Marca:</span>
                                    <select class="form-control" id="spnMarca" name="idMarca" ng-model="llanta.idMarca"><?= Marca_Llanta::getDatosEnOptions(null, null, null) ?></select>
                                </div>
                            </div>
                            <div class="alert alert-danger text-center" id="paddinTop10" ng-show="llanta.idMarca=='#' && frmformularioLlantaOS_A.$submitted">Debes seleccionar una marca para este registro</div>
                        </div>
                        <div class="col-sm-12 col-lg-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">* Gravado:</span>
                                    <select class="form-control" id="spnGravado" name="idGravado" ng-model="llanta.idGravado"><?= Gravado_Llanta::getDatosEnOptions(null, null, null) ?></select>
                                </div>
                            </div>
                            <div class="alert alert-danger text-center" id="paddinTop10" ng-show="llanta.idGravado=='#' && frmformularioLlantaOS_A.$submitted">Debes seleccionar un gravado de llanta para este registro</div>
                        </div>
                        <div class="col-sm-12 col-lg-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">* RP:</span>
                                    <input class="form-control has-primary" id="txtRp" name="rp" type="text" ng-model="llanta.rp">
                                    <!--<input class="form-control has-primary" id="txtRp" name="rp" type="number" ng-model="llanta.rp">-->
                                    <span class="input-group-btn hide">
                                        <button class="input-group btn btn-primary" id="btnActualizarRP" type="button" ng-click="cargarRP();">
                                            <span class="fa fa-refresh input-group"></span>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <div class="alert alert-danger text-center" id="paddinTop10" ng-show="llanta.rp=='' && frmformularioLlantaOS_A.$submitted">El campo RP no puede estar vacio</div>
                        </div>
                        <div class="col-sm-12 col-lg-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">* Serie:</span>
                                    <input class="form-control has-primary" id="txtSerie" name="serie" type="text" ng-model="llanta.serie" ng-change="buscarSerieLlanta(llanta.serie)" required="">
                                </div>
                            </div>
                        </div>
                        <!--Diseño original-->
                        <div class="col-sm-12 col-lg-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Cargar todos?</span>
                                    <span class="input-group-addon">
                                        <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="tcdo">
                                            <input class="mdl-checkbox__input" type="checkbox" id="tcdo" name="tcdo" ng-model="llanta.tcdo" checked ng-change="loadSpinnerReferenciasTipo(llanta.idTipoDisenoOriginal, llanta.tcdo, true)">
                                            <span class="input-group-addon mdl-checkbox__label" ng-show="llanta.tcdo">Si</span>
                                            <span class="input-group-addon mdl-checkbox__label" ng-show="!llanta.tcdo">No</span>
                                        </label>
                                    </span>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">* Dise&ntilde;o original:</span>
                                    <select class="form-control" id="spnDisenoOriginal" name="idTipoDisenoOriginal" ng-model="llanta.idTipoDisenoOriginal" ng-change="loadSpinnerReferenciasTipo(llanta.idTipoDisenoOriginal, llanta.tcdo, true);"><?= Tipo_Llanta::getDatosEnOptions(null, null, null) ?></select>
                                </div>
                                <div class="input-group" ng-show="elementos.spnReferenciaOriginal">
                                    <span class="input-group-addon">* Referencia original:</span>
                                    <select class="form-control" id="spnReferenciaDisenoOriginal" name="idReferenciaTipoDisenoOriginal" ng-model="llanta.idReferenciaTipoDisenoOriginal" ng-options="option.referencia for option in elementos.referenciasTipoDisenoOriginal"></select>
                                </div>
                            </div>
                            <div class="alert alert-danger text-center" id="paddinTop10" ng-show="llanta.idTipoDisenoOriginal=='#' && frmformularioLlantaOS_A.$submitted">Debes seleccionar un diseño original para este registro</div>
                            <div class="alert alert-danger text-center" id="paddinTop10" ng-show="llanta.idReferenciaTipoDisenoOriginal=='#' && frmformularioLlantaOS_A.$submitted">Debes seleccionar una referencia original para este registro</div>
                        </div>
                        <!--Fin Diseño original-->
                        <!----------------------------------------------------->
                        <!--Diseño solicitado-->
                        <div class="col-sm-12 col-lg-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Cargar todos?</span>
                                    <span class="input-group-addon">
                                        <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="tcds">
                                            <input class="mdl-checkbox__input" type="checkbox" id="tcds" name="tcds" ng-model="llanta.tcds" checked ng-change="loadSpinnerReferenciasTipo(llanta.idTipoDisenoSolicitado, llanta.tcds, false)">
                                            <span class="input-group-addon mdl-checkbox__label" ng-show="llanta.tcds">Si</span>
                                            <span class="input-group-addon mdl-checkbox__label" ng-show="!llanta.tcds">No</span>
                                        </label>
                                    </span>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">* Dise&ntilde;o solicitado:</span>
                                    <select class="form-control" id="spnDisenoSolicitado" name="idTipoDisenoSolicitado" ng-model="llanta.idTipoDisenoSolicitado" ng-change="loadSpinnerReferenciasTipo(llanta.idTipoDisenoSolicitado, llanta.tcds, false);"><?= Tipo_Llanta::getDatosEnOptions(null, null, null) ?></select>
                                </div>
                                <div class="input-group" ng-show="elementos.spnReferenciaSolicitada">
                                    <span class="input-group-addon">* Referencia solicitada:</span>
                                    <select class="form-control" id="spnReferenciaDisenoSolicitado" name="idReferenciaTipoDisenoSolicitado" ng-model="llanta.idReferenciaTipoDisenoSolicitado" ng-options="option.referencia for option in elementos.referenciasTipoDisenoSolicitado"></select>
                                </div>
                            </div>
                            <div class="alert alert-danger text-center" id="paddinTop10" ng-show="llanta.idTipoDisenoSolicitado=='#' && frmformularioLlantaOS_A.$submitted">Debes seleccionar un diseño solicitado para este registro</div>
                            <div class="alert alert-danger text-center" id="paddinTop10" ng-show="llanta.idReferenciaTipoDisenoSolicitado=='#' && frmformularioLlantaOS_A.$submitted">Debes seleccionar una referencia solicitada para este registro</div>
                        </div>
                        <!--Fin Diseño solicitado-->
                        <!----------------------------------------------------->
                        <div class="col-sm-12 col-lg-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">* Dimension</span>
                                    <!--<select class="form-control" id="spnDimension" ng-model="llanta.dimension" placeholder="220/22 R15"></select>-->
                                    <input class="form-control" id="txtDimension" type="text" ng-model="llanta.dimension" placeholder="220/22 R15" required ng-change="completeDimensiones();setDimension(null, llanta.dimension)" autocomplete="off">
                                </div>
                            </div>
                            <div class="alert alert-danger text-center" ng-show="llanta.dimension==null && frmformularioLlantaOS_A.$submitted">El campo dimension no puede estar vacio</div>
                            <ul class="list-group" ng-hide="dataPage.hideAutocompleteDimensiones">
                                <li id="liAutocompleteDimensiones" class="list-group-item" ng-repeat="data in filterDimensiones" ng-click="setFieldDimensiones(data)" style="#liAutocompleteDimensiones{cursor: pointer;};#liAutocompleteDimensiones:hover{background-color:  #f9f9f9;">{{ data.dimension }}</li>
                            </ul>
                        </div>
                        <div class="col-sm-12 col-lg-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Urgente:</span>
                                    <span class="input-group-addon">
                                        <span id="paddingLeft70"></span>
                                        <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="chkUrgente">
                                            <input type="checkbox" id="chkUrgente" class="mdl-switch__input" name="urgente" ng-model="llanta.urgente" ng-checked="llanta.urgente">
                                        </label>
                                    </span>
                                    <span class="input-group-addon"><label id="textoEstado">{{ cargarNombreUrgenteChk(llanta.urgente) }}</label></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Observaciones:</span>
                                    <textarea class="form-control" id="txtObservacionesLlanta" name="observaciones" placeholder="Escribe aqui unas observaciones para este registro" ng-model="llanta.observaciones" maxlength="1000"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' id="btnCancelarMDFormularioLlanta_A" class='btn btn-danger' data-dismiss='modal' ng-click="cleanLlanta();">Cancelar</button>
                        <button type='submit' class='btn btn-success'>Aceptar</button>
                    </div>
                </form>
            </div>
        </div>
        <!--TOOLTIPS-->
        <div class="mdl-tooltip" data-mdl-for="btnCerrarDialogFormularioLlanta_A">Cerrar</div>
        <div class="mdl-tooltip" data-mdl-for="btnActualizarRP">Recargar RP</div>
        <div class="mdl-tooltip" data-mdl-for="btnBuscarSerie">Consultar disponibilidad del numero de serie</div>
        <!--FIN TOOLTIPS-->
        <!--------------------------------------------------------------------->
        <!--TOAST-->
        <div id="toast-dialog" class="mdl-js-snackbar mdl-snackbar">
            <div class="mdl-snackbar__text"></div>
            <button class="mdl-snackbar__action" type="button"></button>
        </div>
        <!--FIN TOAST-->
    </div>
    <!--FIN Formulario llanta-->
    <!------------------------------------------------------------------------->
    <!--Dlg Eliminar llanta-->
    <div ng-repeat="objeto in llantas" class="modal fade" id="dlgEliminarLlanta_{{ objeto.id }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal" id="btnCloseDlgDeleteLlanta">&times;</button>
                    ¿Esta seguro de eliminar la llanta con <b>RP: </b>{{ objeto.rp }}?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" id="btnCloseDlgDeleteLlanta" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-success" type="button" id="btnDeleteLlantaAction" data-dismiss="modal" ng-click="deleteLlanta(objeto);">Eliminar</button>
                </div>
            </div>
        </div>
    </div>
    <!--Fin Dlg Eliminar llanta-->
    <!------------------------------------------------------------------------->
    <!--Dlg Registrar salida-->
    <div class="modal fade" id="dlgRegistrarSalida">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" id="btnCloseDlgRegistrarSalida" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="text text-primary">REGISTRAR SALIDA</h3>
                </div>
                <form name="frmAddSalida" novalidate ng-submit="addSalidaLlanta()">
                    <div class="modal-header">
                        <!--CONTENT-->
                        <div class="col-md-12" ng-show="dataPage.dataSalida.spinnerCarga">
                            <div class="mdl-spinner mdl-js-spinner is-active"></div>
                        </div>
                        <div class="col-sm-12 col-lg-12">
                            <h3 class="text text-success">Llanta</h3>
                        </div>
                        <div class="col-lg-12 text-justify" id="paddinTop20">
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">RP: </label><span class="text text-muted"> {{ dataPage.dataSalida.llanta.rp }}</span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Serie: </label><span class="text text-muted"> {{ dataPage.dataSalida.llanta.serie }}</span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Marca: </label><span class="text text-muted"> {{ dataPage.dataSalida.llanta.nombremarca }}</span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Gravado: </label><span class="text text-muted"> {{ dataPage.dataSalida.llanta.nombregravado }}</span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Aplicacion original: </label><span class="text text-muted"> {{ dataPage.dataSalida.llanta.referenciaoriginal }}</span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Aplicacion solicitada: </label><span class="text text-muted"> {{ dataPage.dataSalida.llanta.referenciasolicitada }}</span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Dimension: </label><span class="text text-muted"> {{ dataPage.dataSalida.llanta.dimension }}</span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Estado: </label><span class="text text-muted">{{ dataPage.dataSalida.llanta.nombreEstado }}</span>
                            </div>
                            <div class="col-sm-12 col-lg-12">
                                <label class="text-nowrap">Urgente: </label><span class="text text-muted"> {{ dataPage.dataSalida.llanta.nombreUrgente }}</span>
                            </div>
                            <div class="col-sm-12 col-lg-12">
                                <label class="text-nowrap">Observaciones: </label><span class="text text-muted"> {{ dataPage.dataSalida.llanta.observaciones }}</span>
                            </div>
                        </div>
                        <div class="col-md-12 form-group" id="paddinTop10">
                            <div class="input-group">
                                <span class="input-group-addon">* Valor:</span>
                                <input class="form-control form-control-sm" type="number" id="txtValorSalida" ng-model="dataPage.dataSalida.valor" required>
                            </div>
                            <div class="alert alert-danger" ng-show="dataPage.dataSalida.valor==null && frmAddSalida.$submitted">Este campo no puede estar vacio</div>
                        </div>
                        <div class="col-sm-12 col-lg-12">
                            <span class="text text-nowrap">¿Esta seguro de registrar la salida de esta llanta?</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" type="button" id="btnCancelarDlgRegistrarSalida" data-dismiss="modal">Cancelar</button>
                        <button class="btn btn-success" type="submit" id="btnRegistrarSalidaAction" ng-click="">Aceptar</button>
                    </div>
                </form>
            </div>
        </div>
        <!--TOAST-->
        <div id="toast-dlg-addSalida" class="mdl-js-snackbar mdl-snackbar">
            <div class="mdl-snackbar__text"></div>
            <button class="mdl-snackbar__action" type="button"></button>
        </div>
        <!--FIN TOAST-->
    </div>
    <!--Fin Dlg Registrar salida-->
</div>