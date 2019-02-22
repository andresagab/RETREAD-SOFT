<script src="lib/controladores/revisionTecnomecanica.js"></script>
<div class="col-md-12" ng-controller="revisionTecnomecanica">
    <div class="col-lg-12 hidden" id="cargarLista" 
         ng-click="
        cargarVehiculo(<?=$_GET['id']?>);
        cargarDatos(<?=$_GET['id']?>);
        cargarClientePersona(<?=$_GET['id']?>);
             "></div>
	<div class="col-md-12" id="paddinTop30"></div>
	<div class="col-md-2" ></div>
	<div class="col-md-8" >
            <strong class="text text-success control-label"><h2>Revisiones tecnomecanicas del vehiculo {{ vehiculo.placa }} <small class="text-capitalize">({{ clientePersona.razonSocial }})</small></h2></strong>
	</div>
	<div class="col-md-2" ></div>
        <div class="row col-md-12" id="paddinTop20" ng-hide="objetos">
            <span class="text-info"><i class="fa fa-refresh fa-spin fa-5x primary"></i></span>
        </div>
        <div class="row col-md-12" id="paddinTop20"></div>
        <div class="row col-md-12">
            <div class="col-md-2">
                <div class="form-group-sm">
                    <!--<a href="#/adicionarCargo" data-toggle="modal"><button class="btn btn-primary">Adicionar</button></a>-->
                    <button class="btn btn-primary" type="button" id="btnAdicionar">Adicionar</button>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group-sm">
                    <!--<a href="#/adicionarCargo" data-toggle="modal"><button class="btn btn-primary">Adicionar</button></a>-->
                    <button class="btn btn-default" type="button" id="btnRegresar">Regresar</button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="col-md-12 form-group-sm">
                    <input class="col-md-12 form-control" id="buscar" name="buscar" placeholder="Buscar por: Fed}cha de Expedicion o Fecha de culminacion" ng-model="buscar">
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-2">
                <button class="btn btn-success" type="button" id="cargarLista" ng-click="cargarDatos(<?=$_GET['id']?>)">Actualizar lista</button>
            </div>
            <div class="col-md-1"></div>
        </div>
        <div class="row col-md-12" id="paddinTop20" ng-show="objetos">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <tr class="active">
                            <th ng-click="orden='fechaExpedicion'">Expedicion</th>
                            <th ng-click="orden='fechaFinVigencia'">Fin Vigencia</th>
                            <th ng-click="orden='estado'">Estado</th>
                            <th>Acciones</th>
                        </tr>
                        <tr ng-repeat="objeto in objetos | filter: buscar | orderBy: orden">
                            <td>{{ objeto.fechaExpedicion }}</td>
                            <td>{{ objeto.fechaFinVigencia }}</td>
                            <td>{{ objeto.estado }}</td>
                            <td>
                                <h4>
                                    <a href="principal.php?CON=system/Pages/tecnomecanicasVehiculoFormulario.php&id={{ objeto.id }}&idVehiculo={{ vehiculo.id }}&idCliente={{ clientePersona.id }}" title="Modificar"><span class="glyphicon glyphicon-refresh"></span></a>
                                    <a id="paddingLeft10" href='/#eliminar{{ objeto.id }}' title='Eliminar' data-toggle='modal'><span class="text-danger glyphicon glyphicon-remove-circle"></span></a>
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
                                    ¿Est&aacute; seguro que desea eliminar el registro?
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-danger' data-dismiss='modal' >Cancelar</button>
                                    <a href='principal.php?CON=system/Pages/tecnomecanicasVehiculoActualizar.php&id={{ objeto.id }}&idVehiculo={{ vehiculo.id }}&idCliente={{ clientePersona.id }}&accion=Eliminar'><button type='button' class='btn btn-success' >Aceptar</button></a>
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
    $(document).ready(function(){
        $("#cargarLista").click();
    });
    
    $("#btnAdicionar").click(function (){
        window.location="principal.php?CON=system/Pages/tecnomecanicasVehiculoFormulario.php&idVehiculo=<?=$_GET['id']?>&idCliente=<?=$_GET['idCliente']?>";
    });
    
    $("#btnRegresar").click(function (){
        window.location="principal.php?CON=system/Pages/vehiculos.php&id=<?=$_GET['idCliente']?>";
    });
</script>