panamApp.controller('tiposLlantas', function ($scope, configuracionGlobal, $http, $location){
    $http.get(configuracionGlobal.scripts + "/listadosJSON.php?metodo=tiposLlantaJSON").then(function (respuesta){
        console.log(respuesta);
        $scope.objetos=respuesta.data;
    })
    $scope.cargarLista=function(){
    	$http.get(configuracionGlobal.scripts + "/listadosJSON.php?metodo=tiposLlantaJSON").then(function (respuesta){
            console.log(respuesta);
            $scope.objetos=respuesta.data;
        })
    }
});   