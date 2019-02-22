<?php
//echo round(doubleval("0.080"), 2); die();
/**
 * Created by PhpStorm.
 * User: Andres
 * Date: 12/10/2018
 * Time: 20:36
 */
?>
<script src="lib/factorys/Exel.js"></script>
<script src="lib/controladores/informeInsumos.js"></script>
<div ng-controller="ExelController">
    <div ng-controller="informeInsumos">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="col-sm-12 col-md-1 col-lg-1">
                <button id="btnOptionsInforme" class="mdl-button mdl-js-button mdl-button--icon">
                    <i class="material-icons">keyboard_arrow_down</i>
                </button>
                <ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect" for="btnOptionsInforme">
                    <li class="mdl-menu__item" ng-click="loadObjects();">
                        <h4>
                            <i class="fa fa-list"></i>
                            <span> Ver todos los registros</span>
                        </h4>
                    </li>
                    <li class="mdl-menu__item" data-toggle="modal" href='/#dlgFiltros'>
                        <h4><i class="fa fa-edit"></i><span> Generar informe de busqueda personalizada</span></h4>
                    </li>
                    <li class="mdl-menu__item hide" ng-click="imprimirInforme()">
                        <h4><i class="fa fa-print"></i><span> Imprimir</span></h4>
                    </li>
                    <li class="mdl-menu__item" data-toggle="modal" href="/#dlgFileNameExel">
                        <h4><i class="fa fa-file-excel-o"></i><span> Exportar como exel</span></h4>
                    </li>
                </ul>
                <div class="mdl-tooltip" for="btnOptionsInforme">Opciones</div>
            </div>
            <div class="col-sm-12 col-md-10 col-lg-10">
                <strong class="mdl-color-text--blue">
                    <h2>INSUMOS Y HERRAMIENTAS</h2>
                </strong>
            </div>
            <div class="col-sm-12 col-md-1 col-lg-1"></div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-12" style="padding-top: 10px;">
            <div class="col-sm-12 col-md-3 col-lg-2"></div>
            <div class="col-sm-12 col-md-6 col-lg-8">
                <div class="form-group-sm">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                        <input class="mdl-textfield__input" id="txtSearch" name="txtSearch" ng-model="html.data.inputs.txtSearch">
                        <span class="mdl-textfield__label" for="txtSearch" style="display: inline-flex;">
                            <span class="material-icons">search</span><span> Buscar en el informe</span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-2"></div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-12" style="padding-top: 10px; padding-bottom: 10px">
            <div class="mdl-spinner mdl-js-spinner is-active" ng-show="html.elements.barLoad"></div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-12 table table-responsive">
            <center>
                <table class="mdl-data-table mdl-js-data-table" id="tableInsumosHerramientas">
                    <thead>
                    <tr>
                        <th class="mdl-data-table__cell--non-numeric">INSUMO</th>
                        <th>ORIGINAL</th>
                        <th>RECARGADO</th>
                        <th>ACUMULADO</th>
                        <th>ACTUAL</th>
                        <th>ORIGINAL-PT</th>
                        <th>RECARGADO-PT</th>
                        <th>ACUMULADO-PT</th>
                        <th>TOTAL-PT</th>
                        <th>N° USOS</th>
                        <th>CANT.USADA</th>
                        <th>SOBRANTE-PT</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat="object in html.data.objects | filter: html.data.inputs.txtSearch as result">
                        <td class="mdl-data-table__cell--non-numeric">{{ object.nombreinsumo }}</td>
                        <td>{{ object.stockOriginal }}</td>
                        <td>{{ object.stockCargado }}</td>
                        <td>{{ object.stockAcumulado }}</td>
                        <td>{{ object.stockbodega }}</td>
                        <td>{{ object.stockOriginalPuestoTrabajo }}</td>
                        <td>{{ object.stockRecargadoPuestoTrabajo }}</td>
                        <td>{{ object.stockAcumuladoPuestoTrabajo }}</td>
                        <td>{{ object.totalPuestoTrabajo }}</td>
                        <td>{{ object.numeroUsos }}</td>
                        <td>{{ object.stockUsado }}</td>
                        <td>{{ object.stockRestante }}</td>
                    </tr>
                    <tr ng-show="result<=0">
                        <td colspan="12">No se encontraron resultados</td>
                    </tr>
                    </tbody>
                </table>
            </center>
        </div>
        <div class="modal fade" id="dlgFiltros">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" id="btnCloseDlgFiltros" data-dismiss="modal">&times;</button>
                        <h3 class="mdl-color-text--green">FILTROS DE BUSQUEDA</h3>
                    </div>
                    <form name="frmFiltros" id="frmFiltros" ng-submit="loadObjects();">
                        <div class="modal-header">
                            <!--FECHAS DE CREACION-->
                            <div class="col-sm-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"></span>
                                        <span class="input-group-addon">
                                        <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="chkFechasCreacion">
                                            <input type="checkbox" id="chkFechasCreacion" class="mdl-checkbox__input" name="chkFechasCreacion" ng-model="html.data.inputs.chkFechasCreacion" ng-change="">
                                            <span class="mdl-checkbox__label">
                                                <i class="fa fa-calendar"></i> FECHAS DE CREACI&Oacute;N:
                                            </span>
                                        </label>
                                    </span>
                                    </div>
                                    <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar-plus-o"> Fecha inicio:</i>
                                    </span>
                                        <input class="form-control" id="txtFechaInicioCreacion" type="date" name="txtFechaInicioCreacion" ng-model="html.data.inputs.txtFechaInicioCreacion" ng-disabled="!html.data.inputs.chkFechasCreacion" ng-change="">
                                    </div>
                                    <div class="alert alert-danger" ng-show="html.data.inputs.chkFechasCreacion && html.data.inputs.txtFechaInicioCreacion==null">Este campo no puede estar vacio</div>
                                    <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar-times-o"> Fecha fin:</i>
                                    </span>
                                        <input class="form-control" id="txtFechaFinCreacion" type="date" name="txtFechaFinCreacion" ng-model="html.data.inputs.txtFechaFinCreacion" ng-disabled="!html.data.inputs.chkFechasCreacion" ng-change="">
                                    </div>
                                    <div class="alert alert-danger" ng-show="html.data.inputs.chkFechasCreacion && html.data.inputs.txtFechaFinCreacion==null">Este campo no puede estar vacio</div>
                                    <div class="alert alert-danger" ng-show="html.data.inputs.chkFechasCreacion && html.data.inputs.txtFechaFinCreacion<html.data.inputs.txtFechaInicioCreacion">La fecha fin no puede ser inferior a la fecha de inicio</div>
                                </div>
                            </div>
                            <!--FIN FECHAS DE CREACION-->
                            <!--FECHAS DE RECARGA KARDEX-->
                            <div class="col-sm-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"></span>
                                        <span class="input-group-addon">
                                        <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="chkFechasRecargaKardex">
                                            <input type="checkbox" id="chkFechasRecargaKardex" class="mdl-checkbox__input" name="chkFechasRecargaKardex" ng-model="html.data.inputs.chkFechasRecargaKardex" ng-change="">
                                            <span class="mdl-checkbox__label">
                                                <i class="fa fa-calendar"></i> FECHAS DE RECARGA:
                                            </span>
                                        </label>
                                    </span>
                                    </div>
                                    <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar-plus-o"> Fecha inicio:</i>
                                    </span>
                                        <input class="form-control" id="txtFechaInicioRecargaKardex" type="date" name="txtFechaInicioRecargaKardex" ng-model="html.data.inputs.txtFechaInicioRecargaKardex" ng-disabled="!html.data.inputs.chkFechasRecargaKardex" ng-change="">
                                    </div>
                                    <div class="alert alert-danger" ng-show="html.data.inputs.chkFechasRecargaKardex && html.data.inputs.txtFechaInicioRecargaKardex==null">Este campo no puede estar vacio</div>
                                    <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar-times-o"> Fecha fin:</i>
                                    </span>
                                        <input class="form-control" id="txtFechaFinRecargaKardex" type="date" name="txtFechaFinRecargaKardex" ng-model="html.data.inputs.txtFechaFinRecargaKardex" ng-disabled="!html.data.inputs.chkFechasRecargaKardex" ng-change="">
                                    </div>
                                    <div class="alert alert-danger" ng-show="html.data.inputs.chkFechasRecargaKardex && html.data.inputs.txtFechaFinRecargaKardex==null">Este campo no puede estar vacio</div>
                                    <div class="alert alert-danger" ng-show="html.data.inputs.chkFechasRecargaKardex && html.data.inputs.txtFechaFinRecargaKardex<html.data.inputs.txtFechaInicioRecargaKardex">La fecha fin no puede ser inferior a la fecha de inicio</div>
                                </div>
                            </div>
                            <!--FIN FECHAS DE RECARGA KARDEX-->
                            <!--FECHAS DE ENVIO PT-->
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"></span>
                                        <span class="input-group-addon">
                                        <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="chkFechasEnvioPT">
                                            <input type="checkbox" id="chkFechasEnvioPT" class="mdl-checkbox__input" name="chkFechasEnvioPT" ng-model="html.data.inputs.chkFechasEnvioPT" ng-change="">
                                            <span class="mdl-checkbox__label">
                                                <i class="fa fa-calendar"></i> FECHAS DE ENV&Iacute;O A PUESTO DE TRABAJO:
                                            </span>
                                        </label>
                                    </span>
                                    </div>
                                    <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar-plus-o"> Fecha inicio:</i>
                                    </span>
                                        <input class="form-control" id="txtFechaInicioEnivoPT" type="date" name="txtFechaInicioEnvioPT" ng-model="html.data.inputs.txtFechaInicioEnvioPT" ng-disabled="!html.data.inputs.chkFechasEnvioPT" ng-change="">
                                    </div>
                                    <div class="alert alert-danger" ng-show="html.data.inputs.chkFechasEnvioPT && html.data.inputs.txtFechaInicioEnvioPT==null">Este campo no puede estar vacio</div>
                                    <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar-times-o"> Fecha fin:</i>
                                    </span>
                                        <input class="form-control" id="txtFechaFinEnvioPT" type="date" name="txtFechaFinEnvioPT" ng-model="html.data.inputs.txtFechaFinEnvioPT" ng-disabled="!html.data.inputs.chkFechasEnvioPT" ng-change="">
                                    </div>
                                    <div class="alert alert-danger" ng-show="html.data.inputs.chkFechasEnvioPT && html.data.inputs.txtFechaFinEnvioPT==null">Este campo no puede estar vacio</div>
                                    <div class="alert alert-danger" ng-show="html.data.inputs.chkFechasEnvioPT && html.data.inputs.txtFechaFinEnvioPT<html.data.inputs.txtFechaInicioEnvioPT">La fecha fin no puede ser inferior a la fecha de inicio</div>
                                </div>
                            </div>
                            <!--FIN FECHAS DE ENVIO PT-->
                            <!--FECHAS DE RECARGA PUESTO TRABAJO-->
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"></span>
                                        <span class="input-group-addon">
                                        <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="chkFechasRecargaPT">
                                            <input type="checkbox" id="chkFechasRecargaPT" class="mdl-checkbox__input" name="chkFechasRecargaPT" ng-model="html.data.inputs.chkFechasRecargaPT" ng-change="">
                                            <span class="mdl-checkbox__label">
                                                <i class="fa fa-calendar"></i> FECHAS RECARGA EN PUESTO DE TRABAJO:
                                            </span>
                                        </label>
                                    </span>
                                    </div>
                                    <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar-plus-o"> Fecha inicio:</i>
                                    </span>
                                        <input class="form-control" id="txtFechaInicioRecargaPT" type="date" name="txtFechaInicioRecargaPT" ng-model="html.data.inputs.txtFechaInicioRecargaPT" ng-disabled="!html.data.inputs.chkFechasRecargaPT" ng-change="">
                                    </div>
                                    <div class="alert alert-danger" ng-show="html.data.inputs.chkFechasRecargaPT && html.data.inputs.txtFechaInicioRecargaPT==null">Este campo no puede estar vacio</div>
                                    <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar-times-o"> Fecha fin:</i>
                                    </span>
                                        <input class="form-control" id="txtFechaFinRecargaPT" type="date" name="txtFechaFinRecargaPT" ng-model="html.data.inputs.txtFechaFinRecargaPT" ng-disabled="!html.data.inputs.chkFechasRecargaPT" ng-change="">
                                    </div>
                                    <div class="alert alert-danger" ng-show="html.data.inputs.chkFechasRecargaPT && html.data.inputs.txtFechaFinRecargaPT==null">Este campo no puede estar vacio</div>
                                    <div class="alert alert-danger" ng-show="html.data.inputs.chkFechasRecargaPT && html.data.inputs.txtFechaFinRecargaPT<html.data.inputs.txtFechaInicioRecargaPT">La fecha fin no puede ser inferior a la fecha de inicio</div>
                                </div>
                            </div>
                            <!--FIN FECHAS DE RECARGA PUESTO TRABAJO-->
                            <!--FECHAS DE USO-->
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"></span>
                                        <span class="input-group-addon">
                                        <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="chkFechasUso">
                                            <input type="checkbox" id="chkFechasUso" class="mdl-checkbox__input" name="chkFechasUso" ng-model="html.data.inputs.chkFechasUso" ng-change="">
                                            <span class="mdl-checkbox__label">
                                                <i class="fa fa-calendar"></i> FECHAS DE USO:
                                            </span>
                                        </label>
                                    </span>
                                    </div>
                                    <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar-plus-o"> Fecha inicio:</i>
                                    </span>
                                        <input class="form-control" id="txtFechaInicioUso" type="date" name="txtFechaInicioUso" ng-model="html.data.inputs.txtFechaInicioUso" ng-disabled="!html.data.inputs.chkFechasUso" ng-change="">
                                    </div>
                                    <div class="alert alert-danger" ng-show="html.data.inputs.chkFechasUso && html.data.inputs.txtFechaInicioUso==null">Este campo no puede estar vacio</div>
                                    <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar-times-o"> Fecha fin:</i>
                                    </span>
                                        <input class="form-control" id="txtFechaFinUso" type="date" name="txtFechaFinUso" ng-model="html.data.inputs.txtFechaFinUso" ng-disabled="!html.data.inputs.chkFechasUso" ng-change="">
                                    </div>
                                    <div class="alert alert-danger" ng-show="html.data.inputs.chkFechasUso && html.data.inputs.txtFechaFinUso==null">Este campo no puede estar vacio</div>
                                    <div class="alert alert-danger" ng-show="html.data.inputs.chkFechasUso && html.data.inputs.txtFechaFinUso<html.data.inputs.txtFechaInicioUso">La fecha fin no puede ser inferior a la fecha de inicio</div>
                                </div>
                            </div>
                            <!--FIN FECHAS DE USO-->
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btn2CloseDlgFiltros" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored mdl-color--red" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored mdl-color--green" ng-disabled="getStatusFilters() || validFields()">GENERAR</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="dlgFileNameExel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" id="btnCloseDlgFileNameExel" data-dismiss="modal">&times;</button>
                        <h3 class="mdl-color-text--green">EXPORTAR A EXEL</h3>
                    </div>
                    <form id="frmFilenNameExel" name="frmFileNameExel" ng-submit="exportDataToExel();">
                        <div class="modal-header">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">Nombre del archivo: </span>
                                        <input class="form-control" type="text" id="txtFileNameExel" name="txtFileNameExel" ng-model="html.data.inputs.txtFileNameExel" required>
                                    </div>
                                    <div class="alert alert-danger" ng-show="html.data.inputs.txtFileNameExel==null">Este campo no puede estar vacio</div>
                                    <div class="alert alert-danger" ng-show="result<=0">No se puede exportar un archivo sin datos</div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btn2CloseDlgFileNameExel" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored mdl-color--red" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored mdl-color--green" ng-disabled="html.data.inputs.txtFileNameExel==null || result<=0">EXPORTAR</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>