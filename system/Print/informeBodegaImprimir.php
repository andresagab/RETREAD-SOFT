<?php
session_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>PANAM.sas</title>
        <meta name="viewport" content="width=decive-width,user-scalable=no,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0">
        <link rel="shortcut icon" href="../../design/pics/iconos/IconoPanam.ico">
        <link rel="stylesheet" href="../../lib/frameworks/mdl/material.min.css">
        <script src="../../lib/frameworks/JQuery/jquery-3.2.1.min.js"></script>
        <script src="../../lib/frameworks/JQueryUi/jquery-ui-1.12.1/jquery-ui.min.js"></script>
        <script src="../../lib/frameworks/AngularJS/1.5.0/angular.min.js"></script>
        <script src="../../lib/frameworks/AngularJS/1.5.0/angular-route.min.js"></script>
        <script src="../../lib/frameworks/AngularJS/1.5.0/ngStorage.min.js"></script>
        <script src="../../lib/frameworks/mdl/material.min.js"></script>
        <script src="../../lib/aplicaciones/panamApp.js"></script>
        <script src="../../lib/controladores/informeBodegaImprimir.js"></script>
    </head>
    <body ng-app="navegacion" onafterprint="window.close();">
    <div ng-repeat="">

    </div>
        <div class="col-md-12" ng-controller="informeBodegaImprimir">
            <div class="mdl-spinner mdl-js-spinner is-active" ng-hide="objetos"></div>
            <div class="col-lg-12">
                <center>
                    <table border="0">
                        <tr>
                            <td colspan="2">
                                <img src="../../design/pics/imagenes/PanamLogoEmpresa.png" width="400px" height="170px">
                            </td>
                            <td>
                                <div class="text-center" style="padding-left: 20px">
                                    <p style="margin-top: 10px"><label class="control-label">FABRICA:</label><span class="text text-muted"> Km 7 Via Panamericana Sur - Catambuco</span></p>
                                    <p style="margin-top: -20px"><label class="control-label">Cel:</label><span class="text text-muted"> 3206515737 - hectorortiz@reepacol.com</span></p>
                                    <p style="margin-top: -20px"><span class="text text-muted">PASTO - NARI&Ntilde;O</span></p>
                                </div>
                            </td>
                            <td>
                                <div style="padding-top: 10px; padding-left: 10px">
                                    <img src="../../design/pics/imagenes/Certificacion_Procesos.png" width="70px">
                                </div>
                            </td>
                            <td>
                                <div style="padding-top: 10px; padding-left: 10px">
                                    <img src="../../design/pics/imagenes/indelband-77890015.jpg" width="180px">
                                </div>
                            </td>
                        </tr>
                    </table>
                </center>
            </div>
            <div style="margin-top: -30px; margin-bottom: 10px">
                <center>
                    <h3>INFORME DE BODEGA</h3>
                </center>
            </div>
            <!--RESUMEN-->
            <div style="padding-bottom: 20px;">
                <center>
                    <table class="mdl-data-table" ng-show="objetos!=null">
                        <tr>
                            <th>Llantas filtradas</th>
                            <th>Llantas rencauchadas exitosamente</th>
                            <th>Llantas rechazadas</th>
                            <th>Llantas en reencauche</th>
                            <th>Llantas sin reencauchar</th>
                        </tr>
                        <tr>
                            <td>{{ objetos.length }}</td>
                            <td>{{ getTotalData(0) }}</td>
                            <td>{{ getTotalData(1) }}</td>
                            <td>{{ getTotalData(3) }}</td>
                            <td>{{ getTotalData(2) }}</td>
                        </tr>
                        <tr>
                            <th>N° ordenes de servicio</th>
                            <th>Llantas facturadas</th>
                            <th>Llantas sin facturar</th>
                            <th colspan="2">Total facutrado:</th>
                        </tr>
                        <tr>
                            <td>{{ countOS }}</td>
                            <td>{{ getTotalData(4) }}</td>
                            <td>{{ getTotalData(5) }}</td>
                            <td colspan="2">{{ total }}</td>
                        </tr>
                    </table>
                </center>
            </div>
            <!--END RESUMEN-->
            <table class="mdl-data-table" ng-show="objetos!=null">
                <thead>
                    <tr>
                        <th class="mdl-data-table__cell--non-numeric" ng-click="orden='servicio[0].os'">ORDEN</th>
                        <th ng-click="orden='rp'">RP</th>
                        <th ng-click="orden='serie'">SERIE</th>
                        <th ng-click="orden='gravado[0].nombre'">GRAVADO</th>
                        <th ng-click="orden='nombreMarca'">MARCA</th>
                        <th ng-click="orden='referenciaOriginal[0].referencia'">DIS.ORI</th>
                        <th ng-click="orden='dimension[0].medidaCompleta'">DIMENSION</th>
                        <th ng-click="orden='referenciaSolicitada[0].referencia'">DIS.SOLI</th>
                        <th ng-click="orden='medidas.anchobanda'">ANCHO</th>
                        <!--Esta linea fue remplazada por la linea de abajo el 2018-09-16 01:00<th ng-click="orden='aplicacionEntregada[0].medidaCompleta'">DISE&Ntilde;O FINAL</th>-->
                        <th ng-click="orden='dataSalida[0].valor'">PRECIO</th>
                        <th ng-click="orden='nombreUrgente'">URGENTE</th>
                        <th ng-click="orden='nombreEstado'">ESTADO</th>
                        <th ng-click="orden='fechaRegistro'">FECHA REGISTRO</th>
                    </tr>
                </thead>
                <tbody>
                    <!--<tr ng-repeat="objeto in objetos | filter: buscar | orderBy: orden" style="background: {{ objeto.colorFila }}">-->
                    <tr ng-repeat="objeto in objetos" style="background: {{ objeto.colorFila }}">
                        <td class="mdl-data-table__cell--non-numeric">{{ objeto.servicio[0].os }}-{{ objeto.consecutivo }}</td>
                        <td>{{ objeto.rp }}</td>
                        <td>{{ objeto.serie }}</td>
                        <td>{{ objeto.gravado[0].nombre }}</td>
                        <td>{{ objeto.nombreMarca }}</td>
                        <td>{{ objeto.referenciaOriginal[0].referencia }}</td>
                        <td>{{ objeto.dimension[0].medidaCompleta }}</td>
                        <td>{{ objeto.referenciaSolicitada[0].referencia }}</td>
                        <td>
                            <span ng-show="objeto.medidas.status">{{ objeto.medidas.anchobanda }}</span>
                            <span ng-show="!objeto.medidas.status">{{ objeto.medidas.nameEstado }}</span>
                        </td>
                        <!--Esta linea fue remplazada por la de abajo desde el 2018-09-16 01:03<td>{{ objeto.aplicacionEntregada[0].medidaCompleta }}</td>-->
                        <td>
                            <span ng-show="objeto.dataSalida[0].valor!=null">{{ objeto.dataSalida[0].valor }}</span>
                            <span ng-show="objeto.dataSalida[0].valor==null">Pendiente</span>
                        </td>
                        <td>{{ objeto.nombreUrgente }}</td>
                        <td>{{ objeto.nombreEstado }}</td>
                        <td>{{ objeto.fechaRegistro }}</td>
                    </tr>
                    <tr>
                        <td colspan="8"></td>
                        <td colspan="2">{{ total }}</td>
                        <td colspan="3"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>