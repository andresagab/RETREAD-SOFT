<?php
require_once dirname(__FILE__).'\..\Clases\Persona.php';
require_once dirname(__FILE__).'\..\Clases\Cargo_Empleado.php';
require_once dirname(__FILE__).'\..\Clases\Empleado.php';
require_once dirname(__FILE__).'\..\Clases\Cliente.php';
require_once dirname(__FILE__).'\..\Clases\Tipo_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Marca_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Dimension_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Gravado_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Servicio.php';
require_once dirname(__FILE__).'\..\Clases\Inspeccion_Inicial.php';
if (isset($_GET['id'])) {
    $objeto=new Inspeccion_Inicial('id', $_GET['id'], null, null);
    $llanta=$objeto->getLlanta();
    $servicio=$llanta->getServicio();
    $accion="Finalizar";
    $accionBD="Finalizar";
    $checked='checked';
}
$llanta=$objeto->getLlanta();
$cliente=$servicio->getCliente();
if ($cliente->getRazonSocial()!=null || $cliente->getRazonSocial()!='') $nombreProveedor=$cliente->getRazonSocial();
else $nombreProveedor=$cliente->getPersona()->getNombresCompletos();
?>
<script src="lib/controladores/Image.js"></script>
<script src="lib/controladores/rechazos.js"></script>
<div class="col-md-12" ng-controller="rechazos">
    <div class="col-lg-12" ng-click="limpiarVariables();">
	<div class="col-md-12" id="paddinTop30"></div>
	<div class="col-md-4" ></div>
	<div class="col-md-4" >
            <strong class="text text-primary control-label"><h2><?=$accion?> inspeccion inicial</h2></strong>
	</div>
	<div class="col-md-4" ></div>
        <!--Panel de detalles-->
        <div class="row col-md-12 text-capitalize" id="paddinTop20">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="panel-group" id="accordion" role="tablist">
                    <div class="panel panel-success">
                        <div class="panel-heading" role="tab" id="detalles">
                            <h4 class="panel-title">
                                <a href="#detalles1" data-toggle="collapse" data-parent="#accordion" id="verDetalles">
                                    Ver detalles del servicio <small><i class="text text-capitalize">(OS: <?=$servicio->getOs()?>)</i></small>
                                </a>
                            </h4>
                        </div>
                        <div class="panel-collapse collapse in" id="detalles1">
                            <div class="panel-body">
                                <div class="col-md-12">
                                    <h4>
                                        <strong class="text text-info">Llanta</strong>
                                    </h4>
                                    <p>
                                        <strong>RP: </strong><small class="text-capitalize"><?=$llanta->getRp()?></small>
                                        <strong id="paddingLeft10">Serie: </strong><small class="text-capitalize"><?=$llanta->getSerie()?></small>
                                        <strong id="paddingLeft10">Tipo: </strong><small class="text-capitalize"><?= rtrim($llanta->getGravado()->getNombre())?></small>
                                        <strong id="paddingLeft10">Marca: </strong><small class="text-capitalize"><?= rtrim($llanta->getMarca()->getNombre())?></small>
                                        <strong id="paddingLeft10">Provedor: </strong><small class="text-capitalize"><?= $nombreProveedor ?></small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
        <!--Fin panel de detalles-->
	<div class="row col-md-12 text-capitalize" id="paddinTop20">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <form class="form-horizontal" name="formulario" method="POST" action="principal.php?CON=system/Pages/inspeccionInicialActualizar.php" enctype="multipart/form-data">
                    <div class="col-md-3"></div>
                    <div class="col-md-6" ng-controller="images">
                        <div class="form-group" ng-show="foto">
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="thumbnail">
                                        <img class="card-img-top" id="img" style="height: 300px;" ng-src="{{ thumbnail.dataURL }}">
                                        <div class="caption">
                                            <button class="btn btn-warning" id="btnEliminarImg" type="button" ng-click="deleteImg()">Borrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Foto:</span>
                                <input type="file" class="form-control btn btn-default" name="foto" id="foto" required="" accept=".jpg" onchange="angular.element(this).scope().photoChanged(this.files)">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Estado:</span>
                                <span class="input-group-addon">
                                    <span id="paddingLeft70"></span>
                                    <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="estado">
                                        <input type="checkbox" id="estado" class="mdl-switch__input" name="checked" <?=$checked?>>
                                    </label>
                                </span>
                                <span class="input-group-addon"><label id="textoEstado"></label></span>
                            </div>
                        </div>
                        <!--_Material Design-->
                        <div class="form-group center-block" id="divBtnSeleccionarRechazos">
                            <button class="btn btn-success" id="btnSeleccionarRechazos" type="button" href="/#seleccionarRechazos" data-toggle="modal" ng-click="loadRechazosOfInspeccion(<?=$objeto->getId()?>)">Seleccionar rechazos</button>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Observaciones:</span>
                                <textarea class="form-control has-primary input-sm" name="observaciones" placeholder="Observaciones para este proceso" maxlength="500"></textarea> 
                            </div>
                        </div>
                        <div class="hidden">
                            <div class="col-md-12"><input type="hidden" name="id" value="<?=$objeto->getId()?>"></div>
                            <div class="col-md-12"><input type="hidden" name="accion" value="<?=$accionBD?>"></div>
                        </div>
                        <div class="col-md-12" id="paddinTop10"></div>
                        <div class="form-group" id="paddinTop30">
                             <div class="col-md-2"></div>
                             <div class="col-md-2"><a href="principal.php?CON=system/Pages/procesoServicio.php&id=<?=$objeto->getIdLlanta()?>"><input class="btn btn-danger" type="button" name="Cancelar" value="Cancelar"></a></div>
                             <div class="col-md-2"></div>
                             <div class="col-md-2"><input class="btn btn-info" type="submit" name="btnAccion" value="<?=$accion?>"></div>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </form>
            </div>
            <div class="col-md-1"></div>
	</div>
    </div>
    <div class='modal fade' id='seleccionarRechazos'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' ng-click="limpiarVariables();">&times;</button>
                    <h3 class="text text-primary">Rechazos</h3>
                </div>
                <div class="modal-header">
                    <div class="col-lg-12 col-sm-12" ng-hide="objetos">
                        <span class="text text-info fa fa-circle-o-notch fa-spin fa-4x"></span>
                    </div>
                    <div class="col-lg-12" ng-show="objetos">
                        <ul class="mdl-list">
                            <li class="mdl-list__item" ng-repeat="objeto in objetos">
                                <span class="mdl-list__item-primary-content">
                                    <i class="material-icons  mdl-list__item-avatar mdl-color--teal mdl-color-text--white">R</i>
                                    {{ objeto.nombre }}
                                </span>
                                <span class="mdl-list__item-secondary-action">
                                    <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="chk_{{ objeto.id }}">
                                        <input ng-show="!objeto.checked" class="mdl-checkbox__input" id="chk_{{ objeto.id }}" type="checkbox" name="chk_{{  objeto.id }}" ng-model="chk" ng-click="separarRechazo(chk, objeto.id)">
                                        <!--Si no existe la variable checked en el objeto JSON se presenta el input anterior en caso contrario se muesta los dos siguientes;
                                        El Primero hace referencia a que este tipo de rechazo ya fue seleccionado
                                        El segundo hace referencia a la opcion de volver a marcar el rechazo previamente registrado, este campo se ubica ya que angular no dejo marcar el checkbox por la directiva NG-MODEL
                                        -->
                                        <input ng-show="objeto.checked" class="mdl-checkbox__input" id="chk" type="checkbox" name="chk_{{  objeto.id }}" checked="" disabled="">
                                        <input ng-show="objeto.checked" class="mdl-checkbox__input" id="chk" type="checkbox" name="chk_{{  objeto.id }}" ng-model="chk" ng-click="separarRechazo(chk, objeto.id)">
                                    </label>
                                </span>
                            </li>
                        </ul>
<!--                        <div class="col-lg-12 col-sm-12" ng-repeat="objeto in objetos">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">{{ objeto.nombre }}</span>
                                    <span class="input-group-addon">
                                        <input class="" id="chk" type="checkbox" name="chk_{{  objeto.id }}" ng-model="chk" ng-click="separarRechazo(chk, objeto.id)">
                                        <input ng-show="!objeto.checked" class="mdl-checkbox__input" id="chk" type="checkbox" name="chk_{{  objeto.id }}" ng-model="chk" ng-click="separarRechazo(chk, objeto.id)">
                                        Si no existe la variable checked en el objeto JSON se presenta el input anterior en caso contrario se muesta los dos siguientes;
                                        El Primero hace referencia a que este tipo de rechazo ya fue seleccionado
                                        El segundo hace referencia a la opcion de volver a marcar el rechazo previamente registrado, este campo se ubica ya que angular no dejo marcar el checkbox por la directiva NG-MODEL
                                        
                                        <input ng-show="objeto.checked" class="mdl-checkbox__input" id="chk" type="checkbox" name="chk_{{  objeto.id }}" checked="" disabled="">
                                        <input ng-show="objeto.checked" class="mdl-checkbox__input" id="chk" type="checkbox" name="chk_{{  objeto.id }}" ng-model="chk" ng-click="separarRechazo(chk, objeto.id)">
                                    </span>
                                </div>
                            </div>
                        </div>-->
                    </div>
                </div>
                <div class="modal-header">
                    <div class="col-lg-12 form-group">
                        <div class="input-group">
                            <span class="input-group-addon" ng-init="observaciones=''">Observaciones:</span>
                            <textarea class="form-control has-primary" name="observaciones" placeholder="Escribe algunas obervaciones de las causas del rechazo" ng-model="observaciones">{{ observaciones }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="alert alert-warning" ng-show="!chequeados">
                    <span class="text-muted">!Si esta inspeccion va ha ser rechazada se debe marcar por lo menos una causa¡</span>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-danger' id="btnCancelarSolicitud" data-dismiss='modal' ng-click="limpiarVariables();">Cancelar</button>
                    <a href="/#solicitudEnviada" data-toggle="modal">
                        <button ng-hide="!chequeados" type='button' class='btn btn-success {{ objeto.btnAprobar }}' id="btnAprobar" data-dismiss="modal"
                                ng-click="registrarRechazos(<?= $objeto->getId() ?>, observaciones)"
                                >Aprobar eliminacion</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Fin Formularion modal para aprobar solicitud de eliminacion-->
<script>
    $(document).ready(function(){
        $("#verDetalles").click();
        if(document.getElementById("estado").checked) {
            document.getElementById("textoEstado").innerHTML='Aprobado';
            $("#btnSeleccionarRechazos").hide("slow");
            $("#divBtnSeleccionarRechazos").hide("slow");
        } else {
            document.getElementById("textoEstado").innerHTML='Reprobado';
            $("#btnSeleccionarRechazos").show("slow");
            $("#divBtnSeleccionarRechazos").show("slow");
        }
    });
    
    $("#estado").click(function(){
        if(document.getElementById("estado").checked) {
            document.getElementById("textoEstado").innerHTML='Aprobado';
            $("#btnSeleccionarRechazos").hide("slow");
            $("#divBtnSeleccionarRechazos").hide("slow");
        } else {
            document.getElementById("textoEstado").innerHTML='Reprobado';
            $("#btnSeleccionarRechazos").show("slow");
            $("#divBtnSeleccionarRechazos").show("slow");
        }
    });
    
    //Acciones de foto
    
    $("#foto").change(function (){
        //angular.element(this).scope.photoChanged(this.files);
        //cargarFoto();
    });
    
    
    function cargarFoto(){
        //$("#imagen").src=$("#foto").val();
        document.getElementById("imagen").src=$("#foto").val();
        alert($("#foto").val());
    }
</script>