panamApp.controller('posicionCamara', function ($scope, configuracionGlobal, $http, $location, $routeParams, $timeout){
    
    $scope.ObjetoVulcanizado={}
    
    $scope.elementos={
        barraCargaLista: false,
        btnAdicionarPosicionCamara: true,
        alertaDialog: false,
        vIdVulcanizado: false,
        vFoto: false,
        vPosicion: false
    }
    
    $scope.html={
        alerta: false,
        colorAlerta: null,
        mjsAlerta: null,
        maxPC: 0,
        rbtCPC: null
    }
    
    $scope.lista={}
    
    $scope.posicionCamara={}
    
    $scope.setMaxPC=function (_val) {
        if (_val!=null){
            $scope.html.maxPC=_val;
            $scope.html.rbtCPC=_val;
            if ($scope.html.maxPC==12){
                $("#rbt12").click();
            } else {
                $("#rbt22").click();
            }
        }
    }
    
    $scope.cleanPosicionCamara=function (){
        $scope.posicionCamara={
            idVulcanizado: $scope.ObjetoVulcanizado.id
        }
        $scope.cargarDefaultElementos();
        $scope.deleteImg();
        $("#foto").val(null);
    }
    
    $scope.cargarDefaultElementos=function (){
            $scope.elementos={
            barraCargaLista: false,
            btnAdicionarPosicionCamara: false,
            alertaDialog: false,
            vIdVulcanizado: true,
            vFoto: false,
            vPosicion: false
        }
    }
    
    $scope.cargarVulcanizado=function (_Id){
        if (_Id!=null && _Id!=''){
            $http({
                url: configuracionGlobal.scripts + '/datosJSON.php',
                method: 'GET',
                params: {
                    metodo: 'getVulcanizadoSimple',
                    id: _Id
                }
            }).then(function (r){
                console.log(r.data);
                if (r.data!=null){
                    if (r.data[0].id!=null && r.data[0].id!='') {
                        $scope.elementos.vIdVulcanizado=true;
                        $scope.ObjetoVulcanizado=r.data[0];
                        $scope.posicionCamara.idVulcanizado=$scope.ObjetoVulcanizado.id;
                        $scope.cargarPosicionesCamara($scope.ObjetoVulcanizado.id);
                        $scope.setMaxPC($scope.ObjetoVulcanizado.camaras);
                    } else {
                        $scope.elementos.vIdVulcanizado=false;
                        $scope.showToast(true, "No se cargaron los datos correctamente, vuelve a abrir el proceso de rencauche");
                    }
                } else {
                    $scope.elementos.vIdVulcanizado=false;
                    $scope.showToast(true, "No se cargaron los datos correctamente, vuelve a abrir el proceso de rencauche");
                }
            });
        }
    }
    
    $scope.cargarPosicionesCamara=function (_IdVulcanizado){
        if (_IdVulcanizado!=null && _IdVulcanizado!=''){
            $scope.elementos.barraCargaLista=true;
            $http({
                url: configuracionGlobal.scripts + '/listadosJSON.php',
                method: 'GET',
                params: {
                    metodo: 'getPosicionesCamrasVulcanizado',
                    idVulcanizado: _IdVulcanizado
                }
            }).then(function (r){
                $scope.elementos.barraCargaLista=false;
                $scope.posicionesCamaras=r.data;
                if ($scope.posicionesCamaras.length==0) $scope.showToast(true, "No hay revisiones registradas");
                $scope.validarCantidadPosicionesCamaras(); 
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
    
    $scope.showAlertaHTML=function (_valido, _mjs, _color){
        if (_valido){
            $scope.html.alerta=true;
            $scope.html.mjsAlerta=_mjs;
            $scope.html.colorAlerta=_color;
        } else {
            $scope.html.alerta=false;
            $scope.html.mjsAlerta=null;
            $scope.html.colorAlerta='default';
        }
    }
    
    $scope.setVFoto=function (){
        if ($scope.file!=null) {
            $scope.posicionCamara.foto=true;
            $scope.elementos.vFoto=true;
        }
        else $scope.elementos.vFoto=false;
    }
    
    $scope.setVPosicion=function (_date){
        if (_date!=null) {
            //$scope.posicionCamara.posicion=_date.getHours() + ":" + _date.getMinutes();
            $scope.posicionCamara.posicion=_date;
            $scope.elementos.vPosicion=true;
        } else $scope.elementos.vPosicion=false;
    }
    
    $scope.validarIdVulcanizado=function (){
        if ($scope.elementos.vIdVulcanizado){
            if ($scope.posicionCamara.idVulcanizado!=null && $scope.posicionCamara.idVulcanizado!='') {
                return true;
            }
            else {
                $scope.showAlertaDialog(true, "En este momento no es posible llevar acabo el registro, vuelva a cargar el proceso de rencauche", "danger");
                $scope.elementos.vIdVulcanizado=false;
                return false;
            }
        } else {
            $scope.showAlertaDialog(true, "En este momento no es posible llevar acabo el registro, vuelva a cargar el proceso de rencauche", "danger");
            return false;
        }
    }
    
    $scope.validarFoto=function (){
        if ($scope.elementos.vFoto){
            if ($scope.file!=null) {
                return true;
            }
            else {
                $scope.showAlertaDialog(true, "Debes cargar la foto para llevar acabo el registro", "warning");
                //$("#foto").focus();
                $scope.elementos.vFoto=false;
                return false;
            }
        } else {
            //$("#foto").focus();
            $scope.showAlertaDialog(true, "Debes cargar la foto para llevar acabo el registro", "warning");
            return false;
        }
    }
    
    $scope.validarPosicion=function (){
        if ($scope.html.maxPC==3) var positions=[1, 2, 3];
        else var positions=[1, 2, 3, 4, 5, 6];
        var currentVal=1;
        if ($scope.posicionesCamaras.length>=1) {
            for (var j=0; j<positions.length; j++){
                var valid=false;
                for (var i=0; i<$scope.posicionesCamaras.length; i++){
                    if ($scope.posicionesCamaras[i].posicion==positions[j]) {
                        valid=true;
                        i=$scope.posicionesCamaras.length;
                    }
                }
                if (!valid) {
                    currentVal=positions[j];
                    console.log(currentVal);
                    j=positions.length;
                }
            }
        }
        $scope.posicionCamara.posicion=currentVal;
        if ($scope.posicionCamara.posicion!=null && $scope.posicionCamara.posicion!='') {
            $scope.elementos.vPosicion=true;
            return true;
        } else {
            $scope.showAlertaDialog(true, "Debes dijitar la posicion de la camara para llevar acabo el registro", "warning");
            //$("#txtPosicion").focus();
            $scope.elementos.vPosicion=false;
            return false;
        }
    }
    
    $scope.validarCantidadPosicionesCamaras=function (){
        if ($scope.html.maxPC>0 && $scope.posicionesCamaras.length<$scope.html.maxPC) {
            $scope.elementos.btnAdicionarPosicionCamara=false;
            $scope.showAlertaHTML(true, "Haz registrado " + $scope.posicionesCamaras.length + " revisiones de " + $scope.html.maxPC, "warning");
            return true;
        }
        else {
            $scope.showToast(true, "Solo puedes registrar " + $scope.html.maxPC + " revisiones");
            $scope.showAlertaHTML(true, "Haz registrado todas las revisiones (" + $scope.posicionesCamaras.length + "/" + $scope.html.maxPC + ")", "success");
            $scope.elementos.btnAdicionarPosicionCamara=true;
            return false;
        }
    }
    
    $scope.registrarPosicionCamara=function (){
        /*console.log($scope.elementos);
        console.log($scope.posicionCamara);
        console.log($scope.file);
        console.log($scope.posicionesCamaras);*/
        if ($scope.validarIdVulcanizado() && $scope.validarFoto() && $scope.validarPosicion() && $scope.validarCantidadPosicionesCamaras()){
            $scope.showAlertaDialog(false, null, null);
            $scope.elementos.barraCarga=true;
            //Registro de posicion camara
            //
            var formData=new FormData();
            formData.append("name", "foto");
            formData.append("file", $scope.file);
            $http({
                url: configuracionGlobal.scripts + "/cruds.php",
                method: 'POST',
                data: formData,
                params: {
                    metodo: 'crudPosicionCamara',
                    accion: 'Adicionar',
                    idVulcanizado: $scope.posicionCamara.idVulcanizado,
                    posicion: $scope.posicionCamara.posicion
                },
                headers: {'Content-type': undefined},
                transformRequest: angular.identity
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
                        $scope.cleanPosicionCamara()();
                        $("#btnCancelarMDFormularioLlanta_A").click();
                        break;
                    case 'OK':
                        $scope.cleanPosicionCamara();
                        $scope.cargarPosicionesCamara($scope.ObjetoVulcanizado.id);
                        $scope.showToast(true, "Revision registrada exitosamente");
                        $("#btnCancelarMDFormularioLlanta_A").click();
                        break;
                    default :
                        $scope.cleanPosicionCamara();
                        $scope.showToast(true, "Uoops, ocurrio un error desconocido");
                        $("#btnCancelarMDFormularioLlanta_A").click();
                        break;
                }
            }).error(function (r){
                console.log(r);
                $scope.elementos.barraCarga=false;
                $scope.showToast(true, "No se pudo concetar al servidor");
            });
            //
            //Fin Registro de llanta
        } else {
            $scope.showAlertaDialog(true, "Debes completar los campos requeridos para enviar este registro", 'danger');
        }
    }
    
    $scope.eliminarPosicionCamara=function (_objeto){
        if (_objeto.id!=null && _objeto.id!=''){
            $http({
                url: configuracionGlobal.scripts + "/cruds.php",
                method: 'POST',
                data: _objeto,
                params: {
                    metodo: 'crudPosicionCamara',
                    accion: 'Eliminar'
                },
                headers: {'Content-type': 'application/x-www-form-urlencoded'}
            }).success(function (r){
                $scope.elementos.barraCarga=false;
                switch (r){
                    case 'OK':
                        $scope.cargarPosicionesCamara($scope.ObjetoVulcanizado.id);
                        $scope.showToast(true, "Registro eliminado exitosamente");
                        break;
                    case 'ID':
                        $scope.cargarPosicionesCamara($scope.ObjetoVulcanizado.id);
                        $scope.showToast(true, "No se pudo completar la operacion, recarga la pagina e intentalo nuevamente");
                        break;
                    case 'SD':
                        $scope.cargarPosicionesCamara($scope.ObjetoVulcanizado.id);
                        $scope.showToast(true, "Solicitud desconocida");
                        break;
                    case 'SDE':
                        $scope.cargarPosicionesCamara($scope.ObjetoVulcanizado.id);
                        $scope.showToast(true, "Uoops, ocurrio un error al realizar el registro");
                        break;
                    default :
                        $scope.cargarPosicionesCamara($scope.ObjetoVulcanizado.id);
                        $scope.showToast(true, "Uoops, ocurrio un error desconocido");
                        break;
                }
            }).error(function (r){
                $scope.elementos.barraCarga=false;
                $scope.showToast(true, "No se pudo concetar al servidor");
            });
        }
    }
    
    //Foto
    //
    $scope.thumbnail={
        dataURL: ''
    };
    
    $scope.fileReaderSupported= window.FileReader!=null;
    
    $scope.photoChanged=function(files){
        if (files!=null){
            var file=files[0];
            $scope.elementos.vFoto=true;
            if ($scope.fileReaderSupported && file.type.indexOf('image') > -1){
                $timeout(function (){
                    var fileReader= new FileReader();
                    fileReader.readAsDataURL(file);
                    fileReader.onload= function (e){
                        $timeout(function (){
                            $scope.thumbnail.dataURL= e.target.result;
                            $scope.foto=true;
                        })
                    }
                })
            }
        }
    }
    
    $scope.deleteImg=function (){
        console.log($scope.file);
        $scope.foto=null;
        $("#foto").val(null);
        //Pendiente borrar archivo del input file
    }
    //
    //Fin Foto
    
    $scope.registrarCPC=function (){
        if (validarInput($scope.html.rbtCPC) && validarInput($scope.ObjetoVulcanizado.id)){
            $scope.showAlertaDialog(false, null, null);
            $scope.elementos.barraCarga=true;
            $http({
                url: configuracionGlobal.scripts + "/cruds.php",
                method: 'POST',
                params: {
                    metodo: 'setCPC',
                    valor: $scope.html.rbtCPC,
                    id: $scope.ObjetoVulcanizado.id
                }
            }).success(function (r){
                $scope.elementos.barraCarga=false;
                console.log(r);
                switch (r){
                    case 'SD':
                        showToastDialog(true, "Solicitud desconocida", "toast-dialog-cpc");
                        break;
                    case 'IR':
                        showToastDialog(true, "Solicitud invalida", "toast-dialog-cpc");
                        break;
                    case 'ID':
                        showToastDialog(true, "No se pudo actualizar la cantidad maxima de revisiones, intentalo nuevamente", "toast-dialog-cpc");
                        break;
                    case 'SDE':
                        $("#btnCancelarCPC").click();
                        $scope.showToast(true, "Uoops, ocurrio un error al atualizar los valores");
                        break;
                    case 'OK':
                    case '6':
                    case '3':
                        //$scope.cargarPosicionesCamara($scope.ObjetoVulcanizado.id);
                        $("#btnCancelarCPC").click();
//                        $scope.setMaxPC(r);
//                        $scope.validarCantidadPosicionesCamaras();
                        $scope.cargarVulcanizado($scope.ObjetoVulcanizado.id);
                        $scope.showToast(true, "Cantidad maxima actualizada correctamente");
                        break;
                    default :
                        $("#btnCancelarCPC").click();
                        $scope.showToast(true, "Uoops, ocurrio un error desconocido");
                        break;
                }
            }).error(function (r){
                console.log(r);
                $scope.elementos.barraCarga=false;
                showToastDialog(true, "No se pudo concetar al servidor", "toast-dialog-cpc");
            });
        } else {
            showToastDialog(true, "Hay un error con los valores de cambio", "toast-dialog-cpc");
        }
    }
    
});

//JQUERY
//
$(document).ready(function (){
    $("#btnCargarVulcanizado").click();
})
//
//FIN JQUERY