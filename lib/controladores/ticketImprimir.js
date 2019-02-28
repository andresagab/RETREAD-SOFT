panamApp.controller('ticketImprimir', function ($scope, configuracionGlobal, $http, $location, $sessionStorage, $timeout, $localStorage){

    $scope.page={
        spinnerCarga: false,
        data: {
            fechaActual: new Date().getFullYear() + '/' + (new Date().getMonth()+1) + '/' + new Date().getDate() + ' ' + new Date().getHours() + ':' + new Date().getMinutes() + ':' + new Date().getSeconds(),
            object: null
        }
    }

    $scope.page.spinnerCarga=true;

    $timeout(function () {
        if ($sessionStorage.llantaTicket!=null || $localStorage.llantaTicket){
            $scope.page.spinnerCarga = false;
            $scope.page.data.object = $localStorage.llantaTicket;
            setTimeout(function () {
                window.print();
            }, 1500);
        } else {
            $scope.page.spinnerCarga=false;
            $localStorage.llantaTicket=null;
            showToastDialog(true, "No se cargo ningun registro", "toast-principal");
            setTimeout(function () {
                window.close();
            }, 1000);
        }
    }, 500);
});