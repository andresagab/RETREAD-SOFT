panamApp.controller('infoUsosPuestoTrabajo', function ($scope, $http, configuracionGlobal) {

    $scope.infoUsosPuestoTrabajo = {
        components: {
            loadSpinner: false
        },
        data: {
            objects: []
        }
    };

    $scope.loadInfoUsosPuestoTrabajo = function (_idProceso, _numeroProceso){
        /*
         * _idProceso hace referencia al valor de la llave primaria de un
         * proceso de rencauche.
         *
         * _numeroProceso hace referencia a un valor de tipo int el cual sirve
         * para identificar el nombre de la tabla (proceso) a la cual pertenece,
         * este campo facilita la busqueda exacta de un registro, de no contar
         * con el los resultados pueden ser ambiguos y confusos.
         *
         */
        if (validarInput(_idProceso) && validarInput(_numeroProceso)){
            $scope.infoUsosPuestoTrabajo.data.objects = [];
            $scope.infoUsosPuestoTrabajo.components.loadSpinner = true;
            $http({
                url: configuracionGlobal.scripts + "/datosJSON.php",
                method: 'GET',
                params: {
                    metodo: 'getInfoUsosInsumosJSON',
                    idProceso: _idProceso,
                    proceso: _numeroProceso
                }
            }).success(function (r){
                $scope.infoUsosPuestoTrabajo.components.loadSpinner = false;
                if (r!=null){
                    if (r.length>0) {
                        $scope.infoUsosPuestoTrabajo.data.objects = r;
                        showToastDialog(true, 'Se registraron ' + r.length + ' usos de insumo durante este proceso', 'toast-content-dialogPT');
                    }
                    else {
                        $scope.infoUsosPuestoTrabajo.data.objects = [];
                        showToastDialog(true, 'No se registraron usos de insumos durante este proceso', 'toast-content-dialogPT');
                    }
                } else {
                    $scope.html.listaUsosInsumo = false;
                    $scope.infoUsosPuestoTrabajo.data.objects = [];
                }
            }).error(function (r){
                $scope.infoUsosPuestoTrabajo.data.objects = [];
                $scope.infoUsosPuestoTrabajo.components.loadSpinner = false;
                showToastDialog(true, 'Error 404: No se encontro el archivo y/o no se pudo conectar al servidor', 'toast-content-dialogPT');
            });
        } else {
            $scope.infoUsosPuestoTrabajo.data.objects = []
            showToastDialog(true, 'No se pudo cargar la informacion solicitada, recarga la pagina e intentalo nuevamente', 'toast-content-dialogPT');
            showToastDialog(true, 'No se pudo cargar la informacion solicitada, recarga la pagina e intentalo nuevamente', 'toast-content');
        }
    }

});