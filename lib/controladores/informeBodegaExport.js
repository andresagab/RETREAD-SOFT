panamApp.controller('informeBodegaExport', function ($scope, configuracionGlobal, $http, $location, $sessionStorage, $timeout){

    $scope.objetos=new Array();

    $scope.objetos=$sessionStorage.dataInformeBodega;
    $scope.total = $sessionStorage.totalInformeBodega;

    $scope.data = {
        currentDate: new Date()
    }

    $(document).ready(function (){
        $scope.exportExel('#dataTableContent', 'informeBodega_' + $scope.data.currentDate.getFullYear() + '-' + ($scope.data.currentDate.getMonth()+1) + '-' + $scope.data.currentDate.getDate());
        $timeout(function () {
            window.close();
        }, 1500);
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
    
});   