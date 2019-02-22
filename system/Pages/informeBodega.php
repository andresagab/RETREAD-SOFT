<script src="lib/factorys/Exel.js"></script>
<script src="lib/controladores/informeBodega.js"></script>
<div class="col-md-12" ng-controller="ExelController">
    <div class="col-md-12" ng-controller="informeBodega">
        <input type="hidden" id="txtFiltro" name="txtFiltro" value="{{ html.filtro }}">
        <div class="">
            <div class="col-lg-12 hidden" id="cargarLista"></div>
            <div class="col-sm-1 col-lg-1" >
                <button id="btnOpcionesFiltros" class="mdl-button mdl-js-button mdl-button--icon">
                    <i class="material-icons">keyboard_arrow_down</i>
                </button>
                <ul class="mdl-menu mdl-menu--bottom-left mdl-js-menu mdl-js-ripple-effect" for="btnOpcionesFiltros">
                    <li class="mdl-menu__item" ng-click="cargarListaDefault('', '');setFiltro('')">
                        <h4><i class="fa fa-list"></i><span> Ver todos los registros</span></h4>
                    </li>
                    <li class="mdl-menu__item" ng-click="cargarListaDefault(filtros.filtroRechazadas, '');setFiltro(filtros.filtroRechazadas);">
                        <h4><i class="fa fa-times"></i><span> Generar informe por llantas rechazadas</span></h4>
                    </li>
                    <li class="mdl-menu__item" ng-click="cargarListaDefault(filtros.filtroEnRencauche, '');setFiltro(filtros.filtroEnRencauche);">
                        <h4><i class="fa fa-play"></i><span> Generar informe por llantas en proceso de rencauche</span></h4>
                    </li>
                    <li class="mdl-menu__item" ng-click="cargarListaDefault(filtros.filtroRencauchadas, '');setFiltro(filtros.filtroRencauchadas);">
                        <h4><i class="fa fa-check"></i><span> Generar informe por llantas rencauchadas exitosamente</span></h4>
                    </li>
                    <li class="mdl-menu__item" ng-click="cargarListaDefault(filtros.filtroSinRencauche, '');setFiltro(filtros.filtroSinRencauche);">
                        <h4><i class="fa fa-clock-o"></i><span> Generar informe por llantas sin rencauche</span></h4>
                    </li>
                    <li class="mdl-menu__item" data-toggle="modal" href='/#_frmFiltros'>
                        <h4><i class="fa fa-edit"></i><span> Generar informe de busqueda personalizada</span></h4>
                    </li>
                    <li class="mdl-menu__item" ng-click="imprimirInforme()">
                        <h4><i class="fa fa-print"></i><span> Imprimir</span></h4>
                    </li>
                    <!--<li class="mdl-menu__item" ng-click="exportarExel()">-->
                    <!--<li class="mdl-menu__item" ng-click="exportExel('#dataBodegaTable')">-->
                    <li class="mdl-menu__item" ng-click="exportarExel()">
                    <!--<li class="mdl-menu__item" data-toggle='modal' href="/#dlgFileNameExel">-->
                        <h4><i class="fa fa-file-excel-o"></i><span> Exportar como exel</span></h4>
                    </li>
                </ul>
                <div class="mdl-tooltip" for="btnOpcionesFiltros">Opciones</div>
            </div>
            <div class="col-sm-10 col-lg-10">
                <strong class="mdl-color-text--blue"><h2>BODEGA</h2></strong>
            </div>
            <div class="col-sm-1 col-lg-1 active">
            </div>
            <div class="row col-md-12" id="paddinTop10">&nbsp;</div>
            <!--RESUMEN-->
            <center>
                <table class="mdl-data-table" ng-show="objetos!=null">
                    <tr>
                        <th>Llantas filtradas</th>
                        <th>Llantas rencauchadas exitosamente</th>
                        <th>Llantas rechazadas</th>
                        <th>Llantas en reencauche</th>
                        <th>Llantas sin reencauchar</th>
                    </tr>
                    <tr>
                        <td>{{ objetos.length }}</td>
                        <td>{{ getTotalData(0) }}</td>
                        <td>{{ getTotalData(1) }}</td>
                        <td>{{ getTotalData(3) }}</td>
                        <td>{{ getTotalData(2) }}</td>
                    </tr>
                    <tr>
                        <th>N° ordenes de servicio</th>
                        <th>Llantas facturadas</th>
                        <th>Llantas sin facturar</th>
                        <th colspan="2">Total facutrado:</th>
                    </tr>
                    <tr>
                        <td>{{ html.countOS }}</td>
                        <td>{{ getTotalData(4) }}</td>
                        <td>{{ getTotalData(5) }}</td>
                        <td colspan="2">{{ html.total }}</td>
                    </tr>
                </table>
            </center>
            <!--<div class="col-sm-12 col-md-12 col-lg-12 panel panel-default">
                <div class="panel-body">
                    <div class="col-sm-12 col-md-3 col-lg-3" style="padding: 2px;">
                        <span class="text text-dark">Llantas filtradas: </span><span class="text text-muted">{{ objetos.length }}</span>
                    </div>
                    <div class="col-sm-12 col-md-3 col-lg-3" style="padding: 2px;">
                        <span class="text text-dark">Llantas reencauchadas exitosamente: </span><span class="text text-muted">{{ getTotalData(0) }}</span>
                    </div>
                    <div class="col-sm-12 col-md-3 col-lg-3" style="padding: 2px;">
                        <span class="text text-dark">Llantas reencauchadas rechazadas: </span><span class="text text-muted">{{ getTotalData(1) }}</span>
                    </div>
                    <div class="col-sm-12 col-md-3 col-lg-3" style="padding: 2px;">
                        <span class="text text-dark">Llantas en proceso de reencauche: </span><span class="text text-muted">{{ getTotalData(3) }}</span>
                    </div>
                    <div class="col-sm-12 col-md-3 col-lg-3" style="padding: 2px;">
                        <span class="text text-dark">Llantas sin reencauchar: </span><span class="text text-muted">{{ getTotalData(2) }}</span>
                    </div>
                    <div class="col-sm-12 col-md-3 col-lg-3" style="padding: 2px;">
                        <span class="text text-dark">N° Ordenes de servicio: </span><span class="text text-muted">{{ html.countOS }}</span>
                    </div>
                    <div class="col-sm-12 col-md-3 col-lg-3" style="padding: 2px;">
                        <span class="text text-dark">Llantas facturadas: </span><span class="text text-muted">{{ getTotalData(4) }}</span>
                    </div>
                    <div class="col-sm-12 col-md-3 col-lg-3" style="padding: 2px;">
                        <span class="text text-dark">Llantas sin facturar: </span><span class="text text-muted">{{ getTotalData(5) }}</span>
                    </div>
                </div>
            </div>-->
            <!--END RESUMEN-->
            <div class="row col-md-12" id="paddinTop10">&nbsp;</div>
            <div class="row col-md-12">
                <div class="col-md-2">
                    <div class="form-group-sm">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group-sm">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="col-md-12 form-group-sm">
                        <div class="col-md-12 form-group-sm">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                <input class="mdl-textfield__input" id="buscar" name="buscar" ng-model="buscar">
                                <span class="mdl-textfield__label" for="buscar"><span class="fa fa-search"></span> Buscar en el informe</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-2">
                    <!--<button class="btn btn-success" type="button" id="cargarLista" ng-click="cargarDatos(<?=$_GET['idPT']?>)">Actualizar lista</button>-->
                </div>
                <div class="col-md-1">
                </div>
            </div>
            <div class="row col-md-12" id="paddinTop20" ng-show="html.spinnerCarga">
                <div class="mdl-spinner mdl-js-spinner is-active"></div>
            </div>
            <div class="row" id="paddinTop20" ng-show="objetos">
                <center>
                    <div class="col-md-0"></div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="mdl-data-table mdl-js-data-table" id="dataBodegaTable">
                                <thead>
                                    <tr>
                                        <th class="mdl-data-table__cell--non-numeric" ng-click="orden='servicio[0].os'">ORDEN</th>
                                        <th ng-click="orden='rp'">RP</th>
                                        <th ng-click="orden='clienteName'">CLIENTE</th>
                                        <th ng-click="orden='nombreMarca'">MARCA</th>
                                        <th ng-click="orden='dimension'">DIMENSION</th>
                                        <th ng-click="orden='referenciaSolicitada[0].referencia'">DIS.SOLI</th>
                                        <th ng-click="orden='medidas.anchobanda'">ANCHO</th>
                                        <th ng-click="orden='pesoBanda'">PESO</th>
                                        <th ng-click="orden='dataSalida[0].valor'">PRECIO</th>
                                        <th ng-click="orden='nombreUrgente'">URGENTE</th>
                                        <th ng-click="orden='nombreEstado'">ESTADO</th>
                                        <th ng-click="orden='fechaRegistro'">FECHA REGISTRO</th>
                                        <th ng-click="orden='fechaFinServicio'">FIN RENCAUCHE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="objeto in objetos | filter: buscar | orderBy: orden as result" style="background: {{ objeto.colorFila }}">
                                        <td class="mdl-data-table__cell--non-numeric">{{ objeto.servicio[0].os }}-{{ objeto.consecutivo }}</td>
                                        <td>{{ objeto.rp }}</td>
                                        <td>{{ objeto.clienteName }}</td>
                                        <td>{{ objeto.nombreMarca }}</td>
                                        <td>{{ objeto.dimension }}</td>
                                        <td>{{ objeto.referenciaSolicitada[0].referencia }}</td>
                                        <td>
                                            <span ng-show="objeto.medidas.status">{{ objeto.medidas.anchobanda }}</span>
                                            <span ng-show="!objeto.medidas.status" ><span ng-bind="objeto.medidas.nameEstado"></span></span>
                                        </td>
                                        <td>{{ objeto.pesoBanda }}</td>
                                        <td>
                                            <!--<span class="hide" ng-if="setTotal(objeto.dataSalida[0].valor)"></span>-->
                                            <span ng-show="objeto.dataSalida[0].valor!=null">{{ objeto.dataSalida[0].valor }}</span>
                                            <span ng-show="objeto.dataSalida[0].valor==null">Pendiente</span>
                                        </td>
                                        <td>{{ objeto.nombreUrgente }}</td>
                                        <td>{{ objeto.nombreEstado }}</td>
                                        <td>{{ objeto.fechaRegistro }}</td>
                                        <td>{{ objeto.fechaFinServicio }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="7"></td>
                                        <td colspan="2">{{ html.total }}</td>
                                        <td colspan="4"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-0"></div>
                </center>
            </div>
        </div>
        <div class='modal fade' id='_frmFiltros'>
            <div class='modal-dialog modal-lg'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <button type='button' class='close' data-dismiss='modal'>&times;</button>
                        <h3 class="text text-primary">Filtros</h3>
                    </div>
                    <div class='modal-header'>
                        <form name="frmFiltros" id="frmFiltros">
                            <!--FECHAS RECOLECCION-->
                            <div class="col-sm-12 col-lg-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"></span>
                                        <span class="input-group-addon">
                                            <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="chkFechas">
                                                <input type="checkbox" id="chkFechas" class="mdl-checkbox__input" name="chkFechas" ng-model="html.chkFechas" ng-change="validarFechaInicio();validarFechaFin();validarFiltros()">
                                                <span class="mdl-checkbox__label">
                                                    <i ng-show="!html.chkFechas" class="fa fa-calendar"></i>
                                                    <i ng-show="html.chkFechas" class="fa fa-calendar-check-o"></i> FECHAS DE RECOLECCI&Oacute;N:
                                                </span>
                                            </label>
                                        </span>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar-plus-o"> Fecha inicio:</i>
                                        </span>
                                        <input class="form-control" id="txtFechaInicio" type="date" name="fechaInicio" ng-model="html.txtFechaInicio" ng-disabled="!html.chkFechas" ng-change="validarFechaInicio();">
                                    </div>
                                    <div class="alert alert-danger" ng-show="html.chkFechas && html.txtFechaInicio==null">Este campo no puede estar vacio</div>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar-times-o"> Fecha fin:</i>
                                        </span>
                                        <input class="form-control" id="txtFechaFin" type="date" name="fechaFin" ng-model="html.txtFechaFin" ng-disabled="!html.chkFechas">
                                    </div>
                                    <div class="alert alert-danger" ng-show="html.chkFechas && html.txtFechaFin==null">Este campo no puede estar vacio</div>
                                </div>
                            </div>
                            <!--FIN FECHAS RECOLECCION-->
                            <!--FECHA SALIDA RENCAUCHE 2018-09-21 12:58-->
                            <div class="col-sm-12 col-lg-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"></span>
                                        <span class="input-group-addon">
                                            <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="chkFechasSalida">
                                                <input type="checkbox" id="chkFechasSalida" class="mdl-checkbox__input" name="chkFechasSalida" ng-model="html.chkFechasSalida" ng-change="validarFecha(html.txtFechaInicioSalida);validarFecha(html.txtFechaFinSalida);validarFiltros()">
                                                <span class="mdl-checkbox__label">
                                                    <i ng-show="!html.chkFechasSalida" class="fa fa-calendar"></i>
                                                    <i ng-show="html.chkFechasSalida" class="fa fa-calendar-check-o"></i> FECHAS FIN RENCAUCHE:
                                                </span>
                                            </label>
                                        </span>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar-plus-o"> Fecha inicio:</i>
                                        </span>
                                        <input class="form-control" id="txtFechaInicioSalida" type="date" name="fechaInicioSalida" ng-model="html.txtFechaInicioSalida" ng-disabled="!html.chkFechasSalida" ng-change="validarFecha(html.txtFechaInicioSalida);">
                                    </div>
                                    <div class="alert alert-danger" ng-show="html.chkFechasSalida && html.txtFechaInicioSalida==null">Este campo no puede estar vacio</div>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar-times-o"> Fecha fin:</i>
                                        </span>
                                        <input class="form-control" id="txtFechaFinSalida" type="date" name="fechaFinSalida" ng-model="html.txtFechaFinSalida" ng-disabled="!html.chkFechasSalida">
                                    </div>
                                    <div class="alert alert-danger" ng-show="html.chkFechasSalida && html.txtFechaFinSalida==null">Este campo no puede estar vacio</div>
                                </div>
                            </div>
                            <!--END FECHA SALIDA RENCAUCHE 2018-09-21 12:59-->
                            <!--TAMANOS-->
                            <div class="col-sm-12 col-lg-6 hide">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"></span>
                                        <span class="input-group-addon">
                                            <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="chkTamanos">
                                                <input type="checkbox" id="chkTamanos" class="mdl-checkbox__input" name="chkTamanos" ng-model="html.chkTamanos" ng-change="validarFiltros();">
                                                <span class="mdl-checkbox__label">
                                                    <i ng-show="!html.chkTamanos" class="fa fa-level-down"></i>
                                                    <i ng-show="html.chkTamanos" class="fa fa-level-up"></i> Tamaño:
                                                </span>
                                            </label>
                                        </span>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-arrow-up"> Grande:</i>
                                        </span>
                                        <span class="input-group-addon">
                                            <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="rbtLlantaGrande">
                                                <input type="radio" id="rbtLlantaGrande" class="mdl-radio__button" name="rbtTamano" value="0" ng-model="html.rbtTamano" ng-disabled="!html.chkTamanos">
                                                <!--<span class="mdl-radio__label">First</span>-->
                                            </label>
                                        </span>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-arrow-down"> Pequeña:</i>
                                        </span>
                                        <span class="input-group-addon">
                                            <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="rbtLlantaPequena">
                                                <input type="radio" id="rbtLlantaPequena" class="mdl-radio__button" name="rbtTamano" value="1" ng-model="html.rbtTamano" ng-disabled="!html.chkTamanos">
                                                <!--<span class="mdl-radio__label">First</span>-->
                                            </label>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!--FIN TAMANOS-->
                            <!--ESTADOS-->
                            <div class="col-sm-12 col-lg-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"></span>
                                        <span class="input-group-addon">
                                            <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="chkEstados">
                                                <input type="checkbox" id="chkEstados" class="mdl-checkbox__input" name="chkEstados" ng-model="html.chkEstados" ng-change="validarFiltros();">
                                                <span class="mdl-checkbox__label">
                                                    <i ng-show="!html.chkEstados" class="fa fa-times"></i>
                                                    <i ng-show="html.chkEstados" class="fa fa-check"></i> ESTADOS:
                                                </span>
                                            </label>
                                        </span>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-trash-o"> Rechazados:</i>
                                        </span>
                                        <span class="input-group-addon">
                                            <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="rbtRechazados">
                                                <input type="radio" id="rbtRechazados" class="mdl-radio__button" name="rbtEstado" value="0" ng-model="html.rbtEstado" ng-disabled="!html.chkEstados">
                                                <!--<span class="mdl-radio__label">First</span>-->
                                            </label>
                                        </span>
                                        <span class="input-group-addon">
                                            <i class="fa fa-upload"> Rencauchando:</i>
                                        </span>
                                        <span class="input-group-addon">
                                            <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="rbtRencauche">
                                                <input type="radio" id="rbtRencauche" class="mdl-radio__button" name="rbtEstado" value="1" ng-model="html.rbtEstado" ng-disabled="!html.chkEstados">
                                                <!--<span class="mdl-radio__label">First</span>-->
                                            </label>
                                        </span>
                                        <span class="input-group-addon">
                                            <i class="fa fa-check-square"> Procesado:</i>
                                        </span>
                                        <span class="input-group-addon">
                                            <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="rbtProcesado">
                                                <input type="radio" id="rbtProcesado" class="mdl-radio__button" name="rbtEstado" value="2" ng-model="html.rbtEstado" ng-disabled="!html.chkEstados">
                                                <!--<span class="mdl-radio__label">First</span>-->
                                            </label>
                                        </span>
                                        <span class="input-group-addon">
                                            <i class="fa fa-check-square"> Sin procesar:</i>
                                        </span>
                                        <span class="input-group-addon">
                                            <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="rbtSinProcesar">
                                                <input type="radio" id="rbtSinProcesar" class="mdl-radio__button" name="rbtEstado" value="3" ng-model="html.rbtEstado" ng-disabled="!html.chkEstados">
                                                <!--<span class="mdl-radio__label">First</span>-->
                                            </label>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!--FIN ESTADOS-->
                            <!--SALIDA-->
                            <div class="col-sm-12 col-lg-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"></span>
                                        <span class="input-group-addon">
                                            <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="chkFechasFacturacion">
                                                <input type="checkbox" id="chkFechasFacturacion" class="mdl-checkbox__input" name="chkFechasFacturacion" ng-model="html.chkFechasFacturacion" ng-change="validarFiltros()">
                                                <span class="mdl-checkbox__label">
                                                    <i ng-show="!html.chkFechas" class="fa fa-calendar"></i>
                                                    <i ng-show="html.chkFechas" class="fa fa-calendar-check-o"></i> FECHAS DE FACTURACI&Oacute;N:
                                                </span>
                                            </label>
                                        </span>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar-plus-o"> Fecha inicio:</i>
                                        </span>
                                        <input class="form-control" id="txtFechaInicioFacturacion" type="date" name="fechaInicioFacturacion" ng-model="html.txtFechaInicioFacturacion" ng-disabled="!html.chkFechasFacturacion" ng-change="">
                                    </div>
                                    <div class="alert alert-danger" ng-show="html.chkFechasFacturacion && html.txtFechaInicioFacturacion==null">Este campo no puede estar vacio</div>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar-times-o"> Fecha fin:</i>
                                        </span>
                                        <input class="form-control" id="txtFechaFinFacturacion" type="date" name="fechaFinFacturacion" ng-model="html.txtFechaFinFacturacion" ng-disabled="!html.chkFechasFacturacion">
                                    </div>
                                    <div class="alert alert-danger" ng-show="html.chkFechasFacturacion && html.txtFechaFinFacturacion==null">Este campo no puede estar vacio</div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"></span>
                                        <span class="input-group-addon">
                                            <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="chkEstadosFacturacion">
                                                <input type="checkbox" id="chkEstadosFacturacion" class="mdl-checkbox__input" name="chkEstadosFacturacion" ng-model="html.chkEstadosFacturacion" ng-change="validarFiltros();">
                                                <span class="mdl-checkbox__label">
                                                    <i ng-show="!html.chkEstadosFacturacion" class="fa fa-calendar"></i>
                                                    <i ng-show="html.chkEstadosFacturacion" class="fa fa-calendar-check-o"></i> ESTADOS SALIDA (FACTURACI&Oacute;N):
                                                </span>
                                            </label>
                                        </span>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-save"> Registrada:</i>
                                        </span>
                                        <span class="input-group-addon">
                                            <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="rbtFacturacionRegistrada">
                                                <input type="radio" id="rbtFacturacionRegistrada" class="mdl-radio__button" name="rbtStatusFacturacion" value="0" ng-model="html.rbtEstadoFacturacion" ng-disabled="!html.chkEstadosFacturacion">
                                                <!--<span class="mdl-radio__label">First</span>-->
                                            </label>
                                        </span>
                                        <span class="input-group-addon">
                                            <i class="fa fa-times-circle"> No registrada:</i>
                                        </span>
                                        <span class="input-group-addon">
                                            <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="rbtFacturacionNoRegistrada">
                                                <input type="radio" id="rbtFacturacionNoRegistrada" class="mdl-radio__button" name="rbtStatusFacturacion" value="1" ng-model="html.rbtEstadoFacturacion" ng-disabled="!html.chkEstadosFacturacion">
                                                <!--<span class="mdl-radio__label">First</span>-->
                                            </label>
                                        </span>
                                        <span class="input-group-addon">
                                            <i class="fa fa-save"></i>
                                            <i class="fa fa-times-circle"> Ambos:</i>
                                        </span>
                                        <span class="input-group-addon">
                                            <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="rbtAmbosFacturacion">
                                                <input type="radio" id="rbtAmbosFacturacion" class="mdl-radio__button" name="rbtStatusFacturacion" value="2" ng-model="html.rbtEstadoFacturacion" ng-disabled="!html.chkEstadosFacturacion">
                                                <!--<span class="mdl-radio__label">First</span>-->
                                            </label>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!--FIN SALIDA-->
                            <!--VENDEDOR-->
                            <div class="col-sm-12 col-lg-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"></span>
                                        <span class="input-group-addon">
                                            <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="chkVendedor">
                                                <input type="checkbox" id="chkVendedor" class="mdl-checkbox__input" name="chkVendedor" ng-model="html.chkVendedor" ng-change="validarFiltros();">
                                                <span class="mdl-checkbox__label">
                                                    <i ng-show="!html.chkVendedor" class="fa fa-user"></i>
                                                    <i ng-show="html.chkVendedor" class="fa fa-user-circle"></i> VENDEDOR:
                                                </span>
                                            </label>
                                        </span>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-list-ol"> NOMBRES/IDENTIFICAC&Iacute;ON:</i>
                                        </span>
                                        <input class="form-control" id="txtVendedor" type="text" name="txtVendedor" ng-model="html.txtVendedor" ng-disabled="!html.chkVendedor" ng-change="autocompleteVendedores();" autocomplete="off">
                                    </div>
                                    <div class="alert alert-danger" ng-show="html.chkVendedor && html.txtVendedor==null">Este campo no puede estar vacio</div>
                                </div>
                                <div>
                                    <!--style="#liAutocompleteVendedores{cursor: pointer;};#liAutocompleteVendedores:hover{background-color:  #f9f9f9;}"-->
                                    <div class="list-group" ng-hide="dataPage.hideAutocompleteDimensiones" style="max-block-size: 174px; overflow-y: auto;">
                                        <div id="liAutocompleteVendedores" class="list-group-item" ng-repeat="data in dataPage.objects.vendedoresFilter" ng-click="setFieldVendedor(data)">
                                            <strong class="list-group-item-heading">{{ data.identificacion }}</strong>
                                            <p class="list-group-item-text">{{ data.nombrescompletos }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--FIN VENDEDOR-->
                            <!--OS-->
                            <div class="col-sm-12 col-lg-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"></span>
                                        <span class="input-group-addon">
                                            <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="chkOs">
                                                <input type="checkbox" id="chkOs" class="mdl-checkbox__input" name="chkOs" ng-model="html.chkOs" ng-change="validarFiltros();">
                                                <span class="mdl-checkbox__label">
                                                    <i ng-show="!html.chkOs" class="fa fa-gear"></i>
                                                    <i ng-show="html.chkOs" class="fa fa-gears"></i> ORDEN DE SERVICIO:
                                                </span>
                                            </label>
                                        </span>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-list-ol"> Numero:</i>
                                        </span>
                                        <input class="form-control" id="txtNumeroOs" type="number" name="numeroOs" min="0" ng-model="html.numeroOs" ng-disabled="!html.chkOs" ng-change="validarNumeroOs();">
                                    </div>
                                    <div class="alert alert-danger" ng-show="html.chkOs && html.numeroOs==null">Este campo no puede estar vacio</div>
                                </div>
                            </div>
                            <!--FIN OS-->
                            <!--URGENTES-->
                            <div class="col-sm-12 col-lg-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon"></span>
                                        <span class="input-group-addon">
                                            <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="chkUrgentes">
                                                <input type="checkbox" id="chkUrgentes" class="mdl-checkbox__input" name="chkUrgentes" ng-model="html.chkUrgentes" ng-change="validarFiltros();">
                                                <span class="mdl-checkbox__label">
                                                    <i ng-show="!html.chkUrgentes" class="fa fa-info"></i>
                                                    <i ng-show="html.chkUrgentes" class="fa fa-info-circle"></i> URGENTES:
                                                </span>
                                            </label>
                                        </span>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-check"> Si:</i>
                                        </span>
                                        <span class="input-group-addon">
                                            <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="rbtUrgenteSi">
                                                <input type="radio" id="rbtUrgenteSi" class="mdl-radio__button" name="rbtUrgente" value="0" ng-model="html.rbtUrgente" ng-disabled="!html.chkUrgentes">
                                                <!--<span class="mdl-radio__label">First</span>-->
                                            </label>
                                        </span>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-times"> No:</i>
                                        </span>
                                        <span class="input-group-addon">
                                            <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="rbtUrgenteNo">
                                                <input type="radio" id="rbtUrgenteNo" class="mdl-radio__button" name="rbtUrgente" value="1" ng-model="html.rbtUrgente" ng-disabled="!html.chkUrgentes">
                                                <!--<span class="mdl-radio__label">First</span>-->
                                            </label>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!--FIN URGENTES-->
                        </form>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-danger' data-dismiss='modal' >Cancelar</button>
                        <button type='button' class='btn btn-success' ng-disabled="html.btnGenerar" ng-click="generarInforme()" data-dismiss='modal'>Generar</button>
                    </div>
                </div>
            </div>
            <div id="toast-dialog" class="mdl-js-snackbar mdl-snackbar">
                <div class="mdl-snackbar__text"></div>
                <button class="mdl-snackbar__action" type="button"></button>
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
                                        <input class="form-control" type="text" id="txtFileNameExel" name="txtFileNameExel" ng-model="txtFileNameExel" required>
                                    </div>
                                    <div class="alert alert-danger" ng-show="txtFileNameExel==null">Este campo no puede estar vacio</div>
                                    <div class="alert alert-danger" ng-show="result<=0">No se puede exportar un archivo sin datos</div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btn2CloseDlgFileNameExel" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored mdl-color--red" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored mdl-color--green" ng-disabled="txtFileNameExel==null || result<=0">EXPORTAR</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="toast-content" class="mdl-js-snackbar mdl-snackbar">
      <div class="mdl-snackbar__text"></div>
      <button class="mdl-snackbar__action" type="button"></button>
    </div>
</div>
<script>
    $(document).ready(function(){
        $("#cargarLista").click();
    });
    
    $("#btnRegresar").click(function (){
        window.location="principal.php?CON=system/Pages/puestosTrabajo.php";
    });
</script>