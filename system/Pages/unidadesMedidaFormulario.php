<?php
require_once dirname(__FILE__).'/../Clases/Unidad_Medida.php';
if (isset($_GET['id'])) {
    $objeto=new Unidad_Medida('id', $_GET['id'], null, null);
    $accion="Modificar";
} else {
    $objeto=new Unidad_Medida(null, null, null, null);
    $accion="Adicionar";
}
?>
<div class="col-md-12">
    <div class="col-md-12" id="paddinTop30"></div>
    <div class="col-md-3" ></div>
    <div class="col-md-6" >
        <strong class="text text-success control-label"><h2><?=$accion?> unidad de medida</h2></strong>
    </div>
    <div class="col-md-3" ></div>
    <div class="row col-md-12 text-capitalize" id="paddinTop20">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <form class="form-horizontal" name="formulario" method="POST" action="principal.php?CON=system/Pages/unidadesMedidaActualizar.php">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">* Nombre:</span>
                            <input type="text" class="form-control has-primary input-sm" name="nombre" value="<?= rtrim($objeto->getNombre())?>" placeholder="Ejemplo: Gramo" maxlength="50" required="" data-toggle="tooltip" title="Este campo es obligatorio"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">* Sigla:</span>
                            <input type="text" class="form-control has-primary input-sm" name="sigla" value="<?= rtrim($objeto->getSigla())?>" placeholder="Ejemplo: Gr" maxlength="10" required="" data-toggle="tooltip" title="Este campo es obligatorio"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Descripcion:</span>
                            <textarea class="form-control has-primary input-sm" name="descripcion" placeholder="Descripcion para la unidad de medida" maxlength="500"><?= rtrim($objeto->getDescripcion())?></textarea>
                        </div>
                    </div>
                    <div class="hidden">
                        <div class="col-md-12"><input type="hidden" name="id" value="<?=$objeto->getId()?>"></div>
                    </div>
                    <div class="form-group" id="paddinTop30">
                        <button onclick="window.location='principal.php?CON=system/Pages/unidadesMedida.php'" class="btn btn-danger" type="button" name="Cancelar">Cancelar</button>
                        <input class="btn btn-info" type="submit" name="accion" value="<?=$accion?>">
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
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>