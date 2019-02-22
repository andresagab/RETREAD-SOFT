<script src="lib/controladores/novedadPuestoTrabajo.js"></script>
<div class="col-md-12" ng-controller="novedadPuestoTrabajo">
    <div>
        <div class="col-lg-12 hidden" id="cargarLista" ng-click="cargarDatos(<?=$_GET['idPT']?>);cargarPuestoTrabajo(<?=$_GET['idPT']?>)"></div>
            <div class="col-md-1" ></div>
            <div class="col-md-9" >
                <strong class="text text-uppercase mdl-color-text--blue"><h2>Novedades del puesto de trabajo {{ puestoTrabajo.nombre }}</h2></strong>
            </div>
            <div class="col-md-1" ></div>
            <div class="row col-md-12" id="paddinTop20" ng-show="html.spinnerCarga">
                <div class="mdl-spinner mdl-js-spinner is-active"></div>
            </div>
            <div class="row col-md-12" id="paddinTop30"></div>
            <div class="row col-md-12">
                <div class="col-md-1">
                    <!--<div class="form-group-sm">-->
                        <!--<a href="#/adicionarCargo" data-toggle="modal"><button class="btn btn-primary">Adicionar</button></a>-->
                        <!--<button class="btn btn-primary" type="button" id="btnAdicionar">Adicionar</button>-->
                    <!--</div>-->
                </div>
                <div class="col-md-2">
                    <div class="form-group-sm">
                        <!--<a href="#/adicionarCargo" data-toggle="modal"><button class="btn btn-primary">Adicionar</button></a>-->
                        <button class="btn btn-default" type="button" id="btnRegresar">Regresar</button>
                    </div>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-4">
                    <div class="col-md-12 form-group-sm">
                        <input class="col-md-12 form-control" id="buscar" name="buscar" placeholder="Buscar por cualquier campo de la tabla" ng-model="buscar">
                    </div>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-2">
                    <button class="btn btn-success" type="button" id="cargarLista" ng-click="cargarDatos(<?=$_GET['idPT']?>)">Actualizar lista</button>
                </div>
                <div class="col-md-1"></div>
            </div>
            <div class="row col-md-12" id="paddinTop20" ng-show="objetos">
                <div class="col-md-0"></div>
                <div class="col-md-12">
                    <center>
                        <div class="table-responsive">
                            <table class="mdl-data-table mdl-js-data-table">
                                <thead>
                                    <tr class="active">
                                        <th ng-click="orden='empleado[0].nombresCompletosPersona'">Empleado</th>
                                        <th ng-click="orden='novedad'">Novedad</th>
                                        <th ng-click="orden='nameStatus'">Estado</th>
                                        <th ng-click="orden='fechaRegistro'">Fecha envio</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="objeto in objetos | filter: buscar | orderBy: orden" style="background: {{ objeto.colorFila }}">
                                        <td>{{ objeto.empleado[0].nombresCompletosPersona }}</td>
                                        <td>{{ objeto.minNovedad }}<span ng-show="objeto.minNovedad.length==50">...</span></td>
                                        <td style="background: {{ objeto.colorStatus }}">{{ objeto.nameStatus }}</td>
                                        <td>{{ objeto.fechaRegistro }}</td>
                                        <td>
                                            <h4>
                                                <!--<a href='/#eliminar{{ objeto.id }}' title='Eliminar registro' data-toggle='modal'>
                                                    <span class="text-danger material-icons">delete</span>
                                                </a>-->
                                                <a href="/#detailsNovedad" title="Detalles" data-toggle="modal" ng-click="setObject(objeto);">
                                                    <span class="text-primary material-icons">info</span>
                                                </a>
                                            </h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div ng-repeat="objeto in objetos | filter: buscar">
                            <div class='modal fade' id='eliminar{{ objeto.id }}'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                            ¿Est&aacute; seguro que desea eliminar este registro?
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-danger' data-dismiss='modal' >Cancelar</button>
                                            <a href='principal.php?CON=system/Pages/novedadesPuestoTrabajoActualizar.php&id={{ objeto.id }}&idPT={{ puestoTrabajo.id }}&accion=Eliminar'><button type='button' class='btn btn-success' >Aceptar</button></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </center>
                </div>
                <div class="col-md-0"></div>
            </div>
    </div>
    <div class="modal fade" id="detailsNovedad">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
                    <h3 class="text-uppercase mdl-color-text--blue">
                        <span>Detalles</span>
                    </h3>
                </div>
                <div class="modal-header">
                    <div class="text-justify">
                        <!--<h4>-->
                        <center style="padding-bottom: 15px;">
                            <div style="background: {{ html.data.object.colorStatus }}; width: 30px; height: 30px; border-radius: 15px;"></div>
                        </center>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <label class="mdl-typography--font-bold">Estado:</label><span class="text-muted"> {{ html.data.object.nameStatus }}</span>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <label class="mdl-typography--font-bold">Empleado:</label><span class="text-muted"> {{ html.data.object.empleado[0].nombresCompletosPersona }}</span>
                        </div>
                        <br>
                        <div class="col-sm-12 col-md-12 col-lg-12" layout-padding>
                            <label class="mdl-typography--font-bold">Novedad:</label><span class="text-muted"> {{ html.data.object.novedad }}</span>
                        </div>
                        <br>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <label class="mdl-typography--font-bold">Fecha envio:</label><span class="text-muted"> {{ html.data.object.fechaRegistro }}</span>
                        </div>
                        <!--</h4>-->
                    </div>
                </div>
                <div class="modal-header">
                    <div class="col-md-12 layout-align-center">
                        <button ng-show="!html.data.object.status" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-js-ripple-effect btn-success" type="button" id="btnCheckNovedad" ng-click="actionObject('R')" data-dismiss="modal">
                            <span class="material-icons">check</span>
                        </button>
                        <button class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-js-ripple-effect btn-danger" type="button" id="btnEliminarRegistro" ng-click="actionObject('D');" data-dismiss="modal">
                            <span class="material-icons">delete</span>
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-info" type="button" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
        <div class="mdl-tooltip" for="btnCheckNovedad">
            <span>Marcar como revisada</span>
        </div>
        <div class="mdl-tooltip" for="btnEliminarRegistro">
            <span>Eliminar novedad</span>
        </div>
        <div id="toast-dialog" class="mdl-js-snackbar mdl-snackbar">
            <div class="mdl-snackbar__text"></div>
            <button class="mdl-snackbar__action" type="button"></button>
        </div>
    </div>
</div>
<div id="toast-content" class="mdl-js-snackbar mdl-snackbar">
  <div class="mdl-snackbar__text"></div>
  <button class="mdl-snackbar__action" type="button"></button>
</div>
<script>
    $(document).ready(function(){
        $("#cargarLista").click();
    });
    
    $("#btnRegresar").click(function (){
        window.location="principal.php?CON=system/Pages/puestosTrabajo.php";
    });
</script>