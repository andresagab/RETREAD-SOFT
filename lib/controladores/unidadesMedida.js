panamApp.controller('unidadesMedida', function ($scope, configuracionGlobal, $http, $location){
    $http.get(configuracionGlobal.scripts + "/listadosJSON.php?metodo=unidadesMedidaJSON").then(function (respuesta){
        //console.log(respuesta);
        $scope.objetos=respuesta.data;
    })
    $scope.cargarLista=function(){
    	$http.get(configuracionGlobal.scripts + "/listadosJSON.php?metodo=unidadesMedidaJSON").then(function (respuesta){
            console.log(respuesta);
            $scope.objetos=respuesta.data;
        })
    }
});   