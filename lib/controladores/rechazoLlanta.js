panamApp.controller('rechazoLlanta', function ($scope, configuracionGlobal, $http, $location){
    /*$http.get(configuracionGlobal.scripts + "/listadosJSON.php?metodo=rechazosJSON").then(function (respuesta){
        //console.log(respuesta);
        $scope.objetos=respuesta.data;
    })*/
    
    $scope.html={
        estado: true
    }
    
    $scope.cargarNombreEstado=function (_chk){
        if (_chk) return "Aprobado";
        else return "Rechazado";
    }
    
    $scope.cargarLista=function(){
    	$http.get(configuracionGlobal.scripts + "/listadosJSON.php?metodo=rechazosJSON").then(function (respuesta){
            console.log(respuesta);
            $scope.objetos=respuesta.data;
        })
    }
    
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
            console.log(r.data);
        });
    }
    
    $scope.observaciones="";
    rechazosId=[];
    
    $scope.separarRechazo=function (_chk, _IdRechazo){
        if (_chk){
            rechazosId[rechazosId.length]=_IdRechazo;
        } else {
            if (rechazosId.indexOf(_IdRechazo)!=-1) rechazosId[rechazosId.indexOf(_IdRechazo)]=null;
        }
        $scope.validarRechazos();
        //console.log(rechazosId.length);
        console.log(rechazosId);
    }
    
    $scope.validarRechazos=function (){
        valido=false;
        for (var i = 0; i < rechazosId.length; i++) {
            rechazo=rechazosId[i];
            if (rechazo!=null) {
                valido=true;
                i=rechazosId.length;
            }
        }
        if (valido) $scope.chequeados=true;
        else $scope.chequeados=false;
        return valido;
    }
    
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
        console.log(array);
        return array;
    }
    
    $scope.registrarRechazos=function (_IdProceso, _observaciones, _proceso, _idLlanta){
        if ($scope.validarRechazos()){
            $scope.datos={
                idProceso: _IdProceso,
                idLlanta: _idLlanta,
                observaciones: _observaciones,
                proceso: _proceso
            }
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
                console.log(r);
                rechazosId=[];
                $scope.observaciones="";
                if (r.data=='OK') $scope.showToast(true, 'Rechazos registrados exitosamente');
                else if (r.data=='FEX') $scope.showToast(true, 'Uoops, Hubo un problema al registrar los rechazos');
                else if (r.data=='NR') $scope.showToast(true, 'No se puedo registrar los rechazos, intentalo nuevamente...');
                else if (r.data=='ID') $scope.showToast(true, 'Hacen falta algunos datos, recarga la pagina y vuelve a intentarlo...');
            })
        }
    }
    
    $scope.limpiarVariables=function (){
        rechazosId=[];
        $scope.observaciones="";
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
});   