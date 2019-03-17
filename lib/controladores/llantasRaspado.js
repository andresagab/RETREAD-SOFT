panamApp.controller('llantasRaspado', function ($scope, configuracionGlobal, $location, LlantasFactory){

    $(document).ready(function () {
        $scope.loadData(document.getElementById('txtNumberProcess').value);
        $scope.setNamePage();
    });

    $scope.llantas = {
        page: {
            name: 'Llantas',
            loadSpinner: false
        },
        data: {
            objects: []
        }
    };

    $scope.setNamePage = function(){
        switch (document.getElementById('txtNumberProcess').value) {
            case "1": $scope.llantas.page.name = 'Raspado'; break;
            default: $scope.llantas.page.name = 'Llantas'; break;
        }
    };

    $scope.loadData = function () {
        $scope.llantas.page.loadSpinner = true;
        $scope.llantas.data.objects = [];
        LlantasFactory.getData('llantasRaspadoJSON.php').then(function (r) {
            $scope.llantas.data.objects = r.data.data;
            $scope.llantas.page.loadSpinner = false;
            $scope.setCurrentPage(null);
            $scope.initValues(r.data.data);
            $scope.setCurrentPage(null);
            showToastPrincipalTime(true, r.data.data.length + ' registros cargados exitosamente.', 2000);
        });
    }

});   