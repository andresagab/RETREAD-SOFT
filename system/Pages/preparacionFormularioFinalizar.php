<?php
require_once dirname(__FILE__).'\..\Clases\Persona.php';
require_once dirname(__FILE__).'\..\Clases\Cargo_Empleado.php';
require_once dirname(__FILE__).'\..\Clases\Empleado.php';
require_once dirname(__FILE__).'\..\Clases\Cliente.php';
require_once dirname(__FILE__).'\..\Clases\Tipo_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Marca_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Servicio.php';
require_once dirname(__FILE__).'\..\Clases\Inspeccion_Inicial.php';
require_once dirname(__FILE__).'\..\Clases\Raspado.php';
require_once dirname(__FILE__).'\..\Clases\Preparacion.php';
if (isset($_GET['id'])) {
    $objeto=new Preparacion('id', $_GET['id'], null, null);
    $raspado=$objeto->getRaspado();
    $inspeccionInicial=$raspado->getInspeccion();
    $llanta=$inspeccionInicial->getLlanta();
    $servicio=$llanta->getServicio();
    $accion="Finalizar";
    $checked='checked';
}
?>
<script src="lib/controladores/rechazoLlanta.js"></script>
<div class="col-md-12" ng-controller="rechazoLlanta">
	<div class="col-md-4" ></div>
	<div class="col-md-4" >
            <strong class="text mdl-color-text--blue text-uppercase control-label"><h2><?=$accion?> preparacion</h2></strong>
	</div>
	<div class="col-md-4" ></div>
	<div class="row col-md-12 text-capitalize" id="paddinTop20">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <form class="form-horizontal" name="formulario" method="POST" action="principal.php?CON=system/Pages/preparacionActualizar.php">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Estado:</span>
                            <span class="input-group-addon">
                                <span id="paddingLeft70"></span>
                                <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="estado">
                                    <input type="checkbox" id="estado" class="mdl-switch__input" name="checked" <?=$checked?> ng-model="html.estado" ng-change="cargarNombreEstado(html.estado)">
                                </label>
                            </span>
                            <span class="input-group-addon"><label id="textoEstado">{{ cargarNombreEstado(html.estado) }}</label></span>
                        </div>
                    </div>
                    <div class="form-group center-block" id="divBtnSeleccionarRechazos" ng-show="!html.estado">
                        <button class="btn btn-success" id="btnSeleccionarRechazos" type="button" href="/#seleccionarRechazos" data-toggle="modal" ng-click="loadRechazosOfProceso(<?=$llanta->getId()?>, 2)">Seleccionar rechazos</button>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Observaciones:</span>
                            <textarea class="form-control has-primary input-sm" name="observaciones" placeholder="Observaciones para este proceso" maxlength="500"></textarea> 
                        </div>
                    </div>
                    <div class="hidden">
                        <div class="col-md-12"><input type="hidden" name="id" value="<?=$objeto->getId()?>"></div>
                    </div>
                    <div class="form-group" id="paddinTop20">
                        <a href="principal.php?CON=system/Pages/procesoServicio.php&id=<?=$llanta->getId()?>"><input class="btn btn-danger" type="button" name="Cancelar" value="Cancelar"></a>
                        <input class="btn btn-success" type="submit" name="accion" value="<?=$accion?>">
                    </div>
                </div>
                <div class="col-md-2"></div>
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
                                        <!--Si no existe la variable checked en el objeto JSON se presenta el input anterior en caso contrario se muesta los dos siguientes;
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
                                ng-click="registrarRechazos(<?= $objeto->getId() ?>, observaciones, 2, <?=$llanta->getId()?>)"
                                >Registrar</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="toast-content" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button"></button>
</div>
<script>
</script>