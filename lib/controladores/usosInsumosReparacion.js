panamApp.controller('usosInsumosReparacion', function ($scope, configuracionGlobal, $http, $location, $timeout){

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
        btnUsarVariosInsumos: false,
        btnRecargarInsumos: true,
        fotoTerminacion: false,
        imgTerminacion: null,
        alertaDialogo: false,
        colorAlertaDialogo: 'default',
        mjsAlertaDialogo: null,
        noInsumo: false
    }
    
    $scope.puestoTrabajo={};
    $scope.proceso={};
    $scope.empleado={};
    $scope.usosInsumoProceso={};
    
    $scope.cargarProceso=function (_Id, _Metodo){
        if (_Id!=null && _Id!=''){
            $scope.html.barraCargaPrincipal=true;
            $http({
                url: configuracionGlobal.scripts + "/datosJSON.php",
                method: 'GET',
                params: {
                    metodo: _Metodo,
                    id: _Id
                }
            }).success(function (r) {
                //console.log(r);
                $scope.html.barraCargaPrincipal=false;
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
                $scope.html.barraCargaPrincipal=false;
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
                    $scope.html.noInsumo=false;
                } else {
                    $scope.insumos=null;
                    $scope.html.noInsumo=true;
                    showToastDialog(true, 'Este puesto de trabajo no tiene insumos registrados', 'toast-content-dialog');
                    showToastDialog(true, 'Este puesto de trabajo no tiene insumos registrados', 'toast-content');
                }
            }).error(function (r){
                $scope.html.spinnerCargaDialogo=false;
                showToast(true, 'Error 404: No se encotro el archivo y/o no se puedo conectar al servidoe');
                $scope.insumos={};
            })
        } else $scope.insumos={};
    }
    
    $scope.getUsado=function (object) {
        var valid=false;
        if (object!=null && $scope.usosInsumoProceso!=null){
            //console.log($scope.usosInsumoProceso);
            for (var i=0; i<$scope.usosInsumoProceso.length; i++){
                if (object.id==$scope.usosInsumoProceso[i].idInsumoPt) {
                    //console.log("id: " + object.id);
                    //console.log("idINPT: " + $scope.usosInsumoProceso[i].idInsumoPt);
                    valid=true;
                    i=$scope.usosInsumoProceso.length;
                }
            }
        }
        //console.log(valid);
        return valid;
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
    
    $scope.validarDatosPuestoTrabajo=function (){
        var valid=false;
        if (validarInput($scope.puestoTrabajo.id)){
            $scope.html.alerta=false;
            valid=true;
        } else {
            $scope.html.alerta=true;
            $scope.html.colorAlerta="danger";
            $scope.html.mjsAlerta="";
            $scope.html.mjsAlertaResaltado="No se pudo cargar el puesto de trabajo, intenta recargando la pagina pulsando 'F5'";
            $scope.html.btnRegistrarProceso=true;
        }
        return valid;
    }
    
    $scope.showAlertaDialogo=function (valid, color, message){
        if (valid) {
            $scope.html.alertaDialogo=true;
            $scope.html.colorAlertaDialogo=color;
            $scope.html.mjsAlertaDialogo=message;
        } else  $scope.html.alertaDialogo=false;
    }
    
    //Registro de uso de insumo
    $scope.usoInsumo={}

    //INSERTADO EL 2018-09-09
    $scope.validStockUsed=function(id, _stockUsed){
        var object=null;
        var valid=false;
        for (var i=0; i<$scope.insumos.length; i++){
            if ($scope.insumos[i].id==id) {
                object=$scope.insumos[i];
                i=$scope.insumos.length;
            }
        }
        //console.log(object);
        if (object!=null){
            if (_stockUsed!=null){
                if (_stockUsed>0){
                    if (_stockUsed<=object.remainingStock) valid=true;
                }
            }
        }
        if (valid) $scope.showAlertaDialogo(false, null, null);
        else $scope.showAlertaDialogo(true, "La cantidad que vas a usar no puede ser superior a la disponible (" + _stockUsed + "/" + object.remainingStock + ")");
        return valid;
    }
    //FIN INSERTADO EL 2018-09-09

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
        /*2018-09-25 10:32
        console.log($scope.validarDatosProceso());
        console.log($scope.validarDatosEmpleado());
        console.log(_metodo!=null);
        console.log($scope.validStockUsed(_idInsumo, _stockUsed));*/
        if (_idInsumo!=null && _idInsumo!=''){
            if ($scope.validarDatosProceso() && $scope.validarDatosEmpleado() && _metodo!=null && $scope.validStockUsed(_idInsumo, _stockUsed)){
                $scope.html.spinnerCargaDialogo=true;
                $scope.usoInsumo.idEmpleado=$scope.empleado.id;
                $scope.usoInsumo.idProceso=$scope.proceso.id;
                $scope.usoInsumo.proceso=$scope.html.numeroProceso;
                $scope.usoInsumo.idInsumo=_idInsumo;
                $scope.usoInsumo.cantidad=_stockUsed;
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
            } else console.log("error");
        } else {
            showToastDialog(true, 'No se pudo cargar el insumo, por lo tanto no es posible usarse en este momento', 'toast-content-dialog');
        }
    }
    
    //Fin Registro de uso de insumo
    //--------------------------------------------------------------------------
    //REGISTRO DE LA TERMINACION DE UN INSUMO
    //
    $scope.insumoUsarYTerminar={};
    
    $scope.seleccionarInsumoUsarYTerminar=function (_insumo){
        if (_insumo!=null){
            $scope.insumoUsarYTerminar=_insumo;
        } else {
            $scope.insumoUsarYTerminar={};
            showToastDialog(true, 'No se pudo cargar el insumo', 'toast-content-dialog');
        }
    }
    
    $scope.terminacionInsumo={
        observaciones: null
    }
    
    $scope.terminarInsumo=function (_idInsumo){
        /*
         * Esta funcion sirve para registrar la terminacion de un insumo apartir
         * del id del insumo de un puesto de trabajo (variable que se recibe 
         * como parametro), el id del empleado que es el usuario con el que se 
         * inicia sesion y la respectiva foto que evidencia la terminacion del
         * insumo
         */
        var formData=new FormData();
        formData.append("name", "foto");
        formData.append("file", $scope.file);
        $scope.html.spinnerCargaDialogo=true;
        $("#btnRegresarLista_2").click();
        $http({
            url: configuracionGlobal.scripts + "/cruds.php",
            method: 'POST',
            data: formData,
            params: {
                metodo: 'crudUsosInsumos',
                accion: 'Terminar',
                idInsumo: _idInsumo,
                idEmpleado: $scope.empleado.id,
                observaciones: $scope.terminacionInsumo.observaciones
            },
            headers: {'Content-type': undefined},
            transformRequest: angular.identity
        }).success(function (r){
            /*
            2018-05-27
            $scope.insumos=null;
            $scope.limpiarUsarYTerminarInsumo();
            $scope.cargarUsosInsumosProceso();
            */

            //NUEVO
            $scope.insumos=null;
            $scope.cargarUsosInsumosProceso();
            $scope.usoInsumo={};
            $scope.html.chksInsumos=false;
            $scope.html.insumosId=[];
            $scope.seleccionarAllInsumos();

            switch (r) {
                case 'OK':
                    showToastDialog(true, 'Registro ejecutado exitosamente', 'toast-content-dialog');
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
            $scope.limpiarUsarYTerminarInsumo();
            showToastDialog(true, 'Error 404: no se encontro el archivo y/o no se pudo conectar al servidor', 'toast-content-dialog');
        });
    }
    
    $scope.limpiarUsarYTerminarInsumo=function (){
        $scope.deleteImg();
        $scope.terminacionInsumo.observaciones=null;
        $scope.showAlertaDialogo(false, null, null);
    }
    
    $scope.UsarYTerminarInsumo=function (_idInsumo, metodo){
        /*
         * TRUE: registra el uso del insumo y la terminacion.
         * ELSE: registra unicamente la terminacion
         */
        if (_idInsumo!=null && _idInsumo!='' && metodo!=null){
            console.log($scope.validarFotoTerminacion());
            console.log($scope.file!=null);
            if ($scope.validarFotoTerminacion() && $scope.file!=null){
                if ($scope.validarDatosEmpleado()){
                    if (metodo) $scope.usarInsumo(_idInsumo, true);
                    $scope.terminarInsumo(_idInsumo);
                }
            } else {
                console.log("Hear");
               $scope.showAlertaDialogo(true, 'warning', 'Debes subir una foto que evidencie la terminacion del insumo');
            }
        } else showToastDialog(true, "No se pudo cargar el insumo, intentalo nuevamente", 'toast-content-dialog');
    }
    //
    //FIN REGISTRO DE LA TERMINACION DE UN INSUMO
    //--------------------------------------------------------------------------
    //
    //FUNCIONES IMAGENES DIALOGO PT

    //$scope.file
    
    $scope.validarFotoTerminacion=function (){
        //console.log($scope.html);
        var valid=false;
        if ($scope.html.fotoTerminacion){
            console.log($scope.file);
            if ($scope.file!=null) {
                valid=true;
                $scope.showAlertaDialogo(false, null, null);
            } else $scope.showAlertaDialogo(true, 'warning', 'Debes subir una foto que evidencie la terminacion del insumo');
        } else $scope.showAlertaDialogo(true, 'warning', 'Debes subir una foto que evidencie la terminacion del insumo');
        return valid;
    }

    //$scope.file=null;

    $scope.thumb={
        dataURL: ''
    };
    
    $scope.fileReaderSupported= window.FileReader!=null;
    
    $scope.photoChanged=function(files){
        console.log(files);
        if (files!=null){
            var file=files[0];
            if (file!=null){
                if ($scope.fileReaderSupported && file.type.indexOf('image') > -1){
                    if ($scope.file==null) $scope.file=file;
                    $timeout(function (){
                        var fileReader= new FileReader();
                        fileReader.readAsDataURL(file);
                        fileReader.onload= function (e){
                            $timeout(function (){
                                $scope.thumb.dataURL= e.target.result;
                                $scope.html.fotoTerminacion=true;
                                $scope.validarFotoTerminacion();
                            });
                        }
                    })
                } else $scope.deleteImg();
            } else $scope.deleteImg();
        }
    }
    
    $scope.deleteImg=function (){
        //console.log($scope.file);
        $scope.html.fotoTerminacion=false;
        $scope.file=null;
        $("#file").val(null);
        $scope.validarFotoTerminacion();
    }
    
    //FIN FUNCIONES IMAGENES DIALOGO PT
    //
    //Registro de novedad para puesto de trabajo
    
    $scope.novedadPT={
        novedad: null
    };
    
    $scope.registrarNovedad=function (){
        if ($scope.formularioNovedad.$valid && $scope.validarDatosEmpleado() && $scope.validarDatosPuestoTrabajo() && validarInput($scope.novedadPT.novedad)){
            $scope.html.spinnerCargaDialogo=true;
            $scope.novedadPT.idPuestoTrabajo=$scope.puestoTrabajo.id;
            $scope.novedadPT.idEmpleado=$scope.empleado.id;
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
            }).success(function (r) {
                $scope.limpiarVariablesNovedad();
                $scope.html.spinnerCargaDialogo=false;
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
                showToastDialog(true, 'Error 404: no se encontro el archivo y/o no se pudo conectar al servidor', 'toast-content-dialog');
                $scope.html.spinnerCargaDialogo=false;
                $scope.limpiarVariablesNovedad();
            });
        } else showToastDialog(true, 'No se puede completar la accion', 'toast-content-dialog');
    };
    
    $scope.limpiarVariablesNovedad=function (){
        $scope.novedadPT={
            novedad: null
        };
    };
    
    //Fin Registro de novedad para puesto de trabajo
});

$(document).ready(function () {
    $("#cargarDatos").click();
})