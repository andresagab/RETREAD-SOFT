<?php
require_once dirname(__FILE__) . '/../../lib/php/functions.system.php';
require_once dirname(__FILE__) . '/../Clases/Persona.php';
require_once dirname(__FILE__) . '/../Clases/Cliente.php';
require_once dirname(__FILE__) . '/../Clases/Empleado.php';
require_once dirname(__FILE__) . '/../Clases/Servicio.php';
require_once dirname(__FILE__) . '/../Clases/Tipo_Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Marca_Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Rechazo_Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Dimension_Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Gravado_Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Referencia_Tipo_Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Dimension_Referencia.php';
require_once dirname(__FILE__) . '/../Clases/Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Salida_Llanta.php';
require_once dirname(__FILE__) . '/../Clases/Inspeccion_Inicial.php';
require_once dirname(__FILE__) . '/../Clases/Servicio_Fin.php';
if (isset($_GET['id'])) {
    $objeto=new Llanta('id', $_GET['id'], null, null);
    $accion="Modificar";
    $hideRP="hidden";
    $json=Llanta::getObjetoJSON('id', $objeto->getId(), null, null);
    if ($objeto->getUrgente()) $checked='checked';
    else $checked='';
}
?>
<script src="lib/controladores/llantasFormulario.js"></script>
<div class="col-md-12" ng-controller="llantasFormulario">
    <div class="col-md-12 hidden" id="btnActualizar" ng-click="cargarRP()"></div>
	<div class="col-md-12 text-center">
        <strong class="text mdl-color-text--teal control-label text-uppercase"><h2><?=$accion?> llanta</h2></strong>
	</div>
    <div class="col-md-12 text-center" ng-show="pageData.spinnerCarga">
        <div class="mdl-spinner mdl-js-spinner is-active"></div>
    </div>
	<div class="row col-md-12 text-capitalize" id="paddinTop20">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <form class="form-horizontal" name="formulario" method="POST" action="principal.php?CON=system/Pages/llantasActualizar.php">
                <div class="col-md-12" style="align-items: center;">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">* Marca:</span>
                            <select class="form-control has-primary input-group-sm" name="idMarca" id="txtIdMarca"><?= Marca_Llanta::getDatosEnOptions(null, "order by nombre asc", $objeto->getIdMarca())?></select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">* Gravado:</span>
                            <select class="form-control has-primary input-group-sm" name="idGravado" id="txtIdGravado"><?= Gravado_Llanta::getDatosEnOptions(null, "order by nombre asc", $objeto->getIdGravado())?></select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">* Serie:</span>
                            <input class="form-control input-group-sm" id="txtSerie" name="serie" value="<?= $objeto->getSerie() ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">* Referencia original:</span>
                            <select class="form-control has-primary input-group-sm" id="spnTipoLlantaOriginal" name="idTipoLlantaOriginal" ng-model="pageData.idTipoLlantaOriginal" ng-change="loadReferenciasTipoLlanta(0)" required><?=  Tipo_Llanta::getDatosEnOptions(null, 'order by nombre asc', $objeto->getReferenciaOriginal()->getIdTipoLlanta()) ?></select>
                            <select ng-show="pageData.elements.spnReferenciaOriginal" class="form-control has-primary input-group-sm" id="spnReferenciaOriginal" name="idReferenciaOriginal" required>
                                <option ng-repeat="objeto in pageData.referenciasOriginales" value="{{ objeto.id }}">{{ objeto.referencia }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">* Referencia solicitada:</span>
                            <select class="form-control has-primary input-group-sm" id="spnTipoLlantaSolicitada" name="idTipoLlantaSolicitada" ng-model="pageData.idTipoLlantaSolicitada" ng-change="loadReferenciasTipoLlanta(1)" required><?=  Tipo_Llanta::getDatosEnOptions(null, 'order by nombre asc', $objeto->getReferenciaSolicitada()->getIdTipoLlanta()) ?></select>
                            <select ng-show="pageData.elements.spnReferenciaSolicitada" class="form-control has-primary input-group-sm" id="spnReferenciaSolicitada" name="idReferenciaSolicitada" required>
                                <option ng-repeat="objeto in pageData.referenciasSolicitadas" value="{{ objeto.id }}">{{ objeto.referencia }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">* Dimensi&oacute;n:</span>
                            <select class="form-control has-primary input-group-sm" id="spnDimensiones" name="idDimension" required><?= Dimension_Llanta::getDatosEnOptions(null, "order by dimension asc", $objeto->getIdDimension())?></select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Urgente:</span>
                            <span class="input-group-addon">
                                <span id="paddingLeft70"></span>
                                    <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="chkUrgente">
                                        <input type="checkbox" id="chkUrgente" class="mdl-switch__input" name="urgente" ng-model="pageData.urgente" ng-checked="pageData.urgente" <?= $checked ?>>
                                    </label>
                                </span>
                            <span class="input-group-addon"><label id="textoEstado">{{ cargarNombreUrgenteChk(pageData.urgente) }}</label></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Observaciones:</span>
                            <textarea class="form-control has-primary input-sm" name="observaciones" placeholder="Observaciones para esta llanta" maxlength="300"><?= rtrim($objeto->getObservaciones())?></textarea> 
                        </div>
                    </div>
                    <div class="hidden">
                        <input type="hidden" name="id" value="<?=$objeto->getId()?>">
                    </div>
                    <div class="col-md-12" id="paddinTop20">
                        <a href="principal.php?CON=system/Pages/ordenesServicioFormulario.php&id=<?= $objeto->getIdServicio(); ?>"><input class="btn btn-danger" type="button" name="Cancelar" value="Cancelar"></a>
                        <input class="btn btn-info" type="submit" name="accion" value="<?=$accion?>">
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-1"></div>
	</div>
</div>
<script>
    $(document).ready(function () {
        sessionStorage.setItem('llantaFrm', JSON.stringify(<?= $json ?>));
    });
</script>