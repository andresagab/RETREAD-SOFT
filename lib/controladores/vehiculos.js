panamApp.controller('vehiculos', function ($scope, configuracionGlobal, $http, $location){
    $scope.cargarDatos=function(_idCliente){
    	$http.get(configuracionGlobal.scripts + "/listadosJSON.php?metodo=vehiculosJSON&idCliente="+_idCliente).then(function (respuesta){
            console.log(respuesta);
            $scope.objetos=respuesta.data;
        })
    }
    $scope.cargarCliente=function(_idCliente){
    	$http.get(configuracionGlobal.scripts + "/datosJSON.php?metodo=getClienteJSON&id="+_idCliente).then(function (respuesta){
            console.log(respuesta);
            $scope.cliente=respuesta.data[0];
        })
    }
});   