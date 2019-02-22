<?php
require_once dirname(__FILE__).'/../Clases/Rol.php';
if (isset($_GET['id'])) {
    $objeto=new Rol('id', $_GET['id'], null, null);
    $accion="Modificar";
    if ($objeto->getEstado()) $checked='checked';
    else $checked='';
} else {
    $objeto=new Rol(null, null, null, null);
    $accion="Adicionar";
    $checked='checked';
}
?>
<div class="col-md-12">
	<div class="col-md-12" id="paddinTop30"></div>
	<div class="col-md-4" ></div>
	<div class="col-md-4" >
            <strong class="text text-success control-label"><h2><?=$accion?> rol para el sistema</h2></strong>
	</div>
	<div class="col-md-4" ></div>
	<div class="row col-md-12 text-capitalize" id="paddinTop20">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <form class="form-horizontal" name="formulario" method="POST" action="principal.php?CON=system/Pages/rolesActualizar.php">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Nombre:</span>
                            <input type="text" class="form-control has-primary" name="nombre" value="<?= rtrim($objeto->getNombre())?>" placeholder="Ejemplo: Operario" maxlength="30" required=""/>
                        </div>
                    </div>
                    <div class="col-md-12" id="paddinTop10"></div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Estado:</span>
                            <span class="input-group-addon"><input type="checkbox" class="" name="estado" <?=$checked?> id="estado"/></span>
                            <span class="input-group-addon"><label id="textoEstado"></label></span>
                        </div>
                    </div>
                    <div class="hidden">
                        <div class="col-md-12"><input type="hidden" name="id" value="<?=$objeto->getId()?>"></div>
                    </div>
                    <div class="col-md-12" id="paddinTop10"></div>
                    <div class="form-group" id="paddinTop20">
                         <div class="col-md-2"></div>
                         <div class="col-md-2"><a href="principal.php?CON=system/Pages/roles.php"><input class="btn btn-danger" type="button" name="Cancelar" value="Cancelar"></a></div>
                         <div class="col-md-2"></div>
                         <div class="col-md-2"><input class="btn btn-info" type="submit" name="accion" value="<?=$accion?>"></div>
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