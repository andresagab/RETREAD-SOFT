<?php
require_once dirname(__FILE__).'/../Clases/Persona.php';
require_once dirname(__FILE__).'/../Clases/Cargo_Empleado.php';
require_once dirname(__FILE__).'/../Clases/Empleado.php';
require_once dirname(__FILE__).'/../Clases/Usuario_Persona.php';
if (isset($_GET['id'])) {
    $objeto=new Usuario_Persona('id', $_GET['id'], null, null);
    $persona=$objeto->getPersona();
    $accion="Modificar";
    if ($objeto->getUsuario()->getEstado()) $checked="checked";
    else $checked='';
} else {
    $objeto=new Usuario_Persona(null, null, null, null);
    $accion="Adicionar";
    $objeto->setIdentificacion($_GET['identificacion']);
    $objeto->getPersona()->setFechaNacimiento(date("Y-m-d"));
    $persona=new Persona('identificacion', "'{$_GET['identificacion']}'", null, null);
    $checked="checked";
}
?>
<div class="col-md-12">
	<div class="col-md-12" id="paddinTop30"></div>
	<div class="col-md-4" ></div>
	<div class="col-md-4" >
            <strong class="text text-success control-label"><h2><?=$accion?> usuario para <?= rtrim($persona->getNombresCompletos())?></h2></strong>
	</div>
	<div class="col-md-4" ></div>
	<div class="row col-md-12 text-capitalize" id="paddinTop20">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <form class="form-horizontal" name="formulario" method="POST" action="principal.php?CON=system/Pages/usuariosPersonaActualizar.php">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Usuario:</span>
                            <input type="text" class="form-control has-primary" name="usuario" value="<?= rtrim($objeto->getUsuario()->getUsuario())?>" placeholder="Ejemplo: Usuario123" maxlength="30" required=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Contraseña:</span>
                            <input type="password" class="form-control has-primary" name="clave" id="clave" value="<?= rtrim($objeto->getUsuario()->getClave())?>" maxlength="35" required=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Repetir contaseña:</span>
                            <input type="password" class="form-control has-primary" name="claveR" id="claveR" value="<?= rtrim($objeto->getUsuario()->getClave())?>" maxlength="35" required=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Estado:</span>
                            <span class="input-group-addon"><input type="checkbox" name="estado" <?=$checked?> id="estado"/></span>
                            <span class="input-group-addon"><label id="textoEstado"></label></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Rol:</span>
                            <select class="form-control has-primary" id="cargos" name="idRol"><?= Rol::getDatosEnOptions(null, null, $objeto->getUsuario()->getIdRol())?></select>
                        </div>
                    </div>
                    <div class="hidden">
                        <div class="col-md-12"><input type="hidden" name="identificacion" value="<?=$objeto->getIdentificacion()?>"></div>
                        <div class="col-md-12"><input type="hidden" name="id" value="<?=$objeto->getId()?>"></div>
                    </div>
                    <div class="col-md-12" id="paddinTop10"></div>
                    <div class="form-group" id="paddinTop30">
                         <div class="col-md-2"></div>
                         <div class="col-md-2"><a href="principal.php?CON=system/Pages/usuariosPersona.php&identificacion=<?=$_GET['identificacion']?>"><input class="btn btn-danger" type="button" name="Cancelar" value="Cancelar"></a></div>
                         <div class="col-md-2"></div>
                         <div class="col-md-2"><input class="btn btn-warning" type="submit" name="accion" value="<?=$accion?>"></div>
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
        if(document.getElementById("estado").checked) document.getElementById("textoEstado").innerHTML='Activo';
        else document.getElementById("textoEstado").innerHTML='Bloqueado';
    });
    
    $("#estado").click(function(){
        if(document.getElementById("estado").checked) document.getElementById("textoEstado").innerHTML='Activo';
        else document.getElementById("textoEstado").innerHTML='Bloqueado';
    });
</script>