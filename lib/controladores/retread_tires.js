panamApp.controller('llantas', function ($scope, configuracionGlobal, $location, LlantasFactory){

    $(document).ready(function () {

        // set work_space_number
        $scope.llantas.page.work_space_number = document.getElementById('txtNumberProcess').value;

        $scope.loadData($scope.llantas.work_space_number);
        $scope.setNamePage();
    });

    $scope.llantas = {
        page: {
            name: 'Llantas',
            data_url: 'tiers_json.php',
            loadSpinner: false,
            work_space_number: 0,
            process_url: '',
            ended_process_url: '',
        },
        data: {
            objects: []
        },
        dataDirectSearch: {
            directSearch: false,
            valueSearch: null
        }
    };

    $scope.setNamePage = function(){
        switch ($scope.llantas.page.work_space_number) {
            case "1": $scope.llantas.page.name = 'Inspección Inicial'; break;
            case "2": 
                $scope.llantas.page.name = 'Raspado'; 
                $scope.llantas.page.process_url = 'principal.php?CON=system/Pages/new_raspadoFormulario.php&idInspeccion='; 
                $scope.llantas.page.en = 'principal.php?CON=system/Pages/raspadoFormularioFinalizar.php&id='; 
                break;
            default: $scope.llantas.page.name = 'Llantas'; break;
        }
    };

    /**
     * @description Carga los ultimos 100 registros de la tabla llanta y los asigna a la variable llantas.data.object
     */
    $scope.loadData = function () {
        $scope.buscar = "";
        $scope.llantas.page.loadSpinner = true;
        $scope.llantas.data.objects = [];
        // LlantasFactory.getData($scope.llantas.page.data_url).then(function (r) {
        LlantasFactory.getDirectSearch($scope.llantas.page.data_url, {work_space_number: $scope.llantas.page.work_space_number}).then(function (r) {
            $scope.llantas.data.objects = r.data.data;
            $scope.llantas.page.loadSpinner = false;
            $scope.setCurrentPage(null);
            $scope.initValues(r.data.data);
            $scope.setCurrentPage(null);
            showToastPrincipalTime(true, r.data.data.length + ' registros cargados exitosamente.', 2000);
        });
    };

    /**
     * @description Buscamos una llanta por su número de RP u Orden de servicio
     * @param valueSearch Valor de la llanta buscada (Rp - Orden de servicio)
     */
    $scope.directSearch = function (valueSearch) {
        if (validarInput(valueSearch)) {
            if (isNummber(valueSearch)) {
                $scope.llantas.page.loadSpinner = true;
                //Confirmamos los valores de busqueda, estado y valor buscado respectivamente
                $scope.llantas.dataDirectSearch.directSearch = true;
                $scope.llantas.dataDirectSearch.valueSearch = valueSearch;
                //Por medio de la función getDirectSearch enviaremos el valor buscado y cargaremos los resultados en la variable llantas.data.objects
                LlantasFactory.getDirectSearch($scope.llantas.page.data_url, $scope.llantas.dataDirectSearch).then(function (r) {
                    $scope.llantas.data.objects = r.data.data;
                    $scope.llantas.page.loadSpinner = false;
                    $scope.setCurrentPage(null);
                    $scope.initValues(r.data.data);
                    $scope.setCurrentPage(null);
                    showToastPrincipalTime(true, 'Se encontraron ' + r.data.data.length + ' resultados.', 2000);
                });
            } else {
                showToastPrincipalTime(true, 'No se puede buscar una palabra o letras como números', 3000);
                $scope.llantas.dataDirectSearch.directSearch = false;
                $scope.llantas.dataDirectSearch.valueSearch = null;
            }
        } else {
            showToastPrincipalTime(true, 'Para buscar una llanta debes ingresar el número RP u Orden de servicio de la llanta', 3000);
            $scope.llantas.dataDirectSearch.directSearch = false;
            $scope.llantas.dataDirectSearch.valueSearch = null;
        }
    };

    $scope.open_process = function (process)
    {
        document.location = $scope.llantas.page.process_url + process.id_previous_process;
        console.log(process)
        return

        if (process.procesado)
            document.location = $scope.llantas.page.ended_process_url + process.id;
        else
            document.location = $scope.llantas.page.process_url + process.id_previous_process;
    }

});   