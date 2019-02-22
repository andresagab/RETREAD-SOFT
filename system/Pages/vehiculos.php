<script src="lib/controladores/vehiculos.js"></script>
<div class="col-md-12" ng-controller="vehiculos">
    <div class="col-lg-12 hidden" id="cargarLista" ng-click="cargarDatos(<?=$_GET['id']?>);cargarCliente(<?=$_GET['id']?>)"></div>
	<div class="col-md-12" id="paddinTop30"></div>
	<div class="col-md-2" ></div>
	<div class="col-md-8" >
            <strong class="text text-success control-label"><h2>Vehiculos del cliente {{ cliente.nombresCompletosPersona }} <small class="text-capitalize">({{ cliente.razonSocial }})</small></h2></strong>
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
                    <input class="col-md-12 form-control" id="buscar" name="buscar" placeholder="Buscar por: Nombre o Descripcion" ng-model="buscar">
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-2">
                <button class="btn btn-success" type="button" id="cargarLista" ng-click="cargarDatos(<?=$_GET['id']?>)">Actualizar lista</button>
            </div>
            <div class="col-md-1"></div>
        </div>
        <div class="row col-md-12" id="paddinTop20" ng-show="objetos">
            <div class="col-md-0"></div>
            <div class="col-md-12">
                <center>
                    <div class="table-responsive">
                        <table class="mdl-data-table mdl-js-data-table">
                            <tr class="active">
                                <th ng-click="orden='placa'">Placa</th>
                                <th ng-click="orden='nombreMarca'">Marca</th>
                                <th ng-click="orden='linea'">Linea</th>
                                <th ng-click="orden='modelo'">Modelo</th>
                                <th ng-click="orden='clase'">Clase</th>
                                <th ng-click="orden='nombreCombustible'">Combustible</th>
                                <th ng-click="orden='numeroLlantas'">Numero de llantas</th>
                                <th ng-click="orden='medidaDimension'">Dimension llantas</th>
                                <th>Acciones</th>
                            </tr>
                            <tr ng-repeat="objeto in objetos | filter: buscar | orderBy: orden">
                                <td>{{ objeto.placa }}</td>
                                <td>{{ objeto.nombreMarca }}</td>
                                <td>{{ objeto.linea }}</td>
                                <td>{{ objeto.modelo }}</td>
                                <td>{{ objeto.clase }}</td>
                                <td>{{ objeto.nombreCombustible }}</td>
                                <td>{{ objeto.numeroLlantas }}</td>
                                <td>{{ objeto.medidaDimension }}</td>
                                <td>
                                    <h4>
                                        <a href="principal.php?CON=system/Pages/vehiculosFormulario.php&id={{ objeto.id }}&idCliente={{ cliente.id }}" title="Modificar"><span class="material-icons">edit</span></a>
                                        <a id="paddingLeft10" href='/#eliminar{{ objeto.id }}' title='Eliminar' data-toggle='modal'><span class="text-danger material-icons">delete</span></a>
                                        <a id="paddingLeft10" href="principal.php?CON=system/Pages/soatsVehiculo.php&id={{ objeto.id }}&idCliente={{ cliente.id }}" title="Gestionar soats"><span class="text-success material-icons">credit_card</span></a>
                                        <a id="paddingLeft10" href="principal.php?CON=system/Pages/tecnomecanicasVehiculo.php&id={{ objeto.id }}&idCliente={{ cliente.id }}" title="Gestionar revisiones tecnomecanicas"><span class="text-success material-icons">security</span></a>
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
                                        ¿Est&aacute; seguro que desea eliminar al vehiculo de placa {{ objeto.placa }}?
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-danger' data-dismiss='modal' >Cancelar</button>
                                        <a href='principal.php?CON=system/Pages/vehiculosActualizar.php&id={{ objeto.id }}&idCliente={{ cliente.id }}&accion=Eliminar'><button type='button' class='btn btn-success' >Aceptar</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </center>
            </div>
            <div class="col-md-0"></div>
	</div>
</div>
<script>
    $(document).ready(function(){
        $("#cargarLista").click();
    });
    
    $("#btnAdicionar").click(function (){
        window.location="principal.php?CON=system/Pages/vehiculosFormulario.php&idCliente=<?=$_GET['id']?>";
    });
    
    $("#btnRegresar").click(function (){
        window.location="principal.php?CON=system/Pages/clientes.php";
    });
</script>