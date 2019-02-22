<?php
?>
<script src="lib/controladores/kardex.js"></script>
<div class="col-md-12" ng-controller="kardex">
        <div class="col-lg-12 hidden" id="cargarLista" ng-click="cargarLista()"></div>
	<div class="col-md-12" id="paddinTop30"></div>
	<div class="col-md-4" ></div>
	<div class="col-md-4" >
            <strong class="text text-success control-label"><h2>Productos</h2></strong>
	</div>
	<div class="col-md-4" ></div>
        <div class="row col-md-12" id="paddinTop20" ng-hide="objetos">
            <span class="text-info"><i class="fa fa-refresh fa-spin fa-5x primary"></i></span>
        </div>
        <div class="row col-md-12" id="paddinTop20"></div>
        <div class="row col-md-12">
            <div class="col-md-2">
                <div class="form-group-sm">
                    <!--<a href="#/adicionarCargo" data-toggle="modal"><button class="btn btn-primary">Adicionar</button></a>-->
                    <button class="btn btn-warning" type="button" id="btnAdicionar">Adicionar</button>
                </div>
            </div>
            <div class="col-md-8">
                <div class="col-md-12 form-group-sm">
                    <input class="col-md-12 form-control" id="buscar" name="buscar" placeholder="Buscar: Codigo, nombre, presentacion, unidadMedida, cliente, stock, stockMinimo, stockMaximo, nombreFoto o fechaRegistro" ng-model="buscar">
                </div>
            </div>
            <div class="col-md-2">
                <button class="btn btn-success" type="button" id="cargarLista" ng-click="cargarLista()">Actualizar lista</button>
            </div>
        </div>
        <div class="row col-md-12" id="paddinTop20" ng-show="objetos"
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <tr class="active">
                            <th ng-click="orden='codPuc'">Codigo</th>
                            <th ng-click="orden='nombrePuc'">Nombre</th>
                            <th ng-click="orden='nombrePresentacion'">Presentacion</th>
                            <th ng-click="orden='siglaUnidadMedida'">U.medida</th>
                            <th ng-click="orden='nombresPersona'">Cliente</th>
                            <th ng-click="orden='stock'">Stock</th>
                            <th ng-click="orden='stockMinimo'">Stock.Min</th>
                            <th ng-click="orden='stockMaximo'">Stock.Max</th>
                            <!--<th ng-click="orden='costo'">Costo</th>-->
                            <th ng-click="orden='fechaRegistro'">Fecha Registro</th>
                            <th>Acciones</th>
                        </tr>
                        <tr ng-repeat="objeto in objetos | filter: buscar | orderBy: orden">
                            <td>{{ objeto.codPuc }}</td>
                            <td>{{ objeto.nombrePuc }}</td>
                            <td>{{ objeto.nombrePresentacion }}</td>
                            <td>{{ objeto.siglaUnidadMedida }}</td>
                            <td>{{ objeto.nombresPersona }}</td>
                            <td>{{ objeto.stock }}</td>
                            <td>{{ objeto.stockMinimo }}</td>
                            <td>{{ objeto.stockMaximo }}</td>
                            <!--<td>{{ objeto.costo }}</td>-->
                            <td>{{ objeto.fechaRegistro }}</td>
                            <td>
                                <h4><a href="principal.php?CON=system/Pages/kardexFormulario.php&id={{ objeto.id }}" title="Modificar"><span class="glyphicon glyphicon-refresh"></span></a>
                                <a id="paddingLeft10" href='/#eliminar{{ objeto.id }}' title='Eliminar' data-toggle='modal'><span class="text-danger glyphicon glyphicon-remove-circle"></span></a></h4>
                            </td>
                        </tr>
                    </table>
                </div>
                <div ng-repeat="objeto in objetos | filter: buscar">
                    <div class='modal fade' id='eliminar{{ objeto.id }}'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                    ¿Est&aacute; seguro que desea eliminar el producto {{ objeto.nombrePuc }} ({{ objeto.codPuc }})?
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-danger' data-dismiss='modal' >Cancelar</button>
                                    <a href='principal.php?CON=system/Pages/kardexActualizar.php&id={{ objeto.id }}&accion=Eliminar'><button type='button' class='btn btn-success' >Aceptar</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
	</div>
</div>
<script>
    $(document).ready(function(){
        $("cargarLista").click();
    });
    
    $("#btnAdicionar").click(function (){
        window.location="principal.php?CON=system/Pages/kardexFormulario.php";
    });
</script>