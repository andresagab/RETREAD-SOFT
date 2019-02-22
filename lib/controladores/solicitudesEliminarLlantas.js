panamApp.controller('solicitudesEliminarLlanta', function ($scope, configuracionGlobal, $http, $location, $routeParams){
    $scope.cargarDatos= function (){
        $http.get(configuracionGlobal.scripts + "/listadosJSON.php?metodo=solicitudesEliminarLlantaJSON").then(function (respuesta){
            console.log(respuesta);
            $scope.objetos=respuesta.data;
        })
    }
    
    $scope.aprobar= function (_Id, _ObjetoSolicitud){
        $http({
            url: "system/Scripts/cruds.php?metodo=aprobarSolicitudEliminarLlanta",
            data: _ObjetoSolicitud,
            params: {
                id: _Id
            },
            headers: {
                'Content-type': 'application/x-www-form-urlencoded'
            }
        })
        .then (function (responsive){//Responsive->Respuesta del servidor
            console.log(responsive);
        })
    }
});   