panamApp.controller('ordenServicioImprimir', function ($scope, configuracionGlobal, $http, $location, $localStorage, $timeout) {

    $scope.html = {
        barraCarga: true,
        total: 0
    }

    $scope.ordenServicio = null;
    $scope.tiposServicioOS = null;
    $scope.llantas = null;

    $scope.imprimir=function () {
        $localStorage.osPrint = null;
        window.setTimeout(function(){
            window.print();
        }, 1500);
    }

    $scope.clearData=function() {
        $localStorage.osPrint = null;
    }

    $scope.close=function(){
        $scope.clearData();
        window.close();
    }

    $scope.getTotal = function () {
        for (i=0; i<$scope.llantas.length; i++) {
            if ($scope.llantas[i].salida.valor!=null) $scope.html.total+=parseInt($scope.llantas[i].salida.valor);
        }
    }

    $scope.loadData = function () {
        if ($localStorage.osPrint != null) {
            if ($localStorage.osPrint.objects != null && $localStorage.osPrint.objects.length > 0) {
                $scope.llantas = $localStorage.osPrint.objects;
                $scope.ordenServicio = $localStorage.osPrint.os;
                $scope.tiposServicioOS = $localStorage.osPrint.tiposServicio;
                $scope.html.barraCarga = false;
                $scope.getTotal();
            } else {
                $scope.html.barraCarga = false;
                showToastDialog(true, "No hay registros que se puedan mostrar", 'toast-general');
                //$timeout($scope.close(), 3000);
            }
        } else {
            $scope.html.barraCarga = false;
            showToastDialog(true, "No hay registros que se puedan mostrar", 'toast-general');
            //$timeout($scope.close(), 3000);
        }
        $scope.imprimir();
    }

    $(document).ready(function () {
        $timeout($scope.loadData(), 800);
    })

});   
