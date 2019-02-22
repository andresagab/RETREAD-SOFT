panamApp.controller('menus', function ($scope, configuracionGlobal, $http, $location){
    $scope.config=configuracionGlobal;//Asignamos todos los valores del metodo configuracion global a la variable config
    $http.get(configuracionGlobal.scripts + "/listasJSON.php?metodo=menusJSON").then(function (respuesta){
        //console.log(respuesta);
        $scope.objetos=respuesta.data;
    })
    $scope.verDetalles= function (_objetoId){
        $location.path("/adicionarCargo/"+_objetoId)
        //alert($location.path())
    }
    $scope.gestionar= function (_accion, _objetoId){
        $location.path("/adicionarCargo/"+_accion+"/"+_objetoId)
        //alert($location.path())
    }
    $scope.cargarLista=function(){
    	$http.get(configuracionGlobal.scripts + "/listasJSON.php?metodo=cargosEmpleadoJSON").then(function (respuesta){
	        console.log(respuesta);
	        $scope.objetos=respuesta.data;
	    })
    }
});   