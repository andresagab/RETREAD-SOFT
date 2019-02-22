panamApp.controller('informeBodegaImprimir', function ($scope, configuracionGlobal, $http, $location, $sessionStorage){

    $scope.objetos=new Array();

    $scope.objetos = $sessionStorage.dataInformeBodega;
    $scope.total = $sessionStorage.totalInformeBodega;
    $scope.countOS = $sessionStorage.countOS;

    $(document).ready(function (){
        setTimeout(function () {
            window.print();
        }, 500);
    });

    $scope.cargarListaDefault=function(_filtro, _orden){
        //var data=JSON.parse(sessionStorage.getItem('dataInformeBodega'));
        //for (var i=0; i<data.length; i++) $scope.objetos.push(data[i]);
        console.log($scope.objetos);
        /*if (sessionStorage.getItem('dataInformeBodega')!=null){
            $scope.objetos=JSON.parse(sessionStorage.getItem('dataInformeBodega'));
            window.setTimeout(function(){
                window.print();
            },2000);
        } else {
            $http({
                url: configuracionGlobal.scripts + "/listadosJSON.php",
                method: 'GET',
                params: {
                    metodo: 'getLlantasInformeBodega',
                    filtro: _filtro,
                    orden: _orden
                }
            }).success(function (r){
                if (r!=null){
                    $scope.objetos=r;
                    window.setTimeout(function(){
                        window.print();
                    },2000);
                }
            });
        //}*/
    }

    $scope.getTotalData = function (type) {
        var total = 0;
        if ($scope.objetos.length>0)
            switch (type) {
                case 0:
                    for (i=0; i<$scope.objetos.length; i++) {
                        if ($scope.objetos[i].nombreEstado.toLowerCase()==='procesada (exitosamente)') total++;
                    }
                    break;
                case 1:
                    for (i=0; i<$scope.objetos.length; i++) {
                        if ($scope.objetos[i].nombreEstado.toLowerCase()==='procesada (rechazada)') total++;
                    }
                    break;
                case 2:
                    for (i=0; i<$scope.objetos.length; i++) {
                        if ($scope.objetos[i].nombreEstado.toLowerCase()==='sin procesar') total++;
                    }
                    break;
                case 3:
                    for (i=0; i<$scope.objetos.length; i++) {
                        if ($scope.objetos[i].nombreEstado.toLowerCase()==='rencauchando') total++;
                    }
                    break;
                case 4:
                    for (i=0; i<$scope.objetos.length; i++) {
                        if ($scope.objetos[i].dataSalida.length>0) total++;
                    }
                    break;
                case 5:
                    for (i=0; i<$scope.objetos.length; i++) {
                        if ($scope.objetos[i].dataSalida.length===0) total++;
                    }
                    break;
            }
        return total;
    }

});   