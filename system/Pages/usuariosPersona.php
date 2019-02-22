<?php
require_once dirname(__FILE__).'\..\Clases\Persona.php';
require_once dirname(__FILE__).'\..\Clases\Usuario_Persona.php';
require_once dirname(__FILE__).'\..\Clases\Cargo_Empleado.php';
require_once dirname(__FILE__).'\..\Clases\Empleado.php';
$persona=new Persona('identificacion', "'{$_GET['identificacion']}'", null, null);
if (isset($_GET['id'])){
    $empleado=new Empleado('id', $_GET['id'], null, null);
    $cargo="<label class='control-label'><strong class='text-info'>Cargo:</strong></label><label class='text-muted'>".rtrim($empleado->getCargo()->getNombre())."</label>";
} else $cargo='';
?>
<script src="lib/controladores/usuariosPersona.js"></script>
<div class="col-md-12" ng-controller="usuariosPersona">
    <div class="hidden-lg" id="cargar" ng-click="cargarLista(<?= rtrim($persona->getIdentificacion())?>)"></div>
    <!--<div class="col-md-12" id="paddinTop30" ng-click="cargarLista(<?= rtrim($persona->getIdentificacion())?>)"></div>-->
	<div class="col-md-3"></div>
	<div class="col-md-6">
        <strong class="mdl-color-text--blue text-uppercase"><h2>Usuarios de <?= $persona->getNombresCompletos()?></h2></strong>
	</div>
	<div class="col-md-3"></div>
        <div class="row col-md-12" id="paddinTop20" ng-hide="objetos">
            <div class="mdl-spinner mdl-js-spinner is-active"></div>
        </div>
        <div class="col-md-12"></div>
        <!--<div class="col-md-2"></div>
        <div class="row col-md-8" id="paddinTop20">
            <div class="panel panel-warning" data-toggle="tooltip" title="Informacion del empleado">
                <div class="panel-heading">Datos:</div>
                <div class="panel-body">
                    <div class="col-md-6 col-sm-12">
                        <label class="control-label"><strong class="text-info">Identificacion:</strong></label><label class="text-muted"><?= rtrim($persona->getIdentificacion())?></label>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label class="control-label"><strong class="text-info">Nombres y Apellidos:</strong></label><label class="text-muted"><?= rtrim($persona->getNombresCompletos())?></label>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label class="control-label"><strong class="text-info">Celular:</strong></label><label class="text-muted"><?= rtrim($persona->getCelular())?></label>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label class="control-label"><strong class="text-info">Direccion:</strong></label><label class="text-muted"><?= rtrim($persona->getDireccion())?></label>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <?=$cargo?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>-->
        <div class="row col-md-12" id="paddinTop20"></div>
        <div class="row col-md-12" ng-show="objetos">
            <div class="col-md-1"></div>
            <div class="col-md-2">
                <div class="form-group-sm">
                    <a href="principal.php?CON=system/Pages/usuariosPersonaFormulario.php&identificacion=<?=$_GET['identificacion']?>"><button class="btn btn-primary">Adicionar</button></a>
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-4">
                <div class="col-md-12 form-group-sm">
                    <input class="col-md-12 form-control" id="buscar" name="buscar" placeholder="Buscar por: Usuario, Rol, FechaCreacion o Estado" ng-model="buscar">
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-2">
                <div class="form-group-sm">
                    <a href="principal.php?CON=system/Pages/empleados.php"><button class="btn btn-danger">Regresar</button></a>
                </div>
            </div>
            <div class="col-md-1"></div>
            <!--<div class="col-md-4"></div>-->
        </div>
        <div class="row col-md-12" id="paddinTop20" ng-show="objetos">
            <center>
                <div class="table-responsive">
                    <table class="mdl-data-table mdl-js-data-table">
                        <tr class="active">
                            <th class="mdl-data-table__cell--non-numeric" ng-click="usuario">Usuario</th>
                            <th class="mdl-data-table__cell--non-numeric">Rol</th>
                            <th class="mdl-data-table__cell--non-numeric">Estado</th>
                            <th>Fecha Registro</th>
                            <th class="mdl-data-table__cell--non-numeric">Acciones</th>
                        </tr>
                        <tr ng-repeat='objeto in objetos | filter: buscar | orderBy: ordenar'>
                            <td class="mdl-data-table__cell--non-numeric">{{ objeto.usuario }}</td>
                            <td class="mdl-data-table__cell--non-numeric">{{ objeto.nombreRol }}</td>
                            <td class="mdl-data-table__cell--non-numeric">{{ objeto.nombreEstadoUsuario }}</td>
                            <td>{{ objeto.fechaRegistro.substr(0, 16) }}</td>
                            <td class="mdl-data-table__cell--non-numeric">
                                <h4>
                                    <a href="principal.php?CON=system/Pages/usuariosPersonaFormulario.php&id={{ objeto.id }}">
                                        <span class="material-icons" title="Editar registro">edit</span>
                                    </a>
                                    <a ng-show="objeto.statusDelete" href='/#eliminar{{ objeto.id }}' title='Eliminar registro' data-toggle='modal'>
                                        <span class="material-icons mdl-color-text--red-500">delete</span>
                                    </a>
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
                                    ¿Est&aacute; seguro que desea eliminar el usuario {{ objeto.usuario }}?
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-danger' data-dismiss='modal' >Cancelar</button>
                                    <a href='principal.php?CON=system/Pages/usuariosPersonaActualizar.php&accion=Eliminar&id={{ objeto.id }}&identificacion={{ objeto.identificacion }}'><button type='button' class='btn btn-success' >Aceptar</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </center>
	</div>
</div>
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
        $("#cargar").click();
    });
</script>