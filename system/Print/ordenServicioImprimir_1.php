<?php
session_start();
date_default_timezone_set("America/Bogota");
$today= date("Y-m-d");
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>PANAMA.sas</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" href="../../design/pics/iconos/IcoPanam.ico">
        <link rel="stylesheet" href="../../lib/frameworks/bootstrap-3.3.7-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../lib/frameworks/mdl/material.min.css">
        <script src="../../lib/frameworks/JQuery/jquery-3.2.1.min.js"></script>
        <script src="../../lib/frameworks/JQueryUi/jquery-ui-1.12.1/jquery-ui.min.js"></script>
        <script src="../../lib/frameworks/AngularJS/1.5.0/angular.min.js"></script>
        <script src="../../lib/frameworks/AngularJS/1.5.0/angular-route.min.js"></script>
        <script src="../../lib/frameworks/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
        <script src="../../lib/frameworks/mdl/material.min.js"></script>
        <script src="../../lib/aplicaciones/panamApp.js"></script>
        <script src="../../lib/controladores/ordenServicioImprimir.js"></script>
        <script src="../../lib/scripts/Toast.js"></script>
    </head>
    <body ng-app="navegacion" onafterprint="window.close();">
        <div ng-controller="ordenServicioImprimir">
            <div class="hidden" id="btnCargarDatatosOS" ng-click="cargarDatosOs(<?=$_GET['id']?>)"></div>
            <div ng-show="html.barraCarga" style="padding-top: 20px">
                <div class="col-sm-12 col-md-4"></div>
                <div class="col-sm-12 col-md-4">
                    <div class="mdl-progress mdl-js-progress mdl-progress__indeterminate"></div>
                </div>
                <div class="col-sm-12 col-md-4"></div>
            </div>
            <div class="col-lg-12">
                <center>
                    <table border="0">
                        <tr>
                            <td>
                                <div style="padding-top: 10px">
                                    <img src="../../design/pics/imagenes/LogoPanam.png" width="70px">
                                </div>
                            </td>
                            <td>
                                <div style="margin-top: -20px">
                                    <h3>Panam</h3>
                                    <div style="margin-top: -25px">
                                        <span class="text text-muted small">Reencauchadora</span>
                                    </div>
                                    <br>
                                    <div style="margin-top: -20px">
                                        <span class="text text-muted small">Panam de Colombia S.A.S</span>
                                    </div>
                                </div>
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
            <div class="col-lg-12 text text-uppercase" style="padding-top: 15px">
                <center>
                    <table border="0">
                        <tr>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-addon">CLIENTE:</span>
                                    <input class="form-control" id="txtEmpresa" name="txtEmpresa" type="text" value="{{ ordenServicio.cliente[0].nombreEmpresa }}" disabled>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-addon">CC/Nit:</span>
                                    <input class="form-control" id="txtIdentificacion" name="txtIdentificacion" placeholder="CC/NIT" type="number" value="{{ ordenServicio.cliente[0].identificacion }}" disabled>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-addon">OS:</span>
                                    <input class="form-control" id="txtOs" name="os" placeholder="Orden de servicio (N°)" type="number" min="1" value="{{ ordenServicio.os }}" disabled>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-addon">Direccion:</span>
                                    <input class="form-control" id="txtDireccion" type="text" value="{{ ordenServicio.cliente[0].direccionPersona }}" disabled>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-addon">Telefono:</span>
                                    <input class="form-control" id="txtTelefono" type="text" value="{{ ordenServicio.cliente[0].celularPersona }}" disabled>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-addon" >Fecha de recoleccion:</span>
                                    <input class="form-control" id="txtFechaRecoleccion" name="fechaRecoleccion" type="text" value="{{ ordenServicio.fechaRegistro }}" disabled>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="input-group">
                                    <span class="input-group-addon">Vendedor:</span>
                                    <input class="form-control" id="txtNombresFuncionario" name="nombresFuncionario" type="text" value="{{ ordenServicio.empleado[0].nombresCompletosPersona }}" disabled>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-addon">No. Factura</span>
                                    <input class="form-control" name="numeroFactura" type="number" value="{{ ordenServicio.numeroFactura }}" disabled>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div class="col-sm-12 col-md-12 col-lg-12" style="padding-top: 10px">
                        <div class="form-group-sm form-inline">
                            <div class="input-group" ng-repeat="objeto in tiposServicioOS">
                                <div>
                                    <span class="input-group-addon">{{ objeto.nombre }}</span>
                                    <span class="input-group-addon"><input class="" id="chkTipoServicio_{{ objeto.id }}" name="chk_tipo_servicio_{{ objeto.id }}" type="checkbox" ng-model="objeto.checked" ng-change="separarTipoServicio(objeto.checked, objeto.id)" ng-disabled="html.inputDisabled" ng-checked="objeto.checked"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12" style="padding-top: 10px">
                        <table class="mdl-data-table mdl-js-data-table">
                            <thead>
                                <tr>
                                    <th class="mdl-data-table__cell--non-numeric" ng-click="ordenar='id'">N°</th>
                                    <th>Marca</th>
                                    <th>Gravado</th>
                                    <th>RP</th>
                                    <th>Serie</th>
                                    <th>Diseño/Dimension original</th>
                                    <th>Diseño/Dimension solicitada</th>
                                    <th>Diseño/Dimension entregada</th>
                                    <th>Estado</th>
                                    <th>Urgente</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="objeto in llantas" ng-show="llantas" style="background: {{ objeto.colorEstado }}; color: {{ objeto.colorLetraEstado }};">
                                  <td class="mdl-data-table__cell--non-numeric">{{ objeto.id }}</td>
                                  <td>{{ objeto.nombreMarca }}</td>
                                  <td>{{ objeto.gravado[0].nombre }}</td>
                                  <td>{{ objeto.rp }}</td>
                                  <td>{{ objeto.serie }}</td>
                                  <td>{{ objeto.aplicacionOriginal[0].medidaCompleta }}</td>
                                  <td>{{ objeto.aplicacionSolicitada[0].medidaCompleta }}</td>
                                  <td>{{ objeto.aplicacionEntregada[0].medidaCompleta }}</td>
                                  <td>{{ objeto.nombreProcesado }}</td>
                                  <td style="background: {{ objeto.colorUrgente }}">{{ objeto.nombreUrgente }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </center>
            </div>
        </div>
        <div id="toast-general" class="mdl-js-snackbar mdl-snackbar">
            <div class="mdl-snackbar__text"></div>
            <button class="mdl-snackbar__action" type="button"></button>
        </div>
    </body>
</html>