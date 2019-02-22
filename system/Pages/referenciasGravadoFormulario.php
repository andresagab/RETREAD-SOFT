<?php
require_once dirname(__FILE__).'/../Clases/Tipo_Llanta.php';
require_once dirname(__FILE__).'/../Clases/Referencia_Tipo_Llanta.php';
if (isset($_GET['id'])) {
    $objeto=new Referencia_Tipo_Llanta('id', $_GET['id'], null, null);
    $accion="Modificar";
} else {
    $objeto=new Referencia_Tipo_Llanta(null, null, null, null);
    $objeto->setIdTipoLlanta($_GET['idGravado']);
    $accion="Adicionar";
}
$tipoLlanta=$objeto->getTipoLlanta();
?>
<div class="col-md-12">
    <div class="col-md-3" ></div>
    <div class="col-md-6" >
        <strong class="text text-success control-label"><h2><?=$accion?> referencia <small class="text-capitalize">(<?= $tipoLlanta->getNombre() ?>)</small></h2></strong>
    </div>
    <div class="col-md-3" ></div>
    <div class="row col-md-12 text-capitalize" id="paddinTop20">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <form class="form-horizontal" name="formulario" method="POST" action="principal.php?CON=system/Pages/referenciasGravadoActualizar.php">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">* Referencia:</span>
                            <input type="text" class="form-control has-primary input-sm" id="referencia" name="referencia" value="<?= rtrim($objeto->getReferencia())?>" placeholder="Ejemplo: IDE2" maxlength="15" required=""/>
                            <div class="mdl-tooltip" for="referencia">Este campo es obligatorio</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Observaciones:</span>
                            <textarea class="form-control has-primary input-sm" name="observaciones" placeholder="Observaciones para el gravado" maxlength="1000"><?= rtrim($objeto->getObservaciones())?></textarea>
                        </div>
                    </div>
                    <div class="hidden">
                        <div class="col-md-12"><input type="hidden" name="id" value="<?=$objeto->getId()?>"></div>
                        <div class="col-md-12"><input type="hidden" name="idGravadoLlanta" value="<?=$tipoLlanta->getId()?>"></div>
                    </div>
                    <div class="form-group" id="paddinTop20">
                        <button onclick="window.location='principal.php?CON=system/Pages/referenciasGravado.php&id=<?=$tipoLlanta->getId()?>'" class="btn btn-danger" type="button" name="Cancelar">Cancelar</button>
                        <input class="btn btn-info" type="submit" name="accion" value="<?=$accion?>">
                    </div>
                </div>
                <div class="col-md-3"></div>
            </form>
        </div>
        <div class="col-md-1"></div>
    </div>
</div>