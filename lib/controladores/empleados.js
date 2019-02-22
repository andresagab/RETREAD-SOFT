panamApp.controller('empleados', function ($scope, configuracionGlobal, $http, $location){
    
    $scope.cargarLista=function () {
//        $http.get(configuracionGlobal.scripts + "/listasJSON.php?metodo=empleadosJSON").then(function (respuesta){
//            console.log(respuesta);
//            $scope.objetos=respuesta.data;
//        });
        $scope.html.spinnerCarga=true;
        $http({
            url: configuracionGlobal.scripts + "/listasJSON.php",
            method: 'GET',
            params: {
                metodo: 'empleadosJSON'
            }
        }).success(function (r) {
            $scope.html.spinnerCarga=false;
            $scope.cacheObjetos=r;
            $scope.objetos=r;
            $scope.setPaginaActual(null);
            $scope.initValues();
            $scope.setPaginaActual(null);
        }).error(function (r) {
            $scope.html.spinnerCarga=false;
            showToastDialog(true, "Ocurrio un error al conectar con el servidor y/o el archivo solicitado", "toast-principal");
        });
    }
    
    $scope.verDetalles= function (_objetoId, _identificacion){
        $location.path("principal.php?CON=system/Pages/usuariosPersona.php&identificacion="+_identificacion)
    }
    
    //Paginador
    //
    
    $scope.html={
        spinnerCarga: false,
        prevPage: true,
        nextPage: true
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
    
});

$(document).ready(function () {
    $("#cargarLista").click();
})