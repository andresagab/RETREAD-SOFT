panamApp.controller('roles', function ($scope, configuracionGlobal, $http, $location){
    $scope.config=configuracionGlobal;//Asignamos todos los valores del metodo configuracion global a la variable config

    $scope.html={
        spinnerLoad: false
    }

    $scope.loadData=function () {
            $scope.html.spinnerLoad=true;
            $http.get(configuracionGlobal.scripts + "/listasJSON.php?metodo=rolesJSON")
            .then(function (respuesta){
                $scope.html.spinnerLoad=false;
                $scope.objetos=respuesta.data;
            });
    }

    $scope.loadData();
});