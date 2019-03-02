panamApp.controller('usoInsumosProceso', function ($scope, configuracionGlobal, $http, $location, $timeout){

    $(document).ready(function () {
        if (document.getElementsByName('idEmpleado')!=null) $scope.loadEmpleado(document.getElementsByName('idEmpleado')[0].value);
        if (document.getElementsByName('numeroProceso')!=null) $scope.setNumeroProceso(document.getElementsByName('numeroProceso')[0].value);
        $timeout(function () {
            if (!$scope.page.components.subController) {
                if (document.getElementsByName('idProceso')!=null && document.getElementsByName('metodoProceso')!=null) $scope.cargarProceso(true, null, document.getElementsByName('idProceso')[0].value, document.getElementsByName('metodoProceso')[0].value);
            }
        }, 1000);
    });

    $scope.page = {
        components: {
            loadBar: false,
            loadSpinner: false,
            loadSpinnerDialog: false,
            subController: false,
            alertPrincipal: {
                status: false,
                color: 'danger',
                mjs: null
            },
            alertDialog: {
                status: false,
                color: 'danger',
                mjs: null
            },
            btnRecargarInsumosPuestoTrabajo: true,
            btnUsarVariosInsumos: false,
            btnUsarTerminarInsumo: true,
            txtFiltroInsumos: null,
            chksInsumos: false,
            fotoTerminacion: false
        },
        data: {
            empleado: {},
            puestoTrabajo: {},
            insumos: [],
            proceso: {},
            numeroProceso: null,
            usosInsumoProceso: [],
            novedadPuestoTrabajo: {
                novedad: null
            },
            insumosId: [],
            imgs: {
                fotoTerminacionUrl: null
            },
            terminacionInsumo: {
                observaciones: null
            },
            insumoUsarYTerminar: {}
        }
    }

    $scope.setNumeroProceso=function (_numeroProceso){
        if (validarInput(_numeroProceso)) $scope.page.data.numeroProceso = _numeroProceso;
        else $scope.page.data.numeroProceso = null;
    }

    $scope.loadEmpleado = function (_id){
        if (validarInput(_id)){
            $http({
                url: configuracionGlobal.scripts + "/datosJSON.php",
                method: 'GET',
                params: {
                    metodo: 'getSimpleJSONEmpleado',
                    id: _id
                }
            }).success(function (r) {
                if (r.length>0) $scope.page.data.empleado = r[0];
                else if (r!=null) $scope.page.data.empleado = r;
                else {
                    //$scope.page.btnRegistrarProceso=true;
                    showToast(true, 'No se pudo cargar el usuario con el que inciaste sesión');
                    //disabledButtonPage('btnRegistrarProceso', true);
                    incompleteData("principal.php?CON=system/pages/unknowData.php");
                }
            }).error(function (r){
                //$scope.page.btnRegistrarProceso=true;
                //disabledButtonPage('btnRegistrarProceso', true);
                showToast(true, 'Error 404: No se encontro el archivo y/o no se pudo conectar al servidor');
                incompleteData("principal.php?CON=system/pages/unknowData.php");
            });
        } else {
            //$scope.page.btnRegistrarProceso=true;
            //disabledButtonPage('btnRegistrarProceso', true);
            showToast(true, 'No se pudo cargar el usuario con el que inciaste sesion');
            incompleteData("principal.php?CON=system/pages/unknowData.php");
        }
    }

    $scope.cargarProceso = function (_http, _object, _id, _metodo){
        if (_http) {
            if (_id!=null && _metodo!=null){
                $scope.page.components.loadSpinner = true;
                $http({
                    url: configuracionGlobal.scripts + "/datosJSON.php",
                    method: 'GET',
                    params: {
                        metodo: _metodo,
                        id: _id
                    }
                }).success(function (r) {
                    $scope.page.components.loadSpinner = false;
                    if (r.length>0 && r[0].id!=null) {
                        $scope.page.data.proceso = r[0];
                        $scope.cargarUsosInsumosProceso();
                    } else if (r.id!=null){
                        $scope.page.data.proceso = r;
                        $scope.cargarUsosInsumosProceso();
                    } else {
                        //$scope.page.btnRegistrarProceso = true;//Desactivar boton de registro
                        showToast(true, 'No se pudo cargar el proceso, vuelve a la pagina anterior e intentalo nuevamente');
                        incompleteData("principal.php?CON=system/pages/unknowData.php");
                    }
                }).error(function (r){
                    $scope.page.components.loadSpinner = false;
                    // $scope.page.btnRegistrarProceso = true;
                    showToast(true, 'Error 404: No se encontro el archivo y/o no se pudo conectar al servidor');
                    incompleteData("principal.php?CON=system/pages/unknowData.php");
                });
            } else {
                //$scope.page.btnRegistrarProceso=true;
                showToast(true, 'No se pudo cargar el proceso, vuelve a la pagina anterior e intentalo nuevamente');
                incompleteData("principal.php?CON=system/pages/unknowData.php");
            }
        } else {
            if (_object!=null) {
                $scope.page.data.proceso = _object;
                $scope.cargarUsosInsumosProceso();
            } else {
                //$scope.page.btnRegistrarProceso=true;
                showToast(true, 'No se pudo cargar el proceso, vuelve a la pagina anterior e intentalo nuevamente');
                incompleteData("principal.php?CON=system/pages/unknowData.php");
            }
        }
    }

    $scope.cargarPuestoTrabajo = function (_http, _object, _id){
        if (_http) {
            if (validarInput(_id)){
                $http({
                    url: configuracionGlobal.scripts + "/datosJSON.php",
                    method: 'GET',
                    params: {
                        metodo: 'getPuestoTrabajoSimpleJSON',
                        id: _Id
                    }
                }).success(function (r){
                    if (r.length>0 && r[0]!=null){
                        //$scope.page.btnPuestoTrabajo=true;
                        $scope.page.data.puestoTrabajo = r[0];
                        $scope.cargarInsumosPuestoTrabajo($scope.page.data.puestoTrabajo.id);
                    } else if (r!=null){
                        //$scope.page.btnPuestoTrabajo=true;
                        $scope.page.data.puestoTrabajo = r;
                        $scope.cargarInsumosPuestoTrabajo($scope.page.data.puestoTrabajo.id);
                    } else {
                        $scope.page.data.puestoTrabajo = {};
                        //$scope.page.btnPuestoTrabajo=false;
                    }
                }).error(function (r){
                    showToast(true, 'Error 404: No se encontro el archivo y/o no se pudo conectar al servidor');
                });
            } else {
                //$scope.page.btnPuestoTrabajo=false;
                $scope.page.data.puestoTrabajo = {};
                $scope.cargarInsumosPuestoTrabajo(null);
            }
        } else {
            if (_object!=null) {
                $scope.page.data.puestoTrabajo = _object;
                $scope.cargarInsumosPuestoTrabajo($scope.page.data.puestoTrabajo.id);
            } else {
                //$scope.page.btnRegistrarProceso=true;
                showToast(true, 'No se pudo cargar el proceso, vuelve a la pagina anterior e intentalo nuevamente');
                incompleteData("principal.php?CON=system/pages/unknowData.php");
            }
        }
    }

    $scope.cargarUsosInsumosProceso =function (){
        if (validarInput($scope.page.data.proceso.id) && validarInput($scope.page.data.numeroProceso)){
            if ($scope.page.data.proceso.usosRegistrados) {
                $scope.page.components.loadSpinner = true;
                $http({
                    url: configuracionGlobal.scripts + "/listadosJSON.php",
                    method: 'GET',
                    params: {
                        metodo: 'getSimpleUsosInsumosProcesoJSON',
                        idProceso: $scope.page.data.proceso.id,
                        proceso: $scope.page.data.numeroProceso
                    }
                }).success(function (r){
                    $scope.page.components.loadSpinner = false;
                    if (r.length>0){
                        $scope.page.data.usosInsumoProceso = r;
                        showToast(true, r.length + ' insumos usados');
                    } else {
                        $scope.page.data.usosInsumoProceso = {};
                        showToast(true, '0 insumos usados');
                    }
                    $scope.seleccionarPuestoTrabajo();
                }).error(function (r){
                    $scope.page.components.loadSpinner = false;
                    $scope.usosInsumoProceso={};
                    $scope.seleccionarPuestoTrabajo();
                    showToast(true, 'Error 404: No se encotro el archivo y/o no se puedo conectar al servidor');
                });
            }
        }
    }
    //REVIZAR
    $scope.validarUsosInsumosProceso = function (){
        /*var valid=false;
        if ($scope.page.data.usosInsumoProceso.length>0) {
            valid=true;
            $scope.page.components.alerta=false;
        } else {
            $scope.page.components.alerta=true;
            $scope.page.components.colorAlerta='warning';
            $scope.page.mjsAlerta='Debes registrar los usos de los insumos en el puesto de trabajo';
            $("#puestoTrabajo").focus();
        }
        return valid;*/
    }

    $scope.seleccionarPuestoTrabajo=function (){
        /*if ($scope.validarUsosInsumosProceso()) {
            $scope.page.data.puestoTrabajo.id = $scope.page.data.usosInsumoProceso.idpuestotrabajoinsumo;
            $scope.page.spnListaPuestosTrabajo=true;
            $scope.page.btnRegistrarProceso=false;
            $("#puestoTrabajo").val($scope.page.idPuestoTrabajo);
            $scope.cargarPuestoTrabajo($scope.page.idPuestoTrabajo);
        } else {
            $("#puestoTrabajo").val($scope.page.data.puestoTrabajo.id);
            $scope.cargarPuestoTrabajo($scope.page.data.puestoTrabajo.id);
            $scope.page.spnListaPuestosTrabajo=false;
            $scope.page.btnRegistrarProceso=true;
        }*/
    }

    $scope.setPuestoTrabajoSelect=function (_idPT){
        // $("#puestoTrabajo").val(_idPT);
    }
    //FIN REVIZAR
    $scope.cargarInsumosPuestoTrabajo = function (_IdPuestoTrabajo){
        $scope.page.data.insumos = [];
        if (validarInput(_IdPuestoTrabajo)){
            $scope.page.components.loadSpinnerDialog = true;
            $http({
                url: configuracionGlobal.scripts + "/listadosJSON.php",
                method: 'GET',
                params: {
                    metodo: 'getSimpleInsumosPuestoTrabajoJSON',
                    idPuestoTrabajo: _IdPuestoTrabajo,
                    extras: true
                }
            }).success(function (r){
                $scope.page.components.loadSpinnerDialog=false;
                if (r.length>0){
                    $scope.page.data.insumos = r;
                    $scope.showAlertDialog(false, null, null);
                } else {
                    $scope.page.data.insumos=[];
                    $scope.showAlertDialog(true, 'danger', 'Al parecer este puesto de trabajo no tiene insumos registrados');
                    showToastDialog(true, 'Este puesto de trabajo no tiene insumos registrados', 'toast-content-dialog');
                }
            }).error(function (r){
                console.log(r);
                $scope.page.components.loadSpinnerDialog=false;
                showToast(true, 'Error 404: No se encotro el archivo y/o no se puedo conectar al servidoe');
                $scope.page.data.insumos=[];
            })
        } else $scope.page.data.insumos=[];
    }

    $scope.getUsado=function (object) {
        var valid=false;
        if (object!=null && $scope.page.data.usosInsumoProceso!=null){
            for (var i=0; i<$scope.page.data.usosInsumoProceso.length; i++){
                if (object.id===$scope.page.data.usosInsumoProceso[i].idinsumopuestotrabajo) {
                    valid=true;
                    i = $scope.page.data.usosInsumoProceso.length;
                }
            }
        }
        return valid;
    }

    $scope.seleccionarAllInsumos=function (){
        if ($scope.page.components.chksInsumos) {
            if ($scope.page.data.insumos.length>0){
                $scope.page.data.insumosId=[];
                for (var i = 0; i < $scope.page.data.insumos.length; i++) {
                    $scope.page.data.insumos[i].chk=true;
                    $scope.page.data.insumosId.push($scope.page.data.insumos[i].id);
                }
                if ($scope.usosInsumoProceso.length>0){
                    for (var i = 0; i < $scope.usosInsumoProceso.length; i++) {
                        for (var j = 0; j < $scope.page.data.insumosId.length; j++) {
                            if ($scope.page.data.insumosId[j]==$scope.usosInsumoProceso[i].idInsumoPt) {
                                $scope.page.data.insumosId[j]=null;
                                //$scope.page.data.insumosId[$scope.page.data.insumosId.indexOf($scope.page.data.insumosId[j])]=null;
                            }
                        }
                        for (var x = 0; x < $scope.page.data.insumos.length; x++) {
                            if ($scope.page.data.insumos[x].id==$scope.usosInsumoProceso[i].idInsumoPt) {
                                $scope.page.data.insumos[x].chk=false;
                                x=$scope.page.data.insumos.length;
                            }
                        }
                    }
                }
            } else showToastDialog(true, 'No hay registros para marcar', 'toast-content-dialog');
        } else {
            if ($scope.page.data.insumos!=null){
                if ($scope.page.data.insumos.length>0){
                    $scope.page.data.insumosId=[];
                    for (var i = 0; i < $scope.page.data.insumos.length; i++) {
                        $scope.page.data.insumos[i].chk=false;
                    }
                } else showToastDialog(true, 'No hay registros para desmarcar', 'toast-content-dialog');
            } else showToastDialog(false, 'No hay registros para desmarcar', 'toast-content-dialog');
        }
        $scope.validarInsumos();
    }

    $scope.separarIdInsumo=function (_chk, _IdInsumo){
        if (_chk){
            //$scope.page.data.insumosId.push(_IdInsumo);
            if ($scope.page.data.insumosId.indexOf(_IdInsumo)!=-1) {
                //
            } else $scope.page.data.insumosId.push(_IdInsumo);
        } else {
            if ($scope.page.data.insumosId.indexOf(_IdInsumo)!=-1) $scope.page.data.insumosId[$scope.page.data.insumosId.indexOf(_IdInsumo)]=null;
            //else $scope.page.data.insumosId.push(_IdInsumo);
        }
        $scope.validarInsumos();
    }

    $scope.validarInsumos=function (){
        valido=false;
        if ($scope.page.data.insumosId.length>0){
            for (var i = 0; i < $scope.page.data.insumosId.length; i++) {
                insumo = $scope.page.data.insumosId[i];
                if (insumo!=null) {
                    valido = true;
                    i = $scope.page.data.insumosId.length;
                    $scope.page.components.btnUsarVariosInsumos = true;
                } else $scope.page.components.btnUsarVariosInsumos = false;
            }
        } else $scope.page.components.btnUsarVariosInsumos = false;
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
        return array;
    }

    $scope.validarDatosProceso = function (){
        var valid=false;
        if (validarInput($scope.page.data.proceso.id!=null)){
            $scope.showAlertDialog(false, null, null);
            valid=true;
        } else {
            $scope.showAlertDialog(true, null, "No se pudo cargar el proceso actual, recarga la pagina e inténtalo nuevamente");
            //$scope.page.btnRegistrarProceso=true;
        }
        return valid;
    }

    $scope.validarDatosEmpleado = function (){
        var valid=false;
        if (validarInput($scope.page.data.empleado.id)){
            $scope.showAlertDialog(false, null, null);
            valid=true;
        } else {
            $scope.showAlertDialog(true, 'danger', 'No se pudo cargar el usuario con el que iniciaste sesion, vuelve a ingresar al sistema');
            //$scope.page.btnRegistrarProceso=true;
        }
        return valid;
    }

    $scope.validarDatosPuestoTrabajo=function (){
        var valid = false;
        if (validarInput($scope.page.data.puestoTrabajo.id)){
            $scope.showAlertDialog(false, null, null);
            valid = true;
        } else {
            $scope.showAlertDialog(true, 'danger', "No se pudo cargar el puesto de trabajo, intenta recargando la pagina pulsando 'F5'");
            //$scope.page.btnRegistrarProceso=true;
        }
        return valid;
    }

    $scope.showAlertDialog = function (status, color, message){
        $scope.page.components.alertDialog.status = status;
        $scope.page.components.alertDialog.color = color;
        $scope.page.components.alertDialog.mjs = message;
    }

    //Registro de uso de insumo
    $scope.usoInsumo={}

    /*$scope.validStockUsed = function(id, _stockUsed){
        var object = null;
        var valid = false;
        for (var i=0; i<$scope.page.data.insumos.length; i++){
            if ($scope.page.data.insumos[i].id=id) {
                object=$scope.page.data.insumos[i];
                i=$scope.page.data.insumos.length;
            }
        }
        if (object!=null){
            if (_stockUsed!=null){
                if (_stockUsed>0){
                    if (_stockUsed<=object.remainingStock) valid=true;
                }
            }
        }
        if (valid) $scope.showAlertDialog(false, null, null);
        else $scope.showAlertDialog(true, "La cantidad que vas a usar no puede ser superior a la disponible (" + _stockUsed + "/" + object.remainingStock + ")");
        return valid;
    }*/

    $scope.usarInsumo=function (_idInsumo, _stockUsed, _metodo){
        /*
         * La variable metodo que se recibe como parametro define si el registro
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
        if (validarInput(_idInsumo)){
            //if ($scope.validarDatosProceso() && $scope.validarDatosEmpleado() && _metodo!=null && $scope.validStockUsed(_idInsumo, _stockUsed)){
            if ($scope.validarDatosProceso() && $scope.validarDatosEmpleado() && _metodo!=null){
                $scope.page.components.loadSpinnerDialog = true;
                $scope.usoInsumo.idEmpleado = $scope.page.data.empleado.id;
                $scope.usoInsumo.idProceso = $scope.page.data.proceso.id;
                $scope.usoInsumo.proceso = $scope.page.data.numeroProceso;
                $scope.usoInsumo.idInsumo = _idInsumo;
                if (_stockUsed!=null) $scope.usoInsumo.cantidad = _stockUsed;
                if ($scope.validarInsumos() && !_metodo) $scope.usoInsumo.insumosId = cortarArray($scope.page.data.insumosId);
                else {
                    $scope.page.components.chksInsumos = false;
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
                    $scope.page.components.loadSpinnerDialog = false;
                    $scope.usoInsumo = {};
                    //$scope.page.data.insumos = [];
                    $scope.cargarUsosInsumosProceso();
                    $scope.page.components.chksInsumos = false;
                    $scope.page.data.insumosId = [];
                    $scope.seleccionarAllInsumos();
                    $scope.cargarInsumosPuestoTrabajo($scope.page.data.puestoTrabajo.id);
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
                    $scope.page.components.loadSpinnerDialog = false;
                    $scope.usoInsumo = {};
                    showToastDialog(true, 'Error 404: no se encontro el archivo y/o no se pudo conectar al servidor', 'toast-content-dialog');
                });
            }
        } else {
            showToastDialog(true, 'No se pudo cargar el insumo, por lo tanto no es posible usarse en este momento', 'toast-content-dialog');
        }
    }

    //Fin Registro de uso de insumo
    //--------------------------------------------------------------------------
    //REGISTRO DE LA TERMINACION DE UN INSUMO
    //$scope.insumoUsarYTerminar={};

    //$scope.seleccionarInsumoUsarYTerminar = function (_insumo){
    $scope.seleccionarInsumoUsarYTerminar = function (_object){
        $scope.page.data.insumoUsarYTerminar = {};
        $scope.page.components.btnUsarTerminarInsumo = true;
        if (_object!=null){
            if (_object.id!=null) {
                $scope.page.data.insumoUsarYTerminar = _object;
                $scope.page.components.btnUsarTerminarInsumo = false;
            }
        } else showToastDialog(true, 'No se pudo cargar el insumo o la herramienta', 'toast-content-dialog');
    }

    $scope.terminarInsumo = function (_idInsumo, usar){
        /*
         * Esta funcion sirve para registrar la terminacion de un insumo apartir
         * del id del insumo de un puesto de trabajo (variable que se recibe
         * como parametro), el id del empleado que es el usuario con el que se
         * inicia sesion y la respectiva foto que evidencia la terminacion del
         * insumo
         */
        var formData=new FormData();
        formData.append("name", "fotoTerminacion");
        formData.append("file", $scope.file);
        $scope.page.components.loadSpinnerDialog = true;
        $("#btnRegresarLista_2").click();
        $http({
            url: configuracionGlobal.scripts + "/cruds.php",
            method: 'POST',
            data: formData,
            params: {
                metodo: 'crudUsosInsumos',
                accion: 'Terminar',
                idInsumo: _idInsumo,
                idEmpleado: $scope.page.data.empleado.id,
                observaciones: $scope.page.data.terminacionInsumo.observaciones
            },
            headers: {'Content-type': undefined},
            transformRequest: angular.identity
        }).success(function (r){
            $scope.page.components.loadSpinnerDialog = false;
            if (!usar) {
                $scope.usoInsumo = {};
                $scope.page.components.chksInsumos = false;
                $scope.seleccionarAllInsumos();
                $scope.page.data.insumosId = [];
                $scope.cargarUsosInsumosProceso();
                $scope.cargarInsumosPuestoTrabajo($scope.page.data.puestoTrabajo.id);
            }
            $scope.limpiarUsarYTerminarInsumo();
            switch (r) {
                case 'OK':
                    showToastDialog(true, 'Acción ejecutada exitosamente', 'toast-content-dialog');
                    break;
                case 'SD':
                    showToastDialog(true, 'Solicitud desconocida, intentalo nuevamente', 'toast-content-dialog');
                    break;
                case 'IR':
                    showToastDialog(true, 'Solicitud invalida, intentalo nuevamente', 'toast-content-dialog');
                    break;
                case 'ID':
                    showToastDialog(true, 'No se pudo completar la acción por falta de datos', 'toast-content-dialog');
                    break;
                case 'SDE':
                    showToastDialog(true, 'Uoops! ocurrio un error al guardar el registro', 'toast-content-dialog');
                    break;
                default:
                    showToastDialog(true, 'Error desconocido', 'toast-content-dialog');
                    break;
            }
        }).error(function (r){
            $scope.page.components.loadSpinnerDialog = false;
            $scope.limpiarUsarYTerminarInsumo();
            showToastDialog(true, 'Error 404: no se encontro el archivo y/o no se pudo conectar al servidor', 'toast-content-dialog');
        });
    }
    
    $scope.limpiarUsarYTerminarInsumo=function (){
        $scope.deleteImg();
        $scope.page.data.terminacionInsumo.observaciones = null;
        $scope.showAlertDialog(false, null, null);
    }
    
    //$scope.UsarYTerminarInsumo = function (_idInsumo, metodo){
    $scope.UsarYTerminarInsumo = function (metodo){
        /*
         * TRUE: registra el uso del insumo y la terminacion.
         * ELSE: registra unicamente la terminacion
         */
        if ($scope.page.data.insumoUsarYTerminar!=null) {
            if (validarInput($scope.page.data.insumoUsarYTerminar.id!=null) && metodo!=null){
                // console.log($scope.validarFotoTerminacion());
                // console.log($scope.file!=null);
                if ($scope.validarFotoTerminacion() && $scope.file!=null){
                    if ($scope.validarDatosEmpleado()){
                        if (metodo) $scope.usarInsumo($scope.page.data.insumoUsarYTerminar.id, null,true);
                        $scope.terminarInsumo($scope.page.data.insumoUsarYTerminar.id, metodo);
                    }
                } else $scope.showAlertDialog(true, 'warning', 'Debes subir una foto que evidencie la terminacion del insumo');
            } else showToastDialog(true, "No se pudo cargar el insumo o la herramienta, intentalo nuevamente", 'toast-content-dialog');
        } else showToastDialog(true, "No se pudo cargar el insumo o la herramienta, intentalo nuevamente", 'toast-content-dialog');
    }
    //FIN REGISTRO DE LA TERMINACION DE UN INSUMO
    //--------------------------------------------------------------------------
    //FUNCIONES IMAGENES DIALOGO PUESTO TRABAJO
    $scope.validarFotoTerminacion = function (){
        var valid = false;
        if ($scope.page.components.fotoTerminacion){
            if ($scope.file!=null) {
                valid = true;
                $scope.showAlertDialog(false, null, null);
            } else $scope.showAlertDialog(true, 'warning', 'Debes subir una foto que evidencie la terminación del insumo o la herramienta');
        } else $scope.showAlertDialog(true, 'warning', 'Debes subir una foto que evidencie la terminación del insumo o la herramienta');
        return valid;
    }

    $scope.fileReaderSupported = window.FileReader!=null;
    
    $scope.photoChanged = function(files){
        if (files!=null){
            var file = files[0];
            if (file!=null){
                if ($scope.fileReaderSupported && file.type.indexOf('image') > -1){
                    if ($scope.file==null) $scope.file = file;
                    $timeout(function (){
                        var fileReader = new FileReader();
                        fileReader.readAsDataURL(file);
                        fileReader.onload = function (e){
                            $timeout(function (){
                                $scope.page.data.imgs.fotoTerminacionUrl = e.target.result;
                                $scope.page.components.fotoTerminacion = true;
                                $scope.validarFotoTerminacion();
                            });
                        }
                    });
                } else $scope.deleteImg();
            } else $scope.deleteImg();
        }
    }
    
    $scope.deleteImg = function (){
        $scope.page.components.fotoTerminacion = false;
        $scope.page.data.imgs.fotoTerminacionUrl = null;
        $scope.file = null;
        $('#fotoTerminacion').val(null);
        $('#fotoUsarTerminar').val(null);
        $scope.validarFotoTerminacion();
    }
    //FIN FUNCIONES IMAGENES DIALOGO PUESTO TRABAJO
    //------------------------------------------------------------------------------------------------------------------
    //Registro de novedad para puesto de trabajo
    $scope.registrarNovedad=function (form){
        if (form.$valid && $scope.validarDatosEmpleado() && $scope.validarDatosPuestoTrabajo() && validarInput($scope.page.data.novedadPuestoTrabajo.novedad)){
            $scope.page.components.loadSpinnerDialog = true;
            $scope.page.data.novedadPuestoTrabajo.idPuestoTrabajo = $scope.page.data.puestoTrabajo.id;
            $scope.page.data.novedadPuestoTrabajo.idEmpleado = $scope.page.data.empleado.id;
            $http({
                url: configuracionGlobal.scripts + "/cruds.php",
                method: 'POST',
                data: $scope.page.data.novedadPuestoTrabajo,
                params: {
                    metodo: 'registrarNovedad'
                },
                headers: {
                    'Content-type': 'application/x-www-form-urlencoded'
                }
            }).success(function (r) {
                $scope.page.components.loadSpinnerDialog = false;
                $scope.cleanNovedadPuestoTrabajo();
                switch (r) {
                    case 'OK':
                        showToastDialog(true, 'Novedad enviada exitosamente', 'toast-content-dialog');
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
            }).error(function (r) {
                $scope.page.components.loadSpinnerDialog = false;
                showToastDialog(true, 'Error 404: no se encontro el archivo y/o no se pudo conectar al servidor', 'toast-content-dialog');
                $scope.cleanNovedadPuestoTrabajo();
            });
        } else showToastDialog(true, 'No se puede completar la accion', 'toast-content-dialog');
    };
    
    $scope.cleanNovedadPuestoTrabajo = function (){
        $scope.page.data.novedadPuestoTrabajo.novedad = null;
    };
    //Fin Registro de novedad para puesto de trabajo
});
/*
$(document).ready(function () {
    $("#cargarDatos").click();
});*/