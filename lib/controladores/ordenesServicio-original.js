panamApp.controller('ordenesServicio-original', function ($scope, configuracionGlobal, $http, $location, $routeParams, $localStorage, $interval, $timeout){

    $scope.objetos = [];
    $scope.counterDataBD = 0;

    $(document).ready(function () {
        $scope.html.spinnerCarga = true;
        $scope.getCountDataBd();
        $timeout(function () {
            $scope.html.spinnerCarga = false;
            $scope.cargarLista();
        }, 2000);
        $interval(function () {
            $scope.loadAllData();
        }, 3600000);
    });

    $interval(function () {
        $scope.getCountDataBd();
        if ($scope.counterDataBD!=0) $scope.cargarLista();
    }, 10000);

    $scope.cargarLista= function (){
        if ($localStorage.ordenesServicio!=null) {
            $scope.objetos = $localStorage.ordenesServicio;
            if ($scope.counterDataBD==$localStorage.ordenesServicio.length) $scope.loadDataCache();
            else if ($scope.counterDataBD>$localStorage.ordenesServicio.length) $scope.getNewData();
            else $scope.loadAllData();
        } else $scope.loadAllData();
    }

    $scope.loadAllData = function(){
        $scope.html.spinnerCarga = true;
        $scope.objetos = [];
        if (!$scope.html.loadingData) {
            $scope.html.loadingData = true;
            $http.get(configuracionGlobal.scripts + "/listadosJSON.php?metodo=serviciosJSON").then(function (respuesta){
                $scope.html.loadingData = false;
                $scope.html.spinnerCarga = false;
                $scope.setDataInCache(respuesta.data);
                $scope.cacheObjetos=respuesta.data;
                $scope.objetos=respuesta.data;
                $scope.setPaginaActual(null);
                $scope.setMaxRegistrosPaginator(respuesta.data.length);
                $scope.initValues();
                //$scope.setMaxRegistrosPaginator();
                $scope.setPaginaActual(null);
                console.log($scope.objetos);
                console.log($scope.values);
            });
        }
    }

    $scope.loadDataCache = function(){
        $scope.cacheObjetos=$localStorage.ordenesServicio;
        $scope.objetos=$localStorage.ordenesServicio;
        $scope.setPaginaActual(null);
        $scope.setMaxRegistrosPaginator($localStorage.ordenesServicio.length);
        $scope.initValues();
        //$scope.setMaxRegistrosPaginator();
        $scope.setPaginaActual(null);
    }

    $scope.setDataInCache = function(data){
        $localStorage.ordenesServicio = data;
    }

    $scope.getCountDataBd = function(){
        $http({
            url: configuracionGlobal.scripts + '/listadosJSON.php',
            method: 'GET',
            params: {
                metodo: 'getCountDataOS'
            }
        }).success(function (r) {
            $scope.counterDataBD = r;
        });
    }

    $scope.getNewData = function(){
        //$timeout(function () {
        var newData = [];
            var maxDataBD = $scope.counterDataBD;
            if ($scope.objetos!=null && maxDataBD!=0 && $scope.objetos.length>0) {
                if ($scope.objetos.length<maxDataBD) {
                    //if ($scope.objetos.length>maxDataBD) diferencia = $scope.objetos.length-maxDataBD;else
                    if (!$scope.html.loadingData) {
                        $scope.html.loadingData = true;
                        $scope.html.spinnerCarga = true;
                        diferencia = maxDataBD-$scope.objetos.length;
                        $http({
                            url: configuracionGlobal.scripts + '/listadosJSON.php',
                            method: 'GET',
                            params: {
                                metodo: 'serviciosRecientes',
                                filter: 'order by s.fecharegistro desc limit ' + diferencia
                            }
                        }).success(function (r) {
                            $scope.html.spinnerCarga = false;
                            var finded = false;
                            var newRecords = 0;
                            for (i=0; i<r.length; i++) {
                                for (j=0; j<$scope.objetos.length; j++) {
                                    if ($scope.objetos[j].idos==r[i].idos) {
                                        j = $scope.objetos.length;
                                        finded = true;
                                    }
                                    if (j==$scope.objetos.length-1 && !finded) {
                                        newRecords++;
                                        //$scope.objetos.splice(0, 0, r[i]);
                                        newData.push(r[i]);
                                        //$scope.objetos.push(r[i]);
                                        //$localStorage.ordenesServicio = $scope.objetos;
                                    }
                                }
                            }
                            for (i=0; i<$scope.objetos.length; i++) newData.push($scope.objetos[i]);
                            $scope.objetos = newData;
                            $scope.setDataInCache(newData);
                            //$scope.cargarLista();
                            $scope.html.loadingData = false;
                            showToastPrincipal(true, newRecords + " nuevos registros cargados exitosamente");
                        }).error(function (r) {
                            $scope.html.spinnerCarga = false;
                            $scope.html.loadingData = false;
                            showToastPrincipal(true, "Error al conectar con el servidor" + r);
                        });
                    }
                }
            } else $scope.loadAllData();
        //}, 1000);
    }
    /*
    $interval(function () {
        $scope.getNewData();
    }, 20000);
    */

    //Paginador
    //
    
    $scope.html={
        barraCircleCarga: false,
        spinnerCarga: false,
        prevPage: true,
        nextPage: true,
        loadingData: false
    }
    
    $scope.lstOpcionesRegistrosPaginas=[
        {opcion: 5},
        {opcion: 10},
        {opcion: 20},
        {opcion: 50},
        {opcion: 100}
    ];
    
    $scope.values={
        registrosXPagina: {
            opcion: 50
        },
        totalRegistros: 0,
        paginas: 1,
        paginaActual: 1,
        registroInicio: 0,
        registroFinal: 0,
    }
    
    $scope.cacheObjetos={}

    $scope.setMaxRegistrosPaginator = function(total){
        $scope.values.registrosXPagina.opcion=total;
        if ($scope.lstOpcionesRegistrosPaginas.length==5) $scope.lstOpcionesRegistrosPaginas.push({opcion: total});
        else {
            if ($scope.lstOpcionesRegistrosPaginas.length==6) {
                $scope.lstOpcionesRegistrosPaginas.splice(5, 1, {opcion: total});
            }
        }
    }
    
    $scope.initValues=function () {
        if ($scope.cacheObjetos!=null){
            $scope.values.totalRegistros=$scope.cacheObjetos.length;
            $scope.values.paginas=$scope.getPaginas();
            $scope.values.registroInicio=$scope.getRegistroInicial();
            $scope.values.registroFinal=$scope.getRegistroFinal();
        } else {
            $scope.values.totalRegistros=0;
            $scope.values.paginas=1;
            $scope.values.registroInicio=0;
            $scope.values.registroFinal=0;
        }
    }
    
    $scope.getPaginas=function () {
        if ($scope.objetos!=null && $scope.values!=null) return Math.ceil($scope.values.totalRegistros/$scope.values.registrosXPagina.opcion);
        else return 1;
    }
    
    $scope.getRegistroInicial=function () {
        if ($scope.objetos!=null && $scope.values!=null) return (($scope.values.paginaActual*$scope.values.registrosXPagina.opcion)-($scope.values.registrosXPagina.opcion-1));
        else return 1;
    }
    
    $scope.getRegistroFinal=function () {
        if ($scope.objetos!=null && $scope.values!=null) return ($scope.values.paginaActual*$scope.values.registrosXPagina.opcion);
        else return null;
    }
    
    $scope.setPaginaActual=function (_accion) {
        if (_accion!=null){
            if (_accion) $scope.values.paginaActual++;
            else $scope.values.paginaActual--;
            $scope.values.registroInicio=$scope.getRegistroInicial();
            $scope.values.registroFinal=$scope.getRegistroFinal();
        } else $scope.values.paginaActual=1;
        if ($scope.values.paginaActual==1){
            $scope.html.prevPage=true;
        }
        if ($scope.values.paginas>1) {
            $scope.html.nextPage=false;
            if ($scope.values.paginas==$scope.values.paginaActual) {
                $scope.html.nextPage=true;
                $scope.html.prevPage=false;
            } else {
                if ($scope.values.paginaActual>1) $scope.html.prevPage=false;
            }
        } else $scope.html.nextPage=true;
        $scope.getObjetos();
    }
    
    $scope.getObjetos=function () {
        if ($scope.objetos!=null){
            var datos=[];
            for (var i = $scope.getRegistroInicial(), max = $scope.getRegistroFinal(); i <=max; i++) {
                if ($scope.cacheObjetos[i-1]!=null) datos.push($scope.cacheObjetos[i-1]);
            }
            $scope.objetos=datos;
        } else $scope.objetos=$scope.cacheObjetos;
    }
    
    $scope.setRegistrosXPagina=function (_dato) {
        if (_dato!=null){
            $scope.values.registrosXPagina=_dato;
            $scope.setPaginaActual(null);
            $scope.initValues();
            $scope.setPaginaActual(null);
        }
    }
    
    //
    //FIN Paginador

    //Insertado 2018-09-16 02:30
    $scope.openOS = function (_id) {
        if (validarInput(_id)) {
            window.location='principal.php?CON=system/Pages/ordenesServicioFormulario.php&id=' + _id;
        } else showToast(true, 'No se puede abrir la orden desde aqui');
    }
    //Fin Insertado 2018-09-16 02:30

});   