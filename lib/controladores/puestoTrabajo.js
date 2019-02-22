panamApp.controller('puestoTrabajo', function ($scope, configuracionGlobal, $http, $location){
    $http.get(configuracionGlobal.scripts + "/listadosJSON.php?metodo=getPuestosTrabajosJSON").then(function (respuesta){
        //console.log(respuesta);
        $scope.objetos=respuesta.data;
    })
    $scope.cargarLista=function(){
    	$http.get(configuracionGlobal.scripts + "/listadosJSON.php?metodo=getPuestosTrabajosJSON").then(function (respuesta){
            console.log(respuesta);
            $scope.objetos=respuesta.data;
        })
    }
    
    $scope.html={
        spinnerCargaDialogo: false
    }
    $scope.puestoTrabajo={};
    
    $scope.cargarPuestoTrabajo=function (_Id){
        if (_Id!=null && _Id!='' && _Id!='#'){
            $http.get(configuracionGlobal.scripts + "/datosJSON.php?metodo=getPuestoTrabajoJSON&id="+_Id).then(function (respuesta){
                //console.log(respuesta);
                $scope.puestoTrabajo=respuesta.data[0];
                $scope.cargarInsumosPuestoTrabajo(_Id);
            })
        } else {
            $scope.puestoTrabajo=null;
            $scope.cargarInsumosPuestoTrabajo(null);
        }
    }
    
    $scope.cargarInsumosPuestoTrabajo=function (_IdPuestoTrabajo){
        if (_IdPuestoTrabajo!=null && _IdPuestoTrabajo!='' && _IdPuestoTrabajo!='#'){
            $http({
                url: configuracionGlobal.scripts + "/listadosJSON.php",
                method: 'GET',
                params: {
                    metodo: 'getInsumosPuestoTrabajoJSON',
                    idPT: _IdPuestoTrabajo
                }
            }).then(function (responsive){
                //console.log(responsive);
                $scope.insumos=responsive.data;
            });
        } else $scope.insumos=null;
    }
    
    //Registro de insumo para puesto de trabajo
    
    $scope.insumoPT={};
    
    $scope.registrarInsumo=function (_PuestoTrabajo){
        if (_PuestoTrabajo.id!=null && _PuestoTrabajo.id!='' && _PuestoTrabajo.id!='#'){
            $scope.insumoPT.idPuestoTrabajo=_PuestoTrabajo.id;
            $http({
                url: configuracionGlobal.scripts + "/cruds.php",
                method: 'POST',
                data: $scope.insumoPT,
                params: {
                    metodo: 'registrarInsumo'
                },
                headers: {
                    'Content-type': 'application/x-www-form-urlencoded'
                }
            }).then(function (responsive) {
                //console.log(responsive);
                $scope.limpiarVariables($scope.insumoPT.usuario);
                $scope.cargarInsumosPuestoTrabajo(_PuestoTrabajo.id);
            });
        }
    };
    
    $scope.limpiarVariables=function (_usuario){
        $scope.insumoPT={
            idInsumo: '#',
            cantidad: 1,
            usuario: _usuario
        };
    };
    
    //Fin Registro de insumo para puesto de trabajo
    
    //Registro de novedad para puesto de trabajo
    
    $scope.novedadPT={};
    
    $scope.registrarNovedad=function (_PuestoTrabajo){
        if (_PuestoTrabajo.id!=null && _PuestoTrabajo.id!='' && _PuestoTrabajo.id!='#'){
            $scope.novedadPT.idPuestoTrabajo=_PuestoTrabajo.id;
            $http({
                url: configuracionGlobal.scripts + "/cruds.php",
                method: 'POST',
                data: $scope.novedadPT,
                params: {
                    metodo: 'registrarNovedad'
                },
                headers: {
                    'Content-type': 'application/x-www-form-urlencoded'
                }
            }).then(function (responsive) {
                console.log(responsive);
                $scope.limpiarVariablesNovedad($scope.novedadPT.idEmpleado);
            });
        }
    };
    
    
    $scope.limpiarVariablesNovedad=function (_idEmpleado){
        $scope.novedadPT={
            idEmpleado: _idEmpleado
        };
    };
    
    //Fin Registro de novedad para puesto de trabajo 
    //
    //Registro de terminacion para un insumo
    //
    $scope.terminacion={};
    
    $scope.registrarTerminacion=function (_Insumo, _PuestoTrabajo){
        //console.log(_Insumo);
        if (_Insumo.id!=null && _Insumo.id!=''){
            $scope.terminacion.idInsumoPT=_Insumo.id;
            //console.log($scope.terminacion);
            $http({
                url: configuracionGlobal.scripts + "/cruds.php",
                method: 'POST',
                data: $scope.terminacion,
                params: {
                    metodo: 'terminarInsumo'
                },
                headers: {
                    'Content-type': 'application/x-www-form-urlencoded'
                }
            }).then(function (responsive) {
                console.log(responsive);
                $scope.limpiarVariablesTerminacion($scope.terminacion.idEmpleado);
                $scope.cargarInsumosPuestoTrabajo(_PuestoTrabajo.id);
            });
        }
    };
    
    
    $scope.limpiarVariablesTerminacion=function (_idEmpleado){
        $scope.terminacion={
            idEmpleado: _idEmpleado
        };
    };
    
    //Fin Registro de terminacion para un insumo
    
});   