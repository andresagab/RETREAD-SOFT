<?php
require_once dirname(__FILE__).'/../Clases/Opcion.php';
$lista='';
$datosMenus= Opcion::getListaEnObjetos("ruta is null and idmenu is null", null);
for ($i = 0; $i < count($datosMenus); $i++) {
    $objetoMenu=$datosMenus[$i];
    $lista.="<div class='table-responsive'>";
        $lista.="<div class='alert alert-info' data-toggle='tooltip' title='{$objetoMenu->getDescripcion()}'><b>Menu: </b>{$objetoMenu->getNombre()}";
        $lista.="<a data-toggle='tooltip' id='paddingLeft10' title='Modificar' href='principal.php?CON=system/Pages/menuFormulario.php&id={$objetoMenu->getId()}'><span class='text-success glyphicon glyphicon-refresh'></span></a>";
        $lista.="<a id='paddingLeft10' title='Eliminar' href='/#eliminar{$objetoMenu->getId()}' title='Eliminar' data-toggle='modal'><span class='text-danger glyphicon glyphicon-remove-circle'></span></a>";
        $lista.="</div>";
        $lista.="<table class='table table-hover table-striped'>";
            $lista.="<tr class='active'>";
                $lista.="<th>Nombre</th><th>Descripcion</th><th>Ruta</th><th><a id='paddingLeft10' data-toggle='tooltip' title='Adicionar opcion para este menu' href='principal.php?CON=system/Pages/opcionesMenuFormulario.php&idMenu={$objetoMenu->getId()}'><span class='glyphicon glyphicon-plus'></span></a></th>";
            $lista.="</tr>";
            $datosOpcionesMenu= Opcion::getListaEnObjetos("idMenu={$objetoMenu->getId()} and ruta is not null", null);
            for ($j = 0; $j < count($datosOpcionesMenu); $j++) {
                $objetoOpcion=$datosOpcionesMenu[$j];
                $lista.="<tr>";
                    $lista.="<td>{$objetoOpcion->getNombre()}</td>";
                    $lista.="<td>{$objetoOpcion->getDescripcion()}</td>";
                    $lista.="<td>{$objetoOpcion->getRuta()}</td>";
                    $lista.="<td>";
                    $lista.="<a data-toggle='tooltip' title='Modificar opcion' href='principal.php?CON=system/Pages/opcionesMenuFormulario.php&id={$objetoOpcion->getId()}'><span class='text-success glyphicon glyphicon-refresh'></span></a>";
                    $lista.="<a id='paddingLeft10' title='Eliminar' href='/#eliminarOpcion{$objetoOpcion->getId()}' title='Eliminar opcion' data-toggle='modal'><span class='text-danger glyphicon glyphicon-remove-circle'></span></a>";
                    $lista.="</td>";
                $lista.="</tr>";
                $lista.="<div class='modal fade' id='eliminarOpcion{$objetoOpcion->getId()}'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                    ¿Est&aacute; seguro que desea eliminar la opcion {$objetoOpcion->getNombre()}?
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-danger' data-dismiss='modal' >Cancelar</button>
                                    <a href='principal.php?CON=system/Pages/opcionesMenuActualizar.php&id={$objetoOpcion->getId()}&accion=Eliminar'><button type='button' class='btn btn-success' >Aceptar</button></a>
                                </div>
                            </div>
                        </div>
                    </div>";
            }
        $lista.="</table>";
    $lista.="</div>";
    $lista.="<div class='modal fade' id='eliminar{$objetoMenu->getId()}'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                    ¿Est&aacute; seguro que desea eliminar el menu {$objetoMenu->getNombre()}?
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-danger' data-dismiss='modal' >Cancelar</button>
                                    <a href='principal.php?CON=system/Pages/menuActualizar.php&id={$objetoMenu->getId()}&accion=Eliminar'><button type='button' class='btn btn-success' >Aceptar</button></a>
                                </div>
                            </div>
                        </div>
                    </div>";
}
?>
<script src="lib/controladores/menus.js"></script>
<div class="col-md-12" ng-controller="menus">
	<div class="col-md-12" id="paddinTop30"></div>
	<div class="col-md-4" ></div>
	<div class="col-md-4" >
            <strong class="text text-success control-label"><h2>Menus del sistema</h2></strong>
	</div>
	<div class="col-md-4" ></div>
        <div class="row col-md-12" id="paddinTop20"></div>
        <div class="row col-md-12">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="form-group-sm">
                    <!--<a href="#/adicionarCargo" data-toggle="modal"><button class="btn btn-primary">Adicionar</button></a>-->
                    <button class="btn btn-warning" type="button" id="btnAdicionar">Adicionar</button>
                </div>
            </div>
            <div class="col-md-4"></div>
            <!--
            <div class="col-md-4">
                <div class="col-md-12 form-group-sm">
                    <input class="col-md-12 form-control" id="buscar" name="buscar" placeholder="Buscar por: Nombre o Descripcion" ng-model="buscar">
                </div>
            </div>
            <div class="col-md-4"></div>-->
        </div>
	<div class="row col-md-12" id="paddinTop20">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <?=$lista?>
                <!--
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <tr class="active">
                            <th ng-click="orden='nombre'">Nombre</th><th ng-click="orden='descripcion'">Descripcion</th><th>Acciones</th>
                        </tr>
                        <tr ng-repeat="objeto in objetos | filter: buscar | orderBy: orden">
                            <td>{{ objeto.nombre }}</td>
                            <td>{{ objeto.descripcion }}</td>
                            <td>
                                <h4><a href="principal.php?CON=system/Pages/menuFormulario.php&id={{ objeto.id }}"><span class="glyphicon glyphicon-refresh"></span></a></h4>
                                <h4><a href='/#eliminar{{ objeto.id }}' title='Eliminar' data-toggle='modal'><span class="glyphicon glyphicon-remove-circle"></span></a></h4>
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
                                    ¿Est&aacute; seguro que desea eliminar el menu {{ objeto.nombre }}?
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-danger' data-dismiss='modal' >Cancelar</button>
                                    <a href='principal.php?CON=system/Pages/menuActualizar.php&id={{ objeto.id }}&accion=Eliminar'><button type='button' class='btn btn-success' >Aceptar</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>-->
            </div>
            <div class="col-md-1"></div>
	</div>
</div>
<script>
    $("#btnAdicionar").click(function (){
        window.location="principal.php?CON=system/Pages/menuFormulario.php";
    });
</script>