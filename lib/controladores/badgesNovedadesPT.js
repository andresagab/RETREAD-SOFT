panamApp.controller('badgesNovedadesPT', function ($scope, $http, $interval, configuracionGlobal) {

    $scope.badgeNPT = {
        number: 0
    }

    $scope.validNotifyInSettings = function(){
        if ($scope.badgeNPT.number>0) $scope.generalElements.notifyInSettings=true;
        else $scope.generalElements.notifyInSettings=false;
    }

    $scope.loadNumberNovedadesPuestosTrabajo = function () {
        $http({
            url: configuracionGlobal.scripts + '/datosJSON.php',
            method: 'GET',
            params: {
                metodo: 'getNumberNovedadesPuestoTrabajo'
            }
        }).success(function (r) {
            $scope.badgeNPT.number=r;
            $scope.validNotifyInSettings();
        }).error(function (r) {
            $scope.badgeNPT.number=r;
            $scope.validNotifyInSettings();
        });
    }

    $interval(function () {
        $scope.loadNumberNovedadesPuestosTrabajo();
    }, 60000);

    $scope.validNotifyInSettings();
    $scope.loadNumberNovedadesPuestosTrabajo();

});