panamApp.controller('usosInsumosPuestoTrabajo', function ($scope, configuracionGlobal, $http, $location){
    
    $scope.html={
        barraCargaPrincipal: false,
        spinnerCargaDialogo: false,
        spnListaPuestosTrabajo: true,
        idPuestoTrabajo: "#",
        numeroProceso: null,
        btnPuestoTrabajo: false,
        chksInsumo: false,
        insumosId: [],
        vIdEmpleado: false,
        vIdProceso: false,
        btnRegistrarProceso: true,
        alerta: false,
        colorAlerta: 'default',
        mjsAlerta: '',
        mjsAlertaResaltado: '',
        btnUsarVariosInsumos: false
    }
    
    $scope.puestoTrabajo={};
    $scope.proceso={};
    $scope.empleado={};
    $scope.usosInsumoProceso={};
    
    $scope.cargarProceso=function (_Id, _Metodo){
        if (_Id!=null && _Id!=''){
            $http({
                url: configuracionGlobal.scripts + "/datosJSON.php",
                method: 'GET',
                params: {
                    metodo: _Metodo,
                    id: _Id
                }
            }).success(function (r) {
                if (r.length>0 && r[0].id!=null) {
                    $scope.proceso=r[0];
                    $scope.html.vIdProceso=true;
                    $scope.cargarUsosInsumosProceso();
                }
                else {
                    showToast(true, 'No se pudo cargar el proceso, vuelve a la pagina anterior e intentalo nuevamente');
                    $scope.html.btnRegistrarProceso=true;
                }
            }).error(function (r){
                showToast(true, 'Error 404: No se encontro el archivo y/o no se pudo conectar al servidor');
                $scope.html.btnRegistrarProceso=true;
            });
        } else {
            showToast(true, 'No se pudo cargar el proceso, vuelve a la pagina anterior e intentalo nuevamente');
            $scope.html.btnRegistrarProceso=true;
        }
    }
    
    $scope.cargarEmpleado=function (_Id){
        if (_Id!=null && _Id!=''){
            $http({
                url: configuracionGlobal.scripts + "/datosJSON.php",
                method: 'GET',
                params: {
                    metodo: 'getEmpleadoJSON',
                    id: _Id
                }
            }).success(function (r) {
                if (r.length>0) {
                    $scope.empleado=r[0];
                    $scope.html.vIdEmpleado=true;
                }
                else {
                    showToast(true, 'No se pudo cargar el usuario con el que inciaste sesion');
                    $scope.html.btnRegistrarProceso=true;
                }
            }).error(function (r){
                showToast(true, 'Error 404: No se encontro el archivo y/o no se pudo conectar al servidor');
                $scope.html.btnRegistrarProceso=true;
            });
        } else {
            showToast(true, 'No se pudo cargar el usuario con el que inciaste sesion');
            $scope.html.btnRegistrarProceso=true;
        }
    }
    
    $scope.setNumeroProceso=function (_numeroProceso){
        if (_numeroProceso!=null && _numeroProceso!='') $scope.html.numeroProceso=_numeroProceso;
        else $scope.html.numeroProceso=null;
    }
    
    $scope.cargarPuestoTrabajo=function (_Id){
        if (_Id!=null && _Id!='' && _Id!='#'){
            $http({
                url: configuracionGlobal.scripts + "/datosJSON.php",
                method: 'GET',
                params: {
                    metodo: 'getPuestoTrabajoJSON',
                    id: _Id
                }
            }).success(function (r){
                if (r.length>0){
                    $scope.puestoTrabajo=r[0];
                    $scope.html.btnPuestoTrabajo=true;
                    $scope.cargarInsumosPuestoTrabajo($scope.puestoTrabajo.id);
                } else {
                    $scope.puestoTrabajo={};
                    $scope.html.btnPuestoTrabajo=false;
                }
            }).error(function (r){
                showToast(true, 'Error 404: No se encontro el archivo y/o no se pudo conectar al servidor');
            });
        } else {
            $scope.puestoTrabajo={};
            $scope.cargarInsumosPuestoTrabajo(null);
            $scope.html.btnPuestoTrabajo=false;
        }
    }
    
    $scope.cargarUsosInsumosProceso=function (){
        if ($scope.proceso.id!=null && $scope.proceso.id!='' && $scope.html.numeroProceso!=null){
            $scope.html.barraCargaPrincipal=true;
            $http({
                url: configuracionGlobal.scripts + "/listadosJSON.php",
                method: 'GET',
                params: {
                    metodo: 'getUsosInsumoProceso',
                    idProceso: $scope.proceso.id,
                    proceso: $scope.html.numeroProceso
                }
            }).success(function (r){
                $scope.html.barraCargaPrincipal=false;
                console.log(r);
                if (r.length>0){
                    $scope.usosInsumoProceso=r;
                    showToast(true, r.length + ' insumos usados');
                } else {
                    $scope.usosInsumoProceso={};
                    showToast(true, '0 insumos usados');
                }
                $scope.seleccionarPuestoTrabajo();
            }).error(function (r){
                $scope.html.barraCargaPrincipal=false;
                showToast(true, 'Error 404: No se encotro el archivo y/o no se puedo conectar al servidoe');
                $scope.usosInsumoProceso={};
                $scope.seleccionarPuestoTrabajo();
            });
        }
    }
    
    $scope.validarUsosInsumosProceso=function (){
        var valid=false;
        if ($scope.usosInsumoProceso.length>0) {
            console.log("ok");
            valid=true;
            $scope.html.alerta=false;
        } else {
            $scope.html.alerta=true;
            $scope.html.colorAlerta='warning';
            $scope.html.mjsAlerta='Debes registrar los usos de los insumos en el puesto de trabajo';
            $("#puestoTrabajo").focus();
        }
        return valid;
    }
    
    $scope.seleccionarPuestoTrabajo=function (){
        if ($scope.validarUsosInsumosProceso()) {
            $scope.html.idPuestoTrabajo=$scope.usosInsumoProceso[0].insumoPT[0].idPuestoTrabajo;
            console.log($scope.html);
            $scope.html.spnListaPuestosTrabajo=true;
            $scope.html.btnRegistrarProceso=false;
            $("#puestoTrabajo").val($scope.html.idPuestoTrabajo);
            $scope.cargarPuestoTrabajo($scope.html.idPuestoTrabajo);
        } else {
            $scope.html.spnListaPuestosTrabajo=false;
            $scope.html.btnRegistrarProceso=true;
        }
    }
    
    $scope.setPuestoTrabajoSelect=function (_idPT){
        $("#puestoTrabajo").val(_idPT);
    }
    
    $scope.cargarInsumosPuestoTrabajo=function (_IdPuestoTrabajo){
        $scope.insumos=null;
        if (_IdPuestoTrabajo!=null && _IdPuestoTrabajo!='' && _IdPuestoTrabajo!='#'){
            $scope.html.spinnerCargaDialogo=true;
            $http({
                url: configuracionGlobal.scripts + "/listadosJSON.php",
                method: 'GET',
                params: {
                    metodo: 'getInsumosPuestoTrabajo',
                    idPT: _IdPuestoTrabajo
                }
            }).success(function (r){
                $scope.html.spinnerCargaDialogo=false;
                if (r.length>0){
                    $scope.insumos=r;
                } else {
                    $scope.insumos={};
                    showToastDialog(true, 'Este puesto de trabajo no tiene insumos registrados', 'toast-content-dialog');
                }
            }).error(function (r){
                $scope.html.spinnerCargaDialogo=false;
                showToast(true, 'Error 404: No se encotro el archivo y/o no se puedo conectar al servidoe');
                $scope.insumos={};
            })
        } else $scope.insumos={};
    }
    
    $scope.seleccionarAllInsumos=function (){
        if ($scope.html.chksInsumos) {
            if ($scope.insumos.length>0){
                $scope.html.insumosId=[];
                for (var i = 0; i < $scope.insumos.length; i++) {
                    $scope.insumos[i].chk=true;
                    $scope.html.insumosId.push($scope.insumos[i].id);
                }
                if ($scope.usosInsumoProceso.length>0){
                    for (var i = 0; i < $scope.usosInsumoProceso.length; i++) {
                        for (var j = 0; j < $scope.html.insumosId.length; j++) {
                            if ($scope.html.insumosId[j]==$scope.usosInsumoProceso[i].idInsumoPt) {
                                $scope.html.insumosId[j]=null;
                                //$scope.html.insumosId[$scope.html.insumosId.indexOf($scope.html.insumosId[j])]=null;
                            }
                        }
                        for (var x = 0; x < $scope.insumos.length; x++) {
                            if ($scope.insumos[x].id==$scope.usosInsumoProceso[i].idInsumoPt) {
                                $scope.insumos[x].chk=false;
                                x=$scope.insumos.length;
                            }
                        }
                    }
                }
            } else showToastDialog(true, 'No hay registros para marcar', 'toast-content-dialog');
        } else {
            if ($scope.insumos!=null){
                if ($scope.insumos.length>0){
                    $scope.html.insumosId=[];
                    for (var i = 0; i < $scope.insumos.length; i++) {
                        $scope.insumos[i].chk=false;
                    }
                } else showToastDialog(true, 'No hay registros para desmarcar', 'toast-content-dialog');
            } else showToastDialog(false, 'No hay registros para desmarcar', 'toast-content-dialog');
        }
        $scope.validarInsumos();
        console.log($scope.html.insumosId);
    }
    
    $scope.separarIdInsumo=function (_chk, _IdInsumo){
        if (_chk){
            //$scope.html.insumosId.push(_IdInsumo);
            if ($scope.html.insumosId.indexOf(_IdInsumo)!=-1) {
                //
            } else $scope.html.insumosId.push(_IdInsumo);
        } else {
            if ($scope.html.insumosId.indexOf(_IdInsumo)!=-1) $scope.html.insumosId[$scope.html.insumosId.indexOf(_IdInsumo)]=null;
            //else $scope.html.insumosId.push(_IdInsumo);
        }
        $scope.validarInsumos();
        console.log($scope.html.insumosId);
    }
    
    $scope.validarInsumos=function (){
        valido=false;
        if ($scope.html.insumosId.length>0){
            for (var i = 0; i < $scope.html.insumosId.length; i++) {
                insumo=$scope.html.insumosId[i];
                if (insumo!=null) {
                    valido=true;
                    i=$scope.html.insumosId.length;
                    $scope.html.btnUsarVariosInsumos=true;
                } else $scope.html.btnUsarVariosInsumos=false;
            }
        } else $scope.html.btnUsarVariosInsumos=false;
        //if (valido) $scope.chequeados=true;
        //else $scope.chequeados=false;
        return valido;
    }
    
    function cortarArray(_Array){
        var array="";
        var datos=[];
        if (_Array!=null){
            for (var i = 0; i < _Array.length; i++) {
                var dato=_Array[i];
                if (dato!=null){
                    datos.push(dato);
                }
            }
            for (var i = 0; i < datos.length; i++) {
                var dato=datos[i];
                if (dato!=null){
                    if (i<datos.length-1) auxiliar="|";
                    else auxiliar ="";
                    array+=dato+auxiliar;
                }
            }
        }
        console.log(array);
        return array;
    }
    
    $scope.validarDatosProceso=function (){
        var valid=false;
        if ($scope.proceso.id!=null && $scope.proceso.id!=''){
            $scope.html.vIdProceso=true;
            $scope.html.alerta=false;
            valid=true;
        } else {
            $scope.html.vIdProceso=false;
            $scope.html.alerta=true;
            $scope.html.colorAlerta="danger";
            $scope.html.mjsAlerta="";
            $scope.html.mjsAlertaResaltado="No se pudo cargar el proceso actual, recarga la pagina e intentalo nuevamente";
            $scope.html.btnRegistrarProceso=true;
        }
        return valid;
    }
    
    $scope.validarDatosEmpleado=function (){
        var valid=false;
        if ($scope.empleado.id!=null && $scope.empleado.id!=''){
            $scope.html.vIdEmpleado=true;
            $scope.html.alerta=false;
            valid=true;
        } else {
            $scope.html.vIdEmpleado=false;
            $scope.html.alerta=true;
            $scope.html.colorAlerta="danger";
            $scope.html.mjsAlerta="";
            $scope.html.mjsAlertaResaltado="No se pudo cargar el usuario con el que iniciaste sesion, vuelve a ingresar al sistema";
            $scope.html.btnRegistrarProceso=true;
        }
        return valid;
    }
    
    //Registro de uso de insumo
    $scope.usoInsumo={}
    
    $scope.usarInsumo=function (_idInsumo, _metodo){
        /*
         * La variable metodo que se recibe ocmo parametro define si el registro
         * se hace de forma individual o de forma grupal;
         * 
         * TRUE: metodo individual, lo que significa que solo se va ha registrar
         * un uso.
         * 
         * FALSE: metodo grupal, lo que significa que se hace un registro grupal
         * y que por lo tanto la variable $scope.usoInsumo.insumosId se incluye
         * en la data enviada
         * 
         */
        if (_idInsumo!=null && _idInsumo!=''){
            if ($scope.validarDatosProceso() && $scope.validarDatosEmpleado() && _metodo!=null){
                $scope.html.spinnerCargaDialogo=true;
                $scope.usoInsumo.idEmpleado=$scope.empleado.id;
                $scope.usoInsumo.idProceso=$scope.proceso.id;
                $scope.usoInsumo.proceso=$scope.html.numeroProceso;
                $scope.usoInsumo.idInsumo=_idInsumo;
                if ($scope.validarInsumos() && !_metodo) $scope.usoInsumo.insumosId=cortarArray($scope.html.insumosId);
                else {
                    $scope.html.chksInsumos=false;
                    $scope.seleccionarAllInsumos();
                }
                $http({
                    url: configuracionGlobal.scripts + "/cruds.php",
                    method: 'POST',
                    data: $scope.usoInsumo,
                    params: {
                        metodo: 'crudUsosInsumos',
                        accion: 'Usar'
                    }
                }).success(function (r){
                    //$scope.html.spinnerCargaDialogo=true;
                    $scope.insumos=null;
                    $scope.cargarUsosInsumosProceso();
                    $scope.usoInsumo={};
                    $scope.html.chksInsumos=false;
                    $scope.html.insumosId=[];
                    $scope.seleccionarAllInsumos();
                    //$scope.cargarInsumosPuestoTrabajo($scope.puestoTrabajo.id);
                    switch (r) {
                        case 'OK':
                            showToastDialog(true, 'Uso registrado exitosamente', 'toast-content-dialog');
                            break;
                        case 'SD':
                            showToastDialog(true, 'Solicitud desconocida, intentalo nuevamente', 'toast-content-dialog');
                            break;
                        case 'IR':
                            showToastDialog(true, 'Solicitud invalida, intentalo nuevamente', 'toast-content-dialog');
                            break;
                        case 'ID':
                            showToastDialog(true, 'No se pudo completar la accion por falta de datos', 'toast-content-dialog');
                            break;
                        case 'SDE':
                            showToastDialog(true, 'Uoops! ocurrio un error al guardar el registro', 'toast-content-dialog');
                            break;
                            
                        default:
                            showToastDialog(true, 'Error desconocido', 'toast-content-dialog');
                            break;
                    }
                }).error(function (r){
                    $scope.html.spinnerCargaDialogo=false;
                    $scope.usoInsumo={};
                    showToastDialog(true, 'Error 404: no se encontro el archivo y/o no se pudo conectar al servidor', 'toast-content-dialog');
                });
            }
        } else {
            showToastDialog(true, 'No se pudo cargar el insumo, por lo tanto no es posible usarse en este momento', 'toast-content-dialog');
        }
    }
    
    //Fin Registro de uso de insumo
    
    //REGISTRO DE LA TERMINACION DE UN INSUMO
    //
    $scope.terminacionInsumo={}
    
    $scope.terminarInsumo=function (_idInsumo){
        /*
         * Esta funcion sirve para registrar la terminacion de un insumo apartir
         * del id del insumo de un puesto de trabajo (variable que se recibe 
         * como parametro), el id del empleado que es el usuario con el que se 
         * inicia sesion y la respectiva foto que evidencia la terminacion del
         * insumo
         */
        if (_idInsumo!=null && _idInsumo!='' && _idInsumo!='#'){
            
        }
    }
    //
    //FIN REGISTRO DE LA TERMINACION DE UN INSUMO
    
    
    
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

$(document).ready(function () {
    $("#cargarDatos").click();
})