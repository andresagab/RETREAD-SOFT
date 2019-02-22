<?php
require_once dirname(__FILE__).'\..\Clases\Persona.php';
require_once dirname(__FILE__).'\..\Clases\Cargo_Empleado.php';
require_once dirname(__FILE__).'\..\Clases\Empleado.php';
require_once dirname(__FILE__).'\..\Clases\Cliente.php';
require_once dirname(__FILE__).'\..\Clases\Tipo_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Marca_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Dimension_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Gravado_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Referencia_Tipo_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Dimension_Referencia.php';
require_once dirname(__FILE__).'\..\Clases\Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Servicio.php';
require_once dirname(__FILE__).'\..\Clases\Inspeccion_Inicial.php';
if (isset($_GET['id'])) {
    $objeto=new Inspeccion_Inicial('id', $_GET['id'], null, null);
    $llanta=$objeto->getLlanta();
    $servicio=$llanta->getServicio();
    $accion="Modificar";
    $accionBD="RegistrarFin";
    $hideNumeroRencauche="hidden";
} else {
    $objeto=new Inspeccion_Inicial(null, null, null, null);
    $objeto->setIdLlanta($_GET['idLlanta']);
    $servicio=$objeto->getLlanta()->getServicio();
    $accion="Registrar";
    $accionBD="Registrar";
    $hideNumeroRencauche="";
}
$llanta=$objeto->getLlanta();
$cliente=$servicio->getCliente();
if ($cliente->getRazonSocial()!=null || $cliente->getRazonSocial()!='') $nombreProveedor=$cliente->getRazonSocial();
else $nombreProveedor=$cliente->getPersona()->getNombresCompletos();
?>
<div class="col-md-12">
	<div class="col-md-12" id="paddinTop30"></div>
	<div class="col-md-4" ></div>
	<div class="col-md-4" >
            <strong class="text text-primary control-label"><h2><?=$accion?> inspeccion inicial</h2></strong>
	</div>
    <div class="col-md-4" >
        <button class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab btn-info" id="btnDetalles" type="button" href="/#_Dialog_DetallesProceso" data-toggle="modal">
            <i class="fa fa-info-circle"></i>
        </button>
        <div class="mdl-tooltip" for="btnDetalles">Detalles de la llanta y la orden de servicio</div>
    </div>
    <div class="row col-md-12" id="paddinTop20" ng-show="html.alerta">
        <div class="alert alert-{{ html.colorAlerta }}">{{ html.mjsAlerta }} <b>{{ html.mjsAlertaResaltado }}</b></div>
    </div>
    <div class="row col-md-12" id="paddinTop20" ng-show="html.barraCargaPrincipal">
        <center>
            <div id="p2" class="mdl-progress mdl-js-progress mdl-progress__indeterminate"></div>
        </center>
    </div>
	<div class="row col-md-12 text-capitalize" id="paddinTop20">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <form class="form-horizontal" name="formulario" method="POST" action="principal.php?CON=system/Pages/inspeccionInicialActualizar.php">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="form-group <?=$hideNumeroRencauche?>">
                        <div class="input-group">
                            <span class="input-group-addon">* Numero rencauche:</span>
                            <input class="form-control has-primary" type="number" id="numeroRencauche" name="numeroRencauche" value="" min="1" placeholder="1" required>
                            <span class="input-group-btn hide">
                                <button class="input-group btn btn-success" id="btnActualizar" type="button">Actualizar</button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Observaciones:</span>
                            <textarea class="form-control has-primary input-sm" name="observaciones" placeholder="Observaciones para este proceso" maxlength="500"><?= rtrim($objeto->getObservaciones())?></textarea> 
                        </div>
                    </div>
                    <div class="hidden">
                        <div class="col-md-12"><input type="hidden" name="idEmpleado" value="<?=$USUARIO->getIdEmpleadoUsuario()?>"></div>
                        <div class="col-md-12"><input type="hidden" name="id" value="<?=$objeto->getId()?>"></div>
                        <div class="col-md-12"><input type="hidden" name="idLlanta" value="<?=$objeto->getIdLlanta()?>"></div>
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
    <div class='modal fade' id='_Dialog_DetallesProceso'>
        <div class='modal-dialog modal-lg'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' id="btnCerrarDialogFormularioLlanta_A" data-dismiss='modal'>&times;</button>
                    <h3 class="text text-primary">INFORMACION<br><small>(Llanta y OS)</small></h3>
                </div>
                <div class="modal-header">
                    <div class="text-justify">
                        <div class="col-sm-12 col-lg-12">
                            <div class="col-sm-12 col-lg-12">
                                <h3>OS: <?= $servicio->getOs() ?></h3>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Cliente:</label><span class="text text-muted"> <?= $servicio->getCliente()->getNombreEmpresa() ?></span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Vendedor:</label><span class="text text-muted"> <?= $servicio->getVendedor()->getPersona()->getNombresCompletos() ?></span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Estado:</label><span class="text text-muted"> <?= $servicio->getNombreEstado() ?></span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Observaciones:</label><span class="text text-muted"> <?= $servicio->getObservaciones() ?></span>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-12">
                            <div class="col-sm-12 col-lg-12">
                                <h3>Llanta</h3>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">RP:</label><span class="text text-muted"> <?= $llanta->getRp() ?></span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Serie:</label><span class="text text-muted"> <?= $llanta->getSerie() ?></span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Marca:</label><span class="text text-muted"> <?= $llanta->getMarca()->getNombre() ?></span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Gravado:</label><span class="text text-muted"> <?= $llanta->getGravado()->getNombre() ?></span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Dise&ntilde;o original:</label><span class="text text-muted"> <?= $llanta->getReferenciaOriginal()->getReferencia() ?></span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Dise&ntilde;o solicitado:</label><span class="text text-muted"> <?= $llanta->getReferenciaSolicitada()->getReferencia() ?></span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Aplicacion rencauche:</label><span class="text text-muted"> <?= $llanta->getAplicacionEntregada()->getReferenciaTipoLlanta()->getTipoLlanta()->getNombre() ?> / <?= $llanta->getAplicacionEntregada()->getMedidaCompleta() ?> (<?= $llanta->getAplicacionEntregada()->getReferenciaTipoLlanta()->getReferencia() ?>)</span>
                            </div>
                            <div class="col-sm-12 col-lg-3">
                                <label class="text-nowrap">Estado:</label><span class="text text-muted"> <?= $llanta->getNombreProcesado()?></span>
                            </div>
                            <div class="col-sm-12 col-lg-3">
                                <label class="text-nowrap">Urgente:</label><span class="text text-muted"> <?= $llanta->getNombreUrgente()?></span>
                            </div>
                            <div class="col-sm-12 col-lg-12">
                                <label class="text-nowrap">Observaciones:</label><span class="text text-muted"> <?= $objeto->getObservaciones() ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-danger' data-dismiss='modal'>Cerrar</button>
                </div>
            </div>
        </div>
        <!--TOOLTIPS-->
        <div class="mdl-tooltip" data-mdl-for="btnCerrarDialogFormularioLlanta_A">Cerrar</div>
        <!--FIN TOOLTIPS-->
        <!--------------------------------------------------------------------->
    </div>
</div>
<script>
    function cargarNumeroRencauche(){
        $("#numeroRencauche").load("system/Scripts/datosJSON.php?metodo=getProximoNumeroRencauche"
        , function(responseTxt, statusTxt, xhr){
          console.log(responseTxt);
          document.getElementById("numeroRencauche").value=responseTxt;
        });
    }

    $(document).ready(function(){
        $("#verDetalles").click();
        //cargarNumeroRencauche();
    });
    
    $("#btnActualizar").click(function (){
        //cargarNumeroRencauche();
    });
</script>