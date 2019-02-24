panamApp.controller('llantasOS', function ($scope, configuracionGlobal, $http, $location, $routeParams, $sessionStorage, $timeout, $localStorage){
    
    $scope.ObjetoOrdenServicio={}
    $scope.elementos={
        barraCargaListaLlantas: false,
        barraCarga: false,
        alertaDialog: false,
        colorAlertaDialog: 'default',
        mjsAlertaDialog: null,
        nSerie: false,
        vSerie: false,
        vIdServicio: false,
        vIdMarcar: false,
        vIdGravado: false,
        vIdAplicacionOriginal: false,
        vIdAplicacionSolicitada: false,
        spnReferenciaOriginal: false,
        spnMedidaReferenciaOriginal: false,
        spnReferenciaSolicitada: false,
        spnMedidaReferenciaSolicitada: false
    }
    $scope.lista={}
    $scope.llanta={
        urgente: true,
        observaciones: null
    }
    $scope.dataPage={
        dimensiones: {},
        hideAutocompleteDimensiones: true,
        dataSalida: {
            llanta: null,
            valor: null,
            spinnerCarga: false
        }
    }
    //$scope.objetos={}
    
    $scope.cleanLlanta=function (){
        $scope.llanta=null;
        $scope.llanta={
            urgente: true,
            observaciones: null,
            idServicio: $scope.ObjetoOrdenServicio.id
        };
        $scope.cargarRP();
        $scope.elementos={
            barraCargaListaLlantas: false,
            barraCarga: false,
            alertaDialog: false,
            colorAlertaDialog: 'default',
            mjsAlertaDialog: null,
            nSerie: false,
            vSerie: false,
            vIdServicio: true,
            vIdMarcar: false,
            vIdGravado: false,
            vIdAplicacionOriginal: false,
            vIdAplicacionSolicitada: false,
            spnReferenciaOriginal: false,
            spnMedidaReferenciaOriginal: false,
            spnReferenciaSolicitada: false,
            spnMedidaReferenciaSolicitada: false
        };
    }
    
    $scope.cargarOrdenServicio=function (_Id){
        if (_Id!=null && _Id!=''){
            $http({
                url: configuracionGlobal.scripts + '/datosJSON.php',
                method: 'GET',
                params: {
                    metodo: 'getOrdenServicio',
                    id: _Id
                }
            }).then(function (r){
                $scope.ObjetoOrdenServicio=r.data[0];
                $scope.cargarLlantasOrdenServicio($scope.ObjetoOrdenServicio.id);
                if (r.data[0].id!=null && r.data[0]!='') {
                    $scope.elementos.vIdServicio=true;
                    $scope.llanta.idServicio=$scope.ObjetoOrdenServicio.id;
                }
                else {
                    $scope.elementos.vIdServicio=false;
                    $scope.showToast(true, "La orden de servicio no fue cargada correctamente");
                }
                //console.log($scope.ObjetoOrdenServicio);
            });
        }
    }
    
    $scope.cargarLlantasOrdenServicio=function (_IdServicio){
        if (_IdServicio!=null && _IdServicio!=''){
            $scope.elementos.barraCargaListaLlantas=true;
            $http({
                url: configuracionGlobal.scripts + '/listadosJSON.php',
                method: 'GET',
                params: {
                    metodo: 'getLlantasOrdenServicio',
                    idServicio: _IdServicio
                }
            }).then(function (r){
                $localStorage.dataOS=r.data;
                $scope.llantas=r.data;
                $scope.elementos.barraCargaListaLlantas=false;
                if ($scope.llantas.length==0) $scope.showToast(true, "Esta orden de servicio no tiene llantas registradas");
            });
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
    
    $scope.showToastDialog=function (_valido, _mjs){
        if (_valido){
            'use strict';
            var snackbarContainer = document.querySelector('#toast-dialog');
            snackbarContainer.MaterialSnackbar.showSnackbar({
                message: _mjs
            });
        }
    }
    
    $scope.showToastDialogFrmDisenoEntregado=function (_valido, _mjs){
        if (_valido){
            'use strict';
            var snackbarContainer = document.querySelector('#toast-dialog-de');
            snackbarContainer.MaterialSnackbar.showSnackbar({
                message: _mjs
            });
        }
    }
    
    $scope.showAlertaDialog=function (_valido, _mjs, _color){
        if (_valido){
            $scope.elementos.alertaDialog=true;
            $scope.elementos.colorAlertaDialog=_color;
            $scope.elementos.mjsAlertaDialog=_mjs;
        } else {
            $scope.elementos.alertaDialog=false;
            $scope.elementos.colorAlertaDialog='default';
            $scope.elementos.mjsAlertaDialog=null;
        }
    }
    
    $scope.abrirModalDialogFormularioLlanta_A=function (){
        $scope.cargarRP();
    }
    
    $scope.cargarRP=function (){
        $http.get(configuracionGlobal.scripts + "/datosJSON.php?metodo=getProximoRP").then(function (respuesta){
            //console.log(respuesta);
            $scope.llanta.rp=respuesta.data;
        })
    }
    
    $scope.buscarSerieLlanta=function (_dato){
        $scope.elementos.nSerie=true;
        /*$scope.elementos.nSerie=false;
        if (_dato!=null && _dato!=''){
            $scope.showAlertaDialog(false, null, null);
            $scope.elementos.barraCarga=true;
            $http({
                url: configuracionGlobal.scripts + '/datosJSON.php',
                method: 'GET',
                params: {
                    metodo: 'getLlantaSerie',
                    serie: _dato
                }
            }).then(function (r){
                $scope.elementos.barraCarga=false;
                //console.log(r.data);
                if (r.data=='true'){
                    $scope.elementos.nSerie=true;
                    $scope.showToastDialog(true, "Numero de serie disponible");
                    $scope.showAlertaDialog(false, null, null);
                } else {
                    $scope.elementos.nSerie=false;
                    $scope.showAlertaDialog(true, 'El numero de serie ' + _dato + " esta siendo utlizado por otro registro", "danger");
                    $("#txtSerie").select();
                }
            });
        } else {
            $scope.elementos.nSerie=false;
            $scope.showAlertaDialog(true, "El campo serie no puede estar vacio", "danger");
            $("#txtSerie").focus();
        }*/
    }
    
    $scope.cargarSpnReferenciasTipo=function (_IdTipo){
        $scope.elementos.spnReferenciaOriginal=false;
        $scope.elementos.referenciasTipoDisenoOriginal=null;
        if (_IdTipo!=null && _IdTipo!='' && _IdTipo!='#'){
            $scope.elementos.barraCarga=true;
            $http({
                url: configuracionGlobal.scripts + "/listadosJSON.php",
                method: 'GET',
                params: {
                    metodo: 'referenciasTipoLlantaJSON',
                    idTipoLlanta: _IdTipo
                }
            }).then(function (r){
                $scope.elementos.barraCarga=false;
                $scope.elementos.referenciasTipoDisenoOriginal=r.data;
                console.log(r.data);
                if (r.data.length>0){
                    $scope.elementos.spnReferenciaOriginal=true;
                    $scope.showToastDialog(true, r.data.length +" Referencias cargadas exitosamente");
                } else {
                    $scope.elementos.spnReferenciaOriginal=false;
                    $scope.showToastDialog(true, "Este tipo de llanta no tiene referencias registradas");
                }
            });
        } else {
            $scope.llanta.idTipoDisenoOriginal="#";
            $scope.elementos.spnReferenciaOriginal=false;
            $scope.elementos.referenciasTipoDisenoOriginal=null;
        }
    }
    
    $scope.cargarSpnMedidasReferenciaTipo=function (_IdReferencia){
        $scope.elementos.spnMedidaReferenciaOriginal=false;
        $scope.elementos.dimensionesReferenciaTipoLlantaOriginal=null;
        if (_IdReferencia!=null && _IdReferencia!='' && _IdReferencia!='#'){
            $scope.elementos.barraCarga=true;
            $http({
                url: configuracionGlobal.scripts + "/listadosJSON.php",
                method: 'GET',
                params: {
                    metodo: 'dimensionesReferenciaJSON',
                    idReferencia: _IdReferencia.id
                }
            }).then(function (r){
                $scope.elementos.barraCarga=false;
                $scope.elementos.dimensionesReferenciaTipoLlantaOriginal=r.data;
                console.log(r.data);
                if (r.data.length>0){
                    $scope.elementos.spnMedidaReferenciaOriginal=true;
                    $scope.showToastDialog(true, r.data.length +" medidas cargadas exitosamente");
                } else {
                    $scope.elementos.spnMedidaReferenciaOriginal=false;
                    $scope.showToastDialog(true, "Esta referencia no tiene medidas registradas");
                }
            });
        } else {
            $scope.llanta.idReferenciaTipoDisenoOriginal="#";
            $scope.elementos.spnMReferenciaOriginal=false;
            $scope.elementos.dimensionesReferenciaTipoLlantaOriginal=null;
        }
    }
    
    $scope.cargarSpnReferenciasTipoSolicitado=function (_IdTipo){
        $scope.elementos.spnReferenciaSolicitada=false;
        $scope.elementos.referenciasTipoDisenoSolicitado=null;
        if (_IdTipo!=null && _IdTipo!='' && _IdTipo!='#'){
            $scope.elementos.barraCarga=true;
            $http({
                url: configuracionGlobal.scripts + "/listadosJSON.php",
                method: 'GET',
                params: {
                    metodo: 'referenciasTipoLlantaJSON',
                    idTipoLlanta: _IdTipo
                }
            }).then(function (r){
                $scope.elementos.barraCarga=false;
                $scope.elementos.referenciasTipoDisenoSolicitado=r.data;
                console.log(r.data);
                if (r.data.length>0){
                    $scope.elementos.spnReferenciaSolicitada=true;
                    $scope.showToastDialog(true, r.data.length +" Referencias cargadas exitosamente");
                } else {
                    $scope.elementos.spnReferenciaSolicitada=false;
                    $scope.showToastDialog(true, "Este tipo de llanta no tiene referencias registradas");
                }
            });
        } else {
            $scope.llanta.idTipoDisenoSolicitado="#";
            $scope.elementos.spnReferenciaSolicitada=false;
            $scope.elementos.referenciasTipoDisenoSolicitado=null;
        }
    }
    
    $scope.cargarSpnMedidasReferenciaTipoSolicitado=function (_IdReferencia){
        $scope.elementos.spnMedidaReferenciaSolicitada=false;
        $scope.elementos.dimensionesReferenciaTipoLlantaSolicitada=null;
        if (_IdReferencia!=null && _IdReferencia!='' && _IdReferencia!='#'){
            $scope.elementos.barraCarga=true;
            $http({
                url: configuracionGlobal.scripts + "/listadosJSON.php",
                method: 'GET',
                params: {
                    metodo: 'dimensionesReferenciaJSON',
                    idReferencia: _IdReferencia.id
                }
            }).then(function (r){
                $scope.elementos.barraCarga=false;
                $scope.elementos.dimensionesReferenciaTipoLlantaSolicitada=r.data;
                console.log(r.data);
                if (r.data.length>0){
                    $scope.elementos.spnMedidaReferenciaSolicitada=true;
                    $scope.showToastDialog(true, r.data.length +" medidas cargadas exitosamente");
                } else {
                    $scope.elementos.spnMedidaReferenciaSolicitada=false;
                    $scope.showToastDialog(true, "Esta referencia no tiene medidas registradas");
                }
            });
        } else {
            $scope.llanta.idReferenciaTipoDisenoSolicitado="#";
            $scope.elementos.spnMedidaReferenciaSolicitada=false;
            $scope.elementos.dimensionesReferenciaTipoLlantaSolicitada=null;
        }
    }
    
    $scope.cargarNombreUrgenteChk=function (_ChkEstado){
        if (_ChkEstado) return "Si";
        else return "No";
    }
    
    $scope.validarIdMarcaLlanta=function (){
        if ($scope.llanta.idMarca!='#' && $scope.llanta.idMarca!='' && $scope.llanta.idMarca!=null){
            $scope.elementos.vIdMarcar=true;
        } else {
            $scope.showToastDialog(true, "Debes seleccionar una MARCA");
            $scope.llanta.idMarca='#';
            $("#spnMarca").focus();
            $scope.elementos.vIdMarcar=false;
        }
    }
    
    $scope.validarIdGravadoLlanta=function (){
        if ($scope.llanta.idGravado!='#' && $scope.llanta.idGravado!='' && $scope.llanta.idGravado!=null){
            $scope.elementos.vIdGravado=true;
        } else {
            $scope.showToastDialog(true, "Debes seleccionar un GRAVADO");
            $scope.llanta.idGravado='#';
            $("#spnGravado").focus();
            $scope.elementos.vIdGravado=false;
        }
    }
    
    $scope.validarSerieLlanta=function (){
        if ($scope.llanta.serie!='' && $scope.llanta.serie!=null){
            $scope.elementos.vSerie=true;
        } else {
            $scope.showToastDialog(true, "Debes dijitar el numero de 'SERIE' para este registro");
            $scope.llanta.serie=null;
            $("#txtSerie").focus();
            $scope.elementos.vSerie=false;
            $scope.elementos.nSerie=false;
        }
        if (!$scope.elementos.nSerie){
            $scope.buscarSerieLlanta($scope.llanta.serie);
            $("#txtSerie").focus();
        }
    }
    
    $scope.validarIdAplicacionOriginalLlanta=function (){
        //if ($scope.llanta.idAplicacionOriginal!='#' && $scope.llanta.idAplicacionOriginal!='' && $scope.llanta.idAplicacionOriginal!=null){
        if ($scope.llanta.idReferenciaTipoDisenoOriginal!='#' && $scope.llanta.idReferenciaTipoDisenoOriginal!='' && $scope.llanta.idReferenciaTipoDisenoOriginal!=null){
            $scope.elementos.vIdAplicacionOriginal=true;
        } else {
            //$scope.showToastDialog(true, "Debes seleccionar una 'MEDIDA ORIGINAL' para enviar este registro");
            $scope.showToastDialog(true, "Debes seleccionar una 'REFFERENCIA ORIGINAL' para enviar este registro");
            $scope.cargarSpnReferenciasTipo(null);
            $scope.cargarSpnMedidasReferenciaTipo(null);
            $scope.llanta.idTipoDisenoOriginal='#';
            $scope.llanta.idReferenciaTipoDisenoOriginal='#';
            $scope.llanta.idAplicacionOriginal='#';
            $("#spnDisenoOriginal").focus();
            $scope.elementos.vIdAplicacionOriginal=false;
        }
    }

    $scope.validarIdAplicacionSolicitadaLlanta=function (){
        //if ($scope.llanta.idAplicacionSolicitada!='#' && $scope.llanta.idAplicacionSolicitada!='' && $scope.llanta.idAplicacionSolicitada!=null){
        if ($scope.llanta.idReferenciaTipoDisenoSolicitado!='#' && $scope.llanta.idReferenciaTipoDisenoSolicitado!='' && $scope.llanta.idReferenciaTipoDisenoSolicitado!=null){
            $scope.elementos.vIdAplicacionSolicitada=true;
        } else {
            //$scope.showToastDialog(true, "Debes seleccionar una 'MEDIDA SOLICITADA' para enviar este registro");
            $scope.showToastDialog(true, "Debes seleccionar una 'REFERENCIA SOLICITADA' para enviar este registro");
            $scope.cargarSpnReferenciasTipoSolicitado(null);
            $scope.cargarSpnMedidasReferenciaTipoSolicitado(null);
            $scope.llanta.idTipoDisenoSolicitado='#';
            $scope.llanta.idReferenciaTipoDisenoSolicitado='#';
            $scope.llanta.idAplicacionSolicitada='#';
            $("#spnDisenoSolicitado").focus();
            $scope.elementos.vIdAplicacionSolicitada=false;
        }
    }
    
    $scope.setDimension=function (id, value) {
        if (id!=null) $scope.llanta.idDimension=id;
        else if (value!=null) {
            $scope.llanta.idDimension=0;
            //$scope.llanta.dimension=value;
        }
    }

    $scope.validarDimension=function () {
        var valid=false;
        if ($scope.llanta.idDimension!=null || $scope.llanta.dimension!=null) valid=true;
        else showToastDialog(true, 'El campo dimension no puede estar vacio', "toast-dialog");
        return valid;
    }
    
    $scope.registrarLlanta=function (){
//        console.log($scope.elementos);
//        console.log($scope.llanta);
        $scope.validarIdMarcaLlanta();
        $scope.validarIdGravadoLlanta();
        $scope.validarSerieLlanta();
        $scope.validarIdAplicacionOriginalLlanta();
        $scope.validarIdAplicacionSolicitadaLlanta();
        if ($scope.elementos.vIdServicio && $scope.elementos.vSerie && $scope.elementos.nSerie && $scope.elementos.vIdMarcar && $scope.elementos.vIdGravado && $scope.elementos.vIdAplicacionOriginal && $scope.elementos.vIdAplicacionSolicitada && $scope.validarDimension()){
            $scope.showAlertaDialog(false, null, null);
            $scope.elementos.barraCarga=true;
            //Registro de llanta
            //
            $http({
                url: configuracionGlobal.scripts + "/cruds.php",
                method: 'POST',
                data: $scope.llanta,
                params: {
                    metodo: 'crudLlantasOS',
                    accion: 'Adicionar'
                },
                headers: {'Content-type': 'application/x-www-form-urlencoded'}
            }).success(function (r){
                $scope.elementos.barraCarga=false;
                console.log(r);
                switch (r){
                    case 'SD':
                        $scope.showToastDialog(true, "Solicitud desconocida");
                        break;
                    case 'IR':
                        $scope.showToastDialog(true, "Solicitud invalida");
                        break;
                    case 'ID':
                        $scope.showToastDialog(true, "El registro no pudo completarse por falta de datos, intentalo nuevamente");
                        break;
                    case 'SDE':
                        $scope.showToast(true, "Uoops, ocurrio un error al realizar el registro");
                        $scope.cleanLlanta();
                        $("#btnCancelarMDFormularioLlanta_A").click();
                        break;
                    case 'OK':
                        $scope.loadDimensiones();
                        $scope.cleanLlanta();
                        $scope.cargarLlantasOrdenServicio($scope.ObjetoOrdenServicio.id);
                        $scope.showToast(true, "Llanta registrada exitosamente");
                        $("#btnCancelarMDFormularioLlanta_A").click();
                        break;
                    default:
                        showToast(true, "Ocurrio un error desconocido");
                        break;
                }
            }).error(function (r){
                console.log(r);
                $scope.elementos.barraCarga=false;
                $scope.showToast(true, "No se pudo cargar el archivo");
            });
            //
            //Fin Registro de llanta
        } else {
            $scope.showAlertaDialog(true, "Debes completar los campos requeridos para enviar este registro", 'danger');
        }
    }
    
    $scope.dataDisenoEntregado={
        btnFrmRegistrarDisenoEntregado: false,
        observaciones: null,
        idLlanta: false,
        llanta: null,
        idAplicacionEntregada: [{
            id: "#"
        }]
    }
    
    $scope.cleanDataDisenoEntregado=function (){
        $scope.dataDisenoEntregado={
            btnFrmRegistrarDisenoEntregado: false,
            observaciones: null,
            idLlanta: false,
            llanta: null,
            idAplicacionEntregada: {
                id: "#"
            }
        }
    }
    
    $scope.instantLlanta=function (_objeto){
        if (_objeto.id!=null && _objeto!=''){
            $scope.dataDisenoEntregado.idLlanta=true;
            $scope.dataDisenoEntregado.llanta=_objeto;
            console.log($scope.dataDisenoEntregado);
        }
    }
    
    $scope.cargarSpnReferenciasTipoEntregado=function (_IdTipo){
        $scope.dataDisenoEntregado.spnReferenciaEntregada=false;
        $scope.dataDisenoEntregado.referenciasTipoDisenoEntregado=null;
        if (_IdTipo!=null && _IdTipo!='' && _IdTipo!='#'){
            $scope.elementos.barraCarga=true;
            $http({
                url: configuracionGlobal.scripts + "/listadosJSON.php",
                method: 'GET',
                params: {
                    metodo: 'referenciasTipoLlantaJSON',
                    idTipoLlanta: _IdTipo
                }
            }).then(function (r){
                $scope.elementos.barraCarga=false;
                $scope.dataDisenoEntregado.referenciasTipoDisenoEntregado=r.data;
                console.log(r.data);
                if (r.data.length>0){
                    $scope.dataDisenoEntregado.spnReferenciaEntregada=true;
                    $scope.showToastDialogFrmDisenoEntregado(true, r.data.length +" Referencias cargadas exitosamente");
                } else {
                    $scope.dataDisenoEntregado.spnReferenciaEntregada=false;
                    $scope.showToastDialogFrmDisenoEntregado(true, "Este tipo de llanta no tiene referencias registradas");
                }
            });
        } else {
            $scope.dataDisenoEntregado.idTipoDisenoEntregado="#";
            $scope.dataDisenoEntregado.spnReferenciaEntregada=false;
            $scope.dataDisenoEntregado.referenciasTipoDisenoEntregado=null;
        }
    }
    
    $scope.cargarSpnMedidasReferenciaTipoEntregado=function (_IdReferencia){
        $scope.dataDisenoEntregado.spnMedidaReferenciaEntregada=false;
        $scope.dataDisenoEntregado.dimensionesReferenciaTipoLlantaEntregada=null;
        if (_IdReferencia!=null && _IdReferencia!='' && _IdReferencia!='#'){
            $scope.elementos.barraCarga=true;
            $http({
                url: configuracionGlobal.scripts + "/listadosJSON.php",
                method: 'GET',
                params: {
                    metodo: 'dimensionesReferenciaJSON',
                    idReferencia: _IdReferencia.id
                }
            }).then(function (r){
                $scope.elementos.barraCarga=false;
                $scope.dataDisenoEntregado.dimensionesReferenciaTipoLlantaEntregada=r.data;
                console.log(r.data);
                if (r.data.length>0){
                    $scope.dataDisenoEntregado.spnMedidaReferenciaEntregada=true;
                    $scope.showToastDialogFrmDisenoEntregado(true, r.data.length +" medidas cargadas exitosamente");
                } else {
                    $scope.dataDisenoEntregado.spnMedidaReferenciaEntregada=false;
                    $scope.showToastDialogFrmDisenoEntregado(true, "Esta referencia no tiene medidas registradas");
                }
            });
        } else {
            $scope.dataDisenoEntregado.idReferenciaTipoDisenoEntregado="#";
            $scope.dataDisenoEntregado.spnMReferenciaEntregada=false;
            $scope.dataDisenoEntregado.dimensionesReferenciaTipoLlantaEntregada=null;
        }
        console.log($scope.dataDisenoEntregado);
    }
    
    $scope.validarIdAplicacionEntregada=function (){
        if ($scope.dataDisenoEntregado.idAplicacionEntregada.id!='#' && $scope.dataDisenoEntregado.idAplicacionEntregada.id!='' && $scope.dataDisenoEntregado.idAplicacionEntregada.id!=null){
            $scope.dataDisenoEntregado.vIdAplicacionEntregada=true;
        } else {
            $scope.showToastDialogFrmDisenoEntregado(true, "Debes seleccionar una 'MEDIDA ENTREGADA' para enviar este registro");
            $scope.cargarSpnReferenciasTipoEntregado(null);
            $scope.cargarSpnMedidasReferenciaTipoEntregado(null);
            $scope.dataDisenoEntregado.idTipoDisenoEntregado='#';
            $scope.dataDisenoEntregado.idReferenciaTipoDisenoEntregado='#';
            $scope.dataDisenoEntregado.idAplicacionEntregada='#';
            $("#spnDisenoEntregado").focus();
            $scope.dataDisenoEntregado.vIdAplicacionEntregada=false;
        }
    }
    
    $scope.validarIdLlantaAplicacionEntregada=function (){
        if ($scope.dataDisenoEntregado.llanta.id!=null && $scope.dataDisenoEntregado.llanta.id!=''){
            $scope.dataDisenoEntregado.idLlanta=true;
        } else {
            $scope.showToastDialogFrmDisenoEntregado(true, "La llanta no fue cargada correctamente");
            $scope.dataDisenoEntregado.idLlanta=false;
        }
    }
    
    $scope.registrarDisenoEntregado=function (){
        $scope.validarIdAplicacionEntregada();
        $scope.validarIdLlantaAplicacionEntregada();
        if ($scope.dataDisenoEntregado.vIdAplicacionEntregada && $scope.dataDisenoEntregado.idLlanta){
            $scope.dataDisenoEntregado.btnFrmRegistrarDisenoEntregado=true;
            $scope.dataRequest={
                idLlanta: $scope.dataDisenoEntregado.llanta.id,
                idAplicacionEntregada: $scope.dataDisenoEntregado.idAplicacionEntregada.id,
                observaciones: $scope.dataDisenoEntregado.observaciones
            };
            $scope.elementos.barraCarga=true;
            $http({
                url: configuracionGlobal.scripts + "/cruds.php",
                method: 'POST',
                data: $scope.dataRequest,
                params: {
                    metodo: 'crudLlantasOS',
                    accion: 'RegistrarAplicacionEntregada'
                },
                headers: {'Content-type': 'application/x-www-form-urlencoded'}
            }).success(function (r){
                $scope.elementos.barraCarga=false;
                switch (r){
                    case 'SD':
                        $scope.showToastDialogFrmDisenoEntregado(true, "Solicitud desconocida");
                        $scope.dataDisenoEntregado.btnFrmRegistrarDisenoEntregado=false;
                        break;
                    case 'IR':
                        $scope.showToastDialogFrmDisenoEntregado(true, "Solicitud invalida");
                        $scope.dataDisenoEntregado.btnFrmRegistrarDisenoEntregado=false;
                        break;
                    case 'ID':
                        $scope.showToastDialogFrmDisenoEntregado(true, "El registro no pudo completarse por falta de datos, intentalo nuevamente");
                        $scope.cleanDataDisenoEntregado();
                        break;
                    case 'SDE':
                        $("#btnCancelarFormularioDisenoEntregado").click();
                        $scope.showToast(true, "Uoops, ocurrio un error al realizar el registro");
                        //$scope.cleanDataDisenoEntregado();
                        break;
                    case 'OK':
                        $("#btnCancelarFormularioDisenoEntregado").click();
                        $scope.cargarLlantasOrdenServicio($scope.ObjetoOrdenServicio.id);
                        $scope.showToast(true, "Registro actualizado exitosamente");
                        break;
                }
            }).error(function (){
                $scope.elementos.barraCarga=false;
                $scope.dataDisenoEntregado.btnFrmRegistrarDisenoEntregado=true;
                $scope.showToast(true, "Error 404, no se pudo conectar al servidor, intentalo nuevamente recargando la pagina");
            });
        }
    }

    $scope.loadDimensiones=function () {
        $http({
            url: configuracionGlobal.scripts + "/listadosJSON.php",
            method: 'GET',
            params: {
                metodo: 'dimensionesLlantaJSON'
            }
        }).success(function (r) {
            if (r!=null) $scope.dataPage.dimensiones=r;
        }).error(function (r) {
            showToast(true, "No se pudo conectar con el servidor")
        });
    }

    setInterval(function () {
        $scope.loadDimensiones()
    }, 900000);

    $scope.completeDimensiones=function () {
        var output = [];
        angular.forEach($scope.dataPage.dimensiones, function (value) {
            if ($scope.llanta.dimension!=null){
                if (value.dimension.toLowerCase().indexOf($scope.llanta.dimension.toLowerCase()) >= 0) output.push(value);
            }
        })
        $scope.filterDimensiones=output;
        if ($scope.filterDimensiones!=null) $scope.dataPage.hideAutocompleteDimensiones=false;
    }

    $scope.setFieldDimensiones=function(value){
        $scope.setDimension(value.id, null);
        $scope.llanta.dimension=value.dimension;
        $scope.dataPage.hideAutocompleteDimensiones=true;
    }

    $scope.deleteLlanta=function (object) {
        if (object!=null){
            $scope.elementos.barraCargaListaLlantas=true;
            $http({
                url: configuracionGlobal.scripts + "/cruds.php",
                method: 'POST',
                data: object,
                params: {
                    metodo: 'crudLlantasOS',
                    accion: 'Delete'
                }
            }).success(function (r) {
                $scope.elementos.barraCargaListaLlantas=false;
                switch (r){
                    case 'SD':
                        $scope.showToastDialog(true, "Solicitud desconocida");
                        break;
                    case 'IR':
                        $scope.showToastDialog(true, "Solicitud invalida");
                        break;
                    case 'ID':
                        $scope.showToastDialog(true, "El registro no pudo completarse por falta de datos, intentalo nuevamente");
                        break;
                    case 'SDE':
                        $scope.showToast(true, "Uoops, ocurrio un error al realizar el registro");
                        break;
                    case 'OK':
                        $scope.cargarLlantasOrdenServicio($scope.ObjetoOrdenServicio.id);
                        $scope.showToast(true, "Registro eliminado exitosamente");
                        break;
                    default:
                        showToast(true, "Ocurrio un error desconocido");
                        break;
                }
            }).error(function (r) {
                $scope.elementos.barraCargaListaLlantas=false;
                showToast(true, "No se pudo conectar con el servidor");
            });
        } else showToast(true, "No se puede completar la accion porque el registro no se cargo correctamente");
    }

    $scope.setLlantaSalida=function (object){
        if (object!=null) $scope.dataPage.dataSalida.llanta=object;
        else $scope.dataPage.dataSalida.llanta=null;
    }

    $scope.addSalidaLlanta=function () {
        if ($scope.frmAddSalida.$valid && $scope.dataPage.dataSalida.llanta!=null){
            $scope.dataPage.dataSalida.spinnerCarga=true;
            $http({
                url: configuracionGlobal.scripts + "/cruds.php",
                method: 'POST',
                data: {
                    id: $scope.dataPage.dataSalida.llanta.id,
                    valor: $scope.dataPage.dataSalida.valor
                },
                params: {
                    metodo: 'crudLlantasOS',
                    accion: 'addSalida'
                }
            }).success(function (r) {
                $scope.dataPage.dataSalida.spinnerCarga=false;
                $scope.dataPage.dataSalida.llanta=null;
                $("#btnCloseDlgRegistrarSalida").click();
                switch (r){
                    case 'SD':
                        $scope.showToast(true, "Solicitud desconocida");
                        break;
                    case 'IR':
                        $scope.showToast(true, "Solicitud invalida");
                        break;
                    case 'ID':
                        $scope.showToast(true, "El registro no pudo completarse por falta de datos, intentalo nuevamente");
                        break;
                    case 'SDE':
                        $scope.showToast(true, "Uoops, ocurrio un error al realizar el registro");
                        break;
                    case 'OK':
                        $scope.cargarLlantasOrdenServicio($scope.ObjetoOrdenServicio.id);
                        $scope.showToast(true, "Salida registrada exitosamente");
                        break;
                    default:
                        showToast(true, "Ocurrio un error desconocido");
                        break;
                }
                $scope.dataPage.dataSalida.valor=null;
            }).error(function (r) {
                showToastDialog(true, 'No se pudo conectar con el servidor', 'toast-dlg-addSalida');
                $scope.dataPage.dataSalida.spinnerCarga=false;
            });
        } else showToastDialog(true, 'No se puede completar la accion, recarga la pagina e intentalo nuevamente', 'toast-dlg-addSalida');
    }
    
    $scope.printTicket=function (object) {
        if (object!=null){
            $scope.elementos.barraCargaListaLlantas=true;
            //$sessionStorage.llantaTicket=null;
            $localStorage.llantaTicket=null;
            $timeout(function () {
                $scope.elementos.barraCargaListaLlantas=false;
                //$sessionStorage.llantaTicket=object;
                $localStorage.llantaTicket=object;
                window.open(configuracionGlobal.templatesPrint + "/ticketLlanta.php", null, 'toolbar=no, directories=no, width=1000, height=200, resizable=no, left=50, top=150');
            }, 500);
        } else {
            showToast(true, "No se pudo cargar el registro, recarga la pagina e intental nuevamente");
        }
    }

    //Insertado 2018-09-16 02:53
    $scope.openProcesoRencauche = function (_id) {
        if (validarInput(_id)) {
            window.location='principal.php?CON=system/Pages/procesoServicio.php&id=' + _id;
        } else showToast(true, 'No se puede abrir el proceso de rencauche desde aqui');
    }
    //Fin Insertado 2018-09-16 02:53

});

//JQUERY
//
$(document).ready(function (){
    $("#btnCargarOS").click();
})

//
//FIN JQUERY