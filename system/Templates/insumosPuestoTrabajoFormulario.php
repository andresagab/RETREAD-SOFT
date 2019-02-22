<?php
session_start();
require_once dirname(__FILE__) . "\..\Clases\Producto.php";
require_once dirname(__FILE__) . "\..\Clases\Usuario.php";
?>
<div class="col-md-2 col-sm-12" ></div>
<div class="col-md-8 col-sm-12" >
    <strong class="text text-success control-label"><h2>Adicionar insumo</h2></strong>
</div>
<div class="col-md-2 col-sm-12"></div>
<div class="row col-md-12 text-capitalize" id="paddinTop20">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <form class="form-horizontal" name="formulario" method="POST" action="principal.php?CON=system/Pages/insumosPuestoTrabajoActualizar.php">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">Insumo:</span>
                        <select class="form-control has-success" name="idInsumo">
                            <?= Producto::getDatosEnOptions("stock>stockMinimo and stock<=stockMaximo", "order by id desc", $objeto->getIdInsumo())?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">Cantidad:</span>
                        <input type="number" class="form-control has-primary input-sm" name="cantidad" value="<?= $objeto->getCantidad() ?>" placeholder="Ejemplo: 2" min="1" required=""/>
                    </div>
                </div>
                <div class="hidden">
                    <div class="col-md-12"><input type="hidden" name="id" value=""></div>
                    <div class="col-md-12"><input type="hidden" name="idPT" value=""></div>
                    <div class="col-md-12"><input type="hidden" name="idPuestoTrabajo" value=""></div>
                    <div class="col-md-12"><input type="hidden" name="usuario" value="<?=$USUARIO->getUsuario()?>"></div>
                </div>
                <div class="col-md-12" id="paddinTop10"></div>
                <div class="form-group" id="paddinTop30">
                     <div class="col-md-2"></div>
                     <div class="col-md-2"><a href="principal.php?CON=system/Pages/insumosPuestoTrabajo.php&idPT=<?=$puestoTrabajo->getId()?>"><input class="btn btn-danger" type="button" name="Cancelar" value="Cancelar"></a></div>
                     <div class="col-md-2"></div>
                     <div class="col-md-2"><input class="btn btn-info" type="submit" name="accion" value="<?=$accion?>"></div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </form>
    </div>
    <div class="col-md-1"></div>
</div>