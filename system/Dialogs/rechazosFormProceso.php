<?php
/*
 * Para hacer que este dialog funcione se debe declarar previamente los recursos necesarios:
 * ControladorAngularJS: rechazoLlanta.js
 * Variables PHP: $object, $llanta
 */
?>
<div class='modal fade' id='seleccionarRechazos'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header'>
                <button type='button' class='close' data-dismiss='modal' ng-click="limpiarVariables();">&times;</button>
                <h3 class="text text-primary text-uppercase mdl-color-text--blue">Rechazos</h3>
            </div>
            <div class="modal-header">
                <div class="row col-md-12" id="paddinTop20" ng-hide="objetos">
                    <center>
                        <div class="mdl-progress mdl-js-progress mdl-progress__indeterminate"></div>
                    </center>
                </div>
                <div class="col-lg-12 table-responsive" ng-show="objetos">
                    <center>
                        <table class="mdl-data-table">
                            <thead>
                            <tr>
                                <th class="mdl-data-table__cell--non-numeric" ng-click="order='nombre'">RECHAZO</th>
                                <th class="mdl-data-table__cell--non-numeric">ESTADO</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="objeto in objetos | orderBy: order">
                                <td class="mdl-data-table__cell--non-numeric">{{ objeto.nombre }}</td>
                                <td class="mdl-data-table__cell--non-numeric">
                                    <input ng-show="!objeto.checked" class="mdl-checkbox__input" id="chk_{{ objeto.id }}" type="checkbox" name="chk_{{  objeto.id }}" ng-model="chk" ng-click="separarRechazo(chk, objeto.id)">
                                    <input ng-show="objeto.checked" class="mdl-checkbox__input" id="chk" type="checkbox" name="chk_{{  objeto.id }}" checked="" disabled="">
                                    <input ng-show="objeto.checked" class="mdl-checkbox__input" id="chk" type="checkbox" name="chk_{{  objeto.id }}" ng-model="chk" ng-click="separarRechazo(chk, objeto.id)">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </center>
                </div>
            </div>
            <div class="modal-header">
                <div class="col-lg-12 form-group">
                    <div class="input-group">
                        <span class="input-group-addon" ng-init="observaciones=''">Observaciones:</span>
                        <textarea class="form-control has-primary" name="observaciones" placeholder="Escribe algunas observaciones de las causas del rechazo" ng-model="observaciones">{{ observaciones }}</textarea>
                    </div>
                </div>
            </div>
            <div class="alert alert-warning" ng-show="!chequeados">
                <span class="text-muted">!Si esta inspección va ha ser rechazada se debe marcar por lo menos una causa¡</span>
            </div>
            <div class='modal-footer'>
                <button type='button' class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--red-400 mdl-color-text--white' id="btnCancelarSolicitud" data-dismiss='modal' ng-click="limpiarVariables();">Cancelar</button>
                <a href="/#solicitudEnviada" data-toggle="modal">
                    <button ng-hide="!chequeados" type='button' class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--green-400 mdl-color-text--white {{ objeto.btnAprobar }}' id="btnAprobar" data-dismiss="modal" ng-click="registrarRechazos(<?= $object->getId(); ?> , observaciones, null, <?= $llanta->getId(); ?>)">Aprobar eliminacion</button>
                </a>
            </div>
        </div>
    </div>
</div>
