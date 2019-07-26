panamApp.controller('inspeccionInicial', function ($scope, $interval) {

    $(document).ready(function () {
        if (document.getElementById('diffTime')!=null) $scope.setTimeToGo();
        if (document.getElementById('timeElapsed')!=null) $scope.setTimeElapsed();
    });

    $scope.inspeccionInicial = {
        page: {
            loadSpinner: false
        },
        data: {
            timeToGo: null,
            timeElapsed: null
        }
    };

    $scope.initProcess = function () {
        window.location = 'principal.php?CON=system/pages/inspeccionInicialActualizar.php&id=' + document.getElementById('txtIdLlanta').value + '&accion=initProcess';
    };

    $scope.setTimeToGo = function () {
        var time = document.getElementById('diffTime').value;
        var seconds = 0;
        var minutes = 0;
        if (time>0) {
            minutes = time/60;
            seconds = Math.round(('0.' + minutes.toString().split('.')[1])*60);
            minutes = Math.round(time/60);
        }
        $interval(function () {
            seconds++;
            if (seconds===60) {
                minutes++;
                seconds = 0;
            }
            var partMinutes = '00';
            var partSeconds = '00';
            if (minutes>0) {
                if (minutes<10) partMinutes = '0' + Math.round(minutes);
                else partMinutes = Math.round(minutes);
            }
            if (seconds>0) {
                if (seconds<10) partSeconds = '0' + Math.round(seconds);
                else partSeconds = Math.round(seconds);
            }
            $scope.inspeccionInicial.data.timeToGo = partMinutes + ':' + partSeconds;
            // if (Math.round(minutes)>=1 && Math.round(seconds)>=29) location.reload();
            if (Math.round(seconds)>=29) location.reload();
        }, 1000);
    };

    $scope.setTimeElapsed = function () {
        var time = document.getElementById('timeElapsed').value.split(" ");
        //var years = time[0].split("-")[0];
        //var months = time[0].split("-")[1];
        var days = time[0].split("-")[2];
        var hours = time[1].split(":")[0];
        var minutes = time[1].split(":")[1];
        var seconds = time[1].split(":")[2];
        $interval(function () {
            if (hours===60) {
                days++;
                hours = 0;
            }
            if (minutes===60) {
                hours++;
                minutes = 0;
            }
            if (seconds===60) {
                minutes++;
                seconds = 0;
            }
            var partDays = '';
            var partHours = '00';
            var partMinutes = '00';
            var partSeconds = '00';
            if (days>0) {
                if (days>1) partDays = days + ' dias';
                else partDays = days + ' dia';
            }
            if (hours>0) {
                if (hours<10) partHours = '0' + hours;
                else partHours = hours;
            }
            if (minutes>0) {
                if (minutes<10) partMinutes = '0' + minutes;
                else partMinutes = minutes;
            }
            if (seconds>0) {
                if (seconds<10) partSeconds = '0' + seconds;
                else partSeconds = seconds;
            }
            $scope.inspeccionInicial.data.timeElapsed = partDays + ' ' + partHours + ':' + partMinutes + ':' + partSeconds;
            seconds++;
        }, 1000);
    };

    $scope.backPage = function () {
        window.location = 'principal.php?CON=system/pages/llantas.php';
    };

    $scope.backToOs = function () {
        if (document.getElementById("idOs")!=null) window.location = 'principal.php?CON=system/pages/ordenesServicioFormulario.php&id=' + document.getElementById("idOs").value;
        else backPage();
    };

});