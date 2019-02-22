panamApp.controller('informeRencauche', function ($scope, configuracionGlobal, $http, $location, $sessionStorage){
    
    $(document).ready(function (){
        $sessionStorage.dataInformeRencauche=null;
        $sessionStorage.configuracionInformeRencauche={
            textual: $scope.html.chkInformeTextual,
            fotografico: $scope.html.chkInformeRegistrosFotograficos,
            estadistica: $scope.html.chkInformeDataGrafica,
            valido: $scope.setConfiguracionInforme()
        }
        $("#rbtListaSeleccion").click();
        $("#chkOs").click();
    });
    
    $scope.html={
        spinnerCarga: false,
        progressBarDialog: false,
        btnGenerar: true,
        chkOs: true,
        rbtBusquedaLlanta: 0,
        spnLlantas: true,
        filtro: '',
        numeroOs: null,
        numeroRp: null,
        numeroSerie: null,
        spnLlanta: null,
        rbtListaSeleccion: false,
        rbtRP: false,
        chkInformeTextual: true,
        chkInformeRegistrosFotograficos: false,
        chkInformeDataGrafica: false,
        bodyInforme: false,
        datosInforme: false,
        fotosInforme: false,
        graficaInforme: false,
    }
    
    $scope.llantas=null;
    
    $scope.inspeccionInicial=null;
    $scope.raspado=null;
    $scope.preparacion=null;
    $scope.reparacion=null;
    $scope.cementado=null;
    $scope.relleno=null;
    $scope.corteBanda=null;
    $scope.embandado=null;
    $scope.vulcanizado=null;
    $scope.inspeccionFinal=null;
    $scope.terminacion=null;
    
    $scope.dataInforme=null;
    
    $scope.setFiltro=function (_filtro){
        $scope.html.filtro=_filtro;
    }
    
    $scope.validarFiltros=function () {
        var valido=true;
        if (!$scope.html.chkOs && $scope.html.rbtBusquedaLlanta<1){
            $scope.html.btnGenerar=true;
            showToastDialog(true, "Debes seleccionar como minimo un tipo de busqueda", "toast-dialog");
            valido=false;
        }
        return valido;
    }
    
    $scope.setCheckedOS=function () {
        if ($scope.html.chkOs){
            $scope.html.rbtRP=false;
            $scope.html.rbtListaSeleccion=true;
            $scope.html.rbtBusquedaLlanta=0;
            $("#rbtListaSeleccion").click();
            if (validarInput($scope.html.numeroOs)){
                if ($scope.llantas!=null && $scope.llantas.length>0){
                    if ($scope.html.spnLlanta!=null){
                        $("#spnLlantas").click();
                        $scope.html.btnGenerar=false;
                    } else {
                        $("#spnLlantas").click();
                        $scope.html.btnGenerar=true;
                    }
                } else $scope.html.btnGenerar=true;
            } else {
                $scope.html.btnGenerar=true;
                $scope.html.spnLlantas=true;
            }
        } else {
            $scope.html.rbtListaSeleccion=false;
            $scope.html.rbtBusquedaLlanta=1;
            $scope.html.rbtRP=true;
            $("#rbtRp").click();
        }
    }
    
    $scope.cargarLlantasOs=function () {
        if (validarInput($scope.html.numeroOs)){
            $scope.html.progressBarDialog=true;
            $http({
                url: configuracionGlobal.scripts + "/listadosJSON.php",
                method: 'GET',
                params: {
                    metodo: 'getLlantasOSInformeRencauche',
                    os: $scope.html.numeroOs
                }
            }).success(function (r) {
                console.log(r);
                $scope.html.progressBarDialog=false;
                if (r!=null){
                    if (r.length>0){
                        $scope.llantas=r;
                        $scope.html.spnLlantas=false;
                        showToastDialog(true, r.length + " llantas cargadas", "toast-dialog");
                        //$scope.cargarSpnListaLlantas();
                    } else {
                        $scope.llantas=null;
                        $scope.html.spnLlantas=true;
                        showToastDialog(true, "La orden de servicio N° " + $scope.html.numeroOs + " no existe o no tiene llantas registradas.", "toast-dialog");
                    }
                } else {
                    $scope.llantas=null;
                    $scope.html.spnLlantas=true;
                    showToastDialog(true, "Resultado desconocido", "toast-dialog");
                }
            }).error(function (r) {
                $scope.html.progressBarDialog=false;
                $scope.llantas=null;
                $scope.html.spnLlantas=true;
                showToastDialog(true, "Ocurrio un error al conectar con el servidor o el archivo", "toast-dialog");
                $scope.html.chkOs=false;
            });
        } else {
            showToastDialog(true, "Dijita el numero de la orden de servicio para cargar sus registros", "toast-dialog");
            $("#txtNumeroOs").focus=true;
        }
    }
    
    $scope.activarBtnGenerar=function () {
        if ($scope.validarFiltros() && !$scope.html.chkOs){
            if ($scope.html.rbtBusquedaLlanta==1) {
                if (validarInput($scope.html.numeroRp)) $scope.html.btnGenerar=false;
                else  $scope.html.btnGenerar=true;
            } else if ($scope.html.rbtBusquedaLlanta==2){
                if (validarInput($scope.html.numeroSerie))  $scope.html.btnGenerar=false;
                else  $scope.html.btnGenerar=true;
            }
        }
    }
    
    $scope.setLlanta=function () {
        if ($scope.html.chkOs && validarInput($scope.html.spnLlanta)){
            $scope.html.btnGenerar=false;
        } else {
            $scope.html.btnGenerar=true;
        }
    }
    
    $scope.setConfiguracionInforme=function () {
        var valid=false;
        if (!$scope.html.chkInformeTextual && !$scope.html.chkInformeRegistrosFotograficos && !$scope.html.chkInformeDataGrafica){
            showToastDialog(true, "Debes marcar alguna configuracion para generar el informe", "toast-dialog");
            showToastDialog(true, "Debes marcar alguna configuracion para generar el informe", "toast-principal");
        } else {
            valid=true;
        }
        $sessionStorage.configuracionInformeRencauche={
            textual: $scope.html.chkInformeTextual,
            fotografico: $scope.html.chkInformeRegistrosFotograficos,
            estadistica: $scope.html.chkInformeDataGrafica,
            valido: valid
        }
        return valid;
    }
    
    $scope.generarInforme=function () {
        var valid=false;
        $sessionStorage.dataInformeRencauche=null;
        if ($scope.setConfiguracionInforme()){
            if ($scope.html.chkOs){
                if (validarInput($scope.html.numeroOs) && $scope.llantas.length>0 && $scope.html.spnLlanta!=null){
                    if (validarInput($scope.html.spnLlanta.idLlanta)){
                        valid=true;
                        $scope.html.filtro=" ll.id=" + $scope.html.spnLlanta.idLlanta;
                    }
                }
            } else {
                if ($scope.html.rbtBusquedaLlanta==1 && validarInput($scope.html.numeroRp)){
                    valid=true;
                    $scope.html.filtro=" rp=" + $scope.html.numeroRp;
                } else if ($scope.html.rbtBusquedaLlanta==2) {
                    valid=true;
                    $scope.html.filtro=" serie=" + $scope.html.numeroSerie;
                }

            }
            if (valid && validarInput($scope.html.filtro)){
                $scope.html.spinnerCarga=true;
                $scope.html.bodyInforme=false;
                $scope.vaciarProcesos(11);
                $scope.dataInforme=null;
                chartData=null;
                $http({
                    url: configuracionGlobal.scripts + "/datosJSON.php",
                    method: 'GET',
                    params: {
                        metodo: 'getInformeRencauche',
                        filtro: $scope.html.filtro
                    }
                }).success(function (r) {
                    $scope.html.spinnerCarga=false;
                    console.log(r);
                    if (r!=null){
                        if (r.idOs!=null){
                            $scope.dataInforme=r;
                            $sessionStorage.dataInformeRencauche=r;
                            chartData=$scope.dataInforme.tiemposProcesos;
                            $scope.html.bodyInforme=true;
                            $scope.separarProcesos(true);
                            cargarGrafico();
                            showToastDialog(true, "Datos cargados exitosamente", "toast-principal");
                        } else {
                            $scope.dataInforme=null;
                            $scope.html.bodyInforme=false;
                            $scope.separarProcesos(false);
                            showToastDialog(true, "No se cargo ningun registro", "toast-principal");
                        }
                    } else {
                        $scope.html.bodyInforme=false;
                        $scope.dataInforme=null;
                        $scope.separarProcesos(false);
                        showToastDialog(true, "No se cargo ningun registro", "toast-principal");
                    }
                }).error(function (r) {
                    $scope.html.bodyInforme=false;
                    $scope.separarProcesos(false);
                    $scope.html.spinnerCarga=false;
                    showToastDialog(true, "No se pudo conectar al servidor y/o al archivo solicitado", "toast-principal");
                });
            } else {
                $scope.dataInforme=null;
                $scope.html.bodyInforme=false;
                $scope.separarProcesos(false);
                showToastDialog(true, "No se puede generar el informe, revisa los filtros", "toast-principal");
            }
        } else {
            showToastDialog(true, "No se puede generar el informe, revisa los filtros", "toast-principal");
            $scope.dataInforme=null;
            $scope.html.bodyInforme=false;
            $scope.separarProcesos(false);
        }
    }
    
    $scope.getEstadoOs=function (data){
        if (validarInput(data)){
            switch (data) {
                case 'c':
                    return 'Cerrada';
                    break;
                case 'o':
                    return 'Abierta';
                    break;
                case 'a':
                    return 'Anulada';
                    break;
                    
                default:
                    return 'Desconocido';
                    break;
            }
        }
    }
    
    $scope.getNombreCliente=function () {
        var nombre='';
        if ($scope.dataInforme!=null){
            if (validarInput($scope.dataInforme.nombresCliente)){
                if (validarInput($scope.dataInforme.razonSocial)){
                    nombre=$scope.dataInforme.nombresCliente + " (" + $scope.dataInforme.razonSocial + ")";
                } else nombre=$scope.dataInforme.nombresCliente;
            } else if (validarInput($scope.dataInforme.razonSocial)) nombre=$scope.dataInforme.razonSocial;
        }
        return nombre;
    }
    
    $scope.getUrgenteLlanta=function () {
        if ($scope.dataInforme!=null){
            if ($scope.dataInforme.llantaUrgente) return 'Si';
            else return 'No';
        } else return 'Valor desconcido';
    }
    
    $scope.getMedidaAplicacionEntregada=function () {
        var medida='Pendiente';
        if ($scope.dataInforme!=null){
            if ($scope.dataInforme.aplicacionEntregada[0].id!=null){
                var data=$scope.dataInforme.aplicacionEntregada[0];
                medida="B: " + data.base + " - PR: " + data.profundidad + " - PE: " + data.peso + " - LR: " + data.largo
            }
        }
        return medida;
    }

    $scope.separarProcesos=function (valido) {
        if (valido && $scope.dataInforme!=null){
            if ($scope.dataInforme.rencauche!=null && $scope.dataInforme.rencauche.procesos!=null){
                var procesos=$scope.dataInforme.rencauche.procesos[0];
                switch ($scope.dataInforme.rencauche.procesos.ultimo) {
                    case "InspeccionInicial":
                        $scope.inspeccionInicial=procesos;
                        $scope.vaciarProcesos(10);
                        break;
                    case "Raspado":
                        $scope.raspado=procesos;
                        $scope.inspeccionInicial=procesos.inspeccion[0];
                        $scope.vaciarProcesos(9);
                        break;
                    case "Preparacion":
                        $scope.preparacion=procesos;
                        $scope.raspado=procesos.raspado[0];
                        $scope.inspeccionInicial=$scope.raspado.inspeccion[0];
                        $scope.vaciarProcesos(8);
                        break;
                    case "Reparacion":
                        $scope.reparacion=procesos;
                        $scope.preparacion=procesos.preparacion[0];
                        $scope.raspado=$scope.preparacion.raspado[0];
                        $scope.inspeccionInicial=$scope.raspado.inspeccion[0];
                        $scope.vaciarProcesos(7);
                        break;
                    case "Cementado":
                        $scope.cementado=procesos;
                        $scope.reparacion=procesos.reparacion[0];
                        $scope.preparacion=$scope.reparacion.preparacion[0];
                        $scope.raspado=$scope.preparacion.raspado[0];
                        $scope.inspeccionInicial=$scope.raspado.inspeccion[0];
                        $scope.vaciarProcesos(6);
                        break;
                    case "Relleno":
                        $scope.relleno=procesos;
                        $scope.cementado=procesos.cementado[0];
                        $scope.reparacion=$scope.cementado.reparacion[0];
                        $scope.preparacion=$scope.reparacion.preparacion[0];
                        $scope.raspado=$scope.preparacion.raspado[0];
                        $scope.inspeccionInicial=$scope.raspado.inspeccion[0];
                        $scope.vaciarProcesos(5);
                        break;
                    case "CorteBanda":
                        $scope.corteBanda=procesos;
                        $scope.relleno=procesos.relleno[0];
                        $scope.cementado=$scope.relleno.cementado[0];
                        $scope.reparacion=$scope.cementado.reparacion[0];
                        $scope.preparacion=$scope.reparacion.preparacion[0];
                        $scope.raspado=$scope.preparacion.raspado[0];
                        $scope.inspeccionInicial=$scope.raspado.inspeccion[0];
                        $scope.vaciarProcesos(4);
                        break;
                    case "Embandado":
                        $scope.embandado=procesos;
                        $scope.corteBanda=procesos.corteBanda[0];
                        $scope.relleno=$scope.corteBanda.relleno[0];
                        $scope.cementado=$scope.relleno.cementado[0];
                        $scope.reparacion=$scope.cementado.reparacion[0];
                        $scope.preparacion=$scope.reparacion.preparacion[0];
                        $scope.raspado=$scope.preparacion.raspado[0];
                        $scope.inspeccionInicial=$scope.raspado.inspeccion[0];
                        $scope.vaciarProcesos(3);
                        break;
                    case "Vulcanizado":
                        $scope.vulcanizado=procesos;
                        $scope.embandado=procesos.embandado[0];
                        $scope.corteBanda=$scope.embandado.corteBanda[0];
                        $scope.relleno=$scope.corteBanda.relleno[0];
                        $scope.cementado=$scope.relleno.cementado[0];
                        $scope.reparacion=$scope.cementado.reparacion[0];
                        $scope.preparacion=$scope.reparacion.preparacion[0];
                        $scope.raspado=$scope.preparacion.raspado[0];
                        $scope.inspeccionInicial=$scope.raspado.inspeccion[0];
                        $scope.vaciarProcesos(2);
                        break;
                    case "InspeccionFinal":
                        $scope.inspeccionFinal=procesos;
                        $scope.vulcanizado=procesos.vulcanizado[0];
                        $scope.embandado=$scope.vulcanizado.embandado[0];
                        $scope.corteBanda=$scope.embandado.corteBanda[0];
                        $scope.relleno=$scope.corteBanda.relleno[0];
                        $scope.cementado=$scope.relleno.cementado[0];
                        $scope.reparacion=$scope.cementado.reparacion[0];
                        $scope.preparacion=$scope.reparacion.preparacion[0];
                        $scope.raspado=$scope.preparacion.raspado[0];
                        $scope.inspeccionInicial=$scope.raspado.inspeccion[0];
                        $scope.vaciarProcesos(1);
                        break;
                    case "Terminacion":
                        $scope.terminacion=procesos;
                        $scope.inspeccionFinal=procesos.inspeccionFinal[0];
                        $scope.vulcanizado=$scope.inspeccionFinal.vulcanizado[0];
                        $scope.embandado=$scope.vulcanizado.embandado[0];
                        $scope.corteBanda=$scope.embandado.corteBanda[0];
                        $scope.relleno=$scope.corteBanda.relleno[0];
                        $scope.cementado=$scope.relleno.cementado[0];
                        $scope.reparacion=$scope.cementado.reparacion[0];
                        $scope.preparacion=$scope.reparacion.preparacion[0];
                        $scope.raspado=$scope.preparacion.raspado[0];
                        $scope.inspeccionInicial=$scope.raspado.inspeccion[0];
                        break;
                        
                    default:
                        $scope.vaciarProcesos(11);
                        break;
                }
            }
        } else {
            $scope.vaciarProcesos(11);
        }
    }
    
    $scope.vaciarProcesos=function (cantidad) {
        switch (cantidad) {
            case 1:
                $scope.terminacion=null;
                break;
            case 2:
                $scope.inspeccionFinal=null;
                $scope.terminacion=null;
                break;
            case 3:
                $scope.vulcanizado=null;
                $scope.inspeccionFinal=null;
                $scope.terminacion=null;
                break;
            case 4:
                $scope.embandado=null;
                $scope.vulcanizado=null;
                $scope.inspeccionFinal=null;
                $scope.terminacion=null;
                break;
            case 5:
                $scope.corteBanda=null;
                $scope.embandado=null;
                $scope.vulcanizado=null;
                $scope.inspeccionFinal=null;
                $scope.terminacion=null;
                break;
            case 6:
                $scope.relleno=null;
                $scope.corteBanda=null;
                $scope.embandado=null;
                $scope.vulcanizado=null;
                $scope.inspeccionFinal=null;
                $scope.terminacion=null;
                break;
            case 7:
                $scope.cementado=null;
                $scope.relleno=null;
                $scope.corteBanda=null;
                $scope.embandado=null;
                $scope.vulcanizado=null;
                $scope.inspeccionFinal=null;
                $scope.terminacion=null;
                break;
            case 8:
                $scope.reparacion=null;
                $scope.cementado=null;
                $scope.relleno=null;
                $scope.corteBanda=null;
                $scope.embandado=null;
                $scope.vulcanizado=null;
                $scope.inspeccionFinal=null;
                $scope.terminacion=null;
                break;
            case 9:
                $scope.preparacion=null;
                $scope.reparacion=null;
                $scope.cementado=null;
                $scope.relleno=null;
                $scope.corteBanda=null;
                $scope.embandado=null;
                $scope.vulcanizado=null;
                $scope.inspeccionFinal=null;
                $scope.terminacion=null;
                break;
            case 10:
                $scope.raspado=null;
                $scope.preparacion=null;
                $scope.reparacion=null;
                $scope.cementado=null;
                $scope.relleno=null;
                $scope.corteBanda=null;
                $scope.embandado=null;
                $scope.vulcanizado=null;
                $scope.inspeccionFinal=null;
                $scope.terminacion=null;
                break;
            case 11:
                $scope.inspeccionInicial=null;
                $scope.raspado=null;
                $scope.preparacion=null;
                $scope.reparacion=null;
                $scope.cementado=null;
                $scope.relleno=null;
                $scope.corteBanda=null;
                $scope.embandado=null;
                $scope.vulcanizado=null;
                $scope.inspeccionFinal=null;
                $("img").src=null;
                $scope.terminacion=null;
                break;
                
            default:
                $scope.inspeccionInicial=null;
                $scope.raspado=null;
                $scope.preparacion=null;
                $scope.reparacion=null;
                $scope.cementado=null;
                $scope.relleno=null;
                $scope.corteBanda=null;
                $scope.embandado=null;
                $scope.vulcanizado=null;
                $scope.inspeccionFinal=null;
                $scope.terminacion=null;
                break;
        }
    }

    /*$scope.loadRechazos = function() {
        if ($scope.dataInforme!=null) {
            if ($scope.dataInforme.valorEstado==3) {
                $http({
                    url: configuracionGlobal.scripts + '/datosJSON.php',
                    method: 'GET',
                    params: {
                        metodo: 'getRechazosLlantaJSON',
                        idLlanta: $scope.dataInforme.idLlanta
                    }
                }).success(function (r) {
                    console.log(r);
                }).error(function () {
                    showToastPrincipal(true, 'Error al conectar con el servidor');
                });
            }
        }
    }*/

    /*
    $scope.generarInforme=function (){
        var filtro='';
        var aux='';
        if ($scope.html.chkFechas && $scope.validarFechaInicio() && $scope.validarFechaFin()){
            var fechaInicio=$scope.html.txtFechaInicio.getFullYear() + "-" + ($scope.html.txtFechaInicio.getMonth()+1) + "-" + $scope.html.txtFechaInicio.getDate();
            var fechaFin=$scope.html.txtFechaFin.getFullYear() + "-" + ($scope.html.txtFechaFin.getMonth()+1) + "-" + $scope.html.txtFechaFin.getDate();
            filtro="fechaRegistro between '" + fechaInicio + "' and '" + fechaFin + "' ";
            aux=' and ';
        }
        if ($scope.html.chkTamanos){
            if ($scope.html.rbtTamano==0) filtro+= aux + "idAplicacionOriginal in (select id from dimension_referencia where profundidad>=17.5)";
            else filtro+= aux + "idAplicacionOriginal in (select id from dimension_referencia where profundidad<17.5)";
            aux=' and ';
        }
        if ($scope.html.chkEstados){
            if ($scope.html.rbtEstado==0) filtro+= aux + $scope.filtros.filtroRechazadas;
            else if ($scope.html.rbtEstado==1) filtro+= aux + $scope.filtros.filtroEnRencauche;
            else if ($scope.html.rbtEstado==2) filtro+= aux + $scope.filtros.filtroRencauchadas;
            else filtro+= aux + $scope.filtros.filtroSinRencauche;
            aux=' and ';
        }
        if ($scope.html.chkUrgentes){
            if ($scope.html.rbtUrgente==0) filtro+=aux + " urgente='t'";
            else filtro+=aux + " urgente='f'";
            aux=' and ';
        }
        if ($scope.html.chkOs && $scope.validarNumeroOs()){
            filtro+=aux + " idServicio in (select id from servicio where os='" + $scope.html.numeroOs + "')";
            aux=' and ';
        }
        $scope.html.filtro=filtro;
        $scope.cargarListaDefault(filtro, '');
    }*/
    
    $scope.imprimirInforme=function (){
        window.open(configuracionGlobal.templatesPrint + "/informeRencaucheImprimir.php", null, 'toolbar=no, directories=no, width=1000, height=200, resizable=no, left=50, top=150');
        //window.open(configuracionGlobal.templatesPrint + "/informeRencaucheImprimir.php", null, null);
    }
});
//GRAFICO
//
var chart;

var chartData = [];

function cargarGrafico (){
        AmCharts;
//        
//    })
//    AmCharts.ready(function () {
        // SERIAL CHART
        chart = new AmCharts.AmSerialChart();
        chart.dataProvider = chartData;
        chart.categoryField = "proceso";
        // the following two lines makes chart 3D
        chart.depth3D = 20;
        chart.angle = 30;

        // AXES
        // category
        var categoryAxis = chart.categoryAxis;
        categoryAxis.labelRotation = 90;
        categoryAxis.dashLength = 5;
        categoryAxis.gridPosition = "start";

        // value
        var valueAxis = new AmCharts.ValueAxis();
        valueAxis.title = "Tiempo empleado en cada proceso (Minutos)";
        valueAxis.dashLength = 5;
        chart.addValueAxis(valueAxis);

        // GRAPH
        var graph = new AmCharts.AmGraph();
        graph.valueField = "tiempo";
        graph.colorField = "color";
        graph.balloonText = "<span style='font-size:14px'>[[category]]: <b>[[value]]</b> minutos</span>";
        graph.type = "column";
        graph.lineAlpha = 0;
        graph.fillAlphas = 1;
        chart.addGraph(graph);

        // CURSOR
        var chartCursor = new AmCharts.ChartCursor();
        chartCursor.cursorAlpha = 0;
        chartCursor.zoomable = false;
        chartCursor.categoryBalloonEnabled = false;
        chart.addChartCursor(chartCursor);

        chart.creditsPosition = "top-right";


        // WRITE
        chart.write("chartdiv");
//    });
}

//
//FIN GRAFICO