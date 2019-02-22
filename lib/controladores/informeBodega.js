panamApp.controller('informeBodega', function ($scope, configuracionGlobal, $http, $location, $sessionStorage){

    $(document).ready(function (){
        $sessionStorage.dataInformeBodega=null;
        $scope.cargarListaDefault("ll.fechaRegistro between '" + new Date().getFullYear() + "-" + (new Date().getMonth()+1) + "-" + new Date().getDate() + " 00:00:00' and '" + new Date().getFullYear() + "-" + (new Date().getMonth()+1) + "-" + new Date().getDate() + " 23:59:59' ", '');
        $scope.getTotal("ll.fechaRegistro between '" + new Date().getFullYear() + "-" + (new Date().getMonth()+1) + "-" + new Date().getDate() + " 00:00:00' and '" + new Date().getFullYear() + "-" + (new Date().getMonth()+1) + "-" + new Date().getDate() + " 23:59:59' ", '');
        $scope.loadVendedores();
        //2018-10-19 21:01
        /*
        var cacheVendedor = {};

        $("#txtVendedor").autocomplete({
            minLength: 2,
            source: function (request, response) {
                var word = request.term;
                if (word in cacheVendedor) {
                    response(cacheVendedor[word]);
                    return;
                }
                $.getJSON("system/Scripts/Autocompletar.php?metodo=getIdentificacionesEmpleado", request,
                    function (data) {
                        cacheVendedor[word] = data;
                        response( data );
                    });
            }
        });*/
        //END 2018-10-19 21:01

    });

    $scope.objetos = [];

    $scope.html={
        spinnerCarga: false,
        btnGenerar: true,
        chkFechas: false,
        chkFechasSalida: false,
        chkTamanos: false,
        chkUrgentes: false,
        chkEstados: false,
        chkOs: false,
        rbtTamano: 0,
        rbtEstado: 0,
        rbtUrgente: 0,
        txtFechaInicio: new Date(),
        txtFechaFin: new Date(),
        txtFechaInicioSalida: new Date(),
        txtFechaFinSalida: new Date(),
        filtro: '',
        txtFileNameExel: null,
        chkVendedor: false,
        txtVendedor: null,
        chkFechasFacturacion: false,
        txtFechaInicioFacturacion: new Date(),
        txtFechaFinFacturacion: new Date(),
        chkEstadosFacturacion: false,
        rbtEstadoFacturacion: 0,
        total: 0,
        countOS: 0
    }

    $scope.filtros={
        filtroRechazadas: "ll.id in (select idLlanta from servicio_fin where estado='f')",
        filtroEnRencauche: "ll.id in (select idLlanta from inspeccion_inicial) and ll.id not in (select idLlanta from servicio_fin)",
        filtroRencauchadas: "ll.id in (select idLlanta from servicio_fin where estado='t')",
        filtroSinRencauche: "ll.id not in (select idLlanta from inspeccion_inicial)",
        filtroFacturadas: "ll.id in (select idllanta from salida_llanta)",
        filtroNoFacturadas: "ll.id not in (select idllanta from salida_llanta)",
        filtroFacturadasAndNoFacturadas: "ll.id in (select idllanta from salida_llanta) and ll.id not in (select idllanta from salida_llanta)"
    }
    
    $scope.setFiltro=function (_filtro){
        $scope.html.filtro=_filtro;
        //$("#txtFiltro")
    }
    
    $scope.showToast=function (_valido, _mjs){
        if (_valido){
            'use strict';
            var snackbarContainer = document.querySelector('#toast-content');
            snackbarContainer.MaterialSnackbar.showSnackbar({
                message: _mjs
            });
        }
    }
    
    $scope.showToastDialog=function (_valido, _mjs){
        if (_valido){
            'use strict';
            var snackbarContainer = document.querySelector('#toast-dialog');
            snackbarContainer.MaterialSnackbar.showSnackbar({
                message: _mjs
            });
        }
    }
    
    $scope.cargarListaDefault=function(_filtro, _orden){
        $scope.html.spinnerCarga=true;
    	$http({
            url: configuracionGlobal.scripts + "/listadosJSON.php",
            method: 'GET',
            params: {
                metodo: 'getLlantasInformeBodega',
                filtro: _filtro,
                orden: _orden
            }
        }).success(function (r){
            $scope.html.spinnerCarga=false;
            if (r.length<=0) $scope.showToast(true, "No se han encontrado registros en la base de datos");
            else $scope.showToast(true, r.length + " registros encontrados");
            $scope.objetos=r;
            $sessionStorage.dataInformeBodega=$scope.objetos;
            $scope.getTotal(_filtro, _orden);
            $scope.getCountOS(_filtro, _orden);
        }).error(function (r){
            $scope.html.spinnerCarga=false;
            $scope.showToast(true, "Error al conectar con el servidor");
        });
    }
    
    $scope.validarFiltros=function (){
        if ($scope.html.chkFechas || $scope.html.chkTamanos || $scope.html.chkEstados || $scope.html.chkUrgentes || $scope.html.chkOs || $scope.html.chkFechasSalida || $scope.html.chkVendedor || $scope.html.chkFechasFacturacion || $scope.html.chkEstadosFacturacion) {
            $scope.html.btnGenerar=false;
        } else {
            $scope.html.btnGenerar=true;
            $scope.showToastDialog(true, "Debes marcar como minimo una opcion");
        }
    }
    
    $scope.validarFechaInicio=function (){
        if ($scope.html.txtFechaInicio!=null && $scope.html.txtFechaInicio!="mm/dd/yyyy"){
            $scope.html.btnGenerar=false;
            return true;
        } else {
            $scope.html.btnGenerar=true;
            return false;
        }
    }
    
    $scope.validarFechaFin=function (){
        if ($scope.html.txtFechaFin!=null && $scope.html.txtFechaFin!="mm/dd/yyyy"){
            $scope.html.btnGenerar=false;
            return true;
        } else {
            $scope.html.btnGenerar=true;
            return false;
        }
    }

    //2018-09-21 13:04
    $scope.validarFecha = function(date){
        var valid=false;
        if (date!=null && date!='mm/dd/yyyy') {
            $scope.html.btnGenerar=false;
            valid=true;
        } else $scope.html.btnGenerar=true;
        return valid;
    }
    //END 2018-09-21 13:04

    $scope.validarNumeroOs=function (){
        if ($scope.html.numeroOs!=null && $scope.html.numeroOs!='' && $scope.html.numeroOs!='-'){
            $scope.html.btnGenerar=false;
            return true;
        } else {
            $scope.html.btnGenerar=true;
            return false;
        }
    }
    
    $scope.generarInforme=function (){
        var filtro='';
        var aux='';
        if ($scope.html.chkFechas && $scope.validarFechaInicio() && $scope.validarFechaFin()){
            var fechaInicio=$scope.html.txtFechaInicio.getFullYear() + "-" + ($scope.html.txtFechaInicio.getMonth()+1) + "-" + $scope.html.txtFechaInicio.getDate();
            var fechaFin=$scope.html.txtFechaFin.getFullYear() + "-" + ($scope.html.txtFechaFin.getMonth()+1) + "-" + $scope.html.txtFechaFin.getDate();
            filtro="ll.fechaRegistro between '" + fechaInicio + " 00:00:00' and '" + fechaFin + " 23:59:59' ";
            aux=' and ';
        }
        if ($scope.html.chkFechasSalida && $scope.validarFecha($scope.html.txtFechaInicioSalida) && $scope.validarFecha($scope.html.txtFechaFinSalida)){
            var fechaInicio=$scope.html.txtFechaInicioSalida.getFullYear() + "-" + ($scope.html.txtFechaInicioSalida.getMonth()+1) + "-" + $scope.html.txtFechaInicioSalida.getDate();
            var fechaFin=$scope.html.txtFechaFinSalida.getFullYear() + "-" + ($scope.html.txtFechaFinSalida.getMonth()+1) + "-" + $scope.html.txtFechaFinSalida.getDate();
            //filtro+="sf.id=ll.id and sf.fecharegistro between '" + fechaInicio + "' and '" + fechaFin + "' ";
            filtro += aux + "ll.id in (select idllanta from servicio_fin where idllanta=ll.id and fecharegistro between '" + fechaInicio + " 00:00:00' and '" + fechaFin + " 23:59:59')";
            aux=' and ';
        }
        if ($scope.html.chkFechasFacturacion && $scope.validarFecha($scope.html.txtFechaInicioFacturacion) && $scope.validarFecha($scope.html.txtFechaFinFacturacion)){
            var fechaInicio=$scope.html.txtFechaInicioFacturacion.getFullYear() + "-" + ($scope.html.txtFechaInicioFacturacion.getMonth()+1) + "-" + $scope.html.txtFechaInicioFacturacion.getDate();
            var fechaFin=$scope.html.txtFechaFinFacturacion.getFullYear() + "-" + ($scope.html.txtFechaFinFacturacion.getMonth()+1) + "-" + $scope.html.txtFechaFinFacturacion.getDate();
            filtro += aux + "ll.id in (select idllanta from salida_llanta where idllanta=ll.id and fecharegistro between '" + fechaInicio + " 00:00:00' and '" + fechaFin + " 23:59:59')";
            aux=' and ';
        }
        if ($scope.html.chkTamanos){
            if ($scope.html.rbtTamano==0) filtro+= aux + "ll.idAplicacionOriginal in (select id from dimension_referencia where profundidad>=17.5)";
            else filtro+= aux + "ll.idAplicacionOriginal in (select id from dimension_referencia where profundidad<17.5)";
            aux=' and ';
        }
        if ($scope.html.chkEstados){
            if ($scope.html.rbtEstado==0) filtro+= aux + $scope.filtros.filtroRechazadas;
            else if ($scope.html.rbtEstado==1) filtro+= aux + $scope.filtros.filtroEnRencauche;
            else if ($scope.html.rbtEstado==2) filtro+= aux + $scope.filtros.filtroRencauchadas;
            else filtro+= aux + $scope.filtros.filtroSinRencauche;
            aux=' and ';
        }
        if ($scope.html.chkEstadosFacturacion) {
            if ($scope.html.rbtEstadoFacturacion==0) filtro += aux + $scope.filtros.filtroFacturadas;
            else if ($scope.html.rbtEstadoFacturacion==1) filtro += aux + $scope.filtros.filtroNoFacturadas;
            else filtro += aux + $scope.filtros.filtroFacturadasAndNoFacturadas;
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
        if ($scope.html.chkVendedor && $scope.validarVendedor()) {
            filtro += aux + " ll.idServicio in (select id from servicio where idvendedor in (select id from empleado where identificacion like '%" + $scope.html.txtVendedor + "%'))";
        }
        $scope.html.filtro=filtro;
        $scope.cargarListaDefault(filtro, '');
    }
    
    $scope.imprimirInforme=function (){
        window.open(configuracionGlobal.templatesPrint + "/informeBodegaImprimir.php", null, 'toolbar=no, directories=no, width=500, height=350, resizable=no,left=380, top=240');
        //sessionStorage.setItem('dataInformeBodega', JSON.stringify($scope.objetos));
    }

    $scope.exportarExel=function (){
        window.open(configuracionGlobal.export + "/Exel/informeBodegaExel.php", null, null);
    }

    $scope.exportDataToExel = function () {
        var fileName=$scope.html.txtFileNameExel;
        if (fileName==null) fileName='informeBodega_' + new Date().getFullYear() + '-' + (new Date().getMonth()+1) + '-' + new Date().getDate();
        $scope.exportExel('#dataBodegaTable', fileName);
    }

    //2018-10-19 21:01

    $scope.dataPage = {
        elements: {
            hideAutocompleteVendedor: true
        },
        objects: {
            vendedores: [],
            vendedoresFilter: []
        }
    }

    $scope.loadVendedores = function () {
        $http({
            url: configuracionGlobal.scripts + '/listadosJSON.php',
            method: 'GET',
            params: {
                metodo: 'getEmpleadosJSON'
            }
        }).success(function (r) {
            if (r!=null) $scope.dataPage.objects.vendedores=r;
        }).error(function (r) {
            showToastPrincipal(true, 'No se pudo conectar con el servidor');
        });
    }

    $scope.autocompleteVendedores = function () {
        var output = [];
        angular.forEach($scope.dataPage.objects.vendedores, function (value) {
            if ($scope.html.txtVendedor!=null && $scope.html.txtVendedor!='') {
                if (value.identificacion.toLowerCase().indexOf($scope.html.txtVendedor.toLowerCase()) >= 0 || value.nombrescompletos.toLowerCase().indexOf($scope.html.txtVendedor.toLowerCase()) >= 0) output.push(value);
            } else output = [];
        });
        $scope.dataPage.objects.vendedoresFilter = output;
        if ($scope.dataPage.objects.vendedoresFilter!=null) $scope.dataPage.elements.hideAutocompleteVendedor=false;
    }

    $scope.setFieldVendedor = function (object) {
        if (object!=null) {
            $scope.html.txtVendedor = object.identificacion;
            $scope.dataPage.elements.hideAutocompleteVendedor = true;
            $scope.dataPage.objects.vendedoresFilter = [];
        }
    }

    $scope.validarVendedor = function () {
        valid = false;
        if ($scope.html.chkVendedor) {
            if ($scope.html.txtVendedor!=null) valid = true;
        }
        return valid;
    }

    //END 2018-10-19 21:01

    //INSERT SINCE 2019-02-14 22:42
    $scope.getTotal = function (_filtro, _orden) {
        $http({
            url: configuracionGlobal.scripts + "/listadosJSON.php",
            method: 'GET',
            params: {
                metodo: 'getTotalInformeBodega',
                filtro: _filtro,
                orden: _orden
            }
        }).success(function (r){
            if (r.length<=0) $scope.showToast(true, "Error al cargar el total");
            else $scope.showToast(true, "Total cargado exitosamente");
            $scope.html.total = r;
            $sessionStorage.totalInformeBodega = r;
        }).error(function (r){
            //$scope.html.spinnerCarga=false;
            $scope.showToast(true, "Error al conectar con el servidor");
        });
    }

    $scope.getCountOS = function (_filtro, _orden) {
        $http({
            url: configuracionGlobal.scripts + "/listadosJSON.php",
            method: 'GET',
            params: {
                metodo: 'getCountOSInformeBodega',
                filtro: _filtro,
                orden: _orden
            }
        }).success(function (r){
            $scope.html.countOS = r;
            $sessionStorage.countOS = r;
        }).error(function (r){
            $scope.showToast(true, "Error al conectar con el servidor");
        });
    }

    $scope.getTotalData = function (type) {
        var total = 0;
        if ($scope.objetos.length>0)
        switch (type) {
            case 0:
                for (i=0; i<$scope.objetos.length; i++) {
                    if ($scope.objetos[i].nombreEstado.toLowerCase()==='procesada (exitosamente)') total++;
                }
                break;
            case 1:
                for (i=0; i<$scope.objetos.length; i++) {
                    if ($scope.objetos[i].nombreEstado.toLowerCase()==='procesada (rechazada)') total++;
                }
                break;
            case 2:
                for (i=0; i<$scope.objetos.length; i++) {
                    if ($scope.objetos[i].nombreEstado.toLowerCase()==='sin procesar') total++;
                }
                break;
            case 3:
                for (i=0; i<$scope.objetos.length; i++) {
                    if ($scope.objetos[i].nombreEstado.toLowerCase()==='rencauchando') total++;
                }
                break;
            case 4:
                for (i=0; i<$scope.objetos.length; i++) {
                    if ($scope.objetos[i].dataSalida.length>0) total++;
                }
                break;
            case 5:
                for (i=0; i<$scope.objetos.length; i++) {
                    if ($scope.objetos[i].dataSalida.length===0) total++;
                }
                break;
        }
        return total;
    }

    //END INSERT SINCE 2019-02-14 22:42 - 2019-02-15 pp:pp:pp

});