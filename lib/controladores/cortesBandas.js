panamApp.controller('cortesBandas', function ($scope, $http, configuracionGlobal, $timeout, $interval) {

    $(document).ready(function () {
        $scope.loadData();
    })

    $scope.page= {
        spinnerCarga: false,
        loadingData: false,
        dlgSpinnerCarga: false,
        data: {
            objects: [],
            dlgCorte: {
                item: null,
                object: {
                    empates: null,
                    foto: null,
                    idPuestoTrabajo: null,
                    observaciones: null
                },
                viewPhoto: false
            }
        }
    }

    $scope.showSpinner=function(dlg, show){
        if (dlg) console.log(dlg);
        else $scope.page.spinnerCarga=show;
    }

    $scope.loadData=function () {
        $scope.showSpinner(false, true);
        if (!$scope.page.loadingData) {
            $scope.page.loadingData = true;
            $http({
                url: configuracionGlobal.scripts + "/listadosJSON.php",
                method: 'GET',
                params: {
                    metodo: 'getRegistrosBandasJSON'
                }
            }).success(function (r) {
                $scope.showSpinner(false, false);
                $scope.page.loadingData = false;
                if (r!=null) {
                    $scope.page.data.objects=r;
                    showToastDialog(true, r.length + ' datos cargados', 'toast-principal');
                    $scope.setCurrentPage(null);
                    $scope.initValues(r);
                    $scope.setCurrentPage(null);
                }
            }).error(function (r) {
                $scope.showSpinner(false, false);
                $scope.page.loadingData = false;
                showToastDialog(true, 'No se pudo conectar con el servidor', 'toast-principal');
            });
        }
    }

    $scope.setItemPage = function (object) {
        if (object!=null) $scope.page.data.dlgCorte.item=object;
        else $scope.page.data.dlgCorte.item=null;
    }

    $scope.img={
        dataURL: ''
    };

    $scope.fileReaderSupportedCB= window.FileReader!=null;

    $scope.setFoto=function(files){
        if (files!=null){
            var file=files[0];
            if (file!=null){
                if ($scope.fileReaderSupportedCB && file.type.indexOf('image') > -1){
                    $timeout(function (){
                        var fileReader= new FileReader();
                        fileReader.readAsDataURL(file);
                        fileReader.onload= function (e){
                            $timeout(function (){
                                $scope.img.dataURL= e.target.result;
                                $scope.page.data.dlgCorte.viewPhoto=true;
                                $scope.page.data.dlgCorte.object.foto=file.name;
                            })
                        }
                    })
                } else $scope.deletePhoto();
            } else $scope.deletePhoto();
        }
    }

    $scope.deletePhoto=function (){
        console.log($scope.page);
        $scope.page.data.dlgCorte.viewPhoto=false;
        $scope.file=null;
        $("#fotoCB").val(null);
        $scope.page.data.dlgCorte.object.foto=null;
    }

    $scope.sendCorteBanda=function () {
        if ($scope.frmAddCorte.$valid) console.log("Valido...");
        else console.log("Frm No valido");
        if ($scope.html.idPuestoTrabajo!=null) console.log("idValido");
        else console.log("Id invalido");
        console.log($scope.frmAddCorte);
        if ($scope.frmAddCorte.$valid && $scope.html.idPuestoTrabajo!=null && $scope.empleado!=null && $scope.proceso!=null){
           $scope.page.spinnerCarga=true;
           $scope.page.data.dlgCorte.object.idPuestoTrabajo=$scope.html.idPuestoTrabajo;
           var formData=new FormData();
           formData.append("name", "foto");
           formData.append("file", $scope.file);
           $http({
               url: configuracionGlobal.scripts + "/cruds.php",
               method: 'POST',
               data: formData,
               params: {
                   metodo: 'addCorteBanda',
                   id: $scope.proceso.id,
                   idEmpleado: $scope.empleado.id,
                   idPuestoTrabajo: $scope.page.data.dlgCorte.object.idPuestoTrabajo,
                   empates: $scope.page.data.dlgCorte.object.empates,
                   observaciones: $scope.page.data.dlgCorte.object.observaciones
               },
               headers: {
                   'Content-type': undefined
               },
               transformRequest: angular.identity
           }).success(function (r) {
               $scope.page.spinnerCarga=false;
               $scope.cleanDataCorte();
               $scope.loadData();
               switch (r) {
                   case 'OK':
                       showToastDialog(true, "Corte registrado exitosamente", 'toast-principal');
                       break;
                   case 'SD':
                       showToastDialog(true, 'Solicitud desconocida, intentalo nuevamente', 'toast-principal');
                       break;
                   case 'IR':
                       showToastDialog(true, 'Solicitud invalida, intentalo nuevamente', 'toast-principal');
                       break;
                   case 'ID':
                       showToastDialog(true, 'No se pudo completar la accion por falta de datos', 'toast-principal');
                       break;
                   case 'SDE':
                       showToastDialog(true, 'Uoops! ocurrio un error al guardar el registro', 'toast-principal');
                       break;
                   default:
                       showToastDialog(true, 'Error desconocido', 'toast-principal');
                       break;
               }
               $("#btnCancelarDlgAddCorte").click();
           }).error(function (r) {
               $scope.page.spinnerCarga=false;
               showToastDialog(true, "No se pudo conectar con el servidor", 'toast-principal');
           });
        } else {
            showToastDialog(true, "Asegurate de diligenciar todo el formulario", 'toast-content');
        }
    }

    $scope.cleanDataCorte=function () {
        $scope.page.data.dlgCorte.object.empates=null;
        $scope.page.data.dlgCorte.object.idPuestoTrabajo=null;
        $scope.page.data.dlgCorte.object.observaciones=null;
        $scope.deletePhoto();
    }

    $interval(function () {
        if (!$scope.page.loadingData) {
            $scope.page.loadingData = true;
            $http({
                url: configuracionGlobal.scripts + "/listadosJSON.php",
                method: 'GET',
                params: {
                    metodo: 'getRegistrosBandasJSON'
                }
            }).success(function (r) {
                $scope.page.loadingData = false;
                if (r!=null){
                    if ($scope.page.data.objects.lenght<r.length) {
                        $scope.page.data.objects=null;
                        $scope.page.data.objects=r;
                        showToastDialog(true, 'Datos actualizados', 'toast-principal');
                        $scope.setCurrentPage(null);
                        $scope.initValues(r);
                        $scope.setCurrentPage(null);
                    }
                }
            }).error(function (r) {
                $scope.page.loadingData = false;
                showToastDialog(true, 'No se pudo conectar con el servidor', 'toast-principal');
            });
        }
    }, 300000);

})