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
<!--Tabla de registro-->
<div class="col-md-12 table-responsive" ng-controller="llantasOS">
    <div class="hide" id="btnCargarOS" ng-click="cargarOrdenServicio(<?= $objeto->getId() ?>);loadDimensiones();"></div>
    <div ng-hide="llantas" ng-show="elementos.barraCargaListaLlantas" class="col-md-12 text-center">
        <div class="mdl-spinner mdl-js-spinner is-active"></div>
    </div>
    <center class="" id="paddinTop10">
        <table class="mdl-data-table mdl-js-data-table">
            <thead>
                <tr class="text-uppercase">
                    <th class="mdl-data-table__cell--non-numeric" ng-click="ordenar='consecutivo'">N°</th>
                    <th ng-click="ordenar='rp'">RP</th>
                    <th ng-click="ordenar='serie'">Serie</th>
                    <th ng-click="ordenar='nombreMarca'">Marca</th>
                    <th ng-click="ordenar='gravado[0].nombre'">Gravado</th>
                    <th ng-click="ordenar='referenciaOriginal[0].referencia'">Diseño original</th>
                    <th ng-click="ordenar='dimension'">Dimension</th>
                    <th ng-click="ordenar='referenciaSolicitada[0].referencia'">Diseño solicitado</th>
                    <th class="hide" ng-click="ordenar='aplicacionEntregada[0].medidaCompleta'">Diseño entregado</th>
                    <th ng-click="ordenar='nombreEstado'">Estado</th>
                    <th ng-click="ordenar='nombreUrgente'">Urgente</th>
                    <th ng-click="ordenar='salida.valor'">Valor</th>
                    <th><span ng-hide="ObjetoOrdenServicio.btnAcciones" class="fa fa-plus <?= $btnRegistrar ?>" id="btnAdicionarLlanta" href="/#_FormularioLlanta_A" data-toggle="modal" ng-click="abrirModalDialogFormularioLlanta_A();"></span></th>
                    <div class="mdl-tooltip" for="btnAdicionarLlanta">Adicionar llanta</div>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="objeto in llantas | filter: buscar | orderBy: ordenar" ng-show="llantas" style="background: {{ objeto.colorEstado }}; color: {{ objeto.colorLetraEstado }};">
                    <td class="mdl-data-table__cell--non-numeric">{{ objeto.consecutivo }}</td>
                    <td>
                        <h4 ng-dblclick="openProcesoRencauche(objeto.id);">{{ objeto.rp }}</h4>
                    </td>
                    <td>{{ objeto.serie }}</td>
                    <td>{{ objeto.nombreMarca }}</td>
                    <td>{{ objeto.gravado[0].nombre }}</td>
                    <td>{{ objeto.referenciaOriginal[0].referencia }}</td>
                    <td>{{ objeto.dimension }}</td>
                    <td>{{ objeto.referenciaSolicitada[0].referencia}}</td>
                    <td class="hide">{{ objeto.aplicacionEntregada[0].medidaCompleta }}</td>
                    <td>{{ objeto.nombreEstado }}</td>
                    <td style="background: {{ objeto.colorUrgente }}">{{ objeto.nombreUrgente }}</td>
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
                          <span id="paddingLeft10"  class="<?= $btnRegistrar ?>" ng-show="objeto.btnRegistrarDisenoEntregado" >
                              <a href="/#_FormularioDisenoEntregado" data-toggle='modal' title="Registrar dise&ntilde;o entregado" ng-click="instantLlanta(objeto)">
                                  <span class="material-icons">playlist_add_check</span>
                              </a>
                          </span>
                          <span id="paddingLeft10" >
                              <a href="principal.php?CON=system/Pages/procesoServicio.php&id={{ objeto.id }}" id="btnLlantaRencauche_{{ objeto.id }}" title="Proceso de rencauche">
                                  <span class="material-icons">airplay</span>
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
                                    <span class="input-group-addon">* Dise&ntilde;o original:</span>
                                    <select class="form-control" id="spnDisenoOriginal" name="idTipoDisenoOriginal" ng-model="llanta.idTipoDisenoOriginal" ng-change="cargarSpnReferenciasTipo(llanta.idTipoDisenoOriginal);"><?= Tipo_Llanta::getDatosEnOptions(null, null, null) ?></select>
                                </div>
                                <div class="input-group" ng-show="elementos.spnReferenciaOriginal">
                                    <span class="input-group-addon">* Referencia original:</span>
                                    <select class="form-control" id="spnReferenciaDisenoOriginal" name="idReferenciaTipoDisenoOriginal" ng-model="llanta.idReferenciaTipoDisenoOriginal" ng-options="option.referencia for option in elementos.referenciasTipoDisenoOriginal"></select>
                                    <!--<select class="form-control" id="spnReferenciaDisenoOriginal" name="idReferenciaTipoDisenoOriginal" ng-model="llanta.idReferenciaTipoDisenoOriginal" ng-change="cargarSpnMedidasReferenciaTipo(llanta.idReferenciaTipoDisenoOriginal);" ng-options="option.referencia for option in elementos.referenciasTipoDisenoOriginal"></select>-->
                                </div>
                                <div class="input-group" ng-show="elementos.spnMedidaReferenciaOriginal">
                                    <span class="input-group-addon">Medida original:</span>
                                    <select class="form-control" id="spnMedidaReferenciaDisenoOriginal" name="idAplicacionOriginal" ng-model="llanta.idAplicacionOriginal" ng-options="option.medidaCompleta for option in elementos.dimensionesReferenciaTipoLlantaOriginal"></select>
                                </div>
                            </div>
                            <div class="alert alert-danger text-center" id="paddinTop10" ng-show="llanta.idTipoDisenoOriginal=='#' && frmformularioLlantaOS_A.$submitted">Debes seleccionar un diseño original para este registro</div>
                            <div class="alert alert-danger text-center" id="paddinTop10" ng-show="llanta.idReferenciaTipoDisenoOriginal=='#' && frmformularioLlantaOS_A.$submitted">Debes seleccionar una referencia original para este registro</div>
                            <!--<div class="alert alert-danger text-center" id="paddinTop10" ng-show="llanta.idAplicacionOriginal=='#' && frmformularioLlantaOS_A.$submitted">Debes seleccionar una medida original para este registro</div>-->
                        </div>
                        <!--Fin Diseño original-->
                        <!----------------------------------------------------->
                        <!--Diseño solicitado-->
                        <div class="col-sm-12 col-lg-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">* Dise&ntilde;o solicitado:</span>
                                    <select class="form-control" id="spnDisenoSolicitado" name="idTipoDisenoSolicitado" ng-model="llanta.idTipoDisenoSolicitado" ng-change="cargarSpnReferenciasTipoSolicitado(llanta.idTipoDisenoSolicitado);"><?= Tipo_Llanta::getDatosEnOptions(null, null, null) ?></select>
                                </div>
                                <div class="input-group" ng-show="elementos.spnReferenciaSolicitada">
                                    <span class="input-group-addon">* Referencia solicitada:</span>
                                    <select class="form-control" id="spnReferenciaDisenoSolicitado" name="idReferenciaTipoDisenoSolicitado" ng-model="llanta.idReferenciaTipoDisenoSolicitado" ng-options="option.referencia for option in elementos.referenciasTipoDisenoSolicitado"></select>
                                    <!--<select class="form-control" id="spnReferenciaDisenoSolicitado" name="idReferenciaTipoDisenoSolicitado" ng-model="llanta.idReferenciaTipoDisenoSolicitado" ng-change="cargarSpnMedidasReferenciaTipoSolicitado(llanta.idReferenciaTipoDisenoSolicitado);" ng-options="option.referencia for option in elementos.referenciasTipoDisenoSolicitado"></select>-->
                                </div>
                                <div class="input-group" ng-show="elementos.spnMedidaReferenciaSolicitada">
                                    <span class="input-group-addon">Medida solicitada:</span>
                                    <select class="form-control" id="spnMedidaReferenciaDisenoSolicitado" name="idAplicacionSolicitada" ng-model="llanta.idAplicacionSolicitada" ng-options="option.medidaCompleta for option in elementos.dimensionesReferenciaTipoLlantaSolicitada"></select>
                                </div>
                            </div>
                            <div class="alert alert-danger text-center" id="paddinTop10" ng-show="llanta.idTipoDisenoSolicitado=='#' && frmformularioLlantaOS_A.$submitted">Debes seleccionar un diseño solicitado para este registro</div>
                            <div class="alert alert-danger text-center" id="paddinTop10" ng-show="llanta.idReferenciaTipoDisenoSolicitado=='#' && frmformularioLlantaOS_A.$submitted">Debes seleccionar una referencia solicitada para este registro</div>
                            <!--<div class="alert alert-danger text-center" id="paddinTop10" ng-show="llanta.idAplicacionSolicitada=='#' && frmformularioLlantaOS_A.$submitted">Debes seleccionar una medida solicitada para este registro</div>-->
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
                            <h3>Llanta</h3>
                        </div>
                        <div class="text-justify">
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">RP:</label><span class="text text-muted"> {{ dataPage.dataSalida.llanta.rp }}</span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Serie:</label><span class="text text-muted"> {{ dataPage.dataSalida.llanta.serie }}</span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Marca:</label><span class="text text-muted"> {{ dataPage.dataSalida.llanta.nombreMarca }}</span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Gravado:</label><span class="text text-muted"> {{ dataPage.dataSalida.llanta.nombreGravado }}</span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Aplicacion original:</label><span class="text text-muted"> {{ dataPage.dataSalida.llanta.aplicacionOriginal[0].medidaCompleta }}</span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Aplicacion solicitada:</label><span class="text text-muted"> {{ dataPage.dataSalida.llanta.aplicacionSolicitada[0].medidaCompleta }}</span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Aplicacion rencauche:</label><span class="text text-muted"> {{ dataPage.dataSalida.llanta.aplicacionEntregada[0].medidaCompleta }}</span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Dimension:</label><span class="text text-muted"> {{ dataPage.dataSalida.llanta.dimension }}</span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Estado:</label><span class="text text-muted">{{ dataPage.dataSalida.llanta.nombreEstado }}</span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Urgente:</label><span class="text text-muted"> {{ dataPage.dataSalida.llanta.nombreUrgente }}</span>
                            </div>
                            <div class="col-sm-12 col-lg-12">
                                <label class="text-nowrap">Observaciones:</label><span class="text text-muted"> {{ dataPage.dataSalida.llanta.observaciones }}</span>
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