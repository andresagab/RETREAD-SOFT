<?php
require_once dirname(__FILE__).'/../Clases/Opcion.php';
if (isset($_GET['id'])) {
    $objeto=new Opcion('id', $_GET['id'], null, null);
    //print_r($objeto);
    $menu=$objeto->getMenu();
    //print_r($menu);
    $accion="Modificar";
} else {
    $objeto=new Opcion(null, null, null, null);
    $menu= new Opcion('id', $_GET['idMenu'], null, null);
    $accion="Adicionar";
}
?>
<div class="col-md-12">
	<div class="col-md-12" id="paddinTop30"></div>
	<div class="col-md-3" ></div>
	<div class="col-md-6" >
            <strong class="text text-success control-label"><h2><?=$accion?> opcion del menu <?= rtrim($menu->getNombre())?></h2></strong>
	</div>
	<div class="col-md-3" ></div>
	<div class="row col-md-12 text-capitalize" id="paddinTop20">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <form class="form-horizontal" name="formulario" method="POST" action="principal.php?CON=system/Pages/opcionesMenuActualizar.php">
                <div class="form-group">
                    <div class="input-group">
                        <label class="input-group-addon">Nombre:</label>
                        <input type="text" class="form-control has-primary" name="nombre" value="<?= rtrim($objeto->getNombre())?>" placeholder="Ejemplo: clientes" maxlength="50" required=""/>
                    </div>
                </div>
                <div class="col-md-12" id="paddinTop10"></div>
                <div class="form-group">
                    <div class="input-group">
                        <label class="input-group-addon">Descripcion:</label>
                        <textarea class="form-control has-primary" name="descripcion" placeholder="Descripcion para la opcion" maxlength="300"><?= rtrim($objeto->getDescripcion())?></textarea> 
                    </div>
                </div>
                <div class="col-md-12" id="paddinTop10"></div>
                <div class="form-group">
                    <div class="input-group">
                        <label class="input-group-addon">Ruta:</label>
                        <input type="text" class="form-control has-primary" name="ruta" value="<?= rtrim($objeto->getRuta())?>" placeholder="Ejemplo: carpeta/archivo.php" maxlength="100" required=""/>
                    </div>
                </div>
                <div class="hidden">
                    <div class="col-md-12"><input type="hidden" name="idMenu" value="<?=$menu->getId()?>"></div>
                    <div class="col-md-12"><input type="hidden" name="id" value="<?=$objeto->getId()?>"></div>
                </div>
                <div class="col-md-12" id="paddinTop10"></div>
                <div class="form-group" id="paddinTop30">
                     <div class="col-md-4"></div>
                     <div class="col-md-2"><a href="principal.php?CON=system/Pages/menu.php"><input class="btn btn-danger" type="button" name="Cancelar" value="Cancelar"></a></div>
                     <div class="col-md-2"><input class="btn btn-info" type="submit" name="accion" value="<?=$accion?>"></div>
                </div>
            </form>
        </div>
        <div class="col-md-3"></div>
	</div>
</div>
<script>
</script>