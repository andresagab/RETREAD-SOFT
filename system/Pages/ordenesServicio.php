<?php
if (strtolower($USUARIO->getRol()->getNombre())=='operario' || strtolower($USUARIO->getRol()->getNombre())=='operario cb') {
    $btnRegistrar='hide';
    $btnEliminarRegistro='hide';
}
else {
    $btnRegistrar='';
    $btnEliminarRegistro='';
}
?>
<script src="lib/controladores/ordenesServicio.js"></script>
<div class="col-md-12" ng-controller="ordenesServicio">
    <!--<div class="hidden" id="cargarLista" ng-click="cargarLista()"></div>-->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
        <strong class="text text-uppercase mdl-color-text--blue"><h2>Ordenes de servicio</h2></strong>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" id="paddinTop20" ng-show="html.spinnerCarga">
        <div class="mdl-spinner mdl-js-spinner is-active"></div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top: 20px">
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center">
            <div class="form-group-sm <?= $btnRegistrar ?>">
                <!--<a href="#/adicionarCargo" data-toggle="modal"><button class="btn btn-primary">Adicionar</button></a>-->
                <button class="btn btn-primary" type="button" id="btnAdicionar">Adicionar</button>
                <div class="mdl-tooltip" data-mdl-for="btnAdicionar">Registrar una nueva orden de servicio</div>
            </div>
        </div>
        <div class="visible-xs visible-sm col-xs-12 col-sm-12" style="margin-top: 15px"></div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center">
            <div class="form-group-sm">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" id="buscar" name="buscar" ng-model="buscar">
                    <span class="mdl-textfield__label" for="buscar"><span class="fa fa-search"></span> Buscar entre el registro {{ values.registroInicio }} y {{ values.registroFinal }}</span>
                </div>
            </div>
        </div>
        <div class="visible-xs visible-sm col-xs-12 col-sm-12" style="margin-top: 15px"></div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center">
            <button class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab btn-success" type="button" id="btnCargarListado" ng-click="cargarLista()">
                <i class="material-icons">sync</i>
            </button>
            <div class="mdl-tooltip" data-mdl-for="btnCargarListado">Recargar listado</div>
            <button class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab btn-info" id="btnAyuda" type="button" href="/#_DialogoAyuda" data-toggle='modal'>
                <i class="material-icons">help</i>
            </button>
            <div class="mdl-tooltip" for="btnAyuda">Ver Ayuda</div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="paddinTop20"></div>
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
        <span class="text text-muted">{{ values.registroInicio }} - {{ values.registroFinal }} de {{ values.totalRegistros }}</span>
    </div>
    <div class="visible-xs col-xs-12" style="margin-top: 10px"></div>
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
        <button class="mdl-button mdl-js-button mdl-button--icon" id="paginaAnterior" ng-click="setPaginaActual(false)" ng-disabled="html.prevPage">
            <i class="fa fa-angle-left"></i>
        </button>
        <button class="mdl-button mdl-js-button mdl-button--icon" id="paginaSiguiente" ng-click="setPaginaActual(true)" ng-disabled="html.nextPage">
            <i class="fa fa-angle-right"></i>
        </button>
        <button id="btnLstCantidad" class="mdl-button mdl-js-button mdl-button--icon">
            <i class="fa fa-angle-down"></i>
        </button>
        <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="btnLstCantidad">
            <li disabled class="mdl-menu__item mdl-menu__item--full-bleed-divider">
                Registros por pagina: <span class="mdl-badge" data-badge="{{ values.registrosXPagina.opcion }}"></span>
            </li>
            <li class="mdl-menu__item" ng-repeat="x in lstOpcionesRegistrosPaginas" ng-click="setRegistrosXPagina(x)">
                {{ x.opcion }}
            </li>
        </ul>
        <div class="mdl-tooltip" ng-hide="html.prevPage" for="paginaAnterior">Pagina anterior {{ values.paginaActual-1 }}</div>
        <div class="mdl-tooltip" ng-hide="html.nextPage" for="paginaSiguiente">Pagina siguiente {{ values.paginaActual+1 }}</div>
        <div class="mdl-tooltip" for="btnLstCantidad">Cambiar cantidad de registros por pagina</div>
    </div>
    <div class="visible-xs visible-sm col-xs-12 col-sm-12" style="margin-top: 10px"></div>
    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
        <!--<span class="text text-muted mdl-badge" data-badge="{{ values.paginaActual }}">Pagina</span>-->
        <span class="text text-muted">Pagina: {{ values.paginaActual }}</span>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="paddinTop20" ng-show="objetos">
        <center>
            <div class="table-responsive">
                <table class="mdl-data-table mdl-js-data-table">
                    <thead class="text text-uppercase">
                        <tr>
                            <th ng-click="orden='os'">OS</th>
                            <th class="hide" ng-click="orden='numerofactura'">N° Factura</th>
                            <th class="mdl-data-table__cell--non-numeric" ng-click="orden='nombreEmpresa'">Cliente</th>
                            <th class="mdl-data-table__cell--non-numeric" ng-click="orden='nombresCompletosEmpleado'">Vendedor</th>
                            <th ng-click="orden='numeroLlantas'">N° llantas</th>
                            <th class="mdl-data-table__cell--non-numeric" ng-click="orden='nombreEstado'">Estado</th>
                            <th class="mdl-data-table__cell--non-numeric" ng-click="orden='-fecharecoleccionos'">Fecha recoleccion</th>
                            <th class="mdl-data-table__cell--non-numeric">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="objeto in objetos | filter: buscar | orderBy: orden" style="background: {{ objeto.colorEstado }}; color: {{ objeto.colorLetraEstado }}">
                            <td>
                                <span class="text mdl-typography--font-bold" ng-dblclick="openOS(objeto.idos)">
                                    <h4>{{ objeto.os }}</h4>
                                </span>
                            </td>
                            <td class="hide">{{ objeto.numerofactura }}</td>
                            <td class="mdl-data-table__cell--non-numeric">
                                {{ objeto.nombreEmpresa }}
                                <span class="text-muted" ng-show="objeto.identificacioncliente!=null"> ({{ objeto.identificacioncliente }})</span>
                            </td>
                            <td class="mdl-data-table__cell--non-numeric">{{ objeto.nombresCompletosEmpleado }}</td>
                            <td>{{ objeto.numeroLlantas }}</td>
                            <td class="mdl-data-table__cell--non-numeric">{{ objeto.nombreEstado }}</td>
                            <td class="mdl-data-table__cell--non-numeric">{{ objeto.fecharecoleccionos }}</td>
                            <td class="mdl-data-table__cell--non-numeric">
                                <h4>
                                    <a href="principal.php?CON=system/Pages/ordenesServicioFormulario.php&id={{ objeto.idos }}" title="Abrir"><span class="material-icons">play_arrow</span></a>
                                    <a class="<?= $btnEliminarRegistro ?>" ng-show="objeto.btnEliminar" id="paddingLeft10" href='/#eliminar{{ objeto.idos }}' title='Eliminar' data-toggle='modal'><span class="text-danger material-icons">delete</span></a>
                                </h4>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div ng-repeat="objeto in objetos | filter: buscar">
                <div class='modal fade' id='eliminar{{ objeto.idos }}'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <button type='button' class='close' data-dismiss='modal' id="btnCerrarModalDialog">&times;</button>
                                <div class="mdl-tooltip" for="btnCerrarModalDialog">Cerrar</div>
                                ¿Est&aacute; seguro que desea eliminar la orden de servicio {{ objeto.os }}?
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-danger' data-dismiss='modal' >Cancelar</button>
                                <a href='principal.php?CON=system/Pages/ordenesServicioActualizar.php&id={{ objeto.idos }}&accion=Eliminar'><button type='button' class='btn btn-success' >Aceptar</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </center>
    </div>
</div>
<div class='modal fade' id='_DialogoAyuda'>
    <div class='modal-dialog'>
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
                                <span class="mdl-chip__contact mdl-color--black mdl-color-text--white">1</span>
                                <span class="mdl-chip__text">La orden de servicio fue anulada</span>
                            </span>
                        </div>
                        <div class="col-sm-12 col-lg-12">
                            <span class="mdl-chip mdl-chip--contact">
                                <span class="mdl-chip__contact mdl-color--red mdl-color-text--white">2</span>
                                <span class="mdl-chip__text">La orden de servicio no tiene llantas registradas</span>
                            </span>
                        </div>
                        <div class="col-sm-12 col-lg-12">
                            <span class="mdl-chip mdl-chip--contact">
                                <span class="mdl-chip__contact mdl-color--green mdl-color-text--white">3</span>
                                <span class="mdl-chip__text">La orden de servicio esta al 100% pero aun no ha sido cerrada</span>
                            </span>
                        </div>
                        <div class="col-sm-12 col-lg-12">
                            <span class="mdl-chip mdl-chip--contact">
                                <span class="mdl-chip__contact mdl-color--yellow mdl-color-text--white">4</span>
                                <span class="mdl-chip__text">La orden de servicio tiene llantas con proceso de rencacuche incompleto</span>
                            </span>
                        </div>
                        <div class="col-sm-12 col-lg-12">
                            <span class="mdl-chip mdl-chip--contact">
                                <span class="mdl-chip__contact mdl-color--blue mdl-color-text--white">5</span>
                                <span class="mdl-chip__text">La orden de servicio fue cerrada y completada al 100%</span>
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
<script>
    $(document).ready(function(){
        //$("#cargarLista").click();
    });
    
    $("#btnAdicionar").click(function (){
        window.location="principal.php?CON=system/Pages/ordenesServicioFormulario.php";
    });
</script>