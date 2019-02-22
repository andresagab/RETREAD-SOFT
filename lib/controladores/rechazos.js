panamApp.controller('rechazos', function ($scope, configuracionGlobal, $http, $location){
    
    $scope.cargarLista=function(){
        $scope.html.spinnerCarga=true;
    	$http.get(configuracionGlobal.scripts + "/listadosJSON.php?metodo=rechazosJSON").then(function (respuesta){
            $scope.html.spinnerCarga=false;
            $scope.cacheObjetos=respuesta.data;
            $scope.objetos=respuesta.data;
            $scope.setPaginaActual(null);
            $scope.initValues();
            $scope.setPaginaActual(null);
        })
    }
    
    $scope.loadRechazosOfInspeccion=function(_IdInspeccion){
    	$http.get(configuracionGlobal.scripts + "/datosJSON.php?metodo=rechazosInspeccionJSON&idInspeccion="+_IdInspeccion).then(function (respuesta){
            console.log(respuesta);
            $scope.objetos=respuesta.data;
        })
    }
    
    $scope.observaciones="";
    rechazosId=[];
    
    $scope.separarRechazo=function (_chk, _IdRechazo){
        if (_chk){
            rechazosId[rechazosId.length]=_IdRechazo;
        } else {
            if (rechazosId.indexOf(_IdRechazo)!=-1) rechazosId[rechazosId.indexOf(_IdRechazo)]=null;
        }
        $scope.validarRechazos();
        //console.log(rechazosId.length);
        console.log(rechazosId);
    }
    
    $scope.validarRechazos=function (){
        valido=false;
        for (var i = 0; i < rechazosId.length; i++) {
            rechazo=rechazosId[i];
            if (rechazo!=null) {
                valido=true;
                i=rechazosId.length;
            }
        }
        if (valido) $scope.chequeados=true;
        else $scope.chequeados=false;
        return valido;
    }
    
    function cortarArray(_Array){
        var array="";
        if (_Array!=null){
            for (var i = 0; i < _Array.length; i++) {
                dato=_Array[i];
                if (dato!=null){
                    if (i<_Array.length-1) auxiliar="|";
                    else auxiliar ="";
                    array+=dato+auxiliar;
                }
            }
        }
        console.log(array);
        return array;
    }
    
    $scope.registrarRechazos=function (_IdInspeccionInicial, _observaciones){
        if ($scope.validarRechazos()){
            $scope.datos={
                idInspeccion: _IdInspeccionInicial,
                observaciones: _observaciones
            }
            $http({
                url: configuracionGlobal.scripts + "/cruds.php?metodo=registrarRechazos&idInspeccion="+_IdInspeccionInicial+"&observaciones="+_observaciones,
                data: $scope.datos,
                params: {
                    rechazos: cortarArray(rechazosId)
                },
                headers: {
                    'Content-type': 'application/x-www-form-urlencoded'
                }
            })
            .then(function (responsive){
                console.log(responsive);
                rechazosId=[];
                $scope.observaciones="";
            })
        }
    }
    
    $scope.limpiarVariables=function (){
        rechazosId=[];
        $scope.observaciones="";
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
            opcion: 10
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