panamApp.controller('usuarios', function ($scope, configuracionGlobal, $http, $location){
    $scope.config=configuracionGlobal;//Asignamos todos los valores del metodo configuracion global a la variable config
    $http.get(configuracionGlobal.scripts + "/listasJSON.php?metodo=usuariosJSON").then(function (respuesta){//Llamando al metodo get de http llamamos a la variable configuracionglobal.api_url donde accedemos al archivo con los datos deseados
        console.log(respuesta);//imprimimos los valores asigandos a la variable respuesta en la consola de java
        $scope.usuarios=respuesta.data;//Todos los datos encontrados en el arcivo lista.php se lo asigamos al obejto empleados
    })
    $scope.cargarLista= function (_identificacion){
        $http.get(configuracionGlobal.scripts + "/listasJSON.php?metodo=usuariosPersonaJSON&identificacion="+_identificacion).then(function (respuesta){//Llamando al metodo get de http llamamos a la variable configuracionglobal.api_url donde accedemos al archivo con los datos deseados
            console.log(respuesta);//imprimimos los valores asigandos a la variable respuesta en la consola de java
            $scope.objetos=respuesta.data;//Todos los datos encontrados en el arcivo lista.php se lo asigamos al obejto empleados
        })
    }
});   