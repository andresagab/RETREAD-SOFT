panamApp.controller('cambiarClave', function ($scope, $http, configuracionGlobal){
    
    $scope.html={
        barraCarga: false,
        alertaDialog: false,
        colorAlertaDialog: null,
        mjsAlertaDialog: null,
        btnFrmCambiarClave: true,
        inputClaveNueva: true,
        inputClaveNuevaConfirmar: true,
        hasClaveActual: null,
        hasClaveNueva: null,
        hasClaveNuevaConfirmar: null
    };
    
    $scope.usuarioSession=null;
    $scope.data={};
    
    $scope.cleanDataCambiarClave=function () {
        $scope.data.claveActual=null;
        $scope.data.claveNueva=null;
        $scope.data.claveNuevaConfirmar=null;
    }
    
    $scope.cargarUsuario=function (_id){
        $scope.cleanDataCambiarClave();
        $scope.html.btnFrmCambiarClave=true;
        $scope.html.inputClaveNueva=true;
        $scope.html.inputClaveNuevaConfirmar=true;
        $("#txtClaveActual").focus();
        if (validarInput(_id)){
            $scope.html.barraCarga=true;
            $http({
                url: configuracionGlobal.scripts + "/datosJSON.php",
                method: 'GET',
                params: {
                    metodo: 'getUsuarioJSON',
                    id: _id
                }
            }).success(function (r){
                $scope.html.barraCarga=false;
                if (r!=null){
                    if (r.length>0) $scope.usuarioSession=r[0];
                    else {
                        $scope.cleanDataCambiarClave();
                        $scope.usuarioSession=null;
                        showToastDialog(true, "No se pudo cargar tu cuenta de usuario, vuelve a ingresar al sistema", "toast-dialog-cc");
                    }
                } else {
                    $scope.cleanDataCambiarClave();
                    $scope.usuarioSession=null;
                    showToastDialog(true, "No se pudo cargar tu cuenta de usuario, vuelve a ingresar al sistema", "toast-dialog-cc");
                }
            }).error(function (r) {
                $scope.html.barraCarga=false;
                $scope.cleanDataCambiarClave();
                showToastDialog(true, "No se pudo conentar con el servidor: ( " + r + " )", "toast-dialog-cc");
            });
        } else {
            $scope.cleanDataCambiarClave();
            showToastDialog(true, "No se pudo cargar tu cuenta de usuario, vuelve a ingresar al sistema", "toast-dialog-cc");
        }
    }
    
    $scope.validarClaveActual=function (_data) {
        if (validarInput(_data)){
            $scope.html.barraCarga=true;
            $http({
                url: configuracionGlobal.scripts + "/datosJSON.php",
                method: 'GET',
                params: {
                    metodo: 'compararClaves',
                    claveActual: _data,
                    claveSession: $scope.usuarioSession.clave
                }
            }).success(function (r) {
                $scope.html.barraCarga=false;
                $scope.cleanClavesNuevas();
                switch (r) {
                    case 'OK':
                        $scope.showAlertDialog(false, null, null);
                        $scope.html.hasClaveActual='has-success';
                        $scope.html.inputClaveNueva=false;
                        break;
                    case 'ID':
                        $scope.html.hasClaveActual='has-warning';
                        showToastDialog(true, "No se pudo validar tu contraseña actual", "toast-dialog-cc");
                        $scope.html.inputClaveNueva=true;
                        $scope.html.btnFrmCambiarClave=true;
                        break;
                    case 'FALSE':
                        $scope.html.hasClaveActual='has-warning';
                        $scope.html.inputClaveNueva=true;
                        $scope.showAlertDialog(true, "La contraseña no es correcta", "danger");
                        $scope.html.btnFrmCambiarClave=true;
                        break;
                    default:
                        $scope.html.hasClaveActual='has-warning';
                        $scope.html.inputClaveNueva=true;
                        showToastDialog(true, "Ocurrio un error desconocido: ( " + r + " )", "toast-dialog-cc");
                        $scope.html.btnFrmCambiarClave=true;
                        break;
                }
            }).error(function (r) {
                $scope.cleanClavesNuevas();
                $scope.html.hasClaveActual='has-warning';
                $scope.html.barraCarga=false;
                $scope.html.inputClaveNueva=true;
                showToastDialog(true, "No se pudo conentar con el servidor: ( " + r + " )", "toast-dialog-cc");
                $scope.html.btnFrmCambiarClave=true;
            });
        } else {
            $scope.html.inputClaveNueva=true;
            $scope.html.hasClaveActual='has-warning';
            $scope.showAlertDialog(true, "La contraseña no es correcta", "danger");
            $scope.html.btnFrmCambiarClave=true;
            $scope.cleanClavesNuevas();
        }
    }
    
    $scope.validarClaveNueva=function (_data) {
        var valido=false;
        $scope.data.claveNuevaConfirmar=null;
        if (validarInput(_data)){
            $scope.html.inputClaveNuevaConfirmar=false;
            $scope.html.hasClaveNueva='has-success';
            valido=true;
        } else {
            $scope.showAlertDialog(true, "El campo 'clave nueva' no puede estar vacio", "danger");
            $("#txtClaveNueva").focus();
            $scope.html.inputClaveNuevaConfirmar=true;
            $scope.html.hasClaveNueva='has-warning';
            $scope.html.btnFrmCambiarClave=true;
        }
        return valido;
    }
    
    $scope.validarClaveConfirmar=function (_data) {
        var valido=false;
        if (validarInput(_data)){
            if (_data==$scope.data.claveNueva){
                $scope.showAlertDialog(false, null, null);
                $scope.html.hasClaveNuevaConfirmar='has-success';
                $scope.html.btnFrmCambiarClave=false;
                valido=true;
            } else {
                $scope.html.hasClaveNuevaConfirmar='has-warning';
                $scope.html.btnFrmCambiarClave=true;
                $("#txtClaveNuevaConfirmar").focus();
                $scope.showAlertDialog(true, "Las contraseñas no coinciden", "danger");
            }
        } else {
            $scope.showAlertDialog(true, "El campo 'Repite tu contraseña nueva' no puede estar vacio", "danger");
            $("#txtClaveNuevaConfirmar").focus();
            $scope.html.hasClaveNuevaConfirmar='has-warning';
            $scope.html.btnFrmCambiarClave=true;
        }
        return valido;
    }
    
    $scope.showAlertDialog=function (_valido, _mjs, _color) {
        if (_valido){
            $scope.html.alertaDialog=true;
            $scope.html.mjsAlertaDialog=_mjs;
            $scope.html.colorAlertaDialog=_color;
        } else {
            $scope.html.alertaDialog=false;
            $scope.html.mjsAlertaDialog=null;
            $scope.html.colorAlertaDialog=null;
        }
    }
    
    $scope.cleanClavesNuevas=function () {
        $scope.data.claveNueva=null;
        $scope.data.claveNuevaConfirmar=null;
        $scope.html.inputClaveNuevaConfirmar=true;
    }
    
    $scope.cambiarClave=function (){
        if ($scope.validarClaveConfirmar($scope.data.claveNuevaConfirmar)){
            $scope.html.barraCarga=true;
            $http({
                url: configuracionGlobal.scripts + "/cruds.php",
                method: 'POST',
                params: {
                    metodo: 'cambiarClave',
                    id: $scope.usuarioSession.id,
                    claveNueva: $scope.data.claveNueva
                }
            }).success(function (r) {
                $scope.html.barraCarga=false;
                switch (r) {
                    case 'OK':
                        $("#btnCancelarFrmCambiarClave").click();
                        showToastDialog(true, "Contraseña actualizada correctamente", "toast-principal");
                        document.location.search+="&CC=true";
                        break;
                    case 'SD':
                        showToastDialog(true, "Solicitud desconocida", "toast-dialog-cc");
                        break;
                    case 'ID':
                        showToastDialog(true, "No se pudo cambiar la contraseña por falta de datos", "toast-principal");
                        $("#btnCancelarFrmCambiarClave").click();
                        break;
                    case 'SDE':
                        showToastDialog(true, "No se pudo actualizar la contraseña", "toast-principal");
                        $("#btnCancelarFrmCambiarClave").click();
                        break;
                    default:
                        showToastDialog(true, "Ocurrio un error desconocido: ( " + r + " )", "toast-dialog-cc");
                        break;
                }
            }).error(function (r) {
                $scope.html.barraCarga=false;
                showToastDialog(true, "No se pudo conentar con el servidor: ( " + r + " )", "toast-dialog-cc");
            });
        } else {
            showToastDialog(true, "Hacen falta algunos datos", "toast-dialog-cc");
            $scope.cleanDataCambiarClave();
            $scope.html.btnFrmCambiarClave=true;
            $scope.html.inputClaveNueva=true;
            $scope.html.inputClaveNuevaConfirmar=true;
            $("#txtClaveActual").focus();
        }
    }
    
});

$("#btnCambiarClave").click(function () {
    $("#hideBtnCargarUsuarioCambiarClave").click();
});