<?php
if (strtolower($USUARIO->getRol()->getNombre())!='operario' && strtolower($USUARIO->getRol()->getNombre())!='operario cb'){
?>
    <script src="lib/controladores/categoriaProducto.js"></script>
    <div class="col-md-12" ng-controller="categoriaProducto">
            <div class="col-lg-12 hidden" id="cargarLista" ng-click="cargarLista()"></div>
        <div class="col-md-3" ></div>
        <div class="col-md-6" >
            <strong class="mdl-color-text--blue text-uppercase"><h2>Categorias de producto</h2></strong>
        </div>
        <div class="col-md-3" ></div>
            <div class="row col-md-12" id="paddinTop20" ng-hide="objetos">
                <!--<span class="text-info"><i class="fa fa-refresh fa-spin fa-5x primary"></i></span>-->
                <div class="mdl-spinner mdl-spinner--single-color mdl-js-spinner is-active"></div>
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
                    <!--<div class="col-md-12 form-group-sm">
                        <input class="col-md-12 form-control" id="buscar" name="buscar" placeholder="Buscar por: Nombre o proceso" ng-model="buscar">
                    </div>-->
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input class="mdl-textfield__input" type="text" id="buscar" name="buscar" ng-model="buscar">
                        <span class="mdl-textfield__label" for="buscar">Buscar por: Nombre o descripcion</span>
                    </div>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-2">
                    <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--mini-fab btn-success" type="button" id="cargarLista" ng-click="cargarLista()">
                        <span class="material-icons">sync</span>
                    </button>
                </div>
                <div class="col-md-1"></div>
            </div>
            <!--Listado de imagenes-->
            <div class="row col-md-12" id="paddinTop20" ng-show="objetos">
                <div class="col-md-0"></div>
                <div class="col-md-12">
                    <div class="table-responsive">
                        <div class="col-md-4" ng-repeat="objeto in objetos | filter: buscar | orderBy: orden">
                            <div class="thumbnail">
                                <div class="caption">
                                    <big class="text-primary pull-left" data-toggle="tooltip" title="{{ objeto.descripcion }}">{{ objeto.nombre }}</big>
                                    <div class="pull-right btn-group">
                                        <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="Acciones">
                                            <span class="fa fa-angle-down"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li data-toggle='tooltip' title="Abrir productos de la categoria {{ objeto.nombre }}">
                                                <a href="principal.php?CON=system/Pages/productosCategoria.php&idCategoria={{ objeto.id }}"><span class="pull-0 fa fa-eject"></span> Abrir</a>
                                            </li>
                                            <li data-toggle='tooltip' title="Editar registro">
                                                <a href="principal.php?CON=system/Pages/categoriasProductoFormulario.php&id={{ objeto.id }}"><span class="pull-0 fa fa-pencil text-success"></span> Editar</a>
                                            </li>
                                            <li ng-show="objeto.statusDelete" data-toggle="tooltip" title="Eliminar registro">
                                                <a href="/#eliminar{{ objeto.id }}" data-toggle="modal"><span class="text-danger pull-0 fa fa-remove"></span> Eliminar</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12" id="paddinTop10"></div>
                                <a href="principal.php?CON=system/Pages/productosCategoria.php&idCategoria={{ objeto.id }}">
                                    <img class="img-responsive img-rounded" style="height: 250px;" src="system/Uploads/Imgs/Categorias/{{ objeto.imagen }}"/>
                                </a>
                                <br>
                            </div>
                        </div>
                        <!--<table class="table table-hover table-striped">
                            <tr class="active">
                                <th ng-click="orden='nombre'">Nombre</th>
                                <th ng-click="orden='descripcion'">Descripcion</th>
                                <th>Acciones</th>
                            </tr>
                            <tr ng-repeat="objeto in objetos | filter: buscar | orderBy: orden">
                                <td>{{ objeto.nombre }}</td>
                                <td>{{ objeto.descripcion }}</td>
                                <td>
                                    <h4>
                                        <a href="principal.php?CON=system/Pages/categoriasProductoFormulario.php&id={{ objeto.id }}" title="Modificar registro"><span class="glyphicon glyphicon-refresh"></span></a>
                                        <a id="paddingLeft10" href='/#eliminar{{ objeto.id }}' title='Eliminar registro' data-toggle='modal'><span class="text-danger glyphicon glyphicon-remove-circle"></span></a>
                                    </h4>
                                </td>
                            </tr>
                        </table>-->
                    </div>
                    <div ng-repeat="objeto in objetos | filter: buscar">
                        <div class='modal fade' id='eliminar{{ objeto.id }}'>
                            <div class='modal-dialog'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                        ¿Est&aacute; seguro que desea eliminar la categoria <b>" {{ objeto.nombre }} "</b>?
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-danger' data-dismiss='modal' >Cancelar</button>
                                        <a href='principal.php?CON=system/Pages/categoriasProductoActualizar.php&id={{ objeto.id }}&accion=Eliminar'><button type='button' class='btn btn-success' >Aceptar</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-0"></div>
        </div>
            <!--Fin Listado de imagenes-->
    </div>
    <script>
        $(document).ready(function(){
            $("#cargarLista").click();
        });

        $("#btnAdicionar").click(function (){
            window.location="principal.php?CON=system/Pages/categoriasProductoFormulario.php";
        });
    </script>
<?php
} else header ("Location: index.php?mjs='No tienes los permisos necesarios para acceder a esta pagina'");