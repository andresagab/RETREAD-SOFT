<?php
?>
<script src="lib/controladores/contactosPersona.js"></script>
<div class="col-md-12" ng-controller="contactosPersona">
    <div class="col-lg-12 hidden" id="cargarLista" ng-click="cargarDatos(<?=$_GET['identificacion']?>);cargarEmpleado(<?=$_GET['id']?>)"></div>
	<div class="col-md-4" ></div>
	<div class="col-md-4" >
            <strong class="text text-success control-label"><h2>Contactos del funcionario {{ empleado.nombresCompletosPersona }}</h2></strong>
	</div>
	<div class="col-md-4" ></div>
        <div class="row col-md-12" id="paddinTop20" ng-hide="objetos">
            <div class="mdl-spinner mdl-js-spinner is-active"></div>
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
                <button class="mdl-button mdl-js-button mdl-button--icon mdl-button--fab mdl-button--mini-fab mdl-js-ripple-effect btn-success" type="button" id="cargarLista" ng-click="cargarDatos(<?=$_GET['identificacion']?>)">
                    <span class="material-icons">sync</span>
                </button>
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
                                    <th ng-click="orden='nombresContacto'">Nombres</th>
                                    <th ng-click="orden='apellidosContacto'">Apellidos</th>
                                    <th ng-click="orden='telefonoContacto'">Telefono</th>
                                    <th ng-click="orden='celulaarContacto'">Celular</th>
                                    <th ng-click="orden='direccionContacto'">Direccion</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="objeto in objetos | filter: buscar | orderBy: orden">
                                    <td>{{ objeto.nombresContacto }}</td>
                                    <td>{{ objeto.apellidosContacto }}</td>
                                    <td>{{ objeto.telefonoContacto }}</td>
                                    <td>{{ objeto.celularContacto }}</td>
                                    <td>{{ objeto.direccionContacto }}</td>
                                    <td>
                                        <h4>
                                            <a href="principal.php?CON=system/Pages/contactosPersonaFormulario.php&id={{ objeto.id }}&idEmpleado={{ empleado.id }}" title="Modificar"><span class="fa fa-edit"></span></a>
                                            <a id="paddingLeft10" href='/#eliminar{{ objeto.id }}' title='Eliminar' data-toggle='modal'><span class="text-danger fa fa-trash"></span></a>
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
                                        ¿Est&aacute; seguro que desea eliminar al contacto {{ objeto.nombresCompletosContacto }}?
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-danger' data-dismiss='modal' >Cancelar</button>
                                        <a href='principal.php?CON=system/Pages/contactosPersonaActualizar.php&id={{ objeto.id }}&idEmpleado={{ empleado.id }}&identificacionPersona={{ empleado.identificacion }}&accion=Eliminar'><button type='button' class='btn btn-success' >Aceptar</button></a>
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
        window.location="principal.php?CON=system/Pages/contactosPersonaFormulario.php&idEmpleado=<?=$_GET['id']?>";
    });
    
    $("#btnRegresar").click(function (){
        window.location="principal.php?CON=system/Pages/empleados.php";
    });
</script>