panamApp.controller('productoCategoria', function ($scope, configuracionGlobal, $http, $location){
    
    $scope.html={
        spinnerCarga: false,
        prevPage: true,
        nextPage: true
    }
    
    $scope.lstOpcionesRegistrosPaginas=[
        {opcion: 5},
        {opcion: 10},
        {opcion: 20},
        {opcion: 50},
        {opcion: 100}
    ];
    
    $scope.values={
        registrosXPagina: {
            opcion: 100
        },
        totalRegistros: 0,
        paginas: 1,
        paginaActual: 1,
        registroInicio: 0,
        registroFinal: 0,
    }
    
    $scope.cacheObjetos={}
    
    $scope.cargarCategoria=function(_idCategoria){
    	$http.get(configuracionGlobal.scripts + "/datosJSON.php?metodo=getCategoriaProductoJSON&id="+_idCategoria).then(function (respuesta){
            console.log(respuesta);
            $scope.categoria=respuesta.data[0];
        })
    }
    
    $scope.cargarDatos=function(_idCategoria){
        $scope.html.spinnerCarga=true;
        $scope.objetos=null;
    	$http.get(configuracionGlobal.scripts + "/listadosJSON.php?metodo=getProductosCategoriaJSON&idCategoria="+_idCategoria)
                .then(function (respuesta){
                    $scope.html.spinnerCarga=false;
                    $scope.cacheObjetos=respuesta.data;
                    $scope.objetos=respuesta.data;
                    $scope.setPaginaActual(null);
                    $scope.initValues();
                    $scope.setPaginaActual(null);
                });
    }
    
    $scope.initValues=function () {
        if ($scope.cacheObjetos!=null){
            $scope.values.totalRegistros=$scope.cacheObjetos.length;
            $scope.values.paginas=$scope.getPaginas();
            $scope.values.registroInicio=$scope.getRegistroInicial();
            $scope.values.registroFinal=$scope.getRegistroFinal();
        } else {
            $scope.values.totalRegistros=0;
            $scope.values.paginas=1;
            $scope.values.registroInicio=0;
            $scope.values.registroFinal=0;
        }
        console.log($scope.values);
    }
    
    $scope.getPaginas=function () {
        if ($scope.objetos!=null && $scope.values!=null) return Math.ceil($scope.values.totalRegistros/$scope.values.registrosXPagina.opcion);
        else return 1;
    }
    
    $scope.getRegistroInicial=function () {
        if ($scope.objetos!=null && $scope.values!=null) return (($scope.values.paginaActual*$scope.values.registrosXPagina.opcion)-($scope.values.registrosXPagina.opcion-1));
        else return 1;
    }
    
    $scope.getRegistroFinal=function () {
        if ($scope.objetos!=null && $scope.values!=null) return ($scope.values.paginaActual*$scope.values.registrosXPagina.opcion);
        else return null;
    }
    
    $scope.setPaginaActual=function (_accion) {
        if (_accion!=null){
            if (_accion) $scope.values.paginaActual++;
            else $scope.values.paginaActual--;
            $scope.values.registroInicio=$scope.getRegistroInicial();
            $scope.values.registroFinal=$scope.getRegistroFinal();
        } else $scope.values.paginaActual=1;
        if ($scope.values.paginaActual==1){
            $scope.html.prevPage=true;
        }
        if ($scope.values.paginas>1) {
            $scope.html.nextPage=false;
            if ($scope.values.paginas==$scope.values.paginaActual) {
                $scope.html.nextPage=true;
                $scope.html.prevPage=false;
            } else {
                if ($scope.values.paginaActual>1) $scope.html.prevPage=false;
            }
        } else $scope.html.nextPage=true;
        //if ($scope.values.paginaActual==$scope.values.paginas) $scope.html.previosPage=false;
        //console.log($scope.html);
        //console.log($scope.values);
        $scope.getObjetos();
    }
    
    $scope.getObjetos=function () {
        //alert("cambiando");
        if ($scope.objetos!=null){
            var datos=[];
            for (var i = $scope.getRegistroInicial(), max = $scope.getRegistroFinal(); i <=max; i++) {
                //var dato=$scope.cacheObjetos[i];
                //alert(i-1);
                if ($scope.cacheObjetos[i-1]!=null) datos.push($scope.cacheObjetos[i-1]);
            }
            //$scope.objetos={};
            $scope.objetos=datos;
            //return datos;
        } else $scope.objetos=$scope.cacheObjetos;
        console.log($scope.objetos);
    }
    
    $scope.setRegistrosXPagina=function (_dato) {
        if (_dato!=null){
            $scope.values.registrosXPagina=_dato;
            $scope.setPaginaActual(null);
            $scope.initValues();
            $scope.setPaginaActual(null);
        }
    }

    //Carga de producto 2018-10-01 23:44
    //fechaRegistro: new Date().getFullYear() + '-' + (new Date().getMonth()+1) + '-' + new Date().getDate(),

    $scope.dataForm={
        idEmpleado: null,
        producto: null,
        cantidad: null,
        fechaRegistro: new Date(),
        btnSubmit: false,
        barLoad: false
    }

    $scope.setProductoCarga = function (object) {
        if (object!=null) $scope.dataForm.producto=object;
        else {
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
        if ($scope.dataForm.cantidad!=null) {
            if ($scope.dataForm.cantidad>0) valid=true;
            else showToastDialog(true, 'La cantidad de carga debe ser mayor que cero', 'toast-frm-dialog');
        } else showToastDialog(true, 'La cantidad no puede estar vacia', 'toast-frm-dialog');
        return valid;
    }

    $scope.validFechaRegistro = function () {
        if ($scope.dataForm.fechaRegistro==null) $scope.dataForm.fechaRegistro=new Date();
        return true;
    }

    $scope.validProducto = function (){
        var valid=false;
        if ($scope.dataForm.producto!=null) {
            if ($scope.dataForm.producto.idproducto!=null) valid=true;
        }
        return valid;
    }

    $scope.validIdEmpleado = function (){
        if ($scope.dataForm.idEmpleado!=null) return true;
        else return false;
    }

    $scope.addCarga = function () {
        console.log($scope.dataForm);
        if ($scope.validCantidad() && $scope.validFechaRegistro() && $scope.validProducto() && $scope.validIdEmpleado()) {
            $scope.dataForm.barLoad=true;
            $http({
                url: configuracionGlobal.scripts + '/Actions/productosCategoriaActualizar.php',
                method: 'POST',
                params: {
                    method: 'addCarga'
                },
                data: $scope.dataForm
            }).success(function (r) {
                $scope.dataForm.barLoad=false;
                $("#btnCloseFormCarga").click();
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
                        $scope.cargarDatos($scope.categoria.id);
                        showToastPrincipal(true, "Carga registrada exitosamente");
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
        $scope.dataForm.fechaRegistro=new Date();
    }

    //End Carga de producto 2018-10-01 23:44

});