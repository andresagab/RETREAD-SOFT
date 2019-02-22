<?php
/**
 * Created by PhpStorm.
 * User: Andres
 * Date: 20/10/2018
 * Time: 15:57
 */
?>
<script src="lib/controladores/facturacion.js"></script>
<div ng-controller="facturacion">
    <div class="col-sm-12 col-md-12 col-lg-12 text-center">
        <div class="col-sm-12 col-md-1 col-lg-1">
            <button id="btnOptions" class="mdl-button mdl-js-button mdl-button--icon">
                <i class="material-icons">keyboard_arrow_down</i>
            </button>
            <ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect" for="btnOptions">
                <li class="mdl-menu__item" data-toggle="modal" href='/#dlgSelectLlantas'>
                    <h4><i class="fa fa-dot-circle-o"></i><span> Seleccionar llantas</span></h4>
                </li>
                <li class="mdl-menu__item hide" ng-click="">
                    <h4><i class="fa fa-print"></i><span> Imprimir</span></h4>
                </li>
                <li class="mdl-menu__item" data-toggle="modal" href="/#dlgFileNameExel">
                    <h4><i class="fa fa-file-excel-o"></i><span> Exportar como exel</span></h4>
                </li>
            </ul>
            <div class="mdl-tooltip" for="btnOptions">Opciones</div>
        </div>
        <div class="col-sm-12 col-md-10 col-lg-10">
            <strong class="mdl-color-text--blue">
                <h3>FATURACI&Oacute;N</h3>
            </strong>
        </div>
        <div class="col-sm-12 col-md-1 col-lg-1"></div>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-12" style="padding-top: 10px; padding-bottom: 10px">
        <div class="mdl-spinner mdl-js-spinner is-active" ng-show="html.elements.barLoad"></div>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-12 table table-responsive">
        <center>
            <table class="mdl-data-table mdl-js-data-table" id="tableFacturacion">
                <thead>
                    <tr>
                        <th>RP</th>
                        <th>ORDEN</th>
                        <th class="mdl-data-table__cell--non-numeric">DIMENSI&Oacute;N</th>
                        <th class="mdl-data-table__cell--non-numeric">DISE&Ntilde;O</th>
                        <th class="mdl-data-table__cell--non-numeric">MARCA</th>
                        <th class="mdl-data-table__cell--non-numeric">CLIENTE</th>
                        <th>ANCHO</th>
                        <th>PRECIO</th>
                        <th>CASCO</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="object in html.data.llantasTable">
                        <td></td>
                        <td></td>
                        <td class="mdl-data-table__cell--non-numeric"></td>
                        <td class="mdl-data-table__cell--non-numeric"></td>
                        <td class="mdl-data-table__cell--non-numeric"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </center>
    </div>
    <div class="modal fade" id="dlgSelectLlantas">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" id="btnCloseDlgSelectLlantas" data-dismiss="modal">&times;</button>
                    <h3 class="mdl-color-text--green">SELECCION DE LLANTAS</h3>
                    <div class="col-sm-12 col-md-12 col-lg-12" style="padding-top: 10px; padding-bottom: 10px">
                        <div class="mdl-spinner mdl-js-spinner is-active" ng-show="html.elements.barLoadDlg"></div>
                    </div>
                </div>
                <div class="modal-header">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">ORDEN: </span>
                                <input class="form-control has-success" type="number" min="1" id="txtOrden" name="txtOrden" ng-model="html.elements.inputs.txtOrden">
                            </div>
                        </div>
                        <div class="alert alert-danger" ng-show="html.elements.inputs.txtOrden==null">Este campo no puede estar vacio</div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12 table table-responsive">
                        <center>
                            <table class="mdl-data-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--2dp" ng-show="html.data.llantas.length>=0">
                                <thead>
                                    <tr>
                                        <th>RP</th>
                                        <th class="mdl-data-table__cell--non-numeric">DIMENSI&Oacute;N</th>
                                        <th class="mdl-data-table__cell--non-numeric">DISE&Ntilde;O</th>
                                        <th>ANCHO</th>
                                        <th class="mdl-data-table__cell--non-numeric">MARCA</th>
                                        <th class="mdl-data-table__cell--non-numeric">ESTADO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="objectLlanta in html.data.llantas as resultLlantas">
                                        <td></td>
                                        <td class="mdl-data-table__cell--non-numeric"></td>
                                        <td class="mdl-data-table__cell--non-numeric"></td>
                                        <td></td>
                                        <td class="mdl-data-table__cell--non-numeric"></td>
                                        <td class="mdl-data-table__cell--non-numeric"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </center>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn2CloseDlgSelectLlantas" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored mdl-color--red" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored mdl-color--green" ng-disabled="resultLlantas<=0">ENVIAR</button>
                </div>
            </div>
        </div>
    </div>
</div>
