<?php
require_once dirname(__FILE__).'/../Clases/Persona.php';
require_once dirname(__FILE__).'/../Clases/Cliente.php';
require_once dirname(__FILE__).'/../Clases/Marca_Vehiculo.php';
require_once dirname(__FILE__).'/../Clases/Dimension_Llanta.php';
require_once dirname(__FILE__).'/../Clases/Vehiculo.php';
if (isset($_GET['id'])) {
    $objeto=new Vehiculo('id', $_GET['id'], null, null);
    $cliente=new Cliente('identificacion', "'{$objeto->getIdentificacion()}'", null, "order by id desc limit 1");
    $accion="Modificar";
} else {
    if (isset($_GET['idCliente'])) $cliente=new Cliente ('id', $_GET['idCliente'], null, null);
    $objeto=new Vehiculo(null, null, null, null);
    $objeto->setIdentificacion($cliente->getIdentificacion());
    $accion="Adicionar";
}
?>
<div class="col-md-12">
    <div class="col-md-12" id="paddinTop30"></div>
    <div class="col-md-2 col-sm-12" ></div>
    <div class="col-md-8 col-sm-12" >
        <strong class="text text-success control-label"><h2><?=$accion?> vehiculo del cliente <?=$objeto->getPersona()->getNombresCompletos()?> <small class="text text-capitalize">(<?= rtrim($cliente->getRazonSocial())?>)</small></h2></strong>
    </div>
    <div class="col-md-2 col-sm-12"></div>
    <div class="row col-md-12 text-capitalize" id="paddinTop20">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <form class="form-horizontal" name="formulario" method="POST" action="principal.php?CON=system/Pages/vehiculosActualizar.php">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Placa:</span>
                            <input type="text" class="form-control has-primary input-sm" name="placa" value="<?= rtrim($objeto->getPlaca())?>" placeholder="Ejemplo: AAA-000" maxlength="7" required="" data-toggle="tooltip" title="Este campo es obligatorio"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Linea:</span>
                            <input type="text" class="form-control has-primary input-sm" name="linea" value="<?= rtrim($objeto->getLinea())?>" placeholder="" maxlength="20"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Modelo:</span>
                            <input type="text" class="form-control has-primary input-sm" name="modelo" value="<?= rtrim($objeto->getModelo())?>" placeholder="" maxlength="30"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Clase:</span>
                            <input type="text" class="form-control has-primary input-sm" name="clase" value="<?= rtrim($objeto->getClase())?>" placeholder="" maxlength="30"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Marca:</span>
                            <select class="form-control has-success" name="idMarcaVehiculo">
                                <?= Marca_Vehiculo::getDatosEnOptions(null, "order by id desc", $objeto->getIdMarcaVehiulo())?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Combustible:</span>
                            <select class="form-control has-success" name="combustible">
                                <?= Vehiculo::getCombustiblesOptions($objeto->getCombustible())?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">N° llantas:</span>
                            <input type="number" class="form-control has-primary input-sm" name="numeroLlantas" value="<?= rtrim($objeto->getNumeroLlantas())?>" placeholder="Ejemplo: 4" min="0" required=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Dimension llantas:</span>
                            <select class="form-control has-success" name="idDimension">
                                <?= Dimension_Llanta::getDatosEnOptions(null, "order by id desc", $objeto->getIdDimension())?>
                            </select>
                        </div>
                    </div>
                    <div class="hidden">
                        <div class="col-md-12"><input type="hidden" name="id" value="<?=$objeto->getId()?>"></div>
                        <div class="col-md-12"><input type="hidden" name="idCliente" value="<?=$cliente->getId()?>"></div>
                        <div class="col-md-12"><input type="hidden" name="identificacion" value="<?=$cliente->getIdentificacion()?>"></div>
                    </div>
                    <div class="col-md-12" id="paddinTop10"></div>
                    <div class="form-group" id="paddinTop30">
                         <div class="col-md-2"></div>
                         <div class="col-md-2"><a href="principal.php?CON=system/Pages/vehiculos.php&id=<?=$cliente->getId()?>"><input class="btn btn-danger" type="button" name="Cancelar" value="Cancelar"></a></div>
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