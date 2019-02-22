<?php
require_once dirname(__FILE__).'\..\Clases\Persona.php';
require_once dirname(__FILE__).'\..\Clases\Cliente.php';
require_once dirname(__FILE__).'\..\Clases\Tipo_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Marca_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Gravado_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Empleado.php';
require_once dirname(__FILE__).'\..\Clases\Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Servicio.php';
if (isset($_GET['id'])) {
    $objeto=new Servicio('id', $_GET['id'], null, null);
    $llanta=$objeto->getLlanta();
    $accion="Modificar";
    if ($objeto->getUrgente()) $checked='checked';
    else $checked='';
} else {
    $objeto=new Servicio(null, null, null, null);
    $objeto->setIdLlanta($_GET['idLlanta']);
    $llanta=new Llanta('id', $_GET['idLlanta'], null, null);
    $accion="Adicionar";
    $checked='checked';
}
?>
<div class="col-md-12">
	<div class="col-md-12" id="paddinTop30"></div>
	<div class="col-md-3" ></div>
	<div class="col-md-6" >
            <strong class="text text-success control-label"><h2><?=$accion?> servicio para la llanta <?= rtrim($llanta->getSerie()) ?></h2></strong>
	</div>
	<div class="col-md-3" ></div>
	<div class="row col-md-12 text-capitalize" id="paddinTop20">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <form class="form-horizontal" name="formulario" method="POST" action="principal.php?CON=system/Pages/serviciosLlantaActualizar.php">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Vendedor:</span>
                            <select class="form-control has-primary input-group-sm" name="idVendedor"><?= Empleado::getDatosEnOptions(null, "order by identificacion asc", $objeto->getIdVendedor())?></select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Orden servicio:</span>
                            <input class="form-control has-primary" id="os" type="number" name="os" value="<?=$objeto->getOs()?>" placeholder="Ejemplo: 112233" required="" min="0">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Dise&ntilde;o solicitado:</span>
                            <select class="form-control has-primary input-group-sm" name="idDisenoSolicitado"><?= Gravado_Llanta::getDatosEnOptions(null, "order by nombre asc", $objeto->getIdDisenoSolicitado())?></select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Dise&ntilde;o final:</span>
                            <select class="form-control has-primary input-group-sm" name="idDisenoFinal"><?= Gravado_Llanta::getDatosEnOptions(null, "order by nombre asc", $objeto->getIdDisenoFinal())?></select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Urgente:</span>
                            <span class="input-group-addon"><input type="checkbox" name="urgente" <?=$checked?> id="estado"/></span>
                            <span class="input-group-addon"><label id="textoEstado"></label></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <label class="input-group-addon">Fecha entrega:</label>
                            <input type="date" id="fechaEntrega" class="form-control has-primary" name="fechaEntrega" value="<?= rtrim($objeto->getFechaEntrega())?>" required=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Observaciones:</span>
                            <textarea class="form-control has-primary input-sm" name="observaciones" placeholder="Observaciones para esta servicio" maxlength="500"><?= rtrim($objeto->getObservaciones())?></textarea> 
                        </div>
                    </div>
                    <div class="hidden">
                        <div class="col-md-12"><input type="hidden" name="idLlanta" value="<?=$objeto->getIdLlanta()?>"></div>
                        <div class="col-md-12"><input type="hidden" name="id" value="<?=$objeto->getId()?>"></div>
                    </div>
                    <div class="col-md-12" id="paddinTop10"></div>
                    <div class="form-group" id="paddinTop30">
                         <div class="col-md-2"></div>
                         <div class="col-md-2"><a href="principal.php?CON=system/Pages/llantas.php"><input class="btn btn-danger" type="button" name="Cancelar" value="Cancelar"></a></div>
                         <div class="col-md-2"></div>
                         <div class="col-md-2"><input class="btn btn-info" type="submit" name="accion" value="<?=$accion?>"></div>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </form>
        </div>
        <div class="col-md-1"></div>
	</div>
</div>
<script>
    $(document).ready(function(){
        if(document.getElementById("estado").checked) document.getElementById("textoEstado").innerHTML='Si';
        else document.getElementById("textoEstado").innerHTML='No';
    });
    
    $("#estado").click(function(){
        if(document.getElementById("estado").checked) document.getElementById("textoEstado").innerHTML='Si';
        else document.getElementById("textoEstado").innerHTML='No';
    });
</script>