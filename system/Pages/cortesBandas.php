<?php
require_once dirname(__FILE__) . "/../Clases/Producto.php";
require_once dirname(__FILE__) . "/../Clases/Puc.php";
require_once dirname(__FILE__) . "/../Clases/Gravado_Llanta.php";
require_once dirname(__FILE__) . "/../Clases/Puesto_Trabajo.php";
if ($USUARIO->getRol()->getNombre()!='operario') {
?>
    <div ng-controller="usosInsumosCortesBandas">
        <div ng-controller="cortesBandas">
            <div class="col-md-12 text text-primary">
                <h3>CORTES DE BANDA</h3>
            </div>
            <div class="col-md-12 text-center" ng-show="page.spinnerCarga" style="padding: 5px">
                <div class="mdl-spinner mdl-js-spinner is-active"></div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top: 20px">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center">
                </div>
                <div class="visible-xs visible-sm col-xs-12 col-sm-12" style="margin-top: 15px"></div>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center">
                    <div class="form-group-sm">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" id="buscar" name="buscar" ng-model="buscar">
                            <span class="mdl-textfield__label" for="buscar"><span class="fa fa-search"></span> Buscar entre el registro {{ component.pagination.current_page * component.pagination.records_per_page - (component.pagination.records_per_page - 1) }} y {{ component.pagination.current_page * component.pagination.records_per_page }}</span>
                        </div>
                    </div>
                </div>
                <div class="visible-xs visible-sm col-xs-12 col-sm-12" style="margin-top: 15px"></div>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center">
                    <button class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab btn-success" type="button" id="btnCargarListado" ng-click="loadData(0)">
                        <i class="fa fa-refresh"></i>
                    </button>
                    <div class="mdl-tooltip" data-mdl-for="btnCargarListado">Recargar listado de la página {{ component.pagination.current_page }}</div>
                    <button class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab btn-info hide" id="btnAyuda" type="button" href="/#_DialogoAyuda" data-toggle='modal'>
                        <i class="fa fa-question-circle"></i>
                    </button>
                    <div class="mdl-tooltip" for="btnAyuda">Ver Ayuda</div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="paddinTop20"></div>
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                <span class="text text-muted">{{ component.pagination.current_page * component.pagination.records_per_page - (component.pagination.records_per_page - 1) }} - {{ component.pagination.current_page * component.pagination.records_per_page }} de {{ component.pagination.max_records }}</span>
            </div>
            <div class="visible-xs col-xs-12" style="margin-top: 10px"></div>
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                <!-- <button class="mdl-button mdl-js-button mdl-button--icon" id="paginaAnterior" ng-click="setCurrentPage(false)" ng-disabled="elementsPaginator.previousPage"> -->
                <button class="mdl-button mdl-js-button mdl-button--icon" id="paginaAnterior" ng-click="loadData(-1)" ng-disabled="component.pagination.current_page == 1">
                    <i class="fa fa-angle-left"></i>
                </button>
                <!-- <button class="mdl-button mdl-js-button mdl-button--icon" id="paginaSiguiente" ng-click="setCurrentPage(true)" ng-disabled="elementsPaginator.nextPage"> -->
                <button class="mdl-button mdl-js-button mdl-button--icon" id="paginaSiguiente" ng-click="loadData(1)" ng-disabled="component.pagination.current_page == component.pagination.total_pages">
                    <i class="fa fa-angle-right"></i>
                </button>
                <!-- records per page -->
                <button id="btnLstCantidad" class="mdl-button mdl-js-button mdl-button--icon">
                    <i class="fa fa-angle-down"></i>
                </button>
                <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="btnLstCantidad">
                    <li disabled class="mdl-menu__item mdl-menu__item--full-bleed-divider">
                        <!-- Registros por pagina: <span class="mdl-badge" data-badge="{{ elementsPaginator.recordsForPage }}"></span> -->
                        Registros por pagina: <span class="mdl-badge" data-badge="{{ component.pagination.records_per_page }}"></span>
                    </li>
                    <!-- <li class="mdl-menu__item" ng-repeat="x in elementsPaginator.availableRecordsForPage" ng-click="setRecordsPage(x)"> -->
                    <li class="mdl-menu__item" ng-repeat="x in [5, 10, 25, 50, 100, 500, 1000, 5000]" ng-click="setRecordsPerPage(x)">
                        {{ x }}
                    </li>
                </ul>
                <!-- pages -->
                <button id="btnListPages" class="mdl-button mdl-js-button mdl-button--icon">
                    <i class="fa fa-list-ol"></i>
                </button>
                <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="btnListPages">
                    <li disabled class="mdl-menu__item mdl-menu__item--full-bleed-divider">
                        <!-- Registros por pagina: <span class="mdl-badge" data-badge="{{ elementsPaginator.recordsForPage }}"></span> -->
                        Página actual: <span class="mdl-badge" data-badge="{{ component.pagination.current_page }}"></span>
                    </li>
                    <!-- <li class="mdl-menu__item" ng-repeat="x in elementsPaginator.availableRecordsForPage" ng-click="setRecordsPage(x)"> -->
                    <li class="mdl-menu__item" ng-repeat="x in component.pagination.pages" ng-click="goToPage(x)">
                        {{ x }}
                    </li>
                </ul>
                <!-- tooltips -->
                <div class="mdl-tooltip" ng-hide="component.pagination.current_page == 1" for="paginaAnterior">Pagina anterior {{ component.pagination.current_page - 1 }}</div>
                <div class="mdl-tooltip" ng-hide="component.pagination.current_page == component.pagination.total_pages" for="paginaSiguiente">Pagina siguiente {{ component.pagination.current_page + 1 }}</div>
                <div class="mdl-tooltip" for="btnLstCantidad">Cambiar cantidad de registros por pagina</div>
                <div class="mdl-tooltip" for="btnListPage">Ver lista de páginas</div>
            </div>
            <div class="visible-xs visible-sm col-xs-12 col-sm-12" style="margin-top: 10px"></div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <!--<span class="text text-muted mdl-badge" data-badge="{{ values.paginaActual }}">Pagina</span>-->
                <!-- <span class="text text-muted">Pagina: {{ elementsPaginator.currentPage }}</span> -->
                <span class="text text-muted">Pagina: {{ component.pagination.current_page }} de {{ component.pagination.total_pages }}</span>
            </div>
            <!--List-->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="paddinTop20" ng-show="page.data.objects">
                <center>
                    <div class="table-responsive">
                        <table class="mdl-data-table mdl-js-data-table">
                            <tr>
                                <th ng-click="order='os'">OS</th>
                                <th ng-click="order='rp'">RP</th>
                                <th class="mdl-data-table__cell--non-numeric">GRAVADO</th>
                                <th class="mdl-data-table__cell--non-numeric">DISE&Ntilde;O ORIGINAL</th>
                                <th class="mdl-data-table__cell--non-numeric">DISE&Ntilde;O SOLICITADO</th>
                                <th>ANCHO</th>
                                <th>LARGO</th>
                                <th>EMPATES</th>
                                <th class="mdl-data-table__cell--non-numeric">ESTADO</th>
                                <th class="mdl-data-table__cell--non-numeric">FECHA ENVIO</th>
                                <th class="mdl-data-table__cell--non-numeric" class="text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- <tr ng-repeat="object in page.data.objects | filter: buscar | orderBy: order | limitTo: elementsPaginator.recordsForPage : elementsPaginator.initialRecord-1 as result" ng-show="page.data.objects" style="background-color: {{ object.colorEstado }};"> -->
                            <tr ng-repeat="object in page.data.objects | filter: buscar | orderBy: order as result" ng-show="page.data.objects" style="background-color: {{ object.colorEstado }};">
                                <td>{{ object.os }}</td>
                                <td>{{ object.rp }}</td>
                                <td class="mdl-data-table__cell--non-numeric">{{ object.nombregravado }}</td>
                                <td class="mdl-data-table__cell--non-numeric">{{ object.referenciaoriginal }} <span class="text-muted small">({{ object.tipollantaoriginal }})</span></td>
                                <td class="mdl-data-table__cell--non-numeric">{{ object.referenciasolicitada }} <span class="text-muted small">({{ object.tipollantasolicitada }})</span></td>
                                <td>{{ object.anchobanda }}</td>
                                <td>{{ object.largobanda }}</td>
                                <td>{{ object.nombreEmpates }}</td>
                                <td class="mdl-data-table__cell--non-numeric">{{ object.nombreEstado }}</td>
                                <td class="mdl-data-table__cell--non-numeric">{{ object.fecharegistro }}</td>
                                <td class="mdl-data-table__cell--non-numeric">
                                    <h4>
                                        <a ng-show="!object.estado" class="text-success" href="/#dlgAddCorte" data-toggle="modal" title="Registrar corte de banda" ng-click="setItemPage(object);cargarProceso(object.id, 'getDataCorteBandaJSON');cargarEmpleado(<?= $USUARIO->getIdEmpleadoUsuario() ?>);setNumeroProceso(6)">
                                            <span class="material-icons">check</span>
                                        </a>
                                        <a ng-show="object.estado" class="text-primary" href="/#dlgDetails" data-toggle="modal" title="Informacion de la llanta" ng-click="setItemPage(object);">
                                            <span class="material-icons">info</span>
                                        </a>
                                    </h4>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </center>
            </div>
            <!--End List-->
            <!--Frm corte-->
            <div class="modal fade" id="dlgDetails">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button class="close" id="btnCloseDlgDetails" data-dismiss="modal">&times;</button>
                            <h3 class="text text-primary">Informacion de la llanta</h3>
                        </div>
                        <div class="modal-header">
                            <div class="col-md-12 text-left text-info">
                                <h4>Orden de servicio</h4>
                            </div>
                            <div class="text text-justify">
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <label class="text text-nowrap">Os:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.os }}</span>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <label class="text text-nowrap">Estado:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.nombreEstadoOs }}</span>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <label class="text text-nowrap">Observaciones:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.observacionesos }}</span>
                                </div>
                            </div>
                            <div class="col-md-12 text-left text-info">
                                <h4>Llanta</h4>
                            </div>
                            <div class="text text-justify">
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <label class="text text-nowrap">RP:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.rp }}</span>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <label class="text text-nowrap">Serie:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.serie }}</span>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <label class="text text-nowrap">Marca:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.nombremarca }}</span>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <label class="text text-nowrap">Gravado:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.nombregravado }}</span>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <label class="text text-nowrap">Dise&ntilde;o original:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.referenciaoriginal }} <span class="text-muted">({{ page.data.dlgCorte.item.tipollantaoriginal }})</span></span></span>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <label class="text text-nowrap">Dise&ntilde;o solicitado:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.referenciasolicitada }} <span class="text-muted">({{ page.data.dlgCorte.item.tipollantasolicitada }})</span></span></span>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <label class="text text-nowrap">Dimension:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.dimension }}</span>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <label class="text text-nowrap">Urgente:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.nombreUrgente }}</span>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <label class="text text-nowrap">Estado:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.nombreEstado }}</span>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <label class="text text-nowrap">Observaciones:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.observacionesllanta }}</span>
                                </div>
                            </div>
                            <div class="col-md-12 text-left text-info">
                                <h4>Inspeccion inicial</h4>
                            </div>
                            <div class="text text-justify">
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <label class="text text-nowrap">Numero rencauche:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.numerorencauche }}</span>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <label class="text text-nowrap">Estado:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.nombreCheckedInspeccionInicial }}</span>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <label class="text text-nowrap">Observaciones:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.observacionesinspeccioninicial }}</span>
                                </div>
                            </div>
                            <div class="col-md-12 text-left text-info">
                                <h4>Raspado</h4>
                            </div>
                            <div class="text text-justify">
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <label class="text text-nowrap">Ancho banda:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.anchobanda }}</span>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <label class="text text-nowrap">Largo banda:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.largobanda }}</span>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <label class="text text-nowrap">Retiro cinturon:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.nombreCinturon }}</span>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <label class="text text-nowrap">Cantidad cinturon:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.cinturoncantidad }}</span>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <label class="text text-nowrap">Profundidad:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.profundidad }}</span>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <label class="text text-nowrap">Radio:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.radio }}</span>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <label class="text text-nowrap">Estado:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.nombreCheckedRaspado }}</span>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <label class="text text-nowrap">Observaciones:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.observacionesraspado }}</span>
                                </div>
                            </div>
                            <div class="col-md-12 text-left text-info">
                                <h4>Preparacion</h4>
                            </div>
                            <div class="text text-justify">
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <label class="text text-nowrap">Estado:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.nombreCheckedPreparacion }}</span>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <label class="text text-nowrap">Observaciones:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.observacionespreparacion }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success" id="btnCloseDlgDetailsFooter" type="button" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="dlgAddCorte">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button class="close" id="btnCloseDlgAddCorte" data-dismiss="modal">&times;</button>
                            <h3 class="text text-primary">REGISTRAR CORTE DE BANDA</h3>
                        </div>
                        <div role="tabpanel">
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="form">
                                    <form name="frmAddCorte" novalidate ng-submit="sendCorteBanda()">
                                            <div class="modal-header">
                                                <div class="col-md-12 text-center" ng-show="page.dlgSpinnerCarga">
                                                    <div class="mdl-spinner mdl-js-spinner is-active"></div>
                                                </div>
                                                <div class="col-md-12 text-center" ng-show="html.barraCargaPrincipal">
                                                    <div class="mdl-spinner mdl-js-spinner is-active"></div>
                                                </div>
                                                <div class="col-md-12 text-left text-info">
                                                    <h4>Orden de servicio</h4>
                                                </div>
                                                <div class="text text-justify">
                                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                                        <label class="text text-nowrap">Os:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.os }}</span>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                                        <label class="text text-nowrap">Estado:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.nombreEstadoOs }}</span>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <label class="text text-nowrap">Observaciones:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.observacionesos }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 text-left text-info">
                                                    <h4>Llanta</h4>
                                                </div>
                                                <div class="text text-justify">
                                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                                        <label class="text text-nowrap">RP:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.rp }}</span>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                                        <label class="text text-nowrap">Serie:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.serie }}</span>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                                        <label class="text text-nowrap">Marca:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.nombremarca }}</span>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                                        <label class="text text-nowrap">Gravado:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.nombregravado }}</span>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                                        <label class="text text-nowrap">Dise&ntilde;o original:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.referenciaoriginal }} <span class="text-muted">({{ page.data.dlgCorte.item.tipollantaoriginal }})</span></span></span>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                                        <label class="text text-nowrap">Dise&ntilde;o solicitado:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.referenciasolicitada }} <span class="text-muted">({{ page.data.dlgCorte.item.tipollantasolicitada }})</span></span></span>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                                        <label class="text text-nowrap">Dimension:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.dimension }}</span>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                                        <label class="text text-nowrap">Urgente:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.nombreUrgente }}</span>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                                        <label class="text text-nowrap">Estado:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.nombreEstado }}</span>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <label class="text text-nowrap">Observaciones:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.observacionesllanta }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 text-left text-info">
                                                    <h4>Inspeccion inicial</h4>
                                                </div>
                                                <div class="text text-justify">
                                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                                        <label class="text text-nowrap">Numero rencauche:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.numerorencauche }}</span>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                                        <label class="text text-nowrap">Estado:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.nombreCheckedInspeccionInicial }}</span>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <label class="text text-nowrap">Observaciones:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.observacionesinspeccioninicial }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 text-left text-info">
                                                    <h4>Raspado</h4>
                                                </div>
                                                <div class="text text-justify">
                                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                                        <label class="text text-nowrap">Ancho banda:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.anchobanda }}</span>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                                        <label class="text text-nowrap">Largo banda:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.largobanda }}</span>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                                        <label class="text text-nowrap">Retiro cinturon:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.nombreCinturon }}</span>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                                        <label class="text text-nowrap">Cantidad cinturon:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.cinturoncantidad }}</span>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                                        <label class="text text-nowrap">Profundidad:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.profundidad }}</span>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                                        <label class="text text-nowrap">Radio:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.radio }}</span>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                                        <label class="text text-nowrap">Estado:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.nombreCheckedRaspado }}</span>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <label class="text text-nowrap">Observaciones:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.observacionesraspado }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 text-left text-info">
                                                    <h4>Preparacion</h4>
                                                </div>
                                                <div class="text text-justify">
                                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                                        <label class="text text-nowrap">Estado:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.nombreCheckedPreparacion }}</span>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6">
                                                        <label class="text text-nowrap">Observaciones:</label><span class="text text-muted"> {{ page.data.dlgCorte.item.observacionespreparacion }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-header">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">* Puesto de trabajo:</span>
                                                        <select ng-disabled="html.spnListaPuestosTrabajo" class="form-control has-primary input-group-sm" name="idPuestoTrabajo" id="puestoTrabajo" ng-model="html.idPuestoTrabajo" ng-change="cargarPuestoTrabajo(html.idPuestoTrabajo)"><?= Puesto_Trabajo::getDatosEnOptions("proceso=6", null, null)?></select>
                                                        <span class="input-group-btn" ng-show="html.btnPuestoTrabajo">
                                                            <!--<button class="btn btn-success" type="button" id="btnVerInsumos" href="/#verInsumosPT" data-toggle='modal'>Usar herramientas</button>-->
                                                            <button class="btn btn-success" type="button" id="btnVerInsumos" href="/#managementTools" data-toggle='tab' role="tab">Usar herramientas</button>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">* Empates:</span>
                                                        <input class="form-control form-control-sm" type="number" id="txtEmpates" name="empates" ng-model="page.data.dlgCorte.object.empates" min="0" required>
                                                    </div>
                                                    <div class="alert alert-danger" ng-show="page.data.dlgCorte.object.empates==null && frmAddCorte.$submitted">Este campo no puede estar vacio</div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-group" ng-show="page.data.dlgCorte.viewPhoto">
                                                        <div class="row">
                                                            <div class="col-sm-12 col-md-12">
                                                                <div class="thumbnail">
                                                                    <img class="card-img-top" id="imgVerTerminacion" style="height: 300px;" ng-src="{{ img.dataURL }}">
                                                                    <div class="caption">
                                                                        <button class="btn btn-warning" id="btnEliminarImgTerminacion" type="button" ng-click="deletePhoto()">Borrar</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">* Foto:</span>
                                                            <input ng-model="page.data.dlgCorte.object.foto" id="fotoCB" type="file" class="form-control btn btn-default" name="fileCB" required="" accept="image/*" onchange="angular.element(this).scope().setFoto(this.files)" uploader-model="file">
                                                        </div>
                                                        <div class="alert alert-danger text-center" ng-show="page.data.dlgCorte.object.foto==null && frmAddCorte.$submitted">Debes subir una foto que evidencie el proceso de corte de banda</div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <span class="input-group-addon">Observaciones: </span>
                                                            <textarea class="form-control form-control-sm" name="txtObservaciones" id="txtObservaciones" placeholder="Dijita algunas observaciones sobre el corete de la banda que se registrara" ng-model="page.data.dlgCorte.object.observaciones"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-danger" id="btnCancelarDlgAddCorte" type="button" data-dismiss="modal">Cancelar</button>
                                                <button class="btn btn-success" id="btnAddCorteAction" type="submit" ng-disabled="html.btnRegistrarProceso">Registrar</button>
                                            </div>
                                        </form>
                                </div>
                                <!--GESTION INSUMOS-->
                                <div role="tabpanel" class="tab-pane" id="managementTools">
                                    <div class="modal-header">
                                        <h4 class="text text-muted">GESTIONAR USOS DE INSUMOS</h4>
                                        <h5 class="text text-muted">{{ puestoTrabajo.nombre }}</h5>
                                        <div class="row col-md-12" id="paddinTop20" ng-show="html.spinnerCargaDialogo">
                                            <div class="mdl-spinner mdl-js-spinner is-active"></div>
                                        </div>
                                        <div class="row col-md-12" id="paddinTop20" ng-show="html.alertaDialogo">
                                            <div class="alert alert-{{ html.colorAlertaDialogo }}">{{ html.mjsAlertaDialogo }}</div>
                                        </div>
                                    </div>
                                    <div class="modal-header">
                                        <div role="tabpanel">
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li class="active" role="presentacion" ng-click="limpiarVariablesNovedad()">
                                                    <a href="/#lista" aria-control="" data-toggle="tab" role="tab">Herramientas</a>
                                                </li>
                                                <li role="presentacion" ng-click="limpiarUsarYTerminarInsumo()">
                                                    <a href="/#enviarNovedad" aria-control="" data-toggle="tab" role="tab">Enviar novedad</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content">
                                                <!--List-->
                                                <div role="tabpanel" class="tab-pane active" id="lista">
                                                    <div class="col-md-12 col-sm-12">
                                                        <div class="col-sm-12 col-lg-1" id="paddinTop20">
                                                            <button ng-show="html.btnRecargarInsumos" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab btn-info" id="btnRecargarListaInsumos" type="button" ng-click="cargarInsumosPuestoTrabajo(puestoTrabajo.id);">
                                                                <i class="fa fa-refresh"></i>
                                                            </button>
                                                        </div>
                                                        <div class="col-sm-12 col-lg-10">
                                                            <strong class="text text-success control-label"><h2>Insumos</h2></strong>
                                                        </div>
                                                        <div class="col-sm-12 col-lg-1 hide" id="paddinTop20">
                                                            <button ng-show="html.btnUsarVariosInsumos" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab btn-success" id="btnUsarVariosInsumos" type="button" href="/#_UsarVariosInsumos" aria-control="" data-toggle="tab" role="tab">
                                                                <i class="fa fa-check"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12" ng-show="html.noInsumo" id="paddinTop20">
                                                        <div class="alert alert-danger">No hay insumos disponibles</div>
                                                    </div>
                                                    <div class="col-lg-12" style="padding-top: 20px;">
                                                        <div class="form-group">
                                                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                                                <input class="mdl-textfield__input" id="txtSearch" name="txtSearch" ng-model="txtSearchInsumos">
                                                                <span class="mdl-textfield__label" for="txtSearch" style="display: inline-flex;">
                                                                    <span class="material-icons">search</span><span> Buscar insumos o herramientas</span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12" ng-show="insumos" id="paddinTop20">
                                                        <center>
                                                            <div class="table-responsive">
                                                                <table class="mdl-data-table mdl-js-data-table">
                                                                    <thead>
                                                                    <tr>
                                                                        <th class="mdl-data-table__cell--non-numeric" ng-click="orden='foto'">
                                                                            <span class="fa fa-camera-retro"></span>
                                                                        </th>
                                                                        <th class="mdl-data-table__cell--non-numeric" ng-click="orden='insumo[0].nombrePuc'">Insumo</th>
                                                                        <th ng-click="orden='cantidad'">Cantidad recibida</th>
                                                                        <th ng-click="orden='cantidad'">Cantidad disponible</th>
                                                                        <th class="mdl-data-table__cell--non-numeric" ng-click="orden='nombreEstado'">Estado</th>
                                                                        <th class="mdl-data-table__cell--non-numeric">Acciones</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <!--<tr ng-repeat="dato in insumos | orderBy: orden">-->
                                                                    <tr ng-repeat="dato in insumos | filter: txtSearchInsumos">
                                                                        <td class="mdl-data-table__cell--non-numeric">
                                                                            <div class="thumbnail">
                                                                                <img ng-hide="dato.insumo[0]['notImage']" class="img-responsive" style="width: 50px;" src="system/Uploads/Imgs/Productos/{{ dato.insumo[0]['foto'] }}">
                                                                                <img ng-show="dato.insumo[0]['notImage']" class="img-responsive" style="width: 50px;" src="design/pics/imagenes/not_image.jpg" data-toggle="tooltip" title="Este producto no cuenta con una imagen">
                                                                            </div>
                                                                        </td>
                                                                        <td class="mdl-data-table__cell--non-numeric">{{ dato.insumo[0].nombrePuc }}</td>
                                                                        <td>{{ dato.cantidad }}</td>
                                                                        <td>{{ dato.remainingStock }}</td>
                                                                        <td class="mdl-data-table__cell--non-numeric">{{ dato.nombreEstado }}</td>
                                                                        <td class="mdl-data-table__cell--non-numeric">
                                                                            <h4>
                                                                                <a ng-show="!getUsado(dato) && dato.remainingStock>1" href="/#usarInsumo_{{ dato.id }}" aria-control="" data-toggle="tab" rol="tab"><span class="text-success fa fa-handshake-o" title="Registrar uso"></span></a>
                                                                                <!--<a ng-show="!getUsado(dato)" id="paddingLeft10" ng-click="seleccionarInsumoUsarYTerminar(dato)" href='/#UsarYTerminarInsumo' title='Registrar uso y terminacion' aria-control="" data-toggle="tab" role="tab" ><span class="text-warning fa fa-legal"></span></a>-->
                                                                                <a ng-show="dato.btnUsar && dato.remainingStock<1" id="paddingLeft10" ng-click="seleccionarInsumoUsarYTerminar(dato)" href='/#_TerminarInsumo' title='Terminar insumo' aria-control="" data-toggle="tab" role="tab"><span class="text-danger fa fa-flag-checkered"></span></a>
                                                                            </h4>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </center>
                                                    </div>
                                                </div>
                                                <!--End List-->
                                                <!--------------------------------------------->
                                                <!--Registro de novedad-->
                                                <div role="tabpanel" class="tab-pane" id="enviarNovedad">
                                                    <div class="col-sm-12 col-lg-12" id="paddinTop10">
                                                        <div class="col-md-12 col-sm-12 table-responsive" >
                                                            <strong class="text text-success control-label"><h2>Enviar novedad</h2></strong>
                                                        </div>
                                                        <div class="row col-md-12 text-capitalize" id="paddinTop20">
                                                            <div class="col-md-1"></div>
                                                            <div class="col-md-10">
                                                                <form class="form-horizontal" name="formularioNovedad" id="formularioNovedad" ng-submit="registrarNovedad(this.formularioNovedad)">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <div class="input-group">
                                                                                <span class="input-group-addon">* Novedad:</span>
                                                                                <textarea class="form-control has-primary" name="txtNovedad" id="txtNovedad" ng-model="novedadPT.novedad" placeholder="Escribre la novedad que deseas enviar para este puesto de trabajo" rows="5"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-12 col-lg-12" ng-show="novedadPT.novedad==null && formularioNovedad.$submitted">
                                                                            <div class="alert alert-danger">Debes rellenar este campo</div>
                                                                        </div>
                                                                        <div class="form-group" id="paddinTop30">
                                                                            <div id="showNovedadEnviada" class="col-md-12">
                                                                                <input class="btn btn-info" id="btnRegistrarNovedad" type="submit" name="accion" value="Enviar">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="col-md-1"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--Fin Registro de novedad-->
                                                <!--------------------------------------------->
                                                <!--Usar insumo-->
                                                <div ng-repeat="dato in insumos" role="tabpanel" class="tab-pane" id="usarInsumo_{{ dato.id }}">
                                                    <div class="col-sm-12 col-lg-12" id="paddinTop10">
                                                        <div class="col-md-12 col-sm-12 table-responsive" >
                                                            <strong class="text text-success control-label"><h2>Usar insumo</h2></strong>
                                                        </div>
                                                        <div class="row col-md-12">
                                                            <div class="col-md-12 page-header" id="paddinTop-20">
                                                                <div class="col-sm-12 col-lg-12 table-responsive">
                                                                    <div class="thumbnail">
                                                                        <img ng-hide="dato.insumo[0]['notImage']" class="img-responsive" style="width: 150px;" src="system/Uploads/Imgs/Productos/{{ dato.insumo[0]['foto'] }}">
                                                                        <img ng-show="dato.insumo[0]['notImage']" class="img-responsive" style="width: 150px;" src="design/pics/imagenes/not_image.jpg" data-toggle="tooltip" title="Este producto no cuenta con una imagen">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-6 text-justify">
                                                                    <label class="text-nowrap text-uppercase">Insumo: </label><span class="text text-muted"> {{ dato.insumo[0].nombrePuc }}</span>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-6 text-justify">
                                                                    <label class="text-nowrap text-uppercase">Presentacion: </label><span class="text text-muted"> {{ dato.insumo[0].nombrePresentacion }}</span>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-6 text-justify">
                                                                    <label class="text-nowrap text-uppercase">Unidad medida: </label><span class="text text-muted"> {{ dato.insumo[0].nombreUnidadMedida }}</span>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-6 text-justify">
                                                                    <label class="text-nowrap text-uppercase">Proveedor: </label><span class="text text-muted"> {{ dato.insumo[0].nombreProveedor }}</span>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-6 text-justify">
                                                                    <label class="text-nowrap text-uppercase">Cantidad asignada: </label><span class="text text-muted"> {{ dato.cantidad }}</span>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-6 text-justify">
                                                                    <label class="text-nowrap text-uppercase">Cantidad disponible: </label><span class="text text-muted"> {{ dato.remainingStock }}</span>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-12 text-justify" style="padding-top: 10px">
                                                                    <!--<label class="text-nowrap text-uppercase hide">Cantidad usada: </label><span class="text text-muted"> {{ dato.cantidad }}</span>-->
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <span class="input-group-addon">* Peso banda (<span class="text-muted small">Cantidad usada</span>): </span>
                                                                            <input class="form-control" id="stockUsed" name="txtStockUsed" ng-model="dato.stockUsed" type="number" step="any">
                                                                        </div>
                                                                        <div class="alert alert-danger" ng-show="dato.stockUsed==null">Este campo no puede estar vacio</div>
                                                                        <div class="alert alert-danger" ng-show="dato.stockUsed==0">La cantidad usada debe ser superior a cero</div>
                                                                        <div class="alert alert-danger" ng-show="dato.stockUsed>dato.remainingStock">No puedes usar una cantidad superior a la disponible</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-lg-12 text-center" id="paddinTop10">
                                                                <label class="text text-nowrap text-uppercase">Esta seguro de usar este insumo?</label>
                                                            </div>
                                                            <div class="col-sm-12 col-lg-12" id="paddinTop20">
                                                                <div class="col-md-12">
                                                                    <button id="btnRegresarLista" class="btn btn-default" type="button" href="/#lista" aria-control="" data-toggle="tab" role="tab">Regresar a los insumos</button>
                                                                    <!--<button class="btn btn-info" id="btnUsarInsumo" type="button" name="accion" ng-click="usarInsumo(dato.id, dato.stockUsed, true)" href="/#lista" aria-control="" data-toggle="tab" role="tab">Usar</button>-->
                                                                    <button ng-disabled="dato.stockUsed==null || dato.stockUsed==0 || dato.stockUsed>dato.remainingStock" class="btn btn-info" id="btnUsarInsumo" type="button" name="accion" ng-click="usarInsumo(dato.id, dato.stockUsed, true)" href="/#lista" aria-control="" data-toggle="tab" role="tab">Usar</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--Fin usar insumo-->
                                                <!--------------------------------------------->
                                                <!--Usar y Terminar insumo-->
                                                <div role="tabpanel" class="tab-pane" id="UsarYTerminarInsumo">
                                                    <div class="col-sm-12 col-lg-12" id="paddinTop10">
                                                        <div class="col-md-12 col-sm-12 table-responsive" >
                                                            <strong class="text text-success control-label"><h2>Usar y terminar insumo</h2></strong>
                                                        </div>
                                                        <form name="frmUsarYTerminar" id="frmUsarYTerminar" ng-submit="UsarYTerminarInsumo(insumoUsarYTerminar.id, true)">
                                                            <div class="row col-md-12">
                                                                <div class="col-sm-12 col-lg-12 page-header" id="paddinTop-20">
                                                                    <div class="col-sm-12 col-lg-12 table-responsive">
                                                                        <div class="thumbnail">
                                                                            <img ng-hide="insumoUsarYTerminar.insumo[0].notImage" class="img-responsive" style="width: 150px;" src="system/Uploads/Imgs/Productos/{{ insumoUsarYTerminar.insumo[0]['foto'] }}">
                                                                            <img ng-show="insumoUsarYTerminar.insumo[0].notImage" class="img-responsive" style="width: 150px;" src="design/pics/imagenes/not_image.jpg" data-toggle="tooltip" title="Este producto no cuenta con una imagen">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12 col-lg-6 text-justify">
                                                                        <label class="text-nowrap text-uppercase">Insumo: </label><span class="text text-muted"> {{ insumoUsarYTerminar.insumo[0].nombrePuc }}</span>
                                                                    </div>
                                                                    <div class="col-sm-12 col-lg-6 text-justify">
                                                                        <label class="text-nowrap text-uppercase">Presentacion: </label><span class="text text-muted"> {{ insumoUsarYTerminar.insumo[0].nombrePresentacion }}</span>
                                                                    </div>
                                                                    <div class="col-sm-12 col-lg-6 text-justify">
                                                                        <label class="text-nowrap text-uppercase">Unidad medida: </label><span class="text text-muted"> {{ insumoUsarYTerminar.insumo[0].nombreUnidadMedida }}</span>
                                                                    </div>
                                                                    <div class="col-sm-12 col-lg-6 text-justify">
                                                                        <label class="text-nowrap text-uppercase">Proveedor: </label><span class="text text-muted"> {{ insumoUsarYTerminar.insumo[0].nombreProveedor }}</span>
                                                                    </div>
                                                                    <div class="col-sm-12 col-lg-12 text-justify">
                                                                        <label class="text-nowrap text-uppercase">Cantidad a usar y terminar: </label><span class="text text-muted"> {{ insumoUsarYTerminar.cantidad }}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-12">
                                                                    <div class="col-sm-12 col-lg-12">
                                                                        <div class="form-group" ng-show="html.fotoTerminacion">
                                                                            <div class="row">
                                                                                <div class="col-sm-12 col-md-12">
                                                                                    <div class="thumbnail">
                                                                                        <img class="card-img-top" id="imgVerTerminacion" style="height: 300px;" ng-src="{{ thumb.dataURL }}">
                                                                                        <div class="caption">
                                                                                            <button class="btn btn-warning" id="btnEliminarImgTerminacion" type="button" ng-click="deleteImg()">Borrar</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="input-group">
                                                                                <span class="input-group-addon">Foto:</span>
                                                                                <input id="file" type="file" class="form-control btn btn-default" name="file" required="" accept="image/*" onchange="angular.element(this).scope().photoChanged(this.files)" uploader-model="file">
                                                                            </div>
                                                                        </div>
                                                                        <div class="alert alert-danger text-center" id="paddinTop10" ng-show="html.imgTerminacion=='' && frmUsarYTerminar.$submitted && html.imgTerminacion==null">Debes subir una foto que evidencie la terminacion de la herramienta</div>
                                                                        <div class="form-group">
                                                                            <div class="input-group">
                                                                                <span class="input-group-addon">Observaciones:</span>
                                                                                <!--<textarea class="form-control" id="txtObservacionesUsaryTerminarInsumo" name="txtUsarYTerminarInsumo" required="" ng-model="terminacionInsumo.observaciones" placeholder="Escribe algunas observaciones"></textarea>-->
                                                                                <textarea class="form-control" id="txtObservacionesUsaryTerminarInsumo" name="txtUsarYTerminarInsumo" ng-model="terminacionInsumo.observaciones" placeholder="Escribe algunas observaciones"></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-12 text-center" id="paddinTop10">
                                                                    <label class="text text-nowrap text-uppercase">Esta seguro de usar y terminar este insumo?</label>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-12" id="paddinTop20">
                                                                    <div class="col-md-12">
                                                                        <button id="btnRegresarLista_2" class="btn btn-default" type="button" href="/#lista" aria-control="" data-toggle="tab" role="tab" ng-click="limpiarUsarYTerminarInsumo()">Regresar</button>
                                                                        <button ng-disabled="html.btnUsarYTerminarInsumo" class="btn btn-info" id="btnUsarYTerminarInsumo" type="submit" name="accion">Aceptar</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <!--Fin usar y terminar insumo-->
                                                <!--------------------------------------------->
                                                <!--Terminar insumo-->
                                                <div role="tabpanel" class="tab-pane" id="_TerminarInsumo">
                                                    <div class="col-sm-12 col-lg-12" id="paddinTop10">
                                                        <div class="col-md-12 col-sm-12 table-responsive" >
                                                            <strong class="text text-success control-label"><h2>Terminar insumo</h2></strong>
                                                        </div>
                                                        <form name="frmTerminar" id="frmTerminar" ng-submit="UsarYTerminarInsumo(insumoUsarYTerminar.id, false)">
                                                            <div class="row col-md-12">
                                                                <div class="col-sm-12 col-lg-12 page-header" id="paddinTop-20">
                                                                    <div class="col-sm-12 col-lg-12 table-responsive">
                                                                        <div class="thumbnail">
                                                                            <img ng-hide="insumoUsarYTerminar.insumo[0].notImage" class="img-responsive" style="width: 150px;" src="system/Uploads/Imgs/Productos/{{ insumoUsarYTerminar.insumo[0]['foto'] }}">
                                                                            <img ng-show="insumoUsarYTerminar.insumo[0].notImage" class="img-responsive" style="width: 150px;" src="design/pics/imagenes/not_image.jpg" data-toggle="tooltip" title="Este producto no cuenta con una imagen">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-12 col-lg-6 text-justify">
                                                                        <label class="text-nowrap text-uppercase">Insumo: </label><span class="text text-muted"> {{ insumoUsarYTerminar.insumo[0].nombrePuc }}</span>
                                                                    </div>
                                                                    <div class="col-sm-12 col-lg-6 text-justify">
                                                                        <label class="text-nowrap text-uppercase">Presentacion: </label><span class="text text-muted"> {{ insumoUsarYTerminar.insumo[0].nombrePresentacion }}</span>
                                                                    </div>
                                                                    <div class="col-sm-12 col-lg-6 text-justify">
                                                                        <label class="text-nowrap text-uppercase">Unidad medida: </label><span class="text text-muted"> {{ insumoUsarYTerminar.insumo[0].nombreUnidadMedida }}</span>
                                                                    </div>
                                                                    <div class="col-sm-12 col-lg-6 text-justify">
                                                                        <label class="text-nowrap text-uppercase">Proveedor: </label><span class="text text-muted"> {{ insumoUsarYTerminar.insumo[0].nombreProveedor }}</span>
                                                                    </div>
                                                                    <div class="col-sm-12 col-lg-12 text-justify">
                                                                        <label class="text-nowrap text-uppercase">Cantidad a terminar: </label><span class="text text-muted"> {{ insumoUsarYTerminar.cantidad }}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-12">
                                                                    <div class="col-sm-12 col-lg-12">
                                                                        <div class="form-group" ng-show="html.fotoTerminacion">
                                                                            <div class="row">
                                                                                <div class="col-sm-12 col-md-12">
                                                                                    <div class="thumbnail">
                                                                                        <img class="card-img-top" id="imgVerTerminacion" style="height: 300px;" ng-src="{{ thumb.dataURL }}">
                                                                                        <div class="caption">
                                                                                            <button class="btn btn-warning" id="btnEliminarImgTerminacion" type="button" ng-click="deleteImg()">Borrar</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="input-group">
                                                                                <span class="input-group-addon">* Foto:</span>
                                                                                <input id="file" type="file" class="form-control btn btn-default" name="file" required="" accept="image/*" onchange="angular.element(this).scope().photoChanged(this.files)" uploader-model="file">
                                                                            </div>
                                                                        </div>
                                                                        <div class="alert alert-danger text-center" id="paddinTop10" ng-show="html.imgTerminacion=='' && frmUsarYTerminar.$submitted && html.imgTerminacion==null">Debes subir una foto que evidencie la terminacion de la herramienta</div>
                                                                        <div class="form-group">
                                                                            <div class="input-group">
                                                                                <span class="input-group-addon">* Observaciones:</span>
                                                                                <textarea class="form-control" id="txtObservacionesUsaryTerminarInsumo" name="txtUsarYTerminarInsumo" required="" ng-model="terminacionInsumo.observaciones" placeholder="Escribe algunas observaciones"></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-12 text-center" id="paddinTop10">
                                                                    <label class="text text-nowrap text-uppercase">Esta seguro terminar este insumo?</label>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-12" id="paddinTop20">
                                                                    <div class="col-md-12">
                                                                        <button id="btnRegresarLista_2" class="btn btn-default" type="button" href="/#lista" aria-control="" data-toggle="tab" role="tab" ng-click="limpiarUsarYTerminarInsumo()">Regresar</button>
                                                                        <button ng-disabled="html.btnUsarYTerminarInsumo" class="btn btn-info" id="btnUsarYTerminarInsumo" type="submit" name="accion">Aceptar</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <!--Fin terminar insumo-->
                                                <!--------------------------------------------->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button data-toggle="tab" role="tab" href="/#form" class="btn btn-success">Regresar</button>
                                    </div>
                                </div>
                                <!--END GESTION INSUMOS-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mdl-tooltip" for="btnRecargarListaInsumos">Recargar listado</div>
                <div id="toast-content" class="mdl-js-snackbar mdl-snackbar">
                    <div class="mdl-snackbar__text"></div>
                    <button class="mdl-snackbar__action" type="button"></button>
                </div>
                <div id="toast-content-dialog" class="mdl-js-snackbar mdl-snackbar">
                    <div class="mdl-snackbar__text"></div>
                    <button class="mdl-snackbar__action" type="button"></button>
                </div>
            </div>
            <!--End frm corte-->
            <!--Puesto Trabajo-->

            <!--Fin Puesto Trabajo-->
        </div>
    </div>
    <script src="lib/controladores/cortesBandas.js"></script>
    <script src="lib/controladores/usosInsumosCortesBandas.js"></script>
<?php
} else header ("Location: index.php?mjs='No tienes los permisos necesarios para acceder a esta pagina'");
