<?php
require_once dirname(__FILE__).'/../Clases/Tipo_Llanta.php';
if (isset($_GET['id'])) {
    $objeto=new Tipo_Llanta('id', $_GET['id'], null, null);
    $accion="Modificar";
} else {
    $objeto=new Tipo_Llanta(null, null, null, null);
    $accion="Adicionar";
}
?>
<div class="col-md-12">
    <div class="col-md-12" id="paddinTop30"></div>
    <div class="col-md-4" ></div>
    <div class="col-md-4" >
        <strong class="text text-success control-label"><h2><?=$accion?> tipo de llanta</h2></strong>
    </div>
    <div class="col-md-4" ></div>
    <div class="row col-md-12 text-capitalize" id="paddinTop20">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <form class="form-horizontal" name="formulario" method="POST" action="principal.php?CON=system/Pages/tiposLlantasActualizar.php">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">* Nombre:</span>
                            <input type="text" class="form-control has-primary input-sm" name="nombre" value="<?= rtrim($objeto->getNombre())?>" placeholder="Ejemplo: Convencional" maxlength="50" required="" data-toggle="tooltip" title="Este campo es obligatorio"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Descripcion:</span>
                            <textarea class="form-control has-primary input-sm" name="descripcion" placeholder="Descripcion para el tipo de llanta" maxlength="300"><?= rtrim($objeto->getDescripcion())?></textarea> 
                        </div>
                    </div>
                    <div class="hidden">
                        <div class="col-md-12"><input type="hidden" name="id" value="<?=$objeto->getId()?>"></div>
                    </div>
                    <div class="col-md-12" id="paddinTop10"></div>
                    <div class="form-group" id="paddinTop20">
                        <button onclick="window.location='principal.php?CON=system/Pages/tiposLlantas.php'" class="btn btn-danger" type="button" name="Cancelar">Cancelar</button>
                        <input class="btn btn-info" type="submit" name="accion" value="<?=$accion?>">
                    </div>
                </div>
                <div class="col-md-4"></div>
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