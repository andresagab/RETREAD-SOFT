panamApp.controller('bitacoras', function ($scope, $http, configuracionGlobal, $timeout, $interval) {

    $(document).ready(function () {
        $scope.loadData();
    })

    $scope.page= {
        spinnerCarga: false,
        dlgSpinnerCarga: false,
        data: {
            objects: null
        }
    }

    $scope.showSpinner=function(dlg, show){
        if (dlg) $scope.page.dlgSpinnerCarga=show;
        else $scope.page.spinnerCarga=show;
    }

    $scope.loadData=function () {
        $scope.showSpinner(false, true);
        $http({
            url: configuracionGlobal.scripts + "/listadosJSON.php",
            method: 'GET',
            params: {
                metodo: 'getBitacorasJSON'
            }
        }).success(function (r) {
            $scope.showSpinner(false, false);
            console.log(r);
            if (r!=null) {
                $scope.page.data.objects=r;
                showToastDialog(true, r.length + ' datos cargados', 'toast-principal');
                $scope.setCurrentPage(null);
                $scope.initValues(r);
                $scope.setCurrentPage(null);
            }
        }).error(function (r) {
            $scope.showSpinner(false, false);
            showToastDialog(true, 'No se pudo conectar con el servidor', 'toast-principal');
        });
    }

})