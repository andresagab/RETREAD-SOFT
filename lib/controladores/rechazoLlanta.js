panamApp.controller('rechazoLlanta', function ($scope, configuracionGlobal, $http){
    
    $scope.html = {
        estado: true,
        basicDialog: {
            spinnerLoad: false,
            data: null
        }
    };
    
    $scope.cargarNombreEstado=function (_chk){
        if (_chk) return "Aprobado";
        else return "Rechazado";
    };
    
    $scope.cargarLista=function(){
    	$http.get(configuracionGlobal.scripts + "/listadosJSON.php?metodo=rechazosJSON").then(function (respuesta){
            $scope.objetos=respuesta.data;
        });
    };
    
    $scope.loadRechazosOfProceso=function(_IdLlanta, _Proceso){
    	$http({
            url: configuracionGlobal.scripts + "/datosJSON.php",
            method: 'GET',
            params: {
                metodo: 'rechazosProcesoJSON',
                idLlanta: _IdLlanta,
                proceso: _Proceso
            }
        }).then(function (r){
            $scope.objetos=r.data;
        });
    };
    
    $scope.observaciones="";
    rechazosId=[];
    
    $scope.separarRechazo=function (_chk, _IdRechazo){
        if (_chk){
            rechazosId.push(_IdRechazo);
        } else {
            if (rechazosId.indexOf(_IdRechazo)!=-1) rechazosId.splice(rechazosId.indexOf(_IdRechazo), 1);
        }
        $scope.validarRechazos();
    };
    
    $scope.validarRechazos=function (){
        valido = false;
        $scope.chequeados = false;
        for (var i = 0; i < rechazosId.length; i++) {
            if (rechazosId[i]!=null) {
                valido = true;
                $scope.chequeados = true;
                i = rechazosId.length;
            }
        }
        // if (valido) $scope.chequeados = true;
        // else $scope.chequeados = false;
        return valido;
    };
    
    function cortarArray(_Array){
        var array="";
        if (_Array!=null){
            for (var i = 0; i < _Array.length; i++) {
                dato=_Array[i];
                if (dato!=null){
                    if (i<_Array.length-1) auxiliar="|";
                    else auxiliar ="";
                    array+=dato+auxiliar;
                }
            }
        }
        return array;
    };
    
    $scope.registrarRechazos=function (_IdProceso, _observaciones, _proceso, _idLlanta){
        if ($scope.validarRechazos()){
            $scope.datos = {
                idProceso: _IdProceso,
                idLlanta: _idLlanta,
                observaciones: _observaciones,
                proceso: _proceso
            };
            $http({
                url: configuracionGlobal.scripts + "/cruds.php",
                method: 'POST',
                data: $scope.datos,
                params: {
                    metodo: 'registrarRechazosLlanta',
                    rechazos: cortarArray(rechazosId)
                },
                headers: {
                    'Content-type': 'application/x-www-form-urlencoded'
                }
            })
            .then(function (r){
                rechazosId = [];
                $scope.observaciones = "";
                if (r.data=='OK') showToastPrincipal(true, 'Rechazos registrados exitosamente');
                else if (r.data=='FEX') showToastPrincipal(true, 'Uoops, Hubo un problema al registrar los rechazos');
                else if (r.data=='NR') showToastPrincipal(true, 'No se puedo registrar los rechazos, intentalo nuevamente...');
                else if (r.data=='ID') showToastPrincipal(true, 'Hacen falta algunos datos, recarga la pagina y vuelve a intentarlo...');
            })
        }
    };
    
    $scope.limpiarVariables=function (){
        rechazosId=[];
        $scope.observaciones="";
    };
    
    $scope.loadRechazosLlanta = function (idLlanta) {
        $scope.html.basicDialog.spinnerLoad = true;
        $http({
            url: configuracionGlobal.scripts + "/datosJSON.php",
            method: 'GET',
            params: {
                metodo: 'getInfoRechazosLlanta',
                idLlanta: idLlanta,
            }
        }).then(function (r){
            $scope.html.basicDialog.data = r.data;
            if ($scope.html.basicDialog.data.subRegisters) showToastPrincipal(true, 'Se registraron ' + $scope.html.basicDialog.data.rechazos.length + ' rechazos.');
            else showToastPrincipal(true, 'No se registraron rechazos.');
            $scope.html.basicDialog.spinnerLoad = false;
        });
    };
    
});   