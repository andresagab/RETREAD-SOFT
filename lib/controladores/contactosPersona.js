panamApp.controller('contactosPersona', function ($scope, configuracionGlobal, $http, $location){
    $scope.cargarDatos= function (_identificacionPersona){
        $http.get(configuracionGlobal.scripts + "/listadosJSON.php?metodo=getContactosPersonaJSON&identificacionPersona="+_identificacionPersona).then(function (respuesta){
            console.log(respuesta);
            $scope.objetos=respuesta.data;
        })
    }
    $scope.cargarEmpleado= function (_IdEmpleado){
        $http.get(configuracionGlobal.scripts + "/datosJSON.php?metodo=getEmpleadoJSON&id="+_IdEmpleado).then(function (respuesta){
            console.log(respuesta);
            $scope.empleado=respuesta.data[0];
        })
    }
});   