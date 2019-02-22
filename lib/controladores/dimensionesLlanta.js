panamApp.controller('dimensionesLlanta', function ($scope, configuracionGlobal, $http, $location){
    $scope.cargarLista=function(){
    	$http.get(configuracionGlobal.scripts + "/listadosJSON.php?metodo=dimensionesLlantaJSON").then(function (respuesta){
            console.log(respuesta);
            $scope.objetos=respuesta.data;
            $scope.setCurrentPage(null);
            $scope.initValues(respuesta.data);
            $scope.setCurrentPage(null);
        })
    }
});   