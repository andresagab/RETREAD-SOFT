panamApp.controller('kardex', function ($scope, configuracionGlobal, $http, $location){
    $http.get(configuracionGlobal.scripts + "/listadosJSON.php?metodo=kardexJSON").then(function (respuesta){
        //console.log(respuesta);
        $scope.objetos=respuesta.data;
    })
    $scope.cargarLista=function(){
    	$http.get(configuracionGlobal.scripts + "/listadosJSON.php?metodo=kardexJSON").then(function (respuesta){
            console.log(respuesta);
            $scope.objetos=respuesta.data;
        })
    }
});   