<script src="lib/controladores/InsumoPuestoTrabajo.js"></script>
<script src="lib/controladores/InsumoTerminacion.js"></script>
<div class="col-md-12" ng-controller="insumoPuestoTrabajo">
    <div>
        <div class="col-lg-12 hidden" id="cargarData" ng-click="cargarDatos(<?=$_GET['idPT']?>);cargarPuestoTrabajo(<?=$_GET['idPT']?>);setEmpleado(<?= $USUARIO->getIdEmpleadoUsuario() ?>);"></div>
            <div class="col-md-12" id="paddinTop30"></div>
            <div class="col-md-1" ></div>
            <div class="col-md-9" >
                <strong class="text text-success control-label"><h2>Insumos del puesto de trabajo {{ puestoTrabajo.nombre }}</h2></strong>
            </div>
            <div class="col-md-1" ></div>
            <div class="row col-md-12" id="paddinTop20" ng-hide="objetos">
                <!--<span class="text-info"><i class="fa fa-refresh fa-spin fa-5x primary"></i></span>-->
                <div class="mdl-spinner mdl-js-spinner is-active"></div>
            </div>
            <div class="row col-md-12" id="paddinTop30"></div>
            <div class="row col-md-12">
                <div class="col-md-2">
                    <div class="form-group-sm">
                        <!--<a href="#/adicionarCargo" data-toggle="modal"><button class="btn btn-primary">Adicionar</button></a>-->
                        <button class="btn btn-primary" type="button" id="btnAdicionar">Adicionar</button>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group-sm">
                        <!--<a href="#/adicionarCargo" data-toggle="modal"><button class="btn btn-primary">Adicionar</button></a>-->
                        <button class="btn btn-default" type="button" id="btnRegresar">Regresar</button>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="col-md-12 form-group-sm">
                        <input class="col-md-12 form-control" id="buscar" name="buscar" placeholder="Buscar por: Nombre, Cantidad, Estado o usuario" ng-model="buscar">
                    </div>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-2">
                    <button class="btn btn-success" type="button" id="syncNow" ng-click="cargarDatos(<?=$_GET['idPT']?>)">Actualizar lista</button>
                </div>
                <div class="col-md-1"></div>
            </div>
            <div class="row col-md-12" id="paddinTop20" ng-show="objetos">
                <center>
                    <div class="col-md-0"></div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="mdl-data-table mdl-js-data-table">
                                <thead>
                                    <tr class="active">
                                        <th class="hide" ng-click="orden='foto'">
                                            <span class="fa fa-camera-retro"></span>
                                        </th>
                                        <th ng-click="orden='nombrepuc'">Insumo</th>
                                        <th ng-click="orden='cantidad'">Cantidad asignada</th>
                                        <th ng-click="orden='remainingStock'">Cantidad disponible</th>
                                        <th ng-click="orden='nombreEstado'">Estado</th>
                                        <th ng-click="orden='usuario'">Usuario</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="objeto in objetos | filter: buscar | orderBy: orden" style="background: {{ objeto.colorFila }}">
                                        <td class="hide">
                                            <div class="thumbnail">
                                                <img ng-hide="objeto.notImage" class="img-responsive" style="width: 50px;" src="system/Uploads/Imgs/Productos/{{ objeto.insumo[0]['foto'] }}">
                                                <img ng-show="objeto.foto" class="img-responsive" style="width: 50px;" src="design/pics/imagenes/not_image.jpg" data-toggle="tooltip" title="Este producto no cuenta con una imagen">
                                            </div>
                                        </td>
                                        <td>{{ objeto.nombreproducto }}</td>
                                        <td>{{ objeto.cantidadinsumopt }}</td>
                                        <td>{{ objeto.remainingStock }}</td>
                                        <td>{{ objeto.nombreEstado }}</td>
                                        <td>{{ objeto.nombresempleado }} <span class="text-muted">({{ objeto.identificacionempleado }})</span></td>
                                        <td>
                                            <h4>
                                                <a ng-show="objeto.btnActions" class="{{ objeto.btnModalTerminar }}" href="principal.php?CON=system/Pages/insumosPuestoTrabajoFormulario.php&id={{ objeto.idinsumopt }}&idPT={{ puestoTrabajo.id }}" title="Modificar registro">
                                                    <span class="material-icons">edit</span>
                                                </a>
                                                <a ng-show="objeto.btnActions" class="{{ objeto.btnModalTerminar }}" id="paddingLeft10" href="/#eliminar{{ objeto.idinsumopt }}" title='Eliminar registro' data-toggle='modal'>
                                                    <span class="text-danger material-icons">delete</span>
                                                </a>
                                                <a ng-show="!objeto.terminado" href="/#frmCargarProducto" title="Recargar producto" data-toggle="modal" style="padding-left: 10px;" ng-click="setProductoCarga(objeto);">
                                                    <span class="material-icons mdl-color-text--green">publish</span>
                                                </a>
                                                <!--<a class="hide {{ objeto.btnModalTerminar }}" id="paddingLeft10" href='/#terminar{{ objeto.id }}' title='Terminar insumo' data-toggle='modal'><span class="text-success material-icons">get_app</span></a>-->
                                            </h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div ng-repeat="objeto in objetos | filter: buscar">
                            <div class='modal fade' id="eliminar{{ objeto.idinsumopt }}">
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                            ¿Est&aacute; seguro que desea eliminar el insumo <b>{{ objeto.nombreproducto }}</b>?
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-danger' data-dismiss='modal' >Cancelar</button>
                                            <a href='principal.php?CON=system/Pages/insumosPuestoTrabajoActualizar.php&id={{ objeto.idinsumopt }}&idPT={{ puestoTrabajo.id }}&accion=Eliminar'><button type='button' class='btn btn-success' >Aceptar</button></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Formularion modal para terminacion de insumo-->
                        <div ng-repeat="objeto in objetos | filter: buscar">
                            <div class='modal fade' id='terminar{{ objeto.id }}'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <button ng-click="cargarDatos(<?=$_GET['idPT']?>);" type='button' class='close' data-dismiss='modal'>&times;</button>
                                            <h3 class="text text-primary">TERMINAR INSUMO</h3>
                                        </div>
                                        <div class="modal-header">
                                            <div class="col-lg-12">
                                                <div class="col-lg-6 col-sm-12">
                                                    <label>Insumo: </label><span class="text text-capitalize"> {{ objeto.insumo[0]['nombrePuc'] }} </span>
                                                </div>
                                                <div class="col-lg-6 col-sm-12">
                                                    <label>Estado: </label><span class="text text-capitalize"> {{ objeto.nombreEstado }} </span>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group" id="paddinTop20">
                                                    <div class="input-group">
                                                        <label class="input-group-addon">Observaciones:</label>
                                                        <textarea class="form-control" id="txtObservaciones" name="observaciones" placeholder="Escribe alguna observacion que identifique el porque de la terminacion" maxlength="500" required="" ng-model="observaciones"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group hidden">
                                                    <input type="text" name="idInsumoPT" value="{{ objeto.id }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="alert alert-warning">¡Recuerda que una vez registrada la terminacion para este insumo no podras: Editar y/o Borrar este registro o incluso Enviar otra terminacion para este insumo!</div>
                                            </div>
                                        </div>
                                        <div class='modal-footer' ng-controller="insumoTerminacion">
                                            <button ng-click="cargarDatos(<?=$_GET['idPT']?>);" type='button' class='btn btn-danger' id="btnCancelarSolicitud" data-dismiss='modal' >Cancelar</button>
                                            <a href="/#TerminacionEnviada" data-toggle="modal">
                                                <button type='button' class='btn btn-success {{ objeto.btnEnviarTerminar }}' id="btnAprobar" data-dismiss="modal"
                                                        ng-click="terminar(<?=$USUARIO->getIdEmpleadoUsuario()?>, observaciones, objeto);cargarDatos(<?= $_GET['idPT'] ?>);"
                                                        >Terminar</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Fin Formularion modal para terminacion de insumo-->
                    </div>
                    <div class="col-md-0"></div>
                </center>
            </div>
    </div>
    <!--2018-10-05 00:29-->
    <div class="modal fade" id="frmCargarProducto">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" ng-click="resetFormCarga(true)">&times;</button>
                    <h3 class="mdl-color-text--blue">RECARGAR PRODUCTO</h3>
                    <div class="col-sm-12 col-lg-12 text-center" ng-show="dataForm.barLoad" style="padding-bottom: 10px;">
                        <div class="col-sm-1 col-lg-2"></div>
                        <div class="col-sm-10 col-lg-8">
                            <div class="mdl-spinner mdl-js-spinner is-active"></div>
                        </div>
                        <div class="col-sm-1 col-lg-2"></div>
                    </div>
                </div>
                <form name="formCargar" ng-submit="addCarga();">
                    <div class="modal-header">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="col-sm-6 col-md-6 col-lg-12">
                                    <h4>
                                        <span>Producto: </span><span class="text-muted">{{ dataForm.producto.nombreproducto }}</span>
                                    </h4>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-12">
                                    <h4>
                                        <span>Cantidad en bodega: </span><span class="text-muted">{{ dataForm.producto.stock }}</span>
                                    </h4>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-12">
                                    <h4>
                                        <span>Cantidad en puesto de trabajo: </span><span class="text-muted">{{ dataForm.producto.cantidadinsumopt }}</span>
                                    </h4>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-12">
                                    <h4>
                                        <span>Cantidad restante: </span><span class="text-muted">{{ dataForm.producto.remainingStock }}</span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Cantidad: </span>
                                    <input class="form-control has-success" type="number" step="any" min="0" ng-model="dataForm.cantidad" ng-change="validCantidad();">
                                </div>
                            </div>
                            <div class="alert alert-danger text-center" style="padding-top: 10px;" ng-show="dataForm.cantidad<=0 && formCargar.$submitted">La cantidad a recargar debe ser mayor que cero</div>
                            <div class="alert alert-danger text-center" style="padding-top: 10px;" ng-show="dataForm.producto.stock < dataForm.cantidad">La cantidad a recargar debe ser menor o igual a la disponible en bodega</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnCloseFormCarga" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored mdl-color--red" data-dismiss="modal" ng-click="resetFormCarga(true);">Cancelar</button>
                        <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" ng-click="resetFormCarga(false);" style="padding-left: 5px; padding-right: 5px;">Limpiar</button>
                        <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored mdl-color--green" ng-disabled="dataForm.cantidad<=0 || dataForm.cantidad>=dataForm.producto.stock">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
        <div id="toast-frm-dialog" class="mdl-js-snackbar mdl-snackbar">
            <div class="mdl-snackbar__text"></div>
            <button class="mdl-snackbar__action" type="button"></button>
        </div>
    </div>
    <!--END 2018-10-05 00:29-->
</div>
<div class='modal fade' id='TerminacionEnviada'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header'>
                <button type='button' class='close' data-dismiss='modal'>&times;</button>
                <h3 class="text text-primary">INSUMO TERMINADO CORRECTAMENTE</h3>
                <span class="fa fa-save"></span>
            </div>
            <div class='modal-footer' ng-controller="insumoTerminacion">
                <button type='button' class='btn btn-info' id="btnCerrarEnviado" data-dismiss='modal' >Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $("#cargarData").click();
    });
    
    $("#btnAdicionar").click(function (){
        window.location="principal.php?CON=system/Pages/insumosPuestoTrabajoFormulario.php&idPT=<?=$_GET['idPT']?>";
    });
    
    $("#btnRegresar").click(function (){
        window.location="principal.php?CON=system/Pages/puestosTrabajo.php";
    });
</script>