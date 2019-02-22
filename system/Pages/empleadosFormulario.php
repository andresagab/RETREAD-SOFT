<?php
require_once dirname(__FILE__).'/../Clases/Persona.php';
require_once dirname(__FILE__).'/../Clases/Cargo_Empleado.php';
require_once dirname(__FILE__).'/../Clases/Empleado.php';
if (isset($_GET['id'])) {
    $objeto=new Empleado('id', $_GET['id'], null, null);
    $accion="Modificar";
} else {
    $objeto=new Empleado(null, null, null, null);
    $accion="Adicionar";
    $objeto->getPersona()->setFechaNacimiento(date("Y-m-d"));
}
?>
<div class="col-md-12">
	<div class="col-md-4" ></div>
	<div class="col-md-4" >
            <strong class="text mdl-color-text--teal control-label text-uppercase"><h2><?=$accion?> funcionario</h2></strong>
	</div>
	<div class="col-md-4" ></div>
	<div class="row col-md-12 text-capitalize" id="paddinTop20">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <form class="form-horizontal" name="formulario" method="POST" action="principal.php?CON=system/Pages/empleadosActualizar.php">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group">
                            <label class="input-group-addon">* Identificacion:</label>
                            <input type="number" class="input-group-sm form-control has-primary" name="identificacion" value="<?= rtrim($objeto->getIdentificacion())?>" placeholder="Ejemplo: 1457822" maxlength="20" required=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <label class="input-group-addon">* Nombres:</label>
                            <input type="text" class="form-control has-primary" name="nombres" value="<?= rtrim($objeto->getPersona()->getNombres())?>" placeholder="Ejemplo: Juan" maxlength="50" required=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <label class="input-group-addon">* Apellidos:</label>
                            <input type="text" class="form-control has-primary" name="apellidos" value="<?= rtrim($objeto->getPersona()->getApellidos())?>" placeholder="Ejemplo: Martinez" maxlength="50" required=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <label class="input-group-addon">Celular:</label>
                            <input type="number" class="form-control has-primary" name="celular" value="<?= rtrim($objeto->getPersona()->getCelular())?>" placeholder="Ejemplo: 3001234455" required="" min="0"/>
                        </div>
                    </div>
                    <div class="form-group hidden">
                        <label class="control-label col-md-5">Email:</label>
                        <div class="col-md-3">
                            <input type="email" class="form-control has-primary" name="email" value="<?= rtrim($objeto->getPersona()->getEmail())?>" placeholder="Ejemplo: algo@gmail.com" maxlength="50"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <label class="input-group-addon">Direccion:</label>
                            <input type="text" class="form-control has-primary" name="direccion" value="<?= rtrim($objeto->getPersona()->getDireccion())?>" placeholder="Ejemplo: Cll 17 Cra 24" maxlength="100"/>
                        </div>
                    </div>
                    <div class="col-md-12" id="paddinTop10"></div>
                    <div class="form-group">
                        <div class="input-group">
                            <label class="input-group-addon">* Fecha Nacimiento:</label>
                            <input type="date" id="fechaNacimiento" class="form-control has-primary" name="fechaNacimiento" value="<?= rtrim($objeto->getPersona()->getFechaNacimiento())?>" required>
                        </div>
                    </div>
                    <div class="col-md-12" id="paddinTop10"></div>
                    <div class="form-group">
                        <div class="input-group">
                            <label class="input-group-addon">* Cargo:</label>
                            <select class="form-control has-primary" id="cargos" name="idCargo"><?= Rol::getDatosEnOptions(null, null, $objeto->getIdCargo())?></select>
                        </div>
                    </div>
                    <div class="hidden">
                        <div class="col-md-12"><input type="hidden" name="identificacionAnterior" value="<?= rtrim($objeto->getPersona()->getIdentificacion())?>"></div>
                        <div class="col-md-12"><input type="hidden" name="id" value="<?=$objeto->getId()?>"></div>
                    </div>
                    <div class="col-md-12" id="paddinTop10"></div>
                    <div class="form-group" id="paddinTop30">
                        <button onclick="window.location='principal.php?CON=system/Pages/empleados.php'" class="btn btn-danger" type="button" name="Cancelar">Cancelar</button>
                        <input class="btn btn-success" type="submit" name="accion" value="<?=$accion?>">
                    </div>
                </div>
                <div class="col-md-3"></div>
            </form>
        </div>
        <div class="col-md-1"></div>
	</div>
</div>
<script>
    
    /*
    $("#fechaNacimiento").datepicker({
       inline: true
    });
    */
</script>