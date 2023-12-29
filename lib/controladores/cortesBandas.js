panamApp.controller('cortesBandas', function ($scope, $http, configuracionGlobal, $timeout, $interval) {

    $(document).ready(function () {
        $scope.loadTotalRecords()
        $scope.loadData(0);
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

    /**
     * define component attributes
     */
    $scope.component = {
        pagination: {
            current_page: 1,
            max_records: 0,
            records_per_page: 25,
            total_pages: 0,
            pages: [],
        }
    }

    /**
     * get a range between start and end
     * @param {int} start the firts number of list
     * @param {int} end the last number of list
     * @returns 
     */
    let range = (start, end) => Array.from(Array(end + 1).keys()).slice(start);

    $scope.showSpinner=function(dlg, show){
        if (dlg) console.log(dlg);
        else $scope.page.spinnerCarga=show;
    }

    /**
     * to set records per page of pagination
     * @param {int} records 
     */
    $scope.setRecordsPerPage = function(records)
    {
        // set records per page
        $scope.component.pagination.records_per_page = records;
        // set total pages of pagination
        $scope.component.pagination.total_pages = Math.ceil($scope.component.pagination.max_records / $scope.component.pagination.records_per_page);
        // set pages list
        $scope.component.pagination.pages = range(1, $scope.component.pagination.total_pages);
        // load data
        $scope.loadData(0);
    }

    /**
     * set current page and load their data
     * @param {int} page 
     */
    $scope.goToPage = function(page)
    {
        // set current page with argument
        $scope.component.pagination.current_page = page;
        // set list of paginations
        $scope.component.pagination.pages = range(1, $scope.component.pagination.total_pages);
        // load data
        $scope.loadData(0);
    }

    /**
     * load data of current page
     * @param {int} page 0 to keep current page, 1 to increment to next page and -1 for back to previous page
     */
    $scope.loadData=function (page) {
        $scope.showSpinner(false, true);
        if (!$scope.page.loadingData) {
            $scope.page.loadingData = true;
            // set pagination data
            $scope.component.pagination.current_page += page;
            // http request
            $http({
                url: configuracionGlobal.scripts + "/listadosJSON.php",
                method: 'GET',
                params: {
                    metodo: 'getRegistrosBandasJSON',
                    pagination: $scope.component.pagination,
                }
            }).success(function (r) {
                $scope.showSpinner(false, false);
                $scope.page.loadingData = false;
                if (r!=null) {
                    $scope.page.data.objects = [];
                    $scope.page.data.objects=r;
                    showToastDialog(true, r.length + ' datos cargados', 'toast-principal');
                }
            }).error(function (r) {
                $scope.showSpinner(false, false);
                $scope.page.loadingData = false;
                showToastDialog(true, 'No se pudo conectar con el servidor', 'toast-principal');
            });
        }
    }

    /**
     * load total records for this module
     */
    $scope.loadTotalRecords = function () {
        $http({
            url: configuracionGlobal.scripts + "/listadosJSON.php",
            method: 'GET',
            params: {
                metodo: 'getTotalCortesBanda',
            }
        }).success(function (r) {

            // set max records of pagination
            $scope.component.pagination.max_records = r[0].total;
            // set total pages of pagination
            $scope.component.pagination.total_pages = Math.ceil(r[0].total / $scope.component.pagination.records_per_page);
            // set pages list
            $scope.component.pagination.pages = range(1, $scope.component.pagination.total_pages);

        }).error(function (r) {
            showToastDialog(true, 'No se pudo conectar con el servidor', 'toast-principal');
        });
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
               $scope.loadData(0);
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

    $interval(() => {
        $scope.loadData(0)
    }, 300000);

});