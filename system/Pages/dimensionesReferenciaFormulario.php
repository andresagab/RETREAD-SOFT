<?php
require_once dirname(__FILE__).'/../Clases/Tipo_Llanta.php';
require_once dirname(__FILE__).'/../Clases/Referencia_Tipo_Llanta.php';
require_once dirname(__FILE__).'/../Clases/Dimension_Referencia.php';
if (isset($_GET['id'])) {
    $objeto=new Dimension_Referencia('id', $_GET['id'], null, null);
    $accion="Modificar";
} else {
    $objeto=new Dimension_Referencia(null, null, null, null);
    $objeto->setIdReferenciaTipoLlanta($_GET['idReferencia']);
    $accion="Adicionar";
}
$referencia=$objeto->getReferenciaTipoLlanta();
$gravado=$referencia->getTipoLlanta();
?>
<div class="col-md-12">
    <div class="col-md-12" id="paddinTop30"></div>
    <div class="col-md-3" ></div>
    <div class="col-md-6" >
        <strong class="text text-success control-label"><h2><?=$accion?> medidas <small class="text-muted">(ref: <?= $referencia->getReferencia() ?>)</small></h2></strong>
    </div>
    <div class="col-md-3" ></div>
    <div class="row col-md-12 text-capitalize" id="paddinTop20">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <form class="form-horizontal" name="formulario" method="POST" action="principal.php?CON=system/Pages/dimensionesReferenciaActualizar.php">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">* Base:</span>
                            <input type="number" class="form-control has-primary input-sm" id="base" name="base" value="<?= rtrim($objeto->getBase())?>" placeholder="Ejemplo: 190" min="0" step="any" required>
                            <div class="mdl-tooltip" for="base">Este campo es obligatorio</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">* Profundidad:</span>
                            <input type="number" class="form-control has-primary input-sm" id="profundidad" name="profundidad" value="<?= rtrim($objeto->getProfundidad())?>" placeholder="Ejemplo: 190" min="0" step="any" required>
                            <div class="mdl-tooltip" for="profundidad">Este campo es obligatorio</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">* Peso:</span>
                            <input type="number" class="form-control has-primary input-sm" id="peso" name="peso" value="<?= rtrim($objeto->getPeso())?>" placeholder="Ejemplo: 5.16" min="0" step="any" required>
                            <div class="mdl-tooltip" for="peso">Este campo es obligatorio</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">* Largo:</span>
                            <input type="number" class="form-control has-primary input-sm" id="largo" name="largo" value="<?= rtrim($objeto->getLargo())?>" placeholder="Ejemplo: -11.03" step="any" required>
                            <div class="mdl-tooltip" for="largo">Este campo es obligatorio</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Observaciones:</span>
                            <textarea class="form-control has-primary input-sm" name="observaciones" placeholder="Observaciones para este registro" maxlength="1000"><?= rtrim($objeto->getObservaciones())?></textarea>
                        </div>
                    </div>
                    <div class="hidden">
                        <div class="col-md-12"><input type="hidden" name="id" value="<?=$objeto->getId()?>"></div>
                        <div class="col-md-12"><input type="hidden" name="idReferenciaGravado" value="<?=$referencia->getId()?>"></div>
                    </div>
                    <div class="form-group" id="paddinTop20">
                        <button onclick="window.location='principal.php?CON=system/Pages/dimensionesReferencia.php&id=<?=$referencia->getId()?>'" class="btn btn-danger" type="button" name="Cancelar">Cancelar</button>
                        <input class="btn btn-info" type="submit" name="accion" value="<?=$accion?>">
                    </div>
                </div>
                <div class="col-md-3"></div>
            </form>
        </div>
        <div class="col-md-1"></div>
    </div>
</div>