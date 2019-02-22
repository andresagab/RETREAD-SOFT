<?php
require_once dirname(__FILE__).'/../Clases/Persona.php';
require_once dirname(__FILE__).'/../Clases/Cliente.php';
require_once dirname(__FILE__).'/../Clases/Categoria_Producto.php';
require_once dirname(__FILE__).'/../Clases/Presentacion_Producto.php';
require_once dirname(__FILE__).'/../Clases/Unidad_Medida.php';
require_once dirname(__FILE__).'/../Clases/Tercero.php';
require_once dirname(__FILE__).'/../Clases/Categoria_Producto.php';
require_once dirname(__FILE__).'/../Clases/Puc.php';
require_once dirname(__FILE__).'/../Clases/Producto.php';
if (isset($_GET['id'])) {
    $objeto=new Producto('id', $_GET['id'], null, null);
    $categoria=new Categoria_Producto('id', "'{$objeto->getIdCategoria()}'", null, "order by id desc limit 1");
    $accion="Modificar";
} else {
    if (isset($_GET['idCategoria'])) $categoria=new Categoria_Producto ('id', $_GET['idCategoria'], null, null);
    else header("Location: principal.php?CON=system/Pages/categoriasProducto.php");
    $objeto=new Producto(null, null, null, null);
    $objeto->setIdCategoria($categoria->getId());
    $accion="Adicionar";
}
?>
<div class="col-md-12" ng-controller="images">
    <div class="col-md-2 col-sm-12" ></div>
    <div class="col-md-8 col-sm-12" >
        <strong class="text mdl-color-text--teal control-label text-uppercase"><h2><?=$accion?> producto para la categoria <?= rtrim($categoria->getNombre())?></h2></strong>
    </div>
    <div class="col-md-2 col-sm-12"></div>
    <div class="row col-md-12 text-capitalize" id="paddinTop20">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <form class="form-horizontal" name="formulario" method="POST" action="principal.php?CON=system/Pages/productosCategoriaActualizar.php" enctype="multipart/form-data">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">* Producto:</span>
                            <input type="text" class="form-control has-primary input-sm" name="nombre" value="<?= rtrim($objeto->getPuc()->getNombre())?>" placeholder="Ejemplo: PARCHE CONVENCIONAL" maxlength="50" required="" data-toggle="tooltip" title="Este campo es obligatorio"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">* Presentacion:</span>
                            <select class="form-control has-success" name="idPresentacion">
                                <?= Presentacion_Producto::getDatosEnOptions(null, "order by id desc", $objeto->getIdPresentacion())?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">* Unidad de medida:</span>
                            <select class="form-control has-success" name="idUnidadMedida">
                                <?= Unidad_Medida::getDatosEnOptions(null, "order by id desc", $objeto->getIdUnidadMedida())?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">* Proveedor:</span>
                            <select class="form-control has-success" name="idProvedor">
                                <?= Tercero::getDatosEnOptionsSQL($objeto->getIdProvedor())?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">* Grupo:</span>
                            <input type="number" class="form-control has-primary input-sm" name="grupo" value="<?= $objeto->getGrupo() ?>" placeholder="Ejemplo: 1" min="0"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">* Stock:</span>
                            <input type="number" class="form-control has-primary input-sm" name="stock" value="<?= rtrim($objeto->getStock())?>" placeholder="Ejemplo: 10" min="0" step="any" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">* Stock minimo:</span>
                            <input type="number" class="form-control has-primary input-sm" name="stockMinimo" value="<?= rtrim($objeto->getStockMinimo())?>" placeholder="Ejemplo: 5" min="0" step="any" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">* Stock maximo:</span>
                            <input type="number" class="form-control has-primary input-sm" name="stockMaximo" value="<?= rtrim($objeto->getStockMaximo())?>" placeholder="Ejemplo: 100" min="0" step="any" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Peso:</span>
                            <input type="number" class="form-control has-primary input-sm" name="peso" value="<?= rtrim($objeto->getPeso())?>" placeholder="Ejemplo: 15.3" min="0" step="any">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">* Costo:</span>
                            <input type="number" class="form-control has-primary input-sm" name="costo" value="<?= rtrim($objeto->getCosto())?>" placeholder="Ejemplo: 1500" min="0" step="any" required>
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
                            <span class="input-group-addon">Foto:</span>
                            <input type="file" class="input-group-addon form-control btn btn-default" name="foto" id="foto" accept="image/*" onchange="angular.element(this).scope().photoChanged(this.files)">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Descripcion:</span>
                            <textarea class="form-control has-primary" name="descripcion" maxlength="300" placeholder="Escribre una descripcion para este producto"><?= rtrim($objeto->getPuc()->getDescripcion()) ?></textarea>
                        </div>
                    </div>
                    <div class="hidden">
                        <div class="col-md-12"><input type="hidden" name="id" value="<?=$objeto->getId()?>"></div>
                        <div class="col-md-12"><input type="hidden" name="idCategoria" value="<?=$categoria->getId()?>"></div>
                    </div>
                    <div class="form-group" id="paddinTop20">
                        <button onclick="window.location='principal.php?CON=system/Pages/productosCategoria.php&idCategoria=<?=$categoria->getId()?>'" class="btn btn-danger" type="button" name="Cancelar">Cancelar</button>
                        <input class="btn btn-info" type="submit" name="accion" value="<?=$accion?>">
                    </div>
                </div>
                <div class="col-md-3"></div>
            </form>
        </div>
        <div class="col-md-1"></div>
    </div>
</div>