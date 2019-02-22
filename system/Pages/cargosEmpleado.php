<?php
?>
<div class="col-md-12" ng-controller="cargosEmpleado">
	<div class="col-md-12" id="paddinTop30"></div>
	<div class="col-md-4" ></div>
	<div class="col-md-4" >
            <strong class="text text-success control-label"><h2>Cargos Empleado</h2></strong>
	</div>
	<div class="col-md-4" ></div>
        <div class="row col-md-12" id="paddinTop20" ng-hide="objetos">
            <span class="text-info"><i class="fa fa-refresh fa-spin fa-5x primary"></i></span>
        </div>
        <div class="row col-md-12" id="paddinTop20"></div>
        <div class="row col-md-12">
            <div class="col-md-1"></div>
            <div class="col-md-2">
                <div class="form-group-sm">
                    <!--<a href="#/adicionarCargo" data-toggle="modal"><button class="btn btn-primary">Adicionar</button></a>-->
                    <button class="btn btn-warning" type="button" id="btnAdicionar">Adicionar</button>
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
        <div class="row col-md-12" id="paddinTop20" ng-show="objetos">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <tr class="active">
                            <th ng-click="orden='nombre'">Nombre</th><th ng-click="orden='descripcion'">Descripcion</th><th>Acciones</th>
                        </tr>
                        <tr ng-repeat="objeto in objetos | filter: buscar | orderBy: orden">
                            <td>{{ objeto.nombre }}</td>
                            <td>{{ objeto.descripcion }}</td>
                            <td>
                                <h4>
                                    <a href="principal.php?CON=system/Pages/cargosEmpleadosFormulario.php&id={{ objeto.id }}"><span class="glyphicon glyphicon-refresh"></span></a>
                                    <a href='/#eliminar{{ objeto.id }}' title='Eliminar' data-toggle='modal'><span class="text text-danger glyphicon glyphicon-remove-circle"></span></a>
                                </h4>
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
                                    ¿Est&aacute; seguro que desea eliminar el cargo {{ objeto.nombre }}?
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-danger' data-dismiss='modal' >Cancelar</button>
                                    <a href='principal.php?CON=system/Pages/cargosEmpleadosActualizar.php&id={{ objeto.id }}&accion=Eliminar'><button type='button' class='btn btn-success' >Aceptar</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
	</div>
</div>
<script>
    $("#btnAdicionar").click(function (){
        window.location="principal.php?CON=system/Pages/cargosEmpleadosFormulario.php";
    });
</script>