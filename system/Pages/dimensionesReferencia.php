<?php
?>
<script src="lib/controladores/dimensionesReferencia.js"></script>
<div class="col-md-12" ng-controller="dimensionesReferencia">
        <div class="col-lg-12 hidden" id="cargarLista" ng-click="cargarLista(<?=$_GET['id']?>)"></div>
	<div class="col-md-12" id="paddinTop30"></div>
	<div class="col-md-3" ></div>
	<div class="col-md-6" >
            <strong class="text text-success control-label"><h2>Medidas de la referencia <span class="text-muted">{{ referencia.referencia }}</span></h2></strong>
	</div>
	<div class="col-md-3" ></div>
        <div class="row col-md-12" id="paddinTop20" ng-hide="objetos">
            <div class="mdl-spinner mdl-js-spinner is-active"></div>
        </div>
        <div class="row col-md-12" id="paddinTop20"></div>
        <div class="row col-md-12">
            <div class="col-md-2">
                <div class="form-group-sm">
                    <!--<a href="#/adicionarCargo" data-toggle="modal"><button class="btn btn-primary">Adicionar</button></a>-->
                    <button class="btn btn-primary" type="button" id="btnAdicionar">Adicionar</button>
                    <div class="mdl-tooltip" data-mdl-for="btnAdicionar">Registrar nueva medida</div>
                </div>
            </div>
            <div class="col-md-2">
                <a href="principal.php?CON=system/Pages/referenciasGravado.php&id={{ referencia.tipoLlanta[0].id }}"><button class="btn btn-default" type="button" id="btnRegresar">Regresar</button></a>
                <div class="mdl-tooltip" data-mdl-for="btnRegresar">Regresar al listado de referencias ({{ referencia.tipoLlanta[0].nombre }})</div>
            </div>
            <div class="col-md-4">
                <div class="col-md-12 form-group-sm">
                    <input class="col-md-12 form-control" id="buscar" name="buscar" placeholder="Buscar en cualquier campo de la tabla" ng-model="buscar">
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-2">
                <button class="btn btn-success" type="button" id="cargarLista" ng-click="cargarLista(<?= $_GET['id'] ?>)">Actualizar lista</button>
            </div>
            <div class="col-md-1"></div>
        </div>
        <div class="row col-md-12" id="paddinTop20" ng-show="objetos">
            <center>
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class="table-responsive">
                        <table class="mdl-data-table mdl-js-data-table">
                            <thead class="text text-uppercase">
                                <tr class="active">
                                    <th ng-click="orden='base'">Base</th>
                                    <th ng-click="orden='profundidad'">Profundidad</th>
                                    <th ng-click="orden='peso'">Peso</th>
                                    <th ng-click="orden='largo'">Largo</th>
                                    <th ng-click="orden='observaciones'">Observaciones</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="objeto in objetos | filter: buscar | orderBy: orden">
                                    <td>{{ objeto.base }}</td>
                                    <td>{{ objeto.profundidad }}</td>
                                    <td>{{ objeto.peso }}</td>
                                    <td>{{ objeto.largo }}</td>
                                    <td>{{ objeto.observaciones }}</td>
                                    <td>
                                        <h4>
                                            <a href="principal.php?CON=system/Pages/dimensionesReferenciaFormulario.php&id={{ objeto.id }}" title="Modificar"><span class="fa fa-edit"></span></a>
                                            <a id="paddingLeft10" href='/#eliminar{{ objeto.id }}' title='Eliminar' data-toggle='modal'><span class="text-danger fa fa-trash"></span></a>
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
                                        ¿Est&aacute; seguro que desea eliminar la medida {{ objeto.base }} - {{ objeto.profundidad }} - {{ objeto.peso }} - {{ objeto.largo }}?
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-danger' data-dismiss='modal' >Cancelar</button>
                                        <a href='principal.php?CON=system/Pages/dimensionesReferenciaActualizar.php&id={{ objeto.id }}&accion=Eliminar'><button type='button' class='btn btn-success' >Aceptar</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1"></div>
            </center>
	</div>
</div>
<script>
    $(document).ready(function(){
        $("#cargarLista").click();
    });
    
    $("#btnAdicionar").click(function (){
        window.location="principal.php?CON=system/Pages/dimensionesReferenciaFormulario.php&idReferencia=<?= $_GET['id'] ?>";
    });
</script>