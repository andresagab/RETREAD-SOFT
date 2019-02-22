<?php
if (strtolower($USUARIO->getRol()->getNombre())=='operario') {
    $botones='hide';//Hace referencia al boton de eliminacion directa
    $btnEliminacionSolicitada='';
}
else {
    $botones='';
    $btnEliminacionSolicitada='hide';
}
?>
<script src="lib/controladores/llantas.js"></script>
<div class="col-md-12" ng-controller="llantas">
	<div class="col-md-12" id="paddinTop30"></div>
        <div class="col-md-12 hidden" id="btnCargarDatos" ng-click="cargarDatos();"></div>
	<div class="col-md-4" ></div>
	<div class="col-md-4" >
            <strong class="text text-success control-label"><h2>Llantas</h2></strong>
	</div>
	<div class="col-md-4" ></div>
        <div class="row col-md-12" id="paddinTop20" ng-hide="objetos">
            <div class="mdl-spinner mdl-js-spinner is-active"></div>
        </div>
        <div class="row col-md-12" id="paddinTop20"></div>
        <div class="row col-md-12" ng-show="objetos">
            <div class="col-md-1"></div>
            <div class="col-md-2">
                <div class="form-group-sm <?=$botones?>">
                    <a href="principal.php?CON=system/Pages/llantasFormulario.php"><button class="btn btn-primary" type="button" id="btnAdicionar">Adicionar</button></a>
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-4">
                <div class="col-md-12 form-group-sm">
                    <input class="col-md-12 form-control" id="buscar" name="buscar" placeholder="Buscar por: Tipo, Marca, Proveedor, Serie, Rp, Dimension, FechaCreacion o Estado" ng-model="buscar">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group-sm">
                    <button class="btn btn-success" name="btnCargarDatos" type="button" ng-click="cargarDatos();">Actualizar lista</button>
                </div>
            </div>
        </div>
        <div class="row col-md-12" id="paddinTop20" ng-show="objetos">
            <div class="col-md-0"></div>
            <div class="col-md-0">
                <div class="table-responsive">
                    <table class="table table-hover table-responsive table-striped">
                    <!--<table class="mdl-data-table mdl-js-data-table">-->
                        <tr class="active">
                            <th ng-click="ordenar='rp'">RP</th>
                            <th ng-click="ordenar='nombreTipo'">Tipo</th>
                            <th ng-click="ordenar='nombreMarca'">Marca</th>
                            <th ng-click="ordenar='datoCliente'">Cliente</th>
                            <th ng-click="ordenar='serie'">Serie</th>
                            <th ng-click="ordenar='medidaCompleta'">Dimension</th>
                            <th ng-click="ordenar='nombreAplicacionOriginal'">Aplicacion original</th>
                            <th ng-click="ordenar='nombreAplicacionRencauche'">Aplicacion rencauche</th>
                            <th ng-click="ordenar='referencia'">Referencia</th>
                            <th ng-click="ordenar='nombreTamano'">Tama&ntilde;o</th>
                            <th ng-click="ordenar='nombreProcesado'">Estado</th>
                            <th ng-click="ordenar='observaciones'">Observaciones</th>
                            <th ng-click="ordenar='fechaRegistro'">Fecha Registro</th>
                            <th>Acciones</th>
                        </tr>
                        <tr ng-repeat='objeto in objetos | filter: buscar | orderBy: ordenar' style="background: {{ objeto.color }}" >
                            <td>{{ objeto.rp }}</td>
                            <td>{{ objeto.nombreTipo }}</td>
                            <td>{{ objeto.idMarca[1] }}</td>
                            <td>{{ objeto.datoCliente }}</td>
                            <td>{{ objeto.serie }}</td>
                            <td>{{ objeto.medidaCompleta }}</td>
                            <td>{{ objeto.nombreAplicacionOriginal }}</td>
                            <td>{{ objeto.nombreAplicacionRencauche }}</td>
                            <td>{{ objeto.referencia }}</td>
                            <td>{{ objeto.nombreTamano }}</td>
                            <td>{{ objeto.nombreProcesado }}</td>
                            <td>{{ objeto.observaciones }}</td>
                            <td>{{ objeto.fechaRegistro }}</td>
                            <td>
                                <h4 data-toggle="tooltip">
                                    <a class="<?=$botones?>" href="principal.php?CON=system/Pages/llantasFormulario.php&id={{ objeto.id }}"><strong class="text text-success"><span class="glyphicon glyphicon-refresh"></span></strong></a>
                                    <a class="<?=$botones?>" id="btnEliminarAdmin" href='/#eliminar{{ objeto.id }}' title='Eliminar' data-toggle='modal'><strong class="text text-danger"><span class="glyphicon glyphicon-remove-circle"></span></strong></a>
                                    <a class="<?=$btnEliminacionSolicitada?>" id="btnEliminarSolicitud" href='/#solicitudEliminar{{ objeto.id }}' title='Solicitar eliminacion' data-toggle='modal'><strong class="text text-danger"><span class="glyphicon glyphicon-remove-circle"></span></strong></a>
                                    <!--<a data-toggle="tooltip" title="Iniciar servicio" href="principal.php?CON=system/Pages/serviciosLlanta.php&idLlanta={{ objeto.id }}"><span class="glyphicon glyphicon-road"></span></a>-->
                                    <a data-toggle="tooltip" title="Servicio" href="principal.php?CON=system/Pages/servicioLlantaValidar.php&idLlanta={{ objeto.id }}"><span class="glyphicon glyphicon-road"></span></a>
                                </h4>
                            </td>
                        </tr>
                    </table>
                </div>
                <div ng-repeat="objeto in objetos | filter: buscar">
                    <div class='modal fade' id='eliminar{{ objeto.id }}'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                    ¿Est&aacute; seguro que desea eliminar la llanta con numero de serie {{ objeto.serie }}?
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-danger' data-dismiss='modal' >Cancelar</button>
                                    <a href='principal.php?CON=system/Pages/llantasActualizar.php&accion=Eliminar&id={{ objeto.id }}'><button type='button' class='btn btn-success' >Aceptar</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Formularion modal para enviar solicitud de eliminacion-->
                    <div class='modal fade' id='solicitudEliminar{{ objeto.id }}'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                    <h3 class="text text-primary">Enviar solicitud de eliminacion</h3>
                                </div>
                                <div class="modal-header">
                                    <div class="col-lg-12">                                        
                                        <h4 class="text text-capitalize">Informacion de la llanta</h4>
                                        <div class="col-lg-6 col-sm-12">
                                            <label>RP: </label><span class="text text-capitalize"> {{ objeto.rp }} </span>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <label>Tipo: </label><span class="text text-capitalize"> {{ objeto.nombreTipo }} </span>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <label>Marca: </label><span class="text text-capitalize"> {{ objeto.nombreMarca }} </span>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <label>Cliente: </label><span class="text text-capitalize"> {{ objeto.datoCliente }} </span>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <label>Serie: </label><span class="text text-capitalize"> {{ objeto.serie }} </span>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <label>Dimension: </label><span class="text text-capitalize"> {{ objeto.medidaCompleta }} </span>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <label>Aplicacion original: </label><span class="text text-capitalize"> {{ objeto.nombreAplicacionOriginal }} </span>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <label>Aplicacion Rencauche: </label><span class="text text-capitalize"> {{ objeto.nombreAplicacionRencauche }} </span>
                                        </div>
                                        <div class="col-lg-12 col-sm-12">
                                            <label>Tamaño: </label><span class="text text-capitalize"> {{ objeto.nombreTamano }} </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group" id="paddinTop20">
                                            <div class="input-group">
                                                <label class="input-group-addon">Motivo:</label>
                                                <textarea class="form-control" id="txtMotivo" name="motivo" placeholder="Escribe el motivo por el cual deberia ser eliminada esta llanta" maxlength="500" required="" ng-model="solicitudEliminar.motivo"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group hidden">
                                            <input id="txtLlanta" type="hidden" name="idLlanta" value="{{ objeto.id }}" readonly="">
                                            <input id="txtEmpleado" type="hidden" name="idEmpleado" value="<?= $USUARIO->getIdEmpleadoUsuario() ?>" readonly="" ng-model="solicitudEliminar.idEmpleado">
                                        </div>
                                    </div>
                                </div>
                                <div class="alert alert-warning">
                                    <span>Recuerda que la llanta solo puede eliminarse al no tener servicios de Rencauche registrados</span>
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-danger' id="btnCancelarSolicitud" data-dismiss='modal' >Cancelar</button>
                                    <a href="/#solicitudEnviada" data-toggle="modal">
                                        <button type='button' class='btn btn-success {{ objeto.btnEnviarSolicitud }}' id="btnEnviarEliminacion" data-dismiss="modal"
                                                ng-click="enviarSolicitudEliminar(objeto.id, <?= $USUARIO->getIdEmpleadoUsuario() ?>, solicitudEliminar.motivo, solicitudEliminar);cargarDatos();"
                                                >Aceptar</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Fin Formularion modal para enviar solicitud de eliminacion-->
                </div>
            </div>
            <div class="col-md-0"></div>
	</div>
</div>
<div class='modal fade' id='solicitudEnviada'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header'>
                <button type='button' class='close' data-dismiss='modal'>&times;</button>
                <h3 class="text text-success">Tu solicitud de eliminacion ha sido enviada correctamente</h3>
                <h4 class="text text-info">El registro se borrara automaticamente, solo si tu solicitud fue aprobada</h4>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $("#btnCargarDatos").click();
    });
    
    $("#btnEnviarEliminacion").click(function(){
        //$("#btnCancelarSolicitud").click();
        $("#btnCargarDatos").click();
        $("#btnCargarDatos").click(true);
    });
</script>