panamApp.controller('facturacion', function ($scope, $http, configuracionGlobal) {

    $scope.html = {
        elements: {
            barLoad: false,
            barLoadDlg: false,
            inputs: {
                txtOrden: null
            }
        },
        data: {
            os: {},
            llantas: [],
            llantasTable: [],
            llanta: {}
        }
    };

    $scope.loadOrdenesServicio = function () {
        $http({
            url: configuracionGlobal.scripts + '/listadosJSON.php',
            method: 'GET',
            params: {
                metodo: 'getOrdenesServicioJSONCustomize'
            }
        }).success(function () {

        }).error(function () {
            showToastPrincipal(true, 'Error al conectar con el servidor');
        });
    }

});