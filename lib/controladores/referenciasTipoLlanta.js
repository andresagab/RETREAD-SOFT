panamApp.controller('referenciasTipoLlanta', function ($scope, configuracionGlobal, $http, $location){
    $scope.cargarLista=function(_IdTipoLlanta){
    	$http.get(configuracionGlobal.scripts + "/listadosJSON.php?metodo=referenciasTipoLlantaJSON&idTipoLlanta="+_IdTipoLlanta).then(function (respuesta){
            console.log(respuesta);
            $scope.objetos=respuesta.data;
            $scope.cargarTipoLlanta(_IdTipoLlanta)
        })
    }
    
    $scope.cargarTipoLlanta=function (_IdTipoLlanta){
        $http({
            url: configuracionGlobal.scripts + "/datosJSON.php",
            method: 'GET',
            params: {
                metodo: 'getTipoLlantaJSON',
                id: _IdTipoLlanta
            },
        }).then(function (r) {
            $scope.tipoLlanta=r.data[0];
            console.log(r);
        });
    }
});   