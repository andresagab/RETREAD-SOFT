<?php
require_once dirname(__FILE__).'/../Clases/Persona.php';
require_once dirname(__FILE__).'/../Clases/Contacto_Persona.php';
require_once dirname(__FILE__).'/../Clases/Empleado.php';
if (isset($_GET['id'])) {
    $objeto=new Contacto_Persona('id', $_GET['id'], null, null);
    $empleado=new Empleado('identificacion', "'{$objeto->getIdentificacionPersona()}'", null, "order by id desc limit 1");
    $accion="Modificar";
} else {
    if (isset($_GET['idEmpleado'])) $empleado=new Empleado ('id', $_GET['idEmpleado'], null, null);
    $objeto=new Contacto_Persona(null, null, null, null);
    $objeto->setIdentificacionPersona($empleado->getIdentificacion());
    $accion="Adicionar";
}
?>
<div class="col-md-12">
    <div class="col-md-12" id="paddinTop30"></div>
    <div class="col-md-2 col-sm-12" ></div>
    <div class="col-md-8 col-sm-12" >
        <strong class="text text-success control-label"><h2><?=$accion?> contacto del funcionario <?=$objeto->getPersona()->getNombresCompletos()?></h2></strong>
    </div>
    <div class="col-md-2 col-sm-12"></div>
    <div class="row col-md-12 text-capitalize" id="paddinTop20">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <form class="form-horizontal" name="formulario" method="POST" action="principal.php?CON=system/Pages/contactosPersonaActualizar.php">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Nombres:</span>
                            <input type="text" class="form-control has-primary input-sm" name="nombres" value="<?= rtrim($objeto->getNombres())?>" placeholder="Ejemplo: Pepe" maxlength="50" required="" data-toggle="tooltip" title="Este campo es obligatorio"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Apellidos:</span>
                            <input type="text" class="form-control has-primary input-sm" name="apellidos" value="<?= rtrim($objeto->getApellidos())?>" placeholder="Ejemplo: Perez" maxlength="50" required="" data-toggle="tooltip" title="Este campo es obligatorio"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Telefono:</span>
                            <input type="number" class="form-control has-primary input-sm" name="telefono" value="<?= rtrim($objeto->getTelefono())?>" placeholder="Ejemplo: 7201212" min="0"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Celular:</span>
                            <input type="number" class="form-control has-primary input-sm" name="celular" value="<?= rtrim($objeto->getCelular())?>" placeholder="Ejemplo: 3101234455" min="0" required=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Direccion:</span>
                            <input type="text" class="form-control has-primary input-sm" name="direccion" value="<?= rtrim($objeto->getDireccion())?>" placeholder="Ejemplo: Cll 17 Cra 24 Centro" maxlength="100"/>
                        </div>
                    </div>
                    <div class="hidden">
                        <div class="col-md-12"><input type="hidden" name="id" value="<?=$objeto->getId()?>"></div>
                        <div class="col-md-12"><input type="hidden" name="idEmpleado" value="<?=$empleado->getId()?>"></div>
                        <div class="col-md-12"><input type="hidden" name="identificacionPersona" value="<?=$objeto->getIdentificacionPersona()?>"></div>
                    </div>
                    <div class="col-md-12" id="paddinTop10"></div>
                    <div class="form-group" id="paddinTop30">
                         <div class="col-md-2"></div>
                         <div class="col-md-2"><a href="principal.php?CON=system/Pages/contactosPersona.php&id=<?=$empleado->getId()?>&identificacion=<?=$empleado->getIdentificacion()?>"><input class="btn btn-danger" type="button" name="Cancelar" value="Cancelar"></a></div>
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