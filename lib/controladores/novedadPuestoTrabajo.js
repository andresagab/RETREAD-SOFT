panamApp.controller('novedadPuestoTrabajo', function ($scope, configuracionGlobal, $http, $location){
    
    $scope.html={
        spinnerCarga: false,
        config: configuracionGlobal,
        data: {
            object: null
        }
    }

    $scope.showToast=function (_valido, _mjs){
        if (_valido){
            'use strict';
            var snackbarContainer = document.querySelector('#toast-content');
            snackbarContainer.MaterialSnackbar.showSnackbar({
                message: _mjs
            });
        }
    }
    
    $scope.cargarDatos=function(_idPuestoTrabajo){
        $scope.html.spinnerCarga=true;
    	$http.get(configuracionGlobal.scripts + "/listadosJSON.php?metodo=getNovedadesPuestoTrabajoJSON&idPT="+_idPuestoTrabajo).then(function (respuesta){
            //console.log(respuesta);
            $scope.html.spinnerCarga=false;
            $scope.objetos=respuesta.data;
            if ($scope.objetos.length<=0) $scope.showToast(true, 'No hay novedades para este puesto de trabajo');
        })
    }
    
    $scope.cargarPuestoTrabajo=function(_idPuestoTrabajo){
        $scope.html.spinnerCarga=true;
    	$http.get(configuracionGlobal.scripts + "/datosJSON.php?metodo=getPuestoTrabajoJSON&id="+_idPuestoTrabajo).then(function (respuesta){
            //console.log(respuesta);
            $scope.html.spinnerCarga=false;
            $scope.puestoTrabajo=respuesta.data[0];
        })
    }
    
    $scope.observaciones="";
    
    $scope.limpiarVariables=function (){
        $scope.observaciones="";
    }

    //Code update 07-09-2018
    
    $scope.setObject = function (object) {
        if (object!=null) {
            $scope.html.data.object=object;
        } else showToastDialog(true, 'No se pudo cargar la novedad, intentalo nuevamente', 'toast-dialog');
    }
    
    $scope.actionObject = function (action) {
        if (validarInput(action)){
            if ($scope.html.data.object!=null) {
                if ($scope.html.data.object.id!=null) {
                    $scope.html,spinnerCarga=true;
                    $http({
                        url: configuracionGlobal.scripts + '/cruds.php',
                        method: 'POST',
                        data: $scope.html.data.object,
                        params: {
                            metodo: 'actionsNovedadPuestoTrabajo',
                            action: action
                        },
                        headers: {'Content-type': 'application/x-www-form-urlencoded'}
                    }).success(function (r) {
                        $scope.html,spinnerCarga=false;
                        $scope.html.data.object=null;
                        switch (r){
                            case 'OK':
                                $scope.cargarDatos($scope.puestoTrabajo.id);
                                $scope.showToast(true, "Tarea ejecutada exitosamente");
                                break;
                            case 'ID':
                                $scope.cargarDatos($scope.puestoTrabajo.id);
                                $scope.showToast(true, "No se pudo completar la operacion, recarga la pagina e intentalo nuevamente");
                                break;
                            case 'IR':
                                $scope.cargarDatos($scope.puestoTrabajo.id);
                                $scope.showToast(true, "Solicitud desconocida");
                                break;
                            case 'SDE':
                                $scope.cargarDatos($scope.puestoTrabajo.id);
                                $scope.showToast(true, "Uoops, ocurrio un error al realizar la tarea");
                                break;
                            default :
                                $scope.cargarDatos($scope.puestoTrabajo.id);
                                $scope.showToast(true, "Uoops, ocurrio un error desconocido");
                                break;
                        }
                    }).error(function (r) {
                        $scope.html,spinnerCarga=false;
                        $scope.html.data.object=null;
                        $scope.showToast(true, 'No se pudo llevar acabo la tarea');
                    });
                }
            }
        }
    }
    
    //End code update 07-07-2018

});   