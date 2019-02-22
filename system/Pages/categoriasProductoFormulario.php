<?php
require_once dirname(__FILE__).'/../Clases/Categoria_Producto.php';
if (isset($_GET['id'])) {
    $objeto=new Categoria_Producto('id', $_GET['id'], null, null);
    $accion="Modificar";
} else {
    $objeto=new Categoria_Producto(null, null, null, null);
    $accion="Adicionar";
}
?>
<div class="col-md-12" ng-controller="images">
    <div class="col-md-3" ></div>
    <div class="col-md-6" >
        <strong class="text mdl-color-text--indigo control-label"><h2><?=$accion?> categoria de producto</h2></strong>
    </div>
    <div class="col-md-3" ></div>
    <div class="row col-md-12 text-capitalize" id="paddinTop20">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <form class="form-horizontal" name="formulario" method="POST" action="principal.php?CON=system/Pages/categoriasProductoActualizar.php" enctype="multipart/form-data">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon" ng-init="categoria='<?= rtrim($objeto->getNombre())?>'" >* Nombre:</span>
                            <input type="text" class="form-control has-primary input-sm" name="nombre" value="<?= rtrim($objeto->getNombre())?>" placeholder="Ejemplo: Parches" maxlength="30" required="" data-toggle="tooltip" title="Este campo es obligatorio" ng-model="categoria"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Descripcion:</span>
                            <textarea class="form-control has-primary input-sm" name="descripcion" placeholder="Ejemplo: Escribe una descripcion para la categoria {{ categoria }}"><?= rtrim($objeto->getDescripcion())?></textarea>
                        </div>
                    </div>
                    <div class="form-group" ng-show="foto">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <div class="thumbnail">
                                    <img class="card-img-top" id="img" style="height: 300px;" ng-src="{{ thumbnail.dataURL }}">
                                    <div class="caption">
                                        <button class="btn btn-warning" id="btnEliminarImg" type="button" ng-click="deleteImg()">Borrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">* Foto:</span>
                            <input type="file" class="input-group-addon form-control btn btn-default" name="imagen" id="foto" required="" accept=".jpg" onchange="angular.element(this).scope().photoChanged(this.files)">
                        </div>
                    </div>
                    <div class="hidden">
                        <div class="col-md-12"><input type="hidden" name="id" value="<?=$objeto->getId()?>"></div>
                    </div>
                    <div class="form-group" id="paddinTop20">
                        <button onclick="window.location='principal.php?CON=system/Pages/categoriasProducto.php'" class="btn btn-danger" type="button" name="Cancelar">Cancelar</button>
                        <input class="btn btn-info" type="submit" name="accion" value="<?=$accion?>">
                    </div>
                </div>
                <div class="col-md-3"></div>
            </form>
        </div>
        <div class="col-md-1"></div>
    </div>
</div>