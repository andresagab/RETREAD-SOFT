panamApp.controller('raspado', function ($scope, $interval) {

    $(document).ready(function () {
        if (document.getElementById('diffTime')!=null) $scope.setTimeToGo();
        if (document.getElementById('timeElapsed')!=null) $scope.setTimeElapsed();
    });

    $scope.retreadProcess = {
        page: {
            loadSpinner: false
        },
        data: {
            timeToGo: null,
            timeElapsed: null,
            form: {
                idPuestoTrabajo: null,
                chkRetiroCinturon: false,
                cinturonCantidad: 1
            }
        }
    };

    $scope.initProcess = function () {
        window.location = 'principal.php?CON=system/pages/raspadoActualizar.php&idLlanta=' + document.getElementById('txtIdLlanta').value + '&idPastProcess=' + document.getElementById('txtPastProcess').value + '&accion=initProcess';//review
    };

    $scope.toProcess = function () {
        window.location = 'principal.php?CON=system/pages/inspeccionInicialFormulario.php&id=' + document.getElementById('txtIdLlanta').value + '&accion=initProcess';//review
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
            $scope.retreadProcess.data.timeToGo = partMinutes + ':' + partSeconds;
            if (Math.round(minutes)>=6) location.reload();
        }, 1000);
    };

    $scope.setTimeElapsed = function () {
        var time = document.getElementById('timeElapsed').value.split(" ");
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
            $scope.retreadProcess.data.timeElapsed = partDays + ' ' + partHours + ':' + partMinutes + ':' + partSeconds;
            seconds++;
        }, 1000);
    };

    $scope.backPage = function () {
        window.location = 'principal.php?CON=system/pages/llantasRaspado.php';
    };

});