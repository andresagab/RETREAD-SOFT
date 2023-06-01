panamApp.controller('ordenesServicio', function ($scope, OrdenesServiciosFactory){

    $(document).ready(function () {
        $scope.loadData();
    })

    $scope.module = {
        page: {
            name: 'Ordenes de servicio',
            loadSpinner: false
        },
        data: {
            objects: []
        },
        dataDirectSearch: {
            directSearch: false,
            valueSearch: null,
            client: false
        }
    }

    /**
     * @version Carga los ultimos 50 registros de la tabla servicio ordenados por fecha de registro descendentemente
     */
    $scope.loadData = function () {
        //Reset input de busqueda
        $scope.buscar = "";
        //Activación de barra de carga y limpieza de la variable que almacena las ordenes de registro ($scope.module.data.objects)
        $scope.module.page.loadSpinner = true;
        $scope.module.data.objects = [];
        //Ejecución del método getData del Factory OrdenesServicioFactory
        OrdenesServiciosFactory.getData('ordenesServicioJSON.php').then(function (r) {
            if (validStatusHttpResponse(r, true)) {
                //Ocultamos la barra de carga (loadSpinner)
                $scope.module.page.loadSpinner = false;
                //Asignamos los datos obtenidos a la variable $scope.module.data.objects
                $scope.module.data.objects = r.data.data;
                //Configuramos el paginador
                $scope.setCurrentPage(null);
                $scope.initValues(r.data.data);
                $scope.setCurrentPage(null);
                showToastPrincipalTime(true, 'Registros cargados: ' + r.data.data.length, 2500);
            }
        });
    }

    /**
     * @description Buscamos una orden de servicio por número de orden o número de rp correspondiente a una llanta de la orden
     * @param valueSearch Valor del número de orden o rp de la llanta
     */
    $scope.directSearch = function (valueSearch) {
        if (validarInput(valueSearch)) {
            //Activamos el sppiner de carga
            $scope.module.page.loadSpinner = true;
            //Confirmamos los valores de busqueda, estado y valor buscado respectivamente
            $scope.module.dataDirectSearch.directSearch = true;
            $scope.module.dataDirectSearch.valueSearch = valueSearch;
            $scope.module.dataDirectSearch.client = !isNummber(valueSearch);
            //Por medio de la función getDirectSearch enviaremos el valor buscado y cargaremos los resultados en la variable llantas.data.objects
            OrdenesServiciosFactory.getDirectSearch('ordenesServicioJSON.php', $scope.module.dataDirectSearch).then(function (r) {
                //Validamos si la respuesta fue exitosa - el método llamado se encargará de mostrar los mensajes de error si declaramos true en el segundo parametro
                if (validStatusHttpResponse(r, true)) {
                    //Ocultamos la barra de carga (loadSpinner)
                    $scope.module.page.loadSpinner = false;
                    //Asignamos los datos obtenidos a la variable $scope.module.data.objects
                    $scope.module.data.objects = r.data.data;
                    //Configuramos el paginador
                    $scope.setCurrentPage(null);
                    $scope.initValues(r.data.data);
                    $scope.setCurrentPage(null);
                    //Validación del mensaje de resultados
                    if ($scope.module.dataDirectSearch.client && $scope.module.data.objects.length === 0) showToastPrincipalTime(true, 'El cliente "' + valueSearch + '" no tiene ordenes de servicio.', 2500);
                    else showToastPrincipalTime(true, 'Registros encontrados: ' + r.data.data.length, 2500);
                }
            });
        } else {
            showToastPrincipalTime(true, 'Para buscar ingresa el número de orden de servicio, el número de rp o el nombre del cliente', 3000);
            $scope.module.dataDirectSearch.directSearch = false;
            $scope.module.dataDirectSearch.valueSearch = null;
            $scope.module.dataDirectSearch.client = false;
        }
    };

    //Insertado 2018-09-16 02:30
    /**
     * @version Permite redireccionar a la página correspondiente de la orden de servicio
     * @param _id {ind|string} valor del id correspondiente a la orden de servicio que se va ha abrir.
     */
    $scope.openOS = function (_id) {
        if (validarInput(_id)) {
            window.location='principal.php?CON=system/Pages/ordenesServicioFormulario.php&id=' + _id;
        } else showToast(true, 'No se puede abrir la orden desde aqui');
    }
    //Fin Insertado 2018-09-16 02:30

});   