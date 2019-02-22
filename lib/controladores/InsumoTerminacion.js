panamApp.controller('insumoTerminacion', function ($scope, configuracionGlobal, $http, $location){
    /*$scope.cargarDatos=function(_idPuestoTrabajo){
    	$http.get(configuracionGlobal.scripts + "/listadosJSON.php?metodo=getInsumosPuestoTrabajoJSON&idPT="+_idPuestoTrabajo).then(function (respuesta){
            console.log(respuesta);
            $scope.objetos=respuesta.data;
        })
    }*/
    $scope.cargarInsumoPuestoTrabajo=function(_idInsumoPuestoTrabajo){
    	$http.get(configuracionGlobal.scripts + "/datosJSON.php?metodo=getInsumoPuestoTrabajoJSON&id="+_idInsumoPuestoTrabajo).then(function (respuesta){
            console.log(respuesta);
            $scope.insumo=respuesta.data[0];
        })
    }
    
    $scope.insumoTerminacion={};
    
    $scope.terminar= function (_IdEmpleado, _Observaciones, _Objeto){
        $scope.insumoTerminacion.idEmpleado=_IdEmpleado;
        $scope.insumoTerminacion.idInsumoPT=_Objeto.id;
        $scope.insumoTerminacion.observaciones=_Observaciones;
        //console.log($scope.insumoTerminacion);
        $http({
            url: "system/Scripts/cruds.php?metodo=terminarInsumo",
            method: 'POST',
            data: $scope.insumoTerminacion,
            headers: {
                'Content-type': 'application/x-www-form-urlencoded'
            }
        })
        .then (function (responsive){//Responsive->Respuesta del servidor
            console.log(responsive);
        })
    }
    
});   