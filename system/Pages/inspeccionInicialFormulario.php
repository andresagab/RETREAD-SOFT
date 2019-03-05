<script src="lib/controladores/rechazoLlanta.js"></script>
<script src="lib/controladores/inspeccionInicial.js"></script>
<div ng-controller="rechazoLlanta">
    <div ng-controller="inspeccionInicial">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <strong class="text text-primary text-uppercase mdl-color-text--blue"><h2>inspección inicial</h2></strong>
        </div>
        <div class="col-md-4">
            <button class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab btn-info" id="btnDetalles" type="button" href="/#_Dialog_DetallesProceso" data-toggle="modal">
                <i class="fa fa-info-circle"></i>
            </button>
            <div class="mdl-tooltip" for="btnDetalles">Detalles de la llanta y la orden de servicio</div>
        </div>
        <div class="row col-md-12" id="paddinTop20" ng-show="html.alerta">
            <div class="alert alert-{{ html.colorAlerta }}">{{ html.mjsAlerta }} <b>{{ html.mjsAlertaResaltado }}</b></div>
        </div>
        <div class="row col-md-12" id="paddinTop20" ng-show="components.loadSpinner">
            <center>
                <div class="mdl-progress mdl-js-progress mdl-progress__indeterminate"></div>
            </center>
        </div>
<?php
include_once dirname(__FILE__).'/../../lib/php/Time.php';
include_once dirname(__FILE__).'/../../lib/php/functions.system.php';
require_once dirname(__FILE__).'\..\Clases\Persona.php';
require_once dirname(__FILE__).'\..\Clases\Cargo_Empleado.php';
require_once dirname(__FILE__).'\..\Clases\Empleado.php';
require_once dirname(__FILE__).'\..\Clases\Cliente.php';
require_once dirname(__FILE__).'\..\Clases\Tipo_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Marca_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Dimension_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Gravado_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Referencia_Tipo_Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Dimension_Referencia.php';
require_once dirname(__FILE__).'\..\Clases\Llanta.php';
require_once dirname(__FILE__).'\..\Clases\Servicio.php';
require_once dirname(__FILE__).'\..\Clases\Inspeccion_Inicial.php';
if (isset($_GET['id'])) {
    ?>
        <input type="hidden" id="txtIdLlanta" value="<?= $_GET['id'] ?>">
    <?php
    $llanta = new Llanta('id', $_GET['id'], null, null);
    $servicio = $llanta->getServicio();
    if (validVal($llanta->getFechaInicioProcesoVal())) {
        if (getDiffTimeInSeconds($llanta->getFechaInicioProcesoVal(), date('Y-m-d H:i:s'))>=240) {
            $object = new Inspeccion_Inicial('idLlanta', $llanta->getId(), null, null);
            if (validVal($object->getId())) {
                if (!validVal($object->getIdEmpleado()) && $object->getEstado()==='prs') {
                    ?>
                    <input type="hidden" id="timeElapsed" value="<?= getDiffTiempo($llanta->getFechaInicioProcesoVal(), date('Y-m-d H:i:s')) ?>">
                    <!-- TIME ELAPSED -->
                    <div class="col-sm-12 col-md-12">
                        <h2 class="mdl-color-text--red-800">{{ inspeccionInicial.data.timeElapsed }}</h2>
                    </div>
                    <!-- END TIME ELAPSED -->
                    <!-- FORM -->
                    <div class="col-md-12" id="paddinTop20">
                        <form class="form-horizontal" name="formulario" method="POST" action="principal.php?CON=system/Pages/inspeccionInicialActualizar.php" enctype="multipart/form-data">
                            <div class="col-sm-12 col-md-4"></div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">* Numero reencauche:</span>
                                        <input class="form-control has-primary" type="number" id="numeroRencauche" name="numeroRencauche" value="" min="1" max="5" placeholder="Ejm: 1" step="1" required>
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
                                            <input type="file" class="form-control btn btn-default" name="foto" id="foto" required accept="image/*" onchange="angular.element(this).scope().photoChanged(this.files)">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">Estado:</span>
                                        <span class="input-group-addon">
                                        <span id="paddingLeft70"></span>
                                        <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="estado">
                                            <input type="checkbox" id="estado" class="mdl-switch__input" name="checked" ng-model="html.estado" ng-change="cargarNombreEstado(html.estado)">
                                        </label>
                                    </span>
                                        <span class="input-group-addon"><label id="textoEstado">{{ cargarNombreEstado(html.estado) }}</label></span>
                                    </div>
                                </div>
                                <div class="form-group center-block" id="divBtnSeleccionarRechazos" ng-show="!html.estado">
                                    <button class="btn btn-success" id="btnSeleccionarRechazos" type="button" href="/#seleccionarRechazos" data-toggle="modal" ng-click="loadRechazosOfProceso(<?=$llanta->getId()?>, 0)">Seleccionar rechazos</button>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">Observaciones:</span>
                                        <textarea class="form-control has-primary input-sm" name="observaciones" placeholder="Observaciones para este proceso" maxlength="500"></textarea>
                                    </div>
                                </div>
                                <div class="hidden">
                                    <div class="col-md-12"><input type="hidden" name="idEmpleado" value="<?=$USUARIO->getIdEmpleadoUsuario()?>"></div>
                                    <div class="col-md-12"><input type="hidden" name="id" value="<?=$object->getId()?>"></div>
                                    <div class="col-md-12"><input type="hidden" name="idLlanta" value="<?=$llanta->getId()?>"></div>
                                    <div class="col-md-12"><input type="hidden" name="accion" value="Registrar"></div>
                                </div>
                                <div class="form-group" id="paddinTop30">
                                    <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--red-400 mdl-color-text--white" type="button" ng-click="backPage();">CANCELAR</button>
                                    <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--primary" type="reset" onclick="document.getElementById('btnEliminarImg').click();">REINICIAR</button>
                                    <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--green-400 mdl-color-text--white" type="submit">ENVIAR</button>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4"></div>
                        </form>
                    </div>
                    <!-- END FORM -->
                    <!-- RECHAZOS -->
                    <div class='modal fade' id='seleccionarRechazos'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <button type='button' class='close' data-dismiss='modal' ng-click="limpiarVariables();">&times;</button>
                                    <h3 class="text text-primary text-uppercase mdl-color-text--blue">Rechazos</h3>
                                </div>
                                <div class="modal-header">
                                    <div class="row col-md-12" id="paddinTop20" ng-hide="objetos">
                                        <center>
                                            <div class="mdl-progress mdl-js-progress mdl-progress__indeterminate"></div>
                                        </center>
                                    </div>
                                    <div class="col-lg-12 table-responsive" ng-show="objetos">
                                        <center>
                                            <table class="mdl-data-table">
                                                <thead>
                                                <tr>
                                                    <th class="mdl-data-table__cell--non-numeric" ng-click="order='nombre'">RECHAZO</th>
                                                    <th class="mdl-data-table__cell--non-numeric">ESTADO</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr ng-repeat="objeto in objetos | orderBy: order">
                                                    <td class="mdl-data-table__cell--non-numeric">{{ objeto.nombre }}</td>
                                                    <td class="mdl-data-table__cell--non-numeric">
                                                        <input ng-show="!objeto.checked" class="mdl-checkbox__input" id="chk_{{ objeto.id }}" type="checkbox" name="chk_{{  objeto.id }}" ng-model="chk" ng-click="separarRechazo(chk, objeto.id)">
                                                        <input ng-show="objeto.checked" class="mdl-checkbox__input" id="chk" type="checkbox" name="chk_{{  objeto.id }}" checked="" disabled="">
                                                        <input ng-show="objeto.checked" class="mdl-checkbox__input" id="chk" type="checkbox" name="chk_{{  objeto.id }}" ng-model="chk" ng-click="separarRechazo(chk, objeto.id)">
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </center>
                                    </div>
                                </div>
                                <div class="modal-header">
                                    <div class="col-lg-12 form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon" ng-init="observaciones=''">Observaciones:</span>
                                            <textarea class="form-control has-primary" name="observaciones" placeholder="Escribe algunas observaciones de las causas del rechazo" ng-model="observaciones">{{ observaciones }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="alert alert-warning" ng-show="!chequeados">
                                    <span class="text-muted">!Si esta inspección va ha ser rechazada se debe marcar por lo menos una causa¡</span>
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-danger' id="btnCancelarSolicitud" data-dismiss='modal' ng-click="limpiarVariables();">Cancelar</button>
                                    <a href="/#solicitudEnviada" data-toggle="modal">
                                        <button ng-hide="!chequeados" type='button' class='btn btn-success {{ objeto.btnAprobar }}' id="btnAprobar" data-dismiss="modal" ng-click="registrarRechazos(<?= $object->getId(); ?> , observaciones, 0, <?=$llanta->getId()?>)">Aprobar eliminacion</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END RECHAZOS -->
                    <?php
                } elseif (validVal($object->getIdEmpleado()) && validVal($object->getFoto()) && validVal($object->getNumeroRencauche()) && $object->getEstado()==='prf') {
                    if ($object->getChecked()) {
                        $colorAlert = 'success';
                        $mjs = 'llanta aprobada';
                    } else {
                        $colorAlert = 'danger';
                        $mjs = 'llanta rechazada';
                    }
                    ?>
                    <div class="col-md-12" id="paddinTop20">
                        <div class="alert alert-<?= $colorAlert ?>">
                            <h4>EL PROCESO FUE REGISTRADO EXITOSAMENTE</h4>
                            <span style="font-size: 20px;"><?= $mjs ?></span>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-12" id="paddinTop20">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <div class="col-sm-12 col-md-12 col-lg-12" align="left">
                                        <h4 class="text-uppercase mdl-color-text--green-500">INFORMACIÓN REGISTRADA</h4>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-12" id="paddinTop20" align="left">
                                        <p>
                                            <span class="text-uppercase">EMPLEADO: </span><span class="text-muted"><?= $object->getEmpleado()->getPersona()->getNombresCompletos() ?></span>
                                        </p>
                                        <p>
                                            <span class="text-uppercase">NUMERO REENCAUCHE: </span><span class="text-muted"><?= $object->getNumeroRencauche() ?></span>
                                        </p>
                                        <p>
                                            <span class="text-uppercase">ESTADO: </span><span class="text-muted"><?= $object->getNombreChecked(); ?></span>
                                        </p>
                                        <p>
                                            <span class="text-uppercase">OBSERVACIONES: </span><span class="text-muted"><?= $object->getObservaciones() ?></span>
                                        </p>
                                        <p>
                                            <span class="text-uppercase">TIEMPO DE EJECUCIÓN: </span><span class="text-muted"><?= getDiffTiempoString($llanta->getFechaInicioProceso(), $object->getFechaRegistro()) ?></span>
                                        </p>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-12" id="paddinTop20" align="center">
                                        <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--red-400 mdl-color-text--white" type="button" ng-click="backPage();">REGRESAR</button>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <div class="col-sm-12 col-md-12 col-lg-12" align="left">
                                        <p>
                                            <span class="text-uppercase">EVIDENCIA FOTOGRÁFICA: </span><span class="text-muted">
                                        </p>
                                    </div>
                                    <img class="img img-responsive" ng-src="system/Uploads/Imgs/Inspeccion_Inicial/<?= $object->getFoto() ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else header('Location: principal.php?CON=system/pages/unknowData.php');
        } else {
            ?>
                <input type="hidden" id="diffTime" value="<?= getDiffTimeInSeconds($llanta->getFechaInicioProcesoVal(), date('Y-m-d H:i:s')) ?>">
                <div class="row col-md-12" id="paddinTop20">
                    <div class="alert alert-warning"><h3>El formulario de registro se habilitara cuando el cronometro llegue a 4 minutos: {{ inspeccionInicial.data.timeToGo }}/04:00</h3></div>
                </div>
            <?php
        }
    } else {
        ?>
            <div class="col-md-12" id="paddinTop20">
                <div class="alert alert-info">
                    <h4>Para habilitar el formulario de registro, clique sobre el boton de abajo. Debe tener encuenta que una vez presinado el boton, el formulario de registro se habilitara despues de 4 minutos.</h4>
                    <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--primary" ng-click="initProcess();">Iniciar proceso</button>
                </div>
            </div>
        <?php
    }
} else header('Location: principal.php?CON=system/pages/unknowData.php');
?>
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
                                <div class="col-sm-12 col-lg-6">
                                    <label class="text-nowrap">Estado:</label><span class="text text-muted"> <?= $servicio->getNombreEstado() ?></span>
                                </div>
                                <div class="col-sm-12 col-lg-6">
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
                                    <label class="text-nowrap">Dise&ntilde;o original:</label><span class="text text-muted"> <?= $llanta->getReferenciaOriginal()->getReferencia() ?></span>
                                </div>
                                <div class="col-sm-12 col-lg-6">
                                    <label class="text-nowrap">Dise&ntilde;o solicitado:</label><span class="text text-muted"> <?= $llanta->getReferenciaSolicitada()->getReferencia() ?></span>
                                </div>
                                <div class="col-sm-12 col-lg-6">
                                    <label class="text-nowrap">Estado:</label><span class="text text-muted"> <?= $llanta->getNombreProcesado()?></span>
                                </div>
                                <div class="col-sm-12 col-lg-6">
                                    <label class="text-nowrap">Urgente:</label><span class="text text-muted"> <?= $llanta->getNombreUrgente()?></span>
                                </div>
                                <div class="col-sm-12 col-lg-12">
                                    <label class="text-nowrap">Observaciones:</label><span class="text text-muted"> <?= $object->getObservaciones() ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-danger' data-dismiss='modal'>Cerrar</button>
                    </div>
                </div>
            </div>
            <div class="mdl-tooltip" data-mdl-for="btnCerrarDialogFormularioLlanta_A">Cerrar</div>
        </div>
    </div>
</div>
<div id="toast-content" class="mdl-js-snackbar mdl-snackbar">
    <div class="mdl-snackbar__text"></div>
    <button class="mdl-snackbar__action" type="button"></button>
</div>