<?php
/*
 * Este archivo es un modal dialog que contiene la información correspondiente a los insumos o productos usados en un
 * puesto de trabajo asociado a un proceso de reencauche.
 *
 * Para ejecutar este archivo correctamente se requiere de:
 *
 *-Controller AngularJS: informacionUsosPuestoTrabajo.js
 *
 */
?>
<div class='modal fade' id='_infoUsosPT'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header'>
                <button type='button' class='close' data-dismiss='modal'>&times;</button>
                <h3 class="text text-primary">{{ usosInsumos[0].puestoTrabajo }}</h3>
                <div class="mdl-spinner mdl-js-spinner is-active" ng-show="infoUsosPuestoTrabajo.components.loadSpinner"></div>
            </div>
            <div class='modal-header'>
                <div class="col-sm-12 col-lg-12 text-center">
                    <div class="col-sm-12 col-lg-12">
                        <h4 class="text-uppercase">Insumos o Herramientas usadas ({{ infoUsosPuestoTrabajo.data.objects.length }}):</h4>
                    </div>
                    <center>
                        <div class="col-sm-12 col-lg-12 table-responsive container" id="paddinTop10">
                            <table class="mdl-data-table mdl-js-data-table">
                                <thead>
                                <tr>
                                    <th ng-click="orden='insumo'">Insumo</th>
                                    <th ng-click="orden='cantidad'">Cantidad</th>
                                    <th ng-click="orden='nombreUsado'">Usado</th>
                                    <th ng-click="orden='nombreTerminado'">Terminado</th>
                                    <th ng-click="orden='empleadoUso'">Empleado (uso)</th>
                                    <th ng-click="orden='empleadoEnvio'">Empleado (envio)</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr ng-repeat="objeto in infoUsosPuestoTrabajo.data.objects | orderBy: orden" ng-show="infoUsosPuestoTrabajo.data.objects.length>0">
                                    <td class="mdl-data-table__cell--non-numeric">{{ objeto.insumo }}</td>
                                    <td>{{ objeto.cantidad }}</td>
                                    <td>{{ objeto.nombreUsado }} <span class="text-muted" ng-show="objeto.cantidadUsada!=null">({{ objeto.cantidadUsada }})</span></td>
                                    <td>{{ objeto.nombreTerminado }}</td>
                                    <td>{{ objeto.empleadoUso }}</td>
                                    <td>{{ objeto.empleadoEnvio }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </center>
                </div>
            </div>
            <div class='modal-footer'>
                <button type='button' class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--green-500 mdl-color-text--white' data-dismiss='modal'>Cerrar</button>
            </div>
        </div>
    </div>
    <div id="toast-content-dialogPT" class="mdl-js-snackbar mdl-snackbar">
        <div class="mdl-snackbar__text"></div>
        <button class="mdl-snackbar__action" type="button"></button>
    </div>
</div>
