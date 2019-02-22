panamApp.controller('badges', function ($scope, configuracionGlobal, $http, $interval){

    Push.Permission.GRANTED;

    $scope.cargarNumeroSolicitudesEliminar=function (){
        $http.get(configuracionGlobal.scripts + "/datosJSON.php?metodo=getNumeroSolicitudesEliminar")
        .then(function (responsive){
            console.log(responsive);
            $scope.solicitudesEliminar=responsive.data;
        })
    }
    
    $scope.temporizarSolicitudes=function (){
        setInterval(function (){
            $scope.cargarNumeroSolicitudesEliminar();
        }, 60000, null);
    }
    
    //$scope.cargarNumeroSolicitudesEliminar();
    //$scope.temporizarSolicitudes();

    $scope.dataBadges= {
        numeroCortesBanda: 0,
        notify: null
    }

    $scope.loadNumeroCortes=function () {
        $http({
            url: configuracionGlobal.scripts + "/datosJSON.php",
            method: 'GET',
            params: {
                metodo: 'getNumeroCortesPendientes'
            }
        }).success(function (r) {
            if (r!=null){
                if (r>$scope.dataBadges.numeroCortesBanda){
                    Push.close("CB");
                    $scope.dataBadges.notify=Push.create("CORTES DE BANDA", {
                        tag: 'CB',
                        body: "Has recibido " + (r-$scope.dataBadges.numeroCortesBanda) + " nuevos cortes de banda",
                        icon: "design/pics/imagenes/1448993314848.jpg",
                        timeout: 100000,
                        onClick: function () {
                            window.location="principal.php?CON=system/Pages/cortesBandas.php";
                            this.close();
                        },
                        vibrate: 200
                    });
                }
                $scope.dataBadges.numeroCortesBanda=r;
            }
        }).error(function (r) {
            showToast(true, "No se pudo conectar con el servidor");
        });
    }

    $interval(function () {
        $scope.loadNumeroCortes();
    }, 60000)

    $scope.loadNumeroCortes();

});