<?php
if (strtolower($USUARIO->getRol()->getNombre())=='desarrollador') {
?>
<div ng-controller="bitacoras">
    <div class="col-md-12 text text-uppercase mdl-color-text--blue">
        <h3>BITACORAS</h3>
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
                    <span class="mdl-textfield__label" for="buscar"><span class="fa fa-search"></span> Buscar entre el registro {{ elementsPaginator.initialRecord }} y {{ elementsPaginator.finalRecord }}</span>
                </div>
            </div>
        </div>
        <div class="visible-xs visible-sm col-xs-12 col-sm-12" style="margin-top: 15px"></div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center">
            <button class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab btn-success" type="button" id="btnCargarListado" ng-click="loadData()">
                <i class="material-icons">sync</i>
            </button>
            <div class="mdl-tooltip" data-mdl-for="btnCargarListado">Recargar listado</div>
            <button class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab btn-info hide" id="btnAyuda" type="button" href="/#_DialogoAyuda" data-toggle='modal'>
                <i class="fa fa-question-circle"></i>
            </button>
            <div class="mdl-tooltip" for="btnAyuda">Ver Ayuda</div>
        </div>
    </div>
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
    <!--List-->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="paddinTop20" ng-show="page.data.objects">
        <center>
            <div class="table-responsive">
                <table class="mdl-data-table mdl-js-data-table">
                    <tr>
                        <th ng-click="order='usuario'">USUARIO</th>
                        <th ng-click="order='suceso'">SUCESO</th>
                        <th ng-click="order='ip'">IP</th>
                        <th ng-click="order='fecharegistro'">FECHA REGISTRO</th>
                        <th class="hide text-center">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="object in page.data.objects | filter: buscar | orderBy: order | limitTo: elementsPaginator.recordsForPage : elementsPaginator.initialRecord-1 as result" ng-show="page.data.objects" style="background-color: {{ object.colorEstado }};">
                        <td>{{ object.usuario }}</td>
                        <td>{{ object.nameSuceso }}</td>
                        <td>{{ object.ip }}</td>
                        <td>{{ object.fecharegistro }}</td>
                        <td class="hide">
                            <h4>
                                <a ng-show="object.btnDetails" class="text-success" href="/#dlgDetails" data-toggle="modal" title="Registrar corte de banda" ng-click="">
                                    <span class="material-icons">details</span>
                                </a>
                            </h4>
                        </td>
                    </tr>
                </tbody>
            </table>
        </center>
    </div>
    <div class="modal fade" id="dlgDetails">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                    <h3>DETALLES</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="lib/controladores/bitacoras.js"></script>
<?php
} else header ("Location: index.php?mjs='No tienes los permisos necesarios para acceder a esta pagina'");
