panamApp.controller('informeRencaucheImprimir', function ($scope, configuracionGlobal, $http, $location, $sessionStorage){

    $(document).ready(function (){
        /*$scope.html.filtro=window.opener.txtFiltro.value;
        if (window.opener.viewT.value=="true") $scope.html.chkInformeTextual=true;
        else if (window.opener.viewT.value=="false") $scope.html.chkInformeTextual=false;
        if (window.opener.viewP.value=="true") $scope.html.chkInformeRegistrosFotograficos=true;
        else if (window.opener.viewP.value=="false") $scope.html.chkInformeRegistrosFotograficos=false;
        if (window.opener.viewG.value=="true") $scope.html.chkInformeDataGrafica=true;
        else if (window.opener.viewG.value=="false") $scope.html.chkInformeDataGrafica=false;*/
        //$scope.generarInforme();
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
        chkInformeTextual: false,
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

    $scope.setConfiguracionInforme=function () {
        var valid=false;
        if (!$scope.html.chkInformeTextual && !$scope.html.chkInformeRegistrosFotograficos && !$scope.html.chkInformeDataGrafica){
            showToastDialog(true, "Debes marcar alguna configuracion para generar el informe", "toast-principal");
        } else {
            valid=true;
        }
        return valid;
    }

    $scope.generarInforme=function () {
        $scope.html.spinnerCarga=false;
        $scope.dataInforme=$sessionStorage.dataInformeRencauche;
        chartData=$scope.dataInforme.tiemposProcesos;
        $scope.html.bodyInforme=true;
        $scope.separarProcesos(true);
        cargarGrafico();
        /*
        if ($scope.setConfiguracionInforme()){
            if (validarInput($scope.html.filtro)){
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
                            chartData=$scope.dataInforme.tiemposProcesos;
                            $scope.html.bodyInforme=true;
                            $scope.separarProcesos(true);
                            cargarGrafico();
                            //showToastDialog(true, "Datos cargados exitosamente", "toast-principal");
                            window.setTimeout(function(){
                                window.print();
                            }, 1500);
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
        }*/
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

    console.log($sessionStorage);

    $scope.html.chkInformeTextual=$sessionStorage.configuracionInformeRencauche.textual;
    $scope.html.chkInformeRegistrosFotograficos=$sessionStorage.configuracionInformeRencauche.fotografico;
    $scope.html.chkInformeDataGrafica=$sessionStorage.configuracionInformeRencauche.estadistica;
    if ($sessionStorage.dataInformeRencauche!=null){
        if ($scope.setConfiguracionInforme()){
            $scope.dataInforme=$sessionStorage.dataInformeRencauche;
            chartData=$scope.dataInforme.tiemposProcesos;
            $scope.html.bodyInforme=true;
            $scope.separarProcesos(true);
            cargarGrafico();
            setTimeout(function () {
                window.print();
            }, 1000);
        } else {
            setTimeout(function () {
                window.close();
            }, 1500);
        }
    } else {
        showToastDialog(true, "No se cargo ningun registro", "toast-principal");
        setTimeout(function () {
            window.close();
        }, 1500);
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