<script src="lib/controladores/informeRencauche.js"></script>
<div class="col-md-12" ng-controller="informeRencauche">
    <input type="hidden" id="txtFiltro" name="txtFiltro" value="{{ html.filtro }}">
    <input type="hidden" id="viewT" name="viewT" value="{{ html.chkInformeTextual }}">
    <input type="hidden" id="viewP" name="viewP" value="{{ html.chkInformeRegistrosFotograficos }}">
    <input type="hidden" id="viewG" name="viewG" value="{{ html.chkInformeDataGrafica }}">
    <div class="">
        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-1 display-1" >
            <button id="btnOpcionesFiltros" class="mdl-button mdl-js-button mdl-button--icon" autofocus>
                <i class="fa fa-angle-down"></i>
            </button>
            <ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect" for="btnOpcionesFiltros">
                <li class="mdl-menu__item" data-toggle="modal" href='/#_frmFiltros'>
                    <i class="fa fa-edit"></i><span> Generar informe</span>
                </li>
                <li class="mdl-menu__item">
                    <span class="mdl-list__item-primary-content">
                        <i class="fa fa-newspaper-o"></i> Informacion textual
                    </span>
                    <span class="mdl-list__item-secondary-action pull-right">
                        <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="swithInfText">
                            <input type="checkbox" id="swithInfText" class="mdl-switch__input" ng-model="html.chkInformeTextual" onclick="$('#chkInformeTextual').click();"/>
                        </label>
                    </span>
                </li>
                <li class="mdl-menu__item">
                    <span class="mdl-list__item-primary-content">
                        <i class="fa fa-picture-o"></i> Informacion fotografica
                    </span>
                    <span class="mdl-list__item-secondary-action">
                        <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="swithInfPics">
                            <input type="checkbox" id="swithInfPics" class="mdl-switch__input" ng-model="html.chkInformeRegistrosFotograficos" onclick="$('#chkInformeRegistrosFotograficos').click();"/>
                        </label>
                    </span>
                </li>
                <li class="mdl-menu__item">
                    <span class="mdl-list__item-primary-content">
                        <i class="fa fa-bar-chart-o"></i> Grafica estadistica
                    </span>
                    <span class="mdl-list__item-secondary-action pull-right">
                        <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="swithInfChart">
                            <input type="checkbox" id="swithInfChart" class="mdl-switch__input" ng-model="html.chkInformeDataGrafica" onclick="$('#chkInformeDataGrafica').click();"/>
                        </label>
                    </span>
                </li>
                <li class="mdl-menu__item" ng-show="!html.chkInformeTextual && !html.chkInformeRegistrosFotograficos && !html.chkInformeDataGrafica" onclick="$('#swithInfText').focus();">
                    <span class="mdl-badge" data-badge="!">Activa alguna configuracion de datos</span>
                    <!--<div class="alert alert-danger">Debes marcar alguna configuracion para generar el reporte</div>-->
                </li>
                <li class="mdl-menu__item" ng-click="imprimirInforme()">
                    <i class="fa fa-print"></i><span> Imprimir</span>
                </li>
            </ul>
            <div class="mdl-tooltip" for="btnOpcionesFiltros">Opciones</div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-10">
            <strong class="text text-success control-label"><h2>INFORME DE RENCAUCHE</h2></strong>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-1"></div>
<!--        <div class="row col-md-12" id="paddinTop10"></div>-->
    </div>
    <div class="row col-md-12" id="paddinTop20" ng-show="html.spinnerCarga">
        <div class="mdl-spinner mdl-js-spinner is-active"></div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-show="html.bodyInforme">
<!--    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">-->
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                <h3>Orden de servicio</h3>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><br></div>
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
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 text-left">
                <span class="text-nowrap">Dise&ntilde;o original: </span><span class="text-muted">{{ dataInforme.disenoOriginal[0].referencia }} </span>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 text-left">
                <span class="text-nowrap">Dimension: </span><span class="text-muted">{{ dataInforme.dimension[0].dimension }} </span>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 text-left">
                <span class="text-nowrap">Dise&ntilde;o solicitado: </span><span class="text-muted">{{ dataInforme.disenoSolicitado[0].referencia }} </span>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 text-left">
                <span class="text-nowrap">Dise&ntilde;o entregado: </span><span class="text-muted">{{ getMedidaAplicacionEntregada() }} </span>
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
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive page-header" style="margin-top: 2px; margin-bottom: 2px; padding-bottom: 15px" ng-show="inspeccionInicial!=null">
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
                    <img class="img-responsive" ng-src="system/Uploads/Imgs/Inspeccion_Inicial/{{ inspeccionInicial.foto }}">
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
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive page-header" style="margin-top: 2px; margin-bottom: 2px; padding-bottom: 15px" ng-show="raspado!=null">
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
                    <img class="img-responsive" ng-src="system/Uploads/Imgs/Raspado/{{ raspado.foto }}">
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
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive page-header" style="margin-top: 2px; margin-bottom: 2px; padding-bottom: 15px" ng-show="preparacion!=null">
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
                    <img class="img-responsive" ng-src="system/Uploads/Imgs/Preparacion/{{ preparacion.foto }}">
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
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive page-header" style="margin-top: 2px; margin-bottom: 2px; padding-bottom: 15px" ng-show="reparacion!=null">
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
                    <img class="img-responsive" ng-src="system/Uploads/Imgs/Reparacion/{{ reparacion.foto }}">
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
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive page-header" style="margin-top: 2px; margin-bottom: 2px; padding-bottom: 15px"  ng-show="cementado!=null">
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
                    <img class="img-responsive" ng-src="system/Uploads/Imgs/Cementado/{{ cementado.foto }}">
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
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive page-header" style="margin-top: 2px; margin-bottom: 2px; padding-bottom: 15px" ng-show="relleno!=null">
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
                    <img class="img-responsive" ng-src="system/Uploads/Imgs/Relleno/{{ relleno.foto }}">
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
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive page-header" style="margin-top: 2px; margin-bottom: 2px; padding-bottom: 15px" ng-show="corteBanda!=null">
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
                    <img class="img-responsive" ng-src="system/Uploads/Imgs/Corte_Banda/{{ corteBanda.foto }}">
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
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive page-header" style="margin-top: 2px; margin-bottom: 2px; padding-bottom: 15px"  ng-show="embandado!=null">
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
                    <img class="img-responsive" ng-src="system/Uploads/Imgs/Embandado/{{ embandado.foto }}">
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
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive page-header" style="margin-top: 2px; margin-bottom: 2px; padding-bottom: 15px" ng-show="vulcanizado!=null">
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
                    <img class="img-responsive" ng-src="system/Uploads/Imgs/Vulcanizado/{{ vulcanizado.foto }}">
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
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive page-header" style="margin-top: 2px; margin-bottom: 2px; padding-bottom: 15px" ng-show="inspeccionFinal!=null">
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
                    <img class="img-responsive" ng-src="system/Uploads/Imgs/InspeccionFinal/{{ inspeccionFinal.foto }}">
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
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive page-header" style="margin-top: 2px; margin-bottom: 2px; padding-bottom: 15px" ng-show="terminacion!=null">
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
                    <img class="img-responsive" ng-src="system/Uploads/Imgs/Terminacion/{{ terminacion.foto }}">
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
    <div class='modal fade' id='_frmFiltros'>
        <div class='modal-dialog modal-lg'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                    <h3 class="text text-primary text-uppercase">Filtros</h3>
                    <div class="col-xs-12 col-sm col-md-12 col-lg-12 text-center" ng-show="html.progressBarDialog">
                        <div class="mdl-progress mdl-js-progress mdl-progress__indeterminate"></div>
                    </div>
                </div>
                <div class='modal-header table-responsive'>
                    <form name="frmFiltros" id="frmFiltros">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"></span>
                                    <span class="input-group-addon">
                                        <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="chkOs">
                                            <input type="checkbox" id="chkOs" class="mdl-checkbox__input" name="chkOs" ng-model="html.chkOs" ng-change="setCheckedOS();validarFiltros();">
                                            <span class="mdl-checkbox__label">
                                                <i ng-show="!html.chkOs" class="fa fa-gear"></i>
                                                <i ng-show="html.chkOs" class="fa fa-gears"></i> Cargar llantas de OS:
                                            </span>
                                        </label>
                                    </span>
                                    <span class="input-group-addon"></span>
                                </div>    
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-list-ol"> Numero:</i>
                                    </span>
                                    <input class="form-control" id="txtNumeroOs" type="number" name="numeroOs" min="0" ng-model="html.numeroOs" ng-disabled="!html.chkOs" ng-change="setCheckedOS()" autofocus>
                                    <span class="input-group-btn">
                                        <button class="btn btn-info" id="btnBuscarOs" ng-disabled="!html.chkOs || html.numeroOs==null" ng-click="cargarLlantasOs();"><span class="fa fa-search"></span></button>
                                    </span>
                                </div>
                                <div class="alert alert-danger" ng-show="html.chkOs && html.numeroOs==null">Este campo no puede estar vacio</div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-12 modal-footer"></div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: -15px; padding-bottom: 15px;">
                            <h4 class="text text-muted">Buscar llanta por:</h4>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-hide="!html.chkOs">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"></span>
                                    <span class="input-group-addon">
                                        <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="rbtListaSeleccion">
                                            <input type="radio" id="rbtListaSeleccion" class="mdl-radio__button" name="rbtBusquedaLlanta" value="0" ng-model="html.rbtBusquedaLlanta" ng-checked="html.rbtListaSeleccion" ng-change="validarFiltros()">
                                            <span class="mdl-checkbox__label">
                                                <i class="fa fa-list"></i> Lista de seleccion:
                                            </span>
                                        </label>
                                    </span>
                                    <span class="input-group-addon"></span>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">Llantas: </span>
                                    <select class="form-control has-success" id="spnLlantas" name="llanta" ng-model="html.spnLlanta" ng-disabled="html.spnLlantas" ng-options="'RP: ' +  llanta.serie + ' || SERIE: ' + llanta.serie  for llanta in llantas" ng-change="setLlanta();">
                                        <option value="">Seleccione una opcion</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-12" ng-show="html.rbtRP">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"></span>
                                    <span class="input-group-addon">
                                        <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="rbtRp">
                                            <input type="radio" id="rbtRp" class="mdl-radio__button" name="rbtBusquedaLlanta" value="1" ng-model="html.rbtBusquedaLlanta" ng-change="validarFiltros();activarBtnGenerar();" ng-checked="html.rbtRP">
                                            <span class="mdl-checkbox__label">
                                                <i class="fa fa-database"></i> RP:
                                            </span>
                                        </label>
                                    </span>
                                    <span class="input-group-addon"></span>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">N°: </span>
                                    <input class="form-control has-success" id="txtRp" name="rp" ng-model="html.numeroRp" type="number" ng-disabled="html.rbtBusquedaLlanta!=1" ng-change="activarBtnGenerar();">
                                </div>
                                <div class="alert alert-danger" ng-show="html.rbtBusquedaLlanta==1 && html.numeroRp==null">Este campo no puede estar vacio</div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-6 hide" ng-show="html.rbtRP">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"></span>
                                    <span class="input-group-addon">
                                        <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="rbtSerie">
                                            <input type="radio" id="rbtSerie" class="mdl-radio__button" name="rbtBusquedaLlanta" value="2" ng-model="html.rbtBusquedaLlanta" ng-change="validarFiltros();activarBtnGenerar();">
                                            <span class="mdl-checkbox__label">
                                                <i class="fa fa-code-fork"></i> Serie:
                                            </span>
                                        </label>
                                    </span>
                                    <span class="input-group-addon"></span>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">N°: </span>
                                    <input class="form-control has-success" id="txtSerie" name="serie" ng-model="html.numeroSerie" type="number" ng-disabled="html.rbtBusquedaLlanta!=2" ng-change="activarBtnGenerar();">
                                </div>
                                <div class="alert alert-danger" ng-show="html.rbtBusquedaLlanta==2 && html.numeroSerie==null">Este campo no puede estar vacio</div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hide">
                            <div class="form-group table-responsive">
                                <div class="input-group">
                                    <span class="input-group-addon"></span>
                                    <span class="input-group-addon">
                                        <label>
                                            <i class="fa fa-list"></i> Configurar informe:
                                        </label>
                                    </span>
                                    <span class="input-group-addon"></span>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="chkInformeTextual">
                                            <input type="checkbox" id="chkInformeTextual" class="mdl-checkbox__input" name="chkInformeTextual" ng-model="html.chkInformeTextual" ng-change="setConfiguracionInforme()">
                                            <span class="mdl-checkbox__label">
                                                <i class="fa fa-newspaper-o"> Textual:</i>
                                            </span>
                                        </label>
                                    </span>
                                    <span class="input-group-addon">
                                        <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="chkInformeRegistrosFotograficos">
                                            <input type="checkbox" id="chkInformeRegistrosFotograficos" class="mdl-checkbox__input" name="chkInformeRegistrosFotograficos" ng-model="html.chkInformeRegistrosFotograficos" ng-change="setConfiguracionInforme()">
                                            <span class="mdl-checkbox__label">
                                                <i class="fa fa-picture-o"> Registros fotrograficos:</i>
                                            </span>
                                        </label>
                                    </span>
                                    <span class="input-group-addon">
                                        <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="chkInformeDataGrafica">
                                            <input type="checkbox" id="chkInformeDataGrafica" class="mdl-checkbox__input" name="chkInformeDataGrafica" ng-model="html.chkInformeDataGrafica" ng-change="setConfiguracionInforme()">
                                            <span class="mdl-checkbox__label">
                                                <i class="fa fa-bar-chart-o"> Grafica estadistica:</i>
                                            </span>
                                        </label>
                                    </span>
                                </div>
                                <div class="alert alert-danger" ng-show="!html.chkInformeTextual && !html.chkInformeRegistrosFotograficos && !html.chkInformeDataGrafica">Debes marcar alguna configuracion para generar el reporte</div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-danger' data-dismiss='modal' >Cancelar</button>
                    <button type='button' class='btn btn-success' ng-disabled="html.btnGenerar" ng-click="generarInforme();" data-dismiss='modal'>Generar</button>
                </div>
            </div>
        </div>
        <div class="mdl-tooltip" for="btnBuscarOs">Buscar llantas de la OS <span ng-bind="html.numeroOs">{{ html.numeroOs }}</span></div>
        <div id="toast-dialog" class="mdl-js-snackbar mdl-snackbar">
            <div class="mdl-snackbar__text"></div>
            <button class="mdl-snackbar__action" type="button"></button>
        </div>
    </div>
</div>
<div id="toast-content" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button"></button>
</div>
<script>
</script>