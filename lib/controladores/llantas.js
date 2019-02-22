panamApp.controller('llantas', function ($scope, configuracionGlobal, $http, $location){
    $scope.config=configuracionGlobal;//Asignamos todos los valores del metodo configuracion global a la variable config
    /*$http.get(configuracionGlobal.scripts + "/listasJSON.php?metodo=llantasJSON").then(function (respuesta){
        console.log(respuesta);
        $scope.objetos=respuesta.data;
    })*/
    $scope.cargarDatos=function (){
        $http.get(configuracionGlobal.scripts + "/listadosJSON.php?metodo=llantasJSON").then(function (respuesta){
            console.log(respuesta);
            $scope.objetos=respuesta.data;
        })
    }
    $scope.cargarRP=function (){
        $http.get(configuracionGlobal.scripts + "/datosJSON.php?metodo=getProximoRP").then(function (respuesta){
            console.log(respuesta);
            $scope.rp=respuesta.data;
        })
    }
    $scope.enviarSolicitudEliminar= function(_IdLlanta, _IdEmpleado, _motivo, _objetoSolicitud){
        $http({
            url: configuracionGlobal.scripts+"/cruds.php?metodo=grabarSolicitudEliminarLlanta",
            method: "POST",
            data: _objetoSolicitud,
            params: {
                idLlanta: _IdLlanta,
                idEmpleado: _IdEmpleado,
                motivo: _motivo
            },
            headers: {
                'Content-type': 'application/x-www-form-urlencoded'
            }
        })
        .then(function(respuesta){
            console.log(respuesta);
        })
    }
});   