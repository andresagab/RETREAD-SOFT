<?php

?>
<script src="lib/controladores/solicitudesEliminarLlantas.js"></script>
<div class="col-md-12" ng-controller="solicitudesEliminarLlanta">
    <div class="hidden-lg" id="cargar" ng-click="cargarDatos()"></div>
    <div class="col-md-12" id="paddinTop30" ng-click="cargarDatos()"></div>
	<div class="col-md-3"></div>
	<div class="col-md-6">
            <strong class="text text-success control-label"><h2>Solicitudes para la eliminacion de llantas</h2></strong>
	</div>
	<div class="col-md-3"></div>
        <div class="row col-md-12" id="paddinTop20" ng-hide="objetos">
            <i class="text text-info fa fa-refresh fa-spin fa-5x primary"></i>
        </div>
        <div class="row col-md-12" id="paddinTop20"></div>
        <div class="row col-md-12" ng-show="objetos">
            <div class="col-md-1"></div>
            <div class="col-md-2">
                <div class="form-group-sm hidden">
                    <a href="#"><button class="btn btn-primary">Adicionar</button></a>
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-4">
                <div class="col-md-12 form-group-sm">
                    <input class="col-md-12 form-control" id="buscar" name="buscar" placeholder="Buscar por: Orden de llanta, empleado, motivo, estado o FechaCreacion" ng-model="buscar">
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-2">
                <div class="form-group">
                    <button class="btn btn-success" id="cargar" ng-click="cargarDatos();">Actualizar lista</button>
                </div>
            </div>
            <div class="col-md-1"></div>
            <!--<div class="col-md-4"></div>-->
        </div>
        <div class="row col-md-12" id="paddinTop20" ng-show="objetos">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="table-responsive">
                    <table class="table table-hover table-responsive table-striped">
                        <tr class="active">
                            <th ng-click="ordenar='os'">Llanta</th>
                            <th ng-click="ordenar='observaciones'">Empleado</th>
                            <th ng-click="ordenar='observaciones'">Motivo</th>
                            <th ng-click="ordenar='observaciones'">Estado</th>
                            <th ng-click="ordenar='fechaRegistro'">Fecha Registro</th>
                            <th>Acciones</th>
                        </tr>
                        <tr ng-repeat='objeto in objetos | filter: buscar | orderBy: ordenar' class="text-left">
                            <td>{{ objeto.llantaJSON[0].rp }} ( {{ objeto.llantaJSON[0].serie }} )</td>
                            <td>{{ objeto.personaEmpleado[1] }} {{ objeto.personaEmpleado[2] }} ( <span class="text text-info">{{ objeto.personaEmpleado[0] }}</span> )</td>
                            <td>{{ objeto.motivo }}</td>
                            <td>{{ objeto.nombreEstado }}</td>
                            <td>{{ objeto.fechaRegistro }}</td>
                            <td>
                                <h4>
                                    <i title="Vista detallada"><a href="/#detalles{{ objeto.id }}" data-toggle='modal'><span class="fa fa-list"></span></a></i>
                                    <i id="paddingLeft10"><a href='/#eliminar{{ objeto.id }}' title='Eliminar' data-toggle='modal'><span class="text text-danger glyphicon glyphicon-remove-circle"></span></a></i>
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
                                    ¿Est&aacute; seguro que desea <b>eliminar</b> este registro?
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-danger' data-dismiss='modal' >Cancelar</button>
                                    <a href='principal.php?CON=system/Pages/solicitudesEliminarLlantaActualizar.php&accion=Eliminar&id={{ objeto.id }}'><button type='button' class='btn btn-success' >Aceptar</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <!--Formularion modal para aprobar solicitud de eliminacion-->
                    <div class='modal fade' id='detalles{{ objeto.id }}'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                    <h3 class="text text-primary">Solicitud de eliminacion</h3>
                                </div>
                                <div class="modal-header">
                                    <div class="col-lg-12">                                        
                                        <h4 class="text text-uppercase">Informacion de la llanta</h4>
                                        <div class="col-lg-6 col-sm-12">
                                            <label>RP: </label><span class="text text-capitalize"> {{ objeto.llantaJSON[0].rp }} </span>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <label>Tipo: </label><span class="text text-capitalize"> {{ objeto.llantaJSON[0].nombreTipo }} </span>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <label>Marca: </label><span class="text text-capitalize"> {{ objeto.llantaJSON[0].nombreMarca }} </span>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <label>Cliente: </label><span class="text text-capitalize"> {{ objeto.llantaJSON[0].datoCliente }} </span>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <label>Serie: </label><span class="text text-capitalize"> {{ objeto.llantaJSON[0].serie }} </span>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <label>Dimension: </label><span class="text text-capitalize"> {{ objeto.llantaJSON[0].medidaCompleta }} </span>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <label>Aplicacion original: </label><span class="text text-capitalize"> {{ objeto.llantaJSON[0].nombreAplicacionOriginal }} </span>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <label>Aplicacion Rencauche: </label><span class="text text-capitalize"> {{ objeto.llantaJSON[0].nombreAplicacionRencauche }} </span>
                                        </div>
                                        <div class="col-lg-12 col-sm-12">
                                            <label>Tamaño: </label><span class="text text-capitalize"> {{ objeto.llantaJSON[0].nombreTamano }} </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        
                                    </div>
                                </div>
                                <div class="modal-header">
                                    <div class="col-lg-12">                                        
                                        <h4 class="text text-uppercase">Informacion de la solicitud</h4>
                                        <div class="col-lg-6 col-sm-12">
                                            <label>Empleado solicitador: </label><span class="text text-capitalize"> {{ objeto.personaEmpleado[1] }} {{ objeto.personaEmpleado[2]}} (<i class="text-info">{{ objeto.personaEmpleado[0] }}</i>)</span>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <label>Fecha de envio: </label><span class="text text-capitalize"> {{ objeto.fechaRegistro }}</span>
                                        </div>
                                        <div class="col-lg-12 col-sm-12">
                                            <label>Motivo: </label><span class="text text-capitalize"> {{ objeto.motivo }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="alert alert-warning">
                                    <span>Si la llanta solicitada inicia un proceso de rencauche, esta no podra ser eliminada</span>
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-danger' id="btnCancelarSolicitud" data-dismiss='modal' >Cancelar</button>
                                    <a href="/#solicitudEnviada" data-toggle="modal">
                                        <button type='button' class='btn btn-success {{ objeto.btnAprobar }}' id="btnAprobar" data-dismiss="modal"
                                                ng-click="aprobar(objeto.id, objeto);cargarDatos();"
                                                >Aprobar eliminacion</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Fin Formularion modal para aprobar solicitud de eliminacion-->
                </div>
            </div>
            <div class="col-md-1"></div>
	</div>
</div>
<!--Dialogo de aprobado-->
<div class='modal fade' id='solicitudEnviada'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header'>
                <button type='button' class='close' data-dismiss='modal'>&times;</button>
                <h3 class="text text-success">Solicitud aprobada exitosamente</h3>
                <h4 class="text text-info">La llanta solicitada fue eliminada correctamente</h4>
            </div>
        </div>
    </div>
</div>
<!--Fin Dialogo de aprobado-->
<script>
    $(document).ready(function(){
        //$('[data-toggle="tooltip"]').tooltip();
        $("#cargar").click();
    });
    
    $("#btnAprobar").click(function(){
        //$("#btnCancelarSolicitud").click();
        $("#cargar").click(true);
    });
</script>