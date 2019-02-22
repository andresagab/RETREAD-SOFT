panamApp.controller('informeBodegaExportar', function ($scope, configuracionGlobal, $http, $location){
    
    console.log(document.location);
    
    $(document).ready(function (){
        $scope.cargarListaDefault(window.opener.txtFiltro.value, '');
    })
    
    $scope.cargarListaDefault=function(_filtro, _orden){
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
                window.setTimeout(function (){ 
                    document.location.search="?l=true";
                }, 2000);
            }
        });
    }
    
});   