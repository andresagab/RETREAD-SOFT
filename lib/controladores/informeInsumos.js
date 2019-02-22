panamApp.controller('informeInsumos', function (configuracionGlobal, $scope, $http, $sessionStorage) {

    $scope.html = {
        elements: {
            barLoad: false
        },
        data: {
            inputs: {
                txtSearch: '',
                chkFechasCreacion: false,
                txtFechaInicioCreacion: new Date(),
                txtFechaFinCreacion: new Date(),
                chkFechasRecargaKardex: false,
                txtFechaInicioRecargaKardex: new Date(),
                txtFechaFinRecargaKardex: new Date(),
                chkFechasRecargaPT: false,
                txtFechaInicioRecargaPT: new Date(),
                txtFechaFinRecargaPT: new Date(),
                chkFechasEnvioPT: false,
                txtFechaInicioEnvioPT: new Date(),
                txtFechaFinEnvioPT: new Date(),
                chkFechasUso: false,
                txtFechaInicioUso: new Date(),
                txtFechaFinUso: new Date(),
                txtFileNameExel: null
            },
            objects: null,
            filters: [
                {
                    type: 0,
                    filter: null
                },
                {
                    type: 1,
                    filter: null
                },
                {
                    type: 2,
                    filter: null
                },
                {
                    type: 3,
                    filter: null
                },
                {
                    type: 4,
                    filter: null
                }
            ],
            order: null
        }
    }

    $scope.loadObjects = function () {
        $scope.setFilters();
        $scope.html.elements.barLoad=true;
        $http({
            url: configuracionGlobal.scripts + '/listadosJSON.php',
            method: 'POST',
            data: $scope.html.data.filters,
            params: {
                metodo: 'getDataInformeInsumosJSON',
                order: $scope.html.data.order
            },
            headers: {'Content-type': 'application/x-www-form-urlencoded'}
        }).success(function (r) {
            $scope.html.elements.barLoad=false;
            if (r.length<=0) showToastPrincipal(true, 'No se han encontrado registros en la base de datos');
            else showToastPrincipal(true, r.length + ' registros encontrados');
            $scope.html.data.objects=r;
            //$scope.setObjectSessionStorage(r);
        }).error(function () {
            $scope.html.elements.barLoad=false;
            showToastPrincipal(true, 'Error al conectar con el servidor');
        });
    }

    $scope.setObjectSessionStorage = function (data) {
        $sessionStorage.dataInformInsumosHerramientas=data;
    }

    $scope.getStatusFilters = function () {
        var valid=true;
        if ($scope.html.data.inputs.chkFechasCreacion || $scope.html.data.inputs.chkFechasRecargaKardex || $scope.html.data.inputs.chkFechasRecargaPT || $scope.html.data.inputs.chkFechasEnvioPT || $scope.html.data.inputs.chkFechasUso) valid=false;
        return valid;
    }

    $scope.validFields = function () {
        /*
        true => los campos son vacios o incorrectos
        false => los campos son correctos
         */
        var valid=false;
        if ($scope.html.data.inputs.chkFechasCreacion) {
            if ($scope.html.data.inputs.txtFechaInicioCreacion==null || $scope.html.data.inputs.txtFechaFinCreacion==null) valid=true;
            else if ($scope.html.data.inputs.txtFechaInicioCreacion>$scope.html.data.inputs.txtFechaFinCreacion) valid=true;
        }
        if ($scope.html.data.inputs.chkFechasRecargaKardex) {
            if ($scope.html.data.inputs.txtFechaInicioRecargaKardex==null || $scope.html.data.inputs.txtFechaFinRecargaKardex==null) valid=true;
            else if ($scope.html.data.inputs.txtFechaInicioRecargaKardex>$scope.html.data.inputs.txtFechaFinRecargaKardex) valid=true;
        }
        if ($scope.html.data.inputs.chkFechasRecargaPT) {
            if ($scope.html.data.inputs.txtFechaInicioRecargaPT==null || $scope.html.data.inputs.txtFechaFinRecargaPT==null) valid=true;
            else if ($scope.html.data.inputs.txtFechaInicioRecargaPT>$scope.html.data.inputs.txtFechaFinRecargaPT) valid=true;
        }
        if ($scope.html.data.inputs.chkFechasEnvioPT) {
            if ($scope.html.data.inputs.txtFechaInicioEnvioPT==null || $scope.html.data.inputs.txtFechaFinEnvioPT==null) valid=true;
            else if ($scope.html.data.inputs.txtFechaInicioEnvioPT>$scope.html.data.inputs.txtFechaFinEnvioPT) valid=true;
        }
        if ($scope.html.data.inputs.chkFechasUso) {
            if ($scope.html.data.inputs.txtFechaInicioUso==null || $scope.html.data.inputs.txtFechaFinUso==null) valid=true;
            else if ($scope.html.data.inputs.txtFechaInicioUso>$scope.html.data.inputs.txtFechaFinUso) valid=true;
        }
        return valid;
    }

    $scope.validDate = function (date) {
        if (date!=null) return true;
        else return false;
    }

    $scope.setFilters = function () {
        if ($scope.html.data.inputs.chkFechasCreacion && $scope.validDate($scope.html.data.inputs.txtFechaInicioCreacion) && $scope.validDate($scope.html.data.inputs.txtFechaFinCreacion)) {
            var fechaInicio = $scope.html.data.inputs.txtFechaInicioCreacion.getFullYear() + '-' + ($scope.html.data.inputs.txtFechaInicioCreacion.getMonth()+1) + '-' + $scope.html.data.inputs.txtFechaInicioCreacion.getDate();
            var fechaFin = $scope.html.data.inputs.txtFechaFinCreacion.getFullYear() + '-' + ($scope.html.data.inputs.txtFechaFinCreacion.getMonth()+1) + '-' + $scope.html.data.inputs.txtFechaFinCreacion.getDate();
            $scope.html.data.filters[0].filter=" pr.fecharegistro between '" + fechaInicio + " 00:00:00' and '" + fechaFin + " 23:59:59' and ";
        } else $scope.html.data.filters[0].filter=null;
        if ($scope.html.data.inputs.chkFechasRecargaKardex && $scope.validDate($scope.html.data.inputs.txtFechaInicioRecargaKardex) && $scope.validDate($scope.html.data.inputs.txtFechaFinRecargaKardex)) {
            var fechaInicio = $scope.html.data.inputs.txtFechaInicioRecargaKardex.getFullYear() + '-' + ($scope.html.data.inputs.txtFechaInicioRecargaKardex.getMonth()+1) + '-' + $scope.html.data.inputs.txtFechaInicioRecargaKardex.getDate();
            var fechaFin = $scope.html.data.inputs.txtFechaFinRecargaKardex.getFullYear() + '-' + ($scope.html.data.inputs.txtFechaFinRecargaKardex.getMonth()+1) + '-' + $scope.html.data.inputs.txtFechaFinRecargaKardex.getDate();
            $scope.html.data.filters[1].filter=" and fecharegistro between '" + fechaInicio + " 00:00:00' and '" + fechaFin + " 23:59:59' ";
        } else $scope.html.data.filters[1].filter=null;
        if ($scope.html.data.inputs.chkFechasEnvioPT && $scope.validDate($scope.html.data.inputs.txtFechaInicioEnvioPT) && $scope.validDate($scope.html.data.inputs.txtFechaFinEnvioPT)) {
            var fechaInicio = $scope.html.data.inputs.txtFechaInicioEnvioPT.getFullYear() + '-' + ($scope.html.data.inputs.txtFechaInicioEnvioPT.getMonth()+1) + '-' + $scope.html.data.inputs.txtFechaInicioEnvioPT.getDate();
            var fechaFin = $scope.html.data.inputs.txtFechaFinEnvioPT.getFullYear() + '-' + ($scope.html.data.inputs.txtFechaFinEnvioPT.getMonth()+1) + '-' + $scope.html.data.inputs.txtFechaFinEnvioPT.getDate();
            $scope.html.data.filters[2].filter=" and fecharegistro between '" + fechaInicio + " 00:00:00' and '" + fechaFin + " 23:59:59' ";
        } else $scope.html.data.filters[2].filter=null;
        if ($scope.html.data.inputs.chkFechasRecargaPT && $scope.validDate($scope.html.data.inputs.txtFechaInicioRecargaPT) && $scope.validDate($scope.html.data.inputs.txtFechaFinRecargaPT)) {
            var fechaInicio = $scope.html.data.inputs.txtFechaInicioRecargaPT.getFullYear() + '-' + ($scope.html.data.inputs.txtFechaInicioRecargaPT.getMonth()+1) + '-' + $scope.html.data.inputs.txtFechaInicioRecargaPT.getDate();
            var fechaFin = $scope.html.data.inputs.txtFechaFinRecargaPT.getFullYear() + '-' + ($scope.html.data.inputs.txtFechaFinRecargaPT.getMonth()+1) + '-' + $scope.html.data.inputs.txtFechaFinRecargaPT.getDate();
            $scope.html.data.filters[3].filter=" and fecharegistro between '" + fechaInicio + " 00:00:00' and '" + fechaFin + " 23:59:59' ";
        } else $scope.html.data.filters[3].filter=null;
        if ($scope.html.data.inputs.chkFechasUso&& $scope.validDate($scope.html.data.inputs.txtFechaInicioUso) && $scope.validDate($scope.html.data.inputs.txtFechaFinUso)) {
            var fechaInicio = $scope.html.data.inputs.txtFechaInicioUso.getFullYear() + '-' + ($scope.html.data.inputs.txtFechaInicioUso.getMonth()+1) + '-' + $scope.html.data.inputs.txtFechaInicioUso.getDate();
            var fechaFin = $scope.html.data.inputs.txtFechaFinUso.getFullYear() + '-' + ($scope.html.data.inputs.txtFechaFinUso.getMonth()+1) + '-' + $scope.html.data.inputs.txtFechaFinUso.getDate();
            $scope.html.data.filters[4].filter=" and fecharegistro between '" + fechaInicio + " 00:00:00' and '" + fechaFin + " 23:59:59' ";
        } else $scope.html.data.filters[4].filter=null;
    }

    $scope.exportDataToExel = function () {
        var fileName=$scope.html.data.inputs.txtFileNameExel;
        if (fileName==null) fileName='informeInsumos&Herramientas_' + $scope.data.currentDate.getFullYear() + '-' + ($scope.data.currentDate.getMonth()+1) + '-' + $scope.data.currentDate.getDate()
        $scope.exportExel('#tableInsumosHerramientas', fileName);
    }

});