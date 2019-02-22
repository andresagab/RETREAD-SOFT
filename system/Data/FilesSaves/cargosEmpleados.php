<?php
?>
<div class="col-md-12">
	<div class="col-md-12" id="paddinTop30"></div>
	<div class="col-md-4" ></div>
	<div class="col-md-4" >
            <strong class="text text-success control-label"><h2>Cargos Empleado</h2></strong>
	</div>
	<div class="col-md-4" ></div>
        <div class="row col-md-12" id="paddinTop20"></div>
        <div class="row col-md-12">
            <div class="col-md-1"></div>
            <div class="col-md-2">
                <div class="form-group-sm">
                    <a href="#/adicionarCargo"><button class="btn btn-primary">Adicionar</button></a>
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-4">
                <div class="col-md-12 form-group-sm">
                    <input class="col-md-12 form-control" id="buscar" name="buscar" placeholder="Buscar por: Nombre o Descripcion" ng-model="buscar">
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
	<div class="row col-md-12" id="paddinTop20">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <table class="table table-hover table-responsive table-striped">
                    <tr class="active">
                        <th>Nombre</th><th>Descripcion</th><th>Acciones</th>
                    </tr>
                    <tr ng-repeat='cargoEmpleado in cargosEmpleado | filter: buscar'>
                        <td>{{ cargoEmpleado.nombre }}</td>
                        <td>{{ cargoEmpleado.descripcion }}</td>
                        <td>
                            <h4><span class="glyphicon glyphicon-refresh"></span></h4>
                            <h4><a href='/#eliminar{{ cargoEmpleado.id }}' title='Eliminar' data-toggle='modal'><span class="glyphicon glyphicon-remove-circle"></span></a></h4>
                        </td>
                    </tr>
                </table>
                <div ng-repeat="cargoEmpleado in cargosEmpleado | filter: buscar">
                    <div class='modal fade' id='eliminar{{ cargoEmpleado.id }}'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                    ¿Est&aacute; seguro que desea eliminar el cargo {{ cargoEmpleado.nombre }}?
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-danger' data-dismiss='modal' >Cancelar</button>
                                    <a href=''><button type='button' class='btn btn-success' >Aceptar</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
	</div>
</div>