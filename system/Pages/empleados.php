<?php
if (strtolower($USUARIO->getRol()->getNombre())=='administrador' || strtolower($USUARIO->getRol()->getNombre())=='desarrollador'){
?>
<div class="col-md-12" ng-controller="empleados">
    <div class="hide" id="cargarLista" ng-click="cargarLista()"></div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
        <strong class="mdl-color-text--blue text-uppercase"><h2>Funcionarios</h2></strong>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" id="paddinTop20" ng-show="html.spinnerCarga">
        <div class="mdl-spinner mdl-js-spinner is-active"></div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top: 20px">
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center">
            <div class="form-group-sm">
                <a href="principal.php?CON=system/Pages/empleadosFormulario.php"><button class="btn btn-primary">Adicionar</button></a>
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
            <!--<button class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect mdl-button--accent" type="button" id="btnCargarLista" ng-click="cargarLista()">-->
            <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--mini-fab btn-success" type="button" id="btnCargarLista" ng-click="cargarLista()">
                <!--<span class="fa fa-refresh"></span>-->
                <span class="material-icons">sync</span>
            </button>
            <div class="mdl-tooltip" for="btnCargarLista">Recargar registros</div>
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
                        <tr class="active" data-toggle='tooltip' title="Haciendo click en el titulo de una columna podras ordenar los registros de acuerdo al nombre de la misma">
                            <th ng-click="ordenar='identificacion'" title="Click para ordenar por identificacion">Identificacion</th>
                            <th class="mdl-data-table__cell--non-numeric" ng-click="ordenar='nombres'" title="Ordenar por nombres">Nombres</th>
                            <th class="mdl-data-table__cell--non-numeric" ng-click="ordenar='apellidos'" title="Ordenar por apellidos">Apellidos</th>
                            <th class="mdl-data-table__cell--non-numeric" ng-click="ordenar='nombreCargo'" title="Ordenar por cargo">Cargo</th>
                            <th ng-click="ordenar='celular'" title="Ordenar por celular">Celular</th>
                            <!--<th ng-click="ordenar='email'" data-toggle='tooltip' title="Ordenar por email">Email</th>-->
                            <th class="mdl-data-table__cell--non-numeric" ng-click="ordenar='direccion'" title="Ordenar por direccion">Direcccion</th>
                            <th ng-click="ordenar='fechaNacimiento'" title="Ordenar por fecha de nacimiento">Fecha Nacimiento</th>
                            <th class="hide" ng-click="ordenar='fechaRegistro'" title="Ordenar por fecha de registro">Fecha Registro</th>
                            <th class="mdl-data-table__cell--non-numeric">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat='objeto in objetos | filter: buscar | orderBy: ordenar'>
                            <td>{{ objeto.identificacion }}</td>
                            <td class="mdl-data-table__cell--non-numeric">{{ objeto.nombresPersona }}</td>
                            <td class="mdl-data-table__cell--non-numeric">{{ objeto.apellidosPersona }}</td>
                            <td class="mdl-data-table__cell--non-numeric">{{ objeto.nombreCargo }}</td>
                            <td>{{ objeto.celular }}</td>
                            <td class="mdl-data-table__cell--non-numeric">{{ objeto.direccion }}</td>
                            <td>{{ objeto.fechaNacimientoPersona }}</td>
                            <td class="hide">{{ objeto.fechaRegistro }}</td>
                            <td class="mdl-data-table__cell--non-numeric">
                                <h4>
                                    <a href="principal.php?CON=system/Pages/empleadosFormulario.php&id={{ objeto.id }}">
                                        <span class="material-icons">edit</span>
                                    </a>
                                    <a ng-show="objeto.statusDelete" href='/#eliminar{{ objeto.id }}' title='Eliminar' data-toggle='modal'>
                                        <span class="text text-danger material-icons">delete</span>
                                    </a>
                                    <a href="principal.php?CON=system/Pages/usuariosPersona.php&identificacion={{ objeto.identificacion }}&id={{ objeto.id }}">
                                        <span class="material-icons text-success">person</span>
                                    </a>
                                    <a href="principal.php?CON=system/Pages/contactosPersona.php&identificacion={{ objeto.identificacion }}&id={{ objeto.id }}" title="Gestionar contactos del empleado {{ objeto.nombresCompletosPersona }}">
                                        <span class="material-icons text-warning">home</span>
                                    </a>
                                </h4>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </center>
        <div ng-repeat="objeto in objetos | filter: buscar">
            <div class='modal fade' id='eliminar{{ objeto.id }}'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                            ¿Est&aacute; seguro que desea eliminar al empleado/a {{ objeto.nombresCompletosPersona }}?
                        </div>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-danger' data-dismiss='modal' >Cancelar</button>
                            <a href='principal.php?CON=system/Pages/empleadosActualizar.php&accion=Eliminar&id={{ objeto.id }}'><button type='button' class='btn btn-success' >Aceptar</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
} else header ("Location: index.php?mjs='No tienes los permisos necesarios para acceder a esta pagina'");