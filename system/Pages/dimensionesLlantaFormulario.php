<?php
require_once dirname(__FILE__).'/../Clases/Dimension_Llanta.php';
if (isset($_GET['id'])) {
    $objeto=new Dimension_Llanta('id', $_GET['id'], null, null);
    $accion="Modificar";
} else {
    $objeto=new Dimension_Llanta(null, null, null, null);
    $accion="Adicionar";
}
?>
<div class="col-md-12">
    <div class="col-md-12" id="paddinTop30"></div>
    <div class="col-md-3" ></div>
    <div class="col-md-6" >
        <strong class="text text-success control-label"><h2><?=$accion?> dimension de llanta</h2></strong>
    </div>
    <div class="col-md-3" ></div>
    <div class="row col-md-12 text-capitalize" id="paddinTop20">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <form class="form-horizontal" name="formulario" method="POST" action="principal.php?CON=system/Pages/dimensionesLlantaActualizar.php">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">* Dimension:</span>
                            <input type="text" class="form-control has-primary input-sm" name="dimension" value="<?= $objeto->getDimension(); ?>" placeholder="Ejemplo: 200/22 R17.5"  required="" data-toggle="tooltip" title="Este campo es obligatorio"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Descripcion:</span>
                            <textarea class="form-control has-primary input-sm" name="descripcion" placeholder="Descripcion para la marca de vehiculo" maxlength="500"><?= rtrim($objeto->getDescripcion())?></textarea>
                        </div>
                    </div>
                    <div class="hidden">
                        <div class="col-md-12"><input type="hidden" name="id" value="<?=$objeto->getId()?>"></div>
                    </div>
                    <div class="col-md-12" id="paddinTop10"></div>
                    <div class="form-group" id="paddinTop30">
                         <div class="col-md-2"></div>
                         <div class="col-md-2"><a href="principal.php?CON=system/Pages/dimensionesLlanta.php"><input class="btn btn-danger" type="button" name="Cancelar" value="Cancelar"></a></div>
                         <div class="col-md-2"></div>
                         <div class="col-md-2"><input class="btn btn-success" type="submit" name="accion" value="<?=$accion?>"></div>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </form>
        </div>
        <div class="col-md-1"></div>
    </div>
</div>