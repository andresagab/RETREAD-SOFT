<script src="lib/controladores/cambiarClave.js"></script>
<div class="col-sm-12 col-md-12 col-lg-12" ng-controller="cambiarClave">
    <div class='modal fade' id='_frmCambiarClave'>
        <div class='modal-dialog modal-lg'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' id="btnCerrarDialogFrmCambiarClave" data-dismiss='modal' data-dismiss='modal' ng-click="cleanDataCambiarClave()">&times;</button>
                    <h3 class="text text-primary">CAMBIAR CONTRASE&Ntilde;A</h3>
                </div>
                <form id="frmCambiarClave" name="frmCambiarClave" ng-submit="cambiarClave();">
                    <div class="modal-footer">
                        <div class="col-sm-12 col-lg-12 text-center" ng-show="html.barraCarga" id="paddinBottom10">
                            <div class="hidden" id="hideBtnCargarUsuarioCambiarClave" ng-click="cargarUsuario(<?= $USUARIO->getId() ?>)"></div>
                            <div class="col-sm-1 col-lg-2"></div>
                            <div class="col-sm-10 col-lg-8">
                                <div class="mdl-progress mdl-js-progress mdl-progress__indeterminate"></div>
                            </div>
                            <div class="col-sm-1 col-lg-2"></div>
                        </div>
                        <div class="col-sm-12 col-lg-12" ng-show="html.alertaDialog">
                            <div class="alert alert-{{ html.colorAlertaDialog }} text-center">{{ html.mjsAlertaDialog }}</div>
                        </div>
                        <!--Diseño original-->
                        <div class="col-sm-12 col-lg-12">
                            <div class="form-group">
                                <div class="input-group {{ html.hasClaveActual }}">
                                    <span class="input-group-addon">Contrase&ntilde;a actual:</span>
                                    <input class="form-control has-primary" id="txtClaveActual" name="txtClaveActual" type="password" max="35" required="" ng-model="data.claveActual" ng-change="validarClaveActual(data.claveActual)">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-12">
                            <div class="form-group">
                                <div class="input-group {{ html.hasClaveNueva }}">
                                    <span class="input-group-addon">Contrase&ntilde;a nueva:</span>
                                    <input class="form-control has-primary" id="txtClaveNueva" name="txtClaveNueva" type="password" max="35" required="" ng-model="data.claveNueva" ng-change="validarClaveNueva(data.claveNueva)" ng-disabled="html.inputClaveNueva">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-12">
                            <div class="form-group">
                                <div class="input-group {{ html.hasClaveNuevaConfirmar }}">
                                    <span class="input-group-addon">Repite tu contrase&ntilde;a nueva:</span>
                                    <input class="form-control has-primary" id="txtClaveNuevaConfirmar" name="txtClaveNuevaConfirmar" type="password" max="35" required="" ng-model="data.claveNuevaConfirmar" ng-change="validarClaveConfirmar(data.claveNuevaConfirmar)" ng-disabled="html.inputClaveNuevaConfirmar">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' id="btnCancelarFrmCambiarClave" class='btn btn-danger' data-dismiss='modal' ng-click="cleanDataCambiarClave()">Cancelar</button>
                        <button type='submit' class='btn btn-success' ng-disabled="html.btnFrmCambiarClave">Aceptar</button>
                    </div>
                </form>
            </div>
        </div>
        <!--TOOLTIPS-->
        <div class="mdl-tooltip" data-mdl-for="btnCerrarDialogFrmCambiarClave">Cerrar</div>
        <!--FIN TOOLTIPS-->
        <!--------------------------------------------------------------------->
        <!--TOAST-->
        <div id="toast-dialog-cc" class="mdl-js-snackbar mdl-snackbar">
            <div class="mdl-snackbar__text"></div>
            <button class="mdl-snackbar__action" type="button"></button>
        </div>
        <!--FIN TOAST-->
    </div>
</div>