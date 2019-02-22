<?php
session_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>PANAM.sas</title>
        <meta name="viewport" content="width=decive-width,user-scalable=no,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0">
        <link rel="shortcut icon" href="../../../design/pics/iconos/IconoPanam.ico">
        <link rel="stylesheet" href="../../../lib/frameworks/mdl/material.min.css">
        <script src="../../../lib/frameworks/JQuery/jquery-3.2.1.min.js"></script>
        <script src="../../../lib/frameworks/JQueryUi/jquery-ui-1.12.1/jquery-ui.min.js"></script>
        <script src="../../../lib/frameworks/AngularJS/1.5.0/angular.min.js"></script>
        <script src="../../../lib/frameworks/AngularJS/1.5.0/angular-route.min.js"></script>
        <script src="../../../lib/frameworks/AngularJS/1.5.0/ngStorage.min.js"></script>
        <script src="../../../lib/frameworks/mdl/material.min.js"></script>
        <script src="../../../lib/aplicaciones/panamApp.js"></script>
        <script src="../../../lib/factorys/Exel.js"></script>
        <script src="../../../lib/controladores/informeBodegaExport.js"></script>
    </head>
    <body ng-app="navegacion" ng-controller="ExelController">
        <div class="col-md-12" ng-controller="informeBodegaExport">
            <div class="mdl-spinner mdl-js-spinner is-active" ng-hide="objetos"></div>
            <table class="mdl-data-table" id="dataTableContent" ng-show="objetos!=null">
                <thead>
                    <tr>
                        <th>Fecha de exportacion:</th>
                        <td colspan="2">{{ data.currentDate.getFullYear() }}/{{ data.currentDate.getMonth() + 1 }}/{{ data.currentDate.getDate() }}</td>
                        <td colspan="9"></td>
                    </tr>
                    <tr></tr>
                    <tr>
                        <th class="mdl-data-table__cell--non-numeric" ng-click="orden='servicio[0].os'">ORDEN</th>
                        <th ng-click="orden='rp'">RP</th>
                        <th ng-click="orden='clienteName'">CLIENTE</th>
                        <th ng-click="orden='nombreMarca'">MARCA</th>
                        <th ng-click="orden='dimension'">DIMENSION</th>
                        <th ng-click="orden='referenciaSolicitada[0].referencia'">DIS.SOLI</th>
                        <th ng-click="orden='medidas.anchobanda'">ANCHO</th>
                        <th ng-click="orden='pesoBanda'">PESO</th>
                        <th ng-click="orden='dataSalida[0].valor'">PRECIO</th>
                        <th ng-click="orden='nombreUrgente'">URGENTE</th>
                        <th ng-click="orden='nombreEstado'">ESTADO</th>
                        <th ng-click="orden='fechaRegistro'">FECHA REGISTRO</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="objeto in objetos | filter: buscar | orderBy: orden" style="background: {{ objeto.colorFila }}">
                        <td>{{ objeto.servicio[0].os }}-{{ objeto.consecutivo }}</td>
                        <td>{{ objeto.rp }}</td>
                        <td>{{ objeto.clienteName }}</td>
                        <td>{{ objeto.nombreMarca }}</td>
                        <td>{{ objeto.dimension }}</td>
                        <td>{{ objeto.referenciaSolicitada[0].referencia }}</td>
                        <td>
                            <span ng-show="objeto.medidas.status">{{ objeto.medidas.anchobanda }}</span>
                        </td>
                        <td>{{ objeto.pesoBanda }}</td>
                        <td>
                            <span ng-show="objeto.dataSalida[0].valor!=null">{{ objeto.dataSalida[0].valor }}</span>
                        </td>
                        <td>{{ objeto.nombreUrgente }}</td>
                        <td>{{ objeto.nombreEstado }}</td>
                        <td>{{ objeto.fechaRegistro }}</td>
                    </tr>
                    <tr>
                        <td colspan="8"></td>
                        <td>{{ total }}</td>
                        <td colspan="4"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>