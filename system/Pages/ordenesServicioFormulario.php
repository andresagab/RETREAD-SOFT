<?php
require_once dirname(__FILE__).'\..\Clases\Persona.php';
require_once dirname(__FILE__).'\..\Clases\Cliente.php';
require_once dirname(__FILE__).'\..\Clases\Tipo_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Marca_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Gravado_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Empleado.php';
require_once dirname(__FILE__).'\..\Clases\Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Servicio.php';
require_once dirname(__FILE__).'\..\Clases\Tipo_Servicio.php';
require_once dirname(__FILE__).'\..\Clases\Detalle_Servicio.php';
if (isset($_GET['id'])) {
    $objeto=new Servicio('id', $_GET['id'], null, null);
    $accion="Gestionar";
    $today= explode(" ", $objeto->getFechaRegistro());
    $today=$today[0];
    $grillaLlantas="system/Pages/llantasOrdenServicio.php";
} else {
    $objeto=new Servicio(null, null, null, null);
    $objeto->setNumeroFactura(Servicio::getNextNumeroFactura());
    $accion="Registrar";
    $today=date("Y-m-d");
    $grillaLlantas="system/Pages/llantasOrdenServicio.php";
}
if (strtolower($USUARIO->getRol()->getNombre())=='operario' || strtolower($USUARIO->getRol()->getNombre())=='operario cb') {
    $btnCerrarOS='hide';
}
else {
    $btnCerrarOS='';
}
?>
<script src="lib/controladores/llantasOS.js"></script>
<script src="lib/controladores/os.js"></script>
<div class="col-md-12" ng-controller="os">
    <div class="hidden" id="btnCargarEstadoOS" ng-click="cargarEstadoOS(<?= $objeto->getId() ?>)"></div>
    <div class="col-sm-12 col-md-12" id="paddinTop10" ng-show="ordenServicio.alertaCerrada">
        <div class="alert alert-{{ ordenServicio.colorAlertaCerrada }}">Esta orden de servicio esta {{ ordenServicio.mjsCerrada }}</div>
    </div>
    <div class="col-md-3 col-sm-12" >
        <button class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab btn-danger" id="btnRegresarOS" type="button" onclick="window.location='principal.php?CON=system/Pages/ordenesServicio.php';">
            <!--<i class="fa fa-arrow-left"></i>-->
            <i class="material-icons">arrow_back</i>
        </button>
        <div class="mdl-tooltip" for="btnRegresarOS">Regresar al listado de ordenes de servicio</div>
    </div>
    <div class="col-md-6 col-sm-12" >
        <strong class="text text-success control-label"><h2><?=$accion?> orden de servicio</h2></strong>
    </div>
    <div class="col-md-3 col-sm-12">
        <button class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab btn-success" id="btnRegistrarServicio" type="button" ng-disabled="os.btnRegistrarServicio" ng-click="validarDatosRegistrarOS()" ng-hide="os.btnRegistrarServicioHide">
            <!--<i class="fa fa-check"></i>-->
            <span class="material-icons">check</span>
        </button>
        <div class="mdl-tooltip" for="btnRegistrarServicio">Registrar servicio</div>
        <button class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab btn-info" id="btnAyuda" type="button" href="/#_DialogoAyuda" data-toggle='modal'>
        <!--<button class="mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect" id="btnAyuda" type="button" href="/#_DialogoAyuda" data-toggle='modal'>-->
            <!--<i class="fa fa-question-circle"></i>-->
            <i class="material-icons">help</i>
        </button>
        <div class="mdl-tooltip" for="btnAyuda">Ver Ayuda</div>
        <!--PRINT-->
        <button ng-hide="os.hideListaLlantas" id="btnOpcionesFiltros" class="mdl-button mdl-js-button mdl-button--icon mdl-button--fab mdl-button--mini-fab mdl-js-ripple-effect btn-default">
            <span class="material-icons">print</span>
        </button>
        <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="btnOpcionesFiltros">
            <li class="mdl-menu__item" ng-click="setFilterOS(0);">
                <i class="fa fa-list"></i><span> Imprimir todos los registros</span>
            </li>
            <li class="mdl-menu__item" ng-click="setFilterOS(1)">
                <i class="fa fa-play"></i><span> Imprimir llantas rencauchadas</span>
            </li>
            <li class="mdl-menu__item" ng-click="setFilterOS(2)">
                <i class="fa fa-times"></i><span> Imprmir llantas rechazadas</span>
            </li>
            <li class="mdl-menu__item" ng-click="setFilterOS(3)">
                <i class="fa fa-sign-out"></i><span> Imprimir llantas con salida registrada</span>
            </li>
            <li class="mdl-menu__item" ng-click="setFilterOS(4)">
                <i class="fa fa-check-circle"></i><span> Imprimir seleccionadas</span>
            </li>
        </ul>
        <div class="mdl-tooltip" for="btnOpcionesFiltros">Opciones de impresion</div>
        <!--END PRINT-->
        <button ng-hide="os.hideListaLlantas" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab btn-default hide" id="btnImprimirHoja" type="button" ng-click="imprimirHoja()">
            <!--<i class="fa fa-print"></i>-->
            <i class="material-icons">print</i>
        </button>
        <div class="mdl-tooltip hide" for="btnImprimirHoja">Imprimir</div>
        <button ng-hide="ordenServicio.btnCerrarOS" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab btn-success <?= $btnCerrarOS ?>" id="btnCerrarOS" type="button" data-toggle="modal" href="/#_CerrarOS">
            <i class="fa fa-handshake-o"></i>
        </button>
        <div class="mdl-tooltip" for="btnCerrarOS">Cerrar orden de servicio</div>
    </div>
    <div class="col-sm-12 col-md-12" id="paddinTop20">
        <div class="alert alert-{{ os.colorAlerta }} {{ os.alerta }}">{{ os.mjsAlerta }}</div>
    </div>
    <div class="{{ os.barraCarga }}">
        <div class="col-sm-12 col-md-4"></div>
        <div class="col-sm-12 col-md-4">
            <div class="mdl-progress mdl-js-progress mdl-progress__indeterminate"></div>
        </div>
        <div class="col-sm-12 col-md-4"></div>
    </div>
    <div class="row col-md-12 text-justify" id="paddinTop20">
        <div>
            <form name="formulario" method="POST" action="principal.php?CON=system/Pages/serviciosLlantaActualizar.php">
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Cliente:</span>
                            <input class="form-control" id="txtIdentificacion" name="identificacion" placeholder="CC/NIT" type="text" ng-model="html.identificacion" ng-change="cargarCliente(html.identificacion)" ng-disabled="os.inputDisabled">
                            <span class="input-group-btn {{ os.btnBuscar }}"><button class="input-group btn btn-primary" type="button" id="btnCargarCliente" ng-click="cargarCliente(html.identificacion);" ng-disabled="os.inputDisabled">Buscar</button></span>
                        </div>
                        <!--<div class="mdl-tooltip" for="txtIdentificacion">Este campo es obligatorio</div>-->
                        <div ng-hide="os.inputDisabled" class="alert alert-danger sm" ng-show="html.txtIdentificacion==null">Este campo no puede estar vacio</div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-3">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">OS:</span>
                            <!--<input class="form-control" id="txtOs" name="os" placeholder="Orden de servicio (N°)" type="number" min="1" ng-model="html.txtOs" ng-keyup="cargarOS(html.txtOs);" ng-change="cargarOS(html.txtOs)" ng-disabled="os.inputDisabled">-->
                            <input class="form-control" id="txtOs" name="os" placeholder="Orden de servicio (N°)" type="number" min="1" ng-model="html.txtOs" ng-change="cargarOS(html.txtOs)" ng-disabled="os.inputDisabled">
                        </div>
                        <!--<div class="mdl-tooltip" for="txtOs">Este campo es obligatorio</div>-->
                        <div class="alert alert-danger sm" ng-hide="os.inputDisabled" ng-show="html.txtOs==null">Este campo no puede estar vacio</div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-3">
                    <!--<div class="form-group" ng-show="ordenServicio.campoNFactura">-->
                    <div class="form-group" ng-show="true">
                        <div class="input-group" id="txtNoFactura">
                            <span class="input-group-addon">No. Factura</span>
                            <!--<input class="form-control" name="numeroFactura" type="number" value="<?=$objeto->getNumeroFactura()?>" disabled="">-->
                            <input class="form-control" name="numeroFactura" id="txtNumeroFactura" type="number" ng-model="html.txtNumeroFactura" value="<?=$objeto->getNumeroFactura()?>" min="1" ng-disabled="os.inputDisabled" ng-change="validarNumeroFactura()">
                        </div>
                        <div class="mdl-tooltip" for="txtNoFactura">Este campo es obligatorio</div>
                        <div class="alert alert-danger" ng-hide="os.inputDisabled" ng-show="html.txtNumeroFactura==null">Este campo no puede estar vacio</div>
                    </div>
                </div>
                <div class="{{ os.hideDatos }}">
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Cliente:</span>
                                <input class="form-control" id="txtEmpresa" name="empresa" type="text" ng-model="cliente[0].nombreEmpresa" readonly="">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Direccion:</span>
                                <input class="form-control" id="txtDireccion" name="empresa" type="text" ng-model="cliente[0].direccionPersona" readonly="">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon" >Fecha de recoleccion:</span>
                                <input class="form-control" id="txtFechaRecoleccion" name="fechaRecoleccion" type="date" value="<?= $today ?>" ng-disabled="os.inputDisabled">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Telefono:</span>
                                <input class="form-control" id="txtTelefono" name="telefono" type="text" ng-model="cliente[0].celularPersona" readonly="">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Vendedor:</span>
                                <input class="form-control" id="txtVendedor" name="vendedor" type="text" min="0" ng-model="html.identificacionVendedor" placeholder="CC" ng-keyup="cargarVendedor(html.identificacionVendedor);" ng-disabled="os.inputDisabled">
                                <span class="input-group-btn {{ os.btnBuscar }}"><button class="input-group btn btn-primary" type="button" id="btnCargarVendedor" ng-click="cargarVendedor(html.identificacionVendedor);" ng-disabled="os.inputDisabled">Buscar</button></span>
                            </div>
                            <div class="mdl-tooltip" for="txtVendedor">Este campo es obligatorio</div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4 {{ os.datosVendedor }}">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">Funcionario:</span>
                                <input class="form-control" id="txtNombresFuncionario" name="nombresFuncionario" type="text" ng-model="vendedor[0].nombresCompletosPersona" readonly="">
                            </div>
                            <div class="mdl-tooltip" for="txtVendedor">Este campo es obligatorio</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group col-sm-12 col-md-4" ng-repeat="objeto in tiposServicio">
                        <div class="input-group">
                            <span class="input-group-addon">{{ objeto.nombre }}</span>
                            <span class="input-group-addon"><input class="" id="chkTipoServicio_{{ objeto.id }}" name="chk_tipo_servicio_{{ objeto.id }}" type="checkbox" ng-model="objeto.checked" ng-change="separarTipoServicio(objeto.checked, objeto.id)" ng-disabled="os.inputDisabled" ng-checked="objeto.checked"></span>
                        </div>
                        <div class="mdl-tooltip" for="chkTipoServicio_{{ objeto.id }}">{{ objeto.observaciones }}</div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-lg-12" id="paddinTop20" ng-hide="os.hideListaLlantas" style="padding: 0px, 20xx, 0, 0;">
        <div><?php include $grillaLlantas; ?></div>
    </div>
    <div class='modal fade' id='_CerrarOS'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' id="btnCerrarDialogFormularioLlanta_A" data-dismiss='modal'>&times;</button>
                    <h3 class="text text-primary">CERRAR ORDEN DE SERVICIO</h3>
                </div>
                <div class="modal-header">
                    <div class="col-sm-12 col-lg-12 text-center">
                        <div class="alert alert-warning">Recuerda que despues de cerrar la orden de servicio, no se podra llevar acabo ninguna accion sobre ella.</div>
                    </div>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-default' data-dismiss='modal'>Cancelar</button>
                    <button type='button' class='btn btn-danger' ng-click="cerrarOs(false)" data-dismiss='modal'>Anular</button>
                    <button type='button' class='btn btn-success' ng-click="cerrarOs(true)" data-dismiss='modal'>Cerrar</button>
                </div>
            </div>
        </div>
        <!--TOOLTIPS-->
        <div class="mdl-tooltip" data-mdl-for="btnCerrarDialogFormularioLlanta_A">Cerrar</div>
        <!--FIN TOOLTIPS-->
        <!--------------------------------------------------------------------->
    </div>
</div>
<div class='modal fade' id='_DialogoAyuda'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header'>
                <button type='button' class='close' id="btnCerrarDialogFormularioLlanta_A" data-dismiss='modal'>&times;</button>
                <h3 class="text text-primary">AYUDA</h3>
            </div>
            <div class="modal-header">
                <div class="col-sm-12 col-lg-12">
                    <h3>SIGNIFICADO DE COLORES</h3>
                </div>
                <div class="text-justify">
                    <div class="col-sm-12 col-lg-12">
                        <div class="col-sm-12 col-lg-12">
                            <span class="mdl-chip mdl-chip--contact">
                                <span class="mdl-chip__contact mdl-color--white mdl-color-text--black">1</span>
                                <span class="mdl-chip__text">La llanta solo ha sido registrada en la orden de servicio</span>
                            </span>
                        </div>
                        <div class="col-sm-12 col-lg-12">
                            <span class="mdl-chip mdl-chip--contact">
                                <span class="mdl-chip__contact mdl-color--black mdl-color-text--white">2</span>
                                <span class="mdl-chip__text">La llanta fue rechazada durante el proceso de rencauche</span>
                            </span>
                        </div>
                        <div class="col-sm-12 col-lg-12">
                            <span class="mdl-chip mdl-chip--contact">
                                <span class="mdl-chip__contact mdl-color--red mdl-color-text--white">3</span>
                                <span class="mdl-chip__text">La llanta no ha terminado el proceso de rencauche</span>
                            </span>
                        </div>
                        <div class="col-sm-12 col-lg-12">
                            <span class="mdl-chip mdl-chip--contact">
                                <span class="mdl-chip__contact mdl-color--green mdl-color-text--white">4</span>
                                <span class="mdl-chip__text">La llanta finalizo el proceso de rencauche exitosamente</span>
                            </span>
                        </div>
                        <div class="col-sm-12 col-lg-12">
                            <span class="mdl-chip mdl-chip--contact">
                                <span class="mdl-chip__contact mdl-color--yellow mdl-color-text--black">5</span>
                                <span class="mdl-chip__text">La llanta ya ha registrado su salida y ha terminado un proceso de rencauche</span>
                            </span>
                        </div>
                        <div class="col-sm-12 col-lg-12">
                            <span class="mdl-chip mdl-chip--contact">
                                <span class="mdl-chip__contact mdl-color--blue mdl-color-text--white">6</span>
                                <span class="mdl-chip__text">Resalta la llanta como urgente (Columna 'urgente')</span>
                            </span>
                        </div>
                        <div class="col-sm-12 col-lg-12" style="padding-top: 10px">
                            <div class="alert alert-info">La orden de servicio solo puede ser cerrada cuando todas sus llantas culminen su proceso de rencauche</div>
                        </div>
                        <div class="col-sm-12 col-lg-12">
                            <div class="alert alert-info">El numero de la factura se mostrara cuando la orden de servicio sea cerrrada o anulada</div>
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
<button id="show-toast" class="mdl-button mdl-js-button mdl-button--raised hidden" type="button">Show Toast</button>
<div id="toast-content" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button"></button>
</div>