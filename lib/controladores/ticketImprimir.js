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
        // load llanta from local storage
        tier = localStorage.getItem('llanta_ticket')
        // if ng local storage have llanta ticket or was loaded from default local storage js
        if ($localStorage.llantaTicket != null || tier != null){
            $scope.page.spinnerCarga = false;
            $scope.page.data.object = tier != null ? JSON.parse(tier) : $localStorage.llantaTicket;
            setTimeout(function () {
                window.print();
            }, 1500);
        } else {
            $scope.page.spinnerCarga=false;
            $localStorage.llantaTicket=null;
            showToastDialog(true, "No se cargo ningun registro, intentalo nuevamente", "toast-principal");
            setTimeout(function () {
                window.close();
            }, 1500);
        }
    }, 500);
});