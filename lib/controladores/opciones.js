panamApp.controller('opciones', function ($scope, configuracionGlobal, $http, $location){
    $scope.config=configuracionGlobal;//Asignamos todos los valores del metodo configuracion global a la variable config
    $http.get(configuracionGlobal.scripts + "/listasJSON.php?metodo=opcionesJSON").then(function (respuesta){
        //console.log(respuesta);
        $scope.objetos=respuesta.data;
    })
    $scope.cargarLista=function(){
    	$http.get(configuracionGlobal.scripts + "/listasJSON.php?metodo=cargosEmpleadoJSON").then(function (respuesta){
	        console.log(respuesta);
	        $scope.objetos=respuesta.data;
	    })
    }
});   