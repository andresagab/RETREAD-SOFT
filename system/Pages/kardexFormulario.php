<?php
require_once dirname(__FILE__).'/../Clases/Unidad_Medida.php';
require_once dirname(__FILE__).'/../Clases/Presentacion_Producto.php';
require_once dirname(__FILE__).'/../Clases/Persona.php';
require_once dirname(__FILE__).'/../Clases/Cliente.php';
require_once dirname(__FILE__).'/../Clases/Puc.php';
require_once dirname(__FILE__).'/../Clases/Tercero.php';
require_once dirname(__FILE__).'/../Clases/Producto.php';
if (isset($_GET['id'])) {
    $objeto=new Producto('id', $_GET['id'], null, null);
    $accion="Modificar";
} else {
    $objeto=new Producto(null, null, null, null);
    $accion="Adicionar";
}
?>
<div class="col-md-12">
    <div class="col-md-12" id="paddinTop30"></div>
    <div class="col-md-3" ></div>
    <div class="col-md-6" >
        <strong class="text text-success control-label"><h2><?=$accion?> producto</h2></strong>
    </div>
    <div class="col-md-3" ></div>
    <div class="row col-md-12 text-capitalize" id="paddinTop20">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <form class="form-horizontal" name="formulario" method="POST" action="principal.php?CON=system/Pages/kardexActualizar.php">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <!--<div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Codigo:</span>
                            <input type="text" class="form-control has-primary input-sm" name="codigo" value="<?= rtrim($objeto->getCodPuc())?>" placeholder="Ejemplo: 10214563" maxlength="30" required="" data-toggle="tooltip" title="Este campo es obligatorio"/>
                        </div>
                    </div>-->
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Nombre:</span>
                            <input type="text" class="form-control has-primary input-sm" name="nombre" value="<?= rtrim($objeto->getPuc()->getNombre())?>" placeholder="Ejemplo: Parche" maxlength="50" required="" data-toggle="tooltip" title="Este campo es obligatorio"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Presentacion:</span>
                            <select class="form-control has-primary" name="idPresentacion"><?= Presentacion_Producto::getDatosEnOptions(null, "order by nombre asc", $objeto->getIdPresentacion())?></select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Unidad medida:</span>
                            <select class="form-control has-primary" name="idUnidadMedida"><?= Unidad_Medida::getDatosEnOptions(null, "order by nombre asc", $objeto->getIdPresentacion())?></select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Cliente:</span>
                            <select class="form-control has-primary" name="idProvedor"><?= Tercero::getDatosEnOptions(null, NULL, $objeto->getIdProvedor())?></select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Stock:</span>
                            <input type="number" class="form-control has-primary input-sm" name="stock" value="<?= rtrim($objeto->getStock())?>" placeholder="Ejemplo: 10" min="0"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Stock minimo:</span>
                            <input type="number" class="form-control has-primary input-sm" name="stockMinimo" value="<?= rtrim($objeto->getStockMinimo())?>" placeholder="Ejemplo: 5" min="0"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Stock maximo:</span>
                            <input type="number" class="form-control has-primary input-sm" name="stockMaximo" value="<?= rtrim($objeto->getStockMaximo())?>" placeholder="Ejemplo: 100" min="0"/>
                        </div>
                    </div>
                    <!--
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Costo:</span>
                            <input type="number" class="form-control has-primary input-sm" name="costo" value="<?= rtrim($objeto->getCosto())?>" placeholder="Ejemplo: 15000" min="0"/>
                        </div>
                    </div>-->
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Descripcion:</span>
                            <textarea class="form-control has-primary input-sm" name="descripcion" placeholder="Descripcion para el producto" maxlength="500"><?= rtrim($objeto->getPuc()->getDescripcion())?></textarea>
                        </div>
                    </div>
                    <div class="hidden">
                        <div class="col-md-12"><input type="hidden" name="id" value="<?=$objeto->getId()?>"></div>
                    </div>
                    <div class="col-md-12" id="paddinTop10"></div>
                    <div class="form-group" id="paddinTop30">
                         <div class="col-md-2"></div>
                         <div class="col-md-2"><a href="principal.php?CON=system/Pages/kardex.php"><input class="btn btn-danger" type="button" name="Cancelar" value="Cancelar"></a></div>
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
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>