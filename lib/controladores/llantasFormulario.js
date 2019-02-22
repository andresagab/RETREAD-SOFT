panamApp.controller('llantasFormulario', function ($scope, $http, configuracionGlobal) {

    $(document).ready(function () {
        var llanta=JSON.parse(sessionStorage.getItem('llantaFrm'));
        $scope.pageData.idTipoLlantaOriginal=llanta[0].referenciaOriginal[0].idTipoLlanta;
        $("#spnTipoLlantaOriginal").val($scope.pageData.idTipoLlantaOriginal);
        $scope.pageData.idTipoLlantaSolicitada=llanta[0].referenciaSolicitada[0].idTipoLlanta;
        $("#spnTipoLlantaSolicitada").val($scope.pageData.idTipoLlantaSolicitada);
        $scope.loadReferenciasTipoLlanta(0);
        $scope.loadReferenciasTipoLlanta(1);
        $("#spnReferenciaOriginal").val(llanta[0].idReferenciaOriginal);
        $("#spnReferenciaSolicitada").val(llanta[0].idReferenciaSolicitada);
        $scope.pageData.urgente=llanta[0].urgente;
        $("#chkUrgente").val(llanta[0].urgente);
        console.log($scope.pageData);
    });

    $scope.pageData={
        spinnerCarga: false,
        elements: {
            spnReferenciaOriginal: false,
            spnReferenciaSolicitada: false
        },
        urgente: false,
        idTipoLlantaOriginal: null,
        idTipoLlantaSolicitada: null,
        referenciasOriginales: [],
        referenciasSolicitadas: []
    }

    $scope.cargarNombreUrgenteChk=function(){
        if ($scope.pageData.urgente) return 'SI';
        else return 'NO';
    }

    $scope.loadReferenciasTipoLlanta=function (road) {
        if ($scope.pageData.idTipoLlantaOriginal!=null && road!=null || $scope.pageData.idTipoLlantaSolicitada!=null && road!=null){
            $scope.pageData.spinnerCarga=true;
            var idTipoLlanta=null;
            switch (road){
                case 0:
                    idTipoLlanta=$scope.pageData.idTipoLlantaOriginal;
                    $scope.pageData.elements.spnReferenciaOriginal=false;
                    $scope.referenciasOriginales=null;
                    break;
                case 1:
                    idTipoLlanta=$scope.pageData.idTipoLlantaSolicitada;
                    $scope.pageData.elements.spnReferenciaSolicitada=false;
                    $scope.referenciasSolicitadas=null;
                    break;
            }
            $http({
                url: configuracionGlobal.scripts + "/listadosJSON.php",
                method: 'GET',
                params: {
                    metodo: 'referenciasTipoLlantaJSON',
                    idTipoLlanta: idTipoLlanta
                }
            }).success(function (r) {
                $scope.pageData.spinnerCarga=false;
                if (r!=null) {
                    switch (road){
                        case 0:
                            $scope.pageData.referenciasOriginales=r;
                            $scope.pageData.elements.spnReferenciaOriginal=true;
                            break;
                        case 1:
                            $scope.pageData.referenciasSolicitadas=r;
                            $scope.pageData.elements.spnReferenciaSolicitada=true;
                            break;
                    }
                } else {
                    switch (road){
                        case 0:
                            $scope.pageData.referenciasOriginales=null;
                            $scope.pageData.elements.spnReferenciaOriginal=false;
                            break;
                        case 1:
                            $scope.pageData.elements.spnReferenciaSolicitada=false;
                            $scope.pageData.referenciasSolicitadas=null;
                            break;
                    }
                    showToast(true, 'No se obtuvieron resultados');
                }
            }).error(function (r) {
                $scope.pageData.spinnerCarga=false;
                showToast(true, 'No se pudo conectar con el servidor');
            });
        } else showToast(true, 'Asegurate de seleccionar un tipo de llanta');
    }

});