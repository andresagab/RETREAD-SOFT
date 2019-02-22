<?php
if (strtolower($USUARIO->getRol()->getNombre())=='operario') {
    $btnRegistrar='hide';
    $btnEliminarRegistro='hide';
}
else {
    $btnRegistrar='';
    $btnEliminarRegistro='';
}
?>
<div class="table-responsive" ng-controller="llantasOS">
    <div class="hide" id="btnCargarOS" ng-click="cargarOrdenServicio(<?=$objeto->getId()?>)"></div>
    <!--Tabla de registro-->
    <div ng-hide="llantas" ng-show="elementos.barraCargaListaLlantas">
        <div class="mdl-spinner mdl-js-spinner is-active"></div>
    </div>
    <center class="" id="paddinTop10">
        <table class="mdl-data-table mdl-js-data-table">
            <thead>
                <tr>
                    <th class="mdl-data-table__cell--non-numeric" ng-click="ordenar='id'">N°</th>
                    <th ng-click="ordenar='nombreMarca'">Marca</th>
                    <th ng-click="ordenar='nombre'">Gravado</th>
                    <th ng-click="ordenar='rp'">RP</th>
                    <th ng-click="ordenar='serie'">Serie</th>
                    <th ng-click="ordenar='medidaCompleta'">Diseño/Dimension original</th>
                    <th ng-click="ordenar='medidaCompleta'">Diseño/Dimension solicitada</th>
                    <th ng-click="ordenar='medidaCompleta'">Diseño/Dimension entregada</th>
                    <th ng-click="ordenar='nombreEstado'">Estado</th>
                    <th ng-click="ordenar='nombreUrgente'">Urgente</th>
                    <th><span ng-hide="ObjetoOrdenServicio.btnAcciones" class="fa fa-plus <?= $btnRegistrar ?>" id="btnAdicionarLlanta" href="/#_FormularioLlanta_A" data-toggle="modal" ng-click="abrirModalDialogFormularioLlanta_A();"></span></th>
                    <div class="mdl-tooltip" for="btnAdicionarLlanta">Adicionar llanta</div>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="objeto in llantas | filter: buscar | orderBy: ordenar" ng-show="llantas" style="background: {{ objeto.colorEstado }}; color: {{ objeto.colorLetraEstado }};">
                  <td class="mdl-data-table__cell--non-numeric">{{ objeto.id }}</td>
                  <td>{{ objeto.nombreMarca }}</td>
                  <td>{{ objeto.gravado[0].nombre }}</td>
                  <td>{{ objeto.rp }}</td>
                  <td>{{ objeto.serie }}</td>
                  <td>{{ objeto.aplicacionOriginal[0].medidaCompleta }}</td>
                  <td>{{ objeto.aplicacionSolicitada[0].medidaCompleta }}</td>
                  <td>{{ objeto.aplicacionEntregada[0].medidaCompleta }}</td>
                  <td>{{ objeto.nombreEstado }}</td>
                  <td style="background: {{ objeto.colorUrgente }}">{{ objeto.nombreUrgente }}</td>
                  <td>
                      <h4>
                        <a href="principal.php?CON=system/Pages/procesoServicio.php&id={{ objeto.id }}" id="btnLlantaRencauche_{{ objeto.id }}" title="Proceso de rencauche">
                            <span class="fa fa-gears"></span>
                        </a>
                        <a ng-show="objeto.btnRegistrarDisenoEntregado" id="paddingLeft10" href="/#_FormularioDisenoEntregado" data-toggle='modal' title="Registrar dise&ntilde;o entregado" ng-click="instantLlanta(objeto)">
                            <span class="fa fa-check"></span>
                        </a>
                      </h4>
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
                                    <span class="input-group-addon">Marca:</span>
                                    <select class="form-control" id="spnMarca" name="idMarca" ng-model="llanta.idMarca"><?= Marca_Llanta::getDatosEnOptions(null, null, null) ?></select>
                                </div>
                            </div>
                            <div class="alert alert-danger text-center" id="paddinTop10" ng-show="llanta.idMarca=='#' && frmformularioLlantaOS_A.$submitted">Debes seleccionar una marca para este registro</div>
                        </div>
                        <div class="col-sm-12 col-lg-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Gravado:</span>
                                    <select class="form-control" id="spnGravado" name="idGravado" ng-model="llanta.idGravado"><?= Gravado_Llanta::getDatosEnOptions(null, null, null) ?></select>
                                </div>
                            </div>
                            <div class="alert alert-danger text-center" id="paddinTop10" ng-show="llanta.idGravado=='#' && frmformularioLlantaOS_A.$submitted">Debes seleccionar un gravado de llanta para este registro</div>
                        </div>
                        <div class="col-sm-12 col-lg-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">RP:</span>
                                    <input class="form-control has-primary" id="txtRp" name="rp" readonly="" ng-model="llanta.rp">
                                    <span class="input-group-btn">
                                        <button class="input-group btn btn-primary" id="btnActualizarRP" type="button" ng-click="cargarRP();">
                                            <span class="fa fa-refresh input-group"></span>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Serie:</span>
                                    <input class="form-control has-primary" id="txtSerie" name="serie" type="number" ng-model="llanta.serie" ng-change="buscarSerieLlanta(llanta.serie)" min="1" required="">
                                    <!--<span class="input-group-btn">
                                        <button class="input-group btn btn-warning" id="btnBuscarSerie" type="button" ng-click="buscarSerieLlanta(llanta.serie);">
                                            <span class="fa fa-search input-group"></span>
                                        </button>
                                    </span>-->
                                </div>
                            </div>
                        </div>
                        <!--Diseño original-->
                        <div class="col-sm-12 col-lg-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Dise&ntilde;o original:</span>
                                    <select class="form-control" id="spnDisenoOriginal" name="idTipoDisenoOriginal" ng-model="llanta.idTipoDisenoOriginal" ng-change="cargarSpnReferenciasTipo(llanta.idTipoDisenoOriginal);"><?= Tipo_Llanta::getDatosEnOptions(null, null, null) ?></select>
                                </div>
                                <div class="input-group" ng-show="elementos.spnReferenciaOriginal">
                                    <span class="input-group-addon">Referencia original:</span>
                                    <select class="form-control" id="spnReferenciaDisenoOriginal" name="idReferenciaTipoDisenoOriginal" ng-model="llanta.idReferenciaTipoDisenoOriginal" ng-change="cargarSpnMedidasReferenciaTipo(llanta.idReferenciaTipoDisenoOriginal);" ng-options="option.referencia for option in elementos.referenciasTipoDisenoOriginal"></select>
                                </div>
                                <div class="input-group" ng-show="elementos.spnMedidaReferenciaOriginal">
                                    <span class="input-group-addon">Medida original:</span>
                                    <select class="form-control" id="spnMedidaReferenciaDisenoOriginal" name="idAplicacionOriginal" ng-model="llanta.idAplicacionOriginal" ng-options="option.medidaCompleta for option in elementos.dimensionesReferenciaTipoLlantaOriginal"></select>
                                </div>
                            </div>
                            <div class="alert alert-danger text-center" id="paddinTop10" ng-show="llanta.idTipoDisenoOriginal=='#' && frmformularioLlantaOS_A.$submitted">Debes seleccionar un diseño original para este registro</div>
                            <div class="alert alert-danger text-center" id="paddinTop10" ng-show="llanta.idReferenciaTipoDisenoOriginal=='#' && frmformularioLlantaOS_A.$submitted">Debes seleccionar una referencia original para este registro</div>
                            <div class="alert alert-danger text-center" id="paddinTop10" ng-show="llanta.idAplicacionOriginal=='#' && frmformularioLlantaOS_A.$submitted">Debes seleccionar una medida original para este registro</div>
                        </div>
                        <!--Fin Diseño original-->
                        <!----------------------------------------------------->
                        <!--Diseño solicitado-->
                        <div class="col-sm-12 col-lg-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Dise&ntilde;o solicitado:</span>
                                    <select class="form-control" id="spnDisenoSolicitado" name="idTipoDisenoSolicitado" ng-model="llanta.idTipoDisenoSolicitado" ng-change="cargarSpnReferenciasTipoSolicitado(llanta.idTipoDisenoSolicitado);"><?= Tipo_Llanta::getDatosEnOptions(null, null, null) ?></select>
                                </div>
                                <div class="input-group" ng-show="elementos.spnReferenciaSolicitada">
                                    <span class="input-group-addon">Referencia solicitada:</span>
                                    <select class="form-control" id="spnReferenciaDisenoSolicitado" name="idReferenciaTipoDisenoSolicitado" ng-model="llanta.idReferenciaTipoDisenoSolicitado" ng-change="cargarSpnMedidasReferenciaTipoSolicitado(llanta.idReferenciaTipoDisenoSolicitado);" ng-options="option.referencia for option in elementos.referenciasTipoDisenoSolicitado"></select>
                                </div>
                                <div class="input-group" ng-show="elementos.spnMedidaReferenciaSolicitada">
                                    <span class="input-group-addon">Medida solicitada:</span>
                                    <select class="form-control" id="spnMedidaReferenciaDisenoSolicitado" name="idAplicacionSolicitada" ng-model="llanta.idAplicacionSolicitada" ng-options="option.medidaCompleta for option in elementos.dimensionesReferenciaTipoLlantaSolicitada"></select>
                                </div>
                            </div>
                            <div class="alert alert-danger text-center" id="paddinTop10" ng-show="llanta.idTipoDisenoSolicitado=='#' && frmformularioLlantaOS_A.$submitted">Debes seleccionar un diseño solicitado para este registro</div>
                            <div class="alert alert-danger text-center" id="paddinTop10" ng-show="llanta.idReferenciaTipoDisenoSolicitado=='#' && frmformularioLlantaOS_A.$submitted">Debes seleccionar una referencia solicitada para este registro</div>
                            <div class="alert alert-danger text-center" id="paddinTop10" ng-show="llanta.idAplicacionSolicitada=='#' && frmformularioLlantaOS_A.$submitted">Debes seleccionar una medida solicitada para este registro</div>
                        </div>
                        <!--Fin Diseño solicitado-->
                        <!----------------------------------------------------->
                        <div class="col-sm-12 col-lg-12">
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
    <!--Formulario diseno entregado-->
    <div class='modal fade' id='_FormularioDisenoEntregado'>
        <div class='modal-dialog modal-lg'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' id="btnCerrarDialogFormularioDisenoEnregado" data-dismiss='modal' data-dismiss='modal' ng-click="cleanDataDisenoEntregado()">&times;</button>
                    <h3 class="text text-primary">REGISTRAR DISE&Ntilde;O ENTREGADO</h3>
                </div>
                <form id="frmFormularioDisenoEntregado" name="frmDisenoEntregado" ng-submit="registrarDisenoEntregado();">
                    <div class="modal-footer">
                        <div class="col-sm-12 col-lg-12 text-center" ng-show="elementos.barraCarga" id="paddinBottom10">
                            <div class="col-sm-1 col-lg-2"></div>
                            <div class="col-sm-10 col-lg-8">
                                <div class="mdl-progress mdl-js-progress mdl-progress__indeterminate"></div>
                            </div>
                            <div class="col-sm-1 col-lg-2"></div>
                        </div>
                        <div class="col-sm-12 col-lg-12" ng-show="tools.alertaDialog">
                            <div class="alert alert-{{ tools.colorAlertaDialog }} text-center">{{ tools.mjsAlertaDialog }}</div>
                        </div>
                        <!--Diseño original-->
                        <div class="col-sm-12 col-lg-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Dise&ntilde;o entregada:</span>
                                    <select class="form-control" id="spnDisenoEntregado" name="idTipoDisenoEntregado" ng-model="dataDisenoEntregado.idTipoDisenoEntregado" ng-change="cargarSpnReferenciasTipoEntregado(dataDisenoEntregado.idTipoDisenoEntregado);"><?= Tipo_Llanta::getDatosEnOptions(null, null, null) ?></select>
                                </div>
                                <div class="input-group" ng-show="dataDisenoEntregado.spnReferenciaEntregada">
                                    <span class="input-group-addon">Referencia entregada:</span>
                                    <select class="form-control" id="spnReferenciaDisenoEntregado" name="idReferenciaTipoDisenoEntregado" ng-model="dataDisenoEntregado.idReferenciaTipoDisenoEntregado" ng-change="cargarSpnMedidasReferenciaTipoEntregado(dataDisenoEntregado.idReferenciaTipoDisenoEntregado);" ng-options="option.referencia for option in dataDisenoEntregado.referenciasTipoDisenoEntregado"></select>
                                </div>
                                <div class="input-group" ng-show="dataDisenoEntregado.spnMedidaReferenciaEntregada">
                                    <span class="input-group-addon">Medida entregada:</span>
                                    <select class="form-control" id="spnMedidaReferenciaDisenoEntregado" name="idAplicacionEntregada" ng-model="dataDisenoEntregado.idAplicacionEntregada" ng-options="option.medidaCompleta for option in dataDisenoEntregado.dimensionesReferenciaTipoLlantaEntregada"></select>
                                </div>
                            </div>
                            <div class="alert alert-danger text-center" id="paddinTop10" ng-show="dataDisenoEntregado.idTipoDisenoEntregado=='#' && frmDisenoEntregado.$submitted">Debes seleccionar un diseño para este registro</div>
                            <div class="alert alert-danger text-center" id="paddinTop10" ng-show="dataDisenoEntregado.idReferenciaTipoDisenoEntregado=='#' && frmDisenoEntregado.$submitted">Debes seleccionar una referencia para este registro</div>
                            <div class="alert alert-danger text-center" id="paddinTop10" ng-show="dataDisenoEntregado.idAplicacionEntregada=='#' && frmDisenoEntregado.$submitted ">Debes seleccionar una medida para este registro</div>
                        </div>
                        <!--Fin Diseño original-->
                        <div class="col-sm-12 col-lg-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Observaciones:</span>
                                    <textarea class="form-control" id="txtObservacionesLlanta2" name="observaciones" placeholder="Escribe aqui unas observaciones para este registro" ng-model="dataDisenoEntregado.observaciones" maxlength="1000"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' id="btnCancelarFormularioDisenoEntregado" class='btn btn-danger' data-dismiss='modal' ng-click="cleanDataDisenoEntregado()">Cancelar</button>
                        <button type='submit' class='btn btn-success' ng-disabled="dataDisenoEntregado.btnFrmRegistrarDisenoEntregado">Aceptar</button>
                    </div>
                </form>
            </div>
        </div>
        <!--TOOLTIPS-->
        <div class="mdl-tooltip" data-mdl-for="btnCerrarDialogFormularioDisenoEntregado">Cerrar</div>
        <!--FIN TOOLTIPS-->
        <!--------------------------------------------------------------------->
        <!--TOAST-->
        <div id="toast-dialog-de" class="mdl-js-snackbar mdl-snackbar">
            <div class="mdl-snackbar__text"></div>
            <button class="mdl-snackbar__action" type="button"></button>
        </div>
        <!--FIN TOAST-->
    </div>
    <!--FIN Formulario diseno entregado-->
</div>