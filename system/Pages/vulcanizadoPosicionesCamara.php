<?php
require_once dirname(__FILE__).'\..\Clases\Persona.php';
require_once dirname(__FILE__).'\..\Clases\Cargo_Empleado.php';
require_once dirname(__FILE__).'\..\Clases\Empleado.php';
require_once dirname(__FILE__).'\..\Clases\Cliente.php';
require_once dirname(__FILE__).'\..\Clases\Tipo_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Marca_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Gravado_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Servicio.php';
require_once dirname(__FILE__).'\..\Clases\Inspeccion_Inicial.php';
require_once dirname(__FILE__).'\..\Clases\Raspado.php';
require_once dirname(__FILE__).'\..\Clases\Puc.php';
require_once dirname(__FILE__).'\..\Clases\Producto.php';
require_once dirname(__FILE__).'\..\Clases\Puesto_Trabajo.php';
require_once dirname(__FILE__).'\..\Clases\Preparacion.php';
require_once dirname(__FILE__).'\..\Clases\Reparacion.php';
require_once dirname(__FILE__).'\..\Clases\Cementado.php';
require_once dirname(__FILE__).'\..\Clases\Relleno.php';
require_once dirname(__FILE__).'\..\Clases\Corte_Banda.php';
require_once dirname(__FILE__).'\..\Clases\Embandado.php';
require_once dirname(__FILE__).'\..\Clases\Vulcanizado.php';
if (isset($_GET['id'])) {
    $objeto=new Vulcanizado('id', $_GET['id'], null, null);
} else {
    header("Location: principal.php?CON=system/Pages/404.php");
}
?>
<script src="lib/controladores/posicionCamara.js"></script>
<div class="col-md-12" ng-controller="posicionCamara">
    <div class="hide" ng-click="cargarVulcanizado(<?=$_GET['id']?>);" id="btnCargarVulcanizado"></div>
    <div class="col-md-2" >
        <button class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab btn-danger" id="btnRegresar" type="button" onclick="window.location='principal.php?CON=system/Pages/procesoServicio.php&id=<?= $objeto->getEmbandado()->getCorteBanda()->getRelleno()->getCementado()->getReparacion()->getPreparacion()->getRaspado()->getInspeccion()->getIdLlanta() ?>';">
            <i class="fa fa-arrow-left"></i>
        </button>
        <div class="mdl-tooltip" for="btnRegresar">Regresar al proceso de rencauche</div>
    </div>
    <div class="col-md-8" >
        <strong class="text text-uppercase mdl-color-text--blue control-label"><h2>Registrar revisiones de vulcanizado</h2></strong>
    </div>
    <div class="col-md-2">
        <button class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab btn-success" id="btnRegistrarServicio" type="button" ng-disabled="elementos.btnAdicionarPosicionCamara" ng-click="" ng-hide="elementos.btnAdicionarPosicionCamara" href="/#_FormularioPosicionCamara" data-toggle="modal">
            <i class="fa fa-check"></i>
        </button>
        <div class="mdl-tooltip" for="btnRegistrarServicio">Registrar revision</div>
        <button class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab btn-default" id="btnConfigurarCantidad" type="button" href="/#_CantidadPosiciones" data-toggle="modal">
            <i class="fa fa-gear"></i>
        </button>
        <div class="mdl-tooltip" for="btnConfigurarCantidad">Configurar cantidad de revisiones</div>
    </div>
    <div class="col-md-12 col-sm-12" ng-hide="llantas" ng-show="elementos.barraCargaLista">
        <div class="mdl-spinner mdl-js-spinner is-active"></div>
    </div>
    <div class="row col-md-12 text-center" id="paddinTop20" ng-show="html.alerta">
        <div class="alert alert-{{ html.colorAlerta }}">{{ html.mjsAlerta }}</div>
    </div>
    <div class="row col-md-12 text-capitalize" id="paddinTop20">
        <div class="col-md-1"></div>
        <div class="col-md-10" ng-show="posicionesCamaras">
            <!--Posicion de camara-->
            <div class="col-lg-6 col-md-6 col-sm-12" ng-repeat="dato in posicionesCamaras">
                <div class="thumbnail">
                    <div class="caption">
                        <big class="text-primary pull-left">Revision n°: {{ dato.posicion }}</big>
                        <div class="pull-right btn-group">
                            <button class="btn btn-danger" data-toggle="modal" title="Eliminar" href="/#eliminar{{ dato.id }}" type="button">
                                <span class="fa fa-trash"></span>
                            </button>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12" id="paddinTop10"></div>
                    <img class="img-responsive img-rounded" style="height: 250px;" src="system/Uploads/Imgs/PosicionesCamaras/PC_V-<?=$_GET['id']?>/{{ dato.foto }}"/>
                    <br>
                </div>
            </div>
            <div ng-repeat="objeto in posicionesCamaras | filter: buscar">
                <div class='modal fade' id='eliminar{{ objeto.id }}'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                ¿Est&aacute; seguro que desea eliminar este registro <b>" {{ objeto.posicion }} "</b>?
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-danger' data-dismiss='modal' >Cancelar</button>
                                <button type='button' class='btn btn-success' data-dismiss='modal' ng-click="eliminarPosicionCamara(objeto)">Aceptar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Fin Posicion de camara-->
        </div>
        <div class="col-md-1"></div>
    </div>
    <!--Formulario posicion camara-->
    <div class='modal fade' id='_FormularioPosicionCamara'>
        <div class='modal-dialog modal-lg'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' id="btnCerrarDialogFormularioLlanta_A" data-dismiss='modal' ng-click="cleanPosicionCamara();">&times;</button>
                    <h3 class="text text-primary">REGISTRAR REVISION</h3>
                </div>
                <form id="frmFormularioLlantaOS_A" name="frmformularioLlantaOS_A" ng-submit="registrarPosicionCamara();">
                    <div class="modal-footer">
                        <div class="col-sm-12 col-lg-12 text-center" ng-show="elementos.barraCarga" id="paddinBottom10">
                            <div class="col-sm-1 col-lg-2"></div>
                            <div class="col-sm-10 col-lg-8">
                                <div class="mdl-progress mdl-js-progress mdl-progress__indeterminate"></div>
                            </div>
                            <div class="col-sm-1 col-lg-2"></div>
                        </div>
                        <div class="col-sm-12 col-lg-12" ng-show="elementos.alertaDialog">
                            <div class="alert alert-{{ elementos.colorAlertaDialog }} text-center">{{ elementos.mjsAlertaDialog }}</div>
                        </div>
                        <div class="col-sm-12 col-lg-12">
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
                                    <input id="foto" type="file" class="form-control btn btn-default" name="foto" id="foto" required="" accept="image/*" onchange="angular.element(this).scope().photoChanged(this.files)" ng-model="posicionCamara.foto" uploader-model="file" ng-change="setVFoto();">
                                </div>
                            </div>
                            <div class="alert alert-danger text-center" id="paddinTop10" ng-show="posicionCamara.foto==null && frmformularioLlantaOS_A.$submitted">Debes subir una foto de la posicion que desea registrar</div>
                        </div>
                        <div class="col-sm-12 col-lg-12 hide">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Posicion:</span>
                                    <input type="number" class="form-control" name="posicion" id="txtPosicion" ng-model="posicionCamara.txtPosicion" ng-change="setVPosicion(posicionCamara.txtPosicion)">
                                </div>
                            </div>
                            <div class="alert alert-danger text-center" id="paddinTop10" ng-show="posicionCamara.txtPosicion==null && frmformularioLlantaOS_A.$submitted">Debes ingresar la posision de la camara en formato de horas</div>
                        </div>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' id="btnCancelarMDFormularioLlanta_A" class='btn btn-danger' data-dismiss='modal' ng-click="cleanLlanta();">Cancelar</button>
                        <button type='submit' class='btn btn-success'>Aceptar</button>
                    </div>
                </form>
            </div>
        </div>
        <!--TOOLTIPS-->
        <div class="mdl-tooltip" data-mdl-for="btnCerrarDialogFormularioLlanta_A">Cerrar</div>
        <!--FIN TOOLTIPS-->
        <!--------------------------------------------------------------------->
        <!--TOAST-->
        <div id="toast-dialog" class="mdl-js-snackbar mdl-snackbar">
            <div class="mdl-snackbar__text"></div>
            <button class="mdl-snackbar__action" type="button"></button>
        </div>
        <!--FIN TOAST-->
    </div>
    <!--FIN Formulario posicion camara-->
    <!--Formulario cantidad posiciones camaras-->
    <div class='modal fade' id='_CantidadPosiciones'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' id="btnCerrarCPC" data-dismiss='modal'>&times;</button>
                    <h3 class="text text-primary">CONFIGURAR CANTIDAD DE REVISIONES</h3>
                </div>
                <form id="frmCPC" name="frmCPC" ng-submit="registrarCPC();">
                    <div class="modal-footer">
                        <div class="col-sm-12 col-lg-12 text-center" ng-show="elementos.barraCarga" id="paddinBottom10">
                            <div class="col-sm-1 col-lg-2"></div>
                            <div class="col-sm-10 col-lg-8">
                                <div class="mdl-progress mdl-js-progress mdl-progress__indeterminate"></div>
                            </div>
                            <div class="col-sm-1 col-lg-2"></div>
                        </div>
                        <div class="col-sm-12 col-lg-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="rbt12">
                                            <input type="radio" id="rbt12" class="mdl-radio__button" name="rbtCPC" value="3" ng-model="html.rbtCPC">
                                            <span class="mdl-checkbox__label">
                                                <i class=""></i> 3
                                            </span>
                                        </label>
                                    </span>
                                    <span class="input-group-addon">
                                        <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="rbt22">
                                            <input type="radio" id="rbt22" class="mdl-radio__button" name="rbtCPC" value="6" ng-model="html.rbtCPC">
                                            <span class="mdl-checkbox__label">
                                                <i class=""></i> 6
                                            </span>
                                        </label>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' id="btnCancelarCPC" class='btn btn-danger' data-dismiss='modal'>Cancelar</button>
                        <button type='submit' class='btn btn-success'>Aceptar</button>
                    </div>
                </form>
            </div>
        </div>
        <!--TOOLTIPS-->
        <div class="mdl-tooltip" data-mdl-for="btnCerrarCPC">Cerrar</div>
        <!--FIN TOOLTIPS-->
        <!--------------------------------------------------------------------->
        <!--TOAST-->
        <div id="toast-dialog-cpc" class="mdl-js-snackbar mdl-snackbar">
            <div class="mdl-snackbar__text"></div>
            <button class="mdl-snackbar__action" type="button"></button>
        </div>
        <!--FIN TOAST-->
    </div>
    <!--FIN Formulario cantidad posiciones camaras-->
</div>
<div id="toast-content" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button"></button>
</div>