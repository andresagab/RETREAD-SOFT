panamApp.controller('llantasEditarCorteBanda', function (configuracionGlobal, $scope, $http) {

    $(document).ready(function () {
        $scope.loadLlanta(document.getElementsByName('idLlanta')[0].value);
        $scope.loadCorteBanda(document.getElementsByName('idCorteBanda')[0].value);
    });

    $scope.html = {
        components: {
            loadBar: false,
            loadSpinner: false,
            btnUpdate: true,
        },
        data: {
            corteBanda: {},
            llanta: {}
        }
    }

    $scope.loadLlanta = function (_idLLanta) {
        if (validarInput(_idLLanta)) {
            $scope.html.components.loadSpinner = true;
            $http({
               url: configuracionGlobal.scripts + '/datosJSON.php',
               method: 'GET',
               params: {
                   metodo: 'getLlantaJSONSQL',
                   id: _idLLanta
               }
            }).success(function (r) {
                if ($scope.html.data.corteBanda.length>0) $scope.html.components.loadSpinner = false;
                if (r.length>0 || r!=null) {
                    if (r[0].id!=null) $scope.html.data.llanta = r[0];
                }
            }).error(function (r) {
                $scope.html.components.loadSpinner = false;
                //window.location = "principal.php?CON=system/pages/unknowData.php";
            });
        } else $scope.html.data.llanta = {};
    }

    $scope.loadCorteBanda = function (_idCorteBanda) {
        if (validarInput(_idCorteBanda)) {
            $scope.html.components.loadSpinner = true;
            $http({
               url: configuracionGlobal.scripts + '/datosJSON.php',
               method: 'GET',
               params: {
                   metodo: 'getCorteBandaEditar',
                   id: _idCorteBanda
               }
            }).success(function (r) {
                $scope.html.components.loadSpinner = false;
                if (r!=null) {
                    if (r.id!=null) $scope.html.data.corteBanda = r;
                }
            }).error(function (r) {
                $scope.html.components.loadSpinner = false;
                //window.location = "principal.php?CON=system/pages/unknowData.php";
            });
        } else $scope.html.data.corteBanda = {};
    }

    $scope.prevPage = function () {
        if ($scope.html.data.llanta.idos!=null) window.location = 'principal.php?CON=system/Pages/ordenesServicioFormulario.php&id=' + $scope.html.data.llanta.idos;
        else window.location = "principal.php?CON=system/Pages/unknowData.php";
    }

});