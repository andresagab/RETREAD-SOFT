<?php
require_once dirname(__FILE__).'\..\Clases\Persona.php';
require_once dirname(__FILE__).'\..\Clases\Cargo_Empleado.php';
require_once dirname(__FILE__).'\..\Clases\Empleado.php';
require_once dirname(__FILE__).'\..\Clases\Cliente.php';
require_once dirname(__FILE__).'\..\Clases\Tipo_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Marca_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Gravado_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Dimension_Referencia.php';
require_once dirname(__FILE__).'\..\Clases\Referencia_Tipo_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Servicio.php';
require_once dirname(__FILE__).'\..\Clases\Inspeccion_Inicial.php';
require_once dirname(__FILE__).'\..\Clases\Raspado.php';
require_once dirname(__FILE__).'\..\Clases\Puc.php';
require_once dirname(__FILE__).'\..\Clases\Producto.php';
require_once dirname(__FILE__).'\..\Clases\Puesto_Trabajo.php';
require_once dirname(__FILE__).'\..\Clases\Preparacion.php';
require_once dirname(__FILE__).'\..\Clases\Reparacion.php';
require_once dirname(__FILE__).'\..\Clases\Cementado.php';
require_once dirname(__FILE__).'\..\Clases\Relleno.php';
require_once dirname(__FILE__).'\..\Clases\Corte_Banda.php';
require_once dirname(__FILE__).'\..\Clases\Embandado.php';
require_once dirname(__FILE__).'\..\Clases\Vulcanizado.php';
require_once dirname(__FILE__).'\..\Clases\Inspeccion_Final.php';
require_once dirname(__FILE__).'\..\Clases\Terminacion.php';
if (isset($_GET['id'])) {
    $objeto=new Terminacion('id', $_GET['id'], null, null);
    $inspeccionFinal=$objeto->getInspeccionFinal();
    $vulcanizado=$inspeccionFinal->getVulcanizado();
    $embandado=$vulcanizado->getEmbandado();
    $corteBanda=$embandado->getCorteBanda();
    $relleno=$corteBanda->getRelleno();
    $cementado=$relleno->getCementado();
    $reparacion=$cementado->getReparacion();
    $preparacion=$reparacion->getPreparacion();
    $raspado=$preparacion->getRaspado();
    $inspeccionInicial=$raspado->getInspeccion();
    $servicio=$inspeccionInicial->getLlanta()->getServicio();
    $accion="Modificar";
    $accionBD="RegistrarFin";
} else {
    $objeto=new Terminacion(null, null, null, null);
    $objeto->setIdInspeccionFinal($_GET['idInspeccionFinal']);
    $inspeccionFinal=$objeto->getInspeccionFinal();
    $vulcanizado=$inspeccionFinal->getVulcanizado();
    $embandado=$vulcanizado->getEmbandado();
    $corteBanda=$embandado->getCorteBanda();
    $relleno=$corteBanda->getRelleno();
    $cementado=$relleno->getCementado();
    $reparacion=$cementado->getReparacion();
    $preparacion=$reparacion->getPreparacion();
    $raspado=$preparacion->getRaspado();
    $inspeccionInicial=$raspado->getInspeccion();
    $servicio=$inspeccionInicial->getLlanta()->getServicio();
    $accion="Registrar";
    $accionBD="Registrar";
}
$llanta=$inspeccionInicial->getLlanta();
$cliente=$servicio->getCliente();
if ($cliente->getRazonSocial()!=null || $cliente->getRazonSocial()!='') $nombreProveedor=$cliente->getRazonSocial();
else $nombreProveedor=$cliente->getPersona()->getNombresCompletos();
?>
<script src="lib/controladores/rechazoLlanta.js"></script>
<div class="col-md-12" ng-controller="rechazoLlanta">
    <div class="col-md-4" ></div>
    <div class="col-md-4" >
        <strong class="text text-uppercase mdl-color-text--blue control-label"><h2><?=$accion?> terminacion</h2></strong>
    </div>
    <div class="col-md-4">
        <button class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab btn-info" id="btnDetalles" type="button" href="/#_Dialog_DetallesProceso" data-toggle="modal">
            <i class="fa fa-info-circle"></i>
        </button>
        <div class="mdl-tooltip" for="btnDetalles">Detalles de la llanta y la orden de servicio</div>
    </div>
    <div class="row col-md-12 text-capitalize" id="paddinTop20">
    <div class="col-md-1"></div>
    <div class="col-md-10" ng-controller="images">
        <form class="form-horizontal" name="formulario" method="POST" action="principal.php?CON=system/Pages/terminacionActualizar.php" enctype="multipart/form-data">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="form-group" ng-show="foto">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="thumbnail">
                                <img class="card-img-top" id="img" style="height: 300px;" ng-src="{{ thumbnail.dataURL }}">
                                <div class="caption">
                                    <button class="btn btn-warning" id="btnEliminarImg" type="button" ng-click="deleteImg()">Borrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">* Foto:</span>
                        <input type="file" class="form-control btn btn-default" name="foto" id="foto" required="" accept="image/*" onchange="angular.element(this).scope().photoChanged(this.files)">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">Estado:</span>
                        <span class="input-group-addon">
                            <span id="paddingLeft70"></span>
                            <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="estado">
                                <input type="checkbox" id="estado" class="mdl-switch__input" name="checked" ng-model="html.estado" ng-change="cargarNombreEstado(html.estado)">
                            </label>
                        </span>
                        <span class="input-group-addon"><label id="textoEstado">{{ cargarNombreEstado(html.estado) }}</label></span>
                    </div>
                </div>
                <div class="form-group center-block" id="divBtnSeleccionarRechazos" ng-show="!html.estado">
                    <button class="btn btn-success" id="btnSeleccionarRechazos" type="button" href="/#seleccionarRechazos" data-toggle="modal" ng-click="loadRechazosOfProceso(<?=$llanta->getId()?>, 10)">Seleccionar rechazos</button>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">Observaciones:</span>
                        <textarea class="form-control has-primary input-sm" name="observaciones" placeholder="Observaciones para este proceso" maxlength="500"><?= rtrim($objeto->getObservaciones())?></textarea> 
                    </div>
                </div>
                <div class="hidden">
                    <div class="col-md-12"><input type="hidden" name="id" value="<?=$objeto->getId()?>"></div>
                    <div class="col-md-12"><input type="hidden" name="idInspeccionFinal" value="<?=$objeto->getIdInspeccionFinal()?>"></div>
                    <div class="col-md-12"><input type="hidden" name="idEmpleado" value="<?=$USUARIO->getIdEmpleadoUsuario()?>"></div>
                </div>
                <div class="form-group" id="paddinTop20">
                     <a href="principal.php?CON=system/Pages/procesoServicio.php&id=<?=$objeto->getInspeccionFinal()->getVulcanizado()->getEmbandado()->getCorteBanda()->getRelleno()->getCementado()->getReparacion()->getPreparacion()->getRaspado()->getInspeccion()->getIdLlanta()?>"><input class="btn btn-danger" type="button" name="Cancelar" value="Cancelar"></a>
                     <input class="btn btn-info" type="submit" name="accion" value="<?=$accion?>">
                </div>
            </div>
            <div class="col-md-3"></div>
        </form>
    </div>
    <div class="col-md-1"></div>
    </div>
    <div class='modal fade' id='seleccionarRechazos'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' ng-click="limpiarVariables();">&times;</button>
                    <h3 class="text text-primary">Rechazos</h3>
                </div>
                <div class="modal-header">
                    <div class="col-lg-12 col-sm-12" ng-hide="objetos">
                        <span class="text text-info fa fa-circle-o-notch fa-spin fa-4x"></span>
                    </div>
                    <div class="col-lg-12" ng-show="objetos">
                        <ul class="mdl-list">
                            <li class="mdl-list__item" ng-repeat="objeto in objetos">
                                <span class="mdl-list__item-primary-content">
                                    <i class="material-icons  mdl-list__item-avatar mdl-color--teal mdl-color-text--white">R</i>
                                    {{ objeto.nombre }}
                                </span>
                                <span class="mdl-list__item-secondary-action">
                                    <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="chk_{{ objeto.id }}">
                                        <input ng-show="!objeto.checked" class="mdl-checkbox__input" id="chk_{{ objeto.id }}" type="checkbox" name="chk_{{  objeto.id }}" ng-model="chk" ng-click="separarRechazo(chk, objeto.id)">
                                        <!--
                                        Si no existe la variable checked en el objeto JSON se presenta el input anterior en caso contrario se muesta los dos siguientes;
                                        El Primero hace referencia a que este tipo de rechazo ya fue seleccionado
                                        El segundo hace referencia a la opcion de volver a marcar el rechazo previamente registrado, este campo se ubica ya que angular no dejo marcar el checkbox por la directiva NG-MODEL
                                        -->
                                        <input ng-show="objeto.checked" class="mdl-checkbox__input" id="chk" type="checkbox" name="chk_{{  objeto.id }}" checked="" disabled="">
                                        <input ng-show="objeto.checked" class="mdl-checkbox__input" id="chk" type="checkbox" name="chk_{{  objeto.id }}" ng-model="chk" ng-click="separarRechazo(chk, objeto.id)">
                                    </label>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-header">
                    <div class="col-lg-12 form-group">
                        <div class="input-group">
                            <span class="input-group-addon" ng-init="observaciones=''">Observaciones:</span>
                            <textarea class="form-control has-primary" name="observaciones" placeholder="Escribe algunas obervaciones de las causas del rechazo" ng-model="observaciones">{{ observaciones }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="alert alert-warning" ng-show="!chequeados">
                    <span class="text-muted">!Si esta inspeccion va ha ser rechazada se debe marcar por lo menos una causa¡</span>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-danger' id="btnCancelarSolicitud" data-dismiss='modal' ng-click="limpiarVariables();">Cancelar</button>
                    <a href="/#solicitudEnviada" data-toggle="modal">
                        <button ng-hide="!chequeados" type='button' class='btn btn-success {{ objeto.btnAprobar }}' id="btnAprobar" data-dismiss="modal"
                                ng-click="registrarRechazos(<?= $objeto->getNextId() ?>, observaciones, 10, <?=$llanta->getId()?>)"
                                >Registrar</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class='modal fade' id='_Dialog_DetallesProceso'>
        <div class='modal-dialog modal-lg'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' id="btnCerrarDialogFormularioLlanta_A" data-dismiss='modal'>&times;</button>
                    <h3 class="text text-primary">INFORMACION<br><small>(Llanta y OS)</small></h3>
                </div>
                <div class="modal-header">
                    <div class="text-justify">
                        <div class="col-sm-12 col-lg-12">
                            <div class="col-sm-12 col-lg-12">
                                <h3>OS: <?= $servicio->getOs() ?></h3>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Cliente:</label><span class="text text-muted"> <?= $servicio->getCliente()->getNombreEmpresa() ?></span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Vendedor:</label><span class="text text-muted"> <?= $servicio->getVendedor()->getPersona()->getNombresCompletos() ?></span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Estado:</label><span class="text text-muted"> <?= $servicio->getNombreEstado() ?></span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Observaciones:</label><span class="text text-muted"> <?= $servicio->getObservaciones() ?></span>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-12">
                            <div class="col-sm-12 col-lg-12">
                                <h3>Llanta</h3>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">RP:</label><span class="text text-muted"> <?= $llanta->getRp() ?></span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Serie:</label><span class="text text-muted"> <?= $llanta->getSerie() ?></span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Marca:</label><span class="text text-muted"> <?= $llanta->getMarca()->getNombre() ?></span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Gravado:</label><span class="text text-muted"> <?= $llanta->getGravado()->getNombre() ?></span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Dise&ntilde;o original:</label><span class="text text-muted"> <?= $llanta->getReferenciaOriginal()->getReferencia() ?></span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Dise&ntilde;o solicitado:</label><span class="text text-muted"> <?= $llanta->getReferenciaSolicitada()->getReferencia() ?></span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Aplicacion rencauche:</label><span class="text text-muted"> <?= $llanta->getAplicacionEntregada()->getReferenciaTipoLlanta()->getTipoLlanta()->getNombre() ?> / <?= $llanta->getAplicacionEntregada()->getMedidaCompleta() ?> (<?= $llanta->getAplicacionEntregada()->getReferenciaTipoLlanta()->getReferencia() ?>)</span>
                            </div>
                            <div class="col-sm-12 col-lg-3">
                                <label class="text-nowrap">Estado:</label><span class="text text-muted"> <?= $llanta->getNombreProcesado()?></span>
                            </div>
                            <div class="col-sm-12 col-lg-3">
                                <label class="text-nowrap">Urgente:</label><span class="text text-muted"> <?= $llanta->getNombreUrgente()?></span>
                            </div>
                            <div class="col-sm-12 col-lg-12">
                                <label class="text-nowrap">Observaciones:</label><span class="text text-muted"> <?= $objeto->getObservaciones() ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-danger' data-dismiss='modal'>Cerrar</button>
                </div>
            </div>
        </div>
        <!--TOOLTIPS-->
        <div class="mdl-tooltip" data-mdl-for="btnCerrarDialogFormularioLlanta_A">Cerrar</div>
        <!--FIN TOOLTIPS-->
        <!--------------------------------------------------------------------->
    </div>
</div>
<div id="toast-content" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button"></button>
</div>