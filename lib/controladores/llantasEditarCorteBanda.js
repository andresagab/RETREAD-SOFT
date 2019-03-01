panamApp.controller('llantasEditarCorteBanda', function (configuracionGlobal, $scope, $http, $timeout) {

    $(document).ready(function () {
        $scope.page.components.subController = true;
        $scope.loadLlanta(document.getElementsByName('idLlanta')[0].value);
        $scope.loadCorteBanda(document.getElementsByName('idCorteBanda')[0].value);
        if (document.getElementById('idPuestoTrabajo')!=null) document.getElementById('idPuestoTrabajo').disabled = true;
        if (document.getElementById('btnModificarFrmCorteBanda')!=null) $scope.setStatusBtnModificarFrmCorteBanda(true);
    });

    $scope.html = {
        components: {
            loadBar: false,
            loadSpinner: false,
            btnUpdate: true,
            viewPhotoCorteBanda: false
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
    }

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
                //window.location = "principal.php?CON=system/pages/unknowData.php";
            });
        } else $scope.html.data.llanta = {};
    }

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
                        $scope.cargarProceso(false, r, null, null);
                        if (r.idPuestoTrabajo!=null) $scope.loadPuestoTrabajo(r.idPuestoTrabajo);
                    }
                }
            }).error(function (r) {
                $scope.html.components.loadSpinner = false;
                //window.location = "principal.php?CON=system/pages/unknowData.php";
            });
        }
    }

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
                if (r!=null) {
                    if (r.id!=null) {
                        $scope.html.data.puestoTrabajo = r;
                        $scope.cargarPuestoTrabajo(false, $scope.html.data.puestoTrabajo, null);
                    }
                }
            }).error(function (r) {
                $scope.html.components.loadSpinner = false;
                //window.location = "principal.php?CON=system/pages/unknowData.php";
            });
        }
    }

    $scope.prevPage = function () {
        if ($scope.html.data.llanta.idos!=null) window.location = 'principal.php?CON=system/Pages/ordenesServicioFormulario.php&id=' + $scope.html.data.llanta.idos;
        else window.location = "principal.php?CON=system/Pages/unknowData.php";
    }

    $scope.resetFrmCorteBanda = function () {
        console.log($scope.html);
        $scope.html.forms.dataFrmCorteBanda = null;
        $scope.html.forms.dataFrmCorteBanda = $scope.html.data.corteBanda;
        console.log($scope.html);
    }

    $scope.setStatusBtnModificarFrmCorteBanda = function (status) {
        document.getElementById('btnModificarFrmCorteBanda').disabled = status;
    }

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
    }

    $scope.deletePhoto=function (){
        console.log($scope.page);
        $scope.html.components.viewPhotoCorteBanda = false;
        $scope.file = null;
        $("#fotoCorteBanda").val(null);
        $scope.html.forms.dataFrmCorteBanda.foto = null;
    }

});