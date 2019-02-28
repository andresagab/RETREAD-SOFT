<?php
session_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>PANAM</title>
        <meta name="viewport" content="width=decive-width,user-scalable=no,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0">
        <link rel="shortcut icon" href="../../design/pics/iconos/IconoPanam.ico">
        <link rel="stylesheet" href="../../lib/frameworks/mdl/material.min.css">
        <link rel="stylesheet" href="../../lib/frameworks/bootstrap-3.3.7-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../lib/frameworks/font-awesome-4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="../../design/estilos/tablesPrint.css">
        <script src="../../lib/frameworks/JQuery/jquery-3.2.1.min.js"></script>
        <script src="../../lib/frameworks/JQueryUi/jquery-ui-1.12.1/jquery-ui.min.js"></script>
        <script src="../../lib/frameworks/AngularJS/1.5.0/angular.min.js"></script>
        <script src="../../lib/frameworks/AngularJS/1.5.0/angular-route.min.js"></script>
        <script src="../../lib/frameworks/AngularJS/1.5.0/ngStorage.min.js"></script>
        <script src="../../lib/frameworks/mdl/material.min.js"></script>
        <script src="../../lib/frameworks/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
        <script src="../../lib/frameworks/AmChart/amcharts.js"></script>
        <script src="../../lib/frameworks/AmChart/serial.js"></script>
        <script src="../../lib/frameworks/AmChart/dark.js"></script>
        <script src="../../lib/scripts/ObjectsHTML.js"></script>
        <script src="../../lib/scripts/Toast.js"></script>
        <script src="../../lib/aplicaciones/panamApp.js"></script>
    </head>
    <body ng-app="navegacion" onafterprint="window.close();">
        <div class="" ng-controller="ticketImprimir">
            <div class="row col-md-12 text-center" id="paddinTop20" ng-show="page.spinnerCarga">
                <div class="mdl-spinner mdl-js-spinner is-active"></div>
            </div>
            <div class="col-lg-12">
                <center>
                    <table class="text-uppercase" border="1">
                        <tbody style="background-color: #87bde8">
                            <tr>
                                <th colspan="6" style="text-align: center;">Cliente: {{ page.data.object.nombreEmpresaCliente }}</th>
                                <th rowspan="5" style="padding-top: 2px; padding-bottom: 2px;">
                                    <img class="img-responsive" ng-src="../../design/pics/imagenes/PanamLogoEmpresa.png" width="250px" height="150px">
                                </th>
                            </tr>
                            <tr>
                                <th colspan="6" style="text-align: center;">Vendedor: {{ page.data.object.nombresvendedor }}</th>
                            </tr>
                            <tr>
                                <th>RP:</th>
                                <th>{{ page.data.object.rp }}</th>
                                <th>Dimension</th>
                                <th>{{ page.data.object.dimension }}</th>
                                <th>Diseño:</th>
                                <th>{{ page.data.object.referenciasolicitada }}</th>
                            </tr>
                            <tr>
                                <th style="text-align: right;">OS:</th>
                                <th>{{ page.data.object.os }}<span ng-if="page.data.object.consecutivo">-{{ page.data.object.consecutivo }}</span></th>
                                <th colspan="" style="text-align: right;">Serie:</th>
                                <th colspan="">{{ page.data.object.serie }}</th>
                                <th colspan="" style="text-align: right;">Marca:</th>
                                <th colspan="">{{ page.data.object.nombremarca }}</th>
                            </tr>
                            <tr>
                                <th colspan="6" style="padding-top: 5px; padding-bottom: 5px; text-align: center;">Fecha impresión: {{ page.data.fechaActual }}</th>
                            </tr>
                        </tbody>
                    </table>
                </center>
            </div>
        </div>
        <div id="toast-principal" class="mdl-js-snackbar mdl-snackbar">
          <div class="mdl-snackbar__text"></div>
          <button class="mdl-snackbar__action" type="button"></button>
        </div>
        <script src="../../lib/controladores/ticketImprimir.js"></script>
    </body>
</html>