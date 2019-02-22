<?php
?>
<script src="lib/controladores/presentacionesProducto.js"></script>
<div class="col-md-12" ng-controller="presentacionesProducto">
        <div class="col-lg-12 hidden" id="cargarLista" ng-click="cargarLista()"></div>
	<div class="col-md-4" ></div>
	<div class="col-md-4" >
            <strong class="mdl-color-text--blue text-uppercase"><h2>Presentaciones de producto</h2></strong>
	</div>
	<div class="col-md-4" ></div>
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
                    <input class="col-md-12 form-control" id="buscar" name="buscar" placeholder="Buscar por: Nombre o Descripcion" ng-model="buscar">
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-2">
                <button class="btn btn-success" type="button" id="cargarLista" ng-click="cargarLista()">Actualizar lista</button>
            </div>
            <div class="col-md-1"></div>
        </div>
        <div class="row col-md-12" id="paddinTop20" ng-show="objetos">
            <center>
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class="table-responsive">
                        <table class="mdl-data-table mdl-js-data-table">
                            <thead class="text text-uppercase">
                                <tr class="active">
                                    <th class="mdl-data-table__cell--non-numeric" ng-click="orden='nombre'">Nombre</th><th class="mdl-data-table__cell--non-numeric" ng-click="orden='descripcion'">Descripcion</th><th class="mdl-data-table__cell--non-numeric">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="objeto in objetos | filter: buscar | orderBy: orden">
                                    <td class="mdl-data-table__cell--non-numeric">{{ objeto.nombre }}</td>
                                    <td class="mdl-data-table__cell--non-numeric">{{ objeto.descripcion }}</td>
                                    <td class="mdl-data-table__cell--non-numeric">
                                        <h4>
                                            <a href="principal.php?CON=system/Pages/presentacionesProductoFormulario.php&id={{ objeto.id }}" title="Modificar">
                                                <span class="material-icons">edit</span>
                                            </a>
                                            <a ng-show="objeto.statusDelete" id="paddingLeft10" href='/#eliminar{{ objeto.id }}' title='Eliminar' data-toggle='modal'>
                                                <span class="material-icons mdl-color-text--red-500">delete</span>
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
                                        ¿Est&aacute; seguro que desea eliminar la presentacion {{ objeto.nombre }}?
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-danger' data-dismiss='modal' >Cancelar</button>
                                        <a href='principal.php?CON=system/Pages/presentacionesProductoActualizar.php&id={{ objeto.id }}&accion=Eliminar'><button type='button' class='btn btn-success' >Aceptar</button></a>
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
        window.location="principal.php?CON=system/Pages/presentacionesProductoFormulario.php";
    });
</script>