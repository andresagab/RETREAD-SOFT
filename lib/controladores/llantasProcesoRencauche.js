panamApp.controller('llantasProcesoRencauche', function ($scope, configuracionGlobal, $location, $interval, LlantasFactory, $timeout){

    $(document).ready(function () {
        $scope.setValuesPage();
        $scope.loadData();
        $interval(function () {
            $scope.loadData();
        }, 1800000);
    });

    $scope.llantas = {
        page: {
            name: 'Llantas',
            procces: null,
            sourceData: null,
            sourceForm: null,
            loadSpinner: false
        },
        data: {
            objects: [],
            order: {
                field: null,
                reverse: true
            }
        }
    };

    $scope.setValuesPage = function() {
        switch (document.getElementById('txtNumberProcess').value) {
            case "1":
                $scope.llantas.page.name = 'Raspado';
                $scope.llantas.page.procces = 'Raspado';
                $scope.llantas.page.sourceData = 'llantasRaspadoJSON.php';
                $scope.llantas.page.sourceForm = 'raspadoFormulario.php';
                break;
            case "2":
                $scope.llantas.page.name = 'Preparación';
                $scope.llantas.page.procces = 'Preparación';
                $scope.llantas.page.sourceData = 'llantasPreparacionJSON.php';
                $scope.llantas.page.sourceForm = 'preparacionFormularioNew.php';
                break;
            case "3":
                $scope.llantas.page.name = 'Reparación';
                $scope.llantas.page.procces = 'Reparación';
                $scope.llantas.page.sourceData = 'llantasReparacionJSON.php';
                $scope.llantas.page.sourceForm = 'reparacionFormulario.php';
                break;
            default: $scope.llantas.page.name = 'Llantas'; break;
        }
    };

    $scope.loadData = function () {
        $scope.llantas.page.loadSpinner = true;
        $scope.llantas.data.objects = [];
        LlantasFactory.getData($scope.llantas.page.sourceData).then(function (r) {
            console.log(r);
            $scope.llantas.data.objects = r.data.data;
            $scope.llantas.page.loadSpinner = false;
            $scope.setCurrentPage(null);
            $scope.initValues(r.data.data);
            $scope.setCurrentPage(null);
            if ($scope.llantas.data.objects[0].hasOwnProperty('fechafinpastprocces')) $scope.llantas.data.order.field = 'fechafinpastprocces';
            showToastPrincipalTime(true, r.data.data.length + ' registros cargados exitosamente.', 2000);
        });
    };

    $scope.openFrm = function (idLlanta) {
        if (idLlanta != null && $scope.llantas.page.sourceForm != null) window.location = 'principal.php?CON=system/pages/' + $scope.llantas.page.sourceForm +  '&id=' + idLlanta;
        else {
            showToastPrincipalTime(true, "No se puede abrir el formulario error al cargar la llanta", 3000);
            $timeout(function () {
                window.location = "principal.php?CON=system/pages/unknowData.php";
            }, 3500);
        }
    };
    
});   