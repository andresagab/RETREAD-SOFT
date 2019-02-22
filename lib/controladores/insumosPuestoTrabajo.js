panamApp.controller('insumosPuestoTrabajo', function ($scope, configuracionGlobal, $http, $location){
    
    $scope.html={
        spinnerCarga: false,
        rbsMetodo: false,
        metodoBusqueda: true,
        idCategoria: '#',
        spnListaSeleccion: false,
        txtBuscador: false,
        divInputBusqueda: false,
        datosInsumo: false,
        btnEnviar: true
    }
    
    $scope.cargarIdCategoria=function (_id){
        if (_id!=null && _id!='' && _id!='#'){
            $scope.html.idCategoria=_id;
            $scope.html.rbsMetodo=true;
            $scope.html.btnEnviar=false;
            $scope.cargarSpnInsumosCategoria();
            $scope.showAlerta(false, null, null);
            $scope.validarIdCategoria();
            $scope.validarIdInsumo();
        } else {
            $scope.html.rbsMetodo=false;
            $scope.html.vIdCategoria=false;
            $scope.html.spnListaSeleccion=false;
            $scope.html.txtBuscador=false;
            $scope.html.btnEnviar=true;
            $scope.showAlerta(true, 'Asegurate de seleccionar una categoria', 'warning');
            $("#spnCategorias").focus();
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
    
    $scope.showAlerta=function (_valido, _mjs, _color){
        if (_valido){
            $scope.html.alerta=true;
            $scope.html.colorAlerta=_color;
            $scope.html.mjsAlerta=_mjs;
        } else {
            $scope.html.alerta=false;
            $scope.html.colorAlerta='default';
            $scope.html.mjsAlerta=null;
        }
    }
    
    $scope.buscar=function (_valor){
        if (_valor!=null && _valor!=''){
            $scope.showAlerta(false, null, null);
            if ($scope.validarIdCategoria()){
                $scope.autocompletarBuscador(_valor);
                $scope.html.nombreInsumo=_valor;
                $scope.separarIdInsumo(_valor);
            }
        } else {
            $scope.showAlerta(true, 'Asegurate de buscar y cargar un insumo', 'warning');
            $("#txtNombreInsumo").focus();
        }
    }
    
    $scope.separarIdInsumo=function (_insumo){
        if (_insumo!=null && _insumo!=null){
            if (_insumo.indexOf(".")!=null){
                $scope.html.idInsumo=_insumo.substring(0, _insumo.indexOf("."));
                $scope.html.vIdInsumo=true;
                $scope.cargarInsumo();
            } else {
                $scope.html.idInsumo=null
                $scope.html.vIdInsumo=false;
            }
        }
    };
    
    $scope.separarIdInsumoXSpinner=function (_id){
        if (_id!=null && _id!='' && _id!='#'){
            $scope.html.idInsumo=_id;
            $scope.html.vIdInsumo=true;
            $scope.cargarInsumo();
        } else {
            $scope.html.idInsumo=null
            $scope.html.vIdInsumo=false;
        }
    }
    
    $scope.cargarInsumo=function (){
        if ($scope.validarIdInsumo()){
            $scope.html.spinnerCarga=true;
            $http({
                url: configuracionGlobal.scripts + "/datosJSON.php",
                method: 'GET',
                params: {
                    metodo: 'getInsumoJSON',
                    id: $scope.html.idInsumo
                }
            }).success(function (r){
                console.log(r);
                $scope.html.spinnerCarga=false;
                $scope.insumo=r[0];
                if ($scope.insumo.id!=null){
                    $scope.html.datosInsumo=true;
                } else {
                    $scope.html.datosInsumo=false;
                    showModalDialog(true, "No se pudo cargar el insumo");
                    $scope.html.idInsumo=null;
                }
            }).error(function (r){
                $scope.html.spinnerCarga=false;
            });
        }
    }
    
    $scope.validarIdInsumo=function (){
        if ($scope.html.idInsumo!='#' && $scope.html.idInsumo!='' && $scope.html.idInsumo!=null){
            $scope.showAlerta(false, null, null);
            $scope.html.vIdInsumo=true;
            $scope.html.btnEnviar=false;
            return true;
        } else {
            $scope.showAlerta(true, 'No se ha cargado ningun insumo', 'danger');
            $("#txtNombreInsumo").focus();
            $scope.html.vIdInsumo=false;
            $scope.html.btnEnviar=true;
            return false;
        }
        console.log($scope.html);
    }
    
    $scope.validarIdCategoria=function (){
        if ($scope.html.idCategoria!='#' && $scope.html.idCategoria!='' && $scope.html.idCategoria!=null){
            $scope.showAlerta(false, null, null);
            $scope.html.vIdCategoria=true;
            $scope.html.btnEnviar=false;
            return true;
        } else {
            $scope.showAlerta(true, 'Asegurate de seleccionar una categoria', 'warning');
            $("#spnCategorias").focus();
            $scope.html.vIdCategoria=false;
            $scope.html.btnEnviar=true;
            return false;
        }
        console.log($scope.html);
    }
    
    $scope.cargarSpnInsumosCategoria=function (){
        $scope.html.spinnerCarga=true;
        if ($scope.validarIdCategoria()){
            $("#spnInsumosCategoria").load(configuracionGlobal.scripts + '/Options.php', {
                metodo: 'getInsumosCategoria',
                idCategoria: $scope.html.idCategoria
            }, function (responsiveTxt, status, xhr) {
                hideSpinner();
            });
        }
    }

    function hideSpinner() {
        $scope.html.spinnerCarga=false;
        $("#option-1").click();
    }
    
    $scope.autocompletarBuscador=function (_valor){
        if ($scope.validarIdCategoria()){
            var cache = {};
            $( "#txtNombreInsumo" ).autocomplete({
                minLength: 2,
                source: function( request, response ) {
                    var palabra = request.term;
                    if (palabra in cache) {
                        response(cache[palabra]);
                        return;
                    }
                    $.getJSON(configuracionGlobal.scripts + "/Autocompletar.php", {
                        metodo: 'getNombreProductos',
                        idCategoria: $scope.html.idCategoria,
                        term: _valor
                    },
                    function( data, status, xhr ) {
                        console.log(data);
                        cache[ palabra ] = data;
                        response( data );
                    });
                }
            });
        }
    }
    
    $scope.cargarTipoDeBusqueda=function (_valor){
        console.log(_valor);
        if (_valor!=null && _valor!=''){
            if (_valor=='L') {
                $scope.html.metodoBusqueda=true;
                $scope.html.spnListaSeleccion=true;
                $scope.html.txtBuscador=false;
            } else {
                $scope.html.metodoBusqueda=false;
                $scope.html.spnListaSeleccion=false;
                $scope.html.txtBuscador=true;
            }
        }
    }

});   