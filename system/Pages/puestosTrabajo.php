<?php
if (strtolower($USUARIO->getRol()->getNombre())=='operario' || strtolower($USUARIO->getRol()->getNombre())=='operario cb') header ("Location: index.php?mjs='No tienes los permisos necesarios para acceder a esta pagina'");
else {
?>
<script src="lib/controladores/puestoTrabajo.js"></script>
<div class="col-md-12" ng-controller="puestoTrabajo">
        <div class="col-lg-12 hidden" id="cargarLista" ng-click="cargarLista()"></div>
	<div class="col-md-3" ></div>
	<div class="col-md-6" >
            <strong class="mdl-color-text--blue text-uppercase"><h2>Puestos de trabajo</h2></strong>
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
                    <span class="mdl-textfield__label" for="buscar">Buscar por: Nombre o procceso</span>
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
                            <thead>
                                <tr class="active">
                                    <th class="mdl-data-table__cell--non-numeric" ng-click="orden='nombre'">Nombre</th>
                                    <th class="mdl-data-table__cell--non-numeric" ng-click="orden='nombreProceso'">Proceso</th>
                                    <th class="mdl-data-table__cell--non-numeric" ng-click="orden='numberNovedades'">Novedades</th>
                                    <th class="mdl-data-table__cell--non-numeric">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="objeto in objetos | filter: buscar | orderBy: orden">
                                    <td class="mdl-data-table__cell--non-numeric">{{ objeto.nombre }}</td>
                                    <td class="mdl-data-table__cell--non-numeric">{{ objeto.nombreProceso }}</td>
                                    <td class="mdl-data-table__cell--non-numeric">Total: {{ objeto.numberNovedades }} - <span class="text-muted">Pendientes: {{ objeto.numberNovedadesNoRevisadas }}</span> - <span class="text-muted">Revisadas: {{ objeto.numberNovedadesRevisadas }}</span></td>
                                    <td class="mdl-data-table__cell--non-numeric">
                                        <h4>
                                            <a href="principal.php?CON=system/Pages/puestosTrabajoFormulario.php&id={{ objeto.id }}" title="Modificar"><span class="material-icons">edit</span></a>
                                            <a ng-show="objeto.statusDelete" id="paddingLeft10" href='/#eliminar{{ objeto.id }}' title='Eliminar' data-toggle='modal'><span class="text-danger material-icons">delete</span></a>
                                            <a id="paddingLeft10" href="principal.php?CON=system/Pages/insumosPuestoTrabajo.php&idPT={{ objeto.id }}"><span class="text-warning material-icons" data-toggle="tooltip" title="Gestionar insumos">add_shopping_cart</span></a>
                                            <a id="paddingLeft10" href="principal.php?CON=system/Pages/novedadesPuestoTrabajo.php&idPT={{ objeto.id }}"><span class="text-success material-icons" data-toggle="tooltip" title="Gestionar Novedades">speaker_notes</span></a>
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
                                        ¿Est&aacute; seguro que desea eliminar el puesto de trabajo <b>" {{ objeto.nombre }} "</b>?
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-danger' data-dismiss='modal' >Cancelar</button>
                                        <a href='principal.php?CON=system/Pages/puestosTrabajoActualizar.php&id={{ objeto.id }}&accion=Eliminar'><button type='button' class='btn btn-success' >Aceptar</button></a>
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
    /*$(document).ready(function(){
        $("#cargarLista").click();
    });*/
    
    $("#btnAdicionar").click(function (){
        window.location="principal.php?CON=system/Pages/puestosTrabajoFormulario.php";
    });
</script>
<?php
}