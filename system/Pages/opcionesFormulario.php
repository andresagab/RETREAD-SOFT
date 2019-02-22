<?php
require_once dirname(__FILE__).'/../Clases/Opcion.php';
if (isset($_GET['id'])) {
    $objeto=new Opcion('id', $_GET['id'], null, null);
    $accion="Modificar";
} else {
    $objeto=new Opcion(null, null, null, null);
    $accion="Adicionar";
}
?>
<div class="col-md-12">
	<div class="col-md-12" id="paddinTop30"></div>
	<div class="col-md-4" ></div>
	<div class="col-md-4" >
            <strong class="text text-success control-label"><h2><?=$accion?> opcion</h2></strong>
	</div>
	<div class="col-md-4" ></div>
	<div class="row col-md-12 text-capitalize" id="paddinTop20">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <form class="form-horizontal" name="formulario" method="POST" action="principal.php?CON=system/Pages/opcionesActualizar.php">
                <div class="form-group">
                    <label class="control-label col-md-5">Nombre:</label>
                    <div class="col-md-5">
                        <input type="text" class="form-control has-primary" name="nombre" value="<?= rtrim($objeto->getNombre())?>" placeholder="Ejemplo: Operario" maxlength="50" required=""/>
                    </div>
                </div>
                <div class="col-md-12" id="paddinTop10"></div>
                <div class="form-group">
                    <label class="control-label col-md-5">Descripcion:</label>
                    <div class="col-md-5    ">
                        <textarea class="form-control has-primary" name="descripcion" placeholder="Descripcion para el tipo de Cargo" maxlength="300"><?= rtrim($objeto->getDescripcion())?></textarea> 
                    </div>
                </div>
                <div class="col-md-12" id="paddinTop10"></div>
                <div class="form-group">
                    <label class="control-label col-md-5">Ruta:</label>
                    <div class="col-md-5    ">
                        <input type="text" class="form-control has-primary" name="ruta" value="<?= rtrim($objeto->getRuta())?>" placeholder="Ejemplo: carpeta/archivo.php" maxlength="100" required=""/>
                    </div>
                </div>
                <div class="hidden">
                    <div class="col-md-12"><input type="hidden" name="id" value="<?=$objeto->getId()?>"></div>
                </div>
                <div class="col-md-12" id="paddinTop10"></div>
                <div class="form-group" id="paddinTop30">
                     <div class="col-md-4"></div>
                     <div class="col-md-2"><a href="principal.php?CON=system/Pages/opciones.php"><input class="btn btn-danger" type="button" name="Cancelar" value="Cancelar"></a></div>
                     <div class="col-md-2"><input class="btn btn-info" type="submit" name="accion" value="<?=$accion?>"></div>
                </div>
            </form>
        </div>
        <div class="col-md-1"></div>
	</div>
</div>
<script>
</script>