<?php
?>
<script src="lib/controladores/dimensionesLlanta.js"></script>
<div class="col-md-12" ng-controller="dimensionesLlanta">
        <div class="col-lg-12 hidden" id="cargarLista" ng-click="cargarLista()"></div>
	<div class="col-md-3" ></div>
	<div class="col-md-6" >
            <strong class="mdl-color-text--blue text-uppercase"><h2>Dimensiones de llanta</h2></strong>
	</div>
	<div class="col-md-3" ></div>
        <div class="row col-md-12" id="paddinTop20" ng-hide="objetos">
            <div class="mdl-spinner mdl-js-spinner is-active"></div>
        </div>
        <div class="row col-md-12" id="paddinTop20"></div>
        <div class="row col-md-12">
            <div class="col-md-1"></div>
            <div class="col-md-2">
                <div class="form-group-sm">
                    <!--<a href="#/adicionarCargo" data-toggle="modal"><button class="btn btn-primary">Adicionar</button></a>-->
                    <button class="btn btn-primary" type="button" id="btnAdicionar">Adicionar</button>
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-4">
                <div class="col-md-12 form-group-sm">
                    <input class="col-md-12 form-control" id="buscar" name="buscar" placeholder="Buscar por: Ancho, Perfil, Diametro o descripcion" ng-model="buscar">
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-2">
                <button class="btn btn-success" type="button" id="cargarLista" ng-click="cargarLista()">Actualizar lista</button>
            </div>
            <div class="col-md-1"></div>
        </div><div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="paddinTop20"></div>
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
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="paddinTop20" ng-show="objetos">
        <center>
            <div class="table-responsive">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class="table-responsive">
                        <table class="mdl-data-table mdl-js-data-table">
                            <thead class="text text-uppercase">
                                <tr class="active">
                                    <th class="mdl-data-table__cell--non-numeric" ng-click="orden='medidaCompleta'">Medida</th>
                                    <th class="mdl-data-table__cell--non-numeric" ng-click="orden='descripcion'">Descripcion</th>
                                    <th class="mdl-data-table__cell--non-numeric">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="objeto in objetos | filter: buscar | orderBy: orden | limitTo: elementsPaginator.recordsForPage : elementsPaginator.initialRecord-1 as result">
                                    <td class="mdl-data-table__cell--non-numeric">{{ objeto.medidaCompleta }}</td>
                                    <td class="mdl-data-table__cell--non-numeric">{{ objeto.descripcion }}</td>
                                    <td class="mdl-data-table__cell--non-numeric">
                                        <h4>
                                            <a href="principal.php?CON=system/Pages/dimensionesLlantaFormulario.php&id={{ objeto.id }}" title="Modificar"><span class="material-icons">edit</span></a>
                                            <a ng-show="objeto.statusDelete" id="paddingLeft10" href='/#eliminar{{ objeto.id }}' title='Eliminar' data-toggle='modal'><span class="material-icons mdl-color-text--red-500">delete</span></a>
                                        </h4>
                                    </td>
                                </tr>
                                <tr ng-show="result<=0">
                                    <td colspan="3">No se encontraron resultados</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div ng-repeat="objeto in objetos | filter: buscar">
                        <div class='modal fade' id='eliminar{{ objeto.id }}'>
                            <div class='modal-dialog'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                        ¿Est&aacute; seguro que desea eliminar la medida de vehiculo {{ objeto.medidaCompleta }}?
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-danger' data-dismiss='modal' >Cancelar</button>
                                        <a href='principal.php?CON=system/Pages/dimensionesLlantaActualizar.php&id={{ objeto.id }}&accion=Eliminar'><button type='button' class='btn btn-success' >Aceptar</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1"></div>
            </center>
	</div>
</div>
<script>
    $(document).ready(function(){
        $("#cargarLista").click();
    });
    
    $("#btnAdicionar").click(function (){
        window.location="principal.php?CON=system/Pages/dimensionesLlantaFormulario.php";
    });
</script>