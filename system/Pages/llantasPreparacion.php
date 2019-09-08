<?php
/*VALIDACION DE PERMISOS PARA USUARIOS*/
$allowed = false;
if (strpos(__FILE__, 'php', 0) > -1) {
    $currentFileName = explode('\\', __FILE__)[count(explode('\\', __FILE__))-1];
    $optionMenu = Opcion::getListaEnObjetos("idmenu is not null and ruta like '%$currentFileName'", "limit 1")[0];
    $rolesAsociados = $optionMenu->getRolesAsociados();
    for ($i = 0; $i < count($rolesAsociados); $i++)
        if ($rolesAsociados[$i] == $USUARIO->getRol()->getId()) {
            $allowed = true;
            break;
        }
}
//NEXT LINE COMMENT SINCE 2019/07/29
//if (strtolower($USUARIO->getRol()->getNombre())!='asesor') {
if ($allowed) {
    ?>
    <!--RESOURCES-->
    <script src="lib/factorys/Llantas.js"></script>
    <script src="lib/controladores/llantasProcesoRencauche.js"></script>
    <!--END RESOURCES-->
    <!--PANEL DATA-->
    <div ng-controller="llantasProcesoRencauche">
        <!--LOADED DATA-->
        <input type="hidden" id="txtNumberProcess" value="2">
        <!--END LOADED DATA-->
        <!--HEADER PAGE-->
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
            <div class="mdl-tooltip" data-mdl-for="btnCargarListado">Recargar registros</div>
        </div>
        <!--END HEADER PAGE-->
        <!--SPINNER LOADER-->
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" id="paddinTop20" ng-show="llantas.page.loadSpinner">
            <div class="mdl-spinner mdl-js-spinner is-active"></div>
        </div>
        <!--END SPINNER LOADER-->
        <!--  BUSCADOR  -->
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            <div class="form-group-sm">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" id="buscar" name="buscar" ng-model="buscar">
                    <span class="mdl-textfield__label" for="buscar"><span class="fa fa-search"></span> Buscar entre el registro {{ elementsPaginator.initialRecord }} y {{ elementsPaginator.finalRecord }}</span>
                </div>
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
            <span class="text text-muted">Pagina: {{ elementsPaginator.currentPage }}</span>
        </div>
        <!--  END PAGINATOR  -->
        <!--  TABLE  -->
        <div class="col-sm-12 col-md-12 col-lg-12 table-responsive">
            <center class="" id="paddinTop10">
                <table class="mdl-data-table mdl-js-data-table table-responsive">
                    <thead>
                    <tr class="text-uppercase">
                        <th ng-click="llantas.data.order.field='rp';llantas.data.order.reverse = !llantas.data.order.reverse">RP</th>
                        <th ng-click="llantas.data.order.field='os';llantas.data.order.reverse = !llantas.data.order.reverse">OS</th>
                        <th ng-click="llantas.data.order.field='serie';llantas.data.order.reverse = !llantas.data.order.reverse">Serie</th>
                        <th class="mdl-data-table__cell--non-numeric" ng-click="llantas.data.order.field='nombremarca';llantas.data.order.reverse = !llantas.data.order.reverse">Marca</th>
                        <th class="mdl-data-table__cell--non-numeric" ng-click="llantas.data.order.field='nombregravado';llantas.data.order.reverse = !llantas.data.order.reverse">Gravado</th>
                        <th class="mdl-data-table__cell--non-numeric" ng-click="llantas.data.order.field='referenciaoriginal';llantas.data.order.reverse = !llantas.data.order.reverse">Diseño original</th>
                        <th class="mdl-data-table__cell--non-numeric" ng-click="llantas.data.order.field='dimension';llantas.data.order.reverse = !llantas.data.order.reverse">Dimension</th>
                        <th class="mdl-data-table__cell--non-numeric" ng-click="llantas.data.order.field='referenciasolicitada';llantas.data.order.reverse = !llantas.data.order.reverse">Diseño solicitado</th>
                        <th class="mdl-data-table__cell--non-numeric" ng-click="llantas.data.order.field='procesoNameStatus';llantas.data.order.reverse = !llantas.data.order.reverse">Estado</th>
                        <th class="mdl-data-table__cell--non-numeric" ng-click="llantas.data.order.field='fecharegistrollanta';llantas.data.order.reverse = !llantas.data.order.reverse">Fecha registro</th>
                        <th class="mdl-data-table__cell--non-numeric">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat="objeto in llantas.data.objects | filter: buscar | orderBy: llantas.data.order.field : llantas.data.order.reverse | limitTo: elementsPaginator.recordsForPage : elementsPaginator.initialRecord-1 as result" ng-show="llantas" style="background: {{ objeto.colorStatus }};">
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
                        <td class="mdl-data-table__cell--non-numeric">{{ objeto.fecharegistrollanta }}</td>
                        <td class="mdl-data-table__cell--non-numeric">
                            <span>
                                <!--<a href="principal.php?CON=system/Pages/raspadoFormulario.php&id={{ objeto.id }}" id="btnProcesoReencauche_{{ objeto.id }}" title="Registrar raspado">-->
                                <!--<a ng-click="openFrm(objeto.id);" id="btnProcesoReencauche_{{ objeto.id }}" title="Gestionar {{ llantas.page.procces }}">
                                    <span class="material-icons">airplay</span>
                                </a>-->
                                <button class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-js-ripple-effect mdl-color--blue-400 mdl-color-text--white" id="btnFrmProcces_{{ objeto.id }}" type="button" ng-click="openFrm(objeto.id);" title="Gestionar {{ llantas.page.procces }}">
                                    <span class="material-icons">airplay</span>
                                </button>
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
                                    <span class="mdl-chip__text">La llanta no registra proceso de {{ llantas.page.procces }}</span>
                                </span>
                                </div>
                                <div class="col-sm-12 col-lg-12">
                                <span class="mdl-chip mdl-chip--contact">
                                    <span class="mdl-chip__contact mdl-color--orange-400 mdl-color-text--white">2</span>
                                    <span class="mdl-chip__text">La llanta ya inicio proceso de {{ llantas.page.procces }}, pero esta a la espera de la habilitación del formulario de registro</span>
                                </span>
                                </div>
                                <div class="col-sm-12 col-lg-12">
                                <span class="mdl-chip mdl-chip--contact">
                                    <span class="mdl-chip__contact mdl-color--yellow-400 mdl-color-text--black">3</span>
                                    <span class="mdl-chip__text">El formulario de registro correspondiente al proceso de {{ llantas.page.procces }} ya esta disponible.</span>
                                </span>
                                </div>
                                <div class="col-sm-12 col-lg-12">
                                <span class="mdl-chip mdl-chip--contact">
                                    <span class="mdl-chip__contact mdl-color--green-500 mdl-color-text--white">4</span>
                                    <span class="mdl-chip__text">El proceso de {{ llantas.page.procces }} fue registrado con exito</span>
                                </span>
                                </div>
                                <div class="col-sm-12 col-lg-12" id="paddinTop20">
                                    <div class="alert alert-info">
                                        <span class="text-uppercase">NOTA: </span><span class="text-muted">Los registros se actualizan cada 30 minutos.</span>
                                    </div>
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
    </div>
    <!--END PANEL DATA-->
    <?php
} else header("Location: principal.php?CON=system/pages/accesoDenegado.php");
?>
