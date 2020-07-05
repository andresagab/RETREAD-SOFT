<?php
if (strtolower($USUARIO->getRol()->getNombre())!='asesor') {
    ?>
    <script src="lib/factorys/Llantas.js"></script>
    <script src="lib/controladores/llantas.js"></script>
    <div ng-controller="llantas">
        <input type="hidden" id="txtNumberProcess" value="0">
        <div class="col-sm-12 col-md-3 col-lg-3 text-center">
            <button class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab btn-info" id="btnAyuda" type="button" href="/#_helpDialog" data-toggle='modal'>
                <i class="material-icons">help</i>
            </button>
            <div class="mdl-tooltip" for="btnAyuda">Ver Ayuda</div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6 text-center">
            <h3 class="text-uppercase mdl-color-text--blue">{{ llantas.page.name }}</h3>
        </div>
        <div class="col-sm-12 col-md-3 col-lg-3 text-center">
            <button class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab btn-success" type="button" id="btnCargarListado" ng-click="loadData();">
                <i class="material-icons">sync</i>
            </button>
            <div class="mdl-tooltip" data-mdl-for="btnCargarListado">Recargar listado</div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" id="paddinTop20" ng-show="llantas.page.loadSpinner">
            <div class="mdl-spinner mdl-js-spinner is-active"></div>
        </div>
        <!--  BUSCADOR  -->
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            <div class="form-group-sm">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" id="buscar" name="buscar" ng-model="buscar">
                    <span class="mdl-textfield__label" for="buscar"><span class="fa fa-search"></span> Buscar por número de RP u Orden de servicio.</span>
                </div>
                <!--BUTTON SEARCH-->
                <button class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab btn-warning" type="button" id="btnDirectSearch" ng-click="directSearch(buscar);">
                    <i class="material-icons">search</i>
                </button>
                <div class="mdl-tooltip" data-mdl-for="btnDirectSearch">Busqueda directa</div>
                <!--END BUTTON SEARCH-->
            </div>
        </div>
        <!--  END BUSCADOR  -->
        <!--  PAGINATOR  -->
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="paddinTop20"></div>
        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
            <span class="text text-muted">{{ elementsPaginator.initialRecord }} - {{ elementsPaginator.finalRecord }} de {{ elementsPaginator.totalRecords }}</span>
        </div>
        <div class="visible-xs col-xs-12" style="margin-top: 10px"></div>
        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
            <button class="mdl-button mdl-js-button mdl-button--icon" id="paginaAnterior" ng-click="setCurrentPage(false)" ng-disabled="elementsPaginator.previousPage">
                <i class="fa fa-angle-left"></i>
            </button>
            <button class="mdl-button mdl-js-button mdl-button--icon" id="paginaSiguiente" ng-click="setCurrentPage(true)" ng-disabled="elementsPaginator.nextPage">
                <i class="fa fa-angle-right"></i>
            </button>
            <button id="btnLstCantidad" class="mdl-button mdl-js-button mdl-button--icon">
                <i class="fa fa-angle-down"></i>
            </button>
            <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="btnLstCantidad">
                <li disabled class="mdl-menu__item mdl-menu__item--full-bleed-divider">
                    Registros por pagina: <span class="mdl-badge" data-badge="{{ elementsPaginator.recordsForPage }}"></span>
                </li>
                <li class="mdl-menu__item" ng-repeat="x in elementsPaginator.availableRecordsForPage" ng-click="setRecordsPage(x)">
                    {{ x }}
                </li>
            </ul>
            <div class="mdl-tooltip" ng-hide="elementsPaginator.previousPage" for="paginaAnterior">Pagina anterior {{ elementsPaginator.currentPage-1 }}</div>
            <div class="mdl-tooltip" ng-hide="elementsPaginator.nextPage" for="paginaSiguiente">Pagina siguiente {{ elementsPaginator.currentPage+1 }}</div>
            <div class="mdl-tooltip" for="btnLstCantidad">Cambiar cantidad de registros por pagina</div>
        </div>
        <div class="visible-xs visible-sm col-xs-12 col-sm-12" style="margin-top: 10px"></div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <!--<span class="text text-muted mdl-badge" data-badge="{{ values.paginaActual }}">Pagina</span>-->
            <span class="text text-muted">Pagina: {{ elementsPaginator.currentPage }}</span>
        </div>
        <!--  END PAGINATOR  -->
        <!--  TABLE  -->
        <div class="col-sm-12 col-md-12 col-lg-12 table-responsive">
            <center class="" id="paddinTop10">
                <table class="mdl-data-table mdl-js-data-table table-responsive">
                    <thead>
                    <tr class="text-uppercase">
                        <th ng-click="ordenar='rp'">RP</th>
                        <th ng-click="ordenar='os'">OS</th>
                        <th ng-click="ordenar='serie'">Serie</th>
                        <th class="mdl-data-table__cell--non-numeric" ng-click="ordenar='nombremarca'">Marca</th>
                        <th class="mdl-data-table__cell--non-numeric" ng-click="ordenar='nombregravado'">Gravado</th>
                        <th class="mdl-data-table__cell--non-numeric" ng-click="ordenar='referenciaoriginal'">Diseño original</th>
                        <th class="mdl-data-table__cell--non-numeric" ng-click="ordenar='dimension'">Dimension</th>
                        <th class="mdl-data-table__cell--non-numeric" ng-click="ordenar='referenciasolicitada'">Diseño solicitado</th>
                        <th class="mdl-data-table__cell--non-numeric" ng-click="ordenar='procesoNameStatus'">Estado</th>
    <!--                    <th class="mdl-data-table__cell--non-numeric" ng-click="ordenar='nombreUrgente'">Urgente</th>-->
                        <th class="mdl-data-table__cell--non-numeric" ng-click="ordenar='fecharegistrollanta'">Fecha registro</th>
                        <th class="mdl-data-table__cell--non-numeric">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat="objeto in llantas.data.objects | filter: buscar | orderBy: ordenar | limitTo: elementsPaginator.recordsForPage : elementsPaginator.initialRecord-1 as result" ng-show="llantas" style="background: {{ objeto.colorStatus }};">
                        <td>
                            <h4>{{ objeto.rp }}</h4>
                        </td>
                        <td>{{ objeto.os }}</td>
                        <td>{{ objeto.serie }}</td>
                        <td class="mdl-data-table__cell--non-numeric">{{ objeto.nombremarca }}</td>
                        <td class="mdl-data-table__cell--non-numeric">{{ objeto.nombregravado }}</td>
                        <td class="mdl-data-table__cell--non-numeric">{{ objeto.referenciaoriginal }}</td>
                        <td class="mdl-data-table__cell--non-numeric">{{ objeto.dimension }}</td>
                        <td class="mdl-data-table__cell--non-numeric">{{ objeto.referenciasolicitada }}</td>
                        <td class="mdl-data-table__cell--non-numeric">{{ objeto.procesoNameStatus }}</td>
    <!--                    <td class="mdl-data-table__cell--non-numeric" style="background: {{ objeto.colorUrgente }}">{{ objeto.nombreUrgente }}</td>-->
                        <td class="mdl-data-table__cell--non-numeric">{{ objeto.fecharegistrollanta }}</td>
                        <td class="mdl-data-table__cell--non-numeric">
                            <span>
                                <a href="principal.php?CON=system/Pages/inspeccionInicialFormulario.php&id={{ objeto.id }}" id="btnProcesoReencauche_{{ objeto.id }}" title="Registrar inspección inicial">
                                    <span class="material-icons">airplay</span>
                                </a>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="11" ng-show="result<=0">No se econtraron resultados</td>
                    </tr>
                    </tbody>
                </table>
            </center>
        </div>
        <!--  END TABLE  -->
    </div>
    <!-- HELP DIALOG -->
    <div class='modal fade' id='_helpDialog'>
        <div class='modal-dialog modal-lg'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' id="btnCerrarDialogFormularioLlanta_A" data-dismiss='modal'>&times;</button>
                    <h3 class="text text-primary">AYUDA</h3>
                </div>
                <div class="modal-header">
                    <div class="col-sm-12 col-lg-12">
                        <h3>SIGNIFICADO DE COLORES</h3>
                    </div>
                    <div class="text-justify">
                        <div class="col-sm-12 col-lg-12">
                            <div class="col-sm-12 col-lg-12">
                                <span class="mdl-chip mdl-chip--contact">
                                    <span class="mdl-chip__contact mdl-color--white mdl-color-text--black">1</span>
                                    <span class="mdl-chip__text">La llanta no registra proceso de inspección inicial</span>
                                </span>
                            </div>
                            <div class="col-sm-12 col-lg-12">
                                <span class="mdl-chip mdl-chip--contact">
                                    <span class="mdl-chip__contact mdl-color--orange-400 mdl-color-text--white">2</span>
                                    <span class="mdl-chip__text">La llanta ya inicio proceso de inspección inicial, pero esta a la espera de la habilitación del formulario de registro</span>
                                </span>
                            </div>
                            <div class="col-sm-12 col-lg-12">
                                <span class="mdl-chip mdl-chip--contact">
                                    <span class="mdl-chip__contact mdl-color--yellow-400 mdl-color-text--black">3</span>
                                    <span class="mdl-chip__text">El formulario de registro correspondiente a la inspección inicial ya esta disponible.</span>
                                </span>
                            </div>
                            <div class="col-sm-12 col-lg-12">
                                <span class="mdl-chip mdl-chip--contact">
                                    <span class="mdl-chip__contact mdl-color--green-500 mdl-color-text--white">4</span>
                                    <span class="mdl-chip__text">El proceso de inspección inicial fue registrado con exito</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-danger' data-dismiss='modal'>Cerrar</button>
                </div>
            </div>
        </div>
        <!--TOOLTIPS-->
        <div class="mdl-tooltip" data-mdl-for="btnCerrarDialogFormularioLlanta_A">Cerrar</div>
        <!--FIN TOOLTIPS-->
        <!--------------------------------------------------------------------->
    </div>
    <!-- END HELP DIALOG -->
    <?php
} else header("Location: principal.php?CON=system/pages/accesoDenegado.php");
?>
