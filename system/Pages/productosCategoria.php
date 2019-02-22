<?php
if (strtolower($USUARIO->getRol()->getNombre())!='operario'){
?>
<script src="lib/controladores/productoCategoria.js"></script>
<div class="col-md-12" ng-controller="productoCategoria">
    <div class="hidden" id="cargarData" ng-click="cargarDatos(<?=$_GET['idCategoria']?>);cargarCategoria(<?=$_GET['idCategoria']?>);setEmpleado(<?=$USUARIO->getIdEmpleadoUsuario()?>)"></div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
        <strong class="text text-success text-uppercase"><h2>Productos de la categoria {{ categoria.nombre }}</h2></strong>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" id="paddinTop20" ng-show="html.spinnerCarga">
        <div class="mdl-spinner mdl-js-spinner is-active"></div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" style="margin-top: 20px">
        <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2 text-center">
            <div class="form-group-sm">
                <button class="btn btn-primary" type="button" id="btnAdicionar">Adicionar</button>
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-2">
            <div class="form-group-sm">
                <button class="btn btn-default" type="button" id="btnRegresar">Regresar</button>
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
            <button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--mini-fab btn-success" type="button" id="btnCargarLista" ng-click="cargarDatos(<?=$_GET['idCategoria']?>)"><span class="fa fa-refresh"></span></button>
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
                    <thead>
                        <tr class="active">
                            <th class="hide" ng-click="orden='foto'">
                                <span class="fa fa-camera-retro"></span>
                            </th>
                            <th class="mdl-data-table__cell--non-numeric" ng-click="orden='nombrepuc'">Producto</th>
                            <th class="mdl-data-table__cell--non-numeric" ng-click="orden='descripcionpuc'">Descripcion</th>
                            <th class="mdl-data-table__cell--non-numeric" ng-click="orden='nombrepresentacion'">Presentacion</th>
                            <th class="mdl-data-table__cell--non-numeric" ng-click="orden='siglaunidadmedida'">U.Medida</th>
                            <th class="mdl-data-table__cell--non-numeric" ng-click="orden='nombreproveedor'">Proveedor</th>
                            <th ng-click="orden='stock'">Stock</th>
                            <th ng-click="orden='stockminimo'">Stock Minimo</th>
                            <th ng-click="orden='stockmaximo'">Stock Maximo</th>
                            <th class="hide" ng-click="orden='peso'">Peso</th>
                            <th class="hide" ng-click="orden='costo'">Costo</th>
                            <th class="mdl-data-table__cell--non-numeric">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="objeto in objetos | filter: buscar | orderBy: orden | limitTo: values.registrosXPagina.opcion">
                            <td class="hide">
                                <div class="thumbnail">
                                    <img ng-hide="objeto.notImage" class="img-responsive" style="width: 50px;" src="system/Uploads/Imgs/Productos/{{ objeto.foto }}">
                                    <img ng-show="objeto.notImage" class="img-responsive" style="width: 50px;" src="design/pics/imagenes/not_image.jpg" data-toggle="tooltip" title="Este producto no cuenta con una imagen">
                                </div>
                            </td>
                            <td class="mdl-data-table__cell--non-numeric">{{ objeto.nombrepuc }}</td>
                            <td class="mdl-data-table__cell--non-numeric">{{ objeto.descripcionpuc }}</td>
                            <td class="mdl-data-table__cell--non-numeric">{{ objeto.nombrepresentacion }}</td>
                            <td class="mdl-data-table__cell--non-numeric">{{ objeto.siglaunidadmedida }}</td>
                            <td class="mdl-data-table__cell--non-numeric">{{ objeto.nombreProveedor }}</td>
                            <td>{{ objeto.stock }}</td>
                            <td>{{ objeto.stockminimo }}</td>
                            <td>{{ objeto.stockmaximo }}</td>
                            <td class="hide">{{ objeto.peso }}</td>
                            <td class="hide">{{ objeto.costo }}</td>
                            <td class="mdl-data-table__cell--non-numeric">
                                <h4>
                                    <a href="principal.php?CON=system/Pages/productosCategoriaFormulario.php&id={{ objeto.idproducto }}&idCategoria={{ categoria.id }}" title="Modificar">
                                        <span class="material-icons">edit</span>
                                    </a>
                                    <a ng-show="objeto.statusDelete" id="paddingLeft10" href='/#eliminar{{ objeto.idproducto }}' title='Eliminar' data-toggle='modal'>
                                        <span class="material-icons text-danger">delete</span>
                                    </a>
                                    <a href="/#frmCargarProducto" title="Cargar producto" data-toggle="modal" style="padding-left: 10px;" ng-click="setProductoCarga(objeto);">
                                        <span class="material-icons text-success">publish</span>
                                    </a>
                                </h4>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div ng-repeat="objeto in objetos | filter: buscar">
                <div class='modal fade' id='eliminar{{ objeto.idproducto }}'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                ¿Est&aacute; seguro que desea eliminar el producto <b>{{ objeto.nombrepuc }} {{ objeto.descripcionpuc }}</b>?
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-danger' data-dismiss='modal' >Cancelar</button>
                                <a href='principal.php?CON=system/Pages/productosCategoriaActualizar.php&id={{ objeto.idproducto }}&idCategoria={{ categoria.id }}&accion=Eliminar'><button type='button' class='btn btn-success' >Aceptar</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </center>
    </div>
<!--        <div class="col-sm-12 col-md-12 col-lg-12">
        <div><span class="text text-muted">Registro x Pagina </span>( {{ html.registrosPagina }} )</div><input class="form-control" type="number" ng-model="html.registrosPagina">
    </div>-->
    <div class="modal fade" id="frmCargarProducto">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" ng-click="resetFormCarga(true)">&times;</button>
                    <h3 class="mdl-color-text--blue">CARGAR PRODUCTO</h3>
                    <div class="col-sm-12 col-lg-12 text-center" ng-show="dataForm.barLoad" style="padding-bottom: 10px;">
                        <div class="col-sm-1 col-lg-2"></div>
                        <div class="col-sm-10 col-lg-8">
                            <div class="mdl-spinner mdl-js-spinner is-active"></div>
                        </div>
                        <div class="col-sm-1 col-lg-2"></div>
                    </div>
                </div>
                <form name="formCargar" ng-submit="addCarga();">
                    <div class="modal-header">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="col-sm-6 col-md-6 col-lg-12">
                                    <h4>
                                        <span>Producto: </span><span class="text-muted">{{ dataForm.producto.nombrepuc }}</span>
                                    </h4>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-12">
                                    <h4>
                                        <span>Cantidad en bodega: </span><span class="text-muted">{{ dataForm.producto.stock }}</span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Cantidad: </span>
                                    <input class="form-control has-success" type="number" step="any" ng-model="dataForm.cantidad" ng-change="validCantidad();">
                                </div>
                            </div>
                            <div class="alert alert-danger text-center" style="padding-top: 10px;" ng-show="dataForm.cantidad<=0 && formCargar.$submitted">La cantidad a cargar debe ser mayor que cero</div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Fecha de entrada: </span>
                                    <input class="form-control has-success" type="date" ng-model="dataForm.fechaRegistro" ng-change="validFechaRegistro()">
                                </div>
                            </div>
                            <div class="alert alert-danger text-center" style="padding-top: 10px;" ng-show="dataForm.fechaRegistro==null && formCargar.$submitted">Debes asignar una fecha de entrada</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnCloseFormCarga" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored mdl-color--red" data-dismiss="modal" ng-click="resetFormCarga(true);">Cancelar</button>
                        <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" ng-click="resetFormCarga(false);" style="padding-left: 5px; padding-right: 5px;">Limpiar</button>
                        <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored mdl-color--green" ng-disabled="dataForm.cantidad<=0 || dataForm.fechaRegistro==null">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
        <div id="toast-frm-dialog" class="mdl-js-snackbar mdl-snackbar">
            <div class="mdl-snackbar__text"></div>
            <button class="mdl-snackbar__action" type="button"></button>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $("#cargarData").click();
    });

    $("#btnAdicionar").click(function (){
        window.location="principal.php?CON=system/Pages/productosCategoriaFormulario.php&idCategoria=<?=$_GET['idCategoria']?>";
    });

    $("#btnRegresar").click(function (){
        window.location="principal.php?CON=system/Pages/categoriasProducto.php";
    });
</script>
<?php
} else header ("Location: index.php?mjs='No tienes los permisos necesarios para acceder a esta pagina'");