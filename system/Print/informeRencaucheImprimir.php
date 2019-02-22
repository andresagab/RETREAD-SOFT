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
        <link rel="stylesheet" href="../../lib/frameworks/bootstrap-3.3.7-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../lib/frameworks/font-awesome-4.7.0/css/font-awesome.min.css">
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
        <div class="" ng-controller="informeRencaucheImprimir">
            <div class="row col-md-12 text-center" id="paddinTop20" ng-show="html.spinnerCarga">
                <div class="mdl-spinner mdl-js-spinner is-active"></div>
            </div>
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
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top: -30px; margin-bottom: 10px">
                <strong class="text text-success control-label"><h2>INFORME DE RENCAUCHE</h2></strong>
            </div>
            <div class="" ng-show="html.bodyInforme">
        <!--    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">-->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                        <h3>Orden de servicio</h3>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><br></div>
                    <center>
                        <table class="mdl-data-table mdl-js-data-table" style="max-width: min-content;">
                            <thead>
                                <tr>
                                    <th>OS</th>
                                    <th>Estado</th>
                                    <th>Cliente</th>
                                    <th>Vendedor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ dataInforme.os }}</td>
                                    <td>{{ getEstadoOs(dataInforme.estadoServicio) }}</td>
                                    <td>{{ getNombreCliente() }} <em class="small">{{ dataInforme.identificacionCliente }}</em></td>
                                    <td>{{ dataInforme.nombresVendedor }} <em class="small">{{ dataInforme.identificacionVendedor }}</em></td>
                                </tr>
                            </tbody>
                        </table>
                    </center>
                    <div class="hide">
                        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 text-left">
                            <span class="text-nowrap">OS: </span><span class="text-muted">{{ dataInforme.os }}</span>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 text-left">
                            <span class="text-nowrap">Estado: </span><span class="text-muted">{{ getEstadoOs(dataInforme.estadoServicio); }}</span>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-4 text-left">
                            <span class="text-nowrap">Cliente: </span><span class="text-muted">{{ getNombreCliente(); }} </span><em class="small">{{ dataInforme.identificacionCliente }}</em>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-4 text-left">
                            <span class="text-nowrap">Vendedor: </span><span class="text-muted">{{ dataInforme.nombresVendedor }} </span><em class="small">{{ dataInforme.identificacionVendedor }}</em>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                        <h3>Garantias</h3>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><br></div>
                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 text-left" ng-repeat="object in dataInforme.detalleOS.tiposServicio">
                        <span class="text-muted">{{ object.nombre }}</span>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-left" ng-show="!dataInforme.detalleOS.status">
                        <span class="text-muted text-lowercase text-nowrap">Esta orden de servicio no cuenta con garant&iacute;as registradas.</span>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive page-header" style="margin-top: 2px; margin-bottom: 2px; padding-bottom: 15px">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                        <h3>Llanta</h3>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><br></div>
                    <center>
                        <table class="mdl-data-table mdl-js-data-table" style="max-width: min-content;">
                            <thead>
                                <tr>
                                    <th>RP</th>
                                    <th>Serie</th>
                                    <th>Urgente</th>
                                    <th>Marca</th>
                                    <th>Gravado</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ dataInforme.rp }}</td>
                                    <td>{{ dataInforme.serie }}</td>
                                    <td>{{ getUrgenteLlanta() }}</td>
                                    <td>{{ dataInforme.nombreMarca }}</td>
                                    <td>{{ dataInforme.nombreGravado }}</td>
                                    <td>{{ dataInforme.nombreEstado }}</td>
                                </tr>
                                <tr>
                                    <th colspan="1">Dise&ntilde;o original</th>
                                    <th colspan="1">Dimension</th>
                                    <th colspan="1">Dise&ntilde;o solicitado</th>
                                    <th colspan="3">Dise&ntilde;o entregado</th>
                                </tr>
                                <tr>
                                    <td colspan="1">{{ dataInforme.disenoOriginal[0].referencia }}</td>
                                    <td colspan="1">{{ dataInforme.dimension[0].dimension }}</td>
                                    <td colspan="1">{{ dataInforme.disenoSolicitado[0].referencia }}</td>
                                    <td colspan="3">{{ getMedidaAplicacionEntregada() }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </center>
                    <div class="hide">
                        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 text-left">
                            <span class="text-nowrap">RP: </span><span class="text-muted">{{ dataInforme.rp }}</span>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 text-left">
                            <span class="text-nowrap">Serie: </span><span class="text-muted">{{ dataInforme.serie }}</span>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 text-left">
                            <span class="text-nowrap">Urgente: </span><span class="text-muted">{{ getUrgenteLlanta(); }}</span>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 text-left">
                            <span class="text-nowrap">Marca: </span><span class="text-muted">{{ dataInforme.nombreMarca }} </span>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 text-left">
                            <span class="text-nowrap">Gravado: </span><span class="text-muted">{{ dataInforme.nombreGravado }} </span>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 text-left">
                            <span class="text-nowrap">Estado: </span><span class="text-muted">{{ dataInforme.nombreEstado }} </span>
                        </div>
                        <div class="col-xs-12.hide col-sm-12.hide col-md-12 col-lg-12" style="margin-top: 5px"></div>
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-left">
                            <span class="text-nowrap">Aplicacion original: </span><span class="text-muted">{{ dataInforme.medidasAplicacionOriginal }} </span>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-left">
                            <span class="text-nowrap">Aplicacion solicitada: </span><span class="text-muted">{{ dataInforme.medidasAplicacionSolicitada }} </span>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-left">
                            <span class="text-nowrap">Aplicacion entregada: </span><span class="text-muted">{{ getMedidaAplicacionEntregada() }} </span>
                        </div>
                    </div>
                    <div ng-show="dataInforme.valorEstado==3">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><br></div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                            <h3>Causas del rechazo</h3>
                            <br>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 text-left" ng-repeat="objeto in dataInforme.rechazos" ng-show="dataInforme!=null && dataInforme.rechazos!=null" ng-show="dataInforme.valorEstado==3">
                            <li>{{ objeto.rechazo[0].nombre }}</li>
                        </div>
                        <div style="padding-top: 15px;" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left" ng-show="dataInforme!=null && dataInforme.valorEstado==3 && dataInforme.rechazos!=null && dataInforme.rechazos[0].rechazoLlanta.observaciones!=null">
                            <h4>Observaciones adicionales</h4>
                            <br>
                            <p class="text-uppercase">{{ dataInforme.rechazos[0].rechazoLlanta.observaciones }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive page-header" style="margin-top: 2px; margin-bottom: 2px; padding-bottom: 15px" ng-show="dataInforme!=null && dataInforme.valorEstado==0">
                    <div class="table-responsive">
                        <div class="alert alert-info">SE MOSTRARA EL INFORME CUANDO LA LLANTA INICIE EL PROCESO DE RENCAUCHE</div>
                    </div>
                </div>
                <!--Procesos-->
                <!--INSPECCION INICIAL-->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive page-header" style="margin-top: 2px; margin-bottom: 2px; padding-bottom: 15px" ng-show="inspeccionInicial!=null && html.chkInformeTextual || inspeccionInicial!=null && html.chkInformeRegistrosFotograficos">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left" ng-show="html.chkInformeTextual">
                        <h3>Inspeccion inicial</h3>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-show="html.chkInformeTextual"><br></div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" ng-show="html.chkInformeTextual">
                        <center>
                            <table class="mdl-data-table mdl-js-data-table">
                                <thead>
                                    <tr>
                                        <th>N° rencauche</th>
                                        <th>Operario</th>
                                        <th>Estado</th>
                                        <th>Revision</th>
                                        <th>Fecha/Hora</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ inspeccionInicial.numeroRencauche }}</td>
                                        <td>{{ inspeccionInicial.empleado[0].nombresCompletosPersona }}</td>
                                        <td>{{ inspeccionInicial.nombreChecked }}</td>
                                        <td>{{ inspeccionInicial.nombreEstado }}</td>
                                        <td>{{ inspeccionInicial.fechaRegistro }}</td>
                                    </tr>
                                    <tr>
                                        <th>Observaciones</th>
                                        <td colspan="4">
                                            {{ inspeccionInicial.observaciones }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </center>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-show="html.chkInformeRegistrosFotograficos"><br></div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" ng-show="html.chkInformeRegistrosFotograficos">
                        <div class="thumbnail">
                            <img class="img-responsive" ng-src="../Uploads/Imgs/Inspeccion_Inicial/{{ inspeccionInicial.foto }}">
                            <div class="caption table-responsive" ng-hide="html.chkInformeTextual && html.chkInformeRegistrosFotograficos">
                                <h3>Inspeccion inicial</h3>
                                <center>
                                    <table class="mdl-data-table mdl-js-data-table">
                                        <thead>
                                            <tr>
                                                <th>N° rencauche</th>
                                                <th>Operario</th>
                                                <th>Estado</th>
                                                <th>Revision</th>
                                                <th>Fecha/Hora</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ inspeccionInicial.numeroRencauche }}</td>
                                                <td>{{ inspeccionInicial.empleado[0].nombresCompletosPersona }}</td>
                                                <td>{{ inspeccionInicial.nombreChecked }}</td>
                                                <td>{{ inspeccionInicial.nombreEstado }}</td>
                                                <td>{{ inspeccionInicial.fechaRegistro }}</td>
                                            </tr>
                                            <tr>
                                                <th>Observaciones</th>
                                                <td colspan="4">
                                                    {{ inspeccionInicial.observaciones }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </center>
                                <br>
                                <footer class="pull-right">Fecha/Hora: <cite>{{ inspeccionInicial.fechaRegistro }}</cite></footer>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
                <!--FIN INSPECCION INICIAL-->
                <!--------------------------------------------------------------------->
                <!--RASPADO-->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive page-header" style="margin-top: 2px; margin-bottom: 2px; padding-bottom: 15px" ng-show="raspado!=null && html.chkInformeTextual || raspado!=null && html.chkInformeRegistrosFotograficos">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left" ng-show="html.chkInformeTextual">
                        <h3>Raspado</h3>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-show="html.chkInformeTextual"><br></div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" ng-show="html.chkInformeTextual">
                        <center>
                            <table class="mdl-data-table mdl-js-data-table">
                                <thead>
                                    <tr>
                                        <th>Operario</th>
                                        <th>Ancho banda</th>
                                        <th>Largo banda</th>
                                        <th>Cinturon</th>
                                        <th>Cant.cinturon</th>
                                        <th>Profundidad</th>
                                        <th>Radio</th>
                                        <th>Estado</th>
                                        <th>Revision</th>
                                        <th>Fecha/Hora</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ raspado.empleado[0].nombresCompletosPersona }}</td>
                                        <td>{{ raspado.anchoBanda }}</td>
                                        <td>{{ raspado.largoBanda }}</td>
                                        <td>{{ raspado.nombreCinturon }}</td>
                                        <td>{{ raspado.cinturonCantidad }}</td>
                                        <td>{{ raspado.profundidad }}</td>
                                        <td>{{ raspado.radio }}</td>
                                        <td>{{ raspado.nombreChecked }}</td>
                                        <td>{{ raspado.nombreEstado }}</td>
                                        <td>{{ raspado.fechaRegistro }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">Observaciones</td>
                                        <td colspan="5">{{ raspado.observaciones }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="10">Usos de insumos <span class="text-muted" ng-bind="'(' + raspado.usosInsumos.total + ')' "></span></td>
                                    </tr>
                                    <tr>
                                        <th colspan="3" ng-click="orden='insumo'">Insumo</th>
                                        <th ng-click="orden='cantidad'">Cantidad</th>
                                        <th ng-click="orden='nombreUsado'">Usado</th>
                                        <th ng-click="orden='nombreTerminado'">Terminado</th>
                                        <th colspan="2" ng-click="orden='empleadoUso'">Empleado (uso)</th>
                                        <th colspan="2" ng-click="orden='empleadoEnvio'">Empleado (envio)</th>
                                    </tr>
                                    <tr ng-repeat="objeto in raspado.usosInsumos.datos | orderBy: orden" ng-show="raspado.usosInsumos.datos!=null">
                                        <td colspan="3" class="mdl-data-table__cell--non-numeric">{{ objeto.insumo }}</td>
                                        <td>{{ objeto.cantidad }}</td>
                                        <td>{{ objeto.nombreUsado }}</td>
                                        <td>{{ objeto.nombreTerminado }}</td>
                                        <td colspan="2">{{ objeto.empleadoUso }}</td>
                                        <td colspan="2">{{ objeto.empleadoEnvio }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </center>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-show="html.chkInformeRegistrosFotograficos"><br></div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" ng-show="html.chkInformeRegistrosFotograficos">
                        <div class="thumbnail">
                            <img class="img-responsive" ng-src="../Uploads/Imgs/Raspado/{{ raspado.foto }}">
                            <div class="caption table-responsive" ng-hide="html.chkInformeTextual && html.chkInformeRegistrosFotograficos">
                                <h3>Raspado</h3>
                                <center>
                                    <table class="mdl-data-table mdl-js-data-table">
                                        <thead>
                                            <tr>
                                                <th>Operario</th>
                                                <th>Ancho banda</th>
                                                <th>Largo banda</th>
                                                <th>Cinturon</th>
                                                <th>Cant.cinturon</th>
                                                <th>Profundidad</th>
                                                <th>Radio</th>
                                                <th>Estado</th>
                                                <th>Revision</th>
                                                <th>Fecha/Hora</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ raspado.empleado[0].nombresCompletosPersona }}</td>
                                                <td>{{ raspado.anchoBanda }}</td>
                                                <td>{{ raspado.largoBanda }}</td>
                                                <td>{{ raspado.nombreCinturon }}</td>
                                                <td>{{ raspado.cinturonCantidad }}</td>
                                                <td>{{ raspado.profundidad }}</td>
                                                <td>{{ raspado.radio }}</td>
                                                <td>{{ raspado.nombreChecked }}</td>
                                                <td>{{ raspado.nombreEstado }}</td>
                                                <td>{{ raspado.fechaRegistro }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="5">Observaciones</td>
                                                <td colspan="5">{{ raspado.observaciones }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="10">Usos de insumos <span class="text-muted" ng-bind="'(' + raspado.usosInsumos.total + ')' "></span></td>
                                            </tr>
                                            <tr>
                                                <th colspan="3" ng-click="orden='insumo'">Insumo</th>
                                                <th ng-click="orden='cantidad'">Cantidad</th>
                                                <th ng-click="orden='nombreUsado'">Usado</th>
                                                <th ng-click="orden='nombreTerminado'">Terminado</th>
                                                <th colspan="2" ng-click="orden='empleadoUso'">Empleado (uso)</th>
                                                <th colspan="2" ng-click="orden='empleadoEnvio'">Empleado (envio)</th>
                                            </tr>
                                            <tr ng-repeat="objeto in raspado.usosInsumos.datos | orderBy: orden" ng-show="raspado.usosInsumos.datos!=null">
                                                <td colspan="3" class="mdl-data-table__cell--non-numeric">{{ objeto.insumo }}</td>
                                                <td>{{ objeto.cantidad }}</td>
                                                <td>{{ objeto.nombreUsado }}</td>
                                                <td>{{ objeto.nombreTerminado }}</td>
                                                <td colspan="2">{{ objeto.empleadoUso }}</td>
                                                <td colspan="2">{{ objeto.empleadoEnvio }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </center>
                                <br>
                                <footer class="pull-right">Fecha/Hora: <cite>{{ raspado.fechaRegistro }}</cite></footer>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
                <!--FIN RASPADO-->
                <!--------------------------------------------------------------------->
                <!--------------------------------------------------------------------->
                <!--PREPARACION-->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive page-header" style="margin-top: 2px; margin-bottom: 2px; padding-bottom: 15px" ng-show="preparacion!=null && html.chkInformeTextual || preparacion!=null && html.chkInformeRegistrosFotograficos">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left" ng-show="html.chkInformeTextual">
                        <h3>Preparacion</h3>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-show="html.chkInformeTextual"><br></div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" ng-show="html.chkInformeTextual">
                        <center>
                            <table class="mdl-data-table mdl-js-data-table">
                                <thead>
                                    <tr>
                                        <th colspan="3">Operario</th>
                                        <th colspan="2">Estado</th>
                                        <th colspan="2">Revision</th>
                                        <th colspan="3">Fecha/Hora</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="3">{{ preparacion.empleado[0].nombresCompletosPersona }}</td>
                                        <td colspan="2">{{ preparacion.nombreChecked }}</td>
                                        <td colspan="2">{{ preparacion.nombreEstado }}</td>
                                        <td colspan="3">{{ preparacion.fechaRegistro }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">Observaciones</td>
                                        <td colspan="5">{{ preparacion.observaciones }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="10">Usos de insumos <span class="text-muted" ng-bind="'(' + preparacion.usosInsumos.total + ')' "></span></td>
                                    </tr>
                                    <tr>
                                        <th colspan="3" ng-click="orden='insumo'">Insumo</th>
                                        <th ng-click="orden='cantidad'">Cantidad</th>
                                        <th ng-click="orden='nombreUsado'">Usado</th>
                                        <th ng-click="orden='nombreTerminado'">Terminado</th>
                                        <th colspan="2" ng-click="orden='empleadoUso'">Empleado (uso)</th>
                                        <th colspan="2" ng-click="orden='empleadoEnvio'">Empleado (envio)</th>
                                    </tr>
                                    <tr ng-repeat="objeto in preparacion.usosInsumos.datos | orderBy: orden" ng-show="preparacion.usosInsumos.datos!=null">
                                        <td colspan="3" class="mdl-data-table__cell--non-numeric">{{ objeto.insumo }}</td>
                                        <td>{{ objeto.cantidad }}</td>
                                        <td>{{ objeto.nombreUsado }}</td>
                                        <td>{{ objeto.nombreTerminado }}</td>
                                        <td colspan="2">{{ objeto.empleadoUso }}</td>
                                        <td colspan="2">{{ objeto.empleadoEnvio }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </center>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-show="html.chkInformeRegistrosFotograficos"><br></div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" ng-show="html.chkInformeRegistrosFotograficos">
                        <div class="thumbnail">
                            <img class="img-responsive" ng-src="../Uploads/Imgs/Preparacion/{{ preparacion.foto }}">
                            <div class="caption table-responsive" ng-hide="html.chkInformeTextual && html.chkInformeRegistrosFotograficos">
                                <h3>Preparacion</h3>
                                <center>
                                    <table class="mdl-data-table mdl-js-data-table">
                                        <thead>
                                            <tr>
                                                <th colspan="3">Operario</th>
                                                <th colspan="2">Estado</th>
                                                <th colspan="2">Revision</th>
                                                <th colspan="3">Fecha/Hora</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="3">{{ preparacion.empleado[0].nombresCompletosPersona }}</td>
                                                <td colspan="2">{{ preparacion.nombreChecked }}</td>
                                                <td colspan="2">{{ preparacion.nombreEstado }}</td>
                                                <td colspan="3">{{ preparacion.fechaRegistro }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="5">Observaciones</td>
                                                <td colspan="5">{{ preparacion.observaciones }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="10">Usos de insumos <span class="text-muted" ng-bind="'(' + preparacion.usosInsumos.total + ')' "></span></td>
                                            </tr>
                                            <tr>
                                                <th colspan="3" ng-click="orden='insumo'">Insumo</th>
                                                <th ng-click="orden='cantidad'">Cantidad</th>
                                                <th ng-click="orden='nombreUsado'">Usado</th>
                                                <th ng-click="orden='nombreTerminado'">Terminado</th>
                                                <th colspan="2" ng-click="orden='empleadoUso'">Empleado (uso)</th>
                                                <th colspan="2" ng-click="orden='empleadoEnvio'">Empleado (envio)</th>
                                            </tr>
                                            <tr ng-repeat="objeto in preparacion.usosInsumos.datos | orderBy: orden" ng-show="preparacion.usosInsumos.datos!=null">
                                                <td colspan="3" class="mdl-data-table__cell--non-numeric">{{ objeto.insumo }}</td>
                                                <td>{{ objeto.cantidad }}</td>
                                                <td>{{ objeto.nombreUsado }}</td>
                                                <td>{{ objeto.nombreTerminado }}</td>
                                                <td colspan="2">{{ objeto.empleadoUso }}</td>
                                                <td colspan="2">{{ objeto.empleadoEnvio }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </center>
                                <br>
                                <footer class="pull-right">Fecha/Hora: <cite>{{ preparacion.fechaRegistro }}</cite></footer>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
                <!--FIN PREPARACION-->
                <!--------------------------------------------------------------------->
                <!--------------------------------------------------------------------->
                <!--REPARACION-->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive page-header" style="margin-top: 2px; margin-bottom: 2px; padding-bottom: 15px" ng-show="reparacion!=null && html.chkInformeTextual || reparacion!=null && html.chkInformeRegistrosFotograficos">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left" ng-show="html.chkInformeTextual">
                        <h3>Reparacion</h3>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-show="html.chkInformeTextual"><br></div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" ng-show="html.chkInformeTextual">
                        <center>
                            <table class="mdl-data-table mdl-js-data-table">
                                <thead>
                                    <tr>
                                        <th colspan="3">Operario</th>
                                        <th colspan="2">Estado</th>
                                        <th colspan="2">Revision</th>
                                        <th colspan="3">Fecha/Hora</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="3">{{ reparacion.empleado[0].nombresCompletosPersona }}</td>
                                        <td colspan="2">{{ reparacion.nombreChecked }}</td>
                                        <td colspan="2">{{ reparacion.nombreEstado }}</td>
                                        <td colspan="3">{{ reparacion.fechaRegistro }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">Observaciones</td>
                                        <td colspan="5">{{ reparacion.observaciones }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="10">Usos de insumos <span class="text-muted" ng-bind="'(' + reparacion.usosInsumos.total + ')' "></span></td>
                                    </tr>
                                    <tr>
                                        <th colspan="3" ng-click="orden='insumo'">Insumo</th>
                                        <th ng-click="orden='cantidad'">Cantidad</th>
                                        <th ng-click="orden='nombreUsado'">Usado</th>
                                        <th ng-click="orden='nombreTerminado'">Terminado</th>
                                        <th colspan="2" ng-click="orden='empleadoUso'">Empleado (uso)</th>
                                        <th colspan="2" ng-click="orden='empleadoEnvio'">Empleado (envio)</th>
                                    </tr>
                                    <tr ng-repeat="objeto in reparacion.usosInsumos.datos | orderBy: orden" ng-show="reparacion.usosInsumos.datos!=null">
                                        <td colspan="3" class="mdl-data-table__cell--non-numeric">{{ objeto.insumo }}</td>
                                        <td>{{ objeto.cantidad }}</td>
                                        <td>{{ objeto.nombreUsado }} <span class="text-muted" ng-show="objeto.cantidadUsada!=null">({{ objeto.cantidadUsada }})</span></td>
                                        <td>{{ objeto.nombreTerminado }}</td>
                                        <td colspan="2">{{ objeto.empleadoUso }}</td>
                                        <td colspan="2">{{ objeto.empleadoEnvio }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </center>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-show="html.chkInformeRegistrosFotograficos"><br></div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" ng-show="html.chkInformeRegistrosFotograficos">
                        <div class="thumbnail">
                            <img class="img-responsive" ng-src="../Uploads/Imgs/Reparacion/{{ reparacion.foto }}">
                            <div class="caption table-responsive" ng-hide="html.chkInformeTextual && html.chkInformeRegistrosFotograficos">
                                <h3>Reparacion</h3>
                                <center>
                                    <table class="mdl-data-table mdl-js-data-table">
                                        <thead>
                                            <tr>
                                                <th colspan="3">Operario</th>
                                                <th colspan="2">Estado</th>
                                                <th colspan="2">Revision</th>
                                                <th colspan="3">Fecha/Hora</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="3">{{ reparacion.empleado[0].nombresCompletosPersona }}</td>
                                                <td colspan="2">{{ reparacion.nombreChecked }}</td>
                                                <td colspan="2">{{ reparacion.nombreEstado }}</td>
                                                <td colspan="3">{{ reparacion.fechaRegistro }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="5">Observaciones</td>
                                                <td colspan="5">{{ reparacion.observaciones }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="10">Usos de insumos <span class="text-muted" ng-bind="'(' + reparacion.usosInsumos.total + ')' "></span></td>
                                            </tr>
                                            <tr>
                                                <th colspan="3" ng-click="orden='insumo'">Insumo</th>
                                                <th ng-click="orden='cantidad'">Cantidad</th>
                                                <th ng-click="orden='nombreUsado'">Usado</th>
                                                <th ng-click="orden='nombreTerminado'">Terminado</th>
                                                <th colspan="2" ng-click="orden='empleadoUso'">Empleado (uso)</th>
                                                <th colspan="2" ng-click="orden='empleadoEnvio'">Empleado (envio)</th>
                                            </tr>
                                            <tr ng-repeat="objeto in reparacion.usosInsumos.datos | orderBy: orden" ng-show="reparacion.usosInsumos.datos!=null">
                                                <td colspan="3" class="mdl-data-table__cell--non-numeric">{{ objeto.insumo }}</td>
                                                <td>{{ objeto.cantidad }}</td>
                                                <td>{{ objeto.nombreUsado }} <span class="text-muted" ng-show="objeto.cantidadUsada!=null">({{ objeto.cantidadUsada }})</span></td>
                                                <td>{{ objeto.nombreTerminado }}</td>
                                                <td colspan="2">{{ objeto.empleadoUso }}</td>
                                                <td colspan="2">{{ objeto.empleadoEnvio }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </center>
                                <br>
                                <footer class="pull-right">Fecha/Hora: <cite>{{ reparacion.fechaRegistro }}</cite></footer>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
                <!--FIN REPARACION-->
                <!--------------------------------------------------------------------->
                <!--------------------------------------------------------------------->
                <!--CEMENTADO-->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive page-header" style="margin-top: 2px; margin-bottom: 2px; padding-bottom: 15px"  ng-show="cementado!=null && html.chkInformeTextual || cementado!=null && html.chkInformeRegistrosFotograficos">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left" ng-show="html.chkInformeTextual">
                        <h3>Cementado</h3>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-show="html.chkInformeTextual"><br></div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" ng-show="html.chkInformeTextual">
                        <center>
                            <table class="mdl-data-table mdl-js-data-table">
                                <thead>
                                    <tr>
                                        <th colspan="3">Operario</th>
                                        <th colspan="2">Estado</th>
                                        <th colspan="2">Revision</th>
                                        <th colspan="3">Fecha/Hora</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="3">{{ cementado.empleado[0].nombresCompletosPersona }}</td>
                                        <td colspan="2">{{ cementado.nombreChecked }}</td>
                                        <td colspan="2">{{ cementado.nombreEstado }}</td>
                                        <td colspan="3">{{ cementado.fechaRegistro }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">Observaciones</td>
                                        <td colspan="5">{{ cementado.observaciones }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="10">Usos de insumos <span class="text-muted" ng-bind="'(' + cementado.usosInsumos.total + ')' "></span></td>
                                    </tr>
                                    <tr>
                                        <th colspan="3" ng-click="orden='insumo'">Insumo</th>
                                        <th ng-click="orden='cantidad'">Cantidad</th>
                                        <th ng-click="orden='nombreUsado'">Usado</th>
                                        <th ng-click="orden='nombreTerminado'">Terminado</th>
                                        <th colspan="2" ng-click="orden='empleadoUso'">Empleado (uso)</th>
                                        <th colspan="2" ng-click="orden='empleadoEnvio'">Empleado (envio)</th>
                                    </tr>
                                    <tr ng-repeat="objeto in cementado.usosInsumos.datos | orderBy: orden" ng-show="cementado.usosInsumos.datos!=null">
                                        <td colspan="3" class="mdl-data-table__cell--non-numeric">{{ objeto.insumo }}</td>
                                        <td>{{ objeto.cantidad }}</td>
                                        <td>{{ objeto.nombreUsado }}</td>
                                        <td>{{ objeto.nombreTerminado }}</td>
                                        <td colspan="2">{{ objeto.empleadoUso }}</td>
                                        <td colspan="2">{{ objeto.empleadoEnvio }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </center>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-show="html.chkInformeRegistrosFotograficos"><br></div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" ng-show="html.chkInformeRegistrosFotograficos">
                        <div class="thumbnail">
                            <img class="img-responsive" ng-src="../Uploads/Imgs/Cementado/{{ cementado.foto }}">
                            <div class="caption table-responsive" ng-hide="html.chkInformeTextual && html.chkInformeRegistrosFotograficos">
                                <h3>Cementado</h3>
                                <center>
                                    <table class="mdl-data-table mdl-js-data-table">
                                        <thead>
                                            <tr>
                                                <th colspan="3">Operario</th>
                                                <th colspan="2">Estado</th>
                                                <th colspan="2">Revision</th>
                                                <th colspan="3">Fecha/Hora</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="3">{{ cementado.empleado[0].nombresCompletosPersona }}</td>
                                                <td colspan="2">{{ cementado.nombreChecked }}</td>
                                                <td colspan="2">{{ cementado.nombreEstado }}</td>
                                                <td colspan="3">{{ cementado.fechaRegistro }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="5">Observaciones</td>
                                                <td colspan="5">{{ cementado.observaciones }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="10">Usos de insumos <span class="text-muted" ng-bind="'(' + cementado.usosInsumos.total + ')' "></span></td>
                                            </tr>
                                            <tr>
                                                <th colspan="3" ng-click="orden='insumo'">Insumo</th>
                                                <th ng-click="orden='cantidad'">Cantidad</th>
                                                <th ng-click="orden='nombreUsado'">Usado</th>
                                                <th ng-click="orden='nombreTerminado'">Terminado</th>
                                                <th colspan="2" ng-click="orden='empleadoUso'">Empleado (uso)</th>
                                                <th colspan="2" ng-click="orden='empleadoEnvio'">Empleado (envio)</th>
                                            </tr>
                                            <tr ng-repeat="objeto in cementado.usosInsumos.datos | orderBy: orden" ng-show="cementado.usosInsumos.datos!=null">
                                                <td colspan="3" class="mdl-data-table__cell--non-numeric">{{ objeto.insumo }}</td>
                                                <td>{{ objeto.cantidad }}</td>
                                                <td>{{ objeto.nombreUsado }}</td>
                                                <td>{{ objeto.nombreTerminado }}</td>
                                                <td colspan="2">{{ objeto.empleadoUso }}</td>
                                                <td colspan="2">{{ objeto.empleadoEnvio }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </center>
                                <br>
                                <footer class="pull-right">Fecha/Hora: <cite>{{ cementado.fechaRegistro }}</cite></footer>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
                <!--FIN CEMENTADO-->
                <!--------------------------------------------------------------------->
                <!--------------------------------------------------------------------->
                <!--RELLENO-->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive page-header" style="margin-top: 2px; margin-bottom: 2px; padding-bottom: 15px" ng-show="relleno!=null && html.chkInformeTextual || relleno!=null && html.chkInformeRegistrosFotograficos">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left" ng-show="html.chkInformeTextual">
                        <h3>Relleno</h3>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-show="html.chkInformeTextual"><br></div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" ng-show="html.chkInformeTextual">
                        <center>
                            <table class="mdl-data-table mdl-js-data-table">
                                <thead>
                                    <tr>
                                        <th colspan="3">Operario</th>
                                        <th colspan="2">Estado</th>
                                        <th colspan="2">Revision</th>
                                        <th colspan="3">Fecha/Hora</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="3">{{ relleno.empleado[0].nombresCompletosPersona }}</td>
                                        <td colspan="2">{{ relleno.nombreChecked }}</td>
                                        <td colspan="2">{{ relleno.nombreEstado }}</td>
                                        <td colspan="3">{{ relleno.fechaRegistro }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">Observaciones</td>
                                        <td colspan="5">{{ relleno.observaciones }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="10">Usos de insumos <span class="text-muted" ng-bind="'(' + relleno.usosInsumos.total + ')' "></span></td>
                                    </tr>
                                    <tr>
                                        <th colspan="3" ng-click="orden='insumo'">Insumo</th>
                                        <th ng-click="orden='cantidad'">Cantidad</th>
                                        <th ng-click="orden='nombreUsado'">Usado</th>
                                        <th ng-click="orden='nombreTerminado'">Terminado</th>
                                        <th colspan="2" ng-click="orden='empleadoUso'">Empleado (uso)</th>
                                        <th colspan="2" ng-click="orden='empleadoEnvio'">Empleado (envio)</th>
                                    </tr>
                                    <tr ng-repeat="objeto in relleno.usosInsumos.datos | orderBy: orden" ng-show="relleno.usosInsumos.datos!=null">
                                        <td colspan="3" class="mdl-data-table__cell--non-numeric">{{ objeto.insumo }}</td>
                                        <td>{{ objeto.cantidad }}</td>
                                        <td>{{ objeto.nombreUsado }}</td>
                                        <td>{{ objeto.nombreTerminado }}</td>
                                        <td colspan="2">{{ objeto.empleadoUso }}</td>
                                        <td colspan="2">{{ objeto.empleadoEnvio }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </center>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-show="html.chkInformeRegistrosFotograficos"><br></div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" ng-show="html.chkInformeRegistrosFotograficos">
                        <div class="thumbnail">
                            <img class="img-responsive" ng-src="../Uploads/Imgs/Relleno/{{ relleno.foto }}">
                            <div class="caption table-responsive" ng-hide="html.chkInformeTextual && html.chkInformeRegistrosFotograficos">
                                <h3>Relleno</h3>
                                <center>
                                    <table class="mdl-data-table mdl-js-data-table">
                                        <thead>
                                            <tr>
                                                <th colspan="3">Operario</th>
                                                <th>Relleno</th>
                                                <th colspan="2">Estado</th>
                                                <th colspan="2">Revision</th>
                                                <th colspan="2">Fecha/Hora</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="3">{{ relleno.empleado[0].nombresCompletosPersona }}</td>
                                                <td>{{ relleno.empates }}</td>
                                                <td colspan="2">{{ relleno.nombreChecked }}</td>
                                                <td colspan="2">{{ relleno.nombreEstado }}</td>
                                                <td colspan="2">{{ relleno.fechaRegistro }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="5">Observaciones</td>
                                                <td colspan="5">{{ relleno.observaciones }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="10">Usos de insumos <span class="text-muted" ng-bind="'(' + relleno.usosInsumos.total + ')' "></span></td>
                                            </tr>
                                            <tr>
                                                <th colspan="3" ng-click="orden='insumo'">Insumo</th>
                                                <th ng-click="orden='cantidad'">Cantidad</th>
                                                <th ng-click="orden='nombreUsado'">Usado</th>
                                                <th ng-click="orden='nombreTerminado'">Terminado</th>
                                                <th colspan="2" ng-click="orden='empleadoUso'">Empleado (uso)</th>
                                                <th colspan="2" ng-click="orden='empleadoEnvio'">Empleado (envio)</th>
                                            </tr>
                                            <tr ng-repeat="objeto in relleno.usosInsumos.datos | orderBy: orden" ng-show="relleno.usosInsumos.datos!=null">
                                                <td colspan="3" class="mdl-data-table__cell--non-numeric">{{ objeto.insumo }}</td>
                                                <td>{{ objeto.cantidad }}</td>
                                                <td>{{ objeto.nombreUsado }}</td>
                                                <td>{{ objeto.nombreTerminado }}</td>
                                                <td colspan="2">{{ objeto.empleadoUso }}</td>
                                                <td colspan="2">{{ objeto.empleadoEnvio }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </center>
                                <br>
                                <footer class="pull-right">Fecha/Hora: <cite>{{ relleno.fechaRegistro }}</cite></footer>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
                <!--FIN RELLENO-->
                <!--------------------------------------------------------------------->
                <!--------------------------------------------------------------------->
                <!--CORTE BANDA-->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive page-header" style="margin-top: 2px; margin-bottom: 2px; padding-bottom: 15px" ng-show="corteBanda!=null && html.chkInformeTextual || corteBanda!=null && html.chkInformeRegistrosFotograficos">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left" ng-show="html.chkInformeTextual">
                        <h3>Corte de Banda</h3>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-show="html.chkInformeTextual"><br></div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" ng-show="html.chkInformeTextual">
                        <center>
                            <table class="mdl-data-table mdl-js-data-table">
                                <thead>
                                    <tr>
                                        <th colspan="3">Operario</th>
                                        <th colspan="2">Empates</th>
                                        <th colspan="3">Observaciones</th>
                                        <th colspan="2">Fecha/Hora</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="3">{{ corteBanda.empleado[0].nombresCompletosPersona }}</td>
                                        <td colspan="2">{{ corteBanda.empates }}</td>
                                        <td colspan="3">{{ corteBanda.observaciones }}</td>
                                        <td colspan="2">{{ corteBanda.fechaRegistro }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="10">Usos de insumos <span class="text-muted" ng-bind="'(' + corteBanda.usosInsumos.total + ')' "></span></td>
                                    </tr>
                                    <tr>
                                        <th colspan="3" ng-click="orden='insumo'">Insumo</th>
                                        <th ng-click="orden='cantidad'">Cantidad</th>
                                        <th ng-click="orden='nombreUsado'">Usado</th>
                                        <th ng-click="orden='nombreTerminado'">Terminado</th>
                                        <th colspan="2" ng-click="orden='empleadoUso'">Empleado (uso)</th>
                                        <th colspan="2" ng-click="orden='empleadoEnvio'">Empleado (envio)</th>
                                    </tr>
                                    <tr ng-repeat="objeto in corteBanda.usosInsumos.datos | orderBy: orden" ng-show="corteBanda.usosInsumos.datos!=null">
                                        <td colspan="3" class="mdl-data-table__cell--non-numeric">{{ objeto.insumo }}</td>
                                        <td>{{ objeto.cantidad }}</td>
                                        <td>{{ objeto.nombreUsado }} <span class="text-muted" ng-show="objeto.cantidadUsada!=null">({{ objeto.cantidadUsada }})</span></td>
                                        <td>{{ objeto.nombreTerminado }}</td>
                                        <td colspan="2">{{ objeto.empleadoUso }}</td>
                                        <td colspan="2">{{ objeto.empleadoEnvio }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </center>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-show="html.chkInformeRegistrosFotograficos"><br></div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" ng-show="html.chkInformeRegistrosFotograficos">
                        <div class="thumbnail">
                            <img class="img-responsive" ng-src="../Uploads/Imgs/Corte_Banda/{{ corteBanda.foto }}">
                            <div class="caption table-responsive" ng-hide="html.chkInformeTextual && html.chkInformeRegistrosFotograficos">
                                <h3>Corte de Banda</h3>
                                <center>
                                    <table class="mdl-data-table mdl-js-data-table">
                                        <thead>
                                            <tr>
                                                <th colspan="3">Operario</th>
                                                <th colspan="4">Observaciones</th>
                                                <th colspan="3">Fecha/Hora</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="3">{{ corteBanda.empleado[0].nombresCompletosPersona }}</td>
                                                <td colspan="4">{{ corteBanda.observaciones }}</td>
                                                <td colspan="3">{{ corteBanda.fechaRegistro }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="10">Usos de insumos <span class="text-muted" ng-bind="'(' + corteBanda.usosInsumos.total + ')' "></span></td>
                                            </tr>
                                            <tr>
                                                <th colspan="3" ng-click="orden='insumo'">Insumo</th>
                                                <th ng-click="orden='cantidad'">Cantidad</th>
                                                <th ng-click="orden='nombreUsado'">Usado</th>
                                                <th ng-click="orden='nombreTerminado'">Terminado</th>
                                                <th colspan="2" ng-click="orden='empleadoUso'">Empleado (uso)</th>
                                                <th colspan="2" ng-click="orden='empleadoEnvio'">Empleado (envio)</th>
                                            </tr>
                                            <tr ng-repeat="objeto in corteBanda.usosInsumos.datos | orderBy: orden" ng-show="corteBanda.usosInsumos.datos!=null">
                                                <td colspan="3" class="mdl-data-table__cell--non-numeric">{{ objeto.insumo }}</td>
                                                <td>{{ objeto.cantidad }}</td>
                                                <td>{{ objeto.nombreUsado }}</td>
                                                <td>{{ objeto.nombreTerminado }}</td>
                                                <td colspan="2">{{ objeto.empleadoUso }}</td>
                                                <td colspan="2">{{ objeto.empleadoEnvio }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </center>
                                <br>
                                <footer class="pull-right">Fecha/Hora: <cite>{{ corteBanda.fechaRegistro }}</cite></footer>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
                <!--FIN CORTE BANDA-->
                <!--------------------------------------------------------------------->
                <!--------------------------------------------------------------------->
                <!--EMBANDADO-->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive page-header" style="margin-top: 2px; margin-bottom: 2px; padding-bottom: 15px"  ng-show="embandado!=null && html.chkInformeTextual || embandado!=null && html.chkInformeRegistrosFotograficos">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left" ng-show="html.chkInformeTextual">
                        <h3>Embandado</h3>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-show="html.chkInformeTextual"><br></div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" ng-show="html.chkInformeTextual">
                        <center>
                            <table class="mdl-data-table mdl-js-data-table">
                                <thead>
                                    <tr>
                                        <th colspan="3">Operario</th>
                                        <th>Gravado</th>
                                        <th>Ancho banda</th>
                                        <th>Largo banda</th>
                                        <th>Estado</th>
                                        <th>Revision</th>
                                        <th colspan="2">Fecha/Hora</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="3">{{ embandado.empleado[0].nombresCompletosPersona }}</td>
                                        <td>{{ embandado.gravado[0].nombre }}</td>
                                        <td>{{ embandado.anchoBanda }}</td>
                                        <td>{{ embandado.largoBanda }}</td>
                                        <td>{{ embandado.nombreChecked }}</td>
                                        <td>{{ embandado.nombreEstado }}</td>
                                        <td colspan="2">{{ embandado.fechaRegistro }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">Observaciones</td>
                                        <td colspan="5">{{ embandado.observaciones }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="10">Usos de insumos <span class="text-muted" ng-bind="'(' + embandado.usosInsumos.total + ')' "></span></td>
                                    </tr>
                                    <tr>
                                        <th colspan="3" ng-click="orden='insumo'">Insumo</th>
                                        <th ng-click="orden='cantidad'">Cantidad</th>
                                        <th ng-click="orden='nombreUsado'">Usado</th>
                                        <th ng-click="orden='nombreTerminado'">Terminado</th>
                                        <th colspan="2" ng-click="orden='empleadoUso'">Empleado (uso)</th>
                                        <th colspan="2" ng-click="orden='empleadoEnvio'">Empleado (envio)</th>
                                    </tr>
                                    <tr ng-repeat="objeto in embandado.usosInsumos.datos | orderBy: orden" ng-show="embandado.usosInsumos.datos!=null">
                                        <td colspan="3" class="mdl-data-table__cell--non-numeric">{{ objeto.insumo }}</td>
                                        <td>{{ objeto.cantidad }}</td>
                                        <td>{{ objeto.nombreUsado }}</td>
                                        <td>{{ objeto.nombreTerminado }}</td>
                                        <td colspan="2">{{ objeto.empleadoUso }}</td>
                                        <td colspan="2">{{ objeto.empleadoEnvio }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </center>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-show="html.chkInformeRegistrosFotograficos"><br></div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" ng-show="html.chkInformeRegistrosFotograficos">
                        <div class="thumbnail">
                            <img class="img-responsive" ng-src="../Uploads/Imgs/Embandado/{{ embandado.foto }}">
                            <div class="caption table-responsive" ng-hide="html.chkInformeTextual && html.chkInformeRegistrosFotograficos">
                                <h3>Embandado</h3>
                                <center>
                                    <table class="mdl-data-table mdl-js-data-table">
                                        <thead>
                                            <tr>
                                                <th colspan="3">Operario</th>
                                                <th>Gravado</th>
                                                <th>Ancho banda</th>
                                                <th>Largo banda</th>
                                                <th>Estado</th>
                                                <th>Revision</th>
                                                <th colspan="2">Fecha/Hora</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="3">{{ embandado.empleado[0].nombresCompletosPersona }}</td>
                                                <td>{{ embandado.gravado[0].nombre }}</td>
                                                <td>{{ embandado.anchoBanda }}</td>
                                                <td>{{ embandado.largoBanda }}</td>
                                                <td>{{ embandado.nombreChecked }}</td>
                                                <td>{{ embandado.nombreEstado }}</td>
                                                <td colspan="2">{{ embandado.fechaRegistro }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="5">Observaciones</td>
                                                <td colspan="5">{{ embandado.observaciones }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="10">Usos de insumos <span class="text-muted" ng-bind="'(' + embandado.usosInsumos.total + ')' "></span></td>
                                            </tr>
                                            <tr>
                                                <th colspan="3" ng-click="orden='insumo'">Insumo</th>
                                                <th ng-click="orden='cantidad'">Cantidad</th>
                                                <th ng-click="orden='nombreUsado'">Usado</th>
                                                <th ng-click="orden='nombreTerminado'">Terminado</th>
                                                <th colspan="2" ng-click="orden='empleadoUso'">Empleado (uso)</th>
                                                <th colspan="2" ng-click="orden='empleadoEnvio'">Empleado (envio)</th>
                                            </tr>
                                            <tr ng-repeat="objeto in embandado.usosInsumos.datos | orderBy: orden" ng-show="embandado.usosInsumos.datos!=null">
                                                <td colspan="3" class="mdl-data-table__cell--non-numeric">{{ objeto.insumo }}</td>
                                                <td>{{ objeto.cantidad }}</td>
                                                <td>{{ objeto.nombreUsado }}</td>
                                                <td>{{ objeto.nombreTerminado }}</td>
                                                <td colspan="2">{{ objeto.empleadoUso }}</td>
                                                <td colspan="2">{{ objeto.empleadoEnvio }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </center>
                                <br>
                                <footer class="pull-right">Fecha/Hora: <cite>{{ embandado.fechaRegistro }}</cite></footer>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
                <!--FIN EMBANDADO-->
                <!--------------------------------------------------------------------->
                <!--------------------------------------------------------------------->
                <!--VULCANIZADO-->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive page-header" style="margin-top: 2px; margin-bottom: 2px; padding-bottom: 15px" ng-show="vulcanizado!=null && html.chkInformeTextual || vulcanizado!=null && html.chkInformeRegistrosFotograficos">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left" ng-show="html.chkInformeTextual">
                        <h3>Vulcanizado</h3>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-show="html.chkInformeTextual"><br></div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" ng-show="html.chkInformeTextual">
                        <center>
                            <table class="mdl-data-table mdl-js-data-table">
                                <thead>
                                    <tr>
                                        <th colspan="2">Operario</th>
                                        <th>Metodo</th>
                                        <th>Estado</th>
                                        <th>Revision</th>
                                        <th>Camaras</th>
                                        <th colspan="2">Fecha/Hora inicio</th>
                                        <th colspan="2">Fecha/Hora finalizacion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="2">{{ vulcanizado.empleado[0].nombresCompletosPersona }}</td>
                                        <td>{{ vulcanizado.nombreMetodo }}</td>
                                        <td>{{ vulcanizado.nombreChecked }}</td>
                                        <td>{{ vulcanizado.nombreEstado }}</td>
                                        <td>{{ vulcanizado.camaras }}/{{ vulcanizado.camarasRegistradas }}</td>
                                        <td colspan="2">{{ vulcanizado.fechaRegistro }}</td>
                                        <td colspan="2">{{ vulcanizado.fechaFinalizacion }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">Observaciones</td>
                                        <td colspan="5">{{ vulcanizado.observaciones }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="10">Usos de insumos <span class="text-muted" ng-bind="'(' + vulcanizado.usosInsumos.total + ')' "></span></td>
                                    </tr>
                                    <tr>
                                        <th colspan="3" ng-click="orden='insumo'">Insumo</th>
                                        <th ng-click="orden='cantidad'">Cantidad</th>
                                        <th ng-click="orden='nombreUsado'">Usado</th>
                                        <th ng-click="orden='nombreTerminado'">Terminado</th>
                                        <th colspan="2" ng-click="orden='empleadoUso'">Empleado (uso)</th>
                                        <th colspan="2" ng-click="orden='empleadoEnvio'">Empleado (envio)</th>
                                    </tr>
                                    <tr ng-repeat="objeto in vulcanizado.usosInsumos.datos | orderBy: orden" ng-show="vulcanizado.usosInsumos.datos!=null">
                                        <td colspan="3" class="mdl-data-table__cell--non-numeric">{{ objeto.insumo }}</td>
                                        <td>{{ objeto.cantidad }}</td>
                                        <td>{{ objeto.nombreUsado }}</td>
                                        <td>{{ objeto.nombreTerminado }}</td>
                                        <td colspan="2">{{ objeto.empleadoUso }}</td>
                                        <td colspan="2">{{ objeto.empleadoEnvio }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </center>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-show="html.chkInformeRegistrosFotograficos"><br></div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" ng-show="html.chkInformeRegistrosFotograficos">
                        <div class="thumbnail">
                            <img class="img-responsive" ng-src="../Uploads/Imgs/Vulcanizado/{{ vulcanizado.foto }}">
                            <div class="caption table-responsive" ng-hide="html.chkInformeTextual && html.chkInformeRegistrosFotograficos">
                                <h3>Vulcanizado</h3>
                                <center>
                                    <table class="mdl-data-table mdl-js-data-table">
                                        <thead>
                                            <tr>
                                                <th colspan="2">Operario</th>
                                                <th>Metodo</th>
                                                <th>Estado</th>
                                                <th>Revision</th>
                                                <th>Camaras</th>
                                                <th colspan="2">Fecha/Hora inicio</th>
                                                <th colspan="2">Fecha/Hora finalizacion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="2">{{ vulcanizado.empleado[0].nombresCompletosPersona }}</td>
                                                <td>{{ vulcanizado.nombreMetodo }}</td>
                                                <td>{{ vulcanizado.nombreChecked }}</td>
                                                <td>{{ vulcanizado.nombreEstado }}</td>
                                                <td>{{ vulcanizado.camaras }}/{{ vulcanizado.camarasRegistradas }}</td>
                                                <td colspan="2">{{ vulcanizado.fechaRegistro }}</td>
                                                <td colspan="2">{{ vulcanizado.fechaFinalizacion }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="5">Observaciones</td>
                                                <td colspan="5">{{ vulcanizado.observaciones }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="10">Usos de insumos <span class="text-muted" ng-bind="'(' + vulcanizado.usosInsumos.total + ')' "></span></td>
                                            </tr>
                                            <tr>
                                                <th colspan="3" ng-click="orden='insumo'">Insumo</th>
                                                <th ng-click="orden='cantidad'">Cantidad</th>
                                                <th ng-click="orden='nombreUsado'">Usado</th>
                                                <th ng-click="orden='nombreTerminado'">Terminado</th>
                                                <th colspan="2" ng-click="orden='empleadoUso'">Empleado (uso)</th>
                                                <th colspan="2" ng-click="orden='empleadoEnvio'">Empleado (envio)</th>
                                            </tr>
                                            <tr ng-repeat="objeto in vulcanizado.usosInsumos.datos | orderBy: orden" ng-show="vulcanizado.usosInsumos.datos!=null">
                                                <td colspan="3" class="mdl-data-table__cell--non-numeric">{{ objeto.insumo }}</td>
                                                <td>{{ objeto.cantidad }}</td>
                                                <td>{{ objeto.nombreUsado }}</td>
                                                <td>{{ objeto.nombreTerminado }}</td>
                                                <td colspan="2">{{ objeto.empleadoUso }}</td>
                                                <td colspan="2">{{ objeto.empleadoEnvio }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </center>
                                <br>
                                <footer class="pull-right">Fecha/Hora: <cite>{{ vulcanizado.fechaRegistro }}</cite></footer>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
                <!--FIN VULCANIZADO-->
                <!--------------------------------------------------------------------->
                <!--------------------------------------------------------------------->
                <!--INSPECCION FINAL-->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive page-header" style="margin-top: 2px; margin-bottom: 2px; padding-bottom: 15px" ng-show="inspeccionFinal!=null && html.chkInformeTextual || inspeccionFinal!=null && html.chkInformeRegistrosFotograficos">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left" ng-show="html.chkInformeTextual">
                        <h3>Inspeccion Final</h3>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-show="html.chkInformeTextual"><br></div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" ng-show="html.chkInformeTextual">
                        <center>
                            <table class="mdl-data-table mdl-js-data-table">
                                <thead>
                                    <tr>
                                        <th colspan="3">Operario</th>
                                        <th colspan="2">Estado</th>
                                        <th colspan="2">Revision</th>
                                        <th colspan="3">Fecha/Hora</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="3">{{ inspeccionFinal.empleado[0].nombresCompletosPersona }}</td>
                                        <td colspan="2">{{ inspeccionFinal.nombreChecked }}</td>
                                        <td colspan="2">{{ inspeccionFinal.nombreEstado }}</td>
                                        <td colspan="3">{{ inspeccionFinal.fechaRegistro }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">Observaciones</td>
                                        <td colspan="5">{{ inspeccionFinal.observaciones }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="10">Usos de insumos <span class="text-muted" ng-bind="'(' + inspeccionFinal.usosInsumos.total + ')' "></span></td>
                                    </tr>
                                    <tr>
                                        <th colspan="3" ng-click="orden='insumo'">Insumo</th>
                                        <th ng-click="orden='cantidad'">Cantidad</th>
                                        <th ng-click="orden='nombreUsado'">Usado</th>
                                        <th ng-click="orden='nombreTerminado'">Terminado</th>
                                        <th colspan="2" ng-click="orden='empleadoUso'">Empleado (uso)</th>
                                        <th colspan="2" ng-click="orden='empleadoEnvio'">Empleado (envio)</th>
                                    </tr>
                                    <tr ng-repeat="objeto in inspeccionFinal.usosInsumos.datos | orderBy: orden" ng-show="inspeccionFinal.usosInsumos.datos!=null">
                                        <td colspan="3" class="mdl-data-table__cell--non-numeric">{{ objeto.insumo }}</td>
                                        <td>{{ objeto.cantidad }}</td>
                                        <td>{{ objeto.nombreUsado }}</td>
                                        <td>{{ objeto.nombreTerminado }}</td>
                                        <td colspan="2">{{ objeto.empleadoUso }}</td>
                                        <td colspan="2">{{ objeto.empleadoEnvio }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </center>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-show="html.chkInformeRegistrosFotograficos"><br></div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" ng-show="html.chkInformeRegistrosFotograficos">
                        <div class="thumbnail">
                            <img class="img-responsive" ng-src="../Uploads/Imgs/InspeccionFinal/{{ inspeccionFinal.foto }}">
                            <div class="caption table-responsive" ng-hide="html.chkInformeTextual && html.chkInformeRegistrosFotograficos">
                                <h3>Inspeccion Final</h3>
                                <center>
                                    <table class="mdl-data-table mdl-js-data-table">
                                        <thead>
                                            <tr>
                                                <th colspan="3">Operario</th>
                                                <th colspan="2">Estado</th>
                                                <th colspan="2">Revision</th>
                                                <th colspan="3">Fecha/Hora</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="3">{{ inspeccionFinal.empleado[0].nombresCompletosPersona }}</td>
                                                <td colspan="2">{{ inspeccionFinal.nombreChecked }}</td>
                                                <td colspan="2">{{ inspeccionFinal.nombreEstado }}</td>
                                                <td colspan="3">{{ inspeccionFinal.fechaRegistro }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="5">Observaciones</td>
                                                <td colspan="5">{{ inspeccionFinal.observaciones }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="10">Usos de insumos <span class="text-muted" ng-bind="'(' + inspeccionFinal.usosInsumos.total + ')' "></span></td>
                                            </tr>
                                            <tr>
                                                <th colspan="3" ng-click="orden='insumo'">Insumo</th>
                                                <th ng-click="orden='cantidad'">Cantidad</th>
                                                <th ng-click="orden='nombreUsado'">Usado</th>
                                                <th ng-click="orden='nombreTerminado'">Terminado</th>
                                                <th colspan="2" ng-click="orden='empleadoUso'">Empleado (uso)</th>
                                                <th colspan="2" ng-click="orden='empleadoEnvio'">Empleado (envio)</th>
                                            </tr>
                                            <tr ng-repeat="objeto in inspeccionFinal.usosInsumos.datos | orderBy: orden" ng-show="inspeccionFinal.usosInsumos.datos!=null">
                                                <td colspan="3" class="mdl-data-table__cell--non-numeric">{{ objeto.insumo }}</td>
                                                <td>{{ objeto.cantidad }}</td>
                                                <td>{{ objeto.nombreUsado }}</td>
                                                <td>{{ objeto.nombreTerminado }}</td>
                                                <td colspan="2">{{ objeto.empleadoUso }}</td>
                                                <td colspan="2">{{ objeto.empleadoEnvio }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </center>
                                <br>
                                <footer class="pull-right">Fecha/Hora: <cite>{{ inspeccionFinal.fechaRegistro }}</cite></footer>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
                <!--FIN INSPECCION FINAL-->
                <!--------------------------------------------------------------------->
                <!--------------------------------------------------------------------->
                <!--TERMINACION-->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive page-header" style="margin-top: 2px; margin-bottom: 2px; padding-bottom: 15px" ng-show="terminacion!=null && html.chkInformeTextual || terminacion!=null && html.chkInformeRegistrosFotograficos">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left" ng-show="html.chkInformeTextual">
                        <h3>Terminacion</h3>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-show="html.chkInformeTextual"><br></div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive" ng-show="html.chkInformeTextual">
                        <center>
                            <table class="mdl-data-table mdl-js-data-table">
                                <thead>
                                    <tr>
                                        <th>Operario</th>
                                        <th>Revision</th>
                                        <th>Observaciones</th>
                                        <th>Fecha/Hora</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ terminacion.empleado[0].nombresCompletosPersona }}</td>
                                        <td>{{ terminacion.nombreEstado }}</td>
                                        <td>{{ terminacion.observaciones }}</td>
                                        <td>{{ terminacion.fechaRegistro }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </center>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-show="html.chkInformeRegistrosFotograficos"><br></div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" ng-show="html.chkInformeRegistrosFotograficos">
                        <div class="thumbnail">
                            <img class="img-responsive" ng-src="../Uploads/Imgs/Terminacion/{{ terminacion.foto }}">
                            <div class="caption table-responsive" ng-hide="html.chkInformeTextual && html.chkInformeRegistrosFotograficos">
                                <h3>Terminacion</h3>
                                <center>
                                    <table class="mdl-data-table mdl-js-data-table">
                                        <thead>
                                            <tr>
                                                <th>Operario</th>
                                                <th>Revision</th>
                                                <th>Observaciones</th>
                                                <th>Fecha/Hora</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ terminacion.empleado[0].nombresCompletosPersona }}</td>
                                                <td>{{ terminacion.nombreEstado }}</td>
                                                <td>{{ terminacion.observaciones }}</td>
                                                <td>{{ terminacion.fechaRegistro }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </center>
                                <br>
                                <footer class="pull-right">Fecha/Hora: <cite>{{ terminacion.fechaRegistro }}</cite></footer>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
                <!--FIN TERMINACION-->
                <!--------------------------------------------------------------------->
                <!--Fin procesos-->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive page-header" style="margin-top: 2px; margin-bottom: 2px; padding-bottom: 15px" ng-show="html.chkInformeDataGrafica && dataInforme!=null && dataInforme.valorEstado!=0">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                        <h3>Grafico</h3>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><br></div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12table-responsive">
                        <div id="chartdiv" style="width: 100%; height: 400px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div id="toast-principal" class="mdl-js-snackbar mdl-snackbar">
          <div class="mdl-snackbar__text"></div>
          <button class="mdl-snackbar__action" type="button"></button>
        </div>
        <script src="../../lib/controladores/informeRencaucheImprimir.js"></script>
    </body>
</html>