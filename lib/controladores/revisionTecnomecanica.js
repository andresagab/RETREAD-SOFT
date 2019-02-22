panamApp.controller('revisionTecnomecanica', function ($scope, configuracionGlobal, $http, $location){
    $scope.cargarDatos=function(_idVehivulo){
    	$http.get(configuracionGlobal.scripts + "/listadosJSON.php?metodo=revisionesTecnomecanicasJSON&idVehiculo="+_idVehivulo).then(function (respuesta){
            console.log(respuesta);
            $scope.objetos=respuesta.data;
        })
    }
    $scope.cargarVehiculo=function(_idVehiculo){
    	$http.get(configuracionGlobal.scripts + "/datosJSON.php?metodo=getVehiculoJSON&id="+_idVehiculo).then(function (respuesta){
            console.log(respuesta);
            $scope.vehiculo=respuesta.data[0];
        })
    }
    $scope.cargarCliente=function(_idCliente){
    	$http.get(configuracionGlobal.scripts + "/datosJSON.php?metodo=getClienteJSON&id="+_idCliente).then(function (respuesta){
            console.log(respuesta);
            $scope.cliente=respuesta.data[0];
        })
    }
    $scope.cargarClientePersona=function(_idVehiculo){
    	$http.get(configuracionGlobal.scripts + "/datosJSON.php?metodo=getClientePersonaJSON&idVehiculo="+_idVehiculo).then(function (respuesta){
            console.log(respuesta);
            $scope.clientePersona=respuesta.data[0];
        })
    }
});   