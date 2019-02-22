<?php
require_once dirname(__FILE__).'\..\Clases\Persona.php';
require_once dirname(__FILE__).'\..\Clases\Cliente.php';
require_once dirname(__FILE__).'\..\Clases\Tipo_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Marca_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Servicio.php';
$objeto=new Llanta('id', $_GET['idLlanta'], null, null);
if ($USUARIO->getRol()->getNombre()=='operario') $hideBotones='hide';
else $hideBotones='';
?>
<script src="lib/controladores/serviciosLlanta.js"></script>
<div class="col-md-12" ng-controller="serviciosLlanta">
    <div class="hidden-lg" id="cargar" ng-click="cargarLista(<?=$objeto->getId()?>)"></div>
    <div class="col-md-12" id="paddinTop30" ng-click="cargarLista(<?= $objeto->getId() ?>)"></div>
	<div class="col-md-4"></div>
	<div class="col-md-4">
            <strong class="text text-success control-label"><h2>Servicios de llanta</h2></strong>
	</div>
	<div class="col-md-4"></div>
        <div class="row col-md-12" id="paddinTop20" ng-hide="objetos">
            <i class="fa fa-refresh fa-spin fa-5x primary"></i>
        </div>
        <div class="col-md-12"></div>
        <div class="col-md-2"></div>
        <div class="row col-md-8" id="paddinTop20">
            <div class="panel panel-warning" data-toggle="tooltip" title="Informacion de la llanta">
                <div class="panel-heading">Datos:</div>
                <div class="panel-body">
                    <p>
                        <label class="control-label"><strong class="text-info">RP:&nbsp;</strong></label><i class="text-muted"><?= $objeto->getRp()?></i>
                        <label class="control-label" id="paddingLeft20"><strong class="text-info">Serie:&nbsp;</strong></label><i class="text-muted"><?= $objeto->getSerie()?></i>
                        <label class="control-label" id="paddingLeft20"><strong class="text-info">Dimension:&nbsp;</strong></label><i class="text-muted"><?= rtrim($objeto->getDimension())?></i>
                        <label class="control-label" id="paddingLeft20"><strong class="text-info">Diseno:&nbsp;</strong></label><i class="text-muted"><?= rtrim($objeto->getDiseno())?></i>
                    </p>
                    <p><label class="control-label"><strong class="text-info">Observaciones:&nbsp;</strong></label><i class="text-muted"><?= rtrim($objeto->getObservaciones())?></i></p>
                    <p><label class="control-label"><strong class="text-danger">Servicios registrados:&nbsp;</strong></label><i class="text-muted" id="cantidadServicios"><?=$objeto->getCantidadServicios()?></i></p>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
        <div class="row col-md-12" id="paddinTop20"></div>
        <div class="row col-md-12" ng-show="objetos">
            <div class="col-md-1"></div>
            <div class="col-md-2">
                <div class="form-group-sm <?=$hideBotones?>">
                    <a href="principal.php?CON=system/Pages/serviciosLlantaFormulario.php&idLlanta=<?=$_GET['idLlanta']?>"><button class="btn btn-primary">Adicionar</button></a>
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-4">
                <div class="col-md-12 form-group-sm">
                    <input class="col-md-12 form-control" id="buscar" name="buscar" placeholder="Buscar por: Orden de servicio, Observaciones o FechaCreacion o Estado" ng-model="buscar">
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-2">
                <div class="form-group-sm">
                    <a href="principal.php?CON=system/Pages/llantas.php"><button class="btn btn-danger">Regresar</button></a>
                </div>
            </div>
            <div class="col-md-1"></div>
            <!--<div class="col-md-4"></div>-->
        </div>
        <div class="row col-md-12" id="paddinTop20" ng-show="objetos">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="table-responsive">
                    <table class="table table-hover table-responsive table-striped">
                        <tr class="active">
                            <th ng-click="ordenar='os'">OS</th>
                            <th ng-click="ordenar='observaciones'">Observaciones</th>
                            <th ng-click="ordenar='fechaRegistro'">Fecha Registro</th>
                            <th>Acciones</th>
                        </tr>
                        <tr ng-repeat='objeto in objetos | filter: buscar | orderBy: ordenar' class="text-left">
                            <td>{{ objeto.os }}</td>
                            <td>{{ objeto.observaciones }}</td>
                            <td>{{ objeto.fechaRegistro }}</td>
                            <td>
                                <i class="<?=$hideBotones?>"><a href="principal.php?CON=system/Pages/serviciosLlantaFormulario.php&id={{ objeto.id }}"><span class="glyphicon glyphicon-refresh"></span></a></i>
                                <i class="<?=$hideBotones?>"><a href='/#eliminar{{ objeto.id }}' title='Eliminar' data-toggle='modal'><span class="glyphicon glyphicon-remove-circle"></span></a></i>
                                <h2 class="text-primary small" title="Gestionar proceso de rencauche"><a href="principal.php?CON=system/Pages/procesoServicio.php&idServicio={{ objeto.id }}"><span class="fa fa-puzzle-piece fa-spin fa-2x"></span></a></h2>
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
                                    ¿Est&aacute; seguro que desea eliminar el registro con orden de servicio {{ objeto.os }}?
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-danger' data-dismiss='modal' >Cancelar</button>
                                    <a href='principal.php?CON=system/Pages/serviciosLlantaActualizar.php&accion=Eliminar&id={{ objeto.id }}&idLlanta={{ objeto.idLlanta }}'><button type='button' class='btn btn-success' >Aceptar</button></a>
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
        $('[data-toggle="tooltip"]').tooltip();
        $("#cargar").click();
    });
</script>