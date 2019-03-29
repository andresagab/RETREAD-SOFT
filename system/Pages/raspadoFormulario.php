<script src="lib/controladores/rechazoLlanta.js"></script>
<script src="lib/controladores/raspado.js"></script>
<div ng-controller="rechazoLlanta">
    <div ng-controller="raspado">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <strong class="text text-primary text-uppercase mdl-color-text--blue"><h2>raspado</h2></strong>
        </div>
        <div class="col-md-4">
            <button class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab btn-info" id="btnDetalles" type="button" href="/#_Dialog_DetallesProceso" data-toggle="modal">
                <i class="fa fa-info-circle"></i>
            </button>
            <div class="mdl-tooltip" for="btnDetalles">Detalles de la llanta</div>
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
//        require_once dirname(__FILE__).'\..\Clases\Cargo_Empleado.php';
        require_once dirname(__FILE__).'\..\Clases\Empleado.php';
        require_once dirname(__FILE__).'\..\Clases\Cliente.php';
        require_once dirname(__FILE__).'\..\Clases\Tipo_Llanta.php';
        require_once dirname(__FILE__).'\..\Clases\Marca_Llanta.php';
        require_once dirname(__FILE__).'\..\Clases\Dimension_Llanta.php';
        require_once dirname(__FILE__).'\..\Clases\Gravado_Llanta.php';
        require_once dirname(__FILE__).'\..\Clases\Referencia_Tipo_Llanta.php';
        require_once dirname(__FILE__).'\..\Clases\Dimension_Referencia.php';
        require_once dirname(__FILE__).'\..\Clases\Puesto_Trabajo.php';
        require_once dirname(__FILE__).'\..\Clases\Llanta.php';
        require_once dirname(__FILE__).'\..\Clases\Servicio.php';
        require_once dirname(__FILE__).'\..\Clases\Inspeccion_Inicial.php';
        require_once dirname(__FILE__).'\..\Clases\Raspado.php';
        if (isset($_GET['id'])) {
            $llanta = new Llanta('id', $_GET['id'], null, null);
            $servicio = $llanta->getServicio();
            $inspeccionInicial = new Inspeccion_Inicial('idllanta', $llanta->getId(), null, 'limit 1');
            ?>
            <input type="hidden" id="txtIdLlanta" value="<?= $_GET['id'] ?>">
            <div class="col-sm-12 col-md-12 col-lg-12 text-uppercase text-center mdl-typography--headline">
                <span>RP: </span><span><?= $llanta->getRp(); ?></span>
            </div>
            <?php
            if (validVal($inspeccionInicial->getId()) && $inspeccionInicial->getEstado()==='prf') {
                if ($inspeccionInicial->getChecked()) {
                    $object = new Raspado('idinspeccion', $inspeccionInicial->getId(), null, 'limit 1');
                    if (validVal($object->getFechaInicioProceso())) {
                        if (getDiffTimeInSeconds($object->getFechaInicioProceso(), date('Y-m-d H:i:s'))>=360) {
                            if (validVal($object->getId())) {
                                if (!validVal($object->getIdEmpleado()) && $object->getEstado()==='prs') {
                                    ?>
                                    <!-- PANEL FRM PROCESS -->
                                    <script src="lib/controladores/usoInsumosProceso.js"></script>
                                    <div ng-controller="usoInsumosProceso">
                                            <input type="hidden" id="timeElapsed" value="<?= getDiffTiempo($object->getFechaInicioProceso(), date('Y-m-d H:i:s')) ?>">
                                            <input type="hidden" name="idEmpleado" value="<?= $USUARIO->getIdEmpleadoUsuario(); ?>">
                                            <input type="hidden" name="numeroProceso" value="1">
                                            <input type="hidden" name="idProceso" value="<?= $object->getId(); ?>">
                                            <input type="hidden" name="metodoProceso" value="getSimpleRaspadoJSON">
                                            <!-- TIME ELAPSED -->
                                            <div class="col-sm-12 col-md-12">
                                                <h2 class="mdl-color-text--red-800">{{ retreadProcess.data.timeElapsed }}</h2>
                                            </div>
                                            <!-- END TIME ELAPSED -->
                                            <!-- FORM -->
                                            <div class="col-md-12" id="paddinTop20">
                                                <form class="form-horizontal" name="formulario" method="POST" action="principal.php?CON=system/Pages/raspadoActualizar.php" enctype="multipart/form-data">
                                                    <div class="col-sm-12 col-md-4"></div>
                                                    <div class="col-sm-12 col-md-4">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">* Puesto de trabajo:</span>
                                                                <select class="form-control has-primary input-group-sm" name="idPuestoTrabajo" id="puestoTrabajo" ng-model="retreadProcess.data.form.idPuestoTrabajo" ng-change="cargarPuestoTrabajo(true, null, retreadProcess.data.form.idPuestoTrabajo);" ng-disabled="page.components.spnPuestosTrabajo" ><?= Puesto_Trabajo::getDatosEnOptions("proceso=1", null, null); ?></select>
                                                                <span class="input-group-btn" ng-show="page.components.btnAbrirPuestoTrabajo">
                                                                    <button class="btn btn-success" type="button" id="btnVerInsumos" href="/#verInsumosPT" data-toggle='modal'>Abrir</button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">* Ancho banda:</span>
                                                                <input class="form-control has-primary" id="txtAnchoBanda" name="anchoBanda" type="number" placeholder="Ejemplo: 25(mm)" step="any" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">* Largo banda:</span>
                                                                <input class="form-control has-primary" id="txtLargoBanda" name="largoBanda" type="number" placeholder="Ejemplo: 5(mm)" step="any" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">Retiro de cinturon:</span>
                                                                <span class="input-group-addon">
                                                                    <span id="paddingLeft10"></span>
                                                                    <label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="cinturon">
                                                                        <input type="checkbox" id="cinturon" class="mdl-switch__input" name="cinturon" ng-model="retreadProcess.data.form.chkRetiroCinturon" checked="false">
                                                                    </label>
                                                                </span>
                                                                <span class="input-group-addon">
                                                                    <label ng-show="retreadProcess.data.form.chkRetiroCinturon">Si</label>
                                                                    <label ng-show="!retreadProcess.data.form.chkRetiroCinturon">No</label>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group" id="divSpinner" ng-show="retreadProcess.data.form.chkRetiroCinturon">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">Cantidad:</span>
                                                                <label class="input-group-addon" for="cantidadCinturon">
                                                                    <input class="mdl-slider mdl-js-slider" id="cantidadCinturon" name="cinturonCantidad" type="range" min="1" max="1" value="1" tabindex="0" ng-model="retreadProcess.data.form.cinturonCantidad" readonly>
                                                                </label>
                                                                <span class="input-group-addon"><label id="textoCantidadCinturon">{{ retreadProcess.data.form.cinturonCantidad }}</label></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">* Profundidad:</span>
                                                                <input class="form-control has-primary" id="profundidad" type="number" name="profundidad" placeholder="Ejemplo: 10 (mm)" min="0" step="any" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">* Radio:</span>
                                                                <input class="form-control has-primary" id="radio" type="number" name="radio" placeholder="Ejemplo: 17.5" min="0" step="any" required>
                                                            </div>
                                                        </div>
                                                        <div ng-controller="images">
                                                            <div class="form-group" ng-show="data.statusFoto">
                                                                <div class="row">
                                                                    <div class="col-sm-12 col-md-12">
                                                                        <div class="thumbnail">
                                                                            <img class="card-img-top" id="imgSerial" style="height: 300px;" ng-src="{{ thumbnail.dataURL }}">
                                                                            <div class="caption">
                                                                                <button class="btn btn-warning" id="btnEliminarImgSerial" type="button" ng-click="deleteSpecificImage('#fotoSerial');">Borrar</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">* Foto serial:</span>
                                                                    <input type="file" class="form-control btn btn-default" name="fotoSerial" id="fotoSerial" required accept="image/*" onchange="angular.element(this).scope().loadPhoto(this.files);" ng-click="setIdInput('#' + this.id)">
                                                                </div>
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
                                                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--green-400 mdl-color-text--white" id="btnSeleccionarRechazos" type="button" href="/#seleccionarRechazos" data-toggle="modal" ng-click="loadRechazosOfProceso(<?=$llanta->getId()?>, 1)">Seleccionar rechazos</button>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">Observaciones:</span>
                                                                <textarea class="form-control has-primary input-sm" name="observaciones" placeholder="Observaciones para este proceso" maxlength="500"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="hidden">
                                                            <div class="col-md-12"><input type="hidden" name="id" value="<?= $object->getId(); ?>"></div>
                                                            <div class="col-md-12"><input type="hidden" name="idEmpleado" value="<?= $USUARIO->getIdEmpleadoUsuario(); ?>"></div>
                                                            <div class="col-md-12"><input type="hidden" name="idLlanta" value="<?=$llanta->getId(); ?>"></div>
                                                            <div class="col-md-12"><input type="hidden" name="accion" value="Registrar"></div>
                                                        </div>
                                                        <div class="form-group" id="paddinTop30">
                                                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--red-400 mdl-color-text--white" type="button" ng-click="backPage();">CANCELAR</button>
                                                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--primary" type="reset" onclick="document.getElementById('btnEliminarImg').click();document.getElementById('btnEliminarImgSerial').click();">REINICIAR</button>
                                                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--green-400 mdl-color-text--white" type="submit" ng-disabled="page.components.btnSendForm">ENVIAR</button>
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
                                                            <button type='button' class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--red-400 mdl-color-text--white' id="btnCancelarSolicitud" data-dismiss='modal' ng-click="limpiarVariables();">Cancelar</button>
                                                            <a href="/#solicitudEnviada" data-toggle="modal">
                                                                <button ng-hide="!chequeados" type='button' class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--green-400 mdl-color-text--white {{ objeto.btnAprobar }}' id="btnAprobar" data-dismiss="modal" ng-click="registrarRechazos(<?= $object->getId(); ?> , observaciones, 1, <?= $llanta->getId(); ?>)">Aprobar eliminacion</button>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END RECHAZOS -->
                                            <!--Puesto Trabajo-->
                                            <div class="col-lg-12">
                                                <div class='modal fade' id='verInsumosPT'>
                                                    <div class='modal-dialog modal-lg'>
                                                        <div class='modal-content'>
                                                            <div class='modal-header'>
                                                                <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                                                <h3 class="mdl-color-text--primary">REGISTRAR USOS DE INSUMOS Y/O HERRAMIENTAS</h3>
                                                                <h4 class="text text-muted">{{ page.data.puestoTrabajo.nombre }}</h4>
                                                                <div class="row col-md-12" id="paddinTop20" ng-show="page.components.loadSpinnerDialog">
                                                                    <div class="mdl-spinner mdl-js-spinner is-active"></div>
                                                                </div>
                                                                <div class="row col-md-12" id="paddinTop20" ng-show="page.components.alertDialog.status">
                                                                    <div class="alert alert-{{ page.components.alertDialog.color }}">{{ page.components.alertDialog.mjs }}</div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-header">
                                                                <div role="tabpanel">
                                                                    <ul class="nav nav-tabs" role="tablist">
                                                                        <li class="active" role="presentacion" ng-click="limpiarVariablesNovedad()">
                                                                            <a href="/#lista" aria-control="" data-toggle="tab" role="tab">Herramientas</a>
                                                                        </li>
                                                                        <li role="presentacion" ng-click="limpiarUsarYTerminarInsumo()">
                                                                            <a href="/#enviarNovedad" aria-control="" data-toggle="tab" role="tab">Enviar novedad</a>
                                                                        </li>
                                                                    </ul>
                                                                    <div class="tab-content">
                                                                        <!--LIST INSUMOS-->
                                                                        <div role="tabpanel" class="tab-pane active" id="lista">
                                                                            <div class="col-md-12 col-sm-12">
                                                                                <div class="col-sm-12 col-lg-1" id="paddinTop20">
                                                                                    <button ng-show="page.components.btnRecargarInsumosPuestoTrabajo" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab btn-info" id="btnRecargarListaInsumos" type="button" ng-click="cargarInsumosPuestoTrabajo(page.data.puestoTrabajo.id);">
                                                                                        <i class="fa fa-refresh"></i>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="col-sm-12 col-lg-10">
                                                                                    <strong class="text text-success control-label"><h2>INSUMOS Y/O HERRAMIENTAS</h2></strong>
                                                                                </div>
                                                                                <div class="col-sm-12 col-lg-1" id="paddinTop20">
                                                                                    <button ng-show="page.components.btnUsarVariosInsumos" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab btn-success" id="btnUsarVariosInsumos" type="button" href="/#_UsarVariosInsumos" aria-control="" data-toggle="tab" role="tab">
                                                                                        <i class="fa fa-check"></i>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                            <!--BUSCADOR-->
                                                                            <!--<div class="col-lg-12" style="padding-top: 20px;">
                                                                                <div class="form-group">
                                                                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                                                                        <input class="mdl-textfield__input" id="txtFiltroInsumos" name="txtFiltroInsumos" ng-model="page.components.txtFiltroInsumos" value="">
                                                                                        <span class="mdl-textfield__label" for="txtFiltroInsumos" style="display: inline-flex;">
                                                                                            <span class="material-icons">search</span><span> Buscar insumos o herramientas</span>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>-->
                                                                            <!--END BUSCADOR-->
                                                                            <!--TABLE-->
                                                                            <div class="col-sm-12 col-md-12 col-lg-12" ng-show="page.data.insumos.length>0" id="paddinTop20">
                                                                                <center>
                                                                                    <div class="table-responsive">
                                                                                        <table class="mdl-data-table mdl-js-data-table">
                                                                                            <thead>
                                                                                            <tr>
                                                                                                <td class="mdl-data-table__cell--non-numeric">
                                                                                                    <input class="form-control-sm" type="checkbox" id="_chkAllInsumos" ng-model="page.components.chksInsumos" ng-change="seleccionarAllInsumos()">
                                                                                                </td>
                                                                                                <th class="mdl-data-table__cell--non-numeric" ng-click="orden='foto'">
                                                                                                    <span class="fa fa-camera-retro"></span>
                                                                                                </th>
                                                                                                <th class="mdl-data-table__cell--non-numeric" ng-click="orden='insumo.nombrepuc'">Insumo</th>
                                                                                                <th ng-click="orden='cantidadpuestotrabajo'">Cantidad recibida</th>
                                                                                                <th ng-click="orden='remainingStock'">Cantidad disponible</th>
                                                                                                <th class="mdl-data-table__cell--non-numeric" ng-click="orden='nombreEstado'">Estado</th>
                                                                                                <th class="mdl-data-table__cell--non-numeric">Acciones</th>
                                                                                            </tr>
                                                                                            </thead>
                                                                                            <tbody>
<!--                                                                                            <tr ng-repeat="dato in page.data.insumos | filter: page.components.txtFiltroInsumos | orderBy: orden">-->
                                                                                            <tr ng-repeat="dato in page.data.insumos | orderBy: orden">
                                                                                                <td class="mdl-data-table__cell--non-numeric">
                                                                                                    <input ng-show="!getUsado(dato)" class="form-control-sm" type="checkbox" id="_chkInsumo" ng-checked="dato.chk" ng-model="dato.chk" ng-change="separarIdInsumo(dato.chk, dato.id)">
                                                                                                </td>
                                                                                                <td class="mdl-data-table__cell--non-numeric">
                                                                                                    <div class="thumbnail">
                                                                                                        <img ng-hide="dato.notImage" class="img-responsive" style="width: 50px;" src="system/Uploads/Imgs/Productos/{{ dato.insumo.foto }}">
                                                                                                        <img ng-show="dato.notImage" class="img-responsive" style="width: 50px;" src="design/pics/imagenes/not_image.jpg" data-toggle="tooltip" title="Este producto no cuenta con una imagen">
                                                                                                    </div>
                                                                                                </td>
                                                                                                <td class="mdl-data-table__cell--non-numeric">{{ dato.nombrepuc }}</td>
                                                                                                <td>{{ dato.cantidadpuestotrabajo }}</td>
                                                                                                <td>{{ dato.remainingStock }}</td>
                                                                                                <td class="mdl-data-table__cell--non-numeric">{{ dato.nombreEstado }}</td>
                                                                                                <td class="mdl-data-table__cell--non-numeric">
                                                                                                    <h4>
                                                                                                        <a ng-show="!getUsado(dato)" href="/#usarInsumo_{{ dato.id }}" aria-control="" data-toggle="tab" rol="tab"><span class="text-success fa fa-handshake-o" title="Registrar uso"></span></a>
                                                                                                        <a ng-show="!getUsado(dato)" id="paddingLeft10" ng-click="seleccionarInsumoUsarYTerminar(dato)" href='/#UsarYTerminarInsumo' title='Registrar uso y terminación' aria-control="" data-toggle="tab" role="tab" ><span class="text-warning fa fa-legal"></span></a>
                                                                                                        <a ng-show="dato.btnUsar" id="paddingLeft10" ng-click="seleccionarInsumoUsarYTerminar(dato)" href='/#_TerminarInsumo' title='Terminar insumo' aria-control="" data-toggle="tab" role="tab"><span class="text-danger fa fa-flag-checkered"></span></a>
                                                                                                    </h4>
                                                                                                </td>
                                                                                            </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                </center>
                                                                            </div>
                                                                            <!--END TABLE-->
                                                                        </div>
                                                                        <!--End LIST INSUMOS-->
                                                                        <!--------------------------------------------->
                                                                        <!--Registro de novedad-->
                                                                        <div role="tabpanel" class="tab-pane" id="enviarNovedad">
                                                                            <div class="col-sm-12 col-lg-12" id="paddinTop10">
                                                                                <div class="col-md-12 col-sm-12 table-responsive" >
                                                                                    <strong class="text text-success control-label"><h2>ENVIAR NOVEDAD</h2></strong>
                                                                                </div>
                                                                                <div class="row col-md-12 text-capitalize" id="paddinTop20">
                                                                                    <div class="col-md-1"></div>
                                                                                    <div class="col-md-10">
                                                                                        <form class="form-horizontal" name="formularioNovedad" id="formularioNovedad" ng-submit="registrarNovedad(this.formularioNovedad)">
                                                                                            <div class="col-md-12">
                                                                                                <div class="form-group">
                                                                                                    <div class="input-group">
                                                                                                        <span class="input-group-addon">* Novedad:</span>
                                                                                                        <textarea class="form-control has-primary" name="txtNovedad" id="txtNovedad" ng-model="page.data.novedadPuestoTrabajo.novedad" placeholder="Escribre la novedad que deseas enviar sobre este puesto de trabajo" rows="5"></textarea>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-sm-12 col-lg-12" ng-show="page.data.novedadPuestoTrabajo.novedad==null && formularioNovedad.$submitted">
                                                                                                    <div class="alert alert-danger">Debes rellenar este campo</div>
                                                                                                </div>
                                                                                                <div class="form-group" id="paddinTop30">
                                                                                                    <div id="btnEnviaNovedadPuestoTrabajo" class="col-md-12">
                                                                                                        <input class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--green-500 mdl-color-text--white" id="btnRegistrarNovedad" type="submit" name="accion" value="Enviar" ng-disabled="page.data.novedadPuestoTrabajo.novedad==null || page.data.novedadPuestoTrabajo.novedad==''">
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
                                                                        <div ng-repeat="dato in page.data.insumos" role="tabpanel" class="tab-pane" id="usarInsumo_{{ dato.id }}">
                                                                            <div class="col-sm-12 col-lg-12" id="paddinTop10">
                                                                                <div class="col-md-12 col-sm-12 table-responsive" >
                                                                                    <strong class="text text-success control-label"><h3>USAR INSUMO O HERRAMIENTA</h3></strong>
                                                                                </div>
                                                                                <div class="row col-md-12">
                                                                                    <div class="col-md-12 page-header">
                                                                                        <div class="col-sm-12 col-lg-12 table-responsive">
                                                                                            <div class="thumbnail">
                                                                                                <img ng-hide="dato.notImage" class="img-responsive" style="width: 150px;" src="system/Uploads/Imgs/Productos/{{ dato.foto }}">
                                                                                                <img ng-show="dato.notImage" class="img-responsive" style="width: 150px;" src="design/pics/imagenes/not_image.jpg" data-toggle="tooltip" title="Este producto no cuenta con una imagen">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-sm-12 col-lg-12 text-justify">
                                                                                            <label class="text-nowrap text-uppercase">Insumo o herramienta: </label><span class="text text-muted"> {{ dato.nombrepuc }}</span>
                                                                                        </div>
                                                                                        <div class="col-sm-12 col-lg-6 text-justify">
                                                                                            <label class="text-nowrap text-uppercase">Cantidad asignada: </label><span class="text text-muted"> {{ dato.cantidadpuestotrabajo }}</span>
                                                                                        </div>
                                                                                        <div class="col-sm-12 col-lg-6 text-justify">
                                                                                            <label class="text-nowrap text-uppercase">Cantidad disponible: </label><span class="text text-muted"> {{ dato.remainingStock }}</span>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-sm-12 col-lg-12 text-center" id="paddinTop10">
                                                                                        <label class="text text-nowrap text-uppercase">Esta seguro de registrar este uso?</label>
                                                                                    </div>
                                                                                    <div class="col-sm-12 col-lg-12" id="paddinTop20">
                                                                                        <div class="col-md-12">
                                                                                            <button id="btnRegresarLista" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" type="button" href="/#lista" aria-control="" data-toggle="tab" role="tab">Regresar</button>
                                                                                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--green-500 mdl-color-text--white" id="btnUsarInsumo" type="button" name="accion" ng-click="usarInsumo(dato.id, null, true)" href="/#lista" aria-control="" data-toggle="tab" role="tab">Usar</button>
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
                                                                                    <strong class="text text-success control-label"><h3>USAR Y TERMINAR EL INSUMO O LA HERRAMIENTA</h3></strong>
                                                                                </div>
                                                                                <form name="frmUsarYTerminar" id="frmUsarYTerminar" ng-submit="UsarYTerminarInsumo(true)">
                                                                                    <div class="row col-md-12">
                                                                                        <div class="col-sm-12 col-lg-12 page-header" id="paddinTop-20">
                                                                                            <div class="col-sm-12 col-lg-12 table-responsive">
                                                                                                <div class="thumbnail">
                                                                                                    <img ng-hide="page.data.insumoUsarYTerminar.notImage" class="img-responsive" style="width: 150px;" src="system/Uploads/Imgs/Productos/{{ page.data.insumoUsarYTerminar.foto }}">
                                                                                                    <img ng-show="page.data.insumoUsarYTerminar.notImage" class="img-responsive" style="width: 150px;" src="design/pics/imagenes/not_image.jpg" data-toggle="tooltip" title="Este producto no cuenta con una imagen">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-sm-12 col-lg-6 text-justify">
                                                                                                <label class="text-nowrap text-uppercase">Insumo o herramienta: </label><span class="text text-muted"> {{ page.data.insumoUsarYTerminar.nombrepuc }}</span>
                                                                                            </div>
                                                                                            <div class="col-sm-12 col-lg-12 text-justify">
                                                                                                <label class="text-nowrap text-uppercase">Cantidad: </label><span class="text text-muted"> {{ page.data.insumoUsarYTerminar.cantidadpuestotrabajo }}</span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-sm-12 col-lg-12">
                                                                                            <div class="col-sm-12 col-lg-12">
                                                                                                <div class="form-group" ng-show="page.components.fotoTerminacion">
                                                                                                    <div class="row">
                                                                                                        <div class="col-sm-12 col-md-12">
                                                                                                            <div class="thumbnail">
                                                                                                                <img class="card-img-top" id="imgVerTerminacion" style="height: 300px;" ng-src="{{ page.data.imgs.fotoTerminacionUrl }}">
                                                                                                                <div class="caption">
                                                                                                                    <button class="btn btn-warning" type="button" ng-click="deleteImg()">Borrar</button>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group">
                                                                                                    <div class="input-group">
                                                                                                        <span class="input-group-addon">* Foto:</span>
                                                                                                        <input id="fotoUsarTerminar" type="file" class="form-control btn btn-default" name="fotoUsarTerminar" required accept="image/*" onchange="angular.element(this).scope().photoChanged(this.files)" uploader-model="file">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="alert alert-danger text-center" id="paddinTop10" ng-show="page.data.imgs.fotoTerminacionUrl=='' && frmUsarYTerminar.$submitted && page.data.imgs.fotoTerminacionUrl==null">Debes subir una foto que evidencie la terminación del insumo o la herramienta</div>
                                                                                                <div class="form-group">
                                                                                                    <div class="input-group">
                                                                                                        <span class="input-group-addon">Observaciones:</span>
                                                                                                        <textarea class="form-control" id="txtObservacionesUsaryTerminarInsumo" name="txtUsarYTerminarInsumo" ng-model="page.data.terminacionInsumo.observaciones" placeholder="Escribe algunas observaciones"></textarea>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-sm-12 col-lg-12 text-center" id="paddinTop10">
                                                                                            <label class="text text-nowrap text-uppercase">Esta seguro de usar y terminar este insumo o herramienta?</label>
                                                                                        </div>
                                                                                        <div class="col-sm-12 col-lg-12" id="paddinTop20">
                                                                                            <div class="col-md-12">
                                                                                                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" type="button" href="/#lista" aria-control="" data-toggle="tab" role="tab" ng-click="limpiarUsarYTerminarInsumo()">Regresar</button>
                                                                                                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--green-500 mdl-color-text--white" type="submit" name="accion">Aceptar</button>
<!--                                                                                                <button ng-disabled="page.components.btnUsarTerminarInsumo" class="btn btn-info" type="submit" name="accion">Aceptar</button>-->
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
                                                                                    <strong class="text text-success control-label"><h2>TERMINAR INSUMO O HERRAMIENTA</h2></strong>
                                                                                </div>
                                                                                <form name="frmTerminar" id="frmTerminar" ng-submit="UsarYTerminarInsumo(false)">
                                                                                    <div class="row col-md-12">
                                                                                        <div class="col-sm-12 col-lg-12 page-header" id="paddinTop-20">
                                                                                            <div class="col-sm-12 col-lg-12 table-responsive">
                                                                                                <div class="thumbnail">
                                                                                                    <img ng-hide="page.data.insumoUsarYTerminar.notImage" class="img-responsive" style="width: 150px;" src="system/Uploads/Imgs/Productos/{{ page.data.insumoUsarYTerminar.foto }}">
                                                                                                    <img ng-show="page.data.insumoUsarYTerminar.notImage" class="img-responsive" style="width: 150px;" src="design/pics/imagenes/not_image.jpg" data-toggle="tooltip" title="Este producto no cuenta con una imagen">
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-sm-12 col-lg-12 text-justify">
                                                                                                <label class="text-nowrap text-uppercase">Insumo: </label><span class="text text-muted"> {{ page.data.insumoUsarYTerminar.nombrepuc }}</span>
                                                                                            </div>
                                                                                            <div class="col-sm-12 col-lg-12 text-justify" ng-show="page.data.insumoUsarYTerminar.remainingStock==null">
                                                                                                <label class="text-nowrap text-uppercase">Cantidad a terminar: </label><span class="text text-muted"> {{ page.data.insumoUsarYTerminar.cantidadpuestotrabajo }}</span>
                                                                                            </div>
                                                                                            <div class="col-sm-12 col-lg-12 text-justify" ng-show="page.data.insumoUsarYTerminar.remainingStock!=null">
                                                                                                <label class="text-nowrap text-uppercase">Cantidad a terminar: </label><span class="text text-muted">{{ page.data.insumoUsarYTerminar.cantidadpuestotrabajo }}/{{ page.data.insumoUsarYTerminar.remainingStock }}</span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-sm-12 col-lg-12">
                                                                                            <div class="col-sm-12 col-lg-12">
                                                                                                <div class="form-group" ng-show="page.components.fotoTerminacion">
                                                                                                    <div class="row">
                                                                                                        <div class="col-sm-12 col-md-12">
                                                                                                            <div class="thumbnail">
                                                                                                                <img class="card-img-top" id="imgInsumoTerminacion" style="height: 300px;" ng-src="{{ page.data.imgs.fotoTerminacionUrl }}">
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
                                                                                                        <input class="form-control btn btn-default" id="fotoTerminacion" type="file" name="fotoTerminacion" required accept="image/*" onchange="angular.element(this).scope().photoChanged(this.files)" uploader-model="file">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="alert alert-danger text-center" id="paddinTop10" ng-show="page.data.imgs.fotoTerminacionUrl=='' && frmUsarYTerminar.$submitted && page.data.imgs.fotoTerminacionUrl==null">Debes subir una foto que evidencie la terminación del insumo o la herramienta</div>
                                                                                                <div class="form-group">
                                                                                                    <div class="input-group">
                                                                                                        <span class="input-group-addon">Observaciones:</span>
                                                                                                        <textarea class="form-control" id="txtObservacionesTerminarInsumo" name="txtUsarYTerminarInsumo" ng-model="page.data.terminacionInsumo.observaciones" placeholder = "Escribe algunas observaciones"></textarea>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-sm-12 col-lg-12 text-center" id="paddinTop10">
                                                                                            <label class="text text-nowrap text-uppercase">Esta seguro de dar por terminado este insumo o herramienta?</label>
                                                                                        </div>
                                                                                        <div class="col-sm-12 col-lg-12" id="paddinTop20">
                                                                                            <div class="col-md-12">
                                                                                                <button id="btnRegresarLista_2" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" type="button" href="/#lista" aria-control="" data-toggle="tab" role="tab" ng-click="limpiarUsarYTerminarInsumo()">Regresar</button>
                                                                                                <button ng-disabled="page.components.btnUsarTerminarInsumo" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--green-500 mdl-color-text--white" id="btnUsarYTerminarInsumo" type="submit" name="accion">Aceptar</button>
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
                                                                            <div class="col-sm-12 col-md-12 col-lg-12" id="paddinTop10">
                                                                                <div class="col-md-12">
                                                                                    <strong class="text text-success control-label"><h2>Insumos o herramientas seleccionadas</h2></strong>
                                                                                </div>
                                                                                <div class="row col-md-12">
                                                                                    <div class="panel panel-default">
                                                                                        <div class="panel-body">
                                                                                            <div class="col-sm-12 col-md-12 col-lg-12" id="paddinTop20" align="left">
                                                                                                <p ng-repeat="dato in page.data.insumos" ng-show="dato.chk">
                                                                                                    <span class="text-uppercase">{{ dato.nombrepuc }}: </span><span class="text-muted">{{ dato.cantidadpuestotrabajo }}/{{ dato.remainingStock }}</span>
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-sm-12 col-lg-12 text-center" id="paddinTop10">
                                                                                        <span class="text text-nowrap text-uppercase">Esta seguro de usar estos insumos o herramientas?</span>
                                                                                    </div>
                                                                                    <div class="col-sm-12 col-lg-12" id="paddinTop20">
                                                                                        <div class="col-md-12">
<!--                                                                                            <button id="btnRegresarLista" class="btn btn-default" type="button" href="/#lista" aria-control="" data-toggle="tab" role="tab">Regresar</button>-->
                                                                                            <button id="btnRegresarLista" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" type="button" href="/#lista" aria-control="" data-toggle="tab" role="tab">Regresar</button>
                                                                                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--green-500 mdl-color-text--white" id="btnUsarInsumos" type="button" name="accion" ng-click="usarInsumo('NO', null, false);" href="/#lista" aria-control="" data-toggle="tab" role="tab">Usar</button>
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
                                                                <button type='button' class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--red-400 mdl-color-text--white' id="btnCancelarSolicitud" data-dismiss='modal' >Cerrar</button>
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
                                        </div>
                                    <!-- END PANEL FRM PROCESS -->
                                    <?php
                                } elseif (validVal($object->getIdEmpleado()) && validVal($object->getFoto()) && validVal($object->getAnchoBanda()) && $object->getEstado()==='prf') {
                                    if ($object->getChecked()) {
                                        $colorAlert = 'success';
                                        $mjs = 'llanta aprobada';
                                    } else {
                                        $colorAlert = 'danger';
                                        $mjs = 'llanta rechazada';
                                    }
                                    ?>
                                    <!-- PANEL RESULT PROCESS -->
                                    <script src="lib/controladores/informacionUsosPuestoTrabajo.js"></script>
                                    <div class="col-sm-12 col-md-12 col-lg-12" id="paddinTop20">
                                        <div class="alert alert-<?= $colorAlert ?>">
                                            <h4>EL PROCESO FUE REGISTRADO EXITOSAMENTE</h4>
                                            <span style="font-size: 20px;"><?= $mjs ?></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-12" id="paddinTop20" ng-controller="infoUsosPuestoTrabajo">
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
                                                            <span class="text-uppercase">PUESTO DE TRABAJO: </span><span class="text-muted"><?= $object->getPuestoTrabajo()->getNombre() ?></span>
                                                        </p>
                                                        <p>
                                                            <span class="text-uppercase">ANCHO DE BANDA: </span><span class="text-muted"><?= $object->getAnchoBanda(); ?></span>
                                                        </p>
                                                        <p>
                                                            <span class="text-uppercase">LARGO DE BANDA: </span><span class="text-muted"><?= $object->getLargoBanda(); ?></span>
                                                        </p>
                                                        <p>
                                                            <span class="text-uppercase">RETIRO DE CINTURÓN: </span><span class="text-muted"><?= $object->getNombreCinturon(); ?></span>
                                                        </p>
                                                        <p>
                                                            <span class="text-uppercase">CANTIDAD: </span><span class="text-muted"><?= $object->getCinturonCantidad(); ?></span>
                                                        </p>
                                                        <p>
                                                            <span class="text-uppercase">PROFUNDIDAD: </span><span class="text-muted"><?= $object->getProfundidad(); ?></span>
                                                        </p>
                                                        <p>
                                                            <span class="text-uppercase">RADIO: </span><span class="text-muted"><?= $object->getRadio(); ?></span>
                                                        </p>
                                                        <p>
                                                            <span class="text-uppercase">OBSERVACIONES: </span><span class="text-muted"><?= $object->getObservaciones(); ?></span>
                                                        </p>
                                                        <p>
                                                            <span class="text-uppercase">ESTADO: </span><span class="text-muted"><?= $object->getNombreChecked(); ?></span>
                                                        </p>
                                                        <p>
                                                            <span class="text-uppercase">TIEMPO DE EJECUCIÓN: </span><span class="text-muted"><?= getDiffTiempoString($object->getFechaInicioProceso(), $object->getFechaRegistro()) ?></span>
                                                        </p>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-12" id="paddinTop20" align="center">
                                                        <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--red-400 mdl-color-text--white" type="button" ng-click="backPage();">REGRESAR</button>
                                                        <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--yellow-500 mdl-color-text--black" type="button" ng-click="loadInfoUsosPuestoTrabajo(<?= $object->getId(); ?>, 1)" data-toggle="modal" href="/#_infoUsosPT">INFORMACIÓN PUESTO TRABAJO</button>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-6">
                                                    <div class="col-sm-12 col-md-12 col-lg-12" align="left" style="padding-bottom: 10px;">
                                                        <p>
                                                            <span class="text-uppercase">SERIAL: </span>
                                                        </p>
                                                        <?php
                                                        if (validVal($object->getFotoSerial())) {
                                                            ?>
                                                            <img class="img img-responsive" ng-src="system/Uploads/Imgs/Raspado/<?= $object->getFotoSerial() ?>">
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <p align="left">
                                                                <span class="text-muted">La imagén no esta registrada o fué borrada</span>
                                                            </p>
                                                            <img class="img img-responsive" ng-src="design/pics/imagenes/not_image.jpg">
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="col-sm-12 col-md-12 col-lg-12" align="left">
                                                        <p>
                                                            <span class="text-uppercase">EVIDENCIA FOTOGRÁFICA: </span>
                                                        </p>
                                                        <p align="left">
                                                            <span class="text-muted">Resultado del proceso</span>
                                                        </p>
                                                        <img class="img img-responsive" ng-src="system/Uploads/Imgs/Raspado/<?= $object->getFoto() ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='modal fade' id='_infoUsosPT'>
                                            <div class='modal-dialog modal-lg'>
                                                <div class='modal-content'>
                                                    <div class='modal-header'>
                                                        <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                                        <h3 class="text text-primary">{{ usosInsumos[0].puestoTrabajo }}</h3>
                                                        <div class="mdl-spinner mdl-js-spinner is-active" ng-show="infoUsosPuestoTrabajo.components.loadSpinner"></div>
                                                    </div>
                                                    <div class='modal-header'>
                                                        <div class="col-sm-12 col-lg-12 text-center">
                                                            <div class="col-sm-12 col-lg-12">
                                                                <h4 class="text-uppercase">Insumos o Herramientas usadas ({{ infoUsosPuestoTrabajo.data.objects.length }}):</h4>
                                                            </div>
                                                            <center>
                                                                <div class="col-sm-12 col-lg-12 table-responsive container" id="paddinTop10">
                                                                    <table class="mdl-data-table mdl-js-data-table">
                                                                        <thead>
                                                                        <tr>
                                                                            <th ng-click="orden='insumo'">Insumo</th>
                                                                            <th ng-click="orden='cantidad'">Cantidad</th>
                                                                            <th ng-click="orden='nombreUsado'">Usado</th>
                                                                            <th ng-click="orden='nombreTerminado'">Terminado</th>
                                                                            <th ng-click="orden='empleadoUso'">Empleado (uso)</th>
                                                                            <th ng-click="orden='empleadoEnvio'">Empleado (envio)</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr ng-repeat="objeto in infoUsosPuestoTrabajo.data.objects | orderBy: orden" ng-show="infoUsosPuestoTrabajo.data.objects.length>0">
                                                                            <td class="mdl-data-table__cell--non-numeric">{{ objeto.insumo }}</td>
                                                                            <td>{{ objeto.cantidad }}</td>
                                                                            <td>{{ objeto.nombreUsado }} <span class="text-muted" ng-show="objeto.cantidadUsada!=null">({{ objeto.cantidadUsada }})</span></td>
                                                                            <td>{{ objeto.nombreTerminado }}</td>
                                                                            <td>{{ objeto.empleadoUso }}</td>
                                                                            <td>{{ objeto.empleadoEnvio }}</td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </center>
                                                        </div>
                                                    </div>
                                                    <div class='modal-footer'>
                                                        <button type='button' class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--green-500 mdl-color-text--white' data-dismiss='modal'>Cerrar</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="toast-content-dialogPT" class="mdl-js-snackbar mdl-snackbar">
                                                <div class="mdl-snackbar__text"></div>
                                                <button class="mdl-snackbar__action" type="button"></button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END PANEL RESULT PROCESS -->
                                    <?php
                                } else {
                                    ?>
                                    <!-- ERROR AL REGISTRAR LOS DATOS -->
                                    <input type="hidden" id="txtPastProcess" value="<?= $inspeccionInicial->getId(); ?>">
                                    <div class="row col-sm-12 col-md-12 col-lg-12" id="paddinTop20">
                                        <div class="alert alert-danger">
                                            <h3>OCURRIÓ UN ERROR AL REGISTRAR LOS DATOS, HAZ CLIC EN EL BOTÓN DE ABAJO PARA HACER EL REGISTRO NUEVAMENTE</h3>
                                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--green-500 mdl-color-text--white" ng-click="resetProcces(<?= $object->getId(); ?>);">Reintentar</button>
                                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--orange-500 mdl-color-text--white" ng-click="backPage();">Regresar</button>
                                        </div>
                                    </div>
                                    <!-- END ERROR AL REGISTRAR LOS DATOS -->
                                    <?php
                                }
                            } else header('Location: principal.php?CON=system/pages/unknowData.php');
                        } else {
                            ?>
                            <!-- TIME TO ENABLED FRM PROCESS -->
                            <input type="hidden" id="diffTime" value="<?= getDiffTimeInSeconds($object->getFechaInicioProceso(), date('Y-m-d H:i:s')) ?>">
                            <div class="row col-sm-12 col-md-12 col-lg-12" id="paddinTop20">
                                <div class="alert alert-warning">
                                    <h3>El formulario de registro se habilitara cuando el cronometro llegue a 6 minutos: {{ retreadProcess.data.timeToGo }}/06:00</h3>
                                    <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--orange-500 mdl-color-text--white" ng-click="backPage();">Regresar</button>
                                </div>
                            </div>
                            <!-- END TIME TO ENABLED FRM PROCESS -->
                            <?php
                        }
                    } else {
                        if ($object->getEstado()==='prf' && validVal($object->getIdPuestoTrabajo())) {
                            if ($object->getChecked()) {
                                $colorAlert = 'success';
                                $mjs = 'llanta aprobada';
                            } else {
                                $colorAlert = 'danger';
                                $mjs = 'llanta rechazada';
                            }
                            ?>
                            <!-- PANEL RESULT PROCESS REGISTRO QUE FUE REALIZADO ANTES DE IMPLEMENTAR LA MEDIDA DE TIEMPO-->
                            <script src="lib/controladores/informacionUsosPuestoTrabajo.js"></script>
                            <div class="col-sm-12 col-md-12 col-lg-12" id="paddinTop20">
                                <div class="alert alert-<?= $colorAlert ?>">
                                    <h4>EL PROCESO FUE REGISTRADO EXITOSAMENTE</h4>
                                    <span style="font-size: 20px;"><?= $mjs ?></span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12" id="paddinTop20" ng-controller="infoUsosPuestoTrabajo">
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
                                                    <span class="text-uppercase">PUESTO DE TRABAJO: </span><span class="text-muted"><?= $object->getPuestoTrabajo()->getNombre() ?></span>
                                                </p>
                                                <p>
                                                    <span class="text-uppercase">ANCHO DE BANDA: </span><span class="text-muted"><?= $object->getAnchoBanda(); ?></span>
                                                </p>
                                                <p>
                                                    <span class="text-uppercase">LARGO DE BANDA: </span><span class="text-muted"><?= $object->getLargoBanda(); ?></span>
                                                </p>
                                                <p>
                                                    <span class="text-uppercase">RETIRO DE CINTURÓN: </span><span class="text-muted"><?= $object->getNombreCinturon(); ?></span>
                                                </p>
                                                <p>
                                                    <span class="text-uppercase">CANTIDAD: </span><span class="text-muted"><?= $object->getCinturonCantidad(); ?></span>
                                                </p>
                                                <p>
                                                    <span class="text-uppercase">PROFUNDIDAD: </span><span class="text-muted"><?= $object->getProfundidad(); ?></span>
                                                </p>
                                                <p>
                                                    <span class="text-uppercase">RADIO: </span><span class="text-muted"><?= $object->getRadio(); ?></span>
                                                </p>
                                                <p>
                                                    <span class="text-uppercase">OBSERVACIONES: </span><span class="text-muted"><?= $object->getObservaciones(); ?></span>
                                                </p>
                                                <p>
                                                    <span class="text-uppercase">ESTADO: </span><span class="text-muted"><?= $object->getNombreChecked(); ?></span>
                                                </p>
                                                <p>
                                                    <span class="text-uppercase">TIEMPO DE EJECUCIÓN: </span><span class="text-muted"><?= getDiffTiempoString($object->getFechaInicioProceso(), $object->getFechaRegistro()) ?></span>
                                                </p>
                                            </div>
                                            <div class="col-sm-12 col-md-12 col-lg-12" id="paddinTop20" align="center">
                                                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--red-400 mdl-color-text--white" type="button" ng-click="backPage();">REGRESAR</button>
                                                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--yellow-500 mdl-color-text--black" type="button" ng-click="loadInfoUsosPuestoTrabajo(<?= $object->getId(); ?>, 1)" data-toggle="modal" href="/#_infoUsosPT">INFORMACIÓN PUESTO TRABAJO</button>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                            <div class="col-sm-12 col-md-12 col-lg-12" align="left">
                                                <p>
                                                    <span class="text-uppercase">EVIDENCIA FOTOGRÁFICA: </span><span class="text-muted">
                                                </p>
                                            </div>
                                            <img class="img img-responsive" ng-src="system/Uploads/Imgs/Raspado/<?= $object->getFoto() ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class='modal fade' id='_infoUsosPT'>
                                    <div class='modal-dialog modal-lg'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                                <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                                <h3 class="text text-primary">{{ usosInsumos[0].puestoTrabajo }}</h3>
                                                <div class="mdl-spinner mdl-js-spinner is-active" ng-show="infoUsosPuestoTrabajo.components.loadSpinner"></div>
                                            </div>
                                            <div class='modal-header'>
                                                <div class="col-sm-12 col-lg-12 text-center">
                                                    <div class="col-sm-12 col-lg-12">
                                                        <h4 class="text-uppercase">Insumos o Herramientas usadas ({{ infoUsosPuestoTrabajo.data.objects.length }}):</h4>
                                                    </div>
                                                    <center>
                                                        <div class="col-sm-12 col-lg-12 table-responsive container" id="paddinTop10">
                                                            <table class="mdl-data-table mdl-js-data-table">
                                                                <thead>
                                                                <tr>
                                                                    <th ng-click="orden='insumo'">Insumo</th>
                                                                    <th ng-click="orden='cantidad'">Cantidad</th>
                                                                    <th ng-click="orden='nombreUsado'">Usado</th>
                                                                    <th ng-click="orden='nombreTerminado'">Terminado</th>
                                                                    <th ng-click="orden='empleadoUso'">Empleado (uso)</th>
                                                                    <th ng-click="orden='empleadoEnvio'">Empleado (envio)</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr ng-repeat="objeto in infoUsosPuestoTrabajo.data.objects | orderBy: orden" ng-show="infoUsosPuestoTrabajo.data.objects.length>0">
                                                                    <td class="mdl-data-table__cell--non-numeric">{{ objeto.insumo }}</td>
                                                                    <td>{{ objeto.cantidad }}</td>
                                                                    <td>{{ objeto.nombreUsado }} <span class="text-muted" ng-show="objeto.cantidadUsada!=null">({{ objeto.cantidadUsada }})</span></td>
                                                                    <td>{{ objeto.nombreTerminado }}</td>
                                                                    <td>{{ objeto.empleadoUso }}</td>
                                                                    <td>{{ objeto.empleadoEnvio }}</td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </center>
                                                </div>
                                            </div>
                                            <div class='modal-footer'>
                                                <button type='button' class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--green-500 mdl-color-text--white' data-dismiss='modal'>Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="toast-content-dialogPT" class="mdl-js-snackbar mdl-snackbar">
                                        <div class="mdl-snackbar__text"></div>
                                        <button class="mdl-snackbar__action" type="button"></button>
                                    </div>
                                </div>
                            </div>
                            <!-- END PANEL RESULT PROCESS -->
                            <?php
                        } else {
                            ?>
                            <!-- ENABLED FRM PROCESS -->
                            <div class="col-sm-12 col-md-12 col-lg-12" id="paddinTop20">
                                <input type="hidden" id="txtPastProcess" value="<?= $inspeccionInicial->getId(); ?>">
                                <div class="alert alert-info">
                                    <h4>Para habilitar el formulario de registro clique sobre el botón de abajo. Debe tener en cuenta que una vez presionado el botón, el formulario de registro se habilitara después de 8 minutos.</h4>
                                    <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--primary" ng-click="initProcess();">Iniciar proceso</button>
                                    <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--orange-500 mdl-color-text--white" ng-click="backPage();">Regresar</button>
                                </div>
                            </div>
                            <!-- END ENABLED FRM PROCESS -->
                            <?php
                        }
                    }

                } else {
                    ?>
                    <!-- LLANTA RECHAZADA EN  EL PROCESO ANTERIOR -->
                    <div class="col-sm-12 col-md-12 col-lg-12" id="paddinTop20">
                        <div class="alert alert-danger">
                            <h4>La llanta fue rechazada en el proceso anterior, el reencauche ha terminado.</h4>
                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--primary" ng-click="toProcess();">Ir al proceso anterior</button>
                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--orange-500 mdl-color-text--white" ng-click="backPage();">Regresar</button>
                        </div>
                    </div>
                    <!-- END LLANTA RECHAZADA EN  EL PROCESO ANTERIOR -->
                    <?php
                }
            } else {
                ?>
                <!-- PAST PROCESS PENDING -->
                <div class="col-sm-12 col-md-12 col-lg-12" id="paddinTop20">
                    <div class="alert alert-warning">
                        <h4>Para habilitar el formulario de registro, primero debe registrar el proceso de inspección inicial</h4>
                        <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--primary" ng-click="toProcess();">Ir al proceso</button>
                        <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--orange-500 mdl-color-text--white" ng-click="backPage();">Regresar</button>
                    </div>
                </div>
                <!-- END PAST PROCESS PENDING -->
                <?php
            }
        } else header('Location: principal.php?CON=system/pages/unknowData.php');
        ?>
        <!-- DLG DETAILLS-->
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
        <!-- END DLG DETAILLS-->
    </div>
</div>
<div id="toast-content" class="mdl-js-snackbar mdl-snackbar">
    <div class="mdl-snackbar__text"></div>
    <button class="mdl-snackbar__action" type="button"></button>
</div>