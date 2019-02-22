panamApp.controller('tiposServicio', function ($scope, configuracionGlobal, $http, $location){
    /*$http.get(configuracionGlobal.scripts + "/listadosJSON.php?metodo=rechazosJSON").then(function (respuesta){
        //console.log(respuesta);
        $scope.objetos=respuesta.data;
    })*/
    $scope.cargarLista=function(){
    	$http.get(configuracionGlobal.scripts + "/listadosJSON.php?metodo=getTiposServicioJSON").then(function (respuesta){
            console.log(respuesta);
            $scope.objetos=respuesta.data;
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
});   