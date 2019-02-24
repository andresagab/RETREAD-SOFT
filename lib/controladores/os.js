panamApp.controller('os', function ($scope, configuracionGlobal, $http, $localStorage, $timeout){
    
    $scope.os={
        estado: 'nueva',
        btnRegistrarServicio: 'disabled',
        btnRegistrarServicioHide: false,
        inputDisabled: '',
        btnBuscar: '',
        barraCarga: 'hide',
        hideDatos: 'hide',
        alerta: 'hide',
        mjsAlerta: '',
        colorAlerta: '',
        datosVendedor: 'hide',
        hideListaLlantas: true
    }
    
    $scope.html={}
    
    $scope.servicio={
        CCliente: false,
        CVendedor: false,
        COs: false,
        observaciones: null
    }
    
    $scope.cliente={}
    
    $scope.vendedor={}
    
    $scope.ordenServicio={
        btnCerrarOS: true
    };
    
    $scope.tiposServicioId=[]

    $scope.numerosFacturas=[]
    $scope.numerosOs=[]

    $scope.llantasOS=null;

    $scope.cargarEstadoOS=function (_id){
        if (_id!=null & _id!='') {
            $scope.os.inputDisabled=true;
            $scope.os.barraCarga='';
            $http({
                url: configuracionGlobal.scripts + "/datosJSON.php",
                method: 'GET',
                params: {
                    metodo: 'getOrdenServicio',
                    id: _id
                }
            }).then(function (r){
                $scope.os.barraCarga='hide';
                if (r.data[0].id!=null && r.data[0].id!='' && r.data[0].id!='null'){
                    $scope.os.btnRegistrarServicioHide=true;
                    $scope.os.btnBuscar='hide';
                    $scope.os.hideDatos='';
                    $scope.os.datosVendedor='';
                    $scope.os.estado='registrada';
                    $scope.os.hideListaLlantas=false;
                    $scope.desactivarCampos(true);
                    $scope.ordenServicio=r.data[0];
                    $("#txtIdentificacion").val($scope.ordenServicio.cliente[0].identificacion);
                    $("#txtOs").val($scope.ordenServicio.os);
                    $("#txtEmpresa").val($scope.ordenServicio.cliente[0].nombreEmpresa);
                    $("#txtDireccion").val($scope.ordenServicio.cliente[0].direccionPersona);
                    $("#txtNumeroFactura").val($scope.ordenServicio.numeroFactura);
                    //var fecha=$scope.ordenServicio.cliente[0].fechaRegistro.split(" ");
                    var fecha=$scope.ordenServicio.fechaRecoleccion.split(" ");
                    $("#txtFechaRecoleccion").val(fecha[0]);
                    $("#txtTelefono").val($scope.ordenServicio.cliente[0].celularPersona);
                    $("#txtVendedor").val($scope.ordenServicio.empleado[0].identificacion);
                    $("#txtNombresFuncionario").val($scope.ordenServicio.empleado[0].nombresCompletosPersona);
                    $localStorage.osPrint=null;
                } else {
                    $localStorage.osPrint=null;
                    $scope.os.inputDisabled=false;
                    $scope.loadNumerosFacturas();
                    $scope.loadNumerosOS();
                }
            });
        } else {
            $localStorage.osPrint=null;
            $scope.ordenServicio.btnCerrarOs=true;
            $scope.loadNumerosFacturas();
            $scope.loadNumerosOS();
        }
        $scope.cargarTiposServicio(_id);
    }

    $scope.loadNumerosFacturas=function(){
        $scope.numerosFacturas=[];
        $http({
            url: configuracionGlobal.scripts + "/datosJSON.php",
            method: 'GET',
            params: {
                metodo: 'getNumerosFacturas'
            }
        }).success(function (r) {
            if (r.length>0) $scope.numerosFacturas=r;
        }).error(function (r) {
            showToast(true, "No se pudo conectar con el servidor");
        });
    };

    $scope.loadNumerosOS=function(){
        $scope.numerosFacturas=[];
        $http({
            url: configuracionGlobal.scripts + "/datosJSON.php",
            method: 'GET',
            params: {
                metodo: 'getNumerosOS'
            }
        }).success(function (r) {
            if (r.length>0) $scope.numerosOs=r;
        }).error(function (r) {
            showToast(true, "No se pudo conectar con el servidor");
        });
    };

    $scope.cargarCliente=function (_Identificacion){
        _Identificacion=$("#txtIdentificacion").val();
        $scope.html.txtIdentificacion=_Identificacion;
        var dato=_Identificacion.split(" ", _Identificacion.indexOf("("));
        _Identificacion=dato[0];
        $scope.os.barraCarga='';
        var valido=$scope.validarCampoIdentificacionCliente(_Identificacion);
        if (valido){
            $http({
                url: configuracionGlobal.scripts + '/datosJSON.php',
                method: 'GET',
                params: {
                    metodo: 'getCliente',
                    identificacion: _Identificacion
                }
            }).then(function (r){
                $scope.os.barraCarga='hide';
                $scope.cliente=r.data;
                $scope.validarDataCliente(r.data);
            });
        }
    }
    
    $scope.validarCampoIdentificacionCliente=function (_Identificacion){
        var valido=false;
        if (_Identificacion!=null && _Identificacion!='' && _Identificacion!=' ') {
            valido=true;
            $scope.servicio.CCliente=true;
        } else {
            $scope.os.alerta='';
            $scope.os.mjsAlerta='El campo cliente esta vacio';
            $scope.os.colorAlerta='warning';
            $scope.os.hideDatos='hide';
            $scope.os.barraCarga='hide';
            $("#txtIdentificacion").focus();
            $scope.servicio.CCliente=false;
        }
        return valido;
    }
    
    $scope.validarCampoIdentificacionVendedor=function (_Identificacion){
        var valido=false;
        if (_Identificacion!=null && _Identificacion!='' && _Identificacion!=' ') {
            valido=true;
            $scope.servicio.CVendedor=true;
        } else {
            $scope.os.datosVendedor='hide';
            $scope.os.alerta='';
            $scope.os.mjsAlerta='El campo vendedor esta vacio';
            $scope.os.colorAlerta='warning';
            $scope.os.barraCarga='hide';
            $("#txtVendedor").focus();
            $scope.servicio.CVendedor=false;
        }
        return valido;
    }
    
    $scope.validarDataCliente=function (_cliente){
        var valido=false;
        if (_cliente[0].id!=null && _cliente[0].id!='null') {
            valido=true;
            $scope.os.alerta='hide';
            $scope.os.mjsAlerta=""
            $scope.os.colorAlerta='';
            $scope.os.hideDatos='';
            $scope.servicio.CCliente=true;
            //$("#txtIdentificacion").val($scope.cliente[0].identificacion);
        } else {
            $scope.os.alerta='';
            $scope.os.mjsAlerta="El cliente con NIT o CC '" + $scope.html.txtIdentificacion + "' no esta registrado en el sistema"
            $scope.os.colorAlerta='danger';
            $scope.os.hideDatos='hide';
            $scope.servicio.CCliente=false;
        }
        $scope.showToast(valido, "Cliente '" + $scope.cliente[0].nombreEmpresa + "' cargado exitosamente")
        return valido;
    }
    
    $scope.validarDataVendedor=function (_Objeto){
        var valido=false;
        if (_Objeto[0].id!=null && _Objeto[0].id!='null') {
            valido=true;
            $scope.os.alerta='hide';
            $scope.os.mjsAlerta=""
            $scope.os.colorAlerta='';
            $scope.os.datosVendedor='';
            $scope.servicio.CVendedor=true;
        } else {
            $scope.servicio.CVendedor=false;
            $scope.os.alerta='';
            $scope.os.mjsAlerta="El vendedor con CC '" + $scope.html.txtIdentificacionVendedor + "' no esta registrado en el sistema"
            $scope.os.colorAlerta='danger';
            $scope.os.datosVendedor='hide';
        }
        $scope.showToast(valido, "Vendedor '" + $scope.vendedor[0].nombresCompletosPersona + "' cargado exitosamente")
        return valido;
    }
    
    $scope.cargarVendedor=function (_Identificacion){
        _Identificacion=$("#txtVendedor").val();
        $scope.html.txtIdentificacionVendedor=_Identificacion;
        var dato=_Identificacion.split(" ", _Identificacion.indexOf("("));
        _Identificacion=dato[0];
        $scope.os.barraCarga='';
        var valido=$scope.validarCampoIdentificacionVendedor(_Identificacion);
        if (valido){
            $http({
                url: configuracionGlobal.scripts + '/datosJSON.php',
                method: 'GET',
                params: {
                    metodo: 'getVendedor',
                    identificacion: _Identificacion
                }
            }).then(function (r){
                $scope.os.barraCarga='hide';
                $scope.vendedor=r.data;
                $scope.validarDataVendedor(r.data);
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
    
    $scope.validarCampoOS=function (_OS){
        var valido=false;
        if (_OS!=null && _OS!=''){
            valido=true;
            $scope.servicio.COs=true;
        } else {
            $scope.servicio.COs=false;
            $scope.os.alerta='';
            $scope.os.mjsAlerta='El campo OS no puede estar vacio';
            $scope.os.colorAlerta='warning';
            $scope.os.barraCarga='hide';
            $("#txtOs").focus();
        }
        return valido;
    }
    
    $scope.cargarOS=function (_OS){
        console.log(_OS);
        if ($scope.numerosOs.length>0){
            var valid=false;
            for (var i=0; i<$scope.numerosOs.length; i++){
                if ($scope.numerosOs[i]==_OS) {
                    valid=true;
                    $scope.validarDataOS($scope.numerosOs[i]);
                    i=$scope.numerosOs.length;
                }
            }
            if (!valid) $scope.validarDataOS(null);
        } else {
            $timeout(function () {
                $scope.html.txtOs=_OS;
                $scope.os.barraCarga='';
                //$scope.os.inputDisabled=true;
                if ($scope.validarCampoOS(_OS)){
                    $http({
                        url: configuracionGlobal.scripts + '/datosJSON.php',
                        method: 'GET',
                        params: {
                            metodo: 'getOS',
                            os: _OS
                        }
                    }).then(function (r){
                        //$scope.os.inputDisabled=false;
                        $scope.os.barraCarga='hide';
                        if (r.data!=null){
                            if (r.data[0]!=null) $scope.validarDataOS(r.data[0].id);
                        }
                    });
                }
            }, 150);
        }
    }
    
    $scope.validarDataOS=function (_Objeto){
        var valido=false;
        console.log(_Objeto);
        //if (_Objeto[0]!='' && _Objeto[0].id!=null && _Objeto[0].id!='null') {
        if (_Objeto!=null) {
            $scope.servicio.COs=false;
            $scope.os.alerta='';
            $scope.os.mjsAlerta="El numero '" + $scope.html.txtOs + "' ya esta siendo usado por otra orden de servicio"
            $scope.os.colorAlerta='danger';
            $scope.os.btnRegistrarServicio='disabled';
        } else {
            valido=true;
            $scope.servicio.COs=true;
            $scope.os.alerta='hide';
            $scope.os.btnRegistrarServicio='';
        }
        $scope.showToast(valido, "N° '" + $scope.html.txtOs + "' disponible")
        return valido;
    }

    $scope.validarNumeroFactura=function(){
        var valid=false;
        if ($scope.html.txtNumeroFactura!=null && $scope.html.txtNumeroFactura!=''){
            if ($scope.numerosFacturas.length>0){
                for (var i=0; i<$scope.numerosFacturas.length; i++){
                    if ($scope.numerosFacturas[i]==$scope.html.txtNumeroFactura) {
                        i=$scope.numerosFacturas.length;
                        $scope.os.alerta='';
                        $scope.os.mjsAlerta="El numero de factura '" + $scope.html.txtNumeroFactura + "' esta siendo usado por otra orden de servicio";
                        $scope.os.colorAlerta="danger";
                        valid=false;
                    } else {
                        valid=true;
                        $scope.os.alerta='hide';
                    }
                }
            } else {
                valid=true;
            }
        } else {

        }
        console.log(valid);
        return valid;
    }

    $scope.validarDatosRegistrarOS=function (){
        if ($scope.servicio.CCliente && $scope.servicio.CVendedor && $scope.servicio.COs && $scope.validarNumeroFactura()){
            $scope.registrarOS(true);
        } else {
            $scope.os.alerta='';
            $scope.os.mjsAlerta='Debes diligenciar todo el formulario para registrar esta orden de servicio';
            $scope.os.colorAlerta='danger';
            //$scope.os.btnRegistrarServicio='disabled';
        }
    }

    $scope.registrarOS=function (_valido){
        if (_valido && $scope.os.estado=='nueva'){
            $scope.os.barraCarga='';
            $scope.os.estado='cargando';
            $scope.servicio.idCliente=$scope.cliente[0].id;
            $scope.servicio.idVendedor=$scope.vendedor[0].id;
            $scope.servicio.os=$scope.html.txtOs;
            $scope.servicio.numeroFactura=$scope.html.txtNumeroFactura;
            $scope.servicio.fechaRecoleccion=$("#txtFechaRecoleccion").val();
            $scope.servicio.tiposServicio=cortarArray($scope.tiposServicioId);
            $http({
                url: configuracionGlobal.scripts + "/cruds.php",
                method: 'POST',
                data: $scope.servicio,
                params: {
                    metodo: 'registrarOS'
                }
            }).success(function (res){
                $scope.os.barraCarga='hide';
                $scope.ordenServicio=res;
                console.log(res);
                if ($scope.ordenServicio[0].id!=null && $scope.ordenServicio[0].id!='null' && $scope.ordenServicio[0].id!=''){
                    $scope.os.estado='registrada';
                    $scope.showToast(true, "Orden de servicio registrada exitosamente");
                    window.location="principal.php?CON=system/Pages/ordenesServicioFormulario.php&id="+$scope.ordenServicio[0].id;
                } else {
                    $scope.os.estado='nueva';
                    $scope.showToast(true, "La orden de servicio no pudo registrarse intentalo nuevamente");
                    /*$timeout(function () {
                        window.location.reload();
                    }, 1000);
                    $scope.desactivarCampos(false);*/
                }
            }).error(function (r){
                $scope.os.barraCarga='';
                $scope.os.estado='nueva';
                $scope.showToast(true, "No se pudo conectar al servidor");
            });
        } else {
            $scope.showToast(true, "La orden de servicio actual ya fue registrada");
        }
    }
    
    $scope.desactivarCampos=function (_valido){
        if ($scope.os.estado=='registrada' && _valido){
            $scope.os.inputDisabled='disabled';
            //$scope.html={};
        } else {
            $scope.os.inputDisabled='';
            $scope.html=null;
        }
    }
   
    $scope.cargarTiposServicio=function (_IdServicio){
        //if (_IdServicio!=null && _IdServicio!=){
            $http({
                url: configuracionGlobal.scripts + "/datosJSON.php",
                method: 'GET',
                params: {
                    metodo: 'getTiposServicioJSON',
                    id: _IdServicio
                }
            }).then(function (r){
                $scope.tiposServicio=r.data;
            });
        //}
    }
    
    $scope.separarTipoServicio=function (_chk, _IdTipoServicio){
        if (_chk){
            $scope.tiposServicioId.push(_IdTipoServicio);
        } else {
            //if ($scope.tiposServicioId.indexOf(_IdTipoServicio)!=-1) $scope.tiposServicioId[$scope.tiposServicioId.indexOf(_IdTipoServicio)]=null;
            //if ($scope.tiposServicioId.indexOf(_IdTipoServicio)!=-1) delete $scope.tiposServicioId[$scope.tiposServicioId.indexOf(_IdTipoServicio)];
            if ($scope.tiposServicioId.indexOf(_IdTipoServicio)!=-1) $scope.tiposServicioId.splice($scope.tiposServicioId.indexOf(_IdTipoServicio), 1);
        }
    }
    
    function cortarArray(_Array){
        var array="";
        console.log(_Array);
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

    $scope.dataPrint={
        objects: null,
        os: null,
        tiposServicio: null
    }

    $scope.itemsSelected=new Array();

    $scope.selectedPrint=function(object, status){
        if (object!=null){
            if (status) $scope.itemsSelected.push(object);
            else {
                for (var i=0; i<$scope.itemsSelected.length; i++){
                    if ($scope.itemsSelected[i].id==object.id) $scope.itemsSelected.splice(i, 1);
                }
            }
        }
        console.log($scope.itemsSelected);
    }

    $scope.setFilterOS=function(type){
        $localStorage.osPrint=null;
        $scope.llantasOS=$localStorage.dataOS;
        switch (type){
            case 0:
                $scope.dataPrint.objects = $scope.llantasOS;
                $scope.imprimirHoja();
                break;
            case 1:
                var tempData=new Array();
                for (var i=0; i<$scope.llantasOS.length; i++){
                    var object=$scope.llantasOS[i];
                    if (object!=null){
                        if (object.nombreEstado!=null && object.nombreEstado.toLowerCase()=="procesada (exitosamente)") tempData.push(object);
                    }
                }
                $scope.dataPrint.objects=tempData;
                $scope.imprimirHoja();
                break;
            case 2:
                var tempData=new Array();
                for (var i=0; i<$scope.llantasOS.length; i++){
                    var object=$scope.llantasOS[i];
                    if (object!=null){
                        if (object.nombreEstado!=null && object.nombreEstado.toLowerCase()=="procesada (rechazada)") tempData.push(object);
                    }
                }
                $scope.dataPrint.objects=tempData;
                $scope.imprimirHoja();
                //$scope.itemsSelected=null;
                break;
            case 3:
                var tempData=new Array();
                for (var i=0; i<$scope.llantasOS.length; i++){
                    var object=$scope.llantasOS[i];
                    if (object!=null){
                        if (object.salida!=null){
                            if (object.salida.id!=null) tempData.push(object);
                        }
                    }
                }
                $scope.dataPrint.objects=tempData;
                $scope.imprimirHoja();
                //$scope.itemsSelected=null;
                break;
            case 4:
                $scope.dataPrint.objects=$scope.itemsSelected;
                $scope.imprimirHoja();
                break;
            default:
                showToast(true, 'Accion desconcida');
                break;
        }
    }
    
    $scope.imprimirHoja=function (){
        $scope.dataPrint.os=$scope.ordenServicio;
        $scope.dataPrint.tiposServicio=$scope.tiposServicio;
        $localStorage.osPrint=$scope.dataPrint;
        window.open(configuracionGlobal.templatesPrint + "/ordenServicioImprimir.php", null, 'toolbar=no, directories=no, width=500, height=350, resizable=no,left=280, top=240');
    }
    
    $scope.cerrarOs=function (_accion) {
        var accion=null;
        if (validarInput($scope.ordenServicio) && _accion) accion='c';
        else accion='a';
        document.location="principal.php?CON=system/pages/ordenesServicioActualizar.php&accion=Cerrar&id=" + $scope.ordenServicio.id + "&estado=" + accion;
    }
    
});

//Autocompletar JQUERY-UI
//
$(document).ready(function(){
    $("#btnCargarEstadoOS").click();
    var cache = {};
    var cacheCCVendedor = {};
    $( "#txtIdentificacion" ).autocomplete({
        minLength: 2,
        source: function( request, response ) {
            var palabra = request.term;//value de #txtIdentificacion
            if (palabra in cache) {
                response(cache[palabra]);
                return;//se ssale de autocomplette
            }
            $.getJSON("system/Scripts/Autocompletar.php?metodo=getIdentificacionesClientes", request,
            function( data, status, xhr ) {
                console.log(data);
                cache[ palabra ] = data;
                response( data);
            });
        }
    });
    $( "#txtVendedor" ).autocomplete({
        minLength: 2,
        source: function( request, response ) {
            var palabra = request.term;//value de #txtIdentificacion
            if (palabra in cacheCCVendedor) {
                response(cacheCCVendedor[palabra]);
                return;//se ssale de autocomplette
            }
            $.getJSON("system/Scripts/Autocompletar.php?metodo=getIdentificacionesEmpleado", request,
            function( data, status, xhr ) {
                console.log(data);
                cacheCCVendedor[ palabra ] = data;
                response( data );
            });
        }
    });
    
});
//
//Fin Autocompletar JQUERY-UI