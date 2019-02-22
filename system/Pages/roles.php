<?php
if (strtolower($USUARIO->getRol()->getNombre())!='desarrollador') header ("Location: index.php?mjs='No tienes los permisos necesarios para acceder a esta pagina'");
else {
?>
<script src="lib/controladores/roles.js"></script>
<div class="col-md-12" ng-controller="roles">
	<div class="col-md-12" id="paddinTop30"></div>
	<div class="col-md-4" ></div>
	<div class="col-md-4" >
            <strong class="text text-success control-label"><h2>Roles del sistema</h2></strong>
	</div>
	<div class="col-md-4" ></div>
        <div class="row col-md-12" id="paddinTop20" ng-show="html.spinnerLoad">
            <div class="mdl-spinner mdl-js-spinner is-active"></div>
            <br>
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
                    <input class="col-md-12 form-control" id="buscar" name="buscar" placeholder="Buscar por: Nombre o estado" ng-model="buscar">
                </div>
            </div>
            <div class="col-md-4">
                <button class="mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-button--accent" type="button" id="btnSync" ng-click="loadData()">
                    <span class="material-icons">sync</span>
                </button>
                <div class="mdl-tooltip" data-mdl-for="btnSync">Recargar registros</div>
            </div>
        </div>
        <div class="row col-md-12" id="paddinTop20" ng-show="objetos">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <tr class="active">
                            <th ng-click="orden='nombre'">Nombre</th><th ng-click="orden='estadoNombre'">Estado</th><th>Acciones</th>
                        </tr>
                        <tr ng-repeat="objeto in objetos | filter: buscar | orderBy: orden">
                            <td>{{ objeto.nombre }}</td>
                            <td>{{ objeto.estadoNombre }}</td>
                            <td>
                                <a title="modificar registro" href="principal.php?CON=system/Pages/rolesFormulario.php&id={{ objeto.id }}">
                                    <!--<span class="glyphicon glyphicon-refresh"></span>-->
                                    <span class="material-icons">edit</span>
                                </a>
                                <a id="paddingLeft10" href='/#eliminar{{ objeto.id }}' title='Eliminar' data-toggle='modal'>
                                    <span class="material-icons">delete</span>
                                </a>
                                <a id="paddingLeft10" title="Configurar accesos (Menus y/u opciones)" href="principal.php?CON=system/Pages/rolesAccesos.php&id={{ objeto.id }}">
                                    <span class="material-icons">accessibility</span>
                                </a>
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
                                    ¿Est&aacute; seguro que desea eliminar el rol {{ objeto.nombre }}?
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-danger' data-dismiss='modal' >Cancelar</button>
                                    <a href='principal.php?CON=system/Pages/rolesActualizar.php&id={{ objeto.id }}&accion=Eliminar'><button type='button' class='btn btn-success' >Aceptar</button></a>
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
        window.location="principal.php?CON=system/Pages/rolesFormulario.php";
    });
</script>
<?php
}