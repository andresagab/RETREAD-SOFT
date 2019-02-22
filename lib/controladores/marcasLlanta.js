panamApp.controller('marcasLlantas', function ($scope, configuracionGlobal, $http, $location){
    $http.get(configuracionGlobal.scripts + "/listasJSON.php?metodo=marcasLlantaJSON").then(function (respuesta){
        //console.log(respuesta);
        $scope.objetos=respuesta.data;
    })
    $scope.cargarLista=function(){
    	$http.get(configuracionGlobal.scripts + "/listasJSON.php?metodo=marcasLlantaJSON").then(function (respuesta){
            console.log(respuesta);
            $scope.objetos=respuesta.data;
        })
    }
});   