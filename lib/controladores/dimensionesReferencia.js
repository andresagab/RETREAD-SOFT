panamApp.controller('dimensionesReferencia', function ($scope, configuracionGlobal, $http, $location){
    $scope.cargarLista=function(_IdReferencia){
    	$http.get(configuracionGlobal.scripts + "/listadosJSON.php?metodo=dimensionesReferenciaJSON&idReferencia="+_IdReferencia).then(function (respuesta){
            console.log(respuesta);
            $scope.objetos=respuesta.data;
            $scope.cargarReferencia(_IdReferencia)
        })
    }
    
    $scope.cargarReferencia=function (_IdReferencia){
        $http({
            url: configuracionGlobal.scripts + "/datosJSON.php",
            method: 'GET',
            params: {
                metodo: 'getReferenciaJSON',
                id: _IdReferencia
            },
        }).then(function (r) {
            $scope.referencia=r.data[0];
            console.log(r);
        });
    }
});   