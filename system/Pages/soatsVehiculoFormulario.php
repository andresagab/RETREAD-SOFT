<?php
require_once dirname(__FILE__).'/../Clases/Persona.php';
require_once dirname(__FILE__).'/../Clases/Vehiculo.php';
require_once dirname(__FILE__).'/../Clases/Marca_Vehiculo.php';
require_once dirname(__FILE__).'/../Clases/Dimension_Llanta.php';
require_once dirname(__FILE__).'/../Clases/Vehiculo.php';
require_once dirname(__FILE__).'/../Clases/Soat.php';
if (isset($_GET['id'])) {
    $objeto=new Soat('id', $_GET['id'], null, null);
    $vehiculo=new Vehiculo('id', "'{$objeto->getIdVehiculo()}'", null, null);
    $accion="Modificar";
} else {
    if (isset($_GET['idVehiculo'])) $vehiculo=new Vehiculo ('id', $_GET['idVehiculo'], null, null);
    $objeto=new Soat(null, null, null, null);
    $accion="Adicionar";
}
?>
<div class="col-md-12">
    <div class="col-md-12" id="paddinTop30"></div>
    <div class="col-md-2 col-sm-12" ></div>
    <div class="col-md-8 col-sm-12" >
        <strong class="text text-success control-label"><h2><?=$accion?> soat del vehiculo <?= rtrim($vehiculo->getPlaca())?></h2></strong>
    </div>
    <div class="col-md-2 col-sm-12"></div>
    <div class="row col-md-12 text-capitalize" id="paddinTop20">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <form class="form-horizontal" name="formulario" method="POST" action="principal.php?CON=system/Pages/soatsvehiculoActualizar.php">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Inicio vigencia:</span>
                            <input type="date" class="form-control has-primary input-sm" name="fechaInicioVigencia" value="<?= $objeto->getFechaInicioVigencia()?>" required="" data-toggle="tooltip" title="Este campo es obligatorio"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Fin vigencia:</span>
                            <input type="date" class="form-control has-primary input-sm" name="fechaFinVigencia" value="<?= $objeto->getFechaFinVigencia()?>" required="" data-toggle="tooltip" title="Este campo es obligatorio"/>
                        </div>
                    </div>
                    <div class="hidden">
                        <div class="col-md-12"><input type="hidden" name="id" value="<?=$objeto->getId()?>"></div>
                        <div class="col-md-12"><input type="hidden" name="idVehiculo" value="<?=$vehiculo->getId()?>"></div>
                        <div class="col-md-12"><input type="hidden" name="idCliente" value="<?=$_GET['idCliente']?>"></div>
                    </div>
                    <div class="col-md-12" id="paddinTop10"></div>
                    <div class="form-group" id="paddinTop30">
                         <div class="col-md-2"></div>
                         <div class="col-md-2"><a href="principal.php?CON=system/Pages/soatsVehiculo.php&id=<?=$vehiculo->getId()?>&idCliente=<?=$_GET['idCliente']?>"><input class="btn btn-danger" type="button" name="Cancelar" value="Cancelar"></a></div>
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