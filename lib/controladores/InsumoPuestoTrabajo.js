panamApp.controller('insumoPuestoTrabajo', function ($scope, configuracionGlobal, $http, $location){
    $scope.cargarDatos=function(_idPuestoTrabajo){
    	$http.get(configuracionGlobal.scripts + "/listadosJSON.php?metodo=getInsumosPuestoTrabajoJSON&idPT="+_idPuestoTrabajo).then(function (respuesta){
            console.log(respuesta);
            $scope.objetos=respuesta.data;
        })
    }
    $scope.cargarPuestoTrabajo=function(_idPuestoTrabajo){
    	$http.get(configuracionGlobal.scripts + "/datosJSON.php?metodo=getPuestoTrabajoJSON&id="+_idPuestoTrabajo).then(function (respuesta){
            console.log(respuesta);
            $scope.puestoTrabajo=respuesta.data[0];
        })
    }
    
    $scope.observaciones="";
    
    $scope.limpiarVariables=function (){
        $scope.observaciones="";
    }

    //2018-10-05 00:05 CARGAR INSUMO PT

    $scope.dataForm={
        idEmpleado: null,
        producto: null,
        cantidad: null,
        btnSubmit: false,
        barLoad: false
    }

    $scope.setProductoCarga = function (object) {
        if (object!=null) {
            $scope.dataForm.producto=object;
            if ($scope.dataForm.producto.stock!=null) $scope.dataForm.producto.stock=parseInt($scope.dataForm.producto.stock);
        } else {
            $scope.dataForm.producto=null;
            showToastDialog(true, 'No se pudo seleccionar el producto, intentelo recargando la pagína', 'toast-frm-dialog');
        }
    }

    $scope.setEmpleado = function (idEmpleado) {
        if (idEmpleado!=null) $scope.dataForm.idEmpleado=idEmpleado;
        else {
            $scope.dataForm.idEmpleado=null;
            showToastDialog(true, 'No se pudo tu ID de empleado, intentelo recargando la pagína', 'toast-frm-dialog');
        }
    }

    $scope.validCantidad = function () {
        var valid=false;
        if ($scope.dataForm.cantidad!=null && $scope.validProducto()) {
            if ($scope.dataForm.cantidad>0 && $scope.dataForm.cantidad<=$scope.dataForm.producto.stock) valid=true;
            else showToastDialog(true, 'La cantidad de carga debe ser mayor que cero y menor que ' + $scope.dataForm.producto.stock , 'toast-frm-dialog');
        } else showToastDialog(true, 'La cantidad no puede estar vacia', 'toast-frm-dialog');
        return valid;
    }

    $scope.validProducto = function (){
        var valid=false;
        if ($scope.dataForm.producto!=null) {
            if ($scope.dataForm.producto.idinsumopt!=null) valid=true;
        }
        return valid;
    }

    $scope.validIdEmpleado = function (){
        if ($scope.dataForm.idEmpleado!=null) return true;
        else return false;
    }

    $scope.addCarga = function () {
        console.log($scope.dataForm);
        if ($scope.validCantidad() && $scope.validProducto() && $scope.validIdEmpleado()) {
            $scope.dataForm.barLoad=true;
            $http({
                url: configuracionGlobal.scripts + '/Actions/recargasInsumosPuestoTrabajoActualizar.php',
                method: 'POST',
                params: {
                    method: 'addCarga'
                },
                data: $scope.dataForm
            }).success(function (r) {
                $scope.dataForm.barLoad=false;
                $("#btnCloseFormCarga").click();
                $scope.resetFormCarga(true);
                switch (r){
                    case 'SD':
                        showToastPrincipal(true, "Solicitud desconocida");
                        break;
                    case 'IR':
                        showToastPrincipal(true, "Solicitud invalida");
                        break;
                    case 'ID':
                        showToastPrincipal(true, "El registro no pudo completarse por falta de datos, intentalo nuevamente");
                        break;
                    case 'SDE':
                        showToastPrincipal(true, "Uoops, ocurrio un error al realizar el registro");
                        break;
                    case 'OK':
                        $scope.cargarDatos($scope.puestoTrabajo.id);
                        showToastPrincipal(true, "Recarga registrada exitosamente");
                        break;
                    default:
                        showToastPrincipal(true, "Ocurrio un error desconocido");
                        break;
                }
            }).error(function (r) {
                $scope.dataForm.barLoad=false;
                $("#btnCloseFormCarga").click();
                $scope.resetFormCarga(true);
                showToastPrincipal(true, 'No se pudo conectar con el servidor');
            });
        } else {
            showToastPrincipal(true, 'No se pudo cargar algunos datos necesarios para el registro');
            $("#btnCloseFormCarga").click();
        }
    }

    $scope.resetFormCarga = function (producto) {
        if (producto) $scope.dataForm.producto=null;
        $scope.dataForm.cantidad=null;
    }

    //END 2018-10-05 00:05 CARGAR INSUMO PT

});   