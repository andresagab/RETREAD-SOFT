<?php
require_once dirname(__FILE__).'\..\Clases\Persona.php';
require_once dirname(__FILE__).'\..\Clases\Cargo_Empleado.php';
require_once dirname(__FILE__).'\..\Clases\Empleado.php';
require_once dirname(__FILE__).'\..\Clases\Cliente.php';
require_once dirname(__FILE__).'\..\Clases\Tipo_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Marca_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Gravado_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Referencia_Tipo_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Dimension_Referencia.php';
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
require_once dirname(__FILE__).'\..\Clases\Inspeccion_Final.php';
if (isset($_GET['idVulcanizado'])) header ("Location: principal.php?CON=system/Pages/inspeccionFinalActualizar.php&idVulcanizado={$_GET['idVulcanizado']}&accion=preRegistro");
else {
    if (isset($_GET['id'])) {
        $objeto=new Inspeccion_Final('id', $_GET['id'], null, null);
        $vulcanizado=$objeto->getVulcanizado();
        $embandado=$vulcanizado->getEmbandado();
        $corteBanda=$embandado->getCorteBanda();
        $relleno=$corteBanda->getRelleno();
        $cementado=$relleno->getCementado();
        $reparacion=$cementado->getReparacion();
        $preparacion=$reparacion->getPreparacion();
        $raspado=$preparacion->getRaspado();
        $inspeccionInicial=$raspado->getInspeccion();
        $servicio=$inspeccionInicial->getLlanta()->getServicio();
        $accion="Registrar";
        $accionBD="Registrar";
    } else {
        $objeto=new Inspeccion_Final(null, null, null, null);
        $objeto->setIdVulcanizado($_GET['idVulcanizado']);
        $vulcanizado=$objeto->getVulcanizado();
        $embandado=$vulcanizado->getEmbandado();
        $corteBanda=$embandado->getCorteBanda();
        $relleno=$corteBanda->getRelleno();
        $cementado=$relleno->getCementado();
        $reparacion=$cementado->getReparacion();
        $preparacion=$reparacion->getPreparacion();
        $raspado=$preparacion->getRaspado();
        $inspeccionInicial=$raspado->getInspeccion();
        $servicio=$inspeccionInicial->getLlanta()->getServicio();
        $accion="Registrar";
        $accionBD="Registrar";
    }
    $llanta=$inspeccionInicial->getLlanta();
    $cliente=$servicio->getCliente();
    if ($cliente->getRazonSocial()!=null || $cliente->getRazonSocial()!='') $nombreProveedor=$cliente->getRazonSocial();
else $nombreProveedor=$cliente->getPersona()->getNombresCompletos();
?>
<script src="lib/controladores/usosInsumosPuestoTrabajo.js"></script>
<div class="col-md-12" ng-controller="usosInsumosPuestoTrabajo">
    <div class="hide" id="cargarDatos" ng-click="cargarProceso(<?= $objeto->getId() ?>, 'getInspeccionFinalJSON');cargarEmpleado(<?= $USUARIO->getIdEmpleadoUsuario() ?>);setNumeroProceso(9)"></div>
    <div class="col-md-4" ></div>
    <div class="col-md-4" >
        <strong class="text text-uppercase mdl-color-text--blue control-label"><h2><?=$accion?> inspeccion final</h2></strong>
    </div>
    <div class="col-md-4" >
        <button class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab btn-info" id="btnDetalles" type="button" href="/#_Dialog_DetallesProceso" data-toggle="modal">
            <i class="fa fa-info-circle"></i>
        </button>
        <div class="mdl-tooltip" for="btnDetalles">Detalles de la llanta y la orden de servicio</div>
    </div>
    <div class="row col-md-12" id="paddinTop20" ng-show="html.alerta">
        <div class="alert alert-{{ html.colorAlerta }}">{{ html.mjsAlerta }} <b>{{ html.mjsAlertaResaltado }}</b></div>
    </div>
    <div class="row col-md-12" id="paddinTop20" ng-show="html.barraCargaPrincipal">
        <center>
            <div id="p2" class="mdl-progress mdl-js-progress mdl-progress__indeterminate"></div>
        </center>
    </div>
    <div class="row col-md-12" id="paddinTop20">
        <div class="col-md-1"></div>
        <div class="col-md-10" >
            <form class="form-horizontal" name="formulario" method="POST" action="principal.php?CON=system/Pages/inspeccionFinalActualizar.php" enctype="multipart/form-data">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">* Puesto de trabajo:</span>
                                <select ng-disabled="html.spnListaPuestosTrabajo" class="form-control has-primary input-group-sm" name="idPuestoTrabajo" id="puestoTrabajo" ng-model="html.idPuestoTrabajo" ng-change="cargarPuestoTrabajo(html.idPuestoTrabajo)"><?= Puesto_Trabajo::getDatosEnOptions("proceso=9", null, null)?></select>
                            <span class="input-group-btn" ng-show="html.btnPuestoTrabajo">
                                <button class="btn btn-success" type="button" id="btnVerInsumos" href="/#verInsumosPT" data-toggle='modal'>Usar insumos</button>
                            </span>
                        </div>
                    </div>
                    <div ng-controller="images">
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
                                <input type="file" class="form-control btn btn-default" name="foto" id="foto" required="" accept="image/*" onchange="angular.element(this).scope().photoChanged(this.files)">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Observaciones:</span>
                            <textarea class="form-control has-primary input-sm" name="observaciones" placeholder="Observaciones para este proceso" maxlength="500"><?= rtrim($objeto->getObservaciones())?></textarea> 
                        </div>
                    </div>
                    <div class="hidden">
                        <div class="col-md-12"><input type="hidden" name="id" value="<?=$objeto->getId()?>"></div>
                        <div class="col-md-12"><input type="hidden" name="idPuestoTrabajo" value="{{ html.idPuestoTrabajo }}"></div>
                        <div class="col-md-12"><input type="hidden" name="idVulcanizado" value="<?=$objeto->getIdVulcanizado()?>"></div>
                        <div class="col-md-12"><input type="hidden" name="idEmpleado" value="<?=$USUARIO->getIdEmpleadoUsuario()?>"></div>
                    </div>
                    <div class="form-group" id="paddinTop20">
                        <a href="principal.php?CON=system/Pages/procesoServicio.php&id=<?=$llanta->getId()?>"><input class="btn btn-danger" type="button" name="Cancelar" value="Cancelar"></a>
                        <input ng-disabled="html.btnRegistrarProceso" class="btn btn-info" type="submit" name="accion" value="<?=$accion?>">
                    </div>
                </div>
                <div class="col-md-2"></div>
            </form>
        </div>
        <div class="col-md-1"></div>
    </div>
    <div class="col-sm-12 col-lg-12">
        <div class="alert alert-info small" data-dismiss="alert">
            <button class="close" data-dismiss="alert" id="btnCerrarAlertaInfo"><span>&times;</span></button>
            Recuerda que al usar un insumo en un puesto de trabajo automaticamente se bloquea la seleccion de otro puesto de trabajo
        </div>
        <div class="mdl-tooltip" for="btnCerrarAlertaInfo">Cerrar informacion</div>
    </div>
    <!--Puesto Trabajo-->
    <div class="col-lg-12">
        <div class='modal fade' id='verInsumosPT'>
            <div class='modal-dialog modal-lg'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <button type='button' class='close' data-dismiss='modal'>&times;</button>
                        <h3 class="text text-primary">{{ puestoTrabajo.nombre }}</h3>
                        <div class="row col-md-12" id="paddinTop20" ng-show="html.spinnerCargaDialogo">
                            <div class="mdl-spinner mdl-js-spinner is-active"></div>
                        </div>
                        <div class="row col-md-12" id="paddinTop20" ng-show="html.alertaDialogo">
                            <div class="alert alert-{{ html.colorAlertaDialogo }}">{{ html.mjsAlertaDialogo }}</div>
                        </div>
                    </div>
                    <div class="modal-header">
                        <div role="tabpanel">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="active" role="presentacion" ng-click="limpiarVariablesNovedad()">
                                    <a href="/#lista" aria-control="" data-toggle="tab" role="tab">Herramientas</a>
                                </li>
                                <li role="presentacion" class="hide">
                                    <a href="/#adicionarInsumo" aria-control="" data-toggle="tab" role="tab">Adicionar insumo</a>
                                </li>
                                <li role="presentacion" ng-click="limpiarUsarYTerminarInsumo()">
                                    <a href="/#enviarNovedad" aria-control="" data-toggle="tab" role="tab">Enviar novedad</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="lista">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="col-sm-12 col-lg-1" id="paddinTop20">
                                            <button ng-show="html.btnRecargarInsumos" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab btn-info" id="btnRecargarListaInsumos" type="button" ng-click="cargarInsumosPuestoTrabajo(puestoTrabajo.id);">
                                                <i class="fa fa-refresh"></i>
                                            </button>
                                        </div>
                                        <div class="col-sm-12 col-lg-10">
                                            <strong class="text text-success control-label"><h2>Insumos</h2></strong>
                                        </div>
                                        <div class="col-sm-12 col-lg-1" id="paddinTop20">
                                            <button ng-show="html.btnUsarVariosInsumos" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab btn-success" id="btnUsarVariosInsumos" type="button" href="/#_UsarVariosInsumos" aria-control="" data-toggle="tab" role="tab">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-lg-12" ng-show="html.noInsumo" id="paddinTop20">
                                        <div class="alert alert-danger">No hay insumos disponibles</div>
                                    </div>
                                    <div class="col-lg-12" style="padding-top: 20px;">
                                        <div class="form-group">
                                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                                <input class="mdl-textfield__input" id="txtSearch" name="txtSearch" ng-model="txtSearchInsumos">
                                                <span class="mdl-textfield__label" for="txtSearch" style="display: inline-flex;">
                                                    <span class="material-icons">search</span><span> Buscar insumos o herramientas</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12" ng-show="insumos" id="paddinTop20">
                                        <center>
                                            <div class="table-responsive">
                                                <table class="mdl-data-table mdl-js-data-table">
                                                    <thead>
                                                        <tr>
                                                            <td class="mdl-data-table__cell--non-numeric">
                                                                <input class="form-control-sm" type="checkbox" id="_chkAllInsumos" ng-model="html.chksInsumos" ng-change="seleccionarAllInsumos()">
                                                            </td>
                                                            <th class="hide" ng-click="orden='foto'">
                                                                <span class="fa fa-camera-retro"></span>
                                                            </th>
                                                            <th class="mdl-data-table__cell--non-numeric" ng-click="orden='insumo[0].nombrePuc'">Insumo</th>
                                                            <th ng-click="orden='cantidad'">Cantidad</th>
                                                            <th class="mdl-data-table__cell--non-numeric" ng-click="orden='nombreEstado'">Estado</th>
                                                            <th class="mdl-data-table__cell--non-numeric">Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr ng-repeat="dato in insumos | filter: txtSearchInsumos | orderBy: orden">
                                                            <td class="mdl-data-table__cell--non-numeric">
                                                                <input ng-show="!getUsado(dato)" class="form-control-sm" type="checkbox" id="_chkInsumo" ng-checked="dato.chk" ng-model="dato.chk" ng-change="separarIdInsumo(dato.chk, dato.id)">
                                                            </td>
                                                            <td class="hide">
                                                                <div class="thumbnail">
                                                                    <img ng-hide="dato.insumo[0]['notImage']" class="img-responsive" style="width: 50px;" src="system/Uploads/Imgs/Productos/{{ dato.insumo[0]['foto'] }}">
                                                                    <img ng-show="dato.insumo[0]['notImage']" class="img-responsive" style="width: 50px;" src="design/pics/imagenes/not_image.jpg" data-toggle="tooltip" title="Este producto no cuenta con una imagen">
                                                                </div>
                                                            </td>
                                                            <td class="mdl-data-table__cell--non-numeric">{{ dato.insumo[0].nombrePuc }}</td>
                                                            <td>{{ dato.cantidad }}</td>
                                                            <td class="mdl-data-table__cell--non-numeric">{{ dato.nombreEstado }}</td>
                                                            <td class="mdl-data-table__cell--non-numeric">
                                                                <h4>
                                                                    <a ng-show="!getUsado(dato)" href="/#usarInsumo_{{ dato.id }}" aria-control="" data-toggle="tab" rol="tab"><span class="text-success fa fa-handshake-o" title="Registrar uso"></span></a>
                                                                    <a ng-show="!getUsado(dato)" id="paddingLeft10" ng-click="seleccionarInsumoUsarYTerminar(dato)" href='/#UsarYTerminarInsumo' title='Registrar uso y terminacion' aria-control="" data-toggle="tab" role="tab" ><span class="text-warning fa fa-legal"></span></a>
                                                                    <a ng-show="dato.btnUsar" id="paddingLeft10" ng-click="seleccionarInsumoUsarYTerminar(dato)" href='/#_TerminarInsumo' title='Terminar insumo' aria-control="" data-toggle="tab" role="tab"><span class="text-danger fa fa-flag-checkered"></span></a>
                                                                </h4>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </center>
                                    </div>
                                </div>
                                <!--Registro de insumo-->
                                <div role="tabpanel" class="tab-pane" id="adicionarInsumo">
                                    <div class="col-sm-12 col-lg-12" id="paddinTop10">
                                        <div class="col-md-12 col-sm-12 table-responsive">
                                            <strong class="text text-success control-label"><h2>Adicionar insumo para el puesto de trabajo {{ puestoTrabajo.nombre }}</h2></strong>
                                        </div>
                                        <div class="row col-md-12 text-capitalize" id="paddinTop20">
                                            <div class="col-md-1"></div>
                                            <div class="col-md-10">
                                                <form class="form-horizontal" name="formularioInsumo" method="POST" action="#">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-addon" ng-init="insumoPT.idInsumo='#'">Insumo:</span>
                                                                <select class="form-control has-success" name="idInsumo" ng-model="insumoPT.idInsumo" id="sltInsumos">
                                                                    <?= Producto::getDatosEnOptions("stock>stockMinimo and stock<=stockMaximo", "order by id desc", null)?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-addon" ng-init="insumoPT.cantidad=1">Cantidad:</span>
                                                                <input type="number" class="form-control has-primary input-sm" name="cantidad" value="" placeholder="Ejemplo: 2" min="1" required="" ng-model="insumoPT.cantidad"/>
                                                            </div>
                                                        </div>
                                                        <div class="hidden">
                                                            <div class="col-md-12"><input type="hidden" name="idPT"></div>
                                                            <div class="col-md-12"><input type="hidden" name="usuario"  ng-init="insumoPT.usuario='<?=$USUARIO->getUsuario()?>'"></div>
                                                        </div>
                                                        <div class="form-group" id="paddinTop30">
                                                            <div id="showInsumoEnviadoToast" class="col-md-12">
                                                                <input class="btn btn-info" id="btnRegistrarInsumo" type="button" name="accion" value="Registrar" ng-click="registrarInsumo(puestoTrabajo);">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-md-1"></div>
                                        </div>
                                    </div>
                                </div>
                                <!--Fin Registro de insumo-->
                                <!--------------------------------------------->
                                <!--Registro de novedad-->
                                <div role="tabpanel" class="tab-pane" id="enviarNovedad">
                                    <div class="col-sm-12 col-lg-12" id="paddinTop10">
                                        <div class="col-md-12 col-sm-12 table-responsive" >
                                            <strong class="text text-success control-label"><h2>Enviar novedad</h2></strong>
                                        </div>
                                        <div class="row col-md-12 text-capitalize" id="paddinTop20">
                                            <div class="col-md-1"></div>
                                            <div class="col-md-10">
                                                <form class="form-horizontal" name="formularioNovedad" id="formularioNovedad" ng-submit="registrarNovedad()">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">* Novedad:</span>
                                                                <textarea class="form-control has-primary" name="txtNovedad" id="txtNovedad" ng-model="novedadPT.novedad" placeholder="Escribre la novedad que deseas enviar para este puesto de trabajo" rows="5"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-lg-12" ng-show="novedadPT.novedad==null && formularioNovedad.$submitted">
                                                            <div class="alert alert-danger">Debes rellenar este campo</div>
                                                        </div>
                                                        <div class="form-group" id="paddinTop30">
                                                            <div id="showNovedadEnviada" class="col-md-12">
                                                                <input class="btn btn-info" id="btnRegistrarNovedad" type="submit" name="accion" value="Enviar">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-md-1"></div>
                                        </div>
                                    </div>
                                </div>
                                <!--Fin Registro de novedad-->
                                <!--------------------------------------------->
                                <!--Usar insumo-->
                                <div ng-repeat="dato in insumos" role="tabpanel" class="tab-pane" id="usarInsumo_{{ dato.id }}">
                                    <div class="col-sm-12 col-lg-12" id="paddinTop10">
                                        <div class="col-md-12 col-sm-12 table-responsive" >
                                            <strong class="text text-success control-label"><h2>Usar insumo</h2></strong>
                                        </div>
                                        <div class="row col-md-12">
                                            <div class="col-md-12 page-header" id="paddinTop-20">
                                                <div class="col-sm-12 col-lg-12 table-responsive">
                                                    <div class="thumbnail">
                                                        <img ng-hide="dato.insumo[0]['notImage']" class="img-responsive" style="width: 150px;" src="system/Uploads/Imgs/Productos/{{ dato.insumo[0]['foto'] }}">
                                                        <img ng-show="dato.insumo[0]['notImage']" class="img-responsive" style="width: 150px;" src="design/pics/imagenes/not_image.jpg" data-toggle="tooltip" title="Este producto no cuenta con una imagen">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-lg-6 text-justify">
                                                    <label class="text-nowrap text-uppercase">Insumo: </label><span class="text text-muted"> {{ dato.insumo[0].nombrePuc }}</span>
                                                </div>
                                                <div class="col-sm-12 col-lg-6 text-justify">
                                                    <label class="text-nowrap text-uppercase">Presentacion: </label><span class="text text-muted"> {{ dato.insumo[0].nombrePresentacion }}</span>
                                                </div>
                                                <div class="col-sm-12 col-lg-6 text-justify">
                                                    <label class="text-nowrap text-uppercase">Unidad medida: </label><span class="text text-muted"> {{ dato.insumo[0].nombreUnidadMedida }}</span>
                                                </div>
                                                <div class="col-sm-12 col-lg-6 text-justify">
                                                    <label class="text-nowrap text-uppercase">Proveedor: </label><span class="text text-muted"> {{ dato.insumo[0].nombreProveedor }}</span>
                                                </div>
                                                <div class="col-sm-12 col-lg-12 text-justify">
                                                    <label class="text-nowrap text-uppercase">Cantidad a usar: </label><span class="text text-muted"> {{ dato.cantidad }}</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-lg-12 text-center" id="paddinTop10">
                                                <label class="text text-nowrap text-uppercase">Esta seguro de usar este insumo?</label>
                                            </div>
                                            <div class="col-sm-12 col-lg-12" id="paddinTop20">
                                                <div class="col-md-12">
                                                    <button id="btnRegresarLista" class="btn btn-default" type="button" href="/#lista" aria-control="" data-toggle="tab" role="tab">Regresar</button>
                                                    <button class="btn btn-info" id="btnUsarInsumo" type="button" name="accion" ng-click="usarInsumo(dato.id, true)" href="/#lista" aria-control="" data-toggle="tab" role="tab">Usar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Fin usar insumo-->
                                <!--------------------------------------------->
                                <!--Usar y Terminar insumo-->
                                <div role="tabpanel" class="tab-pane" id="UsarYTerminarInsumo">
                                    <div class="col-sm-12 col-lg-12" id="paddinTop10">
                                        <div class="col-md-12 col-sm-12 table-responsive" >
                                            <strong class="text text-success control-label"><h2>Usar y terminar insumo</h2></strong>
                                        </div>
                                        <form name="frmUsarYTerminar" id="frmUsarYTerminar" ng-submit="UsarYTerminarInsumo(insumoUsarYTerminar.id, true)">
                                            <div class="row col-md-12">
                                                <div class="col-sm-12 col-lg-12 page-header" id="paddinTop-20">
                                                    <div class="col-sm-12 col-lg-12 table-responsive">
                                                        <div class="thumbnail">
                                                            <img ng-hide="insumoUsarYTerminar.insumo[0].notImage" class="img-responsive" style="width: 150px;" src="system/Uploads/Imgs/Productos/{{ insumoUsarYTerminar.insumo[0]['foto'] }}">
                                                            <img ng-show="insumoUsarYTerminar.insumo[0].notImage" class="img-responsive" style="width: 150px;" src="design/pics/imagenes/not_image.jpg" data-toggle="tooltip" title="Este producto no cuenta con una imagen">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-lg-6 text-justify">
                                                        <label class="text-nowrap text-uppercase">Insumo: </label><span class="text text-muted"> {{ insumoUsarYTerminar.insumo[0].nombrePuc }}</span>
                                                    </div>
                                                    <div class="col-sm-12 col-lg-6 text-justify">
                                                        <label class="text-nowrap text-uppercase">Presentacion: </label><span class="text text-muted"> {{ insumoUsarYTerminar.insumo[0].nombrePresentacion }}</span>
                                                    </div>
                                                    <div class="col-sm-12 col-lg-6 text-justify">
                                                        <label class="text-nowrap text-uppercase">Unidad medida: </label><span class="text text-muted"> {{ insumoUsarYTerminar.insumo[0].nombreUnidadMedida }}</span>
                                                    </div>
                                                    <div class="col-sm-12 col-lg-6 text-justify">
                                                        <label class="text-nowrap text-uppercase">Proveedor: </label><span class="text text-muted"> {{ insumoUsarYTerminar.insumo[0].nombreProveedor }}</span>
                                                    </div>
                                                    <div class="col-sm-12 col-lg-12 text-justify">
                                                        <label class="text-nowrap text-uppercase">Cantidad a usar y terminar: </label><span class="text text-muted"> {{ insumoUsarYTerminar.cantidad }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-lg-12">
                                                    <div class="col-sm-12 col-lg-12">
                                                        <div class="form-group" ng-show="html.fotoTerminacion">
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-12">
                                                                    <div class="thumbnail">
                                                                        <img class="card-img-top" id="imgVerTerminacion" style="height: 300px;" ng-src="{{ thumb.dataURL }}">
                                                                        <div class="caption">
                                                                            <button class="btn btn-warning" id="btnEliminarImgTerminacion" type="button" ng-click="deleteImg()">Borrar</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">* Foto:</span>
                                                                <input id="file" type="file" class="form-control btn btn-default" name="file" required="" accept="image/*" onchange="angular.element(this).scope().photoChanged(this.files)" uploader-model="file">
                                                            </div>
                                                        </div>
                                                        <div class="alert alert-danger text-center" id="paddinTop10" ng-show="html.imgTerminacion=='' && frmUsarYTerminar.$submitted && html.imgTerminacion==null">Debes subir una foto que evidencie la terminacion de la herramienta</div>
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">* Observaciones:</span>
                                                                <textarea class="form-control" id="txtObservacionesUsaryTerminarInsumo" name="txtUsarYTerminarInsumo" required="" ng-model="terminacionInsumo.observaciones" placeholder="Escribe algunas observaciones"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-lg-12 text-center" id="paddinTop10">
                                                    <label class="text text-nowrap text-uppercase">Esta seguro de usar y terminar este insumo?</label>
                                                </div>
                                                <div class="col-sm-12 col-lg-12" id="paddinTop20">
                                                    <div class="col-md-12">
                                                        <button id="btnRegresarLista_2" class="btn btn-default" type="button" href="/#lista" aria-control="" data-toggle="tab" role="tab" ng-click="limpiarUsarYTerminarInsumo()">Regresar</button>
                                                        <button ng-disabled="html.btnUsarYTerminarInsumo" class="btn btn-info" id="btnUsarYTerminarInsumo" type="submit" name="accion">Aceptar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!--Fin usar y terminar insumo-->
                                <!--------------------------------------------->
                                <!--Terminar insumo-->
                                <div role="tabpanel" class="tab-pane" id="_TerminarInsumo">
                                    <div class="col-sm-12 col-lg-12" id="paddinTop10">
                                        <div class="col-md-12 col-sm-12 table-responsive" >
                                            <strong class="text text-success control-label"><h2>Terminar insumo</h2></strong>
                                        </div>
                                        <form name="frmTerminar" id="frmTerminar" ng-submit="UsarYTerminarInsumo(insumoUsarYTerminar.id, false)">
                                            <div class="row col-md-12">
                                                <div class="col-sm-12 col-lg-12 page-header" id="paddinTop-20">
                                                    <div class="col-sm-12 col-lg-12 table-responsive">
                                                        <div class="thumbnail">
                                                            <img ng-hide="insumoUsarYTerminar.insumo[0].notImage" class="img-responsive" style="width: 150px;" src="system/Uploads/Imgs/Productos/{{ insumoUsarYTerminar.insumo[0]['foto'] }}">
                                                            <img ng-show="insumoUsarYTerminar.insumo[0].notImage" class="img-responsive" style="width: 150px;" src="design/pics/imagenes/not_image.jpg" data-toggle="tooltip" title="Este producto no cuenta con una imagen">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-lg-6 text-justify">
                                                        <label class="text-nowrap text-uppercase">Insumo: </label><span class="text text-muted"> {{ insumoUsarYTerminar.insumo[0].nombrePuc }}</span>
                                                    </div>
                                                    <div class="col-sm-12 col-lg-6 text-justify">
                                                        <label class="text-nowrap text-uppercase">Presentacion: </label><span class="text text-muted"> {{ insumoUsarYTerminar.insumo[0].nombrePresentacion }}</span>
                                                    </div>
                                                    <div class="col-sm-12 col-lg-6 text-justify">
                                                        <label class="text-nowrap text-uppercase">Unidad medida: </label><span class="text text-muted"> {{ insumoUsarYTerminar.insumo[0].nombreUnidadMedida }}</span>
                                                    </div>
                                                    <div class="col-sm-12 col-lg-6 text-justify">
                                                        <label class="text-nowrap text-uppercase">Proveedor: </label><span class="text text-muted"> {{ insumoUsarYTerminar.insumo[0].nombreProveedor }}</span>
                                                    </div>
                                                    <div class="col-sm-12 col-lg-12 text-justify">
                                                        <label class="text-nowrap text-uppercase">Cantidad a terminar: </label><span class="text text-muted"> {{ insumoUsarYTerminar.cantidad }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-lg-12">
                                                    <div class="col-sm-12 col-lg-12">
                                                        <div class="form-group" ng-show="html.fotoTerminacion">
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-12">
                                                                    <div class="thumbnail">
                                                                        <img class="card-img-top" id="imgVerTerminacion" style="height: 300px;" ng-src="{{ thumb.dataURL }}">
                                                                        <div class="caption">
                                                                            <button class="btn btn-warning" id="btnEliminarImgTerminacion" type="button" ng-click="deleteImg()">Borrar</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">* Foto:</span>
                                                                <input id="file" type="file" class="form-control btn btn-default" name="file" required="" accept="image/*" onchange="angular.element(this).scope().photoChanged(this.files)" uploader-model="file">
                                                            </div>
                                                        </div>
                                                        <div class="alert alert-danger text-center" id="paddinTop10" ng-show="html.imgTerminacion=='' && frmUsarYTerminar.$submitted && html.imgTerminacion==null">Debes subir una foto que evidencie la terminacion de la herramienta</div>
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">* Observaciones:</span>
                                                                <textarea class="form-control" id="txtObservacionesUsaryTerminarInsumo" name="txtUsarYTerminarInsumo" required="" ng-model="terminacionInsumo.observaciones" placeholder="Escribe algunas observaciones"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-lg-12 text-center" id="paddinTop10">
                                                    <label class="text text-nowrap text-uppercase">Esta seguro terminar este insumo?</label>
                                                </div>
                                                <div class="col-sm-12 col-lg-12" id="paddinTop20">
                                                    <div class="col-md-12">
                                                        <button id="btnRegresarLista_2" class="btn btn-default" type="button" href="/#lista" aria-control="" data-toggle="tab" role="tab" ng-click="limpiarUsarYTerminarInsumo()">Regresar</button>
                                                        <button ng-disabled="html.btnUsarYTerminarInsumo" class="btn btn-info" id="btnUsarYTerminarInsumo" type="submit" name="accion">Aceptar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!--Fin terminar insumo-->
                                <!--------------------------------------------->
                                <!--Usar varios insumos-->
                                <div role="tabpanel" class="tab-pane" id="_UsarVariosInsumos">
                                    <div class="col-sm-12 col-lg-12" id="paddinTop10">
                                        <div class="col-md-12 col-sm-12 table-responsive" >
                                            <strong class="text text-success control-label"><h2>Usar insumos</h2></strong>
                                        </div>
                                        <div class="row col-md-12">
                                            <div class="col-md-12 page-header text-justify" id="paddinTop-20">
                                                <div ng-repeat="dato in insumos" ng-show="dato.chk" class="col-sm-12 col-lg-6 table-responsive">
                                                    <span class="mdl-chip mdl-chip--contact">
                                                        <span class="mdl-chip__contact mdl-color--teal mdl-color-text--white">{{ dato.id }}</span>
                                                        <span class="mdl-chip__text">{{ dato.insumo[0].nombrePuc }} <small class="text text-muted">( {{ dato.cantidad }} )</small></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-lg-12 text-center" id="paddinTop10">
                                                <label class="text text-nowrap text-uppercase">Esta seguro de usar estos insumos?</label>
                                            </div>
                                            <div class="col-sm-12 col-lg-12" id="paddinTop20">
                                                <div class="col-md-12">
                                                    <button id="btnRegresarLista" class="btn btn-default" type="button" href="/#lista" aria-control="" data-toggle="tab" role="tab">Regresar</button>
                                                    <button class="btn btn-info" id="btnUsarInsumos" type="button" name="accion" ng-click="usarInsumo('NO', false)" href="/#lista" aria-control="" data-toggle="tab" role="tab">Usar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Fin usar varios insumos-->
                            </div>
                        </div>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-danger' id="btnCancelarSolicitud" data-dismiss='modal' >Cerrar</button>
                        <!--<a href="/#TerminacionEnviada" data-toggle="modal">
                            <button type='button' class='btn btn-success' id="btnAprobar" data-dismiss="modal">Terminar</button>
                        </a>-->
                    </div>
                </div>
            </div>
            <div class="mdl-tooltip" for="_chkAllInsumos">Seleccionar todos los registros</div>
            <div class="mdl-tooltip" for="btnUsarVariosInsumos">Usar insumos seleccionados</div>
            <div class="mdl-tooltip" for="btnRecargarListaInsumos">Recargar listado</div>
            <div id="toast-content-dialog" class="mdl-js-snackbar mdl-snackbar">
                <div class="mdl-snackbar__text"></div>
                <button class="mdl-snackbar__action" type="button"></button>
            </div>
        </div>
    </div>
    <!--Fin Puesto Trabajo-->
    <!--Detalles-->
    <div class='modal fade' id='_Dialog_DetallesProceso'>
        <div class='modal-dialog modal-lg'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' id="btnCerrarDialogFormularioLlanta_A" data-dismiss='modal'>&times;</button>
                    <h3 class="text text-primary">INFORMACION<br><small>(Llanta y OS)</small></h3>
                </div>
                <div class="modal-header">
                    <div class="text-justify">
                        <div class="col-sm-12 col-lg-12">
                            <div class="col-sm-12 col-lg-12">
                                <h3>OS: <?= $servicio->getOs() ?></h3>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Cliente:</label><span class="text text-muted"> <?= $servicio->getCliente()->getNombreEmpresa() ?></span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Vendedor:</label><span class="text text-muted"> <?= $servicio->getVendedor()->getPersona()->getNombresCompletos() ?></span>
                            </div>
                            <div class="col-sm-12 col-lg-12">
                                <label class="text-nowrap">Observaciones:</label><span class="text text-muted"> <?= $servicio->getObservaciones() ?></span>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-12">
                            <div class="col-sm-12 col-lg-12">
                                <h3>Llanta</h3>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">RP:</label><span class="text text-muted"> <?= $llanta->getRp() ?></span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Serie:</label><span class="text text-muted"> <?= $llanta->getSerie() ?></span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Marca:</label><span class="text text-muted"> <?= $llanta->getMarca()->getNombre() ?></span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Gravado:</label><span class="text text-muted"> <?= $llanta->getGravado()->getNombre() ?></span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Aplicacion original:</label><span class="text text-muted"> <?= $llanta->getAplicacionOriginal()->getReferenciaTipoLlanta()->getTipoLlanta()->getNombre() ?> / <?= $llanta->getAplicacionOriginal()->getMedidaCompleta() ?> (<?= $llanta->getAplicacionOriginal()->getReferenciaTipoLlanta()->getReferencia() ?>)</span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Aplicacion solicitada:</label><span class="text text-muted"> <?= $llanta->getAplicacionSolicitada()->getReferenciaTipoLlanta()->getTipoLlanta()->getNombre() ?> / <?= $llanta->getAplicacionSolicitada()->getMedidaCompleta() ?> (<?= $llanta->getAplicacionSolicitada()->getReferenciaTipoLlanta()->getReferencia() ?>)</span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <label class="text-nowrap">Aplicacion rencauche:</label><span class="text text-muted"> <?= $llanta->getAplicacionEntregada()->getReferenciaTipoLlanta()->getTipoLlanta()->getNombre() ?> / <?= $llanta->getAplicacionEntregada()->getMedidaCompleta() ?> (<?= $llanta->getAplicacionEntregada()->getReferenciaTipoLlanta()->getReferencia() ?>)</span>
                            </div>
                            <div class="col-sm-12 col-lg-3">
                                <label class="text-nowrap">Estado:</label><span class="text text-muted"> <?= $llanta->getNombreProcesado()?></span>
                            </div>
                            <div class="col-sm-12 col-lg-3">
                                <label class="text-nowrap">Urgente:</label><span class="text text-muted"> <?= $llanta->getNombreUrgente()?></span>
                            </div>
                            <div class="col-sm-12 col-lg-12">
                                <label class="text-nowrap">Observaciones:</label><span class="text text-muted"> <?= $objeto->getObservaciones() ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-danger' data-dismiss='modal'>Cerrar</button>
                </div>
            </div>
        </div>
        <!--TOOLTIPS-->
        <div class="mdl-tooltip" data-mdl-for="btnCerrarDialogFormularioLlanta_A">Cerrar</div>
        <!--FIN TOOLTIPS-->
        <!--------------------------------------------------------------------->
    </div>
    <!--Fin Detalles-->
</div>
<div id="toast-content" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button"></button>
</div>
<?php
}