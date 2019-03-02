panamApp.controller('llantasEditarCorteBanda', function (configuracionGlobal, $scope, $http, $timeout) {

    $(document).ready(function () {
        $scope.page.components.subController = true;
        $scope.loadLlanta(document.getElementsByName('idLlanta')[0].value);
        $scope.loadCorteBanda(document.getElementsByName('idCorteBanda')[0].value);
        if (document.getElementById('idPuestoTrabajo')!=null) document.getElementById('idPuestoTrabajo').disabled = true;
    });

    $scope.html = {
        components: {
            loadBar: false,
            loadSpinner: false,
            btnUpdate: true,
            viewPhotoCorteBanda: false,
            chkEmpates: false,
            alert: {
                status: false,
                color: 'danger',
                mjs: null
            }
        },
        data: {
            corteBanda: {},
            puestoTrabajo: {},
            llanta: {},
            img: {
                dataUrl: ''
            }
        },
        forms: {
            dataFrmCorteBanda: {}
        }
    };

    $scope.loadLlanta = function (_idLLanta) {
        if (validarInput(_idLLanta)) {
            $scope.html.components.loadSpinner = true;
            $http({
               url: configuracionGlobal.scripts + '/datosJSON.php',
               method: 'GET',
               params: {
                   metodo: 'getLlantaJSONSQL',
                   id: _idLLanta
               }
            }).success(function (r) {
                if ($scope.html.data.corteBanda.length>0) $scope.html.components.loadSpinner = false;
                if (r.length>0 || r!=null) {
                    if (r[0].id!=null) $scope.html.data.llanta = r[0];
                }
            }).error(function (r) {
                $scope.html.components.loadSpinner = false;
                window.location = "principal.php?CON=system/pages/unknowData.php";
            });
        } else $scope.html.data.llanta = {};
    };

    $scope.loadCorteBanda = function (_idCorteBanda) {
        $scope.html.data.corteBanda = {};
        $scope.html.forms.dataFrmCorteBanda = {};
        if (validarInput(_idCorteBanda)) {
            $scope.html.components.loadSpinner = true;
            $http({
               url: configuracionGlobal.scripts + '/datosJSON.php',
               method: 'GET',
               params: {
                   metodo: 'getCorteBandaEditar',
                   id: _idCorteBanda
               }
            }).success(function (r) {
                $scope.html.components.loadSpinner = false;
                if (r!=null) {
                    if (r.id!=null) {
                        $scope.html.data.corteBanda = r;
                        $scope.html.forms.dataFrmCorteBanda = r;
                        $scope.loadFoto();
                        $scope.cargarProceso(false, r, null, null);
                        if (r.idPuestoTrabajo!=null) $scope.loadPuestoTrabajo(r.idPuestoTrabajo);
                    } else {
                        $timeout(function () {
                            $scope.prevPage();
                        }, 5000);
                    }
                } else {
                    $timeout(function () {
                        $scope.prevPage();
                    }, 5000);
                }
            }).error(function (r) {
                $scope.html.components.loadSpinner = false;
                window.location = "principal.php?CON=system/pages/unknowData.php";
            });
        }
    };

    $scope.loadPuestoTrabajo = function (_idPuestoTrabajo) {
        $scope.html.data.puestoTrabajo = {};
        if (validarInput(_idPuestoTrabajo)) {
            $scope.html.components.loadSpinner = true;
            $http({
               url: configuracionGlobal.scripts + '/datosJSON.php',
               method: 'GET',
               params: {
                   metodo: 'getPuestoTrabajoSimpleJSON',
                   id: _idPuestoTrabajo
               }
            }).success(function (r) {
                $scope.html.components.loadSpinner = false;
                var volver = true;
                if (r!=null) {
                    if (r.id!=null) {
                        volver = false;
                        $scope.html.data.puestoTrabajo = r;
                        $scope.cargarPuestoTrabajo(false, $scope.html.data.puestoTrabajo, null);
                    }
                }
                if (volver) {
                    $timeout(function () {
                        $scope.prevPage();
                    }, 5000);
                }
            }).error(function (r) {
                $scope.html.components.loadSpinner = false;
                window.location = "principal.php?CON=system/pages/unknowData.php";
            });
        }
    };

    $scope.prevPage = function () {
        if ($scope.html.data.llanta.idos!=null) window.location = 'principal.php?CON=system/Pages/ordenesServicioFormulario.php&id=' + $scope.html.data.llanta.idos;
        else window.location = "principal.php?CON=system/Pages/unknowData.php";
    };

    $scope.resetFrmCorteBanda = function () {
        console.log($scope.html);
        $scope.html.forms.dataFrmCorteBanda = null;
        $scope.html.forms.dataFrmCorteBanda = $scope.html.data.corteBanda;
        console.log($scope.html);
    };

    $scope.setStatusBtnModificarFrmCorteBanda = function (status) {
        document.getElementById('btnModificarFrmCorteBanda').disabled = status;
    };

    $scope.loadFoto = function(){
        if ($scope.html.data.corteBanda.foto!=null) {
            $scope.html.data.img.dataURL = configuracionGlobal.scripts + "/../Uploads/Imgs/Corte_Banda/" + $scope.html.data.corteBanda.foto;
            $scope.html.components.viewPhotoCorteBanda = true;
        } else $scope.html.components.viewPhotoCorteBanda = true;
    };

    $scope.fileReaderSupportedCB = window.FileReader!=null;

    $scope.setFotoCorteBanda = function(files){
        if (files!=null){
            var file = files[0];
            if (file!=null){
                if ($scope.fileReaderSupportedCB && file.type.indexOf('image') > -1){
                    $timeout(function (){
                        var fileReader = new FileReader();
                        fileReader.readAsDataURL(file);
                        fileReader.onload = function (e){
                            $timeout(function (){
                                $scope.html.data.img.dataURL= e.target.result;
                                $scope.html.components.viewPhotoCorteBanda = true;
                                $scope.html.forms.dataFrmCorteBanda.foto = file.name;
                            })
                        }
                    })
                } else $scope.deletePhoto();
            } else $scope.deletePhoto();
        }
    };

    $scope.deletePhoto=function (){
        $scope.html.components.viewPhotoCorteBanda = false;
        $scope.html.data.img.dataURL = null;
        $scope.file = null;
        $("#fotoCorteBanda").val(null);
        $scope.html.forms.dataFrmCorteBanda.foto = null;
    };
    
    $scope.validSoloEmpates = function () {
        $scope.showAlertPage(false, null, null);
        if ($scope.html.components.chkEmpates) {
            disabledComponnentPage('btnOpenPuestoTrabajo', true);
            disabledComponnentPage('btnEliminarImgCorteBanda', true);
            disabledComponnentPage('fotoCorteBanda', true);
        } else {
            disabledComponnentPage('btnOpenPuestoTrabajo', false);
            disabledComponnentPage('btnEliminarImgCorteBanda', false);
            disabledComponnentPage('fotoCorteBanda', false);
        }
    };

    $scope.showAlertPage = function(status, color, message){
        $scope.html.components.alert.status = status;
        $scope.html.components.alert.color = color;
        $scope.html.components.alert.mjs = message;
    };

    $scope.sendForm = function () {
        if ($scope.html.components.chkEmpates) {
            $scope.showAlertPage(false, 'danger', null);
            $scope.runHttpForm();
        } else {
            if ($scope.page.data.usosInsumoProceso.length>0) {
                if ($scope.page.data.usosInsumoProceso.length>1) {
                    if ($scope.html.data.img.dataURL!=$scope.html.data.corteBanda.foto && $scope.file!=null) $scope.runHttpForm();
                    else $scope.showAlertPage(true, 'danger', 'Asegurate de cargar la foto correspondiente al nuevo corte realizado.');
                } else $scope.showAlertPage(true, 'danger', 'Para modificar el corte de la banda asegúrate de registrar el uso de la nueva banda.');
            } else {
                $scope.showAlertPage(true, 'danger', 'Aún no se ha registrado el corte de banda para esta llanta, por lo tanto no es posible llevar a cabo la acción solicitada.');
                $timeout(function () {
                    $scope.prevPage();
                }, 5000);
            }
        }
    };
    
    $scope.runHttpForm = function () {
        var formData = new FormData();
        formData.append('name', 'fotoCorteBanda');
        formData.append('file', $scope.file);
        if ($scope.html.components.chkEmpates) _ChkEmpates = 1;
        else _ChkEmpates = 0;
        $scope.html.components.loadSpinner = true;
        $http({
            url: configuracionGlobal.scripts + '/llantasEditarCorteBandaActualizar.php',
            method: 'POST',
            data: formData,
            params: {
                method: 'updateCorteBanda',
                chkEmpates: _ChkEmpates,
                idPuestoTrabajo: $scope.html.data.corteBanda.idpuestotrabajo,
                idProceso: $scope.html.data.corteBanda.id,
                proceso: $scope.page.data.numeroProceso,
                empates: $scope.html.forms.dataFrmCorteBanda.empates,
                observaciones: $scope.html.forms.dataFrmCorteBanda.observaciones
            },
            headers: {'Content-type': undefined},
            transformRequest: angular.identity
        }).success(function (r) {
            $scope.html.components.loadSpinner = false;
            validSimpleResponseHTTP(r, 'toast-content');
            $timeout(function () {
                $scope.prevPage();
            }, 3000);
        });
    }

});