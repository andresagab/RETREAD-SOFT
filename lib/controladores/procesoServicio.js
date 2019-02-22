panamApp.controller('proceso', function ($scope, configuracionGlobal, $http, $timeout){
    
    $scope.inspeccionInicial={};
    
    $scope.startTimer=function (){
        if ($scope.inspeccionInicial.id!=null && $scope.inspeccionInicial.id!='' && $scope.inspeccionInicial.id!='0'){
            $http.get(configuracionGlobal.scripts + "/datosJSON.php?metodo=getTiempoTranscurrido&idInspeccion=" + $scope.inspeccionInicial.id)
            .then(function (responsive){
                //console.log(responsive);
                $scope.tiempo=responsive.data;
            })
        }
    }
    
    setInterval(function (){
        $scope.startTimer();
    }, 1000, null);
    
    $scope.html={
        spinnerCargaDialogPT: false,
        listaUsosInsumo: false
    }
    
    $scope.puestoTrabajo={}
    $scope.usosInsumos=null;
    
    $scope.cargarInfoUsosInsumos=function (_idProceso, _numeroProceso){
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
            $scope.html.listaUsosInsumo=false;
            $scope.html.spinnerCargaDialogPT=true;
            $http({
                url: configuracionGlobal.scripts + "/datosJSON.php",
                method: 'GET',
                params: {
                    metodo: 'getInfoUsosInsumosJSON',
                    idProceso: _idProceso,
                    proceso: _numeroProceso
                }
            }).success(function (r){
                $scope.html.spinnerCargaDialogPT=false;
                if (r!=null){
                    if (r.length>0) {
                        $scope.html.listaUsosInsumo=true;
                        $scope.usosInsumos=r;
                        showToastDialog(true, 'Se registraron ' + r.length + ' usos de insumo durante este proceso', 'toast-content-dialogPT');
                    }
                    else {
                        $scope.html.listaUsosInsumo=false;
                        $scope.usosInsumos=null;
                        $scope.usosInsumos={};
                        showToastDialog(true, 'No se registraron usos de insumos durante este proceso', 'toast-content-dialogPT');
                        //showToastDialog(true, 'No se pudo cargar la informacion solicitada, recarga la pagina e intentalo nuevamente', 'toast-content-dialogPT');
                    }
                } else {
                    $scope.html.listaUsosInsumo=false;
                    $scope.usosInsumos=null;
                    $scope.usosInsumos={};
                }
                console.log($scope.usosInsumos);
            }).error(function (r){
                $scope.html.listaUsosInsumo=false;
                $scope.usosInsumos=null;
                $scope.usosInsumos={};
                $scope.html.spinnerCargaDialogPT=false;
                showToastDialog(true, 'Error 404: No se encontro el archivo y/o no se pudo conectar al servidor', 'toast-content-dialogPT');
            });
        } else {
            $scope.html.listaUsosInsumo=false;
            $scope.usosInsumos=null;
            $scope.usosInsumos={};
            showToastDialog(true, 'No se pudo cargar la informacion solicitada, recarga la pagina e intentalo nuevamente', 'toast-content-dialogPT');
            showToastDialog(true, 'No se pudo cargar la informacion solicitada, recarga la pagina e intentalo nuevamente', 'toast-content');
        }
    }
    
    $scope.cargarPuestoTrabajo=function (_idProceso, _numeroProceso){
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
            $scope.html.spinnerCargaDialogPT=true;
            $http({
                url: configuracionGlobal.scripts + "/datosJSON.php",
                method: 'GET',
                params: {
                    metodo: 'getPuestoTrabajoJSON',
                    idProceso: _idProceso,
                    proceso: _numeroProceso
                }
            }).success(function (r){
                $scope.html.spinnerCargaDialogPT=false;
                if (r.data!=null){
                    if (r.length>0) $scope.puestoTrabajo=r[0];
                    else {
                        $scope.puestoTrabajo={}
                        showToastDialog(true, 'No se pudo cargar el puesto de trabajo', 'toast-content-dialogPT');
                    }
                }
            }).error(function (r){
                $scope.html.spinnerCargaDialogPT=false;
                showToastDialog(true, 'Error 404: No se encontro el archivo y/o no se pudo conectar al servidor', 'toast-content-dialogPT');
            });
        } else {
            showToast(true, "No se pudo cargar el registro, recarga la pagina e intentalo nuevamente");
        }
    }
    
    $scope.cargarInsumosPuestoTrabajoEnProceso=function (){
        if ($scope.puestoTrabajo.id!=null && $scope.puestoTrabajo.id!=''){
            $http({
                url: configuracionGlobal.scripts + "/listadosJSON.php",
                method: 'GET',
                params: {
                    metodo: ''
                }
            });
        } else {
            showToastDialog(true, 'No se pueden cargar los insumo en este momento', 'toast-content-dialogPT');
        }
    }
    
    $scope.setInitialTime=function (idLlanta) {
        if (validarInput(idLlanta)){
            $http({
                url: configuracionGlobal.scripts + "/cruds.php",
                method: 'POST',
                params: {
                    metodo: 'setTiempoInicialPR',
                    idLlanta: idLlanta
                }
            }).success(function (r) {
                switch (r){
                    case 'SD':
                        showToastDialog(true, "Solicitud desconocida", "toast-principal");
                        break;
                    case 'IR':
                        showToastDialog(true, "Solicitud invalida", "toas-principal");
                        break;
                    case 'ID':
                        showToastDialog(true, "No se pudo iniciar el tiempo, intentalo nuevamente", "toas-principal");
                        break;
                    case 'SDE':
                        $("#btnCancelarCPC").click();
                        showToast(true, "Uoops, ocurrio un error al llevar acabo el registro");
                        break;
                    case 'OK':
                        showToast(true, "El tiempo de rencauche empieza a correr desde este momento");
                        $timeout(function () {
                            window.location.reload()
                        }, 1500);
                        break;
                    default :
                        $("#btnCancelarCPC").click();
                        $scope.showToast(true, "Uoops, ocurrio un error desconocido");
                        break;
                }
            }).error(function (r) {
                showToast(true, "Error al conectar con el servidor");
            });
        }
    }

});   