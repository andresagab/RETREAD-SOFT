<?php
/*
 * Este archivo es un modal dialog que contiene la información correspondiente al rechazo de una llanta asociado a un
 * proceso de reencauche.
 *
 * Para ejecutar este archivo correctamente se requiere de los siguiente:
 *
 * Controlador AngularJS: rechazoLlanta.js
 *
 * */
?>
<div class='modal fade' id='_infoRechazos'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header'>
                <button type='button' class='close' data-dismiss='modal'>&times;</button>
                <h3 class="text text-primary">CAUSAS DEL RECHAZO</h3>
                <div class="mdl-spinner mdl-js-spinner is-active" ng-show="html.basicDialog.spinnerLoad"></div>
            </div>
            <div class='modal-header'>
                <div class="col-sm-12 col-lg-12 text-left" ng-show="html.basicDialog.data.register && html.basicDialog.data.observaciones!=''">
                    <h4>OBSERVACIONES GENERALES</h4>
                    <br>
                    <p class="text-uppercase">{{ html.basicDialog.data.observaciones }}</p>
                </div>
                <div class="col-sm-12 col-lg-12 text-left">
                    <h4>CAUSAS</h4>
                    <br>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left" ng-repeat="object in html.basicDialog.data.rechazos" ng-show="html.basicDialog.data.subRegisters">
                        <li>{{ object.nombre }}</li>
                    </div>
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
