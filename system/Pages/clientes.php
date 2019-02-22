<script src="lib/controladores/clientes.js"></script>
<div class="col-md-12" ng-controller="clientes">
    <div class="hide" id="cargarLista" ng-click="cargarLista()"></div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
        <strong class="mdl-color-text--blue text-uppercase"><h2>Clientes</h2></strong>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" id="paddinTop20" ng-show="html.spinnerCarga">
        <div class="mdl-spinner mdl-js-spinner is-active"></div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top: 20px">
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 text-center">
            <div class="form-group-sm">
                <a href="principal.php?CON=system/Pages/clientesFormulario.php"><button class="btn btn-primary">Adicionar</button></a>
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
            <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--mini-fab btn-success" type="button" id="btnCargarLista" ng-click="cargarLista()"><span class="material-icons">sync</span></button>
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
                        <tr class="active">
                            <th ng-click="ordenar='identificacion'">Identificacion/Nit</th>
                            <th class="mdl-data-table__cell--non-numeric" ng-click="ordenar='razonSocial'">Razon social</th>
                            <th class="mdl-data-table__cell--non-numeric" ng-click="ordenar='direccion'">Direccion</th>
                            <th class="mdl-data-table__cell--non-numeric" ng-click="ordenar='nombresPersona'">Nombres</th>
                            <th class="mdl-data-table__cell--non-numeric" ng-click="ordenar='apellidosPersona'">Apellidos</th>
                            <th ng-click="ordenar='apellidosPersona'">Celular</th>
                            <th class="mdl-data-table__cell--non-numeric" ng-click="ordenar='emailPersona'">Email</th>
                            <th ng-click="ordenar='fechaRegistro'">Fecha Creacion/Nacimiento</th>
                            <th class="mdl-data-table__cell--non-numeric">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat='objeto in objetos | filter: buscar | orderBy: ordenar'>
                            <td>{{ objeto.identificacion }}</td>
                            <td class="mdl-data-table__cell--non-numeric">{{ objeto.razonSocial }}</td>
                            <td class="mdl-data-table__cell--non-numeric">{{ objeto.direccionPersona }}</td>
                            <td class="mdl-data-table__cell--non-numeric">{{ objeto.nombresPersona }}</td>
                            <td class="mdl-data-table__cell--non-numeric">{{ objeto.apellidosPersona }}</td>
                            <td>{{ objeto.celularPersona }}</td>
                            <td class="mdl-data-table__cell--non-numeric">{{ objeto.emailPersona }}</td>
                            <td>{{ objeto.fechaNacimientoPersona }}</td>
                            <td class="mdl-data-table__cell--non-numeric">
                                <h4>
                                    <a href="principal.php?CON=system/Pages/clientesFormulario.php&id={{ objeto.id }}">
                                        <span class="material-icons">edit</span>
                                    </a>
                                    <a ng-show="objeto.statusDelete" id="paddingLeft10" href='/#eliminar{{ objeto.id }}' title='Eliminar' data-toggle='modal'>
                                        <span class="text-danger material-icons">delete</span>
                                    </a>
                                    <a id="paddingLeft10" href="principal.php?CON=system/Pages/vehiculos.php&id={{ objeto.id }}" title="Gestionar vehiculos">
                                        <span class="material-icons">directions_car</span>
                                    </a>
                                </h4>
                            </td>
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
                                ¿Est&aacute; seguro que desea eliminar el cliente {{ objeto.razonSocial }} ({{ objeto.nit }})?
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-danger' data-dismiss='modal' >Cancelar</button>
                                <a href='principal.php?CON=system/Pages/clientesActualizar.php&accion=Eliminar&id={{ objeto.id }}'><button type='button' class='btn btn-success' >Aceptar</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </center>
    </div>
</div>
<script>
    $(document).ready(function(){
       $("#cargarLista").click(); 
    });
</script>