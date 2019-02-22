<?php
require_once dirname(__FILE__).'/../Clases/Puesto_Trabajo.php';
require_once dirname(__FILE__).'/../Clases/Puc.php';
require_once dirname(__FILE__).'/../Clases/Producto.php';
require_once dirname(__FILE__).'/../Clases/Insumo_Puesto_Trabajo.php';
require_once dirname(__FILE__).'/../Clases/Categoria_Producto.php';
if (isset($_GET['id'])) {
    $objeto=new Insumo_Puesto_Trabajo('id', $_GET['id'], null, null);
    $puestoTrabajo=new Puesto_Trabajo('id', "'{$objeto->getIdPuestoTrabajo()}'", null, "order by id desc limit 1");
    $accion="Modificar";
} else {
    if (isset($_GET['idPT'])) $puestoTrabajo=new Puesto_Trabajo ('id', $_GET['idPT'], null, null);
    $objeto=new Insumo_Puesto_Trabajo(null, null, null, null);
    $objeto->setIdPuestoTrabajo($_GET['idPT']);
    $accion="Adicionar";
}
?>
<script src="lib/controladores/insumosPuestoTrabajo.js"></script>
<div ng-controller="insumosPuestoTrabajo">
    <div class="col-md-2 col-sm-12" ></div>
    <div class="col-md-8 col-sm-12" >
        <strong class="text text-success control-label"><h2><?=$accion?> insumo para el puesto de trabajo <?= rtrim($puestoTrabajo->getNombre())?></h2></strong>
    </div>
    <div class="col-md-2 col-sm-12"></div>
    <div class="col-sm-12 col-md-12 col-lg-12" ng-show="html.spinnerCarga" id="spnSpinnerFrmIP">
        <div class="mdl-spinner mdl-js-spinner is-active"></div>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-12" ng-show="html.alerta">
        <div class="alert alert-{{ html.colorAlerta }}">{{ html.mjsAlerta }}</div>
    </div>
    <div class="row col-md-12 text-capitalize" id="paddinTop20">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <form class="form-horizontal" name="formulario" method="POST" action="principal.php?CON=system/Pages/insumosPuestoTrabajoActualizar.php">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Categoria:</span>
                            <select class="form-control has-success" name="idCategoria" id="spnCategorias" ng-model="html.idCategoria" ng-change="cargarIdCategoria(html.idCategoria)">
                                <?= Categoria_Producto::getDatosEnOptions(null, "order by id desc", null)?>
                            </select>
                            <div class="mdl-tooltip" data-mdl-for="spnCategorias">Seleccion una categoria para cargar sus productos</div>
                        </div>
                    </div>
                    <div class="form-group" ng-show="html.rbsMetodo">
                        <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-1">
                            <input type="radio" id="option-1" class="mdl-radio__button" name="metodoSeleccion" value="L" ng-model="rbMetodoBusqueda" checked ng-change="cargarTipoDeBusqueda(rbMetodoBusqueda)">
                            <span class="mdl-radio__label">Lista de seleccion</span>
                        </label>
                        <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-2">
                            <input type="radio" id="option-2" class="mdl-radio__button" name="metodoSeleccion" value="B" ng-model="rbMetodoBusqueda" ng-change="cargarTipoDeBusqueda(rbMetodoBusqueda)">
                            <span class="mdl-radio__label">Busqueda por nombre</span>
                        </label>
                    </div>
                    <div class="form-group" ng-show="html.spnListaSeleccion">
                        <div class="input-group">
                            <span class="input-group-addon">Insumo:</span>
                            <select class="form-control has-success" name="idInsumo" id="spnInsumosCategoria" ng-model="idInsumoSpinner" ng-change="separarIdInsumoXSpinner(idInsumoSpinner)"></select>
                        </div>
                    </div>
                    <div class="form-group" ng-show="html.txtBuscador">
                        <div class="input-group">
                            <span class="input-group-addon">Nombre insumo:</span>
                            <input class="form-control" id="txtNombreInsumo" type="text" placeholder="Dijita el nombre del insumo que deseas buscar" ng-model="txtNombreInsumo" ng-change="buscar(txtNombreInsumo)">
                            <span class="input-group-btn">
                                <button class="input-group btn btn-success" type="button" id="btnBuscarInsumo" ng-click="buscar(txtNombreInsumo)">
                                    <i class="fa fa-check"></i>
                                </button>
                            </span>
                            <div class="mdl-tooltip" data-mdl-for="txtNombreInsumo">Buscar por nombre del insumo</div>
                            <div class="mdl-tooltip" data-mdl-for="btnBuscarInsumo">Buscar y cargar</div>
                        </div>
                    </div>
                    <div ng-show="html.datosInsumo">
                        <div class="form-group">
                            <div class="table-responsive">
                                <div class="thumbnail">
                                    <div class="caption">
                                        <big class="text-primary pull-left" data-toggle="tooltip" title="{{ insumo.descripcionPuc }}">{{ objeto.nombrePuc }}</big>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12" id="paddinTop10"></div>
                                    <img ng-show="!insumo.notImage" class="img-responsive img-rounded" style="height: 250px;" src="system/Uploads/Imgs/Productos/{{ insumo.foto }}"/>
                                    <img ng-show="insumo.notImage" class="img-responsive img-rounded" style="height: 250px;" src="design/pics/imagenes/not_image.jpg"/>
                                    <br>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Presentacion:</span>
                                <input class="form-control has-primary input-sm" ng-model="insumo.nombrePresentacion" disabled=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Unidad medida:</span>
                                <input class="form-control has-primary input-sm" ng-model="insumo.nombreUnidadMedida" disabled=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Proveedor:</span>
                                <input class="form-control has-primary input-sm" ng-model="insumo.nombreProveedor" disabled=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Grupo:</span>
                                <input class="form-control has-primary input-sm" ng-model="insumo.grupo" disabled=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Stock:</span>
                                <input class="form-control has-primary input-sm" ng-model="insumo.stock" disabled=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Stock minimo:</span>
                                <input class="form-control has-primary input-sm" ng-model="insumo.stockMinimo" disabled=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Stock maximo:</span>
                                <input class="form-control has-primary input-sm" ng-model="insumo.stockMaximo" disabled=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Peso:</span>
                                <input class="form-control has-primary input-sm" ng-model="insumo.peso" disabled=""/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">costo:</span>
                                <input class="form-control has-primary input-sm" ng-model="insumo.costo" disabled=""/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">* Cantidad:</span>
                            <input type="number" class="form-control has-primary input-sm" name="cantidad" value="<?= $objeto->getCantidad() ?>" placeholder="Ejemplo: 1" min="1" step="any" required>
                        </div>
                    </div>
                    <div class="hidden">
                        <div class="col-md-12"><input type="hidden" name="idInsumo" value="{{ html.idInsumo }}"></div>
                        <div class="col-md-12"><input type="hidden" name="id" value="<?=$objeto->getId()?>"></div>
                        <div class="col-md-12"><input type="hidden" name="idPT" value="<?=$objeto->getPuestoTrabajo()->getId()?>"></div>
                        <div class="col-md-12"><input type="hidden" name="idPuestoTrabajo" value="<?=$objeto->getPuestoTrabajo()->getId()?>"></div>
                        <div class="col-md-12"><input type="hidden" name="usuario" value="<?=$USUARIO->getUsuario()?>"></div>
                    </div>
                    <div class="col-md-12" id="paddinTop10"></div>
                    <div class="form-group" id="paddinTop30">
                        <button onclick="window.location='principal.php?CON=system/Pages/insumosPuestoTrabajo.php&idPT=<?=$puestoTrabajo->getId()?>'" class="btn btn-danger" type="button" name="Cancelar">Cancelar</button>
                        <input ng-disabled="html.btnEnviar" class="btn btn-info" type="submit" name="accion" value="<?=$accion?>">
                    </div>
                </div>
                <div class="col-md-2"></div>
            </form>
        </div>
        <div class="col-md-1"></div>
    </div>
</div>
<div id="toast-content" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button"></button>
</div>